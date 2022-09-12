<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;border-collapse:collapse">
  <tbody>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0px 0px 20px 0px;">
        <h1 style="margin:0;padding:0;font-family:{{ $mailCssAtr['font_family'] }};font-weight:{{ $mailCssAtr['fnt_bold'] }};font-size:{{ $mailCssAtr['h1_fnt_size'] }};color:{{ $mailCssAtr['h1_color'] }};">{{ __('common.welcome_txt') }}</h1>
      </td>
    </tr>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0px 0px 20px 0px;">
        <h2 style="margin:0;padding:0;font-family:{{ $mailCssAtr['font_family'] }};font-weight:{{ $mailCssAtr['fnt_bold'] }};font-size:{{ $mailCssAtr['h2_fnt_size'] }};color:{{ $mailCssAtr['h2_color'] }};">{{ __('common.hi_txt') }} {{ $mailArr['fullname'] }}{{ Config('commonconstants.comma_sign') }}</h2>
      </td>
    </tr>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0;">
        <p style="margin:0;padding:0px 0px 10px 0px;font-family:{{ $mailCssAtr['font_family'] }}; font-size:{{ $mailCssAtr['txt_fnt_size'] }};color:{{ $mailCssAtr['txt_color'] }};font-weight:{{ $mailCssAtr['fnt_nrml'] }};">{{ __('auth.su_reg_user_mail_p') }}</p>
        <p style="margin:0;padding:0px 0px 0px 0px;font-family:{{ $mailCssAtr['font_family'] }}; font-size:{{ $mailCssAtr['txt_fnt_size'] }};color:{{ $mailCssAtr['txt_color'] }};font-weight:{{ $mailCssAtr['fnt_nrml'] }};">{{ __('auth.su_reg_mail_username') }} : {{ $mailArr['email'] }}</p>
        <p style="margin:0;padding:0px 0px 0px 0px;font-family:{{ $mailCssAtr['font_family'] }}; font-size:{{ $mailCssAtr['txt_fnt_size'] }};color:{{ $mailCssAtr['txt_color'] }};font-weight:{{ $mailCssAtr['fnt_nrml'] }};">{{ __('common.password_txt') }} : {{ $mailArr['password'] }}</p>
      </td>
    </tr>
  </tbody>
</table>