<div class="col-lg-3 col-md-12 col-sm-12 blog-main-sidebar fw-sidebar">
  <div class="blog-sidebar-links blog-sidebar-block bg-gry br-5 box-shadow">
    <h6>Recent Fund Watch</h6>
    <?php if(count($rcntDataListModel) > 0): ?>
    <ul class="reset">
      <?php $__currentLoopData = $rcntDataListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <li>
        <a href="<?php echo e(route('web.fundwatch', $record2['fw_id'])); ?>" <?php echo e(($reqId == $record2['fw_id'])?'class=active':''); ?>><?php echo e($record2['title']); ?></a>
      </li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    <?php endif; ?>
  </div>

  <div class="blog-sidebar-links blog-sidebar-block bg-gry br-5 box-shadow">
    <h6>Archives</h6>
    <?php if(count($archiveListModel) > 0): ?>
    <ul class="reset">
      <?php $__currentLoopData = $archiveListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <li>
        <a href="<?php echo e(route('web.fundwatch.list', $record3['year'])); ?>" <?php echo e(($reqYear == $record3['year'])?'class=active':''); ?>><?php echo e($record3['year']); ?> <span>(<?php echo e($record3['tot']); ?>)</span></a>
      </li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    <?php endif; ?>
  </div>
</div><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/includes/fund-watch-sidebar.blade.php ENDPATH**/ ?>