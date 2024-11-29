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
    ];
    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}