@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="panel-title">@lang('laravel-cm::lists.index_title')</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    @include('laravel-cm::notifications')
                    <!-- active subscribers -->
                    @if($lists->isEmpty())
                    @lang('laravel-cm::crud.no_entries')
                    @else
                    <table class="table table-striped">
                        <thead>
                        <th>Name</th>
                        <th>List ID</th>
                        <th></th>
                        </thead>
                        <tbody>
                            @foreach($lists as $list)
                            <tr>
                                <td>{{$list->Name}}</td>
                                <td>{{$list->ListID}}</td>
                                <td>
                                    <div class="btn-group pull-right" role="group">
                                        <a class="btn btn-sm btn-default" href="{{ route('admin.newsletters.lists.show',$list->ListID) }}">
                                            <i class="glyphicon glyphicon-eye-open"></i> @lang('laravel-cm::lists.details')
                                        </a>
                                        <a class="btn btn-sm btn-success" href="{{ route('admin.newsletters.lists.stats',$list->ListID) }}">
                                            <i class="glyphicon glyphicon-calendar"></i> @lang('laravel-cm::lists.stats')
                                        </a>
                                        <form class="btn-group"
                                            action="{{ route('admin.newsletters.lists.destroy',$list->ListID) }}"
                                            method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-sm btn-danger"
                                                    type="submit"><i class="glyphicon glyphicon-trash"></i> @lang('laravel-cm::crud.delete')</button>
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