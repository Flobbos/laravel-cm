@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="panel-title">Newsletter</h3>
                        </div>
                        <div class="col-sm-6">
                            <div class="btn-group pull-right">
                                <a href="{{ route('admin.newsletters.show-import') }}" class="btn btn-success btn-sm">
                                    <i class="glyphicon glyphicon-import"></i> Import
                                </a>
                                <a href="{{ route('admin.newsletters.create') }}" class="btn btn-default btn-sm pull-right">
                                    <i class="glyphicon glyphicon-plus"></i> Neue Liste
                                </a>
                                <a href="{{ route('admin.newsletters.create-template') }}" class="btn btn-default btn-sm pull-right">
                                    <i class="glyphicon glyphicon-plus"></i> Neues Template
                                </a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="panel-title">Subscribers</h3>
                        </div>
                        <div class="col-sm-6">
                            <form class="form-inline pull-right" action="{{route('admin.newsletters.index')}}" method="GET">
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
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    @include('admin.notifications')
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
                                        <a class="btn btn-sm btn-default" href="{{ route('admin.newsletters.show',$subscriber['email']) }}">
                                            <i class="glyphicon glyphicon-eye-open"></i> Details
                                        </a>
                                        <form class="btn-group"
                                            action="{{ route('admin.newsletters.destroy',$subscriber['email']) }}"
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
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Unsubscribed</h3>
                </div>
                <div class="panel-body">
                    @endif
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
                                        <a class="btn btn-sm btn-default" href="{{ route('admin.newsletters.show',$subscriber['email']) }}">
                                            <i class="glyphicon glyphicon-eye-open"></i> Details
                                        </a>
                                        <form class="btn-group"
                                            action="{{ route('admin.newsletters.update',$subscriber['email']) }}"
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
                                <td>
                                    <div class="btn-group pull-right" role="group">
                                        <a class="btn btn-sm btn-default" href="{{ route('admin.newsletters.edit',$subscriber['email']) }}">
                                            <i class="glyphicon glyphicon-pencil"></i> @lang('crud.edit')
                                        </a>
                                        <form class="btn-group"
                                            action="{{ route('admin.newsletters.update',$subscriber['email']) }}"
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
        </div>
    </div>
</div>
@stop