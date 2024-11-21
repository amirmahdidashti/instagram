<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use App\Models\message;
use App\Models\Image;
use Pusher\Pusher;
use Auth;
class ChatController extends Controller
{
    public function newChat($id)
    {
        if (Auth::user()->id == $id) {
            return redirect()->back();
        }
        if (Auth::user()->chat_1->contains($id) || Auth::user()->chat_2->contains($id)) {
            $chat = Auth::user()->chat_2->find($id);
            if (!$chat) {
                $chat = Auth::user()->chat_1->find($id);
            }
            return redirect('/chat/' . $chat->id);
        }
        User::findOrFail($id)->chat_1()->attach(Auth::user());
        return redirect('/chat/' . User::findOrFail($id)->chat_1()->find(Auth::user()->id)->id);
    }

    public function chat($id)
    {
        $chat = Chat::findOrFail($id);
        if (!Auth::user()->chat_1->contains($chat->user_2) && !Auth::user()->chat_2->contains($chat->user_1)) {
            return abort(403);
        }
        $messages = $chat->messages;
        $user = Auth::user()->chat_1->find($chat->user_2);
        if ($user == null) {
            $user = Auth::user()->chat_2->find($chat->user_1);
        }
        foreach ($messages as $message) {
            if (!Auth::user()->messages->contains($message->id)) {
                $message->seen = 1;
                $message->save();
            }
        }
        return view('chat', compact('messages', 'user', 'id'));
    }

    public function newMessage(Request $request, $id)
    {
        $message = new message();
        $message->text = $request->message;
        $message->user()->associate(Auth::user());
        $message->chat()->associate(Chat::findOrFail($id));
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
        $pusher->trigger($id, 'new-message', $data);
        return 1;
    }

    public function chats()
    {
        $chats = Auth::user()->chat_1->merge(Auth::user()->chat_2);
        foreach ($chats as $chat) {
            $chat->lastMessage = Chat::find($chat->pivot->id)->messages->last();
            $chat->avatar = Image::where('type', 0)->where('subject_id', $chat->id)->first()->image;
        }
        return view('chats', compact('chats'));
    }
}
