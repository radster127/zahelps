<!DOCTYPE html>  
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/') }}themes/eliteadmin/plugins/images/favicon.png">
        <title>@yield('title') | HelpGivers Community of helpers</title>
        <!-- Bootstrap Core CSS -->
        {!! Html::style('/themes/eliteadmin/bootstrap/dist/css/bootstrap.min.css')!!}
        <!-- <link href="{{ asset('/') }}/themes/eliteadmin/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->
        {!! Html::style('/themes/eliteadmin/plugins/bower_components/toast-master/css/jquery.toast.css')!!}
        <!-- <link href="{{ asset('/') }}/themes/eliteadmin/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet"> -->
        
        <!-- animation CSS -->
        {!! Html::style('/themes/eliteadmin/css/animate.css')!!}
        <!-- <link href="{{ asset('/') }}/themes/eliteadmin/css/animate.css" rel="stylesheet"> -->
        <!-- Custom CSS -->
        {!! Html::style('/themes/eliteadmin/css/style.css') !!}
        <!-- color CSS -->
        {!! Html::style('/themes/eliteadmin/css/colors/blue.css')!!}
        <!-- <link href="{{ asset('/') }}/themes/eliteadmin/css/colors/blue.css" rel="stylesheet"> -->
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        {!! Html::style('/thirdparty/parsley/parsley.css')!!}
        <!-- <link href="{{ asset('/') }}thirdparty/parsley/parsley.css" rel="stylesheet" type="text/css" /> -->
        {!! Html::style('/css/member-custom.css')!!}
        <!-- <link href="{{ asset('/') }}css/member-custom.css" rel="stylesheet" type="text/css" /> -->
    </head>
    <body>
        <!-- Preloader -->
        <div class="preloader">
            <div class="cssload-speeding-wheel"></div>
        </div>
        <section id="wrapper" class="login-register">
            <div class="login-box login-sidebar">
                @yield('content')
            </div>
        </section>
        <!-- jQuery -->
        <script src="{{ asset('/') }}themes/eliteadmin/plugins/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="{{ asset('/') }}themes/eliteadmin/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- Menu Plugin JavaScript -->
        <script src="{{ asset('/') }}themes/eliteadmin/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>

        <!--slimscroll JavaScript -->
        <script src="{{ asset('/') }}themes/eliteadmin/js/jquery.slimscroll.js"></script>
        <!--Wave Effects -->
        <script src="{{ asset('/') }}themes/eliteadmin/js/waves.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="{{ asset('/') }}themes/eliteadmin/js/custom.min.js"></script>

        <script src="{{ asset('/') }}thirdparty/parsley/parsley.js"></script>
        <script src="{{ asset('/') }}themes/eliteadmin/plugins/bower_components/toast-master/js/jquery.toast.js"></script>

        <script src="{{ asset('/') }}js/member-custom.js"></script>
        <script src="{{ asset('/') }}js/member-login.js"></script>
        
        

        @yield('page_js')
        
    </body>

</html>
