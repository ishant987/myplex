<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;border-collapse:collapse">
  <tbody>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0px 0px 20px 0px;"><h2 style="margin:0;padding:0;font-family:<?php echo e($mailCssAtr['font_family']); ?>;font-weight:<?php echo e($mailCssAtr['fnt_bold']); ?>;font-size:<?php echo e($mailCssAtr['h2_fnt_size']); ?>;color:<?php echo e($mailCssAtr['h2_color']); ?>;"><?php echo e(__('common.hi_txt')); ?> <?php echo e($mailArr['fullname']); ?><?php echo e(Config('commonconstants.comma_sign')); ?></h2></td>
    </tr>
    <tr>
      <td align="center" valign="top" style="margin:0;padding:0;">
        <p style="margin:0;padding:0px 0px 0px 0px;font-family:<?php echo e($mailCssAtr['font_family']); ?>; font-size:<?php echo e($mailCssAtr['txt_fnt_size']); ?>;color:<?php echo e($mailCssAtr['txt_color']); ?>;font-weight:<?php echo e($mailCssAtr['fnt_nrml']); ?>;"><?php echo e($mailArr['ans_user_name']); ?> <?php echo e(__('askexpert.mail.answer.body_txt1')); ?> (<i><?php echo e($mailArr['question']); ?></i>), <strong><a href="<?php echo e(route('web.ask-expert')); ?>" target="_blank"><?php echo e(__('common.click_here_txt')); ?></a></strong> <?php echo e(__('askexpert.mail.answer.body_txt2')); ?></p>
      </td>
    </tr>
  </tbody>
</table><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/emails/web/to-user-answer.blade.php ENDPATH**/ ?>