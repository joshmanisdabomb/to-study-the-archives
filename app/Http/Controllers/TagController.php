<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleRedirect;
use App\Models\ArticleTag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TagController extends Controller {

    public function view(string $tag) {
        $tag = ucwords(str_replace('_', ' ', $tag));
        $articles = Article::whereHas('tags', function(Builder $query) use ($tag) {
            $query->where('tag', $tag);
        })->whereNull('deleted_at')->orderBy('name')->get();
        if ($articles->isEmpty()) {
            throw (new ModelNotFoundException)->setModel(Article::class);
        }
        return view('list', [
            'articles' => $articles,
            'title' => $tag,
            'type' => 'tag',
            'matches' => 'tag'
        ]);
    }

}
