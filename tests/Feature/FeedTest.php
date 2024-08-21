<?php

use App\Models\Book;
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\post;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('only allows authenticated users')
    ->expectGuest()->toBeRedirectedFor('/feed');

it('shows books of friends', function(){
    $user = User::factory()->create();
    $friendOne = User::factory()->create();
    $friendTwo = User::factory()->create();

    $friendOne->books()->attach($bookOne = Book::factory()->create(), [
        'status' => 'READING',
        'updated_at' => now()->subDay(),
    ]);

    $friendTwo->books()->attach($bookTwo = Book::factory()->create(), [
        'status' => 'WANT_TO_READ',
        'updated_at' => now()->addDay(),
    ]);

    $user->addFriend($friendOne);
    $friendOne->acceptFriend($user);

    $friendTwo->addFriend($user);
    $user->acceptFriend($friendTwo);

    actingAs($user)
        ->get('/feed')
        ->assertSeeInOrder([
            $friendTwo->name . ' wants to read ' . $bookTwo->title,
            $friendOne->name . ' is reading ' . $bookOne->title,
        ]);

});