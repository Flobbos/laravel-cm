@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">

                <form action="{{ route('admin.newsletters.campaigns.update', ['campaign_id' => $campaign->CampaignID]) }}" role="form" method="POST"  enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="panel-heading panel-default">
                        <h3 class="panel-title">Kampagne bearbeiten</h3>
                        @lang('crud.create_headline')
                    </div>

                    <div class="panel-body">

                        @include('admin.notifications')

                        <div class="form-group">
                            <label class="control-label" for="Name">Name</label>
                            <input class="form-control" type="text" name="Name" value="{{old('Name',$campaign->Name)}}" />
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="Subject">Betreff</label>
                            <input class="form-control" type="text" name="Subject" value="{{old('Subject', $campaign->Subject)}}" />
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="FromName">Absendername</label>
                            <input class="form-control" type="text" name="FromName" value="{{old('FromName',$campaign->FromName)}}" />
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="FromEmail">Absenderadresse</label>
                            <input class="form-control" type="text" name="FromEmail" value="{{old('FromEmail', $campaign->FromEmail)}}" />
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="ReplyTo">Antwortadresse</label>
                            <input class="form-control" type="text" name="ReplyTo" value="{{old('ReplyTo', $campaign->ReplyTo)}}" />
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="HtmlUrl">HtmlUrl (optional, für Template-Updates)</label>
                            <input type="hidden" name="HtmlUrl" value="{{ $campaign->PreviewURL }}">
                            <input class="form-control" placeholder="{{ url('laravel-cm') }}" type="text" value="{{old('HtmlUrl')}}" @input="setHtmlUrl"/>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="ListID">Empfänger-Liste</label>
                            <vue-select :options="{{ $lists->toJson() }}" :selected-lists="{{ json_encode($campaign->ListIDs) }}"></vue-select>
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
