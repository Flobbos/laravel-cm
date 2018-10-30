@extends('layouts.'.config('laravel-cm.layout_file'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">

                <form action="{{ route('laravel-cm::campaigns.send',$campaign->CampaignID) }}" role="form" method="POST"  enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="panel-heading panel-default">
                        <h3 class="panel-title">{{$campaign->Name}}</h3>
                        @lang('laravel-cm::campaigns.schedule_title')
                    </div>

                    <div class="panel-body">

                        @include('laravel-cm::notifications')
                        
                        @lang('laravel-cm::campaigns.preview'): <a href="{{$campaign->PreviewURL}}" target="_blank"><strong>{{$campaign->PreviewURL}}</strong></a><br />
                        
                        <div class="form-group">
                            <label class="control-label" for="ConfirmationEmail">@lang('laravel-cm::campaigns.confirmation_emails_title')</label>
                            <input class="form-control" placeholder="@lang('laravel-cm::campaigns.confirmation_emails_placeholder')" type="text" name="ConfirmationEmail" value="{{ old('ConfirmationEmail') }}" />
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="SendDate">@lang('laravel-cm::campaigns.send_date')</label>
                            <vue-date-picker name="SendDate"></vue-date-picker>
                        </div>

                    </div>

                    <div class="panel-footer">

                        <div class="row">

                            <div class="col-sm-6">
                                <a href="{{ route('laravel-cm::campaigns.index') }}" class="btn btn-danger">@lang('laravel-cm::crud.cancel')</a>
                            </div>

                            <div class="col-sm-6 text-right">
                                <button type="submit" class="btn btn-success">@lang('laravel-cm::crud.save')</button>
                            </div>

                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
@stop