<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleRedirect;
use App\Models\ArticleTag;

class TagController extends Controller {

    public function view() {
        return view('tag', []);
    }

}
