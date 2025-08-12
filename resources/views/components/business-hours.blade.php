<div class="business-hours">
    <h5>Business hours</h5>
    <table>
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
