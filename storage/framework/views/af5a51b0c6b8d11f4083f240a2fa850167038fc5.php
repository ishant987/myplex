<?php $__env->startSection('content'); ?>
   

<section class="inner-top">

    <div class="container">
        <h3 class="report-sub-heading">Report : Rolling Returns</h3>
        <form id="myForm">
            <div class="top-form">
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="form-error">
                            <div class="form-wrapper">
                                <label>Fund Name :</label>
                                <select class="form-control single-select2" name="search_fund_name" required>
                                    <option value="">Select Fund</option>
                                    <?php if(isset($fundNames)): ?>
                                        <?php $__currentLoopData = $fundNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($row->fund_code != ''): ?>
                                                <option value="<?php echo e($row->fund_code); ?>" <?php if(old('search_fund_name',isset($search_fund_name)?$search_fund_name:'') == $row->fund_code): ?> selected <?php endif; ?>><?php echo e($row->fund_name); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <?php if($errors->has('search_fund_name')): ?>
                                <span class="text-danger"><?php echo e($errors->first('search_fund_name')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6">
                        <div class="form-error">
                            <div class="form-wrapper">
                                <label>Form Date :</label>
                                <input type="text" id="rolling_return_from_date" onchange="getRollingReturnToDate()" name="search_from_date" value="<?php echo e(old('search_from_date',isset($search_from_date)?$search_from_date:'')); ?>" class=" form-control" readonly required>
                            </div>
                            <?php if($errors->has('search_from_date')): ?>
                                <span class="text-danger"><?php echo e($errors->first('search_from_date')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6" style="display:none;">
                        <div class="form-error">
                            <div class="form-wrapper">
                                <label>To Date :</label>
                                <input type="text" class=" form-control" id="rolling_return_to" name="search_to_date" value="<?php echo e(old('search_to_date',isset($search_to_date)?$search_to_date:'')); ?>" readonly required>
                            </div>
                            <?php if($errors->has('search_to_date')): ?>
                                <span class="text-danger"><?php echo e($errors->first('search_to_date')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">

                    <div class="col-lg-12 col-sm-12">
                        <div class="form-submit">
                            <input type="submit" name="search" class="search-submit" value="Search">
                            
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="row">

            <div class="col-12">
                <div class="table-wrapper">
                    <table class="table table-bordered result-table" id="myDatatable">
                        <thead>
                            <tr>
                                <th style="text-align: center">#</th>
                                <th style="text-align: center">Entry Date</th>
                                <th style="text-align: center">Closing Nav</th>
                                <th style="text-align: center">1 Month Interval % Change</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if(isset($searched_result) && count($searched_result) > 0): ?>
                            <?php $i = 1; ?>
                                <?php $__currentLoopData = $searched_result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td align="center"><?php echo e($i++); ?></td>
                                        <td align="center" style="white-space: nowrap;"><?php echo e($row['entry_date']); ?></td>
                                        <td align="right"><?php echo e($row['fund_closing']); ?></td>
                                        <td align="right"><?php echo e($row['one_month_interval_percentage_change']); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <?php if(isset($avg_of_three_month_rolling_return) || isset($avg_of_six_month_rolling_return) || isset($avg_of_twelve_month_rolling_return)): ?>
            <div class="row">

                <div class="col-12">
                    <div class="table-wrapper">
                        <table class="table table-bordered result-table">
                            <thead>
                                <tr>
                                    <?php if(isset($avg_of_three_month_rolling_return)): ?>
                                        <th style="text-align: center">Average of Three Months Rolling Return</th>
                                    <?php endif; ?>
                                    <?php if(isset($avg_of_six_month_rolling_return)): ?>
                                        <th style="text-align: center">Average of Six Months Rolling Return</th>
                                    <?php endif; ?>
                                    <?php if(isset($avg_of_twelve_month_rolling_return)): ?>
                                        <th style="text-align: center">Average of One Year Rolling Return</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <?php if(isset($avg_of_three_month_rolling_return)): ?>
                                        <td align="center"><?php echo e($avg_of_three_month_rolling_return); ?></td>
                                    <?php endif; ?>
                                    <?php if(isset($avg_of_six_month_rolling_return)): ?>
                                        <td align="center"><?php echo e($avg_of_six_month_rolling_return); ?></td>
                                    <?php endif; ?>
                                    <?php if(isset($avg_of_twelve_month_rolling_return)): ?>
                                        <td align="center"><?php echo e($avg_of_twelve_month_rolling_return); ?></td>
                                    <?php endif; ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layout.infosolz_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/web/infosolz-calculator/rolling_return.blade.php ENDPATH**/ ?>