<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LikeOrDislike extends Model
{
    protected $fillable = [
        'post_id',
        'user_ip',
        'value',
    ];

    public function posts()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
