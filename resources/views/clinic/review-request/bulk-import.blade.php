@extends('layout.clinic')

@section('content')
    <!-- Content Wrapper. Contains page content -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="text-center">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h1>Import Patient Review Follow Up List</h1>
                    <p>Only allow specific format if you want then download a <a href="{{ route('clinic.reviewRequest.exportFormat') }}" style="color: red" data-toggle="tooltip" data-placement="top" title="{{ 'Patient, MobilePhone, AppointmentTime, DOB | required' }}" > Format File</a><br/>
                        <b>Note: </b> Only <code>USA</code> State Doctor Database</p>
                    <!-- Test all icons -->
                    <h1>
                        <i class="far fa-file-excel text-success"></i>
                        <i class="fas fa-file-csv text-success"></i>
                        <i class="fa fa-file-text-o text-success"></i>
                    </h1>
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
                                        <form action="{{ route('clinic.reviewRequest.import') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="form_type" value="location">
                                            <div class="row">
                                                <div class="form-group col-sm-12 col-md-5 col-xl-5">
                                                    <select name="location_google_review_url" class="form-control">
                                                        <option value="">Select Location</option>
                                                        @foreach($locations as $key => $location)
                                                            <option value="{{ $location->google_review_url }}">{{ $location->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-12 col-md-5 col-xl-5">
                                                    <div class="file-loading form-control">
                                                        <input type="file" name="file" id="input-ficons-5" class="button d-flex justify-content-start">
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-12 col-md-2 col-xl-2 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="doctors" role="tabpanel" aria-labelledby="doctors-tab">
                                    <div class="card-body p-0">
                                        <form action="{{ route('clinic.reviewRequest.import') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="form_type" value="provider">
                                            <div class="row">
                                                <div class="form-group col-sm-12 col-md-5 col-xl-5">
                                                    <select name="provider_google_review_url" class="form-control">
                                                        <option value="">Select Provider</option>
                                                        @foreach($providersListing as $key => $provider)
                                                            <option value="{{ $provider->google_review_url }}">{{ $provider->provider->name }} - {{ $provider->location->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-12 col-md-5 col-xl-5">
                                                    <div class="file-loading form-control">
                                                        <input type="file" name="file" id="input-ficons-5" class="button d-flex justify-content-start">
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-12 col-md-2 col-xl-2 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
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
