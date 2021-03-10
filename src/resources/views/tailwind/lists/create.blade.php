<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create List') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <form action="{{ route('laravel-cm::lists.store') }}" role="form" method="POST"  enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="flex-auto p-5">

                        @include('laravel-cm::notifications')

                        <div class="mb-4">
                            <label class="inline-block mb-2" for="Title">@lang('laravel-cm::lists.title')</label>
                            <input class="block w-full py-2 px-3 text-base font-normal leading-normal text-gray-700 bg-white border border-gray-400 rounded" type="text" name="Title" value="{{old('Title')}}" />
                        </div>

                        <div class="mb-4">
                            <label class="inline-block mb-2" for="UnsubscribePage">@lang('laravel-cm::lists.unsubscribe_page')</label>
                            <input class="block w-full py-2 px-3 text-base font-normal leading-normal text-gray-700 bg-white border border-gray-400 rounded" type="text" name="UnsubscribePage" value="{{old('UnsubscribePage',config('laravel-cm.unsubscribe_success'))}}" />
                        </div>

                        <div class="mb-4">
                            <label class="inline-block mb-2" for="ConfirmationSuccessPage">@lang('laravel-cm::lists.success_page')</label>
                            <input class="block w-full py-2 px-3 text-base font-normal leading-normal text-gray-700 bg-white border border-gray-400 rounded" type="text" name="ConfirmationSuccessPage" value="{{old('ConfirmationSuccessPage',config('laravel-cm.subscribe_success'))}}" />
                        </div>

                        <div class="mb-4">
                            <label class="inline-block mb-2" for="ConfirmedOptIn">@lang('laravel-cm::lists.double_opt_in')</label>
                            <select name="ConfirmedOptIn" class="block w-full py-2 px-3 text-base font-normal leading-normal text-gray-700 bg-white border border-gray-400 rounded">
                                <option value="true">@lang('laravel-cm::crud.yes')</option>
                                <option value="false">@lang('laravel-cm::crud.no')</option>
                            </select>
                        </div>

                    </div>

                    <div class="p-5 bg-gray-300">

                        <div class="grid grid-cols-2 gap-4">

                            <div>
                                <a href="{{ route('laravel-cm::lists.index') }}" class="rounded bg-red-500 text-white hover:bg-red-400 hover:text-red-100 px-2 py-1">@lang('laravel-cm::crud.cancel')</a>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="rounded bg-green-500 text-white hover:bg-green-400 hover:text-green-100 px-2 py-1">@lang('laravel-cm::crud.save')</button>
                            </div>

                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>