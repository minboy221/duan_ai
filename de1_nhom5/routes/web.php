<?php

use Illuminate\Support\Facades\Route;

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
    return view('dashboard');
})->name('dashboard');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/dang-ky', function () {
    return view('dangky');
})->name('dangky');

Route::get('/ngan-sach', function () {
    return view('ngansach');
})->name('ngansach');

Route::get('/phan-tich-ai', function () {
    return view('phantichAi');
})->name('phantich-ai');

Route::get('/tro-ly-giao-dich-ai', function () {
    return view('TroligiaodichAi');
})->name('tro-ly-giao-dich-ai');
