@extends('layouts.admin')

@section('page-header')
    <h1>
        {{ trans('admin.title_customers') }}
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('common.label_home') }} </a></li>
        <li class="active">{{ trans('admin.title_customers') }}</li>
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

        @if (isset($soracoMsg))
            <div class="alert alert-danger" role="alert">{{ $soracoMsg }}</div>
            <p>&nbsp;</p>
        @endif  

        <div style="width: 100%">
            <p class="text-right">
                <button type="button" class="btn btn-default btn-sm" onclick="javascript: resetFunc();" style="margin-right: 10px;">{{ strtoupper(trans('common.btn_reset')) }}</button>                
                <button type="button" class="btn btn-default btn-sm" onclick="javascript: searchFunc();">{{ strtoupper(trans('common.btn_search')) }}</button>
            </p>                  
            <p>
                @if (isset($customers) && count($customers) > 0)
                    <p style="margin-left: 5px;">
                        {{ str_replace('%3', $customers->total(), str_replace('%2', $customers->lastPage(), str_replace('%1', $customers->total()>0?$customers->currentPage():'0', trans('common.str_paginate_title')))) }}
                        <!-- <button type="button" class="btn btn&#45;default btn&#45;sm" onclick="javascript: exportFunc();" style="margin&#45;left: 10px;">{{ trans('common.btn_export_to_csv') }}</button> -->
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
                    <td style="width: 32px; text-align: center; font-weight: bold;">{{ trans('customer.label_id') }}</td>
                    <td class="table-header-title-fixed">First Name</td>
                    <td class="table-header-title-fixed">Last Name</td>
                    <td class="table-header-title-fixed">Email</td>
                    <td class="table-header-title-fixed">Phone</td>
                    <td class="table-header-title-fixed">Organization Name</td>
                    <td class="table-header-title-fixed">Address</td>
                    <td class="table-header-title-fixed">City</td>
                    <td class="table-header-title-fixed">State</td>
                    <td class="table-header-title-fixed">Zip Code</td>
                    <td class="table-header-title-fixed">Country</td>
                    <td class="table-header-title-fixed">Purchased From</td>
                    <td class="table-header-title-fixed">License Key</td>
                    <td class="table-header-title-fixed">Created Date</td>
                </tr>

                @if (isset($customers) && count($customers) > 0)

                    <form class="form-horizontal" role="form" method="POST" id="search_form" action="{{ url('admin/customers') }}">
                        
                        {{ csrf_field() }}

                        <tr>
                            <td></td>                            
                            <td></td>
                            <td class="text-center">
                                <input type="text" id="search_first_name" name="search_first_name" style="width:100%;" onKeydown="javascript: keydownFunc(event);"
                                    @if (isset($searchArray['search_first_name']))
                                         value="{{ $searchArray['search_first_name'] }}"
                                    @endif                                  
                                >
                            </td>
                            <td class="text-center">
                                <input type="text" id="search_last_name" name="search_last_name" style="width:100%;" onKeydown="javascript: keydownFunc(event);"
                                    @if (isset($searchArray['search_last_name']))
                                         value="{{ $searchArray['search_last_name'] }}"
                                    @endif                                   
                                >
                            </td>
                            <td class="text-center">
                                <input type="text" id="search_email" name="search_email" style="width:100%;" onKeydown="javascript: keydownFunc(event);"
                                    @if (isset($searchArray['search_email']))
                                         value="{{ $searchArray['search_email'] }}"
                                    @endif 
                                >
                            </td>
                            <td class="text-center">
                                <input type="text" id="search_phone" name="search_phone" style="width:100%;" onKeydown="javascript: keydownFunc(event);"
                                    @if (isset($searchArray['search_phone']))
                                         value="{{ $searchArray['search_phone'] }}"
                                    @endif 
                                >
                            </td>
                            <td class="text-center">
                                <input type="text" id="search_organization_name" name="search_organization_name" style="width:100%;" onKeydown="javascript: keydownFunc(event);"
                                    @if (isset($searchArray['search_organization_name']))
                                         value="{{ $searchArray['search_organization_name'] }}"
                                    @endif                                 
                                >
                            </td>
                            <td class="text-center">
                                <input type="text" id="search_address" name="search_address" style="width:100%;" onKeydown="javascript: keydownFunc(event);"
                                    @if (isset($searchArray['search_address']))
                                         value="{{ $searchArray['search_address'] }}"
                                    @endif                                  
                                >
                            </td>

                            <td class="text-center">
                                <input type="text" id="search_city" name="search_city" style="width:100%;" onKeydown="javascript: keydownFunc(event);"
                                    @if (isset($searchArray['search_city']))
                                         value="{{ $searchArray['search_city'] }}"
                                    @endif                                  
                                >
                            </td>
                            <td class="text-center">
                                <input type="text" id="search_state" name="search_state" style="width:100%;" onKeydown="javascript: keydownFunc(event);"
                                    @if (isset($searchArray['search_state']))
                                         value="{{ $searchArray['search_state'] }}"
                                    @endif                                  
                                >
                            </td>

                            <td class="text-center">
                                <input type="text" id="search_zip_code" name="search_zip_code" style="width:100%;" onKeydown="javascript: keydownFunc(event);"
                                    @if (isset($searchArray['search_zip_code']))
                                         value="{{ $searchArray['search_zip_code'] }}"
                                    @endif                                   
                                >
                            </td>
                            <td class="text-center">
                                <input type="text" id="search_country" name="search_country" style="width:100%;" onKeydown="javascript: keydownFunc(event);"
                                    @if (isset($searchArray['search_country']))
                                         value="{{ $searchArray['search_country'] }}"
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
                                <input type="text" id="search_license_key" name="search_license_key" style="width:100%;" onKeydown="javascript: keydownFunc(event);"
                                    @if (isset($searchArray['search_license_key']))
                                         value="{{ $searchArray['search_license_key'] }}"
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

                    @foreach ($customers as $row) 
                        <tr>
                            <td class="text-center">
                                <a href="javascript: modifyFunc('{{ $row->id }}', '{{ $customers->currentPage() }}');" style="margin-right: 5px; text-decoration: underline;">{{ trans('common.btn_modify') }}</a>                
                                <a href="javascript: deleteFunc('{{ $row->id }}', '{{ $customers->currentPage() }}');" style="text-decoration: underline;">{{ trans('common.btn_delete') }}</a>
                            </td>                            
                            <td class="text-center">{{ $row->id }}</td>
                            <td class="text-center">{{ $row->first_name }}</td>
                            <td class="text-center">{{ $row->last_name }}</td>
                            <td class="text-center">{{ $row->email }}</td>
                            <td class="text-center">{{ $row->phone }}</td>
                            <td class="text-center">{{ $row->organization_name }}</td>
                            <td class="text-center">{{ $row->address }} </td>
                            <td class="text-center">{{ $row->city }}</td>
                            <td class="text-center">{{ $row->state }}</td>
                            <td class="text-center">{{ $row->zip_code }}</td>
                            <td class="text-center">{{ $row->country }}</td>
                            <td class="text-center">{{ $row->purchased_from }}</td>
                            <td class="text-center">{{ $row->license_key }}</td>
                            <td class="text-center">{!! str_replace(' ', '<br>', $row->created_at) !!}</td>
                        </tr>
                    @endforeach

                @else

                    <tr>
                        <td colspan="12">{{ trans('common.str_no_record') }}</td>
                    </tr>                    
                    
                @endif

            </table>
        </div>  

        <div style="text-align: right;">

            @if (isset($customers) && count($customers) > 0)
                @if (isset($search) && !empty($search))

                    {!! $customers->appends(['search' => $search])->links() !!}

                @else

                    {!! $customers->links() !!}

                @endif                    
            @endif

        </div>

    </div>
    <script type="text/javascript">

        $(document).ready(function(){

          $('#left_menu_item_1').attr('class', 'active');
      
        });

        function modifyFunc(id, page) {
            window.location.href = "{{ url('admin/customers/modify') }}" + "/" + id + "/" + page;
        }

        function deleteFunc(id, page) {
            var msg = "{{ trans('common.info.confirm_delete_item_by_id') }}";
            msg = msg.replace(/%1/, id);
            if (!confirm(msg)) {
                return;
            } 

            window.location.href = "{{ url('admin/customers/delete') }}" + "/" + id + "/" + page;
        }

        function resetFunc() {
            window.location.href = "{{ url('admin/customers') }}";
        }

        function searchFunc() {
            window.search_form.submit();
        }

        function keydownFunc(e) {

            if (e.keyCode == 13)
                searchFunc();
        }

//         function exportFunc() {
//             var url = "{{ url('admin/customers/export/csv') }}";
//             url += "?search_name=" + $('#search_name').val();
//             url += "&search_email=" + $('#search_email').val();
//             url += "&search_company=" + $('#search_company').val();
//             url += "&search_city=" + $('#search_city').val();
//             url += "&search_province=" + $('#search_province').val();
//             url += "&search_country=" + $('#search_country').val();
//             url += "&search_referred_person=" + $('#search_referred_person').val();
//             url += "&search_is_confirmed=" + $('#search_is_confirmed').val();
//             url += "&search_create_time=" + $('#search_create_time').val();
//             url += "&search_confirm_time=" + $('#search_confirm_time').val();
// 
//             window.open(encodeURI(url));
//         }

    </script>
</div>
@endsection
