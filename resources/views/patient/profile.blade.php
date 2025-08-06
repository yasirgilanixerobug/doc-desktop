@extends('layout.patient')

@section('content')
    <div class="row gx-5 home-profile">
        <div class="col-md-8">
            <div class="p-4">
                <h4>Contact information</h4>
                <p>Completing your profile will make it faster to book an online appointment in the future.</p>
            </div>

            <form method="post" action="{{ route('patient.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @if($errors->any())
                    <div class="validation-error-message ">{{ $errors->first() }}</div>
                    <hr>
                @endif

                <div class="form-row">
                    <div class="form-group profile-form-set col-md-6">
                        <label for="firstName">First Name</label>
                        <input id="first_name" placeholder="First Name"
                               type="text"
                               name="first_name"
                               class="form-control @error('first_name') is-invalid @enderror" value="{{ $userDetail->first_name ?? old('first_name') }}"/>
                        @error('first_name')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group profile-form-set col-md-6">
                        <label for="last_name">Last Name</label>
                        <input id="last_name" placeholder="Last Name"
                               type="text"
                               name="last_name"
                               class="form-control @error('last_name') is-invalid @enderror" value="{{ $userDetail->last_name ?? old('last_name') }}"/>
                        @error('last_name')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group profile-form-set col-md-6">
                        <label for="phone">Phone</label>
                        <input id="phone" placeholder="Phone"
                               type="tel"
                               name="phone"
                               class="form-control @error('phone') is-invalid @enderror" value="{{ $userDetail->phone ?? old('phone') }}"/>
                        @error('phone')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group profile-form-set col-md-6">
                        <label for="email">Email</label>
                        <input type="email" placeholder="Email"
                               id="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror" value="{{ $authUser->email ?? old('email') }}"/>
                        @error('email')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group profile-form-set">
                    <label for="address">Address</label>
                    <input type="text"
                        id="address"
                        placeholder="Address"
                           name="address"
                           class="form-control @error('address') is-invalid @enderror" value="{{ $userDetail->address ?? old('address') }}"/>
                    @error('address')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-row">
                    <div class="form-group profile-form-set col-md-4">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" placeholder="City"
                               class="form-control @error('city') is-invalid @enderror" value="{{ $userDetail->city ?? old('city') }}"/>
                        @error('city')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group profile-form-set col-md-4">
                        <label for="state">State</label>
                        <input type="text" id="state" name="state" placeholder="State"
                               class="form-control @error('state') is-invalid @enderror" value="{{ $userDetail->state ?? old('state') }}"/>
                        @error('state')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group profile-form-set col-md-4">
                        <label for="zip_code">Zip</label>
                        <input type="text" id="zip_code" name="zip_code" placeholder="zip_code"
                               class="form-control @error('zip_code') is-invalid @enderror" value="{{ $userDetail->zip_code ?? old('zip_code') }}"/>
                        @error('zip_code')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group profile-form-set col-md-6">
                        <label for="dateofBirth">Date of Birth</label>
                        <input type="text" placeholder="mm/dd/yyyy"
                               id="dob"
                               name="dob"
                               class="form-control @error('dob') is-invalid @enderror" value="{{ $userDetail->dob ?? old('dob') }}"/>
                        @error('dob')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group profile-form-set col-md-6">
                        <label for="gender_id">Gender</label>
                        <select id="gender_id" name="gender_id" class="form-control">
                            <option>Choose</option>
                            @foreach($genders as $key => $gender)
                                <option value="{{ $gender->id }}" {{ ($gender->id === $userDetail->gender_id) ? 'selected' : ''  }}>{{ $gender->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group profile-form-set col-md-12">
                        <div class="custom-file">
                            <input name="image"
                                type="file"
                                class="custom-file-input"
                                accept="image/png, image/jpeg"
                                id="image"/>
                            <label class="custom-file-label"
                                for="image">  Choose image </label>
                        </div>
                    </div>
                </div>

                <br>
                <hr>
                <!-- get information from user section -->
                <div class="insurance">
                    <h4>Health Insurance Information</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input name="ins_front"
                                        type="file"
                                        class="custom-file-input"
                                        accept="image/png, image/jpeg"
                                        id="ins_front"/>
                                    <label class="custom-file-label"
                                        for="ins_front">Choose image front</label>
                                </div>
                            </div>
                            <small class="small-caption">image.png, image.jpeg</small>
                        </div>
                        <div class="form-group col-lg-6">
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input name="ins_back"
                                        type="file"
                                        class="custom-file-input"
                                        accept="image/png, image/jpeg"
                                        id="ins_back"/>
                                    <label class="custom-file-label" for="ins_back">Choose image back</label>
                                </div>
                            </div>
                            <small class="small-caption">image.png, image.jpeg</small>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input name="ins_document"
                                name="document"
                                type="file"
                                class="custom-file-input"
                                id="ins_document"
                            />
                            <label class="custom-file-label" for="ins_document">Choose doc file</label>
                        </div>
                    </div>
                    <small class="small-caption">all .doc types</small>
                </div>
                <!-- end button save changes -->
                <button class="button-27 home-btn" type="submit">
                    Save changes
                </button>
            </form>
        </div>

        <div class="col-md-4">
            <div class="p-4">
                <div class="custom-container">
                    <h4>Profile Image</h4>
                    <img src="{{ $userDetail->image }}" width="200" height="150">
                </div>
                <br>
                <div class="custom-container">
                    <h4>Change Password</h4>
                    <p>
                        if you don't request a password reset, no further
                        action is required.
                    </p>
                </div>
                <form method="POST" action="{{ route('patient.changePassword') }}">
                    @csrf
                    <div class="form-group">
                        <input type="password" name="old_password" id="old_password"
                            class="form-control @error('old_password') validation-error @enderror"
                            placeholder="Old Password"
                            required/>
                        @error('old_password')
                        <div class="validation-error-message ">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" name="password"
                            id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="New Password"
                            required/>
                        @error('password')
                        <div class="validation-error-message ">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" name="password_confirmation"
                            id="password_confirmation"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Confirm Password"
                            required/>
                        @error('password_confirmation')
                        <div class="validation-error-message ">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="button-27" role="button" type="submit">Save</button>
                    <button class="button-28" role="button">Cancel</button>
                    <hr />
                </form>
                @if($insurance)
                <div>
                    <h4>Uploaded Insurance Document</h4>
                    <p>
                        you can download uploaded insurance documents here
                    </p>
                    <ul>
                        @if (isset($insurance->ins_front))
                        <li><a href="{{ route('patient.insDownload', ['file_path' => $insurance->ins_front_full_path]) }}"><i class="fa-solid fa-image"></i> Insurance Front</a></li>
                        @endif

                        @if (isset($insurance->ins_back))
                        <li><a href="{{ route('patient.insDownload', ['file_path' => $insurance->ins_back_full_path]) }}"><i class="fa-solid fa-image"></i> Insurance Back</a></li>
                        @endif

                        @if (isset($insurance->ins_document))
                        <li><a href="{{ route('patient.insDownload', ['file_path' => $insurance->ins_document_full_path]) }}"><i class="fa-solid fa-image"></i> Insurance Document</a></li>
                        @endif
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
