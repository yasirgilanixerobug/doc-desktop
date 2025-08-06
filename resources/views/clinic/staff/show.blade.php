@extends('layout.clinic')

@section('title', 'Staff Detail')

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Staff Detail {{ '( '.$model->name.' )' }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                        <div class="row">
                            <div class="col-12 col-sm-4 showCursor">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Created At</span>
                                        <span class="info-box-number text-center text-muted mb-0">{{ date(config('app.default_date_format'), strtotime($model->created_at)) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4 showCursor">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Status</span>
                                        <span class="info-box-number text-center text-muted mb-0">{{ $model->status->name }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-4 showCursor">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Location</span>
                                        <span class="info-box-number text-center text-muted mb-0">{{ isset($model->staffLocations[0]) ? $model->staffLocations[0]->location->name : 'N\A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table id="w0" class="table table-striped table-bordered detail-view">
                                    <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ ( $model->name) ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $model->email  ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Assign Locations</th>
                                        <td>
                                        @forelse($model->staffLocations as $key => $staffLocation)
                                                <small class="badge badge-danger"> {{ $staffLocation->location->name }}</small>
                                            @empty
                                                <small class="badge badge-danger"> N / A</small>
                                        @endforelse
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Role</th>
                                        <td>{{ $model->getRoleNames()[0]  ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ $model->userDetail->phone  ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{ date(config('app.default_date_format'), strtotime($model->created_at)) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>{{ date(config('app.default_date_format'), strtotime($model->updated_at)) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
