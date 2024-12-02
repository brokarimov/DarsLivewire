<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    protected $fillable = [
        'post_id',
        'comment_id',

    ];
    public function comments()
    {
        return $this->belongsTo(Comment::class);
    }

    public function posts()
    {
        return $this->belongsTo(Post::class);
    }
}
