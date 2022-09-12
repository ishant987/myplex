<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\MonthlyRatioCalculation;
use App\Models\FundMaster;
use Carbon\Carbon;

class CalculateMonthlyRanking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'myplexus:calculate_monthly_ranking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $commonconstants = Config('commonconstants');

        $end_date = '2021-12-31';
        $start_date = Carbon::parse($end_date)->subMonths(12)->addDay()->format('Y-m-d');

        $first_period_start_date = Carbon::parse($end_date)->subMonths(3)->format('Y-m-d');
        $first_period_end_date = $end_date;

        $second_period_start_date = Carbon::parse($first_period_start_date)->subMonths(3)->format('Y-m-d');
        $second_period_end_date = Carbon::parse($first_period_start_date)->subDay()->format('Y-m-d');

        $third_period_start_date = Carbon::parse($second_period_start_date)->subMonths(3)->format('Y-m-d');
        $third_period_end_date = Carbon::parse($second_period_start_date)->subDay()->format('Y-m-d');

        $fourth_period_start_date = Carbon::parse($third_period_start_date)->subMonths(3)->format('Y-m-d');
        $fourth_period_end_date = Carbon::parse($third_period_start_date)->subDay()->format('Y-m-d');

        $fund_type_ids = FundMaster::select('fund_type_id')->where('status', $commonconstants['status_val'][1])->groupBy('fund_type_id')->get();
        $this->info('monthly ranking calculation start: ' . Carbon::now());
        DB::select('TRUNCATE TABLE mpx_monthly_ratio_calculations');
        foreach ($fund_type_ids as $id) {
            DB::select("CALL sp_monthly_ranking('" . $start_date . "','" . $end_date . "','" . $first_period_start_date . "','" . $first_period_end_date . "','" . $second_period_start_date . "','" . $second_period_end_date . "','" . $third_period_start_date . "','" . $third_period_end_date . "','" . $fourth_period_start_date . "','" . $fourth_period_end_date . "'," . $id->fund_type_id . ")");
        }
        $this->info('monthly ranking calculation end: ' . Carbon::now());
    }
}
