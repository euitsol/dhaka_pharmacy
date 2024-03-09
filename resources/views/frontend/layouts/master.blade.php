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

    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">

    
    <!--========== bootstrap css ==========-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!--======== toastr css ========-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
<!--======== toastr script ========-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!--======== bootstrap script ========-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>
<!--========= uikit-js ===========-->
<script src="{{ asset('frontend/vendor/uikit/js/uikit.min.js') }}"></script>
@stack('js_link')
<!--========== custom-js ===========-->
<script src="{{ asset('frontend/asset/js/custom.js') }}"></script>
@include('frontend.includes.add_to_cart')
{{-- @livewireScripts <!-- Include Livewire scripts here --> --}}
@stack('js')

<script>
    $(document).ready(function() {
        var searchInput = $('#searchInput');
        var categorySelect = $('#categorySelect');
        var suggestionBox = $('#suggestionBox');

        searchInput.on('input', function() {

            searchFunction()

        });
        categorySelect.on('change', function() {
            searchFunction()
        });

        function searchFunction() {
            var search_value = searchInput.val();
            var category = categorySelect.val();
            if (search_value === '') {
                suggestionBox.hide();
                $('.header-section .search-filter input').css('border-radius', '10px 0 0 10px');
                $('.header-section .search-filter .sub-btn').css('border-radius', '0px 10px 11px 0');
            } else {
                suggestionBox.show();
                $('.header-section .search-filter input').css('border-radius', '10px 0 0 0');
                $('.header-section .search-filter .sub-btn').css('border-radius', '0px 10px 0 0');
                var url =
                    "{{ route('home.product.search', ['search_value' => ':search', 'category' => ':category']) }}";
                var _url = url.replace(':search', search_value).replace(':category', category);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var result = ''
                        if (!data.products || data.products.length === 0) {
                            result = `
                                    <span class="text-danger text-center d-block my-5">Medicine Not Found</span>
                                `;
                        }
                        data.products.forEach(function(product) {
                            let route = (
                            "{{ route('product.single_product', ['slug']) }}");
                            let _route = route.replace('slug', product.slug);
                            result += `
                                <a href="${_route}">
                                    <div class="card search_item mb-2">
                                        <div class="card-body py-2">
                                            <div class="row align-items-center">
                                                <div class="image col-2">
                                                    <img class="w-100 border border-1 rounded-1"
                                                        src="${product.image}"
                                                        alt="${product.name}">
                                                </div>
                                                <div class="col-10 details">
                                                    <h4 class="product_title">${product.name}</h4>
                                                    <p class="product_sub_cat">${product.pro_sub_cat.name}</p>
                                                    <p>${product.generic.name}</p>
                                                    <p>${product.company.name}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            `;
                        });
                        suggestionBox.html(result);



                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching search data:', error);
                    }
                });


            }
        }
    });
</script>

</body>

</html>
