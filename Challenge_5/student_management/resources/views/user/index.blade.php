@extends('partials.master')

@section('content')
    <div class="card shadow p-3 justify-content-center">
        <div class="card-header text-center">
            <h2 class="card-title card-text">User list</h2>
        </div>

        <div class="card-body">
            @can('create', App\Models\User::class)
            <div class="row flex-row-reverse mb-3 mr-3">
                <a href="{{ route('user.create') }}" class="btn btn-success" role="button">Add user</a>
            </div>
            @endcan
            <table class="text-center table table-hover table-bordered mb-0">
                <thead class="thead-light">
                <tr class="">
                    <th>#</th>
                    <th>User</th>
                    <th>Full name</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{$loop->index + 1}}</td>
                        <td>{{$user->user_name}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->role->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone}}</td>
                        <td class="btn-group w-100">
                            @can('view', $user)
                            <a href="{{ route('user.show', ['id' => $user->id]) }}" class="btn btn-primary btn-sm"
                               role="button">Detail</a>
                            @endcan
                            @can('update', $user)
                            <a href="{{ route('user.edit', ['id' => $user->id]) }}" class="btn btn-warning btn-sm"
                               role="button">Edit</a>
                            @endcan
                            @can('delete', $user)
                            <a href="{{ route('user.destroy', ['id' => $user->id]) }}" class="btn btn-danger btn-sm"
                               role="button">Delete</a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
