@minify
    @switch ($fragment['type'])
        @case ('text')
            <x-article.component :text="$fragment['component']" />
            @break
        @default
            @foreach ($fragment['fragments'] ?? '' as $child)
                <x-article.fragment :fragment="$child" :lang />
            @endforeach
            @break
    @endswitch
@endminify
