<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;

use Log;
use DB;

use App\Lib\App\Notification;
use App\Lib\Core\MailPS;

use App\User;

class MembersBirthday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:membersbirthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send members birthday notification (Email+Push) to birthday user.';

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

        DB::beginTransaction();

        try {
            $userObj = self::getUsrBrthdyList();
            if (count($userObj) > 0) {
                $commonconstants = Config('commonconstants');
                $commonLang = __('common');
                $msgLang = __('message');

                $ynArr = $commonconstants['y_n_val'];
                $yVal = $ynArr[1];
                $nVal = $ynArr[2];

                $isErr = $yVal;

                $defAdminId = $commonconstants['def_super_admin_id'];

                $ntfObj = new Notification();

                /*Check Push Notification On / Off*/
                $pnStngsArr = $ntfObj->getSettingsData(['push_notification_status']);

                $pnStatus = $pnStngsArr['push_notification_status'];
                $pushNtfctnOn = $pnStatus != '' ? $pnStatus : $nVal;

                $title = 'Birthday Wishes!';
                $subTitle = 'The whole team at ' . env('APP_NAME') . ' would like to wish you a very Happy Birthday.';

                $mailPSObj = new MailPS();
                $mailCssAtr = $mailPSObj->getEmailHtmlCssAtr();

                $isMailSend = true; //true / false

                foreach ($userObj as $value) {
                    $userId = intval($value->u_id);
                    $this->info("Notify to birthday user id=" . $userId);
                    if ($userId > 0) {
                        /*Notify to birthday user*/

                        /*Send Email*/
                        if ((($isMailSend == true))) {
                            $mailArr = ["name" => $value->f_name, "body" => $msgLang['mail']['member_birthday']['body']];
                            $content = view('emails.cron.to-birthday-user', compact('mailArr', 'mailCssAtr'));

                            $mailResp = $mailPSObj->sendMail($value->email, $msgLang['mail']['member_birthday']['subject'], $content, '', $msgLang['mail']['member_birthday']['from_name'], '', '', '', '', 'Best,');
                            if (!$mailResp) {
                                return $this->info(__('message.error.email_send'));
                            }
                            $isErr = $nVal;
                        }

                        /*Send Notification*/
                        $usOpt2 = $commonconstants['uopt_typ_opt2_val'];
                        $ntfTypeArr = $commonconstants['notification']['types']['value'];

                        $ntfStngOptn = $ntfObj->getUserSettingInfo($usOpt2, $userId);
                        $genNtfy = $ntfStngOptn['gen_ntfy'];

                        $yesVal = strtolower($commonLang['yes_no_txt']['y']);

                        if ($genNtfy == $yesVal) {
                            $ntfType = $ntfTypeArr[2];

                            $inputNtfcnArr = ['type' => $ntfType, 'title' => $title, 'sub_title' => $subTitle, 'created_medium' => $commonconstants['medium']['value'][4], 'created_by' => $commonconstants['cu_by_val'][1], 'created_id' => $defAdminId];
                            $storeNtfcn = $ntfObj->createNotification($inputNtfcnArr);
                            if ($storeNtfcn) {
                                $ntfcnId = $storeNtfcn->ntfy_id;

                                $inputUsrNtfcnArr = ['ntfy_id' => $ntfcnId, 'u_id' => $userId, 'created_id' => $defAdminId];
                                $storeUsrNtfcn = $ntfObj->createUserNotification($inputUsrNtfcnArr);
                                if ($storeUsrNtfcn) {
                                    $isErr = $nVal;
                                    $is_used = $value->is_used;

                                    /*Send Push Notification.*/
                                    if ($pushNtfctnOn == $yVal && $is_used == $yVal) {
                                        $uRegKeysObj = $ntfObj->getDeviceFcmRegKey($userId);
                                        if ($uRegKeysObj) {
                                            $ntfMsg = array("title" => $title, "body" => $subTitle);
                                            $ntfData = array("data_type" => $ntfType, "title" => $title, "sub_title" => $subTitle);
                                            $uRegKeysArr = Arr::flatten($uRegKeysObj->toArray());
                                            $sendRspns = $ntfObj->notifyFCMMultiple($uRegKeysArr, $ntfMsg, $ntfData);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                if ($isErr == $nVal) {
                    DB::commit();

                    $this->info(__('message.success.add'));
                } else {
                    DB::rollBack();

                    $this->error(__('message.error.saved'));
                }
            }
        } catch (QueryException $exception) {
            DB::rollBack();

            $this->error($exception);
        }

        $this->line('');
        $this->line(__('message.command_end_txt'));
        $this->line('');
        Log::channel('cronlog')->info(__CLASS__ . ' - END ');
    }

    public function getUsrBrthdyList()
    {
        $commonconstants = Config('commonconstants');
        $yVal = $commonconstants['y_n_val'][1];

        // DB::enableQueryLog(); // Enable query log

        return User::select(['u_id', 'f_name', 'email', 'is_used'])->where(['status' => $commonconstants['status_val'][1], 'is_approved' => $yVal])->whereMonth('birthday', '=', date('m'))->whereDay('birthday', '=', date('d'))->orderBy('u_id', 'ASC')->get();

        //$dataObj = User::selectRaw("u_id,".addcslashes('CONCAT_WS(" ", f_name, l_name) AS fullname', "'").",email,is_used")->where(['status' => $commonconstants['status_val'][1], 'is_approved' => $yVal])->whereMonth('birthday', '=', date('m'))->whereDay('birthday', '=', date('d'))->orderBy('u_id', 'ASC')->get();

        // dd(DB::getQueryLog()); // Show results of log

        //return $dataObj;
    }
}
