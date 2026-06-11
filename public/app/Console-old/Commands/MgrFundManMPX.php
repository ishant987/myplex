<?php

namespace App\Console\Commands;

use App\Lib\App\Common;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;

use Log;
use DB;
use Carbon\Carbon;

use App\Models\FundMan;

class MgrFundManMPX extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migration:fundmanmyplexus';

    public $fetchRecords = 100;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take data from TbMeetFundMan table.';

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

            $totRecords = $mgrDb->table('TbMeetFundMan')->select('fund_id')->count();
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
                    $dataRows = $mgrDb->table('TbMeetFundMan')->offset($offset)->take($this->fetchRecords)->get();
                    // print_r($dataRows);die();
                    foreach ($dataRows as $record) {
                        // $this->info("fund man name : " . $record->fund_man_name);
                        $store = new FundMan;
                        if (!$store->where('name', $record->fund_man_name)->exists()) {
                            /*Insert code here*/
                            $store->name = $record->fund_man_name;
                            $store->slug = Common::generateSlug($record->fund_man_name, 'fund_man');
                            $store->designation = $record->designation;
                            $store->company_name = $record->company_name;
                            $store->synopsis = $record->fund_man_says;
                            $store->description = $record->description_value;
                            $store->created_id = $defSprAdmnId;
                            $store->updated_id = $defSprAdmnId;
                            $store->created_at = date($commonconstants['y_m_d_frmt'], strtotime($record->upload_date)) . ' 11:00:00';
                            $store->updated_at = $dateFormatted;
                            $store->migration_at = $dateFormatted;
                            // print_r($store);die();
                            if ($store->save()) {
                                // $this->info("Inserted fund man name : " . $store->fund_man_name);
                            } else {
                                // $this->info("Data not inserted - fund man name : " . $record->fund_man_name);
                            }
                        } else {
                            // $this->info("Data exists - fund man name : " . $record->fund_man_name);
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
