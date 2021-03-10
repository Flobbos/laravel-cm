<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List Stats') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5">
                    <h3 class="text-2xl">@lang('laravel-cm::lists.stats_title'): {{$list_id}}</h3>
                </div>

                <div class="flex-auto p-5">

                    <h5 class="text-xl">@lang('laravel-cm::lists.totals')</h5>
                    <table class="w-full mb-4 text-gray-900 shadow-sm mb-5">
                        <thead>
                            <tr class="bg-gray-200 border-t border-b">
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.active_subscribers')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.unsubscribes')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.deletes')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.bounced')</th>
                            </tr>

                        </thead>
                        <tbody>
                            <tr class="border-b">
                                <td class="p-2">{{$list->TotalActiveSubscribers}}</td>
                                <td class="p-2">{{$list->TotalUnsubscribes}}</td>
                                <td class="p-2">{{$list->TotalDeleted}}</td>
                                <td class="p-2">{{$list->TotalBounces}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h5 class="text-xl">@lang('laravel-cm::lists.new_subscribers')</h5>
                    <table class="w-full mb-4 text-gray-900 shadow-sm mb-5">
                        <thead>
                            <tr class="bg-gray-200 border-t border-b">
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.today')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.yesterday')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.week')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.month')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.year')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b">
                                <td class="p-2">{{$list->NewActiveSubscribersToday}}</td>
                                <td class="p-2">{{$list->NewActiveSubscribersYesterday}}</td>
                                <td class="p-2">{{$list->NewActiveSubscribersThisWeek}}</td>
                                <td class="p-2">{{$list->NewActiveSubscribersThisMonth}}</td>
                                <td class="p-2">{{$list->NewActiveSubscribersThisYear}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h5 class="text-xl">@lang('laravel-cm::lists.unsubscribes')</h5>
                    <table class="w-full mb-4 text-gray-900 shadow-sm mb-5">
                        <thead>
                            <tr class="bg-gray-200 border-t border-b">
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.today')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.yesterday')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.week')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.month')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.year')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b">
                                <td class="p-2">{{$list->UnsubscribesToday}}</td>
                                <td class="p-2">{{$list->UnsubscribesYesterday}}</td>
                                <td class="p-2">{{$list->UnsubscribesThisWeek}}</td>
                                <td class="p-2">{{$list->UnsubscribesThisMonth}}</td>
                                <td class="p-2">{{$list->UnsubscribesThisYear}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h5 class="text-xl">@lang('laravel-cm::lists.deletes')</h5>
                    <table class="w-full mb-4 text-gray-900 shadow-sm mb-5">
                        <thead>
                            <tr class="bg-gray-200 border-t border-b">
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.today')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.yesterday')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.week')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.month')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.year')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b">
                                <td class="p-2">{{$list->DeletedToday}}</td>
                                <td class="p-2">{{$list->DeletedYesterday}}</td>
                                <td class="p-2">{{$list->DeletedThisWeek}}</td>
                                <td class="p-2">{{$list->DeletedThisMonth}}</td>
                                <td class="p-2">{{$list->DeletedThisYear}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h5 class="text-xl">@lang('laravel-cm::lists.bounced')</h5>
                    <table class="w-full mb-4 text-gray-900 shadow-sm mb-5">
                        <thead>
                            <tr class="bg-gray-200 border-t border-b">
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.today')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.yesterday')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.week')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.month')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::lists.year')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b">
                                <td class="p-2">{{$list->BouncesToday}}</td>
                                <td class="p-2">{{$list->BouncesYesterday}}</td>
                                <td class="p-2">{{$list->BouncesThisWeek}}</td>
                                <td class="p-2">{{$list->BouncesThisMonth}}</td>
                                <td class="p-2">{{$list->BouncesThisYear}}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <div class="p-5 bg-gray-300">
                    <a href="{{url()->previous()}}" class="rounded bg-red-500 text-white hover:bg-red-400 hover:text-red-100 px-2 py-1">{{ trans('laravel-cm::crud.cancel') }}</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>