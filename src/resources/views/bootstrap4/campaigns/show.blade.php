@extends('layouts.'.config('laravel-cm.layout_file'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">

                <div class="card-header">
                    <h3>@lang('laravel-cm::campaigns.summary'): {{$campaign_id}}</h3>
                </div>

                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>@lang('laravel-cm::campaigns.recipients'):</strong>
                        </div>
                        <div class="col-sm-8">
                            {{$campaign->Recipients}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>@lang('laravel-cm::campaigns.total_open'):</strong>
                        </div>
                        <div class="col-sm-8">
                            {{$campaign->TotalOpened}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>@lang('laravel-cm::campaigns.clicks'):</strong>
                        </div>
                        <div class="col-sm-8">
                            {{$campaign->Clicks}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>@lang('laravel-cm::campaigns.unsubscribes'):</strong>
                        </div>
                        <div class="col-sm-8">
                            {{$campaign->Unsubscribed}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>@lang('laravel-cm::campaigns.bounced'):</strong>
                        </div>
                        <div class="col-sm-8">
                            {{$campaign->Bounced}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>@lang('laravel-cm::campaigns.unique_views'):</strong>
                        </div>
                        <div class="col-sm-8">
                            {{$campaign->UniqueOpened}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>@lang('laravel-cm::campaigns.spam_complaints'):</strong>
                        </div>
                        <div class="col-sm-8">
                            {{$campaign->SpamComplaints}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>Web-URL:</strong>
                        </div>
                        <div class="col-sm-8">
                            <a href="{{$campaign->WebVersionURL}}" target="_blank">{{$campaign->WebVersionURL}}</a>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>Web-Text-URL:</strong>
                        </div>
                        <div class="col-sm-8">
                            <a href="{{$campaign->WebVersionTextURL}}" target="_blank">{{$campaign->WebVersionTextURL}}</a>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>@lang('laravel-cm::campaigns.global_view'):</strong>
                        </div>
                        <div class="col-sm-8">
                            <a href="{{$campaign->WorldviewURL}}" target="_blank">{{$campaign->WorldviewURL}}</a>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>@lang('laravel-cm::campaigns.forwards'):</strong>
                        </div>
                        <div class="col-sm-8">
                            {{$campaign->Forwards}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>@lang('laravel-cm::campaigns.likes'):</strong>
                        </div>
                        <div class="col-sm-8">
                            {{$campaign->Likes}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>@lang('laravel-cm::campaigns.mentions'):</strong>
                        </div>
                        <div class="col-sm-8">
                            {{$campaign->Mentions}}
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h3>@lang('laravel-cm::campaigns.email_readers')</h3>
                </div>
                
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <th>@lang('laravel-cm::campaigns.client')</th>
                        <th>@lang('laravel-cm::campaigns.version')</th>
                        <th>@lang('laravel-cm::campaigns.percentage')</th>
                        <th>@lang('laravel-cm::campaigns.subscribers')</th>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    {{$user->Client}}
                                </td>
                                <td>
                                    {{$user->Version}}
                                </td>
                                <td>
                                    {{$user->Percentage}}
                                </td>
                                <td>
                                    {{$user->Subscribers}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h3>@lang('laravel-cm::campaigns.lists_segments')</h3>
                </div>
                
                <div class="card-body">
                    @foreach($lists->Lists as $list)
                    <div class="row">
                        <div class="col-sm-6">
                            ListID: {{$list->ListID}}
                        </div>
                        <div class="col-sm-6">
                            Name: {{$list->Name}}
                        </div>
                    </div>
                    @endforeach
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