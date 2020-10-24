<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function getIndex()
    {
        $user = User::find(\Auth::id());
        $messages_send = $user->messages()->get();
        $messages_receive = $user->receiveMessages()->get();
        $messages = Collection::make($messages_send)
            ->merge($messages_receive)
            ->sortBy('created_at')
            ->all();
        return view('message.index', ['messages' => $messages,'user' => $user]);
    }

    public function getFetchMessage(int $id)
    {
        $user = User::find(\Auth::id());
        $receive_user = User::find($id);

        $messages_send = $user->messages()->where('receive_user_id', $receive_user->id)->get();
        $messages_receive = $user->receiveMessages()->where('user_id', $receive_user->id)->get();

        $messages = Collection::make($messages_send)
            ->merge($messages_receive)
            ->sortBy('created_at')
            ->all();

        return view('message.message', ['messages' => $messages,
            'user' => $user,
            'receive_user' => $receive_user
        ]);
    }

    public function postStoreMessage(Request $request, int $id)
    {
        if (!\Auth::user()->can('create', Message::class)) {
            return response(null)->setStatusCode(403);
        }
        if ($request->input('message') != '')
        {
            $user = \Auth::user();
            $message = $request->input('message');
            $receive_user_id = $request->input('receive_user_id');
            $user->messages()->create([
                'message' => $message,
                'receive_user_id' => $receive_user_id
            ]);
        }
        return redirect()->back();
    }

    public function getDeleteMessage(int $id)
    {
        $message = Message::find($id);
        if (!\Auth::user()->can('delete', $message)) {
            return response(null)->setStatusCode(403);
        }
        $message->delete();
        return redirect()->back();
    }

    public function postUpdateMessage(Request $request, int $id)
    {
        $message = Message::find($id);
        if (!\Auth::user()->can('update', $message)) {
            return response(null)->setStatusCode(403);
        }
        $message->message = $request->input('message');
        $message->save();

        return redirect()->back();
    }
}
