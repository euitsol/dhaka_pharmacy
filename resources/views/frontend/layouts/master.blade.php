<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    {{-- Google Tag --}}
    @include('frontend.includes.google_tag')

    <!-- CSRF Token -->
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title', 'DP') - Dhaka Pharmacy </title>
    <!-- Favicon -->
    <link rel="icon" href="{{ storage_url(settings('site_favicon')) }}">

    <!--========= uikit css =========-->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/uikit/css/uikit.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/uikit/css/uikit-rtl.min.css') }}">
    <!--========= goolge fonts =========-->
    <!-- <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet"> -->

    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <!--========== bootstrap css ==========-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

    <!--========= Select2 =========-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <!--========= custiom css =========-->
    <link rel="stylesheet" href="{{ asset('frontend/asset/css/nav.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/asset/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/asset/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/asset/css/prescription.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/asset/css/errors.css') }}">

    {{-- Local CSS --}}
    @if (app()->getLocale() == 'en')
        <link rel="stylesheet" href="{{ asset('frontend/asset/css/locale-en.css') }}">
    @elseif (app()->getLocale() == 'bn')
        <link rel="stylesheet" href="{{ asset('frontend/asset/css/locale-bn.css') }}">
    @endif

    <!--======== FontAwesome cdn ==========-->
    <script src="https://kit.fontawesome.com/db6820c2b5.js" crossorigin="anonymous"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <!--======== toastr css ========-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @stack('css_link')
    {{-- @livewireStyles <!-- Include Livewire styles here --> --}}
    @stack('css')
    <script>
        const mapbox_token = `{{ config('mapbox.mapbox_token') }}`;
        const mapbox_default = {
            'mapbox_token': `{{ config('mapbox.mapbox_token') }}`,
            'center_location_lat': `{{ config('mapbox.center_location_lat') }}`,
            'center_location_lng': `{{ config('mapbox.center_location_lng') }}`,
        };
        const images = {
            'dp': `{{ storage_url('frontend/asset/img/dp.png') }}`
        };
        const TICKET_ID = `{{ getTicketId() }}`;
        const content_image_upload_url = "{{ route('file.ci_upload') }}";
    </script>
    <script>
        const routes = {
            'cart_products': `{{ route('cart.products') }}`,
            'cart_add': `{{ route('cart.add') }}`,
            'cart_update': `{{ route('cart.update') }}`,
            'cart_delete': `{{ route('cart.delete') }}`,
            'login': `{{ route('login') }}`,
            'city_search': `{{ route('u.as.cities') }}`,
            'getMessages': `{{ route('ticket.messages') }}`,
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
                'voucher': {
                    'check': @json(route('u.ck.voucher.check')),
                },
                'prescription': {
                    'create': @json(route('u.obp.create')),
                    'upload': @json(route('u.obp.upload')),
                    'delete': @json(route('u.obp.delete', 'id')),
                    'send_otp': @json(route('u.obp.send_otp')),
                    'resend_otp': @json(route('u.obp.resend_otp')),
                    'verify_otp': @json(route('u.obp.verify_otp')),
                }
            }
        }
    </script>


</head>

<body>
    @include('frontend.includes.preloder')
    @include('frontend.includes.chat_bubble.support')
    <header>
        @include('frontend.includes.header')
    </header>
    <main>
        <div class="container-fluid">
            @yield('content')
        </div>
    </main>
    <footer>
        @include('frontend.includes.footer')
    </footer>

    {{-- Upload Prescription Modal --}}
    @include('frontend.includes.new-upload-prescription')

    <!--========= jquery-cdn ===========-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!--======== toastr script ========-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!--======== bootstrap script ========-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--========= uikit-js ===========-->
    <script src="{{ asset('frontend/vendor/uikit/js/uikit.min.js') }}"></script>
    <script src="{{ asset('frontend/asset/js/cart.js') }}"></script>

    @stack('js_link')
    <!--========== custom-js ===========-->
    <script src="{{ asset('frontend/asset/js/custom.js') }}"></script>
    <script src="{{ asset('frontend/asset/js/support.js') }}"></script>
    <script src="{{ asset('frontend/asset/js/prescription.js') }}"></script>
    {{-- @include('frontend.includes.add_to_cart_js') --}}
    @include('frontend.includes.search_js')
    @include('frontend.includes.wishlist_js')
    {{-- @livewireScripts <!-- Include Livewire scripts here --> --}}
    @stack('js')
</body>

</html>
