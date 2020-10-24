<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChallengeController extends Controller
{
    public function getIndex()
    {
        if (!\Auth::user()->can('viewAny', Challenge::class)) {
            return response(null)->setStatusCode(403);
        }
        $challenges = Challenge::all();
        return view('challenge.index', ['challenges' => $challenges]);
    }

    public function getCreateChallenge()
    {
        if (!\Auth::user()->can('create', Challenge::class)) {
            return response(null)->setStatusCode(403);
        }
        return view('challenge.create');
    }

    public function postStoreChallenge(Request $request)
    {
        if (!\Auth::user()->can('create', Challenge::class)) {
            return response(null)->setStatusCode(403);
        }
        $challenge = new Challenge([
            'name' => $request->input('name'),
            'user_id' => \Auth::id(),
            'suggestion' => $request->input('suggestion')
        ]);
        $file = FileController::upload($request->file('file'));
        $challenge->file()->associate($file);
        $challenge->save();
        return redirect()->route('challenge.index');
    }

    public function postSubmit(Request $request)
    {
        $id = $request->input('id');
        $answer = $request->input('answer');

        $challenge = Challenge::find($id);
        $correct_answer = pathinfo($challenge->file->path, PATHINFO_FILENAME);

        $correct = false;
        $content = null;

        if ($answer === $correct_answer) {
            $correct = true;
            $content = Storage::get($challenge->file->path);
        }

        return response()->json([
           "correct" => $correct,
           "content" => $content
        ]);
    }
}
