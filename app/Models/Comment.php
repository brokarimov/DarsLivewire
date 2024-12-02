<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'parent_id',
        'comment',
        'post_id'
    ];

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function postComments()
    {
        return $this->belongsToMany(Post::class, 'post_comments', 'comment_id', 'post_id');
    }
}
