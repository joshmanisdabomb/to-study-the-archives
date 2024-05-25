<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

/**
 * Class ContentUpdate
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @property int id
 * @property array body
 * @property array|null meta
 * @property string|null content
 * @property string|null lang
 * @property string|null images
 * @property string mod_identifier
 * @property string mod_version
 * @property string mc_version
 * @property \Carbon\Carbon|null created_at
 * @property \Carbon\Carbon|null updated_at
 * @property \Carbon\Carbon|null deleted_at
 *
 * @property-read \App\Models\Article[] articles
 * @property-read \App\Models\Build[] builds
 * @property-read \App\Models\BuildFile[] files
 * @property-read \App\Models\Mod[] mods
 * @property-read \App\Models\ModVersion[] versions
 */
class ContentUpdate extends Model
{
    protected $fillable = [
        'body',
        'meta',
        'content',
        'lang',
        'images',
        'mod_identifier',
        'mod_version',
        'mc_version',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'body' => 'array',
        'meta' => 'array',
    ];

    public function articles() {
        return $this->hasMany(Article::class, 'content_id');
    }

    public function builds() {
        return $this->hasMany(Build::class, 'content_id');
    }

    public function files() {
        return $this->hasMany(BuildFile::class, 'content_id');
    }

    public function mods() {
        return $this->hasMany(Mod::class, 'content_id');
    }

    public function version() {
        return $this->hasMany(ModVersion::class, 'content_id');
    }

    public function commit() {
        if ($this->meta) $this->commitMeta();
        if ($this->content) $this->commitContent(Storage::path($this->content));
    }

    public function commitMeta(): void {
        foreach ($this->meta['mods'] ?? [] as $identifier => $m) {
            $attributes = ['identifier' => $identifier];
            if (!$m) {
                Mod::where($attributes)->delete();
                continue;
            }
            $mod = Mod::updateOrCreate($attributes, $m);

            foreach ($m['versions'] ?? [] as $code => $v) {
                $attributes = ['code' => $code];
                if (!$v) {
                    $mod->versions()->where($attributes)->delete();
                    continue;
                }
                $mod->versions()->updateOrCreate($attributes, $v);
            }
        }
        foreach ($this->meta['builds'] ?? [] as $sha => $b) {
            $attributes = ['commit' => $sha];
            if (!$b) {
                Build::where($attributes)->delete();
                continue;
            }
            $build = Build::updateOrCreate($attributes, $b);

            $files = [];
            foreach ($b['files'] ?? [] as $f) {
                $file = $build->files()->updateOrCreate(['type' => $f['type'], 'sources' => $f['sources']], $f);
                $files[] = $file->id;
            }
            $build->files()->whereNotIn('id', $files)->delete();
        }
    }

    public function commitContent(string $path): void {
        $zip = new ZipArchive();
        $zip->open($path, ZipArchive::RDONLY);
        for ($i = 0; $entry = $zip->statIndex($i); $i++) {
            $contents = $zip->getFromIndex($i);

            $namespace = dirname($entry['name']);
            $identifier = basename($entry['name'], '.json');

            $this->articles()->create([
                'namespace' => $namespace,
                'identifier' => $identifier,
                'data' => json_decode($contents, true),
            ]);
        }
        $zip->close();

        $this->articles()->createMany(Article::query()
            ->select(['namespace', 'identifier'])
            ->where(fn (Builder $query) => $query
                ->select(new Expression("a.data IS NOT NULL AND a.content_id < $this->id"))
                ->from('articles AS a')
                ->where(['a.namespace' => new Expression('articles.namespace'), 'a.identifier' => new Expression('articles.identifier')])
                ->orderByDesc('a.content_id')
                ->limit(1)
                , true)
            ->where(['namespace' => $this->mod_identifier])
            ->groupBy(['namespace', 'identifier'])->get()->toArray());
    }
}
