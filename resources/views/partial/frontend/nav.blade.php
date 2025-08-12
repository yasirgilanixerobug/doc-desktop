<!-- navbar start here!  -->
<nav class="navbar navbar-expand-md navbar-dark color-bground">
    <a class="navbar-brand logo-set" href="#">
        <img src="{{ asset( $clinicComposer->brandLogo ?? config('app.logo_icon')) }}" alt="Brand logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav nav-custom">
            @php $requestUrl = request()->route()->getName();  @endphp
            <li class="nav-item {{ ($requestUrl == 'clinicFrontend.home') ? 'active' : '' }}">
                <a class="nav-link {{ ($requestUrl == 'clinicFrontend.home') ? 'bottom-bdr' : '' }}" href="{{ route('clinicFrontend.home', ['subdomain' => request()->subdomain ]) }}">Home <span class="sr-only">(current)</span></a>
            </li>
{{--            <li class="nav-item  {{ ($requestUrl == 'clinicFrontend.about') ? 'active' : '' }}">--}}
{{--                <a class="nav-link {{ ($requestUrl == 'clinicFrontend.about') ? 'bottom-bdr' : '' }}" href="{{ route('clinicFrontend.about', ['subdomain' => request()->subdomain ]) }}">About</a>--}}
{{--            </li>--}}
{{--            <li class="nav-item {{ ($requestUrl == 'clinicFrontend.review') ? 'active' : '' }}">--}}
{{--                <a class="nav-link {{ ($requestUrl == 'clinicFrontend.review') ? 'bottom-bdr' : '' }}" href="{{ route('clinicFrontend.review', ['subdomain' => request()->subdomain ]) }}">Review</a>--}}
{{--            </li>--}}
            <li class="nav-item {{ ($requestUrl == 'clinicFrontend.provider' || $requestUrl == 'clinicFrontend.providerProfile' ) ? 'active' : '' }}">
                <a class="nav-link {{ ($requestUrl == 'clinicFrontend.provider' || $requestUrl == 'clinicFrontend.providerProfile') ? 'bottom-bdr' : '' }}" href="{{ route('clinicFrontend.provider', ['subdomain' => request()->subdomain ]) }}">Provider</a>
            </li>
            <li class="nav-item {{ ($requestUrl == 'clinicFrontend.location' || $requestUrl == 'clinicFrontend.locationProviders' ) ? 'active' : '' }}">
                <a class="nav-link {{ ($requestUrl == 'clinicFrontend.location' || $requestUrl == 'clinicFrontend.locationProviders') ? 'bottom-bdr' : '' }}" href="{{ route('clinicFrontend.location', ['subdomain' => request()->subdomain ]) }}">Locations</a>
            </li>

        </ul>
    </div>
    @auth
        <a class="navbar-brand" href="#">
            {{ auth()->user()->name }}
        </a>
    @endauth
</nav>
<!-- navbar ended here  -->
