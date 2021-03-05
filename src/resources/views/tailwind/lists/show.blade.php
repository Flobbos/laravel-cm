@extends('layouts.'.config('laravel-cm.layout_file'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">

                <div class="card-header">
                    <h3>@lang('laravel-cm::lists.details_for',['title'=>$list->Title])</h3>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-6">
                            List ID:
                        </div>
                        <div class="col-sm-6">
                            {{$list->ListID}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            @lang('laravel-cm::lists.title'):
                        </div>
                        <div class="col-sm-6">
                            {{$list->Title}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            @lang('laravel-cm::lists.unsubscribe_page'):
                        </div>
                        <div class="col-sm-6">
                            {{$list->UnsubscribePage}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            @lang('laravel-cm::lists.double_opt_in'):
                        </div>
                        <div class="col-sm-6">
                            @if($list->ConfirmedOptIn)
                            @lang('laravel-cm::crud.yes')
                            @else
                            @lang('laravel-cm::crud.no')
                            @endif
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            @lang('laravel-cm::lists.success_page')
                        </div>
                        <div class="col-sm-6">
                            {{$list->ConfirmationSuccessPage}}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            @lang('laravel-cm::lists.unsubscribe_settings'):
                        </div>
                        <div class="col-sm-6">
                            {{$list->UnsubscribeSetting}}
                        </div>
                    </div>
                    
                </div>

                <div class="card-footer">

                    <div class="row">

                        <div class="col-sm-6">
                            <a href="{{url()->previous()}}" class="btn btn-danger">@lang('laravel-cm::crud.cancel')</a>
                        </div>

                        
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>
@stop