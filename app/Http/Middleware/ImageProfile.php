<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use App\Models\Image;
use App\Models\User;
use View;
class ImageProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $avatar = Image::where('type', 0 )->where('subject_id', Auth::user()->id)->first()->image;
        view::share('avatar', $avatar);
        return $next($request);
    }
}
