<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Validator;

use App\Lib\Core\Core;
use App\Lib\Core\MailPS;

use App\Models\PageModel;
use App\Models\EnquiryModel;

class EnquiryController extends BaseController
{
  public function __construct()
  {
    $this->defDataArr = self::getDefData();
  }

  public function contactData(Request $request, $slug = false)
  {
    $dataId = 0;
    if ($slug == false || $slug == '') {
      $dataId = 4;
    }

    $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), $slug, $dataId);
    if (!empty($dataArr)) {

      $dataArr['full_url'] = route('web.contact');

      $meta_title = $dataArr['meta_title'];
      $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
      $meta_descp = $dataArr['meta_descp'];
      $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

      $commonconstants = Config('commonconstants');

      $defDataArr = array_merge($this->defDataArr, array("media_folder" => Core::getUploadedURL($commonconstants['media_dir_name']), "web_lang" => __('web')));

      return view('themes.frontend.pages.contact', compact('dataArr', 'defDataArr'));
    }
    return abort(404);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function storeContact(Request $request)
  {
    $commonconstants = Config('commonconstants');
    $frontconstants = Config('frontconstants');

    $message = __('message');
    $webLang = __('web');
    $resArr['msg'] = "";
    $resArr['url'] = "";

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
    // $resArr['msg'] = $response;
    // return json_encode($resArr);
    if ($response['success'] && $response['action'] == 'contact_form' && $response['score'] > $commonconstants['recaptcha']['score']) {
      $vldtrRules = [
        'name' => 'required',
        'email' => 'required|email',
        'mobile' => 'nullable|numeric',
        'message' => 'required'
      ];

      $vldtrMessages = [];

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

        $store = new EnquiryModel($input);

        $store->u_id = self::getLoggedInUserId();
        if ($store->save()) {
          $fullname = $input['name'];
          $mailArr = ["fullname" => rtrim($fullname)];

          $mailPSObj = new MailPS();
          $mailCssAtr = $mailPSObj->getEmailHtmlCssAtr();

          $commaSign = $commonconstants['comma_sign'];

          $content = view('emails.web.to-admin-contact', compact('mailArr', 'mailCssAtr', 'commaSign'));

          $toEmail = $mailPSObj->getToEmail();

          $contactLang = __('contact');

          $subject = $contactLang['mail_sbjct'];
          $fromName = $contactLang['mail_f_name'];

          $mailResp = $mailPSObj->sendMail($toEmail, $subject, $content, '', $fromName);
          if ($mailResp) {
            $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['1'] . '">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
                            <strong>' . $webLang['success_ttl'] . '&nbsp;</strong> 
                            ' . $message['success']['contact_form_send'] . '
                        </div>';

            $page_class_id = self::getClassIdBymodel('PageModel');
            $dataArr = PageModel::getData($page_class_id, '', 5);
            if (!empty($dataArr)) {
              $slug = $dataArr['slug'];
              if ($slug) {
                $resArr['url'] = route('web.thankyou', $slug);
              }
            }
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
}
