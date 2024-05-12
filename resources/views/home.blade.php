@extends('layouts.app')

@section('head')
    <title>Home | The To Series of Minecraft Mods</title>
@endsection

@section('content')
    <main class="text-center">
        <h1 class="mt-8 text-4xl md:text-5xl lg:text-6xl font-black font-heading">To Series</h1>
        <p class="my-4 text-gray-600 font-extralight text-xl xl:text-2xl">A collection of Minecraft mods by joshmanisdabomb.</p>

        <h2 class="mt-10 mb-7 text-2xl lg:text-3xl font-bold font-heading">All Mods</h2>
        <div class="flex flex-row flex-wrap justify-center items-stretch gap-y-4">
            <x-home.mod :mod="$mods['to_base'] ?? null" class="bg-slate-100 outline-slate-400" />
        </div>

        <h2 class="mt-10 mb-7 text-2xl lg:text-3xl font-bold font-heading">Legacy Mods</h2>
        <div class="flex flex-row flex-wrap justify-center items-stretch gap-y-8">
            <x-home.mod :mod="$mods['lcc'] ?? null" class="bg-stone-100 outline-stone-400" />
            <x-home.mod :mod="$mods['lcc_forge'] ?? null" class="bg-stone-100 outline-stone-400" />
            <x-home.mod :mod="$mods['aimagg'] ?? null" class="bg-stone-100 outline-stone-400" />
            <x-home.mod :mod="$mods['yam'] ?? null" class="bg-stone-100 outline-stone-400" />
        </div>
    </main>
@endsection
