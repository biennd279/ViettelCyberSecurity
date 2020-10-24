@extends('partials.master')

@section('content')
    <div class="row justify-content-center">
        <div class="card col-6 shadow p-3 bg-light">
            <div class="card-header">
                <h5 class="card-title text-center">Submit</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('submission.store', ['id' => $assignment->id]) }}" enctype="multipart/form-data"
                      method="post" class="form-group align-content-center">
                    <div class="form-group">
                        <label class="form-text" for="assignment-id">Assignment id</label>
                        <input type="text" class="form-control" id="assignment-id" name="assignment_id"
                               value="{{ $assignment->id }}" readonly>
                    </div>

                    <div class="form-group">
                        <label class="form-text" for="assignment-name">Assignment name</label>
                        <input type="text" class="form-control" id="assignment-name" name="assignment-name"
                               value="{{ $assignment->name }}" disabled>
                    </div>

                    <div class="form-group">
                        <label class="form-text" for="note">Note</label>
                        <textarea class="form-control" id="note" name="note" rows="5" placeholder="Note"></textarea>
                    </div>

                    <input type="file" id="file" class="p-5 form-control-file" name="file" value="Chose file">
                    <button type="submit" class="btn btn-success btn-block">Submit</button>
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
@endsection
