@extends('layout.clinic')

@section('title', 'Appointment Detail')

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
        }
    </style>

    <link href="{{ asset('clinic-assets/frontend/css/date_picker.css') }}" rel="stylesheet">
@endpush

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" data-appointment-id="{{ encrypt($appointment->id) }}">Appointment Detail</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Location</span>
                                        <span class="info-box-number text-center text-muted mb-0">{{ $appointment->location->name }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-4 {{ in_array($appointment->appointment_status_id, [2,3,4,6] ) ? 'avoid-clicks' : 'showCursor' }}" id="appointmentBtn">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Appointment</span>
                                        <span class="info-box-number text-center text-muted mb-0">{{  date(config('app.default_date_format'), strtotime($appointment->date)) .' ( '.$appointment->start_time . ' )' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-4 {{ in_array($appointment->appointment_status_id, [2,3,4,6] ) ? 'avoid-clicks' : 'showCursor' }}" id="status" data-toggle="modal" data-target="#exampleModal">
                                @switch($appointment->appointment_status_id)
                                    @case(2)
                                        @php $statusBgColor = 'bg-success'; @endphp
                                    @break

                                    @case(3)
                                        @php $statusBgColor = 'bg-warning' @endphp
                                    @break

                                    @case(4)
                                        @php $statusBgColor = 'bg-danger' @endphp
                                    @break

                                    @case(5)
                                        @php $statusBgColor = 'bg-blue' @endphp
                                    @break

                                    @default
                                        @php $statusBgColor = 'bg-light';$statusColor = 'text-muted'; @endphp
                                @endswitch
                                <div class="info-box {{ $statusBgColor  }}">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center {{ isset($statusColor) ?? '' }}">Status</span>
                                        <span class="info-box-number text-center {{isset($statusColor) ?? ''  }} mb-0">{{ $appointment->status->name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">

                                <h4>Patient</h4>
                                <div class="post clearfix">
                                    <div class="user-block">
                                        @if($appointment->userable_type === 'App\Models\User')
                                            <img class="img-circle img-bordered-sm" src="{{ $appointment->userable->userDetail->image }}" alt="User Image">
                                        @else
                                            <img class="img-circle img-bordered-sm" src="{{ $appointment->userable->image }}" alt="User Image">
                                        @endif
                                        <span class="username">
                                              <a href="#">{{ $appointment->userable->name }}</a>
                                            </span>
                                        <span class="description">Patient</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <p>
                                        <b>Reason For Visit: </b>{{ $appointment->comment ?? 'N\A' }}
                                    </p>
                                </div>

                                <h4>Provider</h4>

                                <div class="post clearfix">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="{{ $appointment->provider->userDetail->image }}" alt="user image">
                                        <span class="username">
                                          <a href="#">{{ $appointment->provider->name }}</a>
                                        </span>
                                        <span class="description">Provider</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <p> {{ ' ' }} </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                        <h3 class="text-primary"><i class="fas fa-paint-brush"></i> Appointment</h3>
                        <p class="text-muted">{{ $appointment->comment ?? 'N\A' }}</p>
                        <br>
                        <div class="text-muted">
                            <p class="text-sm">Patient Detail
                                <b class="d-block">Phone: {{ ($appointment->userable->userDetail) ? $appointment->userable->userDetail->phone : $appointment->userable->phone  }}</b>
                                <b class="d-block">Address: {{ ($appointment->userable->userDetail) ? $appointment->userable->userDetail->full_address : $appointment->userable->fullAddress }}</b>
                                <b class="d-block">DOB: {{ ($appointment->userable_type === \App\Models\GuestUser::class) ? date(config('app.default_date_format'), strtotime($appointment->userable->dob)) : date(config('app.default_date_format'), strtotime($appointment->userable->userDetail->dob))  }}</b>
                            </p>
                            <p class="text-sm">Provider Detail
                                <b class="d-block">Phone: {{ ($appointment->provider->userDetail->phone) ?? 'N\A' }}</b>
                                <b class="d-block">Address: {{ ($appointment->provider->userDetail->fullAddress) ?? 'N\A' }}</b>
                            </p>
                        </div>
                        @if($appointment->insurance)
                        <ul class="list-unstyled">
                            <br>
                            <h5 class="mt-5 text-muted">Insurance Files Download</h5>
                            @if (isset($appointment->insurance->ins_front))
                            <li>
                                <a href="{{ route('clinic.insDownload', ['file_path' => $appointment->insurance->ins_front_full_path ]) }}" class="btn-link text-secondary"><i class="far fa-fw fa-image"></i> Insurance ID Front</a>
                            </li>
                            @endif
                            @if (isset($appointment->insurance->ins_back))
                            <li>
                                <a href="{{ route('clinic.insDownload', ['file_path' => $appointment->insurance->ins_back_full_path ]) }}" class="btn-link text-secondary"><i class="far fa-fw fa-image"></i> Insurance ID Back</a>
                            </li>
                            @endif
                            @if (isset($appointment->insurance->ins_document))
                            <li>
                                <a href="{{ route('clinic.insDownload', ['file_path' => $appointment->insurance->ins_document_full_path ]) }}" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i> Insurance ID Document</a>
                            </li>
                            @endif
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>

    <!-- Modal Status Change -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <a class="btn btn-app bg-blue
                        {{ (in_array($appointment->appointment_status_id, [2,3,4,5,6])) ? 'disabled' : 'statusBtn' }}"
                       data-id="5">
                        <i class="fas fa-check"></i> Confirm
                    </a>
                    <a class="btn btn-app bg-success
                       {{ (in_array($appointment->appointment_status_id, [2,3,4,6])) ? 'disabled' : 'statusBtn' }}"
                       data-id="2">
                        <i class="fas fa-clipboard-check"></i> Complete
                    </a>
                    <a class="btn btn-app bg-danger
                        {{ (in_array($appointment->appointment_status_id, [2,3,4,6])) ? 'disabled' : 'statusBtn' }}"
                       data-id="4">
                        <i class="fas fa-eye-slash"></i> No Show
                    </a>
                    <a class="btn btn-app bg-warning
                        {{ (in_array($appointment->appointment_status_id, [2,3,4,6])) ? 'disabled' : 'statusBtn' }}"
                       data-id="3">
                        <i class="fas fa-user-nurse"></i> Cancel By Provider
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->

    <!-- Modal Available Time Slots HTML -->
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
    <!-- SPECIFIC SCRIPTS -->
    <script src="{{ asset('clinic-assets/frontend/js/bootstrap-datepicker.js') }}"></script>
    <script>
        $(document).ready(function (){
            const token = "{{ csrf_token() }}";
            const appointment = @json($appointment);
            const appointmentId = $('.card-title').data('appointment-id');

            $('#status').on('click', function(){
                $('#status').modal('show');
            });

            $('.statusBtn').on('click', function(){

                let statusId  = $(this).data('id');

                let route = "{{ route('clinic.appointmentSetting.changeStatus', [":appointment_id", ":status_id"]) }}";
                var url = route.replace(':appointment_id', appointmentId);
                url = url.replace(':status_id', statusId);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: token,
                        appointment_id: appointmentId,
                        status_id: statusId,
                    },
                    success: function(response) {
                        toastr.success(response.message);

                        setTimeout(function() {
                            location.reload()
                        }, 2000);
                    },
                    error: function(xhr) {
                        toastr.error('something wrong');
                    }
                });
            });

            $('#appointmentBtn').on('click', function(){

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
