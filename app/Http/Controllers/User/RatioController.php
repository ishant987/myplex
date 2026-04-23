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
use App\Http\Controllers\Web\SortinoController;
use App\Http\Controllers\Web\TrackingerrorController;
use App\Http\Controllers\Web\TreynorController;
use App\Http\Controllers\Web\VolatilityController;
use App\Models\CorpusEntry;
use App\Models\CurrencyDetail;
use App\Models\FundDetail;
use App\Models\FundComposition;
use Illuminate\Http\Request;
use App\Models\McapEps;
use App\Models\CurrencyMaster;
use App\Models\FundMaster;
use App\Models\FundType;
use App\Models\IndicesDetail;
use App\Models\IndicesComposition;
use App\Models\IndicesMaster;
use App\Models\User;
use Carbon\CarbonInterface;
use Carbon\Carbon;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

    function ratio_analysis(Request $request){
      return view('web.auth.ratio_analysis.index', $this->subscriptionViewData(Auth::user()));
    }

    function composition_report(Request $request){
      return view('web.auth.composition_report.index', $this->subscriptionViewData(Auth::user()));
    }

    function indies_report(Request $request){
      return view('web.auth.indices_report.index', $this->subscriptionViewData(Auth::user()));
    }

    function indices_history(Request $request){
      $data = $this->indicesReportViewData($request);
      $selectedValues = array_values(array_filter((array) $request->input('indices', [])));
      $dateRange = $this->resolveExplicitDateRange($request->input('start_date'), $request->input('end_date'));

      $data['indices_vals'] = [];
      $data['indices_records'] = collect();

      if (!empty($selectedValues) && $dateRange) {
          $data['indices_records'] = collect($selectedValues)->map(function ($value) {
              return (object) [
                  'name' => $value,
                  'corelation' => $value,
              ];
          });

          foreach ($selectedValues as $selectedValue) {
              $points = IndicesDetail::query()
                  ->where('name', $selectedValue)
                  ->where('publish', 'y')
                  ->whereDate('entry_date', '>=', $dateRange['start']->toDateString())
                  ->whereDate('entry_date', '<=', $dateRange['end']->toDateString())
                  ->orderBy('entry_date')
                  ->get(['entry_date', 'closing_value']);

              $series = $points
                  ->filter(fn ($point) => is_numeric($point->closing_value) && $point->closing_value !== null)
                  ->map(fn ($point) => [
                      Carbon::parse($point->entry_date)->toDateString(),
                      round((float) $point->closing_value, 2),
                  ])
                  ->values()
                  ->all();

              if (!empty($series)) {
                  $data['indices_vals'][$selectedValue] = $series;
              }
          }
      }

      return view('web.indices-reports.indices-history', $data);
    }

    function indices_composition(Request $request){
      return view('web.indices-reports.indices-composition', $this->indicesReportViewData($request));
    }

    function schemes_associated_with_index(Request $request){
      $data = $this->indicesReportViewData($request);
      $selectedIndex = trim((string) $request->input('selected_index', ''));
      $selectedDate = $this->normalizeInputDate($request->input('date'));

      if ($selectedIndex !== '') {
          $funds = FundMaster::query()
              ->where('indices_name', $selectedIndex)
              ->orderBy('fund_name')
              ->get(['fund_id', 'fund_name', 'fund_code', 'classification', 'indices_name']);

          $data['all_schemes'] = $funds
              ->map(function ($fund) use ($selectedDate) {
                  if (empty($fund->fund_code)) {
                      return null;
                  }

                  $detailQuery = FundDetail::query()
                      ->where('fund_code', $fund->fund_code)
                      ->where('publish', 'y');

                  if ($selectedDate) {
                      $detailQuery->whereDate('entry_date', '<=', $selectedDate->toDateString());
                  }

                  $detail = $detailQuery
                      ->orderByDesc('entry_date')
                      ->first(['entry_date', 'closing_nav']);

                  if (!$detail) {
                      return null;
                  }

                  return (object) [
                      'fund_id' => $fund->fund_id,
                      'fund_name' => $fund->fund_name,
                      'classification' => $fund->classification,
                      'fund_code' => $fund->fund_code,
                      'entry_date' => $detail->entry_date,
                      'closing_nav' => $detail->closing_nav,
                  ];
              })
              ->filter()
              ->values();
      }

      return view('web.indices-reports.schemes-associated-with-index', $data);
    }

    function indices_boomers(Request $request){
      return view('web.indices-reports.boomers', $this->indicesMoversViewData($request));
    }

    function indices_busters(Request $request){
      return view('web.indices-reports.busters', $this->indicesMoversViewData($request));
    }

    function index_vs_nav(Request $request){
      return view('web.indices-reports.index-vs-NAV', $this->indexVsNavViewData($request));
    }

    function model_portfolio(){
      $user = Auth::user();
      $data = $this->subscriptionViewData($user);
      $data['page_title'] = 'Model Portfolio';
      $data['page_message'] = 'Model Portfolio is now available from the sidebar. This section is ready for detailed dashboard content.';

      return view('web.ratio-reports.generic_page', $data);
    }

    function filters(Request $request){
      return view('web.auth.filters.index', $this->reportViewData($request));
    }

    function filters_ratios(Request $request){
      return view('web.filters.index', $this->filtersRatiosViewData($request));
    }


    function filters_composition(Request $request){
      return view('web.filters.composition', $this->filtersIndexViewData($request, 'by_composition'));
    }

    function filters_jensens(Request $request){
      return view('web.filters.jensens', $this->filtersJensensViewData($request));
    }

    function filters_beta(Request $request){
      return view('web.filters.beta', $this->filtersBetaViewData($request));
    }

    function filters_volatility(Request $request){
      return view('web.filters.volatility', $this->filtersVolatilityViewData($request));
    }

    function filters_fund_count(Request $request)
    {
        $fundTypeId = (int) $request->input('fund_type_id');

        $count = $fundTypeId > 0
            ? FundMaster::query()->where('fund_type_id', $fundTypeId)->count()
            : 0;

        return response()->json([
            'count' => $count,
        ]);
    }

    function risk_ratio(Request $request){
      return view('web.auth.ratio_analysis.risk_ratio', $this->performanceRatiosViewData($request));
    }

    function return_ratio(Request $request){
      return view('web.auth.ratio_analysis.return_ratio', $this->performanceRatiosViewData($request));
    }

    function sortino_ratio(Request $request){
      $request->merge([
          'Category' => $request->input('Category', 'by_fund'),
          'report_category' => $request->input('report_category', 'sortino'),
      ]);

      $data = $this->reportViewData($request);
      $selection = $this->resolveFundSelection($request, $data);

      $data['fund_type'] = $data['all_fund_types'];
      $data['fund_names'] = $selection['fund_names'];
      $data['fund_type_name'] = $selection['fund_type_name'];
      $data['months'] = range(1, 12);
      $data['years'] = range((int) now()->format('Y'), 1950);
      $data['month'] = $request->input('month');
      $data['year'] = $request->input('year');
      $data['month_second'] = $request->input('month_second');
      $data['year_second'] = $request->input('year_second');

      if ($data['month'] && $data['year']) {
          $data['start_date'] = Carbon::createFromDate((int) $data['year'], (int) $data['month'], 1)->startOfMonth()->toDateString();
      } else {
          $data['start_date'] = null;
      }

      if ($data['month_second'] && $data['year_second']) {
          $data['end_date'] = Carbon::createFromDate((int) $data['year_second'], (int) $data['month_second'], 1)->endOfMonth()->toDateString();
      } else {
          $data['end_date'] = null;
      }

      $selectedFundIds = array_filter(array_map('intval', (array) $request->input('fund_id', [])));
      $minimumAcceptableRate = $request->input('limit');

      if (
          !empty($selectedFundIds) &&
          count($selectedFundIds) >= 2 &&
          $data['start_date'] &&
          $data['end_date'] &&
          $minimumAcceptableRate !== null &&
          $minimumAcceptableRate !== ''
      ) {
          $funds = FundMaster::query()
              ->whereIn('fund_id', $selectedFundIds)
              ->orderBy('fund_name')
              ->get();

          [$sortinoMap, $fundAllReturn] = $this->buildSortinoMap(
              $funds,
              Carbon::parse($data['start_date'])->startOfDay(),
              Carbon::parse($data['end_date'])->endOfDay(),
              (float) $minimumAcceptableRate
          );

          $data['stat_result'] = [
              'fund_absolute_return' => $sortinoMap,
          ];
          $data['fund_all_return'] = $fundAllReturn;
      }

      return view('web.auth.ratio_analysis.sortino_ratio', $data);
    }

    function predictive(Request $request){
      return view('web.predictive.index', $this->subscriptionViewData(Auth::user()));
    }

    function predictive_jensen_alpha(Request $request){
      return view('web.predictive.jensen_alpha', $this->predictiveViewData($request));
    }

    function predictive_sharp_ratio(Request $request){
      return view('web.predictive.sharp_ratio', $this->predictiveViewData($request));
    }

    function predictive_trenyor(Request $request){
      return view('web.predictive.trenyor', $this->predictiveViewData($request));
    }

    function allocation_snapshot(Request $request){
      return view('web.composition_report.allocation_snapshot', $this->compositionReportViewData($request));
    }

    function scheme_portfolio(Request $request){
      return view('web.composition_report.scheme_portfolio', $this->compositionReportViewData($request));
    }

    function occurrence_report(Request $request){
      return view('web.composition_report.occurrence_report', $this->compositionReportViewData($request));
    }

    function top_script_rop_industry(Request $request){
      return view('web.composition_report.top_script_rop_industry', $this->compositionReportViewData($request));
    }

    function new_script_new_industry(Request $request){
      return view('web.composition_report.new_script_new_industry', $this->compositionReportViewData($request));
    }

    function boomers(Request $request){
      return view('web.composition_report.boomers', $this->compositionReportViewData($request));
    }

    function busters(Request $request){
      return view('web.composition_report.busters', $this->compositionReportViewData($request));
    }

    function predictive_fund_details(Request $request)
    {
        $fundId = (int) $request->input('id');
        $fund = $fundId > 0 ? FundMaster::query()->find($fundId) : null;

        if (!$fund) {
            return response()->json([
                'entry_date' => 'N/A',
                'name' => 'N/A',
                'closing_value' => '0.0',
            ]);
        }

        $detail = FundDetail::query()
            ->where('fund_code', $fund->fund_code)
            ->where('publish', 'y')
            ->orderByDesc('entry_date')
            ->first();

        $index = !empty($fund->indices_name)
            ? IndicesMaster::query()
                ->where('name', $fund->indices_name)
                ->orWhere('corelation', $fund->indices_name)
                ->first(['name', 'corelation'])
            : null;

        $lookupNames = array_values(array_unique(array_filter([
            $fund->indices_name,
            $index?->name,
            $index?->corelation,
        ])));

        $indexDetail = empty($lookupNames)
            ? null
            : IndicesDetail::query()
                ->where(function ($query) use ($lookupNames) {
                    $query->whereIn('name', $lookupNames);

                    if ($this->columnExists('indices_detail', 'correlation_new')) {
                        $query->orWhereIn('correlation_new', $lookupNames);
                    }
                })
                ->where('publish', 'y')
                ->orderByDesc('entry_date')
                ->first(['entry_date', 'name', 'closing_value']);

        return response()->json([
            'entry_date' => $detail?->entry_date ? Carbon::parse($detail->entry_date)->format('d-m-Y') : 'N/A',
            'name' => $indexDetail?->name ?? $fund->indices_name ?? 'N/A',
            'closing_value' => $indexDetail?->closing_value ?? '0.0',
        ]);
    }

    function composition_get_funds(Request $request)
    {
        $fundTypeId = (int) $request->input('type_id');
        $funds = $fundTypeId > 0
            ? FundMaster::query()->where('fund_type_id', $fundTypeId)->orderBy('fund_name')->get(['fund_id', 'fund_name', 'fund_code'])
            : collect();

        return response()->json($funds);
    }

    function composition_get_fund_by_scrips(Request $request)
    {
        return response()->json([]);
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

    public static function loggedInUserData($user = null): array
    {
        return app(self::class)->subscriptionViewData($user ?? Auth::user());
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
            'fund_all_return' => [],
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

    protected function predictiveViewData(Request $request): array
    {
        $funds = $this->safeFundList();
        $selectedFundId = (int) $request->input('fund_id', $funds->first()->fund_id ?? 0);
        $duration = (string) $request->input('duration', '6');

        $data = array_merge($this->reportViewData($request), [
            'fundMasterData' => $this->safeFundList(),
            'getData' => $request->all(),
            'selected_fund_id' => $selectedFundId,
            'expected_index' => $request->input('expected_index'),
            'indices_details' => null,
            'fund_details' => null,
            'graph_date' => [],
            'nav_value' => [],
            'closing_value' => [],
            'fund_series' => [],
            'index_series' => [],
            'duration' => $duration,
            'message' => null,
            'predictive_debug' => [
                'route' => optional($request->route())->getName(),
                'fund_id' => $selectedFundId,
                'fund_code' => null,
                'index_name' => null,
                'duration' => $duration,
                'start_date' => null,
                'end_date' => null,
                'fund_points_count' => 0,
                'index_points_count' => 0,
                'fund_series_count' => 0,
                'index_series_count' => 0,
            ],
        ]);

        if ($selectedFundId <= 0) {
            return $data;
        }

        $fund = FundMaster::query()->find($selectedFundId);
        if (!$fund || empty($fund->fund_code)) {
            return $data;
        }

        $latestFundDetail = FundDetail::query()
            ->where('fund_code', $fund->fund_code)
            ->where('publish', 'y')
            ->orderByDesc('entry_date')
            ->first(['entry_date', 'closing_nav']);

        $data['fund_details'] = $fund;

        if (!$latestFundDetail) {
            return $data;
        }

        $endDate = Carbon::parse($latestFundDetail->entry_date)->startOfDay();
        $startDate = $duration === '1'
            ? $endDate->copy()->subYear()
            : $endDate->copy()->subMonths(6);

        $index = !empty($fund->indices_name)
            ? IndicesMaster::query()
                ->where('name', $fund->indices_name)
                ->orWhere('corelation', $fund->indices_name)
                ->first(['name', 'corelation'])
            : null;

        $lookupNames = array_values(array_unique(array_filter([
            $fund->indices_name,
            $index?->name,
            $index?->corelation,
        ])));

        $fundPoints = FundDetail::query()
            ->where('fund_code', $fund->fund_code)
            ->where('publish', 'y')
            ->whereDate('entry_date', '>=', $startDate->toDateString())
            ->whereDate('entry_date', '<=', $endDate->toDateString())
            ->orderBy('entry_date')
            ->get(['entry_date', 'closing_nav']);

        $indexPoints = empty($lookupNames)
            ? collect()
            : IndicesDetail::query()
                ->where(function ($query) use ($lookupNames) {
                    $query->whereIn('name', $lookupNames);

                    if ($this->columnExists('indices_detail', 'correlation_new')) {
                        $query->orWhereIn('correlation_new', $lookupNames);
                    }
                })
                ->where('publish', 'y')
                ->whereDate('entry_date', '>=', $startDate->toDateString())
                ->whereDate('entry_date', '<=', $endDate->toDateString())
                ->orderBy('entry_date')
                ->get(['entry_date', 'closing_value']);

        $fundSeries = $this->buildChartSeriesFromPoints($fundPoints, 'entry_date', 'closing_nav');
        $indexSeries = $this->buildChartSeriesFromPoints($indexPoints, 'entry_date', 'closing_value');

        Log::info('Predictive chart data prepared', [
            'route' => optional($request->route())->getName(),
            'fund_id' => $selectedFundId,
            'fund_code' => $fund->fund_code,
            'index_name' => $fund->indices_name,
            'duration' => $duration,
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'fund_points_count' => $fundPoints->count(),
            'index_points_count' => $indexPoints->count(),
            'fund_series_count' => count($fundSeries),
            'index_series_count' => count($indexSeries),
        ]);

        $data['predictive_debug'] = [
            'route' => optional($request->route())->getName(),
            'fund_id' => $selectedFundId,
            'fund_code' => $fund->fund_code,
            'index_name' => $fund->indices_name,
            'duration' => $duration,
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'fund_points_count' => $fundPoints->count(),
            'index_points_count' => $indexPoints->count(),
            'fund_series_count' => count($fundSeries),
            'index_series_count' => count($indexSeries),
        ];

        $data['indices_details'] = $index ?? (object) ['name' => $fund->indices_name, 'corelation' => $fund->indices_name];
        $data['fund_series'] = $fundSeries;
        $data['index_series'] = $indexSeries;
        $data['graph_date'] = collect($fundSeries)->pluck(0)->all();
        $data['nav_value'] = collect($fundSeries)->pluck(1)->all();
        $data['closing_value'] = collect($indexSeries)->pluck(1)->all();

        if ($request->has('duration') && empty($fundSeries) && empty($indexSeries)) {
            $data['message'] = 'No graph data is available for the selected period.';
        }

        return $data;
    }

    protected function compositionReportViewData(Request $request): array
    {
        $request->merge([
            'fund_type_id' => $request->input('fund_type_id', $request->input('fund_type')),
        ]);

        $data = $this->reportViewData($request);
        $months = range(1, 12);
        $years = range((int) now()->format('Y'), 1950);
        $getData = array_merge([
            'scrip_industry' => 'scrip',
            'Category' => $request->input('Category'),
            'fund_id' => [],
            'fund_type_id' => $request->input('fund_type_id'),
            'industry' => null,
            'fund_scrips' => null,
            'year' => $request->input('year'),
            'month' => $request->input('month'),
        ], $request->all());

        $selection = $this->resolveFundSelection($request, $data);
        $hasSearched = $request->filled('month') && $request->filled('year') && filled($request->input('Category'));
        $fundSnapshot = [];
        $snapshotDate = null;
        $disclaimer = '';

        if ($hasSearched) {
            $snapshotData = $this->buildAllocationSnapshotData($request, $selection['funds']);
            $fundSnapshot = $snapshotData['rows'];
            $snapshotDate = $snapshotData['snapshot_date'];
            $disclaimer = $snapshotData['disclaimer'];

            if ($selection['funds']->isEmpty()) {
                $data['message'] = $request->input('Category') === 'by_fund'
                    ? 'Choose at least 2 funds to run this report.'
                    : 'Choose a fund classification to run this report.';
            } elseif (empty($fundSnapshot)) {
                $data['message'] = 'No information available for this search.';
            }
        }

        return array_merge($data, [
            'fund_type' => $data['all_fund_types'],
            'fund_master' => $data['all_funds'],
            'months' => $months,
            'years' => $years,
            'month' => $request->input('month'),
            'year' => $request->input('year'),
            'month_second' => $request->input('month_second'),
            'year_second' => $request->input('year_second'),
            'limit' => $request->input('limit'),
            'getData' => $getData,
            'has_searched' => $hasSearched,
            'industries' => collect(),
            'mpx_fund_scrips' => collect(),
            'scrips' => collect(),
            'total_corpus_entry' => null,
            'top_scrips' => null,
            'top_industries' => null,
            'monthName' => $request->filled('month') ? date('F', mktime(0, 0, 0, (int) $request->input('month'), 10)) : null,
            'lastDate' => $snapshotDate,
            'active_tab' => $request->input('active_tab'),
            'fund_type_get_data' => null,
            'fund_details' => $selection['funds']->map(fn ($fund) => ['fund_id' => $fund->fund_id])->all(),
            'fund_ids' => (array) $request->input('fund_id', []),
            'fund_composition' => null,
            'fund_snapshot' => $fundSnapshot,
            'fund_names' => $selection['fund_names'],
            'fund_type_name' => $selection['fund_type_name'],
            'disclaimer' => $disclaimer,
        ]);
    }

    protected function buildAllocationSnapshotData(Request $request, Collection $funds): array
    {
        $month = (int) $request->input('month');
        $year = (int) $request->input('year');

        if ($month <= 0 || $year <= 0 || $funds->isEmpty()) {
            return [
                'rows' => [],
                'snapshot_date' => null,
                'disclaimer' => '',
            ];
        }

        $fundCodes = $funds->pluck('fund_code')->filter()->values();

        if ($fundCodes->isEmpty()) {
            return [
                'rows' => [],
                'snapshot_date' => null,
                'disclaimer' => '',
            ];
        }

        $snapshotDate = FundComposition::query()
            ->whereIn('fund_code', $fundCodes->all())
            ->where('publish', 'y')
            ->whereMonth('entry_date', $month)
            ->whereYear('entry_date', $year)
            ->max('entry_date');

        if (!$snapshotDate) {
            return [
                'rows' => [],
                'snapshot_date' => null,
                'disclaimer' => '',
            ];
        }

        $rankMap = $this->buildCompositionRankMap($snapshotDate);
        $compositions = FundComposition::query()
            ->whereIn('fund_code', $fundCodes->all())
            ->where('publish', 'y')
            ->whereDate('entry_date', $snapshotDate)
            ->get(['fund_code', 'scrip_name', 'category', 'content_per']);
        $peMap = McapEps::query()
            ->where('publish', 'y')
            ->whereDate('entry_date', $snapshotDate)
            ->pluck('pe', 'scrip_name');
        $fundNames = $funds->pluck('fund_name', 'fund_code');
        $rows = [];

        foreach ($fundCodes as $fundCode) {
            $fundRows = $compositions->where('fund_code', $fundCode);

            if ($fundRows->isEmpty()) {
                continue;
            }

            $cash = 0.0;
            $sov = 0.0;
            $debt = 0.0;
            $eqSmall = 0.0;
            $eqMid = 0.0;
            $eqLarge = 0.0;
            $eqVeryLarge = 0.0;
            $wtPe = 0.0;

            foreach ($fundRows as $row) {
                $content = (float) ($row->content_per ?? 0);
                $category = strtoupper(trim((string) $row->category));

                if ($category === 'CASH') {
                    $cash += $content;
                    continue;
                }

                if ($category === 'SOV') {
                    $sov += $content;
                    continue;
                }

                if (in_array($category, ['CORPORATE DEBT', 'CORPORATEDEBT'], true)) {
                    $debt += $content;
                    continue;
                }

                if ($category !== 'EQUITY') {
                    continue;
                }

                $status = $rankMap[$row->scrip_name] ?? 'SC';

                if ($status === 'VLC') {
                    $eqVeryLarge += $content;
                } elseif ($status === 'LC') {
                    $eqLarge += $content;
                } elseif ($status === 'MC') {
                    $eqMid += $content;
                } else {
                    $eqSmall += $content;
                }

                $pe = $peMap[$row->scrip_name] ?? null;
                if (is_numeric($pe) && (float) $pe > 0) {
                    $wtPe += ((float) $pe * $content) / 100;
                }
            }

            $othersVal = max(0, 100 - ($cash + $sov + $debt + $eqSmall + $eqMid + $eqLarge + $eqVeryLarge));

            $rows[] = [
                'fund_name' => $fundNames[$fundCode] ?? $fundCode,
                'cash' => number_format($cash, 2, '.', ''),
                'sov' => number_format($sov, 2, '.', ''),
                'debt' => number_format($debt, 2, '.', ''),
                'eq_small' => number_format($eqSmall, 2, '.', ''),
                'eq_mid' => number_format($eqMid, 2, '.', ''),
                'eq_large' => number_format($eqLarge, 2, '.', ''),
                'eq_very_large' => number_format($eqVeryLarge, 2, '.', ''),
                'others_val' => number_format($othersVal, 2, '.', ''),
                'wt_pe' => number_format($wtPe, 2, '.', ''),
            ];
        }

        return [
            'rows' => $rows,
            'snapshot_date' => $snapshotDate,
            'disclaimer' => 'For loss making scrips, earnings are considered as zero.',
        ];
    }

    protected function buildCompositionRankMap(string $snapshotDate): array
    {
        $equityRows = IndicesComposition::query()
            ->where('publish', 'y')
            ->whereDate('entry_date', $snapshotDate)
            ->where('indices_name', 'BSE 500')
            ->where('type', 'Equity')
            ->orderByDesc('percentage')
            ->get(['scrip_name']);

        $rankMap = [];

        foreach ($equityRows->values() as $index => $row) {
            $rank = $index + 1;
            $rankMap[$row->scrip_name] = match (true) {
                $rank <= 15 => 'VLC',
                $rank <= 100 => 'LC',
                $rank <= 250 => 'MC',
                default => 'SC',
            };
        }

        $additionalScrips = McapEps::query()
            ->where('publish', 'y')
            ->whereDate('entry_date', $snapshotDate)
            ->pluck('scrip_name');

        foreach ($additionalScrips as $scripName) {
            if (!isset($rankMap[$scripName])) {
                $rankMap[$scripName] = 'SC';
            }
        }

        return $rankMap;
    }

    protected function filtersRatiosViewData(Request $request): array
    {
        $request->merge([
            'filter' => 'by_ratio',
            'Category' => $request->input('Category', 'by_fund'),
            'fund_type_id' => $request->input('fund_type_id', $request->input('fund_type')),
        ]);

        $data = array_merge($this->reportViewData($request), [
            'filter' => 'by_ratio',
            'Category' => $request->input('Category', 'by_fund'),
            'fund_type' => $request->input('fund_type', $request->input('fund_type_id')),
            'checkedFundIds' => (string) $request->input('checkedFundIds', ''),
            'records' => $request->input('records'),
            'getData' => $request->all(),
            'industries' => collect(),
            'mpx_fund_scrips' => collect(),
            'fund_absolute_return' => [],
        ]);

        if (!$request->filled('report_category')) {
            return $data;
        }

        $ratioData = $this->performanceRatiosViewData($request);

        $data['message'] = $ratioData['message'] ?? $data['message'];
        $data['fund_names'] = $ratioData['fund_names'] ?? $data['fund_names'];
        $data['fund_type_name'] = $ratioData['fund_type_name'] ?? $data['fund_type_name'];
        $data['request_fund_type'] = $ratioData['request_fund_type'] ?? $data['request_fund_type'];
        $data['start_date'] = $ratioData['start_date'] ?? $data['start_date'];
        $data['end_date'] = $ratioData['end_date'] ?? $data['end_date'];
        $data['as_on_time_frame_data'] = $ratioData['as_on_time_frame_data'] ?? $data['as_on_time_frame_data'];
        $data['fund_absolute_return'] = $ratioData['stat_result']['fund_absolute_return'] ?? [];

        if (empty($data['checkedFundIds']) && !empty($data['fund_absolute_return'])) {
            $data['checkedFundIds'] = implode(',', array_keys($data['fund_absolute_return']));
        }

        return $data;
    }

    protected function filtersIndexViewData(Request $request, string $filter = 'by_ratio'): array
    {
        if ($filter === 'by_composition') {
            return $this->filtersCompositionViewData($request);
        }

        return $this->filtersRatiosViewData($request);
    }

    protected function filtersCompositionViewData(Request $request): array
    {
        $request->merge([
            'filter' => 'by_composition',
            'Category' => $request->input('Category', 'by_fund'),
            'fund_type_id' => $request->input('fund_type_id', $request->input('fund_type')),
        ]);

        $data = array_merge($this->reportViewData($request), [
            'filter' => 'by_composition',
            'Category' => $request->input('Category', 'by_fund'),
            'fund_type' => $request->input('fund_type', $request->input('fund_type_id')),
            'checkedFundIds' => (string) $request->input('checkedFundIds', ''),
            'records' => $request->input('records'),
            'getData' => $request->all(),
            'industries' => $this->safeFundCompositionIndustryList(),
            'mpx_fund_scrips' => $this->safeFundCompositionScripList(),
            'fund_absolute_return' => [],
        ]);

        $selection = $this->resolveFundSelection($request, $data);
        $data['fund_names'] = $selection['fund_names'];
        $data['fund_type_name'] = $selection['fund_type_name'];

        $composition = (string) $request->input('composition', '');
        if ($composition === '') {
            return $data;
        }

        if ($selection['funds']->isEmpty()) {
            $data['message'] = $request->input('Category') === 'by_category'
                ? 'Choose a fund classification to run this report.'
                : 'Choose at least 1 fund to run this report.';

            return $data;
        }

        if (
            ($composition === 'scrip' && !filled($request->input('fund_scrips'))) ||
            ($composition === 'industry' && !filled($request->input('industry')))
        ) {
            return $data;
        }

        $range = $this->resolveRankingRange($request);
        $data['start_date'] = $range['start']->toDateString();
        $data['end_date'] = $range['end']->toDateString();

        if ($range['mode'] === 'as_on') {
            $data['as_on_time_frame_data'] = [$request->input('as_on_time_frame')];
        }

        $data['fund_absolute_return'] = $this->buildCompositionFilterMap(
            $selection['funds'],
            $composition,
            $range['start'],
            $range['end'],
            $range['mode'],
            [
                'fund_scrips' => $request->input('fund_scrips'),
                'industry' => $request->input('industry'),
            ]
        );

        if (empty($data['checkedFundIds']) && !empty($data['fund_absolute_return'])) {
            $data['checkedFundIds'] = implode(',', array_keys($data['fund_absolute_return']));
        }

        return $data;
    }

    protected function filtersJensensViewData(Request $request): array
    {
        $funds = $this->safeFundList();
        $selectedFundId = (int) $request->input('fund_id', $funds->first()->fund_id ?? 0);
        $duration = (string) $request->input('duration', '6');

        $data = array_merge($this->reportViewData($request), [
            'fundMasterData' => $funds,
            'selected_fund_id' => $selectedFundId,
            'duration' => $duration,
            'fund_details' => null,
            'indices_details' => null,
            'current_date' => null,
            'current_value' => null,
            'fund_series' => [],
            'index_series' => [],
        ]);

        if ($selectedFundId <= 0) {
            return $data;
        }

        $fund = FundMaster::query()->find($selectedFundId);
        if (!$fund || empty($fund->fund_code)) {
            return $data;
        }

        $latestFundDetail = FundDetail::query()
            ->where('fund_code', $fund->fund_code)
            ->where('publish', 'y')
            ->orderByDesc('entry_date')
            ->first(['entry_date', 'closing_nav']);

        $data['fund_details'] = $fund;

        if (!$latestFundDetail) {
            $data['message'] = 'No fund history is available for the selected scheme.';

            return $data;
        }

        $endDate = Carbon::parse($latestFundDetail->entry_date)->startOfDay();
        $startDate = $duration === '1'
            ? $endDate->copy()->subYear()
            : $endDate->copy()->subMonths(6);

        $index = !empty($fund->indices_name)
            ? IndicesMaster::query()
                ->where('name', $fund->indices_name)
                ->orWhere('corelation', $fund->indices_name)
                ->first(['name', 'corelation'])
            : null;

        $lookupNames = array_values(array_unique(array_filter([
            $fund->indices_name,
            $index?->name,
            $index?->corelation,
        ])));

        $latestIndexDetail = null;
        if (!empty($lookupNames)) {
            $latestIndexDetail = IndicesDetail::query()
                ->where(function ($query) use ($lookupNames) {
                    $query->whereIn('name', $lookupNames);

                    if ($this->columnExists('indices_detail', 'correlation_new')) {
                        $query->orWhereIn('correlation_new', $lookupNames);
                    }
                })
                ->where('publish', 'y')
                ->whereDate('entry_date', '<=', $endDate->toDateString())
                ->orderByDesc('entry_date')
                ->first(['entry_date', 'name', 'closing_value']);
        }

        $fundPoints = FundDetail::query()
            ->where('fund_code', $fund->fund_code)
            ->where('publish', 'y')
            ->whereDate('entry_date', '>=', $startDate->toDateString())
            ->whereDate('entry_date', '<=', $endDate->toDateString())
            ->orderBy('entry_date')
            ->get(['entry_date', 'closing_nav']);

        $indexPoints = empty($lookupNames)
            ? collect()
            : IndicesDetail::query()
                ->where(function ($query) use ($lookupNames) {
                    $query->whereIn('name', $lookupNames);

                    if ($this->columnExists('indices_detail', 'correlation_new')) {
                        $query->orWhereIn('correlation_new', $lookupNames);
                    }
                })
                ->where('publish', 'y')
                ->whereDate('entry_date', '>=', $startDate->toDateString())
                ->whereDate('entry_date', '<=', $endDate->toDateString())
                ->orderBy('entry_date')
                ->get(['entry_date', 'closing_value']);

        $data['indices_details'] = $index ?? (object) ['name' => $fund->indices_name, 'corelation' => $fund->indices_name];
        $data['current_date'] = $endDate->format('d-m-Y');
        $data['current_value'] = $latestIndexDetail && is_numeric($latestIndexDetail->closing_value ?? null)
            ? round((float) $latestIndexDetail->closing_value, 2)
            : null;
        $data['fund_series'] = $this->buildChartSeriesFromPoints($fundPoints, 'entry_date', 'closing_nav');
        $data['index_series'] = $this->buildChartSeriesFromPoints($indexPoints, 'entry_date', 'closing_value');

        if ($request->has('duration') && empty($data['fund_series']) && empty($data['index_series'])) {
            $data['message'] = 'No graph data is available for the selected period.';
        }

        return $data;
    }

    protected function filtersBetaViewData(Request $request): array
    {
        return $this->filtersJensensViewData($request);
    }

    protected function filtersVolatilityViewData(Request $request): array
    {
        return $this->filtersJensensViewData($request);
    }

    protected function indicesReportViewData(Request $request): array
    {
        $data = $this->reportViewData($request);

        $data = array_merge($data, [
            'indices' => $this->safeIndicesList(),
            'schemes' => $this->safeFundList(),
            'months' => range(1, 12),
            'years' => range((int) now()->format('Y'), 1950),
            'month' => $request->input('month'),
            'year' => $request->input('year'),
            'month_second' => $request->input('month_second'),
            'year_second' => $request->input('year_second'),
            'limit' => $request->input('limit'),
            'indices_name' => $request->input('indices', []),
            'indices_vals' => [],
            'indices_composition' => null,
            'all_schemes' => collect(),
            'results_scrips' => null,
            'results_industries' => null,
            'indices_records' => collect(),
        ]);

        return $data;
    }

    protected function indicesMoversViewData(Request $request): array
    {
        $data = $this->indicesReportViewData($request);
        $selectedValues = array_values(array_filter((array) $request->input('indices', [])));
        $periodOne = $this->resolveMonthYearPeriod($request->input('month'), $request->input('year'));
        $periodTwo = $this->resolveMonthYearPeriod($request->input('month_second'), $request->input('year_second'));

        if (empty($selectedValues) || !$periodOne || !$periodTwo) {
            return $data;
        }

        $selectedIndices = IndicesMaster::query()
            ->whereIn('corelation', $selectedValues)
            ->orWhereIn('name', $selectedValues)
            ->orderBy('name')
            ->get();

        $selectedIndexMap = $selectedIndices->flatMap(function ($index) {
            $keys = array_values(array_unique(array_filter([
                $index->corelation ?? null,
                $index->name ?? null,
            ])));

            return collect($keys)->mapWithKeys(fn ($key) => [$key => $index]);
        });

        $data['indices_records'] = collect($selectedValues)->map(function ($value) use ($selectedIndexMap) {
            $index = $selectedIndexMap->get($value);

            return (object) [
                'name' => $index->name ?? $value,
                'corelation' => $index->corelation ?? $value,
            ];
        });

        $resultsScrips = collect();
        $resultsIndustry = collect();

        foreach ($selectedValues as $selectedValue) {
            $selectedIndex = $selectedIndexMap->get($selectedValue);
            $lookupNames = array_values(array_unique(array_filter([
                $selectedValue,
                $selectedIndex->corelation ?? null,
                $selectedIndex->name ?? null,
            ])));

            if (empty($lookupNames)) {
                continue;
            }

            $displayName = $selectedIndex->name ?? $selectedValue;
            $periodOneRows = $this->fetchLatestIndicesCompositionRows($lookupNames, $periodOne['end']);
            $periodTwoRows = $this->fetchLatestIndicesCompositionRows($lookupNames, $periodTwo['end']);

            $resultsScrips = $resultsScrips->concat(
                $this->buildIndicesMoverRows($periodOneRows, $periodTwoRows, 'scrip_name', $displayName)
            );

            $resultsIndustry = $resultsIndustry->concat(
                $this->buildIndicesMoverRows($periodOneRows, $periodTwoRows, 'industry', $displayName)
            );
        }

        $data['results_scrips'] = $resultsScrips->values();
        $data['results_industry'] = $resultsIndustry->values();
        $data['results_industries'] = $data['results_industry'];

        return $data;
    }

    protected function indexVsNavViewData(Request $request): array
    {
        $data = $this->indicesReportViewData($request);
        $dateRange = $this->resolveExplicitDateRange($request->input('from_date'), $request->input('to_date'));

        $data['indices_vals_1'] = [];

        if (!$dateRange) {
            return $data;
        }

        $primary = $this->resolveIndexVsNavSelection(
            (string) $request->input('main_select', 'scheme'),
            (string) $request->input('scheme_main', ''),
            (string) $request->input('index_main', ''),
            $dateRange['start'],
            $dateRange['end']
        );

        $compare = $this->resolveIndexVsNavSelection(
            (string) $request->input('select_1', 'scheme'),
            (string) $request->input('scheme_1', ''),
            (string) $request->input('index_1', ''),
            $dateRange['start'],
            $dateRange['end']
        );

        if (!empty($primary['series'])) {
            $data['indices_vals_1'][$primary['label']] = $primary['series'];
        }

        if (!empty($compare['series'])) {
            $label = $compare['label'];
            if (array_key_exists($label, $data['indices_vals_1'])) {
                $label .= ' (Compare)';
            }

            $data['indices_vals_1'][$label] = $compare['series'];
        }

        return $data;
    }

    protected function populateIndicesHistoryData(Request $request, array $data): array
    {
        $selectedCorrelations = array_values(array_filter((array) $request->input('indices', [])));
        $dateRange = $this->resolveExplicitDateRange($request->input('start_date'), $request->input('end_date'));

        if (empty($selectedCorrelations) || !$dateRange) {
            return $data;
        }

        $selectedIndices = IndicesMaster::query()
            ->whereIn('corelation', $selectedCorrelations)
            ->orWhereIn('name', $selectedCorrelations)
            ->orderBy('name')
            ->get();

        $selectedIndexMap = $selectedIndices->flatMap(function ($index) {
            $keys = array_values(array_unique(array_filter([
                $index->corelation ?? null,
                $index->name ?? null,
            ])));

            return collect($keys)->mapWithKeys(fn ($key) => [$key => $index]);
        });

        $data['indices_records'] = collect($selectedCorrelations)->map(function ($value) use ($selectedIndexMap) {
            $index = $selectedIndexMap->get($value);

            return (object) [
                'name' => $index->name ?? $value,
                'corelation' => $index->corelation ?? $value,
            ];
        });
        $data['indices_vals'] = [];

        foreach ($selectedCorrelations as $selectedValue) {
            $selectedIndex = $selectedIndexMap->get($selectedValue);
            $lookupNames = array_values(array_unique(array_filter([
                $selectedValue,
                $selectedIndex->corelation ?? null,
                $selectedIndex->name ?? null,
            ])));

            if (empty($lookupNames)) {
                continue;
            }

            $points = IndicesDetail::query()
                ->whereIn('name', $lookupNames)
                ->where('publish', 'y')
                ->whereDate('entry_date', '>=', $dateRange['start']->toDateString())
                ->whereDate('entry_date', '<=', $dateRange['end']->toDateString())
                ->orderBy('entry_date')
                ->get(['entry_date', 'closing_value']);

            $series = $points
                ->filter(fn ($point) => is_numeric($point->closing_value) && $point->closing_value !== null)
                ->map(fn ($point) => [
                    Carbon::parse($point->entry_date)->toDateString(),
                    round((float) $point->closing_value, 2),
                ])
                ->values()
                ->all();

            if (!empty($series)) {
                $seriesName = $selectedIndex->name ?? $selectedValue;
                $data['indices_vals'][$seriesName] = $series;
            }
        }

        return $data;
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

    protected function resolveMonthYearPeriod($month, $year): ?array
    {
        if (!$month || !$year) {
            return null;
        }

        try {
            $start = Carbon::createFromDate((int) $year, (int) $month, 1)->startOfMonth();
            $end = $start->copy()->endOfMonth();

            return [
                'start' => $start,
                'end' => $end,
            ];
        } catch (Throwable $e) {
            return null;
        }
    }

    protected function fetchLatestIndicesCompositionRows(array $lookupNames, CarbonInterface $periodEnd): Collection
    {
        $rows = IndicesComposition::query()
            ->whereIn('indices_name', $lookupNames)
            ->where('publish', 'y')
            ->whereDate('entry_date', '<=', $periodEnd->toDateString())
            ->orderByDesc('entry_date')
            ->get(['entry_date', 'indices_name', 'scrip_name', 'industry', 'percentage']);

        if ($rows->isEmpty()) {
            return collect();
        }

        $latestDate = $rows->first()->entry_date;

        return $rows->where('entry_date', $latestDate)->values();
    }

    protected function fetchLatestFundCompositionRows(
        string $fundCode,
        CarbonInterface $startDate,
        CarbonInterface $endDate,
        string $mode = 'range'
    ): Collection {
        try {
            $query = FundComposition::query()
                ->where('fund_code', $fundCode)
                ->where('publish', 'y');

            if ($mode === 'as_on') {
                $query->whereDate('entry_date', '<=', $endDate->toDateString());
            } else {
                $query->whereDate('entry_date', '>=', $startDate->toDateString())
                    ->whereDate('entry_date', '<=', $endDate->toDateString());
            }

            $rows = $query
                ->orderByDesc('entry_date')
                ->get(['entry_date', 'scrip_name', 'industry', 'content_per', 'amount']);

            if ($rows->isEmpty()) {
                return collect();
            }

            $latestDate = $rows->first()->entry_date;

            return $rows->where('entry_date', $latestDate)->values();
        } catch (Throwable $e) {
            return collect();
        }
    }

    protected function resolveIndexVsNavSelection(
        string $selectionType,
        string $schemeCode,
        string $indexValue,
        CarbonInterface $startDate,
        CarbonInterface $endDate
    ): array {
        if ($selectionType === 'index') {
            return $this->buildIndexChartSelection($indexValue, $startDate, $endDate);
        }

        return $this->buildSchemeChartSelection($schemeCode, $startDate, $endDate);
    }

    protected function buildSchemeChartSelection(string $fundCode, CarbonInterface $startDate, CarbonInterface $endDate): array
    {
        $fund = $fundCode !== ''
            ? FundMaster::query()->where('fund_code', $fundCode)->first(['fund_name', 'fund_code'])
            : null;

        if (!$fund || empty($fund->fund_code)) {
            return ['label' => 'Scheme', 'series' => []];
        }

        $points = FundDetail::query()
            ->where('fund_code', $fund->fund_code)
            ->where('publish', 'y')
            ->whereDate('entry_date', '>=', $startDate->toDateString())
            ->whereDate('entry_date', '<=', $endDate->toDateString())
            ->orderBy('entry_date')
            ->get(['entry_date', 'closing_nav']);

        return [
            'label' => $fund->fund_name,
            'series' => $this->buildChartSeriesFromPoints($points, 'entry_date', 'closing_nav'),
        ];
    }

    protected function buildIndexChartSelection(string $indexValue, CarbonInterface $startDate, CarbonInterface $endDate): array
    {
        if ($indexValue === '') {
            return ['label' => 'Index', 'series' => []];
        }

        $index = IndicesMaster::query()
            ->where('corelation', $indexValue)
            ->orWhere('name', $indexValue)
            ->first(['name', 'corelation']);

        $lookupNames = array_values(array_unique(array_filter([
            $indexValue,
            $index?->name,
            $index?->corelation,
        ])));

        $points = IndicesDetail::query()
            ->where(function ($query) use ($lookupNames) {
                $query->whereIn('name', $lookupNames);

                if ($this->columnExists('indices_detail', 'correlation_new')) {
                    $query->orWhereIn('correlation_new', $lookupNames);
                }
            })
            ->where('publish', 'y')
            ->whereDate('entry_date', '>=', $startDate->toDateString())
            ->whereDate('entry_date', '<=', $endDate->toDateString())
            ->orderBy('entry_date')
            ->get(['entry_date', 'closing_value']);

        return [
            'label' => $index?->name ?? $indexValue,
            'series' => $this->buildChartSeriesFromPoints($points, 'entry_date', 'closing_value'),
        ];
    }

    protected function buildChartSeriesFromPoints(Collection $points, string $dateKey, string $valueKey): array
    {
        return $points
            ->filter(function ($point) use ($dateKey, $valueKey) {
                return data_get($point, $dateKey) && is_numeric(data_get($point, $valueKey));
            })
            ->map(function ($point) use ($dateKey, $valueKey) {
                return [
                    Carbon::parse(data_get($point, $dateKey))->toDateString(),
                    round((float) data_get($point, $valueKey), 2),
                ];
            })
            ->values()
            ->all();
    }

    protected function safeFundCompositionScripList(): Collection
    {
        try {
            return FundComposition::query()
                ->where('publish', 'y')
                ->whereNotNull('scrip_name')
                ->where('scrip_name', '!=', '')
                ->selectRaw('scrip_name as actual_scrip')
                ->distinct()
                ->orderBy('actual_scrip')
                ->get();
        } catch (Throwable $e) {
            return collect();
        }
    }

    protected function safeFundCompositionIndustryList(): Collection
    {
        try {
            return FundComposition::query()
                ->where('publish', 'y')
                ->whereNotNull('industry')
                ->where('industry', '!=', '')
                ->select('industry')
                ->distinct()
                ->orderBy('industry')
                ->get();
        } catch (Throwable $e) {
            return collect();
        }
    }

    protected function buildCompositionFilterMap(
        Collection $funds,
        string $composition,
        CarbonInterface $startDate,
        CarbonInterface $endDate,
        string $mode,
        array $filters = []
    ): array {
        $result = [];

        foreach ($funds as $fund) {
            if (empty($fund->fund_id) || empty($fund->fund_code)) {
                continue;
            }

            $value = match ($composition) {
                'scrip' => $this->resolveFundCompositionValue(
                    $fund->fund_code,
                    'scrip_name',
                    (string) ($filters['fund_scrips'] ?? ''),
                    $startDate,
                    $endDate,
                    $mode
                ),
                'industry' => $this->resolveFundCompositionValue(
                    $fund->fund_code,
                    'industry',
                    (string) ($filters['industry'] ?? ''),
                    $startDate,
                    $endDate,
                    $mode
                ),
                'aum' => $this->resolveFundAumValue($fund->fund_code, $startDate, $endDate, $mode),
                'fund_manager' => trim((string) ($fund->fund_manager ?? '')),
                default => null,
            };

            if ($value === null || $value === '' || (!is_string($value) && (float) $value <= 0)) {
                continue;
            }

            $result[$fund->fund_id] = is_numeric($value) ? round((float) $value, 2) : $value;
        }

        return $result;
    }

    protected function resolveFundCompositionValue(
        string $fundCode,
        string $column,
        string $matchValue,
        CarbonInterface $startDate,
        CarbonInterface $endDate,
        string $mode
    ): ?float {
        if ($matchValue === '') {
            return null;
        }

        $rows = $this->fetchLatestFundCompositionRows($fundCode, $startDate, $endDate, $mode);
        if ($rows->isEmpty()) {
            return null;
        }

        $value = $rows
            ->filter(fn ($row) => strcasecmp(trim((string) data_get($row, $column)), trim($matchValue)) === 0)
            ->sum(fn ($row) => (float) ($row->content_per ?? 0));

        return $value > 0 ? $value : null;
    }

    protected function resolveFundAumValue(
        string $fundCode,
        CarbonInterface $startDate,
        CarbonInterface $endDate,
        string $mode
    ): ?float {
        try {
            $query = CorpusEntry::query()
                ->where('fund_code', $fundCode)
                ->where('publish', 'y');

            if ($mode === 'as_on') {
                $query->whereDate('entry_date', '<=', $endDate->toDateString());
            } else {
                $query->whereDate('entry_date', '>=', $startDate->toDateString())
                    ->whereDate('entry_date', '<=', $endDate->toDateString());
            }

            $row = $query
                ->orderByDesc('entry_date')
                ->first(['corpus_entry']);

            return $row && is_numeric($row->corpus_entry) ? (float) $row->corpus_entry : null;
        } catch (Throwable $e) {
            return null;
        }
    }

    protected function columnExists(string $table, string $column): bool
    {
        try {
            return DB::getSchemaBuilder()->hasColumn($table, $column);
        } catch (Throwable $e) {
            return false;
        }
    }

    protected function buildIndicesMoverRows(Collection $oldRows, Collection $newRows, string $groupKey, string $displayName): Collection
    {
        $oldMap = $oldRows
            ->filter(fn ($row) => filled(data_get($row, $groupKey)))
            ->keyBy(fn ($row) => strtolower(trim((string) data_get($row, $groupKey))));

        $newMap = $newRows
            ->filter(fn ($row) => filled(data_get($row, $groupKey)))
            ->keyBy(fn ($row) => strtolower(trim((string) data_get($row, $groupKey))));

        $allKeys = $oldMap->keys()->merge($newMap->keys())->unique()->values();

        return $allKeys->map(function ($key) use ($oldMap, $newMap, $groupKey, $displayName) {
            $oldRow = $oldMap->get($key);
            $newRow = $newMap->get($key);
            $label = data_get($newRow, $groupKey) ?? data_get($oldRow, $groupKey);

            return (object) [
                $groupKey => $label,
                'correlation_new' => $displayName,
                'percentage_old' => (float) (data_get($oldRow, 'percentage') ?? 0),
                'percentage_new' => (float) (data_get($newRow, 'percentage') ?? 0),
            ];
        })->filter(fn ($row) => filled(data_get($row, $groupKey)));
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

    protected function buildSortinoMap(
        Collection $funds,
        CarbonInterface $startDate,
        CarbonInterface $endDate,
        float $minimumAcceptableRate
    ): array {
        $sortinoMap = [];
        $fundAllReturn = [];

        foreach ($funds as $fund) {
            if (empty($fund->fund_id) || empty($fund->fund_code)) {
                continue;
            }

            $metrics = $this->calculateSortinoMetricsForFund($fund, $startDate, $endDate, $minimumAcceptableRate);

            $sortinoMap[$fund->fund_id] = $metrics['sortino'];
            $fundAllReturn[$fund->fund_id] = $metrics;
        }

        return [$sortinoMap, $fundAllReturn];
    }

    protected function calculateSortinoMetricsForFund(
        FundMaster $fund,
        CarbonInterface $startDate,
        CarbonInterface $endDate,
        float $minimumAcceptableRate
    ): array {
        $default = [
            'upside_potential' => 'N/A',
            'downside_risk' => 'N/A',
            'sortino' => 'N/A',
        ];

        if (empty($fund->fund_code)) {
            return $default;
        }

        try {
            $searchIndicesName = filled($fund->indices_name)
                ? (string) $fund->indices_name
                : 'benchmark';

            $request = new Request([
                'search' => 'Search',
                'search_fund_name' => $fund->fund_code,
                'search_indices_name' => $searchIndicesName,
                'search_mar' => $minimumAcceptableRate,
                'search_from_date' => $startDate->toDateString(),
                'search_to_date' => $endDate->toDateString(),
            ]);

            /** @var ViewContract $view */
            $view = app(SortinoController::class)->sortino_calculator($request);
            $payload = method_exists($view, 'getData') ? $view->getData() : [];

            return [
                'upside_potential' => $this->normalizeMetricValue($payload['fund_return_daily_risk_free_average'] ?? null),
                'downside_risk' => $this->normalizeMetricValue($payload['downside_risk'] ?? null),
                'sortino' => $this->normalizeMetricValue($payload['sortino'] ?? null),
            ];
        } catch (Throwable $e) {
            Log::warning('Sortino calculation failed for fund', [
                'fund_id' => $fund->fund_id ?? null,
                'fund_code' => $fund->fund_code ?? null,
                'indices_name' => $fund->indices_name ?? null,
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'mar' => $minimumAcceptableRate,
                'error' => $e->getMessage(),
            ]);

            return $default;
        }
    }

    protected function normalizeMetricValue($value)
    {
        if (is_numeric($value)) {
            return round((float) $value, 4);
        }

        return $value === null || $value === '' ? 'N/A' : $value;
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
