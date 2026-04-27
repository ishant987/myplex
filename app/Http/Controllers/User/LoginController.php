<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Web\BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use App\Support\WelcomeEmailSender;

// use Illuminate\Support\Facades\Auth;
 use Auth;
 use Illuminate\Support\Facades\Http;
 use Carbon\Carbon;

class LoginController extends BaseController
{
    protected int $trialDays = 0;

    protected function createTrialSubscription(User $user, string $expiryDate): void
    {
        $existingTrial = Subscription::query()
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->u_id)
                    ->orWhere('u_id', $user->u_id);
            })
            ->whereIn('subscription_type', ['trial', 'free_subscription'])
            ->exists();

        if ($existingTrial) {
            return;
        }

        Subscription::create([
            'user_id' => $user->u_id,
            'u_id' => $user->u_id,
            'u_code' => $user->u_code,
            'subscription_type' => 'trial',
            'created_date' => date('Y-m-d'),
            'subscription_expiry_date' => $expiryDate,
            'trial_ends_at' => $expiryDate,
            'ends_at' => $expiryDate,
            'status' => 'a',
            'created_by' => 'u',
            'created_id' => $user->u_id,
        ]);
    }

    protected function establishUserSession(Request $request, User $user): void
    {
        $request->session()->regenerate();

        $user->update([
            'session_token' => $request->session()->getId(),
            'is_session_active' => true,
        ]);
    }

    protected function loginRedirectFor(User $user)
    {
        if (config('features.subscription_enabled') && $user->isOnTrial()) {
            return redirect()->route('web.subscription.index')->with('success', 'Your free trial is active. You can continue the trial or choose a paid plan.');
        }

        return redirect()->route('user.index_dashboard')->with('success','You have successfully logged in');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $user->update([
                'session_token' => null,
                'is_session_active' => false,
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.user_login')->with('success', 'You have successfully logged out.');
    }

    public function postLogin(Request $request)
    {
        // dd("ok");insert
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // dd("ok1");

        $credentials = $request->only('email', 'password');

        // dd($credentials);

        if (Auth::attempt($credentials)) 
        {
                 //  dd("ok4");
            $user = Auth::user();
            $this->establishUserSession($request, $user);
             //dd($user);
            // return redirect()->route("user.user_login")->with('error', 'Wrong credentials');
            if(isset($request->pageurl))
            {
                //dd($request->pageurl);
                if($request->pageurl=='subcription')
                {
                    return redirect()->route(config('features.subscription_enabled') ? 'web.subscription.index' : 'user.subscription');
                }
                
            }
            else
            {
                return $this->loginRedirectFor($user);
            }
                 
              // return redirect()->back();
        }
        else
        {
            // dd("ok5");
            return redirect()->route("user.user_login")->with('error', 'Wrong credentials');
        }

        // return redirect()->route("user.user_login")->with('error', 'Wrong credentials');
    }
    //callback

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // public function handleGoogleCallback(Request $request)
    // {
    //     // dd("hi");
    //     try 
    //     {
    //         // dd("hi");
    //         $user = Socialite::driver('google')->user();
    //         // dd($user);
    //         // $finduser = User::where('social_id', $user->u_id)->first();
    //         $finduser = User::where('email', $user->email)->first();
        
    //  //dd($findUser);
    //         if ($finduser) 
    //         {
    //            // dd('ok');
    //             $token = $finduser->createToken('MyApp')->plainTextToken;
    
    //             //  $api_url = env('API_BASE_URL').'google/login';
    //             // dd($api_url);
    //             $response = Http::withHeaders([
    //                 'Accept' => 'application/json',
    //                 'Authorization' => 'Bearer '.$token
    //             ]);
    //             callback
    //             //  dd($response);
    
    //             if ($response->successful()) 
    //             {
    //                 $request->session()->put('user_data', $finduser);
    //                 $request->session()->put('access_token', ['access_token' => $token]);
    
    //                 return redirect()->intended('user.ratio_dashboard')->withSuccess('You have Successfully logged in');
    //             } 
    //             else 
    //             {
    //                 return redirect()->route('user.user_login')->with('error', 'Something went wrong. Please try again.');
    //             }
    //         } 
    //         else 
    //         {
    //             // $name_arr = explode(' ', $user->name);
    //             $newUser = User::updateOrCreate(['email' => $user->email], [
    //                 'f_name' => $name_arr[0],
    //                 'l_name' => implode(' ', array_slice($name_arr, 1)),
    //                 'name' => $user->name,
    //                 'email' => $user->email,
    //                 'acc_type' => 's',
    //                 's_acc_medium' => $user->provider === 'google' ? 'g' : ($user->provider === 'facebook' ? 'f' : ''),
    //                 'password' => bcrypt('my-google'),
    //                 'subscription_expiry_date' => now()->addDays(14), // Example: set expiry date to 1 month from now
    //             ]);
                
    
    //             $token = $newUser->createToken('MyApp')->plainTextToken;
    
    //             // $api_url = env('API_BASE_URL').'google/login';
    
    //             $response = Http::withHeaders([
    //                 'Accept' => 'application/json',
    //                 'callbackAuthorization' => 'Bearer '.$token
    //             ]);
    
    //             if ($response->successful()) 
    //             {
    //                 $request->session()->put('user_data', $newUser);
    //                 $request->session()->put('access_token', ['access_token' => $token]);
    
    //                 return redirect("user.registration")->with('success', 'You have successfully registered.');
    //             } 
    //             else 
    //             {
    //                 return redirect()->route('user.user_login')->with('error', 'Something went wrong during registration. Please try again.');
    //             }
    //         }
    //     } 
    //     catch (Exception $e) 
    //     {
    //         return redirect()->route('user.user_login')->with('error', 'An error occurred. Please try again later.');
    //     }
    // }
    public function handleGoogleCallback(Request $request)
    {
        try 
        {
            $user_google = Socialite::driver('google')->user();
           // $user_facebook = Socialite::driver('facebook')->user();
            if(isset($user_google))
            {
                $email=$user_google->email;
                $finduser = User::where('email', $user_google->email)->first();
                $google_id =$user_google->id;

            }
            // elseif(isset($user_facebook))
            // {
            //     dd($user_facebook);

            // }
           
           // $finduser = User::where('email', $email)->first();
          // dd($user_google);
           
           // dd( $finduser);
            if(isset($finduser))
            {
                if(isset($finduser->s_account) && !$finduser->s_account)
                {

               
                    $update['s_account']=$user_google->id;
                    $update['s_acc_medium']='g';
                    $update['updated_by']='u';
                    $update['acc_type']='s';
                    User::where('email',$user_google->email)->update($update);
                }
                

        


                auth()->login($finduser);
                $this->establishUserSession($request, $finduser);
                return $this->loginRedirectFor($finduser);
            }
            else
            {
                if(isset($finduser->email))
                {
                    auth()->login($finduser);
                    return redirect()->route('user.index_dashboard');
                }
                $expiryDate = Carbon::now()->addDays($this->trialDays)->format('Y-m-d');
                $insert['email']=$user_google->email;
                $insert['subscription_expiry_date']=$expiryDate;
                $insert['trial_ends_at']=$expiryDate;
                $insert['subscription_status']='trial';
                $insert['acc_type']='s';
                $insert['created_by']='u';
                $insert['s_acc_medium']='g';
                $insert['s_account']=$user_google->id;
                $user = User::create($insert);
                $this->createTrialSubscription($user, $expiryDate);
                WelcomeEmailSender::send($user, null, null, route('user.user_login'));
                auth()->login($user);
                $this->establishUserSession($request, $user);
                return $this->loginRedirectFor($user);
              //  return redirect()->back();
            }

           


        }
        catch (Exception $e) {
            return redirect()->route('user.user_login')->with('error','Wrong Credentials');
            // dd($e->getMessage());
        }
       
       // dd($user);
       // return redirect()->route('user.ratio_dashboard');
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }


    public function handleFacebookCallback(Request $request)
    {
     
        try 
        {
            $user_facebook = Socialite::driver('facebook')->user();
          //  dd($user_facebook);
           // $user_facebook = Socialite::driver('facebook')->user();
           
                $email=$user_facebook->email;
                $finduser = User::where('email', $user_facebook->email)->first();
                $google_id =$user_facebook->id;

           
            // elseif(isset($user_facebook))
            // {
            //     dd($user_facebook);

            // }
           
           // $finduser = User::where('email', $email)->first();
          // dd($user_google);
           
           // dd( $finduser);
            if(isset($finduser))
            {
                if(isset($finduser->s_account) && !$finduser->s_account)
                {

               
                    $update['s_account']=$user_facebook->id;
                    $update['s_acc_medium']='f';
                    $update['updated_by']='u';
                    $update['acc_type']='s';
                    User::where('email',$user_facebook->email)->update($update);
                }
                

        


                auth()->login($finduser);
                $this->establishUserSession($request, $finduser);
                return $this->loginRedirectFor($finduser);
            }
            else
            {
                if(isset($finduser->email))
                {
                    auth()->login($finduser);
                    $this->establishUserSession($request, $finduser);
                    return redirect()->route('user.index_dashboard');
                }
                $expiryDate = Carbon::now()->addDays($this->trialDays)->format('Y-m-d');
                $insert['email']=$user_facebook->email;
                $insert['subscription_expiry_date']=$expiryDate;
                $insert['trial_ends_at']=$expiryDate;
                $insert['subscription_status']='trial';
                $insert['acc_type']='s';
                $insert['created_by']='u';
                $insert['s_acc_medium']='f';
                $insert['s_account']=$user_facebook->id;
                $user = User::create($insert);
                $this->createTrialSubscription($user, $expiryDate);
                WelcomeEmailSender::send($user, null, null, route('user.user_login'));
                auth()->login($user);
                $this->establishUserSession($request, $user);
                return $this->loginRedirectFor($user);
              //  return redirect()->back();
            }

           


        }
        catch (Exception $e) 
        {
            return redirect()->route('user.user_login')->with('error', 'An error occurred. Please try again later.');
        }
    }

}
