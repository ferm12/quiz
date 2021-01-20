@extends('layouts.app')

@section('top-nav')

    @include('layouts.templates.top-nav')

@endsection

@section('content')
<div class="content container">

    <div class="row">

        <div style="margin-left: 15px;">
            <p class="p-title-big">Fermin' Partner</p>

            @if (isset($successMsg))
                <div class="alert alert-success" role="alert" style="width: 100%;">{{ $successMsg }}</div>
            @endif
            @if (isset($errorMsg))
                <div class="alert alert-danger" role="alert" style="width: 100%;">{{ $errorMsg }}</div>
            @endif
        </div>

        <div style="margin-top: 30px;">
            <div style="margin-left: 20px;">
                <p class="p-title-medium-blue">{{ strtoupper(trans('customer.label_retrieve_password')) }}</p>
                <p class="p-description-medium-blue">{{ trans('customer.label_retrieve_password_description') }}</p>
            </div>  
            <p>&nbsp;</p>
            
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div style="width: 80%; margin-left: 20px;">

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('user/password/reset') }}">

                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email"><span class="span-required-red">*</span>{{ trans('customer.label_email') }}</label>
                            <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <p>&nbsp;</p>

                        <div class="form-group">
                            <label><span class="span-required-red">*{{ trans('customer.label_required_fields') }}</span></label><br>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-arrow-right"></i> {{ strtoupper(trans('common.btn_submit')) }}
                            </button>
                            <button type="button" class="btn btn-default" onClick="javascript: cancelFunc();" style="margin-left: 10px;">
                                {{ strtoupper(trans('common.btn_cancel')) }}
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>   
    </div> 
    
    <p>&nbsp;</p>

    <script type="text/javascript">

        function cancelFunc() {
            window.location.href = "{{ url('user/login') }}";            
        }

    </script>    

</div>
@endsection
