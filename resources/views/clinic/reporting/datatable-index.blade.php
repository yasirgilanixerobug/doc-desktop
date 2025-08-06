@extends('layout.clinic')

@push('css')
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
@endpush

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Reporting</h3>
                <!-- simple grid search close tag is use bcz some browser not support with out closing tag -->
            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects" id="data-table">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Appt Date
                            </th>
                            <th>
                                Patient
                            </th>
                            <th>
                                Phone
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Provider
                            </th>
                            <th>
                                Location
                            </th>
                            <th>
                                Time
                            </th>
                            <th>
                                Appt Status
                            </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@push('js')
    <!-- Bootstrap DateRangePicker -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <!-- DataTables -->
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

    {{-- Data table button--}}
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>

    <script>
        $(document).ready(function(){
            /* Date Rang Picker*/
            $('input[name="daterange"]').daterangepicker();

            /* Data Table */
            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('clinic.reporting.data') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'date', name: 'date' },
                    { data: 'userable.name', name: 'userable.name' },
                    { data: 'userable.phone', name: 'userable.phone' },
                    { data: 'userable.email', name: 'userable.email' },
                    { data: 'provider', name: 'provider.name' },
                    { data: 'location', name: 'location.name' },
                    { data: 'start_time', name: 'start_time' },
                    { data: 'status', name: 'status.name' },
                ],
                dom: 'Bfrtip',
                buttons: [
                    'excel',
                    'pdf',
                    'print'
                ]
            });
        });
    </script>
@endpush
