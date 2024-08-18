<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookCreateController extends Controller
{
    public function index(Request $request){
        return view('books.create');
    }
}
