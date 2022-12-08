@extends('layouts.' . config('laravel-cm.layout_file'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header">
                        <h3>@lang('laravel-cm::dashboard.short_docs')</h3>
                        Bootstrap4
                    </div>

                    <div class="card-body">

                        @include('laravel-cm::notifications')

                        <h4>1. Templates</h4>
                        <p>
                            @lang('laravel-cm::dashboard.templates')
                        </p>

                        <h4>2. @lang('laravel-cm::dashboard.lists_title')</h4>
                        <p>
                            @lang('laravel-cm::dashboard.lists')
                        </p>

                        <h4>3. @lang('laravel-cm::dashboard.campaigns_title')</h4>
                        <p>
                            @lang('laravel-cm::dashboard.campaigns')
                        </p>

                        <h4>4. @lang('laravel-cm::dashboard.subscribers_title')</h4>
                        <p>
                            @lang('laravel-cm::dashboard.subscribers')
                        </p>

                    </div>
                </div>

                <div class="card mt-4">

                    <div class="card-header">
                        <h3>@lang('laravel-cm::dashboard.config')</h3>
                    </div>

                    <div class="card-body">
                        @foreach (config('laravel-cm') as $key => $config)
                            {{ ucfirst($key) }}:
                            @if (is_array($config))
                                <strong>{{ implode(',', $config) }}</strong><br />
                            @else
                                <strong>{{ $config }}</strong><br />
                            @endif
                        @endforeach
                    </div>

                    <div class="card-footer">

                        <div class="row">

                            <div class="col-sm-6">
                                <a href="https://github.com/Flobbos/laravel-cm" target="_blank">LaravelCM Documentation @github/Flobbos/laravel-cm</a>
                            </div>

                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
@stop
