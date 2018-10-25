@extends('layouts.'.config('laravel-cm.layout_file'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">

                <div class="panel-heading panel-default">
                    <h3 class="panel-title">Summary: {{$campaign_id}}</h3>
                </div>

                <div class="panel-body">
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>Recipients:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{$campaign->Recipients}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>Gelesen:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{$campaign->TotalOpened}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>Klicks:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{$campaign->Clicks}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>Abmeldungen:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{$campaign->Unsubscribed}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>Bounced:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{$campaign->Bounced}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>Uniques:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{$campaign->UniqueOpened}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>Spam complaints:</strong>
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
                            <strong>Globale Ansicht:</strong>
                        </div>
                        <div class="col-sm-8">
                            <a href="{{$campaign->WorldviewURL}}" target="_blank">{{$campaign->WorldviewURL}}</a>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>Weiterleitungen:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{$campaign->Forwards}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>Likes:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{$campaign->Likes}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>Mentions:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{$campaign->Mentions}}
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading panel-default">
                    <h3 class="panel-title">Email-Readers</h3>
                </div>
                
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                        <th>Client</th>
                        <th>Version</th>
                        <th>Percentage</th>
                        <th>Subscribers</th>
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
            
            <div class="panel panel-default">
                <div class="panel-heading panel-default">
                    <h3 class="panel-title">Lists and Segments</h3>
                </div>
                
                <div class="panel-body">
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
            
                <div class="panel-footer">

                    <div class="row">

                        <div class="col-sm-6">
                            <a href="{{url()->previous()}}" class="btn btn-danger">{{ trans('crud.cancel') }}</a>
                        </div>

                    </div>

                </div>

            </div>
            
        </div>

    </div>
</div>
@stop