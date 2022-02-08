<?php

namespace App\Models;

use App\Handlers\Fragment\ParagraphFragmentHandler;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;

/**
 * Class Article
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @property int id
 * @property string registry
 * @property string key
 * @property string name
 * @property string slug1
 * @property string slug2
 * @property \Carbon\Carbon|null created_at
 * @property \Carbon\Carbon|null updated_at
 * @property \Carbon\Carbon|null deleted_at
 *
 * @property-read \App\Models\ArticleSection[] sections
 * @property-read \App\Models\ArticleSection[] sectionsMain
 * @property-read \App\Models\ArticleSection[] sectionsInfo
 * @property-read \App\Models\ArticleRedirect[] redirects
 * @property-read \App\Models\ArticleTag[] tags
 *
 * @property-read string location
 * @property-read ?string image
 * @property-read ?string excerpt
 */
class Article extends Model
{
    protected $fillable = [
        'registry',
        'key',
        'name',
        'slug1',
        'slug2',
    ];

    use HasFactory;

    public function sections() {
        return $this->hasMany(ArticleSection::class)->orderBy('order');
    }

    public function redirects() {
        return $this->hasMany(ArticleRedirect::class);
    }

    public function tags() {
        return $this->hasMany(ArticleTag::class);
    }

    public function getLocationAttribute() : string {
        return $this->registry . '::' . $this->key;
    }

    public function getImageAttribute() : ?string {
        $registry = explode(':', $this->registry, 2);
        $key = explode(':', $this->key, 2);
        $path = 'images/models/' . $key[0] . '/' . $registry[1] . '/' . $key[1] . '.png';
        if (!file_exists(public_path() . '/' . $path)) return null;
        return asset($path);
    }

    public function getExcerptAttribute() : ?string {
        $fragment = $this->sections()->whereHas('fragments', function(Builder $query) { $query->where('type', '=', 'text'); })->get();
        if (!$fragment) return null;
        return strip_tags(ParagraphFragmentHandler::getMarkup($fragment->flatMap(fn(ArticleSection $s) => $s->fragments)->first()->markup));
    }

}
