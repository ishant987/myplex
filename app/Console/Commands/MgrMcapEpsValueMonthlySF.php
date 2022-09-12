<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\QueryException;

use Log;
use DB;
use Carbon\Carbon;

use App\Models\McapEps;

class MgrMcapEpsValueMonthlySF extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migration:mcapepsvaluemonthlysitefolks';
    
    public $fetchRecords = 100;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take data from tb_mcapeps table.';

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
            $mgrDb = DB::connection('mysqlisf');

            $totRecords = $mgrDb->table('tb_mcapeps')->select('ScripName')->count();
            if ($totRecords > 0) {
                $commonconstants = Config('commonconstants');
                $date = new Carbon;
                $dateFormatted = $date->format($commonconstants['db_dt_tm_frmt']);
                $defSprAdmnId = $commonconstants['def_super_admin_id'];
                $yVal = $commonconstants['y_n_val'][1];

                $this->info("Total : " . $totRecords);
                $bar = $this->output->createProgressBar($totRecords);
                $bar->start();

                $noOfLot = 1;
                if ($totRecords > $this->fetchRecords) {
                    $noOfLot = ceil($totRecords / $this->fetchRecords);
                }else{
                    $this->fetchRecords = $totRecords;
                }
                // echo $noOfLot;die();
                for ($i = 1; $i <= $noOfLot; $i++) {
                    $offset = ($i - 1) * $this->fetchRecords;
                    $dataRows = $mgrDb->table('tb_mcapeps')->offset($offset)->take($this->fetchRecords)->get();
                    // print_r($dataRows);die();
                    foreach ($dataRows as $record) {
                        // $this->info("scrip_name : " . $record->ScripName);
                        $store = new McapEps;
                        if (!$store->where(['scrip_name' => $record->ScripName, 'entry_date' => $record->EntryDate])->exists()) {
                            /*Insert code here*/
                            $store->scrip_name = $record->ScripName;
                            $store->entry_date = $record->EntryDate;
                            $store->market_cap = $record->MarketCap;
                            $store->eps = $record->EPS;
                            $store->pe = $record->PE;
                            $store->publish = $yVal;
                            $store->created_id = $defSprAdmnId;
                            $store->updated_id = $defSprAdmnId;
                            $store->migration_at = $dateFormatted;
                            // print_r($store);die();
                            if ($store->save()) {
                                // $this->info("Inserted scrip_name : " . $store->scrip_name);
                            } else {
                                // $this->info("Data Not inserted - scrip_name : " . $record->ScripName);
                            }
                        }
                        else{
                            // $this->info("Data exists - scrip_name : " . $record->ScripName);
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
