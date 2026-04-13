<div class="row align-items-center">
    <div class="col-md-3">    
        <div class="dataTables_info" id="dom-jqry_info" role="status" aria-live="polite">
        Showing 
        <?php echo e($paginator->total()>0?($paginator->currentPage()-1)*($paginator->perPage())+1:0); ?> 
        to 
        <?php echo e(($paginator->count()<$paginator->perPage())?(($paginator->currentPage()-1)*$paginator->perPage()+$paginator->count()):$paginator->currentPage()*$paginator->perPage()); ?> 
        of 
        <?php echo e($paginator->total()); ?> 
        entries
        </div>        
    </div>
    <div class="col-md-9">
        <nav>
            <ul class="pagination f-right">
                
                <?php if($paginator->onFirstPage()): ?>
                <li class="page-item disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">
                    <span class="page-link" aria-hidden="true"><?php echo e(__('admin.previous_txt')); ?></span>
                </li>
                <?php else: ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>"><?php echo e(__('admin.previous_txt')); ?></a>
                </li>
                <?php endif; ?>

                
                <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php if(is_string($element)): ?>
                <li class="page-item disabled" aria-disabled="true"><span class="page-link"><?php echo e($element); ?></span></li>
                <?php endif; ?>

                
                <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($page == $paginator->currentPage()): ?>
                <li class="page-item active" aria-current="page"><span class="page-link"><?php echo e($page); ?></span></li>
                <?php else: ?>
                <li class="page-item"><a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a></li>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
                <?php if($paginator->hasMorePages()): ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" aria-label="<?php echo app('translator')->get('pagination.next'); ?>"><?php echo e(__('admin.next_txt')); ?></a>
                </li>
                <?php else: ?>
                <li class="page-item disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">
                    <span class="page-link" aria-hidden="true"><?php echo e(__('admin.next_txt')); ?></span>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/vendor/pagination/app-admin.blade.php ENDPATH**/ ?>