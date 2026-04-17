<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;
use Storage;
use Illuminate\Support\Arr;
use DB;

use App\Lib\Core\Useful;
use App\Lib\Admin\App;
use App\Lib\Core\MailPS;

use App\Models\User;
use App\Models\UserGroupRelModel;

use App\Models\Plans;
use App\Models\UserSubscription;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class SubscribeduserController extends BaseController
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
        $sortBy = 'u_id';
        $orderBy = 'DESC';

        $lstObj = new User;

        $listDataAtrArr = App::getListDataAtr();
        $moduleAtrArr = $lstObj->getModuleVars();

        $fltrDataArr = array();

        $fltrDataArr['u_code'] = $request->has('fucd') ? $request->query('fucd') : '';
        $fltrDataArr['f_name'] = $request->has('ffn') ? $request->query('ffn') : '';
        $fltrDataArr['l_name'] = $request->has('fln') ? $request->query('fln') : '';
        $fltrDataArr['login_pin'] = $request->has('fpn') ? $request->query('fpn') : '';
        $fltrDataArr['email'] = $request->has('fem') ? $request->query('fem') : '';
        $fltrDataArr['mobile'] = $request->has('fmb') ? $request->query('fmb') : '';
        $fltrDataArr['status'] = $request->has('fsts') ? $request->query('fsts') : '';
        $fltrDataArr['acc_type'] = $request->has('fat') ? $request->query('fat') : '';
        $fltrDataArr['s_acc_medium'] = $request->has('fsm') ? $request->query('fsm') : '';
        $fltrDataArr['created_at'] = $request->has('fad') ? $request->query('fad') : '';
        $fltrDataArr['created_by'] = $request->has('fay') ? $request->query('fay') : '';
        $fltrDataArr['updated_at'] = $request->has('fmd') ? $request->query('fmd') : '';
        $fltrDataArr['updated_by'] = $request->has('fmby') ? $request->query('fmby') : '';

        if ($request->has('ppage')) {
            $perPage = $request->query('ppage');
        }

        if ($request->has('oby')) {
            $orderBy = $request->query('oby');
        }
        if ($request->has('sby')) {
            $sortBy = $request->query('sby');
        }

        $dataListModel = $lstObj::search($fltrDataArr)
            ->with(['latestPaidSubscription.plan'])
            ->orderBy($sortBy, $orderBy)
            ->paginate($perPage);

        $sortbyArr = ['u_id' => __('admin.insertion_txt'), 'f_name' => __('common.f_name_txt'), 'l_name' => __('common.l_name_txt'), 'email' => __('common.email_txt'), 'mobile' => __('common.mobile_txt'), 'acc_type' => __('subscribeduser.acc_type_txt'), 's_acc_medium' => __('subscribeduser.s_acc_medium_txt'), 'created_at' => __('admin.added_date_txt'), 'created_by' => __('admin.added_by_txt'), 'updated_at' => __('admin.mdfy_date_txt'), 'updated_by' => __('admin.mdfy_by_txt')];
        $orderbyArr = ['asc' => 'ASC', 'desc' => 'DESC'];

        $showEntryArr = ['value' => __('admin.sw_entry.options.value'), 'text' => __('admin.sw_entry.options.text')];

        $cFilterArr = ['all_txt' => __('admin.def_drop_optn_styl3_txt')];

        $roleRights = ['add' => App::hasAccessToMethod($this->className, 'admin.subscribeduser.create'), 'edit' => App::hasAccessToMethod($this->className, 'admin.subscribeduser.edit'), 'delete' => App::hasAccessToMethod($this->className, 'admin.deletesubscribeduser')];

        return view('themes.backend.pages.subscribeduser.index', compact('dataListModel', 'data', 'listDataAtrArr', 'moduleAtrArr', 'sortbyArr', 'orderbyArr', 'fltrDataArr', 'perPage', 'sortBy', 'orderBy', 'showEntryArr', 'cFilterArr', 'roleRights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('themes.backend.pages.subscribeduser.createform');
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_upload' => 'required|mimes:xls,xlsx'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $usersImport = new UsersImport();
        Excel::import($usersImport, $request->file('file_upload'));

        $message = $usersImport->getRowCount() . " rows added and " . $usersImport->getUpdRowCount() . " rows updated successfully.";
        if (count($usersImport->getDuplicateEmailArr()) > 0)
            $message .= " Duplicate emails are: " . implode(', ', $usersImport->getDuplicateEmailArr());
        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', $message)->with('title', __('admin.success_ttl'));
    }

    public function createmanual()
    {
        $mdlObj = new User;

        $userGroupArr = $mdlObj->getUserGroupList();

        $moduleAtrArr = Arr::only($mdlObj->getModuleVars(), ['status']);

        $daysArr = $mdlObj->days();
        $monthsArr = $mdlObj->months();

        return view('themes.backend.pages.subscribeduser.createmanualform', compact('userGroupArr', 'moduleAtrArr', 'daysArr', 'monthsArr'));
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
        $adminconstants = Config('adminconstants');
        $auth = Config('auth');

        $message = __('message');
        $admin = __('admin');

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|numeric',
            'p_picture' => 'nullable|file|image|mimes:jpeg,jpg,png|max:' . $commonconstants['img_upld_max_size'] . '',
            'pincode' => 'nullable|numeric',
            'user_group' => 'required|array|min:1',
            'status' => 'required|integer'
        ], [
            'p_picture.max' => $message['error']['img_upload_max_sz']
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $store = new User;

            $input = $request->except('_token', 'submit', 'user_group_from', 'user_group', 'q');

            $bdArr = [];
            $fName = "f_name";
            foreach ($input as $key => $value) {
                if ($key == 'first_name') {
                    $store->$fName = trim($value);
                } elseif ($key == 'b_date' || $key == 'b_month') {
                    array_push($bdArr, trim($value));
                } else {
                    $store->$key = ($value);
                }
            }

            if (count($bdArr) > 0) {
                $b = '';
                if ($bdArr[0] != '' && $bdArr[1] != '') {
                    $b = implode('-', $bdArr);
                }
                $store->birthday = $b;
            }

            if ($request->hasFile('p_picture')) {
                $upldDirName = $commonconstants['user_dir_name'];
                $file      = $request->file('p_picture');
                $extension = $file->getClientOriginalExtension();
                $filename  = $store->f_name . '-dp-' . time() . '.' . $extension;
                $path      = $file->storeAs($upldDirName, $filename);
                if ($path) {
                    $store->p_picture = $filename;
                } else {
                    return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['img_upload'])->with('title', $admin['error_ttl']);
                }
            }

            $cuBy = $commonconstants['cu_by_val'][1];
            $yVal = $commonconstants['y_n_val'][1];

            $accType = $auth['acc_type']['value']['0'];

            $uoptTypOpt2Val = $commonconstants['uopt_typ_opt2_val'];
            $yesVal = strtolower(__('common.yes_no_txt.y'));
            $now = now();

            $genUsrPswdNo = $commonconstants['gen_usr_password_no'];
            $password = Useful::generateStrongPassword($genUsrPswdNo);

            $store->acc_type = $accType;
            $store->password = bcrypt($password);
            $store->is_approved = $yVal;
            $store->created_by = $cuBy;
            $store->created_id = $loginAdminId;
            $store->updated_at = $commonconstants['null'];
            if ($store->save()) {
                $userId = $store->u_id;
                $userGroupArr = $request->input('user_group');
                if (!empty($userGroupArr)) {
                    $store2 = [];
                    foreach ($userGroupArr as $key => $value) {
                        $store2[$key] = ['u_g_id' => $value, 'u_id' => $userId, 'updated_id' => $loginAdminId];
                    }
                    $totInsrt = UserGroupRelModel::insert($store2);
                    if ($totInsrt == 0) {
                        DB::rollBack();

                        return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
                    } else {
                        Plans::captureFreeTrailPlan(["u_id" => $userId, "created_by" => $cuBy]);
                        DB::commit();

                        if (!\App::environment(['local'])) {
                            $mailPSObj = new MailPS();
                            $mailCssAtr = $mailPSObj->getEmailHtmlCssAtr();

                            $email = $input['email'];

                            $fullname = $input['first_name'] . " " . $input['l_name'];
                            $mailArr = ["fullname" => rtrim($fullname), "email" => $email, "password" => $password];

                            $subject    = __('auth.su_reg_mail_sbjct');
                            $content    = view('emails.admin.to-user-signup', compact('mailArr', 'mailCssAtr'));
                            $fromName = __('auth.su_reg_mail_f_name');

                            $mailResp = $mailPSObj->sendMail($email, $subject, $content, '', $fromName);
                        }

                        return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['add'])->with('title', $admin['success_ttl']);
                    }
                }
            } else {
                DB::rollBack();

                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['data_saved'])->with('title', $admin['error_ttl']);
            }
        } catch (QueryException $exception) {
            if (isset($path) && $path) {
                $exists = Storage::exists($path);
                if ($exists) {
                    Storage::delete($path);
                }
            }

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
        $mdlObj = new User;

        $dataArr = $mdlObj->find($id);

        $birthdayArr = ['0' => '', '1' => ''];
        if ($dataArr['birthday'] != '') {
            $birthdayArr = explode("-", $dataArr['birthday']);
        }

        $toObj = UserGroupRelModel::getUserGroupRelList(['u_id' => $id]);

        $userGroupArr = $mdlObj->getUserGroupList();
        $moduleAtrArr = Arr::except($mdlObj->getModuleVars(), ['cu_by_val', 'cu_by_txt', 'y_n_val', 'yes_no_txt']);

        $commonconstants = Config('commonconstants');

        $daysArr = $mdlObj->days();
        $monthsArr = $mdlObj->months();
        $plansArr = Plans::list(['status' => $commonconstants['status_val'][1]], ['p_id', 'plan_name'], 'c_order', 'ASC');
        $userPlanArr = UserSubscription::getData(["u_id" => $id], ['p_id']);
        $userPlanArr = $userPlanArr == null ? ['p_id' => 0] : $userPlanArr;

        $editDataAtrArr = ["title" => __('subscribeduser.edit_txt'), "route" => 'subscribeduser.edit'];

        return view('themes.backend.pages.subscribeduser.updateform', compact('dataArr', 'userGroupArr', 'moduleAtrArr', 'editDataAtrArr', 'birthdayArr', 'daysArr', 'monthsArr', 'toObj', 'plansArr', 'userPlanArr'));
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
        $adminconstants = Config('adminconstants');

        $message = __('message');
        $admin = __('admin');

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id . ',u_id',
            'mobile' => 'required|numeric',
            'p_picture' => 'nullable|file|image|mimes:jpeg,jpg,png|max:' . $commonconstants['img_upld_max_size'] . '',
            'pincode' => 'nullable|numeric',
            // 'plan' => 'required|integer',
            'user_group' => 'required|array|min:1',
            'status' => 'required|integer'
        ], [
            'p_picture.max' => $message['error']['img_upload_max_sz']
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $store = User::find($id);

            $exstPicture = $store->p_picture;

            $input = $request->except('_method', '_token', 'submit', 'user_group_from', 'user_group', 'plan', 'q');

            $bdArr = [];
            $fName = "f_name";
            foreach ($input as $key => $value) {
                if ($key == 'first_name') {
                    $store->$fName = trim($value);
                } elseif ($key == 'b_date' || $key == 'b_month') {
                    array_push($bdArr, trim($value));
                } elseif ($key == 'neet_appearing_year') {
                    $store->neet_apear_year = trim($value);
                } else {
                    $store->$key = ($value);
                }
            }

            if (count($bdArr) > 0) {
                $b = '';
                if ($bdArr[0] != '' && $bdArr[1] != '') {
                    $b = implode('-', $bdArr);
                }
                $store->birthday = $b;
            }

            if ($request->hasFile('p_picture')) {
                $upldDirName = $commonconstants['user_dir_name'];
                $file      = $request->file('p_picture');
                $extension = $file->getClientOriginalExtension();
                $filename  = $store->f_name . '-dp-' . time() . '.' . $extension;
                $path      = $file->storeAs($upldDirName, $filename);
                if ($path) {
                    $store->p_picture = $filename;
                } else {
                    return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['img_upload'])->with('title', $admin['error_ttl']);
                }
            } else {
                $store->p_picture = $exstPicture;
            }

            $cuBy = $commonconstants['cu_by_val'][1];

            $store->updated_by = $cuBy;
            $store->updated_id = $loginAdminId;

            if ($store->save()) {
                if ($request->hasFile('p_picture') && $exstPicture) {
                    $oldFilePath = $upldDirName . '/' . $exstPicture;
                    $exists = Storage::exists($oldFilePath);
                    if ($exists) {
                        Storage::delete($oldFilePath);
                    }
                }

                $userGroupArr = $request->input('user_group');
                if (!empty($userGroupArr)) {
                    UserGroupRelModel::where('u_id', $id)->whereNotIn('u_g_id', $userGroupArr)->delete();

                    $store2 = [];
                    foreach ($userGroupArr as $key => $value) {
                        $rowDataObj = UserGroupRelModel::getUserGroupRelData($id, $value, ['u_g_r_id', 'deleted_at']);
                        if ($rowDataObj) {
                            if ($rowDataObj->deleted_at) {
                                $rowDataObj->updated_id = $loginAdminId;
                                $rowDataObj->deleted_at = NULL;
                                $totAfctd = $rowDataObj->save();
                            } else {
                                $store2 = ['updated_id' => $loginAdminId];
                                $totAfctd = UserGroupRelModel::where(['u_g_r_id' => $rowDataObj->u_g_r_id, 'u_g_id' => $value, 'u_id' => $id])->update($store2);
                            }
                        } else {
                            $store2 = ['u_g_id' => $value, 'u_id' => $id, 'updated_id' => $loginAdminId];
                            $totAfctd = UserGroupRelModel::insert($store2);
                        }
                    }

                    if ($totAfctd == 0) {
                        DB::rollBack();

                        return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['update'])->with('title', $admin['error_ttl']);
                    } else {
                        $planId = $request->input('plan');
                        $userPlanArr = UserSubscription::getData(["u_id" => $id]);
                        if (!empty($userPlanArr) && $planId > 0) {
                            $exstPlanId = $userPlanArr['p_id'];
                            if ($exstPlanId > 0 && $planId != $exstPlanId) {
                                $planRow = Plans::getData(['p_id' => $planId, 'status' => $commonconstants['status_val'][1]]);
                                if ($planRow) {
                                    $today = date($commonconstants['y_m_d_frmt']);
                                    $endDate = Useful::dateadd(date($commonconstants['d_m_y_frmt']), $planRow->duration);

                                    $storeUs = $userPlanArr;

                                    $storeUs->p_id = $planRow->p_id;
                                    $storeUs->plan_type = $planRow->plan_type;
                                    $storeUs->start_date = $today;
                                    $storeUs->end_date = $endDate;
                                    $storeUs->status = $commonconstants['subscription_status_val']['value'][0];
                                    $storeUs->updated_by = $cuBy;
                                    $storeUs->updated_id = $loginAdminId;
                                    if (!$storeUs->save()) {
                                        DB::rollBack();

                                        return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['update'])->with('title', $admin['error_ttl']);
                                    }
                                }
                            }
                        }

                        DB::commit();

                        return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $message['success']['update'])->with('title', $admin['success_ttl']);
                    }
                }
            }
        } catch (QueryException $exception) {
            if (isset($path) && $path) {
                $exists = Storage::exists($path);
                if ($exists) {
                    Storage::delete($path);
                }
            }

            DB::rollBack();

            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            } else {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $message['error']['update'])->with('title', $admin['error_ttl']);
            }
        }
    }

    public function deletedata(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');
        try {
            $checkboxArr = $request->get('checkbox');
            if (count($checkboxArr) > 0) {
                DB::beginTransaction();

                \App\Models\EnquiryModel::whereIn('u_id', $checkboxArr)->delete();
                \App\Models\UserGroupRelModel::whereIn('u_id', $checkboxArr)->forceDelete();

                $dataArr = User::whereIn('u_id', $checkboxArr)->get();

                $delModel = User::whereIn('u_id', $checkboxArr)->delete();
                if ($delModel > 0) {
                    $upldDirName = $commonconstants['user_dir_name'] . "/";
                    foreach ($dataArr as $key => $value) {
                        $image = $value->p_picture;
                        if ($image) {
                            $path = $upldDirName . $image;
                            if (isset($path) && $path) {
                                $exists = Storage::exists($path);
                                if ($exists) {
                                    Storage::delete($path);
                                }
                            }
                        }
                    }
                    DB::commit();
                } else {
                    DB::rollBack();
                }
            }
        } catch (QueryException $exception) {
            DB::rollBack();

            if ($loginAdminId == Config('commonconstants.def_super_admin_id')) {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            } else {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.delete'))->with('title', __('admin.error_ttl'));
            }
        }

        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.delete'))->with('title', __('admin.success_ttl'));
    }

    public function deletepicture($id)
    {
        $loginAdminId = self::getLoggedInAdminId();
        $alertCss2 = Config('adminconstants.alert_css.2');
        $delErrMsg = __('message.error.delete');
        $errTtl = __('admin.error_ttl');
        try {
            DB::beginTransaction();

            $store = User::find($id);
            if ($store) {
                $image = $store->p_picture;

                $store->p_picture = '';

                $cuBy = Config('commonconstants.cu_by_val.1');

                $store->created_by = $cuBy;
                $store->created_id = $loginAdminId;
                $store->updated_by = $cuBy;
                $store->updated_id = $loginAdminId;

                if ($store->save()) {
                    if ($image) {
                        $upldDirName = Config('commonconstants.user_dir_name') . "/";
                        $path = $upldDirName . $image;
                        if (isset($path) && $path) {
                            $exists = Storage::exists($path);
                            if ($exists) {
                                Storage::delete($path);
                                DB::commit();
                            } else {
                                DB::rollBack();
                                return back()->with('alert', $alertCss2)->with('message', $delErrMsg)->with('title', $errTtl);
                            }
                        }
                    }
                } else {
                    return back()->with('alert', $alertCss2)->with('message', $delErrMsg)->with('title', $errTtl);
                }
            } else {
                return back()->with('alert', $alertCss2)->with('message', $delErrMsg)->with('title', $errTtl);
            }
        } catch (QueryException $exception) {
            if ($loginAdminId == Config('commonconstants.def_super_admin_id')) {
                return back()->with('alert', $alertCss2)->with('message', $exception->getMessage())->with('title', $errTtl)->withInput();
            } else {
                return back()->with('alert', $alertCss2)->with('message', $delErrMsg)->with('title', $errTtl);
            }
        }

        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.delete'))->with('title', __('admin.success_ttl'));
    }
}
