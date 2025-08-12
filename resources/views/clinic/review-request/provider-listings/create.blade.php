@extends('layout.clinic')

@section('title', 'Add Provider Listing')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Provider Listing</h3>
                        </div>

                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('clinic.reviewRequest.providerListing.store') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label class="col-sm-2 col-form-label">Provider</label>
                                        <div class="col-sm-12">
                                            <select name="provider_id" id="provider_id" class="form-control @error('provider_id') is-invalid @enderror">
                                                <option value="">Select Provider</option>
                                                @foreach($providers as $keyProvider => $provider)
                                                    <option value="{{ $provider->id }}"
                                                        @if(old('provider_id') == $provider->id) selected @endif>
                                                    {{ $provider->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('provider_id')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <label class="col-sm-2 col-form-label">Location</label>
                                        <div class="col-sm-12">
                                            <select name="location_id" id="location_id" class="form-control @error('location_id') is-invalid @enderror">
                                                <option value="">Select Location</option>
                                            </select>
                                            <span id="location_loader" style="display: none;">
                                                <i class="fa fa-spinner fa-spin"></i> Loading...
                                            </span>
                                            @error('location_id')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>  
                                </div>
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>Google Review URL</label>
                                        <div class="col-sm-12">
                                            <input type="text" name="google_review_url" class="form-control @error('google_review_url') is-invalid @enderror" value="{{ old('google_review_url') }}" placeholder="google review url">
                                            @error('google_review_url')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('#provider_id').on('change', function () {
            var provider_id = $(this).val();

            if (provider_id) {
                $('#location_loader').show();  // Show loader
                $('#location_id').prop('disabled', true); // Disable dropdown
                
                $.ajax({
                    url: "{{ route('clinic.reviewRequest.providerListing.getLocations') }}",
                    type: "GET",
                    data: { provider_id: provider_id },
                    success: function (response) {
                        setTimeout(function () { // Delay for 1 second

                            $('#location_id').empty().append('<option value="">Select Location</option>');
                            
                            if (response.length > 0) {
                                $.each(response, function (key, providerRemainingLocations) {
                                    $('#location_id').append('<option value="' + providerRemainingLocations.location.id + '">' + providerRemainingLocations.location.name + '</option>');
                                });
                            }

                            $('#location_loader').hide(); // Hide loader
                            $('#location_id').prop('disabled', false); // Enable dropdown
                        }, 1000); // 1000ms = 1 second
                    },
                    error: function () {
                        $('#location_loader').hide(); // Hide loader on error
                        $('#location_id').prop('disabled', false);
                    }
                });
            } else {
                $('#location_id').empty().append('<option value="">Select Location</option>');
            }
        });
    });
</script>

@endpush
