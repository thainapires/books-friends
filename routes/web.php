<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, BookController, HomeController};

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/auth/register', [AuthController::class, 'register'])->middleware('guest')->name('register');
Route::get('/auth/login', [AuthController::class, 'login'])->middleware('guest')->name('login');

Route::post('/books', [BookController::class, 'store'])->middleware('auth')->name('books');
Route::get('/books/create', [BookController::class, 'create'])->middleware('auth')->name('books.create');
Route::get('/books/{book}/edit', [BookController::class, 'edit'])->middleware('auth')->name('books.edit');