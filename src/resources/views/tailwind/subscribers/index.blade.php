<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subscriber Lists') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex-auto p-5">
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-1/2 px-2">
                            <h3 class="text-2xl">@lang('laravel-cm::subscribers.title')</h3>
                        </div>
                        <div class="w-1/2 px-2 flex justify-end">
                            @if(!$lists->isEmpty())
                            <form action="{{route('laravel-cm::subscribers.index')}}" method="GET">
                                <div class="flex text-gray-700 px-5">
                                    <select name="listID" class="h-10 pl-3 pr-8 text-base placeholder-gray-600 border rounded-l focus:shadow-outline">
                                        <option value="">@lang('laravel-cm::subscribers.select_list')</option>
                                        @foreach($lists as $list)
                                        @if(request()->get('listID') == $list->ListID)
                                        <option value="{{$list->ListID}}" selected>{{$list->Name}}</option>
                                        @else
                                        <option value="{{$list->ListID}}">{{$list->Name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <button type="submit" class="flex items-center px-4 font-bold text-white bg-blue-500 rounded-r hover:bg-blue-400 focus:bg-blue-700">Go</button>
                                </div>
                            </form>
                            @endif
                            <a href="{{ route('laravel-cm::subscribers.show-import') }}" class="rounded bg-green-500 text-white hover:bg-green-400 hover:text-green-100 px-2 py-2">
                                Import
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex-auto p-5">
                    @include('laravel-cm::notifications')
                    <h3 class="text-2xl">@lang('laravel-cm::subscribers.active_subscribers')</h3>
                    <!-- active subscribers -->
                        @if($subscribed->isEmpty())
                        @lang('laravel-cm::crud.no_entries')
                        @else
                        <table class="w-full mb-4 text-gray-900 shadow-sm">
                            <thead>
                                <tr class="bg-gray-200 border-t border-b">
                                    <th class="text-left p-2 font-bold">E-Mail-Adresse</th>
                                    <th class="text-left p-2 font-bold">Name</th>
                                    <th class="text-left p-2 font-bold"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subscribed as $subscriber)
                                <tr class="border-b">
                                    <td class="p-2">{{$subscriber['email']}}</td>
                                    <td class="p-2">{{$subscriber['name']}}</td>
                                    <td class="p-2">
                                        <div class="flex justify-end" role="group">
                                            <a class="bg-blue-500 text-white text-sm rounded-l px-2 py-1 hover:bg-blue-400 hover:text-blue-100 mx-0" href="{{ route('laravel-cm::subscribers.details',['email'=>$subscriber['email'],'listID'=>request()->get('listID')]) }}">
                                                @lang('laravel-cm::subscribers.details')
                                            </a>
                                            <form action="{{ route('laravel-cm::subscribers.unsubscribe',['email'=>$subscriber['email'],'listID'=>request()->get('listID')]) }}"
                                                method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button class="bg-green-500 text-white text-sm rounded-r px-2 py-1 hover:bg-green-400 hover:text-green-100"
                                                        type="submit">@lang('laravel-cm::subscribers.unsubscribe')</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$subscribed->setPath('subscribers')->appends(request()->except('page'))->links()}}
                        @endif
                </div>
            </div>
        </div>
        <!-- unsubscribed -->
        <div class="max-w-7xl mx-auto mt-8 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex-auto p-5">
                    <h3 class="text-2xl">@lang('laravel-cm::subscribers.unsubscribed')</h3>
                    @if($unsubscribed->isEmpty())
                    @lang('laravel-cm::crud.no_entries')
                    @else
                    <table class="w-full mb-4 text-gray-900 shadow-sm">
                        <thead>
                            <tr class="bg-gray-200 border-t border-b">
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::subscribers.email_address')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::subscribers.name')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unsubscribed as $subscriber)
                            <tr class="border-b">
                                <td class="p-2">{{$subscriber['email']}}</td>
                                <td class="p-2">{{$subscriber['name']}}</td>
                                <td class="p-2 text-right">
                                    <div class="flex justify-end" role="group">
                                        <a class="bg-blue-500 text-white text-sm rounded-l px-2 py-1 hover:bg-blue-400 hover:text-blue-100 mx-0" href="{{ route('laravel-cm::subscribers.details',['email'=>$subscriber['email'],'listID'=>request()->get('listID')]) }}">
                                            @lang('laravel-cm::subscribers.details')
                                        </a>
                                        <form action="{{ route('laravel-cm::subscribers.resubscribe',['email'=>$subscriber['email'],'listID'=>request()->get('listID')]) }}"
                                            method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('PUT') }}
                                            <button class="bg-green-500 text-white text-sm rounded-r px-2 py-1 hover:bg-green-400 hover:text-green-100" type="submit">@lang('laravel-cm::subscribers.subscribe')</button>
                                        </form>
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
        <!-- unconfirmed subscribers -->
        <div class="max-w-7xl mx-auto mt-8 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex-auto p-5">
                    <h3 class="text-2xl">@lang('laravel-cm::subscribers.unconfirmed')</h3>
                    @if($unconfirmed->isEmpty())
                    @lang('laravel-cm::crud.no_entries')
                    @else
                    <table class="table table-striped">
                        <thead>
                            <tr class="bg-gray-200 border-t border-b">
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::subscribers.email_address')</th>
                                <th class="text-left p-2 font-bold">@lang('laravel-cm::subscribers.name')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unconfirmed as $subscriber)
                            <tr class="border-b">
                                <td class="p-2">{{$subscriber['email']}}</td>
                                <td class="p-2">{{$subscriber['name']}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
        <!-- bounced -->
        <div class="max-w-7xl mx-auto mt-8 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex-auto p-5">
                    <h3 class="text-2xl">@lang('laravel-cm::subscribers.bounced')</h3>
                    @if($bounced->isEmpty())
                    @lang('laravel-cm::crud.no_entries')
                    @else
                    <table class="table table-striped">
                        <thead>
                        <th class="text-left p-2 font-bold">@lang('laravel-cm::subscribers.email_address')</th>
                        <th class="text-left p-2 font-bold">@lang('laravel-cm::subscribers.name')</th>
                        </thead>
                        <tbody>
                            @foreach($bounced as $subscriber)
                            <tr>
                                <td class="p-2">{{$subscriber['email']}}</td>
                                <td class="p-2">{{$subscriber['name']}}</td>
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