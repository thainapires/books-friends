<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can have pending friends', function () {
    $user = User::factory()->create();
    $friend = User::factory()->create();

    $user->addFriend($friend);

    //expect($user->pendingFriendsOfMine)->count()->toBe(1);
    expect($user->pendingFriendsOfMine)->toHaveCount(1);
});

it('can have friends requests', function () {
    $user = User::factory()->create();
    $friend = User::factory()->create();

    $friend->addFriend($user);

    expect($user->pendingFriendsOf)->toHaveCount(1);
});

it('does not create duplicated friend request', function(){
    $user = User::factory()->create();
    $friend = User::factory()->create();

    $user->addFriend($friend);
    $user->addFriend($friend);

    expect($user->pendingFriendsOfMine)->toHaveCount(1);
    //expect($user->pendingFriendsOfMine)->not()->toBe(2);
    //expect($user->pendingFriendsOfMine)->not()->toHaveCount(2);
});

it('can accept friends', function(){
    $user = User::factory()->create();
    $friend = User::factory()->create();

    $user->addFriend($friend);

    $friend->acceptFriend($user);

    //expect($user->acceptedFriendsOfMine)->toHaveCount(1);
    //expect($user->acceptedFriendsOfMine->pluck('id'))->toContain($friend->id);

    //High order expectation
    expect($user->acceptedFriendsOfMine)
        ->toHaveCount(1)
        ->pluck('id')
        ->toContain($friend->id);
});

it('can get all friend', function(){
    $user = User::factory()->create();
    $friend = User::factory()->create();
    $anotherFriend = User::factory()->create();
    $yetAnotherFriend = User::factory()->create();

    $user->addFriend($friend);
    $user->addFriend($anotherFriend);
    $user->addFriend($yetAnotherFriend);

    $friend->acceptFriend($user);
    $yetAnotherFriend->acceptFriend($user);

    expect($user->friends)->toHaveCount(2);
    expect($friend->friends)->toHaveCount(1);
    expect($anotherFriend->friends)->toHaveCount(0);
    expect($yetAnotherFriend->friends)->toHaveCount(1);

});

it('can remove a friend', function(){
    $user = User::factory()->create();
    $friend = User::factory()->create();

    $user->addFriend($friend);
    $friend->acceptFriend($user);

    $user->removeFriend($friend);
    expect($user->friends)->toHaveCount(0);
    expect($friend->friends)->toHaveCount(0);
});
