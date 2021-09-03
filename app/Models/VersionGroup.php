<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VersionGroup extends Model
{
    use HasFactory;

    public function versions() {
        return $this->hasMany(Version::class, 'group_id')->orderByDesc('order');
    }
}
