<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Web\BaseController as BaseController;
use App\Models\User;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Auth;
use Mail;
use Illuminate\Mail\Message;
use GuzzleHttp\Client;
use ReCaptcha\ReCaptcha;

class RegistrationController extends BaseController
{
    protected const REGISTRATION_OTP_SESSION_KEY = 'registration_email_otp';


    public function index(Request $request)
    {
        // dd('hii');
        return view('web.auth.registration');
    }

    public function store(Request $request)
    {
        //dd('ok');
        $recaptchaEnabled = !empty(env('RECAPTCHA_SITE_KEY')) && !empty(env('RECAPTCHA_SECRET_KEY'));

        $rules = [
            'company_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'email_otp' => 'required|digits:6',
            'contact_person' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'arn' => 'required|numeric',
            'pan' => 'required|regex:/^[0-9A-Za-z]{10}$/',
            'gst' => 'required|regex:/^[0-9A-Za-z]{15}$/',
            'privacy_policy' => 'required',
            'password' => 'required',
            //'file' => 'mimes:jpg,jpeg,png',
        ];

        if ($recaptchaEnabled) {
            $rules['g-recaptcha-response'] = 'required';
        }

        $validatedData = $request->validate(
            $rules,
            [
                'company_name.required' => 'Please enter  company name.',
                'email.required' => 'Please enter your email address.',
                'email.unique' => 'This email already exists.',
                'email_otp.required' => 'Please enter the OTP sent to your email.',
                'email_otp.digits' => 'Email OTP must be 6 digits.',
                'password.required' => 'Please enter your password.',
                'contact_person.required' => 'Please enter contact person name.',
                'city.required' => 'Please enter your city.',
                'state.required' => 'Please enter your state.',
                'arn.required' => 'Please enter ARN.',
                'arn.numeric' => 'ARN must be numeric.',
                'pan.required' => 'Please enter your PAN.',
                'pan.regex' => 'PAN must be exactly 10 characters long and alphanumeric.',

                'gst.required' => 'Please enter gst.',
                'gst.regex' => 'GST must be exactly 15 characters long and alphanumeric.',

                'privacy_policy.required' => 'Check privacy policy',
                'g-recaptcha-response.required' => 'Please complete the reCAPTCHA verification.',
                //'file.mimes' => 'Logo must be jpg,jpeg,png'
            ]
        );

        if (!$this->emailOtpMatches($request)) {
            return redirect()
                ->back()
                ->withInput($request->except(['password', 'confirm_password']))
                ->with('error', 'Please verify your email with the correct OTP before registering.');
        }

        // dd('hii');
        // $recaptcha = new ReCaptcha(env('RECAPTCHA_SECRET_KEY'));
        // $response = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());
        // if (!$response->isSuccess()) {
        //     // reCAPTCHA verification failed, redirect back with error message
        //     return redirect()->back()->withErrors(['captcha' => 'reCAPTCHA verification failed.']);
        // }
        // if ($request->hasFile('image'))
        if (isset($request->image) && $request->image != '') {
            //  dd('hii');
            $image = $request->file('image');
            // dd($image);
            $imageName = time() . '.' . $image->extension();
            //  $fileName = time().'.'.$request->file->extension();
            // dd($imageName);
            $image->move(public_path('uploads/users'), $imageName);
            // dd('upload');
            $insert['profile'] = $imageName;
        }
        // dd('filenot');

        $plainPassword = $request->password;
        // dd('ok1');
        $registrationDate = date('Y-m-d');
        $registrationDates = Carbon::now();

        $expiryDate = $registrationDates->addDays(14)->format('Y-m-d');
        // dd( $expiryDate);

        // $registrationDate = Carbon::parse($registrationDate);

        $nameParts = explode(' ', $request->contact_person);

        if (count($nameParts) > 1) {
            $insert['l_name'] = array_pop($nameParts);
            $insert['f_name'] = implode(' ', $nameParts);
        } else {
            $insert['f_name'] = $nameParts[0];
        }

        $hashedPassword = Hash::make($plainPassword);
        //dd('ok2');
        $insert['company'] = $request->company_name;
        $insert['email'] = $request->email;
        $insert['contact_person'] = $request->contact_person;
        $insert['city'] = $request->city;
        $insert['state'] = $request->state;
        $insert['arn'] = $request->arn;
        $insert['arn_verification_status'] = 'pending';
        $insert['pan'] = $request->pan;
        $insert['gst'] = $request->gst;
        $insert['password'] = $hashedPassword;
        $insert['subscription_expiry_date'] = $expiryDate;
        $insert['acc_type'] = 'a';
        $insert['created_by'] = 'u';
        $insert['created_id'] = 0;
        $insert['updated_by'] = 'u';
        $insert['updated_id'] = 0;
        if (app()->environment('local')) {
            $insert['is_approved'] = 'n';
            $insert['email_verified_at'] = now();
        }
        // dd($insert);

        $user = User::create($insert);
        $userId = $user->u_id;
        $userCode = $user->u_code;

        $subscription_table['u_id'] = $userId;
        $subscription_table['u_code'] = $userCode;
        $subscription_table['subscription_type'] = 'free_subscription';
        $subscription_table['created_date'] = date('Y-m-d');
        $subscription_table['subscription_expiry_date'] = $expiryDate;
        $subscription_table['status'] = 'a';
        $subscription_table['created_by'] = 'u';
        $subscription_table['created_id'] = $userId;
        $subscription = Subscription::create($subscription_table);

        // $config = [
        //     'driver' => 'smtp',
        //     'host' => 'smtpout.secureserver.net',
        //     'port' => 465,
        //     'from' => ['address' => 'info@technopmse.com', 'name' => 'Myplexus'],
        //     'to'=>$request->email,
        //     'encryption' => 'tls',
        //     'username' => 'info@technopmse.com',
        //     'password' => 'PmSe3xaM23',
        //   //  'sendmail' => '/usr/sbin/sendmail -bs',
        // ];




        $request->session()->forget(self::REGISTRATION_OTP_SESSION_KEY);

        return redirect()
            ->route('user.registration.pending')
            ->with('success', 'Your registration has been submitted. We are verifying your ARN and details.');
    }

