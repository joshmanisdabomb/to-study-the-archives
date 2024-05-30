@empty ($build)
    @php return; @endphp
@endif
<div class="px-4 w-full sm:w-auto">
    <div class="p-4 border border-1 rounded-lg h-full flex flex-col justify-between items-center {{ $class }} sm:w-56 gap-y-3">
        @if ($build->mod->icon)
            <img src="{{ Vite::asset($build->mod->icon) }}" alt="Icon for {{ $build->mod->name }}" class="w-1/2 max-w-36">
        @endif
        <div class="flex-0 flex flex-col justify-center">
            <h3 id="{{ (($type ?? null) ? ($type . '-') : '') . $build->mod->identifier }}" class="font-medium text-lg">{{ $build->mod->name }}</h3>
        </div>
        <x-downloads.buttons :build="$build" label="" justify="start" :button="$type === 'nightly' ? 'bg-indigo-800 hover:bg-indigo-900 active:bg-indigo-950 focus:ring-indigo-200' : 'bg-blue-600 hover:bg-blue-700 active:bg-blue-800 focus:ring-blue-200'"></x-downloads.buttons>
    </div>
</div>
