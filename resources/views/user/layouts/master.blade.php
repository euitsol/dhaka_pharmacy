<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Dashboard'){{ __(' - Dhaka Pharmacy') }}</title>
    <link rel="icon" href="{{ storage_url(settings('site_favicon')) }}">

    <!------- Bootstrap-CSS-CDN-Link ------->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


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

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <!------ Custom-CSS ------->
    @stack('css_link')
    <link rel="stylesheet" href="{{ asset('user/asset/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('user/asset/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('user/asset/css/slide-cart.css') }}">
    {{-- Local CSS --}}
    @if (app()->getLocale() == 'en')
        <link rel="stylesheet" href="{{ asset('user/asset/css/locale-en.css') }}">
    @elseif (app()->getLocale() == 'bn')
        <link rel="stylesheet" href="{{ asset('user/asset/css/locale-bn.css') }}">
    @endif
    @stack('css')


    <script>
        const mapbox_token = `{{ config('mapbox.mapbox_token') }}`;
        const mark_as_read = `{{ route('u.notification.read_all') }}`;
        const audio_url = `{{ asset('admin/mp3/order-notification.mp3') }}`;
        const user_id = `{{ user() ? user()->id : false }}`;
        const content_image_upload_url = "{{ route('file.ci_upload') }}";
    </script>
    <script>
        const routes = {
            'cart_products': `{{ route('cart.products') }}`,
            'cart_add': `{{ route('cart.add') }}`,
            'cart_update': `{{ route('cart.update') }}`,
            'cart_delete': `{{ route('cart.delete') }}`,
            'login': `{{ route('login') }}`,
            'city_search': `{{ route('u.as.cities') }}`
        };
    </script>
    <script>
        window.AppConfig = {
            'urls': {
                'cart': {
                    'products': @json(route('cart.products')),
                    'add': @json(route('cart.add')),
                    'update': @json(route('cart.update')),
                    'delete': @json(route('cart.delete')),
                },
                'address': {
                    'cities': @json(route('u.as.cities')),
                    'details': @json(route('u.as.details', 'id')),
                },
            }
        }
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
    <!-- jQuery CDN -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer">
    </script>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>





    <!--======== toastr script ========-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('js_link')
    <script src="{{ asset('user/asset/js/custom.js') }}"></script>
    <script src="{{ asset('user/asset/js/notificaiton.js') }}"></script>
    <script src="{{ asset('user/asset/js/address.js') }}"></script>
    <script src="{{ asset('frontend/asset/js/cart.js') }}"></script>
    @stack('js')
</body>

</html>
