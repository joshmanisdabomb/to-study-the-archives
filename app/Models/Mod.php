<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Mod
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @property int id
 * @property string identifier
 * @property string name
 * @property string short
 * @property boolean legacy
 * @property string repository
 * @property string repository_branch
 * @property boolean tags
 * @property boolean sources
 * @property boolean modrinth
 * @property boolean curseforge
 * @property int|null content_id
 * @property \Carbon\Carbon|null created_at
 * @property \Carbon\Carbon|null updated_at
 *
 * @property-read \App\Models\ModVersion[] versions
 * @property-read \App\Models\ModVersion|null latest
 * @property-read \App\Models\Build[] builds
 * @property-read \App\Models\ContentUpdate|null contentUpdate
 *
 * @property-read string|null icon
 */
class Mod extends Model
{
    private static array $iconCache = [];

    protected $fillable = [
        'identifier',
        'name',
        'short',
        'legacy',
        'repository',
        'repository_branch',
        'tags',
        'sources',
        'modrinth',
        'curseforge',
        'content_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'legacy' => 'boolean',
        'tags' => 'boolean',
        'sources' => 'boolean',
        'modrinth' => 'boolean',
        'curseforge' => 'boolean',
    ];

    public function versions() {
        return $this->hasMany(ModVersion::class, 'mod_id');
    }

    public function latest() {
        return $this->hasOne(ModVersion::class, 'mod_id')->whereNotNull('released_at')->latest('released_at');
    }

    public function builds() {
        return $this->hasMany(Build::class, 'mod_identifier', 'identifier');
    }

    public function contentUpdate() {
        return $this->belongsTo(ContentUpdate::class, 'content_id');
    }

    public function icon(): Attribute {
        return Attribute::make(function ($value, array $attributes) {
            $identifier = $attributes['identifier'];
            if (!isset(static::$iconCache[$identifier])) {
                $icon = "resources/img/icons/{$identifier}_512.png";
                static::$iconCache[$identifier] = file_exists(base_path($icon)) ? $icon : null;
            }
            return static::$iconCache[$identifier];
        });
    }
}
