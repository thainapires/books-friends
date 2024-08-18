<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{BookCreateController, BookEditController, BookStoreController, HomeController, LoginController, RegisterIndexController};

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/auth/register', [RegisterIndexController::class, 'index'])->middleware('guest')->name('register');
Route::get('/auth/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/books', [BookStoreController::class, 'index'])->middleware('auth')->name('books');
Route::get('/books/create', [BookCreateController::class, 'index'])->middleware('auth')->name('books.create');
Route::get('/books/{book}/edit', [BookEditController::class, 'index'])->middleware('auth')->name('books.edit');