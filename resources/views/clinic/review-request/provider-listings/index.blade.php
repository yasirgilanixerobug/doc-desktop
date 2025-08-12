@extends('layout.clinic')

@section('title', 'Google Listing')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <!-- <div class="card-header">
                            <h3 class="card-title">Google Listing</h3>
                        </div> -->
                        <!-- /.card-header -->
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="googleListing" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="locations-tab" data-toggle="tab" href="#locations" role="tab" aria-controls="locations" aria-selected="true">
                                        Locations
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="doctors-tab" data-toggle="tab" href="#doctors" role="tab" aria-controls="doctors" aria-selected="false">
                                        Doctors
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content mt-3">
                                <div class="tab-pane fade show active" id="locations" role="tabpanel" aria-labelledby="locations-tab">
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table projects">
                                                <thead class="bg-primary text-white text-uppercase">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Address</th>
                                                        <th>Per Appointment Min</th>
                                                        <th>Action</th>
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
                                                        <td class="project-actions">
                                                            <div class="d-flex">
                                                                <a class="btn btn-primary btn-sm mr-2" href="{{ route('clinic.location.show', ['location' => $model->id]) }}">
                                                                    <i class="fas fa-eye"></i>
                                                                    View
                                                                </a>
                                                                <a class="btn btn-info btn-sm text-white" href="{{ route('clinic.location.edit', ['location' => $model->id]) }}">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                    Edit
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @if($locations->count() > 10)
                                    <div class="card-footer">
                                        {{ $locations->appends(['query' =>  Request::get('q') ])->links('pagination') }}
                                    </div>
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="doctors" role="tabpanel" aria-labelledby="doctors-tab">
                                <div class="card-body p-0">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end mb-3">
                                            <a href="{{ route ('clinic.reviewRequest.providerListing.create')}}">
                                                <button type="button" class="btn btn-primary"> <i class="fas fa-plus"></i>&nbsp;Doctor</button>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table projects">
                                            <thead class="bg-primary text-white text-uppercase">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Location</th>
                                                    <th>Status</th>
                                                    <th>Google review url</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($providerListings as $key => $model)    
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$model->provider->userDetail->Name}}</td>
                                                    <td>{{$model->location->name}}</td>
                                                    <td>{{$model->status->name}}</td>
                                                    <td>{{$model->google_review_url}}</td>
                                                    <td class="project-actions">
                                                        <div class="d-flex">
                                                            <a class="btn btn-primary btn-sm mb-2 mb-sm-0 mr-2" href="{{ route('clinic.provider.show', ['provider' => $model->provider_id]) }}">
                                                                <i class="fas fa-eye"></i> View
                                                            </a>
                                                            <a class="btn btn-info btn-sm text-white mb-2 mb-sm-0 mr-2" href="{{ route('clinic.reviewRequest.providerListing.edit', ['provider_listing' => $model->id]) }}">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                            <a class="btn btn-danger btn-sm text-white mb-2 mb-sm-0" href="{{ route('clinic.reviewRequest.providerListing.destroy', ['provider_listing' => $model->id]) }}">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach    
                                            </tbody>
                                        </table>
                                    </div>
                                    </div>
                                    @if($providerListings->count() > 10)
                                    <div class="card-footer">
                                        {{ $providerListings->appends(['query' =>  Request::get('q') ])->links('pagination') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@push('js')
<!-- Persist Active Tab Script -->
<script src="{{ asset('/clinic-assets/custom/js/persist-active-tab.js')  }}"></script>
@endpush



