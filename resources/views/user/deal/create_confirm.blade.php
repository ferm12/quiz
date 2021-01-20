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

    <div id="div_deal_create_confirm_background">

        <center>
            <div id="div_deal_create_confirm_content">

                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p class="p-title-big" style="text-align: center;">{{ trans('deal.str_deal_confirmation_title') }}</p>

                <p>&nbsp;</p>
                {!! str_replace('%1', isset($username)?$username:'', trans('deal.str_deal_confirmation_description')) !!}

                <p>&nbsp;</p>
                <p style='font-weight: bold;'>{{ strtoupper(trans('deal.str_deal_confirmation_summary')) }}</p>

                <table class="table table-no-border">
                    <tr>
                        <td width='210px;'>{{ trans('deal.label_opportunity_shortname') }} : </td>
                        <td>
                            {{ isset($deal['opportunity_name']) ? $deal['opportunity_name'] : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>{{ trans('deal.label_opportunity_submit_date') }} : </td>
                        <td>
                            {{ isset($deal['opportunity_submit_date']) ? $deal['opportunity_submit_date'] : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td valign='top'>{{ trans('deal.label_product_summary') }} : </td>
                        <td>
                            {!! isset($deal['opportunity_product']) ? str_replace(',', '<br>', $deal['opportunity_product']) : '' !!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{ trans('deal.label_opportunity_date') }} : </td>
                        <td>
                            {{ isset($deal['opportunity_date']) ? $deal['opportunity_date'] : '' }}
                        </td>
                    </tr>  
                    <tr>
                        <td>{{ trans('deal.label_aei_account_manager') }} :</td>
                        <td>
                            {{ isset($deal['opportunity_account_manager']) ? $deal['opportunity_account_manager'] : '' }}
                        </td>
                    </tr>                     
                </table>

                <p><strong>{{ trans('deal.label_reseller_info') }}</strong></p>
                <table class="table table-no-border">
                    <tr>
                        <td width='210px;'>{{ trans('customer.label_company_shortname') }} : </td>
                        <td>
                            {{ isset($deal['reseller_company']) ? $deal['reseller_company'] : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>{{ trans('deal.label_sales_contact') }} : </td>
                        <td>
                            {{ isset($deal['reseller_contact']) ? $deal['reseller_contact'] : '' }}
                        </td>
                    </tr>                     
                    <tr>
                        <td>{{ trans('customer.label_phone') }} : </td>
                        <td>
                            {{ isset($deal['reseller_phone']) ? $deal['reseller_phone'] : '' }}
                        </td>
                    </tr>                    
                    <tr>
                        <td>{{ trans('customer.label_email') }} : </td>
                        <td>
                            {{ isset($deal['reseller_email']) ? $deal['reseller_email'] : '' }}
                        </td>
                    </tr>                                         
                </table> 

                <p><strong>{{ trans('deal.label_distributor_info') }}</strong></p>
                <table class="table table-no-border">
                    <tr>
                        <td width='210px;'>{{ trans('deal.label_preferred_distributor') }} :</td>
                        <td>
                            {{ isset($deal['distributor_preferred']) ? $deal['distributor_preferred'] : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>{{ trans('deal.label_sales_contact_distributor') }} :</td>
                        <td>
                            {{ (isset($deal['distributor_contact_firstname']) ? $deal['distributor_contact_firstname'] : '') . ' ' . (isset($deal['distributor_contact_lastname']) ? $deal['distributor_contact_lastname'] : '') }} 
                        </td>
                    </tr>
                    <tr>
                        <td>{{ trans('customer.label_phone') }} :</td>
                        <td>
                            {{ isset($deal['distributor_phone']) ? $deal['distributor_phone'] : '' }}
                        </td>
                    </tr>
                     <tr>
                        <td>{{ trans('customer.label_email') }} :</td>
                        <td>
                            {{ isset($deal['distributor_email']) ? $deal['distributor_email'] : '' }}
                        </td>
                    </tr>
                </table>

                <p><strong>{{ trans('deal.label_enduser_info') }}</strong></p>
                <table class="table table-no-border">
                    <tr>
                        <td width='210px;'>{{ trans('customer.label_company_shortname') }} : </td>
                        <td>
                            {{ isset($deal['customer_company']) ? $deal['customer_company'] : '' }}
                        </td>
                        <td width='210px;'>{{ trans('deal.label_sales_contact') }}: </td>
                        <td>
                            {{ isset($deal['customer_contact']) ? $deal['customer_contact'] : '' }}
                        </td>
                    </tr> 
                    <tr>
                        <td>{{ trans('customer.label_address') }} : </td>
                        <td>
                            {{ isset($deal['customer_address']) ? $deal['customer_address'] : '' }}
                        </td>
                        <td>{{ trans('customer.label_phone') }} : </td>
                        <td>
                            {{ isset($deal['customer_phone']) ? $deal['customer_phone'] : '' }}
                        </td>           
                    </tr> 
                    <tr>
                        <td>{{ trans('customer.label_city') }} : </td>
                        <td>
                            {{ isset($deal['customer_city']) ? $deal['customer_city'] : '' }}
                        </td>
                        <td>{{ trans('customer.label_email') }} : </td>
                        <td>
                            {{ isset($deal['customer_email']) ? $deal['customer_email'] : '' }}
                        </td>            
                    </tr> 
                    <tr>
                        <td>{{ trans('customer.label_province') }} : </td>
                        <td>
                            {{ isset($deal['customer_province']) ? $deal['customer_province'] : '' }}
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>            
                    </tr> 
                    <tr>
                        <td>{{ trans('customer.label_postal_code') }} : </td>
                        <td>
                            {{ isset($deal['customer_postal_code']) ? $deal['customer_postal_code'] : '' }}
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>            
                    </tr> 
                    <tr>
                        <td>{{ trans('customer.label_country') }} : </td>
                        <td>
                            {{ isset($deal['customer_country']) ? $deal['customer_country'] : '' }}
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>          
                    </tr>            
                </table>

                <p>&nbsp;</p>              
                {!! trans('deal.str_deal_confirmation_emailto') !!}

            </div>
        </center>

        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
    </div>
    
</div>
@endsection
