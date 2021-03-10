<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List Details') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5">
                    <h3 class="text-2xl">@lang('laravel-cm::lists.details_for',['title'=>$list->Title])</h3>
                </div>

                <div class="flex-auto p-5">
                    <div class="flex flex-wrap -mx-2 mb-8">

                            <div class="w-1/4 px-2 mb-4">
                                List ID:
                            </div>
                            <div class="w-3/4 px-2 mb-4">
                                {{$list->ListID}}
                            </div>

                            <div class="w-1/4 px-2 mb-4">
                                @lang('laravel-cm::lists.title'):
                            </div>
                            <div class="w-3/4 px-2 mb-4">
                                {{$list->Title}}
                            </div>

                            <div class="w-1/4 px-2 mb-4">
                                @lang('laravel-cm::lists.unsubscribe_page'):
                            </div>
                            <div class="w-3/4 px-2 mb-4">
                                {{$list->UnsubscribePage}}
                            </div>

                            <div class="w-1/4 px-2 mb-4">
                                @lang('laravel-cm::lists.double_opt_in'):
                            </div>
                            <div class="w-3/4 px-2 mb-4">
                                @if($list->ConfirmedOptIn)
                                @lang('laravel-cm::crud.yes')
                                @else
                                @lang('laravel-cm::crud.no')
                                @endif
                            </div>

                            <div class="w-1/4 px-2 mb-4">
                                @lang('laravel-cm::lists.success_page')
                            </div>
                            <div class="w-3/4 px-2 mb-4">
                                {{$list->ConfirmationSuccessPage}}
                            </div>

                            <div class="w-1/4 px-2 mb-4">
                                @lang('laravel-cm::lists.unsubscribe_settings'):
                            </div>
                            <div class="w-3/4 px-2 mb-4">
                                {{$list->UnsubscribeSetting}}
                            </div>

                    </div>

                </div>
                <div class="p-5 bg-gray-300">
                    <a href="{{url()->previous()}}" class="rounded bg-red-500 text-white hover:bg-red-400 hover:text-red-100 px-2 py-1">@lang('laravel-cm::crud.cancel')</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>