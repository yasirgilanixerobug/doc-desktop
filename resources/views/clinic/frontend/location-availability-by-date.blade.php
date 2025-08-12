<style>
    .appointment-done {
        background-color: #eb525b !important;
        color: #fff !important;
    }

    .avoid-clicks {
        pointer-events: none;
    }

    .time-span{
        color: var(--main-color);
        border: 1px solid var(--main-color);
        border-radius: 5px;
        padding: 0px 4px;
        margin: 4px 4px;
    }
</style>

@if (app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName() === 'clinicFrontend.home')
    @if(isset($providerAvailability['date']) && $providerAvailability['date']['is_available'] == 1)
        @forelse($providerAvailability['date']['available_time_slot'] as $key => $availability)
            <span data-appointment="{{ encrypt($providerAvailability['date']['provider_location_id'].'|'.$availability['start_time'].'|'.$availability['date'].'|'.request()->subdomain ) }}"
                  class="appointment-time time-span {{ ($availability['isAppointment'] == 1) ? 'appointment-done avoid-clicks' : '' }}">
                {{ $availability['start_time'] }}
            </span>
        @empty
            <span>No Appointment Available</span>
        @endforelse
    @else
        <span>No Appointment Available</span>
    @endif
@else
    <ul>
    @if(isset($providerAvailability['date']) && $providerAvailability['date']['is_available'] == 1)
        @forelse($providerAvailability['date']['available_time_slot'] as $key => $availability)
            <li data-appointment="{{ encrypt($providerAvailability['date']['provider_location_id'].'|'.$availability['start_time'].'|'.$availability['date'].'|'.request()->subdomain ) }}"
                class="appointment-time time-span {{ ($availability['isAppointment'] == 1) ? 'appointment-done avoid-clicks' : '' }}">
                @if ($availability['isAppointment'] == 1) 
                    <del>{{ $availability['start_time'] }}</del>
                    @else 
                    {{ $availability['start_time'] }} 
                @endif
            </li>
        @empty
            <li>No Appointment Available</li>
        @endforelse
    @else
        <li>No Appointment Available</li>
    @endif
    </ul>
@endif
