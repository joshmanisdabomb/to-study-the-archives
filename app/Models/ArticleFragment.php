<?php

namespace App\Models;

use App\Handlers\Fragment\FragmentHandler;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ArticleFragment
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @property int id
 * @property int section_id
 * @property string type
 * @property array markup
 * @property int order
 * @property \Carbon\Carbon|null created_at
 * @property \Carbon\Carbon|null updated_at
 * @property \Carbon\Carbon|null deleted_at
 *
 * @property-read \App\Models\ArticleSection section
 *
 * @property-read string handler
 */
class ArticleFragment extends Model
{
    protected $fillable = [
        'section_id',
        'type',
        'markup',
        'order',
    ];

    protected $casts = [
        'markup' => 'array',
    ];

    use HasFactory;

    public function section() {
        return $this->belongsTo(ArticleSection::class, 'section_id');
    }

    public function getHandlerAttribute() : string {
        return FragmentHandler::getHandlerForType($this->type);
    }
}
