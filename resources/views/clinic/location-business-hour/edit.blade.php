@extends('layout.clinic')

@section('title', 'Edit Location Business Hours')

@section('content')
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- left column -->
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">( {{ ($locationBusinessHours[0]) ? $locationBusinessHours[0]['location']['name'] : 'N\A' }} ) Location Business Hour</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('clinic.locationBusinessHour.update', [ 'id' => $locationId ]) }}" method="post">
                        @csrf
                        @method('put')
                        <input type="hidden" name="location_id" value="{{ $locationId }}">
                        <div class="card-body">
                            <div class="row">

                                <div class="form-group col">
                                    <label>Day</label>
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" name="locationAvailability[1][day]" {{ (isset($locationDayWorkingTime[1]) && $locationDayWorkingTime[1]['is_available'] == 1) ? 'checked' : '' }} class="custom-control-input" id="customSwitch1">
                                        <label class="custom-control-label" for="customSwitch1">Monday</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <label>Start Time</label>
                                    <select class="form-control" name="locationAvailability[1][start_time]">
                                        @if(isset($locationDayWorkingTime[1]))
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == $locationDayWorkingTime[1]['start_time']) ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @else
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == '08:00 am') ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col">
                                    <label>End Time</label>
                                    <select class="form-control" name="locationAvailability[1][end_time]">
                                        @if(isset($locationDayWorkingTime[1]))
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == $locationDayWorkingTime[1]['end_time']) ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @else
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == '05:00 pm') ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" {{ (isset($locationDayWorkingTime[2]) && $locationDayWorkingTime[2]['is_available'] == 1) ? 'checked' : '' }} name="locationAvailability[2][day]" id="customSwitch2">
                                        <label class="custom-control-label" for="customSwitch2">Tuesday</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <select class="form-control" name="locationAvailability[2][start_time]">
                                        @if(isset($locationDayWorkingTime[2]))
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == $locationDayWorkingTime[2]['start_time']) ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @else
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == '08:00 am') ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-control" name="locationAvailability[2][end_time]">
                                        @if(isset($locationDayWorkingTime[2]))
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == $locationDayWorkingTime[2]['end_time']) ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @else
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == '05:00 pm') ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" {{ (isset($locationDayWorkingTime[3]) && $locationDayWorkingTime[3]['is_available'] == 1) ? 'checked' : '' }} name="locationAvailability[3][day]" id="customSwitch3">
                                        <label class="custom-control-label" for="customSwitch3">Wednesday</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <select class="form-control" name="locationAvailability[3][start_time]">
                                        @if(isset($locationDayWorkingTime[3]))
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == $locationDayWorkingTime[3]['start_time']) ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @else
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == '08:00 am') ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-control" name="locationAvailability[3][end_time]">
                                        @if(isset($locationDayWorkingTime[3]))
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == $locationDayWorkingTime[3]['end_time']) ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @else
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == '05:00 pm') ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" {{ (isset($locationDayWorkingTime[4]) && $locationDayWorkingTime[4]['is_available'] == 1) ? 'checked' : '' }} name="locationAvailability[4][day]" id="customSwitch4">
                                        <label class="custom-control-label" for="customSwitch4">Thursday</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <select class="form-control"  name="locationAvailability[4][start_time]">
                                        @if(isset($locationDayWorkingTime[4]))
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == $locationDayWorkingTime[4]['start_time']) ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @else
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == '08:00 am') ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-control"  name="locationAvailability[4][end_time]">
                                        @if(isset($locationDayWorkingTime[4]))
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == $locationDayWorkingTime[4]['end_time']) ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @else
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == '05:00 pm') ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" {{ (isset($locationDayWorkingTime[5]) && $locationDayWorkingTime[5]['is_available'] == 1) ? 'checked' : '' }}  name="locationAvailability[5][day]" id="customSwitch5">
                                        <label class="custom-control-label" for="customSwitch5">Friday</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <select class="form-control"  name="locationAvailability[5][start_time]">
                                        @if(isset($locationDayWorkingTime[5]))
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == $locationDayWorkingTime[5]['start_time']) ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @else
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == '08:00 am') ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-control"  name="locationAvailability[5][end_time]">
                                        @if(isset($locationDayWorkingTime[5]))
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == $locationDayWorkingTime[5]['end_time']) ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @else
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == '05:00 pm') ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" {{ (isset($locationDayWorkingTime[6]) && $locationDayWorkingTime[6]['is_available'] == 1) ? 'checked' : '' }}  name="locationAvailability[6][day]" id="customSwitch6">
                                        <label class="custom-control-label" for="customSwitch6">Saturday</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <select class="form-control" name="locationAvailability[6][start_time]">
                                        @if(isset($locationDayWorkingTime[6]))
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == $locationDayWorkingTime[6]['start_time']) ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @else
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == '08:00 am') ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-control" name="locationAvailability[6][end_time]">
                                        @if(isset($locationDayWorkingTime[6]))
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == $locationDayWorkingTime[6]['end_time']) ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @else
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == '05:00 pm') ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" {{ (isset($locationDayWorkingTime[0]) && $locationDayWorkingTime[0]['is_available'] == 1) ? 'checked' : '' }} name="locationAvailability[0][day]" id="customSwitch7">
                                        <label class="custom-control-label" for="customSwitch7">Sunday</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <select class="form-control" name="locationAvailability[0][start_time]">
                                        @if(isset($locationDayWorkingTime[0]))
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == $locationDayWorkingTime[0]['start_time']) ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @else
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == '08:00 am') ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-control" name="locationAvailability[0][end_time]">
                                        @if(isset($locationDayWorkingTime[0]))
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == $locationDayWorkingTime[0]['end_time']) ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @else
                                            @foreach($dayTime as $key => $time)
                                                <option {{ ($time == '05:00 pm') ? 'selected' : '' }}>{{ $time }}</option>
                                            @endforeach
                                        @endif
                                    </select>
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
            <!-- /.row -->
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
@endsection

