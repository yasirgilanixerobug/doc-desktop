@extends('layout.clinic')

@section('title', 'Edit Provider Listing')

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
                            <h3 class="card-title">Edit Provider Listing | {{ $providerListing->location->name }}</h3>
                        </div>

                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('clinic.reviewRequest.providerListing.update',['provider_listing' => $providerListing->id]) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>Google Review URL</label>
                                        <div class="col-sm-12">
                                            <input type="text" name="google_review_url" class="form-control @error('google_review_url') is-invalid @enderror" value="{{ $providerListing->google_review_url }}" placeholder="google review url">
                                            @error('google_review_url')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
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
