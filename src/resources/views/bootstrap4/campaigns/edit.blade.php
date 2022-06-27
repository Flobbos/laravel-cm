@extends('layouts.' . config('laravel-cm.layout_file'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">

                    <form action="{{ route('laravel-cm::campaigns.update', ['campaign' => $campaign->CampaignID]) }}"
                        role="form" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="card-header">
                            <h3>@lang('laravel-cm::campaigns.edit_title')</h3>
                            @lang('laravel-cm::crud.edit_headline')
                        </div>

                        <div class="card-body">

                            @include('laravel-cm::notifications')

                            <div class="form-group">
                                <label class="control-label" for="Name">@lang('laravel-cm::campaigns.name')</label>
                                <input class="form-control" type="text" name="Name"
                                    value="{{ old('Name', $campaign->Name) }}" />
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="Subject">@lang('laravel-cm::campaigns.subject')</label>
                                <input class="form-control" type="text" name="Subject"
                                    value="{{ old('Subject', $campaign->Subject) }}" />
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="FromName">@lang('laravel-cm::campaigns.sender_name')</label>
                                <input class="form-control" type="text" name="FromName"
                                    value="{{ old('FromName', $campaign->FromName) }}" />
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="FromEmail">@lang('laravel-cm::campaigns.sender_address')</label>
                                <input class="form-control" type="text" name="FromEmail"
                                    value="{{ old('FromEmail', $campaign->FromEmail) }}" />
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="ReplyTo">@lang('laravel-cm::campaigns.reply_to_address')</label>
                                <input class="form-control" type="text" name="ReplyTo"
                                    value="{{ old('ReplyTo', $campaign->ReplyTo) }}" />
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="HtmlUrl">
                                    @lang('laravel-cm::campaigns.change_template')
                                </label>


                                <select id="HtmlUrl" class="form-control" name="HtmlUrl">
                                    <option value="{{ $campaign->PreviewURL }}">{{ $campaign->PreviewURL }}
                                        @lang('laravel-cm::campaigns.current_template')</option>
                                    @foreach ($templates as $template)
                                        <option value="{{ $template->template_file_url }}">
                                            {{ $template->template_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="ListID">@lang('laravel-cm::campaigns.recipient_lists')</label>
                                <select multiple name="ListIDs[]" class="form-control">
                                    @foreach ($lists as $list)
                                        @if (array_search($list->ListID, old('ListIDs') ?: array_column($campaign->ListIDs, 'ListID')) !== false)
                                            <option value="{{ $list->ListID }}" selected>{{ $list->Name }}</option>
                                        @else
                                            <option value="{{ $list->ListID }}">{{ $list->Name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="card-footer">

                            <div class="row">

                                <div class="col-sm-6">
                                    <a href="{{ route('laravel-cm::campaigns.index') }}"
                                        class="btn btn-danger">{{ trans('laravel-cm::crud.cancel') }}</a>
                                </div>

                                <div class="col-sm-6 text-right">
                                    <button type="submit"
                                        class="btn btn-success">{{ trans('laravel-cm::crud.save') }}</button>
                                </div>

                            </div>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
@stop
