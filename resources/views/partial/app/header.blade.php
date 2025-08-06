<nav class="navbar navbar-expand-md navbar-light justify-content-between custom-nav-set">
    <a class="navbar-brand logo-set" href="{{ route('welcome') }}">
        <img src="{{ asset(config('app.logo')) }}" alt="logo image">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon set-togg"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
        <div class="navbar-nav bold-text">
            @guest
                <a class="nav-item nav-link" href="{{ route('auth.clinicLoginForm') }}">Clinic Login</a>
                <!-- <a href="{{ route('auth.clinicRegisterForm') }}"><button class="btn set-start-free set-sign-up" type="button">SIGN UP</button></a> -->

                <a class="nav-item nav-link" href="{{ route('auth.patientLoginForm') }}">Patient Login</a>
            @endguest
            @auth
                    @hasanyrole('owner|receptionist')
                        <a class="nav-item nav-link" href="{{ route('clinic.calendar') }}">Admin</a>
                        <a class="nav-item nav-link" href="{{ route('clinicFrontend.home', ['subdomain' => Auth::user()->clinic->sub_domain ]) }}">Site</a>
                    @endhasanyrole

                    @role('patient')
                        <a class="nav-item nav-link" href="{{ route('patient.dashboard') }}">Patient Portal</a>
                    @endrole

                    <a class="nav-item nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="{{ route('auth.logout') }}">Logout</a>
                    <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">@csrf</form>
            @endauth
        </div>
    </div>
</nav>
