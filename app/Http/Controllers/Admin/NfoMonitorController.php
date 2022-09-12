<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;
use Storage;

use App\Lib\Admin\App;

use App\Models\NfoOffer;

class NfoMonitorController extends BaseController
{
    public $className;

    public function __construct()
    {
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
        $dataListModel = NfoOffer::list();

        $coreObj = new App();
        $listDataAtrArr = $coreObj->getListDataAtr();
        $statusAtrArr = $coreObj->getStatusLblTyp2Atr();

        $moduleAtrArr = NfoOffer::getModuleVars();

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.nfo-monitor.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.nfo-monitor.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.nfo-monitor.delete')];

        return view('themes.backend.pages.nfomonitor.index', compact('dataListModel', 'listDataAtrArr', 'roleRights', 'statusAtrArr', 'moduleAtrArr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $moduleAtrArr = NfoOffer::getModuleVars();
        $statusArr = App::getStatusLblTyp2Arr();

        return view('themes.backend.pages.nfomonitor.createform', compact('statusArr', 'moduleAtrArr'));
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
            'fund_name' => 'required',
            'fund_opening' => 'required',
            'fund_closing' => 'required',
            'ft_id' => 'required',
            'minimum_investment' => 'required',
            'plan' => 'required',
            'options' => 'required',
            'entry_load' => 'required',
            'exit_load' => 'required',
            'thereafter' => 'required',
            'objective' => 'required',
            'idc_id' => 'required',
            'fund_manager' => 'required',
            'aa_col1_value' => 'required',
            'aa_col1_text' => 'required',
            'aa_col2_value' => 'required',
            'aa_col2_text' => 'required',
            'ces_row1_col1_text' => 'required',
            'ces_row1_col2_text' => 'required',
            'ces_row1_col3_text' => 'required',
            'ces_row2_col1_text' => 'required',
            'ces_row2_col2_text' => 'required',
            'ces_row2_col3_text' => 'required',
            'idea_distiller' => 'required',
            'fund_house_aaum' => 'required',
            'fund_manager_experience' => 'required',
            'uniqness' => 'required',
            'return' => 'required',
            'risk' => 'required',
            'operability' => 'required',
            'oomph_factor' => 'required',
            'post_date' => 'required',
            'status' => 'required'
        ], [
            'ft_id.required' => $admin['validation']['required']['ft_id'],
            'idc_id.required' => $admin['validation']['required']['idc_id'],
            'aa_col1_value.required' => $admin['validation']['required']['aa_col1_value'],
            'aa_col1_text.required' => $admin['validation']['required']['aa_col1_text'],
            'aa_col2_value.required' => $admin['validation']['required']['aa_col2_value'],
            'aa_col2_text.required' => $admin['validation']['required']['aa_col2_text'],
            'ces_row1_col1_text.required' => $admin['validation']['required']['ces_row1_col1_text'],
            'ces_row1_col2_text.required' => $admin['validation']['required']['ces_row1_col2_text'],
            'ces_row1_col3_text.required' => $admin['validation']['required']['ces_row1_col3_text'],
            'ces_row2_col1_text.required' => $admin['validation']['required']['ces_row2_col1_text'],
            'ces_row2_col2_text.required' => $admin['validation']['required']['ces_row2_col2_text'],
            'ces_row2_col3_text.required' => $admin['validation']['required']['ces_row2_col3_text']
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->except('_token', 'submit');

            $store = new NfoOffer($input);

            $store->type = $commonconstants['nfo_monitor_type']['value'][2];
            $store->created_id = $loginAdminId;
            $store->updated_id = $loginAdminId;
            $store->save();
        } catch (QueryException $exception) {
            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            } else {
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
        $dataArr = NfoOffer::find($id);

        $moduleAtrArr = NfoOffer::getModuleVars();
        $statusArr = App::getStatusLblTyp2Arr();

        $editDataAtrArr = ["title" => __('admin.nfomonitor.edit_txt'), "route" => 'nfomonitor.edit'];

        return view('themes.backend.pages.nfomonitor.updateform', compact('dataArr', 'editDataAtrArr', 'moduleAtrArr', 'statusArr'));
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
            'fund_name' => 'required',
            'fund_opening' => 'required',
            'fund_closing' => 'required',
            'ft_id' => 'required',
            'minimum_investment' => 'required',
            'plan' => 'required',
            'options' => 'required',
            'entry_load' => 'required',
            'exit_load' => 'required',
            'thereafter' => 'required',
            'objective' => 'required',
            'idc_id' => 'required',
            'fund_manager' => 'required',
            'aa_col1_value' => 'required',
            'aa_col1_text' => 'required',
            'aa_col2_value' => 'required',
            'aa_col2_text' => 'required',
            'ces_row1_col1_text' => 'required',
            'ces_row1_col2_text' => 'required',
            'ces_row1_col3_text' => 'required',
            'ces_row2_col1_text' => 'required',
            'ces_row2_col2_text' => 'required',
            'ces_row2_col3_text' => 'required',
            'idea_distiller' => 'required',
            'fund_house_aaum' => 'required',
            'fund_manager_experience' => 'required',
            'uniqness' => 'required',
            'return' => 'required',
            'risk' => 'required',
            'operability' => 'required',
            'oomph_factor' => 'required',
            'post_date' => 'required',
            'status' => 'required'
        ], [
            'ft_id.required' => $admin['validation']['required']['ft_id'],
            'idc_id.required' => $admin['validation']['required']['idc_id'],
            'aa_col1_value.required' => $admin['validation']['required']['aa_col1_value'],
            'aa_col1_text.required' => $admin['validation']['required']['aa_col1_text'],
            'aa_col2_value.required' => $admin['validation']['required']['aa_col2_value'],
            'aa_col2_text.required' => $admin['validation']['required']['aa_col2_text'],
            'ces_row1_col1_text.required' => $admin['validation']['required']['ces_row1_col1_text'],
            'ces_row1_col2_text.required' => $admin['validation']['required']['ces_row1_col2_text'],
            'ces_row1_col3_text.required' => $admin['validation']['required']['ces_row1_col3_text'],
            'ces_row2_col1_text.required' => $admin['validation']['required']['ces_row2_col1_text'],
            'ces_row2_col2_text.required' => $admin['validation']['required']['ces_row2_col2_text'],
            'ces_row2_col3_text.required' => $admin['validation']['required']['ces_row2_col3_text']
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->except('_method', '_token', 'submit');

            $store = NfoOffer::find($id);

            foreach ($input as $key => $value) {
                $store->$key = trim($value);
            }
            $store->updated_id = $loginAdminId;
            $store->save();
        } catch (QueryException $exception) {
            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            } else {
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
            if (count($checkboxArr) > 0) {
                $dataArr = NfoOffer::whereIn('no_id', $checkboxArr)->get();
                $delModel = NfoOffer::whereIn('no_id', $checkboxArr)->delete();
                if($delModel > 0){
                    if(count($dataArr)){
                        $upldDirName = $commonconstants['pdf_dir_name']."/";
                        foreach ($dataArr as $value) {
                            $file = $value->file;
                            $path = $upldDirName.$file;
                            if(isset($path) && $path){
                                $exists = Storage::exists($path);
                                if($exists){
                                    Storage::delete($path);
                                }
                            }
                        }
                    }
                }
            }
        } catch (QueryException $exception) {
            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            } else {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['delete'])->with('title', $admin['error_ttl']);
            }
        }
        return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['delete'])->with('title', $admin['success_ttl']);
    }
}
