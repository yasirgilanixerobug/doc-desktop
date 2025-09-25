<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

    <!-- Favicons -->
    <link type="image/x-icon" href="{{ asset(config('app.logo_favicon')) }}" rel="icon">

    <!-- external css link -->
    <link rel="stylesheet" href="{{ asset('app-assets/css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('clinic-assets/custom/css/style.css') }}">
    <!-- font color -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700&family=Poppins:wght@100;200;300;400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--script for google recaptcha-->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <title>{{ config('app.name') }}</title>

    @stack('css')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    @include('partial.app.header')

    <div class="content-wrapper">
        <!-- /.content-header -->
        @yield('content')
    </div>

    @include('partial.app.footer')


</div>

<!-- jQuery library -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

@stack('js')

</body>
</html>
