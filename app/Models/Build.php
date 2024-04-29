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
 * @property string repository
 * @property string mod_identifier
 * @property string mod_version
 * @property string mc_version
 * @property int|null version_id
 * @property int|null run_number
 * @property string ref_name
 * @property string|null commit
 * @property \Carbon\Carbon|null created_at
 * @property \Carbon\Carbon|null updated_at
 * @property \Carbon\Carbon|null deleted_at
 *
 * @property-read \App\Models\ModVersion|null version
 * @property-read \App\Models\BuildFile[]|null files
 */
class Build extends Model
{
    protected $fillable = [
        'nightly',
        'repository',
        'mod_identifier',
        'mod_version',
        'mc_version',
        'run_number',
        'ref_name',
        'commit',
        'created_at',
    ];

    protected $casts = [
        'nightly' => 'boolean',
    ];

    public function version() {
        return $this->belongsTo(ModVersion::class, 'commit', 'commit');
    }

    public function files() {
        return $this->hasMany(BuildFile::class, 'build_id');
    }
}
