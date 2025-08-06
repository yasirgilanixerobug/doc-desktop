@extends('layout.clinic')

@section('title', 'Add Provider')

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
                            <h3 class="card-title">Add Provider</h3>
                        </div>

                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('clinic.provider.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label class="col-sm-2 col-form-label">Allowed Location</label>
                                        <div class="col-sm-12">
                                            <select name="location_id" id="location_id" class="form-control @error('location_id') is-invalid @enderror">
                                                <option value="">Select Location</option>
                                                @foreach($staffLocations as $keyGender => $staffLocation)
                                                    <option value="{{ $staffLocation->location->id }}" >{{ $staffLocation->location->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('location_id')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label class="requiredField">First Name</label>
                                        <input id="first_name" type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" placeholder="First Name" required>
                                        @error('first_name')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label class="requiredField">Last Name</label>
                                        <input id="last_name" type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" placeholder="Last Name" required>
                                        @error('last_name')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-4">
                                        <label class="requiredField">Email</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email" required>
                                        @error('email')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-4">
                                        <label class="requiredField">Phone</label>
                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Phone" required>
                                        @error('phone')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                    <br>
                                    <hr>

                                <div class="row">

                                    <div class="form-group col-6">
                                        <label class="col-sm-2 col-form-label">Gender</label>
                                        <div class="col-sm-6">
                                            <select name="gender_id" id="gender_id" class="form-control @error('gender_id') is-invalid @enderror">
                                                <option value="">Select Gender</option>
                                                @foreach($genders as $keyGender => $gender)
                                                    <option value="{{ $gender->id }}" >{{ $gender->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('gender_id')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <label>Image</label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" placeholder="image">
                                            @error('image')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-4">
                                        <label>State</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" value="{{ old('state') }}" placeholder="State">
                                            @error('state')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group col-4">
                                        <label>City</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}" placeholder="City">
                                            @error('city')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group col-4">
                                        <label>Address</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" placeholder="Address">
                                            @error('address')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-4">
                                        <label>Home</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="home" class="requiredField form-control @error('home') is-invalid @enderror" value="{{ old('home') }}" placeholder="Home">
                                            @error('home')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group col-4">
                                        <label>Office</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="office" class="form-control @error('office') is-invalid @enderror" value="{{ old('office') }}" placeholder="Office">
                                            @error('office')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group col-4">
                                        <label>Fax</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="fax" class="form-control @error('fax') is-invalid @enderror" value="{{ old('fax') }}" placeholder="fax">
                                            @error('fax')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>About</label>
                                        <div class="col-sm-12">
                                            <textarea class="form-control @error('about') is-invalid @enderror" name="about" placeholder="About" rows="7">{{  old('about') }}</textarea>
                                            @error('about')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
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
