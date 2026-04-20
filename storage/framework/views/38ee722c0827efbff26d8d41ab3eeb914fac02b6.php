<?php $__env->startSection('content'); ?>
    
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                        <li><a href="<?php echo e(route('user.ratio_dashboard')); ?>">Ratio Reports</a></li>
                        <li>Comparative</li>
                    </ul>
                </div>
                <div class="perform_head">
                    <h2>Comparative</h2>
                </div>
                <div class="new_page">
                    <div class="wm_tab">
                        <ul class="tabs">
                            <li>
                                <a class="<?php echo e(isset($quartile_set) ? ($quartile_set == 'quartile' ? 'active' : '') : 'active'); ?>"
                                    id="quartile_tab" data-value="quartile" onclick="max_min_fund(this)">Quartile</a>
                            </li>
                            <li>
                                <a class="<?php echo e(isset($quartile_set) && $quartile_set == 'decile' ? 'active' : ''); ?>"
                                    id="decile_tab" data-value="decile" onclick="max_min_fund(this)">Decile</a>
                            </li>
                        </ul>
                    </div>
                    

                    <input type="hidden" name="quartile_status" id="quartile_status"
                        value="<?php echo e(isset($quartile_set) ? $quartile_set : ''); ?>">

                    <div class="light_green_bg">
                        <form action="">
                            <input type="hidden" name="quartile_set" id="quartile_set"
                                value="<?php echo e(isset($quartile_set) ? $quartile_set : 'quartile'); ?>">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form_group radio_btn">
                                        <label>
                                            <input type="radio" name="Category" checked value="by_category"
                                                <?php if(isset($request) && $request->Category == 'by_category'): ?> <?php echo e('Checked'); ?> <?php endif; ?>
                                                onclick='get_fund_types_js(this.value)'>
                                            By Category
                                        </label>
                                        <label>
                                            <input type="radio" name="Category" value="by_fund"
                                                <?php if(isset($request) && $request->Category == 'by_fund'): ?> <?php echo e('Checked'); ?> <?php endif; ?>
                                                onclick='get_fund_types_js(this.value)'>
                                            By Fund
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row date_sec">
                                        <label>1st period</label>
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <input type="text" placeholder="Start Date" class="datepicker"
                                                    name="p_one_start_date" readonly required
                                                    value="<?php echo e(old('p_one_start_date', isset($p_one_start_date) ? date('d-m-Y', strtotime($p_one_start_date)) : '')); ?>">
                                                <?php $__errorArgs = ['p_one_start_date'];
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
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <input type="text" placeholder="End Date" class="datepicker"
                                                    name="p_one_end_date" readonly required
                                                    value="<?php echo e(old('p_one_end_date', isset($p_one_end_date) ? date('d-m-Y', strtotime($p_one_end_date)) : '')); ?>">

                                                <?php $__errorArgs = ['p_one_end_date'];
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
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row date_sec">
                                        <label>2nd period</label>
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <input type="text" placeholder="Start Date" class="datepicker"
                                                    name="p_two_start_date" readonly required
                                                    value="<?php echo e(old('p_two_start_date', isset($p_two_start_date) ? date('d-m-Y', strtotime($p_two_start_date)) : '')); ?>">

                                                <?php $__errorArgs = ['p_two_start_date'];
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
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <input type="text" placeholder="End Date" class="datepicker"
                                                    name="p_two_end_date" readonly required
                                                    value="<?php echo e(old('p_two_end_date', isset($p_two_end_date) ? date('d-m-Y', strtotime($p_two_end_date)) : '')); ?>">

                                                <?php $__errorArgs = ['p_two_end_date'];
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
                                    </div>
                                </div>
                                <div class="col-md-6 div_show_1">
                                    <div class="form_group">
                                        <select name="fund_type_id" id="fund_type" class="select2"
                                            data-placeholder="Select Fund Classification">
                                            <option value=""></option>
                                            <?php if(isset($fund_type)): ?>
                                                <?php $__currentLoopData = $fund_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($val->ft_id); ?>"
                                                        <?php echo e(isset($fund_type_id) && $fund_type_id == $val->ft_id ? 'selected' : ''); ?>>
                                                        <?php echo e($val->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
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

                                <div class="col-md-6 div_hide_1">
                                    <div class="form_group multiple_select">
                                        <select name="fund_id[]" class="select2 multiple" id="select_fund_multiple"
                                            data-max="20" multiple onchange='fund_multiple(this)'>
                                            <option value="">Select Fund</option>
                                            <?php if(isset($all_funds)): ?>
                                                <?php $__currentLoopData = $all_funds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($val->fund_id); ?>"
                                                        <?php if(isset($fund_id) && is_array($fund_id) && in_array($val->fund_id, $fund_id)): ?> selected <?php endif; ?>>
                                                        <?php echo e($val->fund_name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
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

                                <div class="col-md-6">
                                    <div class="form_group">
                                        <select name="report_category">
                                            <option value="">Ratio</option>
                                            <optgroup label="Return Ratio">
                                                <option value="returns" <?php if(old(
                                                        'report_category',
                                                        isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'returns'): ?> selected <?php endif; ?>>
                                                    Returns/CAGR
                                                </option>
                                                <option value="jensens_alpha"
                                                    <?php if(old(
                                                            'report_category',
                                                            isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'jensens_alpha'): ?> selected <?php endif; ?>>
                                                    Jensen’s alpha
                                                </option>
                                                <option value="sharpe" <?php if(old(
                                                        'report_category',
                                                        isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'sharpe'): ?> selected <?php endif; ?>>
                                                    Sharpe
                                                </option>
                                                <option value="treynor" <?php if(old(
                                                        'report_category',
                                                        isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'treynor'): ?> selected <?php endif; ?>>
                                                    Treynor
                                                </option>
                                                <option value="information_ratio"
                                                    <?php if(old(
                                                            'report_category',
                                                            isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'information_ratio'): ?> selected <?php endif; ?>>
                                                    Information Ratio
                                                </option>
                                                <option value="one_month_rolling_return"
                                                    <?php if(old(
                                                            'report_category',
                                                            isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'one_month_rolling_return'): ?> selected <?php endif; ?>>
                                                    1 month Rolling Return
                                                </option>
                                            </optgroup>

                                            <optgroup label="Risk Ratio">
                                                <option value="beta" <?php if(old(
                                                        'report_category',
                                                        isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'beta'): ?> selected <?php endif; ?>>
                                                    Beta
                                                </option>
                                                <option value="volatility"
                                                    <?php if(old(
                                                            'report_category',
                                                            isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'volatility'): ?> selected <?php endif; ?>>
                                                    Volatility
                                                </option>
                                                <option value="tracking_error"
                                                    <?php if(old(
                                                            'report_category',
                                                            isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'tracking_error'): ?> selected <?php endif; ?>>
                                                    Tracking Error
                                                </option>
                                            </optgroup>

                                            <optgroup label="Symmetry Ratio">
                                                <option value="skewness"
                                                    <?php if(old(
                                                            'report_category',
                                                            isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'skewness'): ?> selected <?php endif; ?>>
                                                    Skewness
                                                </option>
                                                <option value="kurtosis"
                                                    <?php if(old(
                                                            'report_category',
                                                            isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'kurtosis'): ?> selected <?php endif; ?>>
                                                    Kurtosis
                                                </option>
                                            </optgroup>

                                            <optgroup label="Correlation">
                                                <option value="r_square"
                                                    <?php if(old(
                                                            'report_category',
                                                            isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'r_square'): ?> selected <?php endif; ?>>
                                                    R Square
                                                </option>
                                            </optgroup>
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


                                <div class="col-md-12">
                                    <div class="bttn_grp">
                                        
                                        
                                        <button type="submit" name="search" id="submit_btn"
                                            value="search">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    

                    <?php if(isset($p_one_quartile_decile_result) &&
                            isset($p_one_quartile_decile_result['fund_absolute_return']) &&
                            isset($p_two_quartile_decile_result) &&
                            isset($p_two_quartile_decile_result['fund_absolute_return'])): ?>
                        <div class="fund_section new_fund_section">
                            <ul>
                                <li>
                                    <b>1st period -</b>
                                    <figure>
                                        <p>start date :</p>
                                        <span><?php echo e(isset($p_one_start_date) ? date('d-m-Y', strtotime($p_one_start_date)) : 'N/A'); ?></span>
                                    </figure>
                                    <figure>
                                        <p>end date :</p>
                                        <span><?php echo e(isset($p_one_end_date) ? date('d-m-Y', strtotime($p_one_end_date)) : 'N/A'); ?></span>
                                    </figure>
                                </li>
                                <li>
                                    <b>2nd period -</b>
                                    <figure>
                                        <p>start date :</p>
                                        <span><?php echo e(isset($p_two_start_date) ? date('d-m-Y', strtotime($p_two_start_date)) : 'N/A'); ?></span>
                                    </figure>
                                    <figure>
                                        <p>end date :</p>
                                        <span><?php echo e(isset($p_two_end_date) ? date('d-m-Y', strtotime($p_two_end_date)) : 'N/A'); ?></span>
                                    </figure>
                                </li>
                                <li>
                                    <p>by functions :</p>
                                    <span><?php echo e(ucwords(str_replace('_', ' ', $report_category ?? 'N/A'))); ?></span>
                                </li>
                                <?php if(isset($fund_type_id)): ?>
                                    <li>
                                        <p>fund classification :</p>
                                        <span><?php echo e(getNameTable('fund_type', 'name', 'ft_id', $fund_type_id)); ?></span>
                                    </li>
                                <?php elseif(isset($fund_id)): ?>
                                    <li>
                                        <p>fund names :</p>
                                        <span>
                                            <?php $__currentLoopData = $fund_id; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e(getNameTable('fund_master', 'fund_name', 'fund_id', $item)); ?>,
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </span>
                                    </li>
                                <?php endif; ?>

                                
                            </ul>
                        </div>

                        <div class="quartile_tab">
                            <div class="graph_table">

                                <div class="share_pdf">
                                    <div class="sharethis-inline-share-buttons"></div>
                                    <a href="javascript:void(0)" id="exportPDFquartile" class="pdf"><img
                                            src="<?php echo e(asset('themes/frontend/assets/infosolz/images/pdf.png')); ?>"></a>

                                </div>

                                <table class="table comp">
                                    <thead>
                                        <tr>
                                            <th style="width: 67%;"></th>
                                            <th colspan="2" class="text_center">1st period</th>
                                            <th colspan="2" class="text_center">2nd period</th>
                                        </tr>
                                    </thead>
                                </table>

                                <table class="table comp2 datatable" id="pdfData">
                                    <thead>
                                        <tr>
                                            <th class="text_left">Name of the Fund</th>

                                            <th class="text_center">Rank</th>
                                            <th class="text_center">Ratio</th>

                                            <th class="text_center">Rank</th>
                                            <th class="text_center">Ratio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $ratio_array = ['beta', 'volatility', 'tracking_error'];
                                            // if (
                                            //     isset($report_category) &&
                                            //     isset($p_one_quartile_decile_result['fund_absolute_return'])
                                            // ) {
                                            //     if (in_array($report_category, $ratio_array)) {
                                            //         asort($p_one_quartile_decile_result[$quartile_set]);
                                            //     } else {
                                            //         arsort($p_one_quartile_decile_result[$quartile_set]);
                                            //     }
                                            // }

                                            if (
                                                isset($quartile_set) &&
                                                isset($p_one_quartile_decile_result[$quartile_set]) &&
                                                count($p_one_quartile_decile_result[$quartile_set]) > 0
                                            ) {
                                                // dd(($p_one_quartile_decile_result[$quartile_set]);
                                                $ratio_array = ['beta', 'volatility', 'tracking_error'];
                                                if (
                                                    isset($report_category) &&
                                                    in_array($report_category, $ratio_array)
                                                ) {
                                                    $p_one_quartile_decile_result[$quartile_set] = custom_sort(
                                                        $p_one_quartile_decile_result[$quartile_set],
                                                    );
                                                    // asort(($p_one_quartile_decile_result[$quartile_set]);
                                                } else {
                                                    $p_one_quartile_decile_result[$quartile_set] = custom_sort(
                                                        $p_one_quartile_decile_result[$quartile_set],
                                                        'dsc',
                                                    );
                                                    // arsort(($p_one_quartile_decile_result[$quartile_set]);
                                                }
                                            }
                                        ?>

                                        <?php $__currentLoopData = $p_one_quartile_decile_result[$quartile_set]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fundId => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="data">
                                                <td class="text_left" id='fund_names'>
                                                    <?php echo e(getNameTable('fund_master', 'fund_name', 'fund_id', $fundId)); ?>

                                                </td>

                                                <td class="text_right">
                                                    <?php if($quartile_set == 'quartile'): ?>
                                                        <?php echo e(is_numeric($p_one_quartile_decile_result['fund_absolute_return'][$fundId]) ? printRank($p_one_quartile_decile_result['quartile'][$fundId]) : printRank('N/A')); ?>

                                                    <?php else: ?>
                                                        <?php echo e(is_numeric($p_one_quartile_decile_result['fund_absolute_return'][$fundId]) ? printRank($p_one_quartile_decile_result['decile'][$fundId]) : printRank('N/A')); ?>

                                                    <?php endif; ?>
                                                </td>

                                                <td class="text_right">
                                                    <?php echo e(printValue($p_one_quartile_decile_result['fund_absolute_return'][$fundId])); ?>

                                                </td>

                                                <td class="text_right">
                                                    <?php if($quartile_set == 'quartile'): ?>
                                                        <?php echo e(is_numeric($p_two_quartile_decile_result['fund_absolute_return'][$fundId]) ? printRank($p_two_quartile_decile_result['quartile'][$fundId]) : printRank('N/A')); ?>

                                                    <?php else: ?>
                                                        <?php echo e(is_numeric($p_two_quartile_decile_result['fund_absolute_return'][$fundId]) ? printRank($p_two_quartile_decile_result['decile'][$fundId]) : printRank('N/A')); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td class="text_right">
                                                    <?php echo e(printValue($p_two_quartile_decile_result['fund_absolute_return'][$fundId])); ?>

                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <!-- <tr class="no-data" style="display: none">
                                                        <td colspan="5">No information available for this search</td>
                                                    </tr> -->

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php echo printNoData(); ?>

                    <?php endif; ?>
                </div>
            </div>
            <?php if(isset($quartile_set) && isset($p_one_quartile_decile_result[$quartile_set])): ?>
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
    function max_min_fund(element) {
        var value = element.getAttribute('data-value');

        $('#quartile_set').val(value);

        var selectedOptions = $('#select_fund_multiple').val() || []; // Get selected options or empty array
        var selectedCategory = $('input[name="Category"]:checked').val();

        var status = $('#quartile_status').val();

        // No need for console.log here (unless for debugging purposes)

        var min = 0;
        var message = '';

        if (value === 'quartile') {
            $('#select_fund_multiple').attr('data-min', 4);
            min = 4;
            message = '<p>You need to select at least ' + min + ' and maximum 20 funds.</p>';
        } else if (value === 'decile') {
            $('#select_fund_multiple').attr('data-min', 10);
            min = 10;
            message = '<p>You need to select at least ' + min + ' and maximum 20 funds.</p>';
        }

        $('#fund_msgg').html(message);

        // Logical errors in the original conditions
        if ((status === 'quartile' && value === 'decile') || (status === 'decile' && value === 'quartile')) {
            // Hide elements with class 'data' and show 'no-data'
            $('.table.comp tbody .data').hide();
            $('.table.comp tbody .no-data').show();
        } else {
            // Show elements with class 'data' and hide 'no-data' (assuming they exist)
            $('.table.comp tbody .data').show();
            $('.table.comp tbody .no-data').hide();
        }


        if (selectedCategory == 'by_fund') {
            if (selectedOptions.length >= min) {
                $('#submit_btn').prop('disabled', false);
            } else {
                $('#submit_btn').prop('disabled', true);
            }
        } else {
            $('#submit_btn').prop('disabled', false);
        }
    }

    window.addEventListener('load', function() {
        document.getElementById('select_fund_multiple').setAttribute('data-min', 4);
        var value = document.getElementById('quartile_set').value;
    });

    // function get_fund_types(thiss) {

    //     var count = $('#select_fund_multiple').select2('data').length;

    //     if (thiss == 'by_category') {

    //         $('#submit_btn').prop('disabled', false);
    //     } else if (thiss == 'by_fund') {

    //         fund_multiple();

    //     }
    // }

    // function fund_multiple(selectElement) {

    //     var min = parseInt($(selectElement).attr('data-min') || 0);
    //     var max = parseInt($(selectElement).attr('data-max') || Infinity);
    //     var selectedOptions = $(selectElement).val();

    //     // Check both min and max conditions in a single expression
    //     var isValidSelection = selectedOptions.length >= min && selectedOptions.length <= max;

    //     // Build the message based on validity
    //     var message = '';
    //     if (!isValidSelection) {
    //         if (selectedOptions.length > max) {
    //             message = '<p>You can select a maximum of ' + max + ' items.</p>';
    //         } else {
    //             message = '<p>You need to select at least ' + min + ' and maximum ' + max + ' funds.</p>';
    //         }
    //     }

    //     // Update button state based on validity
    //     $('#submit_btn').prop('disabled', !isValidSelection);

    //     // Display the message
    //     $('#fund_msgg').html(message);

    // }




    document.addEventListener('DOMContentLoaded', function() {
        var exportButton = document.getElementById('exportPDFquartile');

        exportButton.addEventListener('click', function() {
            var {
                jsPDF
            } = window.jspdf;
            var doc = new jsPDF();

            var img = new Image();
            img.src = "<?php echo e(asset('themes/frontend/assets/infosolz/images/small_logo.png')); ?>";
            img.onload = function() {
                var pageWidth = doc.internal.pageSize.getWidth();
                var imgWidth = 50;
                var imgHeight = 20;
                var centerX = (pageWidth - imgWidth) / 2;

                doc.addImage(img, 'PNG', centerX, 10, imgWidth, imgHeight);

                // Get active tab (Quartile or Decile)
                var activeTab = document.querySelector('.tabs .active').getAttribute('data-value');
                // var reportTitle = activeTab.charAt(0).toUpperCase() + activeTab.slice(1);
                var reportTitle = 'Comparative ' + activeTab.charAt(0).toUpperCase() + activeTab
                    .slice(1); // Add "Comparative" before the capitalized active tab

                // Title
                doc.setFontSize(16);
                doc.setTextColor(45, 135, 23);
                doc.text(reportTitle, pageWidth / 2, 35, {
                    align: 'center'
                });

                // Set Y position for the next text below the title
                var nextYPosition = 35 + 10; // 10 units below the title

                doc.setFontSize(12);
                doc.setTextColor(0, 0, 0);

                // Date and functions details
                var startDate1 =
                    "<?php echo e(isset($p_one_start_date) ? date('d/m/Y', strtotime($p_one_start_date)) : '00/00/0000'); ?>";
                var endDate1 =
                    "<?php echo e(isset($p_one_end_date) ? date('d/m/Y', strtotime($p_one_end_date)) : '00/00/0000'); ?>";
                var startDate2 =
                    "<?php echo e(isset($p_two_start_date) ? date('d/m/Y', strtotime($p_two_start_date)) : '00/00/0000'); ?>";
                var endDate2 =
                    "<?php echo e(isset($p_two_end_date) ? date('d/m/Y', strtotime($p_two_end_date)) : '00/00/0000'); ?>";
                var functions =
                "<?php echo e(isset($report_category) ? $report_category : 'N/A'); ?>"; // Renamed variable
                var fundClassification =
                    "<?php echo e(isset($fund_type_id) ? getNameTable('fund_type', 'name', 'ft_id', $fund_type_id) : 'N/A'); ?>";

                //var fundClassification = "<?php echo e(isset($fund_type_name) ? $fund_type_name[0] : ''); ?>";
                var fundNameElement = document.getElementById('fund_names');
                var fundNames = fundNameElement ? fundNameElement.innerText : 'N/A';


                var startX = 15;
                // Set font to bold for the title
                doc.setFont("Helvetica", "bold"); // Change the font to bold
                doc.text("1st Period", startX, nextYPosition);
                nextYPosition += 10;

                // Set back to normal font for the rest of the text
                doc.setFont("Helvetica", "normal"); // Change back to normal font
                doc.text(`Start Date: ${startDate1}`, startX, nextYPosition);
                nextYPosition += 10;
                doc.text(`End Date: ${endDate1}`, startX, nextYPosition);
                nextYPosition += 10;

                doc.setFont("Helvetica", "bold"); // Change the font to bold
                doc.text("2nd Period", startX, nextYPosition);
                nextYPosition += 10;

                doc.setFont("Helvetica", "normal");
                doc.text(`Start Date: ${startDate2}`, startX, nextYPosition);
                nextYPosition += 10;
                doc.text(`End Date: ${endDate2}`, startX, nextYPosition);
                nextYPosition += 10;

                // Display Functions and Fund Classification
                doc.text(`By Functions: ${functions}`, startX, nextYPosition + 5);


                if (fundClassification !== 'N/A') {
                    doc.text(`Fund Classification: ${fundClassification}`, startX, nextYPosition +
                        40);
                }

                // if (fundNames !== '') {
                //     var wrappedFundNames = doc.splitTextToSize(fundNames, 180); // 180 defines the max width of text before breaking
                //     doc.text('Fund Name:', startX, yPosition);
                //     yPosition += 10;
                //     doc.text(wrappedFundNames, startX, yPosition);  // Write the wrapped text
                //     yPosition += (wrappedFundNames.length * 7); // Adjust yPosition based on the number of lines
                // }

                // Collect the table data from the DOM
                var tableData = [];
                var tableRows = document.querySelectorAll("#pdfData tbody tr");

                tableRows.forEach(function(row) {
                    var rowData = [];
                    row.querySelectorAll("td").forEach(function(cell) {
                        rowData.push(cell.innerText);
                    });
                    tableData.push(rowData);
                });

                // Log collected table data
                console.log("Table Data:", tableData);

                // Generate table in PDF
                // doc.autoTable({
                //     startY: nextYPosition + 50, // Adjust to start the table below the other text
                //     head: [['Name of the Fund', 'Rank (1st)', 'Ratio (1st)', 'Rank (2nd)', 'Ratio (2nd)']], // Ensure header matches the content
                //     body: tableData
                // });

                // Generate table in PDF
                doc.autoTable({
                    startY: nextYPosition +
                    50, // Adjust to start the table below the other text
                    head: [
                        ['', {
                            content: '1st Period',
                            colSpan: 2
                        }, {
                            content: '2nd Period',
                            colSpan: 2
                        }],
                        ['Name of the Fund', 'Rank', 'Ratio', 'Rank',
                        'Ratio'] // Second level headers
                    ],
                    body: tableData,
                    headStyles: {
                        fillColor: [45, 135, 23]
                    },
                });

                // Save the PDF
                var currentDate = new Date();
                var fileName = `${reportTitle}-${currentDate.toISOString().split('T')[0]}.pdf`;
                doc.save(fileName);
            };
        });
    });
</script>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/ratio-reports/comparative.blade.php ENDPATH**/ ?>