<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <!-- external css link -->
    <link rel="stylesheet" href="{{ asset('patient-assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('patient-assets/css/date_picker.css') }}">

    <!-- font color -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700&family=Poppins:wght@100;200;300;400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Favicons -->
    <link type="image/x-icon" href="{{ asset($clinicComposer->favicon  ?? config('app.logo_favicon')) }}" rel="icon">

    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('clinic-assets/plugins/toastr/toastr.min.css') }}">

    <title>{{ env('APP_NAME', 'My Doctor') }}</title>

    @stack('css')
</head>

<body>

<div class="row">
    <div class="col-md-12 wid-full">
        <div class="">
            <div class="container">
                @include('partial.patient.header')

                @yield('content')
            </div>
        </div>
    </div>
</div>


<!-- jQuery library -->
<script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Calendar -->
<script src="{{ asset('patient-assets/js/bootstrap-datepicker.js') }}"></script>

<!-- Toastr -->
<script src="{{ asset('/clinic-assets/plugins/toastr/toastr.min.js') }}"></script>

@include('flash-message')

@stack('js')

</body>
</html>
