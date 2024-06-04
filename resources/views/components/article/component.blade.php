@minify
    @if (is_array($text))
        @if (isset($text['translate']))
            {{ __($text['translate'], locale: $lang ?? app()->getFallbackLocale()) }}
        @elseif (isset($text['text']))
            {{ $text['text'] }}
        @endif
        @foreach ($text['extra'] ?? [] as $extra)
            <x-text-component :text="$extra" :lang />
        @endforeach
    @else
        {{ $text }}
    @endif
@endminify
