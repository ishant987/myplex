<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;
use Storage;
use Illuminate\Support\Facades\Hash;
use Auth;

use App\Lib\Core\Core;
use App\Lib\App\Common;

use App\Models\PageModel;
use App\Models\User;
// use App\Models\AskExpertQuestionModel;
// use App\Models\AnswerModel;
// use App\Models\LikeModel;
// use App\Models\BookmarkModel;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->defDataArr = self::getDefData();
        $this->page_path =env('PAGE_PATHS','web.pages');
    }

    /**
     _
     _ @return property guard use for login
     _
     **/
    public function guard()
    {
        return Auth::guard('web');
    }

    /* Changed by Saumen Laha */
    /* public function myAccountData(Request $request)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 36);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $commonconstants = Config('commonconstants');

            $userId = self::getLoggedInUserId();

            $defDataArr = array("media_folder" => Core::getUploadedURL($commonconstants['media_dir_name']));

            return view('themes.frontend.pages.myaccount', compact('dataArr', 'defDataArr'));
        }
        return abort(404);
    } */

    public function myAccountData(Request $request)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 54);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $commonconstants = Config('commonconstants');

            $userId = self::getLoggedInUserId();

            $defDataArr = array("media_folder" => Core::getUploadedURL($commonconstants['media_dir_name']));

            return view($this->page_path.'.performance-synopsis', compact('dataArr', 'defDataArr'));
        }
        return abort(404);
    }

    public function editProfileData(Request $request)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 20);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $user = User::find(self::getLoggedInUserId());

            $birthdayArr = ['0' => '', '1' => '', '2' => ''];
            if ($user->birthday != '') {
                $birthdayArr = explode("-", $user->birthday);
            }

            $commonconstants = Config('commonconstants');
            $webLang = __('web');

            $defDataArr = array("web_lang" => $webLang, "user_media_folder" => $commonconstants['user_dir_name']);
            $daysArr = User::days();
            $monthsArr = User::months();
            $yearArr = range(date('Y'), 1950);

            return view('themes.frontend.pages.edit-profile', compact('dataArr', 'defDataArr', 'user', 'birthdayArr', 'daysArr', 'monthsArr', 'yearArr'));
        }
        return abort(404);
    }

    public function updateProfile(Request $request)
    {
        $id = self::getLoggedInUserId();

        $commonconstants = Config('commonconstants');
        $frontconstants = Config('frontconstants');

        $message = __('message');
        $webLang = __('web');

        $vldtrRules = [
            'f_name' => 'required|string|max:255',
            'l_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',u_id',
            'mobile' => 'nullable|numeric',
            'company' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'pincode' => 'nullable|string|max:20',
            'birthday_day' => 'nullable|integer|min:1|max:31',
            'birthday_month' => 'nullable|integer|min:1|max:12',
            'birthday_year' => 'nullable|integer|min:1900|max:2100',
            'p_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:' . Config('frontconstants.img_upld_max_size') . ''
        ];

        $vldtrMessages = [
            'f_name.required' => __('front.validation.required.f_name'),
            'p_picture.mimes' => __('front.validation.img_file_upload_type'),
            'p_picture.max' => __('front.validation.img_file_upload_max_sz')
        ];

        $validator = Validator::make($request->all(), $vldtrRules, $vldtrMessages);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        try {
            $store = User::find($id);

            $exstEmail = $store->email;
            $exstPicture = $store->p_picture;
            $exstPincode = $store->pincode;

            $input = $request->only([
                'f_name',
                'l_name',
                'email',
                'mobile',
                'company',
                'city',
                'state',
                'address',
                'pincode',
            ]);

            foreach ($input as $key => $value) {
                $store->$key = is_string($value) ? trim($value) : $value;
            }

            $birthdayYear = trim((string) $request->input('birthday_year', ''));
            $birthdayMonth = trim((string) $request->input('birthday_month', ''));
            $birthdayDay = trim((string) $request->input('birthday_day', ''));

            if ($birthdayYear !== '' && $birthdayMonth !== '' && $birthdayDay !== '') {
                $store->birthday = sprintf('%04d-%02d-%02d', (int) $birthdayYear, (int) $birthdayMonth, (int) $birthdayDay);
            } else {
                $store->birthday = null;
            }

            if ($request->hasFile('p_picture')) {
                $upldDirName = $commonconstants['user_dir_name'];
                $file      = $request->file('p_picture');
                $title     = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                $filename  = $store->f_name . '-dp-' . time() . '-' . Core::removeSpecialChars($title) . '.' . $extension;

                $path      = $file->storeAs($upldDirName, $filename);
                if ($path) {
                    $store->p_picture = $filename;
                } else {
                    return back()->with('alert', $frontconstants['alert_css']['2'])->with('message', $message['error']['img_upload'])->with('title', $webLang['error_ttl']);
                }
            } else {
                $store->p_picture = $exstPicture;
            }

            $store->u_updated_medium = $commonconstants['medium']['value'][1];
            $store->updated_by = $commonconstants['cu_by_val'][2];
            $store->updated_id = $id;

            if ($store->save()) {
                if ($request->hasFile('p_picture') && $exstPicture) {
                    $oldFilePath = $upldDirName . '/' . $exstPicture;
                    $exists = Storage::exists($oldFilePath);
                    if ($exists) {
                        Storage::delete($oldFilePath);
                    }
                }

                if ($exstEmail != $request->email) {
                    $fullname = $store->f_name . " " . $store->l_name;
                    $subscriptionApi = Common::callSubscriptionApi($request->email, $fullname);
                }
            }
        } catch (QueryException $exception) {
            return back()->with('alert', $frontconstants['alert_css']['2'])->with('message', $message['error']['data_saved'])->with('title', $webLang['error_ttl']);
        }

        return back()->with('alert', $frontconstants['alert_css']['1'])->with('message', $message['success']['saved'])->with('title', $webLang['success_ttl']);
    }

    public function resetPasswordData(Request $request)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 33);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $webLang = __('web');

            $defDataArr = array("web_lang" => $webLang);

            return view('themes.frontend.pages.reset-password', compact('dataArr', 'defDataArr'));
        }
        return abort(404);
    }

    public function resetPassword(Request $request)
    {
        $id = self::getLoggedInUserId();
        $user = User::find($id);

        $validated = $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail(__('front.validation.cr_password'));
                    }
                }
            ],
            'new_password' => [
                'required', 'min:6', 'confirmed', 'different:current_password'
            ]
        ]);

        $commonconstants = Config('commonconstants');
        $frontconstants = Config('frontconstants');

        $webLang = __('web');

        $user->fill([
            'password' => Hash::make($validated['new_password']),
            'u_updated_medium' => $commonconstants['medium']['value'][1],
            'updated_by' => $commonconstants['cu_by_val'][2],
            'updated_id' => $id
        ])->save();

        Auth::logoutOtherDevices($validated['new_password']);
        $this->guard()->logout();

        return redirect()->route('web.login')->with('alert', $frontconstants['alert_css']['1'])->with('message', __('passwords.reset'))->with('title', $webLang['success_ttl']);
    }

    public function myQuestionsData(Request $request)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 29);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $commonconstants = Config('commonconstants');

            $dataList = [];

            $dataList = AskExpertQuestionModel::questionList(['status' => $commonconstants['status_val'][1], 'u_id' => self::getLoggedInUserId()], false, 'created_at', 'DESC', $commonconstants['pagination_no_front']);

            $defDataArr = array("media_folder" => Core::getUploadedURL($commonconstants['aeq_dir_name']), "user_media_folder" => $commonconstants['user_dir_name'], "askexpert_lang" => __('askexpert'), 'q_like_type' => $commonconstants['like_type']['value'][3], 'a_like_type' => $commonconstants['like_type']['value'][4], 'bookmark_type' => $commonconstants['bookmark_type']['value'][4], "video_type" => $commonconstants['video_type']['value']);

            return view('themes.frontend.pages.my-questions', compact('dataArr', 'defDataArr', 'dataList'));
        }

        return abort(404);
    }

    public function myAnswersData(Request $request)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 30);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $commonconstants = Config('commonconstants');

            $dataList = [];

            $dataList = AnswerModel::answerList(['status' => $commonconstants['status_val'][1], 'u_id' => self::getLoggedInUserId(), 'group_by' => 'aeq_id'], false, 'aeqa_id', 'DESC', $commonconstants['pagination_no_front']);

            $defDataArr = array("media_folder" => Core::getUploadedURL($commonconstants['aeq_dir_name']), "user_media_folder" => $commonconstants['user_dir_name'], "askexpert_lang" => __('askexpert'), 'q_like_type' => $commonconstants['like_type']['value'][3], 'a_like_type' => $commonconstants['like_type']['value'][4], 'bookmark_type' => $commonconstants['bookmark_type']['value'][4], "video_type" => $commonconstants['video_type']['value']);
            //dd($dataList);

            return view('themes.frontend.pages.my-answers', compact('dataArr', 'defDataArr', 'dataList'));
        }
        return abort(404);
    }

    public function answerDraftData(Request $request)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 31);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $commonconstants = Config('commonconstants');

            $dataList = [];

            $dataList = AnswerModel::answerList(['status' => $commonconstants['status_val'][3], 'u_id' => self::getLoggedInUserId()], false, 'aeqa_id', 'DESC', $commonconstants['pagination_no_front']);

            $defDataArr = array("user_media_folder" => $commonconstants['user_dir_name'], "askexpert_lang" => __('askexpert'));

            return view('themes.frontend.pages.draft-answers', compact('dataArr', 'defDataArr', 'dataList'));
        }
        return abort(404);
    }

    public function likedQuestionsData(Request $request)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 23);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $commonconstants = Config('commonconstants');

            $dataList = [];

            $dataList = AskExpertQuestionModel::questionList(['status' => $commonconstants['status_val'][1], 'like_u_id' => self::getLoggedInUserId(), 'liked' => true], false, 'created_at', 'DESC', $commonconstants['pagination_no_front']);

            $defDataArr = array("media_folder" => Core::getUploadedURL($commonconstants['aeq_dir_name']), "user_media_folder" => $commonconstants['user_dir_name'], "askexpert_lang" => __('askexpert'), 'q_like_type' => $commonconstants['like_type']['value'][3], 'a_like_type' => $commonconstants['like_type']['value'][4], 'bookmark_type' => $commonconstants['bookmark_type']['value'][4], "video_type" => $commonconstants['video_type']['value']);

            return view('themes.frontend.pages.my-questions', compact('dataArr', 'defDataArr', 'dataList'));
        }
        return abort(404);
    }

    public function likedAnswersData(Request $request)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 52);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $commonconstants = Config('commonconstants');

            $dataList = [];

            $dataList = AnswerModel::answerList(['status' => $commonconstants['status_val'][1], 'like_u_id' => self::getLoggedInUserId(), 'liked' => true], false, 'created_at', 'DESC', $commonconstants['pagination_no_front']);

            $defDataArr = array("media_folder" => Core::getUploadedURL($commonconstants['aeq_dir_name']), "user_media_folder" => $commonconstants['user_dir_name'], "askexpert_lang" => __('askexpert'), 'q_like_type' => $commonconstants['like_type']['value'][3], 'a_like_type' => $commonconstants['like_type']['value'][4], 'bookmark_type' => $commonconstants['bookmark_type']['value'][4], "video_type" => $commonconstants['video_type']['value']);

            return view('themes.frontend.pages.my-answers', compact('dataArr', 'defDataArr', 'dataList'));
        }
        return abort(404);
    }
}
