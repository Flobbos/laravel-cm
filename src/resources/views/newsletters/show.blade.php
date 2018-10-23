@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">

                <div class="panel-heading panel-default">
                    <h3 class="panel-title">Details Empfänger</h3>
                </div>

                <div class="panel-body">

                    <div class="row">
                        <div class="col-sm-6">
                            E-Mail-Adresse:
                        </div>
                        <div class="col-sm-6">
                            {{$subscriber->EmailAddress}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            Name:
                        </div>
                        <div class="col-sm-6">
                            {{$subscriber->Name}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            Angemeldet:
                        </div>
                        <div class="col-sm-6">
                            {{$subscriber->Date}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            Status:
                        </div>
                        <div class="col-sm-6">
                            {{$subscriber->State}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            E-Mail-Reader:
                        </div>
                        <div class="col-sm-6">
                            {{$subscriber->ReadsEmailWith}}
                        </div>
                    </div>
                    
                </div>

                <div class="panel-footer">

                    <div class="row">

                        <div class="col-sm-6">
                            <a href="{{url()->previous()}}" class="btn btn-danger">{{ trans('crud.cancel') }}</a>
                        </div>

                        <div class="col-sm-6 text-right">
                            <button type="submit" class="btn btn-success">{{ trans('crud.save') }}</button>
                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>
</div>
@stop