<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogModel;

class BlogController extends Controller
{

    public function __construct(){
        $this->page_path =env('PAGE_PATHS','web.pages');
    }
    

    public function getBlogs(){

        
        $upldDirName = Config('commonconstants.blog_dir_name');

        $blogs = BlogModel::where('status', 1)->get(['author','created_at','image_banner','description','heading','sub_category','sub_heading'])->toArray();
        $data = [];
        foreach ($blogs as $key => $value) {
            if(!isset($data[$value['sub_category']])) $data[$value['sub_category']] = [];
            array_push($data[$value['sub_category']], $value);
        }

        return view($this->page_path.'.blog.index', compact('data'));
        
    }

    public function getBlogDetails($uniqueUrl){

        $blog_details = BlogModel::where('unique_url', $uniqueUrl)->first()->toArray();

        
        return view($this->page_path.'.blog.blog-details', compact('blog_details'));

    }
    
    
}
