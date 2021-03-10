<div class="sm:flex sm:items-center sm:ml-6">
    <div class="relative" x-data="{open: false}" @click.away="open: false" @close.stop="open = false">
        <div @click="open = ! open">
            <button class="flex items-center text-base pl-4 py-2 font-medium text-gray-600 focus:text-gray-800 focus:bg-gray-50 transition duration-150 ease-in-out">
                <div>Newsletter</div>
                <div class="ml-1">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </button>
        </div>
        <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute z-50 mt-2 w-full rounded-b-lg shadow-lg origin-top-right right-0"
            style="display: none;"
            @click="open = false">
            <div class="rounded-b-lg ring-1 ring-black ring-opacity-5 py-1 bg-white">
                <a class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" href="{{route('laravel-cm::dashboard')}}">
                    @lang('laravel-cm::crud.dashboard')
                </a>
                <a class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" href="{{route(config('laravel-cm.newsletter_template_route').'index')}}">
                    @lang('laravel-cm::templates.menu_title')
                </a>
                <a class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" href="{{route('laravel-cm::campaigns.index')}}">
                    @lang('laravel-cm::campaigns.menu_title')
                </a>
                <a class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" href="{{route('laravel-cm::lists.index')}}">
                    @lang('laravel-cm::lists.menu_title')
                </a>
                <a class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" href="{{route('laravel-cm::subscribers.index')}}">
                    @lang('laravel-cm::subscribers.menu_title')
                </a>
            </div>
        </div>
    </div>
</div>