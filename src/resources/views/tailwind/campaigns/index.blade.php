<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Campaigns') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid lg:grid-cols-2 sm:grid-cols-1 p-5">
                    <div class="text-2xl">
                        <h3>Campaigns</h3>
                    </div>
                    <div class="text-right">
                        <a href="{{ route('laravel-cm::campaigns.create') }}"
                            class="inline-block font-normal text-center px-2 py-1 text-md leading-normal text-base rounded cursor-pointer text-white bg-blue-500 hover:text-white hover:bg-blue-400 hover:text-blue-100">
                            @lang('laravel-cm::campaigns.create_button')
                        </a>
                    </div>
                </div>
                <div class="flex-auto p-5">
                    @include('laravel-cm::notifications')
                    @if ($drafts->isEmpty())
                        @lang('laravel-cm::crud.no_entries')
                    @else
                        <table class="w-full mb-4 text-gray-900 shadow-sm">
                            <thead>
                                <tr class="bg-gray-200 border-t border-b">
                                    <th class="text-left p-2 font-bold">Name</th>
                                    <th class="text-left p-2 font-bold">ID</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($drafts as $campaign)
                                    <tr class="border-b">
                                        <td class="p-2">{{ $campaign->Name }}</td>
                                        <td class="p-2">{{ $campaign->CampaignID }}</td>
                                        <td class="p-2">
                                            <div class="flex justify-end" role="group">
                                                <a class="bg-blue-500 text-white hover:bg-blue-400 rounded-l px-2 py-1 text-sm mx-0 outline-none"
                                                    accesskey=""
                                                    href="{{ route('laravel-cm::campaigns.show', $campaign->CampaignID) }}">@lang('laravel-cm::campaigns.summary')</a>
                                                <div x-data="{ show: false }" @click.away="show = false">
                                                    <button @click="show = ! show" type="button"
                                                        class="flex bg-gray-400 text-white px-2 py-1 hover:bg-gray-300 hover:text-grary-100 focus:outline-none text-sm">
                                                        <span class="pl-1">@lang('laravel-cm::campaigns.send')</span>
                                                        <svg class="fill-current text-gray-200"
                                                            xmlns="http://www.w3.org/2000/svg" height="20"
                                                            viewBox="0 0 24 24" width="20">
                                                            <path d="M7 10l5 5 5-5z" />
                                                            <path d="M0 0h24v24H0z" fill="none" />
                                                        </svg>
                                                    </button>
                                                    <div x-show="show"
                                                        class="text-left absolute bg-gray-100 z-10 shadow-md"
                                                        style="min-width:10rem">
                                                        <a class="flex p-2 text-sm hover:underline hover:bg-white"
                                                            href="{{ route('laravel-cm::campaigns.show-preview', $campaign->CampaignID) }}">@lang('laravel-cm::campaigns.send_preview')</a>
                                                        <a class="flex p-2 text-sm hover:underline hover:bg-white"
                                                            href="{{ route('laravel-cm::campaigns.show-send', $campaign->CampaignID) }}">@lang('laravel-cm::campaigns.schedule')</a>
                                                    </div>
                                                </div>
                                                {{-- <a class="bg-green-400 text-white hover:bg-green-300 px-2 py-1 text-sm mx-0 outline-none"
                                               accesskey="" href="{{route('laravel-cm::campaigns.edit',$campaign->CampaignID)}}">@lang('laravel-cm::crud.edit')</a> --}}
                                                <form
                                                    action="{{ route('laravel-cm::campaigns.destroy', $campaign->CampaignID) }}"
                                                    method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button
                                                        class="bg-red-500 text-white hover:bg-red-400 hover:text-red-100 px-2 py-1 text-sm mx-0 outline-none rounded-r"
                                                        type="submit">@lang('laravel-cm::crud.delete')</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <campaign-send-test ref="sendTestCampaign" csrf-token="{{ csrf_token() }}"></campaign-send-test>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto mt-8 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5">
                    <h3 class="text-2xl">@lang('laravel-cm::campaigns.scheduled')</h3>
                </div>
                <div class="flex-auto p-5">
                    @if ($scheduled->isEmpty())
                        @lang('laravel-cm::crud.no_entries')
                    @else
                        <table class="w-full mb-4 text-gray-900 shadow-sm">
                            <thead>
                                <tr class="bg-gray-200 border-t border-b">
                                    <th class="text-left p-2 font-bold">Name</th>
                                    <th class="text-left p-2 font-bold">ID</th>
                                    <th class="text-left p-2 font-bold">@lang('laravel-cm::campaigns.scheduled_time')</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($scheduled as $campaign)
                                    <tr class="border-b">
                                        <td class="p-2">{{ $campaign->Name }}</td>
                                        <td class="p-2">{{ $campaign->CampaignID }}</td>
                                        <td class="p-2">{{ $campaign->DateScheduled }}</td>
                                        <td class="text-right p-2">
                                            <div class="flex justify-end" role="group">
                                                <a class="bg-blue-500 text-white hover:bg-blue-400 rounded-l px-2 py-1 text-sm mx-0 outline-none"
                                                    accesskey=""href="{{ route('laravel-cm::campaigns.show', $campaign->CampaignID) }}">@lang('laravel-cm::campaigns.details')</a>
                                                <a class="bg-yellow-500 text-white hover:bg-yellow-400 rounded-r px-2 py-1 text-sm mx-0 outline-none"
                                                    href="{{ route('laravel-cm::campaigns.unschedule', $campaign->CampaignID) }}">@lang('laravel-cm::campaigns.unschedule')</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto mt-8 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5">
                    <h3 class="text-2xl">@lang('laravel-cm::campaigns.sent')</h3>
                </div>
                <div class="flex-auto p-5">
                    @if ($sent->isEmpty())
                        @lang('laravel-cm::crud.no_entries')
                    @else
                        <table class="w-full mb-4 text-gray-900 shadow-sm">
                            <thead>
                                <tr class="bg-gray-200 border-t border-b">
                                    <th class="text-left p-2 font-bold">Name</th>
                                    <th class="text-left p-2 font-bold">ID</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sent as $campaign)
                                    <tr class="border-b">
                                        <td class="p-2">{{ $campaign->Name }}</td>
                                        <td class="p-2">{{ $campaign->CampaignID }}</td>
                                        <td class="text-right p-2">
                                            <a class="bg-blue-500 text-white hover:bg-blue-400 rounded px-2 py-1 text-sm mx-0 outline-none"
                                                href="{{ route('laravel-cm::campaigns.show', $campaign->CampaignID) }}">@lang('laravel-cm::campaigns.details')</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
