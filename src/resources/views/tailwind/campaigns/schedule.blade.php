<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Schedule Campaign') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('laravel-cm::campaigns.send',$campaign->CampaignID) }}" role="form" method="POST"  enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="p-5">
                        <h3 class="text-2xl">{{$campaign->Name}}</h3>
                        @lang('laravel-cm::campaigns.schedule_title')
                    </div>

                    <div class="flex-auto p-5">

                        @include('laravel-cm::notifications')

                        @lang('laravel-cm::campaigns.preview'): <a href="{{$campaign->PreviewURL}}" target="_blank"><strong>{{$campaign->PreviewURL}}</strong></a><br />

                        <div class="mb-4">
                            <label class="inline-block mb-2" for="ConfirmationEmail">@lang('laravel-cm::campaigns.confirmation_emails_title')</label>
                            <input class="block w-full py-2 px-3 text-base font-normal leading-normal text-gray-700 bg-white border border-gray-400 rounded" placeholder="@lang('laravel-cm::campaigns.confirmation_emails_placeholder')" type="text" name="ConfirmationEmail" value="{{ old('ConfirmationEmail') }}" />
                        </div>

                        <div class="mb-4">
                            <label class="inline-block mb-2" for="SendDate">@lang('laravel-cm::campaigns.send_date')</label>
                            <input type="text"
                                class="block w-full py-2 px-3 text-base font-normal leading-normal text-gray-700 bg-white border border-gray-400 rounded"
                                name="SendDate"
                                placeholder="Format: yyyy-mm-dd HH:mm"/>
                        </div>

                    </div>

                    <div class="p-5 bg-gray-300">

                        <div class="grid grid-cols-2 gap-4">

                            <div>
                                <a href="{{ route('laravel-cm::campaigns.index') }}" class="rounded bg-red-500 text-white hover:bg-red-400 hover:text-red-100 px-2 py-1">@lang('laravel-cm::crud.cancel')</a>
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