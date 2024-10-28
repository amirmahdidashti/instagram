<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use App\Models\message;
use Auth;
class ChatController extends Controller
{
    public function newChat($id)
    {
        if (Auth::user()->id == $id) {
            return redirect()->back();
        }
        $chat = Chat::where('user_1', Auth::user()->id)->where('user_2', $id)->first();
        if ($chat) {
            return redirect('/chat/' . $chat->id);
        } else {
            $chat = Chat::where('user_1', $id)->where('user_2', Auth::user()->id)->first();
            if ($chat) {
                return redirect('/chat/' . $chat->id);
            }
        }
        $chat = new Chat();
        $chat->user_1 = Auth::user()->id;
        $chat->user_2 = $id;
        $chat->save();
        return redirect('/chat/' . $chat->id);
    }

    public function chat($id)
    {
        $chat = Chat::find($id);
        if (!$chat) {
            return redirect('/');
        }
        if ($chat->user_1 != Auth::user()->id && $chat->user_2 != Auth::user()->id) {
            return abort(403);
        }
        $messages = message::where('chat_id', $id)->get();
        $user = User::find($chat->user_2);
        if ($user == Auth::user()) {
            $user = User::find($chat->user_1);
        }
        return view('chat', compact('messages', 'user'));
    }

    public function newMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'required',
        ]);
        $message = new message();
        $message->text = $request->message;
        $message->sender_id = Auth::user()->id;
        $message->chat_id = $id;
        $message->save();
        return redirect('/chat/' . $id);
    }
}
