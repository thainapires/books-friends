<?php

use App\Models\Pivot\BookUser;
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('only allows authenticated user')
    ->expectGuest()->toBeRedirectedFor('/books/create');

it('shows the available statuses on the form', function(){
    $user = User::factory()->create();
    $this->actingAs($user)
        ->get('/books/create')
        ->assertSeeTextInOrder(BookUser::$statuses);
});
