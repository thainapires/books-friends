<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterIndexController extends Controller
{
    public function index(){
        return view('auth.register');
    }
}
