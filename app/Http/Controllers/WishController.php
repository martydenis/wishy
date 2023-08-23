<?php

namespace App\Http\Controllers;

use App\Http\Requests\WishRequest;
use Illuminate\Http\Request;
use App\Models\Wish;
use App\Models\Wishlist;

class WishController extends Controller
{
    public function show(Wish $wish)
    {
        // $this->authorize('view', $wishlist);

        // $wish->load([
        //     'wishes',
        //     'user' => function($query) {
        //         $query->select('id', 'name');
        //     }
        // ]);

        return $wish;
    }

    public function storeOrUpdate(Wishrequest $request)
    {
        $wish = Wish::firstOrNew(['id' => $request->id]);

        $wish->wishlist_id = $request->wishlist_id;
        $wish->name = $request->name;
        $wish->description = $request->description;
        $wish->url = $request->url;
        $wish->save();

        return $wish;
    }

    public function toggleCheck(Wish $wish)
    {
        $this->authorize('update', $wish);

        $wish->checked = !$wish->checked;
        $wish->save();

        return $wish;
    }

    public function destroy(Wish $wish)
    {
        $this->authorize('delete', $wish);

        return $wish->delete();
    }
}
