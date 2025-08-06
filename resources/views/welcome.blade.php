@extends('layout.app')

@section('content')
    <section>
        <!-- Free Scheduling Software  -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 wid-full">
                    <div class="fst-container">
                        <div class="fst-cont-text">
                            <h1>What We Offer ?</h1>
                            <p>A free scheduling software. Organize your business with 24/7 automated online appointments, reminders, and more.</p>
                            @guest
                                <a href="{{ route('auth.clinicLoginForm') }}"><button class="btn set-start-free set-sign-up" type="button">Login</button></a>
                                <!-- <a href="{{ route('auth.clinicRegisterForm') }}"><button class="btn set-start-free set-sign-up" type="button">SIGN UP</button></a> -->
                            @endguest
                            @auth
                                @hasanyrole('owner|receptionist')
                                    <a href="{{ route('clinic.calendar') }}"><button class="btn set-start-free set-sign-up" type="button">Admin</button></a>
                                    <a href="{{ route('clinicFrontend.home', ['subdomain' => Auth::user()->clinic->sub_domain ]) }}"><button class="btn set-start-free set-sign-up" type="button">Site</button></a>
                                @endhasanyrole
                                @role('patient')
                                    <a href="{{ route('patient.dashboard') }}"><button class="btn set-start-free set-sign-up" type="button">Patient Portal</button></a>
                                @endrole

                                <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="{{ route('auth.logout') }}"><button class="btn set-start-free set-sign-up" type="button">Logout</button></a>
                                <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">@csrf</form>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
