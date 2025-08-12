@extends('layout.frontend')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="staff-main">
            <div class="staff-details d-flex justify-content-start align-items-center">
                <div><a href="{{ route('clinicFrontend.provider', ['subdomain' => request()->subdomain ]) }}"><i class="fa-solid fa-angle-left set-li-icon"></i></a></div>
                <div class="details-inner"><img style="border-radius: 50%;" width="70" height="70" src="{{ asset($provider->userDetail->image) }}" alt=""></div>
                <div class="details-inner">
                    <h5>{{ $provider->name }}</h5>
                </div>
            </div>
            <!-- <span style="padding: 5%">Here, you need to specify the location</span> -->
            
            <!-- progress bar -->
            <div class="progress-details">
                <div class="progress" style="height: 3px;">
                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="circle-one"><i class="fa-solid fa-1"></i></div>
              </div>
            </div>
            
            <!-- info div added here -->
            <div class="status-info">
              <h5>Appointment With {{ $provider->name }}</h5>
            </div>

            <!-- bootstrap tabs are started here  -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item dt-calendar">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                       aria-controls="home" aria-selected="true">Locations</a>
                </li>
                <li class="nav-item dt-calendar">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                       aria-controls="contact" aria-selected="false">About</a>
                </li>
            </ul>
            <div class="tab-content left-right" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <ul class="staff-lst-set">
                        @foreach($provider->providerLocation as $key => $providerLocation)
                        <!-- <div class="staff-lst-inner">{{ $providerLocation->location->name . ' Location' }}</div> -->
                        <!-- <li class="set-li-staff see-more"
                            data-toggle="modal"
                            data-provider-location-id="{{ $providerLocation->id }}"
                            data-btn-type="other"
                            data-target="#exampleModalCenter">
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="details-inner-img"><img src="{{ asset(config('custom.location_placeholder')) }}" alt="">
                                </div>
                                <div>
                                    <h6 class="pointer">{{ $providerLocation->location->fullAddress  }}</h6>
                                </div>
                            </div>
                        </li> -->

                        <li class="set-li-staff see-more" data-provider-location-id="{{ $providerLocation->id }}">
                            <a href="{{ route('clinicFrontend.calendar', ['subdomain' => request()->subdomain, 'provider_location_id' => encrypt($providerLocation->id)]) }}">
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="details-inner-img">
                                        <img src="{{ asset(config('custom.location_placeholder')) }}" alt="">
                                    </div>
                                    <div class="sl-sataff-details">
                                        <div>
                                            <h6 class="pointer">{{ $providerLocation->location->fullAddress  }}</h6>
                                        </div>
                                        <div class="staff-lst-inner">({{ $providerLocation->location->name . ' Location' }})</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <p class="cls-about">{{ $provider->userDetail->about ?? 'N\A' }}</p>
                </div>
            </div>
            <!-- bootstrap tabs are end here  -->
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

<!-- Modal -->
<!-- <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Available Time Slots</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body model-td"></div>
            <div class="modal-footer model-td">
                <span><b>We will contact you to confirm your appointment times and location</b></span>
{{--                <button type="button" class="btn select-btn select-changes">Select changes</button>--}}
            </div>
        </div>
    </div>
</div> -->
@endsection

@push('js')
    <!-- <script src="{{ asset('clinic-assets/frontend/js/see-more.js') }}"></script> -->

    <script>
        $(function() {
            $('li').css('cursor', 'pointer')
            .click(function() {
                window.location = $('a', this).attr('href');
                return false;
            });
        });
    </script>
@endpush
