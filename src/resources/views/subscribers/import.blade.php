@extends('layouts.'.config('laravel-cm.layout_file'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">

                <form action="{{ route('laravel-cm::subscribers.import') }}" role="form" method="POST"  enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="panel-heading panel-default">
                        @lang('crud.create_headline')
                    </div>

                    <div class="panel-body">
                        
                        @include('admin.notifications')
                        
                        <div class="form-group">
                            <label class="control-label" for="excel">Excel-Tabelle</label>
                            <input type="file" name="excel" />
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="listID">Liste</label>
                            <select name="listID" class="form-control">
                                @foreach($lists as $list)
                                <option value="{{$list->ListID}}">{{$list->Name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="panel-footer">

                        <div class="row">

                            <div class="col-sm-6">
                                <a href="{{ route('laravel-cm::subscribers.index') }}" class="btn btn-danger">{{ trans('crud.cancel') }}</a>
                            </div>

                            <div class="col-sm-6 text-right">
                                <button type="submit" class="btn btn-success">{{ trans('crud.save') }}</button>
                            </div>

                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
@stop