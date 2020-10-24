@extends('partials.master')

@section('content')
    <div class="row justify-content-center">
        <div class="card p-0 col-6 shadow p-3 bg-light">
            <div class="card-body">
                <div class="d-flex justify-content-center m-4">
                    <a href="{{ route('message.fetch', ['id' => $user->id]) }}" class="btn btn-lg btn-primary">Message</a>
                </div>
                <div class="d-flex m-3">
                    <div class="col pl-4 text-muted"><label>User:</label></div>
                    <div class="col pr-4">{{ $user->user_name }}</div>
                </div>
                <div class="d-flex m-3">
                    <div class="col pl-4 text-muted"><label>Full name:</label></div>
                    <div class="col pr-4">{{ $user->name }}</div>
                </div>
                <div class="d-flex m-3">
                    <div class="col pl-4 text-muted"><label>Role:</label></div>
                    <div class="col pr-4">{{ $user->role->name }}</div>
                </div>
                <div class="d-flex m-3">
                    <div class="col pl-4 text-muted"><label>Email:</label></div>
                    <div class="col pr-4">{{ $user->email }}</div>
                </div>
                <div class="d-flex m-3">
                    <div class="col pl-4 text-muted"><label>Phone</label></div>
                    <div class="col pr-4">{{ $user->phone }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
