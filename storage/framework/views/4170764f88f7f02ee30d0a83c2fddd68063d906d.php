<?php $__env->startSection('content'); ?>
   

<section class="inner-top">

    <div class="container">
        <h3 class="report-sub-heading">Report : CAGR Return</h3>
        <form id="myForm">
            <div class="top-form">
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="form-error">
                            <div class="form-wrapper mb-2">
                                <label>Fund Name :</label>
                                <select class="form-control single-select2" name="search_fund_name" id="fund_name_id" onchange="getIndicesName()" required>
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
                            <div class="form-wrapper mb-2">
                                <label>Indices Name :</label>
                                <input type="text" id="indices_name_id" name="search_indices_name" class=" form-control" readonly required>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6">
                        <div class="form-error">
                            <div class="form-wrapper">
                                <label>Form Date :</label>
                                <input type="text" id="from_date_cagr" onchange="getOneYearDate()" name="search_from_date" value="<?php echo e(old('search_from_date',isset($search_from_date)?$search_from_date:'')); ?>" class="from_date_for_cagr form-control" readonly required>
                            </div>
                            <?php if($errors->has('search_from_date')): ?>
                                <span class="text-danger"><?php echo e($errors->first('search_from_date')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6">
                        <div class="form-error">
                            <div class="form-wrapper">
                                <label>To Date :</label>
                                <input type="text" class=" form-control" id="cagr_to_date" name="search_to_date" value="<?php echo e(old('search_to_date',isset($search_to_date)?$search_to_date:'')); ?>" readonly required>
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
                                <th >Fund Name</th>
                                <th >Index Name</th>
                                <th style="text-align: center">Closing Nav</th>
                                <th style="text-align: center">Closing Value</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if(isset($searched_result) && count($searched_result) > 0): ?>
                            <?php $i = 1; ?>
                                <?php $__currentLoopData = $searched_result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td align="center"><?php echo e($i++); ?></td>
                                        <td align="center" style="white-space: nowrap;"><?php echo e($row['entry_date']); ?></td>
                                        <td ><?php echo e($fund_name); ?></td>
                                        <td ><?php echo e($indices_name); ?></td>
                                        <td align="right"><?php echo e($row['fund_closing']); ?></td>
                                        <td align="right"><?php echo e($row['indices_closing']); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <?php if(isset($fund_return_absolute) &&
            isset($index_return_absolute)): ?>
            <div class="row">

                <div class="col-12">
                    <div class="table-wrapper">
                        <table class="table table-bordered result-table">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Fund Return (Absolute)</th>
                                    <th style="text-align: center">Index Return (Absolute)</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td align="center"><?php echo e($fund_return_absolute); ?></td>
                                    <td align="center"><?php echo e($index_return_absolute); ?></td>
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
<?php echo $__env->make('web.layout.infosolz_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/infosolz-calculator/cagr.blade.php ENDPATH**/ ?>