<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Expression;

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
 * @property int|null content_id
 * @property \Carbon\Carbon released_at
 * @property \Carbon\Carbon|null created_at
 * @property \Carbon\Carbon|null updated_at
 * @property \Carbon\Carbon|null deleted_at
 *
 * @property-read \App\Models\Mod mod
 * @property-read \App\Models\ModVersion|null version
 * @property-read \App\Models\ModVersion|null versionFromCode
 * @property-read \App\Models\BuildFile[]|null files
 * @property-read \App\Models\ContentUpdate|null contentUpdate
 */
class Build extends Model
{
    use Compoships;
    use SoftDeletes;

    private static ?array $modIdCache = null;

    protected $fillable = [
        'nightly',
        'repository',
        'mod_identifier',
        'mod_version',
        'mc_version',
        'run_number',
        'ref_name',
        'commit',
        'content_id',
        'released_at',
        'created_at',
    ];

    protected $casts = [
        'nightly' => 'boolean',
        'released_at' => 'datetime',
    ];

    public function mod() {
        return $this->belongsTo(Mod::class, 'mod_identifier', 'identifier');
    }

    public function version() {
        return $this->belongsTo(ModVersion::class, ['modid', 'mod_version'], ['mod_id', 'code']);
    }

    public function versionFromCode() {
        return $this->belongsTo(ModVersion::class, 'mod_version', 'code')->where(['mod_id' => new Expression('mod_identifier')]);
    }

    public function files() {
        return $this->hasMany(BuildFile::class, 'build_id');
    }

    public function contentUpdate() {
        return $this->belongsTo(ContentUpdate::class, 'content_id');
    }

    public function modid(): Attribute {
        return Attribute::make(function ($value, array $attributes) {
            $identifier = $attributes['mod_identifier'];
            static::$modIdCache ??= Mod::all(['id', 'identifier'])->pluck('id', 'identifier')->toArray();
            return static::$modIdCache[$identifier];
        });
    }
}
