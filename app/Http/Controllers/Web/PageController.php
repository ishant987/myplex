<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use Validator;

use App\Lib\Core\Core;
use App\Lib\Core\MailPS;
use App\Models\AskExpertQuestion;
use App\Models\PageModel;
use App\Models\BannerModel;
use App\Models\TestimonialModel;
use App\Models\FAQModel;
use App\Models\FundClassification;
use App\Models\FundMan;
use App\Models\FundSuggestion;
use App\Models\FundTaxation;
use App\Models\FundWatch;
use App\Models\KnowTheRatio;
use App\Models\News;
use App\Models\Newsletter;
use App\Models\NfoOffer;
use App\Models\NewFromMyplexus;
use App\Models\FundType;
use App\Models\MonthlyRatioCalculation;
use App\Models\CorpusEntry;

use App\Models\FundMaster;
use App\Models\FundDetail;
use App\Models\IndicesDetail;
use App\Models\IndicesMaster;
use DateTime;

// use App\Plans;
use App\Models\SettingsModel;
use App\Models\Teams;
use App\Models\BlogModel;
use Session;
use Socialite;
use App\Models\FundWatchNew;
use App\Models\CalculatorRegister;

use Carbon\Carbon;

class PageController extends BaseController
{
    public $className;
    public $class_id;

    public function __construct()
    {
        $classNameArr = explode('\\', __CLASS__);
        $this->className = end($classNameArr);
        $this->class_id = self::getClassIdByname($this->className);
        $this->page_path = env('PAGE_PATHS', 'web.pages');
        $this->defDataArr = self::getDefData();
        $this->BlogImagePath = url('/') . '/' . Config('commonconstants.blog_dir_name_front_end');
    }

    private function usingSqlite(): bool
    {
        return DB::getDriverName() === 'sqlite';
    }

    private function latestPublishedFundChange(string $fundCode): float
    {
        $latest = FundDetail::where('fund_code', $fundCode)
            ->where('publish', 'y')
            ->orderBy('entry_date', 'desc')
            ->first();

        if (!$latest) {
            return 0.0;
        }

        $previous = FundDetail::where('fund_code', $fundCode)
            ->where('publish', 'y')
            ->where('entry_date', '<', $latest->entry_date)
            ->orderBy('entry_date', 'desc')
            ->first();

        if (!$previous || (float) $previous->closing_nav == 0.0) {
            return 0.0;
        }

        return round((((float) $latest->closing_nav - (float) $previous->closing_nav) / (float) $previous->closing_nav) * 100, 2);
    }

    private function buildFundChangesByType(int $typeId): array
    {
        $rows = [];

        foreach (FundMaster::where('fund_type_id', $typeId)->where('status', 1)->orderBy('fund_name')->get() as $fund) {
            $rows[] = (object) [
                'fund_name' => $fund->fund_name,
                'change_value' => $this->latestPublishedFundChange($fund->fund_code),
            ];
        }

        usort($rows, fn ($left, $right) => $right->change_value <=> $left->change_value);

        return $rows;
    }

    private function buildFundTypeBenchmarks(): array
    {
        $rows = [];

        foreach (FundType::select('ft_id', 'name')->orderBy('ft_id')->get() as $fundType) {
            $fundCodes = FundMaster::where('fund_type_id', $fundType->ft_id)
                ->where('status', 1)
                ->pluck('fund_code')
                ->all();

            $changes = [];
            foreach ($fundCodes as $fundCode) {
                $changes[] = $this->latestPublishedFundChange($fundCode);
            }

            if (!$changes) {
                $changes = [0.0];
            }

            sort($changes);
            $count = count($changes);
            $avg = round(array_sum($changes) / $count, 2);
            $median = $count % 2 === 1
                ? (float) $changes[(int) floor(($count - 1) / 2)]
                : round(((float) $changes[$count / 2 - 1] + (float) $changes[$count / 2]) / 2, 2);

            $rows[] = (object) [
                'FundTypeID' => $fundType->ft_id,
                'FUNDTYPE' => $fundType->name,
                'CHANGEVALUE' => $avg,
                'MEDIANVAL' => $median,
                'CHANGEVALUE_NEW' => $avg,
                'MEDIANVAL_NEW' => $median,
            ];
        }

        return $rows;
    }

    private function buildBestFundsRows(): array
    {
        $typeNames = FundType::pluck('name', 'ft_id')->all();
        $rows = [];

        foreach (FundMaster::where('status', 1)->orderBy('fund_name')->get() as $fund) {
            $change = $this->latestPublishedFundChange($fund->fund_code);
            $rows[] = (object) [
                'fund_name' => $fund->fund_name,
                'name' => $typeNames[$fund->fund_type_id] ?? '',
                'weekly_change' => $change,
                'monthly_change' => $change,
            ];
        }

        usort($rows, fn ($left, $right) => $right->weekly_change <=> $left->weekly_change);

        return array_slice($rows, 0, 10);
    }

    private function buildIndexRows(string $date): array
    {
        $asOf = Carbon::parse($date)->toDateString();
        $typeMap = [
            'NIFTY 100' => 'NSE',
            'CRISIL Short Term Bond' => 'BSE',
            'NIFTY 500' => 'GLOBAL',
        ];
        $rows = [];

        foreach (IndicesMaster::select('name', 'corelation')->where('status', 1)->orderBy('name')->get() as $index) {
            $current = IndicesDetail::where('name', $index->corelation)
                ->where('entry_date', '<=', $asOf)
                ->orderBy('entry_date', 'desc')
                ->first();

            if (!$current) {
                continue;
            }

            $previous = IndicesDetail::where('name', $index->corelation)
                ->where('entry_date', '<', $current->entry_date)
                ->orderBy('entry_date', 'desc')
                ->first();

            $change = 0.0;
            if ($previous && (float) $previous->closing_value != 0.0) {
                $change = round((((float) $current->closing_value - (float) $previous->closing_value) / (float) $previous->closing_value) * 100, 2);
            }

            $rows[] = (object) [
                'name' => $index->name,
                'cur_value' => (float) $current->closing_value,
                'PER_CHANGE' => $change,
                'index_type' => $typeMap[$index->name] ?? 'GLOBAL',
            ];
        }

        return $rows;
    }

    private function buildStaticCurrencyRows(): array
    {
        return [
            (object) ['name' => 'USD/INR', 'cur_value' => 83.14, 'PER_CHANGE' => 0.12],
            (object) ['name' => 'EUR/INR', 'cur_value' => 90.02, 'PER_CHANGE' => 0.08],
            (object) ['name' => 'GBP/INR', 'cur_value' => 105.34, 'PER_CHANGE' => -0.04],
        ];
    }

    private function buildStaticCommodityRows(): array
    {
        return [
            (object) ['name' => 'Gold', 'cur_value' => 72345.12, 'PER_CHANGE' => 0.23],
            (object) ['name' => 'Silver', 'cur_value' => 85230.55, 'PER_CHANGE' => -0.15],
        ];
    }

    private function normalizeMarketTimeFrame(string $timeFrame): string
    {
        $timeFrame = strtolower(trim($timeFrame));

        return match ($timeFrame) {
            '1d', '1_day', '1day' => '1D',
            '1w', '1_week', '1week' => '1W',
            '1m', '1_month', '1month' => '1M',
            '3m', '3_months', '3months' => '3M',
            '1y', '1_year', '1year' => '1Y',
            '5y', '5_year', '5years' => '5Y',
            'all', 'max', 'full' => 'ALL',
            'ytd' => 'YTD',
            default => '1M',
        };
    }

    private function resolveMarketOverviewWindow(Request $request): array
    {
        $endDate = $request->filled('as_on_date')
            ? Carbon::parse($request->input('as_on_date'))->toDateString()
            : (FundDetail::where('publish', 'y')->max('entry_date') ?: Carbon::now()->toDateString());

        if ($request->filled('start_date') && $request->filled('end_date')) {
            return [
                Carbon::parse($request->input('start_date'))->toDateString(),
                Carbon::parse($request->input('end_date'))->toDateString(),
                'range',
            ];
        }

        $timeFrame = $this->normalizeMarketTimeFrame(
            (string) $request->input('time_frame', $request->input('as_on_time_frame', '1M'))
        );

        if ($timeFrame === 'ALL') {
            $startDate = FundDetail::where('publish', 'y')->min('entry_date') ?: $endDate;

            return [$startDate, $endDate, $timeFrame];
        }

        $startDate = Carbon::parse($endDate);
        match ($timeFrame) {
            '1D' => $startDate->subDay(),
            '1W' => $startDate->subWeek(),
            '1M' => $startDate->subMonthNoOverflow(),
            '3M' => $startDate->subMonthsNoOverflow(3),
            '1Y' => $startDate->subYearNoOverflow(),
            '5Y' => $startDate->subYearsNoOverflow(5),
            'YTD' => $startDate->startOfYear(),
            default => $startDate->subMonthNoOverflow(),
        };

        return [$startDate->toDateString(), $endDate, $timeFrame];
    }

    private function buildMarketHistorySeries(string $fundCode, string $startDate, string $endDate): array
    {
        $history = FundDetail::where('fund_code', $fundCode)
            ->where('publish', 'y')
            ->where('entry_date', '<=', $endDate)
            ->orderBy('entry_date', 'asc')
            ->get();

        $windowHistory = $history->filter(function ($row) use ($startDate, $endDate) {
            return $row->entry_date >= $startDate && $row->entry_date <= $endDate;
        })->values();

        if ($windowHistory->count() >= 2) {
            $history = $windowHistory;
        }

        $series = [];
        $previousNav = null;

        foreach ($history as $row) {
            $nav = (float) ($row->closing_nav ?? 0);
            $changeAmount = 0.0;
            $changePercent = 0.0;

            if ($previousNav !== null && $previousNav != 0.0) {
                $changeAmount = round($nav - $previousNav, 2);
                $changePercent = round((($nav - $previousNav) / $previousNav) * 100, 2);
            }

            $series[] = [
                'entry_date' => $row->entry_date,
                'nav' => round($nav, 2),
                'change_amount' => $changeAmount,
                'change_percent' => $changePercent,
            ];

            $previousNav = $nav;
        }

        return $series;
    }

    private function buildMarketOverviewItems($fundMasters, string $startDate, string $endDate): array
    {
        $fundCodes = $fundMasters->pluck('fund_code')->all();

        $detailGroups = FundDetail::whereIn('fund_code', $fundCodes)
            ->where('publish', 'y')
            ->where('entry_date', '<=', $endDate)
            ->orderBy('entry_date')
            ->get()
            ->groupBy('fund_code');

        $corpusGroups = CorpusEntry::whereIn('fund_code', $fundCodes)
            ->where('publish', 'y')
            ->where('entry_date', '<=', $endDate)
            ->orderBy('entry_date')
            ->get()
            ->groupBy('fund_code');

        $items = [];

        foreach ($fundMasters as $fund) {
            $history = $detailGroups->get($fund->fund_code, collect())->values();
            $windowHistory = $history->filter(function ($row) use ($startDate, $endDate) {
                return $row->entry_date >= $startDate && $row->entry_date <= $endDate;
            })->values();

            if ($windowHistory->count() >= 2) {
                $history = $windowHistory;
            }

            $historyCount = $history->count();
            $latestDetail = $historyCount > 0 ? $history[$historyCount - 1] : null;
            $previousDetail = $historyCount > 1 ? $history[$historyCount - 2] : null;

            $currentNav = $latestDetail ? (float) $latestDetail->closing_nav : 0.0;
            $previousNav = $previousDetail ? (float) $previousDetail->closing_nav : 0.0;

            $changeAmount = 0.0;
            $changePercent = 0.0;

            if ($previousDetail && $previousNav != 0.0) {
                $changeAmount = round($currentNav - $previousNav, 2);
                $changePercent = round((($currentNav - $previousNav) / $previousNav) * 100, 2);
            }

            $corpusHistory = $corpusGroups->get($fund->fund_code, collect())->values();
            $latestCorpus = $corpusHistory->count() > 0 ? $corpusHistory[$corpusHistory->count() - 1] : null;
            $corpusValue = $latestCorpus ? (float) $latestCorpus->corpus_entry : 0.0;

            $fundTypeName = $fund->relationLoaded('fundtype') && $fund->fundtype ? $fund->fundtype->name : '';
            if ($fundTypeName === '' && isset($fund->fund_type_id)) {
                $fundTypeName = optional(FundType::find($fund->fund_type_id))->name ?? '';
            }

            $classification = trim((string) ($fund->classification ?: $fundTypeName));
            if ($classification === '') {
                $classification = 'Unclassified';
            }

            $benchmark = trim((string) ($fund->indices_name ?: ''));
            $sizeMetric = $corpusValue > 0 ? $corpusValue : $currentNav;
            $historySeries = [];
            $previousSeriesNav = null;

            foreach ($history as $historyRow) {
                $seriesNav = (float) ($historyRow->closing_nav ?? 0);
                $seriesChangeAmount = 0.0;
                $seriesChangePercent = 0.0;

                if ($previousSeriesNav !== null && $previousSeriesNav != 0.0) {
                    $seriesChangeAmount = round($seriesNav - $previousSeriesNav, 2);
                    $seriesChangePercent = round((($seriesNav - $previousSeriesNav) / $previousSeriesNav) * 100, 2);
                }

                $historySeries[] = [
                    'entry_date' => $historyRow->entry_date,
                    'nav' => round($seriesNav, 2),
                    'change_amount' => $seriesChangeAmount,
                    'change_percent' => $seriesChangePercent,
                ];

                $previousSeriesNav = $seriesNav;
            }

            $items[] = [
                'fund_id' => $fund->fund_id,
                'fund_code' => $fund->fund_code,
                'fund_name' => $fund->fund_name,
                'fund_type_id' => $fund->fund_type_id,
                'fund_type_name' => $fundTypeName !== '' ? $fundTypeName : 'Unclassified',
                'classification' => $classification,
                'benchmark' => $benchmark !== '' ? $benchmark : 'N/A',
                'fund_manager' => $fund->fund_manager ?: 'N/A',
                'fund_house' => $fund->fund_house ?: 'N/A',
                'nav' => round($currentNav, 2),
                'change_amount' => $changeAmount,
                'change_percent' => $changePercent,
                'corpus' => round($corpusValue, 2),
                'size_metric' => round($sizeMetric, 2),
                'last_updated_at' => $latestDetail ? $latestDetail->entry_date : $endDate,
                'tile_height' => 170,
                'accent_color' => '#94a3b8',
                'heat_class' => 'flat',
                'history' => $historySeries,
            ];
        }

        if (!empty($items)) {
            $maxSizeMetric = collect($items)->max('size_metric') ?: 1;

            foreach ($items as $index => $item) {
                $normalized = $maxSizeMetric > 0 ? min($item['size_metric'] / $maxSizeMetric, 1) : 0;
                $tileHeight = 160 + (int) round(70 * max($normalized, 0.15));
                $absChange = abs($item['change_percent']);
                $opacity = min(0.14 + ($absChange / 10) * 0.26, 0.4);

                if ($item['change_percent'] > 0) {
                    $accent = 'rgba(34, 197, 94, ' . $opacity . ')';
                    $heatClass = 'positive';
                } elseif ($item['change_percent'] < 0) {
                    $accent = 'rgba(239, 68, 68, ' . $opacity . ')';
                    $heatClass = 'negative';
                } else {
                    $accent = 'rgba(100, 116, 139, 0.12)';
                    $heatClass = 'flat';
                }

                $items[$index]['tile_height'] = $tileHeight;
                $items[$index]['accent_color'] = $accent;
                $items[$index]['heat_class'] = $heatClass;
            }
        }

        return $items;
    }

