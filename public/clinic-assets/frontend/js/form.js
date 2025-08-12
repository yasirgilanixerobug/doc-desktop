$(document).ready(function (){

    const token = config.data.token;
    const subdomain = config.data.subdomain;
    let findCustomerRoute = config.routes.findCustomerRoute;
    findCustomerRoute = findCustomerRoute.replace(':subdomain', subdomain);

    const hideShowDiv = document.querySelector(".step-info");
    hideShowDiv.addEventListener("click", (event) => {
        event.preventDefault();
        let nextDiv = hideShowDiv.nextElementSibling,
            isHidden = nextDiv.hidden;
        isHidden ? (nextDiv.hidden = false) : (nextDiv.hidden = true);
    });

    $(".custom-file-input").change(function(){
        $(this).next('.custom-file-label').text(this.files[0].name);
    });


    //reset form when
    $(".radioBtn").click(function(){
        $(':input','#appointmntForm')
            .not(':button, :submit, :reset, :hidden, :radio')
            .val('')
            .attr('readonly', false)
    });

    //tooltip
    $('[data-toggle="tooltip"]').tooltip()

    //submit appointment form
    // $("#appointmntForm").on('submit', (function(e) {
    //     e.preventDefault();
    //     var userType = $("input[name='user_type']:checked").val();
    //     var customerId = $("#customer_id").val();
    //     if(userType === 'new')
    //     {
    //         e.currentTarget.submit();
    //     } else if(userType === 'old' && customerId !== '') {
    //         e.currentTarget.submit();
    //     } else {
    //         toastr.error('No Old Record Found Please Chose New Record Option');
    //     }
    // }));

    //send request
    // $("#phone").blur(function(){
    //     var userType = $("input[name='user_type']:checked").val();
    //     var phone = '+1' + $(this).val();
    //
    //     if(userType === 'old'){
    //
    //         let localStorageData = localStorage.getItem(phone);
    //
    //         if (localStorageData === null)
    //         {
    //             $("#customer_id").val('');
    //             $("#first_name").val('').attr("readonly", false);
    //             $("#last_name").val('').attr("readonly", false);
    //             $("#email").val('').attr("readonly", false);
    //             $("#state").val('').attr("readonly", false);
    //             $("#city").val('').attr("readonly", false);
    //             $("#address").val('').attr("readonly", false);
    //             $("#dob").val('').attr("readonly", false);
    //
    //             toastr.error('No Old Record Found!');
    //             return false
    //         }
    //
    //         $.ajax({
    //             url: findCustomerRoute,
    //             type: 'POST',
    //             data: {'_token': token, guest_id: localStorageData, subdomain: subdomain},
    //             success: function(response) {
    //                 if (response.status === 'success')
    //                 {
    //                     var result = confirm('We found record belong to this number do you want to fill your form with record?');
    //                     if(!result)
    //                     {
    //                         return false;
    //                     }
    //
    //                     var customer = response.data;
    //                     localStorage.setItem(phone, customer.guest_id);
    //
    //                     $("#customer_id").val(customer.id);
    //                     $("#first_name").val(customer.first_name).attr("readonly", true);
    //                     $("#last_name").val(customer.last_name).attr("readonly", true);
    //                     $("#email").val(customer.email).attr("readonly", true);
    //                     $("#state").val(customer.state).attr("readonly", true);
    //                     $("#city").val(customer.city).attr("readonly", true);
    //                     $("#address").val(customer.address).attr("readonly", true);
    //                     $("#dob").val(customer.dob).attr("readonly", true);
    //
    //                     //toastr.success(response.message);
    //                 } else {
    //                     $("#customer_id").val('');
    //                     $("#first_name").val('').attr("readonly", false);
    //                     $("#last_name").val('').attr("readonly", false);
    //                     $("#email").val('').attr("readonly", false);
    //                     $("#state").val('').attr("readonly", false);
    //                     $("#city").val('').attr("readonly", false);
    //                     $("#address").val('').attr("readonly", false);
    //                     $("#dob").val('').attr("readonly", false);
    //                     toastr.error(response.message);
    //                 }
    //             },
    //             error: function(xhr) {
    //                 toastr.error('something wrong');
    //             }
    //         });
    //     }
    // });
});
