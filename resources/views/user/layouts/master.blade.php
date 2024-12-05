<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Dashboard'){{ __(' - Dhaka Pharmacy') }}</title>
    <link rel="icon" href="{{ storage_url(settings('site_favicon')) }}">
    <!------- Bootstrap-CSS-CDN-Link ------->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- CSRF Token -->
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <!------- Google-Font -------->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Itim&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!------- Font-Awesome-CDN --------->
    <script src="https://kit.fontawesome.com/db6820c2b5.js" crossorigin="anonymous"></script>


    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <!--======== toastr css ========-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!------ Custom-CSS ------->
    <link rel="stylesheet" href="{{ asset('user/asset/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('user/asset/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('user/asset/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('user/asset/css/style.css') }}">
    @stack('css_link')
    @stack('css')


    <script>
        const mapbox_token = `{{ config('mapbox.mapbox_token') }}`;
        const mark_as_read = `{{ route('u.notification.read_all') }}`;
        const audio_url = `{{ asset('admin/mp3/order-notification.mp3') }}`;
        const user_id = `{{ user() ? user()->id : false }}`;
    </script>
</head>

<body>
    <!-------- Header Section start --------->
    @include('user.partials.header')
    <!------------ Header Section End --------->

    <!------ Dashboard main section ------->
    <section class="dashboard-main-section">
        @yield('content')
    </section>
    <!-- Socket-section -->
    @include('user.partials.socket')
    <!-- Socket-section -->
    <!------ Dashboard main section ------->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script src="{{ asset('white') }}/js/core/jquery.min.js"></script>
    <script src="{{ asset('white') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('white') }}/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('white') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <script src="{{ asset('white') }}/js/plugins/bootstrap-notify.js"></script>
    <!--======== toastr script ========-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @stack('js_link')
    <script src="{{ asset('user/asset/js/custom.js') }}"></script>
    <script src="{{ asset('user/asset/js/notificaiton.js') }}"></script>
    <script>
        const routes = {
            'cart_products': `{{ route('cart.products') }}`,
            'cart_add': `{{ route('cart.add') }}`,
            'cart_update': `{{ route('cart.update') }}`,
            'cart_delete': `{{ route('cart.delete') }}`,
            'login': `{{ route('login') }}`,
        };
    </script>
    @include('frontend.includes.add_to_cart_js')
    <script>
        $(document).ready(function() {
            refreshCart();
        });
    </script>
    @stack('js')
</body>

</html>
