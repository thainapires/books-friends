<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController, LoginController, RegisterIndexController};


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/auth/register', [RegisterIndexController::class, 'index'])->name('register');
Route::get('/auth/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
