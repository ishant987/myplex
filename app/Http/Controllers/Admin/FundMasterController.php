<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Lib\Admin\App;

use App\Models\Corpus;
use App\Models\FundMaster;
use App\Models\FundCore;
use App\Models\FundDetail;
use App\Models\FundComposition;
use App\Models\CorpusEntry;

class FundMasterController extends BaseController
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
        $sortBy = 'fund_id';
        $orderBy = 'DESC';

        $lstObj = new FundMaster;

        $listDataAtrArr = App::getListDataAtr();
        $moduleAtrArr = Arr::except($lstObj->getModuleVars(), ['index_list', 'fund_house_list']);

        $fltrDataArr = array();
        $fltrDataArr['with'] = 'yes';
        $fltrDataArr['fund_name'] = $request->has('ffn') ? $request->query('ffn') : '';
        $fltrDataArr['fund_code'] = $request->has('ffc') ? $request->query('ffc') : '';
        $fltrDataArr['fund_type_id'] = $request->has('fft') ? $request->query('fft') : '';
        $fltrDataArr['fund_term_id'] = $request->has('fftm') ? $request->query('fftm') : '';
        $fltrDataArr['fund_opened'] = $request->has('ffo') ? $request->query('ffo') : '';
        $fltrDataArr['status'] = $request->has('fsts') ? $request->query('fsts') : '';
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

        $sortbyArr = ['fund_id' => __('admin.insertion_txt'), 'fund_name' => __('admin.fund.name_txt'), 'fund_code' => __('admin.fund.code_txt'), 'fund_type_id' => __('admin.fund.type_txt'), 'fund_term_id' => __('admin.fund.term_txt'), 'fund_opened' => __('admin.fund.opened_txt'), 'updated_at' => __('admin.mdfy_date_txt')];
        $orderbyArr = ['asc' => 'ASC', 'desc' => 'DESC'];

        $showEntryArr = ['value' => __('admin.sw_entry.options.value'), 'text' => __('admin.sw_entry.options.text')];

        $cFilterArr = ['all_txt' => __('admin.def_drop_optn_styl3_txt')];

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.fund.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.fund.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.fund.delete')];

        return view('themes.backend.pages.fund.index', compact('dataListModel', 'data', 'listDataAtrArr', 'moduleAtrArr', 'sortbyArr', 'orderbyArr', 'fltrDataArr', 'perPage', 'sortBy', 'orderBy', 'showEntryArr', 'cFilterArr', 'roleRights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $moduleAtrArr = FundMaster::getModuleVars();

        return view('themes.backend.pages.fund.createform', compact('moduleAtrArr'));
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
            'fund_name' => 'required|max:255',
            'fund_code' => 'required|unique:fund_master',
            'cor' => 'required|unique:fund_core',
            'fund_house' => 'required',
            'fund_manager' => 'required',
            'fund_type' => 'required',
            'fund_term' => 'required',
            'index' => 'required',
            'classification' => 'required',
            'face_value' => 'required|numeric',
            'risk_free_return' => 'required|numeric',
            'fund_opened' => 'required',
            'cost' => 'required|numeric',
            'status' => 'required|integer'
        ], [
            'cor.required' => __('admin.fund.validation.required.cor_txt'),
            'cor.unique' => __('admin.fund.validation.cor_exist_txt')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $input = $request->except('_token', 'submit', 'cor');

            $store = new FundMaster;

            foreach ($input as $key => $value) {
                if ($key == 'fund_type') {
                    $store->fund_type_id = trim($value);
                } elseif ($key == 'fund_term') {
                    $store->fund_term_id = trim($value);
                } elseif ($key == 'index') {
                    $store->indices_name = trim($value);
                } else {
                    $store->$key = ($value);
                }
            }

            $store->created_id = $loginAdminId;
            $store->updated_id = $loginAdminId;
            if ($store->save()) {
                $date = new Carbon();
                $dateFormatted = $date->format($commonconstants['db_dt_tm_frmt']);

                $store2 = [];
                $store2['fund_id'] = $store->fund_id;
                $store2['cor'] = $request->input('cor');
                $store2['created_id'] = $loginAdminId;
                $store2['updated_id'] = $loginAdminId;
                $store2['created_at'] = $dateFormatted;
                $store2['updated_at'] = $dateFormatted;
                $totInsrt = FundCore::insert($store2);
                if ($totInsrt == 0) {
                    DB::rollBack();

                    return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
                }

                DB::commit();
                return redirect()->route('admin.fund.corpus.edit', $store->fund_id)->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['add'])->with('title', $admin['success_ttl']);
            }
        } catch (QueryException $exception) {
            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            } else {
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
        $dataArr = FundMaster::find($id);
        $moduleAtrArr = FundMaster::getModuleVars();

        $editDataAtrArr = ["title" => __('admin.fund.edit_txt'), "route" => 'fund.edit'];

        return view('themes.backend.pages.fund.updateform', compact('dataArr', 'editDataAtrArr', 'moduleAtrArr'));
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
            'fund_name' => 'required|max:255',
            'cor' => 'required|unique:fund_core,cor,' . $id . ',fund_id',
            'fund_house' => 'required',
            'fund_manager' => 'required',
            'fund_type' => 'required',
            'fund_term' => 'required',
            'index' => 'required',
            'classification' => 'required',
            'face_value' => 'required|numeric',
            'risk_free_return' => 'required|numeric',
            'fund_opened' => 'required',
            'cost' => 'required|numeric',
            'status' => 'required|integer'
        ], [
            'cor.required' => __('admin.fund.validation.required.cor_txt'),
            'cor.unique' => __('admin.fund.validation.cor_exist_txt')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $input = $request->except('_method', '_token', 'submit', 'cor');

            $store = FundMaster::find($id);

            foreach ($input as $key => $value) {
                if ($key == 'fund_type') {
                    $store->fund_type_id = trim($value);
                } elseif ($key == 'fund_term') {
                    $store->fund_term_id = trim($value);
                } elseif ($key == 'index') {
                    $store->indices_name = trim($value);
                } else {
                    $store->$key = ($value);
                }
            }
            $store->updated_id = $loginAdminId;
            if ($store->save()) {
                $date = new Carbon();
                $dateFormatted = $date->format($commonconstants['db_dt_tm_frmt']);

                $store2 = [];
                $store2['cor'] = $request->input('cor');
                $store2['updated_id'] = $loginAdminId;
                $store2['updated_at'] = $dateFormatted;
                $totInsrt = FundCore::where('fund_id', $id)->update($store2);
                if ($totInsrt == 0) {
                    DB::rollBack();
                    return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
                }

                DB::commit();
                return redirect()->route('admin.fund.index')->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['update'])->with('title', $admin['success_ttl']);
            }
        } catch (QueryException $exception) {
            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            } else {
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
            if (count($checkboxArr) > 0) {
                DB::beginTransaction();
                $dataArr = FundMaster::whereIn('fund_id', $checkboxArr)->get();
                $delModel = FundMaster::whereIn('fund_id', $checkboxArr)->delete();
                if ($delModel > 0) {
                    $delModel2 = FundCore::whereIn('fund_id', $checkboxArr)->delete();
                    if ($delModel2 > 0) {
                        Corpus::whereIn('fund_id', $checkboxArr)->delete();
                        if ($dataArr) {
                            foreach ($dataArr as $value) {
                                $fundCode = $value->fund_code;
                                if ($fundCode) {
                                    FundDetail::where('fund_code', $fundCode)->delete();
                                    FundComposition::where('fund_code', $fundCode)->delete();
                                    CorpusEntry::where('fund_code', $fundCode)->delete();
                                }
                            }
                        }
                        DB::commit();
                        return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['delete'])->with('title', $admin['success_ttl']);
                    } else {
                        DB::rollBack();
                        return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['delete'])->with('title', $admin['error_ttl']);
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexnocor()
    {
        $lstObj = new FundMaster;
        $dataListModel = $lstObj->noCorlist(['nocor' => 'yes']);

        $coreObj = new App();
        $listDataAtrArr = $coreObj->getListDataAtr();

        $roleRights = ['edit' => $coreObj->hasAccessToMethod($this->className, 'admin.fund.edit'), 'delete' => $coreObj->hasAccessToMethod($this->className, 'admin.fund.delete')];

        return view('themes.backend.pages.fund.indexnocor', compact('dataListModel', 'listDataAtrArr', 'roleRights'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editcorpus($id)
    {
        $dataListModel = Corpus::list(['fund_id' => $id]);
        $dataArr = FundMaster::find($id);
        $otherData = ['total' => count($dataListModel), 'data_item' => 0];

        $editDataAtrArr = ["title" => __('admin.fund.edit_corpus_txt') . " " . $dataArr->fund_name, "route" => 'fund.corpus.edit'];

        return view('themes.backend.pages.fund.corpus', compact('dataArr', 'editDataAtrArr', 'dataListModel', 'otherData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatecorpus(Request $request, $id)
    {
        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');

        $message = __('message');
        $admin = __('admin');

        $loginAdminId = self::getLoggedInAdminId();

        $validator = Validator::make($request->all(), [
            'funds' => 'required|array|min:1'
        ], []);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $totCorpus = Corpus::where('fund_id', $id)->count();
            if ($totCorpus > 0) {
                $delModel = Corpus::where('fund_id', $id)->delete();
                if ($delModel == 0) {
                    return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['update'])->with('title', $admin['error_ttl']);
                }
            }
            $date = new Carbon();
            $dateFormatted = $date->format($commonconstants['db_dt_tm_frmt']);
            $funds = $request->input('funds');
            $totInsrt = 0;
            foreach ($funds as $fund) {
                if ($fund != '') {
                    $store2 = [];
                    $store2['fund_id'] = $id;
                    $store2['fund'] = $fund;
                    $store2['created_id'] = $loginAdminId;
                    $store2['updated_id'] = $loginAdminId;
                    $store2['created_at'] = $dateFormatted;
                    $store2['updated_at'] = $dateFormatted;
                    $totInsrt = Corpus::insert($store2);
                }
            }
            if ($totInsrt == 0) {
                DB::rollBack();
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
            }

            DB::commit();
            return redirect()->route('admin.fund.index')->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['update'])->with('title', $admin['success_ttl']);
        } catch (QueryException $exception) {
            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            } else {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['update'])->with('title', $admin['error_ttl']);
            }
        }
    }
}
