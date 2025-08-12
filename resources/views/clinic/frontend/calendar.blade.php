@extends('layout.frontend')

@push('css')
    <link rel="stylesheet" href="{{ asset('clinic-assets/frontend/css/week-month.css') }}"/>
@endpush


@section('content')
<div class="container">
  	<div class="row">
	    <div class="col-lg-12">
	      	<div class="staff-main">
	        	<div class="staff-details d-flex justify-content-start align-items-center">
              <!-- <div id="global-loader"><img src="{{ asset('/clinic-assets/frontend/img/loader.svg') }}" alt="loader"></div> -->
          			<div>
                  @if(app('router')->getRoutes()->match(app('request')->create(URL::previous()))->getName() == 'clinicFrontend.providerProfile')
                  <a href="{{ route('clinicFrontend.providerProfile', ['subdomain' => request()->subdomain ,'provider' => encrypt($providerId) ]) }}"><i class="fa-solid fa-angle-left set-li-icon"></i></a>
                  @else
            			<a href="{{ route('clinicFrontend.locationProviders', ['subdomain' => request()->subdomain ,'location' => encrypt($locationId) ]) }}"><i class="fa-solid fa-angle-left set-li-icon"></i></a>
                  @endif
          			</div>
          			<!-- <div class="details-inner"><img src="Thumb41.svg" alt="" /></div> -->
			        <div class="details-inner">
			        	<!-- <h5>Saifullah Nasir, M.D.</h5> -->
			        	<h5>Date & Time</h5>
			        </div>
			    </div>
        		<!-- progress bar -->
		        <div class="progress-details">
		          	<div class="progress" style="height: 3px;">
			          	<div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
			          	<div class="circle-one"><i class="fa-solid fa-1"></i></div>
                  <div class="circle-two"><i class="fa-solid fa-2"></i></div>
		        	</div>
        		</div>
		        <!-- info div added here -->
		        <div class="status-info">
		          <h5>{{ $appointmentLocation }}</h5>
		          <p>{{ $appointmentWith }}</p>
		        </div>
		        <!-- bootstrap tabs are started here  -->
		        <ul class="nav nav-tabs" id="myTab" role="tablist">
		          	<li class="nav-item dt-calendar">
			            <a
			              class="nav-link active"
			              id="home-tab"
			              data-toggle="tab"
			              href="#home"
			              role="tab"
			              aria-controls="home"
			              aria-selected="true"
			              >Monthly</a>
		         	</li>
			        <li class="nav-item dt-calendar">
			            <a
			              class="nav-link"
			              id="contact-tab"
			              data-toggle="tab"
			              href="#contact"
			              role="tab"
			              aria-controls="contact"
			              aria-selected="false"
			              >Weekly</a>
			        </li>
        		</ul>
        		<div class="tab-content left-right" id="myTabContent">
		          	<div class="tab-pane fade show active"
		            id="home"
		            role="tabpanel"
		            aria-labelledby="home-tab">
		            	<ul class="staff-lst-set">
		              		<div class="calendar">
		              			<div class="calendar-wrapper">
					                <header>
					                	<div class="icons">
					                    	<span id="prev" class="meterial-symboles-rounded">&lsaquo;</span>
					                  	</div>
					                  	<p class="current-date"></p>
					                  	<div class="icons">
					                    	<span id="next" class="meterial-symboles-rounded">&rsaquo;</span>
					                  	</div>
					                </header>
					                <div class="calendar-body">
					                  	<ul class="weeks">
					                    	<li>Sun</li>
					                    	<li>Mon</li>
					                    	<li>Tue</li>
					                    	<li>Wed</li>
					                    	<li>Thu</li>
					                    	<li>Fri</li>
					                    	<li>Sat</li>
					                  	</ul>
					                	<ul class="days"></ul>
					                </div>
		              			</div>
					            <div class="schedule">
					               	<p>Booking</p>
                          <div class="time-tab" id="time-tab">
					                	<!-- <ul>
					                		<li>12:45 pm</li>
					                    	<li>1:30 pm</li>
					                    	<li>2:15 pm</li>
					                    	<li>1:30 pm</li>
					                    	<li>2:15 pm</li>
					                    	<li>3:45 pm</li>
					                    	<li>3:15 pm</li>
					                    	<li>1:30 pm</li>
					                    	<li>2:15 pm</li>
					                  	</ul> -->
					                </div>
					            </div>
            				</div>
            			</ul>
          			</div>
          			<div
			            class="tab-pane fade"
			            id="contact"
			            role="tabpanel"
			            aria-labelledby="contact-tab">
			            <!-- here we add other part of tab -->
			            <div class="container-weekly">
			              <div id="picker"></div>
			            </div>
         			</div>
        		</div>
        		<!-- bootstrap tabs are end here  -->
      		</div>
    	</div>
  	</div>
</div>
@endsection

