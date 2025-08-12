@extends('layout.clinic')

@section('title', 'Clinic Profile Settings')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle bg-gray"
                                     src="{{ asset($clinic->brandLogo)  }}"
                                     alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ $clinic->name }}</h3>

                            <p class="text-muted text-center">{{ $clinic->owner->name . ' ( owner )' }}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Provider</b> <a class="float-right">{{ $clinic->providers->count() }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Staff</b> <a class="float-right">{{ $clinic->staffs->count() }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Locations</b> <a class="float-right">{{ $clinic->locations->count() }}</a>
                                </li>
                            </ul>

                            <a href="#" class="btn btn-dark btn-block"><b>{{ $clinic->status->name }}</b></a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About Me</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                            <p class="text-muted">{{ $clinic->owner->userDetail->fullAddress ?? 'N\A' }}</p>

                            <hr>

                            <strong><i class="fas fa-phone-alt mr-1"></i> Contact</strong>

                            <p class="text-muted">
                                <span class="tag tag-danger">Phone: {{ $clinic->owner->userDetail->phone ?? 'N\A' }}</span><br>
                                <span class="tag tag-success">Fax: {{ $clinic->owner->userDetail->fax ?? 'N\A' }}</span><br>
                                <span class="tag tag-info">Email: {{ $clinic->owner->userDetail->email ?? 'N\A' }}</span><br>
                            </p>

                            <hr>

                            <strong><i class="far fa-file-alt mr-1"></i> About</strong>

                            <p class="text-muted">{{ $clinic->about }}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#locations" data-toggle="tab">Locations</a></li>
                                <li class="nav-item"><a class="nav-link" href="#providers" data-toggle="tab">Providers</a></li>
                                <li class="nav-item"><a class="nav-link" href="#staffs" data-toggle="tab">Staffs</a></li>
                                <li class="nav-item"><a class="nav-link" href="#clinicSettings" data-toggle="tab">Clinic Setting</a></li>
                                <li class="nav-item"><a class="nav-link" href="#ownerSettings" data-toggle="tab">Owner Setting</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="locations">
                                    @forelse($clinic->locations as $key => $location)
                                    <!-- Post -->
                                    <div class="post">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" src="{{ asset($location->image) }}" alt="user image">
                                            <span class="username">
                                              <a href="{{ route('clinic.location.show', ['location' => $location->id]) }}">{{ $location->name }}</a>
                                              <a href="#" class="float-right btn-tool"><i class="fas fa-business-time "></i>{{ $location->per_appointment_min }}</a>
                                            </span>
                                        </div>
                                        <!-- /.user-block -->
                                        <p>
                                            {{ $location->fullAddress }}
                                        </p>
                                    </div>
                                    @empty
                                            <x-alert
                                                type="info"
                                                title="! Location Not Found"
                                                body="Please create some location first <a href='{{ route('clinic.location.create') }}'>create</a>"
                                                footer=" "
                                            ></x-alert>
                                    <!-- /.post -->
                                    @endforelse
                                </div>

                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="providers">
                                    @forelse($clinic->providers as $key => $provider)
                                        <!-- Post -->
                                            <div class="post">
                                                <div class="user-block">
                                                    <img class="img-circle img-bordered-sm" src="{{ asset($provider->userDetail->image) }}" alt="user image">
                                                    <span class="username">
                                                  <a href="{{ route('clinic.provider.show', ['provider' => $provider->id]) }}">{{ $provider->name }}</a>
                                                  <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                                </span>
                                                </div>
                                                <!-- /.user-block -->
                                                <p>
                                                    {{ $provider->userDetail->about ?? 'N\A' }}
                                                </p>
                                            </div>
                                            <!-- /.post -->
                                        @empty
                                            <x-alert
                                                type="info"
                                                title="! Provider Not Found"
                                                body="Please create some provider first <a href='{{ route('clinic.provider.create') }}'>create</a>"
                                                footer=" "
                                            ></x-alert>
                                        @endforelse
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="staffs">
                                    @forelse($clinic->staffs as $key => $staff)
                                        <!-- Post -->
                                            <div class="post">
                                                <div class="user-block">
                                                    <img class="img-circle img-bordered-sm" src="{{ asset($staff->userDetail->image) }}" alt="user image">
                                                    <span class="username">
                                                  <a href="{{ route('clinic.staff.show', ['staff' => $staff->id]) }}">{{ $staff->name }}</a>
                                                  <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                                </span>
                                                </div>
                                                <!-- /.user-block -->
                                                <p>
                                                    {{ $staff->userDetail->about ?? 'N\A' }}
                                                </p>
                                            </div>
                                            <!-- /.post -->
                                        @empty
                                            <x-alert
                                                type="info"
                                                title="! Staff Not Found"
                                                body="Please create some staff first <a href='{{ route('clinic.staff.create') }}'>create</a>"
                                                footer=" "
                                            ></x-alert>
                                        @endforelse
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="clinicSettings">
                                    <form id="clinicSettingForm" class="form-horizontal" action="{{ route('clinic.changeClinicProfile', ['clinic_id' => $clinic->id]) }}" method="post"  enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label requiredField ">Background Color</label>
                                            <div class="col-sm-10">
                                                <input type="color" class="form-control @error('background_color') is-invalid @enderror" value="{{ $clinic->configuration->background_color ?? old('background_color') }}" id="background_color" name="background_color" placeholder="Background Color" required>
                                                @error('background_color')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label requiredField ">Text Color</label>
                                            <div class="col-sm-10">
                                                <input type="color" class="form-control @error('color') is-invalid @enderror" value="{{ $clinic->configuration->color ?? old('color') }}" id="color" name="color" placeholder="Text Color" required>
                                                @error('color')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label requiredField ">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $clinic->name ?? old('name') }}" id="name" name="name" placeholder="Name" required>
                                                @error('name')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label requiredField">Sub Domain</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control @error('sub_domain') is-invalid @enderror" value="{{  $clinic->sub_domain ?? old('sub_domain') }}" id="sub_domain" name="sub_domain" placeholder="Sub Domain" required>
                                                @error('sub_domain')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName2" class="col-sm-2 col-form-label">Logo</label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" id="inputName2" placeholder="Logo">
                                                @error('logo')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputExperience" class="col-sm-2 col-form-label">Fav Icon</label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control @error('favicon') is-invalid @enderror" name="favicon" id="favicon" placeholder="Favicon">
                                                @error('favicon')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">About</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control @error('about') is-invalid @enderror" name="about" placeholder="About" rows="7">{{  $clinic->about ?? old('about') }}</textarea>
                                                @error('about')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="ownerSettings">
                                    <form id="ownerSettingForm" class="form-horizontal" action="{{ route('clinic.changeOwnerProfile', ['owner_id' => $clinic->owner_id]) }}" method="post"  enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="row">
                                            <div class="form-group col">
                                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col">
                                                    <input type="checkbox" name="is_send_sms" class="custom-control-input" {{ (isset($clinic->configuration) && $clinic->configuration->is_send_sms == 1) ? 'checked' : '' }} id="customSwitch1">
                                                    <label class="custom-control-label" for="customSwitch1">Send SMS</label>
                                                </div>
                                            </div>

                                            <div class="form-group col">
                                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col">
                                                    <input type="checkbox" name="is_send_email" class="custom-control-input" {{ (isset($clinic->configuration) && $clinic->configuration->is_send_email == 1) ? 'checked' : '' }}  id="customSwitch2">
                                                    <label class="custom-control-label" for="customSwitch2">Send Email</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label requiredField ">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="requiredField form-control @error('name') is-invalid @enderror" value="{{ $clinic->owner->name ?? old('name') }}" id="name" name="name" placeholder="Name" required>
                                                @error('name')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label requiredField">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="requiredField form-control @error('email') is-invalid @enderror" value="{{  $clinic->owner->email ?? old('email') }}" id="sub_domain" name="email" placeholder="Email" required>
                                                @error('email')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label requiredField">Gender</label>
                                            <div class="col-sm-10">
                                                <select name="gender_id" id="gender_id" class="form-control @error('gender_id') is-invalid @enderror">
                                                    <option value="">Select Gender</option>
                                                    @foreach($genders as $keyGender => $gender)
                                                        <option value="{{ $gender->id }}" {{ ($gender->id == $clinic->owner->userDetail->gender_id) ? 'selected' : ' ' }} >{{ $gender->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('gender_id')
                                                    <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Image</label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"  placeholder="image">
                                                @error('image')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">About</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="about" class="form-control @error('about') is-invalid @enderror" value="{{  $clinic->owner->userDetail->about ?? old('about') }}" placeholder="About">
                                                @error('about')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">State</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" value="{{  $clinic->owner->userDetail->state ?? old('state') }}" placeholder="State">
                                                @error('state')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">City</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{  $clinic->owner->userDetail->city ?? old('city') }}" placeholder="City">
                                                @error('city')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{  $clinic->owner->userDetail->address ?? old('address') }}" placeholder="Address">
                                                @error('address')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label requiredField">Phone</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{  $clinic->owner->userDetail->phone ?? old('phone') }}" placeholder="Phone" required>
                                                @error('phone')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Home</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="home" class="requiredField form-control @error('home') is-invalid @enderror" value="{{  $clinic->owner->userDetail->home ?? old('home') }}" placeholder="Home">
                                                @error('home')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Office</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="office" class="form-control @error('office') is-invalid @enderror" value="{{  $clinic->owner->userDetail->office ?? old('office') }}" placeholder="Office">
                                                @error('office')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Fax</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="fax" class="form-control @error('fax') is-invalid @enderror" value="{{  $clinic->owner->userDetail->fax ?? old('fax') }}" placeholder="fax">
                                                @error('fax')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->

                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
