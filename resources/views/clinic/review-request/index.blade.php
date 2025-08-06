@extends('layout.clinic')

@section('title', 'Request Review List')

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Request Review List</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="search-container" style="text-align-last: center; padding-left: 30%; padding-right: 30%">
                    <label>Select Location</label>
                    <select class="custom-select" id="clinic_location" name="location">
                        <option value="">All Location</option>
                        @foreach($locations as $key => $location)
                            <option value="{{ $location->name }}" {{ ($location->name == request()->location) ? 'Selected' : '' }} >{{ $location->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>DOB</th>
                        <th>Phone</th>
                        <th>Appointment</th>
                        <th>Provider</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Send At</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reviews as $key => $review)
                        <tr>
                            <td>{{ $loop->iteration  }}</td>
                            <td>
                                <a>{{ $review->patient }}</a><br/>
                            </td>
                            <td>{{ date('d M Y', strtotime($review->dob))  }}</td>
                            <td>{{ $review->mobile_phone  }}</td>
                            <td>{{ date('d M Y', strtotime($review->appointment_date))  }}</td>
                            <td>
                                {{ $review->provider }}<br/>
                            </td>
                            <td>
                                {{ $review->location }}<br/>
                            </td>
                            <td>
                                @php
                                    if($review->sms_status === 0) {
                                        $status = 'Pending';

                                    } else if($review->sms_status === 1) {
                                        $status = 'Send';
                                    } else  {
                                        $status = 'Complain';
                                    }
                                @endphp
                                {{ $status }}<br/>
                            </td>
                            <td>{{ date('d M Y', strtotime($review->created_at))  }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <br>
            <div class="col-12">
                {{ $reviews->appends(['q' =>  Request::get('q') ])->links('pagination') }}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection

@push('js')
    <script>
        $(document).on('change', '#clinic_location',  function() {
            let route = "{{ route('clinic.reviewRequest.index', [":location"]) }}";
            let location = $(this).val();
            let url = route.replace(':location', location);
            window.location.replace(url);
        });
    </script>
@endpush
