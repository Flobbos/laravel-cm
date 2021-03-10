<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subscriber Lists') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 text-right">
                    <a href="{{ route('laravel-cm::lists.create') }}" class="rounded bg-blue-500 text-white hover:bg-blue-400 hover:text-blue-100 px-2 py-1">
                        Neue Liste
                    </a>
                </div>
                <div class="flex-auto p-5">
                    @include('laravel-cm::notifications')
                    <!-- active subscribers -->
                    @if($lists->isEmpty())
                    @lang('laravel-cm::crud.no_entries')
                    @else
                    <table class="w-full mb-4 text-gray-900 shadow-sm">
                        <thead>
                            <tr class="bg-gray-200 border-t border-b">
                                <th class="text-left p-2 font-bold">Name</th>
                                <th class="text-left p-2 font-bold">List ID</th>
                                <th class="text-left p-2 font-bold"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lists as $list)
                            <tr class="border-b">
                                <td class="p-2">{{$list->Name}}</td>
                                <td class="p-2">{{$list->ListID}}</td>
                                <td class="p-2 text-right">
                                    <div class="flex justify-end" role="group">
                                        <a class="bg-blue-500 text-white hover:bg-blue-400 rounded-l px-2 py-1 text-sm mx-0 outline-none" href="{{ route('laravel-cm::lists.details',$list->ListID) }}">
                                            @lang('laravel-cm::lists.details')
                                        </a>
                                        <a class="bg-gray-500 text-white text-sm px-2 py-1 mx-0 hover:bg-gray-400 hover:text-gray-100" href="{{ route('laravel-cm::lists.stats',$list->ListID) }}">
                                            @lang('laravel-cm::lists.stats')
                                        </a>
                                        <a class="bg-green-500 text-white text-sm px-2 py-1 mx-0 hover:bg-green-400 hover:text-green-100" href="{{ route('laravel-cm::lists.edit',$list->ListID) }}">
                                            @lang('laravel-cm::crud.edit')
                                        </a>
                                        <form action="{{ route('laravel-cm::lists.destroy',$list->ListID) }}"
                                            method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="rounded-r text-white text-sm px-2 py-1 mx-0 bg-red-500 hover:bg-red-400 hover:text-red-100"
                                                    type="submit">@lang('laravel-cm::crud.delete')</button>
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
    </div>
</x-app-layout>