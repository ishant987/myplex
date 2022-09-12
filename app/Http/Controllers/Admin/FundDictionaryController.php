<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;

use App\Lib\Admin\App;

use App\Models\FundDictionary;

class FundDictionaryController extends BaseController
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
        $dataListModel = FundDictionary::list();
        $coreObj = new App();
        $listDataAtrArr = $coreObj->getListDataAtr();
        $statusAtrArr = $coreObj->getStatusLblTyp2Atr();

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.fund-dictionary.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.fund-dictionary.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.fund-dictionary.delete')];
        
        return view('themes.backend.pages.funddictionary.index', compact('dataListModel', 'listDataAtrArr', 'statusAtrArr', 'roleRights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $statusArr = App::getStatusLblTyp2Arr();

        return view('themes.backend.pages.funddictionary.createform', compact('statusArr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'status' => 'required|integer'
        ], []);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->except('_token', 'submit'); 

            $store = new FundDictionary($input);

            $store->updated_id = $loginAdminId;

            $store->save();
        } catch (QueryException $exception) {
            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            }
            else{
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.data_saved'))->with('title', __('admin.error_ttl'));
            }
        }

        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.add'))->with('title', __('admin.success_ttl'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataArr = FundDictionary::find($id);

        $statusArr = App::getStatusLblTyp2Arr();

        $editDataAtrArr = ["title"=>__('admin.funddictionary.edit_txt'), "route"=>'funddictionary.edit'];
        
        return view('themes.backend.pages.funddictionary.updateform', compact('dataArr', 'statusArr', 'editDataAtrArr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'status' => 'required|integer'
        ], []);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $store = FundDictionary::find($id);

            $input = $request->except('_method', '_token', 'submit'); 

            foreach ($input as $key => $value) {
                $store->$key = trim($value);
            }

            $store->updated_id = $loginAdminId;
            $store->save();
        } catch (QueryException $exception) {
            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            }
            else{
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.update'))->with('title', __('admin.error_ttl'));
            }
        }

        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.update'))->with('title', __('admin.success_ttl'));
    }

    public function deletedata(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();
        $commonconstants = Config('commonconstants');
        try {
            $checkboxArr = $request->get('checkbox');
            if(count($checkboxArr)>0)
            {
                FundDictionary::whereIn('fd_id', $checkboxArr)->delete();
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
