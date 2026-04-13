<div class="faq_inner">
    <div class="accordion" id="accordionExample">
        <?php $__empty_1 = true; $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading<?php echo e($faq->faq_id); ?>">
                <button class="accordion-button <?php echo e(($index == 0)?'':' collapsed'); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo e($faq->faq_id); ?>" aria-expanded="<?php echo e(($index == 0)?'true':'false'); ?>" aria-controls="collapse<?php echo e($faq->faq_id); ?>">
                    <?php echo e($faq->title); ?>

                </button>
            </h2>
            <div id="collapse<?php echo e($faq->faq_id); ?>" class="accordion-collapse collapse <?php echo e(($index == 0)?' show':''); ?>" aria-labelledby="heading<?php echo e($faq->faq_id); ?>" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <?php if($faq->descp): ?>
                        <p><?php echo nl2br($faq->descp); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php endif; ?>
    </div>
</div><?php /**PATH /var/www/vhosts/new.myplexus.com/httpdocs/my-plexus/resources/views/web/common/faq_list.blade.php ENDPATH**/ ?>