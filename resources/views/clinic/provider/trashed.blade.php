@extends('layout.clinic')

@section('title', 'Deleted Providers')

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Deleted Providers</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                    <tr>
                        <th style="width: 1%">
                            #
                        </th>
                        <th style="width: 20%">
                            Name
                        </th>
                        <th style="width: 30%">
                            Email
                        </th>
                        <th>
                            Phone
                        </th>
                        <th>
                            Role
                        </th>
                        <th style="width: 20%">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $key => $user)
                        <tr>
                            <td>{{ $loop->iteration  }}</td>
                            <td>
                                <a>{{ $user->name }}</a><br/>
                            </td>
                            <td>
                                {{ $user->email }}<br/>
                            </td>
                            <td class="project_progress">
                                {{ $user->userDetail->phone }}
                            </td>
                            <td>
                                {{ $user->getRoleNames()[0] }}<br/>
                            </td>
                            <td class="project-actions text-right">
                                <form method="POST" action="{{ route('clinic.provider.restore', ['provider' => $user->id]) }}">
                                    @csrf
                                    <input name="_method" type="hidden" value="POST">
                                    <button onclick="return confirm('Are you sure you want to restore ?')" type="submit" class="btn btn-success restore" title='Restore'><i class="fas fa-recycle"> Restore</i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
