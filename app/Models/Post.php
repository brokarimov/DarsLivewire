<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'description',
        'text',
        'category_id',
        'photo',
    ];
    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function postComments()
    {
        return $this->belongsToMany(Comment::class, 'post_comments', 'post_id', 'comment_id');
    }

    public function likeordislikes()
    {
        return $this->hasMany(LikeOrDislike::class, 'post_id');
    }
    public function views()
    {
        return $this->hasMany(View::class, 'post_id');
    }
}
