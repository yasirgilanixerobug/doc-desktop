$(document).ready(function (){
	// $('#contact-tab').click(function (){
    //     getWeeklyAvailableSlots();
	// })
})


function getWeeklyAvailableSlots(date = null) {
	let availableTimeSlot = [];
	var dateOfSlots = (date == null) ? new Date() : new Date(date);
	var selecedDateYear = dateOfSlots.getFullYear();
    var selecedDate = dateOfSlots.getDate()
    var selecedDateMonth = dateOfSlots.getMonth() + 1; 
    dateOfSlots = selecedDateYear + '-' + selecedDateMonth +  '-' + selecedDate;
    
    let getWeeklyAvailableSlots = config.routes.getWeeklyAvailableSlots;
    getWeeklyAvailableSlots = getWeeklyAvailableSlots.replace(':subdomain', config.data.subdomain);
    
    $.ajax({
        type:'POST',
        url: getWeeklyAvailableSlots,
        data: {
            "_token": config.data.token,
            "subdomain": config.data.subdomain,
            "provider_location_id": providerLocationId,
            "date": dateOfSlots,
        },
        success:function(response) {
            $('#myc-available-time-container').html(response.html);
            //availableTimeSlot =  response.data[0].providerLocationAvailability.available_time_slot;
        }
    });
}