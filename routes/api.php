<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\WishController;
use App\Http\Controllers\FriendshipController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * Private routes
 */

// Authentication
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->post('/logout', [AuthenticatedSessionController::class, 'destroy']);
Route::middleware('auth:sanctum')->delete('/delete-account', [UserController::class, 'destroy']);
Route::middleware('auth:sanctum')->get('/home', [AppController::class, 'getInitialData']);
Route::middleware('auth:sanctum')->get('/friends', [UserController::class, 'getFriends']);

// Wishlists
Route::middleware('auth:sanctum')->post('/wishlists/create', [WishlistController::class, 'store']);
Route::middleware('auth:sanctum')->post('/wishlists/{wishlist}/edit', [WishlistController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/wishlists/{wishlist}', [WishlistController::class, 'destroy']);
// Route::middleware('auth:sanctum')->post('/wishlists/{wishlist}/toggle-privacy', [WishlistController::class, 'togglePrivacy']);
// Route::middleware('auth:sanctum')->get('/home', [AppController::class, 'getInitialData']);

// Wishes
Route::middleware('auth:sanctum')->get('/wishes/{wish}', [WishController::class, 'show']);
Route::middleware('auth:sanctum')->post('/wishes/store-or-update', [WishController::class, 'storeOrUpdate']);
Route::middleware('auth:sanctum')->post('/wishes/{wish}/toggle-check', [WishController::class, 'toggleCheck']);
Route::middleware('auth:sanctum')->delete('/wishes/{wish}', [WishController::class, 'destroy']);

// Friendships
Route::middleware('auth:sanctum')->get('/friends/{friendship}', [FriendshipController::class, 'show']);
Route::middleware('auth:sanctum')->post('/friend-request', [FriendshipController::class, 'createFriendship']);
Route::middleware('auth:sanctum')->post('/friend-request/{friendship}/accept', [FriendshipController::class, 'acceptRequest']);
Route::middleware('auth:sanctum')->post('/friend-request/{friendship}/reject', [FriendshipController::class, 'rejectRequest']);
Route::middleware('auth:sanctum')->delete('/friends/{friendship}', [FriendshipController::class, 'destroy']);


/**
 * Public routes
 */

// Authentication
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
// Wishlists
Route::get('/wishlists', [WishlistController::class, 'getFriendsWishlists']);
Route::get('/wishlists/{wishlist}', [WishlistController::class, 'show']);
