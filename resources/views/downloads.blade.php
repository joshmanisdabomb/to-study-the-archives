<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('wiki.page.downloads') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-alerts />
                <div class="p-6 bg-white border-b border-gray-200">
                    <p class="pb-2 text-center">
                        Below is a list of major versions, <a href="{{ route('nightly') }}" class="underline text-blue-500 hover:text-blue-800 visited:text-blue-600">click here</a> for nightly builds.
                    </p>

                    @foreach ($groups as $k => $group)
                        <h1 class="font-semibold text-2xl mb-2">{{ $group->name }}</h1>
                        <div class="text-center mb-3">
                            @foreach ($group->versions as $k2 => $version)
                                @php ($build = $version->builds->last())
                                @if (!$build) @continue @endif
                                <div class="w-full lg:flex justify-center items-center">
                                    <div class="inline-flex items-center lg:my-1 my-2">
                                        @if ($version->title)
                                            <span class="mr-2">{{ $version->title }}</span>
                                        @endif
                                        <a href="{{ route('build', $build) }}" class="
                                            @if ($k === 0 && $k2 === 0)
                                                bg-green-500 hover:bg-green-700 py-2 px-4 text-lg
                                            @else
                                                bg-blue-600 hover:bg-blue-800 py-1.5 px-3
                                            @endif
                                        text-white rounded inline-flex items-center">
                                            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/></svg>
                                            <span>{{ $version->mod_version }}</span>
                                            @if ($k === 0 && $k2 === 0)
                                                <span class="opacity-80 ml-1 text-gray-200 font-extrabold">(latest)</span>
                                            @endif
                                        </a>
                                        @if ($build->source_path)
                                            <a href="{{ route('source', $build) }}" class="ml-1.5 text-gray-500 hover:text-gray-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                    <p class="ml-1.5">
                                        for Minecraft {{ $version->mc_version }}, released <span class="border-dashed border-black border-b" title="{{ $version->released_at->format('d/m/Y H:i:s') }}">{{ $version->released_at->diffForHumans() }}</span>
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
