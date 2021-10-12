<?php

namespace App\Handlers\Fragment;

use App\Models\Article;
use App\Models\ArticleFragment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

abstract class FragmentHandler {

    public static function getHandlerForType(string $type) : string {
        return '\\App\\Handlers\\Fragment\\' . Str::studly($type) . 'FragmentHandler';
    }

    public static function render(array $markup, callable $renderer, $dump = null) : string {
        $handler = FragmentHandler::getHandlerForType($markup['fragment']);
        if (class_exists($handler)) {
            return $renderer($handler::getMarkup($markup), $markup, $handler);
        } else {
            $content = '';
            $cloner = new VarCloner();
            $dumper = new HtmlDumper();

            $dumper->dump(
                $cloner->cloneVar($dump ?: $markup),
                function ($line, $depth) use (&$content) {
                    if ($depth >= 0) $content .= str_repeat('  ', $depth) . $line . "\n";
                }
            );

            return $content;
        }
    }

    public static function renderArticleList(Collection $articles) : string {
        return '<div class="wiki-article-list grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">' . $articles->map(function ($article) {
            $tag = $article->link ? 'a' : 'span';
            return '<' . $tag . ' class="max-w w-full lg:max-w-full border border-gray-300 bg-white rounded ' . ($article->link ? 'text-indigo-500 hover:text-indigo-800 visited:text-indigo-600 ' : '') . 'flex" href="' . route('article', ['slug1' => $article->slug1, 'slug2' => $article->slug2]) . '">' .
                ($article->image !== null ? '<div class="wiki-article-list-image bg-gray-200" style="background-image: url(\'' . $article->image . '\')"></div>' : '') .
                '<div class="px-4 py-3 flex-grow flex flex-col leading-normal w-full border-gray-400 border-l-4">
                    <div class="font-bold text-xl">' . $article->name . '</div>
                </div>
            </' . $tag . '>';
        })->join('') . '</div>';
    }

    public static function type() : string {
        $shortName = substr((new \ReflectionClass(static::class))->getShortName(), 0, -strlen("FragmentHandler"));
        return Str::snake($shortName);
    }

    public static abstract function getMarkup(array $fragment) : string;

    public static abstract function getOuterMarkup(string $content, array $fragment) : string;

}
