@extends('layouts.admin')

@section('page-header')
	<h1>
		{{ trans('admin.title_modify') }}
		<small></small>
	</h1>
	<ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('common.label_home') }} </a></li>
		<li><a href="{{ url('admin/deals') }}"> {{ trans('admin.title_deals') }} </a></li>
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

        <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/macids/modify/post') }}">
            <input type="hidden" name="id" id="id" 

            @if (isset($mac_id['id']) && !empty($mac_id['id']))
                 value="{{ $mac_id['id'] }}"
            @else  
                 value="{{ old('id') }}"
            @endif

            />
            <input type="hidden" name="page" id="page" 

            @if (isset($mac_id['page']) && !empty($mac_id['page']))
                 value="{{ $mac_id['page'] }}"
            @else  
                 value="{{ old('page') }}"
            @endif

            />

            {{ csrf_field() }}


            <div class="container" style="margin-left: 30px;">
                <div class="row">
                    <p class="p-title-small-blue">{{ strtoupper(trans('deal.label_reseller_info')) }}</p> 
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div style="width: 80%;">
                            <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                                <label for="user_id">User ID</label>

                                <input id="user_id" style="backgroung-color:grey" type="text" name="user_id" class="input-readonly-small" disabled="disabled" title="User ID"
                                    @if (isset($mac_id['user_id']) && !empty($mac_id['user_id']))
                                         value="{{ $mac_id['user_id'] }}"
                                    @else  
                                         value="{{ old('user_id') }}"
                                    @endif
                                />

                                @if ($errors->has('user_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_id') }}</strong>
                                    </span>
                                @endif
                            </div> <!-- form-group -->
                            <div class="form-group{{ $errors->has('sn') ? ' has-error' : '' }}">
                                <label for="sn">SN</label>

                                <input id="sn" type="text" name="sn" class="input-readonly-small" title="SN"
                                    @if (isset($mac_id['sn']) && !empty($mac_id['sn']))
                                         value="{{ $mac_id['sn'] }}"
                                    @else  
                                         value="{{ old('sn') }}"
                                    @endif
                                />

                                @if ($errors->has('sn'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sn') }}</strong>
                                    </span>
                                @endif
                            </div> <!-- form-group -->
                            <div class="form-group{{ $errors->has('mac_id') ? ' has-error' : '' }}">
                                <label for="mac_id">Mac ID</label>

                                <input id="mac_id" type="text" name="mac_id" class="input-readonly-small" title="Mac ID"
                                    @if (isset($mac_id['mac_id']) && !empty($mac_id['mac_id']))
                                         value="{{ $mac_id['mac_id'] }}"
                                    @else  
                                         value="{{ old('mac_id') }}"
                                    @endif
                                />

                                @if ($errors->has('mac_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mac_id') }}</strong>
                                    </span>
                                @endif
                            </div> <!-- form-group -->
                            <div class="form-group{{ $errors->has('purchased_from') ? ' has-error' : '' }}">
                                <label for="purchased_from">Purchased From</label>

                                <input id="purchased_from" type="text" name="purchased_from" class="input-readonly-small" title="Purchased From"
                                    @if (isset($mac_id['purchased_from']) && !empty($mac_id['purchased_from']))
                                         value="{{ $mac_id['purchased_from'] }}"
                                    @else  
                                         value="{{ old('purchased_from') }}"
                                    @endif
                                />

                                @if ($errors->has('purchased_from'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('purchased_from') }}</strong>
                                    </span>
                                @endif
                            </div> <!-- form-group -->
                            <div class="form-group{{ $errors->has('taken') ? ' has-error' : '' }}">
                                <label for="taken">Taken</label>

                                <input id="taken" type="text" name="taken" class="input-readonly-small" title="Taken"
                                    @if (isset($mac_id['taken']) && !empty($mac_id['taken']))
                                         value="{{ $mac_id['taken'] }}"
                                    @else  
                                         value="{{ old('taken') }}"
                                    @endif
                                />

                                @if ($errors->has('taken'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('taken') }}</strong>
                                    </span>
                                @endif
                            </div> <!-- form-group -->
                            <div class="form-group{{ $errors->has('license_number') ? ' has-error' : '' }}">
                                <label for="license_number">License Number</label>

                                <input id="license_number" type="text" name="license_number" class="input-readonly-small" title="License Number"
                                    @if (isset($mac_id['license_number']) && !empty($mac_id['license_number']))
                                         value="{{ $mac_id['license_number'] }}"
                                    @else  
                                         value="{{ old('license_number') }}"
                                    @endif
                                />

                                @if ($errors->has('license_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('license_number') }}</strong>
                                    </span>
                                @endif
                            </div> <!-- form-group -->
                            <div class="form-group{{ $errors->has('activation_key') ? ' has-error' : '' }}">
                                <label for="activation_key">Activation Key</label>

                                <input id="activation_key" type="text" name="activation_key" class="input-readonly-small" title="Activation Key"
                                    @if (isset($mac_id['activation_key']) && !empty($mac_id['activation_key']))
                                         value="{{ $mac_id['activation_key'] }}"
                                    @else  
                                         value="{{ old('activation_key') }}"
                                    @endif
                                />

                                @if ($errors->has('activation_key'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('activation_key') }}</strong>
                                    </span>
                                @endif
                            </div> <!-- form-group -->
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                    </div>
                </div>

                <div class="row" style="margin-top: 20px;">
                    <p class="p-title-small-blue">{{ strtoupper(trans('deal.label_enduser_info')) }}</p> 
                    <div class="col-xs-12 col-sm-4 col-md-4">                 
                        <div class="form-group" id="div_sendemail">
                            <input id="sendemail" type="checkbox" name="sendemail"> Send Email to Customer
                        </div>
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
                                    CANCEL
                                </button>
                            </div>

                        </div>
                    </div>
                </div>              

            </div> <!-- container -->

        </form>

    </div>  

    <script type="text/javascript">

        $(document).ready(function(){

            $('#left_menu_item_2').attr('class', 'active');

            //
            var s = $('#opportunity_product').val();
            if (s) {
                var node = $('#opportunity_product_select');
                node.empty();

                var dataArray = s.split(",");
                for (var i=0; i<dataArray.length; i++) {
                    node.append("<option value='" + dataArray[i]+ "' selected>" + dataArray[i] + "</option>");   
                }

                var str = s.replace(/,/, "<br><br>")
                $('#opportunity_product_select').popover({
                    trigger: 'focus',
                    placement: 'bottom',
                    html: 'true',   
                    content: str, 
                    animation: false  
                });              
            }

            changeStatus();

        });


        function changeStatus() {

            var oppStatus = $('#opportunity_status').val();
            if (oppStatus == '3') {
                $('#div_opportunity_rejection_code').css('display', '');
            } else {
                $('#div_opportunity_rejection_code').css('display', 'none');
            }
        }

        function cancelFunc() {
            window.location.href = "{{ url('admin/macids') }}" + '?page=' + $('#page').val();            
        }

    </script>    
</div>
@endsection
