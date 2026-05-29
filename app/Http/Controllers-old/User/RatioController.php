<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Carbon\Carbon;

class RatioController extends Controller
{
    public function dashboard(Request $request)
    {
        //  dd("ok");
        $user = Auth::user();
        $userId=$user->u_id;
        // dd($userId);
        $data['userdetails']=$userdetails=User::where('u_id',$userId)->first();
        $expiry_datetime= Carbon::parse($userdetails->subscription_expiry_date);
        $data['expiry_date']=$expiry_date=$expiry_datetime->toDateString();
       // $data['expiry_date']=$expiry_date='2024-04-26';
        
       
        $currentDateTime = Carbon::now();
         //  dd($expiry_date);
            $data['current_date']= $current_date=$currentDateTime->toDateString();
       // $data['current_date']= '2024-04-20';
        //dd($current_date);
        $fiveDaysBeforeExpiryDate = $expiry_datetime->subDays(5);
       // dd($fiveDaysBeforeExpiryDate);
        $data['fiveDaysBeforeExpiry']=$fiveDaysBeforeExpiry=$fiveDaysBeforeExpiryDate->toDateString();
        //$data['fiveDaysBeforeExpiry']='2024-04-21';
      // dd($fiveDaysBeforeExpiry);

        return view('web.auth.dashboard',$data);
        // return view('web.auth.ratio',$data);
    }
    function quick_ratio(){
        $user = Auth::user();
        $userId=$user->u_id;
      //  dd($userId);
        $data['userdetails']=$userdetails=User::where('u_id',$userId)->first();
        $expiry_datetime= Carbon::parse($userdetails->subscription_expiry_date);
        $data['expiry_date']=$expiry_date=$expiry_datetime->toDateString();
        // $data['expiry_date']=$expiry_date='2024-04-26';
        // dd($data);
        $currentDateTime = Carbon::now();
         //  dd($expiry_date);
            $data['current_date']= $current_date=$currentDateTime->toDateString();
       // $data['current_date']= '2024-04-20';
        //dd($current_date);
        $fiveDaysBeforeExpiryDate = $expiry_datetime->subDays(5);
       // dd($fiveDaysBeforeExpiryDate);
        $data['fiveDaysBeforeExpiry']=$fiveDaysBeforeExpiry=$fiveDaysBeforeExpiryDate->toDateString();
        return view('web.ratio-reports.quick_ratio', $data);
        
    }
    function monthly_snapshot(){
      $user = Auth::user();
      $userId=$user->u_id;
    //  dd($userId);
      $data['userdetails']=$userdetails=User::where('u_id',$userId)->first();
      $expiry_datetime= Carbon::parse($userdetails->subscription_expiry_date);
      $data['expiry_date']=$expiry_date=$expiry_datetime->toDateString();
      // $data['expiry_date']=$expiry_date='2024-04-26';
      // dd($data);
      $currentDateTime = Carbon::now();
       //  dd($expiry_date);
          $data['current_date']= $current_date=$currentDateTime->toDateString();
     // $data['current_date']= '2024-04-20';
      //dd($current_date);
      $fiveDaysBeforeExpiryDate = $expiry_datetime->subDays(5);
     // dd($fiveDaysBeforeExpiryDate);
      $data['fiveDaysBeforeExpiry']=$fiveDaysBeforeExpiry=$fiveDaysBeforeExpiryDate->toDateString();
      return view('web.ratio-reports.monthly_snapshot', $data);
      
    }
    function weekly_snapshot(){
      $user = Auth::user();
      $userId=$user->u_id;
      //  dd($userId);
      $data['userdetails']=$userdetails=User::where('u_id',$userId)->first();
      $expiry_datetime= Carbon::parse($userdetails->subscription_expiry_date);
      $data['expiry_date']=$expiry_date=$expiry_datetime->toDateString();
      // $data['expiry_date']=$expiry_date='2024-04-26';
      // dd($data);
      $currentDateTime = Carbon::now();
       //  dd($expiry_date);
          $data['current_date']= $current_date=$currentDateTime->toDateString();
     // $data['current_date']= '2024-04-20';
      //dd($current_date);
      $fiveDaysBeforeExpiryDate = $expiry_datetime->subDays(5);
     // dd($fiveDaysBeforeExpiryDate);
      $data['fiveDaysBeforeExpiry']=$fiveDaysBeforeExpiry=$fiveDaysBeforeExpiryDate->toDateString();
      return view('web.ratio-reports.weekly_snapshot', $data);
      
    }

    function subscription_lock(){
      $user = Auth::user();
      $userId=$user->u_id;
      //  dd($userId);
      $data['userdetails']=$userdetails=User::where('u_id',$userId)->first();
      $expiry_datetime= Carbon::parse($userdetails->subscription_expiry_date);
      $data['expiry_date']=$expiry_date=$expiry_datetime->toDateString();
      // $data['expiry_date']=$expiry_date='2024-04-26';
      // dd($data);
      $currentDateTime = Carbon::now();
       //  dd($expiry_date);
          $data['current_date']= $current_date=$currentDateTime->toDateString();
     // $data['current_date']= '2024-04-20';
      //dd($current_date);
      $fiveDaysBeforeExpiryDate = $expiry_datetime->subDays(5);
     // dd($fiveDaysBeforeExpiryDate);
      $data['fiveDaysBeforeExpiry']=$fiveDaysBeforeExpiry=$fiveDaysBeforeExpiryDate->toDateString();
      return view('web.ratio-reports.subscription_lock', $data);
      
    }

}
