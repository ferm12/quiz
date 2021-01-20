@extends('layouts.admin')

@section('page-header')
	<h1>
		{{ trans('admin.title_create_admin_rule') }}
		<small></small>
	</h1>
	<ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('common.label_home') }} </a></li>
		<li><a href="{{ url('admin/permissions') }}"> {{ trans('admin.title_permissions') }} </a></li>
		<li class="active">{{ trans('admin.title_create_admin_rule') }}</li>
	</ol>
@endsection

@section('content')
<div class="content container-fluid">
    <div class="row">

        @if (isset($successMsg))
            <div class="alert alert-success" role="alert">{{ $successMsg }}</div>
        @endif

        @if (isset($errorMsg))
            <div class="alert alert-danger" role="alert">{{ $errorMsg }}</div>
        @endif

        <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/permissions/create') }}">

            {{ csrf_field() }}

            <div class="container" style="margin-left: 30px;">
                <div class="row">
                    <p class="p-title-small-blue">&nbsp;</p> 
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div style="width: 80%;">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name"><span class="span-required-red">*</span>{{ trans('admin.label_rule_name') }}</label>
                                <input id="name" type="text" style="width: 100%;" name="name" value="{{ old('name') }}" >

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>{{ trans('admin.label_privileges') }}</label>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <input type="checkbox" id="check_all">
                                        <label>{{ trans('common.label_all') }}</label>
                                    </div>
                                    <ul class="list-group" id="check_group">
                                        <li class="list-group-item">
                                            <input type="checkbox" id="customer_priv" name="customer_priv" value="1" 
                                            @if (old('customer_priv'))
                                                checked
                                            @endif
                                            >
                                            <label>{{ trans('admin.label_customer_priv') }}</label>
                                        </li>
                                        <li class="list-group-item">
                                            <input type="checkbox" id="customer_report_priv" name="customer_report_priv" value="1"
                                            @if (old('customer_report_priv'))
                                                checked
                                            @endif
                                            >
                                            <label>{{ trans('admin.label_customer_report_priv') }}</label>
                                        </li>
                                        <li class="list-group-item">
                                            <input type="checkbox" id="deal_priv" name="deal_priv" value="1" 
                                            @if (old('deal_priv'))
                                                checked
                                            @endif
                                            >
                                            <label>{{ trans('admin.label_deal_priv') }}</label>
                                        </li>                                        
                                        <li class="list-group-item">
                                            <input type="checkbox" id="deal_report_priv" name="deal_report_priv" value="1"
                                            @if (old('deal_report_priv'))
                                                checked
                                            @endif
                                            >
                                            <label>{{ trans('admin.label_deal_report_priv') }}</label>
                                        </li>
                                        <li class="list-group-item">
                                            <input type="checkbox" id="user_permission_priv" name="user_permission_priv" value="1" 
                                            @if (old('user_permission_priv'))
                                                checked
                                            @endif
                                            >
                                            <label>{{ trans('admin.label_user_permission_priv') }}</label>
                                        </li>
                                        <li class="list-group-item">
                                            <input type="checkbox" id="config_priv" name="config_priv" value="1" 
                                            @if (old('config_priv'))
                                                checked
                                            @endif
                                            >
                                            <label>{{ trans('admin.label_config_priv') }}</label>
                                        </li>                                                                                  
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                    </div>
                </div>

                <div class="row" style="margin-top: 10px;">
                     <div class="col-xs-12 col-sm-4 col-md-4">
                        <div style="width: 80%;">
                            <div class="form-group">
                                <label><span class="span-required-red">*{{ trans('customer.label_required_fields') }}</span></label><br>
                                <button type="submit" class="btn btn-default">
                                    {{ strtoupper(trans('common.btn_save')) }}
                                </button>
                                <button type="button" class="btn btn-default" onClick="javascript: cancelFunc();" style="margin-left: 10px;">
                                    {{ strtoupper(trans('common.btn_cancel')) }}
                                </button>
                            </div>

                        </div>
                    </div>
                </div>              
            </div>

        </form>

    </div>  

    <script type="text/javascript">

        $(document).ready(function(){

            $('#left_menu_item_6').attr('class', 'active');

            $('#check_all').click(function() {
                $('#check_group input[type="checkbox"]').prop('checked', this.checked);
            });      
            
        });

        function cancelFunc() {
            window.location.href = "{{ url('admin/permissions') }}";            
        }

    </script>    
</div>
@endsection
