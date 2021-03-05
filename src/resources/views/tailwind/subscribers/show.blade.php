@extends('layouts.'.config('laravel-cm.layout_file'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">

                <div class="card-header">
                    <h3>@lang('laravel-cm::subscribers.details_title')</h3>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-6">
                            @lang('laravel-cm::subscribers.email_address'):
                        </div>
                        <div class="col-sm-6">
                            {{$subscriber->EmailAddress}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            @lang('laravel-cm::subscribers.name'):
                        </div>
                        <div class="col-sm-6">
                            {{$subscriber->Name}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            @lang('laravel-cm::subscribers.subscribed_date'):
                        </div>
                        <div class="col-sm-6">
                            {{$subscriber->Date}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            @lang('laravel-cm::subscribers.status'):
                        </div>
                        <div class="col-sm-6">
                            {{$subscriber->State}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            @lang('laravel-cm::subscribers.email_reader'):
                        </div>
                        <div class="col-sm-6">
                            {{$subscriber->ReadsEmailWith}}
                        </div>
                    </div>
                    
                </div>

                <div class="card-footer">

                    <div class="row">

                        <div class="col-sm-6">
                            <a href="{{url()->previous()}}" class="btn btn-danger">{{ trans('laravel-cm::crud.cancel') }}</a>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>
@stop