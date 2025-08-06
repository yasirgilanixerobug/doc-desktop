<script>
    let config = {
        routes: {
            findCustomerRoute: "{{ route('clinicFrontend.findCustomer', [":subdomain"]) }}",
            appointmentForm: "{{ route('clinicFrontend.appointmentForm', [":subdomain", ":appointment"]) }}",
            getAvailableTimeSlotsOfProvider: "{{ route('clinicFrontend.getAvailableTimeSlotsOfProvider', [':subdomain']) }}",
            getProvidersByLocation: "{{ route('clinicFrontend.getProvidersByLocation', [":subdomain"]) }}",
            getAvailableTimeSlotsByDate: "{{ route('clinicFrontend.getAvailableTimeSlotsByDate', [":subdomain"]) }}",
            getWeeklyAvailableSlots: "{{ route('clinicFrontend.getWeeklyAvailableSlots', [":subdomain"]) }}",
        },
        data: {
            subdomain: "{{ request()->subdomain }}",
            token: "{{ csrf_token() }}"
        }
    };
</script>
