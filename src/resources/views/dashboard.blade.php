@extends('layouts.'.config('laravel-cm.layout_file'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">

                <div class="panel-heading panel-default">
                    <h3 class="panel-title">Current Settings:</h4>
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