@extends('layout.clinic')

@section('title', 'Location Edit')

@section('content')
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Location ( {{ $model->name }} )</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('clinic.location.update', ['location' => $model->id]) }}" method="post">
                                @csrf
                                @method('PUT')

                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="requiredField">Name</label>
                                            <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $model->name ?? old('name') }}" placeholder="Name" required>
                                            @error('name')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="requiredField">Per Appointment Min</label>
                                            <input type="number" name="per_appointment_min" class="form-control @error('per_appointment_min') is-invalid @enderror" value="{{ ($model->per_appointment_min) ?? old('per_appointment_min') }}" placeholder="Per Appointment Min" required>
                                            @error('per_appointment_min')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="requiredField">State</label>
                                            <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" value="{{ ($model->state) ?? old('state') }}" placeholder="State">
                                        </div>

                                        <div class="form-group col-6">
                                            <label class="requiredField">City</label>
                                            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ ($model->city) ?? old('city') }}" placeholder="City">
                                            @error('city')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="requiredField">Address</label>
                                            <input type="text" id="address-input" name="address" class="form-control map-input @error('address') is-invalid @enderror" value="{{ ($model->address) ?? old('address') }}" placeholder="Address" required>
                                        </div>

                                        <div class="form-group col-6">
                                            <label class="requiredField">Google Review Url</label>
                                            <input type="text" id="google-review-url-input" max="250" name="google_review_url" class="form-control map-input @error('google_review_url') is-invalid @enderror" value="{{ ($model->google_review_url) ?? old('google_review_url') }}" placeholder="Google Review Url">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>Latitude</label>
                                            <input type="text" name="lat" id="address-lat" class="form-control @error('lat') is-invalid @enderror" value="{{ ($model->lat) ?? old('lat') }}" placeholder="Latitude" readonly>
                                            @error('lat')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-6">
                                            <label>Longitude</label>
                                            <input type="text" name="lng" id="address-lng" class="form-control @error('lng') is-invalid @enderror" value="{{ ($model->lng) ?? old('lng') }}" placeholder="Longitude" readonly>
                                            @error('lng')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <br>
                                    <hr>

                                    <div class="row">
                                        <div class="form-group col-4">
                                            <label>Email</label>
                                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ ($model->email) ?? old('email') }}" placeholder="Email">
                                            @error('email')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-4">
                                            <label>Phone</label>
                                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ ($model->phone) ?? old('phone') }}" placeholder="Phone">
                                            @error('phone')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-4">
                                            <label>Fax</label>
                                            <input type="text" name="fax" class="form-control @error('fax') is-invalid @enderror" value="{{ ($model->fax) ?? old('fax') }}" placeholder="Fax">
                                            @error('fax')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                </div>

                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->

            <div id="address-map-container" style="width:100%;height:400px; ">
                <div style="width: 100%; height: 100%" id="address-map"></div>
            </div>

        </section>
        <!-- /.content -->
@endsection

@push('js')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_maps_api_key') }}&libraries=places&callback=initialize" async defer></script>
    <script src="{{ asset('clinic-assets/custom/js/mapInput.js') }}"></script>
@endpush
