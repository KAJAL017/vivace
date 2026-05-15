<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title Meta -->
    <meta charset="utf-8" />
    <title>@yield('admin-title') | Admin </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ admin_assets() }}/assets/images/favicon.ico">
    <!-- Vendor css (Require in all Page) -->
    <link href="{{ admin_assets() }}/assets/css/vendor.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons css (Require in all Page) -->
    <link href="{{ admin_assets() }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App css (Require in all Page) -->
    <link href="{{ admin_assets() }}/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Enterprise Admin Design CSS -->
    <link href="{{ admin_assets() }}/assets/css/enterprise-admin.css" rel="stylesheet" type="text/css" />
    
    <!-- Theme Config js (Require in all Page) -->
    <script src="{{ admin_assets() }}/assets/js/config.js"></script>
    <link rel="stylesheet" href="{{ admin_assets() }}/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css">



    <style>
                #ajax-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
        }

        .spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .lds-dual-ring {
            display: inline-block;
            width: 80px;
            height: 80px;
        }

        .lds-dual-ring:after {
            content: " ";
            display: block;
            width: 64px;
            height: 64px;
            margin: 8px;
            border-radius: 50%;
            border: 6px solid #3498db;
            border-color: #3498db transparent #3498db transparent;
            animation: lds-dual-ring 1.2s linear infinite;
        }

        @keyframes lds-dual-ring {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

    </style>
    @yield('admin-css')
</head>

<body>

    <div id="ajax-loader" style="display:none;">
    <div class="overlay"></div>
    <div class="spinner">
        <div class="lds-dual-ring"></div>
    </div>
</div>


    <!-- START Wrapper -->
    <div class="wrapper">
        <!-- ========== Topbar Start ========== -->
        @include('admin.main.Topbar')
        <!-- Right Sidebar (Theme Settings) -->
        @include('admin.main.Setting')
        <!-- ========== Topbar End ========== -->
        <!-- ========== App Menu Start ========== -->
        @include('admin.main.Sidebar')
        <!-- ========== App Menu End ========== -->
        <!-- ==================================================== -->
        <!-- Start right Content here -->
        <!-- ==================================================== -->
        <div class="page-content">

            <!-- Start Container Fluid -->
            @yield('admin-content')
            <!-- End Container Fluid -->

            <!-- ========== Footer Start ========== -->
          @include('admin.main.Footer')
            <!-- ========== Footer End ========== -->

        </div>
        <!-- ==================================================== -->
        <!-- End Page Content -->
        <!-- ==================================================== -->
    </div>
    <!-- END Wrapper -->
    <!-- Vendor Javascript (Require in all Page) -->
    <script src="{{ admin_assets() }}/assets/js/vendor.js"></script>
    <!-- App Javascript (Require in all Page) -->
    <script src="{{ admin_assets() }}/assets/js/app.js"></script>

    <!-- Vector Map Js -->
    <script src="{{ admin_assets() }}/assets/vendor/jsvectormap/js/jsvectormap.min.js"></script>
    <script src="{{ admin_assets() }}/assets/vendor/jsvectormap/maps/world-merc.js"></script>
    <script src="{{ admin_assets() }}/assets/vendor/jsvectormap/maps/world.js"></script>
    <script src="{{ admin_assets() }}/assets/js/pages/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/trumbowyg/dist/trumbowyg.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <script>
    $(document).ajaxStart(function () {
        $('#ajax-loader').fadeIn();
    });

    $(document).ajaxStop(function () {
        $('#ajax-loader').fadeOut();
    });

    </script>
    <script>
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    </script>
    <script>
		@if(session()->has('success'))
				Swal.fire(
				'',
				'{{ session()->get('success') }}!',
				'success');
		@endif
		@if(session()->has('error'))
				Swal.fire(
				'',
				'{{ session()->get('error') }}!',
				'error');
		@endif
	</script>

    @yield('admin-js')
    <script>
        $(document).ready(function() {
            $('[data-f-id="pbf"]').remove();
        });
    </script>


</body>
</html>
