<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookPutFormRequest;
use App\Http\Requests\BookStoreFormRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Pivot\BookUser;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    use ValidatesRequests;

    public function create(Request $request){
        return view('books.create');
    }

    public function edit(Book $book, Request $request){

        if ($request->user()->cannot('update', $book)) {
            abort(403);
        }

        $book = $request->user()->books->find($book->id);

        return view('books.edit', [
            'book' => $book
        ]);
    }

    public function store(BookStoreFormRequest $request){

        $book = Book::create($request->only('title', 'author'));
        $request->user()->books()->attach($book, [
            'status' => $request->status
        ]);

        return redirect('/');
    }

    public function update(Book $book, BookPutFormRequest $request){

        $book = $request->user()->books->find($book->id);

        $book->update($request->only('title', 'author'));
        $request->user()->books()->updateExistingPivot($book, [
            'status' => $request->status
        ]);

        return redirect('/');
        
    }
}
