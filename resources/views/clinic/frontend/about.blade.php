@extends('layout.frontend')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="staff-main">
            <h3 class="h3-style">About us</h3>
            <hr>
            <div class="inner-cont-about">
                <div>
                    <p>{{ $clinic->about ?? 'N|A' }}</p>
                </div>
            </div>
        </div>
    </div>

{{--    <div class="col-md-4" id="side-menu-component">--}}
{{--        <x-side-menu--}}
{{--            :fullAddress="$clinicLocation->fullAddress"--}}
{{--            :phone="$clinicLocation->phone"--}}
{{--            :businessHours="$locationBusinessHours"--}}
{{--            :weekDays="$weekDays"--}}
{{--        ></x-side-menu>--}}
{{--    </div>--}}
</div>
@endsection
