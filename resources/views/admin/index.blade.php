@extends('layouts.admin')

@section('page-header')
    <h1>
        {{ trans('common.label_dashboard') }}
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('common.label_home') }} </a></li>
    </ol>
@endsection

@section('content')
<div class="content container-fluid">
    <div class="row">

        <p>&nbsp;</p>
        <p>&nbsp;</p>
        
    </div>
</div>
@endsection
