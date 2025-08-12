@extends('layout.clinic')

@section('title', 'Change Provider Password')

@section('content')

    <!-- Page Content -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            @if($errors->any())
                                <div class="validation-error-message ">{{ $errors->first() }}</div>
                            @endif
                            <!-- Change Password Form -->
                                <form  method="POST" action="{{ route('clinic.changePassword') }}">
                                    @csrf
                                    <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="requiredField">Old Password</label>
                                                    <input type="password" name="old_password" class="form-control @error('old_password') validation-error @enderror" required>
                                                    @error('old_password')
                                                        <div class="validation-error-message ">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="requiredField">New Password</label>
                                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                                    @error('password')
                                                    <div class="validation-error-message ">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="requiredField">Confirm Password</label>
                                                    <input type="password" name="password_confirmation" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <button type="submit" class="w-100 btn btn-primary submit-btn">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                </form>
                            <!-- /Change Password Form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Page Content -->
@endsection
