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

@if(isset($providerAvailability['date']))
    @forelse($providerAvailability['date']['available_time_slot'] as $key => $availability)
        <span data-start-time="{{ $availability['start_time'] }}"
              data-date="{{ $availability['date'] }}"
              class="appointment-time time-span showCursor {{ ($availability['isAppointment'] == 1) ? 'appointment-done avoid-clicks' : '' }}">{{ $availability['start_time'] }}</span>
    @empty
        <span>No Appointment Available</span>
    @endforelse
@else
    <span>No Appointment Available</span>
@endif
