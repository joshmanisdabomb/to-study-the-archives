<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\BakedArticle;
use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Expression;
use Symfony\Component\Console\Helper\ProgressBar;

class BakeArticleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article:bake {id?* : Numeric IDs or resource locations to rebake.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command bakes any passed articles, or all articles if none are listed.';

    /**
     * Execute the console command.
     */
    public function handle() {
        $ids = $this->argument('id');
        if (in_array('*', $ids)) {
            $articles = Article::all();
            $this->info('Using all ' . $articles->count() . ' articles in the database.');
        } elseif (!$ids) {
            $articles = Article::query()->typed()->get();
            $this->info('Using all ' . $articles->count() . ' current articles in the database.');
        } else {
            $byId = Article::query()->whereIn('id', $ids)->get();
            $byName = Article::query()->typed()->whereNested(fn (Builder $query) => $query
                ->orWhereIn(new Expression('CONCAT(namespace, ":", identifier)'), $ids)
                ->orWhereIn(new Expression('CONCAT(namespace, ":*")'), $ids)
            )->whereNotIn('id', $ids)->get();
            $articles = collect($byId)->merge($byName)->keyBy('id');
        }
        $this->info('Found articles: ' . $articles->map(fn (Article $article) => $article->__toString())->join(', ', ' and '));

        foreach ($articles as $article) {
            $this->getOutput()->write("Baking article $article... ");
            $baked = collect($article->bake());

            if ($baked->isEmpty()) {
                $this->warn('No baked articles were created or updated, is the JSON malformed?');
            } else {
                $message = [];
                $created = $baked->where('wasRecentlyCreated', '=', true)->pluck('id')->join(', ', ' and ');
                $updated = $baked->where('wasRecentlyCreated', '=', false)->pluck('id')->join(', ', ' and ');
                if ($created) $message[] = $created . ' were created';
                if ($updated) $message[] = $updated . ' were updated';

                $this->info('Baked article IDs ' . implode(' and ', $message) . '.');
            }
        }
    }
}
