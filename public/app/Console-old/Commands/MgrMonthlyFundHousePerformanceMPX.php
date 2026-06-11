<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\QueryException;

use Log;
use DB;
use Carbon\Carbon;

use App\Models\MonthlyFundHousePerformance;

class MgrMonthlyFundHousePerformanceMPX extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migration:monthlyfundhouseperformancemyplexus';

    public $fetchRecords = 100;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take data from TbMonthlyFundHousePerformance table.';

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
     * @return mixed
     */
    public function handle()
    {
        Log::channel('cronlog')->info(__CLASS__ . ' - START ');
        $this->line('');
        $this->line(__('message.command_start_txt'));
        $this->line('');

        try {
            try {
                $mgrDb = DB::connection('sqlsrvmpx');
            } catch (\Exception $e) {
                // $this->error($e);
                echo "Database not connected";
                die();
            }

            $totRecords = $mgrDb->table('TbMonthlyFundHousePerformance')->select('FundTypeId')->count();
            if ($totRecords > 0) {
                $commonconstants = Config('commonconstants');
                $date = new Carbon;
                $dateFormatted = $date->format($commonconstants['db_dt_tm_frmt']);
                $defSprAdmnId = $commonconstants['def_super_admin_id'];

                $this->info("Total : " . $totRecords);
                $bar = $this->output->createProgressBar($totRecords);
                $bar->start();

                $noOfLot = 1;
                if ($totRecords > $this->fetchRecords) {
                    $noOfLot = ceil($totRecords / $this->fetchRecords);
                } else {
                    $this->fetchRecords = $totRecords;
                }
                // echo $noOfLot;die();
                for ($i = 1; $i <= $noOfLot; $i++) {
                    $offset = ($i - 1) * $this->fetchRecords;
                    $dataRows = $mgrDb->table('TbMonthlyFundHousePerformance')->offset($offset)->take($this->fetchRecords)->get();
                    // print_r($dataRows);die();
                    foreach ($dataRows as $record) {
                        // $this->info("FundTypeID : " . $record->FundTypeID);
                        $store = new MonthlyFundHousePerformance;
                        if (!$store->where(['dated' => $record->Dated, 'fund_type_id' => $record->FundTypeId, 'fund_code' => $record->FundCode])->exists()) {
                            /*Insert code here*/
                            $store->dated = $record->Dated;
                            $store->fund_type_id = $record->FundTypeId;
                            $store->timespan = $record->Timespan;
                            $store->fund_code = $record->FundCode;
                            $store->cagr = $record->CAGR;
                            $store->cagr_rank = $record->CAGRRank;
                            $store->cagr_rank_improvement = $record->CAGRRankImprovement;
                            $store->ret_less_idx = $record->RetLessIdx;
                            $store->ret_less_idx_rank = $record->RetLessIdxRank;
                            $store->ret_less_idx_rank_improvement = $record->RetLessIdxRankImprovement;
                            $store->jensen = $record->Jensen;
                            $store->jensen_rank = $record->JensenRank;
                            $store->jensen_rank_improvement = $record->JensenRankImprovement;
                            $store->beta = $record->Beta;
                            $store->beta_rank = $record->BetaRank;
                            $store->beta_rank_improvement = $record->BetaRankImprovement;
                            $store->co_var = $record->CoVar;
                            $store->co_var_rank = $record->CoVarRank;
                            $store->co_var_rank_improvement = $record->CoVarRankImprovement;
                            $store->created_id = $defSprAdmnId;
                            $store->updated_id = $defSprAdmnId;
                            $store->created_at = $dateFormatted;
                            $store->updated_at = $dateFormatted;
                            $store->migration_at = $dateFormatted;
                            // print_r($store);
                            // die();
                            if ($store->save()) {
                                // $this->info("Inserted ID : " . $store->ft_id);
                            } else {
                                // $this->info("Data not inserted - FundTypeID : " . $record->FundTypeID);
                            }
                        } else {
                            // $this->info("Data exists - FundTypeID : " . $record->FundTypeID);
                        }
                        $bar->advance();
                    }
                }
                $bar->finish();
            } else {
                $this->error(__('message.data_not_available'));
            }
        } catch (QueryException $exception) {
            $this->error($exception);
            // $this->error(__('message.error.something_wrong'));
        }

        $this->line('');
        $this->line(__('message.command_end_txt'));
        $this->line('');
        Log::channel('cronlog')->info(__CLASS__ . ' - END ');
    }
}
