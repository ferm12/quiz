@extends('layouts.app')

@section('top-nav')

    @include('layouts.templates.top-nav')

@endsection

@section('menu')

    @include('layouts.templates.menu-basic')

    <script type="text/javascript">

        var headMenuItemIndex = 2;

    </script>
@endsection

@section('content')
<div class="content container">

    <form class="form-horizontal" role="form" method="POST" action="{{ url('user/contact') }}">

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


            <div class="container">
                <div class="row">
                    <div style="margin-left: 20px; margin-top: 20px;">
                        <p class="p-title-small-blue">{{ strtoupper(trans('common.label_contact_info')) }}</p> 
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div style="width: 80%;">                
                                <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                                    <label for="firstname"><span class="span-required-red">*</span>{{ trans('customer.label_firstname') }}</label>
                                    <input id="firstname" type="text" class="form-control" name="firstname" 

                                    @if (isset($customer['firstname']) && !empty($customer['firstname']))
                                         value="{{ $customer['firstname'] }}"
                                    @else  
                                         value="{{ old('firstname') }}"
                                    @endif

                                    >

                                    @if ($errors->has('firstname'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('firstname') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                                    <label for="company"><span class="span-required-red">*</span>{{ trans('customer.label_company_shortname') }}</label>
                                    <input id="company" type="text" class="form-control" name="company" 

                                    @if (isset($customer['company']) && !empty($customer['company']))
                                         value="{{ $customer['company'] }}"
                                    @else  
                                         value="{{ old('company') }}"
                                    @endif

                                    >

                                    @if ($errors->has('company'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('company') }}</strong>
                                        </span>
                                    @endif
                                </div>                                              
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div style="width: 80%;"> 
                                <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                                    <label for="lastname"><span class="span-required-red">*</span>{{ trans('customer.label_lastname') }}</label>
                                    <input id="lastname" type="text" class="form-control" name="lastname" 

                                    @if (isset($customer['lastname']) && !empty($customer['lastname']))
                                         value="{{ $customer['lastname'] }}"
                                    @else  
                                         value="{{ old('lastname') }}"
                                    @endif

                                    >

                                    @if ($errors->has('lastname'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('lastname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <label for="phone"><span class="span-required-red">*</span>{{ trans('customer.label_phone') }}</label>
                                    <input id="phone" type="text" class="form-control" name="phone" 

                                    @if (isset($customer['phone']) && !empty($customer['phone']))
                                         value="{{ $customer['phone'] }}"
                                    @else  
                                         value="{{ old('phone') }}"
                                    @endif

                                    >

                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>                          
                            </div>                  
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4"></div>
                    </div>
                </div>

                <div class="row">
                    <div style="margin-left: 20px; margin-top: 20px;">
                        <p class="p-title-small-blue">{{ strtoupper(trans('customer.label_address')) }}</p> 
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div style="width: 80%;">
                                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                    <label for="address"><span class="span-required-red">*</span>{{ trans('customer.label_street_address') }}</label>
                                    <input id="address" type="text" class="form-control" name="address" 

                                    @if (isset($customer['address']) && !empty($customer['address']))
                                         value="{{ $customer['address'] }}"
                                    @else  
                                         value="{{ old('address') }}"
                                    @endif

                                    >
                                    
                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ ($errors->has('province') || $errors->has('province_id')) ? ' has-error' : '' }}">
                                    <label for="province"><span class="span-required-red">*</span>{{ trans('customer.label_province') }}</label>
                                    <input id="province" type="text" class="form-control" name="province" 

                                    @if (isset($customer['province']) && !empty($customer['province']))
                                         value="{{ $customer['province'] }}"
                                    @else  
                                         value="{{ old('province') }}"
                                    @endif

                                    >

                                    <select id="province_id" name="province_id" style="width: 100%; height: 30px; display: none;" value="">
                                    </select>
 
                                    @if ($errors->has('province'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('province') }}</strong>
                                        </span>
                                    @endif                                   
                                    @if ($errors->has('province_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('province_id') }}</strong>
                                        </span>
                                    @endif

                                    <input id="province_type" type="hidden" class="form-control" name="province_type" value="1">
                                </div>
                                <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                    <label for="country"><span class="span-required-red">*</span>{{ trans('customer.label_country') }}</label>
                                    <select id="country" name="country" style="width: 100%; height: 30px;" value="">
                                        <option value=""></option>

                                        @if (isset($param['countries']))
                                            @foreach ($param['countries'] as $k => $v)

                                                @if (isset($customer['country']) && !empty($customer['country']))

                                                    @if ($k == $customer['country'])
                                                        <option value="{{ $k }}" selected='true' >{{ $v }}</option>
                                                    @else
                                                        <option value="{{ $k }}">{{ $v }}</option>
                                                    @endif                          

                                                @else 

                                                    @if (!empty(old('country')) && $k == old('country'))
                                                        <option value="{{ $k }}" selected='true' >{{ $v }}</option>
                                                    @else
                                                        <option value="{{ $k }}">{{ $v }}</option>
                                                    @endif

                                                @endif

                                            @endforeach
                                        @endif

                                    </select>
                                    @if ($errors->has('country'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('country') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div style="width: 80%;">
                                <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                    <label for="city"><span class="span-required-red">*</span>{{ trans('customer.label_city') }}</label>
                                    <input id="city" type="text" class="form-control" name="city" 

                                    @if (isset($customer['city']) && !empty($customer['city']))
                                         value="{{ $customer['city'] }}"
                                    @else  
                                         value="{{ old('city') }}"
                                    @endif

                                    >
                                    
                                    @if ($errors->has('city'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('postal_code') ? ' has-error' : '' }}">
                                    <label for="postal_code"><span class="span-required-red">*</span>{{ trans('customer.label_postal_code') }}</label>
                                    <input id="postal_code" type="text" class="form-control" name="postal_code" 

                                    @if (isset($customer['postal_code']) && !empty($customer['postal_code']))
                                         value="{{ $customer['postal_code'] }}"
                                    @else  
                                         value="{{ old('postal_code') }}"
                                    @endif

                                    >
                                    
                                    @if ($errors->has('postal_code'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('postal_code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4"></div>
                    </div>
                </div>

                <div class="row">
                    <div style="margin-left: 20px; margin-top: 20px;">
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div style="width: 80%;">
                                <div class="form-group">
                                    <label><span class="span-required-red">*{{ trans('customer.label_required_fields') }}</span></label><br>
                                    <button type="submit" class="btn btn-default">
                                        {{ strtoupper(trans('common.btn_save')) }}
                                    </button>
                                    <button type="button" class="btn btn-default" onClick="javascript: resetFunc();" style="margin-left: 10px;">
                                        {{ strtoupper(trans('common.btn_reset')) }}
                                    </button>                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4"></div>
                        <div class="col-xs-12 col-sm-4 col-md-4"></div>
                    </div>
                </div>
            </div>

        </div>
    </form>

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

        function resetFunc() {
            window.location.href = "{{ url('user/contact') }}";            
        }

    </script>

</div>
@endsection

