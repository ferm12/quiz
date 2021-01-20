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
       
    <div class="row">
        <div style="margin-left: 15px;">
            <p class="p-title-big">{{ strtoupper(trans('deal.label_view_deal')) }}</p>

            @if (isset($successMsg))
                <div class="alert alert-success" role="alert" style="width: 100%;">{{ $successMsg }}</div>
            @endif
            @if (isset($errorMsg))
                <div class="alert alert-danger" role="alert" style="width: 100%;">{{ $errorMsg }}</div>
            @endif
        </div>

        <div class="table-responsive" style="margin-left: 20px; margin-top: 20px;">

            <table class="table table-no-border">
                 <tr>
                    <td colspan="2" class="p-title-small-blue">{{ strtoupper(trans('deal.label_reseller_info')) }}</td>
                </tr>               
                <tr>
                    <td width="200"><strong>{{ trans('customer.label_company_shortname') }}</strong>:</td>
                    <td>{{ $deal->reseller_company }}</td>
                </tr>
                <tr>
                    <td><strong>{{ trans('customer.label_phone') }}</strong>:</td>
                    <td>{{ $deal->reseller_phone }}</td>
                </tr>
                <tr>
                    <td><strong>{{ trans('customer.label_email') }}</strong>:</td>
                    <td>{{ $deal->reseller_email }}</td>
                </tr>            
                <tr>
                    <td><strong>{{ trans('deal.label_sales_contact') }}</strong>:</td>
                    <td>{{ $deal->reseller_contact }}</td>
                </tr>
                <tr>
                    <td><strong>{{ trans('deal.str_opportunity_name') }}</strong>:</td>
                    <td>{{ $deal->opportunity_name }}</td>
                </tr>
                <tr>
                    <td><strong>{{ trans('deal.label_opportunity_date') }}</strong>:</td>
                    <td>{{ !empty($deal->opportunity_date) ? date_format(date_create($deal->opportunity_date), 'Y-m-d') : '' }}</td>
                </tr>
                <tr>
                    <td><strong>{{ trans('deal.label_aei_account_manager') }}</strong>:</td>
                    <td>{{ getAccountManagerById($deal->opportunity_account_manager) }}</td>
                </tr> 
                <tr>
                    <td><strong>{{ trans('deal.label_product_quantity') }}</strong>:</td>
                    <td>{!! str_replace(',', "<br/>", $deal->opportunity_product) !!}</td>
                </tr>                          
            </table>

            <hr class="hr-solid-thin">

            <table class="table table-no-border">
                 <tr>
                    <td colspan="2" class="p-title-small-blue">{{ strtoupper(trans('deal.label_distributor_info')) }}</td>
                </tr>               
                <tr>
                    <td width="200"><strong>{{ trans('deal.label_preferred_distributor') }}</strong>:</td>
                    <td>{{ getDistributorById($deal->distributor_preferred) }}</td>
                </tr>
                <tr>
                    <td><strong>{{ trans('deal.label_sales_contact_distributor') }}</strong>:</td>
                    <td>{{ $deal->distributor_contact_firstname . ' ' . $deal->distributor_contact_lastname }}</td>
                </tr>
                <tr>
                    <td><strong>{{ trans('customer.label_phone') }}</strong>:</td>
                    <td>{{ $deal->distributor_phone }}</td>
                </tr> 
                <tr>
                    <td><strong>{{ trans('customer.label_email') }}</strong>:</td>
                    <td>{{ $deal->distributor_email }}</td>
                </tr> 
            </table>

            <hr class="hr-solid-thin">

            <table class="table table-no-border">
                 <tr>
                    <td colspan="2" class="p-title-small-blue">{{ strtoupper(trans('deal.label_enduser_info')) }}</td>
                </tr>   
                <tr>
                    <td width="200"><strong>{{ trans('customer.label_company_shortname') }}</strong>:</td>
                    <td>{{ $deal->customer_company }}</td>
                </tr> 
                <tr>
                    <td><strong>{{ trans('deal.label_contact_name') }}</strong>:</td>
                    <td>{{ $deal->customer_contact }}</td>
                </tr> 
                <tr>
                    <td><strong>{{ trans('customer.label_phone') }}</strong>:</td>
                    <td>{{ $deal->customer_phone }}</td>
                </tr> 
                <tr>
                    <td><strong>{{ trans('customer.label_email') }}</strong>:</td>
                    <td>{{ $deal->customer_email }}</td>
                </tr>
                <tr>
                    <td><strong>{{ trans('customer.label_address') }}</strong>:</td>
                    <td>{{ $deal->customer_address }}</td>
                </tr>
                <tr>
                    <td><strong>{{ trans('customer.label_city') }}</strong>:</td>
                    <td>{{ $deal->customer_city }}</td>
                </tr>                
                <tr>
                    <td><strong>{{ trans('customer.label_province') }}</strong>:</td>
                    <td>{{ (empty($deal->customer_province)) ? getRegionById($deal->customer_country, $deal->customer_province_id) : $deal->customer_province }}</td>
                </tr>
                <tr>
                    <td><strong>{{ trans('customer.label_postal_code') }}</strong>:</td>
                    <td>{{ $deal->customer_postal_code }}</td>
                </tr>
                <tr>
                    <td><strong>{{ trans('customer.label_country') }}</strong>:</td>
                    <td>{{ getCountryById($deal->customer_country) }}</td>
                </tr>
            </table>

        </div>      
    </div>

    <p>&nbsp;</p>

    <p style="margin-left: 10px;">
        <button type="button" class="btn btn-default" onClick="javascript: backFunc();">
            {{ strtoupper(trans('common.btn_back')) }}
        </button>
    </p>

    <script type="text/javascript">

        function backFunc() {
            window.location.href = "{{ url('user/deal') }}";            
        }

    </script>
    
</div>
@endsection
