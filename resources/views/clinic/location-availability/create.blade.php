@extends('layout.clinic')

@section('title', 'Add Location Availability')

@section('content')
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
{{--                <!-- left column --> --}}
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">( {{ $locationName }} ) Location Availability for {{ $providerName }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('clinic.locationAvailability.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="provider_location_id" value="{{ $providerLocationId }}">
                                <div class="card-body">

                                    <div class="row">

                                        <div class="form-group col">
                                            <label>Day</label>
                                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col isDisable {{ !in_array(1, $locationBusinessDays) ? 'disabled' : ''  }}">
                                                <input type="checkbox" name="locationAvailability[1][day]" {{ !in_array(1, $locationBusinessDays) ? 'disabled' : ''  }} class="custom-control-input" id="customSwitch1">
                                                <label class="custom-control-label" for="customSwitch1">Monday</label>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <label>Start Time</label>
                                            <select class="form-control" name="locationAvailability[1][start_time]" {{ !in_array(1, $locationBusinessDays) ? 'disabled' : ''  }}>
                                                @foreach($dayTime as $key => $time)
                                                    <option {{ ($time == '08:00 am') ? 'selected' : '' }}>{{ $time }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col">
                                            <label>End Time</label>
                                            <select class="form-control" name="locationAvailability[1][end_time]" {{ !in_array(1, $locationBusinessDays) ? 'disabled' : ''  }}>
                                                @foreach($dayTime as $key => $time)
                                                    <option {{ ($time == '05:00 pm') ? 'selected' : '' }}>{{ $time }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="form-group col">
                                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success isDisable {{ !in_array(2, $locationBusinessDays) ? 'disabled' : ''  }}">
                                                <input type="checkbox" class="custom-control-input" name="locationAvailability[2][day]" {{ !in_array(2, $locationBusinessDays) ? 'disabled' : ''  }} id="customSwitch2">
                                                <label class="custom-control-label" for="customSwitch2">Tuesday</label>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <select class="form-control" name="locationAvailability[2][start_time]" {{ !in_array(2, $locationBusinessDays) ? 'disabled' : ''  }}>
                                                @foreach($dayTime as $key => $time)
                                                    <option {{ ($time == '08:00 am') ? 'selected' : '' }}>{{ $time }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <select class="form-control" name="locationAvailability[2][end_time]" {{ !in_array(2, $locationBusinessDays) ? 'disabled' : ''  }}>
                                                @foreach($dayTime as $key => $time)
                                                    <option {{ ($time == '05:00 pm') ? 'selected' : '' }}>{{ $time }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="form-group col">
                                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success isDisable" {{ !in_array(3, $locationBusinessDays) ? 'disabled' : ''  }}>
                                                <input type="checkbox" class="custom-control-input" name="locationAvailability[3][day]" {{ !in_array(3, $locationBusinessDays) ? 'disabled' : ''  }} id="customSwitch3">
                                                <label class="custom-control-label" for="customSwitch3">Wednesday</label>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <select class="form-control" name="locationAvailability[3][start_time]" {{ !in_array(3, $locationBusinessDays) ? 'disabled' : ''  }}>
                                                @foreach($dayTime as $key => $time)
                                                    <option {{ ($time == '08:00 am') ? 'selected' : '' }}>{{ $time }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col">
                                            <select class="form-control" name="locationAvailability[3][end_time]" {{ !in_array(3, $locationBusinessDays) ? 'disabled' : ''  }}>
                                                @foreach($dayTime as $key => $time)
                                                    <option {{ ($time == '05:00 pm') ? 'selected' : '' }}>{{ $time }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="form-group col">
                                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success isDisable {{ !in_array(4, $locationBusinessDays) ? 'disabled' : ''  }}">
                                                <input type="checkbox" class="custom-control-input" name="locationAvailability[4][day]" {{ !in_array(4, $locationBusinessDays) ? 'disabled' : ''  }} id="customSwitch4">
                                                <label class="custom-control-label" for="customSwitch4">Thursday</label>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <select class="form-control"  name="locationAvailability[4][start_time]" {{ !in_array(4, $locationBusinessDays) ? 'disabled' : ''  }}>
                                                @foreach($dayTime as $key => $time)
                                                    <option {{ ($time == '08:00 am') ? 'selected' : '' }}>{{ $time }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col">
                                            <select class="form-control"  name="locationAvailability[4][end_time]" {{ !in_array(4, $locationBusinessDays) ? 'disabled' : ''  }}>
                                                @foreach($dayTime as $key => $time)
                                                    <option {{ ($time == '05:00 pm') ? 'selected' : '' }}>{{ $time }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success isDisable {{ !in_array(5, $locationBusinessDays) ? 'disabled' : ''  }}">
                                                <input type="checkbox" class="custom-control-input"  name="locationAvailability[5][day]" {{ !in_array(5, $locationBusinessDays) ? 'disabled' : ''  }} id="customSwitch5">
                                                <label class="custom-control-label" for="customSwitch5">Friday</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <select class="form-control"  name="locationAvailability[5][start_time]" {{ !in_array(5, $locationBusinessDays) ? 'disabled' : ''  }}>
                                                @foreach($dayTime as $key => $time)
                                                    <option {{ ($time == '08:00 am') ? 'selected' : '' }}>{{ $time }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <select class="form-control"  name="locationAvailability[5][end_time]" {{ !in_array(5, $locationBusinessDays) ? 'disabled' : ''  }}>
                                                @foreach($dayTime as $key => $time)
                                                    <option {{ ($time == '05:00 pm') ? 'selected' : '' }}>{{ $time }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success isDisable {{ !in_array(6, $locationBusinessDays) ? 'disabled' : ''  }}">
                                                <input type="checkbox" class="custom-control-input"  name="locationAvailability[6][day]" {{ !in_array(6, $locationBusinessDays) ? 'disabled' : ''  }} id="customSwitch6">
                                                <label class="custom-control-label" for="customSwitch6">Saturday</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <select class="form-control" name="locationAvailability[6][start_time]" {{ !in_array(6, $locationBusinessDays) ? 'disabled' : ''  }}>
                                                @foreach($dayTime as $key => $time)
                                                    <option {{ ($time == '08:00 am') ? 'selected' : '' }}>{{ $time }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <select class="form-control" name="locationAvailability[6][end_time]" {{ !in_array(6, $locationBusinessDays) ? 'disabled' : ''  }}>
                                                @foreach($dayTime as $key => $time)
                                                    <option {{ ($time == '05:00 pm') ? 'selected' : '' }}>{{ $time }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success isDisable {{ !in_array(0, $locationBusinessDays) ? 'disabled' : ''  }}">
                                                <input type="checkbox" class="custom-control-input" name="locationAvailability[0][day]" {{ !in_array(0, $locationBusinessDays) ? 'disabled' : ''  }} id="customSwitch7">
                                                <label class="custom-control-label" for="customSwitch7">Sunday</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <select class="form-control" name="locationAvailability[0][start_time]" {{ !in_array(0, $locationBusinessDays) ? 'disabled' : ''  }}>
                                                @foreach($dayTime as $key => $time)
                                                    <option {{ ($time == '08:00 am') ? 'selected' : '' }}>{{ $time }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <select class="form-control" name="locationAvailability[0][end_time]" {{ !in_array(0, $locationBusinessDays) ? 'disabled' : ''  }}>
                                                @foreach($dayTime as $key => $time)
                                                    <option {{ ($time == '05:00 pm') ? 'selected' : '' }}>{{ $time }}</option>
                                                @endforeach
                                            </select>
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
                    <!--/.col (left) -->
                <!-- /.row -->
            </div><!-- /.container-fluid -->

        </section>
        <!-- /.content -->
@endsection

@push('js')
    <script>
        $(document).ready(function(){
            $('.isDisable').click(function(){
                var isDisabled =  $(this).hasClass("disabled");
                if (isDisabled === true){
                    toastr.info('first enable this day slot in location');
                }
            });
        });
    </script>
@endpush
