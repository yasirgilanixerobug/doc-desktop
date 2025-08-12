@extends('layout.clinic')

@section('title', 'Provider List')

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-body pb-0">
                <div class="row">
                    @forelse($models as $key => $provider)
                        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                            <div class="card bg-light d-flex flex-fill">
                                <div class="card-header text-muted border-bottom-0">
                                    {{ $provider->getRoleNames()[0] }}
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-7">
                                            <a href="{{ route('clinic.provider.edit', ['provider' => $provider->id]) }}"><h2 class="lead"><b>{{ $provider->name }}</b> <i class="fas fa-pencil-alt"></i> </h2></a>
                                            <p class="text-muted text-sm"><b>About: </b> {{ ($provider->userDetail->about) ? Str::of($provider->userDetail->about)->words(15, ' ....') :  'N\A' }}   </p>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: {{ ($provider->userDetail->fullAddress) ?? 'N\A' }}</li>
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: {{ ($provider->userDetail->phone) ??  'N\A' }}</li>
                                            </ul>
                                        </div>
                                        <div class="col-5 text-center">
                                            <a href="{{ route('clinic.provider.show', ['provider' => $provider->id]) }}">
                                                <img src="{{  asset($provider->userDetail->image) }}" alt="user-avatar" width="150" height="100" class="img-circle img-fluid">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <div class="row">
                                            <div class="col-4">
                                                @if (count($provider->providerLocation) > 0)
                                                    <a href="{{ route('clinic.assignLocation.toProvider', ['provider' => $provider->id]) }}" class="btn btn-sm btn-dark">
                                                        <i class="fas fa-location-arrow"> schedule</i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('clinic.assignLocation.toProvider', ['provider' => $provider->id]) }}" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-location-arrow"> schedule</i>
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="col-4">
                                                <a href="#" data-toggle="modal" data-target="#exampleModal" class="btn btn-sm btn-primary addHoliday" data-holiday="{{ $provider->id }}" >
                                                    <i class="fas fa-calendar "> Holiday</i>
                                                </a>
                                            </div>
                                            <div class="col-4">
                                                <form method="POST" action="{{ route('clinic.provider.destroy', ['provider' => $provider->id]) }}">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button onclick="return confirm('Are you sure you want to delete ?')" type="submit" class="btn btn-sm btn-danger delete" title='Delete'><i class="fas fa-trash"> Delete</i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>No Record Found</p>
                    @endforelse
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                {{ $models->appends(['query' =>  Request::get('q') ])->links('pagination') }}
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->


    <!-- Modal Status Change -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Provider Holiday</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="holidayForm" action="#" method="post" >
                        @csrf

                        <div class="form-group">
                            <label class="control-label">Start Date</label>
                            <div>
                                <input type="date" class="form-control input-lg" name="start_date" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">End Date</label>
                            <div>
                                <input type="date" class="form-control input-lg" name="end_date" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Description</label>
                            <div>
                                <input type="text" class="form-control input-lg" name="description" required>
                            </div>
                        </div>


                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-sms btn-primary">
                                    <i class="fas fa-save"></i> Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('.addHoliday').click(function(){

            let providerId = $(this).data('holiday');
            let route = "{{ route('clinic.providerHoliday.add', [':provider']) }}";
            let url = route.replace(':provider', providerId);

            $('#holidayForm').attr('action', url);
        });
    </script>
@endpush
