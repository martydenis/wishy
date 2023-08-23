<?php

namespace App\Http\Controllers;

use App\Models\Share;
use App\Models\User;
use Illuminate\Http\Request;

class ShareController extends Controller
{

    // public function create(Request $request)
    // {
        
    // }

    public function destroy(Share $share)
    {
        return $share->delete();
    }
}
