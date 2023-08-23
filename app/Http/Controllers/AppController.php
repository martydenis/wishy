<?php

namespace App\Http\Controllers;

class AppController extends Controller
{
    //
    public function index()
    {
        $initial_data = $this->getInitialData();

        return view('app', compact('initial_data'));
    }

    // 
    protected function getInitialData()
    {
        $user = auth()->user();
        $initial_data = [];

        if ($user != null) {
            $initial_data = [
                'user_wishlists' => $user->wishlists,
                'friends' => [
                    'accepted' => $user->getFriends(),
                    'pending' => $user->getPendingInvites(),
                ]
            ];
        }

        return $initial_data;
    }
}
