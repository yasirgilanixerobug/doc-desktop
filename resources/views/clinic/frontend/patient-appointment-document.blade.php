@extends('layout.frontend')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="staff-main appointment">
                    <form id="patientDocumentForm" action="{{ route('clinicFrontend.uploadPatientAppointmentDocument', ['subdomain' => request()->subdomain, 'appointment_id' => encrypt($appointment->id), 'token' => $token]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        @if (count($errors) > 0)
                            <div class = "alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div>
                            Mr/Mis, <h4>{{ $appPatientName }} </h4> kindly upload your document here
                            <hr>
                            <p>{{ $appFor }}</p>
                        </div>
                        <input id="appointment_id" name="appointment_id" value="{{ encrypt($appointment->id) }}" hidden>

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
                                                accept="doc, pdf"
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

                        <button type="submit" class="btn see-more select-btn" data-toggle="modal"
                                data-target="#exampleModalCenter">
                            Continue
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('clinic-assets/frontend/js/form.js') }}"></script>
@endpush
