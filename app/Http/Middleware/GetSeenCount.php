<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use View;
use Auth;
use App\Models\message;
use App\Models\Chat;

class GetSeenCount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check()){
            return $next($request);
        }
        $chats = Chat::where('user_1', Auth::user()->id)->orWhere('user_2', Auth::user()->id)->pluck('id');
        $count = message::whereIn('chat_id',$chats)->where('sender_id','!=',Auth::user()->id)->where('seen',0)->count();
        if($request->route()->getName() == 'chat'){
            $count = $count - message::where('chat_id', $request->id)->where('sender_id','!=',Auth::user()->id)->where('seen',0)->count();
        }
        View::share('unreadCount',$count);
        return $next($request);
    }
}
