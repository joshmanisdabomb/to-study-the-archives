@empty ($mod)
    @php return; @endphp
@endif
<div class="lg:basis-1/3 md:basis-1/2 basis-full px-4">
    <div class="p-4 outline outline-1 rounded-lg h-full flex flex-col justify-between {{ $class }} gap-y-3">
        <div class="flex gap-x-3 items-center flex-col xl:flex-row">
            @if ($mod->icon)
                <img src="{{ Vite::asset($mod->icon) }}" alt="Icon for {{ $mod->name }}" class="w-1/2 xl:w-auto xl:h-24 2xl:h-24 my-3 xl:my-0 max-w-36">
            @endif
            <div class="flex-1 flex flex-col justify-center xl:text-left">
                <h3 id="{{ (($type ?? null) ? ($type . '-') : '') }}" class="font-medium text-2xl mb-2 xl:mb-1">{{ $mod->name }}</h3>
                <p class="font-light">
                    {{ $mod->latest->mod_version }} for Minecraft {{ $mod->latest->mc_version }}, released
                    <span class="border-dashed border-black border-b" title="{{ $mod->latest->released_at->format('d/m/Y H:i:s') }}">{{ $mod->latest->released_at->diffForHumans() }}</span>.
                </p>
            </div>
        </div>
        <x-downloads.buttons :build="$mod->latest->build" label="Direct Download" button="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 focus:ring-blue-200"></x-downloads.buttons>
    </div>
</div>
