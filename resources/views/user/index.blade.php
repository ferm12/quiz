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
            <div class="alert alert-success" role="alert" style="width: 100%;">{{ $successMsg }}</div>
            <p>&nbsp;</p>
        @endif

        @if (isset($errorMsg))
            <div class="alert alert-danger" role="alert" style="width: 100%;">{{ $errorMsg }}</div>
            <p>&nbsp;</p>
        @endif

        <p>&nbsp;</p>
        <p>Home Page</p>
        <div style="width: 100%; height: 380px;" id="partner_portal_banner" > </div>

    </div>
</div>
@endsection
