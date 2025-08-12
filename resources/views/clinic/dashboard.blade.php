@extends('layout.clinic')
@section('title', 'Dashboard')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="info-box mb-3 bg-info" onclick="copyToClipboard('{{ route('clinicFrontend.home', ['subdomain' => $clinicSubDomain ]) }}')">
                        <span class="info-box-icon"><i class="far fa-copy"></i></span>

                        <div class="info-box-content showCursor">
                            <span class="info-box-text">Click To Copy Link</span>
                            <span class="info-box-number">{{ route('clinicFrontend.home', ['subdomain' => $clinicSubDomain ]) }} </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>                 
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="info-box mb-3 {{$twilioPayment['class']}}">        
                        <span class="info-box-icon"><i class="fa fa-dollar-sign"></i></span>

                        <div class="info-box-content showCursor">
                            <span class="info-box-text">Twilio Balance</span>
                            <span class="info-box-number"> {{ $twilioPayment['message'] }} </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
            </div>
            <!-- Small boxes (Stat box) -->
            
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>Visit Site</h3>

                            <p>{{ $clinicSubDomain  }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('clinicFrontend.home', ['subdomain' => $clinicSubDomain ]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $clinic->providers_count ?? 0 }}</h3>

                            <p>Providers</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('clinic.provider.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $clinic->staffs_count ?? 0 }}</h3>

                            <p>Staff</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('clinic.staff.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                @role('owner')
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $clinic->locations_count ?? 0 }}</h3>

                                <p>Locations</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{ route('clinic.location.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @else
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $viewPendingAppointmentCount }}</h3>

                                <p>Pending Appointments</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{ route('clinic.pendingAppointment') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endrole
                <!-- ./col -->

                <div class="col-md-6">
                    <!-- PRODUCT LIST -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Pending Appointments</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <ul class="products-list product-list-in-card pl-2 pr-2">
                                @forelse($viewPendingAppointment as $key => $appointment)
                                    @if($key < 5)
                                        <li class="item">
                                            <div class="product-info" style="margin: 0px">
                                                <a href="{{ route('clinic.appointmentSetting.detail', ['appointment_id' => $appointment->id]) }}" class="product-title">{{ $appointment->userable->name }}
                                                    <span class="badge badge-danger float-right">{{ $appointment->start_time.' / '.date(config('app.default_date_format_string'), strtotime($appointment->date)) }}</span>
                                                </a>
                                                <span class="product-description">
                                                    {{ $appointment->provider->name.' ('.$appointment->location->name.' )' }}
                                                </span>
                                            </div>
                                        </li>
                                    @endif
                                @empty
                                    <li class="item">
                                        <div class="product-info">
                                            <a href="javascript:void(0)" class="product-title">Appointment
                                                <span class="badge badge-warning float-right">{{ date(config('app.default_date_format_string')) }}</span>
                                            </a>
                                            <span class="product-description">
                                            No Pending Appointments
                                        </span>
                                        </div>
                                    </li>
                                @endforelse
                            </ul>
                        </div>

                        
                        <!-- /.card-body -->
                        <div class="card-footer text-center">
                            <a href="{{ route('clinic.pendingAppointment') }}" class="uppercase">View All Pending Appointments</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-md-6">
                    <!-- PRODUCT LIST -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Total Appointments</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <ul class="products-list product-list-in-card pl-2 pr-2">   
                                <li class="item">
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">Appointment
                                            <span class="badge badge-warning float-right">{{ date(config('app.default_date_format_string')) }}</span>
                                        </a>
                                        <h1><span class="product-description"><strong> {{ $totalAppointments }} </strong></span></h1>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        
                        <!-- /.card-body -->
                        <div class="card-footer text-center">
                            <a href="{{ route('clinic.pendingAppointment') }}" class="uppercase">View All Appointments</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>

            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Appointments Of Location {{ date('Y') }}</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>

            @role('receptionist')
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Location Provider Appointments {{ date('Y') }}</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="donutChartForProviderAppointment" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <!-- /.card-body -->
            </div>
            @endrole
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('js')
    <script src="{{ asset('clinic-assets/plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        $(function () {
            var clinicLocations = @json($clinicLocations);
            var totalLocationAppointments = @json($totalLocationAppointments);
            var locationProviderList = @json($locationProviderList);
            var locationAppointmentsOfProvider = @json($locationAppointmentsOfProvider);

            //-------------
            //- DONUT CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
            var donutData        = {
                labels: clinicLocations,
                datasets: [
                    {
                        data: totalLocationAppointments,
                        backgroundColor : [
                            '#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#C0C0C0',
                            '#808080','#000000','#FF0000','#800000', '#FFFF00', '#808000', '#00FF00', '#008000',
                            '#00FFFF', '#008080', '#0000FF', '#000080', '#FF00FF', '#800080'
                        ],
                    }
                ]
            }
            var donutOptions     = {
                maintainAspectRatio : false,
                responsive : true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })

            //Location Providers total Appointments Graph
            var donutChartCanvas = $('#donutChartForProviderAppointment').get(0).getContext('2d')
            var donutData        = {
                labels: locationProviderList,
                datasets: [
                    {
                        data: locationAppointmentsOfProvider,
                        backgroundColor : [
                            '#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#C0C0C0',
                            '#808080','#000000','#FF0000','#800000', '#FFFF00', '#808000', '#00FF00', '#008000',
                            '#00FFFF', '#008080', '#0000FF', '#000080', '#FF00FF', '#800080'
                        ],
                    }
                ]
            }
            var donutOptions     = {
                maintainAspectRatio : false,
                responsive : true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })
        });

        function copyToClipboard(link) {
            /* Get the text field */

            var copyText = link;

            setTimeout(function() {
                window.navigator.clipboard.writeText(copyText);
            }, 1000);

            alert("Clinic Sub Domain Link Copied");
        }
    </script>
@endpush
