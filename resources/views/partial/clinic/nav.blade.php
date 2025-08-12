<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">

            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>


        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-danger navbar-badge">{{ $viewPendingAppointmentCount }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">{{ $viewPendingAppointmentCount }} Notifications</span>
                <div class="dropdown-divider"></div>
                @foreach($viewPendingAppointment as $key => $pendingAppointment)
                    @if($key < 5)
                        <a href="{{ route('clinic.appointmentSetting.detail', ['appointment_id' => $pendingAppointment->id]) }}" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> {{ $pendingAppointment->start_time.' with '.$pendingAppointment->provider->name }}
                            <span class="float-right text-muted text-sm">{{ date(config('app.default_date_format_string'), strtotime($pendingAppointment->date)) }}</span>
                        </a>
                        <div class="dropdown-divider"></div>
                    @endif
                @endforeach
                <a href="{{ route('clinic.pendingAppointment') }}" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

    </ul>
</nav>
<!-- /.navbar -->
