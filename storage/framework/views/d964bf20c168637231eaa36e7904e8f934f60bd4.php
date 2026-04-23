<?php $__env->startSection('dataTables'); ?> <?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card m-b-0">
            <div class="card-header">
                <h5>All Blogs comments</h5>
            </div>
            <div class="card-block">
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.alert','data' => ['type' => ''.e(session()->get('alert')).'','title' => ''.e(session()->get('title')).'','message' => ''.e(session()->get('message')).'']]); ?>
<?php $component->withName('form.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => ''.e(session()->get('alert')).'','title' => ''.e(session()->get('title')).'','message' => ''.e(session()->get('message')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <form id="listDataForm" name="listDataForm" method="post">
                    <?php echo e(csrf_field()); ?>

                    <div class="table-responsive dt-responsive">
                        <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>
                                        Email
                                    </th>
                                    <th>
                                        Comment
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Client IP
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $blogComments['comments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blogComment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr role="row" class="">
                                    <td>
                                        <?php echo e($blogComment['email']); ?>

                                    </td>
                                    <td>
                                        <?php echo e($blogComment['comment']); ?>

                                    </td>
                                    <td>
                                        <?php echo e($blogComment['name']); ?>

                                    </td>
                                    <td>
                                        <label id="change_status<?php echo e($blogComment['id']); ?>" onclick="return changeStatus('id', '<?php echo e($blogComment['id']); ?>', 'blog_comments', '<?php echo e($blogComment['status']); ?>', '<?php echo e($statusAtrArr['status_type']); ?>','/admin39/change-status');" class="label btn-<?php echo e($listDataAtrArr['alert_css'][$blogComment['status']]); ?>"><?php echo e($statusAtrArr['label'][$blogComment['status']]); ?></label>
                                    </td>
                                    <td>
                                        <?php echo e($blogComment['client_ip_address']); ?>

                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/blogComments/index.blade.php ENDPATH**/ ?>