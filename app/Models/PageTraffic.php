<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Article
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @property string page
 * @property int counter
 */
class PageTraffic extends Model
{
    protected $fillable = [
        'page',
        'counter',
    ];

    protected $primaryKey = 'page';

    public $timestamps = false;

    use HasFactory;

}
