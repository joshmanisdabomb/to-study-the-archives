<?php

namespace App\Models;

use App\Handlers\Link\LinkHandler;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Jenssegers\Model\Model;

class Ingredient extends Model {

    protected $fillable = ['item', 'tag', 'count', 'translation', 'link', 'vararg'];

    public static function renderSlot(?Ingredient $inside, string $class = 'gui-slot gui-slot-back') : string {
        return '<div class="' . $class . '">' . ($inside ? $inside->insideSlot() : '') . '</div>';
    }

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

    public function setTagFrom(array $tags) : Ingredient {
        if (!$this->item && $this->tag) {
            return new MultiIngredient(collect($tags[$this->tag])->map(fn($ing) => Ingredient::fromArray(array_replace($this->attributesToArray(), $ing)))->all());
        }
        return $this;
    }

    public function setNameFrom(array $translations) : Ingredient {
        if ($this->item) {
            $this->translation = $translations[$this->item][App::currentLocale()] ?? $translations[$this->item][Config::get('fallback_locale')] ?? $this->id;
        }
        return $this;
    }

    public function setLinkFrom(array $links) : Ingredient {
        if ($this->item) {
            $this->link = $links[$this->item] ?? null;
        }
        return $this;
    }

    public function insideSlot() : string {
        $content = '';
        if ($this->item) {
            $block = 'images/models/' . $this->namespace . '/block/' . $this->path . '.png';
            $item = 'images/models/' . $this->namespace . '/item/' . $this->path . '.png';
            $asset = file_exists(public_path() . '/' . $block) ? $block : $item;
            $content .= '<img class="gui-ingredient" src="' . asset($asset) . '" alt="' . $this->name . '" data-mctooltip="' . $this->name . '">';
        }
        if ($this->link) {
            $handler = LinkHandler::getHandlerForType($this->link['type']);
            $content = $handler::getImageMarkup($this->link, $content);
        }
        if ($this->vararg) $this->count = '...';
        if (!is_numeric($this->count) || $this->count > 1) {
            $content .= '<span class="gui-stack-count mc-text">' . $this->count . '</span>';
        }
        return $content;
    }

    public static function fromArray($arr) : Ingredient {
        if (Arr::isAssoc($arr)) {
            return new Ingredient($arr);
        } else {
            return new MultiIngredient(collect($arr)->map(fn(array $ing) => new Ingredient($ing))->all());
        }
    }

}
