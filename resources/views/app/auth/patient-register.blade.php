@extends('layout.app')

@section('content')
    <!-- form body part  -->
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="container set-main-frm">
                        <h3 class="text-center">Patient Register</h3>
                        <div class="set-inner-frm">
                            <hr>
                            <form class="frm-top-down" action="{{ route('auth.patientRegister') }}" method="post" style="margin-top: 100px" enctype="multipart/form-data">
                                @csrf
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="first_name" class="requiredField form-control @error('first_name') is-invalid @enderror" id="first_name" value="{{ old('first_name') }}" placeholder="First Name" required>
                                    @error('first_name')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="text" name="last_name" class="requiredField form-control @error('last_name') is-invalid @enderror" id="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required>
                                    @error('last_name')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="text" name="dob" class="requiredField form-control @error('dob') is-invalid @enderror" id="dob" value="{{ old('dob') }}" placeholder="Date of Birth mm/dd/yyyy" required>
                                    @error('dob')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="requiredField form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email" required>
                                    @error('email')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="phone" type="tel" name="phone" class="requiredField form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Phone" required>
                                    @error('phone')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="requiredField form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" placeholder="Password" required>
                                    @error('password')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="address" type="text" name="address" class="requiredField form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" placeholder="Address">
                                    @error('address')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="city" type="text" name="city" class="requiredField form-control @error('city') is-invalid @enderror" value="{{ old('city') }}" placeholder="City">
                                    @error('city')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="city" type="text" name="state" class="requiredField form-control @error('state') is-invalid @enderror" value="{{ old('state') }}" placeholder="State">
                                    @error('state')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="zip_code" type="text" name="zip_code" class="requiredField form-control @error('zip_code') is-invalid @enderror" value="{{ old('zip_code') }}" placeholder="Zip Code">
                                    @error('zip_code')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="image" type="file" name="image" class="requiredField form-control @error('image') is-invalid @enderror" value="{{ old('image') }}" placeholder="Image">
                                    @error('image')
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
                                    <button class="btn login-btn" type="submit">Submit</button>
                                </div>
                            </form>
                            <div class="forgotten">
                                <a href="{{ route('auth.patientLoginForm') }}"><span class="link-span">already register</span></a>
                            </div>
                            <div class="terms-policy">
                                <p>By sign up, you agree to our <a href="#">Terms of Use</a> & <a href="#">Privacy
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
