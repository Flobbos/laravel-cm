@extends('layouts.'.config('laravel-cm.layout_file'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">

                <form action="{{ route('laravel-cm::campaigns.store') }}" role="form" method="POST"  enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="panel-heading panel-default">
                        <h3 class="panel-title">Kampagne erstellen</h3>
                        @lang('crud.create_headline')
                    </div>

                    <div class="panel-body">

                        @include('laravel-cm::notifications')

                        <div class="form-group">
                            <label class="control-label" for="Name">Name</label>
                            <input class="form-control" placeholder="My awesome Campaign" type="text" name="Name" value="{{ old('Name') }}" />
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="Subject">Betreff</label>
                            <input class="form-control" placeholder="My awesome Subject" type="text" name="Subject" value="{{old('Subject')}}" />
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="FromName">Absendername</label>
                            <input class="form-control" placeholder="Mr Awesome" type="text" name="FromName" value="{{old('FromName')}}" />
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="FromEmail">Absenderadresse</label>
                            <input class="form-control" placeholder="mr@aweso.me" type="text" name="FromEmail" value="{{old('FromEmail')}}" />
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="ReplyTo">Antwortadresse</label>
                            <input class="form-control"placeholder="mrs@aweso.me" type="text" name="ReplyTo" value="{{old('ReplyTo')}}" />
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="HtmlUrl">HtmlUrl</label>
                            <input class="form-control" type="text" name="HtmlUrl" value="{{old('HtmlUrl', url('laravel-cm'))}}" />
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="ListID">Empfänger-Liste</label>
                            <select multiple name="ListIDs[]" class="form-control">
                                @foreach($lists as $list)
                                @if(in_array($list->ListID,old('ListIDs',[])))
                                <option value="{{$list->ListID}}" selected>{{$list->Name}}</option>
                                @else
                                <option value="{{$list->ListID}}">{{$list->Name}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="panel-footer">

                        <div class="row">

                            <div class="col-sm-6">
                                <a href="{{ route('laravel-cm::campaigns.index') }}" class="btn btn-danger">{{ trans('crud.cancel') }}</a>
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
