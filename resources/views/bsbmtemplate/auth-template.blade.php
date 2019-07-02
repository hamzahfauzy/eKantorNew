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

    <!-- Custom Css -->
    <link href="{{asset('template/bsbm/css/style.css')}}" rel="stylesheet">
    <style type="text/css">
    .invalid-feedback {
        color: red;
    }
    </style>
</head>

<body class="login-page">
    <div class="login-box">
        <center>
            <img src="{{asset('images/logo.png')}}">
        </center>
        <div class="logo">
            <a href="javascript:void(0);">e<b>Kantor</b></a>
            <small>Powered by BAPPEDA Kabupaten ASAHAN</small>
        </div>
        <div class="card">
            <div class="body">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="{{asset('template/bsbm/plugins/jquery/jquery.min.js')}}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{asset('template/bsbm/plugins/bootstrap/js/bootstrap.js')}}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{asset('template/bsbm/plugins/node-waves/waves.js')}}"></script>

    <!-- Validation Plugin Js -->
    <script src="{{asset('template/bsbm/plugins/jquery-validation/jquery.validate.js')}}"></script>

    <!-- Custom Js -->
    <script src="{{asset('template/bsbm/js/admin.js')}}"></script>
    <script src="{{asset('template/bsbm/js/pages/examples/sign-in.js')}}"></script>
</body>

</html>