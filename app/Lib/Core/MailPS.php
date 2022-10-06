<?php

namespace App\Lib\Core;

use Mail;
use App\Lib\Core\UsefulSql;
use App\Models\SettingsModel;

class MailPS extends Core
{
	/*public function __construct()
	{
		$this->imgRootUrl = Core::getImgDir();
	}*/

	public static $etFontFamily = '\'Open Sans\', sans-serif';
	public static $etTxtColor = "#222222";
	public static $etLnkColor = "#285799";
	public static $etH1Color = "#035880";
	public static $etH2Color = "#393939";
	public static $etFntNrml = "400";
	public static $etFntBold = "600";
	public static $etH1FntSize = "40px";
	public static $etH2FntSize = "22px";
	public static $etH3FntSize = "16px";
	public static $etTxtFntSize = "16px";
	public static $etTxtFntLineHght = "24px";
	public static $etFtrFntSize = "13px";

	public static $etSgnTxt1 = "Thank You,";
	public static $etSgnTxt2 = "Team myplexus";

	public static function getSettingsData($keysArr = false)
	{
		if ($keysArr == false) {
			$keysArr = ['google_play_app_link', 'apple_store_app_link'];
		}

		$dataArr = SettingsModel::getSettingsArr($keysArr);

		return $dataArr;
	}

	public static function getEmailHtmlCssAtr()
	{
		$dataArr = ["font_family" => self::$etFontFamily, "txt_color" => self::$etTxtColor, "lnk_color" => self::$etLnkColor, "h1_color" => self::$etH1Color, "h2_color" => self::$etH2Color, "fnt_nrml" => self::$etFntNrml, "fnt_bold" => self::$etFntBold, "h1_fnt_size" => self::$etH1FntSize, "h2_fnt_size" => self::$etH2FntSize, "txt_fnt_size" => self::$etTxtFntSize, "txt_fnt_line_height" => self::$etTxtFntLineHght, "h3_fnt_size" => self::$etH3FntSize, "txt_fnt_size" => self::$etTxtFntSize];
		return $dataArr;
	}

	public static function getToEmail()
	{
		$email = UsefulSql::getSingleValue('options', 'option_value', 'option_key', 'to_email');
		return $email;
	}

	public static function getFromEmail()
	{
		$email = UsefulSql::getSingleValue('options', 'option_value', 'option_key', 'from_email');
		return $email;
	}

