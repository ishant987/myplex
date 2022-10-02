<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;

use App\Lib\Core\Core;
use App\Lib\Core\MailPS;
use App\Models\AskExpertQuestion;
use App\Models\PageModel;
use App\Models\BannerModel;
use App\Models\TestimonialModel;
use App\Models\FAQModel;
use App\Models\FundClassification;
use App\Models\FundMan;
use App\Models\FundSuggestion;
use App\Models\FundTaxation;
use App\Models\FundWatch;
use App\Models\KnowTheRatio;
use App\Models\News;
use App\Models\Newsletter;
use App\Models\NfoOffer;
// use App\Plans;
use App\Models\SettingsModel;
use App\Models\Teams;
use Session;
use Socialite;

class PageController extends BaseController
{
    public $className;
    public $class_id;

    public function __construct()
    {
        $classNameArr = explode('\\', __CLASS__);
        $this->className = end($classNameArr);
        $this->class_id = self::getClassIdByname($this->className);
        $this->page_path =env('PAGE_PATHS','web.pages');
        $this->defDataArr = self::getDefData();
    }

    public function getNewsApi()
    {
        $incoming = @file_get_contents('https://www.moneycontrol.com/rss/latestnews.xml');
        $xml = preg_replace('#&(?=[a-z_0-9]+=)#', '&amp;', $incoming);
        $xml = simplexml_load_string($xml);
        $return_array = array();
        $html = "";
        foreach ($xml->channel as $value) {
            foreach ($value->item as $row) {
                $html .= "<li><p><a href='" . $row->link . "' target='_blank' title=" . $row->title . ">" . $row->title . "</a></p></li>";
            }
        }
        $return_array["html"] = $html;
        return $return_array["html"];
    }

