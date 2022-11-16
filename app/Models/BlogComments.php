<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogComments extends Model
{
    use HasFactory;

    protected $table = 'blog_comments';
    protected $fillable = [
        'blog_id',
        'email',
        'name',
        'client_ip_address'
    ];

    
}
