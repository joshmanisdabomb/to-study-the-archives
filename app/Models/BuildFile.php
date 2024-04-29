<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 * @property \Carbon\Carbon|null created_at
 * @property \Carbon\Carbon|null updated_at
 * @property \Carbon\Carbon|null deleted_at
 *
 * @property-read \App\Models\Build|null build
 *
 * @property-read string filename
 */
class BuildFile extends Model
{
    protected $fillable = [
        'path',
        'type',
        'sources',
        'created_at',
    ];

    protected $casts = [
        'sources' => 'boolean',
    ];

    public function build() {
        return $this->belongsTo(Build::class, 'build_id');
    }

    public function getFilenameAttribute(): string {
        if ($this->nightly) {
            $group = $this->build->version;
            $filename = $group->code . '-' . $this->mc_version . '-' . $this->ref_name . '-' . $this->run_number;
        } else {
            $version = $this->version;
            $filename = $version->group->code . '-' . $this->mc_version . '-' . $this->mod_version;
        }
        return $filename;
    }
}
