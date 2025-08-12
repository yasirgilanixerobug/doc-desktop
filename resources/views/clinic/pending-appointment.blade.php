@extends('layout.clinic')

@section('title', 'Pending Appointment List')

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pending Appointments</h3>

                <!-- simple grid search close tag is use bcz some browser not support with out closing tag -->
                <x-grid-search :searchRoute="route('clinic.pendingAppointment')"></x-grid-search>

            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Patient
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
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($appointments as $key => $appointment)
                            <tr>
                                <td>{{ $loop->iteration  }}</td>
                                <td>
                                    <a href="{{ route('clinic.appointmentSetting.detail', ['appointment_id' => $appointment->id]) }}" target="_blank">{{ $appointment->userable->name }}</a><br/>
                                </td>
                                <td>
                                    {{ isset($appointment->provider) ? $appointment->provider->name : 'Provider Delete' }}<br/>
                                </td>
                                <td class="project_progress">
                                    {{ $appointment->location->name }}
                                </td>
                                <td class="project_progress">
                                    {{ $appointment->start_time}}<br/>
                                    <small>{{ date(config('app.default_date_format_string'), strtotime($appointment->date)) }}</small>
                                </td>
                            </tr>
                    @endforeach
                    </tbody>
                </table>

                <br>
                <div class="col-12">
                    {{ $appointments->appends(['q' =>  Request::get('q') ])->links('pagination') }}
                </div>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
