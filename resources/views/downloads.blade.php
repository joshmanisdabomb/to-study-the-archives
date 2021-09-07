<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('LCC Downloads') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p>Below is a list of downloads:</p>
                    @foreach ($groups as $group)
                        <h1 class="font-semibold text-2xl pt-2">{{ $group->name }}</h1>
                        @foreach ($group->versions as $version)
                            <div class="w-full lg:flex items-center">
                                <p>
                                    {{ $version->mod_version }}{{ $version->title ? (' (' . $version->title . ')') : '' }} for Minecraft {{ $version->mc_version }}, released <span class="border-dashed border-black border-b" title="{{ $version->released_at->format('d/m/Y H:i:s') }}">{{ $version->released_at->diffForHumans() }}</span>
                                </p>
                                <div class="flex-grow lg:text-right py-1">
                                    <a href="https://bitbucket.org/joshmanisdabomb/loosely-connected-concepts/downloads/{{ $group->code }}-{{ $version->mc_version }}-{{ $version->code }}.jar" class="bg-blue-600 hover:bg-blue-800 text-white py-2 px-4 rounded inline-flex items-center">
                                        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/></svg>
                                        <span>Download from BitBucket</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
