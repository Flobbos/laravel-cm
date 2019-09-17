@extends('layouts.'.config('laravel-cm.layout_file'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">

                <div class="card-header">
                    <h3>@lang('laravel-cm::lists.stats_title'): {{$list_id}}</h3>
                    
                </div>

                <div class="card-body">
                     
                    <h5>@lang('laravel-cm::lists.totals')</h5>
                    <table class="table">
                        <thead>
                        <th>@lang('laravel-cm::lists.active_subscribers')</th>
                        <th>@lang('laravel-cm::lists.unsubscribes')</th>
                        <th>@lang('laravel-cm::lists.deletes')</th>
                        <th>@lang('laravel-cm::lists.bounced')</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$list->TotalActiveSubscribers}}</td>
                                <td>{{$list->TotalUnsubscribes}}</td>
                                <td>{{$list->TotalDeleted}}</td>
                                <td>{{$list->TotalBounces}}</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <h5>@lang('laravel-cm::lists.new_subscribers')</h5>
                    <table class="table">
                        <thead>
                        <th>@lang('laravel-cm::lists.today')</th>
                        <th>@lang('laravel-cm::lists.yesterday')</th>
                        <th>@lang('laravel-cm::lists.week')</th>
                        <th>@lang('laravel-cm::lists.month')</th>
                        <th>@lang('laravel-cm::lists.year')</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$list->NewActiveSubscribersToday}}</td>
                                <td>{{$list->NewActiveSubscribersYesterday}}</td>
                                <td>{{$list->NewActiveSubscribersThisWeek}}</td>
                                <td>{{$list->NewActiveSubscribersThisMonth}}</td>
                                <td>{{$list->NewActiveSubscribersThisYear}}</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <h5>@lang('laravel-cm::lists.unsubscribes')</h5>
                    <table class="table">
                        <thead>
                        <th>@lang('laravel-cm::lists.today')</th>
                        <th>@lang('laravel-cm::lists.yesterday')</th>
                        <th>@lang('laravel-cm::lists.week')</th>
                        <th>@lang('laravel-cm::lists.month')</th>
                        <th>@lang('laravel-cm::lists.year')</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$list->UnsubscribesToday}}</td>
                                <td>{{$list->UnsubscribesYesterday}}</td>
                                <td>{{$list->UnsubscribesThisWeek}}</td>
                                <td>{{$list->UnsubscribesThisMonth}}</td>
                                <td>{{$list->UnsubscribesThisYear}}</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <h5>@lang('laravel-cm::lists.deletes')</h5>
                    <table class="table">
                        <thead>
                        <th>@lang('laravel-cm::lists.today')</th>
                        <th>@lang('laravel-cm::lists.yesterday')</th>
                        <th>@lang('laravel-cm::lists.week')</th>
                        <th>@lang('laravel-cm::lists.month')</th>
                        <th>@lang('laravel-cm::lists.year')</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$list->DeletedToday}}</td>
                                <td>{{$list->DeletedYesterday}}</td>
                                <td>{{$list->DeletedThisWeek}}</td>
                                <td>{{$list->DeletedThisMonth}}</td>
                                <td>{{$list->DeletedThisYear}}</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <h5>@lang('laravel-cm::lists.bounced')</h5>
                    <table class="table">
                        <thead>
                        <th>@lang('laravel-cm::lists.today')</th>
                        <th>@lang('laravel-cm::lists.yesterday')</th>
                        <th>@lang('laravel-cm::lists.week')</th>
                        <th>@lang('laravel-cm::lists.month')</th>
                        <th>@lang('laravel-cm::lists.year')</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$list->BouncesToday}}</td>
                                <td>{{$list->BouncesYesterday}}</td>
                                <td>{{$list->BouncesThisWeek}}</td>
                                <td>{{$list->BouncesThisMonth}}</td>
                                <td>{{$list->BouncesThisYear}}</td>
                            </tr>
                        </tbody>
                    </table>
                    
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