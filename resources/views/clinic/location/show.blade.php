@extends('layout.clinic')

@section('title', 'Location Detail')

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Location Detail {{ '( '.$model->name.' )' }}</h3>

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
                                        <span class="info-box-text text-center text-muted">Provider</span>
                                        <span class="info-box-number text-center text-muted mb-0">{{ ($model->locationProvider) ? $model->locationProvider->count() : 0 }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4 showCursor">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Status</span>
                                        <span class="info-box-number text-center text-muted mb-0">Active</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h4>Provider List</h4>
                                @foreach($model->locationProvider as $key => $providerData)
                                    <div class="post clearfix">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" src="{{ ($providerData->provider->userDetail) ? asset($providerData->provider->userDetail->image) : asset('/clinic-assets/dist/img/user1-128x128.jpg') }}" alt="user image">
                                            <span class="username">
                                                <a href="#">{{ $providerData->provider->name }} {{ $providerData->provider->status_id == 0 ? ' (Block)' : ''  }}</a>
                                            </span>
                                            <span class="description">{{ 'Created At '. date(config('app.default_date_format'), strtotime($providerData->provider->created_at)) }}</span>
                                        </div>
                                        <!-- /.user-block -->
                                        <p>
                                            {{ $providerData->provider->userDetail->about ?? 'N\A' }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h4>Staff List</h4>
                                @foreach($model->locationStaff as $key => $staffData)
                                    <div class="post clearfix">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" src="{{ ($staffData->staff->userDetail) ? asset($staffData->staff->userDetail->image) : asset('/clinic-assets/dist/img/user1-128x128.jpg') }}" alt="user image">
                                            <span class="username">
                                                <a href="#">{{ $staffData->staff->name }} {{ $staffData->staff->status_id == 0 ? ' (Block)' : ''  }}</a>
                                            </span>
                                            <span class="description">{{ 'Created At '. date(config('app.default_date_format'), strtotime($staffData->staff->created_at)) }}</span>
                                        </div>
                                        <!-- /.user-block -->
                                        <p>
                                            {{ $staffData->staff->userDetail->about ?? 'N\A' }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                        <h3 class="text-primary"><i class="fas fa-paint-brush"></i> {{ $model->name }}</h3>
                        <p class="text-muted"></p>
                        <br>
                        <div class="text-muted">
                            <p class="text-sm">Address
                                <b class="d-block">{{ $model->address }}</b>
                            </p>
                            <p class="text-sm">State
                                <b class="d-block">{{ $model->state }}</b>
                            </p>
                            <p class="text-sm">City
                                <b class="d-block">{{ $model->city }}</b>
                            </p>
                        </div>

                        <h5 class="mt-5 text-muted">Project files</h5>
                        <ul class="list-unstyled">
                            @forelse($model->businessHour as $key => $business)
                                <li>
                                    <a href="" class="btn-link text-secondary"><b>{{ $weekDays[$business->day_of_week].':' }}</b> <span>{{ $weekDays[$business->day_of_week] ?   $business->start_time . ' - '. $business->end_time : 'Close' }}</span></a>
                                </li>
                            @empty
                                Business Hour Not Set
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
