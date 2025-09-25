<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <!-- external css link -->
    <link rel="stylesheet" href="{{ asset('clinic-assets/frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('clinic-assets/frontend/css/date_picker.css') }}">
    <link rel="stylesheet" href="{{ asset('clinic-assets/custom/css/style.css') }}">

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

    <style>
        .js-cookie-consent{
            position: inherit;
            top: 0px;
            padding: 10px;
            text-align: center;
            width: 100%;
            z-index: 9999;
            background-color: #3b5998;
            border-color: #fffacc;
            border: 1px;
            color: #fff;
        }
        .js-cookie-consent-agree {
            padding: 5px;
            background-color: #0db9f2;
            border-color: #0db9f2;
            color: #fff;
            border-radius: 5px;
        }

        * {
            --main-background-color: {{ ($clinicComposer->configuration->background_color === null)  ? '#273c75' : $clinicComposer->configuration->background_color }};
            --main-color: {{ ($clinicComposer->configuration->color === null)  ? '#273c75' : $clinicComposer->configuration->color }};
        }
    </style>

    @stack('css')
</head>

<body>

<div class="wrapper">
    @include('cookie-consent::index')

    @include('partial.frontend.nav')
    {{--    <div class="container set-main-con">--}}
    <div class="container set-main-con">
        @yield('content')
    </div>

    @include('partial.frontend.footer')

</div>

<!-- jQuery library -->
<script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Calendar -->
<script src="{{ asset('clinic-assets/frontend/js/bootstrap-datepicker.js') }}"></script>

<!-- Toastr -->
<script src="{{ asset('/clinic-assets/plugins/toastr/toastr.min.js') }}"></script>

{{-- add common component in js--}}
<x-config-js></x-config-js>

<script>
    var lastStatus = true;
    const configuration = @json($clinicComposer->configuration);
    this.interval = setInterval(() => {
        if(window.navigator.onLine){
            if (lastStatus !== true)
            {
                toastr.success("Back To Online");
                lastStatus = true;
            }
        } else {
            if (lastStatus !== false)
            {
                toastr.error("You Are Offline");
                lastStatus = false;
            }
        }

    }, 2000);

    // $(document).ready(function () {
    //     $(".color-bground").css("background-color", configuration.background_color);
    //     $(".set-extend-active").css("background-color", configuration.background_color);
    //     //$(".select-btn").css("background-color", configuration.background_color);
    //     $("body").css("color", configuration.color);
    // });


    //ajax loader
    // var $loading = $('#global-loader').hide();
    // console.log($loading);
    // $(document)
    //   .ajaxStart(function () {
    //     console.log('ajax call start');
    //     $loading.show();
    //   })
    //   .ajaxStop(function () {
    //     console.log('ajax call end');
    //     $loading.hide();
    //   });

</script>
@include('flash-message')

@stack('js')

</body>
</html>
