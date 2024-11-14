<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skus extends Model
{
    use HasFactory;

    protected $table = 'skus';

    protected $fillable = ['product_id', 'sku_code', 'size', 'color', 'stock'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
