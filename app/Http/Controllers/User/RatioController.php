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
use Illuminate\Support\Facades\DB;
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
      $data = $this->quickRatioViewData($request);

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
      $data = $this->monthlySnapshotViewData($request);

      if ($request->routeIs('user.monthly_snapshot_new')) {
        return view('web.ratio-reports.monthly_snapshot_new', $data);
      }

      return view('web.ratio-reports.monthly_snapshot', $data);
    }
    function weekly_snapshot(Request $request){
      $data = $this->weeklySnapshotViewData($request);

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

    protected function quickRatioViewData(Request $request): array
    {
        $data = $this->reportViewData($request);
        $normalizedDate = $this->normalizeInputDate($request->input('date'));
        $fundTypeId = (int) $request->input('fund_type_id');
        $reportCategory = $request->input('report_category');
        $type = $request->input('type', 'weekly');

        $data['request_fund_type'] = $fundTypeId > 0
            ? $data['all_fund_types']->firstWhere('ft_id', $fundTypeId)
            : null;

        if (!$normalizedDate || $fundTypeId <= 0 || !$reportCategory) {
            return $data;
        }

        if (!$this->supportsStoredProcedures()) {
            $data['message'] = $this->storedProcedureUnavailableMessage();

            return $data;
        }

        $data['request']->merge([
            'date' => $normalizedDate->format('d-m-Y'),
            'type' => $type,
        ]);

        try {
            $snapshotData = [];

            if ($type === 'weekly') {
                if ($reportCategory === 'return') {
                    $snapshotData = DB::select('CALL sp_weekly_funds(?, ?)', [$normalizedDate->toDateString(), $fundTypeId]);
                } elseif ($reportCategory === 'indices') {
                    $snapshotData = DB::select('CALL sp_weekly_indices(?, ?)', [$normalizedDate->toDateString(), $fundTypeId]);
                } elseif ($reportCategory === 'return_less_index') {
                    $snapshotData = DB::select('CALL sp_weekly_return_less_index(?, ?)', [$normalizedDate->toDateString(), $fundTypeId]);
                }
            } elseif ($type === 'monthly') {
                if ($reportCategory === 'return') {
                    $snapshotData = DB::select('CALL sp_monthly_funds(?, ?)', [$normalizedDate->toDateString(), $fundTypeId]);
                } elseif ($reportCategory === 'indices') {
                    $snapshotData = DB::select('CALL sp_monthly_indices(?, ?)', [$normalizedDate->toDateString(), $fundTypeId]);
                } elseif ($reportCategory === 'return_less_index') {
                    $snapshotData = DB::select('CALL sp_monthly_return_less_index(?, ?)', [$normalizedDate->toDateString(), $fundTypeId]);
                } elseif ($reportCategory === 'corpus_change') {
                    $latestAaumRow = DB::selectOne(
                        'SELECT entry_date FROM mpx_corpus_entry WHERE fund_code IN (SELECT fund_code FROM mpx_fund_master WHERE fund_type_id = ?) ORDER BY entry_date DESC LIMIT 1',
                        [$fundTypeId]
                    );

                    if ($latestAaumRow && !empty($latestAaumRow->entry_date)) {
                        $snapshotData = DB::select('CALL sp_monthly_corpus_change(?, ?)', [$latestAaumRow->entry_date, $fundTypeId]);
                        $data['responseArr']['aaum_date'] = $latestAaumRow->entry_date;
                    }
                }
            }

            $data['responseArr']['snapshot_data'] = collect($snapshotData);
        } catch (Throwable $e) {
            $data['message'] = 'Unable to load quick ratio data right now.';
        }

        return $data;
    }

    protected function weeklySnapshotViewData(Request $request): array
    {
        $data = $this->reportViewData($request);
        $range = $this->resolveWeeklyRange($request->input('date'));

        $data['start_date'] = $range['end']->toDateString();
        $data['end_date'] = $range['start']->toDateString();

        if (!$this->supportsStoredProcedures()) {
            $data['message'] = $this->storedProcedureUnavailableMessage();

            return $data;
        }

        try {
            $allIndices = collect($this->safeSnapshotIndexData('GET_INDICES', $range['start']->toDateString(), $range['days']));
            $data['array_bse'] = $allIndices->filter(fn ($item) => $this->isBseIndex($item->name ?? ''))->values();
            $data['array_nse'] = $allIndices->filter(fn ($item) => $this->isNseIndex($item->name ?? ''))->values();
            $data['array_global_it'] = $allIndices
                ->reject(fn ($item) => $this->isBseIndex($item->name ?? '') || $this->isNseIndex($item->name ?? ''))
                ->values();
            $data['changes_indices'] = $allIndices;
            $data['changes_currency'] = collect($this->safeSnapshotIndexData('GET_CURRENCY', $range['start']->toDateString(), $range['days']));
            $data['changes_commodity'] = collect($this->safeSnapshotIndexData('GET_COMMODITY', $range['start']->toDateString(), $range['days']));
            $data['weekly_benchmark'] = collect(DB::select('CALL sp_snapshot_weekly_benchmark(?)', [$range['start']->toDateString()]));
            $data['weekly_best_funds'] = collect(DB::select('CALL sp_snapshot_weekly_fund(?)', [$range['start']->toDateString()]));
        } catch (Throwable $e) {
            $data['message'] = 'Unable to load weekly snapshot data right now.';
        }

        return $data;
    }

    protected function monthlySnapshotViewData(Request $request): array
    {
        $data = $this->reportViewData($request);
        $range = $this->resolveMonthlyRange($request->input('date'));

        $data['from_date'] = $range['start']->toDateString();
        $data['to_date'] = $range['end']->format('d-m-Y');

        if (!$this->supportsStoredProcedures()) {
            $data['message'] = $this->storedProcedureUnavailableMessage();

            return $data;
        }

        try {
            $allIndices = collect($this->safeSnapshotIndexData('GET_INDICES', $range['end']->toDateString(), $range['days']));
            $data['array_bse'] = $allIndices->filter(fn ($item) => $this->isBseIndex($item->name ?? ''))->values();
            $data['array_nse'] = $allIndices->filter(fn ($item) => $this->isNseIndex($item->name ?? ''))->values();
            $data['array_global_it'] = $allIndices
                ->reject(fn ($item) => $this->isBseIndex($item->name ?? '') || $this->isNseIndex($item->name ?? ''))
                ->values();
            $data['changes_indices'] = $allIndices;
            $data['changes_currency'] = collect($this->safeSnapshotIndexData('GET_CURRENCY', $range['end']->toDateString(), $range['days']));
            $data['changes_commodity'] = collect($this->safeSnapshotIndexData('GET_COMMODITY', $range['end']->toDateString(), $range['days']));
            $data['monthly_benchmark'] = collect(DB::select('CALL sp_snapshot_monthly_benchmark(?)', [$range['end']->toDateString()]));
            $data['best_schemes'] = collect(DB::select('CALL sp_snapshot_monthly_best_fund(?)', [$range['end']->toDateString()]));
        } catch (Throwable $e) {
            $data['message'] = 'Unable to load monthly snapshot data right now.';
        }

        return $data;
    }

    protected function normalizeInputDate(?string $date): ?Carbon
    {
        if (!$date) {
            return null;
        }

        foreach (['d-m-Y', 'Y-m-d', 'd/m/Y'] as $format) {
            try {
                return Carbon::createFromFormat($format, $date)->startOfDay();
            } catch (Throwable $e) {
                continue;
            }
        }

        try {
            return Carbon::parse($date)->startOfDay();
        } catch (Throwable $e) {
            return null;
        }
    }

    protected function resolveWeeklyRange(?string $inputDate): array
    {
        $anchor = $this->normalizeInputDate($inputDate) ?? now()->startOfDay();
        $offsets = [
            'Monday' => [3, 9],
            'Tuesday' => [4, 10],
            'Wednesday' => [5, 11],
            'Thursday' => [6, 12],
            'Friday' => [0, 6],
            'Saturday' => [1, 7],
            'Sunday' => [2, 8],
        ];

        [$startOffset, $endOffset] = $offsets[$anchor->format('l')] ?? [0, 6];

        return [
            'start' => $anchor->copy()->subDays($startOffset),
            'end' => $anchor->copy()->subDays($endOffset),
            'days' => 6,
        ];
    }

    protected function resolveMonthlyRange(?string $inputDate): array
    {
        $anchor = $this->normalizeInputDate($inputDate) ?? now()->startOfDay();
        $end = $anchor->copy()->endOfMonth();
        $start = $end->copy()->startOfMonth();

        return [
            'start' => $start,
            'end' => $end,
            'days' => $start->diffInDays($end),
        ];
    }

    protected function safeSnapshotIndexData(string $mode, string $date, int $days): array
    {
        try {
            return DB::select('CALL sp_snapshot_indices_currency_commodity(?, ?, ?)', [$mode, $date, $days]);
        } catch (Throwable $e) {
            return [];
        }
    }

    protected function isBseIndex(string $name): bool
    {
        $name = strtoupper($name);

        return str_contains($name, 'BSE') || str_contains($name, 'SENSEX');
    }

    protected function isNseIndex(string $name): bool
    {
        $name = strtoupper($name);

        return str_contains($name, 'NSE') || str_contains($name, 'NIFTY');
    }

    protected function supportsStoredProcedures(): bool
    {
        return DB::connection()->getDriverName() === 'mysql';
    }

    protected function storedProcedureUnavailableMessage(): string
    {
        return 'These reports need the MySQL production database and its stored procedures. Your local app is currently using SQLite, so search results cannot load yet.';
    }

}
