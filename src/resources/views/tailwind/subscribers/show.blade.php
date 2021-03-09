<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subscriber Details') }}
        </h2>
    </x-slot>
    <div class="container xl mx-auto mt-10 pb-10">
        <div class="flex flex-col relative bg-white rounded border border-gray-300">
            <div class="flex-auto p-5">
                <div class="flex flex-wrap -mx-2 mb-8">
                
                    <div class="w-1/4 px-2 mb-4">
                        @lang('laravel-cm::subscribers.email_address'):
                    </div>
                    <div class="w-3/4 px-2 mb-4">
                        {{$subscriber->EmailAddress}}
                    </div>
                
                
                
                    <div class="w-1/4 px-2 mb-4">
                        @lang('laravel-cm::subscribers.name'):
                    </div>
                    <div class="w-3/4 px-2 mb-4">
                        {{$subscriber->Name}}
                    </div>
                
                
                
                    <div class="w-1/4 px-2 mb-4">
                        @lang('laravel-cm::subscribers.subscribed_date'):
                    </div>
                    <div class="w-3/4 px-2 mb-4">
                        {{$subscriber->Date}}
                    </div>
                
                
                
                    <div class="w-1/4 px-2 mb-4">
                        @lang('laravel-cm::subscribers.status'):
                    </div>
                    <div class="w-3/4 px-2 mb-4">
                        {{$subscriber->State}}
                    </div>
                
                
                
                    <div class="w-1/4 px-2 mb-4">
                        @lang('laravel-cm::subscribers.email_reader'):
                    </div>
                    <div class="w-3/4 px-2 mb-4">
                        {{$subscriber->ReadsEmailWith}}
                    </div>
                
                </div>
            </div>

            <div class="p-5 bg-gray-300">
                <a href="{{url()->previous()}}" class="rounded bg-red-500 text-white hover:bg-red-400 hover:text-red-100 px-2 py-1">{{ trans('laravel-cm::crud.cancel') }}</a>
            </div>

        </div>

    </div>
</x-app-layout>