<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Utility Application">
    <meta name="author" content="Xunaira J.">
    <meta name="keywords" content="utility">

    <!-- Title Page-->
    <title>Dashboard</title>

    <!-- Fontfaces CSS-->
    <link href="{{url('admin/css/font-face.css')}}" rel="stylesheet" media="all">
    <link href="{{url('admin/vendor/font-awesome-4.7/css/font-awesome.min.css')}}" rel="stylesheet" media="all">
    <link href="{{url('admin/vendor/font-awesome-5/css/fontawesome-all.min.css')}}" rel="stylesheet" media="all">
    <link href="{{url('admin/vendor/mdi-font/css/material-design-iconic-font.min.css')}}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{url('admin/vendor/bootstrap-4.1/bootstrap.min.css')}}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{url('admin/vendor/animsition/animsition.min.css')}}" rel="stylesheet" media="all">
    <link href="{{url('admin/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet" media="all">
    <link href="{{url('admin/vendor/wow/animate.css')}}" rel="stylesheet" media="all">
    <link href="{{url('admin/vendor/css-hamburgers/hamburgers.min.css')}}" rel="stylesheet" media="all">
    <link href="{{url('admin/vendor/slick/slick.css')}}" rel="stylesheet" media="all">
    <link href="{{url('admin/vendor/select2/select2.min.css')}}" rel="stylesheet" media="all">
    <link href="{{url('admin/vendor/perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{url('admin/css/theme.css')}}" rel="stylesheet" media="all">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        @include('admin.header')
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        @include('admin.aside')
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            @include('admin.content_header')
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            @yield('content')
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="{{url('admin/vendor/jquery-3.2.1.min.js')}}"></script>
    <!-- Bootstrap JS-->
    <script src="{{url('admin/vendor/bootstrap-4.1/popper.min.js')}}"></script>
    <script src="{{url('admin/vendor/bootstrap-4.1/bootstrap.min.js')}}"></script>
    <!-- Vendor JS       -->
    <script src="{{url('admin/vendor/slick/slick.min.js')}}">
    </script>
    <script src="{{url('admin/vendor/wow/wow.min.js')}}"></script>
    <script src="{{url('admin/vendor/animsition/animsition.min.js')}}"></script>
    <script src="{{url('admin/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js')}}">
    </script>
    <script src="{{url('admin/vendor/counter-up/jquery.waypoints.min.js')}}"></script>
    <script src="{{url('admin/vendor/counter-up/jquery.counterup.min.js')}}">
    </script>
    <script src="{{url('admin/vendor/circle-progress/circle-progress.min.js')}}"></script>
    <script src="{{url('admin/vendor/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{url('admin/vendor/chartjs/Chart.bundle.min.js')}}"></script>
    <script src="{{url('admin/vendor/select2/select2.min.js')}}">
    </script>

    <!-- Main JS-->
    <script src="{{url('admin/js/main.js')}}"></script>
    <script src="{{url('js/modal.js')}}"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript">
        toastr.options = {
             "positionClass": "toast-bottom-right",
        }
    </script>
    <script>
      @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;
            
            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
      @endif
    </script>

</body>

</html>
<!-- end document-->
