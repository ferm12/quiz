@extends('layouts.app')

@section('top-nav')

    @include('layouts.templates.top-nav')

@endsection

@section('menu')

    @include('layouts.templates.menu-basic')

    <script type="text/javascript">

        var headMenuItemIndex = 1;

    </script>
@endsection

@section('content')
<div class="content container">

    <form class="form-horizontal" role="form" method="POST" action="{{ url('user/account') }}">

        {{ csrf_field() }}
       
        <div class="row">
            <div style="margin-left: 15px;">

                @if (isset($successMsg))
                    <div class="alert alert-success" role="alert" style="width: 100%;">{{ $successMsg }}</div>
                @endif

                @if (isset($errorMsg))
                    <div class="alert alert-danger" role="alert" style="width: 100%;">{{ $errorMsg }}</div>
                @endif

            </div>

            <div style="margin-left: 20px; margin-top: 20px;">

                <!-- <p class="p&#45;title&#45;small&#45;blue">{{ strtoupper(trans('common.label_account_info')) }}</p>  -->
                <h1>{{ strtoupper(trans('common.label_account_info')) }}</h1> 
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div style="width: 80%;">                
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label><span class="span-required-red">*{{ trans('customer.label_required_fields') }}</span></label><br>

                            <label for="first_name" class="font-weight-bold"><span class="span-required-red">*</span>First Name</label>
                            <input id="first_name" type="text" class="form-control" name="first_name" 

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
                            <label for="last_name" class="font-weight-bold"><span class="span-required-red">*</span>Last Name</label>
                            <input id="last_name" type="text" class="form-control" name="last_name"

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
                            <label for="email" class="font-weight-bold"><span class="span-required-red">*</span>{{ trans('customer.label_email') }}</label><span style="font-style:italic;"> (Cannot be changed)</span>
                            <input id="email" type="text" class="form-control" name="email" readonly

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
                            <label for="phone" class="font-weight-bold"><span class="span-required-red">*</span>{{ trans('customer.label_phone') }}</label>
                            <input id="phone" type="text" class="form-control" name="phone" 

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

                        <div class="form-group{{ $errors->has('organization_name') ? ' has-error' : '' }}">
                            <label for="organization_name" class="font-weight-bold"><span class="span-required-red">*</span>Organization Name</label>
                            <input id="organization_name" type="text" class="form-control" name="organization_name"

                            @if (isset($customer["organization_name"]) && !empty($customer['organization_name']))
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
                            <label for="address" class="font-weight-bold"><span class="span-required-red">*</span>Address</label>
                            <input id="address" type="text" class="form-control" name="address"

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
                            <label for="city" class="font-weight-bold"><span class="span-required-red">*</span>City</label>
                            <input id="city" type="text" class="form-control" name="city"

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

                        <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                            <label for="state" class="font-weight-bold"><span class="span-required-red">*</span>State</label>
                            <input id="state" type="text" class="form-control" name="state"

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
                            <label for="zip_code" class="font-weight-bold"><span class="span-required-red">*</span>Zip Code</label>
                            <input id="zip_code" type="text" class="form-control" name="zip_code"

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
                            <label for="purchased_from" class="font-weight-bold"><span class="span-required-red">*</span>Purchased From</label>
                            <input id="purchased_from" type="text" class="form-control" name="purchased_from"

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
                            <label for="license_key" class="font-weight-bold"><span class="span-required-red">*</span>License Key</label><span style="font-style:italic;"> (Cannot be changed)</span>
                            <input id="license_key" type="text" class="form-control" name="license_key" readonly

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


                        <br/>
                        <div class="form-group">
                            <button type="submit" class="btn btn-default">
                                {{ strtoupper(trans('common.btn_save')) }}
                            </button>
                            <button type="button" class="btn btn-default" onClick="javascript: resetFunc();" style="margin-left: 10px;">
                                {{ strtoupper(trans('common.btn_reset')) }}
                            </button>

                                <a href="{{ url('user/accountsummary')}}" class="btn btn-default" style="margin-left:10px;">Cancel</a>

                        </div>                                               
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4"></div>
                <div class="col-xs-12 col-sm-4 col-md-4"></div>
            </div>
        </div>

    </form>

    <script type="text/javascript">

        function resetFunc() {
            window.location.href = "{{ url('user/account') }}";            
        }

    </script>
</div>
@endsection
