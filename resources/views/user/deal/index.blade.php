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
    <div class="row">

        @if (isset($successMsg))
            <div class="alert alert-success" role="alert" style="width: 100%;">{{ $successMsg }}</div>
            <p>&nbsp;</p>
        @endif

        @if (isset($errorMsg))
            <div class="alert alert-danger" role="alert" style="width: 100%;">{{ $errorMsg }}</div>
            <p>&nbsp;</p>
        @endif

        <p>&nbsp;</p>
        
        <div class="container">
            <p class="p-title-big">{{ strtoupper(trans('deal.label_my_deals')) }}</p>

            <p class="text-center"><button type="button" class="btn btn-default btn-sm" onclick="javascript: addDeal();">{{ strtoupper(trans('deal.btn_create_deal')) }}</button></p>                  
            <p>
                @if (isset($deals) && count($deals) > 0)
                    <p style="margin-left: 5px;">{{ str_replace('%3', $deals->total(), str_replace('%2', $deals->lastPage(), str_replace('%1', $deals->total()>0?$deals->currentPage():'0', trans('common.str_paginate_title')))) }}</p>
                @else
                    <p>&nbsp;</p>
                @endif             
            </p>
        </div>

        <div class="table-responsive" style="min-height: 420px; padding-left: 15px; padding-right: 15px;">
            <table class="table table-bordered table-striped table-hover text-nowrap">
                <tr>
                    <td class="table-header-title">{{ trans('customer.label_id') }}</td>
                    <td class="table-header-title">{{ trans('deal.label_deal_number') }}</td>
                    <td class="table-header-title">{{ trans('deal.label_product_quantity') }}</td>
                    <td class="table-header-title">{{ trans('deal.label_end_customer') }}</td>
                    <td class="table-header-title">{{ trans('common.label_create_time') }}</td>
                    <td class="table-header-title">{{ trans('common.label_expired_time') }}</td>
                    <td class="table-header-title">{{ trans('common.label_status') }}</td>
                </tr>

            @if (isset($deals) && count($deals) > 0)

                @foreach ($deals as $row)
                    <tr style="cursor: pointer;" onClick="javascript: viewDeal('{{ $row->id }}', '{{ $deals->currentPage() }}');">
                        <td class="text-center">{{ $row->id }}</td>
                        <td class="text-center">{{ ($row->opportunity_status=='2'?$row->opportunity_id:"&nbsp;") }}</td>
                        <td class="text-left">{!! str_replace(',', "<br/>", $row->opportunity_product) !!}</td>
                        <td class="text-center">{{ $row->customer_contact }}</td>
                        <td class="text-center">{{ !empty($row->created_at) ? date_format(date_create($row->created_at), 'Y-m-d') : '' }}</td> 
                        <td class="text-center">{{ !empty($row->created_at) ? date_format(date_add(date_create($row->created_at), date_interval_create_from_date_string('120 days')), 'Y-m-d') : '' }}</td>
                        <td class="text-center">{{ getDealStatusById($row->opportunity_status) }}</td>
                    </tr>
                @endforeach

            @else

                <tr>
                    <td colspan="7">{{ trans('common.str_no_record') }}</td>
                </tr>
                
            @endif

            </table>

            <div style="text-align: right;">

                @if (isset($deals) && count($deals) > 0)
                    @if (isset($search) && !empty($search))

                        {!! $deals->appends(['search' => $search])->links() !!}

                    @else

                        {!! $deals->links() !!}

                    @endif                    
                @endif

            </div>

        </div> 
    </div>

    <script type="text/javascript">

        function addDeal() {
            window.location.href = "{{ url('user/deal/create') }}";            
        }

        function viewDeal(id, page) {           
            window.location.href = "{{ url('user/deal/view') }}" + "/" + id + "/" + page;     
        }

    </script>
    
</div>
@endsection
