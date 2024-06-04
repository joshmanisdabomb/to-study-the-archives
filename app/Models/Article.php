<?php

namespace App\Models;

use App\Events\ArticleSaved;
use App\View\Components\FragmentComponent;
use App\View\Components\TextComponent;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Expression;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;


/**
 * Class Article
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @property int id
 * @property int content_id
 * @property string namespace
 * @property string identifier
 * @property array data
 * @property \Carbon\Carbon|null created_at
 * @property \Carbon\Carbon|null updated_at
 *
 * @property-read \App\Models\BakedArticle[] bakes
 * @property-read \App\Models\Article[] versions
 * @property-read \App\Models\ContentUpdate contentUpdate
 *
 * @property-read string slug
 */
class Article extends Model
{
    use Notifiable, Compoships;

    protected $fillable = [
        'content_id',
        'namespace',
        'identifier',
        'data',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    protected $dispatchesEvents = [
        'saved' => ArticleSaved::class,
    ];

    public function bakes() {
        return $this->hasMany(BakedArticle::class, 'article_id');
    }

    public function versions() {
        return $this->hasMany(Article::class, ['namespace', 'identifier'], ['namespace', 'identifier']);
    }

    public function contentUpdate() {
        return $this->belongsTo(ContentUpdate::class, 'content_id');
    }

    public function bake(): array {
        $content = $this->data['content'] ?? [];
        if (!$content) return [];
        $baked = [];
        foreach ($content as $lang => $fragments) {
            $html = Blade::renderComponent(
                new FragmentComponent($this->data['content'][$lang] ?? $this->data['content'][App::getFallbackLocale()] ??  '', $lang)
            );
            $all = [
                'name' => Blade::renderComponent(
                    new TextComponent($this->data['name'] ?? '', $lang)
                ),
                'flavor' => Blade::renderComponent(
                    new TextComponent($this->data['flavor'] ?? '', $lang)
                ),
            ];
            $baked[$lang] = $this->bakes()->updateOrCreate(['lang' => $lang], [
                'lang' => $lang,
                ...$all,
                'html' => $html,
                'text' => strip_tags($html),
                'all' => $all + ['content' => $html],
                'content_id' => $this->content_id,
            ]);
        }
        return $baked;
    }

    public function scopeTyped(EloquentBuilder $query): EloquentBuilder {
        return $query->where(fn (Builder $query) => $query
            ->select(new Expression("articles.id = a.id"))
            ->from('articles AS a')
            ->where(['a.namespace' => new Expression('articles.namespace'), 'a.identifier' => new Expression('articles.identifier')])
            ->orderByDesc('a.content_id')
            ->limit(1)
            , true);
    }

    public function slug(): Attribute {
        return Attribute::make(fn ($value, array $attributes) => $attributes['namespace'] . ':' . $attributes['identifier']);
    }

    public function __toString() {
        return "$this->id[$this->namespace:$this->identifier]";
    }
}
