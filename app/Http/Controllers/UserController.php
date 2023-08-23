<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function destroy(Request $request)
    {
        return $request->user()->delete();
    }

    public function getFriends(Request $request)
    {

        return [
            'accepted' => $request->user()->getFriends(),
            'pending' => $request->user()->getPendingInvites(),
        ];
    }
}
