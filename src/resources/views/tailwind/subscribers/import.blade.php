<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Import Subscribers') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('laravel-cm::subscribers.import') }}" role="form" method="POST"  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="flex-auto p-5">

                    @include('laravel-cm::notifications')
                    <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-4">
                        <div>
                            <div class="mb-4">
                                <label class="inline-block mb-2" for="excel">@lang('laravel-cm::subscribers.excel_file')</label>
                                <div class="flex justify-left" x-data="{file: ''}">
                                    <label class="w-full flex items-center px-2 py-2 bg-white text-blue rounded tracking-wide border border-gray-400 cursor-pointer hover:border-blue-500 hover:bg-blue-400 hover:text-white">
                                        <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                        </svg>
                                        <span x-show="!file" class="ml-4">
                                            Select a file
                                        </span>
                                        <span x-show="file" x-text="file" class="ml-4"></span>
                                        <input type='file' name="excel" class="hidden" x-model="file" />
                                    </label>

                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="mb-4">
                                <label class="inline-block mb-2" for="listID">@lang('laravel-cm::subscribers.list_for_import')</label>
                                <select name="listID" class="block w-full py-2 px-3 text-base font-normal leading-normal text-gray-700 bg-white border border-gray-400 rounded">
                                    @foreach($lists as $list)
                                    <option value="{{$list->ListID}}">{{$list->Name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-5 bg-gray-300">

                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <a href="{{ route('laravel-cm::subscribers.index') }}" class="rounded bg-red-500 text-white hover:bg-red-400 hover:text-red-100 px-2 py-1">{{ trans('laravel-cm::crud.cancel') }}</a>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="rounded bg-green-500 text-white hover:bg-green-400 hover:text-green-100 px-2 py-1">{{ trans('laravel-cm::crud.save') }}</button>
                        </div>

                    </div>

                </div>

                </form>
            </div>

        </div>

    </div>
</x-app-layout>