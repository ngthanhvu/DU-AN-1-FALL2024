<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Address extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'address';

    protected $fillable = ['full_name', 'phone', 'tinh_thanh', 'thon_xom', 'xa_phuong', 'quan_huyen', 'user_id'];

    public function users()
    {
        return $this->hasMany(Users::class);
    }
}
