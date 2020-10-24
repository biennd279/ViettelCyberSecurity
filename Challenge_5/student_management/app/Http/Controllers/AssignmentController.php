<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\User;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function getIndex()
    {
        if (!\Auth::user()->can('viewAny', Assignment::class)) {
            return response(null)->setStatusCode(403);
        }
        $assignments = Assignment::all();
        return view('assignment.index', ['assignments' => $assignments]);
    }

    public function getCreateAssignment()
    {
        if (!\Auth::user()->can('create', Assignment::class)) {
            return response(null)->setStatusCode(403);
        }
        return view('assignment.create');
    }

    public function postStoreAssignment(Request $request)
    {
        if (!\Auth::user()->can('create', Assignment::class)) {
            return response()->setStatusCode(403);
        }
        $assignment = new Assignment([
            'name' => $request->input('name'),
            'user_id' => \Auth::id(),
            'description' => $request->input('description')
        ]);
        $file = FileController::upload($request->file('file'));
        $assignment->file()->associate($file);
        $assignment->save();
        return redirect()->route('assignment.index');
    }

    public function getDeleteAssignment(int $id)
    {
        $assignment = Assignment::find($id);
        if (!\Auth::user()->can('delete', $assignment)) {
            return response()->setStatusCode(403);
        }
        $assignment->delete();
        return redirect()->route('assignment.index');
    }
}
