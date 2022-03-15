<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ArticleIndex
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @property int article_id
 * @property int article_redirect_id
 * @property string locale
 * @property string name
 *
 * @property-read \App\Models\Article article
 * @property-read \App\Models\ArticleRedirect articleRedirect
 */
class ArticleIndex extends Model
{
    protected $fillable = [
        'article_id',
        'article_redirect_id',
        'locale',
        'name',
    ];

    use HasFactory;

    public function article() {
        return $this->belongsTo(Article::class);
    }

    public function articleRedirect() {
        return $this->belongsTo(ArticleRedirect::class);
    }

}
