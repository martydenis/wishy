<?php

use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/{any}', [App\Http\Controllers\AppController::class, 'index'])
  ->where('any', '.*')
  ->name('app');

Route::get('/users', function () {
  $user = User::factory()->create();
});

Route::get('/wishlists', function () {
  $wishlist = Wishlist::factory(10)->create();
});