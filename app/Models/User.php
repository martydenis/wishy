<?php

namespace App\Models;

use App\Models\Wishlist;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the wishlists that the user owns.
     */
    public function wishlists() : HasMany
    {
        return $this->hasMany(Wishlist::class)
            ->orderBy('created_at', 'desc')
            ->with([
                'user' => function($query) {
                    $query->select('id', 'name');
                }
            ])
            ->withCount('wishes as wishes_total_count')
            ->withCount(['wishes as wishes_checked_count' => function ($query) {
                $query->where('checked', true);
            }])
            ->addSelect(['created_at_formatted' => Wishlist::select('created_at')
                ->whereColumn('wishlists.id', 'id')
                ->limit(1)
            ]);
    }

    public function friendshipsSent() : HasMany
    {
        return $this->hasMany(Friendship::class, 'user_id');
    }

    public function friendshipsReceived() : HasMany
    {
        return $this->hasMany(Friendship::class, 'friend_id');
    }

    public function getFriends()
    {
        $user_id = $this->id;

        // Retrieve friendship records where the user_id or friend_id matches the current user's ID
        $friendships = Friendship::where(function ($query) use ($user_id) {
                $query->where('user_id', $user_id)
                    ->orWhere('friend_id', $user_id);
            })
            ->orderBy('created_at', 'desc')
            ->where('status', 'accepted')
            ->get();

        $friends = $this->getFriendsFromFriendships($friendships)->sortBy('name')->values();

        return $friends;
    }

    public function getPendingInvites()
    {
        $user_id = $this->id;

        // Retrieve friendship records where the user_id or friend_id matches the current user's ID
        $friendships = Friendship::where('friend_id', $user_id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $friends = $this->getFriendsFromFriendships($friendships);

        return $friends;
    }

    protected function getFriendsFromFriendships($friendships)
    {
        $user_id = $this->id;
        $friendsWithStatus = collect([]);

        foreach ($friendships as $friendship) {
            // Determine the friend's ID based on the friendship record
            $friendId = ($friendship->user_id === $user_id) ? $friendship->friend_id : $friendship->user_id;

            // Retrieve the corresponding friend based on the ID
            $friend = User::find($friendId, ['id', 'name', 'email']);

            // Check if the friend exists
            if ($friend) {
                // Add friendship status details to the friend object
                $friend->friendship_id = $friendship->id;
                $friend->status = $friendship->status;

                // Add the friend to the collection
                $friendsWithStatus->push($friend);
            }
        }

        return $friendsWithStatus;
    }
}
