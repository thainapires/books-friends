<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, BookController, FeedController, FriendController, HomeController};

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/auth/register', [AuthController::class, 'register'])->middleware('guest')->name('register');
Route::get('/auth/login', [AuthController::class, 'login'])->middleware('guest')->name('login');

Route::post('/books', [BookController::class, 'store'])->middleware('auth')->name('books');
Route::get('/books/create', [BookController::class, 'create'])->middleware('auth')->name('books.create');
Route::get('/books/{book}/edit', [BookController::class, 'edit'])->middleware('auth')->name('books.edit');
Route::put('/books/{book}', [BookController::class, 'update'])->middleware('auth')->name('books.update');

Route::get('/friends', [FriendController::class, 'index'])->middleware('auth')->name('friends');
Route::post('/friends', [FriendController::class, 'request'])->middleware('auth')->name('friends.request');
Route::patch('/friends/{friend}', [FriendController::class, 'accept'])->middleware('auth')->name('friends.accept');
Route::delete('/friends/{friend}', [FriendController::class, 'delete'])->middleware('auth')->name('friends.delete');

Route::get('/feed', [FeedController::class, 'index'])->middleware('auth')->name('feed');