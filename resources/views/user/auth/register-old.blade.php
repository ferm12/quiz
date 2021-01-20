@extends('layouts.app')

@section('top-nav')

    @include('layouts.templates.top-nav')

@endsection

@section('content')
<div class="content container">

    <form class="form-horizontal" role="form" method="POST" action="{{ url('user/register') }}">

        {{ csrf_field() }}
       
        <div class="row">
            <div style="margin-left: 15px;">
                <p class="p-title-big">{{ strtoupper(trans('customer.label_become_partner')) }}</p>

                @if (isset($successMsg))
                    <div class="alert alert-success" role="alert" style="width: 100%;">{{ $successMsg }}</div>
                @endif
                @if (isset($errorMsg))
                    <div class="alert alert-danger" role="alert" style="width: 100%;">{{ $errorMsg }}</div>
                @endif
            </div>
            <div style="margin-left: 30px; margin-top: 30px;">
                <p class="p-title-medium-blue">{{ trans('customer.label_apply_to') }}</p>
                <p class="p-description-medium-blue">{{ trans('customer.label_apply_to_description') }}</p>

                <p>&nbsp;</p>

                <div class="container">
                    <div class="row">
                        <p class="p-title-small-blue">{{ strtoupper(trans('customer.label_primary_contact')) }}</p> 
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div style="width: 80%;">
                                <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                                    <label for="firstname"><span class="span-required-red">*</span>{{ trans('customer.label_firstname') }}</label>
                                    <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname') }}">

                                    @if ($errors->has('firstname'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('firstname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                                    <label for="lastname"><span class="span-required-red">*</span>{{ trans('customer.label_lastname') }}</label>
                                    <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}">

                                    @if ($errors->has('lastname'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('lastname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email"><span class="span-required-red">*</span>{{ trans('customer.label_email') }}</label>
                                    <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div style="width: 80%;">
                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <label for="phone"><span class="span-required-red">*</span>{{ trans('customer.label_phone') }}</label>
                                    <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}">

                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('job_title') ? ' has-error' : '' }}">
                                    <label for="job_title"><span class="span-required-red">*</span>{{ trans('customer.label_job_title') }}</label>
                                    <input id="job_title" type="text" class="form-control" name="job_title" value="{{ old('job_title') }}">

                                    @if ($errors->has('job_title'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('job_title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4">
                        </div>
                    </div>

                    <p>&nbsp;</p>

                    <div class="row">
                        <p class="p-title-small-blue">{{ strtoupper(trans('customer.label_company_info')) }}</p> 
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div style="width: 80%;">
                                <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                                    <label for="company"><span class="span-required-red">*</span>{{ trans('customer.label_company') }}</label>
                                    <input id="company" type="text" class="form-control" name="company" value="{{ old('company') }}">

                                    @if ($errors->has('company'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('company') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                    <label for="address"><span class="span-required-red">*</span>{{ trans('customer.label_address') }}</label>
                                    <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}">

                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                    <label for="city"><span class="span-required-red">*</span>{{ trans('customer.label_city') }}</label>
                                    <input id="city" type="text" class="form-control" name="city" value="{{ old('city') }}">

                                    @if ($errors->has('city'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ ($errors->has('province_id') || $errors->has('province')) ? ' has-error' : '' }}">
                                    <label for="province"><span class="span-required-red">*</span>{{ trans('customer.label_province') }}</label>
                                    <input id="province" type="text" class="form-control" name="province" value="{{ old('province') }}">
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
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div style="width: 80%;">
                                <div class="form-group{{ $errors->has('postal_code') ? ' has-error' : '' }}">
                                    <label for="postal_code"><span class="span-required-red">*</span>{{ trans('customer.label_postal_code') }}</label>
                                    <input id="postal_code" type="text" class="form-control" name="postal_code" value="{{ old('postal_code') }}">

                                    @if ($errors->has('postal_code'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('postal_code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                    <label for="country"><span class="span-required-red">*</span>{{ trans('customer.label_country') }}</label>
                                    <select id="country" name="country" style="width: 100%; height: 30px;" value="">
                                        <option value=""></option>

                                        @if (isset($param['countries']))
                                            @foreach ($param['countries'] as $k => $v)
                                                @if (!empty(old('country')) && $k == old('country'))
                                                    <option value="{{ $k }}" selected>{{ $v }}</option>
                                                @else
                                                    <option value="{{ $k }}">{{ $v }}</option>
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
                                 <div class="form-group{{ $errors->has('referred_person') ? ' has-error' : '' }}">
                                    <label for="referred_person"><span class="span-required-red">*</span>{{ trans('customer.label_referred_person') }}</label>
                                    <input id="referred_person" type="text" class="form-control" name="referred_person" value="{{ old('referred_person') }}">

                                    @if ($errors->has('referred_person'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('referred_person') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('partner_type') ? ' has-error' : '' }}">
                                    <label for="partner_type"><span class="span-required-red">*</span>{{ trans('customer.label_partner_type') }}</label>
                                    <select id="partner_type" name="partner_type" style="width: 100%; height: 30px;" value="">
                                        <option value=""></option>

                                        @if (isset($param['partners']))
                                            @foreach ($param['partners'] as $k => $v)
                                                @if (!empty(old('partner_type')) && $k == old('partner_type'))
                                                    <option value="{{ $k }}" selected>{{ $v }}</option>
                                                @else
                                                    <option value="{{ $k }}">{{ $v }}</option>
                                                @endif
                                            @endforeach
                                        @endif

                                    </select>
                                    @if ($errors->has('partner_type'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('partner_type') }}</strong>
                                        </span>
                                    @endif
                                </div>                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4">
                        </div>
                    </div>
                </div>
            </div>      
        </div>

        <p>&nbsp;</p>
        <hr class="hr-solid-thin">

        <div class="row">
            <div style="margin-left: 30px;">
                 <div class="col-xs-12 col-sm-4 col-md-4">
                    <div style="width: 80%;">
                        <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                            <label for="captcha"><span class="span-required-red">*</span>{{ trans('customer.label_captcha') }}</label>
                            <input type="text" id="captcha" name="captcha" class="form-control" placeholder="{{ trans('customer.label_captcha_notice') }}">

                            <img src="{{ url('user/captcha/create') }}"
                                 onclick="this.src='{{ url('user/captcha/create') }}?r='+Math.random();" 
                                 alt="" title="{{ trans('customer.label_captcha_tips') }}" class="img-captcha-small">

                            <p style="margin-top: 3px;">{{ trans('customer.label_captcha_tips') }}</p>

                            @if ($errors->has('captcha'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('captcha') }}</strong>
                                </span>
                            @endif
                        </div>

                        <p>&nbsp;</p>

                        <div class="form-group">
                            <label><span class="span-required-red">*{{ trans('customer.label_required_fields') }}</span></label><br>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-arrow-right"></i> {{ strtoupper(trans('common.btn_apply')) }}
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

    <script type="text/javascript">

        @if (isset($param['provinces']))
            var regions = {!! $param['provinces'] !!};
        @else
            var regions = '';
        @endif

        $(document).ready(function(){

            @if (old('province_id') != '')

                changeRegin("{{ old('province_id') }}");

            @endif


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
            window.location.href = "{{ url('user/login') }}";            
        }

    </script>

</div>
@endsection
