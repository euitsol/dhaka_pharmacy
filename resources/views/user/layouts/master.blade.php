<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Home') - User Dashboard</title>
    <link rel="icon" href="{{ storage_url(settings('site_favicon')) }}">
    <!------- Bootstrap-CSS-CDN-Link ------->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!------ Custom-CSS ------->
    <link rel="stylesheet" href="{{asset('user/asset/css/header.css')}}">
    <link rel="stylesheet" href="{{asset('user/asset/css/footer.css')}}">
    <link rel="stylesheet" href="{{asset('user/asset/css/dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('user/asset/css/style.css')}}">
    <!------- Google-Font -------->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Itim&display=swap" rel="stylesheet">
    <!------- Font-Awesome-CDN --------->
    <script src="https://kit.fontawesome.com/db6820c2b5.js" crossorigin="anonymous"></script>
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
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>