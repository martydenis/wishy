<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'wishlist_id',
        'name',
        'description'
    ];

    /**
     * Get the user that owns the wishlist.
     */
    public function wishlist() : BelongsTo
    {
        return $this->belongsTo(Wishlist::class);
    }
}
