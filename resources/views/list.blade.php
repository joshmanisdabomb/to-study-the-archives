<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row items-center text-center md:text-left">
            <div>
                <h1 class="font-semibold font-bold text-4xl text-gray-800 leading-tight">{{ $title }}</h1>
                @if ($type ?? null)
                    <span class="text-gray-500"><i class="{!! __('wiki.icons.' . $type) !!}"></i>{{ __('wiki.list.type.' . $type) }}</span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-alerts />
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl mb-4">{{ trans_choice('wiki.list.matches.' . $matches, $articles->count()) }}</h2>
                    {!! \App\Handlers\Fragment\FragmentHandler::renderArticleList($articles->each(function(\App\Models\Article $article) { $article->link = true; })) !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
