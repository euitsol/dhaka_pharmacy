<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title> @yield('title', 'Dhakha Pharmacy') - Dhakha Pharmacy </title>

    <!-- Favicon -->
    <link rel="icon" href="{{ storage_url(settings('site_favicon')) }}">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Favicon-->
    <link rel="icon" href="" type="image/png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- White Dashboard --}}
    <link href="{{ asset('white') }}/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ asset('white') }}/css/white-dashboard.css?v=1.0.0" rel="stylesheet" />
    <link href="{{ asset('white') }}/css/theme.css" rel="stylesheet" />
    <link href="{{ asset('admin/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('lam/css/custom.css') }}" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('css_link')
    @stack('css')
    <!--======== toastr css ========-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="white-content dark {{ $class ?? '' }}">
    <div class="wrapper">
        @auth()
            @include('local_area_manager.partials.navbars.sidebar')
            <div class="main-panel">
                @include('local_area_manager.partials.navbars.navbar')
                <div class="content">
                    @yield('content')
                </div>
                @include('local_area_manager.partials.footer')
            </div>
        @endauth
    </div>
    <form id="logout-form" action="{{ route('local_area_manager.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>


    <script src="{{ asset('white') }}/js/core/jquery.min.js"></script>
    <script src="{{ asset('white') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('white') }}/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('white') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <script src="{{ asset('white') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('white') }}/js/white-dashboard.min.js?v=1.0.0"></script>
    <script src="{{ asset('white') }}/js/theme.js"></script>
    <script src="{{ asset('white') }}/js/color_change.js"></script>
    <!--======== toastr script ========-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    <script src="{{ asset('lam/js/custom.js') }}"></script>
    @stack('js_link')
    @stack('js')



</body>

</html>
