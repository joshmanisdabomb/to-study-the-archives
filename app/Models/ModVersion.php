<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ModVersion
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @property int id
 * @property int mod_id
 * @property string name
 * @property string mc_version
 * @property string code
 * @property string commit
 * @property string|null title
 * @property string changelog
 * @property int|null content_id
 * @property \Carbon\Carbon|null released_at
 *
 * @property-read \App\Models\Mod mod
 * @property-read \App\Models\Build build
 * @property-read \App\Models\Build[] builds
 * @property-read \App\Models\ContentUpdate|null contentUpdate
 */
class ModVersion extends Model
{
    use Compoships;

    protected $casts = [
        'released_at' => 'datetime',
    ];

    public function mod() {
        return $this->belongsTo(Mod::class, 'mod_id');
    }

    public function build() {
        return $this->hasOne(Build::class, 'commit', 'commit')->where(['nightly' => false]);
    }

    public function builds() {
        return $this->hasMany(Build::class, ['mod_identifier', 'mod_version'], ['mod.identifier', 'code']);
    }

    public function contentUpdate() {
        return $this->belongsTo(ContentUpdate::class, 'content_id');
    }
}
