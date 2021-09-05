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
 * @property string registry
 * @property string key
 * @property string name
 * @property string slug1
 * @property string slug2
 * @property \Carbon\Carbon|null created_at
 * @property \Carbon\Carbon|null updated_at
 * @property \Carbon\Carbon|null deleted_at
 *
 * @property-read \App\Models\ArticleFragment[] sections
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

}
