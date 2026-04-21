<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Web\BetaController;
use App\Http\Controllers\Web\CagrController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\InformationratioController;
use App\Http\Controllers\Web\JensonsalphaController;
use App\Http\Controllers\Web\KurtosisController;
use App\Http\Controllers\Web\RollingreturnController;
use App\Http\Controllers\Web\rsquereController;
use App\Http\Controllers\Web\SharpeController;
use App\Http\Controllers\Web\SkewnessController;
use App\Http\Controllers\Web\TrackingerrorController;
use App\Http\Controllers\Web\TreynorController;
use App\Http\Controllers\Web\VolatilityController;
use App\Models\CorpusEntry;
use App\Models\CurrencyDetail;
use App\Models\FundDetail;
use Illuminate\Http\Request;
use App\Models\CurrencyMaster;
use App\Models\FundMaster;
use App\Models\FundType;
use App\Models\IndicesDetail;
use App\Models\IndicesMaster;
use App\Models\User;
use Carbon\CarbonInterface;
use Carbon\Carbon;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;
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
      return view('web.ratio-reports.fund_factsheet', $this->fundFactsheetViewData($request));
    }

    function stats(Request $request){
      return view('web.ratio-reports.stats', $this->performanceRatiosViewData($request));
    }

    function quartile_decile(Request $request){
      return view('web.ratio-reports.quartile_decile', $this->quartileDecileViewData($request));
    }

    function comparative(Request $request){
      $data = $request->routeIs('user.r_square_comparison')
          ? $this->rSquareComparisonViewData($request)
          : $this->comparativeViewData($request);

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
            'fund_names' => '',
            'fund_type_name' => null,
            'request_fund_type' => null,
            'fund_id' => (array) $request->input('fund_id', []),
            'fund_type_id' => $request->input('fund_type_id'),
            'index_id' => (array) $request->input('index_id', []),
            'currency_id' => (array) $request->input('currency_id', []),
            'commodity_id' => (array) $request->input('commodity_id', []),
            'as_on_time_frame_data' => [],
            'schemeMaterData' => null,
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

    protected function performanceRatiosViewData(Request $request): array
    {
        $data = $this->reportViewData($request);
        $availability = $this->reportDataAvailability();
        $selection = $this->resolveFundSelection($request, $data);

        $data['fund_type'] = $data['all_fund_types'];
        $data['fund_names'] = $selection['fund_names'];
        $data['fund_type_name'] = $selection['fund_type_name'];
        $data['report_data_ready'] = $availability['ready'];

        if (!$availability['ready']) {
            $data['message'] = $availability['message'];

            return $data;
        }

        if (!$this->canBuildRatioReport($request, $selection['funds'])) {
            if ($request->input('Category') === 'by_category' && !$request->input('fund_type_id')) {
                $data['message'] = 'Choose a fund classification to run this report.';
            } elseif ($request->input('Category') === 'by_fund' && empty(array_filter((array) $request->input('fund_id', [])))) {
                $data['message'] = 'Choose at least 2 funds to run this report.';
            }

            return $data;
        }

        $range = $this->resolveRankingRange($request);
        $ratioMap = $this->buildRatioMap($selection['funds'], (string) $request->input('report_category'), $range['start'], $range['end']);

        $data['start_date'] = $range['start']->toDateString();
        $data['end_date'] = $range['end']->toDateString();
        $data['stat_result'] = [
            'fund_absolute_return' => $ratioMap,
        ];

        if ($range['mode'] === 'as_on') {
            $data['as_on_time_frame_data'] = [$request->input('as_on_time_frame')];
        }

        return $data;
    }

    protected function quartileDecileViewData(Request $request): array
    {
        $data = $this->performanceRatiosViewData($request);
        $ratioMap = $data['stat_result']['fund_absolute_return'] ?? [];
        $reportCategory = (string) $request->input('report_category');

        if (empty($ratioMap) || !$reportCategory) {
            return $data;
        }

        $data['quartile_decile_result'] = [
            'fund_absolute_return' => $ratioMap,
            'quartile' => $this->buildRankBuckets($ratioMap, 4, $this->isLowerBetterRatio($reportCategory)),
            'decile' => $this->buildRankBuckets($ratioMap, 10, $this->isLowerBetterRatio($reportCategory)),
        ];

        return $data;
    }

    protected function comparativeViewData(Request $request): array
    {
        $data = $this->reportViewData($request);
        $selection = $this->resolveFundSelection($request, $data);

        $data['fund_type'] = $data['all_fund_types'];
        $data['fund_names'] = $selection['fund_names'];
        $data['fund_type_name'] = $selection['fund_type_name'];

        if (
            !$request->input('report_category') ||
            !$request->input('Category') ||
            $selection['funds']->isEmpty()
        ) {
            return $data;
        }

        $periodOne = $this->resolveExplicitDateRange($request->input('p_one_start_date'), $request->input('p_one_end_date'));
        $periodTwo = $this->resolveExplicitDateRange($request->input('p_two_start_date'), $request->input('p_two_end_date'));

        if (!$periodOne || !$periodTwo) {
            return $data;
        }

        $reportCategory = (string) $request->input('report_category');
        $ascending = $this->isLowerBetterRatio($reportCategory);

        $periodOneRatios = $this->buildRatioMap($selection['funds'], $reportCategory, $periodOne['start'], $periodOne['end']);
        $periodTwoRatios = $this->buildRatioMap($selection['funds'], $reportCategory, $periodTwo['start'], $periodTwo['end']);

        $allFundIds = array_unique(array_merge(array_keys($periodOneRatios), array_keys($periodTwoRatios)));
        foreach ($allFundIds as $fundId) {
            $periodOneRatios[$fundId] = $periodOneRatios[$fundId] ?? 'N/A';
            $periodTwoRatios[$fundId] = $periodTwoRatios[$fundId] ?? 'N/A';
        }

        $data['report_category'] = $reportCategory;
        $data['p_one_start_date'] = $periodOne['start']->toDateString();
        $data['p_one_end_date'] = $periodOne['end']->toDateString();
        $data['p_two_start_date'] = $periodTwo['start']->toDateString();
        $data['p_two_end_date'] = $periodTwo['end']->toDateString();
        $data['p_one_quartile_decile_result'] = [
            'fund_absolute_return' => $periodOneRatios,
            'quartile' => $this->buildRankBuckets($periodOneRatios, 4, $ascending),
            'decile' => $this->buildRankBuckets($periodOneRatios, 10, $ascending),
        ];
        $data['p_two_quartile_decile_result'] = [
            'fund_absolute_return' => $periodTwoRatios,
            'quartile' => $this->buildRankBuckets($periodTwoRatios, 4, $ascending),
            'decile' => $this->buildRankBuckets($periodTwoRatios, 10, $ascending),
        ];

        return $data;
    }

    protected function rSquareComparisonViewData(Request $request): array
    {
        $data = $this->reportViewData($request);
        $data['report_category'] = 'r_square';
        $data['request']->merge([
            'Category' => 'by_fund',
            'report_category' => 'r_square',
            'compare_type' => $request->input('compare_type', 'Scheme'),
        ]);

        $primaryFundId = (int) $request->input('scheme_id');
        $compareType = (string) $request->input('compare_type', 'Scheme');
        $range = $this->resolveRankingRange($request);

        $data['start_date'] = $range['start']->toDateString();
        $data['end_date'] = $range['end']->toDateString();

        if ($range['mode'] === 'as_on') {
            $data['as_on_time_frame_data'] = [$request->input('as_on_time_frame')];
        }

        if ($primaryFundId <= 0) {
            return $data;
        }

        $primaryFund = FundMaster::query()->find($primaryFundId);
        if (!$primaryFund) {
            return $data;
        }

        $data['schemeMaterData'] = $primaryFund;

        [$compareItems, $compareNames] = $this->resolveRComparisonSelection($request, $compareType);
        $data['fund_names'] = $compareNames;

        if ($compareItems->isEmpty()) {
            return $data;
        }

        $ratioMap = $this->buildRSquareComparisonMap($primaryFund, $compareItems, $compareType, $range['start'], $range['end']);
        $data['stat_result'] = [
            'fund_absolute_return' => $ratioMap,
        ];

        return $data;
    }

    protected function fundFactsheetViewData(Request $request): array
    {
        $data = $this->reportViewData($request);
        $fundId = (int) $request->input('fund_id');
        $selectedDate = $this->normalizeInputDate($request->input('to_date')) ?? now()->startOfDay();
        $data['request']->merge(['to_date' => $selectedDate->toDateString()]);

        if ($fundId <= 0) {
            return $data;
        }

        $fund = FundMaster::with('fundtype')->find($fundId);
        if (!$fund) {
            return $data;
        }

        $closestEntry = FundDetail::query()
            ->where('fund_code', $fund->fund_code)
            ->where('publish', 'y')
            ->whereDate('entry_date', '<=', $selectedDate->toDateString())
            ->orderByDesc('entry_date')
            ->first();

        if (!$closestEntry) {
            $closestEntry = FundDetail::query()
                ->where('fund_code', $fund->fund_code)
                ->where('publish', 'y')
                ->orderByDesc('entry_date')
                ->first();
        }

        if (!$closestEntry) {
            return $data;
        }

        $effectiveDate = Carbon::parse($closestEntry->entry_date)->startOfDay();
        $data['fund_details'] = $fund;
        $data['closest_entry_date'] = $effectiveDate->toDateString();
        $data['index_name'] = $this->resolveIndexName($fund, $effectiveDate);

        $periods = [
            'six_months' => 182,
            'one_year' => 366,
            'two_year' => 731,
            'three_year' => 1096,
            'five_year' => 1827,
        ];

        $jensenAlphaData = [];
        $sharpeData = [];
        $trackingErrorData = [];
        $treynorData = [];
        $informationRatio = [];
        $skewness = [];
        $kurtosis = [];
        $rSquare = [];

        foreach ($periods as $label => $days) {
            $startDate = $effectiveDate->copy()->subDays($days);
            $jensenAlphaData[$label] = $this->extractRatioMetrics($fund, 'jensens_alpha', $startDate, $effectiveDate, [
                'fund_return_absolute',
                'index_return_absolute',
                'jensens_alpha',
                'beta',
            ]);
            $sharpeData[$label] = $this->extractRatioMetrics($fund, 'sharpe', $startDate, $effectiveDate, [
                'sharpe',
                'volatility',
            ]);
            $trackingErrorData[$label] = $this->extractRatioMetrics($fund, 'tracking_error', $startDate, $effectiveDate, [
                'tracking_error',
            ]);
            $treynorData[$label] = $this->extractRatioMetrics($fund, 'treynor', $startDate, $effectiveDate, [
                'treynor',
            ]);
            $informationRatio[$label] = $this->calculateRatioForFund($fund, 'information_ratio', $startDate, $effectiveDate);
            $skewness[$label] = $this->calculateRatioForFund($fund, 'skewness', $startDate, $effectiveDate);
            $kurtosis[$label] = $this->calculateRatioForFund($fund, 'kurtosis', $startDate, $effectiveDate);
        }

        $rSquare['1_year_report'] = $this->extractRatioMetrics($fund, 'r_square', $effectiveDate->copy()->subDays(366), $effectiveDate, ['r_squere']);
        $rSquare['2_year_report'] = $this->extractRatioMetrics($fund, 'r_square', $effectiveDate->copy()->subDays(731), $effectiveDate, ['r_squere']);
        $rSquare['3_year_report'] = $this->extractRatioMetrics($fund, 'r_square', $effectiveDate->copy()->subDays(1096), $effectiveDate, ['r_squere']);
        $rSquare['5_year_report'] = $this->extractRatioMetrics($fund, 'r_square', $effectiveDate->copy()->subDays(1827), $effectiveDate, ['r_squere']);

        $portfolioData = $this->buildFundFactsheetPortfolioData($fund, $effectiveDate);
        $aaumValue = $this->buildAaumChartData($fund->fund_code, $effectiveDate);

        $data['top_scrips'] = json_encode($portfolioData['top_scrip_chart']);
        $data['top_industries'] = json_encode($portfolioData['top_industry_chart']);
        $data['AAUMValue'] = json_encode($aaumValue);
        $data['scrip_bias'] = $portfolioData['scrip_bias'];
        $data['industry_bias'] = $portfolioData['industry_bias'];
        $data['jensonAlphaData'] = $jensenAlphaData;
        $data['sharpeData'] = $sharpeData;
        $data['trackingErrorData'] = $trackingErrorData;
        $data['treynorData'] = $treynorData;
        $data['information_ratio'] = $informationRatio;
        $data['skewness'] = $skewness;
        $data['kurtosis'] = $kurtosis;
        $data['r_square'] = $rSquare;

        return $data;
    }

    protected function buildFundFactsheetPortfolioData(FundMaster $fund, Carbon $effectiveDate): array
    {
        $month = (int) $effectiveDate->format('n');
        $year = (int) $effectiveDate->format('Y');
        $scriptRows = collect();
        $industryRows = collect();

        if ($this->supportsStoredProcedures()) {
            try {
                $scriptRows = collect(DB::select('CALL sp_fund_search_portfolio_top_script(?, ?, ?, ?)', [$month, $year, $fund->fund_code, 20]));
                $industryRows = collect(DB::select('CALL sp_fund_search_portfolio_top_industry(?, ?, ?, ?)', [$month, $year, $fund->fund_code, 20]));
            } catch (Throwable $e) {
                $scriptRows = collect();
                $industryRows = collect();
            }
        }

        $topScriptChart = $scriptRows->take(10)->map(function ($row) {
            return [
                'scrip_name' => $row->scrip_name ?? 'N/A',
                'holdings' => round((float) ($row->content_per ?? 0), 2),
            ];
        })->values()->all();

        $topIndustryChart = $industryRows->take(10)->map(function ($row) {
            return [
                'industry' => $row->industry ?? 'N/A',
                'holdings' => round((float) ($row->industry_content_per ?? 0), 2),
            ];
        })->values()->all();

        return [
            'top_scrip_chart' => $topScriptChart,
            'top_industry_chart' => $topIndustryChart,
            'scrip_bias' => $this->buildBiasPayload($scriptRows, 'content_per', 'percentage', 'scrip_name'),
            'industry_bias' => $this->buildBiasPayload($industryRows, 'industry_content_per', 'total_percentage', 'industry'),
        ];
    }

    protected function buildBiasPayload(Collection $rows, string $fundColumn, string $indexColumn, string $nameColumn): array
    {
        $segments = [
            'top_ten' => $rows->slice(0, 10)->values(),
            'eleven_to_twenty' => $rows->slice(10, 10)->values(),
            'remaining' => $rows->slice(20)->values(),
        ];

        $payload = [
            'top_ten_bias' => null,
            'top_twenty_bias' => null,
            'rest_of_bias' => null,
        ];

        foreach ($segments as $key => $segment) {
            $items = $segment->map(function ($row) use ($fundColumn, $indexColumn, $nameColumn) {
                $fundValue = (float) ($row->{$fundColumn} ?? 0);
                $indexValue = (float) ($row->{$indexColumn} ?? 0);

                return (object) [
                    $nameColumn => $row->{$nameColumn} ?? 'N/A',
                    'fund_value' => $fundValue,
                    'index_value' => $indexValue,
                    'bias' => $fundValue - $indexValue,
                ];
            })->all();

            $totalBias = round(collect($items)->sum('bias'), 2);

            if ($key === 'top_ten') {
                $payload['top_ten_bias'] = $totalBias;
            } elseif ($key === 'eleven_to_twenty') {
                $payload['top_twenty_bias'] = $totalBias;
            } else {
                $payload['rest_of_bias'] = $totalBias;
            }

            $payload[$key] = $items;
        }

        return $payload;
    }

    protected function buildAaumChartData(string $fundCode, Carbon $effectiveDate): array
    {
        $rows = CorpusEntry::query()
            ->where('fund_code', $fundCode)
            ->where('publish', 'y')
            ->whereDate('entry_date', '<=', $effectiveDate->toDateString())
            ->orderByDesc('entry_date')
            ->limit(4)
            ->get(['entry_date', 'corpus_entry'])
            ->sortBy('entry_date')
            ->values();

        $chart = [['Month', 'AAUM']];

        foreach ($rows as $row) {
            $chart[] = [
                Carbon::parse($row->entry_date)->format('M Y'),
                round((float) $row->corpus_entry, 2),
            ];
        }

        return $chart;
    }

    protected function resolveIndexName(FundMaster $fund, Carbon $effectiveDate): ?string
    {
        try {
            $indexName = $fund->indices_name;
            $correlation = DB::table('mpx_indices_corelation')->where('name', $indexName)->value('corelation');
            $lookupNames = array_filter([$correlation, $indexName]);

            $record = IndicesDetail::query()
                ->whereIn('name', $lookupNames)
                ->where('publish', 'y')
                ->whereDate('entry_date', '<=', $effectiveDate->toDateString())
                ->orderByDesc('entry_date')
                ->first();

            return $record?->name ?? $indexName;
        } catch (Throwable $e) {
            return $fund->indices_name;
        }
    }

    protected function resolveFundSelection(Request $request, array $data): array
    {
        $category = $request->input('Category');
        $fundIds = array_filter(array_map('intval', (array) $request->input('fund_id', [])));
        $fundTypeId = (int) $request->input('fund_type_id');
        $funds = collect();
        $fundTypeName = null;
        $fundNames = '';

        if ($category === 'by_category' && $fundTypeId > 0) {
            $funds = FundMaster::query()
                ->where('fund_type_id', $fundTypeId)
                ->orderBy('fund_name')
                ->get();
            $fundType = $data['all_fund_types']->firstWhere('ft_id', $fundTypeId);
            $fundTypeName = $fundType?->name;
        } elseif ($category === 'by_fund' && !empty($fundIds)) {
            $funds = FundMaster::query()
                ->whereIn('fund_id', $fundIds)
                ->orderBy('fund_name')
                ->get();
            $fundNames = $funds->pluck('fund_name')->implode(', ');
        }

        return [
            'funds' => $funds,
            'fund_names' => $fundNames,
            'fund_type_name' => $fundTypeName,
        ];
    }

    protected function resolveRComparisonSelection(Request $request, string $compareType): array
    {
        return match ($compareType) {
            'Index' => $this->resolveNamedSelection(
                IndicesMaster::query()->whereIn('idc_id', array_filter(array_map('intval', (array) $request->input('index_id', []))))->orderBy('name')->get(),
                'name',
            ),
            'Currency' => $this->resolveNamedSelection(
                CurrencyMaster::query()
                    ->where('is_comodity', '0')
                    ->whereIn('cm_id', array_filter(array_map('intval', (array) $request->input('currency_id', []))))
                    ->orderBy('name')
                    ->get(),
                'name',
            ),
            'Commodity' => $this->resolveNamedSelection(
                CurrencyMaster::query()
                    ->where('is_comodity', '1')
                    ->whereIn('cm_id', array_filter(array_map('intval', (array) $request->input('commodity_id', []))))
                    ->orderBy('name')
                    ->get(),
                'name',
            ),
            default => $this->resolveNamedSelection(
                FundMaster::query()
                    ->whereIn('fund_id', array_filter(array_map('intval', (array) $request->input('fund_id', []))))
                    ->orderBy('fund_name')
                    ->get(),
                'fund_name',
            ),
        };
    }

    protected function resolveNamedSelection(Collection $items, string $nameKey): array
    {
        return [
            $items,
            $items->pluck($nameKey)->implode(', '),
        ];
    }

    protected function canBuildRatioReport(Request $request, Collection $funds): bool
    {
        return (bool) $request->input('report_category')
            && (bool) $request->input('Category')
            && $funds->isNotEmpty();
    }

    protected function reportDataAvailability(): array
    {
        $driver = DB::connection()->getDriverName();
        $tableChecks = [
            'fund_type' => DB::getSchemaBuilder()->hasTable('fund_type'),
            'fund_master' => DB::getSchemaBuilder()->hasTable('fund_master'),
            'fund_detail' => DB::getSchemaBuilder()->hasTable('fund_detail'),
            'indices_master' => DB::getSchemaBuilder()->hasTable('indices_master'),
            'indices_detail' => DB::getSchemaBuilder()->hasTable('indices_detail'),
            'corpus_entry' => DB::getSchemaBuilder()->hasTable('corpus_entry'),
        ];

        $missingTables = collect($tableChecks)
            ->filter(fn ($exists) => !$exists)
            ->keys()
            ->values()
            ->all();

        if (!empty($missingTables)) {
            return [
                'ready' => false,
                'message' => 'Required report tables are missing in the current database: ' . implode(', ', $missingTables) . '.',
            ];
        }

        $counts = [
            'fund_type' => DB::table('fund_type')->count(),
            'fund_master' => DB::table('fund_master')->count(),
            'fund_detail' => DB::table('fund_detail')->count(),
            'indices_master' => DB::table('indices_master')->count(),
            'indices_detail' => DB::table('indices_detail')->count(),
            'corpus_entry' => DB::table('corpus_entry')->count(),
        ];

        $emptyTables = collect($counts)
            ->filter(fn ($count) => (int) $count === 0)
            ->keys()
            ->values()
            ->all();

        if (!empty($emptyTables)) {
            $prefix = $driver === 'sqlite'
                ? 'Your local SQLite database has no imported report data'
                : 'The current database is missing report rows';

            return [
                'ready' => false,
                'message' => $prefix . ' in: ' . implode(', ', $emptyTables) . '.',
            ];
        }

        return [
            'ready' => true,
            'message' => null,
        ];
    }

    protected function resolveRankingRange(Request $request): array
    {
        $rankingMode = $request->input('ranking', 'range');

        if ($rankingMode === 'as_on') {
            $asOnDate = $this->normalizeInputDate($request->input('as_on_date')) ?? now()->startOfDay();
            $timeFrame = $request->input('as_on_time_frame', '1_year');
            $startDate = $this->startDateForTimeFrame($asOnDate, $timeFrame);

            return [
                'mode' => 'as_on',
                'start' => $startDate,
                'end' => $asOnDate,
            ];
        }

        $explicitRange = $this->resolveExplicitDateRange($request->input('start_date'), $request->input('end_date'));
        if ($explicitRange) {
            return [
                'mode' => 'range',
                'start' => $explicitRange['start'],
                'end' => $explicitRange['end'],
            ];
        }

        $fallbackEnd = now()->startOfDay();

        return [
            'mode' => 'range',
            'start' => $fallbackEnd->copy()->subYear(),
            'end' => $fallbackEnd,
        ];
    }

    protected function resolveExplicitDateRange(?string $startDate, ?string $endDate): ?array
    {
        $start = $this->normalizeInputDate($startDate);
        $end = $this->normalizeInputDate($endDate);

        if (!$start || !$end) {
            return null;
        }

        if ($start->gt($end)) {
            [$start, $end] = [$end, $start];
        }

        return [
            'start' => $start,
            'end' => $end,
        ];
    }

    protected function startDateForTimeFrame(Carbon $asOnDate, string $timeFrame): Carbon
    {
        return match ($timeFrame) {
            '1_month' => $asOnDate->copy()->subMonth(),
            '3_months' => $asOnDate->copy()->subMonths(3),
            '6_months' => $asOnDate->copy()->subMonths(6),
            '1_year' => $asOnDate->copy()->subYear(),
            '2_year' => $asOnDate->copy()->subYears(2),
            '3_years' => $asOnDate->copy()->subYears(3),
            '5_years' => $asOnDate->copy()->subYears(5),
            default => $asOnDate->copy()->subYear(),
        };
    }

    protected function buildRatioMap(Collection $funds, string $reportCategory, CarbonInterface $startDate, CarbonInterface $endDate): array
    {
        $ratioMap = [];

        foreach ($funds as $fund) {
            $ratioMap[$fund->fund_id] = $this->calculateRatioForFund($fund, $reportCategory, $startDate, $endDate);
        }

        return $ratioMap;
    }

    protected function buildRSquareComparisonMap(
        FundMaster $primaryFund,
        Collection $compareItems,
        string $compareType,
        CarbonInterface $startDate,
        CarbonInterface $endDate
    ): array {
        $ratioMap = [];
        $primarySeries = $this->buildFundReturnSeries($primaryFund, $startDate, $endDate);

        foreach ($compareItems as $item) {
            $compareSeries = match ($compareType) {
                'Index' => $this->buildIndexReturnSeries((string) $item->name, $startDate, $endDate),
                'Currency', 'Commodity' => $this->buildCurrencyReturnSeries((int) $item->cm_id, $startDate, $endDate),
                default => $this->buildFundReturnSeries($item, $startDate, $endDate),
            };

            $ratioMap[$this->rSquareComparisonKey($item, $compareType)] = $this->calculateRCorrelationSquare($primarySeries, $compareSeries);
        }

        return $ratioMap;
    }

    protected function rSquareComparisonKey($item, string $compareType): int
    {
        return match ($compareType) {
            'Index' => (int) $item->idc_id,
            'Currency', 'Commodity' => (int) $item->cm_id,
            default => (int) $item->fund_id,
        };
    }

    protected function buildFundReturnSeries(FundMaster $fund, CarbonInterface $startDate, CarbonInterface $endDate): array
    {
        if (empty($fund->fund_code)) {
            return [];
        }

        $points = FundDetail::query()
            ->where('fund_code', $fund->fund_code)
            ->where('publish', 'y')
            ->where('entry_date', '<=', $endDate->toDateString())
            ->where('entry_date', '>=', $startDate->copy()->subDays(35)->toDateString())
            ->orderBy('entry_date')
            ->get(['entry_date', 'closing_nav']);

        return $this->buildReturnSeriesFromPoints($points, 'entry_date', 'closing_nav');
    }

    protected function buildIndexReturnSeries(string $indexName, CarbonInterface $startDate, CarbonInterface $endDate): array
    {
        if ($indexName === '') {
            return [];
        }

        $points = IndicesDetail::query()
            ->where('name', $indexName)
            ->where('publish', 'y')
            ->where('entry_date', '<=', $endDate->toDateString())
            ->where('entry_date', '>=', $startDate->copy()->subDays(35)->toDateString())
            ->orderBy('entry_date')
            ->get(['entry_date', 'closing_value']);

        return $this->buildReturnSeriesFromPoints($points, 'entry_date', 'closing_value');
    }

    protected function buildCurrencyReturnSeries(int $currencyId, CarbonInterface $startDate, CarbonInterface $endDate): array
    {
        if ($currencyId <= 0) {
            return [];
        }

        $points = CurrencyDetail::query()
            ->where('cm_id', $currencyId)
            ->where('publish', 'y')
            ->where('entry_date', '<=', $endDate->toDateString())
            ->where('entry_date', '>=', $startDate->copy()->subDays(35)->toDateString())
            ->orderBy('entry_date')
            ->get(['entry_date', 'entry_value']);

        return $this->buildReturnSeriesFromPoints($points, 'entry_date', 'entry_value');
    }

    protected function buildReturnSeriesFromPoints(Collection $points, string $dateKey, string $valueKey): array
    {
        $series = [];
        $previousValue = null;

        foreach ($points as $point) {
            $currentValue = data_get($point, $valueKey);
            $entryDate = data_get($point, $dateKey);

            if (!is_numeric($currentValue) || $currentValue <= 0 || !$entryDate) {
                continue;
            }

            if ($previousValue !== null && $previousValue > 0) {
                $series[$entryDate] = (($currentValue - $previousValue) / $previousValue) * 100;
            }

            $previousValue = (float) $currentValue;
        }

        return $series;
    }

    protected function calculateRCorrelationSquare(array $primarySeries, array $compareSeries)
    {
        $sharedDates = array_values(array_intersect(array_keys($primarySeries), array_keys($compareSeries)));
        if (count($sharedDates) < 2) {
            return 'N/A';
        }

        $primaryValues = array_map(fn ($date) => (float) $primarySeries[$date], $sharedDates);
        $compareValues = array_map(fn ($date) => (float) $compareSeries[$date], $sharedDates);
        $correlation = app(rsquereController::class)->correlation($primaryValues, $compareValues);

        if ($correlation === null || !is_numeric($correlation)) {
            return 'N/A';
        }

        return round($correlation * $correlation, 4);
    }

    protected function calculateRatioForFund(FundMaster $fund, string $reportCategory, CarbonInterface $startDate, CarbonInterface $endDate)
    {
        $controllerMap = [
            'returns' => [CagrController::class, 'cagr_calculator', 'fund_return_absolute'],
            'jensens_alpha' => [JensonsalphaController::class, 'jensonsalpha_calculator', 'jensens_alpha'],
            'sharpe' => [SharpeController::class, 'sharpe_calculator', 'sharpe'],
            'treynor' => [TreynorController::class, 'treynor_calculator', 'treynor'],
            'information_ratio' => [InformationratioController::class, 'information_ratio_calculator', 'information_ratio'],
            'beta' => [BetaController::class, 'beta_calculator', 'beta'],
            'volatility' => [VolatilityController::class, 'volatility_calculator', 'volatility'],
            'tracking_error' => [TrackingerrorController::class, 'tracking_error_calculator', 'tracking_error'],
            'skewness' => [SkewnessController::class, 'skewness_calculator', 'skewness'],
            'kurtosis' => [KurtosisController::class, 'kurtosis_calculator', 'kurtosis'],
            'r_square' => [rsquereController::class, 'r_squere_calculator', 'r_squere'],
            'one_month_rolling_return' => [RollingreturnController::class, 'rolling_return_calculator', 'avg_of_twelve_month_rolling_return'],
        ];

        if (!isset($controllerMap[$reportCategory]) || empty($fund->fund_code)) {
            return 'N/A';
        }

        [$controllerClass, $method, $dataKey] = $controllerMap[$reportCategory];

        try {
            $request = new Request([
                'search' => 'Search',
                'search_fund_name' => $fund->fund_code,
                'search_indices_name' => $fund->indices_name,
                'search_from_date' => $startDate->toDateString(),
                'search_to_date' => $endDate->toDateString(),
            ]);

            /** @var ViewContract $view */
            $view = app($controllerClass)->{$method}($request);
            $payload = method_exists($view, 'getData') ? $view->getData() : [];
            $value = $payload[$dataKey] ?? null;

            if (is_numeric($value)) {
                return round((float) $value, 4);
            }

            return $value === null || $value === '' ? 'N/A' : $value;
        } catch (Throwable $e) {
            return 'N/A';
        }
    }

    protected function extractRatioMetrics(FundMaster $fund, string $reportCategory, CarbonInterface $startDate, CarbonInterface $endDate, array $keys): array
    {
        $controllerMap = [
            'jensens_alpha' => [JensonsalphaController::class, 'jensonsalpha_calculator'],
            'sharpe' => [SharpeController::class, 'sharpe_calculator'],
            'tracking_error' => [TrackingerrorController::class, 'tracking_error_calculator'],
            'treynor' => [TreynorController::class, 'treynor_calculator'],
            'r_square' => [rsquereController::class, 'r_squere_calculator'],
        ];

        $result = [];
        foreach ($keys as $key) {
            $result[$key] = 'N/A';
        }

        if (!isset($controllerMap[$reportCategory])) {
            return $result;
        }

        [$controllerClass, $method] = $controllerMap[$reportCategory];

        try {
            $request = new Request([
                'search' => 'Search',
                'search_fund_name' => $fund->fund_code,
                'search_indices_name' => $fund->indices_name,
                'search_from_date' => $startDate->toDateString(),
                'search_to_date' => $endDate->toDateString(),
            ]);

            /** @var ViewContract $view */
            $view = app($controllerClass)->{$method}($request);
            $payload = method_exists($view, 'getData') ? $view->getData() : [];

            foreach ($keys as $key) {
                $value = $payload[$key] ?? null;
                $result[$key] = is_numeric($value) ? round((float) $value, 4) : ($value === null || $value === '' ? 'N/A' : $value);
            }
        } catch (Throwable $e) {
            return $result;
        }

        return $result;
    }

    protected function buildRankBuckets(array $values, int $bucketCount, bool $ascending): array
    {
        $numericValues = collect($values)
            ->filter(fn ($value) => is_numeric($value))
            ->map(fn ($value) => (float) $value);

        if ($numericValues->isEmpty()) {
            return [];
        }

        $sorted = $ascending
            ? $numericValues->sort()
            : $numericValues->sortDesc();

        $total = max($sorted->count(), 1);
        $buckets = [];
        $rank = 0;

        foreach ($sorted as $fundId => $value) {
            $rank++;
            $bucket = (int) ceil(($rank / $total) * $bucketCount);
            $buckets[$fundId] = min(max($bucket, 1), $bucketCount);
        }

        foreach ($values as $fundId => $value) {
            if (!is_numeric($value)) {
                $buckets[$fundId] = 'N/A';
            }
        }

        return $buckets;
    }

    protected function isLowerBetterRatio(string $reportCategory): bool
    {
        return in_array($reportCategory, ['beta', 'volatility', 'tracking_error'], true);
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
