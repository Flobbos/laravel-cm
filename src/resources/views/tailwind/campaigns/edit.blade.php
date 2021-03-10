<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Campaign') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('laravel-cm::campaigns.update', ['campaign' => $campaign->CampaignID]) }}" role="form" method="POST"  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="p-5">
                        <h3 class="text-2xl">@lang('laravel-cm::campaigns.edit_title')</h3>
                        @lang('laravel-cm::crud.edit_headline')
                    </div>

                    <div class="flex-auto p-5">

                        @include('laravel-cm::notifications')

                        <div class="mb-4">
                            <label class="inline-block mb-2" for="Name">@lang('laravel-cm::campaigns.name')</label>
                            <input class="block w-full py-2 px-3 text-base font-normal leading-normal text-gray-700 bg-white border border-gray-400 rounded" type="text" name="Name" value="{{old('Name',$campaign->Name)}}" />
                        </div>

                        <div class="mb-4">
                            <label class="inline-block mb-2" for="Subject">@lang('laravel-cm::campaigns.subject')</label>
                            <input class="block w-full py-2 px-3 text-base font-normal leading-normal text-gray-700 bg-white border border-gray-400 rounded" type="text" name="Subject" value="{{old('Subject', $campaign->Subject)}}" />
                        </div>

                        <div class="mb-4">
                            <label class="inline-block mb-2" for="FromName">@lang('laravel-cm::campaigns.sender_name')</label>
                            <input class="block w-full py-2 px-3 text-base font-normal leading-normal text-gray-700 bg-white border border-gray-400 rounded" type="text" name="FromName" value="{{old('FromName',$campaign->FromName)}}" />
                        </div>

                        <div class="mb-4">
                            <label class="inline-block mb-2" for="FromEmail">@lang('laravel-cm::campaigns.sender_address')</label>
                            <input class="block w-full py-2 px-3 text-base font-normal leading-normal text-gray-700 bg-white border border-gray-400 rounded" type="text" name="FromEmail" value="{{old('FromEmail', $campaign->FromEmail)}}" />
                        </div>

                        <div class="mb-4">
                            <label class="inline-block mb-2" for="ReplyTo">@lang('laravel-cm::campaigns.reply_to_address')</label>
                            <input class="block w-full py-2 px-3 text-base font-normal leading-normal text-gray-700 bg-white border border-gray-400 rounded" type="text" name="ReplyTo" value="{{old('ReplyTo', $campaign->ReplyTo)}}" />
                        </div>

                        <div class="mb-4">
                            <label class="inline-block mb-2" for="HtmlUrl">
                                @lang('laravel-cm::campaigns.change_template')
                            </label>


                            <select id="HtmlUrl" class="block w-full py-2 px-3 text-base font-normal leading-normal text-gray-700 bg-white border border-gray-400 rounded" name="HtmlUrl">
                                <option value="{{ $campaign->PreviewURL }}">{{ $campaign->PreviewURL }} @lang('laravel-cm::campaigns.current_template')</option>
                                @foreach($templates as $template)
                                <option value="{{ $template->template_file_url }}">{{ $template->template_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="inline-block mb-2" for="ListID">@lang('laravel-cm::campaigns.recipient_lists')</label>
                            <select multiple name="ListIDs[]" class="block w-full py-2 px-3 text-base font-normal leading-normal text-gray-700 bg-white border border-gray-400 rounded">
                                @foreach($lists as $list)
                                @if(array_search($list->ListID, old('ListIDs') ?: array_column($campaign->ListIDs, 'ListID'))  !== false)
                                <option value="{{$list->ListID}}" selected>{{$list->Name}}</option>
                                @else
                                <option value="{{$list->ListID}}">{{$list->Name}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="p-5 bg-gray-300">

                        <div class="grid grid-cols-2 gap-4">

                            <div>
                                <a href="{{ route('laravel-cm::campaigns.index') }}" class="rounded bg-red-500 text-white hover:bg-red-400 hover:text-red-100 px-2 py-1">{{ trans('laravel-cm::crud.cancel') }}</a>
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
