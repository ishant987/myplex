<?php $__env->startSection('content'); ?>

    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                        <li><a href="<?php echo e(route('user.ratio_analysis')); ?>"> Ratio Analysis</a></li>
                        <li>Risk Ratio</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>

                    <div class="light_green_bg">
                        <form method="GET" action="">
                            <input type="hidden" name="quartile_set" id="quartile_set"
                                value="<?php echo e(isset($quartile_set) ? $quartile_set : 'quartile'); ?>">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form_group radio_btn">
                                        <label>
                                            <input type="radio" name="ranking" value="range" checked>
                                            Range
                                        </label>
                                        <label>
                                            <input type="radio" name="ranking" value="as_on">
                                            As on
                                        </label>
                                        <?php $__errorArgs = ['ranking'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="alert alert-danger"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                </div>
                                <div class="col-md-4 div_show">
                                    <div class="form_group">
                                        <input type="date" class="form-control" placeholder="Start date" name="start_date"
                                            value="<?php echo e($request->has('start_date') ? \Carbon\Carbon::parse($request->start_date)->format('Y-m-d') : old('start_date')); ?>">
                                        <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="alert alert-danger"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                </div>
                                <div class="col-md-4 div_show">
                                    <div class="form_group">
                                        <input type="date" class="form-control" placeholder="End date" name="end_date"
                                            value="<?php echo e($request->has('end_date') ? \Carbon\Carbon::parse($request->end_date)->format('Y-m-d') : old('end_date')); ?>">
                                        <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="alert alert-danger"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-4 div_hide">
                                    <div class="form_group">
                                        <input type="date" name="as_on_date" class="form-control" placeholder="date"
                                            value="<?php echo e(!empty($request->as_on_date) ? \Carbon\Carbon::parse($request->as_on_date)->format('Y-m-d') : ''); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4 div_hide">
                                    <div class="form_group">
                                        <select name="as_on_time_frame">
                                            <option value="1_month"
                                                <?php if(isset($request) && $request->as_on_time_frame == '1_month'): ?> <?php echo e('selected'); ?> <?php endif; ?>>1 Month
                                            </option>
                                            <option value="3_months"
                                                <?php if(isset($request) && $request->as_on_time_frame == '3_months'): ?> <?php echo e('selected'); ?> <?php endif; ?>>3 Months
                                            </option>
                                            <option value="6_months"
                                                <?php if(isset($request) && $request->as_on_time_frame == '6_months'): ?> <?php echo e('selected'); ?> <?php endif; ?>>6 Months
                                            </option>
                                            <option value="1_year"
                                                <?php if(isset($request) && $request->as_on_time_frame == '1_year'): ?> <?php echo e('selected'); ?> <?php endif; ?>>1 Year
                                            </option>
                                            <option value="2_year"
                                                <?php if(isset($request) && $request->as_on_time_frame == '2_year'): ?> <?php echo e('selected'); ?> <?php endif; ?>>2 Year
                                            </option>
                                            <option value="3_years"
                                                <?php if(isset($request) && $request->as_on_time_frame == '3_years'): ?> <?php echo e('selected'); ?> <?php endif; ?>>3 Years
                                            </option>
                                            <option value="5_years"
                                                <?php if(isset($request) && $request->as_on_time_frame == '5_years'): ?> <?php echo e('selected'); ?> <?php endif; ?>>5 Years
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form_group radio_btn">
                                        <label>
                                            <input type="radio" id="type_Category" name="Category" checked
                                                value="by_category"
                                                <?php if(isset($request) && $request->Category == 'by_category'): ?> <?php echo e('Checked'); ?> <?php endif; ?>
                                                onclick='get_fund_types(this.value)'>
                                            By Category
                                        </label>
                                        <label>
                                            <input type="radio" id="fund_Category" name="Category" value="by_fund"
                                                <?php if(isset($request) && $request->Category == 'by_fund'): ?> <?php echo e('Checked'); ?> <?php endif; ?>
                                                onclick='get_fund_types(this.value)'>
                                            By Fund
                                        </label>
                                    </div>

                                </div>
                                <div class="col-md-4 div_show_1">
                                    <div class="form_group">
                                        <select name="fund_type_id" class="select2" data-placeholder="Select Fund Classification">
                                            <option value=""></option>
                                            <?php $__currentLoopData = $all_fund_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fund_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($fund_type->ft_id); ?>"
                                                    <?php if($fund_type->ft_id == old('fund_type_id', $request->fund_type_id)): ?> selected <?php endif; ?>>
                                                    <?php echo e($fund_type->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['fund_type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="alert alert-danger"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                </div>

                                <!-- <div class="col-md-4">
                                    <div class="form_group">
                                        <select name="report_category">
                                            <option value="">Report Category</option>
                                            <option value="returns"
                                                <?php if(old('report_category', $request->report_category) == 'returns'): ?> selected <?php endif; ?>>
                                                Returns %
                                            </option>
                                            <option value="indices"
                                                <?php if(old('report_category', $request->report_category) == 'indices'): ?> selected <?php endif; ?>>
                                                Indices
                                            </option>
                                            <option value="return_less_index"
                                                <?php if(old('report_category', $request->report_category) == 'return_less_index'): ?> selected <?php endif; ?>>
                                                Return Less Index
                                            </option>
                                        </select>
                                        <?php $__errorArgs = ['report_category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="alert alert-danger"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    
                                </div> -->

                                <div class="col-md-4 div_hide_1">
                                    <div class="form_group">
                                        <select name="fund_id[]" class="select2 multiple" multiple
                                            id="allocation_select_fund" onchange ='set_fund_select_val(this.value)'>
                                            <?php $__currentLoopData = $all_funds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($fund->fund_id); ?>"
                                                    <?php if($fund->fund_id == old('fund_id', $request->fund_id)): ?> selected
                                                <?php elseif(isset($fund_id) && in_array($fund->fund_id, $fund_id)): ?>
                                                selected <?php endif; ?>>
                                                    <?php echo e($fund->fund_name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['fund_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="alert alert-danger"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                        <span class="text-danger" id="fund_msgg"></span>
                                    </div>
                                   
                                </div>

                                <div class="col-md-4">
                                    <div class="form_group">
                                        <select name="report_category">
                                            <option value="">Ratio</option>

                                            <option value="beta" <?php if(old('report_category', $request->report_category) == 'beta'): ?> selected <?php endif; ?>>
                                                Beta
                                            </option>
                                            <option value="volatility" <?php if(old('report_category', $request->report_category) == 'volatility'): ?> selected <?php endif; ?>>
                                                Volatility
                                            </option>
                                            <option value="tracking_error" 
                                            <?php if(old('report_category', $request->report_category) == 'tracking_error'): ?> selected <?php endif; ?>>
                                            Tracking Error
                                        </option>
                                            <!-- <option value="cagr"
                                                <?php if(old('report_category', $request->report_category) == 'cagr'): ?> selected <?php endif; ?>>
                                                CAGR
                                            </option> -->
                                        </select>
                                        <?php $__errorArgs = ['report_category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="alert alert-danger"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form_group">
                                        <select name="index_id" id=""class="select2" data-placeholder="Select Indices">
                                            <option value=""></option>
                                            <?php $__currentLoopData = $indices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ind): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <option value="<?php echo e($ind->idc_id); ?>"  <?php if($ind->idc_id == old('fund_type_id', $request->index_id)): ?> selected <?php endif; ?>><?php echo e($ind->name); ?></option>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                        </select>
                                        <?php $__errorArgs = ['index_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="alert alert-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>


                                <!-- <div class="col-md-4 div_hide_1">
                                    <div class="form_group">
                                        <select name="fund_id">
                                            <?php $__currentLoopData = $all_funds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option value="<?php echo e($fund->fund_id); ?>"
                                                    <?php if($fund->fund_id == old('fund_id', $request->fund_id)): ?> selected <?php endif; ?>>
                                                    <?php echo e($fund->fund_name); ?>

                                                </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['fund_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="alert alert-danger"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    
                                </div> -->




                                <div class="col-md-12">
                                    <div class="bttn_grp">
                                        <button type="submit" id="submit_btn">Search</button>
                                        <!-- <button type="submit" name="submit" value="search_by_fund">show by fund</button> -->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>



                    <?php if(isset($request)&& isset($start_date) && isset($end_date) &&  $request->Category !='' && $request->report_category !=''): ?>
                        <div class="fund_section new_fund_section">
                            <ul>
                                <li>
                                    <p>Start date :</p>
                                    <span><?php echo e(isset($start_date) ? date('d/m/Y', strtotime($start_date)) : '00/00/0000'); ?></span>
                                </li>
                                <li>
                                    <p>End date :</p>
                                    <span><?php echo e(isset($end_date) ? date('d/m/Y', strtotime($end_date)) : '00/00/0000'); ?></span>
                                </li>

                               

                                <li>
                                    <p>By Ratio :</p>

                                    <span>
                                        <?php if(isset($request->report_category) && $request->report_category == 'returns'): ?>
                                            <?php echo e('Returns/CAGR'); ?>

                                        <?php elseif(isset($request->report_category) && $request->report_category == 'jensens_alpha'): ?>
                                            <?php echo e('Jensen’s alpha'); ?>

                                        <?php elseif(isset($request->report_category) && $request->report_category == 'sharpe'): ?>
                                            <?php echo e('Sharpe'); ?>

                                        <?php elseif(isset($request->report_category) && $request->report_category == 'treynor'): ?>
                                            <?php echo e('Treynor'); ?>

                                        <?php elseif(isset($request->report_category) && $request->report_category == 'information_ratio'): ?>
                                            <?php echo e('Information Ratio'); ?>

                                        <?php elseif(isset($request->report_category) && $request->report_category == 'one_month_rolling_return'): ?>
                                            <?php echo e('1 month Rolling Return'); ?>

                                        <?php elseif(isset($request->report_category) && $request->report_category == 'beta'): ?>
                                            <?php echo e('Beta'); ?>

                                        <?php elseif(isset($request->report_category) && $request->report_category == 'volatility'): ?>
                                            <?php echo e('Volatility'); ?>

                                        <?php elseif(isset($request->report_category) && $request->report_category == 'tracking_error'): ?>
                                            <?php echo e('Tracking Error'); ?>

                                        <?php elseif(isset($request->report_category) && $request->report_category == 'skewness'): ?>
                                            <?php echo e('Skewness'); ?>

                                        <?php elseif(isset($request->report_category) && $request->report_category == 'kurtosis'): ?>
                                            <?php echo e('Kurtosis'); ?>

                                        <?php elseif(isset($request->report_category) && $request->report_category == 'r_square'): ?>
                                            <?php echo e('R Sqaure'); ?>

                                        <?php endif; ?>
                                    </span>
                                </li>





                                <?php if(isset($as_on_time_frame_data)): ?>
                                    <li>
                                        <p>Duration :</p>
                                        <span>
                                            <?php if(isset($request) && $request->as_on_time_frame == '1_month'): ?>
                                                <?php echo e('1 Month'); ?>

                                            <?php elseif(isset($request) && $request->as_on_time_frame == '3_months'): ?>
                                                <?php echo e('3 Month'); ?>

                                            <?php elseif(isset($request) && $request->as_on_time_frame == '6_months'): ?>
                                                <?php echo e('6 Month'); ?>

                                            <?php elseif(isset($request) && $request->as_on_time_frame == '1_year'): ?>
                                                <?php echo e('1 Year'); ?>

                                            <?php elseif(isset($request) && $request->as_on_time_frame == '2_year'): ?>
                                                <?php echo e('2 Year'); ?>

                                            <?php elseif(isset($request) && $request->as_on_time_frame == '3_years'): ?>
                                                <?php echo e('3 Years'); ?>

                                            <?php elseif(isset($request) && $request->as_on_time_frame == '5_years'): ?>
                                                <?php echo e('5 Years'); ?>

                                            <?php endif; ?>
                                        </span>
                                    </li>
                                <?php endif; ?>

                               

                                <?php if(isset($request) && $request->Category == 'by_category'): ?>
                                <li>
                                    <p>fund classification :</p>
                                    <span><?php echo e(isset($fund_type_name) ? $fund_type_name : ''); ?></span>
                                </li>
                            <?php endif; ?>

                            <?php if(isset($request) && $request->index_id != ''): ?>
                            <li>
                                <p>Index Name:</p>
                                <span><?php echo e(isset($index_name->name) ? $index_name->name : ''); ?></span>
                            </li>
                           <?php endif; ?>

                                <?php if(isset($request) && $request->Category == 'by_fund'): ?>
                                <li>
                                    <p>fund name :</p>
                                    <span><?php echo e(isset($fund_names) ? $fund_names : ''); ?></span>
                                </li>
                            <?php endif; ?>

                            </ul>
                        </div>

                        <div class="graph_table">
                            <div class="share_pdf">
                                
                                <div class="sharethis-inline-share-buttons" ></div>
                                <a href="javascript:void(0)" id="exportPDF" class="pdf"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/pdf.png')); ?>" ></a>
                                
                            </div>
                            <table class="table datatable" id="pdfData">
                                <thead>
                                    <tr>
                                        <th class="text_left">fund name</th>
                                        <th class="text_center">ratio</th>
                                        <th class="text_center">rank</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($stat_result['fund_absolute_return']) && count($stat_result['fund_absolute_return']) > 0): ?>

                                    <?php
                                        $fundReturns = $stat_result['fund_absolute_return'];

                                        // $sortedFundReturns = collect($fundReturns)->sortDesc()->toArray();

                                        // $sortedFundReturns = collect($fundReturns)->sort()->values()->toArray();

                                                                                // Use asort to sort the array while preserving keys
                                        asort($fundReturns);

                                        // Convert the sorted array to a collection if needed
                                        $sortedFundReturns = collect($fundReturns)->toArray();

                                        $formattedArray = array_map(function($value) {
                                            return is_numeric($value) ? number_format($value, 2) : $value;
                                        }, $sortedFundReturns);

                                    $ranks = [];
                                    $rank = 1;
                                    $previousValue = null;
                                    $previousRank = 0;

                                    foreach ($formattedArray as $key => $value) {
                                        if ($value == 'N/A' || $value == '') {
                                            $ranks[$key] = 'N/A';
                                        } else {
                                            if ($value === $previousValue) {
                                                // Assign the same rank as the previous value
                                                $ranks[$key] = $previousRank;
                                            } else {
                                                // Assign current rank and update previous rank and value
                                                $ranks[$key] = $rank;
                                                $previousRank = $rank;
                                                $previousValue = $value;
                                            }
                                            $rank++;
                                        }
                                    }

                                        // dd($formattedArray);

                                    ?>
                                    <?php endif; ?>

                                    <?php if(isset($formattedArray) && count($formattedArray) > 0): ?>

                                    <?php $__currentLoopData = $formattedArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fundId => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="text_left">
                                                <?php echo e(getNameTable('fund_master', 'fund_name', 'fund_id', $fundId)); ?></td>
                                            <td class="text_right"><?php echo e(printValue($value)); ?></td>
                                            <td class="text_right"><?php echo e(printRank($ranks[$fundId])); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>

                                    <tr>
                                        <td colspan="3">No information available for this search</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                       
                        <?php echo printNoData(); ?>

                    <?php endif; ?>
                </div>
                <?php if(isset($stat_result['fund_absolute_return'])): ?>
                <div class="disclaimer">
                    <p><strong>Note : </strong>For the calculations, the first working day is considered in case of Starting
                        and Ending day.</p>
                </div>
            <div class="disclaimer">
                <p><strong>Disclaimer : </strong><?php echo e($disclaimer); ?></p>
            </div>
       
                
        <?php endif; ?>
            </div>
        </div>

    </div>



<?php $__env->stopSection(); ?>

<script>
    function get_date(thiss) {

        if (thiss == 'Range') {

            $('#from_date_div').show();
            $('#year_month').prop('required', false);
            $('#year_month_div').attr('style', 'display:none');
            $('#to_date').attr('placeholder', 'End Date');


        } else if (thiss == 'As on') {

            $('#from_date_div').hide(); // $('#from_date_div').val('');

            $('#from_date').prop('required', false);
            $('#year_month_div').removeAttr('style');
            $('#year_month').prop('required', true);
            $('#to_date').attr('placeholder', 'Date');




        }

    }

    function get_classification(thiss) {

        if (thiss == 'classification') {

            $('#fund_type_div').removeAttr('style');
            $('#fund_type').prop('required', true);


            $('#fund_master').prop('required', false);

            $('#fund_name_div').attr('style', 'display:none');

        } else if (thiss == 'fund') {

            $('#fund_type_div').attr('style', 'display:none');
            $('#fund_type').prop('required', false);


            $('#fund_master').prop('required', true);

            $('#fund_name_div').removeAttr('style');


        }

    }




    function set_fund_select_val() {

        var thiss = $('#fund_Category').val();
        var count = $('#allocation_select_fund').select2('data').length;

        console.log(thiss + '  ' + count);

        if (thiss == 'by_fund') {

            if (count >= 2 && count <= 20) {
                // console.log('enable');
                $('#submit_btn').prop('disabled', false);
            } else {
                // console.log('disabled');
                // alert('Funds selection limit minimum 4 and maximum 20');
                $('#fund_msgg').html('<p>Selection limit minimum 2 and maximum 20 for <b>Funds</b></p>');
                $('#submit_btn').prop('disabled', true);
            }


        } else {
            $('#submit_btn').prop('disabled', false);
        }
    }


    function get_fund_types(thiss) {

        var count = $('#allocation_select_fund').select2('data').length;

        if (thiss == 'by_category') {

            $('#submit_btn').prop('disabled', false);
        } else if (thiss == 'by_fund') {

            if (count >= 2 && count <= 20) {
                // console.log('enable');
                $('#submit_btn').prop('disabled', false);
            } else {
                // console.log('disabled');
                // alert('Funds selection limit minimum 4 and maximum 20');
                $('#fund_msgg').html('<p>Selection limit minimum 2 and maximum 20 for <b>Funds</b></p>');
                $('#submit_btn').prop('disabled', true);
            }

        }
    }


    document.addEventListener('DOMContentLoaded', function() {
    var exportButton = document.getElementById('exportPDF');

    exportButton.addEventListener('click', function() {
        var { jsPDF } = window.jspdf;
        var doc = new jsPDF();

        var img = new Image();
        img.src = "<?php echo e(asset('themes/frontend/assets/infosolz/images/small_logo.png')); ?>";
        img.onload = function() {
            var pageWidth = doc.internal.pageSize.getWidth();
            var imgWidth = 50;
            var imgHeight = 20;
            var centerX = (pageWidth - imgWidth) / 2;

            doc.addImage(img, 'PNG', centerX, 10, imgWidth, imgHeight);

            doc.setFontSize(16);
            doc.setTextColor(45, 135, 23);
            doc.text('Risk Ratios', pageWidth / 2, 35, { align: 'center' });

            doc.setFontSize(12);
            doc.setTextColor(0, 0, 0);

            // Date and ratio details
            var startDate = "<?php echo e(isset($start_date) ? date('d/m/Y', strtotime($start_date)) : '00/00/0000'); ?>";
            var endDate = "<?php echo e(isset($end_date) ? date('d/m/Y', strtotime($end_date)) : '00/00/0000'); ?>";
            var ratio = <?php if(isset($request->report_category)): ?> <?php switch($request->report_category): case ('returns'): ?> 'Returns/CAGR' <?php break; ?> <?php case ('jensens_alpha'): ?> 'Jensen’s alpha' <?php break; ?> <?php case ('sharpe'): ?> 'Sharpe' <?php break; ?> <?php case ('treynor'): ?> 'Treynor' <?php break; ?> <?php case ('information_ratio'): ?> 'Information Ratio' <?php break; ?> <?php case ('one_month_rolling_return'): ?> '1 month Rolling Return' <?php break; ?> <?php case ('beta'): ?> 'Beta' <?php break; ?> <?php case ('volatility'): ?> 'Volatility' <?php break; ?> <?php case ('tracking_error'): ?> 'Tracking Error' <?php break; ?> <?php case ('skewness'): ?> 'Skewness' <?php break; ?> <?php case ('kurtosis'): ?> 'Kurtosis' <?php break; ?> <?php case ('r_square'): ?> 'R Square' <?php break; ?> <?php endswitch; ?> <?php endif; ?>;

            var duration = <?php if(isset($as_on_time_frame_data)): ?> <?php switch($request->as_on_time_frame): case ('1_month'): ?> '1 Month' <?php break; ?> <?php case ('3_months'): ?> '3 Months' <?php break; ?> <?php case ('6_months'): ?> '6 Months' <?php break; ?> <?php case ('1_year'): ?> '1 Year' <?php break; ?> <?php case ('2_year'): ?> '2 Years' <?php break; ?> <?php case ('3_years'): ?> '3 Years' <?php break; ?> <?php case ('5_years'): ?> '5 Years' <?php break; ?> <?php default: ?> null <?php endswitch; ?> <?php else: ?> null <?php endif; ?>;

            var fundClassification = "<?php echo e(isset($fund_type_name) ? $fund_type_name[0] : ''); ?>";
            var indexName = "<?php echo e(isset($index_name->name) ? $index_name->name : ''); ?>";
            var fundNames = "<?php echo e(isset($fund_names) ? $fund_names : ''); ?>";
            
            var startX = 15;
            var lineHeight = 10;
            var yPosition = 70;

            // Adding start date and end date
            doc.text('Start date: ' + startDate, startX, yPosition);
            doc.text('End date: ' + endDate, startX + 70, yPosition);
            // yPosition += 10;

            // Adding ratio and duration
            doc.text('By Ratio: ' + ratio, startX + 140, yPosition);
            // if (duration !== null) {
            //     doc.text('Duration: ' + duration, startX + 100, yPosition);
            // }
            // startX + 100;
            yPosition += 10;


            <?php if(isset($request) && $request->index_id != ''): ?>
                doc.text('Index Name: ' + indexName, startX, yPosition);
            <?php endif; ?>

            // Add fund classification (if by_category)
            <?php if(isset($request) && $request->Category == 'by_category'): ?>
                doc.text('Fund Classification: ' + fundClassification, startX + 70, yPosition);
            <?php endif; ?>

            yPosition += 10;

            <?php if(isset($request) && $request->Category == 'by_fund'): ?>
                // Split the fund names if too long to fit within 180 units (adjust width as necessary)
                var splitFundNames = doc.splitTextToSize(fundNames, 160);
                doc.text('Fund Name: ', startX, yPosition);
                yPosition += 10;
                doc.text(splitFundNames, startX, yPosition);  // This will handle multiple lines
                yPosition += splitFundNames.length * lineHeight; // Adjust yPosition based on the number of lines
            <?php endif; ?>


            // Adding table data (your existing DataTable logic)
            var table = new DataTable('#pdfData');
            var tableData = [];
            table.rows({ search: 'applied' }).data().each(function(row) {
                tableData.push(row);
            });

            doc.autoTable({
                head: [['Fund Name', 'Ratio', 'Rank']],
                body: tableData,
                startX: startX,
                startY: yPosition + 10,
                headStyles: { fillColor: [45, 135, 23] }
            });

            var currentDate = new Date();
            var fileName = 'Risk-Ratios-' + currentDate + '.pdf';

            doc.save(fileName);
        };
    });
});




</script>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/auth/ratio_analysis/risk_ratio.blade.php ENDPATH**/ ?>