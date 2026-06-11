<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\QueryException;

use Log;
use DB;
use Carbon\Carbon;

use App\Models\NfoOffer;

class MgrNfoOfferMPX extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migration:nfooffermyplexus';

    public $fetchRecords = 100;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take data from bs_nfo_offer table.';

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

            $totRecords = $mgrDb->table('bs_nfo_offer')->select('slno')->count();
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
                    $dataRows = $mgrDb->table('bs_nfo_offer')->offset($offset)->take($this->fetchRecords)->get();
                    // print_r($dataRows);die();
                    foreach ($dataRows as $record) {
                        // $this->info("FundID : " . $record->FundID);
                        $store = new NfoOffer;
                        if (!$store->where('no_id', $record->slno)->exists()) {
                            /*Insert code here*/
                            switch ($record->type) {
                                case 1:
                                    $type = 'f';
                                    break;
                                case 2:
                                    $type = 'l';
                                    break;
                                default:
                                    $type = '';
                                    break;
                            }

                            $store->no_id = $record->slno;
                            $store->type = $type;
                            $store->fund_name = $record->title;
                            $store->fund_opening = $record->start_date_nfo;
                            $store->fund_closing = $record->end_date_nfo;
                            $store->file = $record->file1;
                            $store->link = $record->link;
                            $store->post_date = $record->date_time;
                            $store->created_id = $defSprAdmnId;
                            $store->updated_id = $defSprAdmnId;
                            $store->created_at = $record->DateInserted;
                            $store->updated_at = $dateFormatted;
                            $store->migration_at = $dateFormatted;
                            // print_r($store);die();
                            if ($store->save()) {
                                // $this->info("Inserted ID : " . $store->no_id);
                            } else {
                                // $this->info("Data not inserted - slno : " . $record->slno);
                            }
                        } else {
                            // $this->info("Data exists - FundID : " . $record->FundID);
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
