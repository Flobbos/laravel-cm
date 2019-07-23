@extends('layouts.'.config('laravel-cm.layout_file'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">

                <form action="{{ route('laravel-cm::subscribers.import') }}" role="form" method="POST"  enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="card-header">
                        <h3>@lang('laravel-cm::subscribers.import_title')</h3>
                    </div>

                    <div class="card-body">
                        
                        @include('laravel-cm::notifications')
                        
                        <div class="form-group">
                            <label class="control-label" for="excel">@lang('laravel-cm::subscribers.excel_file')</label>
                            <input type="file" name="excel" />
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="listID">@lang('laravel-cm::subscribers.list_for_import')</label>
                            <select name="listID" class="form-control">
                                @foreach($lists as $list)
                                <option value="{{$list->ListID}}">{{$list->Name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="card-footer">

                        <div class="row">

                            <div class="col-sm-6">
                                <a href="{{ route('laravel-cm::subscribers.index') }}" class="btn btn-danger">{{ trans('laravel-cm::crud.cancel') }}</a>
                            </div>

                            <div class="col-sm-6 text-right">
                                <button type="submit" class="btn btn-success">{{ trans('laravel-cm::crud.save') }}</button>
                            </div>

                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
@stop