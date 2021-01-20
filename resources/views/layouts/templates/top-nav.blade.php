    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" href="{{ url('/') }}">
                    <span class="logo-lg" title="Quiz"><strong>Quiz</strong></span>
                </a>
            </div>
            <p class="navbar-text">

                @if (isset($username))
                     {{ str_replace('%1', $username, trans('common.label_welcome')) }}
                @endif

            </p>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        
                        <li><a href="{{ url('user/login') }}" class="menu-item-title-small"><i class="fa fa-btn fa-sign-in">&nbsp;</i>{{ strtoupper(trans('customer.btn_login')) }} <span class="sr-only">(current)</span></a></li>
                        
                    @else
                    
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user">&nbsp;</i> <span class="sr-only">(current)</span></a>                                
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('user/password/change') }}" class="menu-item-title-small"><i class="fa fa-key">&nbsp;</i> {{ strtoupper(trans('customer.btn_change_password')) }}</a></li>
                                <li><a href="{{ url('user/logout') }}" class="menu-item-title-small"><i class="fa fa-sign-out">&nbsp;</i> {{ strtoupper(trans('customer.btn_logout')) }}</a></li>
                            </ul>
                        </li>

                    @endif
                </ul>
            </div>      
     
        </div>
    </nav>
