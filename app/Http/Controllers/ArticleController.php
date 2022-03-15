<?php

namespace App\Http\Controllers;

use App\Handlers\Fragment\FragmentHandler;
use App\Handlers\Fragment\TextFragmentHandler;
use App\Models\Article;
use App\Models\ArticleIndex;
use App\Models\ArticleRedirect;
use App\Models\ArticleTitle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;

class ArticleController extends Controller {

    public function list() {
        $articles = Article::whereNull('deleted_at')->orderBy('name')->get();
        return view('list', [
            'articles' => $articles,
            'title' => __('wiki.list.title'),
            'matches' => 'all'
        ]);
    }

    public function view(string $slug1, string $slug2) {
        $article = Article::with(['sections', 'sections.fragments', 'tags'])->where('slug1', $slug1)->where('slug2', $slug2)->whereNull('deleted_at')->first();
        if (!$article) {
            $redirect = ArticleRedirect::with(['article'])->where('slug1', $slug1)->where('slug2', $slug2)->firstOrFail();
            session()->flash('alert-yellow', 'Redirected from <span class="font-bold">/' . $slug1 . '/' . $slug2 . '</span>.');
            return redirect()->route('article', [
                'slug1' => $redirect->article->slug1,
                'slug2' => $redirect->article->slug2
            ]);
        }

        //Read info from info table fragment.
        $infos = $article->sections()->where('type', 'info')->get();
        foreach ($infos as $section) {
            $table = $section->fragments->firstWhere('markup.fragment', '=', 'table');
            if ($table === null) continue;
            $table = $table->markup;

            $info = [];
            foreach ($table['rows'] as $row) {
                $key = collect($row['cells'][0]['fragments'])
                    ->map(fn(array $fragment) => FragmentHandler::render($fragment, fn(string $content) => $content))
                    ->join('');
                $value = collect($row['cells'][1]['fragments'])
                    ->map(fn(array $fragment) => FragmentHandler::render($fragment, fn(string $content) => '<div>' . $content . '</div>'))
                    ->join('');
                $info[$key] = $value;
            }
            break;
        }
        return view('article', [
            'article' => $article,
            'main' => $article->sections()->where('type', 'main')->get(),
            'info' => $info ?? null
        ]);
    }

    public function search() {
        $locale = App::currentLocale();

        //Index translations for articles without them in the current locale.
        $translates = Article::with(['redirects'])->has('indices', '=', 0, 'and', function(Builder $query) {
            $query->where('locale', '=', App::currentLocale());
        })->whereNull('deleted_at')->get();
        foreach ($translates as $translate) {
            ArticleIndex::create([
                'article_id' => $translate->id,
                'article_redirect_id' => null,
                'locale' => App::currentLocale(),
                'name' => TextFragmentHandler::displayJsonText($translate->name)
            ]);
            foreach ($translate->redirects as $redirect) {
                if ($redirect->name) {
                    ArticleIndex::create([
                        'article_id' => $translate->id,
                        'article_redirect_id' => $redirect->id,
                        'locale' => App::currentLocale(),
                        'name' => TextFragmentHandler::displayJsonText($redirect->name)
                    ]);
                }
            }
        }

        //Perform search with this index.
        $term = request('q');

        //Article indexed name exact match.
        $article = Article::whereHas('indices', function(Builder $query) use ($term) { $query->where('name', '=', $term); })->whereNull('deleted_at')->first();
        if ($article) return redirect()->route('article', ['slug1' => $article->slug1, 'slug2' => $article->slug2]);

        //Search term matches.
        $query = Article::whereHas('indices', function(Builder $query) use ($term) { $query->where('name', 'like', '%' . $term . '%'); })->with(['sections', 'sections.fragments'])->whereNull('deleted_at');
        $matches = $query->get();

        //Typo matches.
        $chars = strlen($term);
        $query = Article::whereHas('indices', function(Builder $query) use ($term, $chars) {
            $query->whereNested(function(\Illuminate\Database\Query\Builder $query) use ($term, $chars) {
                for ($i = 0; $i <= $chars; $i++) {
                    $query->orWhere('name', 'like', '%' . substr_replace($term, '_', $i, 0) . '%');
                    if ($i != $chars) $query->orWhere('name', 'like', '%' . substr_replace($term, '_', $i, 1) . '%');
                }
            });
        })->with(['sections', 'sections.fragments'])->whereNotIn('id', $matches->pluck('id'))->whereNull('deleted_at');
        $typos = $query->get();

        return view('search', [
            'query' => $term,
            'matches' => $matches->all(),
            'similars' => $typos->all()
        ]);
    }

    public function random() {
        $article = Article::query()->whereNull('deleted_at')->inRandomOrder()->first();
        return redirect()->route('article', ['slug1' => $article->slug1, 'slug2' => $article->slug2]);
    }

}
