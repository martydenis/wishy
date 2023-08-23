<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'friend_id',
        'status'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // Define the 'belongsTo' relationship with the 'User' model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define the 'belongsTo' relationship with the 'User' model for the friend
    public function friend()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }
}
