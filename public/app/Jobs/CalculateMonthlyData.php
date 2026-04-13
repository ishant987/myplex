<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DB;
use App\Models\MonthlyRatioCalculation;
use App\Models\FundMaster;
use Carbon\Carbon;

class CalculateMonthlyData implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    private $end_date;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $end_date)
    {
        $this->end_date = $end_date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $commonconstants = Config('commonconstants');

        $end_date = $this->end_date;
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
        \Log::info('monthly ranking calculation start: '.Carbon::now());
        DB::select('TRUNCATE TABLE mpx_monthly_ratio_calculations');
        foreach ($fund_type_ids as $id) {
            DB::select("CALL sp_monthly_ranking('".$start_date."','".$end_date."','".$first_period_start_date."','".$first_period_end_date."','".$second_period_start_date."','".$second_period_end_date."','".$third_period_start_date."','".$third_period_end_date."','".$fourth_period_start_date."','".$fourth_period_end_date."',".$id->fund_type_id.")");
        }
        \Log::info('monthly ranking calculation end: '.Carbon::now());
    }
}
