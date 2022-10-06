<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;border-collapse:collapse">
  <tbody>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0px 0px 20px 0px;">
        <h2 style="margin:0;padding:0;font-family:{{ $mailCssAtr['font_family'] }};font-weight:{{ $mailCssAtr['fnt_bold'] }};font-size:{{ $mailCssAtr['h2_fnt_size'] }};color:{{ $mailCssAtr['h2_color'] }};">{{ __('common.hi_txt') }} {{ $mailArr['fullname'] }}{{ Config('commonconstants.comma_sign') }} </h2>
      </td>
    </tr>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0;">
        <p style="margin:0;padding:0px 0px 10px 0px;font-family:{{ $mailCssAtr['font_family'] }}; font-size:{{ $mailCssAtr['txt_fnt_size'] }};color:{{ $mailCssAtr['txt_color'] }};font-weight:{{ $mailCssAtr['fnt_nrml'] }};">here is the result of your Retirement Calculator that you have just submitted</p>      
      </td>
    </tr>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0;">
        <div class="table-responsive" style="margin:0;padding:0px 0px 10px 0px;font-family:{{ $mailCssAtr['font_family'] }}; font-size:{{ $mailCssAtr['txt_fnt_size'] }};color:{{ $mailCssAtr['txt_color'] }};font-weight:{{ $mailCssAtr['fnt_nrml'] }};">
            <table class="table table-bordered" style="background: #f7f7fb;width: 100%;">
              <thead>
                <tr>
                  <th style="border-bottom: 1px solid #000000;background: #000;color: #509b41;    padding: .75rem;text-align: left;">Parameter</th>
                  <th style="border-bottom: 1px solid #000000;background: #000;color: #509b41;    padding: .75rem;text-align: left;">Value by You</th>
                </tr>
              </thead><tbody>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Current Age</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">{{ $mailArr['data']['current_age'] }}</td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Expected age of Retirement</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">{{ $mailArr['data']['retirement_age'] }}</td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Life Expectancy</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">{{ $mailArr['data']['life_expect'] }}</td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Rate of return during accumulation period</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">{{ $mailArr['data']['return_during'] }}</td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Rate of return after retirement</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">{{ $mailArr['data']['return_after'] }}</td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Inflation</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">{{ $mailArr['data']['inflation'] }}</td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Monthly expenditure (In Rs.)</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">{{ $mailArr['data']['monthly_expence'] }}</td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Pension/income after retirement (If any)</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">{{ $mailArr['data']['pension'] }}</td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Current Savings per month/SIP (If any)</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">{{ $mailArr['data']['curr_savings'] }}</td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Current lump sum (If any)</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">{{ $mailArr['data']['current_lumsum'] }}</td>
                </tr>
                <tr>
                  <th style="border-bottom: 1px solid #000000;background: #000;color: #509b41;    padding: .75rem;text-align: left;" colspan="2">Results</th>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Corpus you will need on retirement</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">{{ $mailArr['data']['corpus_need_on_retirement'] }}</td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Savings Required per month</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">{{ $mailArr['data']['savings_required_per_month'] }}</td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Savings Required per year</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">{{ $mailArr['data']['savings_equired_per_year'] }}</td>
                </tr>
                </tbody>
              </table>
          </div>        
      </td>
    </tr>
    @if($mailArr['image_url'])
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0;">
        <img src="{{ $mailArr['image_url'] }}" style="max-width:100%;" alt="graph">     
      </td>
    </tr>
    @endif
  </tbody>
</table>