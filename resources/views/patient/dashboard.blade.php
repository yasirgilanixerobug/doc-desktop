@extends('layout.patient')
@push('css')
    <style>
        .appointment-done { background-color: #eb525b !important;color: #fff !important; }

        .avoid-clicks { pointer-events: none; }

        .time-span{
            color: var(--main-color);
            border: 1px solid var(--main-color);
            border-radius: 5px;
            padding: 0px 4px;
            margin: 4px 4px;
            display: inline-block;
            width: 60px;
            align-items: center;
        }
    </style>
@endpush
@section('content')
<div class="home-home">
{{--    <h3 class="home-welcom">Home</h3>--}}
    <div class="row">
        <div class="col-md-12">
            <div class="patient-home">
                <div class="patient-welcom mb-3">
                    <h3>Appointments</h3>
                </div>
                <!-- bootstrap tabs are started here  -->
                <ul class="nav appoint-nav-tabs"
                    id="myTab"
                    role="tablist">
                    <li class="nav-item">
                        <a class="appoint-nav-link {{ (request()->type === 'upcoming') ? 'active' : '' }}"
                           href="{{ route('patient.dashboard', ['type' => 'upcoming']) }}"
                           aria-selected="true">Upcoming</a>
                    </li>
                    <li class="nav-item">
                        <a class="appoint-nav-link {{ (request()->type === 'past') ? 'active' : '' }}"
                           href="{{ route('patient.dashboard', ['type' => 'past']) }}"
                           aria-selected="false">Past</a>
                    </li>
                </ul>
                <div class="tab-content left-right home-border"
                     id="myTabContent">
                    <div class="tab-pane fade show active"
                         id="home"
                         role="tabpanel"
                         aria-labelledby="home-tab">
                        <div class="patient-table-content">
                            <!--Appointment can change before 24 hours added here  -->
{{--                            <div class="container">--}}
{{--                                <div class="news">--}}
{{--                                    <div class="news-content">--}}
{{--                                        <i class="fa-solid fa-triangle-exclamation"></i>--}}
{{--                                        <p>Appointment can change before 24 hours.</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <!-- Appointment can change before 24 hours ended here -->
                            @if($appointments->count() != 0)

                            <table class="table table-borderless table-responsive">
                                <thead scope="row" class="table-head-set">
                                <tr>
                                    <th scope="col">Clinic</th>
                                    <th scope="col">Provider</th>
                                    <th scope="col">Appointment Time</th>
                                    <th scope="col">Location Address</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($appointments as $key => $appointment)
                                    @php
                                        if(now() < $appointment->date) {
                                            $startTime = \Carbon\Carbon::parse(now());
                                            $finishTime = \Carbon\Carbon::parse($appointment->date);
                                            $totalDuration = $finishTime->diffInHours($startTime);

                                            $isDate = 'future';
                                        } else {
                                            $isDate = 'past';
                                            $totalDuration = 36;
                                        }

                                    @endphp
                                    <tr scope="row" class="table-row-set">
                                        <td>{{ $appointment->clinic->name }}</td>
                                        <td>{{ ($appointment->provider->userDetail->first_name)
                                                ? $appointment->provider->userDetail->first_name. ' '.$appointment->provider->userDetail->last_name
                                                : $appointment->provider->name }}</td>
                                        <td>{{ date(config('app.default_date_format_string'), strtotime($appointment->date)) }}<br /><b><small>{{ $appointment->start_time }}</small></b></td>
                                        <td>{{ $appointment->location->fullAddress }}</td>
                                        <td><span class="status-panding">{{ $appointment->status->name }}</span></td>
                                        <td>
{{--                                            <button class="button-81" role="button">--}}
{{--                                                Cancel--}}
{{--                                            </button>--}}
                                            @if(in_array($appointment->appointment_status_id,[1,5]))
                                            <button type="button"
                                                    id="change_appointment"
                                                    class="btn button-81"
                                                    data-toggle="modal"
                                                    data-appointment-id="{{ ($isDate === 'future' && $totalDuration >= 36) ? encrypt($appointment->id) : '' }}"
                                                    data-target="#exampleModalCenter"
                                                    {{ ($isDate === 'future' && $totalDuration >= 36) ? encrypt($appointment->id) : 'disabled' }}
                                                    >
                                                Change
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @else
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <i class="fa-regular fa-calendar-xmark no-appoint pb-2"></i>
                                                <a href="#"><h5 class="card-title text-danger">Not Found</h5></a>
                                                <p class="card-text">No Record Found</p>
                                            </div>
                                        </div>
                                    </div>
                            @endif
                        </div>
                        <!-- pagination added here! -->
{{--                        <ul class="pagination justify-content-end">--}}
{{--                            <li class="page-item disabled"><span class="page-link">Previous</span></li>--}}
{{--                            <li class="page-item"><a class="page-link" href="#">1</a></li>--}}
{{--                            <li class="page-item active"><span class="page-link">2</span></li>--}}
{{--                            <li class="page-item"><a class="page-link" href="#">3</a></li>--}}
{{--                            <li class="page-item"><a class="page-link" href="#">Next</a></li>--}}
{{--                        </ul>--}}
                        <!-- pagination ended here! -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <img src="{{ asset('/patient-assets/img/color-fill36.png') }}"
                        alt="card-logo"/>
                    <a href="{{ route('patient.allPractices') }}"><h5 class="card-title">Request Appointment</h5></a>
                    <p class="card-text">
                        Click here to request an appointment.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="">
                <div class="card">
                    <div class="card-body">
                        <img src="{{ asset('/patient-assets/img/colorfill-13.png') }}"
                            alt="card-logo"/>
                        <a href="{{ route('patient.profile') }}"><h5 class="card-title">Profile</h5></a>
                        <p class="card-text">
                            This includes the patient's information, health insurance document and medical history document.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
            <div class="modal-body model-td available-time-modal-body"></div>
            <div class="modal-footer model-td">
                <button type="button" class="btn select-btn select-changes">Select changes</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        $(document).ready(function (){
            const token = "{{ csrf_token() }}";

            $('#change_appointment').on('click', function(){
                let appointmentId = $(this).data('appointment-id');
                let route = "{{ route('clinic.appointmentSetting.edit', [":appointment_id"]) }}";
                var url = route.replace(':appointment_id', appointmentId);

                $.ajax({
                    url: url,
                    type: 'get',
                    success: function(response) {
                        $("#exampleModalCenter").appendTo("body").modal('show');
                        $(".available-time-modal-body").html(response.html);
                    },
                    error: function(xhr) {
                        toastr.error('something wrong');
                    }
                });
            });

            $(document).on('click', '.close',function(){
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });
    </script>
@endpush
