@extends('layout.clinic')

@section('title', 'Customer List')

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Clinic Customer <a href="{{ route('clinic.customer.create') }}" class="btn btn-success btn-sm">Create</a></h3>

                <!-- simple grid search close tag is use bcz some browser not support with out closing tag -->
                <x-grid-search :searchRoute="route('clinic.customer.index')"></x-grid-search>

            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Phone
                        </th>
                        <th>
                            DOB
                        </th>
                        <th>
                            Address
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($guestUsers as $key => $customer)
                        <tr>
                            <td>
                                <a href="#" class="addAppointment" data-toggle="modal" data-customer-id="{{ $customer->id }}" data-target="#exampleModal">
                                    <i class="fa fa-plus"></i>
                                </a>
                                {{ $loop->iteration  }}
                            </td>
                            <td>
                                <a href="{{ route('clinic.customer.show', ['customer' => $customer->id]) }}" target="_blank">{{ $customer->name }}</a>
                            </td>
                            <td>
                                {{ $customer->email }}<br/>
                            </td>
                            <td>
                                {{ $customer->phone }}<br/>
                            </td>
                            <td>
                                {{ ($customer->dob) ? date(config('app.default_date_format'), strtotime($customer->dob)) : 'N/A'  }}<br/>
                            </td>
                            <td>
                                {{ $customer->fullAddress }}
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ route('clinic.customer.show', ['customer' => $customer->id]) }}">
                                    <i class="fas fa-eye">
                                    </i>
                                    View
                                </a>
                                <a class="btn btn-info btn-sm" href="{{ route('clinic.customer.edit', ['customer' => $customer->id]) }}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <br>
                <div class="col-12">
                    {{ $guestUsers->appends(['q' =>  Request::get('q') ])->links('pagination') }}
                </div>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->


    <!-- Modal Status Change -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Appointment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="addAppointmentForm" action="#" method="post" >
                        @csrf

                        <div class="row">
                            <div class="form-group col-6">
                                <select id="location_dropdown" name="location_id" class="form-control" required>
                                    <option value="">Select Location</option>
                                    @foreach($locations as $key => $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-6">
                                <select id="provider_dropdown" name="provider_id" class="form-control" required></select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-6">
                                <div><input id="date" type="date" class="form-control input-lg" name="date" required></div>
                            </div>

                            <div class="form-group col-6">
                                <select id="available_time_slot_dropdown" class="form-control" name="start_time"></select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <input type="text" class="form-control input-lg" placeholder="Comment" name="comment">
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <button id="submitBtn" type="submit" class="btn btn-sms btn-primary">
                                    <i class="fas fa-save"></i> Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <!-- SPECIFIC SCRIPTS -->
    <script src="{{ asset('clinic-assets/frontend/js/bootstrap-datepicker.js') }}"></script>
    <script>
        $(document).ready(function (){
            const token = "{{ csrf_token() }}";
            let addAppointmentRoute = "{{ route('clinic.customer.addAppointment') }}";
            let getLocationProvider = "{{ route('clinic.customer.locationProvider') }}";
            let getProviderAvailability = "{{ route('clinic.customer.providerAvailability') }}";
            let customerId;

            $("#provider_dropdown").attr("disabled", true);
            $("#date").attr("disabled", true);
            $("#available_time_slot_dropdown").attr("disabled", true);

            $('.addAppointment').on('click', function(){
                customerId = $(this).data('customer-id');
                $("#exampleModalCenter").appendTo("body").modal('show');
            });

            /*------------------------------------------
            --------------------------------------------
            Location Dropdown Change Event
            --------------------------------------------
            --------------------------------------------*/
            $('#location_dropdown').on('change', function () {
                var locationId = this.value;
                $("#provider_dropdown").attr("disabled", false).html('');
                $.ajax({
                    url: getLocationProvider,
                    type: "POST",
                    data: {
                        location_id: locationId,
                        _token: token
                    },
                    dataType: 'json',
                    success: function (result) {
                        if (result.status === 'success')
                        {
                            $('#provider_dropdown').html('<option value="">-- Select Provider --</option>');
                            $.each(result.data, function (key, value) {
                                $("#provider_dropdown").append('<option value="' + value
                                    .id + '">' + value.name + '</option>');
                            });
                        } else {
                            toastr.error(result.message);
                        }
                        //$('#time_slot_dropdown').html('<option value="">-- Select Time Slot --</option>');
                    }
                });
            });

            $('#provider_dropdown').on('change', function () {
                $("#date").attr("disabled", false);
            });
            /*------------------------------------------
            --------------------------------------------
            Date vise Available Time Slot Dropdown Change Event
            --------------------------------------------
            --------------------------------------------*/
            $('#date').on('change', function () {
                $('#available_time_slot_dropdown').attr("disabled", false).html('');
                var date = this.value;
                var locationId = $('#location_dropdown').val();
                var providerId = $('#provider_dropdown').val();

                $("#available_time_slot_dropdown").html('');
                $.ajax({
                    url: getProviderAvailability,
                    type: "POST",
                    data: {
                        date: date,
                        location_id: locationId,
                        provider_id: providerId,
                        _token: token
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#available_time_slot_dropdown').html('<option value="">-- Select Time Slot --</option>');
                        if (result.status === 'success')
                        {
                            $.each(result.data, function (key, value) {
                                if (value.isAppointment === 0)
                                {
                                    $("#available_time_slot_dropdown").append('<option value="' + value
                                        .start_time + '">' + value.start_time + '</option>');
                                }
                            });
                        } else{
                            toastr.error(result.message);
                        }
                        //$('#time_slot_dropdown').html('<option value="">-- Select Time Slot --</option>');
                    }
                });
            });


            $("#addAppointmentForm").on('submit', (function(e) {
                e.preventDefault();
                $("#submitBtn").attr("disabled", true);
                var data = $('#addAppointmentForm').serialize();

                $.ajax({
                    url: addAppointmentRoute,
                    type: 'post',
                    data: {'_token': token, form_data: data, customer_id:customerId },
                    success: function(response) {
                        if (response.status === 'success')
                        {
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }

                        setTimeout(function() {
                            location.reload()
                        }, 2000);
                    },
                    error: function(xhr) {
                        toastr.error('something wrong');
                    }
                });
            }));

            $(document).on('click', '.close',function(){
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });
    </script>
@endpush
