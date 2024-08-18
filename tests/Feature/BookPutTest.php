<?php

use App\Models\Book;
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

beforeEach(function() {
    $this->user = User::factory()->create();
});

it('redirects unauthenticated users')
    ->expectGuest()->toBeRedirectedFor('/books/1', 'put');

it('fails if book does not exist', function(){
    actingAs($this->user)
        ->put('/books/1')
        ->assertStatus(404);
});

it('validates the request details', function(){
    $this->user->books()->attach($book = Book::factory()->create(), [
        'status' => 'READING'
    ]);

    actingAs($this->user)
        ->put('/books/' . $book->id)
        ->assertSessionHasErrors(['title', 'author', 'status']);
});

it('fails if the user does not own the book', function(){
    $anotherUser = User::factory()->create();
    $anotherUser->books()->attach($book = Book::factory()->create(), [
        'status' => 'READING'
    ]);

    actingAs($this->user)
        ->put('/books/' . $book->id, [
            'tile' => 'New title',
            'author' => 'New author',
            'status' => 'READING'
        ])
        ->assertStatus(403);
});

it('updates the book', function(){
    $this->user->books()->attach($book = Book::factory()->create(), [
        'status' => 'READING'
    ]);

    actingAs($this->user)
        ->put('/books/' . $book->id, [
            'title' => 'Updated title',
            'author' => 'Updated author',
            'status' => 'READ'
        ]);
        
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Updated title',
            'author' => 'Updated author',
        ]);

        $this->assertDatabaseHas('book_user', [
            'book_id' => $book->id,
            'status' => 'READ'
        ]);
});