    public function pageData(Request $request, $slug)
    {

        $dataArr = PageModel::getData($this->class_id, $slug);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;
            return view('themes.frontend.pages.page', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function homeData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 1;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $bnrMdl = $nwsApiArr = $fundManMdl = $tstmnlMdl = $calcPgsMdl = $pthPgsMdl = $faqMdl = $blogPosts = $nwsListMdl = [];

            $commonconstants = Config('commonconstants');
            $status = $commonconstants['status_val'][1];

            $bnrMdl = BannerModel::bannerList(['bnr_group' => 'home-banner', 'status' => $status], '', 'c_order', 'DESC');
            $nwsApiData = self::getNewsApi();
            $fundManMdl = FundMan::list(['take' => 1, 'status' => $status], ['fm_id', 'name', 'slug', 'designation', 'company_name', 'synopsis', 'media_id'], 'fm_id', 'DESC');
            $tstmnlMdl = TestimonialModel::testimonialList(['status' => $status], ['tmnl_id', 'name', 'descp', 'company', 'designation', 'media_id'], 'tmnl_id', 'DESC');
            $pthPgsMdl = PageModel::pageList(['ids' => [21, 22, 23, 24, 25], 'status' => $status], ['title', 'slug', 'template_id'], 'c_order', 'ASC');
            $stngDataArr = SettingsModel::getSettingsArr(['paathshaala_heading', 'paathshaala_image', 'newsletter_heading', 'newsletter_description'], $commonconstants['status_val'][1]);
            // $faqs = FAQModel::faqList(['category_id' => $commonconstants['def_faq_cat_id'], 'status' => $status], ['title', 'descp', 'faq_id'], 'c_order', 'ASC');

            // $plansMdl = Plans::list(['status' => $status, 'show_on_wa' => $commonconstants['y_n_val'][1]], ['p_id', 'plan_name', 'amount', 'duration_name'], 'c_order', 'ASC');

            // $blogPosts = json_decode(file_get_contents(env('BLOG_URL') . '/wp-json/wp/v2/posts/?_embed&per_page=3'), true);
            $nwsListMdl = News::list(['status' => $commonconstants['status_val']['1']], ['title', 'slug', 'media_type', 'image', 'video_from', 'video_data', 'video_image', 'news_source_link'], '', '', 3);

            $aeQuesMdl = AskExpertQuestion::list(['status' => $status], '', 'created_at', 'DESC', 1);

            $fndWtchMdl = FundWatch::frontList([], '', '', '', 1);

            $nfoMdl = NfoOffer::frontList([], '', '', '', 1);

            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['media_dir_name']), "setting_folder" => Core::getUploadedURL($commonconstants['setting_dir_name']), "news_folder" => Core::getUploadedURL($commonconstants['news_dir_name']), "user_media_folder" => $commonconstants['user_dir_name'], "payment_lang" => __('payment'), "yes_no_txt" => __('common.yes_no_txt'), "web_lang" => __('web')));
            // dd($defDataArr);
            return view('web.home.index', compact('defDataArr', 'dataArr', 'bnrMdl', 'nwsApiData', 'fundManMdl', 'tstmnlMdl', 'pthPgsMdl', 'stngDataArr','blogPosts', 'nwsListMdl', 'aeQuesMdl', 'fndWtchMdl', 'nfoMdl'));
        }
        return abort(404);
    }

    public function storeNewsletter(Request $request)
    {
        $commonconstants = Config('commonconstants');
        $frontconstants = Config('frontconstants');

        $message = __('message');
        $webLang = __('web');
        $resArr['msg'] = "";

        $vars = array(
            'secret' => $commonconstants['recaptcha']['secret_key'],
            "response" => $request->input('recaptcha_v3')
        );
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        $encoded_response = curl_exec($ch);
        $response = json_decode($encoded_response, true);
        curl_close($ch);

        if ($response['success'] && $response['action'] == 'newsletter_form' && $response['score'] > $commonconstants['recaptcha']['score']) {
            $vldtrRules = [
                'email'  => 'required|email|unique:newsletter'
            ];

            $vldtrMessages = [
                'email.unique' => $message['success']['newsletter_exist']
            ];

            $validator = Validator::make($request->all(), $vldtrRules, $vldtrMessages);

            if ($validator->fails()) {
                // $resArr['msg'] = $validator->getMessageBag();
                // return json_encode($resArr);
                $html = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                        <strong>' . $webLang['error_ttl'] . '&nbsp;</strong>';
                if ($validator->getMessageBag()->toArray()) {
                    $html .= '<ul>';
                    foreach ($validator->getMessageBag()->toArray() as $errors) {
                        foreach ($errors as $error) {
                            $html .= '<li>' . $error . '</li>';
                        }
                    }
                    $html .= '</ul>';
                }
                $html .= '</div>';
                $resArr['msg'] = $html;
                return json_encode($resArr);
            }

            try {
                $input = $request->except('_token', 'submit');
                $store = new Newsletter($input);
                if ($store->save()) {
                    $email = $input['email'];

                    $mailPSObj = new MailPS();
                    $mailCssAtr = $mailPSObj->getEmailHtmlCssAtr();

                    $commaSign = $commonconstants['comma_sign'];

                    $content = view('emails.web.to-user-newsletter', compact('mailCssAtr', 'commaSign'));

                    $subject = $webLang['newsletter']['mail_sbjct'];
                    $fromName = $webLang['newsletter']['mail_f_name'];

                    $mailResp = $mailPSObj->sendMail($email, $subject, $content, '', $fromName);
                    if ($mailResp) {
                        $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['1'] . '">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                            <strong>' . $webLang['success_ttl'] . '&nbsp;</strong> 
                            ' . $message['success']['newsletter_add'] . '
                        </div>';
                    } else {
                        $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                            <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                            ' . $message['error']['email_send'] . '
                        </div>';
                    }
                }
            } catch (QueryException $exception) {
                $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                    <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                    ' . $message['error']['data_saved'] . '
                </div>';
            }
        } else {
            //then probably this is a bot
            //you can do your logic here pass it or deny or do something special
            //score check value of 0.5 you can set which you want form 0 to 1
            //score 1 is probably human score 0 is probably bot
            $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                ' . $message['error']['recaptcha'] . '
            </div>';
        }
        return json_encode($resArr);
    }

    public function aboutData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 3;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $teamMdl = [];

            $commonconstants = Config('commonconstants');

            $status = $commonconstants['status_val']['1'];

            $teamMdl = Teams::list(['status' => $status], ['team_id', 'name', 'media_id', 'designation', 'linkedin_link'], 'c_order', 'ASC');

            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['media_dir_name'])));
            return view($this->page_path.'.about', compact('defDataArr', 'dataArr', 'teamMdl'));
        }
        return abort(404);
    }

    public function thankYouData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 4;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view('themes.frontend.pages.thank-you', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function fundManData(Request $request, $slug)
    {
        $dataArr = PageModel::getData($this->class_id, '', 31);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $fundManMdl = $fundManListMdl = [];

            $commonconstants = Config('commonconstants');

            $status = $commonconstants['status_val']['1'];

            $fundManMdl = FundMan::getData(['slug' => $slug, 'status' => $status], ['fm_id', 'name', 'designation', 'company_name', 'media_id', 'description', 'disclaimer', 'disclaimer_note']);
            if ($fundManMdl) {
                $fundManListMdl = FundMan::list(['data_id_not_in' => $fundManMdl->fm_id, 'status' => $status], ['fm_id', 'name', 'slug', 'designation', 'company_name', 'media_id']);
            }

            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['media_dir_name'])));

            return view($this->page_path.'.fund-man', compact('defDataArr', 'dataArr', 'fundManMdl', 'fundManListMdl'));
        }
        return abort(404);
    }
    public function founder(Request $request)
    {
        $dataArr = PageModel::getData($this->class_id, '',48);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();
            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $fundManMdl = $fundManListMdl = [];

            $commonconstants = Config('commonconstants');

            $status = $commonconstants['status_val']['1'];


            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['media_dir_name'])));

            return view($this->page_path.'.founder', compact('defDataArr', 'dataArr', 'fundManMdl', 'fundManListMdl'));
        }
        return abort(404);
    }

    public function knowYourSchemeData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 32;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view('themes.frontend.pages.know-your-scheme', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function fundPortfolioData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 7;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path.'.fund-portfolio', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function faqData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 26;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $commonconstants = Config('commonconstants');

            $status = $commonconstants['status_val']['1'];

            $faqs = FAQModel::faqList(['category_id' => $commonconstants['def_faq_cat_id'], 'status' => $status], ['faq_id', 'title', 'descp'], 'c_order', 'ASC');
            $pthPgsMdl = PageModel::pageList(['ids' => [21, 22, 23, 24, 25], 'status' => $status], ['title', 'slug', 'template_id'], 'c_order', 'ASC');
            $stngDataArr = SettingsModel::getSettingsArr(['paathshaala_heading', 'paathshaala_image', 'newsletter_heading', 'newsletter_description'], $commonconstants['status_val'][1]);

            // dd($dataArr);

            $defDataArr = array_merge($this->defDataArr, array("setting_folder" => Core::getUploadedURL($commonconstants['setting_dir_name']), "web_lang" => __('web')));

            return view($this->page_path.'.faq', compact('defDataArr', 'dataArr', 'pthPgsMdl', 'stngDataArr','faqs'));
        }
        return abort(404);
    }

    public function mutualFundClassificationsData(Request $request, $id = 0)
    {
        $dataArr = PageModel::getData($this->class_id, '', 22);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $fundClsMdl = $fundClsListMdl = [];

            $commonconstants = Config('commonconstants');

            $status = $commonconstants['status_val']['1'];

            if ($id == 0) {
                $fundClsMdl = FundClassification::list(['status' => $status, 'take' => 1], ['fc_id', 'title', 'description', 'file']);
                if ($fundClsMdl) {
                    $fundClsMdl = $fundClsMdl[0];
                }
            } else {
                $fundClsMdl = FundClassification::getData(['fc_id' => $id, 'status' => $status], ['fc_id', 'title', 'description', 'file']);
            }

            if ($fundClsMdl) {
                $fundClsListMdl = FundClassification::list(['status' => $status], ['fc_id', 'title']);
            }

            $pthPgsMdl = PageModel::pageList(['ids' => [21, 22, 23, 24, 25], 'status' => $status], ['title', 'slug', 'template_id'], 'c_order', 'ASC');
            $stngDataArr = SettingsModel::getSettingsArr(['paathshaala_heading', 'paathshaala_image', 'newsletter_heading', 'newsletter_description'], $status);

            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['pdf_dir_name']), "setting_folder" => Core::getUploadedURL($commonconstants['setting_dir_name']), "web_lang" => __('web')));

            return view('themes.frontend.pages.mutual-fund-classifications', compact('defDataArr', 'dataArr', 'fundClsMdl', 'fundClsListMdl', 'pthPgsMdl', 'stngDataArr'));
        }
        return abort(404);
    }

    public function mutualFundTaxationData(Request $request, $id = 0)
    {
        $dataArr = PageModel::getData($this->class_id, '', 21);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $fundTxnMdl = $fundTxnListMdl = [];

            $commonconstants = Config('commonconstants');

            $status = $commonconstants['status_val']['1'];

            if ($id == 0) {
                $fundTxnMdl = FundTaxation::list(['status' => $status, 'take' => 1], ['ft_id', 'title', 'description', 'file']);
                if ($fundTxnMdl) {
                    $fundTxnMdl = $fundTxnMdl[0];
                }
            } else {
                $fundTxnMdl = FundTaxation::getData(['ft_id' => $id, 'status' => $status], ['ft_id', 'title', 'description', 'file']);
            }

            if ($fundTxnMdl) {
                $fundTxnListMdl = FundTaxation::list(['status' => $status], ['ft_id', 'title']);
            }

            $pthPgsMdl = PageModel::pageList(['ids' => [21, 22, 23, 24, 25], 'status' => $status], ['title', 'slug', 'template_id'], 'c_order', 'ASC');
            $stngDataArr = SettingsModel::getSettingsArr(['paathshaala_heading', 'paathshaala_image', 'newsletter_heading', 'newsletter_description'], $status);

            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['pdf_dir_name']), "setting_folder" => Core::getUploadedURL($commonconstants['setting_dir_name']), "web_lang" => __('web')));

            return view('themes.frontend.pages.mutual-fund-taxation', compact('defDataArr', 'dataArr', 'fundTxnMdl', 'fundTxnListMdl', 'pthPgsMdl', 'stngDataArr'));
        }
        return abort(404);
    }

    public function knowTheRatioData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 23;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $commonconstants = Config('commonconstants');

            $status = $commonconstants['status_val']['1'];

            $dataArr['know_the_ratio'] = KnowTheRatio::list(['status' => $status], ['ktr_id', 'title', 'description', 'media_id'], 'c_order', 'ASC');
            $pthPgsMdl = PageModel::pageList(['ids' => [21, 22, 23, 24, 25], 'status' => $status], ['title', 'slug', 'template_id'], 'c_order', 'ASC');
            $stngDataArr = SettingsModel::getSettingsArr(['paathshaala_heading', 'paathshaala_image', 'newsletter_heading', 'newsletter_description'], $commonconstants['status_val'][1]);

            // dd($faqMdl);

            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['media_dir_name']), "setting_folder" => Core::getUploadedURL($commonconstants['setting_dir_name']), "web_lang" => __('web')));

            return view('themes.frontend.pages.know-the-ratio', compact('defDataArr', 'dataArr', 'pthPgsMdl', 'stngDataArr'));
        }
        return abort(404);
    }

    public function compositionSnapshotData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 8;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path.'.fund-composition-snapshot', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function weeklySnapshotData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 10;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path.'.weekly-snapshot', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function monthlySnapshotData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 9;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path.'.monthly-snapshot', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function monthlyRankingData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 6;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;
            return view($this->page_path.'.monthly-ranking', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function fundPerformanceData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 18;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path.'.fund-performance', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function compareSchemeData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 19;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path.'.compare-scheme', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function performanceSnapshotData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 20;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path.'.performance-snapshot', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function calculatorsPageData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 44;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();
            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;
            if ($request->isMethod('post')) {
                session()->put('useremail', $request->useremail);
                session()->put('username', $request->username);
            }
            return view('themes.frontend.pages.calculators', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function redirectCalculator($service, Request $request)
    {
        return Socialite::driver($service)->redirect();
    }

    public function callbackCalculator(Request $request, $provider)
    {
        $frontconstants = Config('frontconstants');
        $webLang = __('web');
        $authLang = __('auth');
        $userSocial =   Socialite::driver($provider)->stateless()->user();

        $useremail = $userSocial->getEmail();
        $username = $userSocial->getName();

        if ($useremail == '' || $useremail === null) {
            return redirect()->route('web.calculators')->with('alert', $frontconstants['alert_css']['3'])->with('message', $authLang['warning']['email_not_provided'])->with('title', $webLang['warning_ttl']);
        }

        session()->put('useremail', $useremail);
        session()->put('username', $username);

        return redirect()->route('web.calculators');
    }

    public function thoughtsAndOpinionOnFundsData(Request $request)
    {
        $dataArr = PageModel::getData($this->class_id, '', 24);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $fundSgsListMdl = [];

            $commonconstants = Config('commonconstants');

            $status = $commonconstants['status_val']['1'];

            $fundSgsListMdl = FundSuggestion::list(['status' => $status], ['title', 'description', 'file']);

            $pthPgsMdl = PageModel::pageList(['ids' => [21, 22, 23, 24, 25], 'status' => $status], ['title', 'slug', 'template_id'], 'c_order', 'ASC');
            $stngDataArr = SettingsModel::getSettingsArr(['paathshaala_heading', 'paathshaala_image', 'newsletter_heading', 'newsletter_description'], $status);

            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['pdf_dir_name']), "setting_folder" => Core::getUploadedURL($commonconstants['setting_dir_name']), "web_lang" => __('web')));

            return view('themes.frontend.pages.thoughts-and-opinion-on-funds', compact('defDataArr', 'dataArr', 'fundSgsListMdl', 'pthPgsMdl', 'stngDataArr'));
        }
        return abort(404);
    }

    public function newsData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 27;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $dataListMdl = [];

            $commonconstants = Config('commonconstants');

            $dataListMdl = News::list(['status' => $commonconstants['status_val']['1']], ['title', 'slug', 'media_type', 'image', 'video_from', 'video_data', 'video_image', 'news_source_link']);

            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['news_dir_name'])));

            return view('themes.frontend.pages.in-the-news', compact('defDataArr', 'dataArr', 'dataListMdl'));
        }
        return abort(404);
    }

    public function pentatecData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 29;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view('themes.frontend.pages.pentatec-filter', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }
}
