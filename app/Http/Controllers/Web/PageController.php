<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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
use App\Models\NewFromMyplexus;
// use App\Plans;
use App\Models\SettingsModel;
use App\Models\Teams;
use App\Models\BlogModel;
use Session;
use Socialite;
use App\Models\FundWatchNew;
use App\Models\CalculatorRegister;

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
        $this->BlogImagePath = url('/') . '/' . Config('commonconstants.blog_dir_name_front_end');
    }

    public function getNewsApi()
    {
        $incoming = @file_get_contents('https://www.moneycontrol.com/rss/latestnews.xml');
        if (! $incoming) {
            return '';
        }
        $xml = preg_replace('#&(?=[a-z_0-9]+=)#', '&amp;', $incoming);
        $xml = simplexml_load_string($xml);
        if (! $xml) {
            return '';
        }
        $return_array = array();
        $html = [];
		$p = [];
		$htm = "";
		$i=1;
		$count = 0;
        foreach ($xml->channel as $value) {			
            foreach ($value->item as $row) {				
				$i++;
					//echo $i;
		/*$html['data'][] = "<div class='single_slider_nav'><p><a href='" . $row->link . "' target='_blank'>" . $row->title ."</a></p><p>Testing Data One</p><p>Testing Data Two</p></div>";*/	
		
		$p['data'][] = "<p><a href='" . $row->link . "' target='_blank'>" . $row->title ."</a></p>";
            }
			
			//$html['data'][] = "<div class='single_slider_nav'></div>";
        }
		
		$arrays = array_chunk($p['data'], 2);
		
		//dd($arrays);
		
		//dd( array_chunk($html['data'], 2) );
        //dd($i);
        //$return_array["html"] = $html;
		
		foreach ($arrays as $array_num => $array) {
			$htm = "<div class='single_slider_nav'>";
		  //echo "Array $array_num:\n";
			//dd($array);
		  foreach ($array as $item_num => $item) {
			  $htm .= $item;
			//echo "  Item $item_num: $item\n";
		  }
			$htm .= "</div>";
			
			$html['data'][] = $htm;
			$htm = "";
		}
		//dd($html['data']);
        return json_encode($html);
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
		$blogResponses = [];
		
        if ($slug == false || $slug == '') {
            $dataId = 1;
        }
		
		$apiURL = 'https://blog.myplexus.com/wp-json/wp/v2/posts';		
		$blogResponses = $this->blogData($apiURL);
		
		$apiURL = 'https://www.myplexus.com/api/v1/funds';
        $fundReponses = $this->DropDownData($apiURL);
		
		$apiURL = 'https://www.myplexus.com/api/v1/fund-classifications';
        $performaceResponses = $this->DropDownData($apiURL);
		
		//dd($performaceResponses);
		
		//dd($fundReponses['data']);
		
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
            $blogPosts=BlogModel::where('status', 1)
            ->orderBy('updated_at', 'desc')
            ->limit(3)
            ->get();
            $nwsListMdl = News::list(['status' => $commonconstants['status_val']['1']], ['title', 'slug', 'media_type', 'image', 'video_from', 'video_data', 'video_image', 'news_source_link'], '', '', 3);

            $aeQuesMdl = AskExpertQuestion::list(['status' => $status], '', 'created_at', 'DESC', 1);

            //$fndWtchMdl = FundWatch::frontList([], '', '', '', 2);
			$fndWtchMdl = FundWatchNew::where('status','1')->orderBy('id','desc')->with('fundDetails')->get();	
			
			
			//dd($fndWtchMdl);

            $nfoMdl = NfoOffer::frontList([], '', '', '','',5);
			
			$allnewfroms = Schema::hasTable('new_from_myplexus') ? NewFromMyplexus::all() : collect();
			
			//dd($allnewfroms);
			
            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['media_dir_name']), "setting_folder" => Core::getUploadedURL($commonconstants['setting_dir_name']), "news_folder" => Core::getUploadedURL($commonconstants['news_dir_name']), "user_media_folder" => $commonconstants['user_dir_name'], "payment_lang" => __('payment'), "yes_no_txt" => __('common.yes_no_txt'), "web_lang" => __('web')));
            // dd($defDataArr);
            $BlogImagePath=$this->BlogImagePath;
            return view('web.home.index', compact('defDataArr', 'dataArr', 'bnrMdl', 'nwsApiData', 'fundManMdl', 'tstmnlMdl', 'pthPgsMdl', 'stngDataArr','blogPosts','BlogImagePath', 'nwsListMdl', 'aeQuesMdl', 'fndWtchMdl', 'nfoMdl', 'blogResponses', 'fundReponses', 'performaceResponses', 'allnewfroms'));
        }
        return abort(404);
    }
	
    public function DropDownData($apiURL)
    {
        try {
            $response = Http::timeout(5)->get($apiURL, []);
            if (! $response->successful()) {
                return ['success' => false, 'data' => []];
            }

            return $response->json() ?? ['success' => false, 'data' => []];
        } catch (\Throwable $th) {
            return ['success' => false, 'data' => []];
        }
        //dd($responseBody);
    }
	
	public function blogData($apiURL)
	{
		$blogs = [];
		$parameters = ['per_page' => 3];
        try {
		    $response = Http::timeout(5)->get($apiURL, $parameters);
            if (! $response->successful()) {
                return [];
            }
		    $responseBody = $response->json();
        } catch (\Throwable $th) {
            return [];
        }
		
		//dd($responseBody);
		
		if(!empty($responseBody))
		{
			foreach($responseBody as $response)
			{	
				
				$blogs[] = array(
					
					'img' => $this->blogImage($response['featured_media']),
					'title' => html_entity_decode($response['title']['rendered']),
					'short_desc' => $response['content']['rendered'],
					'link' => $response['link']
				
				);
			}
		}
		
		return $blogs;
		
		
	}
	
	public function blogImage($id)
	{
		
		$apiURL = 'https://blog.myplexus.com/wp-json/wp/v2/media/'.$id;		
		$parameters = "";
		$response = Http::get($apiURL, $parameters);
		$statusCode = $response->status();
		$responseBody = json_decode($response->getBody(), true);	
		$img_url = "";
		
        //dd($responseBody);

        if(array_key_exists('media_details', $responseBody))
        {
            if(isset($responseBody['media_details']['sizes']['full']['source_url']))
            {
                $img_url = $responseBody['media_details']['sizes']['full']['source_url'];
                
            } else {
                
                $img_url = $responseBody['media_details']['sizes']['medium']['source_url'];
            }
        }
		
		
		//dd($responseBody);
		
		return $img_url;
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


    public function performanceSynopsisData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 54;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path.'.performance-synopsis', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function thankYouData(Request $request, $slug = false)
    {
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 5;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path.'.thank-you', compact('defDataArr', 'dataArr'));
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

            return view($this->page_path.'.know-your-scheme', compact('defDataArr', 'dataArr'));
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

            // if ($id == 0) {
            //     $fundClsMdl = FundClassification::list(['status' => $status, 'take' => 1], ['fc_id', 'title', 'description', 'file']);
            //     if ($fundClsMdl) {
            //         $fundClsMdl = $fundClsMdl[0];
            //     }
            // } else {
            //     $fundClsMdl = FundClassification::getData(['fc_id' => $id, 'status' => $status], ['fc_id', 'title', 'description', 'file']);
            // }

            // if ($fundClsMdl) {
            //     $fundClsListMdl = FundClassification::list(['status' => $status], ['fc_id', 'title']);
            // }

            $pthPgsMdl = PageModel::pageList(['ids' => [21, 22, 23, 24, 25], 'status' => $status], ['title', 'slug', 'template_id'], 'c_order', 'ASC');
            $stngDataArr = SettingsModel::getSettingsArr(['paathshaala_heading', 'paathshaala_image', 'newsletter_heading', 'newsletter_description'], $status);

            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['pdf_dir_name']), "setting_folder" => Core::getUploadedURL($commonconstants['setting_dir_name']), "web_lang" => __('web')));

            return view($this->page_path.'.mutual-fund-classifications', compact('defDataArr', 'dataArr', 'fundClsMdl', 'fundClsListMdl', 'pthPgsMdl', 'stngDataArr'));
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

            // if ($id == 0) {
            //     $fundTxnMdl = FundTaxation::list(['status' => $status, 'take' => 1], ['ft_id', 'title', 'description', 'file']);
            //     if ($fundTxnMdl) {
            //         $fundTxnMdl = $fundTxnMdl[0];
            //     }
            // } else {
            //     $fundTxnMdl = FundTaxation::getData(['ft_id' => $id, 'status' => $status], ['ft_id', 'title', 'description', 'file']);
            // }

            // if ($fundTxnMdl) {
            //     $fundTxnListMdl = FundTaxation::list(['status' => $status], ['ft_id', 'title']);
            // }

            $pthPgsMdl = PageModel::pageList(['ids' => [21, 22, 23, 24, 25], 'status' => $status], ['title', 'slug', 'template_id'], 'c_order', 'ASC');
            $stngDataArr = SettingsModel::getSettingsArr(['paathshaala_heading', 'paathshaala_image', 'newsletter_heading', 'newsletter_description'], $status);

            $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['pdf_dir_name']), "setting_folder" => Core::getUploadedURL($commonconstants['setting_dir_name']), "web_lang" => __('web')));

            return view($this->page_path.'.mf-taxation', compact('defDataArr', 'dataArr', 'fundTxnMdl', 'fundTxnListMdl', 'pthPgsMdl', 'stngDataArr'));
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

            return view($this->page_path.'.know-the-ratio', compact('defDataArr', 'dataArr', 'pthPgsMdl', 'stngDataArr'));
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
	
	public function corpusDetailsData(Request $request, $slug = false)
    {
		
		 $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 51;
        }		

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
		
		//dd($dataArr);
		
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            $apiUrl = "https://www.myplexus.com/api/v1/fund-classifications";

            $responseData = $this->getData($apiUrl);

            //dd($responseData);

            return view($this->page_path.'.corpus-details', compact('defDataArr', 'dataArr'));
        }
        return abort(404);

    }

    public function getData($apiUrl)
    {
        try {
		    $response = Http::timeout(5)->get($apiUrl, "");
            if (! $response->successful()) {
                return ['success' => false, 'data' => []];
            }

            return $response->json() ?? ['success' => false, 'data' => []];
        } catch (\Throwable $th) {
            return ['success' => false, 'data' => []];
        }
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
			//dd($dataArr);

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
        // dd($this->class_id);
        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        // dd($dataArr);
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
        // dd($request->all());
        $dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 6;
        }
        // dd($dataId);
        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;
            // dd($dataArr);
            // dd($this->page_path);
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
			//print_r($defDataArr);
            //dd($this->page_path);
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
		//dd($dataArr);
		$dataArr['title'] = 'Category Performance Snapshot';
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;
			//dd($this->page_path);
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

                //data storing for loggin session
                $calculator_register = new CalculatorRegister();
                // dd($calculator_register);
                $calculator_register->username = $request->username;
                $calculator_register->email = $request->useremail;
                $calculator_register->save();
				return redirect('https://myplexus.com/calctest');
				//dd(url()->previous());				
            }
			
			//dd($request->fullUrl());
            return view($this->page_path.'.calculators', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

	 public function calculatorsPageDatas(Request $request, $slug = false)
    {
		// dd($request);
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
                // dd('post');
                session()->put('useremail', $request->useremail);
                session()->put('username', $request->username);

                
				return redirect(url()->previous());
				//dd(url()->previous());				
            }else{
                // dd('Not');
            }
			
			//dd($request->fullUrl());
            return view($this->page_path.'.calculatortest', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
    }

    public function redirectCalculator($service, Request $request)
    {
        // dd($request->all());
        // dd($service);
        // dd(Socialite::driver($service));
        // dd(Socialite);
        // $drivers = array_keys(config('services.socialite', []));
        // dd($drivers);
        return Socialite::driver($service)->redirect();
        // return Socialite::driver('google')->redirectUrl(config('services.google.calcredirect'))->redirect();
    }

    public function callbackCalculator(Request $request, $provider)
    {
        // dd($provider);
        if($provider=='google'){
            $provider = 'google-calc';
        }else{
            $provider = 'facebook-calc';
        }
        $frontconstants = Config('frontconstants');
        $webLang = __('web');
        $authLang = __('auth');
        $userSocial =   Socialite::driver($provider)->stateless()->user();
        // dd($userSocial);

        $useremail = $userSocial->getEmail();
        // dd($useremail);
        $username = $userSocial->getName();

        if ($useremail == '' || $useremail === null) {
            return redirect()->route('web.calculators')->with('alert', $frontconstants['alert_css']['3'])->with('message', $authLang['warning']['email_not_provided'])->with('title', $webLang['warning_ttl']);
        }

        $calculator_register = new CalculatorRegister();
        // dd($calculator_register);
        $calculator_register->username = $username;
        $calculator_register->email = $useremail;
        $calculator_register->platform = $provider=='google-calc'? '1' : '2';
        $calculator_register->save();

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

            return view($this->page_path.'.thoughts-and-opinion-on-funds', compact('defDataArr', 'dataArr', 'fundSgsListMdl', 'pthPgsMdl', 'stngDataArr'));
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
			
			//dd($dataListMdl);
			
			//dd($this->defDataArr);

            //$defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['news_dir_name'])));
			
			$defDataArr = array_merge($this->defDataArr, array("media_folder" => 'https://www.new.myplexus.com/storage/news/'));
			
			//dd($defDataArr);

            //return view('themes.frontend.pages.in-the-news', compact('defDataArr', 'dataArr', 'dataListMdl'));
			
			return view($this->page_path.'.in-the-news', compact('defDataArr', 'dataArr', 'dataListMdl'));			
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
	
	public function fundManDetailsData(Request $request, $slug = false)
	{
		$dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 51;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path.'.fund-man-details', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
	}
	
	public function fundManDetailsShridattaBhandwaldar(Request $request, $slug = false)
	{
		$dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 52;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path.'.shridatta-bhandwaldar', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
	}
	
	public function fundManDetailsShreyasDevalkar(Request $request, $slug = false)
	{
		$dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 53;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path.'.shreyas-devalkar', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
	}
	
	public function fundManDetailsAniruddhaNaha(Request $request, $slug = false)
	{
		$dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 54;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path.'.aniruddha-naha', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
	}
	
	public function fundManDetailsSanjayChawla(Request $request, $slug = false)
	{
		$dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 55;
        }

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path.'.sanjay-chawla', compact('defDataArr', 'dataArr'));
        }
        return abort(404);
	}
	
	public function returnCalculationData(Request $request, $slug = false)
	{
		$dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 56;
        }
		
		$apiURL = 'https://www.myplexus.com/api/v1/funds';
        $fundReponses = $this->DropDownData($apiURL);
		
		$apiURL = 'https://www.myplexus.com/api/v1/indices';
        $index_fundReponses = $this->DropDownData($apiURL);

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path.'.return-calculator', compact('defDataArr', 'dataArr', 'fundReponses', 'index_fundReponses'));
        }
        return abort(404);
	}
	
	public function volatilityCalculationData(Request $request, $slug = false) 
	{
		$dataId = 0;
        if ($slug == false || $slug == '') {
            $dataId = 57;
        }
		
		$apiURL = 'https://www.myplexus.com/api/v1/funds';
        $fundReponses = $this->DropDownData($apiURL);
		
		$apiURL = 'https://www.myplexus.com/api/v1/indices';
        $index_fundReponses = $this->DropDownData($apiURL);

        $dataArr = PageModel::getData($this->class_id, $slug, $dataId);
        if (!empty($dataArr)) {
            $dataArr['full_url'] = $request->fullUrl();

            $meta_title = $dataArr['meta_title'];
            $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
            $meta_descp = $dataArr['meta_descp'];
            $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

            $defDataArr = $this->defDataArr;

            return view($this->page_path.'.volatility-calculator', compact('defDataArr', 'dataArr', 'fundReponses', 'index_fundReponses'));
        }
        return abort(404);
	}
}
