<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laravel CM') }}
        </h2>
    </x-slot>
    <div class="container xl mx-auto py-5">
        <div class="flex flex-col relative bg-white rounded border border-gray-300">
            <div class="flex-auto p-5 border-b">
                <h3 class="mb-3 text-xl">@lang('laravel-cm::dashboard.short_docs')</h3>
                Tailwind CSS
            </div>
            <div class="flex-auto p-5">
                @include('laravel-cm::notifications')

                <h4>1. Templates</h4>
                <p>
                    @lang('laravel-cm::dashboard.templates')
                </p>

                <h4>2. @lang('laravel-cm::dashboard.lists_title')</h4>
                <p>
                    @lang('laravel-cm::dashboard.lists')
                </p>

                <h4>3. @lang('laravel-cm::dashboard.campaigns_title')</h4>
                <p>
                    @lang('laravel-cm::dashboard.campaigns')
                </p>

                <h4>4. @lang('laravel-cm::dashboard.subscribers_title')</h4>
                <p>
                    @lang('laravel-cm::dashboard.subscribers')
                </p>
            </div>
        </div>
        <div class="flex flex-col relative bg-white rounded border border-gray-300 mt-5 mb-5">
            <div class="flex-auto p-5 border-b">
                <h3 class="mb-3 text-xl">@lang('laravel-cm::dashboard.config')</h3>
            </div>

            <div class="flex-auto p-5">
                @foreach(config('laravel-cm') as $key => $config)
                {{ucfirst($key)}}: <strong>{{$config}}</strong><br />
                @endforeach
            </div>

            <div class="flex-auto p-5 bg-gray-200">
                <a href="https://github.com/Flobbos/laravel-cm" target="_blank">LaravelCM Documentation @github/Flobbos/laravel-cm</a>
            </div>
        </div>

    </div>
</x-app-layout>
