<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Review extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'user_id',
        'product_id',
        'review',
        'image_path',
        'likes',
        'rating'
    ];
    protected $casts = [
        'replies' => 'array',
    ];
    
 
    public function user()
    {
        return $this->belongsTo(Users::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
