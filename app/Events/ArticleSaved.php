<?php

namespace App\Events;

use App\Models\Article;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ArticleSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Article $article) {}
}
