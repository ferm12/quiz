@extends('layouts.app-simple')

@section('content')
<div class="content container-fluid">

    @if (isset($successMsg))
        <div class="alert alert-success" role="alert" style="width: 100%;">{{ $successMsg }}</div>
    @endif
    @if (isset($errorMsg))
        <div class="alert alert-danger" role="alert" style="width: 100%;">{{ $errorMsg }}</div>       
    @endif 

    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary" style="margin: 10px;">
                <div class="panel-heading" style="height: 50px;">
                    <p class="p-title-medium-white">{{ trans('customer.label_admin_login') }}</p>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/login') }}">

                        {{ csrf_field() }}

                        <p>&nbsp;</p>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label"><span class="span-required-red">*</span>{{ trans('customer.label_email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label"><span class="span-required-red">*</span>{{ trans('customer.label_password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                            <label for="captcha" class="col-md-4 control-label"><span class="span-required-red">*</span>{{ trans('customer.label_captcha') }}</label>

                            <div class="col-md-6">
                                <input type="text" id="captcha" name="captcha" class="form-control" placeholder="{{ trans('customer.label_captcha_notice') }}">

                                <img src="{{ url('admin/captcha/create') }}"
                                     onclick="this.src='{{ url('admin/captcha/create') }}?r='+Math.random();" 
                                     alt="" title="{{ trans('customer.label_captcha_tips') }}" class="img-captcha-small">

                                <p style="margin-top: 3px;">{{ trans('customer.label_captcha_tips') }}</p>

                                @if ($errors->has('captcha'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('captcha') }}</strong>
                                    </span>
                                @endif
               
                            </div>
                        </div>

<!--
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div> -->

                        <div class="form-group">
                             <div class="col-md-6 col-md-offset-4">
                                <label><span class="span-required-red">*{{ trans('customer.label_required_fields') }}</span></label><br>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> {{ strtoupper(trans('customer.btn_login')) }}
                                </button>

                                <a class="btn btn-link" href="{{ url('admin/password/reset') }}">Forgot Your Password?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <p>&nbsp;</p>
</div>
@endsection
