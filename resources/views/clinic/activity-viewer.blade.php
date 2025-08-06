@extends('layout.clinic')

@section('title', 'Activity Viewer')

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Activity Log</h3>

                <!-- simple grid search close tag is use bcz some browser not support with out closing tag -->
                <x-grid-search :searchRoute="route('clinic.activityViewer')"></x-grid-search>

            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                    <tr>
                        <th style="width: 1%">
                            #
                        </th>
                        <th style="width: 20%">
                            Log Name
                        </th>
                        <th style="width: 30%">
                            Description
                        </th>
                        <th style="width: 30%">
                            Event
                        </th>
                        <th>
                            Update Model
                        </th>
                        <th>
                            Update By
                        </th>
                        <th>
                            Created At
                        </th>
                        <th>
                            Update At
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($activities as $key => $activity)
                        <tr>
                            <td>{{ $loop->iteration  }}</td>
                            <td>
                                {{ $activity->log_name }}<br/>
                            </td>
                            <td>
                                {{ $activity->description }}<br/>
                            </td>
                            <td>
                                {{ $activity->event }}
                            </td>
                            <td>
                                {{ ($activity->subject) ? $activity->subject->name : 'N\A' }}
                            </td>
                            <td>
                                {{ ($activity->causer) ? $activity->causer->name : 'N\A' }}
                            </td>
                            <td>
                                {{ date(config('app.default_date_format_string'), strtotime($activity->created_at))  }}
                            </td>
                            <td>
                                {{ date(config('app.default_date_format_string'), strtotime($activity->updated_at))  }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <br>
                <div class="col-12">
                    {{ $activities->appends(['query' =>  Request::get('q') ])->links('pagination') }}
                </div>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
