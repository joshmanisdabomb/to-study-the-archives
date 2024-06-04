<?php

namespace App\Listeners;

use App\Events\ArticleSaved;

class BakeArticleListener
{
    public function handle(ArticleSaved $event): void {
        if (empty($event->article->data)) {
            $event->article->bakes()->delete();
            return;
        }
        $bakes = $event->article->bake();
        $event->article->bakes()->whereNotIn('lang', array_keys($bakes))->delete();
    }
}
