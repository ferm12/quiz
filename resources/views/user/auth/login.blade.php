@extends('layouts.app')

@section('top-nav')

    @include('layouts.templates.top-nav')

@endsection

@section('content')
<div class="content container">
    <div class="row">
        <div style="margin-left: 15px;">
            <p class="p-title-big">{{ strtoupper(trans('customer.label_partner_login')) }}</p>

            @if (isset($successMsg))
                <div class="alert alert-success" role="alert" style="width: 100%;">{{ $successMsg }}</div>
            @endif
            @if (isset($errorMsg))
                <div class="alert alert-danger" role="alert" style="width: 100%;">{{ $errorMsg }}</div>
            @endif
        </div>        
    </div>

    <div class="row">
        <div style="margin-left: 15px;">
            <div class="col-xs-12 col-md-6">

                <div id="div_login_banner"></div>
                <div id="div_login_banner_description">{{ trans('customer.label_banner_description') }}</div>

                <p>&nbsp;</p>

                <p>
                    <label id="label_login_not_yet">{{ trans('customer.label_not_yet') }}</label>
                    <button class="btn btn-default" onClick="javascript: registerFunc();">
                        {{ strtoupper(trans('customer.btn_become_partner')) }}
                    </button>
                </p>            
            </div>
            <div class="col-xs-12 col-md-6">

                <h4>{{ trans('customer.label_registered_partners') }}</h4>
                <p>{{ trans('customer.label_registered_description') }}</p>

                <form class="form-horizontal" role="form" method="POST" action="{{ url('user/login') }}">
                    
                    {{ csrf_field() }}

                    @if (isset($return_url))
                        <input type="hidden" name="return_url" value="{{ $return_url }}">
                    @endif

                    <div style="width: 70%; margin-left: 12px;">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email"><span class="span-required-red">*</span>{{ trans('customer.label_email') }}</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password"><span class="span-required-red">*</span>{{ trans('customer.label_password') }}</label>
                            <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                           <label for="captcha"><span class="span-required-red">*</span>{{ trans('customer.label_captcha') }}</label>
                            <input type="text" id="captcha" name="captcha" class="form-control" placeholder="{{ trans('customer.label_captcha_notice') }}">

                            <img src="{{ url('user/captcha/create') }}"
                                 onclick="this.src='{{ url('user/captcha/create') }}?r='+Math.random();" 
                                 alt="" title="{{ trans('customer.label_captcha_tips') }}" class="img-captcha-small">

                            <p style="margin-top: 3px;">{{ trans('customer.label_captcha_tips') }}</p>

                            @if ($errors->has('captcha'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('captcha') }}</strong>
                                </span>
                            @endif
                        </div>

    <!--
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> {{ trans('customer.label_remember_me') }}
                                </label>
                            </div>
                        </div>
                        -->

                        <div class="form-group">
                            <label><span class="span-required-red">*{{ trans('customer.label_required_fields') }}</span></label><br>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-sign-in"></i> {{ strtoupper(trans('customer.btn_login')) }}
                            </button>
                            <a class="btn btn-link" href="{{ url('user/password/reset') }}">{{ trans('customer.btn_forgot_password') }}</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        $(document).ready(function(){
            $("#div_login_banner").css("background-image", "url(\'{{ asset('images/partner_login_left_background.jpg') }}\')");
        });     

        function registerFunc() {
            window.location.href = "{{ url('user/register') }}";            
        }

    </script>

</div>
@endsection
