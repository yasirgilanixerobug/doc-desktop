@extends('layout.clinic')

@section('title', 'Location List')

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Locations</h3>

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
                        <th>
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
                    @foreach($locations as $key => $model)
                        <tr>
                            <td>{{ $loop->iteration  }}</td>
                            <td>
                                <a>{{ $model->name }}</a><br/>
                                <small>Created {{ date(config('app.default_date_format'), strtotime($model->created_at)) }}</small>
                            </td>
                            <td>
                                {{ $model->address }}<br/>
                                <small>{{ $model->state.' '. $model->city }}</small>
                            </td>
                            <td class="project_progress">
                                {{ $model->per_appointment_min }}
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm" href="{{ route('clinic.location.show', ['location' => $model->id]) }}">
                                    <i class="fas fa-eye">
                                    </i>
                                    View
                                </a>
                                <a class="btn btn-info btn-sm" href="{{ route('clinic.location.edit', ['location' => $model->id]) }}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Edit
                                </a>
                                @if(count($model->businessHour) > 0)
                                    <a class="btn btn-dark btn-sm" href="{{ route('clinic.locationBusinessHour.edit', ['location_id' => $model->id]) }}">
                                        <i class="fas fa-location-arrow">
                                        </i>
                                        Business Hours
                                    </a>
                                @else
                                    <a class="btn btn-info btn-sm" href="{{ route('clinic.locationBusinessHour.create', ['location_id' => $model->id]) }}">
                                        <i class="fas fa-location-arrow">
                                        </i>
                                        Business Hours
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
