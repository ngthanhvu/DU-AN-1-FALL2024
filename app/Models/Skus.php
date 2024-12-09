<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Skus extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'skus';

    protected $fillable = ['product_id', 'sku_code', 'size', 'stock', 'price'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
