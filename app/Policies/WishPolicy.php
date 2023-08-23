<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Wish;

class WishPolicy
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
    // public function view(User $user, Wish $wish): bool
    // {
    //     return;
    // }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Wish $wish): bool
    {
        $wishlist = $wish->wishlist;
        return $user->id === $wishlist->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Wish $wish): bool
    {
        $wishlist = $wish->wishlist;
        return WishlistPolicy::view($user, $wishlist);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Wish $wish): bool
    {
        return $this->create($user, $wish);
    }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(User $user, Wish $wish): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can permanently delete the model.
     */
    // public function forceDelete(User $user, Wish $wish): bool
    // {
    //     //
    // }
}
