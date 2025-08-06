<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">@yield('title')</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">

                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('clinic.dashboard') }}">Home </a></li>
                    @php $link = "" @endphp
                    @for($i = 1; $i <= count(Request::segments()); $i++)
                        @if($i < count(Request::segments()) & $i > 0)
                            @php $link .= "/" . Request::segment($i); @endphp
                            <li class="breadcrumb-item"><a class="breadcrumb-item active" href="{{ $link }}">{{ ucwords(str_replace('-',' ',Request::segment($i)))}}</a></li>
                        @else
                            &nbsp / {{  ucwords(str_replace('-',' ',Request::segment($i))) }}
                        @endif
                    @endfor
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content-header -->
