<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\QueryException;

use Log;
use DB;
use Carbon\Carbon;

use App\Models\FundDetail;
use App\Models\SettingsModel;

class MgrNavsValueDailyMPX extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migration:navsvaluedailymyplexus';

    public $fetchRecords = 100;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take data from TbFundDetail table.';

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

            $totRecords = $mgrDb->table('TbFundDetail')->select('EntryDate')->count();
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
                } else {
                    $this->fetchRecords = $totRecords;
                }
                $lastCurrencyMigrateOn = SettingsModel::getSettingValue('nav_migrate');
                for ($i = 1; $i <= $noOfLot; $i++) {
                    $offset = ($i - 1) * $this->fetchRecords;
                    $dataRows = $mgrDb->table('TbFundDetail')->whereDate('EntryDate', '>=', $lastCurrencyMigrateOn)->offset($offset)->take($this->fetchRecords)->orderBy('EntryDate', 'ASC')->get();
                    // print_r($dataRows);die();
                    foreach ($dataRows as $record) {
                        // $this->info("FundCode : " . $record->FundCode);
                        $storeEntryDate = date($commonconstants['y_m_d_frmt'], strtotime($record->EntryDate));
                        if ($lastCurrencyMigrateOn != $storeEntryDate) {
                            SettingsModel::where('option_key', 'nav_migrate')->update(['option_value' => $storeEntryDate, 'updated_id' => $defSprAdmnId]);
                        } else {
                            $lastCurrencyMigrateOn = SettingsModel::getSettingValue('nav_migrate');
                        }
                        $store = new FundDetail;
                        if (!$store->where(['fund_code' => $record->FundCode, 'entry_date' => $record->EntryDate])->exists()) {
                            /*Insert code here*/
                            $store->fund_code = $record->FundCode;
                            $store->entry_date = $record->EntryDate;
                            $store->closing_nav = $record->ClosingNav;
                            $store->holiday = $record->Holiday;
                            $store->percentage_change = $record->PercentageChange;
                            $store->publish = $yVal;
                            $store->created_id = $defSprAdmnId;
                            $store->updated_id = $defSprAdmnId;
                            $store->migration_at = $dateFormatted;
                            // print_r($store);die();
                            if ($store->save()) {
                                // $this->info("Inserted ID : " . $store->fund_code);
                            } else {
                                // $this->info("Data Not inserted - FundCode : " . $record->FundCode);
                            }
                        } else {
                            // $this->info("Data exists - FundCode : " . $record->FundCode);
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
