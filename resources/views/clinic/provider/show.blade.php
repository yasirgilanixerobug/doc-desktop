@extends('layout.clinic')

@section('title', 'Provider Detail')

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Provider Detail {{ '( '.$model->name.' )' }}</h3>

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
                                        <span class="info-box-text text-center text-muted">Total Locations</span>
                                        <span class="info-box-number text-center text-muted mb-0">{{ ($model->providerLocation !== null) ?  count($model->providerLocation) : 0 }}</span>
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
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <h6>Assigned Locations List</h6>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Created at</th>
                                                <th scope="col">Full Address</th>
                                                <th scope="col">Per Appoinyment Mints</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($model->providerLocation as $key => $locationData)
                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{ $locationData->location->name }}</td>
                                                <td>{{ date(config('app.default_date_format'), strtotime($locationData->location->created_at)) }}</td>
                                                <td>{{ $locationData->location->fullAddress }}</td>
                                                <td>{{ ($locationData->location) ? $locationData->location->per_appointment_min : 'Not Set default 15' }}</td>
                                            </tr>
                                        @endforeach    
                                        </tbody>
                                    </table>
                                </div> 
                               
                            </div>
                        </div><hr>

                        <div class="row">
                            <div class="col-12"><br>
                                <h6>Provider Current Year Holidays List</h6>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">From To</th>
                                                <th scope="col">Created at</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($model->providerHoliday as $key => $holiday)
                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{ date(config('app.default_date_format'), strtotime($holiday->start_date)) . ' To '. date(config('app.default_date_format'), strtotime($holiday->end_date)) }}</td>
                                                <td>{{ date(config('app.default_date_format'), strtotime($holiday->created_at)) }}</td>
                                                <td>{{ $holiday->description }}</td>
                                                <td>
                                                    @if(date('Y-m-d', strtotime($holiday->start_date)) > now()->format('Y-m-d'))
                                                    <a href="{{ route('clinic.providerHoliday.remove', ['provider_holiday' => $holiday->id]) }}">
                                                        <button onclick="return confirm('Are you sure you want to delete ?')" type="submit" class="btn btn-sm btn-danger delete" title='Delete Holiday'><i class="fas fa-trash"> Delete</i></button>
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach    
                                        </tbody>
                                    </table>
                                </div>    
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                        <h3 class="text-primary"><i class="fas fa-paint-brush"></i>{{ $model->name }}</h3>
                        <p class="text-muted"></p>
                        <br>
                        <div class="text-muted">
                            <p class="text-sm">Address
                                <b class="d-block">{{ $model->address ?? 'N\A' }}</b>
                            </p>
                            <p class="text-sm">State
                                <b class="d-block">{{ $model->state ?? 'N\A' }}</b>
                            </p>
                            <p class="text-sm">City
                                <b class="d-block">{{ $model->city ?? 'N\A' }}</b>
                            </p>
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
