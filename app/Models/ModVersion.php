<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ModVersion
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @property int id
 * @property int mod_id
 * @property string mod_version
 * @property string mc_version
 * @property string code
 * @property string commit
 * @property string|null title
 * @property string changelog
 * @property \Carbon\Carbon|null released_at
 *
 * @property-read \App\Models\Mod mod
 * @property-read \App\Models\Build[] build
 */
class ModVersion extends Model
{
    protected $casts = [
        'released_at' => 'datetime',
    ];

    public function mod() {
        return $this->belongsTo(Mod::class, 'mod_id');
    }

    public function build() {
        return $this->hasOne(Build::class, 'commit', 'commit')->where(['nightly' => false]);
    }
}
