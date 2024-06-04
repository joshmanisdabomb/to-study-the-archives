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
use Illuminate\Support\Facades\DB;
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

        $attributes = [
            'body' => $body,
            'meta' => $meta,
            'content' => $content instanceof UploadedFile ? $content->store('content') : null,
            'lang' => $lang instanceof UploadedFile ? $lang->store('lang') : null,
            'images' => $images instanceof UploadedFile ? $images->store('images') : null,
            'mod_identifier' => $mod_id,
            'mod_version' => $mod_version,
            'mc_version' => $mc_version,
        ];
        $update = DB::transaction(function () use ($attributes) {
            $update = ContentUpdate::create($attributes);
            $update->commit();

            return $update;
        });

        $update->load(['articles.bakes', 'mods', 'versions', 'builds', 'files']);
        return response()->json($update);
    }
}
