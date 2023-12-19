<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title> @yield('title', 'Dashboard') - Dhakha Pharmacy </title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Favicon-->
    <link rel="icon" href="" type="image/png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Font-Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- LTE CDN  --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">



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

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        
        <!-- Main Header -->
        @include('backend.partial.nav')


        <!-- Left side column. contains the logo and sidebar -->
        @include('backend.partial.sidebar')
        

        <div class="content-wrapper">

            @yield('content');

        </div>

        <!-- Main Footer -->
        @include('backend.partial.footer')


    
    </div>


     {{-- Jquery CDN  --}}
     <script src="{{ asset('backend/js/jquery.min.js') }}"></script>
     <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
     {{-- LTE CDN  --}}
     @stack('js_link')
 
     <script src="{{ asset('backend/js/custom.js') }}"></script>
     @stack('js');




</body>

</html>
