@extends('layout.frontend')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="staff-main">
            <h3 class="h3-style">Provider</h3>
            <span style="padding: 5%">For appointment, select doctor from the list</span>
            <hr>
            <ul class="staff-lst-set">
                @forelse($providers as $Key => $provider)
                    <li class="set-li-staff d-flex justify-content-between align-items-center">
                        <a href="{{ route('clinicFrontend.providerProfile', ['subdomain' => request()->subdomain, 'provider' => encrypt($provider->id)]) }}" class="d-flex justify-content-between">
                            <div><img style="border-radius: 50%;" src="{{ asset($provider->userDetail->image) }}" alt=""></div>
                            <div>
                                <h6>{{ $provider->name }}</h6>
                            </div>
                        </a>
                        <div><i class="fa-solid fa-angle-right set-li-icon"></i></div>
                    </li>
                @empty
                    <!-- if result or file not found   -->
                    <x-not-found></x-not-found>
                @endforelse
            </ul>
        </div>
    </div>

{{--    <div class="col-md-4" id="side-menu-component">--}}
{{--        <x-side-menu--}}
{{--            :fullAddress="$clinicLocation->fullAddress"--}}
{{--            :phone="$clinicLocation->phone"--}}
{{--            :businessHours="$locationBusinessHours"--}}
{{--            :weekDays="$weekDays"--}}
{{--        ></x-side-menu>--}}
{{--    </div>--}}
</div>
@endsection

@push('js')
    <script>
        $(function() {
            $('li').css('cursor', 'pointer')
                .click(function() {
                    window.location = $('a', this).attr('href');
                    return false;
                });
        });
    </script>
@endpush
