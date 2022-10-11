<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\admin\blogCreate;
use Illuminate\Support\Facades\Auth;
use App\Models\BlogModel;
use App\Models\MediaModel;
use Validator;
use App\Lib\Core\Core;
use App\Lib\Admin\App;
use Illuminate\Database\QueryException;

class BlogController extends BaseController
{

     public function __construct()
     {

          $this->admin = Auth::guard('admin')->user();
     }

     public function index()
     {

          $blogs = BlogModel::get()->toArray();
          $coreObj = new App();
          $listDataAtrArr = $coreObj->getListDataAtr();
          $statusAtrArr = $coreObj->getStatusLblTyp2Atr();
          return view("themes.backend.pages.blog.index", compact('blogs', 'statusAtrArr', 'listDataAtrArr'));
     }

     public function create()
     {
          $adminID = Auth::guard('admin')->user()->admin_id;
          $data = ['adminID' => $adminID];
          $firstName = Auth::guard('admin')->user()['first_name'];
          return view("themes.backend.pages.blog.create", compact('data', 'firstName'));
     }

     public function edit($id)
     {

          $blog = BlogModel::findOrFail($id);

          $coreObj = new App();
          $listDataAtrArr = $coreObj->getListDataAtr();
          $statusAtrArr = $coreObj->getStatusLblTyp2Atr();


          return view("themes.backend.pages.blog.update", compact('blog'));
     }

     private function cleanUrl($string)
     {
          $str_url = strtolower(preg_replace('/-+/', '-', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $string))));
          if ($str_url == '-') {
               return uniqid(6) . uniqid(3);
          }
          return $str_url;
     }


     public function store(Request $request, $id = '')
     {
          $params = $request->input();
          $isActivated = $params['is_active'] == '1' ? 1 : null;
          $curTime = new \DateTime();
          $published_time = $curTime->format("Y-m-d H:i:s");
          $params['published_by'] = $isActivated;
          $params['published_date'] = !is_null($isActivated) ? $published_time : null;
          $params['created_by'] = Auth::guard('admin')->user()['first_name'];
          $params['heading'] = SELF::cleanUrl($params['heading']);
          $params['image_thumb'] = SELF::fileUpload($request->file('image_thumb'));
          $params['image_banner'] = SELF::fileUpload($request->file('image_banner'));


          BlogModel::updateOrCreate(
               [
                    //  check data with the existing db data (e.g) id
                    'id' => $id,
               ],

               $params

          );

          return redirect(route('admin.blog.index'));
     }

     private function fileUpload($file)
     {

          $upldDirName = Config('commonconstants.blog_dir_name');
          $title     = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
          $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
          $filename  = time() . '-' . Core::removeSpecialChars($title) . '.' . $extension;
          $path      = $file->storeAs($upldDirName, $filename);
          return $filename;
     }

     public function delete(Request $request){

          
        $loginAdminId = self::getLoggedInAdminId();
        $commonconstants = Config('commonconstants');
        try {
             $checkboxArr = $request->get('checkbox');
             if (count($checkboxArr)) {
                  BlogModel::whereIn('id', $checkboxArr)->delete();
            }
        } catch (QueryException $exception) {
            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            } else {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.delete'))->with('title', __('admin.error_ttl'));
            }
        }

        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.delete'))->with('title', __('admin.success_ttl'));
          
     }
     
     
}
