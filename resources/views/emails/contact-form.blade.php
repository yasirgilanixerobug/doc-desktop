<p>Patient Detail</p>
<p>Patient: {{ $data['review_follow_up']['patient'] }}</p>
<p>DOB: {{ date('d M Y', strtotime($data['review_follow_up']['dob']))  }}</p>
<p>Phone: {{ $data['review_follow_up']['mobile_phone'] }}</p>
<p>Appointment Date: {{ $data['review_follow_up']['appointment_date'] }}</p>
<p>Location: {{ $data['review_follow_up']['location'] }}</p>
<p>Provider: {{ $data['review_follow_up']['provider'] }}</p>
<br>
<hr>
<p>Name: {{ $data['name'] }}</p>
<p>Subject: {{ $data['subject'] }}</p>
<p>Message: {{ $data['message'] }}</p>