	public static function getMailHeaderHtml()
	{
		$stngArr = self::getSettingsData(['email_template_logo']);
		$emailTemplateLogo = $stngArr['email_template_logo'] ?? '';

		$appName = Config('app.name');
		
		$html = '<!doctype html>
		<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
		<head>
			<!--[if gte mso 15]>
		<xml>
		<o:OfficeDocumentSettings>
			<o:AllowPNG />
			<o:PixelsPerInch>96</o:PixelsPerInch>
		</o:OfficeDocumentSettings>
		</xml>
		<![endif]-->
		<meta charset="UTF-8">
		<meta http-equiv="x-ua-compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="format-detection" content="telephone=no">
		<title>' . $appName . '</title>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
		<!-- Custom Stylesheets -->
		<style type="text/css">
		<style type="text/css">
		body {
			margin: 0;
			padding: 0;
			font-family: \'Open Sans\', sans-serif;
			-ms-text-size-adjust: 100%;
			-webkit-font-smoothing: antialiased;
			-moz-osx-font-smoothing: grayscale;
		}
		table {
			border-collapse: collapse;
			mso-table-lspace: 0;
			mso-table-rspace: 0;
		}
		p {
			margin: 0;
			padding: 0;
		}
		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			display: block;
			margin: 0;
			padding: 0;
		}
		img, a img {
			border: 0;
			height: auto;
			outline: none;
			text-decoration: none;
		}
		body,
		#bodyTable,
		#bodyCell {
			height: 100%;
			margin: 0;
			padding: 0;
			width: 100%;
		}
		#outlook a {
			padding: 0;
		}
		img {
			-ms-interpolation-mode: bicubic;
		}
		table {
			mso-table-lspace: 0;
			mso-table-rspace: 0;
		}
		.ReadMsgBody {
			width: 100%;
		}
		.ExternalClass {
			width: 100%;
		}
		p,
		a,
		li,
		td,
		blockquote {
			mso-line-height-rule: exactly;
		}
		a[href^=tel],
		a[href^=sms] {
			color: inherit;
			cursor: default;
			text-decoration: none;
		}
		p,
		a,
		li,
		td,
		body,
		table,
		blockquote {
			-ms-text-size-adjust: 100%;
			-webkit-text-size-adjust: 100%;
		}
		.ExternalClass,
		.ExternalClass p,
		.ExternalClass td,
		.ExternalClass div,
		.ExternalClass span,
		.ExternalClass font {
			line-height: 100%;
		}
		a[x-apple-data-detectors] {
			color: inherit !important;
			text-decoration: none !important;
			font-size: inherit !important;
			font-family: inherit !important;
			font-weight: inherit !important;
			line-height: inherit !important;
		}
		@media only screen and (max-width:660px) {
			table.container {
				width: 480px !important;
			}
			table.container_wrapper {
				width: 98% !important;
				padding: 0px 1%;
			}
			td.banner img {
				width: 100% !important;
				height: auto !important;
			}
			.logo .logoimg{
				width: 25% !important;
				height: auto !important;
			}
			.content {
				font-size: 16px !important;
				line-height: 20px !important;
			}
		}
		@media only screen and (max-width:510px) {
			table.container {
				width: 100% !important;
			}
			table.container_wrapper {
				width: 94% !important;
				padding: 0px 3%;
			}
			td.banner img {
				width: 100% !important;
				height: auto !important;
			}
			.content {
				font-size: 16px !important;
				line-height: 20px !important;
			}
			td.icon-mail img {
				width: 92px !important;
				height: auto !important;
			}
		}
	</style>
		</head>
		<body bgcolor="#FFFFFF">
	<table class="container" width="700" border="0" align="center" cellpadding="0" cellspacing="0"
		style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0;">';
		if($emailTemplateLogo != ''){
			$html .= '<tr>
				<td class="logo" align="left" valign="middle" style="margin: 0; padding: 10px 50px;">
					<img class="logoimg" src="' . Core::getUploadedURL(Config('commonconstants.setting_dir_name')) . $emailTemplateLogo . '" alt="' . $appName . '" title="' . $appName . '" width="225">
				</td>
			</tr>';
		}
		return $html;
	}

	/*
	* To hide signature area must pass "true" on function. 
	*/
	public static function getMailFooterHtml($hideSgntr = false, $signatureTxt1 = false)
	{
		$imgRootUrl = Core::getImgDir();
		$appName = Config('app.name');

		$etFontFamily = self::$etFontFamily;
		$etFntNrml = self::$etFntNrml;
		$etTxtColor = self::$etTxtColor;
		$etTxtFntSize = self::$etTxtFntSize;
		$etTxtFntLineHght = self::$etTxtFntLineHght;

		$stngArr = self::getSettingsData(['facebook', 'twitter', 'linkedin', 'to_email']);
		$facebook = $stngArr['facebook'];
		$twitter = $stngArr['twitter'];
		$linkedin = $stngArr['linkedin'];
		$toEmail = $stngArr['to_email'];

		if ($signatureTxt1 != '') {
			$etSgnTxt1 = $signatureTxt1;
		} else {
			$etSgnTxt1 = self::$etSgnTxt1;
		}

		$html = '';
		if ($hideSgntr == false) {
			$html .= '<tr>
			<td class="content" align="left" valign="top"
				style="margin:0; padding:0px 50px 35px; font-family:' . $etFontFamily . '; font-size:' . $etTxtFntSize . '; line-height:' . $etTxtFntLineHght . '; color:' . $etTxtColor . '; font-weight:' . $etFntNrml . ';">
				<p style="font-family:' . $etFontFamily . '; font-size:22px; line-height:32px; color:' . $etTxtColor . '; font-weight:600;padding: 0;margin:0;">' . $etSgnTxt1 . '</p>
				<p style="font-family:' . $etFontFamily . '; font-size:20px; line-height:30px; color:' . $etTxtColor . '; font-weight:' . $etFntNrml . ';padding: 0;margin:0;">' . self::$etSgnTxt2 . '</p>
			</td>
		</tr>';
		}
		$html .= '<tr>
				<td height="12" align="center" valign="middle" style="margin:0; padding:25px 50px; background-color:#F5F5F5;">
					<p style="font-family:' . $etFontFamily . '; font-size:24px; line-height:33px; color:' . $etTxtColor . '; font-weight:600;text-align: center;padding: 0 0 9px 0;margin:0;">We’d love to hear from you!</p>
					<p class="unsubscribetext" style="max-width: 400px;font-family:' . $etFontFamily . '; font-size:12px; line-height:19px; color:#888888; font-weight:' . $etFntNrml . ';padding: 0;margin:0;">If you have any questions please contact us <a href="mailto:'.$toEmail.'" style="color: #888888;text-decoration: none;">'.$toEmail.'</a>.</p>';
					if( $facebook || $twitter || $linkedin ){
						$html .= '<ul style="list-style: none; padding-left: 0; width: 100%;">';
						if( $facebook ){
							$html .= '<li style="display: inline-block; width: 40px;"><a href="'.$facebook.'"><img src="' . $imgRootUrl . 'facebook.png" alt=""></a></li>';
						}
						if( $twitter ){
							$html .= '<li style="display: inline-block; width: 40px;"><a href="'.$twitter.'"><img src="' . $imgRootUrl . 'twitter.png" alt=""></a></li>';
						}
						if( $linkedin ){
							$html .= '<li style="display: inline-block; width: 40px;"><a href="'.$linkedin.'"><img src="' . $imgRootUrl . 'linkedin.png" alt=""></a></li>';
						}
						$html .= '</ul>';
					}
					$html .= '<p style="font-family:' . $etFontFamily . '; font-size:14px; line-height:25px; color:#888888; font-weight:' . $etFntNrml . ';text-align: center;padding: 0;margin:0;">'.__('common.copyright_txt').' '.date('Y').' <b style="letter-spacing: 0.6px;">'.$appName.'</b>. '.__('common.right_resrv_txt').'.</p>
				</td>
			</tr>
		</table>
		</body>
		</html>';
		return $html;
	}


	public static function sendMail($toEmail, $subject, $content, $fromEmail = null, $fromName = null, $cc = null, $bcc = null, $filePath = false, $hideSgntr = false, $signatureTxt1 = false)
	{
		$headerContent = self::getMailHeaderHtml();
		$footerContent = self::getMailFooterHtml($hideSgntr, $signatureTxt1);

		$content = $headerContent . $content . $footerContent;

		if (!$fromEmail) {
			$fromEmail = self::getFromEmail();
		}
		if (!$fromName) {
			$fromName = Config('app.name');
		}

		try {

			Mail::send([], [], function ($message) use ($toEmail, $subject, $fromName, $fromEmail, $cc, $bcc, $content, $filePath) {
				$message->from($fromEmail, $fromName);
				$message->to($toEmail, null);

				if ($cc)	$message->cc($cc, null);
				if ($bcc) $message->bcc($bcc, null);

				$message->subject($subject);
				$message->setBody($content, 'text/html');
				if ($filePath) {
					$message->attach($filePath);
				}
			});
			return true;
		} catch (\Exception $e) {
			\Log::error('[Mail ERROR(' . $subject . ') - <' . $toEmail . '>]:' . $e->getMessage());
			// dd($e);
			return false;
		}
	}
}
