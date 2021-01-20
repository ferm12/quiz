@extends('layouts.admin')

@section('page-header')
    <h1>
        {{ trans('customer.label_change_password') }}
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('common.label_home') }} </a></li>
        <li class="active">{{ trans('customer.label_change_password') }}</li>
    </ol>
@endsection

@section('content')
<div class="content container-fluid">
    <div class="row">

        <p>&nbsp;</p>
        
        @if (isset($successMsg))
            <div class="alert alert-success" role="alert">{{ $successMsg }}</div>
            <p>&nbsp;</p>
        @endif

        @if (isset($errorMsg))
            <div class="alert alert-danger" role="alert">{{ $errorMsg }}</div>
            <p>&nbsp;</p>
        @endif

        <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/password/change') }}">
              
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                <label for="old_password" class="col-md-4 control-label"><span style="color: red;">*</span>{{ trans('customer.label_password') }}</label>

                <div class="col-md-6">
                    <input id="old_password" type="password" class="form-control" name="old_password" style="width: 65%;" value="{{ old('old_password') }}" placeholder="">

                    @if ($errors->has('old_password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('old_password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label"><span style="color: red;">*</span>{{ trans('customer.label_password_new') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" style="width: 65%;" value="{{ old('password') }}" placeholder="">

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label for="password_confirmation" class="col-md-4 control-label"><span style="color: red;">*</span>{{ trans('customer.label_password_new_confirmation') }}</label>

                <div class="col-md-6">
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" style="width: 65%;" value="{{ old('password_confirmation') }}" placeholder="">

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
            </div>            

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-default btn-sm" style="margin-right: 10px;">{{ strtoupper(trans('common.btn_save')) }}</button>
                    <button type="button" class="btn btn-default btn-sm" onclick="javascript: cancelFunc();">{{ strtoupper(trans('common.btn_cancel')) }}</button>
                </div>
            </div>
        </form>

        <p>&nbsp;</p>
    </div>  

    <script type="text/javascript">

        function cancelFunc() {
            window.location.href = "{{ url('admin') }}";            
        }

    </script>    
</div>
@endsection
