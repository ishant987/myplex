<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;border-collapse:collapse">
  <tbody>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0px 0px 20px 0px;">
        <h2 style="margin:0;padding:0;font-family:<?php echo e($mailCssAtr['font_family']); ?>;font-weight:<?php echo e($mailCssAtr['fnt_bold']); ?>;font-size:<?php echo e($mailCssAtr['h2_fnt_size']); ?>;color:<?php echo e($mailCssAtr['h2_color']); ?>;"><?php echo e(__('common.hi_txt')); ?> <?php echo e($mailArr['fullname']); ?><?php echo e(Config('commonconstants.comma_sign')); ?> </h2>
      </td>
    </tr>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0;">
        <p style="margin:0;padding:0px 0px 10px 0px;font-family:<?php echo e($mailCssAtr['font_family']); ?>; font-size:<?php echo e($mailCssAtr['txt_fnt_size']); ?>;color:<?php echo e($mailCssAtr['txt_color']); ?>;font-weight:<?php echo e($mailCssAtr['fnt_nrml']); ?>;">Here is summary of your Risk Profile that you just filled.</p>      
      </td>
    </tr>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0;">
        <div class="table-responsive" style="margin:0;padding:0px 0px 10px 0px;font-family:<?php echo e($mailCssAtr['font_family']); ?>; font-size:<?php echo e($mailCssAtr['txt_fnt_size']); ?>;color:<?php echo e($mailCssAtr['txt_color']); ?>;font-weight:<?php echo e($mailCssAtr['fnt_nrml']); ?>;">
            <table class="table table-bordered" style="background: #f7f7fb;width: 100%;">
              <thead>
                <tr>
                  <th style="background: #000;color: #509b41;    padding: .75rem;text-align: left;">Parameter</th>
                  <th style="background: #000;color: #509b41;    padding: .75rem;text-align: left;">Type of investor</th>
                  <th style="background: #000;color: #509b41;    padding: .75rem;text-align: left;">Score</th>
                </tr>
              </thead>
              <tbody> 
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Capacity to take Risk</td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"><?php echo e($mailArr['portfolio_data']['capacity_to_take_risk_for_accor1']); ?></td>
                  <td  style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;" id="c_type_star">
                        <img src="<?php echo e(url('images/'.$mailArr['portfolio_data']['accor1_star'].'-green-star.png')); ?>" alt="<?php echo e($mailArr['portfolio_data']['accor1_star']); ?> - start" />                       
                  </td>
                </tr>
                <tr>
                  <td  style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Risk appetite</td>
                  <td  style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;"id="r_type"><?php echo e($mailArr['portfolio_data']['capacity_to_take_risk_for_accor2']); ?></td>
                  <td  style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;" id="r_type_star">
                     <img src="<?php echo e(url('images/'.$mailArr['portfolio_data']['accor2_star'].'-green-star.png')); ?>" alt="<?php echo e($mailArr['portfolio_data']['accor2_star']); ?> - start" />  
                  </td>
                </tr>
                <tr> 
                  <td  style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">Need to take Risk</td>
                  <td  style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;" id="r_r_type"><?php echo e($mailArr['portfolio_data']['capacity_to_take_risk_for_accor3']); ?></td>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;" id="r_r_type_star">
                      <img src="<?php echo e(url('images/'.$mailArr['portfolio_data']['accor3_star'].'-green-star.png')); ?>" alt="<?php echo e($mailArr['portfolio_data']['accor3_star']); ?> - start" />
                    </td>
                </tr>
              </tbody>
            </table>
          </div>        
      </td>
    </tr>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0;">
        <div class="overall_risk" align="center">  
            <ul style="margin:0;padding:0px 0px 10px 0px;font-family:<?php echo e($mailCssAtr['font_family']); ?>; font-size:<?php echo e($mailCssAtr['txt_fnt_size']); ?>;color:<?php echo e($mailCssAtr['txt_color']); ?>;font-weight:<?php echo e($mailCssAtr['fnt_nrml']); ?>;">
                <li style="width:46%;padding:15px 0px;text-align:center;border-right:1px solid #fff;font-size:16px;color:#000;display:inline-block;font-weight:bold">Your Overall Risk Profile</li>
                <li style="width: 45%;text-align: center;font-size: 16px;color: #000;display: inline-block;font-weight: bold;"><span id="tot_r_type"><?php echo e($mailArr['portfolio_data']['capacity_to_take_risk_for_total']); ?></span></li>
            </ul>
        </div>     
      </td>
    </tr>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0;">
          <p style="margin:0;padding:0px 0px 10px 0px;font-family:<?php echo e($mailCssAtr['font_family']); ?>; font-size:<?php echo e($mailCssAtr['txt_fnt_size']); ?>;color:<?php echo e($mailCssAtr['txt_color']); ?>;font-weight:<?php echo e($mailCssAtr['fnt_nrml']); ?>;">For your reference</p>
      </td>
    </tr>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0;">
        <div class="table-responsive" style="margin:0;padding:0px 0px 10px 0px;font-family:<?php echo e($mailCssAtr['font_family']); ?>; font-size:<?php echo e($mailCssAtr['txt_fnt_size']); ?>;color:<?php echo e($mailCssAtr['txt_color']); ?>;font-weight:<?php echo e($mailCssAtr['fnt_nrml']); ?>;">
                             
          <table class="table table-bordered table-step" style="width: 100%;background: #f7f7fb;">
              <thead>
                <tr>
                  <th style="vertical-align: bottom;border-bottom: 0px solid #020202;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">Score</th>
                  <th style="vertical-align: bottom;border-bottom: 0px solid #020202;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">Tolerance level</th>
                  <th style="vertical-align: bottom;border-bottom: 0px solid #020202;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">Preferable Equity holding</th>
                  <th style="vertical-align: bottom;border-bottom: 0px solid #020202;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">PreferableDebt holding</th>
                  <th style="vertical-align: bottom;border-bottom: 0px solid #020202;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">Type of Investor</th>
                </tr>
              </thead>    
              <tbody>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">4 - 5</td>
                  <td style="background: #00b050;padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">Very High</td>
                  <td style="background: #00b050;padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">100%</td>
                  <td style="background: #00b050;padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">0%</td>
                  <td style="background: #00b050;padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">Highly Aggressive</td>
                </tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">3 - 4</td>
                  <td style="background: #92d050;padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">High</td>
                  <td style="background: #92d050;padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">80%</td>
                  <td style="background: #92d050;padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">20%</td>
                  <td style="background: #92d050;padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">Aggressive</td></tr>
                <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">2 - 3</td>
                  <td style="background: #ffff66;padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">Moderate</td>
                  <td style="background: #ffff66;padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">60%</td>
                  <td style="background: #ffff66;padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">40%</td>
                  <td style="background: #ffff66;padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">Moderate</td>
                </tr>
                  <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">1 - 2</td>
                  <td style="background: #ff7c80;padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">Low</td>
                  <td style="background: #ff7c80;padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">40%</td>
                  <td style="background: #ff7c80;padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">60%</td>
                  <td style="background: #ff7c80;padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">Conservative</td>
                </tr>
                  <tr>
                  <td style="padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;">0 - 1</td>
                  <td style="background: #ff3300;padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">Very Low</td>
                  <td style="background: #ff3300;padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">20%</td>
                  <td style="background: #ff3300;padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">80%</td>
                  <td style="background: #ff3300;padding: .75rem;vertical-align: top;border: 1px solid #000000;font-size: 15px;color: #000;text-align: center;">Highly Conservative</td>
                </tr>
              </tbody>
            </table>
          </div>
      </td>
    </tr>
  </tbody>
</table><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/emails/web/to-user-risk-portfolio.blade.php ENDPATH**/ ?>