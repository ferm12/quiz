@extends('layouts.app')

@section('top-nav')

    @include('layouts.templates.top-nav')

@endsection

@section('content')
<div class="content container">
    <div class="row justify-content-center">
        <!-- <div class="col&#45;md&#45;8"> -->
        <div>
            <div class="card">
                <div class="card-header"><h3>Verify Your Email Address</h3></div>

                <div class="card-body">
                    <h4>Thank you, for your submission.</h4><br/>
                    <h4>Before proceeding, please check your email at {{$data['email']}} for a verification link.</h4>

                    <h4>{{ __('If you did not receive the email') }}, <a href="{{ url('/email/resend') . "/". $data['user_id'] }}">{{ __('click here to request another') }}</a>.</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
