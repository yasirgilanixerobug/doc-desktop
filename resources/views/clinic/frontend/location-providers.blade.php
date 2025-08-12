@extends('layout.frontend')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="staff-main">

                <div class="staff-details d-flex justify-content-start align-items-center">
                    <div><a href="{{  route('clinicFrontend.location', ['subdomain' => request()->subdomain]) }}"><i class="fa-solid fa-angle-left set-li-icon"></i></a></div>
                    <div class="details-inner"><img style="border-radius: 50%;" width="70" height="70" src="{{ isset($providerLocations[0]) ? asset($providerLocations[0]->location->image) : '' }}" alt=""></div>
                    <div class="details-inner">
                        <h5>{{ isset($providerLocations[0]) ? $providerLocations[0]->location->name : 'Not Found' }}</h5>
                    </div>
                </div>
                <!-- <span style="padding: 5%">Here, you need to specify the provider</span> -->
                
                <!-- progress bar -->
                <div class="progress-details">
                    <div class="progress" style="height: 3px;">
                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="circle-one"><i class="fa-solid fa-1"></i></div>
                  </div>
                </div>
                
                <!-- info div added here -->
                <div class="status-info">
                  <h5>Appointment in {{ isset($providerLocations[0]) ? $providerLocations[0]->location->name : 'N\A' }}</h5>
                </div>

                <hr>
                <ul class="staff-lst-set">
                    @forelse($providerLocations as $Key => $providerLocation)
                        @if($providerLocation->provider)
                        <li class="set-li-staff see-more d-flex justify-content-between align-items-center"
                            data-provider-location-id="{{ $providerLocation->id }}">
                            <a href="{{ route('clinicFrontend.calendar', ['subdomain' => request()->subdomain, 'provider_location_id' => encrypt($providerLocation->id)]) }}">
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="details-inner-img">
                                        <img style="border-radius: 50%;" src="#" alt="">
                                    </div>
                                    <div>
                                        <h6 class="pointer">{{ $providerLocation->provider->name  }}</h6>
                                    </div>
                                </div>
                            </a>
                            <div><i class="fa-solid fa-angle-right set-li-icon"></i></div>
                        </li>
                        @endif
                    @empty
                    <!-- if result or file not found   -->
                        <x-not-found></x-not-found>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>


    <!-- Modal -->
<!--     <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
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

