<?php

namespace App\Http\Controllers;

use App\Http\Requests\WishlistRequest;
use App\Http\Requests\WishRequest;
use App\Models\Share;
use App\Models\Wishlist;
use App\Models\Wish;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{

    public function show(Wishlist $wishlist)
    {
        $this->authorize('view', $wishlist);

        return $wishlist->loadFullDetails();
    }

    static public function getFriendsWishlists()
    {
        $user = auth()->user();

        $wishlists = collect([]);
        foreach ($user->getFriends() as $friend) {
            foreach ($friend->wishlists as $wishlist) {
                if (Gate::forUser($user)->allows('view', $wishlist)) {
                    $wishlists->push($wishlist);
                }
            }
        }

        return $wishlists->sortByDesc('created_at')->values();
    }

    public function store(WishlistRequest $request)
    {
        $wishes = $this->validateWishes($request->wishes);

        if (!empty($wishes['errors'])) {
            return $wishes['errors'];
        }


        $userId = auth()->user()->id;
        $wishlist = new Wishlist();
        $wishlist->name = $request->name;
        $wishlist->description = $request->description;
        $wishlist->privacy = (int)$request->privacy;
        $wishlist->user_id = $userId;
        $wishlist->save();

        $friendIds = collect($request->friends_shared_with)->pluck('id')->toArray();
        $shares = [];
        foreach ($friendIds as $friendId) {
            $share = new Share();
            $share->friend_id = $friendId;
            $share->user_id = $userId;
            $shares[] = $share;
        }

        $wishlist->shares()->saveMany($shares);
        $wishlist->wishes()->saveMany($wishes);

        return $wishlist->loadFullDetails();
    }

    public function update(WishlistRequest $request, Wishlist $wishlist)
    {
        $this->authorize('update', $wishlist);

        $wishes = $this->validateWishes($request->wishes);
        if (!is_array($wishes)) {
            return $wishes;
        }

        $wishlist->name = $request->name;
        $wishlist->description = $request->description;
        $wishlist->privacy = (int)$request->privacy;

        $userId = auth()->user()->id;
        $friendIds = collect($request->friends_shared_with)->pluck('id')->toArray();
        $existingShares = $wishlist->shares->pluck('friend_id')->toArray();

        // Add new shares
        $sharesToAdd = array_diff($friendIds, $existingShares);
        foreach ($sharesToAdd as $friendId) {
            $share = new Share();
            $share->friend_id = $friendId;
            $share->user_id = $userId;
            $wishlist->shares()->save($share);
        }

        // Remove shares that are no longer in the request
        $sharesToRemove = array_diff($existingShares, $friendIds);
        $wishlist->shares()->whereIn('friend_id', $sharesToRemove)->delete();

        $wishIdsInRequest = array_column($wishes, 'id');
        $wishlist->wishes()->whereNotIn('id', $wishIdsInRequest)->delete();
        $wishlist->wishes()->saveMany($wishes);

        $wishlist->save();

        return $wishlist->loadFullDetails();
    }

    // public function togglePrivacy(Wishlist $wishlist)
    // {
    //     $this->authorize('update', $wishlist);

    //     $wishlist->privacy = !$wishlist->privacy;
    //     $wishlist->save();

    //     return $wishlist;
    // }

    public function destroy(Wishlist $wishlist)
    {
        $this->authorize('delete', $wishlist);

        return $wishlist->delete();
    }

    protected function validateWishes($wishes)
    {
        $result = [];
        $errors = [];

        foreach ($wishes as $i => $wish) {
            $wishValidator = Validator::make($wish, (new WishRequest())->rules());

            if ($wishValidator->fails()) {
                $errors['wishes'][$i] = $wishValidator->errors();
            } else {
                $result[] = new Wish($wishValidator->validated());
            }
        }

        if (!empty($errors)) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $errors,
            ], 422);
        }

        return $result;
    }
}
