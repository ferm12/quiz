@extends('layouts.app-simple')

@section('top-nav')

    @include('layouts.templates.top-nav')

@endsection

@section('content')
<div class="content container">

    <div class="row">

        <div style="margin-left: 15px;">
            <p class="p-title-big">{{ strtoupper(trans('admin.label_reset_password')) }}</p>

            @if (isset($successMsg))
                <div class="alert alert-success" role="alert" style="width: 100%;">{{ $successMsg }}</div>
            @endif
            @if (isset($errorMsg))
                <div class="alert alert-danger" role="alert" style="width: 100%;">{{ $errorMsg }}</div>
            @endif
        </div>

        <div style="margin-top: 30px;"> 
            <p>&nbsp;</p>
            
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div style="width: 80%; margin-left: 20px;">

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/password/reset/enter') }}">

                        {{ csrf_field() }}
                        <input type="hidden" id="id" name="id" value="{{ (isset($id)) ? $id : old('id') }}" />
                        <input type="hidden" id="token" name="token" value="{{ (isset($token)) ? $token : old('token') }}" />

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password"><span class="span-required-red">*</span>{{ trans('customer.label_password_new') }}</label>
                            <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password_confirmation"><span class="span-required-red">*</span>{{ trans('customer.label_password_new_confirmation') }}</label>
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}">

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>

                        <p>&nbsp;</p>

                        <div class="form-group">
                            <label><span class="span-required-red">*{{ trans('customer.label_required_fields') }}</span></label><br>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-arrow-right"></i> {{ strtoupper(trans('common.btn_submit')) }}
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>   
    </div> 
    
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>

    <script type="text/javascript">

        function cancelFunc() {
            window.location.href = "{{ url('admin/login') }}";            
        }

    </script>    

</div>
@endsection
