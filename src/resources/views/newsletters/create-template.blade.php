@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">

                <form action="{{ route('admin.newsletters.store-template') }}" role="form" method="POST"  enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="panel-heading panel-default">
                        <h3 class="panel-title">List erstellen</h3>
                        @lang('crud.create_headline')
                    </div>

                    <div class="panel-body">
                        
                        @include('admin.notifications')
                        
                        <div class="form-group">
                            <label class="control-label" for="Name">Name</label>
                            <input class="form-control" type="text" name="Name" value="{{old('Name','TestCampaign')}}" />
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="Subject">Betreff</label>
                            <input class="form-control" type="text" name="Subject" value="{{old('Subject','Super awesome campaign')}}" />
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="FromName">Absendername</label>
                            <input class="form-control" type="text" name="FromName" value="{{old('FromName','Big Kahoona')}}" />
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="FromEmail">Absenderadresse</label>
                            <input class="form-control" type="text" name="FromEmail" value="{{old('FromEmail','big@kahoona.com')}}" />
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="ReplyTo">Antwortadresse</label>
                            <input class="form-control" type="text" name="ReplyTo" value="{{old('ReplyTo','nl@kahoona.com')}}" />
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="HtmlUrl">HtmlUrl</label>
                            <input class="form-control" type="text" name="HtmlUrl" value="{{old('HtmlUrl',url('storage/laravel-cm'))}}" />
                        </div>
                        
                        <input type="hidden" name="ListIDs[]" value="19739853070514151a1b374191a4fa18" />
                        
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