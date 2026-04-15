<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;
use Illuminate\Validation\Rule;
// use Illuminate\Support\Str;
use Auth;
use DB;

use App\Lib\Core\MailPS;
// use App\Lib\App\Common;
use App\Lib\Core\Useful;

use App\Models\PageModel;
use App\Models\User;
use App\Models\UserGroupRelModel;
use Session;

// use Socialite;

class AuthController extends BaseController
{
    protected function establishFrontendSession(Request $request, User $user): void
    {
        $request->session()->regenerate();

        $user->update([
            'session_token' => $request->session()->getId(),
            'is_session_active' => true,
        ]);
    }

    protected $redirectTo = '/myaccount'; //..if needed then use to redirect else leave..

    /**
     **_ Create a new controller instance.
    _**
     **_ @return void
    _**/
    public function __construct()
    {
        $this->middleware('guest:web')->except('logout');
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

    public function signupData(Request $request)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 34);		
		//dd($dataArr);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = array("web_lang" => __('web'));

            return view('themes.frontend.pages.signup', compact('dataArr', 'defDataArr'));
        }
        return abort(404);
    }
	
	public function investorsignupData(Request $request)
	{		
		 $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 53);
		//dd($dataArr);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = array("web_lang" => __('web'));
			
			return view($this->page_path.'.investor.create-investor', compact('dataArr', 'defDataArr'));
		}
	}
	
	public function investorsignupsave(Request $request)
	{
		//dd( $request->all() );
		
		$commonconstants = Config('commonconstants');
        $frontconstants = Config('frontconstants');

        $message = __('message');
        $webLang = __('web');
        $resArr['msg'] = "";
        $resArr['url'] = "";	
		$authLang = __('auth');
		
            $vldtrRules = [
                'f_name' => 'required',
                'email'  => 'required|email|unique:users',
                'user_type' => 'required'                
            ];

            $vldtrMessages = [
                'f_name.required' => __('front.validation.required.f_name')
            ];

            $validator = Validator::make($request->all(), $vldtrRules, $vldtrMessages);

            if ($validator->fails()) {
                // $resArr['msg'] = $validator->getMessageBag();
                // return json_encode($resArr);
                $html = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                        <strong>' . $webLang['error_ttl'] . '&nbsp;</strong>';
                if ($validator->getMessageBag()->toArray()) {
                    $html .= '<ul>';
                    foreach ($validator->getMessageBag()->toArray() as $errors) {
                        foreach ($errors as $error) {
                            $html .= '<li>' . $error . '</li>';
                        }
                    }
                    $html .= '</ul>';
                }
                $html .= '</div>';
                $resArr['msg'] = $html;
                return json_encode($resArr);
            }
			
			try {
				
				
				$dataSavedErrMsg = $message['error']['saved'];
                $cuBy = $commonconstants['cu_by_val'][2];
                $cuMedium = $commonconstants['medium']['value'][1];
                $accType = Config('auth.acc_type.value.0');
                $defAdminId = $commonconstants['def_super_admin_id'];
                $defUsrGrpId = $commonconstants['def_sbsrbd_usr_grp_id'];

                DB::beginTransaction();

                $email = $request->email;
                $genUsrPswdNo = $commonconstants['gen_usr_password_no'];
                //$password = Useful::generateStrongPassword($genUsrPswdNo);				
				$password = 'admin123#';
				
				//dd($password);

                $store = $store2 = new User();
                $store->acc_type = $accType;
                $store->f_name = $request->f_name;
                $store->l_name = $request->l_name;
                $store->email = $email;
                $store->password = bcrypt($password);               
                $store->status           = $commonconstants['status_val'][1];
                $store->is_approved      = $commonconstants['y_n_val'][1];
                $store->created_by       = $cuBy;
                $store->created_id       = 0;
				$store->user_type		 = $request->user_type;
				$store->is_contacted_with_team = $request->is_contacted_with_team;
                if ($store->save()) {					
					$userId = $store->u_id;
                    $store2->created_id       = $userId;
                    $store2->updated_by       = $cuBy;
                    $store2->updated_id       = $userId;
					
					if ($store2->save()) {
                        $role = new UserGroupRelModel();
                        $role->u_g_id       = $defUsrGrpId;
                        $role->u_id         = $userId;
                        $role->updated_id   = $defAdminId;
                        if ($role->save()) {
                            DB::commit();

                            $fullname = rtrim($request->f_name . " " . $request->l_name);

                            session()->put('useremail', $email);
                            session()->put('username', $fullname);                            
						}
					}
					
					
                                /*attempt to do the login*/
                                if (Auth::attempt(['email' => $email, 'password' => $password])) {
                                    $this->establishFrontendSession($request, Auth::user());
                                    $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['1'] . '">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                                        <strong>' . $webLang['success_ttl'] . '&nbsp;</strong> 
                                        ' . $authLang['success']['su_signup'] . '
                                    </div>';

                                    $resArr['url'] = route('web.myaccount');
                                } else {
                                    $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                                        <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                                        ' . $authLang['failed'] . '
                                    </div>';
                                }
					
				} else {
					
					DB::rollBack();
				
				}	
			
			} catch(QueryException $exception)
			{
				DB::rollBack();
				$resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                    <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                    ' . $dataSavedErrMsg . '
                </div>';
			}
		
		return json_encode($resArr);
		
	}

    public function signup(Request $request)
    {
        $commonconstants = Config('commonconstants');
        $frontconstants = Config('frontconstants');

        $message = __('message');
        $webLang = __('web');
        $resArr['msg'] = "";
        $resArr['url'] = "";

        $vars = array(
            'secret' => $commonconstants['recaptcha']['secret_key'],
            "response" => $request->input('recaptcha_v3')
        );

        $url = "https://www.google.com/recaptcha/api/siteverify";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        $encoded_response = curl_exec($ch);
        $response = json_decode($encoded_response, true);
        curl_close($ch);

        if ($response['success'] && $response['action'] == 'signup_form' && $response['score'] > $commonconstants['recaptcha']['score']) {
            $vldtrRules = [
                'f_name' => 'required',
                'email'  => 'required|email|unique:users',
                'mobile' => 'required|numeric',
                'pincode' => 'required|numeric'
            ];

            $vldtrMessages = [
                'f_name.required' => __('front.validation.required.f_name')
            ];

            $validator = Validator::make($request->all(), $vldtrRules, $vldtrMessages);

            if ($validator->fails()) {
                // $resArr['msg'] = $validator->getMessageBag();
                // return json_encode($resArr);
                $html = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                        <strong>' . $webLang['error_ttl'] . '&nbsp;</strong>';
                if ($validator->getMessageBag()->toArray()) {
                    $html .= '<ul>';
                    foreach ($validator->getMessageBag()->toArray() as $errors) {
                        foreach ($errors as $error) {
                            $html .= '<li>' . $error . '</li>';
                        }
                    }
                    $html .= '</ul>';
                }
                $html .= '</div>';
                $resArr['msg'] = $html;
                return json_encode($resArr);
            }

            try {
				
                $dataSavedErrMsg = $message['error']['saved'];
                $cuBy = $commonconstants['cu_by_val'][2];
                $cuMedium = $commonconstants['medium']['value'][1];
                $accType = Config('auth.acc_type.value.0');
                $defAdminId = $commonconstants['def_super_admin_id'];
                $defUsrGrpId = $commonconstants['def_sbsrbd_usr_grp_id'];

                DB::beginTransaction();

                $email = $request->email;
                $genUsrPswdNo = $commonconstants['gen_usr_password_no'];
                $password = Useful::generateStrongPassword($genUsrPswdNo);

                $store = $store2 = new User();
                $store->acc_type = $accType;
                $store->f_name = $request->f_name;
                $store->l_name = $request->l_name;
                $store->email = $email;
                $store->password = bcrypt($password);
                $store->mobile = $request->mobile;
                $store->pincode = $request->pincode;
                $store->company = $request->company;
                $store->status           = $commonconstants['status_val'][1];
                $store->is_approved      = $commonconstants['y_n_val'][1];
                $store->trial_ends_at    = now()->addDays(14);
                $store->subscription_status = 'trial';
                $store->created_by       = $cuBy;
                $store->created_id       = 0;
                if ($store->save()) {
                    $userId = $store->u_id;
                    $store2->created_id       = $userId;
                    $store2->updated_by       = $cuBy;
                    $store2->updated_id       = $userId;
                    if ($store2->save()) {
                        $role = new UserGroupRelModel();
                        $role->u_g_id       = $defUsrGrpId;
                        $role->u_id         = $userId;
                        $role->updated_id   = $defAdminId;
                        if ($role->save()) {
                            DB::commit();

                            $fullname = rtrim($request->f_name . " " . $request->l_name);

                            session()->put('useremail', $email);
                            session()->put('username', $fullname);

                            $mailPSObj = new MailPS();
                            $mailCssAtr = $mailPSObj->getEmailHtmlCssAtr();

                            $mailArr = ["fullname" => $fullname, "email" => $email, "password" => $password];

                            $authLang = __('auth');

                            $subject    = $authLang['su_reg_mail_sbjct'];
                            $content    = view('emails.web.to-user-signup', compact('mailArr', 'mailCssAtr'));
                            $fromName   = $authLang['su_reg_mail_f_name'];

                            $mailResp = $mailPSObj->sendMail($email, $subject, $content, '', $fromName);
                            if ($mailResp) {
                                /*attempt to do the login*/
                                if (Auth::attempt(['email' => $email, 'password' => $password])) {
                                    Auth::user()->update([
                                        'session_token' => session()->getId(),
                                        'is_session_active' => true,
                                    ]);
                                    $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['1'] . '">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                                        <strong>' . $webLang['success_ttl'] . '&nbsp;</strong> 
                                        ' . $authLang['success']['su_signup'] . '
                                    </div>';

                                    $resArr['url'] = route('web.myaccount');
                                } else {
                                    $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                                        <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                                        ' . $authLang['failed'] . '
                                    </div>';
                                }
                            } else {
                                $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                                    <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                                    ' . $message['error']['email_send'] . '
                                </div>';
                            }
                        } else {
                            DB::rollBack();

                            $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                                <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                                ' . $dataSavedErrMsg . '
                            </div>';
                        }
                    } else {
                        DB::rollBack();

                        $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                            <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                            ' . $dataSavedErrMsg . '
                        </div>';
                    }
                } else {
                    DB::rollBack();

                    $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                        <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                        ' . $dataSavedErrMsg . '
                    </div>';
                }
            } catch (QueryException $exception) {
                // $resArr['msg'] = $store;
                // return json_encode($resArr);
                $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                    <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                    ' . $dataSavedErrMsg . '
                </div>';
            }
        } else {
            /*
            then probably this is a bot
            you can do your logic here pass it or deny or do something special
            score check value of 0.5 you can set which you want form 0 to 1
            score 1 is probably human score 0 is probably bot
            */
            $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                ' . $message['error']['recaptcha'] . '
            </div>';
        }
        return json_encode($resArr);
    }

    /**
     * Show user login form
     */
    public function loginForm(Request $request)
    {
        //dd("ok");
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 33);
        if (!empty($dataArr)) {
            
            $dataArr['full_url'] = $request->fullUrl();

            $previousUrl = url()->previous();
            
            /*if ($previousUrl == route('web.logout')) {
                $previousUrl = route('web.myaccount');
            }*/
            
            $request->session()->put('url.web_intended', $previousUrl);
            
            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = array("web_lang" => __('web'));

            //dd("ok");

            return view('themes.frontend.pages.login', compact('dataArr', 'defDataArr'));
        }
        return abort(404);
    }

  public function login(Request $request)
{
    $commonconstants = Config('commonconstants');
    $frontconstants = Config('frontconstants');

    $message = __('message');
    $webLang = __('web');
    $resArr['msg'] = "";
    $resArr['url'] = "";

    $vars = array(
        'secret' => $commonconstants['recaptcha']['secret_key'],
        "response" => $request->input('recaptcha_v3')
    );

    $url = "https://www.google.com/recaptcha/api/siteverify";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
    $encoded_response = curl_exec($ch);
    $response = json_decode($encoded_response, true);
    curl_close($ch);

    if ($response['success'] && $response['action'] == 'login_form' && $response['score'] > $commonconstants['recaptcha']['score']) {
        try {
            $authLang = __('auth');

            $input = $request->all();
            $email = $input['email'];

            $validator = Validator::make($request->all(), [
                'email' => 'required|email', // Assuming email is used for login
            ]);

            if ($validator->fails()) {
                $html = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                    <strong>' . $webLang['error_ttl'] . '&nbsp;</strong>';
                if ($validator->getMessageBag()->toArray()) {
                    $html .= '<ul>';
                    foreach ($validator->getMessageBag()->toArray() as $errors) {
                        foreach ($errors as $error) {
                            $html .= '<li>' . $error . '</li>';
                        }
                    }
                    $html .= '</ul>';
                }
                $html .= '</div>';
                $resArr['msg'] = $html;
                return json_encode($resArr);
            }

            $usrObj = User::where('email', $email)->first();
            if (!$usrObj) {
                $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                    <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                    ' . $authLang['failed'] . '
                </div>';
                return json_encode($resArr);
            }

            if ($usrObj->status != $commonconstants['status_val'][1]) {
                $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['3'] . '">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                    <strong>' . $webLang['warning_ttl'] . '&nbsp;</strong> 
                    ' . $authLang['warning']['acc_disabled'] . '
                </div>';
                return json_encode($resArr);
            }
            if ($usrObj->is_approved == $commonconstants['y_n_val'][2]) {
                $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['3'] . '">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                    <strong>' . $webLang['warning_ttl'] . '&nbsp;</strong> 
                    ' . $authLang['warning']['acc_approved'] . '
                </div>';
                return json_encode($resArr);
            }

            // Log in the user without checking the password
            Auth::login($usrObj);
            $this->establishFrontendSession($request, $usrObj);

            $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['1'] . '">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                <strong>' . $webLang['success_ttl'] . '&nbsp;</strong> 
                ' . $authLang['success']['login'] . '
            </div>';

            session()->put('useremail', $email);
            session()->put('username', trim($usrObj->f_name.' '.$usrObj->l_name));

            $resArr['url'] = $request->session()->get('url.web_intended');
        } catch (QueryException $exception) {
            $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                ' . $authLang['failed'] . '
            </div>';
        }
    } else {
        $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
            <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
            ' . $message['error']['recaptcha'] . '
        </div>';
    }
    return json_encode($resArr);
}

    /**
     * Logout only front end user.
     */
    public function logout()
    {
        $this->guard()->logout();

        $frontconstants = Config('frontconstants');
        $webLang = __('web');

        return redirect()->route('web.login')->with('alert', $frontconstants['alert_css']['1'])->with('message', __('auth.success.logout'))->with('title', $webLang['success_ttl']);
    }

    public function forgotPassword(Request $request)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 35);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = array("web_lang" => __('web'));

            return view('themes.frontend.pages.forgot-password', compact('dataArr', 'defDataArr'));
        }
        return abort(404);
    }

    /**
     * Send mail to restore password
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function forgotPasswordSendCode(Request $request)
    {
        $commonconstants = Config('commonconstants');
        $frontconstants = Config('frontconstants');

        $message = __('message');
        $webLang = __('web');
        $resArr['msg'] = "";
        $resArr['url'] = "";

        $vars = array(
            'secret' => $commonconstants['recaptcha']['secret_key'],
            "response" => $request->input('recaptcha_v3')
        );

        $url = "https://www.google.com/recaptcha/api/siteverify";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        $encoded_response = curl_exec($ch);
        $response = json_decode($encoded_response, true);
        curl_close($ch);

        if ($response['success'] && $response['action'] == 'forgot_password_form' && $response['score'] > $commonconstants['recaptcha']['score']) {
            $vldtrRules = [
                'email'  => 'required|email',
            ];

            $vldtrMessages = [];

            $validator = Validator::make($request->all(), $vldtrRules, $vldtrMessages);

            if ($validator->fails()) {
                // $resArr['msg'] = $validator->getMessageBag();
                // return json_encode($resArr);
                $html = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                        <strong>' . $webLang['error_ttl'] . '&nbsp;</strong>';
                if ($validator->getMessageBag()->toArray()) {
                    $html .= '<ul>';
                    foreach ($validator->getMessageBag()->toArray() as $errors) {
                        foreach ($errors as $error) {
                            $html .= '<li>' . $error . '</li>';
                        }
                    }
                    $html .= '</ul>';
                }
                $html .= '</div>';
                $resArr['msg'] = $html;
                return json_encode($resArr);
            }

            try {
                $authLang = __('auth');
                $passwordsLang = __('passwords');

                DB::beginTransaction();

                $user = User::whereEmail($request->input('email'))->first();
                if (is_null($user)) {
                    $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                        <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                        ' . $passwordsLang['user'] . '
                    </div>';
                    return json_encode($resArr);
                } else {
                    if ($user->status != $commonconstants['status_val'][1]) {
                        $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['3'] . '">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                            <strong>' . $webLang['warning_ttl'] . '&nbsp;</strong> 
                            ' . $authLang['warning']['acc_disabled'] . '
                        </div>';
                        return json_encode($resArr);
                    }
                    if ($user->is_approved == $commonconstants['y_n_val'][2]) {
                        $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['3'] . '">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                            <strong>' . $webLang['warning_ttl'] . '&nbsp;</strong> 
                            ' . $authLang['warning']['acc_approved'] . '
                        </div>';
                        return json_encode($resArr);
                    }
                }

                $userId = $user->u_id;

                $user->forget_code = mt_rand(100000, 999999);
                $user->updated_by       = $commonconstants['cu_by_val'][2];
                $user->updated_id       = $userId;
                if ($user->save()) {
                    $mailResp = User::sendResetPasswordCode($user);
                    if ($mailResp['mailResp'] || $mailResp['smsResp']) {
                        DB::commit();

                        $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['1'] . '">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                            <strong>' . $webLang['success_ttl'] . '&nbsp;</strong> 
                            ' . $passwordsLang['sent_pfx'] . '
                        </div>';

                        $resArr['url'] = route('web.forgot.password.verification.code');
                    } else {
                        DB::rollBack();

                        $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                            <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                            ' . $message['error']['email_send'] . '
                        </div>';
                    }
                } else {
                    DB::rollBack();

                    $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                        <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                        ' . $message['error']['saved'] . '
                    </div>';
                }
            } catch (QueryException $exception) {
                // $resArr['msg'] = $store;
                // return json_encode($resArr);
                $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                    <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                    ' . $message['error']['something_wrong'] . '
                </div>';
            }
        } else {
            /*
            then probably this is a bot
            you can do your logic here pass it or deny or do something special
            score check value of 0.5 you can set which you want form 0 to 1
            score 1 is probably human score 0 is probably bot
            */
            $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                ' . $message['error']['recaptcha'] . '
            </div>';
        }
        return json_encode($resArr);
    }

    public function forgotPasswordVerificationCode(Request $request)
    {
        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 39);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = array("web_lang" => __('web'));

            return view('themes.frontend.pages.forgot-password-verification', compact('dataArr', 'defDataArr'));
        }
        return abort(404);
    }

    public function forgotPasswordVerificationCodeCheck(Request $request)
    {
        $commonconstants = Config('commonconstants');
        $frontconstants = Config('frontconstants');

        $message = __('message');
        $webLang = __('web');
        $resArr['msg'] = "";
        $resArr['url'] = "";

        $vars = array(
            'secret' => $commonconstants['recaptcha']['secret_key'],
            "response" => $request->input('recaptcha_v3')
        );

        $url = "https://www.google.com/recaptcha/api/siteverify";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        $encoded_response = curl_exec($ch);
        $response = json_decode($encoded_response, true);
        curl_close($ch);

        if ($response['success'] && $response['action'] == 'forgot_password_verification_form' && $response['score'] > $commonconstants['recaptcha']['score']) {
            $vldtrRules = [
                'forget_code' => 'required|digits:6'
            ];

            $vldtrMessages = [];
            $frontconstants = Config('frontconstants');

            $validator = Validator::make($request->all(), $vldtrRules, $vldtrMessages);
            if ($validator->fails()) {
                // $resArr['msg'] = $validator->getMessageBag();
                // return json_encode($resArr);
                $html = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                        <strong>' . $webLang['error_ttl'] . '&nbsp;</strong>';
                if ($validator->getMessageBag()->toArray()) {
                    $html .= '<ul>';
                    foreach ($validator->getMessageBag()->toArray() as $errors) {
                        foreach ($errors as $error) {
                            $html .= '<li>' . $error . '</li>';
                        }
                    }
                    $html .= '</ul>';
                }
                $html .= '</div>';
                $resArr['msg'] = $html;
                return json_encode($resArr);
            }

            try {
                $user = User::where('forget_code', $request->forget_code)->first();
                if ($user !== null) {
                    $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['1'] . '">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                        <strong>' . $webLang['success_ttl'] . '&nbsp;</strong> 
                        ' . $message['success']['code_verify'] . '
                    </div>';

                    $resArr['url'] = route('web.forgot.reset.password', [$request->forget_code]);
                } else {
                    $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                        <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                        ' . $message['error']['code_verify'] . '
                    </div>';
                }
            } catch (QueryException $exception) {
                // $resArr['msg'] = $store;
                // return json_encode($resArr);
                $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                    <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                    ' . $message['error']['something_wrong'] . '
                </div>';
            }
        } else {
            /*
            then probably this is a bot
            you can do your logic here pass it or deny or do something special
            score check value of 0.5 you can set which you want form 0 to 1
            score 1 is probably human score 0 is probably bot
            */
            $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                ' . $message['error']['recaptcha'] . '
            </div>';
        }
        return json_encode($resArr);
    }


    public function forgotResetPassword(Request $request, $code)
    {
        $userMdl = User::where('forget_code', $code)->first();

        $frontconstants = Config('frontconstants');
        $webLang = __('web');

        if ($userMdl === null) {
            return redirect()->route('web.forgot.password')->with('alert', $frontconstants['alert_css']['2'])->with('message', __('passwords.token'))->with('title', $webLang['error_ttl']);
        }

        $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 40);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = array("web_lang" => $webLang);

            return view('themes.frontend.pages.forgot-reset-password', compact('dataArr', 'defDataArr', 'code'));
        }
        return abort(404);
    }

    /**
     * Change password after check if the code is correct
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function forgotResetPasswordSave(Request $request, $code)
    {
        $commonconstants = Config('commonconstants');
        $frontconstants = Config('frontconstants');

        $message = __('message');
        $webLang = __('web');
        $resArr['msg'] = "";
        $resArr['url'] = "";

        $vars = array(
            'secret' => $commonconstants['recaptcha']['secret_key'],
            "response" => $request->input('recaptcha_v3')
        );

        $url = "https://www.google.com/recaptcha/api/siteverify";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        $encoded_response = curl_exec($ch);
        $response = json_decode($encoded_response, true);
        curl_close($ch);

        if ($response['success'] && $response['action'] == 'forgot_reset_password_form' && $response['score'] > $commonconstants['recaptcha']['score']) {
            $vldtrRules = [
                /*'code' => 'required|max:30|regex:/^[a-z0-9 .\-]+$/i',*/
                'password' => 'required|min:6',
                'password_confirmation' => 'required|min:6|same:password'
            ];

            $vldtrMessages = [];

            $validator = Validator::make($request->all(), $vldtrRules, $vldtrMessages);

            if ($validator->fails()) {
                // $resArr['msg'] = $validator->getMessageBag();
                // return json_encode($resArr);
                $html = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                        <strong>' . $webLang['error_ttl'] . '&nbsp;</strong>';
                if ($validator->getMessageBag()->toArray()) {
                    $html .= '<ul>';
                    foreach ($validator->getMessageBag()->toArray() as $errors) {
                        foreach ($errors as $error) {
                            $html .= '<li>' . $error . '</li>';
                        }
                    }
                    $html .= '</ul>';
                }
                $html .= '</div>';
                $resArr['msg'] = $html;
                return json_encode($resArr);
            }

            try {
                $passwordsLang = __('passwords');

                DB::beginTransaction();

                $user = User::where('forget_code', $code)->first();
                if ($user !== null) {
                    $userId = $user->u_id;

                    $user->forget_code = $commonconstants['null'];
                    $user->password = bcrypt($request->input('password'));
                    $user->updated_by       = $commonconstants['cu_by_val'][2];
                    $user->updated_id       = $userId;
                    if ($user->save()) {
                        DB::commit();

                        session(['alert' => $frontconstants['alert_css']['1'], 'message' => $passwordsLang['reset'], 'title' => $webLang['success_ttl']]);

                        $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['1'] . '">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                            <strong>' . $webLang['success_ttl'] . '&nbsp;</strong> 
                            ' . $passwordsLang['reset'] . '
                        </div>';

                        $resArr['url'] = route('web.login');
                    } else {
                        DB::rollBack();

                        $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                            <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                            ' . $message['error']['saved'] . '
                        </div>';
                    }
                } else {
                    DB::rollBack();

                    $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                        <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                        ' . $passwordsLang['token'] . '
                    </div>';
                }
            } catch (QueryException $exception) {
                // $resArr['msg'] = $store;
                // return json_encode($resArr);
                $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                    <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                    ' . $message['error']['something_wrong'] . '
                </div>';
            }
        } else {
            /*
            then probably this is a bot
            you can do your logic here pass it or deny or do something special
            score check value of 0.5 you can set which you want form 0 to 1
            score 1 is probably human score 0 is probably bot
            */
            $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                ' . $message['error']['recaptcha'] . '
            </div>';
        }
        return json_encode($resArr);
    }

    /* public function callback(Request $request, $provider)
    {
        $commonconstants = Config('commonconstants');
        $auth = Config('auth');
        $frontconstants = Config('frontconstants');

        $message = __('message');
        $webLang = __('web');
        $authLang = __('auth');

        $s_acc_medium = '';
        if ($provider == 'google') {
            $s_acc_medium = $auth['s_acc_medium']['value'][0];
        } elseif ($provider == 'facebook') {
            $s_acc_medium = $auth['s_acc_medium']['value'][1];
        } elseif ($provider == 'microsoft') {
            $s_acc_medium = $auth['s_acc_medium']['value'][2];
        } elseif ($provider == 'apple') {
            $s_acc_medium = $auth['s_acc_medium']['value'][3];
        }

        $dataSavedErrMsg = $message['error']['saved'];

        $cuBy = $commonconstants['cu_by_val'][2];
        $cuMedium = $commonconstants['medium']['value'][1];
        $accType = $auth['acc_type']['value'][1];

        $input = $request->all();

        if ($provider == 'apple') {
            $userSocial =   Socialite::driver($provider)->userFromToken($input['id_token']);
        } else {
            $userSocial =   Socialite::driver($provider)->stateless()->user();
        }

        $user  =   User::where(['email' => $userSocial->getEmail()])->get()->first();

        DB::beginTransaction();
        if ($user) {
            if ($user->status != $commonconstants['status_val'][1]) {
                return redirect()->route('web.login')->with('alert', $frontconstants['alert_css']['3'])->with('message', $authLang['warning']['acc_disabled'])->with('title', $webLang['warning_ttl']);
            }
            if ($user->is_approved == $commonconstants['y_n_val'][2]) {
                return redirect()->route('web.login')->with('alert', $frontconstants['alert_css']['3'])->with('message', $authLang['warning']['acc_approved'])->with('title', $webLang['warning_ttl']);
            }

            if ($user->s_acc_medium != $s_acc_medium) {

                $user->s_acc_medium = $s_acc_medium;
                $user->acc_type = $accType;
                $user->s_account = $userSocial->getId();
                $user->u_updated_medium = $cuMedium;
                $user->updated_by       = $cuBy;
                $user->updated_id       = $user->u_id;
                if ($user->save()) {
                    DB::commit();
                } else {
                    DB::rollBack();
                    return redirect()->route('web.login')->with('alert', $frontconstants['alert_css']['2'])->with('message', $dataSavedErrMsg)->with('title', $webLang['error_ttl']);
                }
            }

            if (Auth::login($user)) {
                $this->establishFrontendSession($request, $user);
                return redirect($request->session()->get('url.web_intended'));
            } else {
                return redirect()->route('web.login')->with('alert', $frontconstants['alert_css']['2'])->with('message', __('auth.failed'))->with('title', $webLang['error_ttl']);
            }
        } else {
            $nameArr = explode(" ", $userSocial->getName());
            $email = $userSocial->getEmail();
            $genUsrPswdNo = $commonconstants['gen_usr_password_no'];
            $password = Useful::generateStrongPassword($genUsrPswdNo);
            $defAdminId = $commonconstants['def_super_admin_id'];
            $defUsrGrpId = $commonconstants['def_sbsrbd_usr_grp_id'];

            $store = $store2 = new User();
            $store->acc_type = $accType;
            $store->s_account = $userSocial->getId();
            $store->s_acc_medium = $s_acc_medium;
            $store->f_name = $nameArr[0];
            $store->l_name = (isset($nameArr[1])) ? $nameArr[1] : '';
            $store->email = $email;
            $store->password = bcrypt($password);
            $store->status           = $commonconstants['status_val'][1];
            $store->is_approved      = $commonconstants['y_n_val'][1];
            $store->trial_ends_at    = now()->addDays(14);
            $store->subscription_status = 'trial';
            $store->u_created_medium = $cuMedium;
            $store->created_by       = $cuBy;
            $store->created_id       = 0;
            $store->updated_at = $commonconstants['null'];
            if ($store->save()) {
                $userId = $store->u_id;

                $store2->created_id       = $userId;
                $store2->u_updated_medium = $cuMedium;
                $store2->updated_by       = $cuBy;
                $store2->updated_id       = $userId;
                if ($store2->save()) {
                    $role = new UserGroupRelModel;
                    $role->u_g_id       = $defUsrGrpId;
                    $role->u_id         = $userId;
                    $role->updated_id   = $defAdminId;
                    $role->save();

                    $uoptTypOpt2Val = $commonconstants['uopt_typ_opt2_val'];
                    $yesVal = strtolower(__('common.yes_no_txt.y'));
                    $now = now();

                    $insertUsrOptArr = [];
                    for ($i = 0; $i < 5; $i++) {
                        $insertUsrOptArr[$i]['type'] = $uoptTypOpt2Val;
                        if ($i == 0) {
                            $insertUsrOptArr[$i]['option_key'] = "gen_ntfy";
                        }
                        if ($i == 1) {
                            $insertUsrOptArr[$i]['option_key'] = "my_intrst_ntfy";
                        }
                        if ($i == 2) {
                            $insertUsrOptArr[$i]['option_key'] = "my_stry_ntfy";
                        }
                        if ($i == 3) {
                            $insertUsrOptArr[$i]['option_key'] = "my_poll_rslt_ancmnt_ntfy";
                        }
                        if ($i == 4) {
                            $insertUsrOptArr[$i]['option_key'] = "my_qstn_ans_ntfy";
                        }
                        $insertUsrOptArr[$i]['option_value'] = $yesVal;
                        $insertUsrOptArr[$i]['u_id'] = $userId;
                        $insertUsrOptArr[$i]['created_at'] = $now;
                        $insertUsrOptArr[$i]['updated_at'] = $now;
                    }
                    $insertUsrOptData = UserOptionModel::insert($insertUsrOptArr);
                    if ($insertUsrOptData > 0) {
                        $storeGpDataArr = array();
                        $storeGpDataArr['u_id'] = $userId;
                        $storeGpDataArr['type'] = $commonconstants['gmf_opt1_val'];
                        $storeGpDataArr['points'] = $commonconstants['gmf_opt1_pt'];
                        $insertedIdGp = GamificationPointsModel::create($storeGpDataArr)->wasRecentlyCreated;
                        if ($insertedIdGp == 0) {
                            DB::rollBack();

                            return redirect()->route('web.login')->with('alert', $frontconstants['alert_css']['2'])->with('message', $dataSavedErrMsg)->with('title', $webLang['error_ttl']);
                        } else {
                            DB::commit();

                            $mailPSObj = new MailPS();
                            $mailCssAtr = $mailPSObj->getEmailHtmlCssAtr();

                            $fullname = $store->f_name . " " . $store->l_name;
                            $mailArr = ["fullname" => rtrim($fullname), "email" => $email, "password" => $password];

                            $subject    = $authLang['su_reg_mail_sbjct'];
                            $content    = view('emails.web.to-user-signup', compact('mailArr', 'mailCssAtr'));
                            $fromName   = $authLang['su_reg_mail_f_name'];

                            $mailResp = $mailPSObj->sendMail($email, $subject, $content, '', $fromName);

                            if ($mailResp) {
                                if (Auth::login($store)) {
                                    $this->establishFrontendSession($request, $store);
                                    return redirect($request->session()->get('url.web_intended'));
                                } else {
                                    return redirect()->route('web.login')->with('alert', $frontconstants['alert_css']['2'])->with('message', __('auth.failed'))->with('title', $webLang['error_ttl']);
                                }
                            } else {
                                return redirect()->route('web.login')->with('alert', $frontconstants['alert_css']['2'])->with('message', $message['error']['email_send'])->with('title', $webLang['error_ttl']);
                            }
                        }
                    } else {
                        DB::rollBack();

                        return redirect()->back()->withInput()->with('alert', $frontconstants['alert_css']['2'])->with('message', $dataSavedErrMsg)->with('title', $webLang['error_ttl']);
                    }
                } else {
                    DB::rollBack();

                    return redirect()->back()->withInput()->with('alert', $frontconstants['alert_css']['2'])->with('message', $dataSavedErrMsg)->with('title', $webLang['error_ttl']);
                }
            } else {
                DB::rollBack();

                return redirect()->back()->withInput()->with('alert', $frontconstants['alert_css']['2'])->with('message', $dataSavedErrMsg)->with('title', $webLang['error_ttl']);
            }
        }
    } */

    /* public function redirect($service)
    {
        if ($service == 'apple') {
            $state = time();
            $url = 'https://appleid.apple.com/auth/authorize';
            $fields = [
                'client_id'     => env('APPLE_CLIENT_ID'),
                'redirect_uri'  => env('APPLE_REDIRECT_URI'),
                'scope'         => 'name email',
                'response_type' => 'code id_token',
                'response_mode' => 'form_post',
                'state' => md5($state),
                'nonce' => Str::uuid() . '.' . $state,
            ];
            $query = http_build_query($fields, null, '&', PHP_QUERY_RFC3986);
            return redirect($url . '?' . $query);
        }
        return Socialite::driver($service)->redirect();
    } */
}
