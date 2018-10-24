@extends('layouts.'.config('laravel-cm.layout_file'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="panel-title">Subscribers</h3>
                        </div>
                        <div class="col-sm-3">
                            @if(!$lists->isEmpty())
                            <form class="form-inline pull-right" action="{{route('laravel-cm::subscribers.index')}}" method="GET">
                                <div class="form-group">
                                    <select name="listID" class="form-control">
                                        <option value="">Liste auswählen</option>
                                        @foreach($lists as $list)
                                        @if(request()->get('listID') == $list->ListID)
                                        <option value="{{$list->ListID}}" selected>{{$list->Name}}</option>
                                        @else
                                        <option value="{{$list->ListID}}">{{$list->Name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-md">Go</button>
                            </form>
                            @endif
                        </div>
                        <div class="col-sm-3">
                            <a href="{{ route('laravel-cm::subscribers.show-import') }}" class="btn btn-success btn-md pull-right">
                                <i class="glyphicon glyphicon-import"></i> Import
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            @include('laravel-cm::notifications')
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Active</h3>
                </div>
                <div class="panel-body">
                    <!-- active subscribers -->
                    @if($subscribed->isEmpty())
                    @lang('crud.no_entries')
                    @else
                    <table class="table table-striped">
                        <thead>
                        <th>E-Mail-Adresse</th>
                        <th>Name</th>
                        <th></th>
                        </thead>
                        <tbody>
                            @foreach($subscribed as $subscriber)
                            <tr>
                                <td>{{$subscriber['email']}}</td>
                                <td>{{$subscriber['name']}}</td>
                                <td>
                                    <div class="btn-group pull-right" role="group">
                                        <a class="btn btn-sm btn-default" href="{{ route('laravel-cm::subscribers.details',['email'=>$subscriber['email'],'listID'=>request()->get('listID')]) }}">
                                            <i class="glyphicon glyphicon-eye-open"></i> Details
                                        </a>
                                        <form class="btn-group"
                                            action="{{ route('laravel-cm::subscribers.unsubscribe',['email'=>$subscriber['email'],'listID'=>request()->get('listID')]) }}"
                                            method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-sm btn-danger"
                                                    type="submit"><i class="glyphicon glyphicon-trash"></i> Abmelden</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$subscribed->links()}}
                    @endif
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Unsubscribed</h3>
                </div>
                <div class="panel-body">
                    <!-- unsubscribed -->
                    @if($unsubscribed->isEmpty())
                    @lang('crud.no_entries')
                    @else
                    <table class="table table-striped">
                        <thead>
                        <th>E-Mail-Adresse</th>
                        <th>Name</th>
                        </thead>
                        <tbody>
                            @foreach($unsubscribed as $subscriber)
                            <tr>
                                <td>{{$subscriber['email']}}</td>
                                <td>{{$subscriber['name']}}</td>
                                <td>
                                    <div class="btn-group pull-right" role="group">
                                        <a class="btn btn-sm btn-default" href="{{ route('laravel-cm::subscribers.details',['email'=>$subscriber['email'],'listID'=>request()->get('listID')]) }}">
                                            <i class="glyphicon glyphicon-eye-open"></i> Details
                                        </a>
                                        <form class="btn-group"
                                            action="{{ route('laravel-cm::subscribers.resubscribe',['email'=>$subscriber['email'],'listID'=>request()->get('listID')]) }}"
                                            method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('PUT') }}
                                            <button class="btn btn-sm btn-success"
                                                    type="submit"><i class="glyphicon glyphicon-trash"></i> Anmelden</button>
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
            <!-- unconfirmed subscribers -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Unconfirmed</h3>
                </div>
                <div class="panel-body">
                    <!-- unconfirmed -->
                    @if($unconfirmed->isEmpty())
                    @lang('crud.no_entries')
                    @else
                    <table class="table table-striped">
                        <thead>
                        <th>E-Mail-Adresse</th>
                        <th>Name</th>
                        </thead>
                        <tbody>
                            @foreach($unconfirmed as $subscriber)
                            <tr>
                                <td>{{$subscriber['email']}}</td>
                                <td>{{$subscriber['name']}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
            <!-- bounced -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Bounced</h3>
                </div>
                <div class="panel-body">
                    <!-- unconfirmed -->
                    @if($bounced->isEmpty())
                    @lang('crud.no_entries')
                    @else
                    <table class="table table-striped">
                        <thead>
                        <th>E-Mail-Adresse</th>
                        <th>Name</th>
                        </thead>
                        <tbody>
                            @foreach($bounced as $subscriber)
                            <tr>
                                <td>{{$subscriber['email']}}</td>
                                <td>{{$subscriber['name']}}</td>
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