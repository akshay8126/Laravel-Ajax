<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;

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

Route::get('/', function () {
    return view('welcome');
})->middleware('guest')->name('/');


Route::controller(LoginController::class)->group(function () {
    Route::post('/login', 'login')->name('login')->middleware('guest');
    Route::get('/register', 'register')->name('register')->middleware('guest');
    Route::post('/register-data', 'registerdata')->name('registerdata');
    Route::post('/logout', 'logout')->name('logout');
});
Route::controller(HomeController::class)->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/home', 'home')->name('home');
    });
});
