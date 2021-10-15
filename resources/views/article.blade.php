<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row items-center text-center md:text-left">
            @if ($info)
                <div class="wiki-header-image flex-grow-0 flex-shrink-0">{!! \Illuminate\Support\Arr::pull($info, 'Image') !!}</div>
            @endif
            <div class="{{ $info ? 'border-gray-400 md:border-l-2 md:pl-4 md:ml-1 py-3' : '' }}">
                <h1 class="font-semibold font-bold text-4xl text-gray-800 leading-tight">
                    {{ $article->name }}
                </h1>
                <aside>
                    <div>
                        @foreach ($main as $section)
                            <a href="#section-{{ $section->id }}" title="{{ $section->name }}" class="underline text-blue-500 hover:text-blue-800 visited:text-blue-600">{{ $section->name }}</a>
                            @if (!$loop->last)
                                <span class="wiki-separator">-</span>
                            @endif
                        @endforeach
                    </div>
                </aside>
            </div>
        </div>
        @if ($info)
            @php
                $colors = \Illuminate\Support\Arr::pull($info, 'Map Colors');
                $reqtool = \Illuminate\Support\Arr::pull($info, 'Required Tool');
                if ($reqtool) $tool = ['Required', $reqtool];
                $rectool = \Illuminate\Support\Arr::pull($info, 'Recommended Tool');
                if ($rectool) $tool = ['Recommended', $rectool];
            @endphp
            <div class="mt-2 flex flex-wrap gap-1 text-xs sm:text-sm">
                @foreach ($info as $k => $v)
                    <div class="rounded-xl bg-gray-200 py-0.5 px-2.5 flex items-center">
                        <div class="font-bold mr-1">{!! $k !!}:</div>
                        <div>{!! $v !!}</div>
                    </div>
                @endforeach
            </div>
            @if ($tool ?? null)
                <div class="mt-2 flex flex-wrap gap-1">
                    <div class="flex items-center">
                        <div class="font-bold mr-2">{!! $tool[0] !!} Tool:</div>
                        <div>{!! $tool[1] !!}</div>
                    </div>
                </div>
            @endif
            @if ($colors)
                <div class="mt-2 flex flex-wrap gap-1">
                    <div class="flex items-center">
                        <div class="font-bold mr-2">Map Color{{ substr_count($colors, '<div class="wiki-color">') > 1 ? 's' : '' }}:</div>
                        <div>{!! $colors !!}</div>
                    </div>
                </div>
            @endif
        @endif
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-alerts />
                <div class="p-6 bg-white border-b border-gray-200">
                    @foreach ($main as $section)
                        <h2 id="section-{{ $section->id }}" class="font-semibold text-2xl">{{ $section->name }}</h2>
                        @foreach ($section->fragments as $fragment)
                            {!! \App\Handlers\Fragment\FragmentHandler::render($fragment->markup, function(string $content, array $markup, string $class) {
                                return $class::getOuterMarkup($content, $markup);
                            }, $fragment) !!}
                        @endforeach
                    @endforeach
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($article->tags)
                        <div class="flex gap-1 items-center mb-1">
                            <span>Tags: </span>
                            <div class="flex flex-wrap gap-1">
                                @foreach ($article->tags as $tag)
                                    <a href="{{ route('tag', ['tag' => \Illuminate\Support\Str::snake(strtolower($tag->tag))]) }}" class="rounded-xl bg-blue-400 hover:bg-blue-600 visited:bg-blue-500 text-white py-0.5 px-2.5 flex items-center">
                                        <div>{{ $tag->tag }}</div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div>
                        <a href="{{ route('category', ['registry' => $article->slug1]) }}" class="underline text-blue-500 hover:text-blue-800 visited:text-blue-600">
                            View all {{ str_replace('_', ' ', $article->slug1) }} articles.
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
