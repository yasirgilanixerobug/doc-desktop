@extends('layout.app')

@section('content')
    <!-- form body part  -->
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="container set-main-frm">
                        <h3 class="text-center">{{ $loginFor }} Log in</h3>
                        <div class="set-inner-frm">
{{--                            <div class="login-img">--}}
{{--                                <a href="#" class="btn login-wd-btns" type="submit">--}}
{{--                                    <span><img src="{{ asset('app-assets/images/png-google-thumbnail.png') }}" alt=""></span>--}}
{{--                                    Login with Google--}}
{{--                                </a>--}}
{{--                                <br>--}}
{{--                                <a href="#" class="btn login-wd-btns" type="submit">--}}
{{--                                    <span><img src="{{ asset('app-assets/images/facebook-logo.png') }}" alt=""></span>--}}
{{--                                    Login with Facebook--}}
{{--                                </a>--}}
{{--                            </div>--}}
                            <hr>

                            <form class="frm-top-down" action="{{ route('auth.clinicLogin') }}" method="post" style="margin-top: 100px">
                                @csrf
                                <input type="hidden" name="is_appointment_route" value="{{ $isAppointmentRoute }}">
                                <div class="form-group">
                                    <input type="email" name="email" class="requiredField form-control @error('email') is-invalid @enderror" placeholder="Email" required>
                                    @error('email')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="requiredField form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                                    @error('password')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="recaptcha-wrapper">
                                        <div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror" 
                                            data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}">
                                        </div>
                                    </div>
                                    @error('g-recaptcha-response')
                                    <span class="error invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="frm-top-down">
                                    <button class="btn login-btn" type="submit">Login</button>
                                </div>
                            </form>
                            <div class="forgotten">
                                <a href="{{ route('password.request') }}"><span class="link-span">forgot your password?</span></a><br>
                                <!-- <a href="{{ $signupRoute }}"><span class="link-span">{{ $loginFor  }} Sign up</span></a> -->
                            </div>
                            <div class="terms-policy">
                                <p>By signing, you agree to our <a href="#">Terms of Use</a> & <a href="#">Privacy
                                        Policy</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
