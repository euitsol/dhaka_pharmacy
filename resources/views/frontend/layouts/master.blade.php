<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title', 'Dhakha Pharmacy') - Dhakha Pharmacy </title>
    <!-- Favicon -->
    <link rel="icon" href="{{ storage_url(settings('site_favicon')) }}">

    <!--========= uikit css =========-->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/uikit/css/uikit.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/uikit/css/uikit-rtl.min.css') }}">
    <!--========= goolge fonts =========-->
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!--========== bootstrap css ==========-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!--========= Select2 =========-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <!--========= custiom css =========-->
    <link rel="stylesheet" href="{{ asset('frontend/asset/css/nav.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/asset/css/style.css') }}">

    <!--======== FontAwesome cdn ==========-->
    <script src="https://kit.fontawesome.com/db6820c2b5.js" crossorigin="anonymous"></script>
    @stack('css_link')
    {{-- @livewireStyles <!-- Include Livewire styles here --> --}}
    @stack('css')

</head>

<!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
<!--------- Header-section-Start ----------->
<!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
<header>
    @include('frontend.includes.header')
</header>
<!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
<!---------  Header-section-End  ----------->
<!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->


<!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
<!------- Main Cotent Area Start  -------->
<!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
<main>
    <div class="container-fluid">
        @yield('content')
    </div>
</main>
<!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
<!-------  Main Cotent Area End  --------->
<!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->



<!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
<!--------- Footer-secion-Start ---------->
<!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
@include('frontend.includes.footer')
<!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
<!---------  Footer-secion-End  ---------->
<!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->


<!--========= jquery-cdn ===========-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!--======== bootstrap script ========-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
crossorigin="anonymous"></script>
<!--========= uikit-js ===========-->
<script src="{{ asset('frontend/vendor/uikit/js/uikit.min.js') }}"></script>
@stack('js_link')
<!--========== custom-js ===========-->
<script src="{{ asset('frontend/asset/js/custom.js') }}"></script>
{{-- @livewireScripts <!-- Include Livewire scripts here --> --}}
@stack('js')
</body>

</html>
