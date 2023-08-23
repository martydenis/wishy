<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wish extends Model
{
    use HasFactory;

    protected $table = 'wishes';

    protected $fillable = [
        'wishlist_id',
        'name',
        'description',
        'url',
        'checked',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the user that owns the wishlist.
     */
    public function wishlist() : BelongsTo
    {
        return $this->belongsTo(Wishlist::class);
    }
}
