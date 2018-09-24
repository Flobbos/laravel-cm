@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">

                <form action="{{ route('admin.newsletters.store') }}" role="form" method="POST"  enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="panel-heading panel-default">
                        <h3 class="panel-title">List erstellen</h3>
                        @lang('crud.create_headline')
                    </div>

                    <div class="panel-body">
                        
                        @include('admin.notifications')
                        
                        <div class="form-group">
                            <label class="control-label" for="Title">Titel</label>
                            <input class="form-control" type="text" name="Title" value="{{old('Title')}}" />
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="UnsubscribePage">Seite zum Abmelden</label>
                            <input class="form-control" type="text" name="UnsubscribePage" value="{{old('UnsubscribePage')}}" />
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="ConfirmationSuccessPage">Seite nach Bestätigung</label>
                            <input class="form-control" type="text" name="ConfirmationSuccessPage" value="{{old('ConfirmationSuccessPage')}}" />
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="ConfirmedOptIn">Double Opt-In?</label>
                            <select name="ConfirmedOptIn" class="form-control">
                                <option value="true">Ja</option>
                                <option value="false">Nein</option>
                            </select>
                        </div>
                        
                    </div>

                    <div class="panel-footer">

                        <div class="row">

                            <div class="col-sm-6">
                                <a href="{{ route('admin.newsletters.index') }}" class="btn btn-danger">{{ trans('crud.cancel') }}</a>
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