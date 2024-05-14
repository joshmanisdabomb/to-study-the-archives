@empty ($mod)
    @php return; @endphp
@endif
<div class="lg:basis-1/3 md:basis-1/2 basis-full px-4">
    <div class="p-4 outline outline-1 rounded-lg h-full flex flex-col justify-between {{ $class }}">
        <div class="flex gap-x-3 items-center flex-col xl:flex-row">
            @if (file_exists(base_path($icon = "resources/img/icons/{$mod->identifier}_512.png")))
                <img src="{{ Vite::asset($icon) }}" alt="Icon for {{ $mod->name }}" class="w-1/2 xl:w-auto xl:h-24 2xl:h-24 my-3 xl:my-0 max-w-36">
            @endif
            <div class="flex-1 flex flex-col justify-center xl:text-left">
                <h3 id="{{ $mod->identifier }}" class="font-medium text-2xl mb-2 xl:mb-1">{{ $mod->name }}</h3>
                <p class="font-light">
                    {{ $mod->latest->mod_version }} for Minecraft {{ $mod->latest->mc_version }}, released
                    <span class="border-dashed border-black border-b" title="{{ $mod->latest->released_at->format('d/m/Y H:i:s') }}">{{ $mod->latest->released_at->diffForHumans() }}</span>.
                </p>
            </div>
        </div>
        <div>
            <div class="flex {{ false ? 'justify-between' : 'justify-center' }} mt-3">
                @if (false)
                    <div class="flex gap-x-2">
                        <a href="#" class="svg-btn px-3 py-2 text-white transition-colors duration-150 bg-modrinth rounded-lg focus:outline-none focus:shadow-outline hover:bg-modrinth-700 active:bg-modrinth-800 focus:ring-4 focus:ring-modrinth-200">
                            {!! Vite::content('resources/img/external/modrinth.svg') !!}
                        </a>
                        <a href="#" class="svg-btn px-3 py-2 text-white transition-colors duration-150 bg-curseforge rounded-lg focus:outline-none focus:shadow-outline hover:bg-curseforge-500 active:bg-curseforge-600 focus:ring-4 focus:ring-curseforge-200">
                            {!! Vite::content('resources/img/external/curse.svg') !!}
                        </a>
                    </div>
                @endif
                <div class="flex gap-x-2">
                    @foreach ($mod->latest->build->files as $file)
                        @if ($file->sources) @continue @endif
                        <a href="{{ $file->id }}" class="svg-btn flex gap-x-1.5 px-3 py-2 text-white transition-colors duration-150 bg-blue-600 rounded-lg focus:outline-none focus:shadow-outline hover:bg-blue-700 active:bg-blue-800 focus:ring-4 focus:ring-blue-200">
                            @if ($file->type)
                                {!! Vite::content("resources/img/external/$file->type.svg") !!}
                            @else
                                <span class="block material-symbols-outlined">download</span>
                                Direct Download
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
