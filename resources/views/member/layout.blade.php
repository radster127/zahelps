<!DOCTYPE html>  
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
        <title>@yield('title') | HelpGivers Community of helpers</title>

        @include('member.includes.css')
        <script type="text/javascript">
          function userAvatarImgError(image) {
              image.onerror = "";
              image.src = "{{ asset('/') }}images/user.png";
              return true;
          }
          function proofPictureImgError(image) {
              image.onerror = "";
              image.src = "{{ asset('/') }}images/no_image_available.png";
              return true;
          }
          
          
        </script>

    </head>
    <body>
        <!-- Preloader -->
        <div class="preloader">
            <div class="cssload-speeding-wheel"></div>
        </div>


        <div id="wrapper">

            @include('member.includes.topbar')
            @include('member.includes.navbar')
            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">

                    @yield('content')

                </div>
                @include('member.includes.footer')
            </div>
            <!-- /#page-wrapper -->
        </div>
        @include('member.includes.js')
        @yield('page_js')


    </body>
</html>
