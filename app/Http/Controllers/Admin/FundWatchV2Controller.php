<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;
use Storage;
use App\Http\Requests\admin\FundWatch as fwRequest;
use App\Lib\Core\Core;
use App\Lib\Admin\App;

use App\Models\FundWatch;
use App\Models\FundMaster;
use App\Models\FundWatchNew;
class FundWatchV2Controller extends BaseController
{
    public $className;

    public function __construct(){
        $classNameArr = explode('\\', __CLASS__);
        $this->className = end($classNameArr);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataListModel = FundWatchNew::with('fundDetails')->get();
        $coreObj = new App();
        $listDataAtrArr = $coreObj->getListDataAtr();
        $statusAtrArr = $coreObj->getStatusLblTyp2Atr();

        $fldsHide = __('admin.fundwatch.flds_hide');
        $boolFalse = Config('commonconstants.bool_false');

        $moduleAtrArr = FundWatch::getModuleVars();

        // $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.fund-watch.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.fund-watch.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.fund-watch.delete')];
        $roleRights = ['add' => true, 'edit' => false, 'delete' => true];
        
        return view('themes.backend.pages.fundwatch.list', compact('dataListModel', 'listDataAtrArr', 'moduleAtrArr', 'statusAtrArr', 'roleRights', 'fldsHide', 'boolFalse'));
    }
     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $statusArr = App::getStatusLblTyp2Arr();
        $fundMaster = FundMaster::where('status',1)->get();
        $fldsHide = __('admin.fundwatch.flds_hide');
        $boolFalse = Config('commonconstants.bool_false');

        return view('themes.backend.pages.fundwatch.create', compact('statusArr', 'fldsHide', 'boolFalse','fundMaster'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(fwRequest $request)
    {
        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');

        $path = '';

        try {
            $input = $request->except('_token', 'submit'); 
            $store = new FundWatchNew($input);
            
            // $fldsHide = __('admin.fundwatch.flds_hide');
            // $boolFalse = $commonconstants['bool_false'];
            // if( $fldsHide['c_order'] == $boolFalse ){
            //     $c_order = intval($input['c_order']);
            //     $store->c_order = $c_order > 0 ? $c_order : 0;
            // }

            $store->updated_id = $loginAdminId;

            $store->save();
        } catch (QueryException $exception) {
            if(isset($path) && $path){
                $exists = Storage::exists($path);
                if($exists){
                    Storage::delete($path);
                }
            }

            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            }
            else{
                // return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.data_saved'))->with('title', __('admin.error_ttl'));
            }
        }

        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.add'))->with('title', __('admin.success_ttl'));
    }
    public function deletedata(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();
        $commonconstants = Config('commonconstants');
        try {
            $checkboxArr = $request->get('checkbox');
            if(count($checkboxArr)>0)
            {
                $dataArr = FundWatchNew::whereIn('id', $checkboxArr)->get();
                $delModel = FundWatchNew::whereIn('id', $checkboxArr)->delete();
               
            }
        } catch (QueryException $exception) {
            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            }
            else{
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.delete'))->with('title', __('admin.error_ttl'));
            }
        }
        
        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.delete'))->with('title', __('admin.success_ttl'));
    }
}
