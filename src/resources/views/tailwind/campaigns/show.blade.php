<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Campaign Summary') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5">
                    <h3 class="text-2xl">@lang('laravel-cm::campaigns.summary'): {{$campaign_id}}</h3>
                </div>
                <div class="flex-auto p-5">
                    <div class="flex flex-wrap -mx-2 mb-8">
                        <div class="w-1/4 px-2 mb-4">
                            <strong>@lang('laravel-cm::campaigns.recipients'):</strong>
                        </div>
                        <div class="w-3/4 px-2 mb-4">
                            {{$campaign->Recipients}}
                        </div>
                        <div class="w-1/4 px-2 mb-4">
                            <strong>@lang('laravel-cm::campaigns.total_open'):</strong>
                        </div>
                        <div class="w-3/4 px-2 mb-4">
                            {{$campaign->TotalOpened}}
                        </div>
                        <div class="w-1/4 px-2 mb-4">
                            <strong>@lang('laravel-cm::campaigns.clicks'):</strong>
                        </div>
                        <div class="w-3/4 px-2 mb-4">
                            {{$campaign->Clicks}}
                        </div>
                        <div class="w-1/4 px-2 mb-4">
                            <strong>@lang('laravel-cm::campaigns.unsubscribes'):</strong>
                        </div>
                        <div class="w-3/4 px-2 mb-4">
                            {{$campaign->Unsubscribed}}
                        </div>
                        <div class="w-1/4 px-2 mb-4">
                            <strong>@lang('laravel-cm::campaigns.bounced'):</strong>
                        </div>
                        <div class="w-3/4 px-2 mb-4">
                            {{$campaign->Bounced}}
                        </div>
                        <div class="w-1/4 px-2 mb-4">
                            <strong>@lang('laravel-cm::campaigns.unique_views'):</strong>
                        </div>
                        <div class="w-3/4 px-2 mb-4">
                            {{$campaign->UniqueOpened}}
                        </div>
                        <div class="w-1/4 px-2 mb-4">
                            <strong>@lang('laravel-cm::campaigns.spam_complaints'):</strong>
                        </div>
                        <div class="w-3/4 px-2 mb-4">
                            {{$campaign->SpamComplaints}}
                        </div>
                        <div class="w-1/4 px-2 mb-4">
                            <strong>Web-URL:</strong>
                        </div>
                        <div class="w-3/4 px-2 mb-4">
                            <a href="{{$campaign->WebVersionURL}}" target="_blank">{{$campaign->WebVersionURL}}</a>
                        </div>
                        <div class="w-1/4 px-2 mb-4">
                            <strong>Web-Text-URL:</strong>
                        </div>
                        <div class="w-3/4 px-2 mb-4">
                            <a href="{{$campaign->WebVersionTextURL}}" target="_blank">{{$campaign->WebVersionTextURL}}</a>
                        </div>
                        <div class="w-1/4 px-2 mb-4">
                            <strong>@lang('laravel-cm::campaigns.global_view'):</strong>
                        </div>
                        <div class="w-3/4 px-2 mb-4">
                            <a href="{{$campaign->WorldviewURL}}" target="_blank">{{$campaign->WorldviewURL}}</a>
                        </div>
                        <div class="w-1/4 px-2 mb-4">
                            <strong>@lang('laravel-cm::campaigns.forwards'):</strong>
                        </div>
                        <div class="w-3/4 px-2 mb-4">
                            {{$campaign->Forwards}}
                        </div>
                        <div class="w-1/4 px-2 mb-4">
                            <strong>@lang('laravel-cm::campaigns.likes'):</strong>
                        </div>
                        <div class="w-3/4 px-2 mb-4">
                            {{$campaign->Likes}}
                        </div>
                        <div class="w-1/4 px-2 mb-4">
                            <strong>@lang('laravel-cm::campaigns.mentions'):</strong>
                        </div>
                        <div class="w-3/4 px-2 mb-4">
                            {{$campaign->Mentions}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-8 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5">
                    <h3 class="text-2xl">@lang('laravel-cm::campaigns.email_readers')</h3>
                </div>
                <div class="flex-auto p-5">
                    <table class="w-full mb-4 text-gray-900 shadow-sm">
                        <thead>
                            <tr class="bg-gray-200 border-t border-b">
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::campaigns.client')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::campaigns.version')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::campaigns.percentage')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::campaigns.subscribers')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="border-b">
                                <td class="p-2">
                                    {{$user->Client}}
                                </td>
                                <td class="p-2">
                                    {{$user->Version}}
                                </td>
                                <td class="p-2">
                                    {{$user->Percentage}}
                                </td>
                                <td class="p-2">
                                    {{$user->Subscribers}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto mt-8 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5">
                    <h3 class="text-2xl">@lang('laravel-cm::campaigns.lists_segments')</h3>
                </div>

                <div class="flex-auto p-5">
                    @foreach($lists->Lists as $list)
                    <div class="flex flex-wrap -mx-2 mb-8">
                        <div class="w-1/4 px-2 mb-4">
                            ListID: {{$list->ListID}}
                        </div>
                        <div class="w-3/4 px-2 mb-4">
                            Name: {{$list->Name}}
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="p-5 bg-gray-300">

                    <a href="{{url()->previous()}}" class="rounded bg-red-500 text-white hover:bg-red-400 hover:text-red-100 px-2 py-1">{{ trans('laravel-cm::crud.cancel') }}</a>

                </div>
            </div>
        </div>
            
    </div>

</x-app-layout>