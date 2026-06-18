<?php $__env->startSection('dataTables'); ?> <?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card m-b-0">
            <div class="card-header">
                <h5>All Blogs</h5>
                <!-- Add New -->

                <?php if($roleRights['add']): ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_add_new','data' => ['url' => ''.e(route('admin.blog.create')).'']]); ?>
<?php $component->withName('link_add_new'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.blog.create')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php endif; ?>
                <!-- Multi Delete -->

                <?php if($roleRights['delete']): ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.btn_multi_delete','data' => []]); ?>
<?php $component->withName('form.btn_multi_delete'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php endif; ?>
                &nbsp;
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
                <form id="listDataForm" name="listDataForm" method="post" action="<?php echo e(route('admin.blog.delete')); ?>">
                    <?php echo e(csrf_field()); ?>

                    <div class="table-responsive dt-responsive">
                        <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th class="cc-w-35 no-sort-del">
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.checkbox','data' => ['style' => 'default','name' => 'check_all','id' => 'check_all']]); ?>
<?php $component->withName('form.field.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'default','name' => 'check_all','id' => 'check_all']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    </th>
                                    <th>
                                        <?php echo e(__('blog.title_txt')); ?>

                                    </th>
                                    <th>
                                        <?php echo e(__('blog.tags')); ?>

                                    </th>
                                    <th>
                                        <?php echo e(__('blog.status')); ?>

                                    </th>
                                    <th>
                                        Created By
                                    </th>
                                    <th>
                                        Comments
                                    </th>
                                    <th>
                                        Published By
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr role="row" class="">
                                    <td class="id">
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.field.checkbox','data' => ['style' => 'default','name' => 'checkbox[]','value' => ''.e($blog->id).'','fldclass' => 'del-chkbx']]); ?>
<?php $component->withName('form.field.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'default','name' => 'checkbox[]','value' => ''.e($blog->id).'','fldclass' => 'del-chkbx']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($roleRights['edit']): ?>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link_tooltip','data' => ['url' => ''.e(route('admin.blog.edit', $blog->id)).'','title' => 'Edit']]); ?>
<?php $component->withName('link_tooltip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.blog.edit', $blog->id)).'','title' => 'Edit']); ?>
                                            <?php echo e($blog->heading); ?>

                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    </td>
                                    <?php else: ?>
                                    <?php echo e($blog->heading); ?>

                                    <?php endif; ?>
                                    <td>
                                        <?php echo e($blog->tags); ?>

                                    </td>
                                    <td>

                                        <label id="change_status<?php echo e($blog->id); ?>" onclick="return changeStatus('id', <?php echo e($blog->id); ?>, 'blog', <?php echo e($blog->status); ?>, '<?php echo e($statusAtrArr['status_type']); ?>');" class="label btn-<?php echo e($listDataAtrArr['alert_css'][$blog->status]); ?>"><?php echo e($statusAtrArr['label'][$blog->status]); ?></label>
                                    </td>
                                    <td>
                                        <?php echo e($blog->creator->first_name); ?>

                                    </td>
                                    <td>
                                        <?php if($blog->comments->count()): ?>
                                        <a href="<?php echo e(route('admin.blog.comments', $blog->id)); ?>">View Comments (<?php echo e($blog->comments->count()); ?>)</a>
                                        <?php else: ?>
                                        No comments
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo e($blog->published_date); ?>

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
<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/pages/blog/index.blade.php ENDPATH**/ ?>