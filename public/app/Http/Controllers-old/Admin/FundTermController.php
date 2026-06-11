<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;

use App\Lib\Admin\App;

use App\Models\FundTerm;

class FundTermController extends BaseController
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
        $dataListModel = FundTerm::list();

        $coreObj = new App();
        $listDataAtrArr = $coreObj->getListDataAtr();

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.fundterm.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.fundterm.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.fundterm.delete')];
        
        return view('themes.backend.pages.fundterm.index', compact('dataListModel', 'listDataAtrArr', 'roleRights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('themes.backend.pages.fundterm.createform');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');

        $message = __('message');
        $admin = __('admin');

        $loginAdminId = self::getLoggedInAdminId();

        $validator = Validator::make($request->all(), [
            'term' => 'required|unique:fund_term',
            'days' => 'required|numeric'
        ], []);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->except('_token', 'submit'); 

            $store = new FundTerm($input);

            $store->created_id = $loginAdminId;
            $store->updated_id = $loginAdminId;
            $store->save();
        } catch (QueryException $exception) {
            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            }
            else{
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
            }
        }
        return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['add'])->with('title', $admin['success_ttl']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataArr = FundTerm::find($id);
        
        $editDataAtrArr = ["title"=>__('fundterm.edit_txt'), "route" => 'fundterm.edit'];
        
        return view('themes.backend.pages.fundterm.updateform', compact('dataArr', 'editDataAtrArr'));
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
        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');

        $message = __('message');
        $admin = __('admin');

        $loginAdminId = self::getLoggedInAdminId();

        $validator = Validator::make($request->all(), [
            'term' => 'required|unique:fund_term,term,' . $id . ',ftm_id',
            'days' => 'required|numeric'
        ], []);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->except('_method', '_token', 'submit'); 

            $store = FundTerm::find($id);

            foreach ($input as $key => $value) 
            {
                $store->$key = trim($value);
            }
            $store->updated_id = $loginAdminId;
            $store->save();
        } catch (QueryException $exception) {
            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            }
            else{
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['update'])->with('title', $admin['error_ttl']);
            }
        }
        return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['update'])->with('title', $admin['success_ttl']);
    }

    public function deleteData(Request $request)
    {
        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');

        $message = __('message');
        $admin = __('admin');

        $loginAdminId = self::getLoggedInAdminId();
        try {
            $checkboxArr = $request->get('checkbox');
            if(count($checkboxArr)>0)
            {
                FundTerm::whereIn('ftm_id', $checkboxArr)->delete();
            }
        } catch (QueryException $exception) {
            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            }
            else{
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['delete'])->with('title', $admin['error_ttl']);
            }
        }
        return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['delete'])->with('title', $admin['success_ttl']);
    }
}
