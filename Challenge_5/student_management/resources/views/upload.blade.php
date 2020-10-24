@extends('partials.master')

@section('content')
<div class="row justify-content-center">
    <div class="card col-6 shadow p-3 bg-light">
        <div class="card-header">
            <h5 class="card-title text-center">Submit</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('file.store') }}" enctype="multipart/form-data"
                  method="post" class="form-group align-content-center">

                <input type="file" id="file" class="p-5 form-control-file" name="file" value="Chose file">
                <button type="submit" class="btn btn-success btn-block">Submit</button>
                {{ csrf_field() }}
            </form>
        </div>
    </div>
</div>
@endsection
