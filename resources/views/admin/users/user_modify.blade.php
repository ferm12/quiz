@extends('layouts.admin')

@section('page-header')
	<h1>
		{{ trans('admin.title_modify') }}
		<small></small>
	</h1>
	<ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('common.label_home') }} </a></li>
		<li><a href="{{ url('admin/users') }}"> {{ trans('admin.title_users') }} </a></li>
		<li class="active">{{ trans('admin.title_modify') }}</li>
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

        <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/users/modify/post') }}">
            <input type="hidden" name="id" id="id" 

            @if (isset($admin['id']) && !empty($admin['id']))
                 value="{{ $admin['id'] }}"
            @else  
                 value="{{ old('id') }}"
            @endif

            />
            <input type="hidden" name="page" id="page" 

            @if (isset($admin['page']) && !empty($admin['page']))
                 value="{{ $admin['page'] }}"
            @else  
                 value="{{ old('page') }}"
            @endif

            />

            {{ csrf_field() }}

            <div class="container" style="margin-left: 30px;">
                <div class="row">
                    <p class="p-title-small-blue">&nbsp;</p> 
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div style="width: 80%;">
                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label for="first-name"><span class="span-required-red">*</span>{{ trans('customer.label_firstname') }}</label>
                                <input id="first-name" type="text" style="width: 100%;" name="first_name" 

                                @if (isset($admin['first_name']) && !empty($admin['first_name']))
                                     value="{{ $admin['first_name'] }}"
                                @else  
                                     value="{{ old('first_name') }}"
                                @endif

                                >

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label for="last-name"><span class="span-required-red">*</span>{{ trans('customer.label_lastname') }}</label>
                                <input id="last-name" type="text" style="width: 100%;" name="last_name"
                                
                                @if (isset($admin['last_name']) && !empty($admin['last_name']))
                                     value="{{ $admin['last_name'] }}"
                                @else  
                                     value="{{ old('last_name') }}"
                                @endif

                                >

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email"><span class="span-required-red">*</span>{{ trans('customer.label_email') }}</label>
                                <input id="email" type="text" style="width: 100%;" name="email" 
                                
                                @if (isset($admin['email']) && !empty($admin['email']))
                                     value="{{ $admin['email'] }}"
                                @else  
                                     value="{{ old('email') }}"
                                @endif

                                >

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password">{{ trans('customer.label_password') }}</label>
                                <input id="password" type="password" style="width: 100%;" name="password" style="width: 65%;" value="{{ old('password') }}" placeholder="">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password_confirmation">{{ trans('customer.label_password_confirmation') }}</label>
                                <input id="password_confirmation" type="password" style="width: 100%;" name="password_confirmation" style="width: 65%;" value="{{ old('password_confirmation') }}" placeholder="">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                    </div>
                </div>

                <div class="row" style="margin-top: 25px;">
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

            $('#left_menu_item_5').attr('class', 'active');

            // 
            var init = $('#init_default').val();
            if (init == '1') {
                $('#div_rule_id').css('display', 'none');
                $('#div_account_status').css('display', 'none');
            }  
        });

        function cancelFunc() {
            window.location.href = "{{ url('admin/users') }}" + '?page=' + $('#page').val();            
        }

    </script>    
</div>
@endsection
