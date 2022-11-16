<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogModel;

class BlogController extends Controller
{

    public function __construct(){
        $this->page_path =env('PAGE_PATHS','web.pages');
        $this->ImagePath = url('/').'/'. Config('commonconstants.blog_dir_name_front_end');
        $this->selectCoulums =['unique_url','author','created_at','image_banner','description','heading','sub_category','sub_heading','image_thumb'];
    }
    

    public function getBlogs(){

        $data =SELF::getdata();
        
        return view($this->page_path.'.blog.index', ['data'=>$data,'ImagePath'=>$this->ImagePath]);
        
    }

    public function getBlogDetails($uniqueUrl){

        $blog_details = BlogModel::where('unique_url', $uniqueUrl)->first()->toArray();
        $data =SELF::getdata();
        
        return view($this->page_path.'.blog.blog-details',  ['blog_details'=>$blog_details,'ImagePath'=>$this->ImagePath,'data'=>$data,]);

    }
    private function getData(){
        $blogs = BlogModel::where('status', 1)
                            ->orderBy('updated_at','desc')
                            ->get($this->selectCoulums)
                            ->toArray();
        $data = [];
        foreach ($blogs as $key => $value) {
            if(!isset($data[$value['sub_category']])) $data[$value['sub_category']] = [];
            array_push($data[$value['sub_category']], $value);
        }
        return $data;
    }
    
    
}
