<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Post extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'title',
        'content',
        'image',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class);
    }

    /**
     * Check if the title exists (excluding a specific post ID if provided)
     */
    public static function titleExists($title, $excludeId = null)
    {
        $query = self::where('title', $title);

        if ($excludeId) {
            // Exclude the post with this ID (useful for updating)
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
