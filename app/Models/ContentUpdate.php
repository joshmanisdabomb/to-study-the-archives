<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
