<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 * @property boolean sources
 * @property boolean tags
 *
 * @property-read \App\Models\ModVersion[] versions
 * @property-read \App\Models\ModVersion|null latest
 */
class Mod extends Model
{
    public function versions() {
        return $this->hasMany(ModVersion::class, 'mod_id');
    }

    public function latest() {
        return $this->hasOne(ModVersion::class, 'mod_id')->whereNotNull('released_at')->latest('released_at');
    }
}
