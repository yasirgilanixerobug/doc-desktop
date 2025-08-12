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

    .set-up-down{
        padding-bottom: 25px;
        display: flex;
        flex-flow: row wrap;
        justify-content: center;
        align-content: space-between;
    }
</style>

<div class="time-show">
    <h5 class="d-flex justify-content-center">{{ $name }}</h5>
    <ul class="nav nav-pills mb-3 d-flex justify-content-between" id=" pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link custom-btn {{ ($btnType == 'today') ? 'active' : '' }}" data-tab="0" id="pills-today-tab" data-toggle="pill"
               href="#pills-today-3" role="tab" aria-controls="pills-today"
               aria-selected="true">{{ date('D', strtotime(date('d-m-Y'))) }} <br>{{ date('M d') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link custom-btn {{ ($btnType == 'tomorrow') ? 'active' : '' }}" data-tab="1" id="pills-tomorrow-tab" data-toggle="pill"
               href="#pills-tomorrow-3" role="tab" aria-controls="pills-tomorrow"
               aria-selected="false">{{ date('D', strtotime(date('d-m-Y', strtotime('+1 days')))) }} <br> {{ date('M d', strtotime('tomorrow')) }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link custom-btn {{ ($btnType == 'thirdDay') ? 'active' : '' }}" data-tab="1" id="pills-third-day-tab" data-toggle="pill"
               href="#pills-third-day-3" role="tab" aria-controls="pills-third-day"
               aria-selected="false">{{ date('D', strtotime(date('d-m-Y', strtotime('+2 days')))) }} <br> {{ date('M d', strtotime('+2 days')) }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link custom-btn {{ ($btnType == 'other') ? 'active' : '' }}" data-tab="2" id="pills-other-tab" data-toggle="pill"
               href="#pills-other-3" role="tab" aria-controls="pills-other"
               aria-selected="false">Others <br> Dates</a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent-3">
        <div class="tab-pane fade {{ ($btnType == 'today') ? 'show active' : '' }}" id="pills-today-3" role="tabpanel"
             aria-labelledby="pills-today-tab">
            <div class="d-flex justify-content-center align-content-between flex-wrap">
                <div class="today-tab-data set-up-down">
                    @if(isset($providerAvailability['today']))
                        @forelse($providerAvailability['today']['available_time_slot'] as $key => $availability)
                            <span data-appointment="{{ encrypt($providerAvailability['today']['provider_location_id'].'|'.$availability['start_time'].'|'.$availability['date'].'|'.request()->subdomain ) }}"
                                  class="appointment-time time-span {{ ($availability['isAppointment'] == 1) ? 'appointment-done avoid-clicks' : '' }}">
                                {{ $availability['start_time'] }}
                            </span>
                        @empty
                            <span class="time-span avoid-clicks">No Appointment Available</span>
                        @endforelse
                    @else
                        <span class="time-span avoid-clicks">No Appointment Available</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="tab-pane fade {{ ($btnType == 'tomorrow') ? 'show active' : '' }}" id="pills-tomorrow-3" role="tabpanel"
             aria-labelledby="pills-tomorrow-tab">
            <div class="d-flex justify-content-center align-content-between flex-wrap">
                <div class="tomorrow-tab-data set-up-down">
                    @if(isset($providerAvailability['tomorrow']))
                        @forelse($providerAvailability['tomorrow']['available_time_slot'] as $key => $availability)
                            <span data-appointment="{{ encrypt($providerAvailability['tomorrow']['provider_location_id'].'|'.$availability['start_time'].'|'.$availability['date'].'|'.request()->subdomain ) }}"
                                class="appointment-time time-span {{ ($availability['isAppointment'] == 1) ? 'appointment-done avoid-clicks' : '' }}">
                                {{ $availability['start_time'] }}
                            </span>
                            @empty
                                <span class="time-span avoid-clicks">No Appointment Available</span>
                        @endforelse
                    @else
                        <span class="time-span avoid-clicks">No Appointment Available</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="tab-pane fade {{ ($btnType == 'thirdDay') ? 'show active' : '' }}" id="pills-third-day-3" role="tabpanel"
             aria-labelledby="pills-third-day-tab">
            <div class="d-flex justify-content-center align-content-between flex-wrap">
                <div class="third-day-tab-data set-up-down">
                    @if(isset($providerAvailability['thirdDay']))
                        @forelse($providerAvailability['thirdDay']['available_time_slot'] as $key => $availability)
                            <span data-appointment="{{ encrypt($providerAvailability['thirdDay']['provider_location_id'].'|'.$availability['start_time'].'|'.$availability['date'].'|'.request()->subdomain ) }}"
                                  class="appointment-time time-span {{ ($availability['isAppointment'] == 1) ? 'appointment-done avoid-clicks' : '' }}">
                                {{ $availability['start_time'] }}
                            </span>
                        @empty
                            <span class="time-span avoid-clicks">No Appointment Available</span>
                        @endforelse
                    @else
                        <span class="time-span avoid-clicks">No Appointment Available</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="tab-pane fade {{ ($btnType == 'other') ? 'show active' : '' }}" id="pills-other-3" role="tabpanel"
             aria-labelledby="pills-other-tab">
            <form>
                <div class="form-group add_bottom_45 table-condensed">
                    <div id="calendar"></div>
                    <input type="hidden" id="my_hidden_input">
                    <ul class="legend d-flex justify-content-start">
                        <li class="d-flex"><strong class="available"></strong> Available</li>
                        <li class="d-flex"><strong class="not-available"></strong> No Appointment Available
                        </li>
                    </ul>
                </div>
            </form>
            <hr>
            <div class="d-flex justify-content-center align-content-between flex-wrap">
                <div class="other-tab-data set-up-down" id="available-slot-by-date">
                    @if(isset($providerAvailability['today']))
                        @forelse($providerAvailability['today']['available_time_slot'] as $key => $availability)
                            <span data-appointment="{{ encrypt($providerAvailability['today']['provider_location_id'].'|'.$availability['start_time'].'|'.$availability['date'].'|'.request()->subdomain ) }}"
                                  class="appointment-time time-span {{ ($availability['isAppointment'] == 1) ? 'appointment-done avoid-clicks' : '' }}">
                                {{ $availability['start_time'] }}
                            </span>
                        @empty
                            <span class="time-span avoid-clicks">No Appointment Available</span>
                        @endforelse
                    @else
                        <span class="time-span avoid-clicks">No Appointment Available</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone-with-data-2012-2022.min.js"></script>--}}

<script>
    $(document).ready(function() {
        //var localtz = moment.tz.guess();
        //const date = time.clone().tz(localtz);
        //console.log(new Date());

        let providerId = @json($providerId);
        let locationId = @json($locationId);
        let disableWeekDays = @json($disableWeekDays);
        let holidays = @json($holidays);
        let subdomain = '{{ request()->subdomain }}';
        let token = "{{ csrf_token() }}";

        $('#calendar').datepicker({
            todayHighlight: true,
            daysOfWeekDisabled: disableWeekDays,
            weekStart: 1,
            startDate: new Date(),
            format: "yyyy-mm-dd",
            datesDisabled: holidays,
        }).on('changeDate', function(e) {

            var date = e.format();
            let route = '{{ route("clinicFrontend.getAvailableTimeSlotsByDate", [":subdomain"]) }}';
            let url = route.replace(':subdomain', subdomain);

            $.ajax({
                type:'POST',
                url: url,
                data: {
                    "_token": token,
                    "subdomain": subdomain,
                    "provider_id": providerId,
                    "location_id": locationId,
                    "date": date,
                },
                success:function(response) {
                    $("#available-slot-by-date").html(response.html);
                }
            });

            // $('.close').on('click', function(){
            //     alert('clse modal');
            //     $("#availableTimeSlotsModal").modal('hide');
            // });

            // $('#availableTimeSlotsModalCancelBtn').on('click', function(){
            //     $("#availableTimeSlotsModal").modal('hide');
            // });
        });
    });
</script>
