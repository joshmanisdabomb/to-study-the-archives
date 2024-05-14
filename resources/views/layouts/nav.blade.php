<nav class="bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-700 shadow-lg sticky top-0 left-0 w-full">
    <div class="max-w-screen-xl flex flex-wrap items-stretch justify-between mx-auto md:px-4 relative">
        <a href="#" class="flex items-center px-4 py-1 md:p-0 font-heading">
            <img src="{{ Vite::asset('resources/img/icons/to_all_512.png') }}" class="h-11 me-2" alt="To Play it All Logo" />
            <p class="self-center text-2xl dark:text-white transition-opacity duration-150 hover:opacity-50 whitespace-nowrap">
                <span class="font-black">To Collection</span>
                <span class="font-light hidden lg:inline">of mods for Minecraft</span>
            </p>
        </a>
        <button data-collapse-toggle="navbar-dropdown" type="button" aria-controls="navbar-dropdown" aria-expanded="false" class="group inline-flex md:hidden items-center px-3 justify-center text-black bg-gradient-to-b
                        hover:from-slate-100 hover:to-slate-200 focus:from-slate-100 focus:to-slate-200 active:from-slate-200 active:to-slate-300
                        aria-expanded:from-slate-200 aria-expanded:to-slate-300 aria-expanded:hover:from-slate-300 aria-expanded:hover:to-slate-400 aria-expanded:focus:from-slate-300 aria-expanded:focus:to-slate-400 aria-expanded:active:text-white aria-expanded:active:from-slate-400 aria-expanded:active:to-slate-500">
            <span class="material-symbols-outlined">
                <span class="group-aria-expanded:hidden">menu</span>
                <span class="hidden group-aria-expanded:block">close</span>
            </span>
        </button>
        <div class="absolute md:static top-full hidden w-full md:block md:w-auto bg-gray-50 md:bg-transparent shadow-lg md:shadow-none" id="navbar-dropdown">
            <ul class="flex flex-col font-medium p-0 md:flex-row dark:bg-gray-800 dark:border-gray-700">
                <li>
                    <a href="{{ route('home') }}" aria-current="page" class="{{ request()->routeIs('home') ? 'selected' : '' }} block p-4 h-full text-black bg-gradient-to-b
                        hover:from-violet-200 hover:to-violet-400 focus:from-violet-200 focus:to-violet-400 active:text-white active:from-violet-500 active:to-violet-700
                        selected:text-white selected:from-violet-500 selected:to-violet-700 selected:hover:from-violet-600 selected:hover:to-violet-800 selected:focus:from-violet-600 selected:focus:to-violet-800 selected:active:from-violet-700 selected:active:to-violet-900">
                        Home
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}" aria-current="page" class="{{ request()->routeIs('downloads') ? 'selected' : '' }} block p-4 h-full text-black bg-gradient-to-b
                        hover:from-lime-50 hover:to-lime-100 focus:from-lime-50 focus:to-lime-100 active:from-lime-200 active:to-lime-400
                        selected:text-white selected:from-lime-500 selected:to-lime-700 selected:hover:from-lime-600 selected:hover:to-lime-800 selected:focus:from-lime-600 selected:focus:to-lime-800 selected:active:from-lime-700 selected:active:to-lime-900">
                        Downloads
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
