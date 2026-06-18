<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FundDetail;
use App\Models\FundMaster;
use App\Models\FundType;
use App\Models\IndicesDetail;
use App\Models\IndicesMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SnapshotController extends Controller
{
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

    public function monthly_snapshot_new(Request $request)
    {
        $data = RatioController::loggedInUserData();
        $to_date = !empty($request->date) ? date('Y-m-d', strtotime($request->date)) : date('Y-m-d', strtotime('-1 day'));

        $data['browser_title'] = 'Snapshot';
        $data['active_menu'] = 'dashboard';
        $data['to_date'] = $to_date;

        $from_date = Carbon::parse($to_date)->subMonth()->toDateString();
        $data['from_date'] = $from_date;
        $days = (int) round((strtotime($to_date) - strtotime($from_date)) / (60 * 60 * 24));

        if ($this->usingSqlite()) {
            $data['monthly_benchmark'] = $monthly_benchmark = $this->buildFundTypeBenchmarks();
            $data['changes_indices'] = $this->buildIndexRows($to_date);
            $data['changes_currency'] = $this->buildStaticCurrencyRows();
            $data['changes_commodity'] = $this->buildStaticCommodityRows();
            $data['best_schemes'] = $this->buildBestFundsRows();
        } else {
            $data['monthly_benchmark'] = $monthly_benchmark = DB::select('CALL sp_snapshot_monthly_benchmark_new("' . $to_date . '")');

            foreach ($monthly_benchmark as $key => $monthly_benchmark_val) {
                $fundCategoryChangeReturn = 0;
                $type_id = $monthly_benchmark_val->FundTypeID;
                $date = Carbon::createFromFormat('Y-m-d', $to_date);
                $end_date = $date->format('Y-m-d');
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

                $changes_fund = DB::select('CALL sp_snapshot_fund_change_val("' . $end_date . '","' . $type_id . '","' . $days . '","monthly")');

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
            $data['best_schemes'] = DB::select('CALL sp_snapshot_monthly_best_fund("' . $from_date . '")');
        }

        $data['array_bse'] = [];
        $data['array_nse'] = [];
        $data['array_global_it'] = [];

        foreach ($data['changes_indices'] as $value) {
            if ($value->index_type == 'NSE') {
                $data['array_nse'][] = $value;
            }
            if ($value->index_type == 'BSE') {
                $data['array_bse'][] = $value;
            }
            if ($value->index_type == 'GLOBAL') {
                $data['array_global_it'][] = $value;
            }
        }

        $disclaimerQuery = DB::table('fund_watch_disclaimer')->where('status', 1)->first();
        $data['disclaimer'] = $disclaimerQuery->disclaimer;

        return view('web.ratio-reports.monthly_snapshot_new', $data);
    }

    public function getChangesFund(Request $request)
    {
        $type_id = (int) ($request->fund_type_id ?? 0);
        $dataArr = $responseArr = [];

        if ($this->usingSqlite()) {
            $responseArr['changes_fund'] = $this->buildFundChangesByType($type_id);
            return $responseArr;
        }

        if ($request->type == 'weekly') {
            $date = Carbon::createFromFormat('d-m-Y', $request->date);
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

    public function weekly_snapshot_new(Request $request)
    {
        $data = RatioController::loggedInUserData();
        $data['browser_title'] = 'Snapshot';
        $data['active_menu'] = 'dashboard';
        $date = !empty($request->date) ? date('Y-m-d', strtotime($request->date)) : date('Y-m-d', strtotime('-1 day'));

        $daysToSubtract = [
            'Monday' => ['start' => 3, 'end' => 9],
            'Tuesday' => ['start' => 4, 'end' => 10],
            'Wednesday' => ['start' => 5, 'end' => 11],
            'Thursday' => ['start' => 6, 'end' => 12],
            'Friday' => ['start' => 0, 'end' => 6],
            'Saturday' => ['start' => 1, 'end' => 7],
            'Sunday' => ['start' => 2, 'end' => 8],
        ];

        $weekday = Carbon::parse($date)->format('l');
        if (isset($daysToSubtract[$weekday])) {
            $startDays = $daysToSubtract[$weekday]['start'];
            $endDays = $daysToSubtract[$weekday]['end'];
            $end_date = Carbon::parse($date)->subDays($startDays)->toDateString();
            $start_date = Carbon::parse($date)->subDays($endDays)->toDateString();
        } else {
            $start_date = $end_date = null;
        }

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $days = 6;

        if ($this->usingSqlite()) {
            $data['changes_indices'] = $this->buildIndexRows($end_date);
            $data['changes_currency'] = $this->buildStaticCurrencyRows();
            $data['changes_commodity'] = $this->buildStaticCommodityRows();
            $data['weekly_benchmark'] = $this->buildFundTypeBenchmarks();
            $data['weekly_best_funds'] = $this->buildBestFundsRows();
        } else {
            $data['changes_indices'] = DB::select('CALL sp_snapshot_indices_currency_commodity_updated_new("GET_INDICES","' . $end_date . '",' . $days . ')');
            $data['changes_currency'] = DB::select('CALL sp_snapshot_indices_currency_commodity("GET_CURRENCY","' . $end_date . '",' . $days . ')');
            $data['changes_commodity'] = DB::select('CALL sp_snapshot_indices_currency_commodity("GET_COMMODITY","' . $end_date . '",' . $days . ')');
            $data['weekly_benchmark'] = DB::select('CALL sp_snapshot_weekly_benchmark("' . $end_date . '")');
            $data['weekly_best_funds'] = DB::select('CALL sp_snapshot_weekly_fund("' . $end_date . '")');
        }

        $data['array_bse'] = [];
        $data['array_nse'] = [];
        $data['array_global_it'] = [];
        foreach ($data['changes_indices'] as $value) {
            if ($value->index_type == 'NSE') {
                $data['array_nse'][] = $value;
            }
            if ($value->index_type == 'BSE') {
                $data['array_bse'][] = $value;
            }
            if ($value->index_type == 'GLOBAL') {
                $data['array_global_it'][] = $value;
            }
        }

        $disclaimerQuery = DB::table('fund_watch_disclaimer')->where('status', 1)->first();
        $data['disclaimer'] = $disclaimerQuery->disclaimer;

        return view('web.ratio-reports.weekly_snapshot_new', $data);
    }
}
