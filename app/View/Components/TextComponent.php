<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\View\Component;

class TextComponent extends Component
{
    public string $lang;

    public function __construct(public array|string $text, ?string $lang = null) {
        $this->lang = $lang ?: App::getLocale();
    }

    public function render(): View {
        return view('components.article.component');
    }
}
