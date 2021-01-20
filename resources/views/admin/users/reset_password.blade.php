@extends('layouts.admin')

@section('page-header')
    <center>
        <h1>
        {{ trans('customer.label_change_password') }} 
        for {{ $customer['first_name'] . ' '. $customer['last_name'] }}
        </h1>
    </center>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('common.label_home') }} </a></li>
        <li class="active">{{ trans('customer.label_change_password') }}</li>
    </ol>
@endsection

@section('content')
<div class="content container-fluid">
    <div class="row">
@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
</div>
@endif  


        <p>&nbsp;</p>
        
        @if (isset($successMsg))
            <div class="alert alert-success" role="alert">{{ $successMsg }}</div>
            <p>&nbsp;</p>
        @endif

        @if (isset($errorMsg))
            <div class="alert alert-danger" role="alert">{{ $errorMsg }}</div>
            <p>&nbsp;</p>
        @endif

        <form class="form-horizontal" role="form" method="POST" action="<?php echo '/admin/customers/resetpassword/' . $customer['id'];  ?>">
              
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label"><span style="color: red;">*</span>{{ trans('customer.label_password_new') }}</label>

                <div class="col-md-6">
                    <input id="password" class="form-control" name="password" style="width: 65%;" value="" placeholder="">
                    <button type="button" class="btn btn-default btn-sm" onclick="javascript: generatePasswordFunc();">Generate Password</button>

                    <br/></br/>
                    <p class="p-title-small-blue">OPTIONS</p> 
                    <input id="sendemail" type="checkbox" name="sendemail"> Send new password to customer via email

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <br/>
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
        function generatePasswordFunc(){
            let pass = Math.random().toString(36).slice(-11);
            $('#password').val(pass);
            
        }
        
        function cancelFunc() {
            window.location.href = "{{ url()->previous() }}";            
        }

    </script>    
</div>
@endsection
