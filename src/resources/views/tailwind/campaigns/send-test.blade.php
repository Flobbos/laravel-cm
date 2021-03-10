<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Campaign Test') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('laravel-cm::campaigns.send-preview', $campaign_id) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="p-5">
                        <h3 class="text-2xl">@lang('laravel-cm::campaigns.send_test_title')</h3>
                    </div>
                    <div class="flex-auto p-5">
                    @include('laravel-cm::notifications')

                        <div class="mb-4">
                            <label class="inline-block mb-2" for="emails">@lang('laravel-cm::campaigns.send_test_emails',['max_email'=>config('laravel-cm.max_test_emails')])</label>
                            <input type="text" id="emails" class="block w-full py-2 px-3 text-base font-normal leading-normal text-gray-700 bg-white border border-gray-400 rounded" name="emails">
                            <p class="text-sm italic mt-2">
                                @lang('laravel-cm::campaigns.send_test_hint')
                            </p>
                        </div>

                    </div>

                    <div class="p-5 bg-gray-300">

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <a href="{{ route('laravel-cm::campaigns.index') }}" class="rounded bg-red-500 text-white hover:bg-red-400 hover:text-red-100 px-2 py-1">@lang('laravel-cm::crud.cancel')</a>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="rounded bg-green-500 text-white hover:bg-green-400 hover:text-green-100 px-2 py-1">@lang('laravel-cm::campaigns.send-test')</button>
                            </div>

                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
