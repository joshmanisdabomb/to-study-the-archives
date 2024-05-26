@extends('layouts.app')

@section('head')
    <title>Home | To Collection of mods for Minecraft</title>
@endsection

@section('content')
    <main class="text-center">
        <h1 class="mt-8 text-4xl md:text-5xl lg:text-6xl font-black font-heading">To Collection</h1>
        <p class="my-4 text-gray-600 font-extralight text-xl xl:text-2xl">A series of mods with focused content, created by joshmanisdabomb.</p>

        <h2 class="mt-10 mb-7 text-2xl lg:text-3xl font-bold font-heading">All Mods</h2>
        <div class="flex flex-row flex-wrap justify-stretch md:justify-center items-stretch gap-y-8">
            <x-downloads.mod :mod="$mods['to_base'] ?? null" class="bg-slate-100 border-slate-400" />
        </div>

        <h2 class="mt-10 mb-7 text-2xl lg:text-3xl font-bold font-heading">Legacy Mods</h2>
        <div class="flex flex-row flex-wrap justify-stretch md:justify-center items-stretch gap-y-8">
            <x-downloads.mod :mod="$mods['lcc'] ?? null" class="bg-stone-100 border-stone-400" />
            <x-downloads.mod :mod="$mods['lcc_forge'] ?? null" class="bg-stone-100 border-stone-400" />
            <x-downloads.mod :mod="$mods['aimagg'] ?? null" class="bg-stone-100 border-stone-400" />
            <x-downloads.mod :mod="$mods['yam'] ?? null" class="bg-stone-100 border-stone-400" />
        </div>
    </main>
@endsection
