@extends('layout.frontend')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="search-container">
            <label class="select-location">Select Location</label>
            <select class="custom-select" id="clinic_location">
                <option>Select Location</option>
                @foreach($clinicLocations as $key => $location)
                    <option value="{{ $location->id }}" {{ ($location->id == $clinicCurrentLocation->id) ? 'Selected' : '' }} >{{ $location->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="row" id="providers">
            @forelse($providers as $key => $data)
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="details d-flex justify-content-start">
                        <div class="img-tag"><img src="{{ asset($data['userDetail']['image']) }}" alt=""></div>
                        <div class="inner-text">
                            <a href="{{ route('clinicFrontend.providerProfile', ['subdomain' => request()->subdomain, 'provider' => encrypt($data['provider']['id']) ]) }}"><h5>{{ $data['provider']['name'] }}</h5></a>
                            <p class="set-crd-txt">{{ $data['userDetail']['about'] ?  Str::of($data['userDetail']['about'])->words(12, ' ....') : 'N\A' }}</p>
                        </div>
                    </div>
                        <ul class="nav nav-pills d-flex justify-content-around" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="btn see-more select-btn set-extend set-extend-active" data-btn-type="today"
                                        data-toggle="modal"
                                        data-provider-location-id="{{ $data['providerLocation']['id'] }}"
                                        data-target="#exampleModalCenter">
                                    <span class="extend set-extend-active">{{ date('D', strtotime(date('d-m-Y'))) }} <br> {{ date('M d') }}</span>
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="btn see-more select-btn set-extend" data-btn-type="tomorrow" data-toggle="modal"
                                        data-provider-location-id="{{ $data['providerLocation']['id'] }}"
                                        data-target="#exampleModalCenter">
                                    {{ date('D', strtotime(date('d-m-Y', strtotime('+1 days')))) }} <br><span class="extend">{{ date('M d', strtotime('tomorrow')) }}</span>
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="btn see-more select-btn set-extend" data-btn-type="thirdDay" data-toggle="modal"
                                        data-provider-location-id="{{ $data['providerLocation']['id'] }}"
                                        data-target="#exampleModalCenter">
                                    {{ date('D', strtotime(date('d-m-Y', strtotime('+2 days')))) }} <br><span class="extend">{{ date('M d', strtotime('+2 days')) }}</span>
                                </button>
                            </li>
                        </ul>
                        <div class="set-up-down">
                        @if(isset($data['providerLocationAvailability']['available_time_slot']))
                            @forelse($data['providerLocationAvailability']['available_time_slot'] as $timeSlotKey => $slot)
                                @if($loop->iteration <= 9)
                                    <span data-appointment="{{ encrypt($data['providerLocation']['id'].'|'.$slot['start_time'].'|'.$slot['date'].'|'.request()->subdomain ) }}"
                                          class="appointment-time time-span {{ ($slot['isAppointment'] == 1) ? 'appointment-done avoid-clicks' : '' }}">{{ $slot['start_time'] }}</span>
                                @else
                                    @break
                                @endif
                            @empty
                                    <span class="appointment-time time-span avoid-clicks">No Appointment</span>
                            @endforelse
                        @else
                                <span class="appointment-time time-span avoid-clicks">No Appointment</span>
                        @endif
                    </div>
                    <!-- Button trigger modal -->
                        <button type="button" class="btn see-more select-btn" data-toggle="modal"
                                data-provider-location-id="{{ $data['providerLocation']['id'] }}"
                                data-btn-type="other"
                                data-target="#exampleModalCenter">
                            see more!
                        </button>
                </div>
            </div>
            @empty
                <!-- if result or file not found   -->
                <x-not-found></x-not-found>
            @endforelse
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
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
{{--                    <button type="button" class="btn select-btn select-changes">Select changes</button>--}}
                </div>
            </div>
        </div>
    </div>

    <!-- Direction Right SideBar -->
{{--    <div class="col-md-4" id="side-menu-component">--}}
{{--        <x-side-menu--}}
{{--            :fullAddress="$clinicCurrentLocation->fullAddress"--}}
{{--            :phone="$clinicCurrentLocation->phone"--}}
{{--            :businessHours="$locationBusinessHours"--}}
{{--            :weekDays="$weekDays"--}}
{{--        ></x-side-menu>--}}
{{--    </div>--}}
</div>
@endsection

@push('js')
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone-with-data-2012-2022.min.js"></script>--}}
<script src="{{ asset('clinic-assets/frontend/js/see-more.js') }}"></script>
<script>
        $(document).ready(function () {
            //on location change get location providers
            $(document).on('change', '#clinic_location',  function() {
                let route = config.routes.getProvidersByLocation;
                let locationId = $(this).val();
                let url = route.replace(':subdomain', config.data.subdomain);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: config.data.token,
                        location_id: locationId,
                        //time_zone: timeZone,
                    },
                    success: function(response) {
                        $("#providers").html(response.html);
                        //$("#side-menu-component").html(response.sideMenu);
                    },
                    error: function(xhr) {
                        //Do Something to handle error
                    }
                });
            });
        });
    </script>
@endpush
