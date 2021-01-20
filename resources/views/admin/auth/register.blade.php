@extends('layouts.app-simple')

@section('content')
<div class="content container-fluid">

    @if (isset($errorMsg))
        <div class="alert alert-danger" role="alert" style="width: 100%;">{{ $errorMsg }}</div>
    @else
        <p>&nbsp;</p>
    @endif 

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" style="margin: 10px;">
                <div class="panel-heading" style="height: 50px;">
                    <p class="p-title-medium">{{ trans('customer.label_admin_register') }}</p>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/register') }}">

                        {{ csrf_field() }}

                        <p>&nbsp;</p>

                        <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                            <label for="firstname" class="col-md-4 control-label"><span class="span-required-red">*</span>{{ trans('customer.label_firstname') }}</label>

                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname') }}">

                                @if ($errors->has('firstname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                            <label for="lastname" class="col-md-4 control-label"><span class="span-required-red">*</span>{{ trans('customer.label_lastname') }}</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}">

                                @if ($errors->has('lastname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

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

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password_confirmation" class="col-md-4 control-label"><span class="span-required-red">*</span>{{ trans('customer.label_password_confirmation') }}</label>

                            <div class="col-md-6">
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
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

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <label><span class="span-required-red">*{{ trans('customer.label_required_fields') }}</span></label><br>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-arrow-right"></i> {{ strtoupper(trans('customer.btn_register')) }}
                                </button>
                                <button type="button" class="btn btn-default" onClick="javascript: cancelFunc();" style="margin-left: 10px;">
                                    {{ strtoupper(trans('common.btn_cancel')) }}
                                </button>                            
                            </div>
                        </div>

                        <p>&nbsp;</p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        function cancelFunc() {
            window.location.href = "{{ url('admin/login') }}";            
        }

    </script>


</div>
@endsection
