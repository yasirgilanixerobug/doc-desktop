@extends('layout.app')

@section('content')
    <!-- form body part  -->
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="container set-main-frm">
                        <h3 class="text-center">Forgot Password</h3>
                        <div class="set-inner-frm">
                            <form class="frm-top-down" action="{{ route('password.email') }}" method="post" style="margin-top: 100px">
                                @csrf
                                <div class="form-group">
                                    <input type="email" name="email" class="requiredField form-control @error('email') is-invalid @enderror" placeholder="Email" required>
                                    @error('email')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="frm-top-down">
                                    <button class="btn login-btn" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
