<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Comment extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['name', 'comment', 'user_id', 'product_id'];

    public function user()
    {
        return $this->belongsTo(Users::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
