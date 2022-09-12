<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;
use Storage;
use Illuminate\Support\Arr;

use App\Lib\Admin\App;

use App\Models\AskExpertQuestion;
use App\Models\AskExpertQuestionAnswer;
use App\Models\UserLike;

class AskExpertQuestionController extends BaseController
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
        $commonconstants = Config('commonconstants');

        $data = $request->all();
        $perPage = $commonconstants['pagination_no'];
        $sortBy = 'aeq_id';
        $orderBy = 'DESC';

        $lstObj = new AskExpertQuestion;
        $coreObj = new App();

        $listDataAtrArr = $coreObj->getListDataAtr();
        $statusAtrArr = $coreObj->getStatusLblTyp2Atr();
        $moduleAtrArr = Arr::except($lstObj->getModuleVars(), ['media_folder', 'video_type']);

        $fltrDataArr = array();

        $fltrDataArr['question'] = $request->has('fqn') ? $request->query('fqn') : '';
        $fltrDataArr['topic'] = $request->has('ftc') ? $request->query('ftc') : '';
        $fltrDataArr['status'] = $request->has('fst') ? $request->query('fst') : '';
        $fltrDataArr['created_at'] = $request->has('fct') ? $request->query('fct') : '';
        $fltrDataArr['created_user'] = $request->has('fcu') ? $request->query('fcu') : '';
        $fltrDataArr['updated_at'] = $request->has('fut') ? $request->query('fut') : '';

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

        $sortbyArr = ['aeq_id' => __('admin.insertion_txt'), 'question' => __('askexpert.question.label_txt'), 'topic' => __('askexpert.topic_txt'), 'created_at' => __('admin.added_date_txt'), 'updated_at' => __('admin.mdfy_date_txt')];
        $orderbyArr = ['asc' => 'ASC', 'desc' => 'DESC'];

        $showEntryArr = ['value' => __('admin.sw_entry.options.value'), 'text' => __('admin.sw_entry.options.text')];

        $cFilterArr = ['all_txt' => __('admin.def_drop_optn_styl3_txt')];

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.question.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.question.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.question.delete')];

        return view('themes.backend.pages.question.index', compact('dataListModel', 'data', 'listDataAtrArr', 'moduleAtrArr', 'statusAtrArr', 'sortbyArr', 'orderbyArr', 'perPage', 'sortBy', 'orderBy', 'showEntryArr', 'roleRights', 'fltrDataArr', 'cFilterArr'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataArr = AskExpertQuestion::find($id);

        $commonconstants = Config('commonconstants');

        $statusArr = App::getStatusLblTyp2Arr();

        $moduleAtrArr = Arr::only(AskExpertQuestion::getModuleVars(), ['media_folder', 'video_type']);

        $editDataAtrArr = ["title" => __('askexpert.question.edit_txt'), "route" => 'question.edit'];

        return view('themes.backend.pages.question.updateform', compact('dataArr', 'statusArr', 'moduleAtrArr', 'editDataAtrArr'));
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
            'question' => 'required',
            'status' => 'required|integer'
        ], []);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $store = AskExpertQuestion::find($id);

            $input = $request->except('_method', '_token', 'submit');

            $store->question = $input['question'];
            $store->status = $input['status'];
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

                UserLike::whereIn('data_id', $checkboxArr)->where('type', '=', $commonconstants['like_type']['value']['0'])->delete();

                $dataArr = AskExpertQuestion::whereIn('aeq_id', $checkboxArr)->get();

                $delModel = AskExpertQuestion::whereIn('aeq_id', $checkboxArr)->delete();
                if ($delModel > 0) {
                    $upldDirName = $commonconstants['aeq_dir_name'] . "/";

                    $videoTypeLocal = $commonconstants['video_type']['value']['0'];

                    $aeaLikeType = $commonconstants['like_type']['value']['1'];
                    foreach ($dataArr as $record) {
                        $image1 = $record->image1;
                        if ($image1 != '') {
                            $path1 = $upldDirName . $image1;
                            if (isset($path1) && $path1) {
                                $exists1 = Storage::exists($path1);
                                if ($exists1) {
                                    Storage::delete($path1);
                                }
                            }
                        }
                        $image2 = $record->image2;
                        if ($image2 != '') {
                            $path2 = $upldDirName . $image2;
                            if (isset($path2) && $path2) {
                                $exists2 = Storage::exists($path2);
                                if ($exists2) {
                                    Storage::delete($path2);
                                }
                            }
                        }
                        $image3 = $record->image3;
                        if ($image3 != '') {
                            $path3 = $upldDirName . $image3;
                            if (isset($path3) && $path3) {
                                $exists3 = Storage::exists($path3);
                                if ($exists3) {
                                    Storage::delete($path3);
                                }
                            }
                        }

                        if (($record->video_from != '') && ($record->video_from == $videoTypeLocal)) {
                            $videoData = $record->video_data;
                            if ($videoData != '')
                                $path4 = $upldDirName . $videoData;
                            if (isset($path4) && $path4) {
                                $exists4 = Storage::exists($path4);
                                if ($exists4) {
                                    Storage::delete($path4);
                                }
                            }
                        }
                    }

                    $dataArr2 = AskExpertQuestionAnswer::whereIn('aeq_id', $checkboxArr)->get();
                    $delModel2 = AskExpertQuestionAnswer::whereIn('aeq_id', $checkboxArr)->delete();
                    if ($delModel2 > 0) {
                        foreach ($dataArr2 as $record2) {
                            UserLike::where('data_id', '=', $record2->aeqa_id)->where('type', '=', $aeaLikeType)->delete();
                        }
                    }
                }

                \DB::commit();
            } else {
                \DB::rollBack();
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
