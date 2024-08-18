<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function index(Request $request){
        return view('friends.index', [
            'friends' => $request->user()->friends,
            'pendingFriends' => $request->user()->pendingFriendsOfMine,
            'friendRequests' => $request->user()->pendingFriendsOf,
        ]);
    }
}
