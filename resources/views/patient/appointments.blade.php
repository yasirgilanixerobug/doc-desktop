@extends('layout.patient')

@section('content')
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
                            href="{{ route('patient.appointments', ['type' => 'upcoming']) }}"
                           aria-selected="true">Upcoming</a>
                    </li>
                    <li class="nav-item">
                        <a class="appoint-nav-link {{ (request()->type === 'past') ? 'active' : '' }}"
                            href="{{ route('patient.appointments', ['type' => 'past']) }}"
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
                            <div class="container">
                                <div class="news">
                                    <div class="news-content">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                        <p>Appointment can change before 24 hours.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Appointment can change before 24 hours ended here -->
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
                                    <tr scope="row" class="table-row-set">
                                        <td>{{ $appointment->clinic->name }}</td>
                                        <td>{{ ($appointment->provider->userDetail->first_name)
                                                ? $appointment->provider->userDetail->first_name. ' '.$appointment->provider->userDetail->last_name
                                                : $appointment->provider->name }}</td>
                                        <td>{{ date(config('app.default_date_format_string'), strtotime($appointment->date)) }}<br /><b><small>{{ $appointment->start_time }}</small></b></td>
                                        <td>{{ $appointment->location->fullAddress }}</td>
                                        <td><span class="status-panding">{{ $appointment->status->name }}</span></td>
                                        <td>
                                            <button class="button-81" role="button">
                                                Cancel
                                            </button>
                                            <button type="button"
                                                    class="btn button-81"
                                                    data-toggle="modal"
                                                    data-target="#exampleModalCenter">
                                                Change</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- pagination added here! -->
                        <ul class="pagination justify-content-end">
                            <li class="page-item disabled"><span class="page-link">Previous</span></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item active"><span class="page-link">2</span></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                        <!-- pagination ended here! -->
                    </div>
                    <div class="tab-pane fade"
                        id="contact"
                        role="tabpanel"
                        aria-labelledby="contact-tab">
                        <div class="patient-table-content">
                            <!--Appointment can change before 24 hours added here  -->
                            <div class="container">
                                <div class="news">
                                    <div class="news-content">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                        <p>Appointment can change before 24 hours.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Appointment can change before 24 hours ended here -->
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
                                    <tr scope="row" class="table-row-set">
                                        <td>{{ $appointment->clinic->name }}</td>
                                        <td>{{ ($appointment->provider->userDetail->first_name)
                                                ? $appointment->provider->userDetail->first_name. ' '.$appointment->provider->userDetail->last_name
                                                : $appointment->provider->name }}</td>
                                        <td>{{ date(config('app.default_date_format_string'), strtotime($appointment->date)) }}<br /><b><small>{{ $appointment->start_time }}</small></b></td>
                                        <td>{{ $appointment->location->fullAddress }}</td>
                                        <td><span class="status-panding">{{ $appointment->status->name }}</span></td>
                                        <td>
                                            <button class="button-81" role="button">
                                                Cancel
                                            </button>
                                            <button type="button"
                                                    class="btn button-81"
                                                    data-toggle="modal"
                                                    data-target="#exampleModalCenter">
                                                Change</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- pagination added here! -->
                        <ul class="pagination justify-content-end">
                            <li class="page-item disabled"><span class="page-link">Previous</span></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item active"><span class="page-link">2</span></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                        <!-- pagination ended here! -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
