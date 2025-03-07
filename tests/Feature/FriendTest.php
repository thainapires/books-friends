<?php

use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\post;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('redirects unauthenticated users')
    ->expectGuest()->toBeRedirectedFor('/friends');

it('shows a list of the users pending friends', function(){
    $user = User::factory()->create();
    $friends = User::factory()->times(2)->create();

    $friends->each(fn ($friend) => $user->addFriend($friend));

    actingAs($user)
        ->get('/friends')
        ->assertOk()
        ->assertSeeTextInOrder(array_merge(['Pending friend requests'], $friends->pluck('name')->toArray()));

});

it('shows a list of the users friend requests', function(){
    $user = User::factory()->create();
    $friends = User::factory()->times(2)->create();

    $friends->each(fn ($friend) => $friend->addFriend($user));

    actingAs($user)
        ->get('/friends')
        ->assertOk()
        ->assertSeeTextInOrder(array_merge(['Friend requests'], $friends->pluck('name')->toArray()));
});

it('shows a list of the users accepted friends', function(){
    $user = User::factory()->create();
    $friends = User::factory()->times(2)->create();

    $friends->each(function ($friend) use ($user){
        $user->addFriend($friend);
        $friend->acceptFriend($user);
    });

    actingAs($user)
        ->get('/friends')
        ->assertOk()
        ->assertSeeTextInOrder(array_merge(['Friends'], $friends->pluck('name')->toArray()));
});
