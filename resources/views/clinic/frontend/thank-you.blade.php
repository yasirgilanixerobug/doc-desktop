@extends('layout.frontend')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="staff-main">
                    <div class="staff-details d-flex justify-content-start align-items-center">
                        <div>
                            <a href="#"><i class="fa-solid fa-angle-left set-li-icon"></i></a>
                        </div>
                        <div class="details-inner"><img src="Thumb41.svg" alt="" /></div>
                        <div class="details-inner">
                            <!-- <h5>Saifullah Nasir, M.D.</h5> -->
                            <h5>Complete</h5>
                        </div>
                    </div>
                    <!-- progress bar -->
                    <div class="progress-details">
                        <div class="progress" style="height: 3px;">
                            <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="circle-one"><i class="fa-solid fa-1"></i></div>
                            <div class="circle-two"><i class="fa-solid fa-2"></i></div>
                            <div class="circle-three"><i class="fa-solid fa-3"></i></div>
                            <div class="circle-four"><i class="fa-solid fa-4"></i></div>
                        </div>
                    </div>
                    <div class="container">
                      <div class="row">
                        <div class="col-lg-12">
                            <div class="thank-you">
                                <img src="{{ asset('clinic-assets/frontend/img/icons8-checkmark-100.png') }}" alt="" />
                                <h1>Thanks for your booking!</h1>
                                <p>You'll receive a conformation E-mail and SMS</p>
                                @if($appointmentData)
                                    <p>You Booked an appointment with</p>
                                    <p>{{ $appointmentData['provider_name'] }}</p>
                                    <p>On, {{ $appointmentData['location_address'] }}</p>
                                    <p>At, {{ date('M d Y', strtotime($appointmentData['appointment_date'])) . ', '.  $appointmentData['appointment_time'] }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function (){
            let guestUser = @json($guestUser);

            if (guestUser !== null)
            {
                localStorage.setItem(guestUser.phone, guestUser.id);
            }
        });
    </script>
@endpush
