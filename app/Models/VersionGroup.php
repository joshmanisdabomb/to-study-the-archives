<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VersionGroup
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @property int id
 * @property string name
 * @property string code
 * @property string branch
 * @property boolean sources
 * @property boolean tags
 * @property int order
 *
 * @property-read \App\Models\Version[] versions
 */
class VersionGroup extends Model
{
    use HasFactory;

    public function versions() {
        return $this->hasMany(Version::class, 'group_id')->orderByDesc('order');
    }
}
