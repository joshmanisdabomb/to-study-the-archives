<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ContentUpdate;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use ZipArchive;

class ContentController extends Controller
{
    public function update(Request $request) {
        $body = $request->post('body');
        if (is_string($body)) $body = json_decode($body, true);
        if (!is_array($body) || empty($body['key']) || $body['key'] !== env('API_KEY')) throw new AuthenticationException;
        unset($body['key']);

        $meta = $request->post('meta');
        if (is_string($meta)) $meta = json_decode($meta, true);

        $mod_id = Arr::get($body, 'mod.id');
        if (!$mod_id) throw new BadRequestException('Requires mod.id in JSON body.');
        $mod_version = Arr::get($body, 'mod.version');
        if (!$mod_version) throw new BadRequestException('Requires mod.version in JSON body.');
        $mc_version = Arr::get($body, 'mc.version');
        if (!$mc_version) throw new BadRequestException('Requires mc.version in JSON body.');

        $content = $request->file('content');
        $lang = $request->file('lang');
        $images = $request->file('images');

        $update = ContentUpdate::create([
            'body' => $body,
            'meta' => $meta,
            'content' => $content instanceof UploadedFile ? $content->store('content') : null,
            'lang' => $lang instanceof UploadedFile ? $lang->store('lang') : null,
            'images' => $images instanceof UploadedFile ? $images->store('images') : null,
            'mod_identifier' => $mod_id,
            'mod_version' => $mod_version,
            'mc_version' => $mc_version,
        ]);

        if ($content instanceof UploadedFile) {
            $zip = new ZipArchive();
            $zip->open($content->getPathname());
            for ($i = 0; $entry = $zip->statIndex($i); $i++) {
                $contents = $zip->getFromIndex($i);

                $namespace = dirname($entry['name']);
                $identifier = basename($entry['name'], '.json');

                $update->articles()->create([
                    'namespace' => $namespace,
                    'identifier' => $identifier,
                    'data' => json_decode($contents, true),
                ]);
            }
            $zip->close();

            $update->articles()->createMany(Article::query()
                ->select(['namespace', 'identifier'])
                ->where(fn (Builder $query) => $query
                    ->select(new Expression("a.data IS NOT NULL AND a.content_id < $update->id"))
                    ->from('articles AS a')
                    ->where(['a.namespace' => new Expression('articles.namespace'), 'a.identifier' => new Expression('articles.identifier')])
                    ->orderByDesc('a.content_id')
                    ->limit(1)
                , true)
                ->where(['namespace' => $mod_id])
                ->groupBy(['namespace', 'identifier'])->get()->toArray());
        } else {
            $content = null;
        }

        $update->load(['articles']);
        return response()->json($update);
    }
}
