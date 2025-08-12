<div class="cont-info">
    <h3 class="pointer">Directions</h3>
    <div class="location-set">
        <iframe
            src="https://www.google.com/maps/embed/v1/place?key={{ config('app.google_maps_api_key') }}&q={{ $fullAddress }}"
            width="100%" height="100%" allowfullscreen="" loading="lazy"></iframe>
    </div>
    <div class="adress-links">
        <div><a href="#"><i class="fa-solid fa-map-location"></i> {{ $fullAddress ?? 'N\A' }}</a></div>
        {{--                <div><a href="#"><i class="fa-solid fa-globe"></i> {{ $clinicCurrentLocation->email ?? 'N\A' }}</a></div>--}}
        <div><a href="#"><i class="fa-solid fa-phone"></i> {{ $phone ?? 'N\A' }}</a></div>
    </div>
    <div class="business-hours">
        <h5 class="pointer">Business hours</h5>
        <table class="pointer">
            @forelse($businessHours as $key => $hour)
                <tr>
                    <th>{{ $weekDays[$hour->day_of_week] }}</th>
                    <td>{{ $weekDays[$hour->day_of_week] ? $hour->start_time . ' - '. $hour->end_time : 'Close' }}</td>
                </tr>
            @empty
                Business Hour Not Set
            @endforelse
        </table>
    </div>
</div>
