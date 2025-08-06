<style>
    .appointment-done {
        background-color: #eb525b !important;
        color: #fff !important;
    }

    .avoid-clicks {
        pointer-events: none;
    }
</style>

@forelse($providers as $key => $data)
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="details d-flex justify-content-start">
                <div class="img-tag"><img src="{{ asset($data['userDetail']['image']) }}" alt=""></div>
                <div class="inner-text">
                    <a href="{{ route('clinicFrontend.providerProfile', ['subdomain' => request()->subdomain, 'provider' => $data['provider']['id'] ]) }}"><h5>{{ $data['provider']['name'] }}</h5></a>
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
                        <span>No Appointment Available</span>
                    @endforelse
                @else
                    <span>No Appointment Available</span>
                @endif
            </div>
            <!-- Button trigger modal -->
            <button type="button" class="btn see-more select-btn"
                    data-toggle="modal"
                    data-btn-type="other"
                    data-provider-location-id="{{ $data['providerLocation']['id'] }}"
                    data-target="#exampleModalCenter">
                see more!
            </button>
        </div>
    </div>
    @empty
        <!-- if result or file not found   -->
        <x-not-found></x-not-found>
@endforelse
