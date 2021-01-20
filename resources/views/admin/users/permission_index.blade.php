@extends('layouts.admin')

@section('page-header')
    <h1>
        {{ trans('admin.title_permissions') }}
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('common.label_home') }} </a></li>
        <li class="active">{{ trans('admin.title_permissions') }}</li>
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
                <button type="button" class="btn btn-default btn-sm" onclick="javascript: createFunc();">{{ strtoupper(trans('admin.btn_create_admin_rule')) }}</button>
            </p>                  
            <p>
                @if (isset($rules) && count($rules) > 0)
                    <p style="margin-left: 5px;">{{ str_replace('%3', $rules->total(), str_replace('%2', $rules->lastPage(), str_replace('%1', $rules->total()>0?$rules->currentPage():'0', trans('common.str_paginate_title')))) }}</p>
                @else
                     <p>&nbsp;</p>
                @endif             
            </p>
        </div>
   
        <div class="table-responsive" style="font-size: 11px;">
            <table class="table table-bordered table-hover text-nowrap">
                <tr>
                    <td rowspan="2" style="width: 32px; text-align: center; font-weight: bold;">{{ trans('customer.label_id') }}</td>
                    <td rowspan="2" class="table-header-title-fixed">{{ trans('customer.label_name') }}</td>
                    <td colspan="6" class="table-header-title-fixed">{{ trans('admin.label_privileges') }}</td>
                    <td rowspan="2" class="table-header-title-fixed">{{ trans('common.label_operation') }}</td>
                </tr>
                <tr>
                    <td class="table-header-title-fixed">{{ trans('admin.label_customer_priv') }}</td>
                    <td class="table-header-title-fixed">{{ trans('admin.label_customer_report_priv') }}</td>
                    <td class="table-header-title-fixed">{{ trans('admin.label_deal_priv') }}</td>
                    <td class="table-header-title-fixed">{{ trans('admin.label_deal_report_priv') }}</td>
                    <td class="table-header-title-fixed">{{ trans('admin.label_user_permission_priv') }}</td>
                    <td class="table-header-title-fixed">{{ trans('admin.label_config_priv') }}</td>
                </tr>

                @if (isset($rules) && count($rules) > 0)

                    @foreach ($rules as $row)
                        <tr>                      
                            <td class="text-center">{{ $row->id }}</td>
                            <td class="text-center">{{ $row->name }}</td>
                            <td class="text-center">{{ $row->customer_priv }}</td>
                            <td class="text-center">{{ $row->customer_report_priv }}</td>
                            <td class="text-center">{{ $row->deal_priv }}</td>
                            <td class="text-center">{{ $row->deal_report_priv }}</td>
                            <td class="text-center">{{ $row->user_permission_priv }}</td>
                            <td class="text-center">{{ $row->config_priv }}</td>
                            <td class="text-center">
                                @if ($row->init_default != '1')
                                    <a href="javascript: modifyFunc('{{ $row->id }}', '{{ $rules->currentPage() }}');" style="margin-right: 10px; text-decoration: underline;">{{ trans('common.btn_modify') }}</a>                
                                    <a href="javascript: deleteFunc('{{ $row->id }}', '{{ $rules->currentPage() }}');" style="text-decoration: underline;">{{ trans('common.btn_delete') }}</a>
                                @endif
                            </td>                             
                        </tr>
                    @endforeach

                @else

                    <tr>
                        <td colspan="9">{{ trans('common.str_no_record') }}</td>
                    </tr>                    
                    
                @endif

            </table>
        </div>  

        <div style="text-align: right;">

            @if (isset($rules) && count($rules) > 0)
                @if (isset($search) && !empty($search))

                    {!! $rules->appends(['search' => $search])->links() !!}

                @else

                    {!! $rules->links() !!}

                @endif                    
            @endif

        </div>

    </div>
    <script type="text/javascript">

        $(document).ready(function(){

          $('#left_menu_item_6').attr('class', 'active');
      
        });

        function createFunc() {
            window.location.href = "{{ url('admin/permissions/create') }}";  
        }

        function modifyFunc(id, page) {
            window.location.href = "{{ url('admin/permissions/modify') }}" + "/" + id + "/" + page;
        }

        function deleteFunc(id, page) {
            var msg = "{{ trans('common.info.confirm_delete_item_by_id') }}";
            msg = msg.replace(/%1/, id);
            if (!confirm(msg)) {
                return;
            } 

            window.location.href = "{{ url('admin/permissions/delete') }}" + "/" + id + "/" + page;
        }

    </script>
</div>
@endsection
