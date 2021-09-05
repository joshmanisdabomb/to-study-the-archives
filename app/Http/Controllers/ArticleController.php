<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleController extends Controller {

    public function view(string $slug1, string $slug2) {
        $article = Article::with(['sections', 'sections.fragments'])->where('slug1', $slug1)->where('slug2', $slug2)->first();
        return view('article', [
            'article' => $article
        ]);
    }

}
