@extends('partials.master')

@section('content')
    <div class="card shadow p-3 justify-content-center">
        <div class="card-header text-center">
            <h2 class="card-title card-text">Assignment List</h2>
        </div>

        <div class="card-body">
            @can('create', \App\Models\Assignment::class)
            <div class="row flex-row-reverse mb-3 mr-3">
                <a href="{{ route('assignment.create') }}" class="btn btn-success" role="button">Add assignment</a>
            </div>
            @endcan
            <table class="text-center table table-hover table-bordered mb-0">
                <thead class="thead-light">
                <tr class="">
                    <th>#</th>
                    <th>Name</th>
                    <th>Teacher</th>
                    <th class="w-50">Description</th>
                    <th>File</th>
                    <th>Submission</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($assignments as $assignment)
                <tr>
                    <td>{{ $assignment->index + 1 }}</td>
                    <td>{{ $assignment->name }}</td>
                    <td>{{ $assignment->user->name }}</td>
                    <td>{{ $assignment->description }}</td>
                    <td>
                        @if($assignment->file)
                        <a href="{{ \App\Http\Controllers\FileController::download($assignment->file) }}"
                           role="button" class="btn btn-info btn-sm">Download</a>
                        @endif
                    </td>
                    <td>
                        @can('create', \App\Models\Submission::class)
                        <a href="{{ route('submission.create', ['id' => $assignment->id]) }}"
                           role="button" class="btn btn-sm btn-success"> Submit </a>
                        @endcan
                        @can('view', $assignment)
                        <a href="{{ route('submission.index', ['id' => $assignment->id]) }}"
                           role="button" class="btn btn-info btn-sm">Submission</a>
                        @endcan
                    </td>
                    <td>
                        @can('delete', $assignment)
                        <a href="{{ route('assignment.destroy', ['id' => $assignment->id]) }}" role="button"
                           class="btn btn-danger btn-sm"> Delete </a>
                        @endcan
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
