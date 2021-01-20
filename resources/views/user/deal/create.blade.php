@extends('layouts.app')

@section('top-nav')

    @include('layouts.templates.top-nav')

@endsection

@section('menu')

    @include('layouts.templates.menu-deal')

    <script type="text/javascript">

        var headMenuItemIndex = 1;

    </script>
@endsection


@section('banner')

    @include('layouts.templates.banner-deal')

@endsection


@section('content')
<div class="content container">

    <p>&nbsp;</p>

    <form class="form-horizontal" role="form" method="POST" action="{{ url('user/deal/create') }}">

        {{ csrf_field() }}
       
        <div class="row">
            <div style="margin-left: 15px;">
                <p class="p-title-big">{{ strtoupper(trans('deal.label_create_deal')) }}</p>
                
                @if (isset($successMsg))
                    <div class="alert alert-success" role="alert" style="width: 100%;">{{ $successMsg }}</div>
                @endif
                @if (isset($errorMsg))
                    <div class="alert alert-danger" role="alert" style="width: 100%;">{{ $errorMsg }}</div>
                @endif
            </div>
            <div style="margin-left: 20px; margin-top: 20px;">
                
                <div id="div_deal_argeement">

                    {!! trans('deal.str_argeement') !!}

                    <div class="form-group{{ $errors->has('accept') ? ' has-error' : '' }}" style="margin-left: 5px;">
                        <input id="accept" type="checkbox" name="accept" value="1" 
                            @if (old('accept'))
                                checked
                            @endif
                        >
                        <label for="accept"><span class="span-required-red">*</span>{{ trans('common.label_accept') }}</label>

                        @if ($errors->has('accept'))
                            <span class="help-block">
                                <strong>{{ $errors->first('accept') }}</strong>
                            </span>
                        @endif
                    </div>                    

                </div>

                <p>&nbsp;</p>

                <div class="container">
                    <div class="row">
                        <p class="p-title-small-blue">{{ strtoupper(trans('deal.label_reseller_info')) }}</p> 
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div style="width: 80%;">
                                <div class="form-group{{ $errors->has('reseller_company') ? ' has-error' : '' }}">
                                    <label for="reseller_company"><span class="span-required-red">*</span>{{ trans('customer.label_company') }}</label>
                                    
                                    <input id="reseller_company" type="text" class="form-control" name="reseller_company"
                                        @if (isset($customer['reseller_company']) && !empty($customer['reseller_company']))
                                             value="{{ $customer['reseller_company'] }}"
                                        @else  
                                             value="{{ old('reseller_company') }}"
                                        @endif
                                    >

                                    @if ($errors->has('reseller_company'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('reseller_company') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('reseller_phone') ? ' has-error' : '' }}">
                                    <label for="reseller_phone"><span class="span-required-red">*</span>{{ trans('customer.label_phone') }}</label>

                                    <input id="reseller_phone" type="text" class="form-control" name="reseller_phone"
                                        @if (isset($customer['reseller_phone']) && !empty($customer['reseller_phone']))
                                             value="{{ $customer['reseller_phone'] }}"
                                        @else  
                                             value="{{ old('reseller_phone') }}"
                                        @endif
                                    >

                                    @if ($errors->has('reseller_phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('reseller_phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('reseller_email') ? ' has-error' : '' }}">
                                    <label for="reseller_email"><span class="span-required-red">*</span>{{ trans('customer.label_email') }}</label>

                                    <input id="reseller_email" type="text" class="form-control" name="reseller_email"
                                        @if (isset($customer['reseller_email']) && !empty($customer['reseller_email']))
                                             value="{{ $customer['reseller_email'] }}"
                                        @else  
                                             value="{{ old('reseller_email') }}"
                                        @endif
                                    >

                                    @if ($errors->has('reseller_email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('reseller_email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('reseller_contact') ? ' has-error' : '' }}">
                                    <label for="reseller_contact"><span class="span-required-red">*</span>{{ trans('deal.label_sales_contact') }}</label>

                                    <input id="reseller_contact" type="text" class="form-control" name="reseller_contact"
                                        @if (isset($customer['reseller_contact']) && !empty($customer['reseller_contact']))
                                             value="{{ $customer['reseller_contact'] }}"
                                        @else  
                                             value="{{ old('reseller_contact') }}"
                                        @endif
                                    >

                                    @if ($errors->has('reseller_contact'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('reseller_contact') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('opportunity_name') ? ' has-error' : '' }}">
                                    <label for="opportunity_name"><span class="span-required-red">*</span>{{ trans('deal.label_opportunity_name') }}</label>
                                    <input id="opportunity_name" type="text" class="form-control" name="opportunity_name" value="{{ old('opportunity_name') }}">

                                    @if ($errors->has('opportunity_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('opportunity_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('opportunity_date') ? ' has-error' : '' }}">
                                    <label for="opportunity_date"><span class="span-required-red">*</span>{{ trans('deal.label_opportunity_date') }}</label>
                                    <input id="opportunity_date" type="text" class="form-control" name="opportunity_date" value="{{ old('opportunity_date') }}" readonly="true">

                                    @if ($errors->has('opportunity_date'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('opportunity_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('opportunity_account_manager') ? ' has-error' : '' }}">
                                    <label for="opportunity_account_manager"><span class="span-required-red">*</span>{{ trans('deal.label_aei_account_manager') }}</label>
                                    <select id="opportunity_account_manager" name="opportunity_account_manager" style="width: 100%; height: 30px;" value="">
                                        <option value=""></option>

                                        @if (isset($param['managers'])) 
                                            @foreach ($param['managers'] as $k => $v)
                                                @if (!empty(old('opportunity_account_manager')) && $k == old('opportunity_account_manager'))
                                                    <option value="{{ $k }}" selected>{{ $v }}</option>
                                                @else
                                                    <option value="{{ $k }}">{{ $v }}</option>
                                                @endif
                                            @endforeach
                                        @endif

                                    </select>

                                    @if ($errors->has('opportunity_account_manager'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('opportunity_account_manager') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4"></div>
                        <div class="col-xs-12 col-sm-4 col-md-4"></div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div style="width: 80%;">
                                <div class="form-group{{ $errors->has('opportunity_product') ? ' has-error' : '' }}">
                                    <label for="opportunity_product"><span class="span-required-red">*</span>{{ trans('deal.label_product_quantity') }}</label>
                                    
                                    <select id="opportunity_product_select" class="form-control" readonly="true" multiple="multiple" size="7" style="font-size: 10px;">
                                    </select>
                                    <input type="hidden" name="opportunity_product" value="" id="opportunity_product"/>

                                    <p style="margin-top: 10px;">  
                                        <button type="button" class="btn btn-default btn-sm" id="btn_select_product">
                                            {{ strtoupper(trans('deal.btn_select_product')) }}
                                        </button>
                                        <button type="button" class="btn btn-default btn-sm" id="btn_clear" style="margin-left: 10px;">
                                            {{ strtoupper(trans('common.btn_clear')) }}
                                        </button>
                                    </p>

                                    @if ($errors->has('opportunity_product'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('opportunity_product') }}</strong>
                                        </span>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6"></div>
                    </div>

                    <p>&nbsp;</p>

                    <div class="row">
                        <p class="p-title-small-blue">{{ strtoupper(trans('deal.label_distributor_info')) }}</p> 
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div style="width: 80%;">
                                <div class="form-group{{ $errors->has('distributor_preferred') ? ' has-error' : '' }}">
                                    <label for="distributor_preferred"><span class="span-required-red">*</span>{{ trans('deal.label_preferred_distributor') }}</label>
                                    <select id="distributor_preferred" name="distributor_preferred" style="width: 100%; height: 30px;" value="">
                                        <option value=""></option>

                                        @if (isset($param['distributors']))                                
                                            @foreach ($param['distributors'] as $k => $v)
                                                @if (!empty(old('distributor_preferred')) && $k == old('distributor_preferred'))
                                                    <option value="{{ $k }}" selected>{{ $v }}</option>
                                                @else
                                                    <option value="{{ $k }}">{{ $v }}</option>
                                                @endif
                                            @endforeach
                                        @endif

                                    </select>

                                    @if ($errors->has('distributor_preferred'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('distributor_preferred') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="width: 100%">
                                    <div class="row">
                                        <label for="distributor_contact"><span class="span-required-red">*</span>{{ trans('deal.label_sales_contact_distributor') }}</label>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-6">
                                            <div class="form-group{{ $errors->has('distributor_contact_firstname') ? ' has-error' : '' }}" style="margin-right:5px;">
                                                <input id="distributor_contact_firstname" type="text" class="form-control" name="distributor_contact_firstname" value="{{ old('distributor_contact_firstname') }}" placeholder="{{ trans('customer.label_firstname') }}">

                                                @if ($errors->has('distributor_contact_firstname'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('distributor_contact_firstname') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6">
                                             <div class="form-group{{ $errors->has('distributor_contact_lastname') ? ' has-error' : '' }}"  style="margin-right:5px;">
                                                <input id="distributor_contact_lastname" type="text" class="form-control" name="distributor_contact_lastname" value="{{ old('distributor_contact_lastname') }}" placeholder="{{ trans('customer.label_lastname') }}">

                                                @if ($errors->has('distributor_contact_lastname'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('distributor_contact_lastname') }}</strong>
                                                    </span>
                                                @endif
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('distributor_phone') ? ' has-error' : '' }}">
                                    <label for="distributor_phone"><span class="span-required-red">*</span>{{ trans('customer.label_phone') }}</label>
                                    <input id="distributor_phone" type="text" class="form-control" name="distributor_phone" value="{{ old('distributor_phone') }}">

                                    @if ($errors->has('distributor_phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('distributor_phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('distributor_email') ? ' has-error' : '' }}">
                                    <label for="distributor_email"><span class="span-required-red">*</span>{{ trans('customer.label_email') }}</label>
                                    <input id="distributor_email" type="text" class="form-control" name="distributor_email" value="{{ old('distributor_email') }}">

                                    @if ($errors->has('distributor_email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('distributor_email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4"></div>
                        <div class="col-xs-12 col-sm-4 col-md-4"></div>
                    </div>

                    <p>&nbsp;</p>

                    <div class="row">
                        <p class="p-title-small-blue">{{ strtoupper(trans('deal.label_enduser_info')) }}</p> 
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div style="width: 80%;">
                                <div class="form-group{{ $errors->has('customer_company') ? ' has-error' : '' }}">
                                    <label for="customer_company"><span class="span-required-red">*</span>{{ trans('customer.label_company') }}</label>
                                    <input id="customer_company" type="text" class="form-control" name="customer_company" value="{{ old('customer_company') }}">

                                    @if ($errors->has('customer_company'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('customer_company') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('customer_contact') ? ' has-error' : '' }}">
                                    <label for="customer_contact"><span class="span-required-red">*</span>{{ trans('deal.label_contact_name') }}</label>
                                    <input id="customer_contact" type="text" class="form-control" name="customer_contact" value="{{ old('customer_contact') }}">

                                    @if ($errors->has('customer_contact'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('customer_contact') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('customer_phone') ? ' has-error' : '' }}">
                                    <label for="customer_phone"><span class="span-required-red">*</span>{{ trans('customer.label_phone') }}</label>
                                    <input id="customer_phone" type="text" class="form-control" name="customer_phone" value="{{ old('customer_phone') }}">

                                    @if ($errors->has('customer_phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('customer_phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('customer_email') ? ' has-error' : '' }}">
                                    <label for="customer_email"><span class="span-required-red">*</span>{{ trans('customer.label_email') }}</label>
                                    <input id="customer_email" type="text" class="form-control" name="customer_email" value="{{ old('customer_email') }}">

                                    @if ($errors->has('customer_email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('customer_email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('customer_address') ? ' has-error' : '' }}">
                                    <label for="customer_address"><span class="span-required-red">*</span>{{ trans('customer.label_address') }}</label>
                                    <input id="customer_address" type="text" class="form-control" name="customer_address" value="{{ old('customer_address') }}">

                                    @if ($errors->has('customer_address'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('customer_address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('customer_city') ? ' has-error' : '' }}">
                                    <label for="customer_city"><span class="span-required-red">*</span>{{ trans('customer.label_city') }}</label>
                                    <input id="customer_city" type="text" class="form-control" name="customer_city" value="{{ old('customer_city') }}">

                                    @if ($errors->has('customer_city'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('customer_city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ ($errors->has('customer_province') || $errors->has('customer_province_id')) ? ' has-error' : '' }}">
                                    <label for="customer_province"><span class="span-required-red">*</span>{{ trans('customer.label_province') }}</label>
                                    <input id="customer_province" type="text" class="form-control" name="customer_province" value="{{ old('customer_province') }}">

                                    <select id="customer_province_id" name="customer_province_id" style="width: 100%; height: 30px; display: none;" value="">
                                    </select>

                                    @if ($errors->has('customer_province'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('customer_province') }}</strong>
                                        </span>
                                    @endif
                                    @if ($errors->has('customer_province_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('customer_province_id') }}</strong>
                                        </span>
                                    @endif

                                    <input id="customer_province_type" type="hidden" class="form-control" name="customer_province_type" value="1">

                                </div>
                                <div class="form-group{{ $errors->has('customer_postal_code') ? ' has-error' : '' }}">
                                    <label for="customer_postal_code"><span class="span-required-red">*</span>{{ trans('customer.label_postal_code') }}</label>
                                    <input id="customer_postal_code" type="text" class="form-control" name="customer_postal_code" value="{{ old('customer_postal_code') }}">

                                    @if ($errors->has('customer_postal_code'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('customer_postal_code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('customer_country') ? ' has-error' : '' }}">
                                    <label for="customer_country"><span class="span-required-red">*</span>{{ trans('customer.label_country') }}</label>
                                    <select id="customer_country" name="customer_country" style="width: 100%; height: 30px;" value="">
                                        <option value=""></option>

                                        @if (isset($param['countries'])) 
                                            @foreach ($param['countries'] as $k => $v)
                                                @if (!empty(old('customer_country')) && $k == old('customer_country'))
                                                    <option value="{{ $k }}" selected>{{ $v }}</option>
                                                @else
                                                    <option value="{{ $k }}">{{ $v }}</option>
                                                @endif
                                            @endforeach
                                        @endif

                                    </select>

                                    @if ($errors->has('customer_country'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('customer_country') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4"></div>
                        <div class="col-xs-12 col-sm-4 col-md-4"></div>
                    </div>
                </div>
            </div>      
        </div>

        <p>&nbsp;</p>

        <div class="row">
            <div style="margin-left: 20px;">
                 <div class="col-xs-12 col-sm-4 col-md-4">
                    <div style="width: 80%;">
                        <div class="form-group">
                            <label><span class="span-required-red">*{{ trans('customer.label_required_fields') }}</span></label><br>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-arrow-right"></i> {{ strtoupper(trans('common.btn_submit')) }}
                            </button>
                            <button type="button" class="btn btn-default" onClick="javascript: backFunc();" style="margin-left: 10px;">
                                {{ strtoupper(trans('common.btn_back')) }}
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

    <div id="dlg_select_product" title="{{ trans('deal.label_select_product') }}" style="display: none;">
        <div class="container" style="width: 320px;">
            <div class="row">
                <p>&nbsp;</p>
                <div class="form-group">
                    <label for="product_list"><span class="span-required-red">*</span>{{ trans('deal.label_product') }}</label>
                    <select id="product_list" name="product_list" style="width: 100%; height: 30px;" value="">
                        <option value=""></option>

                        @if (isset($param['products'])) 
                            @foreach ($param['products'] as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        @endif

                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity"><span class="span-required-red">*</span>{{ trans('deal.label_quantity') }}</label>
                    <input type="text" name="quantity" id="quantity" style="width: 100%;" value="" />
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        @if (isset($param['provinces']))
            var regions = {!! $param['provinces'] !!};
        @else
            var regions = '';
        @endif

        var totalProductQuantity = 0;

        function addProductQuantity(pro_title, pro_count) {

            var pro_list_str = $('#opportunity_product').val();

            if (pro_list_str == "") {

                var str = pro_title + " - " + pro_count;
                var node = $('#opportunity_product_select');
                node.empty();
                node.append("<option value='" + str + "' selected>" + str + "</option>");

                $('#opportunity_product').val(str);
                totalProductQuantity = parseInt(pro_count);

            } else {

                var proListArray = pro_list_str.split(",");
                var bExists = false;
                var tempCount = 0;
                for (var i=0; i<proListArray.length; i++) {
                    
                    var s = String(proListArray[i]);
                    var index = s.lastIndexOf(" - ");                
                    if (s.substr(0, index) == pro_title) {
                        proListArray[i] = pro_title + " - " + pro_count;
                        bExists = true;

                        tempCount = parseInt(s.substr(index+3, s.length-index-3));
                        break;
                    }
                }

                if (bExists == false) {
                    proListArray.push(pro_title + " - " + pro_count);
                    totalProductQuantity += parseInt(pro_count);
                } else {
                    totalProductQuantity += parseInt(pro_count) - tempCount;
                }

                //
                var node = jQuery('#opportunity_product_select');
                node.empty();           
                for (var i=0; i<proListArray.length; i++) {
                    node.append("<option value='" + proListArray[i] + "' selected>" + proListArray[i] + "</option>");   
                }

                $('#opportunity_product').val(proListArray.join(","));
            }
        }  

        $(document).ready(function() {

            //
            @if (!empty(old('customer_province_id')))
                var province_id = "{{ old('customer_province_id') }}";
            @else
                var province_id = "";
            @endif
            changeRegin(province_id);

            $('#customer_country').change(function() {

                changeRegin('');

            });  

            //
            var s = "{{ old('opportunity_product') }} ";
            if (s) {
                var dataArray = s.split(",");
                for (var i=0; i<dataArray.length; i++) {

                    var s2 = String(dataArray[i]);
                    var index = s2.lastIndexOf(" - ");
                    if (index > 0) {
                        addProductQuantity(s2.substr(0, index), s2.substr(index+3, s2.length-index-3));
                    }
                }
            }                              

            $("#opportunity_date").datepicker({ dateFormat: 'yy-mm-dd' });

            $('#btn_select_product').click(function() {

                $('#product_list').val('');
                $('#quantity').val('');

                $("#dlg_select_product").dialog({
                    dialogClass: "no-close",
                    modal: true, 
                    minWidth: 420,
                    minHeight: 300,
                    buttons: [{
                            text: "{!! trans('common.btn_save_continue') !!}",
                            click: function() {
                                var v = $('#product_list').val();
                                if (!v) {
                                    alert("{{ str_replace('%1', trans('deal.label_product'), trans('common.info.notice_select_option')) }}");
                                    $('#product_list').focus();
                                    return;
                                }
                                var q = $('#quantity').val();
                                if (q == "") {
                                    alert("{{ str_replace('%1', trans('deal.label_quantity'), trans('common.info.notice_enter_input')) }}");
                                    $('#quantity').focus();
                                    return;
                                }                                
                                var matchArray = q.match(/[0-9]/g);
                                if (!matchArray || matchArray.join("").length < q.length) {
                                    alert("{{ str_replace('%1', trans('deal.label_quantity'), trans('common.info.notice_consist_of_digit')) }}");
                                    $('#quantity').focus();
                                    return;
                                }
                                var intValue = parseInt(q);
                                if (intValue <= 0) {
                                    alert("{!! str_replace('%1', trans('deal.label_quantity'), trans('common.info.notice_big_than_zero')) !!}");
                                    $('#quantity').focus();
                                    return;
                                }

                                addProductQuantity($('#product_list').find("option:selected").text(), intValue);
                                $('#product_list').val('');
                                $('#quantity').val('');
                            }
                        }, {
                            text: "{{ trans('common.btn_save') }}",
                            click: function() {
                                var v = $('#product_list').val();
                                if (!v) {
                                    alert("{{ str_replace('%1', trans('deal.label_product'), trans('common.info.notice_select_option')) }}");
                                    $('#product_list').focus();
                                    return;
                                }
                                var q = $('#quantity').val();
                                if (q == "") {
                                    alert("{{ str_replace('%1', trans('deal.label_quantity'), trans('common.info.notice_enter_input')) }}");
                                    $('#quantity').focus();
                                    return;
                                }                                
                                var matchArray = q.match(/[0-9]/g);
                                if (!matchArray || matchArray.join("").length < q.length) {
                                    alert("{{ str_replace('%1', trans('deal.label_quantity'), trans('common.info.notice_consist_of_digit')) }}");
                                    $('#quantity').focus();
                                    return;
                                }
                                var intValue = parseInt(q);
                                if (intValue <= 0) {
                                    alert("{!! str_replace('%1', trans('deal.label_quantity'), trans('common.info.notice_big_than_zero')) !!}");
                                    $('#quantity').focus();
                                    return;
                                }

                                addProductQuantity($('#product_list').find("option:selected").text(), intValue);
                                $(this).dialog("close");

                            }
                        }, {
                            text: "{{ trans('common.btn_close') }}",
                            style: "margin-right: 65px;",
                            click: function() {
                                $(this).dialog("close");
                            }
                        }
                    ]
                });
            });

            $('#btn_clear').click(function() {
                $('#opportunity_product_select').empty();
                $('#opportunity_product').val('');

                totalProductQuantity = 0;    
            }); 
        });

        function changeRegin(id) {

            var country = $('#customer_country').val();

            if (regions && regions[country]) {

                var node = $('#customer_province_id');
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
                $('#customer_province').css('display', 'none');
                $('#customer_province_type').val('2');

            } else {

                $('#customer_province_id').css('display', 'none');
                $('#customer_province').css('display', '');
                $('#customer_province_type').val('1');                   
            }

        }

        function backFunc() {
            window.location.href = "{{ url('user/deal') }}";            
        }

    </script>
    
</div>
@endsection
