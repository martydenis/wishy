<?php

namespace App\Http\Controllers;

use \App\Models\Wishlist;

class AppController extends Controller
{
    //
    public function index() {
        // $wishlists = Wishlist::all();

        // $wishlist->name = 'My first wishlist';
        // $wishlist->description = 'Little description';
        // $wishlist->owner_id = 1;
        // $wishlist->save();
        // dd($wishlist);

        // return view('app', compact('wishlists'));
        return view('app');
    }
}
