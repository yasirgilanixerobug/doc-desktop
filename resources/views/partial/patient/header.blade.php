<nav class="navbar navbar-expand-md sticky-top navbar-light custom-home">
    <div class="container">
        <a class="navbar-brand" href="#"><h2 class="home-welcom">{{ Auth::user()->shortName }}</h2></a>
        <button
            class="navbar-toggler navbar-toggler-right"
            type="button"
            data-toggle="collapse"
            data-target="#navbar1">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbar1">
            <ul class="navbar-nav">
                <li class="nav-item ml-3">
                    <a class="nav-link {{ request()->routeIs('patient.dashboard') ? 'home-active' : '' }}" href="{{ route('patient.dashboard') }}">Home</a>
                </li>
{{--                <li class="nav-item ml-3">--}}
{{--                    <a class="nav-link {{ request()->routeIs('patient.appointments') ? 'home-active' : '' }}" href="{{ route('patient.appointments', ['appointment_type' => 'upcoming']) }}">Appointments</a>--}}
{{--                </li>--}}
                <li class="nav-item ml-3">
                    <a class="nav-link {{ request()->routeIs('patient.profile') ? 'home-active' : '' }}" href="{{ route('patient.profile') }}">Profile</a>
                </li>
                <li class="nav-item ml-3">
                    <a class="nav-link {{ request()->routeIs('patient.providers') ? 'home-active' : '' }}" href="{{ route('patient.providers') }}">Doctors</a>
                </li>
                <li class="nav-item ml-3">
                    <a class="nav-link {{ request()->routeIs('patient.clinics') ? 'home-active' : '' }}" href="{{ route('patient.clinics') }}">Clinics</a>
                </li>
                <li class="nav-item ml-3">
                    <a class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="{{ route('auth.logout') }}">Logout</a>
                    <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
