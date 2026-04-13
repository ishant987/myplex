<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\QueryException;

use Log;
use DB;
use Carbon\Carbon;

use App\Models\FundType;

class MgrFundTypeMPX extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migration:fundtypemyplexus';

    public $fetchRecords = 100;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take data from TbFundType table.';

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

            $totRecords = $mgrDb->table('TbFundType')->select('FundTypeID')->count();
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
                    $dataRows = $mgrDb->table('TbFundType')->offset($offset)->take($this->fetchRecords)->get();
                    // print_r($dataRows);die();
                    foreach ($dataRows as $record) {
                        // $this->info("FundTypeID : " . $record->FundTypeID);
                        $store = new FundType;
                        if (!$store->where('ft_id', $record->FundTypeID)->exists()) {
                            /*Insert code here*/
                            $store->ft_id = $record->FundTypeID;
                            $store->name = $record->TypeName;
                            $store->active_passive = $record->ActivePassive;
                            $store->monthly_performance = $record->MonthlyPerformance;
                            $store->created_id = $defSprAdmnId;
                            $store->updated_id = $defSprAdmnId;
                            $store->created_at = $dateFormatted;
                            $store->updated_at = $dateFormatted;
                            // print_r($store);
                            // die();
                            if ($store->save()) {
                                // $this->info("Inserted ID : " . $store->ft_id);
                            } else {
                                // $this->info("Data not inserted - FundTypeID : " . $record->FundTypeID);
                            }
                        } else {
                            // $this->info("Data exists - FundTypeID : " . $record->FundTypeID);
                            $store2 = FundType::find($record->FundTypeID);
                            $store2->name = $record->TypeName;
                            $store2->active_passive = $record->ActivePassive;
                            $store2->monthly_performance = $record->MonthlyPerformance;
                            $store2->updated_id = $defSprAdmnId;
                            $store2->updated_at = $dateFormatted;
                            // print_r($store);die();
                            if ($store2->save()) {
                                // $this->info("Updated ID : " . $store->ft_id);
                            } else {
                                // $this->info("Data not updated - FundTypeID : " . $record->FundTypeID);
                            }
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
