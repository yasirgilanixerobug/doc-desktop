@extends('layout.clinic')

@section('title', 'Edit Customer')

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
                            <h3 class="card-title">Edit Staff</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('clinic.customer.update', ['customer' => $model->id]) }}" method="post">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="user_id" value="{{ $model->id }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label class="requiredField">First Name</label>
                                        <input id="first_name" type="text" name="first_name" class="form-control @error('name') is-invalid @enderror" value="{{ $model->first_name ?? old('first_name') }}" placeholder="First Name" required>
                                        @error('first_name')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label class="requiredField">Last Name</label>
                                        <input id="last_name" type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ $model->last_name ?? old('last_name') }}" placeholder="Last Name" required>
                                        @error('last_name')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label class="requiredField">Email</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ ($model->email) ?? old('email') }}" placeholder="Email" required>
                                        @error('email')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-6">
                                        <label class="requiredField">Phone</label>
                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ ($model->phone) ?? old('phone') }}" placeholder="Phone" required>
                                        @error('phone')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>Address</label>
                                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ ($model->address) ?? old('address') }}" placeholder="Address">
                                        @error('address')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label>City</label>
                                        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ ($model->city) ?? old('city') }}" placeholder="City">
                                        @error('city')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-4">
                                        <label>State</label>
                                        <input id="state" type="text" name="state" class="form-control @error('state') is-invalid @enderror" value="{{ $model->state ?? old('state') }}" placeholder="State">
                                        @error('state')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-4">
                                        <label>Zip Code</label>
                                        <input id="zip_code" type="text" name="zip_code" class="form-control @error('zip_code') is-invalid @enderror" value="{{ $model->zip_code ?? old('zip_code') }}" placeholder="Zip Code">
                                        @error('zip_code')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-4">
                                        <label>Home</label>
                                        <input id="home" type="text" name="home" class="form-control @error('home') is-invalid @enderror" value="{{ $model->home ?? old('home') }}" placeholder="Home">
                                        @error('home')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-4">
                                        <label>Office</label>
                                        <input type="text" name="office" class="form-control @error('office') is-invalid @enderror" value="{{ ($model->office) ?? old('office') }}" placeholder="Office">
                                        @error('office')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-4">
                                        <label>Fax</label>
                                        <input type="text" name="fax" class="form-control @error('fax') is-invalid @enderror" value="{{ ($model->fax) ?? old('fax') }}" placeholder="Fax" >
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
    </section>
    <!-- /.content -->
@endsection
