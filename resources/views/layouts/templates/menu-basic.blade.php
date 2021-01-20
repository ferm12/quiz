
    <nav class="navbar navbar-default" style="margin-top: -21px;">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"></a>
            </div> 

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <!-- <li id="btn_my_account"><a href="{{ url('user/accountsummary') }}" class="menu&#45;item&#45;title&#45;medium"> {{ strtoupper(trans('common.btn_my_account')) }} <span class="sr&#45;only">(current)</span></a></li> -->
                    <li id="btn_my_account"><a href="{{ url('user/accountsummary') }}" class="menu-item-title-medium"> Account <span class="sr-only">(current)</span></a></li>
                    <!-- <li id="btn_my_contact"><a href="{{ url('user/contact') }}" class="menu&#45;item&#45;title&#45;medium"> {{ strtoupper(trans('common.btn_my_contact')) }}</a></li> -->
                    <!-- <li id="btn_my_deals"><a href="{{ url('user/deal') }}" class="menu&#45;item&#45;title&#45;medium"> {{ strtoupper(trans('deal.btn_my_deals')) }}</a></li> -->
                </ul>
            </div>

            <script type="text/javascript">

                $(document).ready(function() {

                    switch(headMenuItemIndex) {
                        case 1:
                            $("#btn_my_account").attr("class", "active");
                            break;
                        case 2:
                            $("#btn_my_contact").attr("class", "active");
                            break;
                        case 3:
                            $("#btn_my_deals").attr("class", "active");
                            break;
                        default:
                            break;
                    }
                });

            </script>

        </div>
    </nav>
