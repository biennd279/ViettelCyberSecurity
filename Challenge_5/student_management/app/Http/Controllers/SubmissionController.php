<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{

    public function getIndex(int $assignment_id)
    {
        $assignment = Assignment::find($assignment_id);
        if (!\Auth::user()->can('view', $assignment)) {
            return response(null)->setStatusCode(403);
        }
        return view('assignment.submission', ['assignment' => $assignment]);
    }

    public function getCreateSubmit(int $id)
    {
        if (!\Auth::user()->can('create', Assignment::class)) {
            return response(null)->setStatusCode(403);
        }

        $assignment = Assignment::find($id);
        return view('assignment.submit', ['assignment' => $assignment]);
    }

    public function postCreateSubmit(Request $request, int $id)
    {
        if (!\Auth::user()->can('create', Assignment::class)) {
            return response(null)->setStatusCode(403);
        }

        $assigment = Assignment::find($id);
        $submission = new Submission([
            'note' => $request->input('note'),
            'user_id' => \Auth::id()
        ]);
        $file = FileController::upload($request->file('file'));
        $submission->file()->associate($file);
        $assigment->submissions()->save($submission);
        return redirect()->route('assignment.index');
    }
}
