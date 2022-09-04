<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




Route::prefix('/notification')->group(function () {
    Route::get('read-all', [NotificationController::class, 'readAll'])->name('admin.notification.readAll');
    Route::get('AdminReadAll', [NotificationController::class, 'AdminReadAll'])->name('admin.notification.AdminReadAll');
    Route::get('newUser', [NotificationController::class, 'newUser'])->name('admin.notification.newUser');
    Route::get('adminNewChat', [NotificationController::class, 'adminNewChat'])->name('admin.notification.adminNewChat');



});

Route::prefix('/chat')->group(function () {
    Route::get('/',[ChatController::class, 'chat'])->name('chat');
    Route::post('/post',[ChatController::class, 'post'])->name('chat.post');
    Route::get('/log',[ChatController::class, 'log'])->name('chat.log');
    Route::get('/destroySession',[ChatController::class, 'destroySession'])->name('chat.destroySession');
    Route::post('/start',[ChatController::class, 'start'])->name('chat.start');
    Route::get('/isSetSession',[ChatController::class, 'isSetSession'])->name('chat.isSetSession');
    Route::delete('/destroy/{chat}',[ChatController::class, 'destroy'])->name('chat.destroy');

});


