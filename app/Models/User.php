<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Pivot\BookUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function books(){
        return $this->belongsToMany(Book::class)
            ->using(BookUser::class)
            ->withPivot('status')
            ->withTimestamps();
    }

    public function getFriendsAttribute(){
        return $this->acceptedFriendsOfMine->merge($this->acceptedFriendsOf);
    }

    public function addFriend(User $friend){
        $this->friendsOfMine()->syncWithoutDetaching($friend, [
            'accepted' => false
        ]);
    }

    public function friendsOfMine(){
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
            ->withPivot('accepted');
    }

    public function friendsOf(){
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id')
            ->withPivot('accepted');
    }

    public function pendingFriendsOfMine(){
        return $this->friendsOfMine()->wherePivot('accepted', false);
    }

    public function acceptedFriendsOf(){
        return $this->friendsOf()->wherePivot('accepted', true);
    }

    public function acceptedFriendsOfMine(){
        return $this->friendsOfMine()->wherePivot('accepted', true);
    }

    public function pendingFriendsOf(){
        return $this->friendsOf()->wherePivot('accepted', false);
    }

    public function acceptFriend(User $friend){
        $friend->friendsOfMine()->updateExistingPivot($this->id, [
            'accepted' => true
        ]);
    }

    public function removeFriend(User $friend){
        $this->friendsOfMine()->detach($friend);
    }
}
