<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>{{ trans('common.title_app') }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />

    <link rel="stylesheet" href="{{ asset('lib/bootstrap-3.3.7/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/jquery-ui-1.11.4/themes/ui-lightness/jquery-ui.min.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}} 

<!--
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    -->
      
    <script src="{{ asset('lib/jquery/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('lib/bootstrap-3.3.7/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('lib/jquery-ui-1.11.4/jquery-ui.min.js') }}"></script>

    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

</head>
<body id="app-layout">

    <nav class="navbar navbar-default" style="height: 60px;">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <span class="logo-lg" title="{{ trans('common.title_screenbeam') }}"><img src="{{ asset('images/logo_screenbeam_small_0830.png') }}" /></span>
                </a>
            </div>

        </div>
    </nav>
    
    @yield('content')

    <p>&nbsp;</p>

    @include('layouts.templates.footer-copyright')

</body>
</html>
