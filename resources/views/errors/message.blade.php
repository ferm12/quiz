@extends('layouts.app-simple')

@section('top-nav')

    @include('layouts.templates.top-nav-error')

@endsection

@section('content')
<div class="content container">
    <div class="content" style="min-height: 420px;">

	    @if (isset($message))
	        <h3>{{ $message }}</h3>
	    @endif

    </div>
</div>
@endsection