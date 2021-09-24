<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('wiki.page.home') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                    <p class="font-bold">404: Page Not Found</p>
                    <p>This page does not exist yet. Click <a class="underline text-blue-500 hover:text-blue-800 visited:text-blue-600" href="{{ url()->previous() }}">here</a> to go back or go to the <a class="underline text-blue-500 hover:text-blue-800 visited:text-blue-600" href="{{ route('home') }}">homepage</a>.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
