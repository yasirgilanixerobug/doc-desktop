@extends('layout.frontend')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="staff-main">
            <h3 class="h3-style">Reviews</h3>
            <hr>
            <div class="inner-cont-review">
                <div><i class="fa-solid fa-comment-dots"></i></div>
                <div>
                    <h5>There are no reviews yet</h5>
                </div>
                <div>
                    <p>Would you like to share your feedback? Leave </p>
                    <p>a review about your experience.</p>
                </div>
                <div>
                    <button type="button" class="btn select-btn" data-target="#">
                        write review
                    </button>
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
