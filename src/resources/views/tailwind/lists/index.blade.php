@extends('layouts.'.config('laravel-cm.layout_file'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3>@lang('laravel-cm::lists.index_title')</h3>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('laravel-cm::lists.create') }}" class="btn btn-primary btn-smt">
                                Neue Liste
                            </a>
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
                                <td class="text-right">
                                    <div class="btn-group" role="group">
                                        <a class="btn btn-sm btn-primary" href="{{ route('laravel-cm::lists.details',$list->ListID) }}">
                                            @lang('laravel-cm::lists.details')
                                        </a>
                                        <a class="btn btn-sm btn-success" href="{{ route('laravel-cm::lists.stats',$list->ListID) }}">
                                            @lang('laravel-cm::lists.stats')
                                        </a>
                                        <a class="btn btn-sm btn-primary" href="{{ route('laravel-cm::lists.edit',$list->ListID) }}">
                                            @lang('laravel-cm::crud.edit')
                                        </a>
                                        <form class="btn-group"
                                            action="{{ route('laravel-cm::lists.destroy',$list->ListID) }}"
                                            method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-sm btn-danger"
                                                    type="submit">@lang('laravel-cm::crud.delete')</button>
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