@extends('layouts.'.config('laravel-cm.layout_file'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('laravel-cm::campaigns.send-preview', $campaign_id) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3>@lang('laravel-cm::campaigns.send_test_title')</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('laravel-cm::notifications')

                        <div class="row">

                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="emails">@lang('laravel-cm::campaigns.send_test_emails',['max_email'=>config('laravel-cm.max_test_emails')])</label>
                                    <input type="text" id="emails" class="form-control" name="emails">
                                    <p class="help-block">
                                        @lang('laravel-cm::campaigns.send_test_hint')
                                    </p>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="card-footer">

                        <div class="row">

                            <div class="col-sm-6">
                                <a href="{{ route('laravel-cm::campaigns.index') }}" class="btn btn-danger">@lang('laravel-cm::crud.cancel')</a>
                            </div>

                            <div class="col-sm-6 text-right">
                                <button type="submit" class="btn btn-success">@lang('laravel-cm::campaigns.send-test')</button>
                            </div>

                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection
