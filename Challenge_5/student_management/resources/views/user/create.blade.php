@extends('partials.master')

@section('content')
    <div class="row justify-content-center">
        <div class="card col-6 shadow p-3 bg-light">
            <div class="card-header">
                <h5 class="card-title text-center">Create User</h5>
            </div>
            <div class="card-body">
                <form id="form-edit-profile" class="form-group" action="{{route('user.store')}}" method="post">
                    <div class="form-group">
                        <label for="user-name">User name</label>
                        <input id="user-name" name="user_name" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input id="name" name="name" type="text" class="form-control">
                    </div>

                    @can('createAny', \App\Models\User::class)
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="role" name="role_id" class="form-control custom-select">
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @else
                        <input type="hidden" name="role_id" value="{{ $roles->firstWhere('name', 'student')->id }}">
                    @endcan

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" class="form-control" placeholder="******">
                    </div>

                    <div class="form-group">
                        <label for="repeat-password">Repeat Password</label>
                        <input id="repeat-password" type="password" class="form-control" placeholder="******">
                    </div>

                    <div class="form-group">
                        <label for="email"> Email </label>
                        <input id="email" name="email" type="email" class="form-control" placeholder="Email">
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input id="phone" name="phone" type="text" class="form-control" placeholder="Phone">
                    </div>

                    <button type="reset" class="btn btn-danger">Reset</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
@endsection
