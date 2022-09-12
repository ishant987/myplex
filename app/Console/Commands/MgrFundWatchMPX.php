<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\QueryException;

use Log;
use DB;
use Carbon\Carbon;

use App\Models\FundWatch;

class MgrFundWatchMPX extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migration:fundwatchmyplexus';

    public $fetchRecords = 100;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take data from TbFundWatch table.';

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

            $totRecords = $mgrDb->table('TbFundWatch')->select('fund_id')->count();
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
                    $dataRows = $mgrDb->table('TbFundWatch')->offset($offset)->take($this->fetchRecords)->get();
                    // print_r($dataRows);die();
                    foreach ($dataRows as $record) {
                        // $this->info("title : " . $record->title);
                        $store = new FundWatch;
                        if (!$store->where('title', $record->fund_title)->exists()) {
                            /*Insert code here*/
                            $store->title = $record->fund_title;
                            $store->description = $record->fund_des;
                            $store->file = $record->upload_file;
                            $store->created_id = $defSprAdmnId;
                            $store->updated_id = $defSprAdmnId;
                            $store->created_at = date($commonconstants['y_m_d_frmt'], strtotime($record->upload_date)) . ' 11:00:00';
                            $store->updated_at = $dateFormatted;
                            $store->migration_at = $dateFormatted;
                            // print_r($store);die();
                            if ($store->save()) {
                                // $this->info("Inserted title : " . $store->title);
                            } else {
                                // $this->info("Data not inserted - title : " . $record->title);
                            }
                        } else {
                            // $this->info("Data exists - title : " . $record->title);
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
