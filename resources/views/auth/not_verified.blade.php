@extends('layouts.app')

@section('top-nav')

   @include('layouts.templates.top-nav') 

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h3>{{ __('Verify Your Email Address') }}</h3></div>

                <div class="card-body">
                        <div class="alert alert-danger" role="alert">

                            </h4>{{ __('Email has NOT been verified.')  }}</h4>
                        </div>

                    <h4>{{ __('Before proceeding, please check your email for a verification link.') }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
