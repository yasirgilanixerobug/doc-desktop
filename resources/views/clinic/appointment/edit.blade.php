    <style>
        .appointment-done { background-color: #eb525b !important;color: #fff !important; }

        .avoid-clicks { pointer-events: none; }

        .time-span{
            color: var(--main-color);
            border: 1px solid var(--main-color);
            border-radius: 5px;
            padding: 0px 4px;
            margin: 4px 4px;
        }
    </style>

<div class="time-show">
    <h5 class="d-flex justify-content-center">{{ $name }}</h5>
    <div class="tab-content">
        <div class="tab-pane fade show active">
            <form>
                <div class="form-group add_bottom_45 table-condensed">
                    <div id="calendar"></div>
                    <input type="hidden" id="my_hidden_input">
                    <ul class="legend d-flex justify-content-start">
                        <li class="d-flex"><strong class="available"></strong> Available</li>
                        <li class="d-flex"><strong class="not-available"></strong> Not available
                        </li>
                    </ul>
                </div>
            </form>
            <hr>
            <div class="d-flex justify-content-center align-content-between flex-wrap">
                <div class="other-tab-data" id="available-slot-by-date">
                    @if(isset($providerAvailability['date']))
                        @forelse($providerAvailability['date']['available_time_slot'] as $key => $availability)
                            <span
                                data-start-time="{{ $availability['start_time'] }}"
                                data-date="{{ $availability['date'] }}"
                                  class="appointment-time time-span showCursor {{ ($availability['isAppointment'] == 1) ? 'appointment-done avoid-clicks' : '' }}">
                                {{ $availability['start_time'] }}
                            </span>
                        @empty
                            <span>No Appointment Available</span>
                        @endforelse
                    @else
                        <span>No Appointment Available</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let appointmentId = @json($appointmentId);
        let disableWeekDays = @json($disableWeekDays);
        let token = "{{ csrf_token() }}";
        let holidays = @json($holidays);

        $('#calendar').datepicker({
            todayHighlight: true,
            daysOfWeekDisabled: disableWeekDays,
            weekStart: 1,
            startDate: new Date(),
            format: "yyyy-mm-dd",
            datesDisabled: holidays,
        }).on('changeDate', function(e) {

            var date = e.format();
            let route = '{{ route("clinic.appointmentSetting.getAvailableTimeSlotsByDate", [":appointment_id"]) }}';
            var url = route.replace(':appointment_id', appointmentId);

            $.ajax({
                type:'POST',
                url: url,
                data: {
                    "_token": token,
                    "appointment_id": appointmentId,
                    "date": date,
                },
                success:function(response) {
                    $("#available-slot-by-date").html(response.html);
                }
            });
        });

        $(document).on('click', '.appointment-time', function() {
            if (confirm('Are you sure to change the appointment?')) {
                var appointmentStartTime  = $(this).data('start-time');
                var appointmentDate  = $(this).data('date');
                let route = '{{ route("clinic.appointmentSetting.update", [":appointment_id"]) }}';
                var url = route.replace(':appointment_id', appointmentId);

                $.ajax({
                    type:'PATCH',
                    url: url,
                    data: {
                        "_token": token,
                        "appointment_start_time": appointmentStartTime,
                        "date": appointmentDate,
                    },
                    success:function(response) {

                        if (response.status === 'error')
                        {
                            toastr.error(response.message);
                        } else {
                            toastr.success(response.message);
                        }

                        setTimeout(function() {
                            location.reload()
                        }, 2000);
                    }
                });
            }
        });
    });
</script>

