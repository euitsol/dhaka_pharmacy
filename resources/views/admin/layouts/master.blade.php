<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title> @yield('title', 'Admin Dashboard') - Dhaka Pharmacy </title>

    <!-- Favicon -->
    <link rel="icon" href="{{ storage_url(settings('site_favicon')) }}">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Favicon-->
    <link rel="icon" href="" type="image/png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    {{-- White Dashboard --}}
    <link href="{{ asset('white') }}/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ asset('white') }}/css/white-dashboard.css?v=1.0.0" rel="stylesheet" />
    <link href="{{ asset('white') }}/css/theme.css" rel="stylesheet" />
    <!--======== toastr css ========-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('admin/css/custom.css') }}" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('css_link')
    @stack('css')
    <script>
        const mapbox_token = `{{ config('mapbox.mapbox_token') }}`;
        const map_center = `[{{ config('mapbox.center_location_lng') }}, {{ config('mapbox.center_location_lat') }}]`;
        const pharmacy_radious = `{{ config('mapbox.pharmacy_radious') }}`;
        const mapbox_style_id = `{{ config('mapbox.mapbox_style_id') }}`;
        const audio_url = `{{ asset('admin/mp3/order-notification.mp3') }}`;
        const admin_id = `{{ admin() ? admin()->id : false }}`;
        const content_image_upload_url = "{{ route('file.ci_upload') }}";
    </script>
    <script>
        window.AppConfig = {
            'urls': {
                'product': {
                    'generics': @json(route('product.generic_name.search')),
                    'categories': @json(route('product.product_category.search')),
                    'sub_categories': @json(route('product.product_sub_category.search')),
                    'companies': @json(route('product.company_name.search')),
                    'units': @json(route('product.medicine_unit.search')),
                    'bulk_create': @json(route('product.medicine.store.bulk_entry')),
                },
                'file': {
                    'upload': @json(route('file.upload')),
                    'delete': @json(route('file.delete')),
                },
                'obp': {
                    'product_search': @json(route('obp.search.obp_details')),
                    'delivery_address': @json(route('obp.list.obp_details'))
                }

            }
        }
    </script>
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
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('admin/js/realtime-notification.js') }}"></script>
    <script src="{{ asset('ckEditor5/main.js') }}"></script>
    @stack('js_link')

    @stack('js')



</body>

</html>
