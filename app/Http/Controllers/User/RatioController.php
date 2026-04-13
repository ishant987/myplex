<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class RatioController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $data = $this->subscriptionViewData($user);

        return view('web.auth.dashboard', $data);
    }

    function notifications(){
      $user = Auth::user();
      $data = $this->subscriptionViewData($user);
      $data['page_title'] = 'Notifications';
      $data['page_message'] = 'You do not have any new notifications right now.';

      return view('web.ratio-reports.generic_page', $data);
    }

    function quick_ratio(){
        $user = Auth::user();
        $data = $this->subscriptionViewData($user);

        return view('web.ratio-reports.quick_ratio', $data);
        
    }

    function ratio_analysis(){
      $user = Auth::user();
      $data = $this->subscriptionViewData($user);
      $data['page_title'] = 'Ratio Analysis';
      $data['page_message'] = 'Ratio Analysis is now available from the sidebar. This section is ready for detailed dashboard content.';

      return view('web.ratio-reports.generic_page', $data);
    }

    function composition_report(){
      $user = Auth::user();
      $data = $this->subscriptionViewData($user);
      $data['page_title'] = 'Composition Report';
      $data['page_message'] = 'Composition Report is now available from the sidebar. This section is ready for detailed dashboard content.';

      return view('web.ratio-reports.generic_page', $data);
    }

    function indies_report(){
      $user = Auth::user();
      $data = $this->subscriptionViewData($user);
      $data['page_title'] = 'Indies Report';
      $data['page_message'] = 'Indies Report is now available from the sidebar. This section is ready for detailed dashboard content.';

      return view('web.ratio-reports.generic_page', $data);
    }

    function model_portfolio(){
      $user = Auth::user();
      $data = $this->subscriptionViewData($user);
      $data['page_title'] = 'Model Portfolio';
      $data['page_message'] = 'Model Portfolio is now available from the sidebar. This section is ready for detailed dashboard content.';

      return view('web.ratio-reports.generic_page', $data);
    }

    function filters(){
      $user = Auth::user();
      $data = $this->subscriptionViewData($user);
      $data['page_title'] = 'Filters';
      $data['page_message'] = 'Filters is now available from the sidebar. This section is ready for detailed dashboard content.';

      return view('web.ratio-reports.generic_page', $data);
    }

    function predictive(){
      $user = Auth::user();
      $data = $this->subscriptionViewData($user);
      $data['page_title'] = 'Predictive';
      $data['page_message'] = 'Predictive is now available from the sidebar. This section is ready for detailed dashboard content.';

      return view('web.ratio-reports.generic_page', $data);
    }
    function monthly_snapshot(){
      $user = Auth::user();
      $data = $this->subscriptionViewData($user);

      return view('web.ratio-reports.monthly_snapshot', $data);
      
    }
    function weekly_snapshot(){
      $user = Auth::user();
      $data = $this->subscriptionViewData($user);

      return view('web.ratio-reports.weekly_snapshot', $data);
      
    }

    function fund_factsheet(){
      $user = Auth::user();
      $data = $this->subscriptionViewData($user);
      $data['page_title'] = 'Fund Factsheet';
      $data['page_message'] = 'Fund Factsheet is available in your dashboard module. This page is now clickable and ready for content integration.';

      return view('web.ratio-reports.generic_page', $data);
    }

    function stats(){
      $user = Auth::user();
      $data = $this->subscriptionViewData($user);
      $data['page_title'] = 'Stats';
      $data['page_message'] = 'Stats is available in your dashboard module. This page is now clickable and ready for content integration.';

      return view('web.ratio-reports.generic_page', $data);
    }

    function quartile_decile(){
      $user = Auth::user();
      $data = $this->subscriptionViewData($user);
      $data['page_title'] = 'Quartile & Decile';
      $data['page_message'] = 'Quartile & Decile is available in your dashboard module. This page is now clickable and ready for content integration.';

      return view('web.ratio-reports.generic_page', $data);
    }

    function comparative(){
      $user = Auth::user();
      $data = $this->subscriptionViewData($user);
      $data['page_title'] = 'Comparative';
      $data['page_message'] = 'Comparative is available in your dashboard module. This page is now clickable and ready for content integration.';

      return view('web.ratio-reports.generic_page', $data);
    }

    function subscription_lock(){
      $user = Auth::user();
      $data = $this->subscriptionViewData($user);

      return view('web.ratio-reports.subscription_lock', $data);
      
    }

    protected function subscriptionViewData($user): array
    {
        $userdetails = User::where('u_id', $user->u_id)->first();
        $currentDate = now();
        $expiryDatetime = $this->resolveSubscriptionExpiry($userdetails);
        $showRenewWarning = false;
        $showExpiredWarning = false;

        if ($expiryDatetime) {
            if ($expiryDatetime->isPast() && !$userdetails->hasActiveSubscription()) {
                $showExpiredWarning = true;
            } elseif ($expiryDatetime->copy()->subDays(5)->lte($currentDate) && !$userdetails->hasActiveSubscription()) {
                $showRenewWarning = true;
            }
        }

        return [
            'userdetails' => $userdetails,
            'expiry_date' => $expiryDatetime ? $expiryDatetime->toDateString() : null,
            'current_date' => $currentDate->toDateString(),
            'fiveDaysBeforeExpiry' => $expiryDatetime ? $expiryDatetime->copy()->subDays(5)->toDateString() : null,
            'has_active_subscription' => $userdetails->hasActiveSubscription(),
            'show_renew_warning' => $showRenewWarning,
            'show_expired_warning' => $showExpiredWarning,
        ];
    }

    protected function resolveSubscriptionExpiry($userdetails): ?Carbon
    {
        if (!$userdetails) {
            return null;
        }

        if (!empty($userdetails->subscription_expiry_date)) {
            return Carbon::parse($userdetails->subscription_expiry_date);
        }

        if (method_exists($userdetails, 'activeSubscription')) {
            $activeSubscription = $userdetails->activeSubscription()->first();
            if ($activeSubscription?->ends_at) {
                return Carbon::parse($activeSubscription->ends_at);
            }
        }

        if (!empty($userdetails->trial_ends_at)) {
            return Carbon::parse($userdetails->trial_ends_at);
        }

        return null;
    }

}
