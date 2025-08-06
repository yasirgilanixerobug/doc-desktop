<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">

    <title>Doc change log</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.min.css" />

    <style type="text/css">
        body{
            margin-top:20px;
        }
        .text-muted {
            color: #8492a6 !important;
        }
        .spaced-text{
            letter-spacing: 0.5px ;
        }
    </style>

    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-12">
                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 01 - 15 April 2025</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Resolve the duplicate appointment issue in the resources/views/clinic/frontend/appointment.blade.php file.
                                    </i>        
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Added commits records up to April 11, 2025 in change log page.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Updated the AppointmentExport file to replace the "patient deleted" text with "N/A".
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 16 - 28 February 2025</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Resolved the issue of fetching the latest location records in the bulkImport function of the Clinic/ReviewRequestController.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Resolved the issue of fetching the latest inserted record of a location in the sendMessageForm function of the Clinic/ReviewRequestController.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Resolved the issue to display only the latest record in the singleRequest function of the ReviewRequestController.
                                    </i>          
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 01 - 15 February 2025</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Resolved the issue of provider service by injecting the Status model.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Resolved the issue of staff location in the "to-provider" Blade file.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Resolved the issue of storing the provider by staff.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Resolve the issue of provider listing.
                                    </i>          
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Disabled access to other locations for staff members.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Added functionality to associate a provider with a location when creating a new provider.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Added a location dropdown to the provider creation form.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Removed the 'about' column length validation from the ProviderRequest file.
                                    </i>  
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Added commits records up to February 4, 2025.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 01 - 15 January 2025</h5>
                    <div class="col-12"> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Disallow all bots except Google in the application.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Use last updated date with hard code instead of using Carbon in the privacy policy and terms and conditions pages.
                                    </i> 
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 16 - 31 December 2024</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Fix the validation error field style for reCaptcha on the login page.
                                    </i>           
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add the footer to the frontend partial page and link it to the actual Terms & Conditions and Privacy Policy routes.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Use the Laravel view route instead of the get route for simple file rendering in web.php file.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Create two routes, one for the Privacy Policy and one for the Terms & Conditions, with corresponding Blade files, and add links in the footer and other places.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the position of the "Terms and Conditions" div in the appointment form.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add a checkbox in the appointment Blade file, set it to be unchecked by default, and apply validation to ensure that the form does not submit if the checkbox is not checked.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement reCaptcha functionality in the patient and clinic registration forms.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add reCaptcha validation during login, so the form will only submit after reCaptcha is approved.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Use the best approach for the create and update methods in the provider listings.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Use the ternary operator in the provider listing validation for the PUT method and replace Auth::user()->clinic_id with the authUserClinicID variable wherever it is used multiple times in the provider listing controller.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Make the provider listings table responsive in the provider listings index file and add some styling.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement the edit and update functionality for provider listings, add validation to ensure that one doctor can create only one record against any location, and implement a soft delete method also.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add a validation on the appointment Blade file to ensure that the Date of Birth (DOB) is greater than 14 years, allowing the form to submit. If the DOB is less than 14 years, prevent the form from submitting.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Create a separate persist.js file and link it in the "Review Request Send Message" and "Bulk Import" Blade files, then remove the script reference from the clinic main layout page.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Comment the age validation code in the appointment request and the JavaScript in the appointment Blade file.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Remove the age validation popup and its associated JavaScript code.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add server-side validation to ensure that the DOB is at least 16 years old.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Create a new JS file for the active tab functionality and remove all separate JS and Bootstrap links.
                                    </i> 
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 01 - 15 December 2024</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Resolve the Twilio status code 401 issue
                                    </i>          
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add validation to prevent users under 16 years old from booking an appointment by calculating the age based on the input DOB. If the user’s age is below 16, the appointment cannot be booked
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add two tabs under the Request Review Now section in the sidebar: one to select a location for review and another for provider listings, passing the Provider Review URL in the same way as the Location Review URL.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add two tabs under the Upload & Schedule List in the sidebar: one for Location Upload & URL, and another for Provider Listing & URL.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add two tabs to the Provider Listing page: one for providers and another for locations, with pagination for both.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Create a "Provider Listing" section to display both provider listings and locations.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add a "Provider Listing" tab to the Review Follow-Up List in the sidebar.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Hide the registration button on the login page.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 16 - 30 November 2024</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Resolve the appointment status issue
                                    </i>  
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Resolve the issue of updating the appointment and changing the status.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Resolve the issue of the appointment for the current date in the monthly calendar.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Resolve the issue of appointment holidays in the monthly calendar.
                                    </i>         
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the code to return an array from the Twilio service with a message and balance separately instead of a single string combining them.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Dashboard PHP code shifted into the controller and variables passed to the view.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the amount icons on the Twilio balance card on the dashboard..
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Separate the "Copy Subdomain Link" and "Twilio Balance" cards on the dashboard.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Create two separate cards on dashboard: one for the subdomain link and another for the twilio balance.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add conditions to the background color of the Twilio balance card: if the balance is greater than 3, the background color will be 'info'; if it is between 0 and 4 (exclusive), the background color will be 'warning'; and if the balance is 0, the background color will be 'danger'.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 01 - 15 November 2024</h5>
                    <div class="col-12"> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the email template and email subject for the appointment. Use "appointment dynamic status" instead of the word "schedule" for the appointment in the email subject. Add the appointment comment in the email template to display the reason for the appointment.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 16 - 31 October 2024</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Resolve the issue of the review SMS.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Remove the error of the start and end date of a holiday for the provider.
                                    </i>      
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show company logo in review follow up page.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Use jQuery instead of JavaScript for date validation format of appointment.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the logo style: "height from 50px to 80px" to make it a little bit bigger.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Make a script for appointment date validation with an error message. If there’s an error, qill show this message.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement functionality to delete only future holidays of provider.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement functionality to show the delete button only when the holiday date is in the future for the provider.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change dateStatus from 1 to 0 to show today's holiday in the monthly calendar.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement functionality to soft delete provider holidays, and add two tables in the provider detail page for assigned location details and provider holidays details.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 16 - 30 September 2024</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Resolve the appointment issue.
                                    </i>     
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the clinic registration URL in web.php file.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 16 - 31 August 2024</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the appointment API issue.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the provider null issue on production when fetching the holiday of the provider.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue of the name being null on the appointment calendar.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue when the mobile API creates an appointment.
                                    </i>    
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Make the "about" column optional in the API during the patient edit functionality.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 01 - 15 August 2024</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the 500 server error related to the timezone.
                                    </i>            
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show the weekly records in the date range in the weekly-available-slot API.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Create a static rule for the phone number during registration named startsWith, with our condition during registration, because the built-in startsWith rule works only after Laravel 9, and we are using Laravel 8.75.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Display the patient record of SMS in the request review index page.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 01 - 15 July 2024</h5>
                    <div class="col-12"> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement rate limiting in the kernel.php file.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 16 - 30 April 2024</h5>
                    <div class="col-12"> 
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Resolve the weekly and monthly API appointment issues.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 16 - 31 December 2023</h5>
                    <div class="col-12"> 
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue with the $ sign in Twilio.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the Google review URL location issue in the location request file.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue of sending a single SMS for the review.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show the Twilio balance and the patient list with the last record by location in the clinic dashboard.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add the last record of the patient for every location.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the single request review function to improve the query code.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement functionality to send SMS only to the location provider.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the file paths in the single message for review command class, review request controller, send mail job, send review message job, send SMS job, mail service, and Twilio service.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the validation for Twilio SMS.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Move the new folder "service" to the "services" directory.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the send SMS and mail services.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 01 - 15 December 2023</h5>
                    <div class="col-12"> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        The review functionality works completely.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        The review follow-up functionality implements completely.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 16 - 31 July 2023</h5>
                    <div class="col-12"> 
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the image issue in the calendar.
                                    </i>
                                </li> 
                            </div>
                        </ul>
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 01 - 15 June 2023</h5>
                    <div class="col-12"> 
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the "provider not found" issue in the location provider Blade file.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">
                                        Solve the location API issue in the Api/ProviderController.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">
                                        Solve the issue of the step form layout through CSS.
                                    </i>
                                </li> 
                            </div>
                        </ul>
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 16 - 31 May 2023</h5>
                    <div class="col-12"> 
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the step issue of the location-provider blade file.
                                    </i>
                                </li> 
                            </div>
                        </ul>
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Make the step form responsive through CSS.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the theme of the appointment Blade file again.
                                    </i>
                                </li> 
                            </div>
                        </ul>
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 01 - 15 May 2023</h5>
                    <div class="col-12">
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        In the clinic/FrontendController function getWeeklyAvailableSlots, update the dateTo from 4 days to 3 days.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Remove the scroller for the weekly calendar.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Comment the global loader CSS code and the calendar Blade file code.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Set the step more options layout through CSS.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Make step calendar routes in a clinic.php file
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add step appointment for location and provider separately, change appointment title, add weekly and monthly calendar, remove first and last name minimum 3-character validation, and change style.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Display the registered patient's DOB on the appointment details page.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 16 - 30 April 2023</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the clinic configuration cache issue.
                                    </i>           
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Display only the location number in the appointment email.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 01 - 15 April 2023</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the validation issue for profile updates in the patient API.
                                    </i>           
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the appointment form text area column from "appointment about" to "appointment comment" in the appointment Blade file.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the available slots function name to "weekly available slots" in api/ProviderController and also update its API route URL to be more readable, improving the code.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Ran composer update to update the project dependencies.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the routes according to the server in the api.php file.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the route according to the server in the api.php file. Create three separate prefix groups for patient, appointment, and auth, and place each category's routes within its respective group.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the profile edit route according to the server in the patient API.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show insurance documents in the patient profile API.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 16 - 31 March 2023</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue of available appointment slots for a provider.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue with changing the appointment status.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue with the logout API.
                                    </i>          
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement the appointment change API to update appointments with all necessary conditions.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the patient dashboard to display the latest five past and upcoming appointments.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Made multiple updates in the API, including changes to the patient dashboard API, patient profile API, and patient change password API.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement functionality where a patient can upload and update their profile image from the dashboard.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implemented the forgot password and logout API.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the response of the logout API.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the Sanctum API to Passport API.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement clinic APIs to book appointments, signup, and login for authentication, fetch all locations, and create an API for the patient dashboard to show all related data, including the patient and patient appointment documents. Create separate controllers for each category.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 16 - 28 February 2023</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the appointment issue when uploading insurance data.
                                    </i>          
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the .htaccess file.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Refactor the upload insurance documents functionality.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement the functionality to download insurance documents.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement the functionality to send an email or SMS to staff and the patient when updating an appointment.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Store the date of birth and ZIP code when registering a patient.
                                    </i> 
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 01 - 15 February 2023</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the type issue in the header.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the redirection issue after login.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the typo issue in the patient message in the message service.
                                    </i>            
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the variables in the appointment controller in the appointment function.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the appointment function using the best approach in the Appointment controller.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement the functionality to create & update insurance data.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement the functionality to show only active clinics and display the clinic's about description (30 words) in the patient dashboard.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement the functionality allowing the patient to change their appointment.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add a patient registration link in the registration form.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add new features in the patient clinic.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show the clinic and provider list on the patient dashboard.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement the patient registration functionality along with the patient registration Blade.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 16 - 31 January 2023</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Resolve the helper file error.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the insurance document issue in the appointment service.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue when updating the customer name.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue with the provider name in the User model.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the name issue in the GuestUser model.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue of the date of birth in the AppointmentRequest.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue of the location in the AppointmentService.
                                    </i>           
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Use constants instead of hard-coded values in the Appointment controller.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Set the mobile view for the appointment page.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add constants for models in User, Status, Gender, AppointmentStatus, and AppBookingChannel models.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the appointment detail view.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the SMS message in the message service.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show the active menu of a page in the sidebar.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the appointment document upload placeholder tooltip.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the patient document upload size from 2 MB to 5 MB.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the appointment document upload size from 2 MB to 5 MB.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add ZIP code in the appointment form, change the form layout for customer creation and editing, and update the appointment layout to include ZIP code.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add a short name field only in the appointment, in both the GuestUser and User models.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the pattern for the first name or last name.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the pattern for the first name or last name in the GuestUser model.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show the latest appointments notification on top.
                                    </i> 
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 01 - 15 January 2023</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue of uploading patient appointment documents via the link.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the provider location issue in the ClinicService.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the provider location issue in the clinic routes file.
                                    </i>            
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show the date of birth (DOB) in the new appointment email Blade file.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show the date of birth (DOB) in the appointment detail, customer index, and customer show Blade files.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Remove comments from the code in the AppointmentService.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Optimize the appointment and insurance document upload process.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Generate a link for uploading documents.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Remove comments from the appointment job code in the AppointmentController.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the appointment form.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add first and last name in GuestUser model.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add first and last name in GuestUser model.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add date of birth in the appointment table.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Remove "change name" to first and last name everywhere in the project.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add filters for first and last name on customer and pending appointment search.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show first and last name of old patients.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add a tip in the appointment form.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Allow the patient to add an insurance attachment with the email.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 16 - 31 December 2022</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue of appointment customer data not being found.
                                    </i>           
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add a Laravel route in the JS component.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add new functionality to manage appointments through the location page.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add insurance input fields in the appointment form.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement the functionality to send an email to all location receptionists.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Allow the admin to update staff locations.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement the functionality to assign multiple staff locations to staff.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        The logo of the project has been changed.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add local storage and a thank you page in the project.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the interval of online or offline status to 2 seconds in the layout frontend Blade file.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add online and offline message alert functionality in the layout frontend Blade file.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add a cancel button in the confirm appointment slots.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Remove the margin from the thank you page.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 01 - 15 December 2022</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the spelling issue in the login.
                                    </i>            
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the color of the appointment slots.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the logo and the App name.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the live domain in the route file.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the thank you page controller and route.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add a thank you page after the appointment is done.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 16 - 30 November 2022</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue with the appointment update functionality.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue in the appointment Blade file.
                                    </i>            
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        The appointment email layout done.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the appointment email layout.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Set the hours dropdown in the LocationAvailabilityController.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add Laravel Passport for API authentication.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add style to round the image in the profile Blade file and add a placeholder location image.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add text in the provider list and profile Blade files.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Set a dynamic image for the provider and provider profile.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Allow the admin to upload WebP images.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Make the full bar clickable in the provider section.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 01 - 15 November 2022</h5>
                    <div class="col-12"> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the "Not Available" slot message of the appointment.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add a number in the location name in LocationRequest to validate the proper location name.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show an error message when no record is found in reporting.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the AppointmentExport.php file.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement export functionality for reporting in the App.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 16 - 31 October 2022</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the footer image issue.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Correct the config file image path.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the header image issue.
                                    </i>           
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the background color of the logo in profile settings.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Allow the admin to change the domain slug.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show a "disabled location day" message in the Location Availability create and update Blade files.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Set a default logo when a clinic registers.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Set the config app name in the subject of NewAppointmentMail.php file.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the app logo and favicon images.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add placeholder images for male and female in the User model.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 01 - 15 October 2022</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Remove the log function in the MapInput.js file.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        In ClientProfileRequest validation, remove the max rule from the about column.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the about and gender column fields issue in the provider create form.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the image issue and the provider sidebar image issue.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the guest user clinic issue.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the find customer issue.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the unauthenticated route issue.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the two route issue for local and server.
                                    </i>            
                                </li> 
                            </div>
                        </ul>
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the styling of the footer and welcome Blade files.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the new doc logos ( logo, logo_icon, logo_favicon ).
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Install the backup package in my project.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add redirection in the provider profile when the location changes.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the CSS style for the record not found component.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add a new component for record not found.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add uploaded images to the Git ignore file.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show only the first 15 words of the about description in the provider list.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add some user images to the public directory.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Set the cookie consent in the frontend layout Blade file.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement functionality to fetch user appointment data when the cookie allows and reset form fields when the user changes the user type to "new" or "old."
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement functionality to autofill the appointment form with the old record.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Set table layout for location and pending appointment.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement functionality so that staff and owner can create a customer and make an appointment for this customer.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Remove Google and Facebook login functionality.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Restrict staff to view and assign only their location provider.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add the total number of appointments for each location provider.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Set the reporting date range layout.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Refactor the code and queries.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add functionality to remove all cached data when the user logs out.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Create a trait for authentication data named MyAuthData.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Create a helper for authentication data.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 16 - 30 September 2022</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the route file issue.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the redirection issue and refactor the code of the welcome route.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue of the appointment message when an appointment is completed.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the appointment cursor issue when updating an appointment by staff.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the time zone issue for appointments.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the appointment title issue on the calendar.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the logo issue with the phone required.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the appointment count issue in PendingAppointmentComposer.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the appointment cache query issue.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the cursor or appointment update issue.
                                    </i>           
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement the reporting functionality and create a ReportController to perform all related functionality here.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement the functionality of activity logs using the Spatie Activity Log package.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Set the end time for the provider location availability.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Set the end time of the location's business hours to 5 PM from 8 AM.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show the provider name and location name along with the location availability when assigning location availability to a provider.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add restriction in provider assign to a location along with the location's business hours.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Set the date format everywhere on the website.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Set variables in the .env.example file for configuration purposes.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Comment the auth:clear-reset schedule in the kernel file.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the route issue for the scheduler and client patient sites, where / is used for the scheduler site and /client is used for the client patient site.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Remove unused routes from the web file.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show only the next appointments for the current day in LocationAvailabilityService.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show a message in the appointment popup.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the functionality to open the appointment form on the current page instead of a new page.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show the cursor as "copy" when hovering over the clinic site link on the clinic dashboard.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add some conditions in the main menu for the owner role.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show the current year's appointments of the location in a Clinic dashboard graph.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show the location of the staff on the staff detail page.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add a date that is two days later in the appointment frontend view.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the appointment SMS and email sending functionality.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Allow the admin to activate or disable receiving appointment SMS and email notifications.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add comments in functions to describe their purpose and functionality.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the appointment color when the status changes.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Send appointment SMS and email to the patient only when the status is updated or changed.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show the appointment color on the calendar based on its status.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show appointments in the calendar by provider.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Improve the clinic dashboard query optimization.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement Laravel Debug Bar for better debugging and query optimization.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the profile view for location, provider, and staff.
                                    </i> 
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 01 - 15 September 2022</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the appointment issue when the provider is deleted.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the link issue of the provider in the partial navbar Blade file.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue of owner profile update.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue of appointments for deleted providers.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue with the staff email and phone.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue with assigning staff to a location.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue with staff's appointments for today.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue with appointments related to deleted providers.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the map issue on the About, Review, Provider, and Profile pages.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the cursor issue on status click.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the location days issue.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the mail service message issue.
                                    </i>            
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Refactor the code in the appointment model.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement pending appointment search functionality.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Improve the code in the view pending appointment composer.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Mark the appointment as done when the status or appointment date changes.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add pending appointment notification functionality in the clinic dashboard.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Improve the code in the staff edit functionality.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Send email and SMS to the owner and assigned staff location when an appointment is made.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement the functionality to assign a location to staff.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement the functionality to delete staff, move them to trash, and restore them.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement the functionality to delete a provider, show trashed providers, and restore them.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show all pending appointments in ascending order in clinic dashboard.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the time zone in the configuration file.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show pending appointments on the dashboard and side menu.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show status colors on the appointment detail page.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Improve the code for sending SMS and email services.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement the functionality to reset the password.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement the functionality to send mail using SendMailJob and MailService.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Queue the job to run on the server.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement appointment SMS sending with a queue job.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement SMS functionality through Twilio and create a TwilioService.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the maximum number of digits for the phone number from 13 to 12 in the AppointmentRequest.
                                    </i> 
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 16 - 31 August 2022</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the "route login not defined" issue.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue with per appointment minutes.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the time issue in the Location Availability controller.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue with clinic service holiday dates.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue with editing appointments.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the home location provider issue.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the provider location detail issue.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue with displaying location latitude, longitude, and location details.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the appointment update issue.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the provider holiday issue.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the appointment issue.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the subdomain copy issue.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the time slot issue in the modal of the location availability Blade file.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue with the active state of the home link.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue of disabled location and active tab.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the phone validation issue.
                                    </i>           
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show the current year's data of appointments in clinic dashboard.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show provider holidays on the provider details page.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show location directions on the appointment page.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the side menu with location changes.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Create a component for directions and business hours.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the message for reverting the appointment.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Allow admin to change the appointment functionality and status only if it's "Approved" or "Confirmed," and cannot modify the status once it's "Completed," "No Show," or "Cancelled by Provider."
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Allow the admin to update appointments and use drag-and-drop functionality for appointment scheduling.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Main site logo change in header.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add some CSS for header styling.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change assets for the provider by location Blade file.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement functionality to change appointment status and also added appointment tooltip.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Main site assets changed.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Contact validation updated in ClinicRegisterRequest, LocationRequest, OwnerProfileRequest, ProviderRequest, and StaffRequest.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 01 - 15 August 2022</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the phone validation issue in GuestUser, Location, and UserDetails models.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Phone validation issue solved in every validation request where the phone is used.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve appointment available time slots issues.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the appointment validation rule issue.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the staff creation issue.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Gender validation issue solved in owner profile.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Gender validation issue solved during provider creating.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue of provider location availability.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the appointment issue for both local and server environments.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the route issue.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the appointment issue.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the error in clinic registration and login.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the typo issue on the clinic login page.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the issue with the registration and login form of the clinic.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the footer error for the frontend site.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the clinic profile issue.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the clinic logo and favicon issue.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the validation error issue on the clinic profile and owner details.
                                    </i>            
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the default dashboard for the clinic.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Provide image validation change from max 10 to 1000.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show admin and main site links on the home page.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Improve the home page code.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add more validation rules for appointment.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Allow only clinic owner, office, and receptionists to log in to the clinic.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Main logo style updated.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add disabled weekdays for provider location in location availibility blade file.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change location availability index.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add some changes in auth login and registration forms.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add some changes in clinic login and registration forms.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement appointment functionality without calendar schedule.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        The default time slot for appointments on the home page has been set.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Allow the admin to update provider details.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Update the partial pages and include them in the clinic login and registration forms.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add a lot of images for the app in the public directory.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Subdomain changed on the server side.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add a calendar to the app.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Set the right-side menu with clinic contact information in clinic dashboard.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Set the logo and favicon in the clinic composer and cache the clinic query.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Generate and copy the link in the clinic dashboard.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Allow the owner to view and update the clinic profile, update their user data, and change the password.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Show business hours of the location in the location show Blade file.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the side menu font icons.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Allow the clinic admin to update the password.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement flash message functionality.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add location business hours and create a model and controller for it.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        On the clinic site, added functionality that allow patients to view the clinic's default location provider, about section, provider list, and provider profile.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement functionality to create a clinic subdomain.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add total locations, total staff, total providers, and clinic subdomain to the clinic dashboard.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Set the clinic frontend theme.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the clinic appointment calendar.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement functionality to show clinic appointments on the calendar.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement functionality to create or update provider location availability.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Improve the code for assigning a location to a provider.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement functionality to assign a location to a provider.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>

                    <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Date</span> &nbsp;&nbsp; 16 - 31 July 2022</h5>
                    <div class="col-12">
                        <div class="badge badge-danger mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">bugs</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Solve the provider location issue in ProviderLocation model.
                                    </i>           
                                </li> 
                            </div>
                        </ul> 
                        <div class="badge badge-success mt-3 p-2 ml-5">
                            <span class="text-uppercase spaced-text">functionalities</span>
                        </div>  
                        <ul class="list-unstyled mt-3">
                            <div class="ml-5">
                                <li class="text-muted ml-3">
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Create the AssignLocation Controller, model, and request, and also "add" and "update" Blade file to perform assign location works.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement the Provider CRUD functionality.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement the Staff CRUD functionality.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement the Location CRUD functionality.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement the Clinic Staff CRUD functionality.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Set dump pages for the provider profile, provider list, staff list, and calendar.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Integrate the clinic theme with a separate directory.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Set the app logos in the config file.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Add logos in the public directory
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Refactor the clinic registration code in User model and in Auth Service.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Change the slug name to sub_domain in the clinic model.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Implement clinic login, registration, and logout functionality.
                                    </i> 
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                        Installed the project in Laravel 8 version.
                                    </i>
                                    <i class="mdi mdi-circle-medium d-flex align-items-baseline ml-4">	
                                       Make the initial commit of my project.
                                    </i>
                                </li> 
                            </div>
                        </ul> 
                    </div>
                </div>
            </div>
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>