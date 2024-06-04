<?php

namespace App\View\Components;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\View\Component;

class FragmentComponent extends Component
{
    public array $fragment;
    public string $lang;

    public function __construct(Article|array $fragment, ?string $lang = null) {
        $this->fragment = $fragment instanceof Article ? $fragment->data : $fragment;
        $this->lang = $lang ?: App::getLocale();
    }

    public function render(): View {
        return view('components.article.fragment');
    }
}
