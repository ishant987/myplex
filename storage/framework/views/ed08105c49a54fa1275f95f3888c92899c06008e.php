<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;border-collapse:collapse">
  <tbody>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0px 0px 20px 0px;">
        <h2 style="margin:0;padding:0;font-family:<?php echo e($mailCssAtr['font_family']); ?>;font-weight:<?php echo e($mailCssAtr['fnt_bold']); ?>;font-size:<?php echo e($mailCssAtr['h2_fnt_size']); ?>;color:<?php echo e($mailCssAtr['h2_color']); ?>;"><?php echo e(__('common.hi_txt')); ?> <?php echo e($mailArr['fullname']); ?><?php echo e(Config('commonconstants.comma_sign')); ?> </h2>
      </td>
    </tr>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0;">
        <p style="margin:0;padding:0px 0px 10px 0px;font-family:<?php echo e($mailCssAtr['font_family']); ?>; font-size:<?php echo e($mailCssAtr['txt_fnt_size']); ?>;color:<?php echo e($mailCssAtr['txt_color']); ?>;font-weight:<?php echo e($mailCssAtr['fnt_nrml']); ?>;">here is the result of your Retirement Calculator that you have just submitted</p>      
      </td>
    </tr>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0;">
        <div class="table-responsive" style="margin:0;padding:0px 0px 10px 0px;font-family:<?php echo e($mailCssAtr['font_family']); ?>; font-size:<?php echo e($mailCssAtr['txt_fnt_size']); ?>;color:<?php echo e($mailCssAtr['txt_color']); ?>;font-weight:<?php echo e($mailCssAtr['fnt_nrml']); ?>;">
            <table class="table table-bordered" style="background: #f7f7fb;width: 100%;">
              <thead>
                <tr>
                  <th style="border-bottom: 1px solid #000000;background: #000;color: #509b41;    padding: .75rem;text-align: left;">Parameter</th>
                  <th style="border-bottom: 1px solid #000000;background: #000;color: #509b41;    padding: .75rem;text-align: left;">Value by You</th>
                </tr>
              </thead><tbody>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Current Age</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['data']['current_age']); ?></td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Expected age of Retirement</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['data']['retirement_age']); ?></td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Life Expectancy</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['data']['life_expect']); ?></td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Rate of return during accumulation period</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['data']['return_during']); ?></td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Rate of return after retirement</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['data']['return_after']); ?></td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Inflation</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['data']['inflation']); ?></td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Monthly expenditure (In Rs.)</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['data']['monthly_expence']); ?></td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Pension/income after retirement (If any)</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['data']['pension']); ?></td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Current Savings per month/SIP (If any)</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['data']['curr_savings']); ?></td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Current lump sum (If any)</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['data']['current_lumsum']); ?></td>
                </tr>
                <tr>
                  <th style="border-bottom: 1px solid #000000;background: #000;color: #509b41;    padding: .75rem;text-align: left;" colspan="2">Results</th>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Corpus you will need on retirement</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['data']['corpus_need_on_retirement']); ?></td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Savings Required per month</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['data']['savings_required_per_month']); ?></td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Savings Required per year</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['data']['savings_equired_per_year']); ?></td>
                </tr>
                </tbody>
              </table>
          </div>        
      </td>
    </tr>
    <?php if($mailArr['image_url']): ?>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0;">
        <img src="<?php echo e($mailArr['image_url']); ?>" style="max-width:100%;" alt="graph">     
      </td>
    </tr>
    <?php endif; ?>
  </tbody>
</table><?php /**PATH /var/www/vhosts/new.myplexus.com/httpdocs/my-plexus/resources/views/emails/web/to-user-retirement-calculator.blade.php ENDPATH**/ ?>