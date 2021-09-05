<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($article->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @foreach ($article->sections as $section)
                        <h1 class="font-semibold text-2xl pt-2">{{ $section->name }}</h1>
                        @foreach ($section->fragments as $fragment)
                            <p class="pb-2">
                                {!! ($fragment->handler)::getMarkup($fragment) !!}
                            </p>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
