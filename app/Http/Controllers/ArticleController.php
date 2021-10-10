<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleRedirect;

class ArticleController extends Controller {

    public function view(string $slug1, string $slug2) {
        $article = Article::with(['sections', 'sections.fragments'])->where('slug1', $slug1)->where('slug2', $slug2)->whereNull('deleted_at')->first();
        if (!$article) {
            $redirect = ArticleRedirect::with(['article'])->where('slug1', $slug1)->where('slug2', $slug2)->firstOrFail();
            session()->flash('alert-yellow', 'Redirected from <span class="font-bold">/' . $slug1 . '/' . $slug2 . '</span>.');
            return redirect()->route('article', [
                'slug1' => $redirect->article->slug1,
                'slug2' => $redirect->article->slug2
            ]);
        }
        return view('article', [
            'article' => $article
        ]);
    }

    public function search() {
        $term = request('q');
        $chars = strlen($term);

        $article = Article::where('name', '=', $term)->whereNull('deleted_at')->first();
        if ($article) return redirect()->route('article', ['slug1' => $article->slug1, 'slug2' => $article->slug2]);

        $redirect = ArticleRedirect::where('name', '=', $term)->first();
        if ($redirect) return redirect()->route('article', [
            'slug1' => $redirect->article->slug1,
            'slug2' => $redirect->article->slug2
        ]);

        $query = Article::with(['sections', 'sections.fragments'])->where('name', 'like', '%' . $term . '%')->whereNull('deleted_at');
        $matches = $query->get();

        $query = Article::with(['sections', 'sections.fragments'])->where(function($query) use ($term, $chars) {
            for ($i = 0; $i <= $chars; $i++) {
                $query->orWhere('name', 'like', '%' . substr_replace($term, '_', $i, 0) . '%');
                if ($i != $chars) $query->orWhere('name', 'like', '%' . substr_replace($term, '_', $i, 1) . '%');
            }
        });
        $query->whereNotIn('id', $matches->pluck('id'));
        $query->whereNull('deleted_at');
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
