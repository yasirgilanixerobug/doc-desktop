@extends('layout.clinic')

@section('title', 'Edit Provider')

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
                            <h3 class="card-title">Edit Provider</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('clinic.provider.update', ['provider' => $model->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="user_id" value="{{ $model->id }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label class="requiredField">First Name</label>
                                        <input id="first_name" type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ $model->userDetail->first_name ?? old('first_name') }}" placeholder="First Name" required>
                                        @error('first_name')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label class="requiredField">Last Name</label>
                                        <input id="last_name" type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ $model->userDetail->last_name ?? old('last_name') }}" placeholder="Last Name" required>
                                        @error('last_name')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label class="requiredField">Email</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ ($model->email) ?? old('email') }}" placeholder="Email" required>
                                        @error('email')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-6">
                                        <label class="requiredField">Phone</label>
                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ ($model->userDetail->phone) ?? old('phone') }}" placeholder="Phone" required>
                                        @error('email')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <br>
                                <hr>

                                <div class="row">

                                    <div class="form-group col-6">
                                        <label class="col-sm-6 col-form-label">Gender</label>
                                        <div class="col-sm-6">
                                            <select name="gender_id" id="gender_id" class="form-control @error('gender_id') is-invalid @enderror">
                                                <option value="">Select Gender</option>
                                                @foreach($genders as $keyGender => $gender)
                                                    <option value="{{ $gender->id }}" {{ ($gender->id == $model->userDetail->gender_id) ? 'selected' : ' ' }} >{{ $gender->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('gender_id')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <label>Image</label>
                                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"  placeholder="image">
                                            @error('image')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-4">
                                        <label>State</label>
                                            <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" value="{{  $model->userDetail->state ?? old('state') }}" placeholder="State">
                                            @error('state')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                    </div>

                                    <div class="form-group col-4">
                                        <label>City</label>
                                            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{  $model->userDetail->city ?? old('city') }}" placeholder="City">
                                            @error('city')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                    </div>

                                    <div class="form-group col-4">
                                        <label>Address</label>
                                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{  $model->userDetail->address ?? old('address') }}" placeholder="Address">
                                            @error('address')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-4">
                                        <label>Home</label>
                                            <input type="text" name="home" class="requiredField form-control @error('home') is-invalid @enderror" value="{{  $model->userDetail->home ?? old('home') }}" placeholder="Home">
                                            @error('home')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                    </div>

                                    <div class="form-group col-4">
                                        <label>Office</label>
                                            <input type="text" name="office" class="form-control @error('office') is-invalid @enderror" value="{{  $model->userDetail->office ?? old('office') }}" placeholder="Office">
                                            @error('office')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                    </div>

                                    <div class="form-group col-4">
                                        <label>Fax</label>
                                            <input type="text" name="fax" class="form-control @error('fax') is-invalid @enderror" value="{{  $model->userDetail->fax ?? old('fax') }}" placeholder="fax">
                                            @error('fax')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>About</label>
                                        <div class="col-sm-12">
                                            <textarea class="form-control @error('about') is-invalid @enderror" name="about" placeholder="About" rows="7">{{  $model->userDetail->about ?? old('about') }}</textarea>
                                            @error('about')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
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
    </section>
    <!-- /.content -->
@endsection
