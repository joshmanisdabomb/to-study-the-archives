<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Article
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @property int id
 * @property int article_id
 * @property string registry
 * @property string key
 * @property string name
 * @property string slug1
 * @property string slug2
 * @property \Carbon\Carbon|null created_at
 * @property \Carbon\Carbon|null updated_at
 * @property \Carbon\Carbon|null deleted_at
 *
 * @property-read \App\Models\Article article
 *
 * @property-read string location
 * @property-read ?string image
 */
class ArticleRedirect extends Model
{
    protected $fillable = [
        'registry',
        'key',
        'name',
        'slug1',
        'slug2',
    ];

    use HasFactory;

    public function article() {
        return $this->belongsTo(Article::class);
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

}
