<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        <div class="flex justify-between h-16 gap-4 mr-2 items-center">
            <div class="flex md:flex-grow">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:-my-px md:ml-7 md:flex md:flex-grow md:justify-between">
                    <div class="flex gap-x-4">
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                            {{ __('wiki.navigation.home') }}
                        </x-nav-link>
                        <x-nav-link :href="route('category', ['registry' => 'block'])" :active="request()->routeIs('category') && request()->route('registry') == 'block'">
                            {{ __('wiki.navigation.block') }}
                        </x-nav-link>
                        <x-nav-link :href="route('category', ['registry' => 'item'])" :active="request()->routeIs('category') && request()->route('registry') == 'item'">
                            {{ __('wiki.navigation.item') }}
                        </x-nav-link>
                        <x-nav-link :href="route('category', ['registry' => 'entity'])" :active="request()->routeIs('category') && request()->route('registry') == 'entity'">
                            {{ __('wiki.navigation.entity') }}
                        </x-nav-link>
                        <x-nav-link :href="route('category', ['registry' => 'version'])" :active="request()->routeIs('category') && request()->route('registry') == 'version'">
                            {{ __('wiki.navigation.version') }}
                        </x-nav-link>
                        <x-nav-link :href="route('downloads')" :active="request()->routeIs('downloads') || request()->routeIs('nightly')">
                            {{ __('wiki.navigation.downloads') }}
                        </x-nav-link>
                    </div>

                    <div class="flex gap-x-4">
                        <x-nav-link :href="route('random')" :active="false">
                            <i class="fas fa-dice fa-lg"></i>
                        </x-nav-link>
                    </div>
                </div>
            </div>

            {{-- <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div> --}}

            <form action="{{ route('search') }}" method="get" class="appearance-none flex items-center w-full bg-gray-200 text-gray-700 border border-gray-200 rounded p-0.5 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="wiki-search">
                <input class="appearance-none bg-transparent border-none w-full text-gray-700 p-2 leading-tight focus:outline-none flex-grow-1" type="text" name="q" placeholder="{{ __('wiki.navigation.search', ['name' => config('app.name', 'Laravel')]) }}" aria-label="Search">
                <button class="flex-shrink-0 bg-indigo-500 hover:bg-indigo-700 border-indigo-500 hover:border-indigo-700 text-sm border-4 text-white px-1 m-1 rounded-lg" type="submit">
                    <i class="fas fa-search" style="position: relative; top: 1px;"></i>
                </button>
            </form>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('wiki.navigation.home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('category', ['registry' => 'block'])" :active="request()->routeIs('category') && request()->route('registry') == 'block'">
                {{ __('wiki.navigation.block') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('category', ['registry' => 'item'])" :active="request()->routeIs('category') && request()->route('registry') == 'item'">
                {{ __('wiki.navigation.item') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('category', ['registry' => 'entity'])" :active="request()->routeIs('category') && request()->route('registry') == 'entity'">
                {{ __('wiki.navigation.entity') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('category', ['registry' => 'version'])" :active="request()->routeIs('category') && request()->route('registry') == 'version'">
                {{ __('wiki.navigation.version') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('downloads')" :active="request()->routeIs('downloads')">
                {{ __('wiki.navigation.downloads') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('random')" :active="false">
                {{ __('wiki.navigation.random') }}
            </x-responsive-nav-link>
        </div>

        {{-- <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div> --}}
    </div>
</nav>
