<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ArticleSection
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @property int id
 * @property int article_id
 * @property string name
 * @property string type
 * @property int order
 * @property \Carbon\Carbon|null created_at
 * @property \Carbon\Carbon|null updated_at
 * @property \Carbon\Carbon|null deleted_at
 *
 * @property-read \App\Models\Article article
 * @property-read \App\Models\ArticleFragment[] fragments
 */
class ArticleSection extends Model
{
    protected $fillable = [
        'article_id',
        'name',
        'type',
        'order',
    ];

    use HasFactory;

    public function article() {
        return $this->belongsTo(Article::class);
    }

    public function fragments() {
        return $this->hasMany(ArticleFragment::class, 'section_id')->orderBy('order');
    }

}
