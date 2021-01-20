
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
                    <li id="btn_deal_registration"><a href="{{ url('user/deal') }}" class="menu-item-title-medium"> {{ strtoupper(trans('deal.btn_deal_registration')) }} <span class="sr-only">(current)</span></a></li>
                    <li id="btn_training"><a href="javascript: jumpOpen('https://partner.screenbeam.com/training/');" class="menu-item-title-medium"> {{ strtoupper(trans('common.btn_training')) }}</a></li>
                    <li id="btn_sales_toolbox"><a href="javascript: jumpOpen('https://partner.screenbeam.com/salestools/');" class="menu-item-title-medium"> {{ strtoupper(trans('common.btn_sales_toolbox')) }}</a></li>
                    <li id="btn_technical_resources"><a href="javascript:jumpOpen('https://actiontec.zendesk.com/hc/en-us');" class="menu-item-title-medium"> {{ strtoupper(trans('common.btn_technical_resources')) }}</a></li>               
                    <li id="btn_my_account"><a href="{{ url('user/account') }}" class="menu-item-title-medium"> {{ strtoupper(trans('common.btn_my_account')) }}</a></li>                
                </ul>
            </div>
            
		    <script type="text/javascript">

                var p = "{{ url('user/api/login') }}";
                var k = "{{ config('auth.api.local_client_key') }}";

		        $(document).ready(function() {
		            
		            switch(headMenuItemIndex) {
		                case 1:
		                    $("#btn_deal_registration").attr("class", "active");
		                    break;
		                case 2:
		                    $("#btn_training").attr("class", "active");
		                    break;
		                case 3:
		                    $("#btn_sales_toolbox").attr("class", "active");
		                    break;
		                case 4:
		                    $("#btn_technical_resources").attr("class", "active");
		                    break;
                        case 5:
                            $("#btn_my_account").attr("class", "active");
                            break;
		                default:
		                    break;
		            }
		        });

                function jumpTo(url) {
                    window.location.href = p + "?k=" + k + "&url=" + url;
                }

                function jumpOpen(url) {
                    window.open(p + "?k=" + k + "&url=" + url);
                }

		    </script>

        </div>
    </nav>