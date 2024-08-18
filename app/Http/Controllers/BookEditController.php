<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookEditController extends Controller
{
    public function index(Book $book, Request $request){

        if(!$book = $request->user()->books->find($book->id)){
            abort(403);
        }

        return view('books.edit', [
            'book' => $book
        ]);
    }
}
