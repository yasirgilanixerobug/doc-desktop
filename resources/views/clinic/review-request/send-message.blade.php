@extends('layout.clinic')

@section('content')
    <!-- Content Wrapper. Contains page content -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="text-center">
                    <h1>Send Follow Up Review Message To Our Patients</h1>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Message send to patient who take an appointment <a href="{{ route('clinic.reviewRequest.bulkImport') }}" style="color: red" data-toggle="tooltip"> Upload Patient Follow Up Review List</a><br/></p>
                    <p> <b>Note: </b> if sms send to a patient then system not send sms to same patient next time till new record not upload</p>
                    <p><b>Note: </b> like Hi, NAME your appointment at APPOINTMENT_TIME we want your feedback about your experience with DOCTOR at LOCATION here are the link REVIEW_URL </p>
                    <div class="card card-primary">
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="googleListing" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="locations-tab" data-toggle="tab" href="#locations" role="tab" aria-controls="locations" aria-selected="true">
                                        Locations
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="doctors-tab" data-toggle="tab" href="#doctors" role="tab" aria-controls="doctors" aria-selected="false">
                                        Doctors
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content mt-3">
                                <div class="tab-pane fade show active" id="locations" role="tabpanel" aria-labelledby="locations-tab">
                                    <div class="card-body p-0">
                                        <form action="{{ route('clinic.reviewRequest.sendMessage') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                            <div class="row">
                                                <div class="form-group col-9">
                                                    <select name="location" class="form-control">
                                                        <option value="">Select Location</option>
                                                        @foreach($locations as $key => $location)
                                                            <option value="{{ $location->name }}">{{ $location->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-3 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="doctors" role="tabpanel" aria-labelledby="doctors-tab">
                                    <div class="card-body p-0">
                                        <form action="{{ route('clinic.reviewRequest.sendMessage') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group col-9">
                                                    <select name="provider" class="form-control">
                                                        <option value="">Select Provider</option>
                                                        @foreach($providers as $key => $provider)
                                                            <option value="{{ $provider->name }}">{{ $provider->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group col-3 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    @foreach($lastRecords as $key => $lastRecord)
                        <b>{{ $lastRecord->location  }}: </b>  {{ ' ( '.date('d M Y', strtotime($lastRecord->latest_created_at)) .' ) Last Record:'  }}</p>
                    @endforeach
                </div>
            </div>
        </section>
@endsection

@push('js')
<!-- Persist Active Tab Script -->
<script src="{{ asset('/clinic-assets/custom/js/persist-active-tab.js')  }}"></script>
@endpush

