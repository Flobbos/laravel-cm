@extends('layouts.'.config('laravel-cm.layout_file'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">

                <div class="panel-heading panel-default">
                    <h3 class="panel-title">Stats: {{$list_id}}</h3>
                    
                </div>

                <div class="panel-body">
                     
                    <h5>Totals</h5>
                    <table class="table">
                        <thead>
                        <th>Active</th>
                        <th>Unsubscribed</th>
                        <th>Deleted</th>
                        <th>Bounced</th>
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
                    
                    <h5>New Subscribers</h5>
                    <table class="table">
                        <thead>
                        <th>Today</th>
                        <th>Yesterday</th>
                        <th>Week</th>
                        <th>Month</th>
                        <th>Year</th>
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
                    
                    <h5>Unsubscribed</h5>
                    <table class="table">
                        <thead>
                        <th>Today</th>
                        <th>Yesterday</th>
                        <th>Week</th>
                        <th>Month</th>
                        <th>Year</th>
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
                    
                    <h5>Deleted</h5>
                    <table class="table">
                        <thead>
                        <th>Today</th>
                        <th>Yesterday</th>
                        <th>Week</th>
                        <th>Month</th>
                        <th>Year</th>
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
                    
                    <h5>Bounced</h5>
                    <table class="table">
                        <thead>
                        <th>Today</th>
                        <th>Yesterday</th>
                        <th>Week</th>
                        <th>Month</th>
                        <th>Year</th>
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

                <div class="panel-footer">

                    <div class="row">

                        <div class="col-sm-6">
                            <a href="{{url()->previous()}}" class="btn btn-danger">{{ trans('crud.cancel') }}</a>
                        </div>

                        <div class="col-sm-6 text-right">
                            <button type="submit" class="btn btn-success">{{ trans('crud.save') }}</button>
                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>
</div>
@stop