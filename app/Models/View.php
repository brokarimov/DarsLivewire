<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = [
        'post_id',
        'user_ip',
    ];

    public function posts()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
