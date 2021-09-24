<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('wiki.page.search', ['for' => $query]) }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-alerts />
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (!$matches && !$similars)
                        <p>{{ __('wiki.search.none') }}</p>
                    @elseif ($matches)
                        <h1 class="font-semibold text-2xl mb-2">{{ trans_choice('wiki.search.matches', count($matches)) }}</h1>
                    @endif
                    @foreach ($matches as $match)
                        <a class="wiki-search-result max-w-sm w-full lg:max-w-full mb-4 border border-gray-300 bg-white rounded text-blue-500 hover:text-blue-800 visited:text-blue-600 flex" href="{{ route('article', ['slug1' => $match->slug1, 'slug2' => $match->slug2]) }}">
                            @if ($match->image !== null)
                                <div class="wiki-search-image bg-gray-200" style="background-image: url('{{ $match->image }}')"></div>
                            @endif
                            <div class="px-4 py-3 flex-grow flex flex-col leading-normal w-full border-gray-400 border-l-4">
                                <div class="font-bold text-xl mb-1">{{ $match->name }}</div>
                                <p class="text-gray-700 text-base">{{ $match->excerpt }}</p>
                            </div>
                        </a>
                    @endforeach
                    @if ($similars)
                        <h1 class="font-semibold text-2xl mb-2">{{ trans_choice('wiki.search.similar', count($similars)) }}</h1>
                    @endif
                    @foreach ($similars as $similar)
                        <a class="wiki-search-result max-w-sm w-full lg:max-w-full mb-4 border border-gray-300 bg-white rounded text-blue-500 hover:text-blue-800 visited:text-blue-600 flex" href="{{ route('article', ['slug1' => $similar->slug1, 'slug2' => $similar->slug2]) }}">
                            @if ($similar->image !== null)
                                <div class="wiki-search-image bg-gray-200" style="background-image: url('{{ $similar->image }}')"></div>
                            @endif
                            <div class="px-4 py-3 flex-grow flex flex-col leading-normal w-full border-gray-400 border-l-4">
                                <div class="font-bold text-xl mb-1">{{ $similar->name }}</div>
                                <p class="text-gray-700 text-base">{{ $similar->excerpt }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
