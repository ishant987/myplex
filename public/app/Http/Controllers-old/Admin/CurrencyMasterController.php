<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

use Validator;
use Carbon\Carbon;

use App\Lib\Admin\App;

use App\Models\CurrencyMaster;
use App\Models\CurrencyCor;
use App\Models\CurrencyDetail;

class CurrencyMasterController extends BaseController
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
        $dataListModel = CurrencyMaster::list();

        $coreObj = new App();
        $listDataAtrArr = $coreObj->getListDataAtr();
        $statusAtrArr = $coreObj->getStatusLblTyp2Atr();

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.currency.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.currency.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.currency.delete')];
        
        return view('themes.backend.pages.currency.index', compact('dataListModel', 'listDataAtrArr', 'roleRights', 'statusAtrArr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statusArr = App::getStatusLblTyp2Arr();
        return view('themes.backend.pages.currency.createform', compact('statusArr'));
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
            'name' => 'required',
            'currency_url' => 'required|url',
            'status' => 'required|integer'
        ], [
            'name.required' => __('admin.currency.validation.required.name_txt')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

           
        DB::beginTransaction();

        try {
            $input = $request->except('_token', 'submit', 'currency_url'); 

            //dd($input);

            $store = new CurrencyMaster($input);
            //$store->is_comodity = $request->input('is_comodity');
            $store->created_id = $loginAdminId;
            $store->updated_id = $loginAdminId;
            if($store->save()){
                $date = new Carbon();
                $dateFormatted = $date->format($commonconstants['db_dt_tm_frmt']);

                $store2 = [];
                $store2['cm_id'] = $store->cm_id;
                $store2['cor'] = $request->input('currency_url');
                $store2['created_id'] = $loginAdminId;
                $store2['updated_id'] = $loginAdminId;
                $store2['created_at'] = $dateFormatted;
                $store2['updated_at'] = $dateFormatted;
                $totInsrt = CurrencyCor::insert($store2);
                if ($totInsrt == 0) {
                    DB::rollBack();

                    return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
                }

                DB::commit();
                
                return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['add'])->with('title', $admin['success_ttl']);
            }
        } catch (QueryException $exception) {
            dd($exception->getMessage());
            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            }
            else{
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataArr = CurrencyMaster::find($id);
        $statusArr = App::getStatusLblTyp2Arr();
        
        $editDataAtrArr = ["title"=>__('admin.currency.edit_txt'), "route" => 'currency.edit'];
        
        return view('themes.backend.pages.currency.updateform', compact('dataArr', 'editDataAtrArr', 'statusArr'));
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
            'name' => 'required',
            'currency_url' => 'required|url',
            'status' => 'required|integer'
        ], [
            'name.required' => __('admin.currency.validation.required.name_txt')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $input = $request->except('_method', '_token', 'submit', 'currency_url'); 

            $store = CurrencyMaster::find($id);

            foreach ($input as $key => $value) 
            {
                $store->$key = trim($value);
            }
            $store->updated_id = $loginAdminId;
            if($store->save()){
                $date = new Carbon();
                $dateFormatted = $date->format($commonconstants['db_dt_tm_frmt']);
                
                $store2 = [];
                $store2['cor'] = $request->input('currency_url');
                $store2['updated_id'] = $loginAdminId;
                $store2['updated_at'] = $dateFormatted;
                $totUpdt = CurrencyCor::where('cm_id', $id)->update($store2);
                if ($totUpdt == 0) {
                    DB::rollBack();
                    return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['update'])->with('title', $admin['error_ttl']);
                }

                DB::commit();
                return redirect()->route('admin.currency.index')->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['update'])->with('title', $admin['success_ttl']);
            }
        } catch (QueryException $exception) {
            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            }
            else{
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['update'])->with('title', $admin['error_ttl']);
            }
        }
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
                DB::beginTransaction();
                $delModel = CurrencyMaster::whereIn('cm_id', $checkboxArr)->delete();
                if($delModel > 0){
                    $delModel2 = CurrencyCor::whereIn('cm_id', $checkboxArr)->delete();
                    if($delModel2 > 0){
                        CurrencyDetail::whereIn('cm_id', $checkboxArr)->delete();
                        DB::commit();
                        return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['delete'])->with('title', $admin['success_ttl']);
                    }
                    else{
                        DB::rollBack();
                        return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['delete'])->with('title', $admin['error_ttl']);
                    }
                }
            }
        } catch (QueryException $exception) {
            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            }
            else{
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['delete'])->with('title', $admin['error_ttl']);
            }
        }
    }
}
