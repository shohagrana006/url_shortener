<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{env('APP_NAME')}}</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('backend_asset')}}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('backend_asset')}}/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="{{asset('backend_asset')}}/css/custom.css" rel="stylesheet">
    
    @stack('admin_style')

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

     @include('admin.partials.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @include('admin.partials.navbar')

                @yield('admin_content')

            </div>
            <!-- End of Main Content -->

            @include('admin.partials.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

   
    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('backend_asset')}}/vendor/jquery/jquery.min.js"></script>
    <script src="{{asset('backend_asset')}}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('backend_asset')}}/js/sb-admin-2.min.js"></script>

    @stack('admin_script')
</body>
</html>