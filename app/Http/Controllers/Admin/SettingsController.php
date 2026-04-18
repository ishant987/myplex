<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;
use Storage;

use App\Lib\Core\Core;

use App\Models\SettingsModel;
use Illuminate\Support\Collection;

class SettingsController extends BaseController
{
    protected function defaultRazorpaySettings(): array
    {
        return [
            [
                'field_type' => 'text',
                'field_label' => 'Razorpay Key ID',
                'option_key' => 'razorpay_key_id',
                'option_value' => config('razorpay.key_id'),
                'options_label' => null,
                'options_value' => null,
                'type' => Config('commonconstants.setting_type_options'),
                'field_info' => 'Public Razorpay key used during checkout.',
                'is_required' => 'y',
                'c_order' => 101,
                'status' => Config('commonconstants.status_val.1'),
                'updated_id' => self::getLoggedInAdminId() ?: 0,
                'updated_at' => now(),
            ],
            [
                'field_type' => 'text',
                'field_label' => 'Razorpay Key Secret',
                'option_key' => 'razorpay_key_secret',
                'option_value' => config('razorpay.key_secret'),
                'options_label' => null,
                'options_value' => null,
                'type' => Config('commonconstants.setting_type_options'),
                'field_info' => 'Secret Razorpay key used for server-side requests.',
                'is_required' => 'y',
                'c_order' => 102,
                'status' => Config('commonconstants.status_val.1'),
                'updated_id' => self::getLoggedInAdminId() ?: 0,
                'updated_at' => now(),
            ],
            [
                'field_type' => 'text',
                'field_label' => 'Razorpay Webhook Secret',
                'option_key' => 'razorpay_webhook_secret',
                'option_value' => config('razorpay.webhook_secret'),
                'options_label' => null,
                'options_value' => null,
                'type' => Config('commonconstants.setting_type_options'),
                'field_info' => 'Webhook secret for verifying Razorpay callbacks.',
                'is_required' => 'n',
                'c_order' => 103,
                'status' => Config('commonconstants.status_val.1'),
                'updated_id' => self::getLoggedInAdminId() ?: 0,
                'updated_at' => now(),
            ],
            [
                'field_type' => 'text',
                'field_label' => 'Razorpay Currency',
                'option_key' => 'razorpay_currency',
                'option_value' => config('razorpay.currency', 'INR'),
                'options_label' => null,
                'options_value' => null,
                'type' => Config('commonconstants.setting_type_options'),
                'field_info' => 'Currency sent while creating Razorpay orders.',
                'is_required' => 'y',
                'c_order' => 104,
                'status' => Config('commonconstants.status_val.1'),
                'updated_id' => self::getLoggedInAdminId() ?: 0,
                'updated_at' => now(),
            ],
            [
                'field_type' => 'text',
                'field_label' => 'Razorpay Company Name',
                'option_key' => 'razorpay_company_name',
                'option_value' => config('razorpay.company_name', 'MyPlexus'),
                'options_label' => null,
                'options_value' => null,
                'type' => Config('commonconstants.setting_type_options'),
                'field_info' => 'Company name shown in the Razorpay checkout.',
                'is_required' => 'y',
                'c_order' => 105,
                'status' => Config('commonconstants.status_val.1'),
                'updated_id' => self::getLoggedInAdminId() ?: 0,
                'updated_at' => now(),
            ],
        ];
    }

    protected function razorpaySettingKeys(): array
    {
        return [
            'razorpay_key_id',
            'razorpay_key_secret',
            'razorpay_webhook_secret',
            'razorpay_currency',
            'razorpay_company_name',
        ];
    }

    protected function ensureRazorpaySettingsExist(): void
    {
        foreach ($this->defaultRazorpaySettings() as $setting) {
            SettingsModel::firstOrCreate(
                ['option_key' => $setting['option_key']],
                $setting
            );
        }
    }

