<?php

use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\UserApiController;
use \App\Http\Controllers\Api\AuthApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Cache;
use \Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::post('auth/login', [AuthApiController::class, 'login'])->name('auth.login');
Route::post('auth/register', [AuthApiController::class, 'register'])->name('auth.register');

Route::resource('post', PostApiController::class);
Route::resource('user', UserApiController::class);
Route::post('user/avatar', [UserApiController::class, 'storeImage'])->name('user.avatar');
Route::post('post/filter', [\App\Http\Controllers\Api\FilterPostController::class, 'filter'])->name('post.filter');

Route::get('/', function (){
    $users = Cache::remember('users', 600, function () {
        return \App\Models\User::all();
    });


});
