@extends('layouts.admin')

@section('page-header')
	<h1>
		{{ trans('admin.title_modify') }}
		<small></small>
	</h1>
	<ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('common.label_home') }} </a></li>
		<li><a href="{{ url('admin/customers') }}"> {{ trans('admin.title_customers') }} </a></li>
		<li class="active">{{ trans('admin.title_modify') }}</li>
	</ol>
@endsection

@section('content')
<div class="content container-fluid">
    <div class="row">



        @if ($message = Session::get('successMsg'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
        </div>
        @endif  

        @if (isset($successMsg))
            <div class="alert alert-success" role="alert">{{ $successMsg }}</div>
        @endif

        @if (isset($errorMsg))
            <div class="alert alert-danger" role="alert">{{ $errorMsg }}</div>
        @endif

        <label><span class="span-required-red" style="padding-left:29px;">*{{ trans('customer.label_required_fields') }}</span></label><br>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/customers/modify/post') }}">
            <input type="hidden" name="id" id="id" 

            @if (isset($customer['id']) && !empty($customer['id']))
                 value="{{ $customer['id'] }}"
            @else  
                 value="{{ old('id') }}"
            @endif

            />
            <input type="hidden" name="page" id="page" 

            @if (isset($customer['page']) && !empty($customer['page']))
                 value="{{ $customer['page'] }}"
            @else  
                 value="{{ old('page') }}"
            @endif

            />

            {{ csrf_field() }}

            <div class="container" style="margin-left: 30px;">

                <div class="row">
                    <p class="p-title-small-blue">{{ strtoupper(trans('customer.label_primary_contact')) }}</p> 
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div style="width: 80%;">
                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label for="first_name"><span class="span-required-red">*</span>{{ trans('customer.label_firstname') }}</label>
                                <input id="first_name" class="form-control" type="text" style="width: 100%;" name="first_name" required 

                                @if (isset($customer['first_name']) && !empty($customer['first_name']))
                                     value="{{ $customer['first_name'] }}"
                                @else  
                                     value="{{ old('first_name') }}"
                                @endif

                                >

                                @if ($errors->has('first_name'))
                                    <span class="help-block alert-danger">
                                        <strong>The first name may only contain letters and numbers, no white space</strong>
                                    </span>

                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label for="last_name"><span class="span-required-red">*</span>{{ trans('customer.label_lastname') }}</label>
                                <input id="last_name" class="form-control" type="text" style="width: 100%;" name="last_name" required
                                
                                @if (isset($customer['last_name']) && !empty($customer['last_name']))
                                     value="{{ $customer['last_name'] }}"
                                @else  
                                     value="{{ old('last_name') }}"
                                @endif

                                >

                                @if ($errors->has('last_name'))
                                    <span class="help-block alert-danger">
                                        <strong>The last name may only contain letters and numbers, no white space</strong>
                                    </span>
                                @endif

                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email"><span class="span-required-red">*</span>{{ trans('customer.label_email') }}</label>
                                <span style="font-style:italic;"> (Cannot be changed)</span>
                                <input id="email" class="form-control" type="text" style="width: 100%;" name="email" required readonly

                                
                                @if (isset($customer['email']) && !empty($customer['email']))
                                     value="{{ $customer['email'] }}"
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

                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label for="phone"><span class="span-required-red">*</span>{{ trans('customer.label_phone') }}</label>
                                <input id="phone" class="form-control" type="text" style="width: 100%;" name="phone" required
                                
                                @if (isset($customer['phone']) && !empty($customer['phone']))
                                     value="{{ $customer['phone'] }}"
                                @else  
                                     value="{{ old('phone') }}"
                                @endif

                                >

                                @if ($errors->has('phone'))
                                    <span class="help-block alert-danger">
                                        <strong>1.The phone may contain letters, numbers, and</strong><br>
                                        <strong>2.Any of these -_+*() special characters </strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password">{{ trans('customer.label_password') }}</label>
                                <!-- <input id="password" type="text" style="width: 100%;" name="password" value=""> -->
                                <br/><a href="<?php echo '/admin/customers/resetpassword/' . $customer['id']; ?>" class="btn btn-default" style="margin-left:10px;">Reset Password</a>


                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>  
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 10px;">
                    <p class="p-title-small-blue">SCHOOL</p> 
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div style="width: 80%;">
                            <div class="form-group{{ $errors->has('organization_name') ? ' has-error' : '' }}">
                                <label for="organization-name"><span class="span-required-red">*</span>Organization Name</label>
                                <input id="organization-name" class="form-control" type="text" style="width: 100%;" name="organization_name" required
                                
                                @if (isset($customer['organization_name']) && !empty($customer['organization_name']))
                                     value="{{ $customer['organization_name'] }}"
                                @else  
                                     value="{{ old('organization_name') }}"
                                @endif

                                >

                                @if ($errors->has('organization_name'))
                                   <span class="help-block alert-danger">
                                        <strong>1.The organization name may contain letters, numbers and</strong><br/>
                                        <strong>2.Any of these -_+.,!@$%^*() special characters</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                <label for="address"><span class="span-required-red">*</span>{{ trans('customer.label_address') }}</label>
                                <input id="address" class="form-control" type="text" style="width: 100%;" name="address" required
                                
                                @if (isset($customer['address']) && !empty($customer['address']))
                                     value="{{ $customer['address'] }}"
                                @else  
                                     value="{{ old('address') }}"
                                @endif

                                >

                                @if ($errors->has('address'))
                                    <span class="help-block alert-danger">
                                        <strong>1.The street address may contain letters, numbers and</strong><br/>
                                        <strong>2.Any of these -_+.,!@$%^*() special characters</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                <label for="city"><span class="span-required-red">*</span>{{ trans('customer.label_city') }}</label>
                                <input id="city" class="form-control" type="text" style="width: 100%;" name="city" required
                                
                                @if (isset($customer['city']) && !empty($customer['city']))
                                     value="{{ $customer['city'] }}"
                                @else  
                                     value="{{ old('city') }}"
                                @endif

                                >

                                @if ($errors->has('city'))
                                    <span class="help-block alert-danger">
                                        <strong>The city may only contain letters and numbers</strong><br/>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ ($errors->has('state') || $errors->has('state')) ? ' has-error' : '' }}">
                                <label for="state"><span class="span-required-red">*</span>State</label>
                                <input id="state" class="form-control" type="text" style="width: 100%;" name="state" required

                                @if (isset($customer['state']) && !empty($customer['state']))
                                     value="{{ $customer['state'] }}"
                                @else  
                                     value="{{ old('state') }}"
                                @endif

                                >
                                @if ($errors->has('state'))
                                    <span class="help-block alert-danger">
                                        <strong>The state may only contain letters and numbers</strong><br/>
                                    </span>
                                @endif
                               
                            </div>                                
                            <div class="form-group{{ $errors->has('zip_code') ? ' has-error' : '' }}">
                                <label for="zip-code"><span class="span-required-red">*</span>Zip Code</label>
                                <input id="zip-code" class="form-control" type="text" style="width: 100%;" name="zip_code" required
                                
                                @if (isset($customer['zip_code']) && !empty($customer['zip_code']))
                                     value="{{ $customer['zip_code'] }}"
                                @else  
                                     value="{{ old('zip_code') }}"
                                @endif

                                >

                                @if ($errors->has('zip_code'))
                                    <span class="help-block alert-danger">
                                        <strong>The zip code may only contain letters and numbers</strong><br/>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                <label for="country" class="font-weight-bold"><span class="span-required-red">*</span>Country</label>
                                <span style="font-style:italic;"> (Cannot be changed)</span>
                                <input id="country" type="text" class="form-control" name="country" readonly

                                @if (isset($customer['country']) && !empty($customer['country']))
                                     value="{{ $customer['country'] }}"
                                @else  
                                     value="{{ old('country') }}"
                                @endif

                                >
                                @if ($errors->has('country'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('country') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('purchased_from') ? ' has-error' : '' }}">
                                <label for="purchased_from"><span class="span-required-red">*</span>Purchased From</label>
                                <input id="purchased_from" class="form-control" type="text" style="width: 100%;" name="purchased_from" required
                                
                                @if (isset($customer['purchased_from']) && !empty($customer['purchased_from']))
                                     value="{{ $customer['purchased_from'] }}"
                                @else  
                                     value="{{ old('purchased_from') }}"
                                @endif

                                >

                                @if ($errors->has('purchased_from'))
                                    <span class="help-block alert-danger">
                                        <strong>1.The purchased from may only contain letters, numbers and</strong><br/>
                                        <strong>2.Any of these -_+.,!@$%^*() special characters</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('license_key') ? ' has-error' : '' }}">
                                <label for="license_key"><span class="span-required-red">*</span> License Key </label>
                                <span style="font-style:italic;"> (Cannot be changed)</span>
                                <input id="license_key" class="form-control" type="text" style="width: 100%;" name="license_key" required readonly
                                
                                @if (isset($customer['license_key']) && !empty($customer['license_key']))
                                     value="{{ $customer['license_key'] }}"
                                @else  
                                     value="{{ old('license_key') }}"
                                @endif

                                >

                                @if ($errors->has('license_key'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('license_key') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                <!-- <div class="row" style="margin&#45;top: 10px;"> -->
                <!--     <p class="p&#45;title&#45;small&#45;blue">OPTIONS</p>  -->
                <!--     <div class="col&#45;xs&#45;12 col&#45;sm&#45;4 col&#45;md&#45;4"> -->
            
                <!--         <div style="width: 80%;"> -->
                <!--             <div class="form&#45;group" id="div_sendemail" style=""> -->
                <!--                 <input id="sendemail" type="checkbox" name="sendemail"> Send Email to Customer -->
                <!--             </div>                     -->
                <!--         </div>         -->
                <!--     </div>  -->
                <!--     <div class="col&#45;xs&#45;12 col&#45;sm&#45;4 col&#45;md&#45;4"> -->
                <!--     </div>                     -->

                <!-- </div> -->

                <div class="row" style="margin-top: 25px;">
                     <div class="col-xs-12 col-sm-4 col-md-4">
                        <div style="width: 80%;">

                            <div class="form-group">
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

        @if (isset($param['provinces']))
            var regions = {!! $param['provinces'] !!};
        @else
            var regions = '';
        @endif

        $(document).ready(function(){

            $('#left_menu_item_1').attr('class', 'active');

            //
            @if (isset($customer['province_id']) && !empty($customer['province_id']))
                var province_id = "{{ $customer['province_id'] }}";
            @else 
                @if (!empty(old('province_id')))
                    var province_id = "{{ old('province_id') }}";
                @else
                    var province_id = "";
                @endif
            @endif
            changeRegin(province_id);

            $('#country').change(function() {

                changeRegin('');

            });       
            
        });

        function changeRegin(id) {

            var country = $('#country').val();

            if (regions && regions[country]) {

                var node = $('#province_id');
                node.empty();
                node.append("<option value=''></option>");

                var arr = regions[country];

                for (var key in arr) {
                    if (id != '' && id == key) {
                        node.append("<option value='" + key + "' selected='true'>" + arr[key] + "</option>");
                    } else {
                        node.append("<option value='" + key + "'>" + arr[key] + "</option>");
                    }
                }

                node.css('display', '');
                $('#province').css('display', 'none');
                $('#province_type').val('2');

            } else {

                $('#province_id').css('display', 'none');
                $('#province').css('display', '');
                $('#province_type').val('1');                   
            }

        }

        function cancelFunc() {
            window.location.href = "{{ url('admin/customers') }}" + '?page=' + $('#page').val();            
        }

        function changeStatus() {
            // var v = $('#is_confirmed').val();
            // if (v == '2' || v == '3') {
            //     $('#div_sendemail').css('display', '');
            // } else {
            //     $('#div_sendemail').css('display', 'none');
            // }
        }

    </script>    
</div>
@endsection
