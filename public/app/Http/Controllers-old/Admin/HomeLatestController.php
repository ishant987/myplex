<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\LatestFromPlexus;
use App\Http\Requests\admin\AdsCreate;
use App\Models\BlogModel;
use App\Lib\Core\Core;
use App\Lib\Admin\App;
class HomeLatestController extends BaseController
{
    public function __construct()
    {
         
         $classNameArr = explode('\\', __CLASS__);
         $this->className = end($classNameArr);
        //  $this->admin = self::getLoggedInAdminId();
    }
    function index(){
        $data = LatestFromPlexus::with('creator')->orderBy('created_at','desc')->get();
          $coreObj = new App();
          $listDataAtrArr = $coreObj->getListDataAtr();
          $statusAtrArr = $coreObj->getStatusLblTyp2Atr();
          $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.blog.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.blog.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.blog.delete')];

        return view("themes.backend.pages.latest.index", compact('data', 'statusAtrArr', 'listDataAtrArr','roleRights'));
    }
    public function create(AdsCreate $request){
        LatestFromPlexus::create([
            'heading'=>$request->input('heading'),
            'sub_heading'=>$request->input('sub_heading'),
            'link'=>$request->input('link'),
            'created_by'=>1,
        ]);
        return response()->json(['message'=>'Sucessfully created'],200);
    }
}
