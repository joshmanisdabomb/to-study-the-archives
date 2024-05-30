@extends('layouts.app')

@section('head')
    <title>Downloads | To Collection of mods for Minecraft</title>
@endsection

@section('content')
    <main class="text-center">
        <h1 class="mt-8 text-4xl md:text-5xl lg:text-6xl font-black font-heading">Downloads</h1>
        <p class="my-4 text-gray-600 font-extralight text-xl xl:text-2xl">Download stable and nightly builds for Fabric, Quilt and Forge.</p>

        <h2 class="mt-10 mb-7 text-2xl lg:text-3xl font-bold font-heading">Latest Stable</h2>
        <div class="flex flex-row flex-wrap justify-stretch sm:justify-center items-stretch gap-y-8">
            <x-downloads.latest :build="$stable['to_base'] ?? null" type="stable" class="bg-slate-100 border-slate-400" />
        </div>

        <h2 class="mt-10 mb-7 text-2xl lg:text-3xl font-bold font-heading">Latest Nightly</h2>
        <div class="m-10 flex flex-col items-center">
            <p class="py-4 px-10 rounded-lg border-[3px] border border-double border-red-400 bg-red-100 text-red-900">Nightly builds are likely to be buggy and incomplete. Please make a backup before playing.</p>
        </div>
        <div class="flex flex-row flex-wrap justify-stretch sm:justify-center items-stretch gap-y-8">
            <x-downloads.latest :build="$nightly['to_base'] ?? null" type="nightly" class="bg-rose-200 border-rose-500" />
        </div>

        <h2 class="mt-10 mb-7 text-2xl lg:text-3xl font-bold font-heading">All Downloads</h2>

        <div class="relative overflow-x-auto">
            <table class="w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="font-heading text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="w-16"></th>
                        <th scope="col" class="px-6 py-3 lg:w-px lg:whitespace-nowrap">Mod</th>
                        <th scope="col" class="px-6 py-3">Version</th>
                        <th scope="col" class="px-6 py-3">Branch</th>
                        <th scope="col" class="px-6 py-3">Release</th>
                        <th scope="col" class="px-6 py-3">Uploaded</th>
                        <th scope="col" class="px-6 py-3">Download</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($all as $build)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="relative w-16">
                                @if ($build->mod?->icon)
                                    <img src="{{ Vite::asset($build->mod->icon) }}" alt="Icon for {{ $build->mod->name }}" class="absolute ps-6 top-0 left-0 w-full h-full object-contain">
                                @endif
                            </td>
                            <td class="px-6 py-4 lg:w-px lg:whitespace-nowrap">
                                {{ $build->mod?->name ?: $build->mod_identifier }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($build->version)
                                    <span
                                        @if ($build->version->title)
                                            class="border-dashed border-black border-b" title="{{ $build->version->title }}"
                                        @endif
                                    >
                                        {{ $build->version->name }}
                                    </span>
                                @else
                                    {{ $build->mod_version }}
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                {{ (!$build->nightly && $build->mod) ? $build->mod->repository_branch : $build->ref_name }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-x-1">
                                    @if ($build->nightly)
                                        <span class="text-xl leading-none material-symbols-outlined relative bottom-px" aria-hidden="true">nightlight</span>
                                        <span>Nightly Build {{ $build->run_number }}</span>
                                    @else
                                        <span class="text-xl leading-none material-symbols-outlined relative bottom-px" aria-hidden="true">check</span>
                                        <span>Stable</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="border-dashed border-black border-b" title="{{ $build->released_at->format('d/m/Y H:i:s') }}">{{ $build->released_at->diffForHumans() }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <x-downloads.buttons :build="$build" label="" justify="start"
                                     :button="$build->nightly ? 'bg-indigo-800 hover:bg-indigo-900 active:bg-indigo-950 focus:ring-indigo-200' : 'bg-blue-600 hover:bg-blue-700 active:bg-blue-800 focus:ring-blue-200'"
                                     :source="$build->nightly ? 'bg-lavender-500 hover:bg-lavender-600 active:bg-lavender-700 focus:ring-lavender-300' : 'bg-slate-400 hover:bg-slate-500 active:bg-slate-600 focus:ring-slate-300'"
                                ></x-downloads.buttons>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection
