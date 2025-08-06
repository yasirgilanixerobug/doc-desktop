$(document).ready(function() {

    fetchTimeSlotsByDate();

    $(document).on('click', '.day', function (){
        var selectDate = $(this).text();
        var selectDateMonth = $('.current-date').text();//is current month
        var selectedDate = selectDate + ' ' + selectDateMonth;
        
        fetchTimeSlotsByDate(selectedDate);
    })

    $(document).on('click', '.appointment-time', function() {

        let appointentToken = $(this).data('appointment');
        let appointmentFormUrl = config.routes.appointmentForm;
        appointmentFormUrl = appointmentFormUrl.replace(':subdomain', config.data.subdomain);
        appointmentFormUrl = appointmentFormUrl.replace(':appointment', appointentToken);

        window.location.href = appointmentFormUrl;
    })
});

function fetchTimeSlotsByDate(date = null) {

    var dateOfSlots = (date == null) ? new Date() : new Date(date);

    var selecedDateYear = dateOfSlots.getFullYear()
    var selecedDateMonth = dateOfSlots.getMonth() + 1 
    var selecedDate = dateOfSlots.getDate()
    
    dateOfSlots = selecedDateYear + '-' + selecedDateMonth +  '-' + selecedDate;
    let getAvailableTimeSlotsByDate = config.routes.getAvailableTimeSlotsByDate;
    let getAvailableTimeSlotsByDateUrl = getAvailableTimeSlotsByDate.replace(':subdomain', config.data.subdomain);

    $.ajax({
        type:'POST',
        url: getAvailableTimeSlotsByDateUrl,
        data: {
            "_token": config.data.token,
            "subdomain": config.data.subdomain,
            "provider_id": providerId,
            "location_id": locationId,
            "date": dateOfSlots,
        },
        success:function(response) {
            document.getElementById("time-tab").innerHTML = response.html;
            appendUl();
        }
    });
}