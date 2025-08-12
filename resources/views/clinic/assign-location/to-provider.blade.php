@extends('layout.clinic')

@section('title', 'Assign Location To Provider')

@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
        {{--                <!-- left column --> --}}
        <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Assign Location : {{ $provider->name }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="#" method="post">
                    @csrf
                    <input id="providerId" type="hidden" name="provider_id" value="{{ $provider->id }}">
                    <div class="card-body">
                        <div class="row">
                            @forelse($clinicLocations as $key => $location)
                                <div class="form-group col">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col">
                                        <input data-location-id="{{ $location->id }}"  type="checkbox" name="assignLocation[{{ $loop->iteration }}]" {{ (isset($activeLocation[$location->id]) && $activeLocation[$location->id]['status_id'] == 1) ? 'checked' : '' }} class="custom-control-input locationCheckbox" id="customSwitch{{ $loop->iteration }}"
                                        {{ in_array($location->id, $staffLocationIds->toArray()) ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="customSwitch{{ $loop->iteration }}">{{ $location->name }}</label>
                                    </div>
                                </div>
                            @empty
                                <x-alert
                                    type="danger"
                                    title="! Important Required Location"
                                    body="Please create some location first <a href='{{ route('clinic.location.create') }}'>create</a>"
                                    footer=" "
                                ></x-alert>
                            @endforelse
                        </div>
                    </div>
                    <!-- /.card-body -->
                </form>
            </div>
            <!-- /.card -->
            <!--/.col (left) -->
            <!-- /.row -->
        </div><!-- /.container-fluid -->

    </section>
    <!-- /.content -->

    <!-- ASSIGN LOCATION AVAILABILITY OF PROVIDER -->
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Set Location Availability : {{ $provider->name }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                    <tr>
                        <th style="width: 1%">
                            #
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Address
                        </th>
                        <th>
                            Per Appointment Min
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($assignLocations as $key => $model)
                        <tr>
                            <td>{{ $loop->iteration  }}</td>
                            <td>
                                <a>{{ $model->location->name }}</a><br/>
                                <small>Created {{ date(config('app.default_date_format'), strtotime($model->location->created_at)) }}</small>
                            </td>
                            <td>
                                {{ $model->location->address }}<br/>
                                <small>{{ $model->location->state.' '. $model->location->city }}</small>
                            </td>
                            <td>
                                {{ $model->location->per_appointment_min }}
                            </td>
                            <td class="project-actions">
                                @if (count($model->providerLocationAvailability) > 0)
                                    <a href="{{ route('clinic.locationAvailability.edit', ['provider_location_id' => $model->id]) }}" class="btn btn-sm btn-dark">
                                        <i class="fas fa-location-arrow"></i> Edit Availability
                                    </a>
                                @else
                                    <a href="{{ route('clinic.locationAvailability.create', ['provider_location_id' => $model->id]) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-location-arrow"></i> Add Availability
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            const providerId = $("#providerId").val();
            var url = '{{ route("clinic.assignLocation.storeOrUpdate") }}';

            $('.locationCheckbox').on('click', function (){
                let locationId = $(this).data('location-id');
                let isLocationCheck = $(this).is(':checked');

                $.ajax({
                    type:'POST',
                    url: url,
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'provider_id': providerId,
                        'location_id': locationId,
                        'is_location_check': isLocationCheck,
                    },

                    success:function(data) {
                        if (data.status === 'true')
                        {
                            toastr.success(data.message);
                        }else
                        {
                            toastr.error(data.message);

                        }

                        setTimeout(function() {
                            location.reload(true);
                        }, 2000);
                    }
                });
            });
        });
    </script>
@endpush
