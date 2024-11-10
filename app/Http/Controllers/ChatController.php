<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use App\Models\message;
use Pusher\Pusher;
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
        $messages = Message::where('chat_id', $id)->get();
        $user = User::find($chat->user_2);
        if ($user == Auth::user()) {
            $user = User::find($chat->user_1);
        }
        foreach ($messages as $message) {
            if ($message->sender_id != Auth::user()->id) {
                $message->seen = 1;
                $message->save();
            }
        }
        return view('chat', compact('messages', 'user','id'));
    }

    public function newMessage(Request $request, $id)
    {
        $message = new message();
        $message->text = $request->message;
        $message->sender_id = Auth::user()->id;
        $message->chat_id = $id;
        $message->save();

        $options = array(
          'cluster' => 'ap2',
          'useTLS' => true
        );
        $pusher = new Pusher(
          'afe67a7ef0421517e32b',
          'c24f93b8becbbcfac33c',
          '1891907',
          $options
        );
        $data = $message;
        $pusher->trigger($id , 'new-message', $data);
        return 1;
    }

    public function chats()
    {
        $chats = Chat::where('user_1', Auth::user()->id)->orWhere('user_2', Auth::user()->id)->get();
        foreach ($chats as $chat) {
            $chat->user = User::find($chat->user_2);
            if ($chat->user == Auth::user()) {
                $chat->user = User::find($chat->user_1);
            }
            $chat->lastMessage = Message::where('chat_id', $chat->id)->latest()->first();
        }
        return view('chats', compact('chats'));
    }
}
