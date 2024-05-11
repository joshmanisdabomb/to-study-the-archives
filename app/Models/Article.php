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
 * @property int content_id
 * @property string namespace
 * @property string identifier
 * @property array data
 * @property \Carbon\Carbon|null created_at
 * @property \Carbon\Carbon|null updated_at
 *
 * @property-read \App\Models\ContentUpdate contentUpdate
 */
class Article extends Model
{
    protected $fillable = [
        'content_id',
        'namespace',
        'identifier',
        'data',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function contentUpdate() {
        return $this->belongsTo(ContentUpdate::class, 'content_id');
    }
}