@push('js')
    <script>
        let providerId = @json($providerId);
        let locationId = @json($locationId);
        let providerLocationId = @json($providerLocationId);
        let disableWeekDays = @json($disableWeekDays);
        let holidays = @json($holidays);
    </script>

    <!-- SPECIFIC SCRIPTS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
    <script src="{{ asset('clinic-assets/frontend/js/calendar.js') }}"></script>
    <script type="text/javascript" src="{{ asset('clinic-assets/frontend/js/mark-calendar.js') }}"></script>
    
    <script src="{{ asset('clinic-assets/frontend/js/monthly-calendar.js') }}"></script>
    <script src="{{ asset('clinic-assets/frontend/js/weekly-calendar.js') }}"></script>

    <script type="text/javascript">
      (function ($) {
        $("#picker").markyourcalendar({
          availability: [
            // ["1:00", "2:00", "3:00", "4:00", "5:00"],
            // [],
            // ["3:00"],
            // [],
            // ["5:00"],
            // [],
            // [],
          ],
          isMultiple: false,
          // onClick: function (ev, data) {
          //   var html = ``;
          //   $.each(data, function () {
          //     var d = this.split(" ")[0];
          //     html += `<p>` + d + ` ` + t + `</p>`;
          //   });
          //   $("#selected-dates").html(html);
          // },
          // onClickNavigator: function (ev, instance) {
          //   var arr = [
          //     [
          //       ["4:00", "5:00", "6:00", "7:00", "8:00"],
          //       ["1:00", "5:00"],
          //       ["2:00", "5:00"],
          //       ["3:30"],
          //       ["2:00", "5:00"],
          //       ["2:00", "5:00"],
          //       ["2:00", "5:00"],
          //     ],
          //     [
          //       ["2:00", "5:00"],
          //       ["4:00", "5:00", "6:00", "7:00", "8:00"],
          //       ["4:00", "5:00"],
          //       ["2:00", "5:00"],
          //       ["2:00", "5:00"],
          //       ["2:00", "5:00"],
          //       ["2:00", "5:00"],
          //     ],
          //     [
          //       ["4:00", "5:00"],
          //       ["4:00", "5:00"],
          //       ["4:00", "5:00", "6:00", "7:00", "8:00"],
          //       ["3:00", "6:00"],
          //       ["3:00", "6:00"],
          //       ["3:00", "6:00"],
          //       ["3:00", "6:00"],
          //     ],
          //     [
          //       ["4:00", "5:00"],
          //       ["4:00", "5:00"],
          //       ["4:00", "5:00"],
          //       ["4:00", "5:00", "6:00", "7:00", "8:00"],
          //       ["4:00", "5:00"],
          //       ["4:00", "5:00"],
          //       ["4:00", "5:00"],
          //     ],
          //     [
          //       ["4:00", "6:00"],
          //       ["4:00", "6:00"],
          //       ["4:00", "6:00"],
          //       ["4:00", "6:00"],
          //       ["4:00", "5:00", "6:00", "7:00", "8:00"],
          //       ["4:00", "6:00"],
          //       ["4:00", "6:00"],
          //     ],
          //     [
          //       ["3:00", "6:00"],
          //       ["3:00", "6:00"],
          //       ["3:00", "6:00"],
          //       ["3:00", "6:00"],
          //       ["3:00", "6:00"],
          //       ["4:00", "5:00", "6:00", "7:00", "8:00"],
          //       ["3:00", "6:00"],
          //     ],
          //     [
          //       ["3:00", "4:00"],
          //       ["3:00", "4:00"],
          //       ["3:00", "4:00"],
          //       ["3:00", "4:00"],
          //       ["3:00", "4:00"],
          //       ["3:00", "4:00"],
          //       ["4:00", "5:00", "6:00", "7:00", "8:00"],
          //     ],
          //   ];
          //   var rn = Math.floor(Math.random() * 10) % 7;
          //   instance.setAvailability(arr[rn]);
          // },
        });
      })(jQuery);
    </script>
    <script type="text/javascript">
      // var _gaq = _gaq || [];
      // _gaq.push(["_setAccount", "UA-36251023-1"]);
      // _gaq.push(["_setDomainName", "jqueryscript.net"]);
      // _gaq.push(["_trackPageview"]);

      // (function () {
      //   var ga = document.createElement("script");
      //   ga.type = "text/javascript";
      //   ga.async = true;
      //   ga.src =
      //     ("https:" == document.location.protocol
      //       ? "https://ssl"
      //       : "http://www") + ".google-analytics.com/ga.js";
      //   var s = document.getElementsByTagName("script")[0];
      //   s.parentNode.insertBefore(ga, s);
      // })();
    </script>
    <script>
      // try {
      //   fetch(
      //     new Request(
      //       "https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js",
      //       { method: "HEAD", mode: "no-cors" }
      //     )
      //   )
      //     .then(function (response) {
      //       return true;
      //     })
      //     .catch(function (e) {
      //       var carbonScript = document.createElement("script");
      //       carbonScript.src =
      //         "//cdn.carbonads.com/carbon.js?serve=CK7DKKQU&placement=wwwjqueryscriptnet";
      //       carbonScript.id = "_carbonads_js";
      //       document.getElementById("carbon-block").appendChild(carbonScript);
      //     });
      // } catch (error) {}
    </script>
@endpush