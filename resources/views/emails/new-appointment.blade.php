<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- external css link -->
    <!--    <link rel="stylesheet" href="assets/css/appointment.css" />-->
    <!-- font color -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700&family=Poppins:wght@100;200;300;400;500&display=swap"
        rel="stylesheet"
    />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }
        .main-container {
            display: flex;
            flex-wrap: wrap;
            padding-top: 20px;
            max-width: 992px;
            margin: 0 auto;
        }
        .part-first {
            width: 60%;
        }
        .letter-part {
            padding: 50px;
            border: 1px solid #ecf0f1;
            border-radius: 10px;
        }
        .span-dot {
            color: DodgerBlue;
        }
        .border-botem {
            border-bottom: 1px solid #ecf0f1;
            margin-top: 20px;
        }
        .letter-part p {
            color: #7f8c8d;
            margin: 15px 0 0 0;
        }
        .letter-part span {
            color: #95a5a6;
            margin: 15px 0 0 0;
        }
        .appoint-link a {
            text-decoration: none;
            color: DodgerBlue;
            font-weight: 500;
        }

        /* address part started here!  */
        .part-second {
            width: 40%;
            padding-left: 20px;
        }
        .address-part {
            padding: 20px;
            border: 1px solid #ecf0f1;
            border-radius: 10px;
            max-width: 250px;
            height: 100%;
        }
        .address-part p {
            color: #7f8c8d;
            margin: 15px 0 15px 0;
        }
        .img-class {
            text-align: center;
        }

        /* media query for responsive  */
        @media only screen and (max-width: 576px) {
            .main-container {
                display: flex;
                flex-direction: column;
                margin: 0 auto;
                padding: 20px;
            }
            .part-first {
                width: 100%;
            }
            .letter-part {
                padding: 20px;
                width: 100%;
            }
            .address-part {
                max-width: 100%;
                padding: 20px;
            }
            .part-second {
                width: 100%;
                margin-top: 20px;
            }
        }
    </style>
    <title>Appointment</title>
    <!--    <link rel="stylesheet" href="assets/css/style.css">-->
</head>
<body>
<div class="main-container">
    <!-- 60% -->
    <div class="part-first">
        <div class="letter-part">
            <h2>{{ $details['clinic_name'] }}<span class="span-dot">.</span></h2>
            <div class="border-botem"></div>
            <p><span>When:</span> {{ date('d M Y', strtotime($details['data']['appointment_date'])) }} {{ $details['data']['appointment_time'] }}</p>
            <p><span>Location:</span> {{ $details['data']['location_address'] }}</p>
            <p><span>Provider:</span> {{ $details['data']['provider_name'] }}</p>
            <p><span>Status:</span> <span style="color:#165ccc">{{ $details['data']['appointment_status'] }}</span></p>
            <div class="border-botem"></div>
            <p><span>Customer:</span> {{ $details['data']['patient_name'] }}</p>
            <p><span>Email:</span> {{ $details['data']['patient_email'] }}</p>
            <p><span>Phone:</span> {{ $details['data']['patient_phone'] }}</p>
            <p><span>DOB:</span> {{ date('d M Y', strtotime($details['data']['patient_dob'])) }}</p>
            <p><span>Address:</span> {{ $details['data']['patient_address'] }}</p>
            <p><span>Reason for Appointment:</span> {{ $details['data']['appointment_comment'] ?? '' }}</p>
{{--            <div class="appoint-link"><a href="#">Get Direction</a></div>--}}
            <p><span>Booked From:</span> Custom Booking Page</p>
            <div class="border-botem"></div>
            <p><span>Sincerely</span></p>
            <p><span></span> {{ $details['data']['clinic'] }}</p>
        </div>
    </div>

    <!-- 40% -->
    <div class="part-second">
        <div class="address-part">
            <div class="img-class">
                <img width="150" src="{{ asset('https://doc.fivedocs.com'.$details['data']['clinic_logo']) }}" alt="Brand logo" />
            </div>
            <p>
                {{ $details['data']['location_address'] }}
            </p>
            <p>
                {{ $details['data']['location_phone'] }}
            </p>

            @if($details['is'] === 'patient_message' && isset($details['data']['ins_upload_expire_link']) && $details['data']['ins_upload_expire_link'] !== null)
                <div class="appoint-link">
                    <p>You can upload your insurance documents here (this link expire in 2 hours)</p>
                    <div class="appoint-link"><a href="{{ $details['data']['ins_upload_expire_link'] }}">Upload</a></div>
                </div>
            @endif

            <div class="appoint-link"><a href="{{ route('clinicFrontend.home', ['subdomain' => $details['data']['clinic_sub_domain'] ]) }}">View Website</a></div>
        </div>
    </div>
</div>
</body>
</html>
