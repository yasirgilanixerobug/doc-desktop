@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center">Terms and Conditions</h1>
        <div class="card p-4 shadow-lg">
            <p>Welcome to our website (doc.fivedocs.com), These terms and conditions outline the rules and regulations for the use of our website (doc.fivedocs.com). By using this website (doc.fivedocs.com) and submitting your appointment request, you agree to the following terms and conditions:</p>

            <h5>1. Appointment Information</h5>
            <p>When submitting an appointment request, you are required to provide the following information:</p>
            <ul class="pb-4 pl-5">
                <li>Name (required) .</li>
                <li>Email address (required) .</li>
                <li>Phone number (required) .</li>
                <li>Date of birth (required) .</li>
                <li>Address (optional) .</li>
                <li>Reason for visit (optional) .</li>
            </ul>
            <p>This information is essential to process your appointment and send you relevant SMS notifications.</p>

            <h5>2. SMS Subscription & Consent</h5>
            <p>By checking the checkbox, you consent to receive SMS notifications related to your appointment, including but not limited to:</p>
            <ul class="pb-4 pl-5">
                <li>Confirmation of your appointment.</li>
                <li>Reminders before your appointment.</li>
                <li>Notifications regarding appointment changes.</li>
                <li>Promotional messages related to services offered.</li>
            </ul>
            <p>You will also be automatically subscribed to our SMS package, which includes ongoing appointment-related updates.</p>

            <h5>3. Post-Visit Follow-Up</h5>
            <p>After your appointment, we may contact you via phone call or SMS to inquire about your experience with the doctor. Based on your feedback, you may be encouraged to leave a review for the doctor on Google.</p>

            <h5>4. Review Submission</h5>
            <p>We encourage all patients to provide feedback about their visit. You may be asked to leave a google review based on your experience, which will help improve our services and assist other patients in making informed decisions.</p>

            <h5>5. Privacy of Personal Information</h5>
            <p>All personal information provided during the appointment booking process will be handled in accordance with our <a href="{{ route('privacyPolicy') }}" target="_blank">Privacy Policy</a>. We value your privacy and will not share your information without your consent, except as necessary to fulfill the purpose of providing appointment-related services.</p>

            <h5>6. Changes to Terms</h5>
            <p>We reserve the right to modify these Terms & Conditions at any time. Any changes will be posted on this page, and the date of the most recent update will be reflected at the bottom of this page. We encourage you to review these terms periodically.</p>

            <h5>7. Limitation of Liability</h5>
            <p>While we strive to provide accurate and timely services, we do not accept liability for any delays or errors in the SMS notifications or appointment scheduling process. We will make reasonable efforts to ensure that communication reaches the intended recipient but cannot guarantee 100% delivery.</p>

            <h5>8. Governing Law</h5>
            <p>These Terms & Conditions are governed by and construed in accordance with the laws of USA. Any disputes arising from these terms will be subject to the exclusive jurisdiction of the courts in USA.</p>

            <p class="text-center">Last Updated: 29th Dec 2024</p>

        </div>
    </div>
@endsection
