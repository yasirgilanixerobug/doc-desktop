	@php 
		$providerLocationId = isset($providers[0]['providerLocationAvailability']) ? $providers[0]['providerLocationAvailability']['provider_location_id'] : 0;
		$containerItteration = 0
	@endphp

	@foreach($providers[0]['providerLocationAvailability']['available_time_slot'] as $key => $slots)
		<div class="myc-day-time-container" id="myc-day-time-container-{{ $containerItteration }}">
		@forelse($slots as $loopOne => $slot)
			@if($loop->iteration < 10)
					<a href="{{ route('clinicFrontend.appointmentForm', ['subdomain' => request()->subdomain,'appointment' =>  encrypt($providerLocationId.'|'.$slot['start_time'].'|'.$slot['date'].'|'.request()->subdomain )]) }}" 
					class="myc-available-time {{ ($slot['isAppointment'] == 1) ? 'appointment-done avoid-clicks' : '' }}" 
					data-time="{{ $slot['start_time'] }}"
					data-date="{{ $slot['date'] }}">
						@if($slot['isAppointment'] == 1)
							<del>{{ $slot['start_time'] }}</del>
							@else
							{{ $slot['start_time'] }}
						@endif
					</a>
			 @else
			 		<div class="more-slots myc-available-time more-slot-container-{{ $containerItteration }}">
				 		<a href="{{ route('clinicFrontend.appointmentForm', ['subdomain' => request()->subdomain,'appointment' =>  encrypt($providerLocationId.'|'.$slot['start_time'].'|'.$slot['date'].'|'.request()->subdomain )]) }}" 
							class="myc-available-time {{ ($slot['isAppointment'] == 1) ? 'appointment-done avoid-clicks' : '' }}" 
							data-time="{{ $slot['start_time'] }}"
							data-date="{{ $slot['date'] }}">
							@if($slot['isAppointment'] == 1)
								<del>{{ $slot['start_time'] }}</del>
								@else
								{{ $slot['start_time'] }}
							@endif
						</a>
			 		</div>
			 @endif

			@if ($loop->last)
		        <div class="myc-available-time show_hide active" data-container="{{ $containerItteration }}" style="color: white; background-color: #273c75; cursor: pointer;" data-content="toggle-text" href="#">See more</div>
		    @endif

			@empty
			<a href="#" class="myc-available-time avoid-clicks">-</a>
			<a href="#" class="myc-available-time avoid-clicks">-</a>
			<a href="#" class="myc-available-time avoid-clicks">-</a>
		@endforelse
			<div style="clear:both;"></div>
		</div>
		@php $containerItteration++ @endphp
	@endforeach
<script>
	$(document).ready(function () {
	    $(".more-slots").hide();
	    $(".show_hide").on("click", function () {
	    	var containerCounter  = $(this).data('container');
	    	var txt = $('.more-slot-container-' + containerCounter).is(':visible') ? 'See more' : 'See less';
	        $(this).text(txt);
	        $('.more-slot-container-' + containerCounter).slideToggle(200);
	    });
	});
</script>