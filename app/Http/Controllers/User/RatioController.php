<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CurrencyMaster;
use App\Models\FundMaster;
use App\Models\FundType;
use App\Models\IndicesMaster;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Throwable;

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

    function quick_ratio(Request $request){
      $data = $this->reportViewData($request);

      if ($request->routeIs('user.performance_ratios')) {
        return view('web.ratio-reports.stats', $data);
      }

      return view('web.ratio-reports.quick_ratio_new', $data);
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
    function monthly_snapshot(Request $request){
      $data = $this->reportViewData($request);

      if ($request->routeIs('user.monthly_snapshot_new')) {
        return view('web.ratio-reports.monthly_snapshot_new', $data);
      }

      return view('web.ratio-reports.monthly_snapshot', $data);
    }
    function weekly_snapshot(Request $request){
      $data = $this->reportViewData($request);

      if ($request->routeIs('user.weekly_snapshot_new')) {
        return view('web.ratio-reports.weekly_snapshot_new', $data);
      }

      return view('web.ratio-reports.weekly_snapshot', $data);
    }

    function fund_factsheet(Request $request){
      return view('web.ratio-reports.fund_factsheet', $this->reportViewData($request));
    }

    function stats(Request $request){
      return view('web.ratio-reports.stats', $this->reportViewData($request));
    }

    function quartile_decile(Request $request){
      return view('web.ratio-reports.quartile_decile', $this->reportViewData($request));
    }

    function comparative(Request $request){
      $data = $this->reportViewData($request);

      if ($request->routeIs('user.r_square_comparison')) {
        return view('web.ratio-reports.r_square_comparison', $data);
      }

      return view('web.ratio-reports.comparative', $data);
    }

    function subscription_lock(){
      $user = Auth::user();
      $data = $this->subscriptionViewData($user);

      return view('web.ratio-reports.subscription_lock', $data);
      
    }

    protected function subscriptionViewData($user): array
    {
        $userdetails = null;
        if ($user && !empty($user->u_id)) {
            $userdetails = User::where('u_id', $user->u_id)->first();
        }

        if (!$userdetails && $user instanceof User) {
            $userdetails = $user;
        }

        $currentDate = now();
        $expiryDatetime = $this->resolveSubscriptionExpiry($userdetails);
        $hasActiveSubscription = $userdetails && method_exists($userdetails, 'hasValidAccess')
            ? $userdetails->hasValidAccess()
            : false;
        $showRenewWarning = false;
        $showExpiredWarning = false;

        if ($expiryDatetime && !$hasActiveSubscription) {
            if ($expiryDatetime->isPast()) {
                $showExpiredWarning = true;
            } elseif ($expiryDatetime->copy()->subDays(5)->lte($currentDate)) {
                $showRenewWarning = true;
            }
        }

        return [
            'userdetails' => $userdetails,
            'expiry_date' => $expiryDatetime ? $expiryDatetime->toDateString() : null,
            'expiry_date_display' => $expiryDatetime ? $expiryDatetime->format('d/m/Y') : null,
            'current_date' => $currentDate->toDateString(),
            'fiveDaysBeforeExpiry' => $expiryDatetime ? $expiryDatetime->copy()->subDays(5)->toDateString() : null,
            'has_active_subscription' => $hasActiveSubscription,
            'show_renew_warning' => $showRenewWarning,
            'show_expired_warning' => $showExpiredWarning,
            'subscription_cta_url' => $this->resolveSubscriptionCtaUrl(),
        ];
    }

    protected function resolveSubscriptionExpiry($userdetails): ?Carbon
    {
        if (!$userdetails || !method_exists($userdetails, 'accessExpiresAt')) {
            return null;
        }

        return $userdetails->accessExpiresAt();
    }

    protected function resolveSubscriptionCtaUrl(): string
    {
        if (config('features.subscription_enabled') && Route::has('web.subscription.index')) {
            return route('web.subscription.index');
        }

        if (Route::has('user.subscription')) {
            return route('user.subscription', ['cal' => 'subcription']);
        }

        return '#';
    }

    protected function reportViewData(Request $request): array
    {
        $today = now();
        $funds = $this->safeFundList();
        $currencies = $this->safeCurrencyList();
        $selectedDate = $request->input('date', $today->format('d-m-Y'));

        return array_merge($this->subscriptionViewData(Auth::user()), [
            'request' => $request,
            'message' => null,
            'disclaimer' => '',
            'quartile_set' => $request->input('quartile_set', 'quartile'),
            'report_category' => $request->input('report_category'),
            'all_fund_types' => $this->safeFundTypeList(),
            'all_funds' => $funds,
            'funds' => $funds,
            'indices' => $this->safeIndicesList(),
            'currencies' => $currencies,
            'ratio_array' => [],
            'quartile_decile_result' => [],
            'p_one_quartile_decile_result' => [],
            'p_two_quartile_decile_result' => [],
            'stat_result' => [],
            'sortedFundReturns' => [],
            'fundReturns' => [],
            'ranks' => [],
            'rank' => [],
            'fund_names' => [],
            'fund_type_name' => null,
            'request_fund_type' => null,
            'fund_id' => (array) $request->input('fund_id', []),
            'fund_type_id' => $request->input('fund_type_id'),
            'index_id' => (array) $request->input('index_id', []),
            'currency_id' => (array) $request->input('currency_id', []),
            'commodity_id' => (array) $request->input('commodity_id', []),
            'as_on_time_frame_data' => [],
            'schemeMaterData' => [],
            'Id' => null,
            'start_date' => $request->input('start_date', $today->copy()->subDays(6)->toDateString()),
            'end_date' => $request->input('end_date', $today->toDateString()),
            'p_one_start_date' => $request->input('p_one_start_date'),
            'p_one_end_date' => $request->input('p_one_end_date'),
            'p_two_start_date' => $request->input('p_two_start_date'),
            'p_two_end_date' => $request->input('p_two_end_date'),
            'to_date' => $selectedDate,
            'from_date' => $today->copy()->startOfMonth()->toDateString(),
            'array_bse' => collect(),
            'array_nse' => collect(),
            'array_global_it' => collect(),
            'changes_currency' => collect(),
            'changes_commodity' => collect(),
            'changes_indices' => collect(),
            'monthly_benchmark' => collect(),
            'weekly_benchmark' => collect(),
            'best_schemes' => collect(),
            'weekly_best_funds' => collect(),
            'responseArr' => [],
            'top_industries' => null,
            'AAUMValue' => null,
            'top_scrips' => null,
            'fund_details' => null,
            'closest_entry_date' => null,
            'index_name' => null,
            'jensonAlphaData' => null,
            'sharpeData' => null,
            'trackingErrorData' => null,
            'r_square' => null,
            'scrip_bias' => null,
            'industry_bias' => null,
            'treynorData' => null,
            'information_ratio' => null,
            'skewness' => null,
            'kurtosis' => null,
        ]);
    }

    protected function safeFundTypeList()
    {
        try {
            return FundType::query()->orderBy('name')->get();
        } catch (Throwable $e) {
            return collect();
        }
    }

    protected function safeFundList()
    {
        try {
            return FundMaster::query()->orderBy('fund_name')->get();
        } catch (Throwable $e) {
            return collect();
        }
    }

    protected function safeIndicesList()
    {
        try {
            return IndicesMaster::query()->orderBy('name')->get();
        } catch (Throwable $e) {
            return collect();
        }
    }

    protected function safeCurrencyList()
    {
        try {
            return CurrencyMaster::query()->orderBy('name')->get();
        } catch (Throwable $e) {
            return collect();
        }
    }

}
