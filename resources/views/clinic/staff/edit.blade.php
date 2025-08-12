@extends('layout.clinic')

@section('title', 'Edit Staff')

@push('css')
    <link rel="stylesheet" href="{{ asset('clinic-assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('clinic-assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

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
                        <form action="{{ route('clinic.staff.update', ['staff' => $model->id]) }}" method="post">
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

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label class="requiredField">Role</label>
                                        <select id="role" name="role" class="form-control" required>
                                            <option value="">Select Role</option>
                                            @foreach($roles as $key => $role)
                                                <option {{ ( $role['name'] == $model->getRoleNames()[0]) ? 'selected' : '' }}  value="{{ $role['name'] }}">{{ $role['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-6">
                                        <label class="requiredField">Assign Location</label>
                                        <select class="select2 form-control" id="location" name="location_id[]" multiple="multiple" data-placeholder="Select a location" style="width: 100%;">
                                            <option value="">Select Location</option>
                                            @foreach($locations as $key => $location)
                                                <option {{ ( isset($model->staffLocations) && in_array($location->id, $model->staffLocations->pluck('location_id')->toArray())) ? 'selected' : '' }}  value="{{ $location->id }}">{{ $location->name }}</option>
                                            @endforeach
                                        </select>
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

@push('js')
    <!-- Select2 -->
    <script src="{{ asset('clinic-assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>
@endpush
