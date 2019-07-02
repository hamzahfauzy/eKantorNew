<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>{{env('APP_NAME','eKantor Application')}}</title>
    <!-- Favicon-->
    <link rel="icon" href="{{asset('images/logo.png')}}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{asset('template/bsbm/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{asset('template/bsbm/plugins/node-waves/waves.css')}}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{asset('template/bsbm/plugins/animate-css/animate.css')}}" rel="stylesheet" />

    <link href="{{asset('template/bsbm/plugins/dropzone/dropzone.css')}}" rel="stylesheet">

    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{asset('template/bsbm/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="{{asset('template/bsbm/plugins/morrisjs/morris.css')}}" rel="stylesheet" />

    <!-- Sweet Alert Css -->
    <link href="{{asset('template/bsbm/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" />

    <!-- JQuery DataTable Css -->
    <link href="{{asset('template/bsbm/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">

    <!-- Custom Css -->
    <link href="{{asset('template/bsbm/css/style.css')}}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{asset('template/bsbm/css/themes/all-themes.css')}}" rel="stylesheet" />

    <style type="text/css">
    .invalid-feedback {
        color: red;
    }
    .dropdown-menu ul.menu li {
        list-style-type: none;
    }
    </style>
</head>

<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        @include('bsbmtemplate.partial.top-bar')
    </nav>
    <!-- #Top Bar -->
    <section>
        @include('bsbmtemplate.partial.sidebar')
    </section>

    <section class="content">
        @yield('content')
    </section>

    <!-- Jquery Core Js -->
    <script src="{{asset('template/bsbm/plugins/jquery/jquery.min.js')}}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{asset('template/bsbm/plugins/bootstrap/js/bootstrap.js')}}"></script>

    <!-- Bootstrap Select Css -->
    <link href="{{asset('template/bsbm/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />

    <!-- Waves Effect Plugin Js -->
    <script src="{{asset('template/bsbm/plugins/node-waves/waves.js')}}"></script>

    <!-- Jquery Validation Plugin Css -->
    <script src="{{asset('template/bsbm/plugins/jquery-validation/jquery.validate.js')}}"></script>

    <!-- Custom Js -->
    <script src="{{asset('template/bsbm/js/admin.js')}}"></script>
    <script src="{{asset('template/bsbm/js/pages/forms/form-validation.js')}}"></script>

    @yield('script')
</body>

</html>