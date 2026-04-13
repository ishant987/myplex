<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

use App\Models\EnquiryModel;
use App\Models\News;
use App\Models\AskExpertQuestion;
use App\Models\User;
use App\Models\Newsletter;
use App\Models\FundMaster;
use App\Models\IndicesMaster;
use App\Models\CurrencyMaster;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Schema;

class DashboardController extends BaseController
{
    public function index()
    {
        $commonconstants = Config('commonconstants');
        $adminLang = __('admin');

        $nwsObj = new News();
        $aeqObj = new AskExpertQuestion();
        $usrObj = new User();

        $totalBoxes = [0 => ['total' => EnquiryModel::getTotalCount($commonconstants['enquiry_type']['value']['0']), 'title' => __('contact.label_txt'), 'url' => route('admin.contact.index')], 1 => ['total' => $aeqObj->select('aeq_id')->count(), 'title' => __('askexpert.aeq_txt'), 'url' => route('admin.question.index')], 2 => ['total' => $usrObj->count(), 'title' => __('subscribeduser.label_txt'), 'url' => route('admin.subscribeduser.index')], 3 => ['total' => Newsletter::getTotalCount(), 'title' => $adminLang['newsletter']['label_txt'], 'url' => route('admin.newsletter.index')], 4 => ['total' => FundMaster::select('fund_id')->count(), 'title' => $adminLang['fund']['label_txt'], 'url' => route('admin.fund.index')], 5 => ['total' => IndicesMaster::select('idc_id')->count(), 'title' => $adminLang['indices']['label_txt'], 'url' => route('admin.indices.index')], 6 => ['total' => CurrencyMaster::select('cm_id')->count(), 'title' => $adminLang['currency']['label_txt'], 'url' => route('admin.currency.index')]];

        $slBoxes = [0 => ['title' => "", 'url' => ""], 1 => ['title' => $adminLang['scrip']['dashboard_label'], 'url' => route('admin.scrips.index')], 2 => ['title' => $adminLang['clear_cache_txt'], 'url' => route('admin.clearcache')]];

        $nwsRcntList = $nwsObj->list('', ['n_id', 'title', 'created_at'], '', '', 5);

        $aeqRcntList = $aeqObj->select(['aeq_id', 'question', 'created_at'])->orderBy('aeq_id', 'DESC')->paginate(5);

        $suRcntList = $usrObj->selectRaw("u_id," . addcslashes('CONCAT_WS(" ", f_name, l_name) AS fullname', "'") . ", created_at")->orderBy('u_id', 'DESC')->paginate(5);

        $recentTxt = $adminLang['recent_txt'];
        $recentBoxesAtr = ['box1_title' => $recentTxt . ' ' . __('news.label_txt'), 'box2_title' => $recentTxt . ' ' . __('askexpert.aeq_txt'), 'box3_title' => $recentTxt . ' ' . __('subscribeduser.label_txt')];

        $moduleAtrArr = ['see_all' => $adminLang['see_all_txt'], 'data_not_available' => __('message.data_not_available'), 'target' => $commonconstants['target_opt1'], "mdfy_dt_frmt" => $commonconstants['dt_tm_frmt2'], "edit_txt" => $adminLang['edit_txt'], "added_date_txt" => $adminLang['added_date_txt'], 'list_txt' => $adminLang['list_txt'], 'char_lngth' => Config('adminconstants.descp_char_lngth')];

        $subscriptionStats = [];
        if (config('features.subscription_enabled') && Schema::hasTable('subscriptions') && Schema::hasTable('payment_transactions')) {
            $subscriptionStats = [
                ['title' => 'Active Subscribers', 'total' => User::where('subscription_status', 'active')->count()],
                ['title' => 'Trial Users', 'total' => User::where('subscription_status', 'trial')->count()],
                ['title' => 'Trial Expiring In 7 Days', 'total' => User::where('subscription_status', 'trial')->whereBetween('trial_ends_at', [now(), now()->copy()->addDays(7)])->count()],
                ['title' => 'Monthly Revenue', 'total' => number_format((float) PaymentTransaction::where('status', 'captured')->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount'), 2)],
            ];
        }

        return view('themes.backend.pages.dashboard', compact('totalBoxes', 'slBoxes', 'moduleAtrArr', 'recentBoxesAtr', 'nwsRcntList', 'aeqRcntList', 'suRcntList', 'subscriptionStats'));
    }

    public function cleardata()
    {
        $loginAdminId = self::getLoggedInAdminId();

        $commonconstants = Config('commonconstants');
        $adminconstants = Config('adminconstants');

        $admin = __('admin');

        try {
            // Get all files in a directory
            $files = Storage::allFiles($commonconstants['raw_dir_name']);
            if ($files) {
                // Delete Files
                if (!Storage::delete($files)) {
                    return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $admin['error']['clear_cache'])->with('title', $admin['error_ttl']);
                }
            }
            return back()->with('alert', $adminconstants['alert_css'][1])->with('message', $admin['success']['clear_cache'])->with('title', $admin['success_ttl']);
        } catch (QueryException $exception) {
            if ($loginAdminId == $commonconstants['def_super_admin_id']) {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $exception->getMessage())->with('title', $admin['error_ttl'])->withInput();
            } else {
                return back()->with('alert', $adminconstants['alert_css'][2])->with('message', $admin['error']['clear_cache'])->with('title', $admin['error_ttl']);
            }
        }
    }
}
