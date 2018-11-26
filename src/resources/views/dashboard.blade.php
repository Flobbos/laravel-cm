@extends('layouts.'.config('laravel-cm.layout_file'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">

                <div class="panel-heading panel-default">
                    <h3 class="panel-title">@lang('laravel-cm::dashboard.short_docs')</h3>
                </div>

                <div class="panel-body">
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
            
            <div class="panel panel-default">
                
                <div class="panel-heading panel-default">
                    <h3 class="panel-title">@lang('laravel-cm::dashboard.config')</h3>
                </div>
                
                <div class="panel-body">
                    @foreach(config('laravel-cm') as $key => $config)
                    {{ucfirst($key)}}: <strong>{{$config}}</strong><br />
                    @endforeach
                </div>
                
                <div class="panel-footer">

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