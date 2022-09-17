<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Build
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @property int id
 * @property boolean nightly
 * @property string mc_version
 * @property string mod_version
 * @property int|null version_id
 * @property string path
 * @property string|null source_path
 * @property int|null run_number
 * @property string ref_name
 * @property string|null sha
 * @property \Carbon\Carbon|null created_at
 * @property \Carbon\Carbon|null updated_at
 * @property \Carbon\Carbon|null deleted_at
 *
 * @property-read \App\Models\Version|null version
 *
 * @property-read string filename
 */
class Build extends Model
{
    use HasFactory;

    protected $fillable = [
        'nightly',
        'mc_version',
        'mod_version',
        'version_id',
        'path',
        'source_path',
        'run_number',
        'ref_name',
        'sha',
        'created_at',
    ];

    public function version() {
        return $this->belongsTo(Version::class, 'version_id');
    }

    public function getFilenameAttribute(): string {
        if ($this->nightly) {
            $group = VersionGroup::query()->where(['branch' => $this->ref_name])->first() ?: VersionGroup::query()->orderBy('order')->first();
            $filename = $group->code . '-' . $this->mc_version . '-' . $this->ref_name . '-' . $this->run_number;
        } else {
            $version = $this->version;
            $filename = $version->group->code . '-' . $this->mc_version . '-' . $this->mod_version;
        }
        return $filename;
    }

}
