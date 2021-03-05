@extends('layouts.'.config('laravel-cm.layout_file'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">

                <form action="{{ route('laravel-cm::lists.update',$list->ListID) }}" role="form" method="POST"  enctype="multipart/form-data">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    <div class="card-header">
                        <h3>@lang('laravel-cm::lists.edit_headline')</h3>
                        @lang('laravel-cm::crud.edit_headline')
                    </div>

                    <div class="card-body">
                        
                        @include('laravel-cm::notifications')
                        
                        <div class="form-group">
                            <label class="control-label" for="Title">@lang('laravel-cm::lists.title')</label>
                            <input class="form-control" type="text" name="Title" value="{{old('Title', $list->Title)}}" />
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="UnsubscribePage">@lang('laravel-cm::lists.unsubscribe_page')</label>
                            <input class="form-control" type="text" name="UnsubscribePage" value="{{old('UnsubscribePage',$list->UnsubscribePage)}}" />
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="ConfirmationSuccessPage">@lang('laravel-cm::lists.success_page')</label>
                            <input class="form-control" type="text" name="ConfirmationSuccessPage" value="{{old('ConfirmationSuccessPage',$list->ConfirmationSuccessPage)}}" />
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="ConfirmedOptIn">@lang('laravel-cm::lists.double_opt_in')</label>
                            <select name="ConfirmedOptIn" class="form-control">
                                <option value="true" @if($list->ConfirmedOptIn) selected @endif>@lang('laravel-cm::crud.yes')</option>
                                <option value="false" @if(!$list->ConfirmedOptIn) selected @endif>@lang('laravel-cm::crud.no')</option>
                            </select>
                        </div>
                        
                    </div>

                    <div class="card-footer">

                        <div class="row">

                            <div class="col-sm-6">
                                <a href="{{ route('laravel-cm::lists.index') }}" class="btn btn-danger">@lang('laravel-cm::crud.cancel')</a>
                            </div>

                            <div class="col-sm-6 text-right">
                                <button type="submit" class="btn btn-success">@lang('laravel-cm::crud.save')</button>
                            </div>

                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
@stop