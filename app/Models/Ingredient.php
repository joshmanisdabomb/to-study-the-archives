<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Jenssegers\Model\Model;

class Ingredient extends Model {

    protected $fillable = ['item', 'tag', 'count', 'translation'];

    public function getIdAttribute() : ?string {
        return $this->item;
    }

    public function getNamespaceAttribute() : ?string {
        if (!$this->item) return null;
        return explode(':', $this->item, 2)[0];
    }

    public function getPathAttribute() : ?string {
        if (!$this->item) return null;
        return explode(':', $this->item, 2)[1];
    }

    public function getNameAttribute() : ?string {
        $id = $this->id;
        return $this->translation ?: $id;
    }

    public function setNameFrom(array $translations) : Ingredient {
        if ($this->item) {
            $this->translation = $translations[$this->item][App::currentLocale()] ?? $translations[$this->item][Config::get('fallback_locale')] ?? $this->id;
        }
        return $this;
    }

    public function insideSlot() : string {
        $content = '';
        if ($this->item) {
            $id = explode(':', $this->item, 2);
            $content .= '<img src="' . asset('images/models/' . $this->namespace . '/' . $this->path . '.png') . '" alt="' . $this->name . '" data-mctooltip="' . $this->name . '">';
        }
        if ($this->count > 1) {
            $content .= '<span class="gui-stack-count mc-text">' . $this->count . '</span>';
        }
        return $content;
    }

}
