<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'province',
        'district',
        'commune',
        'hamlet',
        'total_price',
        'payment_method',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(Users::class);
    }
}
