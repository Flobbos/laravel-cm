@extends('layouts.'.config('laravel-cm.layout_file'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <form action="{{ route('laravel-cm::campaigns.send-preview', $campaign_id) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3 class="panel-title">Send Campaign Test</h3>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @include('laravel-cm::notifications')

                        <div class="row">

                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="emails">Enter up to {{ config('laravel-cm.max_test_emails') }} addresses at once, separated by a comma.</label>
                                    <input type="text" id="emails" class="form-control" name="emails">
                                    <p class="help-block">
                                        For test emails, personalization tags are replaced with the fallback terms you supplied.
                                    </p>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="panel-footer">

                        <div class="row">

                            <div class="col-sm-6">
                                <a href="{{ route('laravel-cm::campaigns.index') }}" class="btn btn-danger">@lang('laravel-cm::crud.cancel')</a>
                            </div>

                            <div class="col-sm-6 text-right">
                                <button type="submit" class="btn btn-success">@lang('laravel-cm::crud.send-test')</button>
                            </div>

                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection
