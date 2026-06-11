<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Web\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Newsletter;
use App\Lib\Core\Core;
use App\Lib\Core\MailPS;

class NesletterController extends BaseController
{
    public function StoreNewsLetter(Request $request){
        $frontconstants = Config('frontconstants');
        $commonconstants = Config('commonconstants');
        $message = __('message');
        $webLang = __('web');
        $resArr['msg'] = "";
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
            return response()->json($validator->getMessageBag()->toArray()['email'],422);
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
                        <strong>' . $webLang['success_ttl'] . '&nbsp;</strong> 
                        ' . $message['success']['newsletter_add'] . '
                    </div>';
                } else {
                    $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                        <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                        ' . $message['error']['email_send'] . '
                    </div>';
                }
            }
        } catch (QueryException $exception) {
            $resArr['msg'] = '<div class="alert alert-' . $frontconstants['alert_css']['2'] . '">
                <strong>' . $webLang['error_ttl'] . '&nbsp;</strong> 
                ' . $message['error']['data_saved'] . '
            </div>';
        }
        return json_encode($resArr);
    }
}
