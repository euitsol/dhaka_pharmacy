<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">

    <title> @yield('title', 'Dashboard') - Dhakha Pharmacy </title>

    <!-- Favicon-->
    <link rel="icon" href="" type="image/png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    {{-- Font-Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">

    {{-- Toastr --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    
    <link href="{{ asset('backend/css/custom.css') }}" rel="stylesheet">
    @stack('css_link')
    @stack('css')
    <style>
        .brand-link .brand-image {
            margin-left: 0;
            margin-right: 0;
            margin-top: 0;
            max-height: 45px;
            width: 100%;
            object-fit: cover;
        }
    </style>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Main Header -->
        @include('backend.partial.nav')
        <!-- Left side column. contains the logo and sidebar -->
        @include('backend.partial.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper  py-5 px-5">
            @yield('content')
        </div>

        <!-- Main Footer -->
        @include('backend.partial.footer')
    </div>

    <script src="{{ asset('backend/js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
    @stack('js_link')
    
    <script src="{{ asset('backend/js/custom.js') }}"></script>
    @stack('js');
</body>

</html>