<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

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

// ログイン画面
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login.index');
// ユーザー登録画面
Route::get('/user', [RegisterController::class, 'showRegistrationForm'])->name('user.register');
Route::post('/user/register', 'App\Http\Controllers\Auth\RegisterController@register')->name('user.exec.register');

// middleware auth
Route::group(['middleware' => ['auth']], function () {
    // メモ一覧画面
    Route::get('/memo', [MemoController::class, 'index'])->name('memo.index');
    Route::get('/memo/add', [MemoController::class, 'add'])->name('memo.add');
    Route::post('/memo/update', [MemoController::class, 'update'])->name('memo.update');
    Route::post('/memo/delete', [MemoController::class, 'delete'])->name('memo.delete');
    Route::get('/memo/select', [MemoController::class, 'select'])->name('memo.select');
    Route::get('logout', [LoginController::class, 'logout'])->name('memo.logout');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
