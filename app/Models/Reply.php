<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'review_id',
        'reply',
    ];

    // Quan hệ với model Review
    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    // Quan hệ với model User
    public function user()
    {
        return $this->belongsTo(Users::class);
    }
}
