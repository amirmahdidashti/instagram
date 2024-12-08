<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ChatController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPost']);
    Route::get('/register', [AuthController::class, 'register']);
    Route::post('/register', [AuthController::class, 'registerPost']);
    Route::get('/logout', [AuthController::class, 'logout']);
});
Route::middleware(['auth','avatar'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/', [SiteController::class, 'index']);
    Route::get('/chat/{id}', [ChatController::class, 'chat'])->name('chat');
    Route::get('/chat', [ChatController::class, 'chats']);
    Route::post('/chat/{id}', [ChatController::class, 'newMessage']);
    Route::get('/search', [SiteController::class, 'search']);
    Route::get('/all', [SiteController::class, 'all']);
    Route::get('/newpost', [SiteController::class, 'newpost']);
    Route::post('/newpost', [SiteController::class, 'newpostPost']);
    Route::get('/delete/{id}', [SiteController::class, 'delete']);
    Route::get('/profile/{id?}', [SiteController::class, 'profile']);
    // Route::get('/profile', [SiteController::class, 'profile']);
    Route::post('/profile', [SiteController::class, 'profilePost']);
    Route::get('/profile/{id}/chat', [ChatController::class, 'newChat']);
    Route::get('/profile/{id}/follow', [SiteController::class, 'follow']);
    Route::get('/profile/{id}/posts', [SiteController::class, 'userPosts']);
    Route::get('/{id}', [SiteController::class, 'show']);
    Route::post('/{id}', [SiteController::class, 'comment']);
});
