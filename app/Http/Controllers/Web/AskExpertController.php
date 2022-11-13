<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController as BaseController;
use Illuminate\Http\Request;

use Validator;

use App\Lib\Core\Core;
use App\Lib\Core\MailPS;
use App\Lib\App\Common;

use App\Models\PageModel;
use App\Models\AskExpertTopic;
use App\Models\AskExpertQuestion;
use App\Models\AskExpertQuestionAnswer;
use App\Models\User;

class AskExpertController extends BaseController
{
  public function __construct()
  {
    $this->defDataArr = self::getDefData();
    $this->page_path =env('PAGE_PATHS','web.pages');
  }

  public function askExpertData(Request $request)
  {
    $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 16);

    if (!empty($dataArr)) {
      $dataArr['full_url'] = $request->fullUrl();

      $meta_title = $dataArr['meta_title'];
      $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
      $meta_descp = $dataArr['meta_descp'];
      $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

      $dataArr['aet_id'] = 0;
      $dataArr['parent'] = 0;

      $dataList = $filterArr = $topicsModel = $expertUsersArr = [];

      if ($request->has('ms') || $request->has('mt')) {
        $validator = Validator::make(['ms' => $request->query('ms'), 'mt' => $request->query('mt')], [
          'ms' => 'nullable|regex:/(^[A-Za-z0-9 ]+$)+/|max:50',
          'mt' => 'nullable|numeric'
        ]);
        if ($validator->fails()) {
          abort(404);
        } else {
          if ($request->has('ms')) {
            $filterArr['search'] = $request->query('ms');
          }
          if ($request->has('mt')) {
            $filterArr['aet_id'] = $request->query('mt');
          }
        }
      }

      $commonconstants = Config('commonconstants');

      $filterArr['status'] = $commonconstants['status_val']['1'];

      $emObj = new AskExpertQuestion;

      $dataList = $emObj->list($filterArr, false, 'created_at', 'DESC', $commonconstants['pagination_no_front']);
      $countArr = $emObj->listCount($filterArr);
      // dd($dataList);

      $filterArrTopic['status'] = $commonconstants['status_val']['1'];
      $filterArrTopic["parent"] = 0;
      $topicsModel = AskExpertTopic::list($filterArrTopic, '', 'c_order', 'ASC');

      $expertUsersArr = User::usersListByGroup($commonconstants['expert_group_id'], ['f_name', 'l_name', 'profile', 'about', 'p_picture']);

      $defDataArr = array("media_folder" => Core::getUploadedURL($commonconstants['aeq_dir_name']), "user_media_folder" => $commonconstants['user_dir_name'], "askexpert_lang" => __('askexpert'), "other_topic_id" => $commonconstants['other_aet_id'], 'q_like_type' => $commonconstants['like_type']['value'][0], 'a_like_type' => $commonconstants['like_type']['value'][1], "video_type" => $commonconstants['video_type']['value']);

      return view($this->page_path.'.ask-expert', compact('dataArr', 'defDataArr', 'dataList', 'countArr', 'topicsModel', 'expertUsersArr'));
    }
    return abort(404);
  }

  public function askExpertTopicData(Request $request, $slug)
  {
    $topic = [];

    $pgDataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 16, ['title', 'descp']);

    $commonconstants = Config('commonconstants');

    $topic = AskExpertTopic::getData(0, $commonconstants['status_val']['1'], false, $slug);
    if ($topic) {
      $dataArr = $topic->toArray();

      $dataArr['full_url'] = $request->fullUrl();

      $dataArr['meta_title'] = strip_tags($dataArr['title']);
      $dataArr['meta_descp'] = '';
      $dataArr['title'] = $pgDataArr['title'];
      $dataArr['descp'] = $pgDataArr['descp'];
      $dataArr['req_slug'] = $slug;

      $mediaFolder = Core::getUploadedURL($commonconstants['media_dir_name']);
      if (!empty($dataArr['media'])) {
        $dataArr['image_path'] = $mediaFolder . $dataArr['media']['path'];
        $dataArr['image_alt'] = $dataArr['media']['alt'];
        $dataArr['image_title'] = $dataArr['media']['title'];
      }

      $dataList = $filterArr = $topicsModel = $expertUsersArr = [];

      if ($request->has('ms')) {
        $validator = Validator::make(['ms' => $request->query('ms')], [
          'ms' => 'nullable|regex:/(^[A-Za-z0-9 ]+$)+/|max:50'
        ]);
        if ($validator->fails()) {
          abort(404);
        } else {
          $filterArr['search'] = $request->query('ms');
        }
      }

      $topicId = $topic->aet_id;
      if ($topicId == $commonconstants['other_aet_id']) {
        $filterArr['parent_topic_id'] = $commonconstants['other_aet_id'];
      } else {
        $filterArr['aet_id'] = $topicId;
      }

      $filterArr['status'] = $commonconstants['status_val']['1'];

      $emObj = new AskExpertQuestion;

      $dataList = $emObj->list($filterArr, false, 'created_at', 'DESC', $commonconstants['pagination_no_front']);
      $countArr = $emObj->listCount($filterArr);

      $filterArrTopic['status'] = $commonconstants['status_val']['1'];
      $filterArrTopic["parent"] = 0;
      $topicsModel = AskExpertTopic::list($filterArrTopic, '', 'c_order', 'ASC');

      $expertUsersArr = User::usersListByGroup($commonconstants['expert_group_id'], ['f_name', 'l_name', 'profile', 'about', 'p_picture']);

      $defDataArr = array("media_folder" => Core::getUploadedURL($commonconstants['media_dir_name']), "user_media_folder" => $commonconstants['user_dir_name'], "askexpert_lang" => __('askexpert'), "other_topic_id" => $commonconstants['other_aet_id'], 'q_like_type' => $commonconstants['like_type']['value'][0], 'a_like_type' => $commonconstants['like_type']['value'][1], "video_type" => $commonconstants['video_type']['value']);

      return view('themes.frontend.pages.ask-expert', compact('dataArr', 'defDataArr', 'countArr', 'expertUsersArr', 'dataList', 'topicsModel'));
    }
    return abort(404);
  }

  public function askQuestionData(Request $request)
  {
    $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 17);

    if (!empty($dataArr)) {
      $dataArr['full_url'] = $request->fullUrl();

      $meta_title = $dataArr['meta_title'];
      $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
      $meta_descp = $dataArr['meta_descp'];
      $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

      $topicsModel = [];

      $commonconstants = Config('commonconstants');

      $topicsModel = AskExpertTopic::list(['status' => $commonconstants['status_val'][1], 'parent' => 0], '', 'c_order', 'ASC');

      $defDataArr = array("media_folder" => Core::getUploadedURL($commonconstants['media_dir_name']), "other_aet_id" => $commonconstants['other_aet_id'], 'video_types' => $commonconstants['video_type']);

      return view('themes.frontend.pages.ask-question', compact('dataArr', 'defDataArr', 'topicsModel'));
    }
    return abort(404);
  }

  public function askQuestionSave(Request $request)
  {
    $commonconstants = Config('commonconstants');
    $frontconstants = Config('frontconstants');

    $message = __('message');
    $webLang = __('web');

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

    if ($response['success'] && $response['action'] == 'askquestionpage' && $response['score'] > $commonconstants['recaptcha']['score']) {
      $validator = Validator::make($request->all(), [
        'aet_id' => 'required',
        'question' => 'required',
        'picture1' => 'nullable|image|mimes:jpeg,png,jpg|max:' . $frontconstants['aeq_img_upld_max_size'] . '',
        'picture2' => 'nullable|image|mimes:jpeg,png,jpg|max:' . $frontconstants['aeq_img_upld_max_size'] . '',
        'picture3' => 'nullable|image|mimes:jpeg,png,jpg|max:' . $frontconstants['aeq_img_upld_max_size'] . '',
        'local_video' => 'nullable|file|mimes:mp4|max:' . $frontconstants['aeq_vdo_upld_max_size'] . '',
        'yt_video' => 'nullable|url',
      ], [
        'aet_id.required' => __('front.validation.required.aet_id'),
        'picture1.max' => __('front.validation.img_file_upload_max_sz5'),
        'picture2.max' => __('front.validation.img_file_upload_max_sz5'),
        'picture3.max' => __('front.validation.img_file_upload_max_sz5'),
        'local_video.max' => __('front.validation.vid_file_upload_max_sz100'),
        'yt_video.url' => __('message.error.valid_url'),
      ]);

      $videoTypeLocal = $commonconstants['video_type']['value']['0'];
      $videoTypeYtube = $commonconstants['video_type']['value']['1'];

      $validator->after(function () use ($request, $validator, $videoTypeLocal, $videoTypeYtube) {
        $videoFrom = $request->input('video_type');
        if ($videoFrom) {
          switch ($videoFrom) {
            case $videoTypeLocal:
              if (!$request->hasFile('local_video')) {
                $validator->errors()->add('local_video', __('front.validation.required.video_file'));
              }
              break;
            case $videoTypeYtube:
              if (!$request->input('yt_video')) {
                $validator->errors()->add('yt_video', __('front.validation.required.youtube_code'));
              }
              break;
          }
        }
      });

      if ($validator->fails()) {
        return redirect()->back()->withInput()->withErrors($validator);
      }

      $message = __('message');
      $webLang = __('web');
      $frontLang = __('front');

      $userId = self::getLoggedInUserId();

      if ($request->aet_id == $commonconstants['other_aet_id']) {
        if ($request->title != "") {
          $objModel = new AskExpertTopic();
          $data = $objModel->where('title', $request->title)->get()->first();
          if ($data) {
            $aet_id = $data->aet_id;
          } else {
            $objModel->title = $request->title;
            $objModel->slug = Common::generateSlug($request->title, 'ask_expert_topic', '', '', '');
            $objModel->media_id = 0;
            $objModel->c_order = 0;
            $objModel->parent = $commonconstants['other_aet_id'];
            $objModel->status = $commonconstants['status_val'][2];
            $objModel->created_medium = $commonconstants['medium']['value']['1'];
            $objModel->created_by = $commonconstants['cu_by_val']['2'];
            $objModel->created_id = $userId;
            $objModel->updated_at = $commonconstants['null'];

            if ($objModel->save()) {
              $aet_id = $objModel->aet_id;
            } else {
              return back()->withInput()->with('alert', $frontconstants['alert_css']['2'])->with('message', $message['error']['data_saved'])->with('title', $webLang['error_ttl']);
            }
          }
        } else {
          return back()->withInput()->with('alert', $frontconstants['alert_css']['2'])->with('message', $frontLang['error']['other_topic_required'])->with('title', $webLang['error_ttl']);
        }
      } else {
        $aet_id = $request->aet_id;
      }

      $objModelQue = new AskExpertQuestion();

      $objModelQue->aet_id = $aet_id;
      $objModelQue->question = $request->input('question');
      $objModelQue->status = $commonconstants['status_val'][2];
      $objModelQue->u_id = $userId;
      $objModelQue->updated_at = $commonconstants['null'];

      $upldDirName = $commonconstants['aeq_dir_name'];
      if ($request->hasFile('picture1')) {
        $file      = $request->file('picture1');
        $title     = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $filename  = 'aeq-img1-' . time() . '-' . Core::removeSpecialChars($title) . '.' . $extension;

        $path      = $file->storeAs($upldDirName, $filename);
        if ($path) {
          $objModelQue->image1 = $filename;
        } else {
          return back()->with('alert', $frontconstants['alert_css']['2'])->with('message', $message['error']['img_upload'])->with('title', $webLang['error_ttl']);
        }
      }
      if ($request->hasFile('picture2')) {
        $file      = $request->file('picture2');
        $title     = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $filename  = 'aeq-img2-' . time() . '-' . Core::removeSpecialChars($title) . '.' . $extension;

        $path      = $file->storeAs($upldDirName, $filename);
        if ($path) {
          $objModelQue->image2 = $filename;
        } else {
          return back()->with('alert', $frontconstants['alert_css']['2'])->with('message', $message['error']['img_upload'])->with('title', $webLang['error_ttl']);
        }
      }
      if ($request->hasFile('picture3')) {
        $file      = $request->file('picture3');
        $title     = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $filename  = 'aeq-img3-' . time() . '-' . Core::removeSpecialChars($title) . '.' . $extension;

        $path      = $file->storeAs($upldDirName, $filename);
        if ($path) {
          $objModelQue->image3 = $filename;
        } else {
          return back()->with('alert', $frontconstants['alert_css']['2'])->with('message', $message['error']['img_upload'])->with('title', $webLang['error_ttl']);
        }
      }
      $videoFrom = $request->input('video_type');
      if ($videoFrom) {
        $objModelQue->video_from = $videoFrom;
        switch ($videoFrom) {
          case $videoTypeLocal:/*Local*/
            if ($request->hasFile('local_video')) {
              $file2      = $request->file('local_video');
              $title2     = pathinfo($file2->getClientOriginalName(), PATHINFO_FILENAME);
              $extension2 = pathinfo($file2->getClientOriginalName(), PATHINFO_EXTENSION);
              $filename2  = 'aeq-vid-' . time() . '-' . Core::removeSpecialChars($title2) . '.' . $extension2;

              $path2      = $file2->storeAs($upldDirName, $filename2);
              if ($path2) {
                $objModelQue->video_data = $filename2;
              } else {
                return back()->with('alert', Config('adminconstants.alert_css.2'))->with('message', __('message.error.vdo_upload'))->with('title', __('admin.error_ttl'));
              }
            }
            break;
          case $videoTypeYtube:/*Youtube*/
            $youtubeCode = $request->input('yt_video');
            if ($youtubeCode != "") {
              $objModelQue->video_data = $youtubeCode;
            }
            break;
        }
      }

      if ($objModelQue->save()) {
        $authUsr = self::getLoggedInUserProfileInfo();

        $fullname = $authUsr['f_name'] . " " . $authUsr['l_name'];
        $mailArr = ["fullname" => rtrim($fullname)];

        $mailPSObj = new MailPS();
        $mailCssAtr = $mailPSObj->getEmailHtmlCssAtr();

        $commaSign = $commonconstants['comma_sign'];

        $content = view('emails.web.to-admin-ask-expert-question', compact('mailArr', 'mailCssAtr', 'commaSign'));

        $toEmail = $mailPSObj->getToEmail();

        $aeLang = __('askexpert.mail');

        $subject = $aeLang['question']['subject'];
        $fromName = $aeLang['from_name'];

        $mailResp = $mailPSObj->sendMail($toEmail, $subject, $content, '', $fromName);
        if ($mailResp) {
          return back()->with('alert', $frontconstants['alert_css']['1'])->with('message', $frontLang['success']['question_save'])->with('title', $webLang['success_ttl']);
        } else {
          return back()->with('alert', $frontconstants['alert_css']['2'])->with('message', $message['error']['email_send'])->with('title', $webLang['error_ttl']);
        }
      } else {
        return back()->withInput()->with('alert', $frontconstants['alert_css']['2'])->with('message', $message['error']['data_saved'])->with('title', $webLang['error_ttl']);
      }
    } else {
      /*
            then probably this is a bot
            you can do your logic here pass it or deny or do something special
            score check value of 0.5 you can set which you want form 0 to 1
            score 1 is probably human score 0 is probably bot
            */
      return back()->withInput()->with('alert', $frontconstants['alert_css']['2'])->with('message', $message['error']['recaptcha'])->with('title', $webLang['error_ttl']);
    }
  }

  public function addAnswerData(Request $request, $aeq_id)
  {
    $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 42);
    if (!empty($dataArr)) {
      $dataArr['full_url'] = $request->fullUrl();

      $meta_title = $dataArr['meta_title'];
      $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
      $meta_descp = $dataArr['meta_descp'];
      $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

      return view('themes.frontend.pages.add-answer', compact('dataArr', 'aeq_id'));
    }
    return abort(404);
  }

  public function answerSave(Request $request, $aeq_id)
  {
    $commonconstants = Config('commonconstants');
    $frontconstants = Config('frontconstants');

    $message = __('message');
    $webLang = __('web');

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

    if ($response['success'] && $response['action'] == 'askanswerpage' && $response['score'] > $commonconstants['recaptcha']['score']) {
      $vldtrRules = [
        'answer' => 'required',
      ];

      $vldtrMessages = [];

      $validator = Validator::make($request->all(), $vldtrRules, $vldtrMessages);

      if ($validator->fails()) {
        return redirect()->back()->withInput()->withErrors($validator);
      }

      $frontLang = __('front');

      $question = AskExpertQuestion::find($aeq_id);

      if ($question) {
        $status = $request->stype;

        $objModel = new AskExpertQuestionAnswer();

        $objModel->aet_id = $question->aet_id;
        $objModel->aeq_id = $aeq_id;
        $objModel->answer = $request->answer;
        $objModel->status = $status;
        $objModel->u_id = self::getLoggedInUserId();
        $objModel->updated_by = $commonconstants['cu_by_val'][2];
        $objModel->updated_id = self::getLoggedInUserId();
        $objModel->updated_at = $commonconstants['null'];
        if ($objModel->save()) {
          if ($status == $commonconstants['status_val']['1']) {
            $authUsr = self::getLoggedInUserProfileInfo();

            /*Send email to ask question user*/
            $mailResp = $objModel->sendMailToQuestionUser($question, $authUsr);
            /*if( !$mailResp )
              {
                \DB::rollBack();

                return redirect()->back()->withInput()->with('alert', $frontconstants['alert_css']['2'])->with('message', $message['error']['email_send'])->with('title', $webLang['error_ttl']);
              }*/
          }

          return back()->with('alert', $frontconstants['alert_css']['1'])->with('message', ($status == $commonconstants['status_val']['1']) ? $frontLang['success']['answer_save'] : $frontLang['success']['draft_answer_save'])->with('title', $webLang['success_ttl']);
        } else {
          return back()->withInput()->with('alert', $frontconstants['alert_css']['2'])->with('message', $message['error']['data_saved'])->with('title', $webLang['error_ttl']);
        }
      } else {
        return back()->withInput()->with('alert', $frontconstants['alert_css']['2'])->with('message', $message['error']['req_data_not_found'])->with('title', $webLang['error_ttl']);
      }
    } else {
      /*
            then probably this is a bot
            you can do your logic here pass it or deny or do something special
            score check value of 0.5 you can set which you want form 0 to 1
            score 1 is probably human score 0 is probably bot
            */
      return back()->withInput()->with('alert', $frontconstants['alert_css']['2'])->with('message', $message['error']['recaptcha'])->with('title', $webLang['error_ttl']);
    }
  }

  public function draftAnswerData(Request $request, $aeqa_id)
  {
    $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 42);
    if (!empty($dataArr)) {
      $dataArr['full_url'] = $request->fullUrl();

      $meta_title = $dataArr['meta_title'];
      $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
      $meta_descp = $dataArr['meta_descp'];
      $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

      $answer = AskExpertQuestionAnswer::getAnswerData(['aeqa_id' => $aeqa_id, 'u_id' => self::getLoggedInUserId(), 'status' => Config('commonconstants.status_val.3')],  ['aeqa_id', 'answer']);

      return view('themes.frontend.pages.add-answer', compact('dataArr', 'answer'));
    }

    return abort(404);
  }

  public function draftAnswerSave(Request $request, $aeqa_id)
  {
    $commonconstants = Config('commonconstants');
    $frontconstants = Config('frontconstants');

    $message = __('message');
    $webLang = __('web');

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

    if ($response['success'] && $response['action'] == 'askanswerpage' && $response['score'] > $commonconstants['recaptcha']['score']) {
      $vldtrRules = [
        'answer' => 'required',
      ];

      $vldtrMessages = [];

      $validator = Validator::make($request->all(), $vldtrRules, $vldtrMessages);

      if ($validator->fails()) {
        return back()->withInput()->withErrors($validator);
      }

      $frontLang = __('front');

      $lgnUserId = self::getLoggedInUserId();

      $objModel = AskExpertQuestionAnswer::getAnswerData(['aeqa_id' => $aeqa_id, 'u_id' => $lgnUserId, 'status' => $commonconstants['status_val'][3]]);
      if ($objModel) {
        $status = $request->stype;

        $objModel->answer = $request->answer;
        $objModel->status = $status;
        $objModel->updated_by = $commonconstants['cu_by_val'][2];
        $objModel->updated_id = $lgnUserId;
        if ($objModel->save()) {
          if ($status == $commonconstants['status_val']['1']) {
            $authUsr = self::getLoggedInUserProfileInfo();

            /*Send email to ask question user*/
            $mailResp = $objModel->sendMailToQuestionUser($objModel->question, $authUsr);
            /*if( !$mailResp )
              {
                return redirect()->back()->withInput()->with('alert', $frontconstants['alert_css']['2'])->with('message', $message['error']['email_send'])->with('title', $webLang['error_ttl']);
              }*/

            /*Push Notification*/
            $sendRspns = $objModel->sendPushNtfctnToQuestionUser($objModel->question, $authUsr, $objModel->aeq_id);
          }

          return redirect()->route('web.add-answer', $objModel->aeq_id)->with('alert', $frontconstants['alert_css']['1'])->with('message', ($status == $commonconstants['status_val']['1']) ? $frontLang['success']['answer_save'] : $frontLang['success']['draft_answer_save'])->with('title', $webLang['success_ttl']);
        } else {
          return back()->withInput()->with('alert', $frontconstants['alert_css']['2'])->with('message', $message['error']['data_saved'])->with('title', $webLang['error_ttl']);
        }
      } else {
        return back()->withInput()->with('alert', $frontconstants['alert_css']['2'])->with('message', $message['error']['req_data_not_found'])->with('title', $webLang['error_ttl']);
      }
    } else {
      /*
            then probably this is a bot
            you can do your logic here pass it or deny or do something special
            score check value of 0.5 you can set which you want form 0 to 1
            score 1 is probably human score 0 is probably bot
            */
      return back()->withInput()->with('alert', $frontconstants['alert_css']['2'])->with('message', $message['error']['recaptcha'])->with('title', $webLang['error_ttl']);
    }
  }

  public function deleteAnswerDraft($id)
  {
    $commonconstants = Config('commonconstants');
    $frontconstants = Config('frontconstants');

    $message = __('message');
    $webLang = __('web');

    $status = $commonconstants['status_val'][3];

    \DB::beginTransaction();

    if ($id == 'all') {
      $status =  AskExpertQuestionAnswer::where(['status' => $status, 'u_id' => self::getLoggedInUserId()])->delete();
      if ($status) {
        \DB::commit();

        return back()->with('alert', $frontconstants['alert_css']['1'])->with('message', $message['success']['delete'])->with('title', $webLang['success_ttl']);
      } else {
        \DB::rollBack();

        return back()->with('alert', $frontconstants['alert_css']['2'])->with('message', $message['error']['delete'])->with('title', $webLang['error_ttl']);
      }
    } else {
      $objModel = AskExpertQuestionAnswer::getAnswerData(['aeqa_id' => $id, 'u_id' => self::getLoggedInUserId(), 'status' => $status]);
      if ($objModel) {
        if ($objModel->delete()) {
          \DB::commit();

          return back()->with('alert', $frontconstants['alert_css']['1'])->with('message', $message['success']['delete'])->with('title', $webLang['success_ttl']);
        } else {
          \DB::rollBack();

          return back()->with('alert', $frontconstants['alert_css']['2'])->with('message', $message['error']['delete'])->with('title', $webLang['error_ttl']);
        }
      } else {
        \DB::rollBack();

        return back()->with('alert', $frontconstants['alert_css']['2'])->with('message', $message['error']['req_data_not_found'])->with('title', $webLang['error_ttl']);
      }
    }
  }

  public function answerDraftData(Request $request)
  {
    $dataArr = PageModel::getData(self::getClassIdBymodel('PageModel'), '', 43);
    if (!empty($dataArr)) {
      $dataArr['full_url'] = $request->fullUrl();

      $meta_title = $dataArr['meta_title'];
      $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
      $meta_descp = $dataArr['meta_descp'];
      $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

      $commonconstants = Config('commonconstants');

      $dataList = [];

      $dataList = AskExpertQuestionAnswer::answerList(['status' => $commonconstants['status_val'][3], 'u_id' => self::getLoggedInUserId()], false, 'aeqa_id', 'DESC', $commonconstants['pagination_no_front']);

      $defDataArr = array("user_media_folder" => $commonconstants['user_dir_name'], "askexpert_lang" => __('askexpert'));

      return view('themes.frontend.pages.draft-answers', compact('dataArr', 'defDataArr', 'dataList'));
    }
    return abort(404);
  }
}
