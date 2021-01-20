@extends('layouts.admin')

@section('page-header')
    <h1>
        Mac IDs
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('common.label_home') }} </a></li>
        <li class="active">{{ trans('admin.title_deals') }}</li>
    </ol>
@endsection

@section('content')
<div class="content container-fluid">
    <div class="row">

        @if (isset($successMsg))
            <div class="alert alert-success" role="alert">{{ $successMsg }}</div>
            <p>&nbsp;</p>
        @endif

        @if (isset($errorMsg))
            <div class="alert alert-danger" role="alert">{{ $errorMsg }}</div>
            <p>&nbsp;</p>
        @endif  


        <div style="width: 100%">
            <p class="text-right">
                <button type="button" class="btn btn-default btn-sm" onclick="javascript: resetFunc();" style="margin-right: 10px;">{{ strtoupper(trans('common.btn_reset')) }}</button>                
                <button type="button" class="btn btn-default btn-sm" onclick="javascript: searchFunc();">{{ strtoupper(trans('common.btn_search')) }}</button>
            </p>                  
            <p>
                @if (isset($mac_ids) && count($mac_ids) > 0)
                    <p style="margin-left: 5px;">
                        {{ str_replace('%3', $mac_ids->total(), str_replace('%2', $mac_ids->lastPage(), str_replace('%1', $mac_ids->total()>0?$mac_ids->currentPage():'0', trans('common.str_paginate_title')))) }}
                        <button type="button" class="btn btn-default btn-sm" onclick="javascript: exportFunc();" style="margin-left: 10px;">{{ trans('common.btn_export_to_csv') }}</button>
                    </p>
                @else
                     <p>&nbsp;</p>
                @endif              
            </p>
        </div>
   
        <div class="table-responsive" style="font-size: 11px;">
            <table class="table table-bordered table-striped table-hover text-nowrap">
                <tr>
                    <td class="table-header-title-fixed">{{ trans('common.label_operation') }}</td>

                    <td class="table-header-title-fixed">Id</td>
                    <td class="table-header-title-fixed">User id</td>
                    <td class="table-header-title-fixed">Sn</td>
                    <td class="table-header-title-fixed">Mac ID</td>
                    <td class="table-header-title-fixed">Purchased from</td>
                    <td class="table-header-title-fixed">Taken</td>
                    <td class="table-header-title-fixed">License number</td>
                    <td class="table-header-title-fixed">Activation key</td>
                    <td class="table-header-title-fixed">Created Time</td>
                    
                </tr>

                @if (isset($mac_ids) && count($mac_ids) > 0)

                    <form class="form-horizontal" role="form" method="POST" id="search_form" action="{{ url('admin/macids') }}">
                        
                        {{ csrf_field() }}

                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center">
                                <input type="text" id="search_user_id" name="search_user_id" style="width:100%;" onKeydown="javascript: keydownFunc(event);"
                                    @if (isset($searchArray['search_user_id']))
                                         value="{{ $searchArray['search_user_id'] }}"
                                    @endif                                  
                                >
                            </td>
                            <td class="text-center">
                                <input type="text" id="search_sn" name="search_sn" style="width:100%;" onKeydown="javascript: keydownFunc(event);"
                                    @if (isset($searchArray['search_sn']))
                                         value="{{ $searchArray['search_sn'] }}"
                                    @endif                                   
                                >
                            </td>
                            <td class="text-center">
                                <input type="text" id="search_mac_id" name="search_mac_id" style="width:100%;" onKeydown="javascript: keydownFunc(event);"
                                    @if (isset($searchArray['search_mac_id']))
                                         value="{{ $searchArray['search_mac_id'] }}"
                                    @endif 
                                >
                            </td>
                            <td class="text-center">
                                <input type="text" id="search_purchased_from" name="search_purchased_from" style="width:100%;" onKeydown="javascript: keydownFunc(event);"
                                    @if (isset($searchArray['search_purchased_from']))
                                         value="{{ $searchArray['search_purchased_from'] }}"
                                    @endif                                 
                                >
                            </td>                           
                            <td class="text-center">
                                <input type="text" id="search_taken" name="search_taken" style="width:100%;" onKeydown="javascript: keydownFunc(event);"
                                    @if (isset($searchArray['search_taken']))
                                         value="{{ $searchArray['search_taken'] }}"
                                    @endif 
                                >
                            </td>
                            <td class="text-center">
                                <input type="text" id="search_license_number" name="search_license_number" style="width:100%;" onKeydown="javascript: keydownFunc(event);"
                                    @if (isset($searchArray['search_license_number']))
                                         value="{{ $searchArray['search_license_number'] }}"
                                    @endif 
                                >
                            </td>
                            <td class="text-center">
                                <input type="text" id="search_activation_key" name="search_activation_key" style="width:100%;" onKeydown="javascript: keydownFunc(event);"
                                    @if (isset($searchArray['search_activation_key']))
                                         value="{{ $searchArray['search_activation_key'] }}"
                                    @endif 
                                >
                            </td>
                            <td class="text-center">
                                <input type="text" id="search_created_date" name="search_created_date" style="width:100%;" onKeydown="javascript: keydownFunc(event);"
                                    @if (isset($searchArray['search_created_date']))
                                         value="{{ $searchArray['search_created_date'] }}"
                                    @endif 
                                >
                            </td>

                        </tr>
                    </form>

                    @foreach ($mac_ids as $row)
                        <tr>
                            <td class="text-center">
                                <a href="javascript: modifyFunc('{{ $row->id }}', '{{ $mac_ids->currentPage() }}');" style="margin-right: 5px; text-decoration: underline;">{{ trans('common.btn_modify') }}</a>                
                                <a href="javascript: deleteFunc('{{ $row->id }}', '{{ $mac_ids->currentPage() }}');" style="text-decoration: underline;">{{ trans('common.btn_delete') }}</a>
                            </td>
                            <td class="text-center">{{ $row->id }}</td>                           
                            <td class="text-center">{{ $row->user_id }}</td>
                            <td class="text-center">{{ $row->sn }}</td>
                            <td class="text-center">{{ $row->mac_id }}</td>
                            <td class="text-center">{{ $row->purchased_from }}</td>
                            <td class="text-center">{{ $row->taken }}</td>
                            <td class="text-center">{{ $row->license_number }}</td>
                            <td class="text-center">{{ $row->activation_key}}</td>
                            <td class="text-center">{!! str_replace(' ', '<br>', $row->created_at) !!}</td>
                        </tr>
                    @endforeach

                @else

                    <tr>
                        <td colspan="13">{{ trans('common.str_no_record') }}</td>
                    </tr>
                    
                @endif

            </table>
        </div>  

        <div style="text-align: right;">

            @if (isset($mac_ids) && count($mac_ids) > 0)
                @if (isset($search) && !empty($search))

                    {!! $mac_ids->appends(['search' => $search])->links() !!}

                @else

                    {!! $mac_ids->links() !!}

                @endif                    
            @endif

        </div>

    </div>
    <script type="text/javascript">

        $(document).ready(function(){

            $('#left_menu_item_2').attr('class', 'active');
            $('[data-toggle="popover"]').popover({'html': true});

        });

        function modifyFunc(id, page) {
            window.location.href = "{{ url('admin/macids/modify') }}" + "/" + id + "/" + page;
        }

        function deleteFunc(id, page) {
            var msg = "{{ trans('common.info.confirm_delete_item_by_id') }}";
            msg = msg.replace(/%1/, id);
            if (!confirm(msg)) {
                return;
            } 

            window.location.href = "{{ url('admin/macids/delete') }}" + "/" + id + "/" + page;
        }

        function resetFunc() {
            window.location.href = "{{ url('admin/macids') }}";
        }

        function searchFunc() {
            if (window.search_form) {
                window.search_form.submit();
            }
        }

        function keydownFunc(e) {

            if (e.keyCode == 13)
                searchFunc();
        }

        function exportFunc() {
            var url = "{{ url('admin/mac_ids/export/csv') }}";
            url += "?search_user_id=" + $('#search_user_id').val();
            url += "&search_sn=" + $('#search_sn').val();
            url += "&search_mac_id=" + $('#search_mac_id').val();
            url += "&search_purchased_from=" + $('#search_purchased_from').val();
            url += "&search_taken=" + $('#search_taken').val();
            url += "&search_license_number=" + $('#search_license_number').val();
            url += "&search_activation_key=" + $('#search_activation_key').val();
            url += "&search_created_date=" + $('#search_created_date').val();

            window.open(encodeURI(url));
        }

    </script>
</div>
@endsection