    public function pending()
    {
        return view('web.auth.registration_pending');
    }

    public function verify(Request $request, $id)
    {
        // echo 'hii';
        // die;
        $update['is_approved'] = 'y';
        $update['email_verified_at'] = now();
        $id = base64_decode($id);
        $user_find = User::find($id);
        $update_data = $user_find->update($update);

        return redirect()->route('user.user_login');
    }

    public function checkEmailUnique(Request $request)
    {
        $email = $request->email;

        $user = User::where('email', $email)->first();

        return response()->json(['unique' => !$user]);
    }

    public function sendRegistrationOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email already exists.',
        ]);

        $otp = (string) random_int(100000, 999999);
        $otpData = [
            'email' => strtolower(trim($request->email)),
            'otp_hash' => Hash::make($otp),
            'expires_at' => now()->addMinutes(10)->timestamp,
        ];

        $request->session()->put(self::REGISTRATION_OTP_SESSION_KEY, $otpData);

        try {
            Mail::send('web.auth.email.registration_otp', [
                'email' => $request->email,
                'otp' => $otp,
                'expiresInMinutes' => 10,
            ], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Your registration OTP');
            });
        } catch (\Exception $exception) {
            Log::warning('Registration OTP email failed to send.', [
                'email' => $request->email,
                'message' => $exception->getMessage(),
            ]);

            if (!app()->environment('local')) {
                $request->session()->forget(self::REGISTRATION_OTP_SESSION_KEY);

                return response()->json([
                    'status' => false,
                    'message' => 'We could not send the OTP right now. Please try again.',
                ], 422);
            }

            return response()->json([
                'status' => true,
                'message' => 'OTP generated locally. Use this code: ' . $otp,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully to your email address.',
        ]);
    }

    protected function emailOtpMatches(Request $request): bool
    {
        $otpData = $request->session()->get(self::REGISTRATION_OTP_SESSION_KEY);

        if (!$otpData || empty($otpData['email']) || empty($otpData['otp_hash']) || empty($otpData['expires_at'])) {
            return false;
        }

        if (strtolower(trim((string) $request->email)) !== $otpData['email']) {
            return false;
        }

        if (now()->timestamp > (int) $otpData['expires_at']) {
            return false;
        }

        return Hash::check((string) $request->email_otp, $otpData['otp_hash']);
    }
}
