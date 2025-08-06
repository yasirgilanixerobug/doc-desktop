@extends('layout.frontend')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="staff-main appointment">
                    <div class="staff-details d-flex justify-content-start align-items-center">
                        <div>
                            <a href="{{ route('clinicFrontend.calendar', ['subdomain' => request()->subdomain, 'provider_location_id' => encrypt($providerLocationId)]) }}"><i class="fa-solid fa-angle-left set-li-icon"></i></a>
                        </div>
                        <div class="details-inner"><img src="Thumb41.svg" alt="" /></div>
                        <div class="details-inner">
                        <!-- <h5>Saifullah Nasir, M.D.</h5> -->
                        <h5>Your Information</h5>
                        </div>
                    </div>
                    <!-- progress bar -->
                    <div class="progress-details">
                        <div class="progress" style="height: 3px;">
                            <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="circle-one"><i class="fa-solid fa-1"></i></div>
                            <div class="circle-two"><i class="fa-solid fa-2"></i></div>
                            <div class="circle-three"><i class="fa-solid fa-3"></i></div>
                        </div>
                    </div>
                    <!-- info div added here -->
                    <div class="status-info">
                      <h5>{{ $appointmentLocation }}</h5>
                      <p>{{ $appointmentWith }}</p>
                    </div>

                    @guest
                        <div class="form-check form-check-inline">
                            <input class="form-check-input radioBtn" type="radio" name="user_type" id="inlineRadio1" value="guest" data-toggle="tooltip" title="create new appointment as a guest user"  {{ (!Auth::check() || session()->get('appointment_form_type')  === 'user_guest') ? 'checked' : '' }}>
                            <label class="form-check-label" for="inlineRadio1">Guest Patient<i class="bi bi-question-circle"></i></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input radioBtn" type="radio" name="user_type" id="inlineRadio2" value="established" data-toggle="tooltip" title="If you allow cookie then they show your old data according to your phone number" {{ (session()->get('appointment_form_type')  === 'user_established') ? 'checked' : '' }}>
                            <label class="form-check-label" for="inlineRadio2">Established Patient</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input radioBtn" type="radio" name="user_type" id="inlineRadio3" value="register" data-toggle="tooltip" title="create new appointment with new user registration" {{ (session()->get('appointment_form_type')  === 'user_register') ? 'checked' : '' }}>
                            <label class="form-check-label" for="inlineRadio3">New Patient<i class="bi bi-question-circle"></i></label>
                        </div>
                    @endguest

                    @if (count($errors) > 0)
                        <div class = "alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @php $display='display: inline;'; @endphp
                    @if((!auth()->check() && session()->get('appointment_form_type')  === 'user_guest' && session()->get('appointment_form_type')  ===  null))
                        @php $display = 'display: inline;'; @endphp
                    @endif
                    @if((!auth()->check() && session()->get('appointment_form_type')  !== 'user_guest' && session()->get('appointment_form_type')  !== null))
                        @php $display = 'display: none;'; @endphp
                    @endif
                    <div id="user_guest"  class="desc" style="{{ $display  }}">
                        <form id="appointmntForm" action="{{ route('clinicFrontend.appointment', ['subdomain' => request()->subdomain, 'appointment_form_type' => 'user_guest']) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input name="appointment" value="{{ $encryptedAppointmentString  }}" hidden>
                            <input id="customer_id" name="customer_id" value="" hidden>

                            <div class="form-row f-pad-top">
                                    <div class="form-group col-md-6">
                                        <input type="text" id="appoint_first_name" name="first_name" class="requiredField form-control @error('first_name') is-invalid @enderror" value="{{ isset($authUser->userDetail) ? $authUser->userDetail->first_name : old('first_name') }}" placeholder="First Name" required>
                                        @error('first_name')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="text" id="appoint_last_name" name="last_name" class="requiredField form-control @error('last_name') is-invalid @enderror" value="{{ isset($authUser->userDetail) ? $authUser->userDetail->last_name : old('last_name') }}" placeholder="Last Name" required>
                                        @error('last_name')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            <div class="form-row f-pad-top">
                                    <div class="form-group col-md-6">
                                        <input type="email" id="appoint_email" name="email" class="requiredField form-control @error('email') is-invalid @enderror" value="{{ isset($authUser->email) ? $authUser->email :  old('email') }}"  placeholder="Email" required>
                                        @error('email')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="number" id="appoint_phone" name="phone" class="requiredField form-control @error('phone') is-invalid @enderror" value="{{ isset($authUser->userDetail) ? $authUser->userDetail->phone : old('phone') }}"  placeholder="Phone" required >
                                        @error('phone')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            <div class="form-group f-pad-top">
                                    <input type="text" id="appoint_dob" name="dob" class="requiredField form-control @error('dob') is-invalid @enderror" value="{{ isset($authUser->userDetail) ? date('m/d/Y', strtotime($authUser->userDetail->dob)) : old('dob') }}" placeholder="Date of Birth (mm/dd/yyyy)" required>
                                    <span id="date-error-message" style="color: red; display: none;">please enter a valid date in the format MM/DD/YYYY. Month between(01-12), Date between(01-31), and Year (from 1900 to current year).</span>
                                    <span id="age-error-message" style="color: red; display: none;">age must be atleast 14 years.</span>
                                    @error('dob')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            <div class="form-group f-pad-top">
                                    <input type="text" id="appoint_address" name="address" class="form-control" value="{{ isset($authUser->userDetail) ? $authUser->userDetail->address : old('address') }}"   placeholder="Address">
                                    @error('address')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            <div class="form-row f-pad-top">
                                    <div class="form-group col-md-4">
                                        <input type="text" id="appoint_city" name="city" class="form-control" value="{{ isset($authUser->userDetail) ? $authUser->userDetail->city : old('city') }}"  placeholder="City">
                                        @error('city')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <input type="text" id="appoint_state" name="state" class="form-control" value="{{ isset($authUser->userDetail) ? $authUser->userDetail->state : old('state') }}"  placeholder="State">
                                        @error('state')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <input type="text" id="appoint_zip_code" name="zip_code" class="form-control" value="{{ isset($authUser->userDetail) ? $authUser->userDetail->zip_code : old('zip_code') }}"  placeholder="Zip Code">
                                        @error('zip_code')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            <div class="form-group f-pad-top">
                                    <input hidden type="text" id="appoint_other_name" name="other_name" class="form-control" value="{{  old('other_name') }}"  placeholder="Other Name">
                                    @error('other_name')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            <div class="form-group f-pad-top">
                                    <textarea id="appoint_comment" name="comment" class="form-control @error('comment') is-invalid @enderror" name="comment" placeholder="Reason For Visit" rows="7">{{ old('comment') }}</textarea>
                                    @error('comment')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            <div class="step-info-main">
                                    <p>
                                        If you would like to provide us with more information (insurance
                                        & ID or other documents) to expedite your checkin process please
                                        upload picture or document file here.
                                    </p>
                                    <p class="step-info">upload here</p>
                                    <div hidden>
                                        <div class="insurance">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="input-group mb-3">
                                                        <div class="custom-file">
                                                            <input
                                                                name="ins_front"
                                                                type="file"
                                                                class="custom-file-input"
                                                                accept="image/png, image/jpeg"
                                                                id="inputGroupFile01"
                                                            />
                                                            <label class="custom-file-label" for="inputGroupFile01">ID Front</label>
                                                        </div>
                                                    </div>
                                                    <span>Only jpeg,png,jpg,webp | max 5MB</span>
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <div class="input-group mb-3">
                                                        <div class="custom-file">
                                                            <input
                                                                name="ins_back"
                                                                type="file"
                                                                class="custom-file-input"
                                                                accept="image/png, image/jpeg"
                                                                id="inputGroupFile02"
                                                            />
                                                            <label class="custom-file-label" for="inputGroupFile02">ID Back</label>
                                                        </div>
                                                    </div>
                                                    <span>Only jpeg,png,jpg,webp | max 5MB</span>
                                                </div>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input
                                                        name="ins_document"
                                                        type="file"
                                                        class="custom-file-input"
                                                        id="inputGroupFile03"
                                                    />
                                                    <label class="custom-file-label" for="inputGroupFile03">Document File</label>
                                                </div>
                                            </div>
                                            <span>Only pdf,doc,docx | max 5MB</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('termsConditions') is-invalid @enderror" name="termsConditions" type="checkbox" value="1">
                                    <span>Agree to <a href="{{route('termsAndConditions')}}" target="_blank">Terms & Conditions</a>.</span>
                                    <p class="small text-muted">
                                        By agreeing to the Terms & Conditions, you will automatically be subscribed to receive appointment reminders via SMS.
                                    </p>
                                    @error('termsConditions')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                            <button type="submit" id="submitBtn" class="btn see-more select-btn">
                                Continue
                            </button>
                        </form>
                    </div>

                    <div id="user_established" class="desc" style="{{ (!auth()->check() && session()->get('appointment_form_type')  === 'user_established') ? '' : 'display: none;' }}">
                            <form class="frm-top-down" action="{{ route('auth.clinicLogin', ['appointment_form_type' => 'user_established']) }}" method="post" style="margin-top: 100px">
                                @csrf
{{--                                <input type="hidden" name="is_appointment_route" value="{{ $isAppointmentRoute }}">--}}
                                <div class="form-group">
                                    <input id="login_email" type="email" name="email" class="requiredField form-control @error('email') is-invalid @enderror" placeholder="Email" required>
                                    @error('email')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="login_password" type="password" name="password" class="requiredField form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                                    @error('password')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="frm-top-down">
                                    <button type="submit" class="btn see-more select-btn" data-toggle="modal"
                                            data-target="#exampleModalCenter">
                                        Login
                                    </button>
                                </div>
                            </form>
                        </div>

                    <div id="user_register" class="desc" style="{{ (!auth()->check() && session()->get('appointment_form_type')  === 'user_register') ? '' : 'display: none;' }}">
                            <form class="frm-top-down" action="{{ route('auth.patientRegister', ['appointment_form_type' => 'user_register']) }}" method="post" style="margin-top: 100px">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="first_name" class="requiredField form-control @error('first_name') is-invalid @enderror" id="register_first_name" value="{{ old('first_name') }}" placeholder="First Name" required>
                                    @error('first_name')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="text" name="last_name" class="requiredField form-control @error('last_name') is-invalid @enderror" id="register_last_name" value="{{ old('last_name') }}" placeholder="Last Name" required>
                                    @error('last_name')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="text" name="dob" class="requiredField form-control @error('dob') is-invalid @enderror" id="register_dob" value="{{ old('dob') }}" placeholder="Date of Birth mm/dd/yyyy" required>
                                    @error('dob')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="register_email" type="email" name="email" class="requiredField form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email" required>
                                    @error('email')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="register_phone" type="tel" name="phone" class="requiredField form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Phone" required>
                                    @error('phone')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="register_password" type="password" name="password" class="requiredField form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" placeholder="Password" required>
                                    @error('password')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="register_address" type="text" name="address" class="requiredField form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" placeholder="Address">
                                    @error('address')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="register_city" type="text" name="city" class="requiredField form-control @error('city') is-invalid @enderror" value="{{ old('city') }}" placeholder="City">
                                    @error('city')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="register_state" type="text" name="state" class="requiredField form-control @error('state') is-invalid @enderror" value="{{ old('state') }}" placeholder="State">
                                    @error('state')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="register_zip_code" type="text" name="zip_code" class="requiredField form-control @error('zip_code') is-invalid @enderror" value="{{ old('zip_code') }}" placeholder="Zip Code">
                                    @error('zip_code')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="frm-top-down">
                                    <button type="submit" class="btn see-more select-btn" data-toggle="modal"
                                            data-target="#exampleModalCenter">
                                        Register
                                    </button>
                                </div>
                            </form>
                        </div>
                </div>
            </div>

            <!-- Direction Right SideBar -->
{{--            <div class="col-md-4" id="side-menu-component">--}}
{{--                <x-side-menu--}}
{{--                    :fullAddress="$clinicCurrentLocation->fullAddress"--}}
{{--                    :phone="$clinicCurrentLocation->phone"--}}
{{--                    :businessHours="$locationBusinessHours"--}}
{{--                    :weekDays="$weekDays"--}}
{{--                ></x-side-menu>--}}
{{--            </div>--}}
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $("input[name$='user_type']").click(function() {
                let userType = $(this).val();
                $("div.desc").hide();
                $("#user_" + userType).show();
            });

            $('#appointmntForm').on('submit', function () {
                var btn = $('#submitBtn');
                btn.prop('disabled', true);
                //btn.text('Submitting...'); // Optional: change text to show progress
                btn.addClass('loading');
                btn.html('<span class="spinner-border spinner-border-sm"></span> Submitting...');
            });
        });
    </script>

    <script src="{{ asset('clinic-assets/frontend/js/form.js') }}"></script>
    <script>
        $(document).ready(function() {
            let isValid = true; // Flag to track form validity

            $("#appoint_dob").on("input", function(e) {
                let input = $(this).val().replace(/\D/g, ''); // Remove non-numeric characters
                let month = input.substring(0, 2); // first 2 digits for month
                let date = input.substring(2, 4);  // then 2 digits for date
                let year = input.substring(4, 8);  // then 4 digits for year
                let errorMessage = $("#date-error-message");
                let ageErrorMessage = $("#age-error-message");

                const currentYear = new Date().getFullYear();

                isValid = true; // Reset form validity

                // Month, Date, and Year Validation also Show error message if invalid
                if (month > 12 || (date && date > 31) || (year.length === 4 && (year < 1900 || year > currentYear))) {
                    errorMessage.show(); // Show error message
                    ageErrorMessage.hide(); // Hide age error message
                    isValid = false; // Set form validity to false
                } else {
                    errorMessage.hide(); // Hide error message
                    
                    // Check age if valid date is entered
                    if (month && date && year.length === 4) {
                        let dob = new Date(year, month - 1, date); // Create Date object
                        let age = calculateAge(dob); // Calculate age
                        if (age < 14) {
                            ageErrorMessage.show(); // Show age error message
                            isValid = false; // Set form validity to false
                        } else {
                            ageErrorMessage.hide(); // Hide age error message
                        }
                    } else {
                        ageErrorMessage.hide(); // Hide age error message if date is incomplete
                    }
                }

                // Add slashes between month, date, and year automatically
                if (input.length >= 5) {
                    $(this).val(`${month}/${date}/${year}`);
                } else if (input.length >= 3) {
                    $(this).val(`${month}/${date}`);
                } else if (input.length >= 1) {
                    $(this).val(`${month}`);
                }
            });

            // Allow only digits
            $("#appoint_dob").on("keypress", function(e) {
                if (e.key < '0' || e.key > '9') {
                    e.preventDefault();
                }
            });

            // Function to calculate age
            function calculateAge(dob) {
                let today = new Date();
                let age = today.getFullYear() - dob.getFullYear();
                let monthDiff = today.getMonth() - dob.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                    age--; // Adjust for incomplete year
                }
                return age;
            }
        });
    </script>
@endpush
