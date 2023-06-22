<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    //
    public function index() {
        $wishlists = \App\Models\Wishlist::all();

        // $wishlist->name = 'My first wishlist';
        // $wishlist->description = 'Little description';
        // $wishlist->owner_id = 1;
        // $wishlist->save();
        // dd($wishlist);

        return view('app', compact('wishlists'));
    }
}
