@extends('layouts.app')

@section('top-nav')

    @include('layouts.templates.top-nav')

@endsection

@section('menu')

    @include('layouts.templates.menu-basic')

@endsection

@section('content')
<div class="content container">

    <div class="row">

        @if (isset($successMsg))
            <div class="alert alert-success" role="alert">{{ $successMsg }}</div>
        @endif
        @if (isset($errorMsg))
            <div class="alert alert-danger" role="alert" style="width: 100%;">{{ $errorMsg }}</div>
        @endif       
    </div>

    <p>&nbsp;</p>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" style="margin: 10px;">
                <div class="panel-heading" style="height: 50px;">
                    <p class="p-title-medium">{{ trans('customer.label_change_password') }}</p>
                </div>
                <div class="panel-body">

                    <p>&nbsp;</p>

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('user/password/change') }}">

                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                            <label for="old_password" class="col-md-4 control-label"><span class="span-required-red">*</span>{{ trans('customer.label_password') }}</label>

                            <div class="col-md-6">
                                <input id="old_password" type="password" class="form-control" name="old_password" value="{{ old('old_password') }}">

                                @if ($errors->has('old_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('old_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label"><span class="span-required-red">*</span>{{ trans('customer.label_password_new') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password_confirmation" class="col-md-4 control-label"><span class="span-required-red">*</span>{{ trans('customer.label_password_new_confirmation') }}</label>

                            <div class="col-md-6">
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                                               
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-default" style="margin-right: 10px;">{{ strtoupper(trans('common.btn_save')) }}</button>

                                <a href="{{ url('user/accountsummary')}}" class="btn btn-default" style="margin-left:10px;">Cancel</a>
                            </div>
                        </div>

                        <p>&nbsp;</p>
                    </form>
                </div>
            </div>
        </div>
    </div> 
    
    <p>&nbsp;</p>

</div>
@endsection
