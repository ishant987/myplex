<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;

use App\Lib\Admin\App;

use App\Models\Plans;

class PlanController extends BaseController
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
        $dtObj = new Plans;

        $dataListModel = Plans::list();

        $coreObj = new App();
        $listDataAtrArr = $coreObj->getListDataAtr();
        $statusAtrArr = $coreObj->getStatusLblTyp2Atr();
        $moduleAtrArr = $dtObj->getModuleVars();

        $roleRights = ['add' => $coreObj->hasAccessToMethod($this->className, 'admin.plan.create'), 'edit' => $coreObj->hasAccessToMethod($this->className, 'admin.plan.edit'), 'delete' => $coreObj->hasAccessToMethod($this->className, 'admin.plan.delete')];

        return view('themes.backend.pages.plan.index', compact('dataListModel', 'listDataAtrArr', 'statusAtrArr', 'moduleAtrArr', 'roleRights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statusArr = App::getStatusLblTyp2Arr();
        $moduleAtrArr = Plans::getModuleVars();

        return view('themes.backend.pages.plan.createform', compact('statusArr', 'moduleAtrArr'));
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

        $adminLang = __('admin');

        $input = $request->all();

        $validator = Validator::make($input, [
            'plan_name' => 'required|unique:plans',
            'amount' => 'nullable|integer',
            'plan_type' => 'required',
            'plan_duration' => 'required_if:plan_type,=,lp',
            'free_trial' => 'required_if:plan_type,=,lp',
            'show_on_wa' => 'required_if:plan_type,=,lp',
            'c_order' => 'nullable|integer',
            'status' => 'required|integer'
        ], [
            'c_order.integer' => $adminLang['validation']['integer']['c_order'],
            'plan_duration.required_if' => __('plan.validation.required.plan_duration')
        ]);

        $validator->after(function () use ($input, $validator) {
            $commonconstants = Config('commonconstants');
            $yVal = $commonconstants['y_n_val'][1];
            $planTypeFf = $commonconstants['plan_type']['value'][0];

            $plnObj = new Plans;
            $dataRow = $plnObj->getData(["free_trial" => $yVal], ['free_trial']);
            if ($dataRow) {
                if ($input['free_trial'] == $yVal) {
                    $validator->errors()->add('free_trial', __('plan.warning.free_trial'));
                }
            }
            $dataRow2 = $plnObj->getData(["plan_type" => $planTypeFf], ['plan_type']);
            if ($dataRow2) {
                if ($input['plan_type'] == $planTypeFf) {
                    $validator->errors()->add('plan_type', __('plan.warning.plan_type'));
                }
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->except('_token', 'submit', 'files');

            $store = new Plans($input);

            foreach ($input as $key => $value) {
                if ($key == "plan_duration") {
                    $store->duration = trim($value);
                } else if ($key == "plan_duration_name") {
                    $store->duration_name = trim($value);
                } else if ($key == 'c_order') {
                    $c_order = intval($value);
                    $store->$key = $c_order > 0 ? $c_order : 0;
                } else {
                    $store->$key = trim($value);
                }
            }
            $store->amount = isset($input['amount']) ? $input['amount'] : 0.00;
            $store->duration = isset($input['plan_duration']) ? $input['plan_duration'] : 0;
            $store->created_id = $loginAdminId;
            $store->updated_id = $loginAdminId;

            $store->save();
        } catch (QueryException $exception) {
            if ($loginAdminId == Config('commonconstants.def_super_admin_id')) {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            } else {
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
        $dtObj = new Plans;

        $dataArr = $dtObj->find($id);

        $statusArr = App::getStatusLblTyp2Arr();
        $moduleAtrArr = $dtObj->getModuleVars();

        $editDataAtrArr = ["title" => __('plan.edit_txt'), "route" => 'plan.edit'];

        return view('themes.backend.pages.plan.updateform', compact('dataArr', 'statusArr', 'editDataAtrArr', 'moduleAtrArr'));
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

        $adminLang = __('admin');

        $input = $request->all();

        $validator = Validator::make($input, [
            'plan_name' => 'required|unique:plans,plan_name,' . $id . ',p_id',
            'free_trial' => 'required',
            'show_on_wa' => 'required',
            'c_order' => 'nullable|integer',
            'status' => 'required|integer'
        ], [
            'c_order.integer' => $adminLang['validation']['integer']['c_order']
        ]);

        $validator->after(function () use ($input, $id, $validator) {
            $commonconstants = Config('commonconstants');
            $yVal = $commonconstants['y_n_val'][1];
            $dataRow = Plans::getData(["free_trial" => $yVal], ['p_id', 'free_trial']);
            if ($dataRow) {
                if ($input['free_trial'] == $yVal && $id != $dataRow->p_id) {
                    $validator->errors()->add('free_trial', __('plan.warning.free_trial'));
                }
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->except('_method', '_token', 'submit', 'files');

            $store = Plans::find($id);

            foreach ($input as $key => $value) {
                if ($key == "plan_duration_name") {
                    $store->duration_name = trim($value);
                } else if ($key == 'c_order') {
                    $c_order = intval($value);
                    $store->$key = $c_order > 0 ? $c_order : 0;
                } else {
                    $store->$key = trim($value);
                }
            }
            $store->updated_id = $loginAdminId;
            $store->save();
        } catch (QueryException $exception) {
            if ($loginAdminId == Config('commonconstants.def_super_admin_id')) {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            } else {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.update'))->with('title', __('admin.error_ttl'));
            }
        }

        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.update'))->with('title', __('admin.success_ttl'));
    }

    public function deleteData(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();

        try {
            $checkboxArr = $request->get('checkbox');
            if (count($checkboxArr) > 0) {
                Plans::destroy($checkboxArr);
            }
        } catch (QueryException $exception) {
            if ($loginAdminId == Config('commonconstants.def_super_admin_id')) {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            } else {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.delete'))->with('title', __('admin.error_ttl'));
            }
        }

        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.delete'))->with('title', __('admin.success_ttl'));
    }
}
