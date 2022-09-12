<tr>
  <td style="margin:0;padding:25px 50px 10px 50px;font-family:{{ $mailCssAtr['font_family'] }}; font-size:{{ $mailCssAtr['txt_fnt_size'] }};color:{{ $mailCssAtr['txt_color'] }};font-weight:{{ $mailCssAtr['fnt_nrml'] }};line-height:{{ $mailCssAtr['txt_fnt_line_height'] }};">{{ __('common.hi_txt') }} {{ $mailArr['fullname'] }}{{ Config('commonconstants.comma_sign') }}</td>
</tr>
<tr>
  <td style="margin:0;padding:0px 50px 25px 50px;font-family:{{ $mailCssAtr['font_family'] }}; font-size:{{ $mailCssAtr['txt_fnt_size'] }};color:{{ $mailCssAtr['txt_color'] }};font-weight:{{ $mailCssAtr['fnt_nrml'] }};line-height:{{ $mailCssAtr['txt_fnt_line_height'] }};">{{ __('auth.su_f_pswd_mail_p_pfx') }} <strong>{{ $mailArr['forget_code'] }}</strong> {{ __('auth.su_f_pswd_mail_p_sfx') }}</td>
</tr>