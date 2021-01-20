@extends('layouts.app-simple')

@section('top-nav')

    @include('layouts.templates.top-nav-error')

@endsection

@section('content')
<div class="content container">
    <div class="content" style="min-height: 420px;">
        <h3>{{ trans('common.error.503') }}</h3>
    </div>
</div>
@endsection
