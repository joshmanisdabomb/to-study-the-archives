<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Version
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @property int id
 * @property string mod_version
 * @property string mc_version
 * @property string code
 * @property int group_id
 * @property string title
 * @property string changelog
 * @property \Carbon\Carbon|null released_at
 *
 * @property-read \App\Models\VersionGroup group
 *
 * @property-read ?string bitbucketDownload
 */
class Version extends Model
{
    use HasFactory;

    public function group() {
        return $this->belongsTo(VersionGroup::class, 'group_id');
    }

    public function getBitbucketDownloadAttribute() : ?string {
        return 'https://bitbucket.org/joshmanisdabomb/loosely-connected-concepts/downloads/' . $this->group->code . '-' . $this->mc_version . '-' . $this->code . '.jar';
    }

    protected $dates = ['released_at'];
}
