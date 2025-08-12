@extends('layout.patient')

@section('content')
    <div class="home-profile">
        <h4>My Docs</h4>
            <div class="row">
                @forelse($providers as $key => $provider)
                    @php
                    $providerProfileLink = route('clinicFrontend.providerProfile', ['subdomain' => $provider['clinic_sub_domain'], 'provider' => $provider['id']]);
                    @endphp
                <div class="col-md-4">
                    <div class="card text-center custom-care">
                        <div class="card-body inner-card-care">
                            <a href="{{ $providerProfileLink }}">
                                <img class="card-img-top"
                                     src="{{ $provider['image'] }}"
                                     alt="Card image"/>
                            </a>
                            <h6 class="card-title care-blue-text">
                                <a href="{{ $providerProfileLink }}">
                                    {{ $provider['name'] }}
                                </a>
                            </h6>
{{--                            <p class="card-text">Family Medicine</p>--}}
{{--                            <div class="five-star">--}}
{{--                                <i class="fa-solid fa-star"></i>--}}
{{--                                <i class="fa-solid fa-star"></i>--}}
{{--                                <i class="fa-solid fa-star"></i>--}}
{{--                                <i class="fa-solid fa-star"></i>--}}
{{--                                <i class="fa-solid fa-star"></i>--}}
{{--                                <small class="care-blue-text">(4)</small>--}}
{{--                            </div>--}}
                            <p class="card-text">{{ $provider['about'] ?? 'N/A'  }}</p>
{{--                            <a href="{{ $providerProfileLink }}" class="btn btn-outline-danger home-btn">{{ $provider['phone'] ?? 'N/A' }}</a>--}}
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
