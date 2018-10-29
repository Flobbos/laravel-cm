@extends('layouts.'.config('laravel-cm.layout_file'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="panel-title">Campaigns</h3>
                        </div>
                        <div class="col-sm-6">
                            <div class="btn-group pull-right">
                                <a href="{{ route('laravel-cm::campaigns.create') }}" class="btn btn-default btn-sm">
                                    <i class="glyphicon glyphicon-plus"></i> Neue Kampagne
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('laravel-cm::notifications')
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Drafts</h3>
                </div>
                <div class="panel-body">
                    @if($drafts->isEmpty())
                    @lang('crud.no_entries')
                    @else
                    <table class="table">
                        <thead>
                        <th>Name</th>
                        <th>ID</th>
                        <th></th>
                        </thead>
                        <tbody>
                            @foreach($drafts as $campaign)
                            <tr>
                                <td>{{$campaign->Name}}</td>
                                <td>{{$campaign->CampaignID}}</td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-success" 
                                           accesskey="" href="{{route('laravel-cm::campaigns.show',$campaign->CampaignID)}}"><i class="glyphicon glyphicon-eye-open"></i> Summary</a>
                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Send <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{route('laravel-cm::campaigns.show-preview',$campaign->CampaignID)}}">Send Preview</a></li>
                                            <li><a href="{{route('laravel-cm::campaigns.show-send',$campaign->CampaignID)}}">Schedule</a></li>
                                        </ul>
                                        <a class="btn btn-sm btn-success" 
                                           accesskey="" href="{{route('laravel-cm::campaigns.edit',$campaign->CampaignID)}}"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                                        <form class="btn-group"
                                            action="{{ route('laravel-cm::campaigns.destroy',$campaign->CampaignID) }}"
                                            method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-sm btn-danger"
                                                    type="submit"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    <campaign-send-test ref="sendTestCampaign" csrf-token="{{ csrf_token() }}"></campaign-send-test>
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Scheduled</h3>
                </div>
                <div class="panel-body">
                    
                    @if($scheduled->isEmpty())
                    @lang('crud.no_entries')
                    @else
                    <table class="table table-striped">
                        <thead>
                        <th>Name</th>
                        <th>ID</th>
                        <th></th>
                        </thead>
                        <tbody>
                            @foreach($scheduled as $campaign)
                            <tr>
                                <td>{{$campaign->Name}}</td>
                                <td>{{$campaign->CampaignID}}</td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-primary" 
                                           accesskey=""href="{{route('laravel-cm::campaigns.show',$campaign->CampaignID)}}"><i class="glyphicon glyphicon-eye-open"></i> Details</a>
                                        <a class="btn btn-sm btn-default" role="button" 
                                           data-toggle="collapse" href="#{{$campaign->CampaignID}}" 
                                           aria-expanded="false"
                                           aria-controls="{{$campaign->CampaignID}}">Test</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Sent</h3>
                </div>
                <div class="panel-body">
                    
                    @if($sent->isEmpty())
                    @lang('crud.no_entries')
                    @else
                    <table class="table table-striped">
                        <thead>
                        <th>Name</th>
                        <th>ID</th>
                        <th></th>
                        </thead>
                        <tbody>
                            @foreach($sent as $campaign)
                            <tr>
                                <td>{{$campaign->Name}}</td>
                                <td>{{$campaign->CampaignID}}</td>
                                <td class="text-right">
                                    <a class="btn btn-sm btn-primary" 
                                       href="{{route('laravel-cm::campaigns.show',$campaign->CampaignID)}}"><i class="glyphicon glyphicon-eye-open"></i> Details</a>
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
</div>
@stop
