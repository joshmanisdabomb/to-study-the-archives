<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleRedirect;
use App\Models\ArticleTag;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller {

    public function view(string $registry) {
        $articles = Article::where('slug1', $registry)->whereNull('deleted_at')->orderBy('name')->get();
        if ($articles->isEmpty()) {
            throw (new ModelNotFoundException)->setModel(Article::class);
        }
        return view('category', [
            'registry' => $registry,
            'articles' => $articles
        ]);
    }

}
