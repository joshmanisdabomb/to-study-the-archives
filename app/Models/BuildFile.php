<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BuildFile
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @property int id
 * @property int build_id
 * @property string path
 * @property string|null type
 * @property boolean sources
 * @property int|null content_id
 * @property \Carbon\Carbon released_at
 * @property \Carbon\Carbon|null created_at
 * @property \Carbon\Carbon|null updated_at
 * @property \Carbon\Carbon|null deleted_at
 *
 * @property-read \App\Models\Build|null build
 * @property-read \App\Models\ContentUpdate|null contentUpdate
 *
 * @property-read string filename
 */
class BuildFile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'path',
        'type',
        'sources',
        'content_id',
        'released_at',
        'created_at',
    ];

    protected $casts = [
        'sources' => 'boolean',
        'released_at' => 'datetime',
    ];

    public function build() {
        return $this->belongsTo(Build::class, 'build_id');
    }

    public function filename(): Attribute {
        return Attribute::make(function () {
            $filename = $this->build->mod->short . '-' . $this->build->mc_version . '-';
            if ($this->build->nightly) {
                $filename .= $this->build->ref_name . '-' . $this->build->run_number;
            } else {
                $filename .= $this->build->mod_version;
            }
            return $filename;
        });
    }

    public function contentUpdate() {
        return $this->belongsTo(ContentUpdate::class, 'content_id');
    }
}
