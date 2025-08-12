$(document).ready(function (){
    let subdomain = config.data.subdomain;
    let token = config.data.token;

    $(document).on('click', '.appointment-time', function() {
        if (confirm('Are you sure you want to book an appointment?')) {
            var appointment = $(this).data('appointment');

            //for local
            //var url = '{{ route("clinicFrontend.appointmentForm", [":appointment", ":subdomain"]) }}';
            //for server
            var url = config.routes.appointmentForm;
            url = url.replace(':subdomain', subdomain);
            url = url.replace(':appointment', appointment);

            window.open(url, '_self');
        }
    });

    //get more clinic locations
    $(document).on('click', '.see-more' , function() {
        var btnType = $(this).data('btn-type');
        let route = config.routes.getAvailableTimeSlotsOfProvider;
        let providerLocationId = $(this).data('provider-location-id');
        let url = route.replace(':subdomain', subdomain);

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: token,
                subdomain: subdomain,
                provider_location_id: providerLocationId,
                btn_type: btnType,
            },
            success: function(response) {
                $("#exampleModalCenter").appendTo("body").modal('show');
                $(".modal-body").html(response.html);
            },
            error: function(xhr) {
                //Do Something to handle error
            }
        });
    });

    $(document).on('click', '.close',function(){
        $(".modal-body").empty();
        $("#exampleModalCenter").modal('hide');
    });
});
