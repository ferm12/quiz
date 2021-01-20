@extends('layouts.app')

@section('top-nav')

    @include('layouts.templates.top-nav')

@endsection

@section('menu')

    @include('layouts.templates.menu-basic')

    <script type="text/javascript">

        var headMenuItemIndex = 1;

    </script>
@endsection

@section('content')
<div class="content container">

    @if (session('successMsg'))
        <div class="alert alert-success" role="alert" style="width: 100%;">{{ session('successMsg') }}</div>
    @endif

    @if (session('soracoMsg'))
        <div class="alert alert-success" role="alert" style="width: 100%;">{{ session('soracoMsg') }}</div>
    @endif

    <div class="row">
        <div style="margin-left: 20px; margin-top: 20px;">

            <!-- <p class="p&#45;title&#45;small&#45;blue">{{ strtoupper(trans('account_summary.title')) }}</p>  -->
            <h1>{{ strtoupper(trans('account_summary.title')) }}</h1>
            <div>
                <div style="width: 80%;">                
                    <div class="form-group">
                        <div class="font-weight-bold">Full Name</div>
                        <div id="full-name">
                             {{ $customer['first_name'] . ' ' . $customer['last_name'] }}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="font-weight-bold">{{ trans('customer.label_email') }}</div>
                        <div id="email">
                            {{ $customer['email'] }}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="font-weight-bold">License Key</div>
                        <div class="" id="license-key">
                            {{ $customer['license_key'] }}
                        </div>
                    </div>
                    <div class="form-group">
                        <a href="{{ url('user/account')}}" class="btn btn-default">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .row -->


    <script type="text/javascript">

        function resetFunc() {
            window.location.href = "{{ url('user/account') }}";            
        }

    </script>
</div>
@endsection
