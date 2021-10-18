<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//routes for change password
Route::get('change-password',[\App\Http\Controllers\HomeController::class,'editPassword'])->name('change.password');
Route::post('update-password',[\App\Http\Controllers\HomeController::class,'updatePassword'])->name('update.password');
