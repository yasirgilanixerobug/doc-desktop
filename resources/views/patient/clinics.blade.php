@extends('layout.patient')

@section('content')
    <div class="home-profile">
        <h4>Practice</h4>
        <div class="row">
            @forelse($clinics as $key => $clinic)
                <div class="col-md-4">
                <div class="card text-center custom-care">
                    <div class="card-body inner-card-care">
                        <img class="card-img-top"
                            src="{{ $clinic['logo'] }}"
                            alt="Card image"/>
                        <h6 class="card-title care-blue-text">{{ $clinic['name']  }}</h6>
                        <p class="card-text">
                            {{ $clinic['about'] ? Str::of($clinic['about'])->words(30, ' ....') : 'N/A' }}
                        </p>
                        <a href="{{ route('clinicFrontend.home', ['subdomain' => $clinic['sub_domain'] ]) }}" class="btn btn-danger home-btn">Visit</a>
                    </div>
                </div>
            </div>
            @empty
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <i class="fa-regular fa-calendar-xmark no-appoint pb-2"></i>
                            <a href="#"><h5 class="card-title text-danger">Not Found</h5></a>
                            <p class="card-text">No Record Found</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
