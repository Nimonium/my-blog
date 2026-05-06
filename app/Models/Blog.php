<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'slug', 
        'category_id', 
        'short_description', 
        'content', 
        'image_path'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