    protected function getSettingsByKeys(array $keys, int $status)
    {
        return SettingsModel::whereIn('option_key', $keys)
            ->where('status', '=', $status)
            ->orderBy('c_order', 'ASC')
            ->get();
    }

    protected function updateSettingsCollection(Collection $dataObj, array $input, int $loginAdminId, string $type): int
    {
        $save = 0;

        foreach ($dataObj as $value) {
            $store = [
                'option_value' => $input[$value->option_key] ?? $value->option_value,
                'updated_id' => $loginAdminId,
            ];

            $save = SettingsModel::where(['type' => $type, 'option_id' => $value->option_id])->update($store);
        }

        return $save;
    }

    public function editGeneral()
    {
        $commonconstants = Config('commonconstants');

        $type = $commonconstants['setting_type_general'];

        $dataObj = SettingsModel::getSettingsFields( $type, $commonconstants['status_val']['1'] );

        $moduleAtrArr = self::getModuleVars();
        $editDataAtrArr = ["title" => __('admin.settings.general_txt'), "route" => 'settings.general', "postroute" => 'admin.settings.general.update'];

        return view('themes.backend.pages.setting.settingform', compact('dataObj', 'moduleAtrArr', 'editDataAtrArr'));
    }

    public function updateGeneral(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');

        $type = $commonconstants['setting_type_general'];

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'logo' => 'nullable|file|image|mimes:jpeg,jpg,png|max:'.$commonconstants['img_upld_max_size'].'',
            'email_template_logo' => 'nullable|file|image|mimes:jpeg,jpg,png|max:'.$commonconstants['img_upld_max_size'].'',
            'menu_logo' => 'nullable|file|image|mimes:jpeg,jpg,png|max:'.$commonconstants['img_upld_max_size'].'',
            'from_email' => 'required|email',
            'to_email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        \DB::beginTransaction();

        try {
            $input = $request->except('_method', '_token', 'submit');

            $dataObj = SettingsModel::getSettingsFields( $type, $commonconstants['status_val']['1'] );

            if($dataObj){
                $store = [];
                $upldDirName = $commonconstants['setting_dir_name'];
                foreach ($dataObj as $value) {
                    switch ($value->field_type) {
                        case 'image':
                            $exstImage = '';
                            $exstImage = $value->option_value;
                            if ($request->hasFile($value->option_key)) {
                                $file      = $request->file($value->option_key);
                                $filename  = time().'-'.$file->getClientOriginalName();
                                $path      = $file->storeAs($upldDirName, $filename);
                                if($path){
                                    $dataValue = $filename;
                                }
                                else{
                                    return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.img_upload'))->with('title', __('admin.error_ttl'));
                                }
                            }
                            else{
                                $dataValue = $exstImage;
                            }
                            break;
                        default:
                            $dataValue = $input[$value->option_key];
                            break;
                    }
                    $store['option_value'] = $dataValue;
                    $store['updated_id'] = $loginAdminId;

                    $save = SettingsModel::where(['type' => $type, 'option_id' => $value->option_id])->update($store);
                    if($save > 0){
                        if($value->field_type == 'image' && $request->hasFile($value->option_key) && $exstImage)
                        {
                            $oldFilePath = $upldDirName.'/'.$exstImage;
                            $exists = Storage::exists($oldFilePath);
                            if($exists){
                                Storage::delete($oldFilePath);
                            }
                        }
                    }
                }

                if($save > 0){
                    \DB::commit();

                    return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.update'))->with('title', __('admin.success_ttl'));
                }
            }
        } catch (QueryException $exception) {
            \DB::rollBack();

            if(isset($path) && $path){
                $exists = Storage::exists($path);
                if($exists){
                    Storage::delete($path);
                }
            }

            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            }
            else{
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.update'))->with('title', __('admin.error_ttl'));
            }
        }
    }

    public function editOptions()
    {
        $commonconstants = Config('commonconstants');

        $type = $commonconstants['setting_type_options'];

        $dataObj = SettingsModel::where('type', '=', $type)
            ->where('status', '=', $commonconstants['status_val']['1'])
            ->whereNotIn('option_key', $this->razorpaySettingKeys())
            ->orderBy('c_order', 'ASC')
            ->get();

        $moduleAtrArr = self::getModuleVars();
        $editDataAtrArr = ["title" => __('admin.settings.options_txt'), "route" => 'settings.options', "postroute" => 'admin.settings.options.update'];

        return view('themes.backend.pages.setting.settingform', compact('dataObj', 'moduleAtrArr', 'editDataAtrArr'));
    }

    public function updateOptions(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');

        $type = $commonconstants['setting_type_options'];

        $validator = Validator::make($request->all(), [
            'push_notification_status' => 'required',
            'fcm_key' => 'required_if:push_notification_status,y',
            'share_text' => 'required',
            'latest_android_version' => 'required',
            'google_play_app_link' => 'required',
            'latest_ios_version' => 'required',
            'apple_store_app_link' => 'required'
        ], [
            'fcm_key.required_if' => __('admin.validation.fcm_key')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        \DB::beginTransaction();

        try {
            $input = $request->except('_method', '_token', 'submit');

            $dataObj = SettingsModel::where('type', '=', $type)
                ->where('status', '=', $commonconstants['status_val']['1'])
                ->whereNotIn('option_key', $this->razorpaySettingKeys())
                ->orderBy('c_order', 'ASC')
                ->get();

            if($dataObj){
                $store = [];
                $upldDirName = $commonconstants['setting_dir_name'];
                foreach ($dataObj as $value) {
                    switch ($value->field_type) {
                        case 'image':
                            $exstImage = '';
                            $exstImage = $value->option_value;
                            if ($request->hasFile($value->option_key)) {
                                $file      = $request->file($value->option_key);
                                $filename  = time().'-'.$file->getClientOriginalName();
                                $path      = $file->storeAs($upldDirName, $filename);
                                if($path){
                                    $dataValue = $filename;
                                }
                                else{
                                    return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.img_upload'))->with('title', __('admin.error_ttl'));
                                }
                            }
                            else{
                                $dataValue = $exstImage;
                            }
                            break;
                        default:
                            $dataValue = $input[$value->option_key];
                            break;
                    }
                    $store['option_value'] = $dataValue;
                    $store['updated_id'] = $loginAdminId;

                    $save = SettingsModel::where(['type' => $type, 'option_id' => $value->option_id])->update($store);
                    if($save > 0){
                        if($value->field_type == 'image' && $request->hasFile($value->option_key) && $exstImage)
                        {
                            $oldFilePath = $upldDirName.'/'.$exstImage;
                            $exists = Storage::exists($oldFilePath);
                            if($exists){
                                Storage::delete($oldFilePath);
                            }
                        }
                    }
                }

                if($save > 0){
                    \DB::commit();

                    return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.update'))->with('title', __('admin.success_ttl'));
                }
            }
        } catch (QueryException $exception) {
            \DB::rollBack();

            if(isset($path) && $path){
                $exists = Storage::exists($path);
                if($exists){
                    Storage::delete($path);
                }
            }

            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            }
            else{
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.update'))->with('title', __('admin.error_ttl'));
            }
        }
    }

    public function editRazorpay()
    {
        $commonconstants = Config('commonconstants');
        $this->ensureRazorpaySettingsExist();

        $dataObj = $this->getSettingsByKeys($this->razorpaySettingKeys(), $commonconstants['status_val']['1']);

        $moduleAtrArr = self::getModuleVars();
        $editDataAtrArr = ["title" => __('admin.settings.razorpay_txt'), "route" => 'settings.razorpay', "postroute" => 'admin.settings.razorpay.update'];

        return view('themes.backend.pages.setting.settingform', compact('dataObj', 'moduleAtrArr', 'editDataAtrArr'));
    }

    public function updateRazorpay(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();
        $commonconstants = Config('commonconstants');

        $validator = Validator::make($request->all(), [
            'razorpay_key_id' => 'required|string|max:255',
            'razorpay_key_secret' => 'required|string|max:255',
            'razorpay_webhook_secret' => 'nullable|string|max:255',
            'razorpay_currency' => 'required|string|max:10',
            'razorpay_company_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        \DB::beginTransaction();

        try {
            $this->ensureRazorpaySettingsExist();
            $input = $request->except('_method', '_token', 'submit');
            $dataObj = $this->getSettingsByKeys($this->razorpaySettingKeys(), $commonconstants['status_val']['1']);

            if ($dataObj->isNotEmpty()) {
                $this->updateSettingsCollection($dataObj, $input, $loginAdminId, $commonconstants['setting_type_options']);

                \DB::commit();

                return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.update'))->with('title', __('admin.success_ttl'));
            }

            \DB::rollBack();

            return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.update'))->with('title', __('admin.error_ttl'));
        } catch (QueryException $exception) {
            \DB::rollBack();

            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            }

            return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.update'))->with('title', __('admin.error_ttl'));
        }
    }

    public function editMail()
    {
        $commonconstants = Config('commonconstants');

        $type = $commonconstants['setting_type_mail_stng'];

        $dataObj = SettingsModel::getSettingsFields( $type, $commonconstants['status_val']['1'] );

        $moduleAtrArr = self::getModuleVars();
        $editDataAtrArr = ["title" => __('admin.settings.mail_txt'), "route" => 'settings.mail', "postroute" => 'admin.settings.mail.update'];

        return view('themes.backend.pages.setting.settingform', compact('dataObj', 'moduleAtrArr', 'editDataAtrArr'));
    }

    public function updateMail(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');

        $type = $commonconstants['setting_type_mail_stng'];

        $validator = Validator::make($request->all(), [
            'mail_protocol' => 'required',
            'smtp_secure' => 'nullable',
            'smtp_hostname' => 'required',
            'smtp_port' => 'required',
            'smtp_username' => 'required',
            'smtp_password' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        \DB::beginTransaction();

        try {
            $input = $request->except('_method', '_token', 'submit');

            $dataObj = SettingsModel::getSettingsFields($type, $commonconstants['status_val']['1']);

            if($dataObj){
                $store = [];
                $upldDirName = $commonconstants['setting_dir_name'];
                foreach ($dataObj as $value) {
                    switch ($value->field_type) {
                        case 'image':
                            $exstImage = '';
                            $exstImage = $value->option_value;
                            if ($request->hasFile($value->option_key)) {
                                $file      = $request->file($value->option_key);
                                $filename  = time().'-'.$file->getClientOriginalName();
                                $path      = $file->storeAs($upldDirName, $filename);
                                if($path){
                                    $dataValue = $filename;
                                }
                                else{
                                    return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.img_upload'))->with('title', __('admin.error_ttl'));
                                }
                            }
                            else{
                                $dataValue = $exstImage;
                            }
                            break;
                        default:
                            $dataValue = $input[$value->option_key];
                            break;
                    }
                    $store['option_value'] = $dataValue;
                    $store['updated_id'] = $loginAdminId;

                    $save = SettingsModel::where(['type' => $type, 'option_id' => $value->option_id])->update($store);
                    if($save > 0){
                        if($value->field_type == 'image' && $request->hasFile($value->option_key) && $exstImage)
                        {
                            $oldFilePath = $upldDirName.'/'.$exstImage;
                            $exists = Storage::exists($oldFilePath);
                            if($exists){
                                Storage::delete($oldFilePath);
                            }
                        }
                    }
                }

                if($save > 0){
                    \DB::commit();

                    return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.update'))->with('title', __('admin.success_ttl'));
                }
            }
        } catch (QueryException $exception) {
            \DB::rollBack();

            if(isset($path) && $path){
                $exists = Storage::exists($path);
                if($exists){
                    Storage::delete($path);
                }
            }

            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            }
            else{
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.update'))->with('title', __('admin.error_ttl'));
            }
        }
    }

    public function editCustom()
    {
        $commonconstants = Config('commonconstants');

        $type = $commonconstants['setting_type_custom_stng'];

        $dataObj = SettingsModel::getSettingsFields( $type, $commonconstants['status_val']['1'] );

        $moduleAtrArr = self::getModuleVars();
        $editDataAtrArr = ["title" => __('admin.settings.custom_txt'), "route" => 'settings.custom', "postroute" => 'admin.settings.custom.update'];

        return view('themes.backend.pages.setting.settingform', compact('dataObj', 'moduleAtrArr', 'editDataAtrArr'));
    }

    public function updateCustom(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');

        $type = $commonconstants['setting_type_custom_stng'];

        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        \DB::beginTransaction();

        try {
            $input = $request->except('_method', '_token', 'submit');

            $dataObj = SettingsModel::getSettingsFields( $type, $commonconstants['status_val']['1'] );

            if($dataObj){
                $store = [];
                $upldDirName = $commonconstants['setting_dir_name'];
                foreach ($dataObj as $value) {
                    switch ($value->field_type) {
                        case 'image':
                            $exstImage = '';
                            $exstImage = $value->option_value;
                            if ($request->hasFile($value->option_key)) {
                                $file      = $request->file($value->option_key);
                                $filename  = time().'-'.$file->getClientOriginalName();
                                $path      = $file->storeAs($upldDirName, $filename);
                                if($path){
                                    $dataValue = $filename;
                                }
                                else{
                                    return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.img_upload'))->with('title', __('admin.error_ttl'));
                                }
                            }
                            else{
                                $dataValue = $exstImage;
                            }
                            break;
                        default:
                            $dataValue = $input[$value->option_key];
                            break;
                    }
                    $store['option_value'] = $dataValue;
                    $store['updated_id'] = $loginAdminId;

                    $save = SettingsModel::where(['type' => $type, 'option_id' => $value->option_id])->update($store);
                    if($save > 0){
                        if($value->field_type == 'image' && $request->hasFile($value->option_key) && $exstImage)
                        {
                            $oldFilePath = $upldDirName.'/'.$exstImage;
                            $exists = Storage::exists($oldFilePath);
                            if($exists){
                                Storage::delete($oldFilePath);
                            }
                        }
                    }
                }

                if($save > 0){
                    \DB::commit();

                    return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.update'))->with('title', __('admin.success_ttl'));
                }
            }
        } catch (QueryException $exception) {
            \DB::rollBack();

            if(isset($path) && $path){
                $exists = Storage::exists($path);
                if($exists){
                    Storage::delete($path);
                }
            }

            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            }
            else{
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.update'))->with('title', __('admin.error_ttl'));
            }
        }
    }

    public function editSocial()
    {
        $commonconstants = Config('commonconstants');

        $type = $commonconstants['setting_type_social_stng'];

        $dataObj = SettingsModel::getSettingsFields( $type, $commonconstants['status_val']['1'] );

        $moduleAtrArr = self::getModuleVars();
        $editDataAtrArr = ["title" => __('admin.settings.social_txt'), "route" => 'settings.social', "postroute" => 'admin.settings.social.update'];

        return view('themes.backend.pages.setting.settingform', compact('dataObj', 'moduleAtrArr', 'editDataAtrArr'));
    }

    public function updateSocial(Request $request)
    {
        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');

        $type = $commonconstants['setting_type_social_stng'];

        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        \DB::beginTransaction();

        try {
            $input = $request->except('_method', '_token', 'submit');

            $dataObj = SettingsModel::getSettingsFields( $type, $commonconstants['status_val']['1'] );

            if($dataObj){
                $store = [];
                $upldDirName = $commonconstants['setting_dir_name'];
                foreach ($dataObj as $value) {
                    switch ($value->field_type) {
                        case 'image':
                            $exstImage = '';
                            $exstImage = $value->option_value;
                            if ($request->hasFile($value->option_key)) {
                                $file      = $request->file($value->option_key);
                                $filename  = time().'-'.$file->getClientOriginalName();
                                $path      = $file->storeAs($upldDirName, $filename);
                                if($path){
                                    $dataValue = $filename;
                                }
                                else{
                                    return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.img_upload'))->with('title', __('admin.error_ttl'));
                                }
                            }
                            else{
                                $dataValue = $exstImage;
                            }
                            break;
                        default:
                            $dataValue = $input[$value->option_key];
                            break;
                    }
                    $store['option_value'] = $dataValue;
                    $store['updated_id'] = $loginAdminId;

                    $save = SettingsModel::where(['type' => $type, 'option_id' => $value->option_id])->update($store);
                    if($save > 0){
                        if($value->field_type == 'image' && $request->hasFile($value->option_key) && $exstImage)
                        {
                            $oldFilePath = $upldDirName.'/'.$exstImage;
                            $exists = Storage::exists($oldFilePath);
                            if($exists){
                                Storage::delete($oldFilePath);
                            }
                        }
                    }
                }

                if($save > 0){
                    \DB::commit();

                    return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.update'))->with('title', __('admin.success_ttl'));
                }
            }
        } catch (QueryException $exception) {
            \DB::rollBack();

            if(isset($path) && $path){
                $exists = Storage::exists($path);
                if($exists){
                    Storage::delete($path);
                }
            }

            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            }
            else{
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.update'))->with('title', __('admin.error_ttl'));
            }
        }
    }

    public function deletefile($id)
    {
        $loginAdminId = self::getLoggedInAdminId();
        $alertCss2 = Config('adminconstants.alert_css.2');
        $delErrMsg = __('message.error.delete');
        $errTtl = __('admin.error_ttl');
        $commonconstants = Config('commonconstants');

        try {
            \DB::beginTransaction();

            $store = SettingsModel::find($id);
            if($store){
                $file = $store->option_value;

                $store->option_value = '';

                $store->updated_id = $loginAdminId;

                if($store->save()){
                    if($file){
                        $upldDirName = $commonconstants['setting_dir_name']."/";
                        $path = $upldDirName.$file;
                        if(isset($path) && $path){
                            $exists = Storage::exists($path);
                            if($exists){
                                Storage::delete($path);
                                \DB::commit();
                            }
                            else{
                                \DB::rollBack();
                                return back()->with('alert', $alertCss2)->with('message', $delErrMsg)->with('title', $errTtl);
                            }
                        }
                    }
                }
                else{
                    return back()->with('alert', $alertCss2)->with('message', $delErrMsg)->with('title', $errTtl);
                }
            }
            else{
                return back()->with('alert', $alertCss2)->with('message', $delErrMsg)->with('title', $errTtl);
            }
        } catch (QueryException $exception) {
            \DB::rollBack();

            if($loginAdminId == $commonconstants['def_super_admin_id']){
                return back()->with('alert', $alertCss2)->with('message', $exception->getMessage())->with('title', $errTtl)->withInput();
            }
            else{
                return back()->with('alert', $alertCss2)->with('message', $delErrMsg)->with('title', $errTtl);
            }
        }

        return back()->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('message.success.delete'))->with('title', __('admin.success_ttl'));
    }


    public static function getModuleVars(){
        $commonconstants = Config('commonconstants');
        $langadmin =  __('admin');

        return ["y_n_val" => $commonconstants['y_n_val'], "def_drop_optn" => $langadmin['def_drop_optn_styl1_txt'], "view_txt" => $langadmin['view_txt'], "target" => $commonconstants['target_opt1'], "media_folder" => Core::getUploadedURL($commonconstants['setting_dir_name']), "img_width" => Config('adminconstants.image_width'), "remove_txt" => $langadmin['remove_txt']];
    }
}
