<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5>Edit Sensitive Details</h5>
    </div>
    <div class="card-block">
        <form method="POST" action="<?php echo e(route('admin.secure-panel.users.update', $user->u_id)); ?>">
            <?php echo csrf_field(); ?>
            <div class="row">
                <?php $__currentLoopData = [
                    'company_name' => 'Company Name',
                    'contact_person' => 'Contact Person',
                    'city' => 'City',
                    'state' => 'State',
                    'pan' => 'PAN',
                    'arn' => 'ARN',
                    'gst' => 'GST',
                    'bank_name' => 'Bank Name',
                    'account_holder_name' => 'Account Holder Name',
                    'account_number' => 'Account Number',
                    'ifsc_code' => 'IFSC Code',
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="<?php echo e($field); ?>"><?php echo e($label); ?></label>
                        <input
                            type="text"
                            class="form-control"
                            id="<?php echo e($field); ?>"
                            name="<?php echo e($field); ?>"
                            value="<?php echo e(old($field, optional($user->sensitiveDetails)->{$field})); ?>"
                        >
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <button type="submit" class="btn btn-primary">Save Details</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/admin/secure-panel/users/edit.blade.php ENDPATH**/ ?>