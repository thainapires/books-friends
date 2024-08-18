<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Pivot\BookUser;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    use ValidatesRequests;

    public function create(Request $request){
        return view('books.create');
    }

    public function edit(Book $book, Request $request){

        if(!$book = $request->user()->books->find($book->id)){
            abort(403);
        }

        return view('books.edit', [
            'book' => $book
        ]);
    }

    public function store(Request $request){

        $this->validate($request, [
            'title' => 'required',
            'author' => 'required',
            'status' => ['required', Rule::in(array_keys(BookUser::$statuses))],
        ]);

        $book = Book::create($request->only('title', 'author'));
        $request->user()->books()->attach($book, [
            'status' => $request->status
        ]);

        return redirect('/');
    }

    public function update(Book $book, Request $request){
        if(!$book = $request->user()->books->find($book->id)){
            abort(403);
        }

        $this->validate($request, [
            'title' => 'required',
            'author' => 'required',
            'status' => ['required', Rule::in(array_keys(BookUser::$statuses))],
        ]);

        $book->update($request->only('title', 'author'));
        $request->user()->books()->updateExistingPivot($book, [
            'status' => $request->status
        ]);

        return redirect('/');
        
    }
}
