<!DOCTYPE html>
<html class="app page-{{ str_replace('.', '-', request()->route()->getName()) }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @include('layouts.head')
        @yield('head')
    </head>
    <body class="app bg-slate-50">
        @include('layouts.nav')
        @include('layouts.header')
        <div class="max-w-screen-3xl mx-auto p-5 md:px-10 gap-5 flex items-start lg:flex-row-reverse flex-col items-stretch lg:items-start">
            @hasSection('aside')
                <div class="flex-initial 2xl:w-1/5 lg:w-1/4 bg-white p-4 rounded-lg shadow-lg">
                    @yield('aside')
                </div>
            @endif
            <div class="flex-1 bg-white p-4 rounded-lg shadow-lg">
                @yield('content')
            </div>
        </div>
        @include('layouts.footer')
    </body>
</html>
