<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use App\Imports\ScripsImport;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;
use Maatwebsite\Excel\Facades\Excel;

use App\Lib\Admin\App;
use App\Lib\App\Common;

use App\Models\Scrips;

class ScripsController extends BaseController
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
    public function index(Request $request)
    {
        $data = $request->all();
        $perPage = Config('commonconstants.pagination_no');
        $sortBy = 'scrp_id';
        $orderBy = 'DESC';

        $lstObj = new Scrips;

        $listDataAtrArr = App::getListDataAtr();
        $moduleAtrArr = [];

        $fltrDataArr = array();

        $fltrDataArr['scrip_name'] = $request->has('fsn') ? Common::ampSafeOnUrl($request->query('fsn')) : '';
        $fltrDataArr['type'] = $request->has('fte') ? $request->query('fte') : '';
        $fltrDataArr['industry'] = $request->has('fiy') ? $request->query('fiy') : '';
        $fltrDataArr['actual_scrip'] = $request->has('fas') ? Common::ampSafeOnUrl($request->query('fas')) : '';
        $fltrDataArr['updated_at'] = $request->has('fmd') ? $request->query('fmd') : '';

        if ($request->has('ppage')) {
            $perPage = $request->query('ppage');
        }

        if ($request->has('oby')) {
            $orderBy = $request->query('oby');
        }
        if ($request->has('sby')) {
            $sortBy = $request->query('sby');
        }

        $dataListModel = $lstObj::search($fltrDataArr)->orderBy($sortBy, $orderBy)->paginate($perPage);

        $sortbyArr = ['scrp_id' => __('admin.insertion_txt'), 'scrip_name' => __('admin.scrip.label_txt'), 'type' => __('admin.type_txt'), 'industry' => __('admin.industry_txt'), 'actual_scrip' => __('admin.scrip.actual_txt'), 'updated_at' => __('admin.mdfy_date_txt')];
        $orderbyArr = ['asc' => 'ASC', 'desc' => 'DESC'];

        $showEntryArr = ['value' => __('admin.sw_entry.options.value'), 'text' => __('admin.sw_entry.options.text')];

        $cFilterArr = ['all_txt' => __('admin.def_drop_optn_styl3_txt')];

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.scrips.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.scrips.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.scrips.delete')];

        return view('themes.backend.pages.scrip.index', compact('dataListModel', 'data', 'listDataAtrArr', 'moduleAtrArr', 'sortbyArr', 'orderbyArr', 'fltrDataArr', 'perPage', 'sortBy', 'orderBy', 'showEntryArr', 'cFilterArr', 'roleRights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('themes.backend.pages.scrip.createform');
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_upload' => 'required|mimes:xls,xlsx'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $dataImport = new ScripsImport();
        Excel::import($dataImport, $request->file('file_upload'));

        $message = $dataImport->getRowCount() . " rows added and " . $dataImport->getUpdRowCount() . " rows updated successfully.";
        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', $message)->with('title', __('admin.success_ttl'));
    }

    public function createmanual()
    {
        return view('themes.backend.pages.scrip.createmanualform');
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

        $input = $request->all();

        $validator = Validator::make($input, [
            'scrip_name' => 'required|unique:scrips',
            'type' => 'required',
            'industry' => 'required',
            'actual_scrip' => 'required'
        ], []);

        $validator->after(function () use ($input, $validator) {
            $result = Scrips::where(function ($query) use ($input) {
                $query->where(['scrip_name' => $input['scrip_name'], 'actual_scrip' => $input['actual_scrip']]);
            })->first();
            if ($result) {
                $validator->errors()->add('scrip_name', __('admin.validation.dup_scrip_name'));
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $inputNew = $request->except('_token', 'submit');

            $store = new Scrips($inputNew);

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
        $dataArr = Scrips::find($id);

        $editDataAtrArr = ["title" => __('admin.scrip.edit_txt'), "route" => 'scrips.edit'];

        return view('themes.backend.pages.scrip.updateform', compact('dataArr', 'editDataAtrArr'));
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

        $input = $request->all();

        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');

        $message = __('message');
        $admin = __('admin');

        $validator = Validator::make($input, [
            'scrip_name' => 'required|unique:scrips,scrip_name,' . $id . ',scrp_id',
            'type' => 'required',
            'industry' => 'required',
            'actual_scrip' => 'required'
        ], []);

        $validator->after(function () use ($input, $validator, $id) {
            $result = Scrips::where(function ($query) use ($input, $id) {
                $query->where(['scrip_name' => $input['scrip_name'], 'actual_scrip' => $input['actual_scrip']])->where('scrp_id', '!=', $id);
            })->first();
            if ($result) {
                $validator->errors()->add('scrip_name', __('admin.validation.dup_scrip_name'));
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $store = Scrips::find($id);

            $inputNew = $request->except('_method', '_token', 'submit');

            foreach ($inputNew as $key => $value) {
                $store->$key = ($value);
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

        return redirect()->route('admin.scrips.index')->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['update'])->with('title', $admin['success_ttl']);
    }

    public function deletedata(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();
        try {
            $checkboxArr = $request->get('checkbox');
            if (count($checkboxArr) > 0) {
                Scrips::whereIn('scrp_id', $checkboxArr)->delete();
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
