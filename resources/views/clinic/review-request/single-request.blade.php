@extends('layout.clinic')

@section('title', 'Single Request')

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
                            <h3 class="card-title">Single Request</h3>
                        </div>

                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('clinic.reviewRequest.storeSingleRequest') }}" method="post">
                            @csrf
                            <div class="card-body">
                                @foreach($lastRecords as $key => $lastRecord)
                                    <b>{{ $lastRecord->location  }}: </b>  {{ ' ( '.date('d M Y', strtotime($lastRecord->latest_created_at)) .' ) Last Record:'  }}</p>
                                @endforeach

                                <div class="row">
                                    <div class="form-group col-4">
                                        <label class="requiredField">First Name</label>
                                        <input id="first_name" type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" placeholder="First Name" required>
                                        @error('first_name')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-4">
                                        <label>Last Name</label>
                                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" placeholder="Last Name">
                                        @error('last_name')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-4">
                                        <label>Phone</label>
                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Phone">
                                        @error('phone')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-4">
                                        <label class="requiredField">Location</label>
                                        <select name="location_id" class="form-control">
                                            <option value="">Select Location</option>
                                            @foreach($locations as $key => $location)
                                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-4">
                                        <label class="requiredField">Provider</label>
                                        <select id="provider" name="provider" class="form-control">
                                            <option value="">Select Provider</option>
                                            @foreach($providers as $key => $provider)
                                                <option value="{{ $provider->name }}">{{ $provider->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-4">
                                        <label class="requiredField">Appointment Date</label>
                                        <input type="date" id="appointment_date" name="appointment_date" class="form-control map-input @error('appointment_date') is-invalid @enderror" value="{{ old('appointment_date') }}" placeholder="Appointment Date">
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
