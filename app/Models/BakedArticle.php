<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BakedArticle
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @property int article_id
 * @property string lang
 * @property string name
 * @property string flavor
 * @property string html
 * @property string text
 * @property array all
 * @property int content_id
 * @property \Carbon\Carbon|null created_at
 * @property \Carbon\Carbon|null updated_at
 *
 * @property-read \App\Models\Article article
 *
 * @property-read string slug
 */
class BakedArticle extends Model
{
    protected $fillable = [
        'article_id',
        'lang',
        'name',
        'flavor',
        'html',
        'text',
        'all',
        'content_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'all' => 'array',
    ];

    public function article() {
        return $this->belongsTo(BakedArticle::class, 'article_id');
    }

    public function contentUpdate() {
        return $this->belongsTo(ContentUpdate::class, 'content_id');
    }
}
