@extends('layouts.admin')

@section('page-header')
	<h1>
		{{ trans('admin.title_config') }}
		<small></small>
	</h1>
	<ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('common.label_home') }} </a></li>
		<li class="active">{{ trans('admin.title_config') }}</li>
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

        <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/config') }}">

            {{ csrf_field() }}

            <div class="container" style="margin-left: 30px;">
                <div class="row">
                    <p class="p-title-small-blue">{{ trans('admin.title_config_email') }}</p> 
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div style="width: 80%;">
                            <div class="form-group">
                                <label for="sender_name">{{ trans('admin.label_sender_name') }}</label>
                                <input id="sender_name" type="text" style="width: 100%;" name="sender_name" 

                                @if (isset($configs['sender_name']) && !empty($configs['sender_name']))
                                     value="{{ $configs['sender_name'] }}"
                                @endif

                                >
                            </div>
                            <div class="form-group">
                                <label for="sender_email">{{ trans('admin.label_sender_email') }}</label>
                                <input id="sender_email" type="text" style="width: 100%;" name="sender_email"
                                
                                @if (isset($configs['sender_email']) && !empty($configs['sender_email']))
                                     value="{{ $configs['sender_email'] }}"
                                @endif

                                >

                            </div>
                            <div class="form-group">
                                <label for="email_group_registration_notification">{{ trans('admin.label_email_group_reg_notification') }}</label>
                                <textarea id="email_group_registration_notification" style="width: 100%;" name="email_group_registration_notification" rows="5">{{ isset($configs['email_group_registration_notification']) ? $configs['email_group_registration_notification'] : "" }}</textarea>

                            </div>
                            <div class="form-group">
                                <label for="email_group_mac_id_request_notification">Mac ID Request Notification (multiple email address separated with comma)</label>
                                <textarea id="email_group_mac_id_request_notification" style="width: 100%;" name="email_group_mac_id_request_notification" rows="5">{{ isset($configs['email_group_mac_id_request_notification']) ? $configs['email_group_mac_id_request_notification'] : "" }}</textarea>

                            </div>
                        </div>
                    </div> <!-- col-xs-12 col-sm-6 col-md-6 -->
                    <div class="col-xs-12 col-sm-6 col-md-6">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div style="width: 80%;">
                            <p>&nbsp;</p>
                            <div class="form-group">
                                <button type="submit" class="btn btn-default">
                                    {{ strtoupper(trans('common.btn_save')) }}
                                </button>
                                <button type="button" class="btn btn-default" onclick="javascript:cancelFunc();" style="margin-left: 10px;">
                                    CANCEL
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                    </div>                     
                </div>     
            </div>
        </form>

    </div>  

    <script type="text/javascript">
        function cancelFunc() {
            window.location.href = "{{ url('admin/customers') }}";
        }


        $(document).ready(function(){
            // console.log('doc ready!!');

            // $('#left_menu_item_7').attr('class', 'active');
        });

    </script>    
</div>
@endsection
