@extends('layouts.' . config('laravel-cm.layout_file'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3>Campaigns</h3>
                            </div>
                            <div class="col-sm-6">
                                <a href="{{ route('laravel-cm::campaigns.create') }}"
                                    class="btn btn-success text-white btn-sm float-right">
                                    @lang('laravel-cm::campaigns.create_button')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @include('laravel-cm::notifications')
                <div class="card mt-4">
                    <div class="card-header">
                        <h3>@lang('laravel-cm::campaigns.drafts')</h3>
                    </div>
                    <div class="card-body">
                        @if ($drafts->isEmpty())
                            @lang('laravel-cm::crud.no_entries')
                        @else
                            <table class="table">
                                <thead>
                                    <th>Name</th>
                                    <th>ID</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($drafts as $campaign)
                                        <tr>
                                            <td>{{ $campaign->Name }}</td>
                                            <td>{{ $campaign->CampaignID }}</td>
                                            <td class="text-right">
                                                <div class="btn-group">
                                                    <a class="btn btn-sm btn-success" accesskey=""
                                                        href="{{ route('laravel-cm::campaigns.show', $campaign->CampaignID) }}"><i
                                                            class="glyphicon glyphicon-eye-open"></i> @lang('laravel-cm::campaigns.summary')</a>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            @lang('laravel-cm::campaigns.send') <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a
                                                                    href="{{ route('laravel-cm::campaigns.show-preview', $campaign->CampaignID) }}">@lang('laravel-cm::campaigns.send_preview')</a>
                                                            </li>
                                                            <li><a
                                                                    href="{{ route('laravel-cm::campaigns.show-send', $campaign->CampaignID) }}">@lang('laravel-cm::campaigns.schedule')</a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    {{-- <a class="btn btn-sm btn-success" 
                                           accesskey="" href="{{route('laravel-cm::campaigns.edit',$campaign->CampaignID)}}">@lang('laravel-cm::crud.edit')</a> --}}
                                                    <form class="btn-group"
                                                        action="{{ route('laravel-cm::campaigns.destroy', $campaign->CampaignID) }}"
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
                        <campaign-send-test ref="sendTestCampaign" csrf-token="{{ csrf_token() }}"></campaign-send-test>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h3>@lang('laravel-cm::campaigns.scheduled')</h3>
                    </div>
                    <div class="card-body">

                        @if ($scheduled->isEmpty())
                            @lang('laravel-cm::crud.no_entries')
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <th>Name</th>
                                    <th>ID</th>
                                    <th>@lang('laravel-cm::campaigns.scheduled_time')</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($scheduled as $campaign)
                                        <tr>
                                            <td>{{ $campaign->Name }}</td>
                                            <td>{{ $campaign->CampaignID }}</td>
                                            <td>{{ $campaign->DateScheduled }}</td>
                                            <td class="text-right">
                                                <div class="btn-group">
                                                    <a class="btn btn-sm btn-default"
                                                        accesskey=""href="{{ route('laravel-cm::campaigns.show', $campaign->CampaignID) }}">@lang('laravel-cm::campaigns.details')</a>
                                                    <a class="btn btn-sm btn-danger"
                                                        href="{{ route('laravel-cm::campaigns.unschedule', $campaign->CampaignID) }}">@lang('laravel-cm::campaigns.unschedule')</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h3>@lang('laravel-cm::campaigns.sent')</h3>
                    </div>
                    <div class="card-body">

                        @if ($sent->isEmpty())
                            @lang('laravel-cm::crud.no_entries')
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <th>Name</th>
                                    <th>ID</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($sent as $campaign)
                                        <tr>
                                            <td>{{ $campaign->Name }}</td>
                                            <td>{{ $campaign->CampaignID }}</td>
                                            <td class="text-right">
                                                <a class="btn btn-sm btn-primary"
                                                    href="{{ route('laravel-cm::campaigns.show', $campaign->CampaignID) }}">@lang('laravel-cm::campaigns.details')</a>
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
