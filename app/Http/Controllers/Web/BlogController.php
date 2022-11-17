<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogModel;
use App\Models\PageModel;

class BlogController extends BaseController
{

    public function __construct()
    {
        $this->page_path = env('PAGE_PATHS', 'web.pages');
        $this->ImagePath = url('/') . '/' . Config('commonconstants.blog_dir_name_front_end');
        $this->selectCoulums = ['unique_url', 'author', 'created_at', 'image_banner', 'description', 'heading', 'sub_category', 'sub_heading', 'image_thumb'];
        $this->specificBlogLength = ["must_read" => 6, "highlighted_posts" => 5, "editors_pick" => 3];
    }


    public function getBlogs(Request $request)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 49);
        $dataArr['full_url'] = $request->fullUrl();

        $meta_title = $dataArr['meta_title'];
        $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
        $meta_descp = $dataArr['meta_descp'];
        $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

        $dataArr['aet_id'] = 0;
        $dataArr['parent'] = 0;
        $data = SELF::getdata();

        return view($this->page_path . '.blog.index', ['data' => $data, 'ImagePath' => $this->ImagePath, 'dataArr' => $dataArr]);
    }

    public function getBlogDetails($uniqueUrl)
    {

        $blog_details = BlogModel::where('unique_url', $uniqueUrl)->first()->toArray();
        $data = SELF::getdata();
        return view($this->page_path . '.blog.blog-details',  ['blog_details' => $blog_details, 'ImagePath' => $this->ImagePath, 'data' => $data,]);
    }
    protected function getData()
    {
        $blogs = BlogModel::where('status', 1)
            ->orderBy('updated_at', 'desc')
            ->get($this->selectCoulums)
            ->toArray();
        $data = [];
        foreach ($blogs as $key => $value) {
            if (!isset($data[$value['sub_category']])) $data[$value['sub_category']] = [];
            if (count($data[$value['sub_category']]) < $this->specificBlogLength[$value['sub_category']]) array_push($data[$value['sub_category']], $value);
        }
        return $data;
    }
}
