<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Wishlist;

class WishlistPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    // public function viewAny(User $user): bool
    // {
    //     //
    //     return true;
    // }

    /**
     * Determine whether the user can view the model.
     */
    public static function view(User $user, Wishlist $wishlist): bool
    {
        if ($wishlist->privacy == 2 || $user->id === $wishlist->user_id) {
            return true;
        }

        $friendsIds = $wishlist->shares()->pluck('friend_id');
        if ($wishlist->privacy == 1 && $friendsIds->contains($user->id)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    // public function create(User $user): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Wishlist $wishlist): bool
    {
        return $user->id === $wishlist->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Wishlist $wishlist): bool
    {
        return $this->update($user, $wishlist);
    }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(User $user, Wishlist $wishlist): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can permanently delete the model.
     */
    // public function forceDelete(User $user, Wishlist $wishlist): bool
    // {
    //     //
    // }
}
