@extends('layout.clinic')

@section('title', 'Staff List')

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-body pb-0">
                <div class="row">
                    @forelse($models as $key => $staff)
                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                        <div class="card bg-light d-flex flex-fill">
                            <div class="card-header text-muted border-bottom-0">
                                {{ $staff->getRoleNames()[0] }} ( {{ isset($staff->staffLocation) ? $staff->staffLocation->location->name :  'N\A' }} )
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-7">
                                        <a href="{{ route('clinic.staff.edit', ['staff' => $staff->id]) }}"><h2 class="lead"><b>{{ $staff->name }}</b> <i class="fas fa-pencil-alt"></i> </h2></a>
                                        <p class="text-muted text-sm"><b>About: </b> {{ ($staff->userDetail->about) ??  'N\A' }}   </p>
                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: {{ ($staff->userDetail->phone) ??  'N\A' }}</li>
                                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-location-arrow "></i></span> Location #: {{ isset($staff->staffLocation) ? $staff->staffLocation->location->name :  'N\A' }}</li>
                                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span>Mail: {{ ($staff->email) ?? 'N\A' }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-5 text-center">
                                        <a href="{{ route('clinic.staff.show', ['staff' => $staff->id]) }}">
                                            <img src="{{  asset($staff->userDetail->image) }}" alt="user-avatar" class="img-circle img-fluid">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                @if($staff->id != Auth::user()->id)
                                    <div class="text-right">
                                        <form method="POST" action="{{ route('clinic.staff.destroy', ['staff' => $staff->id]) }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button onclick="return confirm('Are you sure you want to delete ?')" type="submit" class="btn btn-danger delete" title='Delete'><i class="fas fa-trash"> Delete</i></button>
                                        </form>
                                    </div>
                                @endif
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
@endsection
