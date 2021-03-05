@extends('layouts.'.config('laravel-cm.layout_file'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">

                <form action="{{ route('laravel-cm::campaigns.store') }}" role="form" method="POST"  enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="card-header">
                        <h3>@lang('laravel-cm::campaigns.create_campaign_title')</h3>
                        @lang('laravel-cm::crud.create_headline')
                    </div>

                    <div class="card-body">

                        @include('laravel-cm::notifications')

                        <div class="form-group">
                            <label class="control-label" for="Name">@lang('laravel-cm::campaigns.name')</label>
                            <input class="form-control" placeholder="My awesome Campaign" type="text" name="Name" value="{{ old('Name') }}" />
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="Subject">@lang('laravel-cm::campaigns.subject')</label>
                            <input class="form-control" placeholder="My awesome Subject" type="text" name="Subject" value="{{old('Subject')}}" />
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="FromName">@lang('laravel-cm::campaigns.sender_name')</label>
                            <input class="form-control" placeholder="Mr Awesome" type="text" name="FromName" value="{{old('FromName',config('laravel-cm.from_name'))}}" />
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="FromEmail">@lang('laravel-cm::campaigns.sender_address')</label>
                            <input class="form-control" placeholder="mr@aweso.me" type="text" name="FromEmail" value="{{old('FromEmail',config('laravel-cm.from_email'))}}" />
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="ReplyTo">@lang('laravel-cm::campaigns.reply_to_address')</label>
                            <input class="form-control"placeholder="mrs@aweso.me" type="text" name="ReplyTo" value="{{old('ReplyTo',config('laravel-cm.reply_to'))}}" />
                        </div>
                        
                        @if($templates->isEmpty())
                        <p>@lang('laravel-cm::campaigns.no_templates_error')</p>
                        @else
                        <div class="form-group">
                            <label class="control-label" for="HtmlUrl">@lang('laravel-cm::campaigns.html_url')</label>
                            <select class="form-control" name="HtmlUrl">
                                @foreach($templates as $template)
                                @if(old('HtmlUrl') == $template->template_file_url)
                                <option selected value="{{$template->template_file_url}}">{{$template->template_name}}</option>
                                @else
                                <option value="{{$template->template_file_url}}">{{$template->template_name}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        @endif
                        
                        <div class="form-group">
                            <label class="control-label" for="ListID">@lang('laravel-cm::campaigns.recipient_lists')</label>
                            <select multiple name="ListIDs[]" class="form-control">
                                @foreach($lists as $list)
                                @if(in_array($list->ListID,old('ListIDs',[])))
                                <option value="{{$list->ListID}}" selected>{{$list->Name}}</option>
                                @else
                                <option value="{{$list->ListID}}">{{$list->Name}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="card-footer">

                        <div class="row">

                            <div class="col-sm-6">
                                <a href="{{ route('laravel-cm::campaigns.index') }}" class="btn btn-danger">{{ trans('laravel-cm::crud.cancel') }}</a>
                            </div>

                            <div class="col-sm-6 text-right">
                                <button type="submit" class="btn btn-success">{{ trans('laravel-cm::crud.save') }}</button>
                            </div>

                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
@stop
