<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Title -->
        <title>@yield('title') | HelpGivers Community of helpers</title>

        <!-- Vendor CSS -->
        <link rel="stylesheet" href="{{ asset('/') }}themes/neptune/vendor/bootstrap4/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('/') }}themes/neptune/vendor/themify-icons/themify-icons.css">
        <link rel="stylesheet" href="{{ asset('/') }}themes/neptune/vendor/font-awesome/css/font-awesome.min.css">

        <!-- Neptune CSS -->
        <link rel="stylesheet" href="{{ asset('/') }}themes/neptune/css/core.css">

        <link href="{{ asset('/') }}thirdparty/parsley/parsley.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/') }}css/custom.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="auth-bg">

        <div class="auth">
            <div class="auth-header">
<!--                <div class="mb-2"><img src="{{ asset('/') }}themes/neptune/img/logo.png" title=""></div>-->
                <div class="mb-2"><img src="{{ asset('/') }}themes/eliteadmin/plugins/images/hg_plan_logo.png" alt="Home" /></div>
                <h6>Welcome! Sign in to access the admin panel</h6>
            </div>
            <div class="container-fluid">
                <div class="row">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Vendor JS -->
        <script type="text/javascript" src="{{ asset('/') }}themes/neptune/vendor/jquery/jquery-1.12.3.min.js"></script>
        <script type="text/javascript" src="{{ asset('/') }}themes/neptune/vendor/tether/js/tether.min.js"></script>
        <script type="text/javascript" src="{{ asset('/') }}themes/neptune/vendor/bootstrap4/js/bootstrap.min.js"></script>
        <script src="{{ asset('/') }}thirdparty/parsley/parsley.js"></script>

        <script type="text/javascript">
            $(function () {
                $('.login_form').parsley();
            })
        </script>
    </body>
</html>