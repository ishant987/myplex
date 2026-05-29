<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;

use App\Lib\Admin\App;

use App\Models\AskExpertQuestionAnswer;
use App\Models\UserLike;

class AskExpertQuestionAnswerController extends BaseController
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
    public function index(Request $request, $aeq_id)
    {
        $data = $request->all();
        $perPage = Config('commonconstants.pagination_no');
        $sortBy = 'aeqa_id';
        $orderBy = 'DESC';
        $lstObj = new AskExpertQuestionAnswer;
        $coreObj = new App();
        $listDataAtrArr = $coreObj->getListDataAtr();
        $moduleAtrArr = $lstObj->getModuleVars();

        $fltrDataArr = array();
        $fltrDataArr['aeq_id'] = $aeq_id;
        $fltrDataArr['answer'] = $request->has('far') ? $request->query('far') : '';
        $fltrDataArr['status'] = $request->has('fst') ? $request->query('fst') : '';
        $fltrDataArr['created_at'] = $request->has('fca') ? $request->query('fca') : '';
        $fltrDataArr['updated_at'] = $request->has('fua') ? $request->query('fua') : '';
        $fltrDataArr['updated_by'] = $request->has('fub') ? $request->query('fub') : '';

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
        //echo $dataListModel->toSql();exit;

        $sortbyArr = ['aeqa_id' => __('admin.insertion_txt'), 'answer' => __('askexpert.answer.label_txt'), 'created_at' => __('admin.added_date_txt'), 'updated_at' => __('admin.mdfy_date_txt')];
        $orderbyArr = ['asc' => 'ASC', 'desc' => 'DESC'];

        $showEntryArr = ['value' => __('admin.sw_entry.options.value'), 'text' => __('admin.sw_entry.options.text')];

        $cFilterArr = ['all_txt' => __('admin.def_drop_optn_styl3_txt')];

        $roleRights = ['edit' => App::hasAccessToMethod($this->className, 'admin.answer.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.answer.delete')];

        return view('themes.backend.pages.answer.index', compact('dataListModel', 'data', 'listDataAtrArr', 'sortbyArr', 'orderbyArr', 'perPage', 'sortBy', 'orderBy', 'showEntryArr', 'roleRights', 'fltrDataArr', 'moduleAtrArr', 'cFilterArr'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataArr = AskExpertQuestionAnswer::find($id);

        $statusArr = AskExpertQuestionAnswer::statusArr();

        $editDataAtrArr = ["title" => __('askexpert.answer.edit_txt'), "route" => 'answer.edit'];

        return view('themes.backend.pages.answer.updateform', compact('dataArr', 'statusArr', 'editDataAtrArr'));
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
            'answer' => 'required',
            'status' => 'required|integer',
        ], [
            'answer.required' => __('answer.validation.required.answer'),
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $store = AskExpertQuestionAnswer::find($id);

            $input = $request->except('_method', '_token', 'submit');
            foreach ($input as $key => $value) {
                $store->$key = trim($value);
            }

            $store->updated_by = $commonconstants['cu_by_val']['1'];
            $store->updated_id = $loginAdminId;
            $store->save();
        } catch (QueryException $exception) {
            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            } else {
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
            if (count($checkboxArr) > 0) {
                \DB::beginTransaction();

                UserLike::whereIn('data_id', $checkboxArr)->where('type', '=', $commonconstants['like_type']['value']['2'])->delete();

                $delModel = AskExpertQuestionAnswer::whereIn('aeqa_id', $checkboxArr)->delete();
                if ($delModel > 0) {
                    \DB::commit();
                } else {
                    \DB::rollBack();
                }
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