    public function marketOverviewData(Request $request)
    {
        $dataArr = [
            'title' => 'Market Overview',
            'meta_title' => 'Market Overview',
            'meta_descp' => 'Database-driven fund heatmap using the local MyPlex fund tables.',
            'full_url' => $request->fullUrl(),
        ];

        $defDataArr = $this->defDataArr;

        $fundTypes = FundType::orderBy('name', 'asc')->get();
        $selectedFundTypeId = $request->input('fund_type_id');
        $selectedClassification = trim((string) $request->input('classification', ''));
        $selectedBenchmark = trim((string) $request->input('benchmark', ''));
        $selectedManager = trim((string) $request->input('fund_manager', ''));
        $searchQuery = trim((string) $request->input('q', ''));
        $sort = trim((string) $request->input('sort', 'change_desc'));

        $query = FundMaster::with('fundtype')->where('status', 1);

        if ($selectedFundTypeId) {
            $query->where('fund_type_id', $selectedFundTypeId);
        }

        if ($selectedClassification !== '') {
            $query->where('classification', 'like', '%' . $selectedClassification . '%');
        }

        if ($selectedBenchmark !== '') {
            $query->where('indices_name', 'like', '%' . $selectedBenchmark . '%');
        }

        if ($selectedManager !== '') {
            $query->where('fund_manager', 'like', '%' . $selectedManager . '%');
        }

        if ($searchQuery !== '') {
            $query->where(function ($subQuery) use ($searchQuery) {
                $subQuery->where('fund_name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('fund_code', 'like', '%' . $searchQuery . '%')
                    ->orWhere('classification', 'like', '%' . $searchQuery . '%')
                    ->orWhere('indices_name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('fund_manager', 'like', '%' . $searchQuery . '%');
            });
        }

        [$startDate, $endDate, $timeFrame] = $this->resolveMarketOverviewWindow($request);
        $allFundMasters = FundMaster::with('fundtype')->where('status', 1)->orderBy('fund_name', 'asc')->get();
        $allItemsCollection = collect($this->buildMarketOverviewItems($allFundMasters, $startDate, $endDate));
        $fundMasters = $query->orderBy('fund_name', 'asc')->get();
        $items = $this->buildMarketOverviewItems($fundMasters, $startDate, $endDate);

        $itemsCollection = collect($items);
        $summary = [
            'total_funds' => $itemsCollection->count(),
            'positive_count' => $itemsCollection->filter(fn ($item) => $item['change_percent'] > 0)->count(),
            'negative_count' => $itemsCollection->filter(fn ($item) => $item['change_percent'] < 0)->count(),
            'flat_count' => $itemsCollection->filter(fn ($item) => $item['change_percent'] == 0)->count(),
            'average_change_percent' => $itemsCollection->count() > 0 ? round($itemsCollection->avg('change_percent'), 2) : 0.0,
            'last_updated_at' => $endDate,
        ];

        $topGainers = $itemsCollection->sortByDesc('change_percent')->take(5)->values()->all();
        $topLosers = $itemsCollection->sortBy('change_percent')->take(5)->values()->all();

        $classificationCatalog = $allItemsCollection->groupBy('classification')->map(function ($group, $name) {
            return [
                'name' => $name,
                'count' => $group->count(),
                'average_change_percent' => round($group->avg('change_percent'), 2),
                'top_fund' => $group->sortByDesc('change_percent')->first(),
            ];
        })->sortByDesc('count')->values()->all();

        $fundTypeGroups = $itemsCollection->groupBy('fund_type_name')->map(function ($group, $name) {
            return [
                'name' => $name,
                'count' => $group->count(),
                'average_change_percent' => round($group->avg('change_percent'), 2),
                'total_corpus' => round($group->sum('corpus'), 2),
                'top_fund' => $group->sortByDesc('change_percent')->first(),
            ];
        })->sortByDesc('count')->values()->all();

        $classificationGroups = $itemsCollection->groupBy('classification')->map(function ($group, $name) {
            return [
                'name' => $name,
                'count' => $group->count(),
                'average_change_percent' => round($group->avg('change_percent'), 2),
                'total_corpus' => round($group->sum('corpus'), 2),
                'top_fund' => $group->sortByDesc('change_percent')->first(),
            ];
        })->sortByDesc('count')->values()->all();

        switch ($sort) {
            case 'name_asc':
                $items = $itemsCollection->sortBy('fund_name')->values()->all();
                break;
            case 'name_desc':
                $items = $itemsCollection->sortByDesc('fund_name')->values()->all();
                break;
            case 'corpus_desc':
                $items = $itemsCollection->sortByDesc('corpus')->values()->all();
                break;
            case 'corpus_asc':
                $items = $itemsCollection->sortBy('corpus')->values()->all();
                break;
            case 'negative_first':
                $items = $itemsCollection->sortBy('change_percent')->values()->all();
                break;
            case 'positive_first':
            case 'change_desc':
            default:
                $items = $itemsCollection->sortByDesc('change_percent')->values()->all();
                break;
        }

        $classificationOptions = FundMaster::where('status', 1)
            ->whereNotNull('classification')
            ->where('classification', '!=', '')
            ->distinct()
            ->orderBy('classification', 'asc')
            ->pluck('classification')
            ->filter()
            ->values()
            ->all();

        $benchmarkOptions = FundMaster::where('status', 1)
            ->whereNotNull('indices_name')
            ->where('indices_name', '!=', '')
            ->distinct()
            ->orderBy('indices_name', 'asc')
            ->pluck('indices_name')
            ->filter()
            ->values()
            ->all();

        $managerOptions = FundMaster::where('status', 1)
            ->whereNotNull('fund_manager')
            ->where('fund_manager', '!=', '')
            ->distinct()
            ->orderBy('fund_manager', 'asc')
            ->pluck('fund_manager')
            ->filter()
            ->values()
            ->all();

        $dataArr['request'] = $request;
        $dataArr['fund_types'] = $fundTypes;
        $dataArr['summary'] = $summary;
        $dataArr['top_gainers'] = $topGainers;
        $dataArr['top_losers'] = $topLosers;
        $dataArr['classification_groups'] = $classificationGroups;
        $dataArr['items'] = $items;
        $dataArr['classification_options'] = $classificationOptions;
        $dataArr['benchmark_options'] = $benchmarkOptions;
        $dataArr['manager_options'] = $managerOptions;
        $dataArr['time_frame'] = $timeFrame;
        $dataArr['start_date'] = $startDate;
        $dataArr['end_date'] = $endDate;
        $dataArr['sort'] = $sort;
        $dataArr['disclaimer'] = DB::table('fund_watch_disclaimer')->where('status', 1)->value('disclaimer')
            ?: 'Market overview values are derived from the local fund tables.';

        return view($this->page_path . '.market-overview', compact('defDataArr', 'dataArr'));
    }

    public function marketHeatmapData(Request $request)
    {
        $dataArr = [
            'title' => 'Market Heatmap',
            'meta_title' => 'Market Heatmap',
            'meta_descp' => 'Dark market wall with chart and live heatmap tiles from the local MyPlex fund tables.',
            'full_url' => $request->fullUrl(),
        ];

        $defDataArr = $this->defDataArr;

        $fundTypes = FundType::orderBy('name', 'asc')->get();
        $selectedFundTypeId = $request->input('fund_type_id');
        $selectedClassification = trim((string) $request->input('classification', ''));
        $selectedBenchmark = trim((string) $request->input('benchmark', ''));
        $selectedManager = trim((string) $request->input('fund_manager', ''));
        $searchQuery = trim((string) $request->input('q', ''));
        $sort = trim((string) $request->input('sort', 'change_desc'));
        $selectedFundCode = trim((string) $request->input('fund_code', ''));

        $query = FundMaster::with('fundtype')->where('status', 1);

        if ($selectedFundTypeId) {
            $query->where('fund_type_id', $selectedFundTypeId);
        }

        if ($selectedClassification !== '') {
            $query->where('classification', 'like', '%' . $selectedClassification . '%');
        }

        if ($selectedBenchmark !== '') {
            $query->where('indices_name', 'like', '%' . $selectedBenchmark . '%');
        }

        if ($selectedManager !== '') {
            $query->where('fund_manager', 'like', '%' . $selectedManager . '%');
        }

        if ($searchQuery !== '') {
            $query->where(function ($subQuery) use ($searchQuery) {
                $subQuery->where('fund_name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('fund_code', 'like', '%' . $searchQuery . '%')
                    ->orWhere('classification', 'like', '%' . $searchQuery . '%')
                    ->orWhere('indices_name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('fund_manager', 'like', '%' . $searchQuery . '%');
            });
        }

        [$startDate, $endDate, $timeFrame] = $this->resolveMarketOverviewWindow($request);
        $allFundMasters = FundMaster::with('fundtype')->where('status', 1)->orderBy('fund_name', 'asc')->get();
        $fundMasters = $query->orderBy('fund_name', 'asc')->get();
        $items = $this->buildMarketOverviewItems($fundMasters, $startDate, $endDate);

        $itemsCollection = collect($items);
        $summary = [
            'total_funds' => $itemsCollection->count(),
            'positive_count' => $itemsCollection->filter(fn ($item) => $item['change_percent'] > 0)->count(),
            'negative_count' => $itemsCollection->filter(fn ($item) => $item['change_percent'] < 0)->count(),
            'flat_count' => $itemsCollection->filter(fn ($item) => $item['change_percent'] == 0)->count(),
            'average_change_percent' => $itemsCollection->count() > 0 ? round($itemsCollection->avg('change_percent'), 2) : 0.0,
            'last_updated_at' => $endDate,
        ];

        $topGainers = $itemsCollection->sortByDesc('change_percent')->take(5)->values()->all();
        $topLosers = $itemsCollection->sortBy('change_percent')->take(5)->values()->all();

        $classificationCatalog = collect($this->buildMarketOverviewItems($allFundMasters, $startDate, $endDate))
            ->groupBy('classification')
            ->map(function ($group, $name) {
                return [
                    'name' => $name,
                    'count' => $group->count(),
                    'average_change_percent' => round($group->avg('change_percent'), 2),
                    'top_fund' => $group->sortByDesc('change_percent')->first(),
                ];
            })->sortByDesc('count')->values()->all();

        $fundTypeGroups = $itemsCollection->groupBy('fund_type_name')->map(function ($group, $name) {
            return [
                'name' => $name,
                'count' => $group->count(),
                'average_change_percent' => round($group->avg('change_percent'), 2),
                'total_corpus' => round($group->sum('corpus'), 2),
                'top_fund' => $group->sortByDesc('change_percent')->first(),
            ];
        })->sortByDesc('count')->values()->all();

        $classificationGroups = $itemsCollection->groupBy('fund_type_name')->map(function ($group, $name) {
            return [
                'name' => $name,
                'count' => $group->count(),
                'average_change_percent' => round($group->avg('change_percent'), 2),
                'total_corpus' => round($group->sum('corpus'), 2),
                'top_fund' => $group->sortByDesc('change_percent')->first(),
            ];
        })->sortByDesc('count')->values()->all();

        switch ($sort) {
            case 'name_asc':
                $items = $itemsCollection->sortBy('fund_name')->values()->all();
                break;
            case 'name_desc':
                $items = $itemsCollection->sortByDesc('fund_name')->values()->all();
                break;
            case 'corpus_desc':
                $items = $itemsCollection->sortByDesc('corpus')->values()->all();
                break;
            case 'corpus_asc':
                $items = $itemsCollection->sortBy('corpus')->values()->all();
                break;
            case 'negative_first':
                $items = $itemsCollection->sortBy('change_percent')->values()->all();
                break;
            case 'positive_first':
            case 'change_desc':
            default:
                $items = $itemsCollection->sortByDesc('change_percent')->values()->all();
                break;
        }

        $maxSizeMetric = max((float) collect($items)->max('size_metric'), 1.0);
        $items = collect($items)->values()->map(function ($item) use ($maxSizeMetric) {
            $normalized = max(0.2, min((float) ($item['size_metric'] ?? 0) / $maxSizeMetric, 1.0));
            $span = (int) max(1, min(5, round($normalized * 5)));
            $rowSpan = (int) max(1, min(3, ceil($span / 2)));
            $absChange = abs((float) ($item['change_percent'] ?? 0));
            $opacity = min(0.14 + ($absChange / 10) * 0.26, 0.4);

            if (($item['change_percent'] ?? 0) > 0) {
                $accent = 'rgba(34, 197, 94, ' . $opacity . ')';
                $heatClass = 'positive';
            } elseif (($item['change_percent'] ?? 0) < 0) {
                $accent = 'rgba(239, 68, 68, ' . $opacity . ')';
                $heatClass = 'negative';
            } else {
                $accent = 'rgba(100, 116, 139, 0.12)';
                $heatClass = 'flat';
            }

            $item['tile_span'] = $span;
            $item['tile_row_span'] = $rowSpan;
            $item['tile_size_label'] = $span >= 5 ? 'XL' : ($span === 4 ? 'L' : ($span === 3 ? 'M' : 'S'));
            $item['accent_color'] = $accent;
            $item['heat_class'] = $heatClass;

            return $item;
        })->all();

        $itemsCollection = collect($items);

        $featuredFunds = $itemsCollection->sortByDesc('size_metric')->take(6)->values()->map(function ($item) use ($startDate, $endDate) {
            if (empty($item['history'])) {
                $item['history'] = $this->buildMarketHistorySeries($item['fund_code'], $startDate, $endDate);
            }

            return $item;
        })->all();

        $selectedFund = null;
        foreach ($featuredFunds as $featuredFund) {
            if ($selectedFundCode !== '' && $featuredFund['fund_code'] === $selectedFundCode) {
                $selectedFund = $featuredFund;
                break;
            }
        }

        if ($selectedFund === null) {
            $selectedFund = $featuredFunds[0] ?? ($items[0] ?? null);
        }

        if ($selectedFund && empty($selectedFund['history'])) {
            $selectedFund['history'] = $this->buildMarketHistorySeries($selectedFund['fund_code'], $startDate, $endDate);
        }

        $heatmapGroups = collect($items)->groupBy('classification')->map(function ($group, $name) {
            return [
                'name' => $name,
                'count' => $group->count(),
                'average_change_percent' => round($group->avg('change_percent'), 2),
                'items' => $group->sortByDesc('size_metric')->values()->all(),
            ];
        })->sortByDesc('count')->values()->all();

        $timeFrames = [
            ['value' => '1D', 'label' => '1D'],
            ['value' => '1M', 'label' => '1M'],
            ['value' => '3M', 'label' => '3M'],
            ['value' => '1Y', 'label' => '1Y'],
            ['value' => '5Y', 'label' => '5Y'],
            ['value' => 'ALL', 'label' => 'All'],
        ];

        $dataArr['request'] = $request;
        $dataArr['fund_types'] = $fundTypes;
        $dataArr['summary'] = $summary;
        $dataArr['top_gainers'] = $topGainers;
        $dataArr['top_losers'] = $topLosers;
        $dataArr['classification_groups'] = $classificationGroups;
        $dataArr['fund_type_groups'] = $fundTypeGroups;
        $dataArr['items'] = $items;
        $dataArr['featured_funds'] = $featuredFunds;
        $dataArr['selected_fund'] = $selectedFund;
        $dataArr['heatmap_groups'] = $heatmapGroups;
        $dataArr['classification_catalog'] = $classificationCatalog;
        $dataArr['selected_classification'] = $selectedClassification;
        $dataArr['classification_options'] = FundMaster::where('status', 1)
            ->whereNotNull('classification')
            ->where('classification', '!=', '')
            ->distinct()
            ->orderBy('classification', 'asc')
            ->pluck('classification')
            ->filter()
            ->values()
            ->all();
        $dataArr['benchmark_options'] = FundMaster::where('status', 1)
            ->whereNotNull('indices_name')
            ->where('indices_name', '!=', '')
            ->distinct()
            ->orderBy('indices_name', 'asc')
            ->pluck('indices_name')
            ->filter()
            ->values()
            ->all();
        $dataArr['manager_options'] = FundMaster::where('status', 1)
            ->whereNotNull('fund_manager')
            ->where('fund_manager', '!=', '')
            ->distinct()
            ->orderBy('fund_manager', 'asc')
            ->pluck('fund_manager')
            ->filter()
            ->values()
            ->all();
        $dataArr['time_frame'] = $timeFrame;
        $dataArr['start_date'] = $startDate;
        $dataArr['end_date'] = $endDate;
        $dataArr['sort'] = $sort;
        $dataArr['time_frames'] = $timeFrames;
        $dataArr['disclaimer'] = DB::table('fund_watch_disclaimer')->where('status', 1)->value('disclaimer')
            ?: 'Market overview values are derived from the local fund tables.';

        return view($this->page_path . '.stock-heatmap', compact('defDataArr', 'dataArr'));
    }

    // public function getNewsApi()
    // {
    //     $incoming = @file_get_contents('https://www.moneycontrol.com/rss/latestnews.xml');
    //     $xmlRaw = preg_replace('#&(?=[a-z_0-9]+=)#', '&amp;', $incoming);
    //     $xmlString = mb_convert_encoding($xmlRaw, 'UTF-8', 'auto');
    //     $xml = simplexml_load_string($xmlString);
    //     $return_array = array();
    //     $html = [];
    // 	$p = [];
    // 	$htm = "";
    // 	$i=1;
    // 	$count = 0;
    //     foreach ($xml->channel as $value) {			
    //         foreach ($value->item as $row) {				
    // 			$i++;
    // 				//echo $i;
    // 	/*$html['data'][] = "<div class='single_slider_nav'><p><a href='" . $row->link . "' target='_blank'>" . $row->title ."</a></p><p>Testing Data One</p><p>Testing Data Two</p></div>";*/	

    // 	$p['data'][] = "<p><a href='" . $row->link . "' target='_blank'>" . $row->title ."</a></p>";
    //         }

    // 		//$html['data'][] = "<div class='single_slider_nav'></div>";
    //     }

    // 	$arrays = array_chunk($p['data'], 2);

    // 	//dd($arrays);

    // 	//dd( array_chunk($html['data'], 2) );
    //     //dd($i);
    //     //$return_array["html"] = $html;

    // 	foreach ($arrays as $array_num => $array) {
    // 		$htm = "<div class='single_slider_nav'>";
    // 	  //echo "Array $array_num:\n";
    // 		//dd($array);
    // 	  foreach ($array as $item_num => $item) {
    // 		  $htm .= $item;
    // 		//echo "  Item $item_num: $item\n";
    // 	  }
    // 		$htm .= "</div>";

    // 		$html['data'][] = $htm;
    // 		$htm = "";
    // 	}
    // 	//dd($html['data']);
    //     return json_encode($html);
    // }

    public function pageData(Request $request, $slug)
    {

        $dataArr = PageModel::getData($this->class_id, $slug);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;
            return view('themes.frontend.pages.page', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function homeData(Request $request, $slug = false)
    {
        $dataId = 0;
        $blogResponses = [];

        if ($slug == false || $slug == '') {
            $dataId = 1;
        }

        $apiURL = 'https://blog.myplexus.com/wp-json/wp/v2/posts';
        $blogResponses = $this->blogData($apiURL);

        $apiURL = 'https://www.myplexus.com/api/v1/funds';
        $fundReponses = $this->DropDownData($apiURL);

        $apiURL = 'https://www.myplexus.com/api/v1/fund-classifications';
        $performaceResponses = $this->DropDownData($apiURL);

        //dd($blogResponses);

        //dd($fundReponses['data']);

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $bnrMdl = $nwsApiArr = $fundManMdl = $tstmnlMdl = $calcPgsMdl = $pthPgsMdl = $faqMdl = $blogPosts = $nwsListMdl = [];

            $commonconstants = Config('commonconstants');
            $status = $commonconstants['status_val'][1];

            $bnrMdl = BannerModel::bannerList(['bnr_group' => 'home-banner', 'status' => $status], '', 'c_order', 'DESC');
            // $nwsApiData = self::getNewsApi();
            $nwsApiData = [];
            $fundManMdl = FundMan::list(['take' => 0, 'status' => $status], ['fm_id', 'name', 'slug', 'designation', 'company_name', 'synopsis', 'media_id'], 'fm_id', 'DESC');
            $tstmnlMdl = TestimonialModel::testimonialList(['status' => $status], ['tmnl_id', 'name', 'descp', 'company', 'designation', 'media_id'], 'tmnl_id', 'DESC');
            $pthPgsMdl = PageModel::pageList(['ids' => [21, 22, 23, 24, 25], 'status' => $status], ['title', 'slug', 'template_id'], 'c_order', 'ASC');
            $stngDataArr = SettingsModel::getSettingsArr(['paathshaala_heading', 'paathshaala_image', 'newsletter_heading', 'newsletter_description'], $commonconstants['status_val'][1]);
            // $faqs = FAQModel::faqList(['category_id' => $commonconstants['def_faq_cat_id'], 'status' => $status], ['title', 'descp', 'faq_id'], 'c_order', 'ASC');

            // $plansMdl = Plans::list(['status' => $status, 'show_on_wa' => $commonconstants['y_n_val'][1]], ['p_id', 'plan_name', 'amount', 'duration_name'], 'c_order', 'ASC');

            // $blogPosts = json_decode(file_get_contents(env('BLOG_URL') . '/wp-json/wp/v2/posts/?_embed&per_page=3'), true);
            $blogPosts = BlogModel::where('status', 1)
                ->orderBy('updated_at', 'desc')
                ->limit(3)
                ->get();
            $nwsListMdl = News::list(['status' => $commonconstants['status_val']['1']], ['title', 'slug', 'media_type', 'image', 'video_from', 'video_data', 'video_image', 'news_source_link'], '', '', 3);

            $aeQuesMdl = AskExpertQuestion::list(['status' => $status], '', 'created_at', 'DESC', 1);

            //$fndWtchMdl = FundWatch::frontList([], '', '', '', 2);
            $fndWtchMdl = FundWatchNew::where('status', '1')->orderBy('id', 'desc')->with('fundDetails')->get();


            // dd($fundManMdl);

            $nfoMdl = NfoOffer::frontList([], '', '', '', '', 5);

            $allnewfroms = NewFromMyplexus::all();

            // dd($allnewfroms);

            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['media_dir_name']), "setting_folder" => Core::getUploadedURL($commonconstants['setting_dir_name']), "news_folder" => Core::getUploadedURL($commonconstants['news_dir_name']), "user_media_folder" => $commonconstants['user_dir_name'], "payment_lang" => __('payment'), "yes_no_txt" => __('common.yes_no_txt'), "web_lang" => __('web')));
            // dd($defDataArr);
            $BlogImagePath = $this->BlogImagePath;
            return view('web.home.index', compact('defDataArr', 'dataArr', 'bnrMdl', 'nwsApiData', 'fundManMdl', 'tstmnlMdl', 'pthPgsMdl', 'stngDataArr', 'blogPosts', 'BlogImagePath', 'nwsListMdl', 'aeQuesMdl', 'fndWtchMdl', 'nfoMdl', 'blogResponses', 'fundReponses', 'performaceResponses', 'allnewfroms'));
        }
        return abort(404);
    }

    public function DropDownData($apiURL)
    {
        $data = [];
        $parameters = [];
        $response = Http::get($apiURL, $parameters);
        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);

        return $responseBody;
        //dd($responseBody);
    }

    public function blogData($apiURL)
    {
        $blogs = [];
        $parameters = ['per_page' => 3];
        $response = Http::get($apiURL, $parameters);
        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);

        //dd($responseBody);

        if (!empty($responseBody)) {
            foreach ($responseBody as $response) {

                $blogs[] = array(

                    'img' => $this->blogImage($response['featured_media']),
                    'title' => html_entity_decode($response['title']['rendered']),
                    'short_desc' => $response['content']['rendered'],
                    'link' => $response['link']

                );
            }
        }

        return $blogs;
    }

    public function blogData2($apiURL)
    {
        $blogs = [];
        $parameters = ['per_page' => 50];
        $response = Http::get($apiURL, $parameters);
        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);

        //dd($responseBody);

        if (!empty($responseBody)) {
            foreach ($responseBody as $response) {

                $blogs[] = array(

                    'img' => $this->blogImage($response['featured_media']),
                    'title' => html_entity_decode($response['title']['rendered']),
                    'short_desc' => $response['content']['rendered'],
                    'link' => $response['link']

                );
            }
        }

