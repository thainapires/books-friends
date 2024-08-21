<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class FriendController extends Controller
{
    use ValidatesRequests;

    public function index(Request $request){
        return view('friends.index', [
            'friends' => $request->user()->friends,
            'pendingFriends' => $request->user()->pendingFriendsOfMine,
            'friendRequests' => $request->user()->pendingFriendsOf,
        ]);
    }

    public function request(Request $request){

        $this->validate($request, [
            'email' => ['required', 'exists:users,email', Rule::notIn([$request->user()->email])]
        ]);

        $request->user()->addFriend(User::whereEmail($request->email)->first());

        return back();
    }

    public function accept(Request $request, User $friend){
        $request->user()->pendingFriendsOf()->updateExistingPivot($friend, [
            'accepted' => true,
        ]);

        return back();
    }

    public function delete(Request $request, User $friend){

        $teste = $request->user()->removeFriend($friend);

        return back();
    }
}
