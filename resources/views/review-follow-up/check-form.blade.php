@extends('layout.app')

@push('css')
    <style>
        .contact-form {
            display: none;
        }
        .company-logo {
            max-height: 150px; 
            margin: 10px auto; 
            display: block;
        }
    </style>
@endpush

@section('content')
    <!-- form body part  -->
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card">
                    @if(isset($reviewFollowUp->clinic->logo))
                        <img src="{{ asset($reviewFollowUp->clinic->logo) }}" alt="Clinic Logo" class="img-fluid company-logo">
                    @endif
                    <div class="container set-main-frm">
                        <h3 class="text-center">Leave A Review</h3>
                        <p>Thank you for choosing Stat Cardiologist for your health care. Please let us know how was your experience with us.</p>
                        <br>
                        <div class="set-inner-frm">
                            <div class="mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="review" id="goodReview" value="good" onclick="handleReviewType('good')">
                                    <label class="form-check-label" for="goodReview">Good Review</label>
                                </div>
                                @if($reviewFollowUp->sms_status != 2)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="review" id="badReview" value="bad" onclick="handleReviewType('bad')">
                                        <label class="form-check-label" for="badReview">Bad Review</label>
                                    </div>
                                @endif
                            </div>

                            <hr>
                            <div class="contact-form" id="contactForm">
                                <p>We are sorry that you had a bad experience. Please share some additional details as we are continuously working to improve our services from the patients' perspectives.</p>
                                <br>
                                <form class="frm-top-down" action="{{ route('contactUs.form')  }}" method="post" style="margin-top: 100px">
                                @csrf
                                    <input type="hidden" name="review_follow_up_id" value="{{ encrypt($reviewFollowUp->id) }}">
                                    <div class="form-group">
                                        <input type="text" id="name" name="name" class="requiredField form-control @error('name') is-invalid @enderror" placeholder="Name" required>
                                        @error('name')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="email" name="email" class="requiredField form-control @error('email') is-invalid @enderror" placeholder="Email" required>
                                        @error('email')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="subject" name="subject" class="requiredField form-control @error('subject') is-invalid @enderror" placeholder="Subject" required>
                                        @error('subject')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control requiredField @error('message') is-invalid @enderror" id="message" name="message" rows="4" required></textarea>
                                        @error('message')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="frm-top-down">
                                        <button class="btn login-btn" type="submit">Submit</button>
                                    </div>
                                </form>
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
        var reviewUrl = @json($reviewUrl);
        function handleReviewType(type) {
            const contactForm = document.getElementById('contactForm');

            if (type === 'bad') {
                contactForm.style.display = 'block';
            } else if(type === 'good') {
                contactForm.style.display = 'none';
                // Redirect to a different link for good review
                window.location.href = reviewUrl;
            }
        }
    </script>
@endpush
