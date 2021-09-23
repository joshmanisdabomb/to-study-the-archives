<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('wiki.page.home') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-alerts />
                <div class="p-6 bg-white border-b border-gray-200 text-center">
                    <h1 class="text-2xl mt-6 mb-12">Welcome to the Loosely Connected Concepts Wiki, serving {{ $articles }} pages.</h1>

                    <div class="grid md:grid-cols-5 sm:grid-cols-3 grid-cols-2 gap-x-2 mb-12">
                        @foreach (['Wasteland', 'Power', 'Nuclear', 'Materials', 'Nostalgic'] as $card)
                            <a href="{{ route("article", ['slug1' => 'concept', 'slug2' => strtolower($card)]) }}" class="overflow-hidden wiki-card text-blue-500 hover:text-blue-800 visited:text-blue-600">
                                <div class="rounded w-full wiki-card-img" style="background-image: url('/images/cards/{{ strtolower($card) }}.png');"></div>
                                <div class="text-xl p-2">{{ $card }}</div>
                            </a>
                        @endforeach
                    </div>

                    <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1">
                        <div class="">
                            <div class="text-2xl font-bold">
                                <i class="fas fa-tags fa-fw"></i>
                                Tags
                            </div>
                            <div class="text-left">
                                @foreach ($tags as $tag)
                                    <p><a href="{{ route("tag", ['tag' => \Illuminate\Support\Str::snake(strtolower($tag))]) }}" class="text-blue-500 hover:text-blue-800 visited:text-blue-600">{{ $tag }}</a></p>
                                @endforeach
                            </div>
                        </div>
                        <div class="">
                            <div class="text-2xl font-bold">
                                <i class="fas fa-layer-group fa-fw"></i>
                                Categories
                            </div>
                            <div class="text-left">
                                @foreach ($registries as $registry)
                                    <p><a href="{{ route("category", ['registry' => $registry]) }}" class="text-blue-500 hover:text-blue-800 visited:text-blue-600">{{ ucwords(str_replace('_', ' ', $registry)) }}</a></p>
                                @endforeach
                            </div>
                        </div>
                        <div class="">
                            <div class="text-2xl font-bold">
                                <i class="fas fa-fire fa-fw"></i>
                                Popular Pages
                            </div>
                            <div class="text-left">
                                @foreach ($popular as $article)
                                    <div class="grid" style="grid-template-columns: 1fr auto;">
                                        <a href="{{ route("article", ['slug1' => $article->slug1, 'slug2' => $article->slug2]) }}" class="text-blue-500 hover:text-blue-800 visited:text-blue-600">{{ $article->name }}</a>
                                        <p>{{ $article->counter }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="">
                            <div class="text-2xl font-bold">
                                <i class="fas fa-book fa-fw"></i>
                                Guides
                            </div>
                            <div class="text-left">
                                @foreach ($guides as $article)
                                    <p><a href="{{ route("article", ['slug1' => $article->slug1, 'slug2' => $article->slug2]) }}" class="text-blue-500 hover:text-blue-800 visited:text-blue-600">{{ $article->name }}</a></p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>