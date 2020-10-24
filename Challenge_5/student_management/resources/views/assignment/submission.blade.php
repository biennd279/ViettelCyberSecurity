@extends('partials.master')

@section('content')
    <div class="card shadow p-3 justify-content-center">
        <div class="card-header text-center">
            <h2 class="card-title card-text">Submission List</h2>
        </div>

        <div class="card-body">
            <table class="text-center table table-hover table-bordered mb-0">
                <thead class="thead-light">
                    <tr class="">
                        <th>#</th>
                        <th>Student name</th>
                        <th>Note</th>
                        <th>Time created</th>
                        <th>File</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignment->submissions as $submission)
                    <tr>
                        <td>{{ $submission->index + 1 }}</td>
                        <td>{{ $submission->user->name }}</td>
                        <td>{{ $submission->note }}</td>
                        <td>{{ $submission->created_at }}</td>
                        <td>
                            @if($submission->file)
                                <a href="{{ \App\Http\Controllers\FileController::download($submission->file) }}"
                                   role="button" class="btn btn-info btn-sm">Download</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
