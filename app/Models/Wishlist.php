<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'privacy',
        'name',
        'description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the user that owns the wishlist.
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the wishes of the wishlist
     */
    public function wishes() : HasMany
    {
        return $this->hasMany(Wish::class);
    }

    /**
     * Get the share linked to the wishlist
     */
    public function shares() : HasMany
    {
        return $this->hasMany(Share::class);
    }

    /**
     * Get the friends linked to the shares
     */
    public function friendsSharedWith()
    {
        $shares = $this->shares;
        $friends = $this->user->getFriends();

        $valid_friends = [];
        foreach ($shares as $share) {
            $friend = $friends->firstWhere('id', $share->friend_id);

            if ($friend) {
                $valid_friends[] = $friend;
            }
        }

        return $valid_friends;
    }

    public function loadFullDetails()
    {
        $this->load([
            'wishes',
            'user' => function($query) {
                $query->select('id', 'name');
            },
        ]);

        $this->created_at_formatted = $this->getCreatedAtFormattedAttribute();
        $this->friends_shared_with = $this->friendsSharedWith();
        $this->wishes_total_count = $this->wishes()->count();
        $this->wishes_checked_count = $this->checkedWishes()->count();

        return $this;
    }

    public function getCreatedAtFormattedAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d/m/Y');
    }

    /**
     * Get the checked wishes of the wishlist
     */
    public function checkedWishes() : HasMany
    {
        return $this->hasMany(Wish::class)->where('checked', 1);
    }
}
