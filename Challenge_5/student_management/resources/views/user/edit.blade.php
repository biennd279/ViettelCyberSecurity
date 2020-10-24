@extends('partials.master')

@section('content')
<div class="row justify-content-center">
    <div class="card col-6 shadow p-3 bg-light">
        <div class="card-header">
            <h5 class="card-title text-center">Edit Profile</h5>
        </div>
        <div class="card-body">
            <form id="form-edit-profile" action="{{route('user.update')}}" method="post" class="form-group">
                @can('updateBaseInfo', \App\Models\User::class)
                <div class="form-group">
                    <label for="user-name">User name</label>
                    <input id="user-name" name="user_name" type="text" class="form-control"
                           value="{{ $user->user_name }}">
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" class="form-control" value="{{ $user->name }}">
                </div>
                @else
                <div class="form-group">
                    <label for="user-name">User name</label>
                    <input id="user-name" name="user_name" type="text" class="form-control"
                           value="{{ $user->user_name }}" disabled>
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" class="form-control" value="{{ $user->name }}" disabled>
                </div>
                @endcan


                @can('updateAny', \App\Models\User::class)
                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role_id" class="form-control custom-select">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $role->id == $user->role_id ? "selected" : "" }}>
                                {{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endcan

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" class="form-control" placeholder="******"
                           value="">
                </div>

                <div class="form-group">
                    <label for="repeat-password">Repeat Password</label>
                    <input id="repeat-password" type="password" class="form-control" placeholder="******" value="">
                </div>

                <div class="form-group">
                    <label for="email"> Email </label>
                    <input id="email" name="email" type="email" class="form-control" placeholder="Email"
                           value="{{ $user->email }}">
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input id="phone" name="phone" type="text" class="form-control" placeholder="Phone"
                           value="{{ $user->phone }}">
                </div>

                <input type="hidden" name="id" value="{{ $user->id }}">

                <button type="reset" class="btn btn-danger">Reset</button>
                <button type="submit" class="btn btn-success">Save changes</button>
                {{ csrf_field() }}
            </form>
        </div>
    </div>
</div>
@endsection
