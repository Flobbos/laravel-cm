<div class="hidden sm:flex sm:items-center sm:ml-6">
    <x-dropdown align="right" width="48">
        <x-slot name="trigger">
            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                <div>Newsletter</div>
                <div class="ml-1">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </button>
        </x-slot>
        <x-slot name="content">
            <x-dropdown-link :href="route('laravel-cm::dashboard')">
                @lang('laravel-cm::crud.dashboard')
            </x-dropdown-link>
            <x-dropdown-link :href="route(config('laravel-cm.newsletter_template_route').'index')">
                @lang('laravel-cm::templates.menu_title')
            </x-dropdown-link>
            <x-dropdown-link :href="route('laravel-cm::campaigns.index')">
                @lang('laravel-cm::campaigns.menu_title')
            </x-dropdown-link>
            <x-dropdown-link :href="route('laravel-cm::lists.index')">
                @lang('laravel-cm::lists.menu_title')
            </x-dropdown-link>
            <x-dropdown-link :href="route('laravel-cm::subscribers.index')">
                @lang('laravel-cm::subscribers.menu_title')
            </x-dropdown-link>
        </x-slot>
    </x-dropdown>
</div>