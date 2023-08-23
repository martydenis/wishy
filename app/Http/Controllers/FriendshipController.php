<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FriendshipController extends Controller
{

    public function createFriendship(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email', // The email field is required and must be a valid email address
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // If validation fails, you can handle the response accordingly
            throw new ValidationException($validator);
        }

        $email = $request->email;
        $friend = User::where('email', $email)->first();
        $user = $request->user();

        if (!$friend) {
            return response()->json(['message' => 'No user was found using this email address'], Response::HTTP_NOT_FOUND);
        }

        if ($friend->id == $user->id) {
            return response()->json(['message' => 'Please invite other people than yourself'], Response::HTTP_CONFLICT);
        }

        $existingFriendship = $this->getFriendshipBetween($user->id, $friend->id);
        if ($existingFriendship) {
            if ($existingFriendship->status == 'accepted') {
                $message = 'This person is already your friend';
            } else {
                $message = 'This person has already been invited';
            }

            return response()->json(['message' => $message], Response::HTTP_CONFLICT);
        }

        $friendship = new Friendship();
        $friendship->user_id = $request->user()->id;
        $friendship->friend_id = $friend->id;
        $friendship->save();

        return response()->json(['message' => 'A friend request was sent']);
    }

    public function acceptRequest(Friendship $friendship)
    {
        $friendship->status = 'accepted';
        $friendship->save();
    }

    public function rejectRequest(Friendship $friendship)
    {
        $friendship->status = 'rejected';
        $friendship->save();
    }

    public function destroy(Friendship $friendship)
    {
        return $friendship->delete();
    }

    protected function getFriendshipBetween($user_id, $friend_id)
    {
        $existingFriendship = Friendship::where(function ($query) use ($user_id, $friend_id) {
            $query->where('user_id', $user_id)->where('friend_id', $friend_id);
        })->orWhere(function ($query) use ($user_id, $friend_id) {
            $query->where('user_id', $friend_id)->where('friend_id', $user_id);
        })->first();

        return $existingFriendship;
    }
}
