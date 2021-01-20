@extends('layouts.app')

@section('top-nav')

    @include('layouts.templates.top-nav')

@endsection

@section('content')

<div class="content container">
        <div class="login-wrapper">
            <!-- <p class="p&#45;title&#45;big">{{ strtoupper(trans('customer.label_partner_login')) }}</p> -->
            <h1>
                Welcome to the Quiz
            </h1>
            <p>&nbsp;</p>
            <h4>
                To retrieve your License Key, please login or create an account.
            </h4>
        </div><!-- .login-wrapper -->


        <div id="sign-on-container">
            @if (session('customer_verified_msg'))
                <div class="alert alert-success" role="alert" style="width: 100%;">{{ session('customer_verified_msg') }}</div>
            @endif

            @if (isset($successMsg))
                <div class="alert alert-success" role="alert" style="width: 100%;">{{ $successMsg }}</div>
            @endif
            @if (isset($errorMsg))
                <div class="alert alert-danger" role="alert" style="width: 100%;">{{ $errorMsg }}</div>
            @endif

            <div class="signon-page">
                <div class="signon-block">

                    <div class="sign-on-login-heading">
                        <div class="sign-on-login-text">
                            <h3 class="page-heading">Login</h3>
                        </div>
                    </div>

                    <div class="form-group">

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('user/api/login') }}">

                            {{ csrf_field() }}

                            <label id="required-label"><span class="span-required-red">*{{ trans('customer.label_required_fields') }}</span></label><br>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email"><span class="span-required-red">* </span>{{ trans('customer.label_email') }}</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password"><span class="span-required-red">* </span>{{ trans('customer.label_password') }}</label>
                                <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <br/><br/>

                            <div class="form-group button-form">
                                <button type="submit" class="button"><i class="fa fa-btn fa-sign-in"></i> LOGIN</button>
                            </div>
                        </form>
                    </div>
                    <div class="form-group text-center">
                        <div>
                            <div>
                                <a href="{{ url('user/password/reset') }}" title="Forgot password?">{{ trans('customer.btn_forgot_password') }}</a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="separator"></div>
                <div class="register-block">
                    <h3 class="page-heading">Register</h3>
                    <div class="icon">
                        <div class="icon-row1">
                            <i class="fa fa-user"></i>
                        </div>
                    </div>
                    <div class="button-link-container">
                        <a class="button" href="{{ url('user/register') }}">CREATE AN ACCOUNT</a>
                    </div>
                </div>
            </div>
        </div> <!-- sing-on-container -->

</div>
@endsection
