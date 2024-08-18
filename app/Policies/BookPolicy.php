<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class BookPolicy
{
    public function update(User $user, Book $book){
        return $user->books->contains($book);
    }
}
