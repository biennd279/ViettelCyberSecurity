@extends('partials.master')

@section('content')
    <div class="card shadow p-3 justify-content-center">
        <div class="card-header text-center">
            <h2 class="card-title card-text">Assignment List</h2>
        </div>

        <div class="card-body">
            <form class="form-group" id="form-add-assignment" action="{{ route('assignment.store') }}"
                  method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Assigment name" required>
                </div>
                <div class="form-group">
                    <label for="file">File</label>
                    <input type="file" id="file" class="form-control-file" name="file" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" placeholder="Description" rows="5"></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                {{csrf_field()}}
            </form>
        </div>
    </div>
@endsection
