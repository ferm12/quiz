<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ trans('common.title_app_admin') }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{ asset('lib/bootstrap-3.3.7/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/jquery-ui-1.11.4/themes/ui-lightness/jquery-ui.min.css') }}">

    <link rel="stylesheet" href="{{ asset('lib/admin-lte/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/admin-lte/dist/css/skins/skin-blue-light.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

<!--
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  -->

    <script src="{{ asset('lib/jquery/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('lib/bootstrap-3.3.7/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('lib/jquery-ui-1.11.4/jquery-ui.min.js') }}"></script>

    <script src="{{ asset('lib/admin-lte/dist/js/adminlte.min.js') }} "></script>

</head>

<body class="hold-transition skin-blue-light sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="{{ url('/admin') }}" class="logo">
          <span class="logo-mini"><b></b></span>
           <span class="logo-lg">{{ trans('common.title_app_admin') }}</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <!-- Notifications Menu -->
                    <li class="dropdown notifications-menu" style="display: none;">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">0</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header"></li>
                            <li>
                                <ul class="menu">
                                    <li>
                                        <a href="#"><i class="fa fa-users text-aqua"></i></a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>

                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                             <!-- <img src="{{ asset('admin-lte/dist/img/user3-128x128.jpg') }}" class="user-image" alt="User Image"> -->
                            <i class="fa fa-user"></i>
                            <span class="hidden-xs">
                                @if (isset($userPermission))
                                    {{ $userPermission['first_name'] . ' ' . $userPermission['last_name'] }}
                                @endif
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <!-- <img src="{{ asset('admin-lte/dist/img/user3-128x128.jpg') }}" class="img-circle" alt="User Image"> -->
                                <i class="fa fa-user fa-4x"></i>
                                <p>  
                                    @if (isset($userPermission))
                                        {{ $userPermission['first_name'] . ' ' . $userPermission['last_name'] }}
                                    @endif
                                    <small></small>
                                </p>
                            </li>
                            
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ url('admin/password/change') }}" class="btn btn-default btn-flat">{{ trans('customer.btn_change_password') }}</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('admin/logout') }}" class="btn btn-default btn-flat">{{ trans('customer.btn_logout') }}</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Control Sidebar Toggle Button -->
                    <li style="display: none;">
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel" style="display: none;">
                <div class="pull-left image">
                    <img src="{{ asset('admin-lte/dist/img/user3-128x128.jpg') }}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>Guest</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>

            <p>&nbsp;</p>

            <!-- search form (Optional) -->
            <form action="#" method="get" class="sidebar-form" style="display: none;">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="{{ trans('common.str_searching') }}">
                    <span class="input-group-btn">
                        <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </form>

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header" style="display: none;"></li>
                <!-- comments {{-- --}} -->
                {{--@if (isset($userPermission)) --}}

                    {{-- @if ($userPermission['customer_priv'] == 'Y') --}}
                        <li id="left_menu_item_1"><a href="{{ url('admin/customers') }}"><i class="fa fa-users"></i> <span>{{ trans('admin.title_customers') }}</span></a></li>                
                    {{-- @endif --}}
                    {{-- @if ($userPermission['deal_priv'] == 'Y') --}}
                        <!-- <li id="left_menu_item_2"><a href="{{ url('admin/macids') }}"><i class="fa fa&#45;hashtag"></i> <span>Mac IDs</span></a></li> -->
                    {{-- @endif --}}
                    {{-- @if ($userPermission['user_permission_priv'] == 'Y') --}}
                        <li id="left_menu_item_5"><a href="{{ url('admin/users') }}"><i class="fa fa-user"></i> <span>{{ trans('admin.title_users') }}</span></a></li>
                        <!-- <li id="left_menu_item_6"><a href="{{-- url('admin/permissions') --}}"><i class="fa fa&#45;balance&#45;scale"></i> <span>{{-- trans('admin.title_permissions') --}}</span></a></li> -->
                    {{-- @endif --}}
                    {{-- @if ($userPermission['config_priv'] == 'Y') --}}
                        <li id="left_menu_item_7"><a href="{{ url('admin/config') }}"><i class="fa fa-cog"></i> <span>{{ trans('admin.title_config') }}</span></a></li>
                    {{-- @endif --}}
                {{-- @endif --}}

            </ul>
        </section>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-color: #ffffff;">
        <!-- Content Header (Page header) -->
        <section class="content-header">

          @yield('page-header')

        </section>

        <!-- Main content -->
        <section class="content container-fluid">

          @yield('content')

        </section>
    </div>
    <!-- /.content-wrapper -->


    <!-- Main Footer -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
        </div>

        <p>{{ str_replace('1%', date('Y'), trans('common.str_copyright')) }}</p>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-stats-tab" data-toggle="tab"><i class="fa fa-users"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane active" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Recent Activity</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:;">
                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                                <p>Will be 23 on April 24th</p>
                            </div>
                        </a>
                    </li>
                </ul>

                <!-- /.control-sidebar-menu -->
                <h3 class="control-sidebar-heading">Tasks Progress</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:;">
                            <h4 class="control-sidebar-subheading">
                                Custom Template Design
                                <span class="pull-right-container">
                                    <span class="label label-danger pull-right">70%</span>
                                </span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Stats tab content -->
            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>

            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">General Settings</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Report panel usage
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>Some information about this general settings option</p>
                    </div>
                </form>
            </div>

        </div>
    </aside>

    <!-- Add the sidebar's background. This div must be placed
        immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>

</div>
</body>
</html>