        return $blogs;
    }

    public function blogImage($id)
    {

        $apiURL = 'https://blog.myplexus.com/wp-json/wp/v2/media/' . $id;
        $parameters = "";
        $response = Http::get($apiURL, $parameters);
        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);
        $img_url = "";

        //dd($responseBody);

        if (array_key_exists('media_details', $responseBody)) {
            if (isset($responseBody['media_details']['sizes']['full']['source_url'])) {
                $img_url = $responseBody['media_details']['sizes']['full']['source_url'];
            } else {

                $img_url = $responseBody['media_details']['sizes']['medium']['source_url'];
            }
        }


        //dd($responseBody);

        return $img_url;
    }

    public function storeNewsletter(Request $request)
    {
        $commonconstants = Config('commonconstants');
        $frontconstants = Config('frontconstants');

        $message = __('message');
        $webLang = __('web');
        $resArr['msg'] = "";

        $vars = array(
            'secret' => $commonconstants['recaptcha']['secret_key'],
            "response" => $request->input('recaptcha_v3')
        );
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        $encoded_response = curl_exec($ch);
        $response = json_decode($encoded_response, true);
        curl_close($ch);

        if ($response['success'] && $response['action'] == 'newsletter_form' && $response['score'] > $commonconstants['recaptcha']['score']) {
            $vldtrRules = [
                'email'  => 'required|email|unique:newsletter'
            ];

            $vldtrMessages = [
                'email.unique' => $message['success']['newsletter_exist']
            ];

            $validator = Validator::make($request->all(), $vldtrRules, $vldtrMessages);

            if ($validator->fails()) {
                // $resArr['msg'] = $validator->getMessageBag();
                // return json_encode($resArr);
                $html = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                        <strong>' . $webLang['error_ttl'] . '&nbsp;</strong>';
                if ($validator->getMessageBag()->toArray()) {
                    $html .= '<ul>';
                    foreach ($validator->getMessageBag()->toArray() as $errors) {
                        foreach ($errors as $error) {
                            $html .= '<li>' . $error . '</li>';
                        }
                    }
                    $html .= '</ul>';
                }
                $html .= '</div>';
                $resArr['msg'] = $html;
                return json_encode($resArr);
            }

            try {
                $input = $request->except('_token', 'submit');
                $store = new Newsletter($input);
                if ($store->save()) {
                    $email = $input['email'];

                    $mailPSObj = new MailPS();
                    $mailCssAtr = $mailPSObj->getEmailHtmlCssAtr();

                    $commaSign = $commonconstants['comma_sign'];

                    $content = view('emails.web.to-user-newsletter', compact('mailCssAtr', 'commaSign'));

                    $subject = $webLang['newsletter']['mail_sbjct'];
                    $fromName = $webLang['newsletter']['mail_f_name'];

                    $mailResp = $mailPSObj->sendMail($email, $subject, $content, '', $fromName);
                    if ($mailResp) {
                        $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['1'] . '">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                            <strong>' . $webLang['success_ttl'] . '&nbsp;</strong> 
                            ' . $message['success']['newsletter_add'] . '
                        </div>';
                    } else {
                        $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                            <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                            ' . $message['error']['email_send'] . '
                        </div>';
                    }
                }
            } catch (QueryException $exception) {
                $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                    <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                    ' . $message['error']['data_saved'] . '
                </div>';
            }
        } else {
            //then probably this is a bot
            //you can do your logic here pass it or deny or do something special
            //score check value of 0.5 you can set which you want form 0 to 1
            //score 1 is probably human score 0 is probably bot
            $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                ' . $message['error']['recaptcha'] . '
            </div>';
        }
        return json_encode($resArr);
    }

    public function aboutData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 3;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $teamMdl = [];

            $commonconstants = Config('commonconstants');

            $status = $commonconstants['status_val']['1'];

            $teamMdl = Teams::list(['status' => $status], ['team_id', 'name', 'media_id', 'designation', 'linkedin_link'], 'c_order', 'ASC');

            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['media_dir_name'])));
            return view($this->page_path . '.about', compact('defDataArr', 'dataArr', 'teamMdl'));
        }
        return abort(404);
    }


    public function performanceSynopsisData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 54;
        }
        
        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;
            $getdata = $request->all();
            $type = !empty($getdata['type'])?$getdata['type']:'quartile-active';
            $ratio_type = !empty($getdata['ratio_type'])?$getdata['ratio_type']:'returns';
            $fund_type_status = '1';


            if(!empty($type)){
                if($type=='quartile-passive' || $type=='decile-passive'){
                    $fund_type_status = '0';
                }
                $monthly_performance_synopses = DB::table('monthly_performance_synopses')
                            ->select('monthly_performance_synopses.*', DB::raw('GROUP_CONCAT(fund_name) as fund_names'), DB::raw('GROUP_CONCAT(quartile1) as quartiles1'), DB::raw('GROUP_CONCAT(quartile2) as quartiles2'), DB::raw('GROUP_CONCAT(decile1) as deciles1'), DB::raw('GROUP_CONCAT(decile2) as deciles2'))
                            ->where('fund_type_status',$fund_type_status)
                            ->where('ratio_type',$ratio_type)
                            ->groupBy('monthly_performance_synopses.fund_house')
                            ->orderBy('monthly_performance_synopses.fund_house', 'asc')
                            ->get();
                $monthly_performance_synopses_last_date = DB::table('monthly_performance_synopses')->select('date')->first()->date;          
                //dd($monthly_performance_synopses);
                $performance_synopses = [];
                foreach($monthly_performance_synopses as $k=>$monthly_performance_synopsis){
                    $quartiles1Arr =  $quartiles2Arr =  $deciles1Arr =  $deciles2Arr = $quartiles1ArrValueCount = $quartiles2ArrValueCount = [];
                    $quartile1 =  $quartile2 =  $quartile3 =  $quartile4 = $decile1 = $decile2 = $decile3 = $decile4 = $decile5 = $decile6 = $decile7 = $decile8 = $decile9 = $decile10  = 0;
                    $quartile1_ =  $quartile2_ =  $quartile3_ =  $quartile4_ = $decile1_ = $decile2_ = $decile3_ = $decile4_ = $decile5_ = $decile6_ = $decile7_ = $decile8_ = $decile9_ = $decile10_ = 0;

                    $quartiles1 =  $monthly_performance_synopsis->quartiles1;
                    $quartiles2 =  $monthly_performance_synopsis->quartiles2;
                    $deciles1 =  $monthly_performance_synopsis->deciles1;
                    $deciles2 =  $monthly_performance_synopsis->deciles2;
                    $fund_names =  $monthly_performance_synopsis->fund_names;

                    if(!empty($quartiles1)){
                        $quartiles1Arr = explode(',',$quartiles1);
                        $quartiles2Arr = explode(',',$quartiles2);

                        $deciles1Arr = explode(',',$deciles1);
                        $deciles2Arr = explode(',',$deciles2);

                        $fund_namesArr = explode(',',$fund_names);


                        $quartiles1ArrValueCount = array_count_values($quartiles1Arr);
                        $quartiles2ArrValueCount = array_count_values($quartiles2Arr);

                        $deciles1ArrValueCount = array_count_values($deciles1Arr);
                        $deciles2ArrValueCount = array_count_values($deciles2Arr);


                        $duplicatesquartiles1 = self::findDuplicates($quartiles1Arr);
                        $duplicatesdeciles1 = self::findDuplicates($deciles1Arr);
                        
                        //print_r($quartiles1Arr);
                        //dd($quartiles1Arr); 
                        //dd($duplicatesquartiles1); 
                        //dd($fund_namesArr); 
                        //dd($quartiles1Arr); 
                        //dd(array_search(4, $quartiles1Arr)); 


                        for($i=1;$i<=4;$i++){
                            $name = 'quartile'.$i;
                            $name2 = 'quartileSchemes'.$i;
                            $nameCount = 0;
                            $scheme_names = [];
                            if(array_key_exists($i,$quartiles1ArrValueCount)){
                                
                                $nameCount = $quartiles1ArrValueCount[$i];
                            }
                            if(!empty($duplicatesquartiles1[$i])){
                                foreach($duplicatesquartiles1[$i] as $dk=>$quartileKey){
                                    if (isset($fund_namesArr[$quartileKey])) {
                                        $scheme_names[] = '* '.$fund_namesArr[$quartileKey];
                                    }
                                }
                            }
                            $performance_synopses[$k][$name] = $nameCount;
                            $performance_synopses[$k][$name2] = !empty($scheme_names)?implode('<br>',$scheme_names):'';
                        }
                        //dd($scheme_names);
                        for($i=1;$i<=4;$i++){
                            $name_ = '_quartile'.$i;
                            $nameCount_ = 0;
                            if(array_key_exists($i,$quartiles2ArrValueCount)){
                                
                                $nameCount_ = $quartiles2ArrValueCount[$i];
                            }
                            $performance_synopses[$k][$name_] = $nameCount_;
                        }

                        for($j=1;$j<=10;$j++){
                            $name = 'decile'.$j;
                            $name2 = 'decileSchemes'.$j;
                            $nameCount = 0;
                            $scheme_names_d = [];
                            if(array_key_exists($j,$deciles1ArrValueCount)){
                                
                                $nameCount = $deciles1ArrValueCount[$j];
                            }
                            if(!empty($duplicatesdeciles1[$j])){
                                foreach($duplicatesdeciles1[$j] as $dk=>$decileKey){
                                    if (isset($fund_namesArr[$decileKey])) {
                                        $scheme_names_d[] = '* '.$fund_namesArr[$decileKey];
                                    }
                                }
                            }
                            $performance_synopses[$k][$name] = $nameCount;
                            $performance_synopses[$k][$name2] = !empty($scheme_names_d)?implode('<br>',$scheme_names_d):'';
                        }

                        for($j=1;$j<=10;$j++){
                            $name_ = '_decile'.$j;
                            $nameCount_ = 0;
                            if(array_key_exists($j,$deciles2ArrValueCount)){
                                
                                $nameCount_ = $deciles2ArrValueCount[$j];
                            }
                            $performance_synopses[$k][$name_] = $nameCount_;
                        }
                    }
                    $performance_synopses[$k]['total_schemes'] = count($quartiles1Arr);
                    $performance_synopses[$k]['fund_house'] = $monthly_performance_synopsis->fund_house;
                    
                    
                }
            }
            
            $disclaimer_text = '';



            //dd($performance_synopses);
            return view($this->page_path . '.performance-synopsis', compact('defDataArr', 'dataArr', 'performance_synopses','type','ratio_type','monthly_performance_synopses_last_date','disclaimer_text'));
        }
        return abort(404);
    }
    function findDuplicates($array) {
        $valueCounts = array_count_values($array);
        $duplicates = [];
        
        foreach ($array as $key => $value) {
            //if ($valueCounts[$value] > 1) {
                $duplicates[$value][] = $key;
            //}
        }
    
        return $duplicates;
    }
    public function thankYouData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 4;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path . '.thank-you', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function fundManData(Request $request, $slug)
    {
        $dataArr = PageModel::getData($this->class_id, '', 31);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $fundManMdl = $fundManListMdl = [];

            $commonconstants = Config('commonconstants');

            $status = $commonconstants['status_val']['1'];

            $fundManMdl = FundMan::getData(['slug' => $slug, 'status' => $status], ['fm_id', 'name', 'designation', 'company_name', 'media_id', 'description', 'disclaimer', 'disclaimer_note']);
            if ($fundManMdl) {
                $fundManListMdl = FundMan::list(['data_id_not_in' => $fundManMdl->fm_id, 'status' => $status], ['fm_id', 'name', 'slug', 'designation', 'company_name', 'media_id']);
            }
            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['media_dir_name'])));

            return view($this->page_path . '.fund-man', compact('defDataArr', 'dataArr', 'fundManMdl', 'fundManListMdl'));
        }
        return abort(404);
    }
    public function founder(Request $request)
    {
        $dataArr = PageModel::getData($this->class_id, '', 48);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();
            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $fundManMdl = $fundManListMdl = [];

            $commonconstants = Config('commonconstants');

            $status = $commonconstants['status_val']['1'];


            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['media_dir_name'])));

            return view($this->page_path . '.founder', compact('defDataArr', 'dataArr', 'fundManMdl', 'fundManListMdl'));
        }
        return abort(404);
    }

    public function knowYourSchemeData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 32;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path . '.know-your-scheme', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function fundPortfolioData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 7;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path . '.fund-portfolio', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function faqData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 26;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $commonconstants = Config('commonconstants');

            $status = $commonconstants['status_val']['1'];

            $faqs = FAQModel::faqList(['category_id' => $commonconstants['def_faq_cat_id'], 'status' => $status], ['faq_id', 'title', 'descp'], 'c_order', 'ASC');
            $pthPgsMdl = PageModel::pageList(['ids' => [21, 22, 23, 24, 25], 'status' => $status], ['title', 'slug', 'template_id'], 'c_order', 'ASC');
            $stngDataArr = SettingsModel::getSettingsArr(['paathshaala_heading', 'paathshaala_image', 'newsletter_heading', 'newsletter_description'], $commonconstants['status_val'][1]);

            // dd($dataArr);

            $defDataArr = array_merge($this->defDataArr, array("setting_folder" => Core::getUploadedURL($commonconstants['setting_dir_name']), "web_lang" => __('web')));

            return view($this->page_path . '.faq', compact('defDataArr', 'dataArr', 'pthPgsMdl', 'stngDataArr', 'faqs'));
        }
        return abort(404);
    }

    public function mutualFundClassificationsData(Request $request, $id = 0)
    {
        $dataArr = PageModel::getData($this->class_id, '', 22);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $fundClsMdl = $fundClsListMdl = [];

            $commonconstants = Config('commonconstants');

            $status = $commonconstants['status_val']['1'];

            // if ($id == 0) {
            //     $fundClsMdl = FundClassification::list(['status' => $status, 'take' => 1], ['fc_id', 'title', 'description', 'file']);
            //     if ($fundClsMdl) {
            //         $fundClsMdl = $fundClsMdl[0];
            //     }
            // } else {
            //     $fundClsMdl = FundClassification::getData(['fc_id' => $id, 'status' => $status], ['fc_id', 'title', 'description', 'file']);
            // }

            // if ($fundClsMdl) {
            //     $fundClsListMdl = FundClassification::list(['status' => $status], ['fc_id', 'title']);
            // }

            $pthPgsMdl = PageModel::pageList(['ids' => [21, 22, 23, 24, 25], 'status' => $status], ['title', 'slug', 'template_id'], 'c_order', 'ASC');
            $stngDataArr = SettingsModel::getSettingsArr(['paathshaala_heading', 'paathshaala_image', 'newsletter_heading', 'newsletter_description'], $status);

            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['pdf_dir_name']), "setting_folder" => Core::getUploadedURL($commonconstants['setting_dir_name']), "web_lang" => __('web')));

            return view($this->page_path . '.mutual-fund-classifications', compact('defDataArr', 'dataArr', 'fundClsMdl', 'fundClsListMdl', 'pthPgsMdl', 'stngDataArr'));
        }
        return abort(404);
    }

    public function mutualFundTaxationData(Request $request, $id = 0)
    {
        $dataArr = PageModel::getData($this->class_id, '', 21);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $fundTxnMdl = $fundTxnListMdl = [];

            $commonconstants = Config('commonconstants');

            $status = $commonconstants['status_val']['1'];

            // if ($id == 0) {
            //     $fundTxnMdl = FundTaxation::list(['status' => $status, 'take' => 1], ['ft_id', 'title', 'description', 'file']);
            //     if ($fundTxnMdl) {
            //         $fundTxnMdl = $fundTxnMdl[0];
            //     }
            // } else {
            //     $fundTxnMdl = FundTaxation::getData(['ft_id' => $id, 'status' => $status], ['ft_id', 'title', 'description', 'file']);
            // }

            // if ($fundTxnMdl) {
            //     $fundTxnListMdl = FundTaxation::list(['status' => $status], ['ft_id', 'title']);
            // }

            $fundTxnMdl = FundTaxation::getData(['ft_id' => $id, 'status' => $status], ['ft_id', 'title', 'description', 'file']);

            //dd($fundTxnMdl);

            $pthPgsMdl = PageModel::pageList(['ids' => [21, 22, 23, 24, 25], 'status' => $status], ['title', 'slug', 'template_id'], 'c_order', 'ASC');
            $stngDataArr = SettingsModel::getSettingsArr(['paathshaala_heading', 'paathshaala_image', 'newsletter_heading', 'newsletter_description'], $status);

            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['pdf_dir_name']), "setting_folder" => Core::getUploadedURL($commonconstants['setting_dir_name']), "web_lang" => __('web')));

            // dd($pthPgsMdl);

            return view($this->page_path . '.mf-taxation', compact('defDataArr', 'dataArr', 'fundTxnMdl', 'fundTxnListMdl', 'pthPgsMdl', 'stngDataArr'));
        }
        return abort(404);
    }

    public function knowTheRatioData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 23;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $commonconstants = Config('commonconstants');

            $status = $commonconstants['status_val']['1'];

            $dataArr['know_the_ratio'] = KnowTheRatio::list(['status' => $status], ['ktr_id', 'title', 'description', 'media_id'], 'c_order', 'ASC');
            $pthPgsMdl = PageModel::pageList(['ids' => [21, 22, 23, 24, 25], 'status' => $status], ['title', 'slug', 'template_id'], 'c_order', 'ASC');
            $stngDataArr = SettingsModel::getSettingsArr(['paathshaala_heading', 'paathshaala_image', 'newsletter_heading', 'newsletter_description'], $commonconstants['status_val'][1]);

            // dd($faqMdl);

            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['media_dir_name']), "setting_folder" => Core::getUploadedURL($commonconstants['setting_dir_name']), "web_lang" => __('web')));

            return view($this->page_path . '.know-the-ratio', compact('defDataArr', 'dataArr', 'pthPgsMdl', 'stngDataArr'));
        }
        return abort(404);
    }

    public function compositionSnapshotData_old(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 8;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            // sayan 02/01/2025
            $fund_snapshot = [];
            $fund_types = [];
            $fund_type_id = '';
            $heading_name = '';
            $getdata = $request->all();
            //$date = CorpusEntry::getLastPublishedDate();
            $date = '2024-12-31';

            //dd($date);
            // $year = date('Y');
            // $month = date("m", strtotime("-1 month"));
            // $mth = date("M", strtotime("-1 month"));

            // if (date("m") <= 01 && $year == date('Y')) {
            //     $year = $year - 1;
            // }

            $year = date('Y',strtotime($date));
            $month = date("m", strtotime($date));
            $mth = date("M", strtotime($date));


            $fund_types = FundType::get();


            //dd($month.' '. $year);die;
            if (!empty($getdata['fund_type_id'])) {


                $fund_type_id = $getdata['fund_type_id'];
                $fund_type = FundType::where('ft_id', $fund_type_id)->first();
                // dd($getdata['fund_type']);
                $data['fund_type_name'] = $fund_type->name;

                $heading_name = $fund_type->name . ': For The Month of ' . $mth . ', ' . $year;
                //dd($heading_name);die;

                $mcap_entry = DB::table('mcap_eps')
                    ->select('scrip_name', 'market_cap')
                    ->whereYear('entry_date', $year)
                    ->whereMonth(
                        'entry_date',
                        $month
                    )
                    ->orderBy('market_cap', 'DESC')
                    ->get();

                // dd($mcap_entry);

                $vlc_scrip_arr = [];
                $lc_scrip_arr = [];
                $mc_scrip_arr = [];
                $sc_scrip_arr = [];

                $i = 0;
                foreach ($mcap_entry as $mcap_val) {

                    $i++;

                    if (
                        $i >= 1 && $i <= 15
                    ) {

                        array_push($vlc_scrip_arr, $mcap_val->scrip_name);
                    } else if (
                        $i >= 16 && $i <= 100
                    ) {
                        array_push($lc_scrip_arr, $mcap_val->scrip_name);
                    } else if (
                        $i >= 101 && $i <= 250
                    ) {

                        array_push($mc_scrip_arr, $mcap_val->scrip_name);
                    } else if ($i > 250) {

                        array_push($sc_scrip_arr, $mcap_val->scrip_name);
                    }
                }

                $fund_snapshot = DB::select('CALL sp_fund_composition_classification(' . $fund_type_id . ')');

                if (!empty($fund_snapshot)) {
                    foreach ($fund_snapshot as  $k2 => $fund_ss) {
                        # code...
                        $fund_dtl = DB::table('fund_master')->select('fund_code')->where('fund_name', $fund_ss->fund_name)->first();
                        $vlc_val = DB::table('fund_composition')
                            ->select(DB::raw('SUM(content_per) as vlc'))
                            ->where('fund_code', $fund_dtl->fund_code)
                            ->whereIn('scrip_name', $vlc_scrip_arr)
                            ->whereYear('entry_date', $year)
                            ->whereMonth('entry_date', $month)
                            ->first();

                        $lc_val = DB::table('fund_composition')
                            ->select(DB::raw('SUM(content_per) as lc'))
                            ->where('fund_code', $fund_dtl->fund_code)
                            ->whereIn('scrip_name', $lc_scrip_arr)
                            ->whereYear('entry_date', $year)
                            ->whereMonth('entry_date', $month)
                            ->first();

                        $mc_val = DB::table('fund_composition')
                            ->select(DB::raw('SUM(content_per) as mc'))
                            ->where('fund_code', $fund_dtl->fund_code)
                            ->whereIn('scrip_name', $mc_scrip_arr)
                            ->whereYear('entry_date', $year)
                            ->whereMonth('entry_date', $month)
                            ->first();

                        $sc_val = DB::table('fund_composition')
                            ->select(DB::raw('SUM(content_per) as sc'))
                            ->where('fund_code', $fund_dtl->fund_code)
                            ->whereIn('scrip_name', $sc_scrip_arr)
                            ->whereYear('entry_date', $year)
                            ->whereMonth('entry_date', $month)
                            ->first();

                        $fund_snapshot[$k2]->eq_small = number_format($sc_val->sc, 2);
                        $fund_snapshot[$k2]->eq_mid = number_format($mc_val->mc, 2);
                        $fund_snapshot[$k2]->eq_large = number_format($lc_val->lc, 2);
                        $fund_snapshot[$k2]->eq_very_large = number_format($vlc_val->vlc, 2);

                        //dd($fund_ss);
                    }
                }
            }

            //dd($fund_snapshot);

            //dd($this->page_path); die;
            return view($this->page_path . '.fund-composition-snapshot', compact('defDataArr', 'dataArr', 'fund_types', 'fund_snapshot', 'fund_type_id', 'heading_name'));
        }
        return abort(404);
    }

    public function compositionSnapshotData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 8;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            // sayan 02/01/2025
            $fund_snapshot = [];
            $fundsArr = $fund_types = [];
            $fund_type_id = '';
            $heading_name = '';
            $getdata = $request->all();
            $fund_types = FundType::get();


            //dd($month.' '. $year);die;
            if (!empty($getdata['fund_type_id'])) {
                //$date = CorpusEntry::getLastPublishedDate();
                $last_composition_allocation_info = DB::table('fund_category_composition_allocations')->orderByDesc('id')->select('monthinfo', 'yearinfo') ->first();
                $funds = DB::table('fund_master')->orderBy('fund_name','ASC')->selectRaw('GROUP_CONCAT(fund_name) as fund_names')->where('fund_type_id',$getdata['fund_type_id']) ->first();
                $fundsArr = !empty($funds->fund_names)?explode(',',$funds->fund_names):[];
                //dd($funds);
                $date=$last_composition_allocation_info->yearinfo.'-'.$last_composition_allocation_info->monthinfo.'-01';
                $year = date('Y', strtotime($date));
                $month = date("m", strtotime($date));
                $mth = date("M", strtotime($date));

                $fund_type_id = $getdata['fund_type_id'];
                $fund_type = FundType::where('ft_id', $fund_type_id)->first();
                // dd($getdata['fund_type']);
                $data['fund_type_name'] = $fund_type->name;
                
                //dd($heading_name);die;
                $fund_snapshot = DB::table('fund_category_composition_allocations')
                    ->where('fund_category_composition_allocations.monthinfo', $month)
                    ->where('fund_category_composition_allocations.yearinfo', $year)
                    ->where('fund_category_composition_allocations.fund_type_id', $fund_type_id)
                    ->orderBy('fund_category_composition_allocations.fund_name', 'ASC')
                    ->groupBy('fund_name')
                    ->select('fund_category_composition_allocations.*')
                    ->get();
                //dd($fund_snapshot);

                if(empty($fund_snapshot[0])){

                    $date = date('Y-m-d', strtotime($date.' first day of last month'));
                    $year = date('Y', strtotime($date));
                    $month = date("m", strtotime($date));
                    $mth = date("M", strtotime($date));

                    $fund_snapshot = DB::table('fund_category_composition_allocations')
                    ->where('fund_category_composition_allocations.monthinfo', $month)
                        ->where('fund_category_composition_allocations.yearinfo', $year)
                        ->where('fund_category_composition_allocations.fund_type_id', $fund_type_id)
                        ->orderBy('fund_category_composition_allocations.fund_name', 'ASC')
                        ->groupBy('fund_name')
                        ->select('fund_category_composition_allocations.*')
                        ->get();

                }


                $heading_name = $fund_type->name . ': For The Month of ' . $mth . ', ' . $year;
                
            }

            //dd($fund_snapshot);

            //dd($this->page_path); die;
            return view($this->page_path . '.fund-composition-snapshot', compact('defDataArr', 'dataArr', 'fund_types', 'fund_snapshot', 'fund_type_id', 'heading_name', 'fundsArr'));
        }
        return abort(404);
    }

    public function corpusDetailsData(Request $request, $slug = false)
    {

        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 51;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);

        //dd($dataArr);

        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            $apiUrl = "https://www.myplexus.com/api/v1/fund-classifications";

            $responseData = $this->getData($apiUrl);

            //dd($responseData);

            return view($this->page_path . '.corpus-details', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function getData($apiUrl)
    {
        $parameters = "";
        $response = Http::get($apiUrl, $parameters);
        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);

        return $responseBody;
    }



    public function weeklySnapshotData(Request $request, $slug = false)
    {

        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 10;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;
            //dd($dataArr);

            // sayan 06/01/2025

            $date = date('Y-m-d', strtotime('-1 day'));

            $daysToSubtract = [
                'Monday' => ['start' => 3, 'end' => 9],
                'Tuesday' => ['start' => 4, 'end' => 10],
                'Wednesday' => ['start' => 5, 'end' => 11],
                'Thursday' => ['start' => 6, 'end' => 12],
                'Friday' => ['start' => 0, 'end' => 6],
                'Saturday' => ['start' => 1, 'end' => 7],
                'Sunday' => ['start' => 2, 'end' => 8],
            ];

            // Get the weekday of the provided date
            $weekday = Carbon::parse($date)->format('l');
            // dd($weekday);
            // Get the number of days to subtract based on the weekday
            if (isset($daysToSubtract[$weekday])) {
                $startDays = $daysToSubtract[$weekday]['start'];

                $endDays = $daysToSubtract[$weekday]['end'];
                // dd()
                $end_date = Carbon::parse($date)->subDays($startDays)->toDateString();
                $start_date = Carbon::parse($date)->subDays($endDays)->toDateString();
                // dd('Start: '.$start_date." End: ".$end_date);
            } else {
                // Handle case where the weekday is not found (optional)
                $start_date = $end_date = null;
            }
            $from_date = $start_date;
            $to_date = $end_date;

            // $from_date = date("Y-m-d", strtotime("last week -2 days"));
            // $to_date = date("Y-m-d", strtotime("last week 4 days"));

            //dd($to_date);
            $days = strtotime($to_date) - strtotime($from_date);
            $days = (int)round($days / (60 * 60 * 24));

            $days = 6;

            if ($this->usingSqlite()) {
                $data['changes_indices'] = $this->buildIndexRows($to_date);
                $data['changes_currency'] = [
                    (object) ['name' => 'USD/INR', 'cur_value' => 83.14, 'PER_CHANGE' => 0.12],
                    (object) ['name' => 'EUR/INR', 'cur_value' => 90.02, 'PER_CHANGE' => 0.08],
                    (object) ['name' => 'GBP/INR', 'cur_value' => 105.34, 'PER_CHANGE' => -0.04],
                ];
                $data['changes_commodity'] = [
                    (object) ['name' => 'Gold', 'cur_value' => 72345.12, 'PER_CHANGE' => 0.23],
                    (object) ['name' => 'Silver', 'cur_value' => 85230.55, 'PER_CHANGE' => -0.15],
                ];
                $data['weekly_benchmark'] = $this->buildFundTypeBenchmarks();
                $data['best_schemes'] = $this->buildBestFundsRows();
            } else {
                $data['changes_indices'] = DB::select('CALL sp_snapshot_indices_currency_commodity_updated_new("GET_INDICES","' . $to_date . '",' . $days . ')');
                $data['changes_currency'] = DB::select('CALL sp_snapshot_indices_currency_commodity("GET_CURRENCY","' . $to_date . '",' . $days . ')');
                $data['changes_commodity'] = DB::select('CALL sp_snapshot_indices_currency_commodity("GET_COMMODITY","' . $to_date . '",' . $days . ')');
                $data['weekly_benchmark'] = DB::select('CALL sp_snapshot_weekly_benchmark("' . $to_date . '")');
                $data['best_schemes'] = DB::select('CALL sp_snapshot_weekly_fund("' . $to_date . '")');
            }

            $data['array_bse'] = [];
            $data['array_nse'] = [];
            $data['array_global_it'] = [];
            foreach ($data['changes_indices'] as $value) {
                if ($value->index_type == "NSE") {
                    $data['array_nse'][] = $value;
                }
                if ($value->index_type == "BSE") {
                    $data['array_bse'][] = $value;
                }
                if ($value->index_type == "GLOBAL") {
                    $data['array_global_it'][] = $value;
                }
            }
            //dd($previous_week_end); die;

            return view($this->page_path . '.weekly-snapshot', compact('defDataArr', 'dataArr', 'data', 'from_date', 'to_date'));
        }

        return abort(404);
    }



    public function monthlySnapshotData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 9;
        }
        // dd($this->class_id);
        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        // dd($dataArr);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            // sayan 03/01/2025

            
            $date = date("Y-m-d", strtotime("-1 days"));
            
            $to_date = $date;
            $oneMonthBefore = Carbon::parse($to_date)->subMonth();
            $from_date = $oneMonthBefore->toDateString();
            
            $days = strtotime($to_date) - strtotime($from_date);
            // dd($days);
            $days = (int)round($days / (60 * 60 * 24));
            

            //dd($from_date,$to_date);
            // $from_date = '2024-11-10';
            // $to_date = '2024-12-10';

            $days = strtotime($to_date) - strtotime($from_date);
            $days = (int)round($days / (60 * 60 * 24));

            if ($this->usingSqlite()) {
                $data['monthly_benchmark'] = $monthly_benchmark = $this->buildFundTypeBenchmarks();
                $data['changes_indices'] = $this->buildIndexRows($to_date);
                $data['changes_currency'] = [
                    (object) ['name' => 'USD/INR', 'cur_value' => 83.14, 'PER_CHANGE' => 0.12],
                    (object) ['name' => 'EUR/INR', 'cur_value' => 90.02, 'PER_CHANGE' => 0.08],
                    (object) ['name' => 'GBP/INR', 'cur_value' => 105.34, 'PER_CHANGE' => -0.04],
                ];
                $data['changes_commodity'] = [
                    (object) ['name' => 'Gold', 'cur_value' => 72345.12, 'PER_CHANGE' => 0.23],
                    (object) ['name' => 'Silver', 'cur_value' => 85230.55, 'PER_CHANGE' => -0.15],
                ];
                $data['best_schemes'] = $this->buildBestFundsRows();
            } else {
                $data['monthly_benchmark'] = $monthly_benchmark = DB::select('CALL sp_snapshot_monthly_benchmark_new("' . $to_date . '")');

                foreach ($monthly_benchmark as $key => $monthly_benchmark_val) {
                    $fundCategoryChangeReturn = 0;
                    $type_id = $monthly_benchmark_val->FundTypeID;
                    $date = Carbon::createFromFormat('Y-m-d', $to_date);
                    $end_date = $date->format('Y-m-d');
                    $start_date = $date->subMonth(1)->format('Y-m-d');
                    $end_days = date('t', strtotime($end_date));
                    if ($end_days == 31) {
                        $days = 30;
                    } elseif ($end_days == 30) {
                        $days = 29;
                    } elseif ($end_days == 29) {
                        $days = 28;
                    } elseif ($end_days == 28) {
                        $days = 27;
                    }
                    $query = 'CALL sp_snapshot_fund_change_val("' . $end_date . '","' . $type_id . '","' . $days . '","monthly")';

                    $changes_fund = DB::select($query);

                    if (count($changes_fund)) {
                        $changeValues = array_map(function ($item) {
                            return printValue($item->change_value);
                        }, $changes_fund);

                        $arr = array_filter($changeValues, 'is_numeric');
                        sort($arr);

                        $count = count($arr);
                        $return = 0;

                        if ($count > 0) {
                            $changeValuesSum = array_sum($arr);
                            $fundCategoryChangeReturn = $changeValuesSum / $count;
                        }

                        $middleIndex = floor(($count - 1) / 2);
                        if ($count % 2) {
                            $return = $arr[$middleIndex];
                        } else {
                            $return = ($arr[$middleIndex] + $arr[$middleIndex + 1]) / 2;
                        }

                        $monthly_benchmark[$key]->MEDIANVAL_NEW = $return;
                        $monthly_benchmark[$key]->CHANGEVALUE_NEW = $fundCategoryChangeReturn;
                    } else {
                        $monthly_benchmark[$key]->MEDIANVAL_NEW = 0;
                        $monthly_benchmark[$key]->CHANGEVALUE_NEW = 0;
                    }
                }

                $data['changes_indices'] = DB::select('CALL sp_snapshot_indices_currency_commodity_updated_new("GET_INDICES","' . $to_date . '",' . $days . ')');
                $data['changes_currency'] = DB::select('CALL sp_snapshot_indices_currency_commodity("GET_CURRENCY","' . $to_date . '",' . $days . ')');
                $data['changes_commodity'] = DB::select('CALL sp_snapshot_indices_currency_commodity("GET_COMMODITY","' . $to_date . '",' . $days . ')');
                $data['best_schemes'] = DB::select('CALL sp_snapshot_monthly_best_fund_new("' . $from_date . '","' . $to_date . '")');
            }

            $data['array_bse'] = [];
            $data['array_nse'] = [];
            $data['array_global_it'] = [];
            foreach ($data['changes_indices'] as $value) {
                if ($value->index_type == "NSE") {
                    $data['array_nse'][] = $value;
                }
                if ($value->index_type == "BSE") {
                    $data['array_bse'][] = $value;
                }
                if ($value->index_type == "GLOBAL") {
                    $data['array_global_it'][] = $value;
                }
            }

            //dd($this->page_path);die;
            return view($this->page_path . '.monthly-snapshot', compact('defDataArr', 'dataArr', 'data', 'from_date', 'to_date'));
        }
        return abort(404);
    }

    public function monthlyRankingData_(Request $request, $slug = false)
    {
        // dd($request->all());
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 6;
        }
        // dd($dataId);
        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;
            // dd($dataArr);
            // dd($this->page_path);
            // sayan 08/01/2025

            $end_date = CorpusEntry::getLastPublishedDate();


            //dd($end_date);

            $start_date = Carbon::parse($end_date)->subMonths(12)->addDay()->format('Y-m-d');
            $first_period_start_date = Carbon::parse($end_date)->subMonths(3)->format('Y-m-d');
            $first_period_end_date = $end_date;

            $second_period_start_date = Carbon::parse($first_period_start_date)->subMonths(3)->format('Y-m-d');
            $second_period_end_date = Carbon::parse($first_period_start_date)->subDay()->format('Y-m-d');

            $third_period_start_date = Carbon::parse($second_period_start_date)->subMonths(3)->format('Y-m-d');
            $third_period_end_date = Carbon::parse($second_period_start_date)->subDay()->format('Y-m-d');

            $fourth_period_start_date = Carbon::parse($third_period_start_date)->subMonths(3)->format('Y-m-d');
            $fourth_period_end_date = Carbon::parse($third_period_start_date)->subDay()->format('Y-m-d');

            // $start_date = Carbon::parse($end_date)->subMonths(12)->addDay()->format('Y-m-d');
            // $first_period_start_date = Carbon::parse($end_date)->subDay(3)->format('Y-m-d');
            // $first_period_end_date = $end_date;

            // $second_period_start_date = Carbon::parse($first_period_start_date)->subDay(3)->format('Y-m-d');
            // $second_period_end_date = Carbon::parse($first_period_start_date)->subDay()->format('Y-m-d');

            // $third_period_start_date = Carbon::parse($second_period_start_date)->subDay(3)->format('Y-m-d');
            // $third_period_end_date = Carbon::parse($second_period_start_date)->subDay()->format('Y-m-d');

            // $fourth_period_start_date = Carbon::parse($third_period_start_date)->subDay(3)->format('Y-m-d');
            // $fourth_period_end_date = Carbon::parse($third_period_start_date)->subDay()->format('Y-m-d'); 


            // dd([
            //     $first_period_start_date,$first_period_end_date,
            //     $second_period_start_date,$second_period_end_date,
            //     $third_period_start_date,$third_period_end_date,
            //     $fourth_period_start_date,$fourth_period_end_date,
            // ]);

            //die;
            $dataArr2 = $fund_type = $responseArr  = $aumArr = $one_year_returnArr = [];
            $type_id = $fund_name = '';
            $fund_types = FundType::get();
            $getdata = $request->all();
            if (!empty($getdata)) {
                $fund_classification = $getdata['fund_classification'];
                $fund_type = FundType::where('name', $fund_classification)->first();
                $type_id = $fund_type->ft_id;
                $fund_name = $fund_type->name;

                $lstObj = new CorpusEntry;
                $getActiveAUMs = $lstObj::getActiveAUMs();
                foreach ($getActiveAUMs as $kd => $getActiveAUM) {
                    $aumArr[$getActiveAUM->fund_code] = $getActiveAUM->corpus_entry;
                }

                //dd($fund_type);
                $dataArr3 = DB::select('CALL sp_quick_return_ration_test("' . $end_date . '",' . $type_id . ')');
                $dataArr2 = MonthlyRatioCalculation::list(['fund_type_id' => $type_id]);
                //dd($type_id);
                foreach ($dataArr3 as $k3 => $data3) {
                    $one_year_returnArr[$data3->fund_code] = $data3->oneyear;
                }


                //  dd($dataArr2); die;
                // echo "<pre>";print_r($dataArr2);die;
                // \Log::debug('data_array', [$dataArr2]);
                // print_r($dataArr2);die;
                $volatalityArr = $betaArr = $jensenAlphaArr = [];
                if (count($dataArr2) > 0) {
                    // dd('if');
                    foreach ($dataArr2 as $fund) {
                        if ($fund->p1_volatality !== null && $fund->p2_volatality !== null && $fund->p3_volatality !== null && $fund->p4_volatality !== null) {
                            // $volatalityArr[0][$fund->fund_code] = $fund->p1_volatality;
                            // $volatalityArr[1][$fund->fund_code] = $fund->p2_volatality;
                            // $volatalityArr[2][$fund->fund_code] = $fund->p3_volatality;
                            // $volatalityArr[3][$fund->fund_code] = $fund->p4_volatality;

                            $p1_fund_return_volatality = self::stvolatilityApi($fund->fund_code, $first_period_start_date, $first_period_end_date);
                            if (!empty($p1_fund_return_volatality)) {
                                $p1_volatality = ($p1_fund_return_volatality['volatility'] != 'N/A') ? $p1_fund_return_volatality['volatility'] : '';
                            }
                            $p2_fund_return_volatality = self::stvolatilityApi($fund->fund_code, $second_period_start_date, $second_period_end_date);

                            if (!empty($p2_fund_return_volatality)) {
                                $p2_volatality = ($p2_fund_return_volatality['volatility'] != 'N/A') ? $p2_fund_return_volatality['volatility'] : '';
                            }
                            $p3_fund_return_volatality = self::stvolatilityApi($fund->fund_code, $third_period_start_date, $third_period_end_date);

                            if (!empty($p3_fund_return_volatality)) {
                                $p3_volatality = ($p3_fund_return_volatality['volatility'] != 'N/A') ? $p3_fund_return_volatality['volatility'] : '';
                            }
                            $p4_fund_return_volatality = self::stvolatilityApi($fund->fund_code, $fourth_period_start_date, $fourth_period_end_date);

                            if (!empty($p4_fund_return_volatality)) {
                                $p4_volatality = ($p4_fund_return_volatality['volatility'] != 'N/A') ? $p4_fund_return_volatality['volatility'] : '';
                            }

                            $volatalityArr[0][$fund->fund_code] = $p1_volatality;
                            $volatalityArr[1][$fund->fund_code] = $p2_volatality;
                            $volatalityArr[2][$fund->fund_code] = $p3_volatality;
                            $volatalityArr[3][$fund->fund_code] = $p4_volatality;
                        }
                        if ($fund->p1_beta !== null && $fund->p2_beta !== null && $fund->p3_beta !== null && $fund->p4_beta !== null) {
                            // $betaArr[0][$fund->fund_code] = $fund->p1_beta;
                            // $betaArr[1][$fund->fund_code] = $fund->p2_beta;
                            // $betaArr[2][$fund->fund_code] = $fund->p3_beta;
                            // $betaArr[3][$fund->fund_code] = $fund->p4_beta;

                            $p1_fund_return_beta = self::stbetaApi($fund->fund_code, $first_period_start_date, $first_period_end_date);
                            if (!empty($p1_fund_return_beta)) {
                                $p1_beta = ($p1_fund_return_beta['beta'] != 'N/A') ? $p1_fund_return_beta['beta'] : '';
                            }
                            $p2_fund_return_beta = self::stbetaApi($fund->fund_code, $second_period_start_date, $second_period_end_date);

                            if (!empty($p2_fund_return_beta)) {
                                $p2_beta = ($p2_fund_return_beta['beta'] != 'N/A') ? $p2_fund_return_beta['beta'] : '';
                            }
                            $p3_fund_return_beta = self::stbetaApi($fund->fund_code, $third_period_start_date, $third_period_end_date);

                            if (!empty($p3_fund_return_beta)) {
                                $p3_beta = ($p3_fund_return_beta['beta'] != 'N/A') ? $p3_fund_return_beta['beta'] : '';
                            }
                            $p4_fund_return_beta = self::stbetaApi($fund->fund_code, $fourth_period_start_date, $fourth_period_end_date);

                            if (!empty($p4_fund_return_beta)) {
                                $p4_beta = ($p4_fund_return_beta['beta'] != 'N/A') ? $p4_fund_return_beta['beta'] : '';
                            }

                            $betaArr[0][$fund->fund_code] = $p1_beta;
                            $betaArr[1][$fund->fund_code] = $p2_beta;
                            $betaArr[2][$fund->fund_code] = $p3_beta;
                            $betaArr[3][$fund->fund_code] = $p4_beta;
                        }
                        if ($fund->p1_jensen_alpha !== null && $fund->p2_jensen_alpha !== null && $fund->p3_jensen_alpha !== null && $fund->p4_jensen_alpha !== null) {
                            $p1_fund_return_jensenalpha = self::jensenalphaApi($fund->fund_code, $first_period_start_date, $first_period_end_date);
                            if (!empty($p1_fund_return_jensenalpha)) {
                                $p1_jensenalpha = ($p1_fund_return_jensenalpha['jensens_alpha'] != 'N/A') ? $p1_fund_return_jensenalpha['jensens_alpha'] : '';
                            }
                            $p2_fund_return_jensenalpha = self::jensenalphaApi($fund->fund_code, $second_period_start_date, $second_period_end_date);

                            if (!empty($p2_fund_return_jensenalpha)) {
                                $p2_jensenalpha = ($p2_fund_return_jensenalpha['jensens_alpha'] != 'N/A') ? $p2_fund_return_jensenalpha['jensens_alpha'] : '';
                            }
                            $p3_fund_return_jensenalpha = self::jensenalphaApi($fund->fund_code, $third_period_start_date, $third_period_end_date);

                            if (!empty($p3_fund_return_jensenalpha)) {
                                $p3_jensenalpha = ($p3_fund_return_jensenalpha['jensens_alpha'] != 'N/A') ? $p3_fund_return_jensenalpha['jensens_alpha'] : '';
                            }
                            $p4_fund_return_jensenalpha = self::jensenalphaApi($fund->fund_code, $fourth_period_start_date, $fourth_period_end_date);

                            if (!empty($p4_fund_return_jensenalpha)) {
                                $p4_jensenalpha = ($p4_fund_return_jensenalpha['jensens_alpha'] != 'N/A') ? $p4_fund_return_jensenalpha['jensens_alpha'] : '';
                            }

                            $jensenAlphaArr[0][$fund->fund_code] = $p1_jensenalpha;
                            $jensenAlphaArr[1][$fund->fund_code] = $p2_jensenalpha;
                            $jensenAlphaArr[2][$fund->fund_code] = $p3_jensenalpha;
                            $jensenAlphaArr[3][$fund->fund_code] = $p4_jensenalpha;


                            // $jensenAlphaArr[0][$fund->fund_code] = $fund->p1_jensen_alpha;
                            // $jensenAlphaArr[1][$fund->fund_code] = $fund->p2_jensen_alpha;
                            // $jensenAlphaArr[2][$fund->fund_code] = $fund->p3_jensen_alpha;
                            // $jensenAlphaArr[3][$fund->fund_code] = $fund->p4_jensen_alpha;
                        }
                    }

                    //dd($jensenAlphaArr);
                    //print_r($this->gtRiskRatiosval('Axis Mid', $volatalityArr)); die;
                    foreach ($dataArr2 as $index => $fund) {
                        \Log::debug('fund', [$fund->fund_code]);


                        $dataArr2[$index]['aaum'] = $aumArr[$fund->fund_code];
                        $dataArr2[$index]['one_year_return'] = $one_year_returnArr[$fund->fund_code];

                        $dataArr2[$index]['volatality'] = $dataArr2[$index]['market_risk'] = $dataArr2[$index]['return_quality'] = null;
                        if ($fund->p1_volatality !== null && $fund->p2_volatality !== null && $fund->p3_volatality !== null && $fund->p4_volatality !== null) {
                            // dd($fund->fund_code.'-------'.$volatalityArr);
                            $dataArr2[$index]['volatality'] = $this->gtRiskRatiosval($fund->fund_code, $volatalityArr);
                        }
                        // dd($dataArr2[$index]['volatality']);
                        if ($fund->p1_beta !== null && $fund->p2_beta !== null && $fund->p3_beta !== null && $fund->p4_beta !== null) {
                            $dataArr2[$index]['market_risk'] = $this->gtRiskRatiosval($fund->fund_code, $betaArr);
                        }
                        if ($fund->p1_jensen_alpha !== null && $fund->p2_jensen_alpha !== null && $fund->p3_jensen_alpha !== null && $fund->p4_jensen_alpha !== null) {
                            $dataArr2[$index]['return_quality'] = $this->gtReturnQualityval($fund->fund_code, $jensenAlphaArr);
                        }
                        $unset_array = array("p1_volatality", "p2_volatality", "p3_volatality", "p4_volatality", 'p1_beta', 'p2_beta', 'p3_beta', 'p4_beta', 'p1_jensen_alpha', 'p2_jensen_alpha', 'p3_jensen_alpha', 'p4_jensen_alpha');
                        foreach ($unset_array as $key) {
                            unset($dataArr2[$index][$key]);
                        }
                    }
                    //dd($dataArr2);die;
                    //$responseArr['monthly_ranking'] = $dataArr2;


                }
                $responseArr['to_date'] = date('F, Y', strtotime($end_date));
            }

            return view($this->page_path . '.monthly-ranking', compact('defDataArr', 'dataArr', 'fund_types', 'type_id', 'fund_name', 'dataArr2', 'responseArr'));
        }
        return abort(404);
    }
    public function monthlyRankingData(Request $request, $slug = false)
    {
        // dd($request->all());
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 6;
        }
        // dd($dataId);
        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;
            // dd($dataArr);
            // dd($this->page_path);
            // sayan 08/01/2025

            $end_date = CorpusEntry::getLastPublishedDate();


            //dd($end_date);

            

            //die;
            $dataArr2 = $fund_type = $responseArr  = $aumArr = $one_year_returnArr = [];
            $type_id = $fund_name = '';
            $fund_types = FundType::get();
            $getdata = $request->all();
            //dd($getdata);
            if (!empty($getdata)) {
                $fund_classification = $getdata['fund_classification'];
                $fund_type = FundType::where('name', $fund_classification)->first();
                //dd($fund_type);
                $type_id = $fund_type->ft_id;
                $fund_name = $fund_type->name;

                $dataArr2 = MonthlyRatioCalculation::list(['fund_type_id' => $type_id, 'end_date'=> $end_date]);
                //dd($dataArr2);
                $volatalityArr = $betaArr = $jensenAlphaArr = [];
                if (count($dataArr2) > 0) {
                    // dd('if');
                    foreach ($dataArr2 as $fund) {
                        if ($fund->p1_volatality !== null && $fund->p2_volatality !== null && $fund->p3_volatality !== null && $fund->p4_volatality !== null) {
                            $volatalityArr[0][$fund->fund_code] = $fund->p1_volatality;
                            $volatalityArr[1][$fund->fund_code] = $fund->p2_volatality;
                            $volatalityArr[2][$fund->fund_code] = $fund->p3_volatality;
                            $volatalityArr[3][$fund->fund_code] = $fund->p4_volatality;                           
                        }
                        if ($fund->p1_beta !== null && $fund->p2_beta !== null && $fund->p3_beta !== null && $fund->p4_beta !== null) {
                            $betaArr[0][$fund->fund_code] = $fund->p1_beta;
                            $betaArr[1][$fund->fund_code] = $fund->p2_beta;
                            $betaArr[2][$fund->fund_code] = $fund->p3_beta;
                            $betaArr[3][$fund->fund_code] = $fund->p4_beta;                            
                        }
                        if ($fund->p1_jensen_alpha !== null && $fund->p2_jensen_alpha !== null && $fund->p3_jensen_alpha !== null && $fund->p4_jensen_alpha !== null) {  

                            $jensenAlphaArr[0][$fund->fund_code] = $fund->p1_jensen_alpha;
                            $jensenAlphaArr[1][$fund->fund_code] = $fund->p2_jensen_alpha;
                            $jensenAlphaArr[2][$fund->fund_code] = $fund->p3_jensen_alpha;
                            $jensenAlphaArr[3][$fund->fund_code] = $fund->p4_jensen_alpha;
                        }
                    }

                    //dd($jensenAlphaArr);
                    //print_r($this->gtRiskRatiosval('Axis Mid', $volatalityArr)); die;
                    foreach ($dataArr2 as $index => $fund) {
                        \Log::debug('fund', [$fund->fund_code]);

                        $dataArr2[$index]['volatality'] = $dataArr2[$index]['market_risk'] = $dataArr2[$index]['return_quality'] = null;
                        if ($fund->p1_volatality !== null && $fund->p2_volatality !== null && $fund->p3_volatality !== null && $fund->p4_volatality !== null) {
                            // dd($fund->fund_code.'-------'.$volatalityArr);
                            $dataArr2[$index]['volatality'] = $this->gtRiskRatiosval($fund->fund_code, $volatalityArr);
                        }
                        // dd($dataArr2[$index]['volatality']);
                        if ($fund->p1_beta !== null && $fund->p2_beta !== null && $fund->p3_beta !== null && $fund->p4_beta !== null) {
                            $dataArr2[$index]['market_risk'] = $this->gtRiskRatiosval($fund->fund_code, $betaArr);
                        }
                        if ($fund->p1_jensen_alpha !== null && $fund->p2_jensen_alpha !== null && $fund->p3_jensen_alpha !== null && $fund->p4_jensen_alpha !== null) {
                            $dataArr2[$index]['return_quality'] = $this->gtReturnQualityval($fund->fund_code, $jensenAlphaArr);
                        }
                        $unset_array = array("p1_volatality", "p2_volatality", "p3_volatality", "p4_volatality", 'p1_beta', 'p2_beta', 'p3_beta', 'p4_beta', 'p1_jensen_alpha', 'p2_jensen_alpha', 'p3_jensen_alpha', 'p4_jensen_alpha');
                        foreach ($unset_array as $key) {
                            unset($dataArr2[$index][$key]);
                        }
                    }
                    //dd($dataArr2);die;
                    //$responseArr['monthly_ranking'] = $dataArr2;


                }
                $responseArr['to_date'] = date('F, Y', strtotime($end_date));
            }

            return view($this->page_path . '.monthly-ranking', compact('defDataArr', 'dataArr', 'fund_types', 'type_id', 'fund_name', 'dataArr2', 'responseArr'));
        }
        return abort(404);
    }
    // sayan
    public static function jensenalphaApi($fund_code, $start_date, $end_date)
    {
        $baseUrl = URL::to('/');
        $endpoint = 'report-jensens-alpla-api';

        // Construct the full URL
        $url = $baseUrl . '/' . $endpoint;

        $params = [
            'search_fund_name' => $fund_code,
            'search_from_date' => $start_date,
            'search_to_date' => $end_date,
            'search' => 'Search'
        ];

        // dd($params);
        // dd($url);
        $fullUrl = $url . '?' . http_build_query($params);
        // dd($fullUrl);
        // Send a GET request to the URL with the query parameters
        $response = Http::get($url, $params);



        // Check if the request was successful
        if ($response->successful()) {
            // Get the data from the response
            $ratioData = $response->json();
        } else {
            $ratioData = [];
        }
        return $ratioData;
    }

    public static function stbetaApi($fund_code, $start_date, $end_date)
    {
        // dd('informationRatioApi');
        $baseUrl = URL::to('/');
        $endpoint = 'report-beta-api';

        // Construct the full URL
        $url = $baseUrl . '/' . $endpoint;
        // dd($url);

        $params = [
            'search_fund_name' => $fund_code,
            'search_from_date' => $start_date,
            'search_to_date' => $end_date,
            'search' => 'Search'
        ];
        $fullUrl = $url . '?' . http_build_query($params);
        // dd($fullUrl);
        // Send a GET request to the URL with the query parameters
        $response = Http::get($url, $params);
        // dd($response);
        //   if($fund_code == 'INF959L01CF0'){
        // dd($response->json());
        //   }
        // Check if the request was successful
        if ($response->successful()) {
            // Get the data from the response
            $ratioData = $response->json();
        } else {
            $ratioData = [];
        }
        return $ratioData;
    }

    public static function stvolatilityApi($fund_code, $start_date, $end_date)
    {
        // dd('informationRatioApi');
        $baseUrl = URL::to('/');
        $endpoint = 'report-volatility-api';

        // Construct the full URL
        $url = $baseUrl . '/' . $endpoint;
        // dd($url);

        $params = [
            'search_fund_name' => $fund_code,
            'search_from_date' => $start_date,
            'search_to_date' => $end_date,

            'search' => 'Search'
        ];
        $fullUrl = $url . '?' . http_build_query($params);
        // dd($fullUrl);
        // Send a GET request to the URL with the query parameters
        $response = Http::get($url, $params);
        // dd($response);
        // Check if the request was successful
        if ($response->successful()) {
            // Get the data from the response
            $ratioData = $response->json();
        } else {
            $ratioData = [];
        }
        return $ratioData;
    }


    //Volatility and Market Risk avg
    public function gtRiskRatiosval($fund_code, $ratioArr)
    {
        $calArr = [];
        foreach ($ratioArr as $key => $dataArr) {
            $dataArr = array_filter($dataArr, fn($value) => !is_null($value) && $value !== '');
            arsort($dataArr);
            //echo '<pre>';
            //print_r($dataArr);
            $final_val_vol = $dataArr[$fund_code];
            $value_vol = (max($dataArr) - min($dataArr)) / 5;
            $value_1_vol = max($dataArr);
            // dd($value_1_vol);
            $value_2_vol = $value_1_vol - $value_vol;
            $value_3_vol = $value_2_vol - $value_vol;
            $value_4_vol = $value_3_vol - $value_vol;
            $value_5_vol = $value_4_vol - $value_vol;
            $value_6_vol = min($dataArr);
            // dd($value_1_vol.'|'.$value_2_vol.'|'.$value_3_vol.'|'.$value_4_vol.'|'.$value_5_vol.'|'.$value_6_vol);
            //print_r($final_val_vol.'||'.$value_1_vol.'|'.$value_2_vol.'|'.$value_3_vol.'|'.$value_4_vol.'|'.$value_5_vol.'|'.$value_6_vol.'<br>');


            //\log::debug('final_val_vol - '.$key, [$fund_code,$dataArr[$fund_code]]);

            if ($final_val_vol >= $value_2_vol && $final_val_vol <= $value_1_vol) {
                $param_vol = 1;
            } elseif ($final_val_vol >= $value_3_vol && $final_val_vol <= $value_2_vol) {
                $param_vol = 2;
            } elseif ($final_val_vol >= $value_4_vol && $final_val_vol <= $value_3_vol) {
                $param_vol = 3;
            } elseif ($final_val_vol >= $value_5_vol && $final_val_vol <= $value_4_vol) {
                $param_vol = 4;
            } elseif ($final_val_vol >= $value_6_vol && $final_val_vol <= $value_5_vol) {
                $param_vol = 5;
            } else {
                $param_vol = 5;
            }
            //\log::debug('param_vol - '.$key, [$fund_code,$param_vol]);

            $calArr[$key] = $param_vol;
        }

        $avgva = array_sum($calArr) / 4;
        // print_r($calArr);
        // print_r($avgva); 
        // return round($avgva);
        // return $avgva;
        if ($avgva <= 5 && $avgva > 4) {
            return 1;
        } elseif ($avgva <= 4 && $avgva > 3) {
            return 2;
        } elseif ($avgva <= 3 && $avgva > 2) {
            return 3;
        } elseif ($avgva <= 2 && $avgva > 1) {
            return 4;
        } elseif ($avgva <= 1 && $avgva > 0) {
            return 5;
        }
    }
    //Return Quality avg
    public function gtReturnQualityval($fund_code, $sdArr)
    {
        $calArr = [];
        foreach ($sdArr as $key => $dataArr) {
            $dataArr = array_filter($dataArr, fn($value) => !is_null($value) && $value !== '');
            arsort($dataArr);
            $value_vol = (max($dataArr) - min($dataArr)) / 5;
            $value_1_vol = min($dataArr);
            $value_2_vol = $value_1_vol + $value_vol;
            $value_3_vol = $value_2_vol + $value_vol;
            $value_4_vol = $value_3_vol + $value_vol;
            $value_5_vol = $value_4_vol + $value_vol;
            $value_6_vol = max($dataArr);

            //\log::debug('values - '.$key, [$value_1_vol,$value_2_vol,$value_3_vol,$value_4_vol,$value_5_vol,$value_6_vol]);

            $final_val_vol = $dataArr[$fund_code];
            //\log::debug('final_val_vol - '.$key, [$fund_code,$dataArr[$fund_code]]);

            if ($final_val_vol >= $value_1_vol && $final_val_vol < $value_2_vol) {
                $param_vol = 1;
            } elseif ($final_val_vol >= $value_2_vol && $final_val_vol < $value_3_vol) {
                $param_vol = 2;
            } elseif ($final_val_vol >= $value_3_vol && $final_val_vol < $value_4_vol) {
                $param_vol = 3;
            } elseif ($final_val_vol >= $value_4_vol && $final_val_vol < $value_5_vol) {
                $param_vol = 4;
            } else {
                $param_vol = 5;
            }
            //\log::debug('param_vol - '.$key, [$fund_code,$param_vol]);

            $calArr[$key] = $param_vol;
        }
        $avgva = array_sum($calArr) / 4;
        // return round($avgva);
        // return $avgva;
        if ($avgva <= 5 && $avgva > 4) {
            return 5;
        } elseif ($avgva <= 4 && $avgva > 3) {
            return 4;
        } elseif ($avgva <= 3 && $avgva > 2) {
            return 3;
        } elseif ($avgva <= 2 && $avgva > 1) {
            return 2;
        } elseif ($avgva <= 1 && $avgva > 0) {
            return 1;
        }
    }
    //***************************** */
    public function fundPerformanceData_(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 18;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;
            //print_r($defDataArr);
            //dd($this->page_path);

            return view($this->page_path . '.fund-performance', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function fundPerformanceData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 18;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;
            //print_r($defDataArr);
            //dd($this->page_path);

            // sayan
            $portfolioData = $returnData = $fund_details_ratios = $dataPoints = [];
            $limit = 10;
            $getdata = $request->all();
            $year = date('Y');
            $month = date("m", strtotime("-1 month"));
            $mth = date("M", strtotime("-1 month"));
            $last_date = date("Y-m-d", strtotime("last day of previous month"));


            $fund_master = FundMaster::where('status', 1)->orderBy('fund_name', 'asc')->get();
            //dd($fund_master);
            if (date("m") <= 01 && $year == date('Y')) {
                $year = $year - 1;
            }

            // $month = 11;
            // $year = 2024;
            // $last_date = '2024-11-30';
            // dd($year,$month);
            $type = !empty($getdata['type']) ? $getdata['type'] : 'return';
            $fund_details_ratios = [];
            $returnData['dataPoints'] = [];



            if (!empty($getdata['fund_code'])) {
                $fund_code = $getdata['fund_code'];
                $fund_detail = FundDetail::where('fund_code', $fund_code)->where('publish', 'y')->orderBy('entry_date', 'DESC')->first();
                $fund_details = FundMaster::where('fund_code', $fund_code)->first();
                if(!empty($fund_details)){
                    $fund_id = $fund_details->fund_id;
                    $indicesName = $fund_details->indices_name;
                    $last_date = FundDetail::getLastPublishedDate($fund_code);
                    //dd($last_date);

                    $query2 = "
                    SELECT * 
                    FROM mpx_indices_detail 
                    WHERE (
                        name = (SELECT corelation FROM mpx_indices_corelation WHERE name = :indicesName1) 
                        OR 
                        name = (SELECT corelation FROM mpx_indices_master WHERE name = :indicesName2)
                    ) 
                    AND publish = 'y' 
                    ORDER BY entry_date DESC 
                    LIMIT 1 ";

                    $results = DB::select($query2, [
                        'indicesName1' => $indicesName,
                        'indicesName2' => $indicesName,
                    ]);
                    $arrayResults = json_decode(json_encode($results), true);
                    $index_detail = $arrayResults[0];
                    $corpus_detail = CorpusEntry::where('fund_code', $fund_details->fund_code)->where('publish', 'y')->orderBy('entry_date', 'DESC')->first();
                    $no_of_schemes = FundMaster::where('fund_type_id', $fund_details->fund_type_id)->count();

                    $fund_details_ratios['benchmark'] = $fund_details->indices_name;
                    $fund_details_ratios['benchmark_closing_value'] = \Arr::get($index_detail, 'closing_value', '');
                    $fund_details_ratios['benchmark_entry_date'] =  date('d-m-Y', strtotime(\Arr::get($index_detail, 'entry_date', '')));
                    $fund_details_ratios['category'] = $fund_details->classification;
                    $fund_details_ratios['fund_house'] = $fund_details->fund_house;
                    $fund_details_ratios['fund_name'] = $fund_details->fund_name;
                    $fund_details_ratios['fund_code'] = $fund_details->fund_code;
                    $fund_details_ratios['fund_opened'] = date('d-m-Y', strtotime($fund_details->fund_opened));
                    $fund_details_ratios['fund_man'] = $fund_details->fund_manager;
                    $fund_details_ratios['nav'] = \Arr::get($fund_detail, 'closing_nav', '');
                    $fund_details_ratios['nav_entry_date'] = date('d-m-Y', strtotime(\Arr::get($fund_detail, 'entry_date', '')));
                    $fund_details_ratios['aaum'] = \Arr::get($corpus_detail, 'corpus_entry', '');
                    $fund_details_ratios['no_of_schemes'] = $no_of_schemes;


                    //dd($fund_details_ratios);
                    
                    $returnData['dataPoints'] = $dataPoints;

                    // For Portfolio
                    if (($type == 'portfolio')) {
                        $query3 = DB::select('CALL sp_fund_search_portfolio("' . $fund_code . '")');
                        $portfolio_array = count($query3) ? $query3[0] : [];
                        $year = $portfolio_array->yearinfo;
                        $month = $portfolio_array->monthinfo;
                        $last_date = CorpusEntry::getLastPublishedDate();
                        $last_date = $year.'-'.$month.'-'. (date("t", strtotime($year . '-' . $month)));

                        //dd($last_date);
                        $mcap_entry = DB::table('mcap_eps')
                            ->select('scrip_name', 'market_cap')
                            ->whereYear('entry_date', $year)
                            ->whereMonth('entry_date', $month)
                            ->orderBy('market_cap', 'DESC')
                            ->get();

                        // dd($mcap_entry);

                        $vlc_scrip_arr = [];
                        $lc_scrip_arr = [];
                        $mc_scrip_arr = [];
                        $sc_scrip_arr = [];

                        $i = 0;
                        foreach ($mcap_entry as $mcap_val) {

                            $i++;

                            if ($i >= 1 && $i <= 15) {

                                array_push($vlc_scrip_arr, $mcap_val->scrip_name);
                            } else if ($i >= 16 && $i <= 100) {
                                array_push($lc_scrip_arr, $mcap_val->scrip_name);
                            } else if ($i >= 101 && $i <= 250) {

                                array_push($mc_scrip_arr, $mcap_val->scrip_name);
                            } else if ($i > 250) {

                                array_push($sc_scrip_arr, $mcap_val->scrip_name);
                            }
                        }

                        
                        //dd($last_date);

                        //dd($portfolio_array);
                        $vlc_val = DB::table('fund_composition')
                            ->select(DB::raw('SUM(content_per) as vlc'))
                            ->where('fund_code', $fund_details->fund_code)
                            ->whereIn('scrip_name', $vlc_scrip_arr)
                            ->whereYear('entry_date', $year)
                            ->whereMonth('entry_date', $month)
                            ->first();

                        $lc_val = DB::table('fund_composition')
                            ->select(DB::raw('SUM(content_per) as lc'))
                            ->where('fund_code', $fund_details->fund_code)
                            ->whereIn('scrip_name', $lc_scrip_arr)
                            ->whereYear('entry_date', $year)
                            ->whereMonth('entry_date', $month)
                            ->first();

                        $mc_val = DB::table('fund_composition')
                            ->select(DB::raw('SUM(content_per) as mc'))
                            ->where('fund_code', $fund_details->fund_code)
                            ->whereIn('scrip_name', $mc_scrip_arr)
                            ->whereYear('entry_date', $year)
                            ->whereMonth('entry_date', $month)
                            ->first();

                        $sc_val = DB::table('fund_composition')
                            ->select(DB::raw('SUM(content_per) as sc'))
                            ->where('fund_code', $fund_details->fund_code)
                            ->whereIn('scrip_name', $sc_scrip_arr)
                            ->whereYear('entry_date', $year)
                            ->whereMonth('entry_date', $month)
                            ->first();

                        // $query = "CALL composition_allocation_snapshot_new('" . $fund_details->fund_type_id . "','" . $fund_details->fund_code . "','" . $month . "','" . $year . "') ";
                        // $val = DB::select($query)[0];
                        // $no_of_script_sql = DB::table('fund_composition')
                        // ->select(DB::raw('count(*) as tot_count'))
                        // ->whereRaw("category = 'Equity' AND entry_date='2024-11-30' AND  fund_code = '" . $fund_code . "'")
                        // ->get();

                        // $no_of_script =$no_of_script_sql[0]->tot_count;
                        // $portfolio_array = array(
                        //     'fund_name' => $val->fund_name,
                        //     'cash'      => $val->cash,
                        //     'sov'       => $val->sov,
                        //     'debt'      => $val->debt,
                        //     'eq_small'  => number_format($sc_val->sc, 2),
                        //     'eq_mid'    => number_format($mc_val->mc, 2),
                        //     'eq_large'  => number_format($lc_val->lc, 2),
                        //     'eq_very_large' => number_format($vlc_val->vlc, 2),
                        //     'others_val'  => $val->others_val,
                        //     'wt_pe'     => $val->wt_pe,
                        //     'monthinfo' => $val->monthinfo,
                        //     'yearinfo'  => $val->yearinfo,
                        //     'no_of_script'  => $no_of_script,
                        // );

                        $portfolio_array->eq_small = number_format($sc_val->sc, 2);
                        $portfolio_array->eq_mid = number_format($mc_val->mc, 2);
                        $portfolio_array->eq_large = number_format($lc_val->lc, 2);
                        $portfolio_array->eq_very_large = number_format($vlc_val->vlc, 2);
                        $portfolioData = $portfolio_array;



                        $total_corpus_entry = DB::table('corpus_entry')
                            ->where('fund_code', $fund_details->fund_code)
                            ->where('entry_date', $last_date)
                            ->select(
                                DB::raw('COALESCE(SUM(corpus_entry) / 100, 1) as total_corpus_entry')
                            )->first()->total_corpus_entry;

                        // dd($total_corpus_entry);

                        $portfolioData->top_scrips = DB::table('view_corpus_with_allocation')
                            ->where('fund_code', $fund_details->fund_code)
                            ->where('corpus_entry_date', $last_date)
                            ->where('composition_entry_date', $last_date)
                            ->where('category', 'Equity')
                            ->select(
                                'scrip_name',
                                'industry',
                                'corpus_entry_date',
                                'composition_entry_date',
                                DB::raw('SUM(calculated_amount/100) as amount'),
                                DB::raw($total_corpus_entry . ' as AUM'),
                                DB::raw('(SUM(calculated_amount/100) / ' . $total_corpus_entry . ') * 100 as content_per')
                            )
                            ->orderBy('content_per', 'desc')
                            ->groupBy('scrip_name')
                            ->limit($limit)
                            ->get();

                        // dd($data['top_scrips']);

                        $portfolioData->top_industries = DB::table('view_corpus_with_allocation')
                            ->where('fund_code', $fund_details->fund_code)
                            ->where('corpus_entry_date', $last_date)
                            ->where('composition_entry_date', $last_date)
                            ->where('category', 'Equity')
                            ->select(
                                'industry',
                                'category',
                                'fund_code',
                                DB::raw($total_corpus_entry . ' as AUM'),
                                DB::raw('SUM(content_per) as allocation'),
                                // DB::raw('SUM(content_per/100) as allocation'),
                                DB::raw('SUM(calculated_amount/100) as amount'),
                                DB::raw('(SUM(calculated_amount/100) / ' . $total_corpus_entry . ') * 100 as content_per')
                            )
                            ->orderBy('content_per', 'desc')
                            ->groupBy('industry')
                            ->limit($limit)
                            ->get();

                        $portfolioData->all_industries = DB::table('view_corpus_with_allocation')
                            ->where('fund_code', $fund_details->fund_code)
                            ->where('corpus_entry_date', $last_date)
                            ->where('composition_entry_date', $last_date)
                            ->where('category', 'Equity')
                            ->select(
                                'industry',
                                'category',
                                'fund_code',
                                DB::raw($total_corpus_entry . ' as AUM'),
                                DB::raw('SUM(content_per) as allocation'),
                                // DB::raw('SUM(content_per/100) as allocation'),
                                DB::raw('SUM(calculated_amount/100) as amount'),
                                DB::raw('(SUM(calculated_amount/100) / ' . $total_corpus_entry . ') * 100 as content_per')
                            )
                            //->orderBy('content_per', 'desc')
                            ->groupBy('industry')
                            //->limit($limit)
                            ->get();
                        //dd($portfolioData);    
                    } elseif (($type == 'ratio')) {

                        //$end_date = CorpusEntry::getLastPublishedDate();
                        //$end_date = '2025-01-24';
                        $end_date = date('Y-m-d', strtotime(\Arr::get($fund_detail, 'entry_date', '')));

                        //dd($end_date);
                        $oneyear_start_date = date('Y-m-d', strtotime('-1 year', strtotime($end_date)));
                        $two_start_date = date('Y-m-d', strtotime('-2 year', strtotime($end_date)));

                        $oneyearjensenalpha = self::jensenalphaApi($fund_code, $oneyear_start_date, $end_date);
                        $twoyearjensenalpha = self::jensenalphaApi($fund_code, $two_start_date, $end_date);
                        $oneyearvolatility = self::stvolatilityApi($fund_code, $oneyear_start_date, $end_date);
                        $twoyearvolatility = self::stvolatilityApi($fund_code, $two_start_date, $end_date);
                        //dd($twoyearvolatility);
                        // $one_year = DB::select('CALL sp_fund_jensenalpha_beta_volatility_2("' . $oneyear_start_date . '","' . $end_date . '","' . $fund_code . '")');
                        // $two_year = DB::select('CALL sp_fund_jensenalpha_beta_volatility_2("' . $two_start_date . '","' . $end_date . '","' . $fund_code . '")');
                        $returnData['one_year'] = $returnData['two_year'] =  [];
                        if (!empty($oneyearjensenalpha)) {
                            $returnData['one_year']['jensen_alpha'] = ($oneyearjensenalpha['jensens_alpha'] != 'N/A') ? $oneyearjensenalpha['jensens_alpha'] : '';
                            $returnData['one_year']['beta'] = ($oneyearjensenalpha['beta'] != 'N/A') ? $oneyearjensenalpha['beta'] : '';
                            $returnData['one_year']['volatility'] = ($oneyearvolatility['volatility'] != 'N/A') ? $oneyearvolatility['volatility'] : '';
                            $returnData['one_year']['end_date'] = $end_date;
                        }
                        if (!empty($twoyearjensenalpha)) {
                            $returnData['two_year']['jensen_alpha'] = ($twoyearjensenalpha['jensens_alpha']!='N/A')?$twoyearjensenalpha['jensens_alpha']:'';
                            $returnData['two_year']['beta'] = ($twoyearjensenalpha['beta'] != 'N/A') ? $twoyearjensenalpha['beta'] : '';
                            $returnData['two_year']['volatility'] = ($twoyearvolatility['volatility'] != 'N/A') ? $twoyearvolatility['volatility'] : '';
                        }


                        //dd($returnData);




                        $last_aaum = DB::select("SELECT DATE_FORMAT(entry_date, '%d-%m-%Y') AS entry_date , corpus_entry FROM mpx_corpus_entry WHERE entry_date = (SELECT entry_date from mpx_corpus_entry WHERE fund_code = '" . $fund_code . "' AND publish = 'y' ORDER BY entry_date DESC LIMIT 1) AND fund_code = '" . $fund_code . "'");
                        $returnData['last_aaum'] = count($last_aaum) ? $last_aaum[0] : [];

                        $f_aaum = DB::select("SELECT DATE_FORMAT(entry_date, '%d-%m-%Y') AS entry_date , corpus_entry FROM mpx_corpus_entry WHERE entry_date = (SELECT entry_date from mpx_corpus_entry WHERE fund_code = '" . $fund_code . "' AND publish = 'y' ORDER BY entry_date DESC LIMIT 3,1) AND fund_code = '" . $fund_code . "'");
                        $returnData['f_aaum'] = count($f_aaum) ? $f_aaum[0] : [];

                        $s_aaum = DB::select("SELECT DATE_FORMAT(entry_date, '%d-%m-%Y') AS entry_date , corpus_entry FROM mpx_corpus_entry WHERE entry_date = (SELECT entry_date from mpx_corpus_entry WHERE fund_code = '" . $fund_code . "' AND publish = 'y' ORDER BY entry_date DESC LIMIT 6,1) AND fund_code = '" . $fund_code . "'");
                        $returnData['s_aaum'] = count($s_aaum) ? $s_aaum[0] : [];

                        $t_aaum = DB::select("SELECT DATE_FORMAT(entry_date, '%d-%m-%Y') AS entry_date , corpus_entry FROM mpx_corpus_entry WHERE entry_date = (SELECT entry_date from mpx_corpus_entry WHERE fund_code = '" . $fund_code . "' AND publish = 'y' ORDER BY entry_date DESC LIMIT 9, 1) AND fund_code = '" . $fund_code . "'");
                        $returnData['t_aaum'] = count($t_aaum) ? $t_aaum[0] : [];
                        //dd($returnData);

                    } else {
                        //dd($last_date);
                        $last_date = date('Y-m-d', strtotime(\Arr::get($fund_detail, 'entry_date', '')));
                        $return_scheme = DB::select('CALL sp_fund_search_scheme_ret("' . $last_date . '","' . $fund_details->fund_code . '")');
                        $returnData['return_scheme'] = $return_scheme[0];
                        //dd($returnData);

                        
                        //********************Scheme NAV Chart****************** */

                        $start_date = date('Y-m-d', strtotime($last_date . ' - 1 year'));
                        $fund_index_currencyArr = DB::select('CALL sp_fund_index_currency("GRAPH_FUND","' . $start_date . '","' . $last_date . '",0,"' . $fund_code . '","","",0)');
                        //dd($fund_index_currencyArr);
                        if (!empty($fund_index_currencyArr)) {
                            foreach ($fund_index_currencyArr as $key_c => $fund_index_currency) {
                                $dataPoints[$key_c]['y'] = $fund_index_currency->VALUE;
                                $dataPoints[$key_c]['label'] = $fund_index_currency->DATE;
                            }
                        }
                        $returnData['dataPoints'] = $dataPoints;
                        //*******************************TO CATEGORY************************************** */
                        if (($type == 'return')) {
                        
                            $seven_days_fund_returns = $thirty_days_fund_returns = $ninety_days_fund_returns = $sixmonths_fund_returns = $oneyear_fund_returns = $twoyear_fund_returns = $threeyear_fund_returns = $fiveyear_fund_returns = [];
                            $sp_quick_return_ration_new = DB::select('CALL sp_quick_return_ration_new2("' . $last_date . '",' . $fund_details->fund_type_id . ')');
                            //dd($sp_quick_return_ration_new);
                            foreach ($sp_quick_return_ration_new as $fundId => $fundValue) {

                                //dd($fundValue);
                                $seven_days = '7DAYS';
                                $thirty_days = '30DAYS';
                                $ninety_days = '90DAYS';
                                $sixmonths = 'sixmonths';
                                $oneyear = 'oneyear';
                                $twoyear = 'twoyear';
                                $threeyear = 'threeyear';
                                $fiveyear = 'fiveyear';

                                if($fundValue->$seven_days!='N/A'){
                                    $seven_days_fund_returns[$fundValue->fund_id] = $fundValue->$seven_days;
                                }
                                if ($fundValue->$thirty_days != 'N/A') {
                                    $thirty_days_fund_returns[$fundValue->fund_id] = $fundValue->$thirty_days;
                                }
                                if ($fundValue->$ninety_days != 'N/A') {
                                    $ninety_days_fund_returns[$fundValue->fund_id] = $fundValue->$ninety_days;
                                }
                                if ($fundValue->$sixmonths != 'N/A') {
                                    $sixmonths_fund_returns[$fundValue->fund_id] = $fundValue->$sixmonths;
                                }
                                if ($fundValue->$oneyear != 'N/A') {
                                    $oneyear_fund_returns[$fundValue->fund_id] = $fundValue->$oneyear;
                                }
                                if ($fundValue->$twoyear != 'N/A') {
                                    $twoyear_fund_returns[$fundValue->fund_id] = $fundValue->$twoyear;
                                }
                                if ($fundValue->$threeyear != 'N/A') {
                                    $threeyear_fund_returns[$fundValue->fund_id] = $fundValue->$threeyear;
                                }
                                if ($fundValue->$fiveyear != 'N/A') {
                                    $fiveyear_fund_returns[$fundValue->fund_id] = $fundValue->$fiveyear;
                                }

                                //dd($fundValue->$sevenDAYS);
                            }
                            //dd($fiveyear_fund_returns);
                            //dd($fiveyear_fund_returns);

                            $dataArr6['SEVENDAYS'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 7 days')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_details->fund_type_id . '")');
                            if(!empty($seven_days_fund_returns[$fund_details->fund_id])){
                                $decile = self::decile_calc($seven_days_fund_returns, $fund_details->fund_id);
                                $quartile = self::quartile_calc($seven_days_fund_returns, $fund_details->fund_id);
                                $dataArr6['SEVENDAYS'][0]->decile = $decile;
                                $dataArr6['SEVENDAYS'][0]->quartile = $quartile;
                            }
                        
                            //dd($dataArr6['SEVENDAYS']);

                            $dataArr6['THIRTYDAYS'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 30 days')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_details->fund_type_id . '")');
                            if (!empty($thirty_days_fund_returns[$fund_details->fund_id])) {
                                $decile = self::decile_calc($thirty_days_fund_returns, $fund_details->fund_id);
                                $quartile = self::quartile_calc($thirty_days_fund_returns, $fund_details->fund_id);
                                $dataArr6['THIRTYDAYS'][0]->decile = $decile;
                                $dataArr6['THIRTYDAYS'][0]->quartile = $quartile;
                            }
                            //dd($dataArr6['THIRTYDAYS']);
                            

                            $dataArr6['NINTYDAYS'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 3 months')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_details->fund_type_id . '")');
                            if (!empty($ninety_days_fund_returns[$fund_details->fund_id])) {
                                $decile = self::decile_calc($ninety_days_fund_returns, $fund_details->fund_id);
                                $quartile = self::quartile_calc($ninety_days_fund_returns, $fund_details->fund_id);
                                $dataArr6['NINTYDAYS'][0]->decile = $decile;
                                $dataArr6['NINTYDAYS'][0]->quartile = $quartile;
                            }
                            

                            $dataArr6['SIXMONTHS'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 6 months')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_details->fund_type_id . '")');
                            if (!empty($sixmonths_fund_returns[$fund_details->fund_id])) {
                                $decile = self::decile_calc($sixmonths_fund_returns, $fund_details->fund_id);
                                $quartile = self::quartile_calc($sixmonths_fund_returns, $fund_details->fund_id);
                                $dataArr6['SIXMONTHS'][0]->decile = $decile;
                                $dataArr6['SIXMONTHS'][0]->quartile = $quartile;
                            }
                        

                            $dataArr6['ONEYEAR'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 1 year')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_details->fund_type_id . '")');
                            if (!empty($oneyear_fund_returns[$fund_details->fund_id])) {
                                $decile = self::decile_calc($oneyear_fund_returns, $fund_details->fund_id);
                                $quartile = self::quartile_calc($oneyear_fund_returns, $fund_details->fund_id);
                                $dataArr6['ONEYEAR'][0]->decile = $decile;
                                $dataArr6['ONEYEAR'][0]->quartile = $quartile;
                            }
                        


                            $dataArr6['TWOYEAR'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 2 year')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_details->fund_type_id . '")');
                            if (!empty($twoyear_fund_returns[$fund_details->fund_id])) {
                                $decile = self::decile_calc($twoyear_fund_returns, $fund_details->fund_id);
                                $quartile = self::quartile_calc($twoyear_fund_returns, $fund_details->fund_id);
                                $dataArr6['TWOYEAR'][0]->decile = $decile;
                                $dataArr6['TWOYEAR'][0]->quartile = $quartile;
                            }
                            

                            $dataArr6['THREEYEAR'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 3 year')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_details->fund_type_id . '")');
                            if (!empty($threeyear_fund_returns[$fund_details->fund_id])) {
                                $decile = self::decile_calc($threeyear_fund_returns, $fund_details->fund_id);
                                $quartile = self::quartile_calc($threeyear_fund_returns, $fund_details->fund_id);
                                $dataArr6['THREEYEAR'][0]->decile = $decile;
                                $dataArr6['THREEYEAR'][0]->quartile = $quartile;
                            }
                        

                            $dataArr6['FIVEYEAR'] = DB::select('CALL sp_get_cagr_quartile_decile("' . date('Y-m-d', strtotime($last_date . ' - 5 year')) . '","' . $last_date . '","' . $fund_code . '","' . $fund_details->fund_type_id . '")');
                            if (!empty($fiveyear_fund_returns[$fund_details->fund_id])) {
                                
                                $decile = self::decile_calc($fiveyear_fund_returns, $fund_details->fund_id);
                                $quartile = self::quartile_calc($fiveyear_fund_returns, $fund_details->fund_id);
                                $dataArr6['FIVEYEAR'][0]->decile = $decile;
                                $dataArr6['FIVEYEAR'][0]->quartile = $quartile;
                            }
                            //dd($dataArr6);
                            $category_compare_data = [];
                            $i = 0;
                            $fund_nameld = "";
                            $fund_name = "";
                            $leadername = "";
                            $laggername = "";
                            $fund_nameldc = "";
                            $fund_name1 = "";
                            foreach ($dataArr6 as $key => $data) {
                                if (count($data)) {
                                    $category_compare_data[$key] = $data[0];
                                    if (!empty($data[0]->leader_fund_code)) {
                                        $leader_fund_code = DB::table('fund_master')->select("fund_name")->where("fund_code", $data[0]->leader_fund_code)->get();
                                        //dd($leader_fund_code);
                                        $leader_fund_name = $leader_fund_code[0]->fund_name;
                                        $category_compare_data[$key]->leader_fund_name = $leader_fund_name;
                                    }
                                    if (!empty($data[0]->laggard_fund_code)) {
                                        $laggard_fund_code = DB::table('fund_master')->select("fund_name")->where("fund_code", $data[0]->laggard_fund_code)->get();
                                        //dd($laggard_fund_code);
                                        $laggard_fund_name = $laggard_fund_code[0]->fund_name;
                                        $category_compare_data[$key]->laggard_fund_name = $laggard_fund_name;
                                    }
                                    /*switch ($key) {
                                        case 'SEVENDAYS':
                                            $start = date('Y-m-d', strtotime($last_date . ' - 7 days'));
                                            break;
                                        case 'THIRTYDAYS':
                                            $start = date('Y-m-d', strtotime($last_date . ' - 30 days'));
                                            break;
                                        case 'NINTYDAYS':
                                            $start = date('Y-m-d', strtotime($last_date . ' - 3 months'));
                                            break;
                                        case 'SIXMONTHS':
                                            $start = date('Y-m-d', strtotime($last_date . ' - 6 months'));
                                            break;
                                        case 'ONEYEAR':
                                            $start = date('Y-m-d', strtotime($last_date . ' - 1 year'));
                                            break;
                                        case 'TWOYEAR':
                                            $start = date('Y-m-d', strtotime($last_date . ' - 2 year'));
                                            break;
                                        case 'THREEYEAR':
                                            $start = date('Y-m-d', strtotime($last_date . ' - 3 year'));
                                            break;
                                        case 'FIVEYEAR':
                                            $start = date('Y-m-d', strtotime($last_date . ' - 5 year'));
                                            break;
                                    }
                                    $leader = number_format((float)$data[0]->leader, 2, '.');
                                    $conditions = [
                                        ["cagr_value", 'LIKE', "%{$leader}%"],
                                        ["fund_type_id", '=', $fund_details->fund_type_id],
                                        ["start_date", '=', $start]
                                    ];
                                    $fund_name = DB::table('cagrs')->select("fund_code")->where($conditions)->get();
                                    if (!$fund_name->isEmpty()) {
                                        $leaderfc = $fund_name[0]->fund_code;
                                        $fund_nameld = DB::table('fund_master')->select("fund_name")->where("fund_code", $leaderfc)->get();
                                    }
                                    if ($fund_nameld != "") {
                                        $leadername = $fund_nameld[0]->fund_name;
                                    }
                                    $lagger = number_format((float)$data[0]->laggard, 2, '.');
                                    $conditions1 = [
                                        ["cagr_value", 'LIKE', "%{$lagger}%"],
                                        ["fund_type_id", '=', $fund_details->fund_type_id],
                                        ["start_date", '=', $start]
                                    ];
                                    $fund_name1 = DB::table('cagrs')->select("fund_code")->where($conditions1)->get();
                                    if (!$fund_name1->isEmpty()) {
                                        $laggerfc = $fund_name1[0]->fund_code;
                                        $fund_nameldc = DB::table('fund_master')->select("fund_name")->where("fund_code", 'LIKE', "%{$laggerfc}%")->get();
                                    }
                                    if ($fund_nameldc != "") {
                                        $laggername = $fund_nameldc[0]->fund_name;
                                    }
                                    $category_compare_data[$key] = $data[0];
                                    if ($leadername) {
                                        $category_compare_data[$key . "" . $i] = $leadername;
                                    }
                                    if ($laggername) {
                                        $category_compare_data[$key . "" . $i . "c"] = $laggername;
                                    }*/
                                } else {
                                    $category_compare_data[$key] = [];
                                }
                                $i++;
                            }
                            //dd($category_compare_data);
                            $returnData['category_compare_data'] = $category_compare_data;
                        } else {
                            //dd($last_date .'---'.$indicesName);
                            $return_benchmark = DB::select('CALL sp_fund_search_benchmark_ret_new("' . $last_date . '","' . $indicesName . '","' .  $fund_details->fund_code . '")');
                            $returnData['return_benchmark'] = $return_benchmark[0];
                            //dd($return_benchmark);
                            //****scheme_high_low***** */
                            $fund_search_scheme_high_lowArr['SEVENDAYS'] = DB::select('CALL Sp_fund_search_scheme_high_low("' . $last_date . '","' . $fund_code . '",7)');
                            $fund_search_scheme_high_lowArr['THIRTYDAYS'] = DB::select('CALL Sp_fund_search_scheme_high_low("' . $last_date . '","' . $fund_code . '",30)');
                            $fund_search_scheme_high_lowArr['NINTYDAYS'] = DB::select('CALL Sp_fund_search_scheme_high_low("' . $last_date . '","' . $fund_code . '",90)');
                            $fund_search_scheme_high_lowArr['SIXMONTHS'] = DB::select('CALL Sp_fund_search_scheme_high_low("' . $last_date . '","' . $fund_code . '",180)');
                            $fund_search_scheme_high_lowArr['ONEYEAR'] = DB::select('CALL Sp_fund_search_scheme_high_low("' . $last_date . '","' . $fund_code . '",365)');
                            $fund_search_scheme_high_lowArr['TWOYEAR'] = DB::select('CALL Sp_fund_search_scheme_high_low("' . $last_date . '","' . $fund_code . '",730)');
                            $fund_search_scheme_high_lowArr['THREEYEAR'] = DB::select('CALL Sp_fund_search_scheme_high_low("' . $last_date . '","' . $fund_code . '",1095)');
                            $fund_search_scheme_high_lowArr['FIVEYEAR'] = DB::select('CALL Sp_fund_search_scheme_high_low("' . $last_date . '","' . $fund_code . '",1825)');

                            $scheme_high_low_data = [];
                            foreach ($fund_search_scheme_high_lowArr as $key => $data3) {
                                if (count($data3)) {
                                    $scheme_high_low_data[$key] = $data3[0];
                                } else {
                                    $scheme_high_low_data[$key] = [];
                                }
                            }
                            $returnData['scheme_high_low_data'] = $scheme_high_low_data;
                            //dd($scheme_high_low_data);

                            //***********benchmark_high_low***************** */
                            $fund_search_ben_high_lowArr['SEVENDAYS'] = DB::select('CALL sp_fund_search_ben_high_low("' . $last_date . '","' . $indicesName . '",7)');
                            $fund_search_ben_high_lowArr['THIRTYDAYS'] = DB::select('CALL sp_fund_search_ben_high_low("' . $last_date . '","' . $indicesName . '",30)');
                            $fund_search_ben_high_lowArr['NINTYDAYS'] = DB::select('CALL sp_fund_search_ben_high_low("' . $last_date . '","' . $indicesName . '",90)');
                            $fund_search_ben_high_lowArr['SIXMONTHS'] = DB::select('CALL sp_fund_search_ben_high_low("' . $last_date . '","' . $indicesName . '",180)');
                            $fund_search_ben_high_lowArr['ONEYEAR'] = DB::select('CALL sp_fund_search_ben_high_low("' . $last_date . '","' . $indicesName . '",365)');
                            $fund_search_ben_high_lowArr['TWOYEAR'] = DB::select('CALL sp_fund_search_ben_high_low("' . $last_date . '","' . $indicesName . '",730)');
                            $fund_search_ben_high_lowArr['THREEYEAR'] = DB::select('CALL sp_fund_search_ben_high_low("' . $last_date . '","' . $indicesName . '",1095)');
                            $fund_search_ben_high_lowArr['FIVEYEAR'] = DB::select('CALL sp_fund_search_ben_high_low("' . $last_date . '","' . $indicesName . '",1825)');

                            $benchmark_high_low_data = [];
                            foreach ($fund_search_ben_high_lowArr as $key => $data4) {
                                if (count($data4)) {
                                    $benchmark_high_low_data[$key] = $data4[0];
                                } else {
                                    $benchmark_high_low_data[$key] = [];
                                }
                            }
                            $returnData['benchmark_high_low_data'] = $benchmark_high_low_data;
                            //dd($benchmark_high_low_data);


                        }
                        //********************************************************************* */




                        //dd($returnData);
                    }

                }
            }

            return view($this->page_path . '.fund-performance-new', compact('defDataArr', 'dataArr', 'portfolioData', 'returnData', 'fund_master', 'request', 'fund_details_ratios', 'type'));
        }
        return abort(404);
    }
    public static function all_returns_by_fund_type($fund_type_id, $start_date, $end_date)
    {
        $all_funds = FundMaster::where('fund_type_id', $fund_type_id)->get();
        $all_fund_all_return = [];
        foreach ($all_funds as $fund) {
            $individual_fund_code = $fund->fund_code;
            $individual_fund_return = self::jensenalphaApi($individual_fund_code, $start_date, $end_date);
            // array_push($all_fund_all_return, $individual_fund_return);
            $all_fund_all_return[$fund->fund_id] = $individual_fund_return;
        }
        return $all_fund_all_return;
    }
    public static function quartile_calc($fund_returns, $fundID)
    {
        $numeric_fund_returns = array_filter($fund_returns, function ($value) {
            return is_numeric($value);
        });

        sort($numeric_fund_returns);
        // dd($numeric_fund_returns);

        // $tolerance = 0.0000001;

        $leader = max($numeric_fund_returns);
        // $leader = 8.08;
        // dd($max_fund_return_val);
        $laggard = min($numeric_fund_returns);
        // $laggard = 8.03;
        // dd($min_fund_return_val);
        $leader = number_format($leader, 2);
        $laggard = number_format($laggard, 2);

        $class_interval = $leader - $laggard;
        // dd($class_interval);
        $class_interval = number_format($class_interval, 2);

        $quartile_interval = ($class_interval / 4);
        // dd($quartile_interval);
        $interval_4th = $leader - $quartile_interval;
        // dd($interval_4th);
        $interval_3rd = $interval_4th - $quartile_interval;
        // dd($interval_3rd);
        $interval_2nd = $interval_3rd  - $quartile_interval;
        // dd($interval_2nd);
        $interval_1st = $interval_2nd - $quartile_interval;

        $fund_type_quartile_array = [];
        $params['leader'] = $leader;
        $params['laggard'] = $laggard;
        $params['interval_4th'] = $interval_4th;
        $params['interval_3rd'] = $interval_3rd;
        $params['interval_2nd'] = $interval_2nd;
        $params['interval_1st'] = $interval_1st;
        $params['report_type'] = 'returns';
        $params['selected_fund_return'] = $fund_returns[$fundID];

        $selected_fund_return = number_format(floatval($params['selected_fund_return']), 2);
        // $selected_fund_return = 3.0181409536041;
        // $leader = $params['leader'];
        $leader =  $params['leader'];
        $laggard = $params['laggard'];
        // dd($laggard);
        $interval_4th = number_format($params['interval_4th'], 2);
        $interval_3rd = number_format($params['interval_3rd'], 2);
        $interval_2nd = number_format($params['interval_2nd'], 2);
        // $interval_2nd = 3.1920756346725;
        $interval_1st = number_format($params['interval_1st'], 2);
        // $interval_1st = 3.0181409536041;

        // echo $interval_1st.'-------------'.$selected_fund_return."-------------|".$interval_2nd;
        $quartile = null;
        /*if($selected_fund_return > $interval_4th && $selected_fund_return <= $leader){
            $quartile = 4;
        }elseif($selected_fund_return > $interval_3rd && $selected_fund_return <= $interval_4th){
            $quartile = 3;
        }elseif($selected_fund_return > $interval_2nd && $selected_fund_return <= $interval_3rd){
            $quartile = 2;
        }elseif($selected_fund_return >= $interval_1st && $selected_fund_return <= $interval_2nd){
            $quartile = 1;
        }else{
            $quartile = 0;
        }*/
        $tolerance = 0.0000001;

        $report_type = $params['report_type'];

        $risk_ratio_array = ['beta', 'volatility', 'tracking_error'];

        if (in_array($report_type, $risk_ratio_array)) {

            if ($selected_fund_return >= $interval_4th  && $selected_fund_return <= $leader) {
                $quartile = 1;
            } elseif ($selected_fund_return >= $interval_3rd  && $selected_fund_return <= $interval_4th) {
                $quartile = 2;
            } elseif ($selected_fund_return >= $interval_2nd  && $selected_fund_return <= $interval_3rd) {
                $quartile = 3;
            } elseif ($selected_fund_return >= $interval_1st  && $selected_fund_return <= $interval_2nd) {
                $quartile = 4;
            } else {
                $quartile = '';
            }
        } else {
            if ($selected_fund_return >= $interval_4th  && $selected_fund_return <= $leader) {
                $quartile = 4;
            } elseif ($selected_fund_return >= $interval_3rd  && $selected_fund_return <= $interval_4th) {
                $quartile = 3;
            } elseif ($selected_fund_return >= $interval_2nd  && $selected_fund_return <= $interval_3rd) {
                $quartile = 2;
            } elseif ($selected_fund_return >= $interval_1st  && $selected_fund_return <= $interval_2nd) {
                $quartile = 1;
            } else {
                $quartile = '';
            }
        }



        // dd($quartile);

        return $quartile;
    }
    public static function decile_calc($fund_returns, $fundID)
    {
        //echo '<pre>';print_r($fund_returns);
        $numeric_fund_returns = array_filter($fund_returns, function ($value) {
            return is_numeric($value);
        });

        sort($numeric_fund_returns);

        $leader = max($numeric_fund_returns);
        // $leader = 8.08;
        // dd($max_fund_return_val);
        $laggard = min($numeric_fund_returns);
        // $laggard = 8.03;
        // dd($min_fund_return_val);

        $leader = number_format($leader, 2);
        $laggard = number_format($laggard, 2);

        $class_interval = $leader - $laggard;
        // dd($class_interval);
        $decile_interval = ($class_interval / 10);

        // $decile_interval = number_format($decile_interval,2);

        // dd($leader,$laggard,$decile_interval);
        $interval_10th = $leader - $decile_interval;
        // dd($interval_4th);
        $interval_9th = $interval_10th - $decile_interval;
        // dd($interval_3rd);
        $interval_8th = $interval_9th - $decile_interval;
        // dd($interval_2nd);
        $interval_7th = $interval_8th - $decile_interval;
        $interval_6th = $interval_7th - $decile_interval;
        $interval_5th = $interval_6th - $decile_interval;
        $interval_4th = $interval_5th - $decile_interval;
        $interval_3rd = $interval_4th - $decile_interval;
        $interval_2nd = $interval_3rd - $decile_interval;
        $interval_1st = $interval_2nd - $decile_interval;

        //dd($fund_returns[1493]);
        $selected_fund_return2 =  $fund_returns[$fundID];
        //dd($selected_fund_return2);

        $params['leader'] = $leader;
        $params['laggard'] = $laggard;
        $params['interval_10th'] = $interval_10th;
        $params['interval_9th'] = $interval_9th;
        $params['interval_8th'] = $interval_8th;
        $params['interval_7th'] = $interval_7th;
        $params['interval_6th'] = $interval_6th;
        $params['interval_5th'] = $interval_5th;
        $params['interval_4th'] = $interval_4th;
        $params['interval_3rd'] = $interval_3rd;
        $params['interval_2nd'] = $interval_2nd;
        $params['interval_1st'] = $interval_1st;
        $params['report_type'] = 'returns';
        $params['selected_fund_return'] = $selected_fund_return2;
        $params['fund_id'] = $fundID;
        //$decile = self::decile_calc($params);

        $selected_fund_return = number_format(floatval($params['selected_fund_return']), 2);

        // $selected_fund_return = $params['selected_fund_return'];
        $leader =  $params['leader'];
        $laggard = $params['laggard'];
        // dd($laggard);
        $interval_10th = number_format($params['interval_10th'], 2);
        $interval_9th = number_format($params['interval_9th'], 2);
        $interval_8th = number_format($params['interval_8th'], 2);
        $interval_7th = number_format($params['interval_7th'], 2);
        $interval_6th = number_format($params['interval_6th'], 2);
        $interval_5th = number_format($params['interval_5th'], 2);
        $interval_4th = number_format($params['interval_4th'], 2);
        $interval_3rd = number_format($params['interval_3rd'], 2);
        $interval_2nd = number_format($params['interval_2nd'], 2);
        $interval_1st = number_format($params['interval_1st'], 2);


        // echo $interval_1st.'-------------'.$selected_fund_return."-------------|".$interval_2nd;
        $decile = null;

        // if($params['fund_id'] == 80){

        //     dd($selected_fund_return,$params,$interval_10th,$interval_9th,$interval_8th,$interval_7th,$interval_6th,$interval_5th,$interval_4th,$interval_3rd,$interval_2nd,$interval_1st);

        // }
        $report_type = $params['report_type'];


        $risk_ratio_array = ['beta', 'volatility', 'tracking_error'];

        $tolerance = 0.0000001;

        if (in_array($report_type, $risk_ratio_array)) {

            if ($selected_fund_return >= $interval_10th  && $selected_fund_return <= $leader) {
                $decile = 1;
            } elseif ($selected_fund_return >= $interval_9th  && $selected_fund_return <= $interval_10th) {
                $decile = 2;
            } elseif ($selected_fund_return >= $interval_8th  && $selected_fund_return <= $interval_9th) {
                $decile = 3;
            } elseif ($selected_fund_return >= $interval_7th  && $selected_fund_return <= $interval_8th) {
                $decile = 4;
            } elseif ($selected_fund_return >= $interval_6th  && $selected_fund_return <= $interval_7th) {
                $decile = 5;
            } elseif ($selected_fund_return >= $interval_5th  && $selected_fund_return <= $interval_6th) {
                $decile = 6;
            } elseif ($selected_fund_return >= $interval_4th  && $selected_fund_return <= $interval_5th) {
                $decile = 7;
            } elseif ($selected_fund_return >= $interval_3rd  && $selected_fund_return <= $interval_4th) {
                $decile = 8;
            } elseif ($selected_fund_return >= $interval_2nd  && $selected_fund_return <= $interval_3rd) {
                $decile = 9;
            } elseif ($selected_fund_return >= $interval_1st  && $selected_fund_return <= $interval_2nd) {
                $decile = 10;
            } else {
                $decile = '';
            }
        } else {

            if ($selected_fund_return >= $interval_10th  && $selected_fund_return <= $leader) {
                $decile = 10;
            } elseif ($selected_fund_return >= $interval_9th  && $selected_fund_return <= $interval_10th) {
                $decile = 9;
            } elseif ($selected_fund_return >= $interval_8th  && $selected_fund_return <= $interval_9th) {
                $decile = 8;
            } elseif ($selected_fund_return >= $interval_7th  && $selected_fund_return <= $interval_8th) {
                $decile = 7;
            } elseif ($selected_fund_return >= $interval_6th  && $selected_fund_return <= $interval_7th) {
                $decile = 6;
            } elseif ($selected_fund_return >= $interval_5th  && $selected_fund_return <= $interval_6th) {
                $decile = 5;
            } elseif ($selected_fund_return >= $interval_4th  && $selected_fund_return <= $interval_5th) {
                $decile = 4;
            } elseif ($selected_fund_return >= $interval_3rd  && $selected_fund_return <= $interval_4th) {
                $decile = 3;
            } elseif ($selected_fund_return >= $interval_2nd  && $selected_fund_return <= $interval_3rd) {
                $decile = 2;
            } elseif ($selected_fund_return >= $interval_1st  && $selected_fund_return <= $interval_2nd) {
                $decile = 1;
            } else {
                $decile = '';
            }
        }





        return $decile;
    }


    public function compareSchemeData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 19;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path . '.compare-scheme', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function performanceSnapshotData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 20;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        //dd($dataArr);
        $dataArr['title'] = 'Category Performance Snapshot';
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;
            //dd($this->page_path);


            //sayan.
            $responseArr = $dataArr2 = $request_fund_type = [];
            $all_fund_types = FundType::where('active_passive', 'A')->get();
            if (isset($request->fund_type_id)) {
                $request_fund_type = FundType::where('ft_id', $request->fund_type_id)->first();
            }

            $type = (isset($request->type) && $request->type) ? $request->type : '';
            $type_id = isset($request->fund_type_id) ? $request->fund_type_id : '';
            $report_category = isset($request->report_category) ? $request->report_category : '';
            $date = (isset($request->date) && $request->date) ? date('Y-m-d', strtotime(urldecode($request->date))) : '';
            $responseArr['type'] = $type;
            if (!empty($type) && !empty($type_id) && !empty($report_category) && !empty($date)) {

                // $Latest_corpus_entry_date='2024-03-31';
                // $last_aaum =  DB::select("SELECT `entry_date` FROM `mpx_corpus_entry` WHERE fund_code IN (SELECT fund_code FROM mpx_fund_master WHERE fund_type_id = $type_id) ORDER BY `entry_date` DESC LIMIT 0,1;");
                // $last_aaum_date = $last_aaum[0]->entry_date;

                // dd($last_aaum_date);
                $corpusdate = $date = date('Y-m-d', strtotime($date . ' -1 day'));
                $corpusdate = Carbon::createFromFormat('Y-m-d', trim($corpusdate));

                //dd($date);
                // Get the current date
                $currentDate = Carbon::now();

                if ($corpusdate->isCurrentMonth()) {
                    // If the given date is in the current month, return the last date of the previous month
                    $final_corpus_date =  $currentDate->subMonthNoOverflow()->endOfMonth()->format('Y-m-d');
                } else {
                    // If the given date is in a previous month, return the last date of that month
                    $final_corpus_date =  $corpusdate->endOfMonth()->format('Y-m-d');
                }

                // $last_aaum_date = '2023-03-31';
                // dd($last_aaum_date);
                if ($type == 'weekly') {
                    if ($report_category == 'return') {                        
                        //$dataArr2 = DB::select('CALL sp_weekly_funds_test(' . $type_id . ',"' . $date . '")');
                        $dataArr2 = DB::select('CALL sp_weekly_funds_new(' . $type_id . ',"' . $date . '")');
                    }
                    if ($report_category == 'indices') {
                        $dataArr2 = DB::select('CALL sp_weekly_indices("' . $date . '",' . $type_id . ')');
                    }
                    if ($report_category == 'return_less_index') {
                        $dataArr2 = self::return_less_index($type_id, $date, 'weekly');
                        // $dataArr2 = DB::select('CALL sp_weekly_return_less_index("' . $date . '",' . $type_id . ')');
                    }
                }
                if ($type == 'monthly') {
                    if ($report_category == 'return') {
                        // $dataArr2 = DB::select('CALL sp_monthly_funds("'.$date.'",'.$type_id.')');
                        // $dataArr2 = DB::select('CALL sp_quick_return_ration("' . $date . '",' . $type_id . ')');
                        $dataArr2 = DB::select('CALL sp_quick_return_ration_test("' . $date . '",' . $type_id . ')');
                        
                    }
                    if ($report_category == 'indices') {
                        // dd('CALL sp_monthly_indices("'.$date.'",'.$type_id.')');
                        $dataArr2 = DB::select('CALL sp_monthly_indices("' . $date . '",' . $type_id . ')');
                    }
                    if ($report_category == 'return_less_index') {
                        $dataArr2 = self::return_less_index($type_id, $date, 'monthly');
                        // $dataArr2 = DB::select('CALL sp_monthly_return_less_index("' . $date . '",' . $type_id . ')');
                    }
                    if ($report_category == 'corpus_change') {
                        $dataArr2 = DB::select('CALL sp_monthly_corpus_change("' . $final_corpus_date . '",' . $type_id . ')');
                    }
                }

                //dd($dataArr2);
                if (count($dataArr2)) {

                    $responseArr['snapshot_data'] = $dataArr2;
                    $responseArr['type'] = $type;
                    $responseArr['test'] = $type_id;
                    if ($report_category == 'corpus_change') {
                        $responseArr['aaum_date'] = $final_corpus_date;
                    }
                    // dd($responseArr);
                    // $data['responseArr'] = $responseArr;
                    // return $this->sendResponse($responseArr, __('api.success.api_dt_rtrv'));
                }
            }



            return view($this->page_path . '.performance-snapshot', compact('defDataArr', 'dataArr', 'all_fund_types', 'request', 'responseArr', 'request_fund_type'));
        }
        return abort(404);
    }

    /*================================================*/

    function return_less_index($fund_type_id, $date, $type)
    {
        $fund_codes = FundMaster::where('fund_type_id', $fund_type_id)->select('fund_code')->get()->pluck('fund_code')->toArray();

        $indices = FundMaster::where('fund_type_id', $fund_type_id)->select('indices_name')->groupBy('indices_name')->get()->pluck('indices_name')->toArray();

        $mergedResults = [];

        if ($type == 'monthly') {

            // $sixMonthsAgo = date('Y-m-d', strtotime('-6 months +1 day', strtotime($date)));
            // $oneYearAgo = date('Y-m-d', strtotime('-1 year +1 day', strtotime($date)));
            // $twoYearsAgo = date('Y-m-d', strtotime('-2 year +1 day', strtotime($date)));
            // $threeYearsAgo = date('Y-m-d', strtotime('-3 year +1 day', strtotime($date)));

            $sixMonthsAgo = date('Y-m-d', strtotime('-6 months', strtotime($date)));
            $oneYearAgo = date('Y-m-d', strtotime('-1 year', strtotime($date)));
            $twoYearsAgo = date('Y-m-d', strtotime('-2 year', strtotime($date)));
            $threeYearsAgo = date('Y-m-d', strtotime('-3 year', strtotime($date)));

            // dd($sixMonthsAgo,$oneYearAgo,$twoYearsAgo,$threeYearsAgo);

            $indicesDetails = IndicesDetail::whereIn('correlation_new', $indices)
                ->select(DB::raw("
                correlation_new,
                MAX(CASE WHEN entry_date = '$date' THEN closing_value END) AS closing_value_current_date,
                MAX(CASE WHEN entry_date = '$sixMonthsAgo' THEN closing_value END) AS closing_value_sixMonthsAgo,
                MAX(CASE WHEN entry_date = '$oneYearAgo' THEN closing_value END) AS closing_value_oneYearAgo,
                MAX(CASE WHEN entry_date = '$twoYearsAgo' THEN closing_value END) AS closing_value_twoYearsAgo,
                MAX(CASE WHEN entry_date = '$threeYearsAgo' THEN closing_value END) AS closing_value_threeYearsAgo,
                (
                    (MAX(CASE WHEN entry_date = '$date' THEN closing_value END) - 
                    MAX(CASE WHEN entry_date = '$sixMonthsAgo' THEN closing_value END)) / 
                    NULLIF(MAX(CASE WHEN entry_date = '$sixMonthsAgo' THEN closing_value END), 0)
                ) * 100 AS sixmonthsReturn,
                (
                    (MAX(CASE WHEN entry_date = '$date' THEN closing_value END) - 
                    MAX(CASE WHEN entry_date = '$oneYearAgo' THEN closing_value END)) / 
                    NULLIF(MAX(CASE WHEN entry_date = '$oneYearAgo' THEN closing_value END), 0)
                ) * 100 AS oneYearReturn,
                (
                    (
                        POW(
                            CAST(MAX(CASE WHEN entry_date = '$date' THEN closing_value END) AS DECIMAL(15, 6)) / 
                            NULLIF(CAST(MAX(CASE WHEN entry_date = '$twoYearsAgo' THEN closing_value END) AS DECIMAL(15, 6)), 0),
                            1 / 2
                        ) - 1
                    ) * 100
                ) AS twoyearsReturn,
                (
                    (
                        POW(
                            CAST(MAX(CASE WHEN entry_date = '$date' THEN closing_value END) AS DECIMAL(15, 6)) / 
                            NULLIF(CAST(MAX(CASE WHEN entry_date = '$threeYearsAgo' THEN closing_value END) AS DECIMAL(15, 6)), 0),
                            (1 / 3)
                        ) - 1 
                    ) * 100
                ) AS threeyearsReturn
            "))->groupBy('correlation_new')
                ->get()->keyBy('correlation_new')->toArray();

            $fundDetails = FundDetail::whereIn('fund_detail.fund_code', $fund_codes)
                ->join('fund_master', 'fund_master.fund_code', '=', 'fund_detail.fund_code')
                ->select(DB::raw("
                mpx_fund_master.fund_code,
                mpx_fund_master.fund_name,
                mpx_fund_master.indices_name as correlation_new,
                MAX(CASE WHEN entry_date = '$date' THEN closing_nav END) AS closing_nav_current_date,
                MAX(CASE WHEN entry_date = '$sixMonthsAgo' THEN closing_nav END) AS closing_nav_sixMonthsAgo,
                MAX(CASE WHEN entry_date = '$oneYearAgo' THEN closing_nav END ) AS closing_nav_oneYearAgo,
                MAX(CASE WHEN entry_date = '$twoYearsAgo' THEN closing_nav END) AS closing_nav_twoYearsAgo,
                MAX(CASE WHEN entry_date = '$threeYearsAgo' THEN closing_nav END) AS closing_nav_threeYearsAgo,
                (
                    (MAX(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) - 
                    MAX(CASE WHEN mpx_fund_detail.entry_date = '$sixMonthsAgo' THEN mpx_fund_detail.closing_nav END)) / 
                    NULLIF(MAX(CASE WHEN mpx_fund_detail.entry_date = '$sixMonthsAgo' THEN mpx_fund_detail.closing_nav END), 0)
                ) * 100 AS sixmonthsReturn,
                (
                    (MAX(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) - 
                    MAX(CASE WHEN mpx_fund_detail.entry_date = '$oneYearAgo' THEN mpx_fund_detail.closing_nav END)) / 
                    NULLIF(MAX(CASE WHEN mpx_fund_detail.entry_date = '$oneYearAgo' THEN mpx_fund_detail.closing_nav END), 0)
                ) * 100 AS oneYearReturn,
                (
                (
                    POW(
                            CAST(MAX(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) AS DECIMAL(15, 6)) / 
                            NULLIF(CAST(MAX(CASE WHEN mpx_fund_detail.entry_date = '$twoYearsAgo' THEN mpx_fund_detail.closing_nav END) AS DECIMAL(15, 6)), 0),
                            (1 / 2)
                        ) - 1 
                    ) * 100
                ) AS twoyearsReturn,
                (
                (
                    POW(
                        CAST(MAX(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) AS DECIMAL(15, 6)) / 
                        NULLIF(CAST(MAX(CASE WHEN mpx_fund_detail.entry_date = '$threeYearsAgo' THEN mpx_fund_detail.closing_nav END) AS DECIMAL(15, 6)), 0),
                        (1 / 3)
                    ) - 1 ) * 100
                ) AS threeyearsReturn
            "))->groupBy('fund_detail.fund_code')
                ->get()->toArray();

            // dd($sixMonthsAgo, $oneYearAgo, $twoYearsAgo, $threeYearsAgo, $fundDetails, $indicesDetails);

            foreach ($fundDetails as $fund) {
                $correlation_new = $fund['correlation_new'];
                // Check if the index data exists for the correlation_new
                $index = isset($indicesDetails[$correlation_new]) ? $indicesDetails[$correlation_new] : [
                    'sixmonthsReturn' => 0,
                    'oneYearReturn' => 0,
                    'twoyearsReturn' => 0,
                    'threeyearsReturn' => 0
                ];

                // Helper function to check if value is 'N/A'

                $result = [
                    'fund_name' => $fund['fund_name'],
                    'fund_code' => $fund['fund_code'],
                    'sixmonths' => self::calculateDifference($fund['sixmonthsReturn'], $index['sixmonthsReturn']),
                    'oneyear'   => self::calculateDifference($fund['oneYearReturn'], $index['oneYearReturn']),
                    'twoyear'   => self::calculateDifference($fund['twoyearsReturn'], $index['twoyearsReturn']),
                    'threeyear' => self::calculateDifference($fund['threeyearsReturn'], $index['threeyearsReturn']),
                ];

                array_push($mergedResults, (object) $result);
            }
        } elseif ($type == 'weekly') {

            $sevenDaysAgo = date('Y-m-d', strtotime('-7 days', strtotime($date)));
            $fourteenDaysAgo = date('Y-m-d', strtotime('-14 days', strtotime($date)));
            $thirtyDaysAgo = date('Y-m-d', strtotime('-30 days', strtotime($date)));
            $sixtyDaysAgo = date('Y-m-d', strtotime('-60 days', strtotime($date)));

            // dd($sixMonthsAgo,$oneYearAgo,$twoYearsAgo,$threeYearsAgo);

            $indicesDetails = IndicesDetail::whereIn('correlation_new', $indices)
                ->select(DB::raw("
            correlation_new,
            MAX(CASE WHEN entry_date = '$date' THEN closing_value END) AS closing_value_current_date,
            MAX(CASE WHEN entry_date = '$sevenDaysAgo' THEN closing_value END) AS closing_value_sevenDaysAgo,
            MAX(CASE WHEN entry_date = '$fourteenDaysAgo' THEN closing_value END) AS closing_value_fourteenDaysAgo,
            MAX(CASE WHEN entry_date = '$thirtyDaysAgo' THEN closing_value END) AS closing_value_thirtyDaysAgo,
            MAX(CASE WHEN entry_date = '$sixtyDaysAgo' THEN closing_value END) AS closing_value_sixtyDaysAgo,
            (
                (MAX(CASE WHEN entry_date = '$date' THEN closing_value END) - 
                MAX(CASE WHEN entry_date = '$sevenDaysAgo' THEN closing_value END)) / 
                NULLIF(MAX(CASE WHEN entry_date = '$sevenDaysAgo' THEN closing_value END), 0)
            ) * 100 AS sevenDaysReturn,
            (
                (MAX(CASE WHEN entry_date = '$date' THEN closing_value END) - 
                MAX(CASE WHEN entry_date = '$fourteenDaysAgo' THEN closing_value END)) / 
                NULLIF(MAX(CASE WHEN entry_date = '$fourteenDaysAgo' THEN closing_value END), 0)
            ) * 100 AS fourteenDaysReturn,
            (
                (MAX(CASE WHEN entry_date = '$date' THEN closing_value END) - 
                MAX(CASE WHEN entry_date = '$thirtyDaysAgo' THEN closing_value END)) / 
                NULLIF(MAX(CASE WHEN entry_date = '$thirtyDaysAgo' THEN closing_value END), 0)
            ) * 100 AS thirtyDaysReturn,
            (
                (MAX(CASE WHEN entry_date = '$date' THEN closing_value END) - 
                MAX(CASE WHEN entry_date = '$sixtyDaysAgo' THEN closing_value END)) / 
                NULLIF(MAX(CASE WHEN entry_date = '$sixtyDaysAgo' THEN closing_value END), 0)
            ) * 100 AS sixtyDaysReturn
        "))
                ->groupBy('correlation_new')
                ->get()
                ->keyBy('correlation_new')
                ->toArray();

            $fundDetails = FundDetail::whereIn('fund_detail.fund_code', $fund_codes)
                ->join('fund_master', 'fund_master.fund_code', '=', 'fund_detail.fund_code')
                ->select(DB::raw("
          mpx_fund_master.fund_code,
          mpx_fund_master.fund_name,
          mpx_fund_master.indices_name as correlation_new,
          MAX(CASE WHEN entry_date = '$date' THEN closing_nav END) AS closing_nav_current_date,
          MAX(CASE WHEN entry_date = '$sevenDaysAgo' THEN closing_nav END) AS closing_nav_sevenDaysAgo,
          MAX(CASE WHEN entry_date = '$fourteenDaysAgo' THEN closing_nav END ) AS closing_nav_fourteenDaysAgo,
          MAX(CASE WHEN entry_date = '$thirtyDaysAgo' THEN closing_nav END) AS closing_nav_thirtyDaysAgo,
          MAX(CASE WHEN entry_date = '$sixtyDaysAgo' THEN closing_nav END) AS closing_nav_sixtyDaysAgo,
          (
              (SUM(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) - 
              SUM(CASE WHEN mpx_fund_detail.entry_date = '$sevenDaysAgo' THEN mpx_fund_detail.closing_nav END)) / 
              NULLIF(SUM(CASE WHEN mpx_fund_detail.entry_date = '$sevenDaysAgo' THEN mpx_fund_detail.closing_nav END), 0)
          ) * 100 AS sevenDaysReturn,
          (
              (SUM(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) - 
              SUM(CASE WHEN mpx_fund_detail.entry_date = '$fourteenDaysAgo' THEN mpx_fund_detail.closing_nav END)) / 
              NULLIF(SUM(CASE WHEN mpx_fund_detail.entry_date = '$fourteenDaysAgo' THEN mpx_fund_detail.closing_nav END), 0)
          ) * 100 AS fourteenDaysReturn,
          (
              (SUM(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) - 
              SUM(CASE WHEN mpx_fund_detail.entry_date = '$thirtyDaysAgo' THEN mpx_fund_detail.closing_nav END)) / 
              NULLIF(SUM(CASE WHEN mpx_fund_detail.entry_date = '$thirtyDaysAgo' THEN mpx_fund_detail.closing_nav END), 0)
          ) * 100 AS thirtyDaysReturn,
          (
              (SUM(CASE WHEN mpx_fund_detail.entry_date = '$date' THEN mpx_fund_detail.closing_nav END) - 
              SUM(CASE WHEN mpx_fund_detail.entry_date = '$sixtyDaysAgo' THEN mpx_fund_detail.closing_nav END)) / 
              NULLIF(SUM(CASE WHEN mpx_fund_detail.entry_date = '$sixtyDaysAgo' THEN mpx_fund_detail.closing_nav END), 0)
          ) * 100 AS sixtyDaysReturn
      "))
                ->groupBy('fund_detail.fund_code')
                ->get()->toArray();

            // dd($date,$sevenDaysAgo, $fourteenDaysAgo, $thirtyDaysAgo, $sixtyDaysAgo,$indicesDetails,$fundDetails);

            foreach ($fundDetails as $fund) {
                $correlation_new = $fund['correlation_new'];
                // Check if the index data exists for the correlation_new
                $index = isset($indicesDetails[$correlation_new]) ? $indicesDetails[$correlation_new] : [
                    'sevenDaysReturn' => 0,
                    'fourteenDaysReturn' => 0,
                    'thirtyDaysReturn' => 0,
                    'sixtyDaysReturn' => 0
                ];

                // Helper function to check if value is 'N/A'

                $result = [
                    'fund_name' => $fund['fund_name'],
                    'fund_code' => $fund['fund_code'],
                    '7DAYS' => self::calculateDifference($fund['sevenDaysReturn'], $index['sevenDaysReturn']),
                    '14DAYS'   => self::calculateDifference($fund['fourteenDaysReturn'], $index['fourteenDaysReturn']),
                    '30DAYS'   => self::calculateDifference($fund['thirtyDaysReturn'], $index['thirtyDaysReturn']),
                    '60DAYS' => self::calculateDifference($fund['sixtyDaysReturn'], $index['sixtyDaysReturn']),
                ];

                array_push($mergedResults, (object) $result);
            }
        }

        return $mergedResults;
    }


    function calculateDifference($fundValue, $indexValue)
    {
        if ($fundValue === 'N/A' || $fundValue == 0) {
            return 'N/A'; // If fund value is 'N/A', return 'N/A'
        }
        if ($indexValue === 'N/A') {
            $indexValue = 0; // If index value is 'N/A', consider it as 0
        }
        return number_format($fundValue, 2) - number_format($indexValue, 2); // Calculate the difference
    }

    /*==============================================*/

    public function calculatorsPageData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 44;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();
            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;
            if ($request->isMethod('post')) {
                session()->put('useremail', $request->useremail);
                session()->put('username', $request->username);

                //data storing for loggin session
                $calculator_register = new CalculatorRegister();
                // dd($calculator_register);
                $calculator_register->username = $request->username;
                $calculator_register->email = $request->useremail;
                $calculator_register->save();
                return redirect('https://myplexus.com/calctest');
                //dd(url()->previous());				
            }

            //dd($request->fullUrl());
            return view($this->page_path . '.calculators', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function calculatorsPageDatas(Request $request, $slug = false)
    {
        // dd($request);
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 44;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();
            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;
            if ($request->isMethod('post')) {
                // dd('post');
                session()->put('useremail', $request->useremail);
                session()->put('username', $request->username);


                return redirect(url()->previous());
                //dd(url()->previous());				
            } else {
                // dd('Not');
            }

            // dd($this->page_path);
            // return view($this->page_path.'.calculatortest', compact('defDataArr', 'dataArr'));
            return view($this->page_path . '.calculatortest', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function redirectCalculator($service, Request $request)
    {
        // dd($request->all());
        // dd($service);
        // dd(Socialite::driver($service));
        // dd(Socialite);
        // $drivers = array_keys(config('services.socialite', []));
        // dd($drivers);
        return Socialite::driver($service)->redirect();
        // return Socialite::driver('google')->redirectUrl(config('services.google.calcredirect'))->redirect();
    }

    public function callbackCalculator(Request $request, $provider)
    {
        // dd($provider);
        if ($provider == 'google') {
            $provider = 'google-calc';
        } else {
            $provider = 'facebook-calc';
        }
        $frontconstants = Config('frontconstants');
        $webLang = __('web');
        $authLang = __('auth');
        $userSocial =   Socialite::driver($provider)->stateless()->user();
        // dd($userSocial);

        $useremail = $userSocial->getEmail();
        // dd($useremail);
        $username = $userSocial->getName();

        if ($useremail == '' || $useremail === null) {
            return redirect()->route('web.calculators')->with('alert', $frontconstants['alert_css']['3'])->with('message', $authLang['warning']['email_not_provided'])->with('title', $webLang['warning_ttl']);
        }

        $calculator_register = new CalculatorRegister();
        // dd($calculator_register);
        $calculator_register->username = $username;
        $calculator_register->email = $useremail;
        $calculator_register->platform = $provider == 'google-calc' ? '1' : '2';
        $calculator_register->save();

        session()->put('useremail', $useremail);
        session()->put('username', $username);

        return redirect()->route('web.calculators');
    }

    public function thoughtsAndOpinionOnFundsData(Request $request)
    {
        $dataArr = PageModel::getData($this->class_id, '', 24);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $fundSgsListMdl = [];

            $commonconstants = Config('commonconstants');

            $status = $commonconstants['status_val']['1'];

            $fundSgsListMdl = FundSuggestion::list(['status' => $status], ['title', 'description', 'file']);

            $pthPgsMdl = PageModel::pageList(['ids' => [21, 22, 23, 24, 25], 'status' => $status], ['title', 'slug', 'template_id'], 'c_order', 'ASC');
            $stngDataArr = SettingsModel::getSettingsArr(['paathshaala_heading', 'paathshaala_image', 'newsletter_heading', 'newsletter_description'], $status);

            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['pdf_dir_name']), "setting_folder" => Core::getUploadedURL($commonconstants['setting_dir_name']), "web_lang" => __('web')));

            return view($this->page_path . '.thoughts-and-opinion-on-funds', compact('defDataArr', 'dataArr', 'fundSgsListMdl', 'pthPgsMdl', 'stngDataArr'));
        }
        return abort(404);
    }

    public function newsData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 27;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $dataListMdl = [];

            $commonconstants = Config('commonconstants');

            $dataListMdl = News::list(['status' => $commonconstants['status_val']['1']], ['title', 'slug', 'media_type', 'image', 'video_from', 'video_data', 'video_image', 'news_source_link']);

            //dd($dataListMdl);

            //dd($this->defDataArr);

            //$defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['news_dir_name'])));

            $defDataArr = array_merge($this->defDataArr, array("media_folder" => 'https://www.new.myplexus.com/storage/news/'));

            //dd($defDataArr);

            //return view('themes.frontend.pages.in-the-news', compact('defDataArr', 'dataArr', 'dataListMdl'));

            $blogResponses = [];
            $apiURL = 'https://blog.myplexus.com/wp-json/wp/v2/posts';
            // $blogResponses = $this->blogData2($apiURL);


            $newsData = DB::table('news')->orderBy('news.n_id', 'desc')->get();

            // dd($newsData);

            return view($this->page_path . '.in-the-news', compact('defDataArr', 'dataArr', 'dataListMdl','blogResponses','newsData'));
        }
        return abort(404);
    }

    public function pentatecData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 29;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view('themes.frontend.pages.pentatec-filter', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function fundManDetailsData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 51;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path . '.fund-man-details', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function fundManDetailsShridattaBhandwaldar(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 52;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path . '.shridatta-bhandwaldar', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function fundManDetailsShreyasDevalkar(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 53;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path . '.shreyas-devalkar', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function fundManDetailsAniruddhaNaha(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 54;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path . '.aniruddha-naha', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function fundManDetailsSanjayChawla(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 55;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path . '.sanjay-chawla', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function returnCalculationData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 56;
        }

        $apiURL = 'https://www.myplexus.com/api/v1/funds';
        $fundReponses = $this->DropDownData($apiURL);

        $apiURL = 'https://www.myplexus.com/api/v1/indices';
        $index_fundReponses = $this->DropDownData($apiURL);

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path . '.return-calculator', compact('defDataArr', 'dataArr', 'fundReponses', 'index_fundReponses'));
        }
        return abort(404);
    }

    public function volatilityCalculationData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 57;
        }

        $apiURL = 'https://www.myplexus.com/api/v1/funds';
        $fundReponses = $this->DropDownData($apiURL);

        $apiURL = 'https://www.myplexus.com/api/v1/indices';
        $index_fundReponses = $this->DropDownData($apiURL);

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path . '.volatility-calculator', compact('defDataArr', 'dataArr', 'fundReponses', 'index_fundReponses'));
        }
        return abort(404);
    }

    public function getChangesFundNew(Request $request)
    {
        $type_id = (int) ($request->fund_type_id ?? 0);

        if ($this->usingSqlite()) {
            return ['changes_fund' => $this->buildFundChangesByType($type_id)];
        }

        $responseArr = [];
        if ($request->type == 'weekly') {
            $date = Carbon::createFromFormat('Y-m-d', $request->date);
            $weekday = date('l', strtotime($date));
            if ($weekday == 'Monday') {
                $start_date = $date->subDays(3)->format('Y-m-d');
                $end_date = $date->subDays(9)->format('Y-m-d');
            }
            if ($weekday == 'Tuesday') {
                $start_date = $date->subDays(4)->format('Y-m-d');
                $end_date = $date->subDays(10)->format('Y-m-d');
            }
            if ($weekday == 'Wednesday') {
                $start_date = $date->subDays(5)->format('Y-m-d');
                $end_date = $date->subDays(11)->format('Y-m-d');
            }
            if ($weekday == 'Thursday') {
                $start_date = $date->subDays(6)->format('Y-m-d');
                $end_date = $date->subDays(12)->format('Y-m-d');
            }
            if ($weekday == 'Friday') {
                $start_date = $date->subDays(0)->format('Y-m-d');
                $end_date = $date->subDays(6)->format('Y-m-d');
            }
            if ($weekday == 'Saturday') {
                $start_date = $date->subDays(1)->format('Y-m-d');
                $end_date = $date->subDays(7)->format('Y-m-d');
            }
            if ($weekday == 'Sunday') {
                $start_date = $date->subDays(2)->format('Y-m-d');
                $end_date = $date->subDays(8)->format('Y-m-d');
            }
            $days = 6;
            $query = 'CALL sp_snapshot_fund_change_val("' . $start_date . '","' . $type_id . '","' . $days . '","weekly")';
        } else {
            $date = Carbon::createFromFormat('Y-m-d', $request->date);
            $end_date = $date->format('Y-m-d');
            $start_date = $date->subMonth(1)->format('Y-m-d');
            $end_days = date('t', strtotime($end_date));
            if ($end_days == 31) {
                $days = 30;
            } elseif ($end_days == 30) {
                $days = 29;
            } elseif ($end_days == 29) {
                $days = 28;
            } elseif ($end_days == 28) {
                $days = 27;
            }
            $query = 'CALL sp_snapshot_fund_change_val("' . $end_date . '","' . $type_id . '","' . $days . '","monthly")';
        }

        $changes_fund = DB::select($query);
        if (count($changes_fund)) {
            $responseArr['changes_fund'] = $changes_fund;
            return $responseArr;
        }

        return [];
    }
}
