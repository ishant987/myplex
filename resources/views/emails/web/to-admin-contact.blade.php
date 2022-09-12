<tr>
  <td style="margin:0;padding:25px 50px 10px 50px;font-family:{{ $mailCssAtr['font_family'] }}; font-size:{{ $mailCssAtr['txt_fnt_size'] }};color:{{ $mailCssAtr['txt_color'] }};font-weight:{{ $mailCssAtr['fnt_nrml'] }};line-height:{{ $mailCssAtr['txt_fnt_line_height'] }};">{{ __('common.hello_txt') }} {{ __('common.admin_txt') }}{{ $commaSign }}</td>
</tr>
<tr>
  <td style="margin:0;padding:0px 50px 25px 50px;font-family:{{ $mailCssAtr['font_family'] }}; font-size:{{ $mailCssAtr['txt_fnt_size'] }};color:{{ $mailCssAtr['txt_color'] }};font-weight:{{ $mailCssAtr['fnt_nrml'] }};line-height:{{ $mailCssAtr['txt_fnt_line_height'] }};">{{ __('contact.mail_p_pfx') }}<strong>{{ $mailArr['fullname'] }}{{ $commaSign }}</strong> <a style="color: {{ $mailCssAtr['lnk_color'] }};" href="{{ route('admin.contact.index') }}" target="_blank">{{ __('common.click_here_txt') }}</a>{{ __('contact.mail_p_sfx') }}</td>
</tr>