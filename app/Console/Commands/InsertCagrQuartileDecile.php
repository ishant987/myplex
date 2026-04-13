<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\FundMaster;
use App\Models\FundDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class InsertCagrQuartileDecile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:daily-cagr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is made to insert data for daily cagr quartile decile insert job- made by Saikat@infosolz';

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
        //process starting......
        $this->info("Cagr insert process started at: ".Carbon::now());
        // die;
        //getting all fund codes in a loop
        // dd('hi');
        $allFunds = $results = DB::table('fund_master')
                                    ->select('fund_type_id', DB::raw('MAX(fund_code) as fund_code'))
                                    ->where('status', 1)
                                    ->groupBy('fund_type_id')
                                    ->get();    
        // dd($allFunds);
        foreach($allFunds as $fundDetail){
            $fund_code = $fundDetail->fund_code;
            // dd($fund_code."---Belogs To---".$fundDetail->fund_type_id);
            $last_date = FundDetail::getLastPublishedDate($fund_code);
            // dd($last_date);
            try{
                DB::select('CALL sp_get_cagr_test("'.date('Y-m-d', strtotime($last_date. ' - 6 days')).'","'.$last_date.'","'.$fund_code.'","'.$fundDetail->fund_type_id.'")');

                DB::select('CALL sp_get_cagr_test("'.date('Y-m-d', strtotime($last_date. ' - 1 month')).'","'.$last_date.'","'.$fund_code.'","'.$fundDetail->fund_type_id.'")');

                DB::select('CALL sp_get_cagr_test("' . date('Y-m-d', strtotime($last_date . ' - 3 months')) . '","' . $last_date . '","' . $fund_code . '","' . $fundDetail->fund_type_id . '")');

                DB::select('CALL sp_get_cagr_test("' . date('Y-m-d', strtotime($last_date . ' - 6 months')) . '","' . $last_date . '","' . $fund_code . '","' . $fundDetail->fund_type_id . '")');

                DB::select('CALL sp_get_cagr_test("'.date('Y-m-d', strtotime($last_date. ' - 1 year')).'","'.$last_date.'","'.$fund_code.'","'.$fundDetail->fund_type_id.'")');

                DB::select('CALL sp_get_cagr_test("'.date('Y-m-d', strtotime($last_date. ' - 2 year')).'","'.$last_date.'","'.$fund_code.'","'.$fundDetail->fund_type_id.'")');

                DB::select('CALL sp_get_cagr_test("'.date('Y-m-d', strtotime($last_date. ' - 3 year')).'","'.$last_date.'","'.$fund_code.'","'.$fundDetail->fund_type_id.'")');

                DB::select('CALL sp_get_cagr_test("'.date('Y-m-d', strtotime($last_date. ' - 5 year')).'","'.$last_date.'","'.$fund_code.'","'.$fundDetail->fund_type_id.'")');
                $this->info('Execution for fund ID: '.$fundDetail->fund_type_id.' has been completed!');
            }catch(Exception $e){
                $this->info('An error occured--'.$e->getMessage());
            }

        }
        //process ending.........
        $this->info("Cagr insert process ended at: ".Carbon::now());
        Log::info('Cagr Job Has been Executed at: '.Carbon::now());
    }
}
