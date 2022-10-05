<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogModel extends Model
{
    use HasFactory;
    protected $table = 'blog';
    protected $fillable = [
        'category',
        'heading',
        'description',
        'url',
        'author',
        'image_banner',
        'image_thumb',
        'created_by',
        'published_by',
        'published_date',
        'is_active',
        'tags',
    ];
}
