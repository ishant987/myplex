<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;border-collapse:collapse">
  <tbody>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0px 0px 20px 0px;">
        <h1 style="margin:0;padding:0;font-family:<?php echo e($mailCssAtr['font_family']); ?>;font-weight:<?php echo e($mailCssAtr['fnt_bold']); ?>;font-size:<?php echo e($mailCssAtr['h1_fnt_size']); ?>;color:<?php echo e($mailCssAtr['h1_color']); ?>;"><?php echo e(__('common.welcome_txt')); ?></h1>
      </td>
    </tr>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0px 0px 20px 0px;">
        <h2 style="margin:0;padding:0;font-family:<?php echo e($mailCssAtr['font_family']); ?>;font-weight:<?php echo e($mailCssAtr['fnt_bold']); ?>;font-size:<?php echo e($mailCssAtr['h2_fnt_size']); ?>;color:<?php echo e($mailCssAtr['h2_color']); ?>;"><?php echo e(__('common.hi_txt')); ?> <?php echo e($mailArr['fullname']); ?><?php echo e(Config('commonconstants.comma_sign')); ?></h2>
      </td>
    </tr>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0;">
        <p style="margin:0;padding:0px 0px 10px 0px;font-family:<?php echo e($mailCssAtr['font_family']); ?>; font-size:<?php echo e($mailCssAtr['txt_fnt_size']); ?>;color:<?php echo e($mailCssAtr['txt_color']); ?>;font-weight:<?php echo e($mailCssAtr['fnt_nrml']); ?>;"><?php echo e(__('auth.su_reg_admin_mail_p')); ?></p>
        <p style="margin:0;padding:0px 0px 0px 0px;font-family:<?php echo e($mailCssAtr['font_family']); ?>; font-size:<?php echo e($mailCssAtr['txt_fnt_size']); ?>;color:<?php echo e($mailCssAtr['txt_color']); ?>;font-weight:<?php echo e($mailCssAtr['fnt_nrml']); ?>;"><?php echo e(__('auth.su_reg_mail_username')); ?> : <?php echo e($mailArr['email']); ?></p>
        <p style="margin:0;padding:0px 0px 0px 0px;font-family:<?php echo e($mailCssAtr['font_family']); ?>; font-size:<?php echo e($mailCssAtr['txt_fnt_size']); ?>;color:<?php echo e($mailCssAtr['txt_color']); ?>;font-weight:<?php echo e($mailCssAtr['fnt_nrml']); ?>;"><?php echo e(__('common.password_txt')); ?> : <?php echo e($mailArr['password']); ?></p>
      </td>
    </tr>
  </tbody>
</table><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/emails/admin/to-user-signup.blade.php ENDPATH**/ ?>