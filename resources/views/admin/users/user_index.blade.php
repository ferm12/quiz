@extends('layouts.admin')

@section('page-header')
    <h1>
        {{ trans('admin.title_users') }}
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('common.label_home') }} </a></li>
        <li class="active">{{ trans('admin.title_users') }}</li>
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
                <button type="button" class="btn btn-default btn-sm" onclick="javascript: createFunc();">{{ strtoupper(trans('admin.btn_create_user')) }}</button>
            </p>                  
            <p>
                @if (isset($admins) && count($admins) > 0)
                    <p style="margin-left: 5px;">{{ str_replace('%3', $admins->total(), str_replace('%2', $admins->lastPage(), str_replace('%1', $admins->total()>0?$admins->currentPage():'0', trans('common.str_paginate_title')))) }}</p>
                @else
                     <p>&nbsp;</p>
                @endif             
            </p>
        </div>
   
        <div class="table-responsive" style="font-size: 11px;">
            <table class="table table-bordered table-striped table-hover text-nowrap">
                <tr>
                    <td style="width: 32px; text-align: center; font-weight: bold;">{{ trans('customer.label_id') }}</td>
                    <td class="table-header-title-fixed">{{ trans('customer.label_firstname') }}</td>
                    <td class="table-header-title-fixed">{{ trans('customer.label_lastname') }}</td>
                    <td class="table-header-title-fixed">{{ trans('customer.label_email') }}</td>
                    <td class="table-header-title-fixed">{{ trans('common.label_create_time') }}</td>
                    <td class="table-header-title-fixed">{{ trans('common.label_operation') }}</td>
                </tr>

                @if (isset($admins) && count($admins) > 0)

                    @foreach ($admins as $row)
                        <tr>                      
                            <td class="text-center">{{ $row->id }}</td>
                            <td class="text-center">{{ $row->first_name }}</td>
                            <td class="text-center">{{ $row->last_name }}</td>
                            <td class="text-center">{{ $row->email }}</td>
                            <td class="text-center">{{ $row->created_at }}</td>
                            <td class="text-center">
                                <a href="javascript: modifyFunc('{{ $row->id }}', '{{ $admins->currentPage() }}');" style="margin-right: 10px; text-decoration: underline;">{{ trans('common.btn_modify') }}</a>                
                                
                                {{-- @if ($row->init_default != '1') --}}
                                    <a href="javascript: deleteFunc('{{ $row->id }}', '{{ $admins->currentPage() }}');" style="text-decoration: underline;">{{ trans('common.btn_delete') }}</a>
                                {{-- @endif --}}
                            </td>                             
                        </tr>
                    @endforeach

                @else

                    <tr>
                        <td colspan="7">{{ trans('common.str_no_record') }}</td>
                    </tr>                    
                    
                @endif

            </table>
        </div>  

        <div style="text-align: right;">

            @if (isset($admins) && count($admins) > 0)
                @if (isset($search) && !empty($search))

                    {!! $admins->appends(['search' => $search])->links() !!}

                @else

                    {!! $admins->links() !!}

                @endif                    
            @endif

        </div>

    </div>
    <script type="text/javascript">

        $(document).ready(function(){

          $('#left_menu_item_5').attr('class', 'active');
      
        });

        function createFunc() {
            window.location.href = "{{ url('admin/users/create') }}";  
        }

        function modifyFunc(id, page) {
            window.location.href = "{{ url('admin/users/modify') }}" + "/" + id + "/" + page;
        }

        function deleteFunc(id, page) {
            var msg = "{{ trans('common.info.confirm_delete_item_by_id') }}";
            msg = msg.replace(/%1/, id);
            if (!confirm(msg)) {
                return;
            } 

            window.location.href = "{{ url('admin/users/delete') }}" + "/" + id + "/" + page;
        }

    </script>
</div>
@endsection
