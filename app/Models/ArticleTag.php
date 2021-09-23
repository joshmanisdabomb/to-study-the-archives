<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Article
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @property int article_id
 * @property string tag
 *
 * @property-read \App\Models\Article article
 */
class ArticleTag extends Model
{
    protected $fillable = [
        'article_id',
        'tag',
    ];

    protected $primaryKey = 'article_id';

    use HasFactory;

    public function article() {
        return $this->belongsTo(Article::class);
    }

}
