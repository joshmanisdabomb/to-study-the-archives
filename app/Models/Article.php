<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
