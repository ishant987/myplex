<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AdminModel;
class BlogModel extends Model
{
    use HasFactory,SoftDeletes;
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
        'updated_id',
        'sub_category',
        'sub_heading',
        'unique_url',
    ];

    public function creator(){
        return $this->hasOne('App\Models\AdminModel','admin_id','created_by');
    }

    public function comments(){

        return $this->hasMany('App\Models\BlogComments', 'blog_id', 'id');

    }
    
}
