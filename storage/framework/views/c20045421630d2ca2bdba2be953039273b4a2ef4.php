<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;border-collapse:collapse">
  <tbody>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0px 0px 20px 0px;">
        <h2 style="margin:0;padding:0;font-family:<?php echo e($mailCssAtr['font_family']); ?>;font-weight:<?php echo e($mailCssAtr['fnt_bold']); ?>;font-size:<?php echo e($mailCssAtr['h2_fnt_size']); ?>;color:<?php echo e($mailCssAtr['h2_color']); ?>;"><?php echo e(__('common.hi_txt')); ?> <?php echo e($mailArr['fullname']); ?><?php echo e(Config('commonconstants.comma_sign')); ?> </h2>
      </td>
    </tr>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0;">
        <p style="margin:0;padding:0px 0px 10px 0px;font-family:<?php echo e($mailCssAtr['font_family']); ?>; font-size:<?php echo e($mailCssAtr['txt_fnt_size']); ?>;color:<?php echo e($mailCssAtr['txt_color']); ?>;font-weight:<?php echo e($mailCssAtr['fnt_nrml']); ?>;">here is the result of your SIP Performance Calculator that you have just submitted</p>      
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
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">SIP Amount (Rs.)</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['data']['sip_amount']); ?></td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Name of the Fund</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['data']['fund_name']); ?></td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Duration (Month)</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['data']['duration_months']); ?></td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Day of SIP</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['data']['sip_day']); ?></td>
                </tr>
                <tr>
                  <th style="border-bottom: 1px solid #000000;background: #000;color: #509b41;    padding: .75rem;text-align: left;" colspan="2">Results</th>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Return Rate (%)</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['data']['sip_return']); ?></td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Your Investments (Rs.)</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['data']['invested_amount']); ?></td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Your Current Value (Rs.)</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['data']['current_value']); ?></td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Current NAV (Rs.)</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['data']['current_nav']); ?></td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Total Unit</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['data']['total_unit']); ?></td>
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
</table><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/emails/web/to-user-sip-calculator.blade.php ENDPATH**/ ?>