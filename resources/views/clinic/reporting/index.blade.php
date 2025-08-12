@extends('layout.clinic')

@section('title', 'Appointments Reporting')

@push('css')
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
@endpush

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                Search
                <a class="btn btn-warning"
                   href="{{ route('clinic.reporting.export') }}">
                    Export Report
                </a>
            </div>
            <div class="card-body">
                <form id="ownerSettingForm" class="form-horizontal" action="{{ route('clinic.reporting.index') }}" method="post">
                    @csrf

                    <div class="row">

                        <div class="input-group input-daterange col">
                            <input type="text" name="daterange" class="form-control" value="{{ date('m/d/Y', strtotime($from)) }} - {{ date('m/d/Y', strtotime($to)) }}">
                        </div>

                        <div class="form-group  col">
                            <select name="location_id" id="location_id" class="form-control">
                                <option value="">Select Location</option>
                                @foreach($locations as $key => $location)
                                    <option value="{{ $location->id }}" {{ ($location->id == request()->location_id) ? 'selected' : ' ' }} >{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col">
                            <input type="text" name="q" class="form-control float-right" value="{{ old('q') ?? request()->q }}" placeholder="Search">
                        </div>

                        <div class="form-group col">
                            <select name="appointment_status_id" id="appointment_status_id" class="form-control">
                                <option value="">Select Status</option>
                                @foreach($statuses as $key => $status)
                                    <option value="{{ $status->id }}" {{ ($status->id == request()->appointment_status_id) ? 'selected' : ' ' }} >{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">Report</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Reporting</h3>
                <!-- simple grid search close tag is use bcz some browser not support with out closing tag -->
            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Appt Date
                        </th>
                        <th>
                            Patient
                        </th>
                        <th>
                            Phone
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Provider
                        </th>
                        <th>
                            Location
                        </th>
                        <th>
                            Time
                        </th>
                        <th>
                            Appt Status
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($appointments as $key => $appointment)
                        <tr>
                            <td>{{ $loop->iteration  }}</td>
                            <td>
                                {{ date(config('app.default_date_format'), strtotime($appointment->date))  }}
                                <br><small>{{ $appointment->start_time }}</small>
                            </td>
                            <td>
                                <a href="{{ route('clinic.appointmentSetting.detail', ['appointment_id' => $appointment->id]) }}" target="_blank">{{ $appointment->userable->name }}</a><br/>
                            </td>
                            <td>
                                {{ ($appointment->userable) ? $appointment->userable->phone : 'N\A'  }}
                            </td>
                            <td>
                                {{ ($appointment->userable) ? $appointment->userable->email : 'N\A'  }}
                            </td>
                            <td>
                                {{ isset($appointment->provider) ? $appointment->provider->name : 'Provider Delete' }}<br/>
                            </td>
                            <td>
                                {{ $appointment->location->name }}
                            </td>
                            <td>
                                {{ $appointment->start_time}}<br/>
                                <small>{{ date(config('app.default_date_format_string'), strtotime($appointment->date)) }}</small>
                            </td>
                            <td>
                                {{ $appointment->status->name }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <br>
                <div class="col-12">
                    {{ $appointments->appends([
                        'q' =>  Request::get('q'),
                        'daterange' => Request::get('daterange'),
                        'appointment_status_id' =>  Request::get('appointment_status_id'),
                        'location_id' =>  Request::get('location_id'),
                        ])->links('pagination') }}
                </div>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection

@push('js')
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <script>
        $(document).ready(function(){
            $('input[name="daterange"]').daterangepicker();

            {{--let exportUrl = '{{ route('clinic.reporting.export') }}';--}}
            {{--$('.export').on('click', function() {--}}

            {{--    var requestData = @json(request()->all());--}}
            {{--    console.log(requestData);--}}
            {{--    alert();--}}
            {{--    let type = $(this).data('type');--}}

            {{--    $.ajax({--}}
            {{--        type:'GET',--}}
            {{--        url: exportUrl,--}}
            {{--        data:{--}}
            {{--            type: type,--}}
            {{--            params: requestData,--}}
            {{--        },--}}
            {{--        success:function(data){--}}
            {{--            window.location.href = exportUrl;--}}
            {{--        }--}}
            {{--    });--}}
            {{--});--}}
        });
    </script>
@endpush
