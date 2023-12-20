<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title> @yield('title', 'Dhakha Pharmacy') - Dhakha Pharmacy </title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Favicon-->
    <link rel="icon" href="" type="image/png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- LTE CDN  --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css"> --}}

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('css_link')

    {{-- White Dashboard --}}
    <link href="{{ asset('white') }}/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ asset('white') }}/css/white-dashboard.css?v=1.0.0" rel="stylesheet" />
    <link href="{{ asset('white') }}/css/theme.css" rel="stylesheet" />
    <script src="{{ asset('white') }}/js/core/jquery.min.js"></script>
    <script src="{{ asset('white') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('white') }}/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('white') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <script src="{{ asset('white') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('white') }}/js/white-dashboard.min.js?v=1.0.0"></script>
    <script src="{{ asset('white') }}/js/theme.js"></script>
    <script src="{{ asset('white') }}/js/color_change.js"></script>

    <link href="{{ asset('backend/css/custom.css') }}" rel="stylesheet">

    @stack('css')

</head>

<body class="white-content dark {{ $class ?? '' }}">
    <div class="wrapper">
        @auth()
            @include('admin.partials.navbars.sidebar')
            <div class="main-panel">
                @include('admin.partials.navbars.navbar')
                    <div class="content">
                        @yield('content')
                    </div>
                @include('admin.partials.footer')
            </div>
        @endauth
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    @stack('js_link')
    <script src="{{ asset('backend/js/custom.js') }}"></script>
    @stack('js');




</body>

</html>
