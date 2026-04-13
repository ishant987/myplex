<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Web\BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
class SubscriptionController extends BaseController
{
    
    public function dashboard(Request $request, $slug = false)
    {
        //echo 'hii sub';
        if (!Auth::check()) 
        {
            //dd('hi');
            // User is not authenticated, redirect to the login page
            return redirect()->route('user.user_login',['cal' => 'subcription']);
          
        }
        else
        {
            // echo 'hii sub';
            // die;
            return view('web.auth.subcription');
        }

        


    }

}
