@extends('layout.clinic')

@section('title', 'Appointment Calendar')

@push('css')
    <!-- fullCalendar -->
{{--    <link rel="stylesheet" href="{{ asset('/clinic-assets/plugins/fullcalendar/main.css') }}">--}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.css">
@endpush

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

{{--            <div class="row">--}}
{{--                @foreach($appointmentStatus as $ke => $status)--}}
{{--                <div class="col-2 col-sm-2" id="status">--}}
{{--                        <div class="info-box {{ $status['color']  }}">--}}
{{--                            <div class="info-box-content">--}}
{{--                                <span class="info-box-number text-center {{ $status['color']  }} mb-0">{{$status['name'] }}</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                </div>--}}
{{--                @endforeach--}}
{{--            </div>--}}

            <div class="row">
                <!-- /.col -->
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-body p-0">
                            <div class="search-container" style="text-align-last: center; padding-left: 30%; padding-right: 30%">
                                <label>Select Provider</label>
                                <select class="custom-select" id="clinic_provider">
                                    <option value="">All Providers</option>
                                    @foreach($providers as $key => $provider)
                                        <option value="{{ $provider->id }}" {{ ($provider->id == request()->provider_id) ? 'Selected' : '' }} >{{ $provider->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex flex-row justify-content-center">
                            @foreach($appointmentStatus as $ke => $status)
                                <span class="mr-2">
                                    <i class="fas fa-square {{ $status['color'] }}"></i> {{ $status['name'] }}
                                </span>
                            @endforeach
                        </div>
                            <!-- THE CALENDAR -->
                        <div id="calendar"></div>
                    </div>
                        <!-- /.card-body -->
                </div>
                    <!-- /.card -->
            </div>
                <!-- /.col -->
        </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('js')
    <!-- jQuery UI -->
{{--    <script src="{{ asset('/clinic-assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>--}}
    <!-- fullCalendar 2.2.5 -->
{{--    <script src="{{ asset('/clinic-assets/plugins/moment/moment.min.js') }}"></script>--}}
{{--    <script src="{{ asset('/clinic-assets/plugins/fullcalendar/main.js') }}"></script>--}}
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('/clinic-assets/dist/js/demo.js') }}"></script>
    <!-- Page specific script -->

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.js"></script>

    <script>
        $(function () {
            let token = "{{ csrf_token() }}";
            var appointments = @json($appointments);
            /* initialize the calendar
             -----------------------------------------------------------------*/

            var Calendar = FullCalendar.Calendar;
            var calendarEl = document.getElementById('calendar');


            var calendar = new Calendar(calendarEl, {
                timeZone: 'Asia/Karachi',
                headerToolbar: {
                    left  : 'prev,next today',
                    center: 'title',
                    right : 'dayGridMonth,timeGridWeek,timeGridDay'
                },

                eventDidMount: function(info) {
                    $(info.el).tooltip({
                        title: info.event.extendedProps.description,
                        placement: "top",
                        trigger: "hover",
                        container: "body"
                    });
                },

                eventClick: function(info) {
                    info.jsEvent.preventDefault(); // don't let the browser navigate

                    var route = '{{ route("clinic.appointmentSetting.detail", ":appointment_id") }}';
                    url = route.replace(':appointment_id', info.event.id);

                    if (info.event.url) {
                        window.open(url);
                    }
                },

                themeSystem: 'bootstrap',
                //Random default events
                events: appointments,
                editable  : true,
                droppable : true, // this allows things to be dropped onto the calendar !!!

                eventDrop: function(info) {
                    //var eventChangeMessage = " was dropped on " + info.event.start.toISOString();
                    var date = info.event.start.toISOString()

                    let route = "{{ route('clinic.appointmentSetting.update', [":appointment_id"]) }}";
                    let appointment_id =  info.event.id;
                    let url = route.replace(':appointment_id', appointment_id);

                    $.ajax({
                        url: url,
                        type: 'PATCH',
                        data: {
                            _token: token,
                            appointment_id: appointment_id,
                            date: date,
                        },
                        success: function(response) {
                            if (response.status === 'error')
                            {
                                info.revert();
                                toastr.error(response.message);
                            } else {
                                toastr.success(response.message);
                            }
                        },
                        error: function(xhr) {
                            toastr.error('something went wrong');
                        }
                    });

                }
            });

            calendar.render();

            //on change providers
            $(document).on('change', '#clinic_provider',  function() {
                let route = "{{ route('clinic.calendar', [":provider_id"]) }}";
                let providerId = $(this).val();
                let url = route.replace(':provider_id', providerId);
                window.location.replace(url);
            });
        })
        </script>
@endpush
