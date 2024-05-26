<div class="flex {{ ($modstores = ($modstores ?? null) && ($mod->modrinth || $mod->curseforge)) ? 'justify-between' : ('justify-' . ($justify ?? 'center')) }}">
    @if ($modstores)
        <div class="flex gap-x-2">
            @if ($mod->modrinth)
                <a href="#" class="svg-btn px-3 py-2 text-white transition-colors duration-150 bg-modrinth rounded-lg focus:outline-none focus:shadow-outline hover:bg-modrinth-700 active:bg-modrinth-800 focus:ring-4 focus:ring-modrinth-200">
                    {!! Vite::content('resources/img/external/modrinth.svg') !!}
                </a>
            @endif
            @if ($mod->curseforge)
                <a href="#" class="svg-btn px-3 py-2 text-white transition-colors duration-150 bg-curseforge rounded-lg focus:outline-none focus:shadow-outline hover:bg-curseforge-500 active:bg-curseforge-600 focus:ring-4 focus:ring-curseforge-200">
                    {!! Vite::content('resources/img/external/curse.svg') !!}
                </a>
            @endif
        </div>
    @endif
    <div class="flex gap-x-2">
        @foreach ($build?->files ?: [] as $file)
            @if (empty($sources) && $file->sources) @continue @endif
            <a href="{{ route('download', $file) }}" class="svg-btn flex gap-x-1.5 px-3 py-2 text-white transition-colors duration-150 rounded-lg focus:outline-none focus:shadow-outline focus:ring-4 {{ $button }}">
                @if ($file->type)
                    {!! Vite::content("resources/img/external/$file->type.svg") !!}
                @elseif ($file->sources)
                    <span class="block material-symbols-outlined" aria-hidden="true">local_cafe</span>
                    <span class="sr-only">source</span>
                @else
                    <span class="block material-symbols-outlined">download</span>
                    {{ $label }}
                @endif
            </a>
        @endforeach
    </div>
</div>
