<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;border-collapse:collapse">
  <tbody>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0px 0px 20px 0px;"><h2 style="margin:0;padding:0;font-family:{{ $mailCssAtr['font_family'] }};font-weight:{{ $mailCssAtr['fnt_bold'] }};font-size:{{ $mailCssAtr['h2_fnt_size'] }};color:{{ $mailCssAtr['h2_color'] }};">{{ __('common.hi_txt') }} {{ $mailArr['fullname'] }}{{ Config('commonconstants.comma_sign') }}</h2></td>
    </tr>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0;">
        <p style="margin:0;padding:0px 0px 0px 0px;font-family:{{ $mailCssAtr['font_family'] }}; font-size:{{ $mailCssAtr['txt_fnt_size'] }};color:{{ $mailCssAtr['txt_color'] }};font-weight:{{ $mailCssAtr['fnt_nrml'] }};">{{ $mailArr['ans_user_name'] }} {{ __('askexpert.mail.answer.body_txt1') }} (<i>{{ $mailArr['question'] }}</i>), <strong><a href="{{ route('web.ask-expert') }}" target="_blank">{{ __('common.click_here_txt') }}</a></strong> {{ __('askexpert.mail.answer.body_txt2') }}</p>
      </td>
    </tr>
  </tbody>
</table>