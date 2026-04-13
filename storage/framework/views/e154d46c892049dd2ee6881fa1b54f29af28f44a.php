<?php $__env->startSection('content'); ?>
   

<section class="inner-top">

    <div class="container">
        <h3 class="report-sub-heading">Report : SIP Return</h3>
        <form id="myForm" onsubmit="return sipSearchFormValidation()">
            <div class="top-form">
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="form-error">
                            <div class="form-wrapper mb-2">
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
                            <div class="form-wrapper mb-2">
                                <label>SIP Amount (INR) :</label>
                                <input type="text" name="search_sip_amount" id="sip_amount" value="<?php echo e(old('search_sip_amount',isset($search_sip_amount)?$search_sip_amount:'')); ?>" class="onlynum form-control" required >
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="form-error">
                            <div class="form-wrapper mb-2">
                                <label>Term (Year) :</label>
                                <input type="text" name="search_term" id="sip_term" class="onlynum form-control" value="<?php echo e(old('search_term',isset($search_term)?$search_term:'')); ?>"  onkeyup="getEntryDate();getReportDate();">
                            </div>
                        </div>
                        <?php if($errors->has('search_term')): ?>
                            <span class="text-danger"><?php echo e($errors->first('search_term')); ?></span>
                        <?php endif; ?>
                        <span class="text-danger" id="sip_term_err_msg"></span>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="form-error">
                            <div class="form-wrapper mb-2">
                                <label>Term (Month) :</label>
                                <input type="text" name="search_term_month" id="sip_term_month" class="onlynum form-control" value="<?php echo e(old('search_term_month',isset($search_term_month)?$search_term_month:'')); ?>"  onkeyup="getEntryDate();getReportDate();">
                            </div>
                        </div>
                        <?php if($errors->has('search_term_month')): ?>
                            <span class="text-danger"><?php echo e($errors->first('search_term_month')); ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="form-error">
                            <div class="form-wrapper">
                                <label>Entry Date :</label>
                                <input type="text" id="sip_entry_date" name="search_entry_date" value="<?php echo e(old('search_from_date',isset($search_entry_date)?$search_entry_date:'')); ?>" class=" form-control" readonly required onchange="getReportDate()">
                            </div>
                            <?php if($errors->has('search_entry_date')): ?>
                                <span class="text-danger"><?php echo e($errors->first('search_entry_date')); ?></span>
                            <?php endif; ?>
                            <span class="text-danger" id="sip_entry_date_err_msg"></span>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="form-error">
                            <div class="form-wrapper">
                                <label>Report Date :</label>
                                <input type="text" class=" form-control" id="report_date" name="search_report_date" value="<?php echo e(old('search_report_date',isset($search_report_date)?$search_report_date:'')); ?>" readonly required>
                            </div>
                            <?php if($errors->has('search_report_date')): ?>
                                <span class="text-danger"><?php echo e($errors->first('search_report_date')); ?></span>
                            <?php endif; ?>
                            <span class="text-danger" id="report_date_err_msg"></span>
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
                                <th style="text-align: center">SIP Amount (INR)</th>
                                <th style="text-align: center">NAV</th>
                                <th style="text-align: center">Units</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if(isset($searched_result) && count($searched_result) > 0): ?>
                            <?php $i = 1; ?>
                                <?php $__currentLoopData = $searched_result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td align="center"><?php echo e($i++); ?></td>
                                        <td align="center" style="white-space: nowrap;"><?php echo e($row['entry_date']); ?></td>
                                        <td align="right"><?php echo e($row['sip_amount']); ?></td>
                                        <td align="right"><?php echo e($row['fund_closing']); ?></td>
                                        <td align="right"><?php echo e($row['units']); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <?php if(isset($search_report_date) &&
            isset($redemption_date) &&
            isset($total_sip_amount) &&
            isset($final_nav) &&
            isset($sum_of_units) &&
            isset($xirr)): ?>
            <div class="row">

                <div class="col-12">
                    <div class="table-wrapper">
                        <table class="table table-bordered result-table">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Report Date</th>
                                    <th style="text-align: center">Redemption Date </th>
                                    <th style="text-align: center">SIP Amount (INR)</th>
                                    <th style="text-align: center">Nav</th>
                                    <th style="text-align: center">Units</th>
                                    <th style="text-align: center">SIP Return</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td align="center"><?php echo e($search_report_date); ?></td>
                                    <td align="center"><?php echo e($redemption_date); ?></td>
                                    <td align="center"><?php echo e($total_sip_amount); ?></td>
                                    <td align="center"><?php echo e($final_nav); ?></td>
                                    <td align="center"><?php echo e($sum_of_units); ?></td>
                                    <td align="center"><?php echo e($xirr); ?></td>
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
<?php echo $__env->make('web.layout.infosolz_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/web/infosolz-calculator/sip.blade.php ENDPATH**/ ?>