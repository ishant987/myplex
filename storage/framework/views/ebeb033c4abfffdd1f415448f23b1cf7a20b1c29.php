<div class="faq_inner">
    <div class="accordion" id="accordionExample">
        <?php $__empty_1 = true; $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading<?php echo e(data_get($faq, 'faq_id', $index)); ?>">
                <button class="accordion-button <?php echo e(($index == 0)?'':' collapsed'); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo e(data_get($faq, 'faq_id', $index)); ?>" aria-expanded="<?php echo e(($index == 0)?'true':'false'); ?>" aria-controls="collapse<?php echo e(data_get($faq, 'faq_id', $index)); ?>">
                    <?php echo e(data_get($faq, 'title', 'FAQ item')); ?>

                </button>
            </h2>
            <div id="collapse<?php echo e(data_get($faq, 'faq_id', $index)); ?>" class="accordion-collapse collapse <?php echo e(($index == 0)?' show':''); ?>" aria-labelledby="heading<?php echo e(data_get($faq, 'faq_id', $index)); ?>" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <?php if(data_get($faq, 'descp')): ?>
                        <p><?php echo nl2br(data_get($faq, 'descp')); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /var/www/resources/views/web/common/faq_list.blade.php ENDPATH**/ ?>