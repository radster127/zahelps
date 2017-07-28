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

        @include('admin.includes.css')
    </head>
    <body class="fixed-sidebar fixed-header skin-default content-appear">
        <div class="wrapper">

            <!-- Preloader -->
            <div class="preloader"></div>

            <!-- Sidebar -->
            <div class="site-overlay"></div>

            @include('admin.includes.sidebar')

            <!-- Sidebar second -->
            <?php /* @include('admin.includes.sidebar_second') */?>

            <!-- Header -->
            @include('admin.includes.header')

            <div class="site-content">
                <!-- Content -->
                <div class="content-area py-1">
                    <div class="container-fluid">


                        @yield('content')

                    </div>
                </div>
                <!-- Footer -->
                @include('admin.includes.footer') 
            </div>

        </div>

        @include('admin.includes.js') 
        @yield('page_js')
    </body>

</html>