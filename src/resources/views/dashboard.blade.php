@extends('layouts.'.config('laravel-cm.layout_file'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">

                <div class="panel-heading panel-default">
                    @lang('crud.create_headline')
                </div>

                <div class="panel-body">
                    <h4>Current Settings:</h4>
                    @foreach(config('laravel-cm') as $key => $config)
                    {{ucfirst($key)}}: {{$config}}<br />
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