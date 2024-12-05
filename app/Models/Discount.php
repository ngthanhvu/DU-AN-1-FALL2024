<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Discount extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $table = 'discounts';
    protected $fillable = [
        'code',
        'value',
        'type',
        'expires_at',
        'usage_limit',
        'used_count'
    ];

    protected $guarded = [];
    protected $casts = [
        'expires_at' => 'datetime',
    ];
    public function incrementUsedCount()
    {
        $this->increment('used_count');
    }
    public function calculateDiscountValue($totalAmount)
    {
        if ($this->type === 'percentage') {
            return ($totalAmount * ($this->value / 100));
        } else {
            return $this->value;
        }
    }
    public function isExpired()
    {
        return $this->expires_at && $this->expires_at <= now();
    }
    public function hasUsageLimitExceeded()
    {
        return $this->usage_limit && $this->used_count >= $this->usage_limit;
    }
}
