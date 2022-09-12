<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

use Validator;
use Illuminate\Validation\Rule;

use App\Lib\Core\MailPS;

use App\Models\AdminModel;

class AuthController extends BaseController
{
    protected $redirectTo = '/dashboard';

    /**
     **_ Create a new controller instance.
     _**
     **_ @return void
     _**/
    public function __construct()
    {
      $this->middleware('guest:admin')->except('logout');
    }

    /**
     _
     _ @return property guard use for login
     _
     **/
    public function guard()
    {
     return Auth::guard('admin');
    }

    // login from for admin
    public function showLoginForm(Request $request)
    {
        $adminPrfx = Config('commonconstants.admin_prefix');
        $previousUrl = url()->previous();
        if (strpos($previousUrl,$adminPrfx) == false) {
            $previousUrl = $adminPrfx;
        }        
        $request->session()->put('url.intended',$previousUrl);
        return view('themes.backend.pages.login');
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $username = $input['username'];
        Validator::make($request->all(), [
            'username' => [
                'required',
                Rule::exists('admin')->where(function ($query) use($username){
                    $query->where('username', $username);
                }),
            ],
            'password' => 'required|min:6'
        ], [
            'username.exists' => __('auth.error.no_acc_username')
        ])->validate();

        $usrObj = AdminModel::where('username', $username)->first();
        if($usrObj->status != 1){
            return back()->withInput($request->only('username', 'remember'))->with('alert', Config('adminconstants.alert_css.3'))->with('message', __('auth.warning.acc_disabled'))->with('title', __('admin.warning_ttl'));
        } 

        $rememberMe = ($request->has('remember') && $request->get('remember') == Config('commonconstants.y_n_val.1')) ? true : false;

        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password], $rememberMe)) {            
            return redirect($request->session()->get('url.intended'));
        }
        
        return back()->withInput($request->only('username', 'remember'))->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('auth.error.login_username'))->with('title', __('admin.error_ttl'));
    }

    public function logout()
    {
		Auth::guard('admin')->logout();
		return redirect()->route('admin.login')->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('auth.success.logout'))->with('title', __('admin.success_ttl'));
	}

    // forgotpassword from for admin
    public function showForgotpasswordForm()
    {
    	if (Auth::guard('admin')->user()) return redirect()->route('admin.dashboard');
        return view('themes.backend.pages.forgotpassword');
    }

    public function forgotPassword(Request $request)
    {
        $input = $request->all();
        $email = $input['email'];
        Validator::make($request->all(), [
            'email' => [
                'required','email',
                Rule::exists('admin')->where(function ($query) use($email){
                    $query->where('email', $email);
                }),
            ]
        ], [
            'email.exists' => __('auth.error.no_acc_email')
        ])->validate();

        $user = AdminModel::where('email', $email)->first();
        if($user->status != 1){
            return back()->withInput($request->only('email'))->with('alert', Config('adminconstants.alert_css.3'))->with('message', __('auth.warning.acc_disabled'))->with('title', __('admin.warning_ttl'));
        } 
        else{
            try {    
                \DB::beginTransaction();

                $newPassword = \App\Lib\Core\Useful::generateStrongPassword( Config('adminconstants.gen_new_pass_lngth') );

                $user->password = bcrypt($newPassword);
                $user->updated_id = $user->admin_id;
                if($user->save()){
                    $mailPSObj = new MailPS();
                    $mailCssAtr = $mailPSObj->getEmailHtmlCssAtr();
                    
                    $subject    = __('auth.f_password_mail_sbjct');
                    $content    = view('emails.admin.to-user-f-password', compact('user', 'mailCssAtr', 'newPassword'));

                    $fromName = __('auth.f_password_mail_f_name');
                    $mailResp   = $mailPSObj->sendMail($email, $subject, $content, '', $fromName);
                    if($mailResp)
                    {   
                        \DB::commit();

                        return redirect()->route('admin.login')->with('alert', Config('adminconstants.alert_css.1'))->with('message', __('auth.success.f_password'))->with('title', __('admin.success_ttl'));
                    }
                    else
                    { 
                        \DB::rollBack();

                        return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.email_send'))->with('title', __('admin.error_ttl')); 
                    }
                }
                else{
                    \DB::rollBack();

                    return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.data_saved'))->with('title', __('admin.error_ttl')); 
                }
            } catch (QueryException $exception) {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', $exception->getMessage())->with('title', __('admin.error_ttl'))->withInput();
            }

            return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.something_wrong'))->with('title', __('admin.error_ttl')); 
        }
    }
}