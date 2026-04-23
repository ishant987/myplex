<?php $__env->startSection('content'); ?>
    <?php
        $selectedRanking = old('ranking', $request->ranking ?? 'range');
        $selectedCategory = old('Category', $request->Category ?? 'by_category');
        $selectedQuartileSet = old('quartile_set', $request->quartile_set ?? ($quartile_set ?? 'quartile'));
        $isAsOnMode = $selectedRanking === 'as_on';
        $isByFundMode = $selectedCategory === 'by_fund';
    ?>
    <style>
        .fund_section.new_fund_section ul li.fund-name-item span {
            display: block;
            max-width: 100%;
            white-space: normal;
            word-break: break-word;
            overflow-wrap: anywhere;
            line-height: 1.45;
        }
    </style>
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                        <li><a href="<?php echo e(route('user.ratio_dashboard')); ?>">Ratio Reports</a></li>
                        <li>Quartile & Decile</li>
                    </ul>
                </div>

            

                <div class="new_page">

                    <div class="wm_tab">
                        <ul class="tabs">
                            <li>
                                <a class="<?php echo e(isset($request->quartile_set) ? ($request->quartile_set == 'quartile' ? 'active' : '') : 'active'); ?>"
                                    id="quartile_tab" data-value="quartile" onclick="max_min_fund(this)">Quartile</a>
                            </li>
                            <li>
                                <a class="<?php echo e(isset($request->quartile_set) && $request->quartile_set == 'decile' ? 'active' : ''); ?>"
                                    id="decile_tab" data-value="decile" onclick="max_min_fund(this)">Decile</a>
                            </li>
                        </ul>
                    </div>

                    

                    <input type="hidden" name="quartile_status" id="quartile_status"
                        value="<?php echo e(isset($quartile_set) ? $quartile_set : ''); ?>">

                    <div class="light_green_bg">
                        <form method="GET" action="">
                            <input type="hidden" name="quartile_set" id="quartile_set"
                                value="<?php echo e(isset($quartile_set) ? $quartile_set : 'quartile'); ?>">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form_group radio_btn">
                                        <label>
                                            <input type="radio" id="type_Category" name="Category"
                                                value="by_category"
                                                <?php echo e($selectedCategory === 'by_category' ? 'checked' : ''); ?>

                                                onclick='get_fund_types_js(this.value)'>
                                            By Category
                                        </label>
                                        <label>
                                            <input type="radio" id="fund_Category" name="Category" value="by_fund"
                                                <?php echo e($selectedCategory === 'by_fund' ? 'checked' : ''); ?>

                                                onclick='get_fund_types_js(this.value)'>
                                            By Fund
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-4 div_show_1" style="<?php echo e($isByFundMode ? 'display:none;' : ''); ?>">
                                    <div class="form_group">
                                        <select name="fund_type_id" class="select2" data-placeholder="Select Fund Type"
                                            id="fund_type" <?php echo e($isByFundMode ? 'disabled' : ''); ?>>
                                            <option value="">Select Fund Type</option>
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

                                <div class="col-md-4 div_hide_1" style="<?php echo e($isByFundMode ? '' : 'display:none;'); ?>">
                                    <div class="form_group">
                                        <select name="fund_id[]" class="select2 multiple" multiple id="select_fund_multiple"
                                            data-max="20" data-min="<?php echo e($selectedQuartileSet === 'decile' ? 10 : 4); ?>"
                                            onchange='fund_multiple(this)' <?php echo e($isByFundMode ? '' : 'disabled'); ?>>
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
                                            <optgroup label="Return Ratio">
                                                <option value="returns" <?php if(old('report_category', $request->report_category) == 'returns'): ?> selected <?php endif; ?>>
                                                    Returns/CAGR
                                                </option>
                                                <option value="jensens_alpha"
                                                    <?php if(old('report_category', $request->report_category) == 'jensens_alpha'): ?> selected <?php endif; ?>>
                                                    Jensen’s alpha
                                                </option>
                                                <option value="sharpe" <?php if(old('report_category', $request->report_category) == 'sharpe'): ?> selected <?php endif; ?>>
                                                    Sharpe
                                                </option>
                                                <option value="treynor" <?php if(old('report_category', $request->report_category) == 'treynor'): ?> selected <?php endif; ?>>
                                                    Treynor
                                                </option>
                                                <option value="information_ratio"
                                                    <?php if(old('report_category', $request->report_category) == 'information_ratio'): ?> selected <?php endif; ?>>
                                                    Information Ratio
                                                </option>
                                                <option value="one_month_rolling_return"
                                                    <?php if(old('report_category', $request->report_category) == 'one_month_rolling_return'): ?> selected <?php endif; ?>>
                                                    1 month Rolling Return
                                                </option>
                                            </optgroup>

                                            <optgroup label="Risk Ratio">


                                                <option value="beta" <?php if(old('report_category', $request->report_category) == 'beta'): ?> selected <?php endif; ?>>
                                                    Beta
                                                </option>
                                                <option value="volatility"
                                                    <?php if(old('report_category', $request->report_category) == 'volatility'): ?> selected <?php endif; ?>>
                                                    Volatility
                                                </option>
                                                <option value="tracking_error"
                                                    <?php if(old('report_category', $request->report_category) == 'tracking_error'): ?> selected <?php endif; ?>>
                                                    Tracking Error
                                                </option>
                                            </optgroup>

                                            <optgroup label="Symmetry Ratio">
                                                <option value="skewness"
                                                    <?php if(old('report_category', $request->report_category) == 'skewness'): ?> selected <?php endif; ?>>
                                                    Skewness
                                                </option>
                                                <option value="kurtosis"
                                                    <?php if(old('report_category', $request->report_category) == 'kurtosis'): ?> selected <?php endif; ?>>
                                                    Kurtosis
                                                </option>
                                            </optgroup>

                                            <optgroup label="Correlation">
                                                <option value="r_square"
                                                    <?php if(old('report_category', $request->report_category) == 'r_square'): ?> selected <?php endif; ?>>
                                                    R Sqaure
                                                </option>
                                            </optgroup>

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
                                    <div class="form_group radio_btn">
                                        <label>
                                            <input type="radio" name="ranking" value="range"
                                                <?php echo e($selectedRanking === 'range' ? 'checked' : ''); ?>>
                                            Range
                                        </label>
                                        <label>
                                            <input type="radio" name="ranking" value="as_on"
                                                <?php echo e($selectedRanking === 'as_on' ? 'checked' : ''); ?>>
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
                                <div class="col-md-4 div_show" style="<?php echo e($isAsOnMode ? 'display:none;' : ''); ?>">
                                    <div class="form_group">
                                        <input type="date" class="form-control" placeholder="Start date" name="start_date"
                                            <?php echo e($isAsOnMode ? 'disabled' : ''); ?>

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
                                <div class="col-md-4 div_show" style="<?php echo e($isAsOnMode ? 'display:none;' : ''); ?>">
                                    <div class="form_group">
                                        <input type="date" class="form-control" placeholder="End date" name="end_date"
                                            <?php echo e($isAsOnMode ? 'disabled' : ''); ?>

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
                                <div class="col-md-4 div_hide" style="<?php echo e($isAsOnMode ? '' : 'display:none;'); ?>">
                                    <div class="form_group">
                                        <input type="date" name="as_on_date" class="form-control" placeholder="date"
                                            <?php echo e($isAsOnMode ? '' : 'disabled'); ?>

                                            value="<?php echo e(!empty($request->as_on_date) ? \Carbon\Carbon::parse($request->as_on_date)->format('Y-m-d') : ''); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4 div_hide" style="<?php echo e($isAsOnMode ? '' : 'display:none;'); ?>">
                                    <div class="form_group">
                                        <select name="as_on_time_frame" <?php echo e($isAsOnMode ? '' : 'disabled'); ?>>
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

                                <div class="col-md-12">
                                    <div class="bttn_grp">
                                        <button type="submit" id="submit_btn">Search</button>
                                        <!-- <button type="submit" name="submit" value="search_by_fund">show by fund</button> -->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php if(isset($request) && $request->Category != '' && $request->report_category != ''): ?>
                        <div class="tabsct">
                            

                            <div class="quartile_table"
                                <?php if(isset($quartile_set) && $quartile_set == 'quartile'): ?> style="display: block;" <?php else: ?> style="display: none;" <?php endif; ?>>
                                <div class="fund_section new_fund_section">
                                    <ul>
                                        <li>
                                            <p>start date :</p>
                                            <span><?php echo e(isset($start_date) ? date('d/m/Y', strtotime($start_date)) : ''); ?></span>
                                        </li>
                                        <li>
                                            <p>end date :</p>
                                            <span><?php echo e(isset($end_date) ? date('d/m/Y', strtotime($end_date)) : ''); ?></span>
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

                                        <?php if(!empty($as_on_time_frame_data)): ?>
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

                                        <?php if(isset($request) && $request->Category == 'by_fund'): ?>
                                            <li class="fund-name-item">
                                                <p>fund name :</p>
                                                <span><?php echo e(isset($fund_names) ? $fund_names : ''); ?></span>
                                            </li>
                                        <?php endif; ?>

                                    </ul>
                                </div>

                                <div class="graph_table">
                                    <div class="share_pdf">

                                        <div class="sharethis-inline-share-buttons"></div>
                                        <a href="javascript:void(0)" id="exportPDFquartile" class="pdf"><img
                                                src="<?php echo e(asset('themes/frontend/assets/infosolz/images/pdf.png')); ?>"></a>

                                    </div>

                                    <table
                                        class="table <?php echo e(isset($quartile_set) && $quartile_set === 'quartile' ? 'datatable' : ''); ?>"
                                        id="pdfData-quartile">
                                        <thead>
                                            <tr>
                                                <th class="text_left">fund name</th>
                                                <th class="text_center">ratio</th>
                                                <th class="text_center">Quartile</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(isset($quartile_set) && $quartile_set === 'quartile'): ?>
                                                <?php if(isset($quartile_decile_result['fund_absolute_return']) && isset($quartile_decile_result['quartile'])): ?>
                                                    <?php
                                                        $ratio_array = ['beta', 'volatility', 'tracking_error'];
                                                        if (
                                                            isset($report_category) &&
                                                            isset($quartile_decile_result['fund_absolute_return'])
                                                        ) {
                                                            if (in_array($report_category, $ratio_array)) {
                                                                asort($quartile_decile_result['fund_absolute_return']);

                                                                asort($quartile_decile_result['quartile']);
                                                            } else {
                                                                arsort($quartile_decile_result['fund_absolute_return']);

                                                                arsort($quartile_decile_result['quartile']);
                                                            }
                                                        }
                                                    ?>
                                                    <?php $__currentLoopData = $quartile_decile_result['fund_absolute_return']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fundId => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td class="text_left">
                                                                <?php echo e(getNameTable('fund_master', 'fund_name', 'fund_id', $fundId)); ?>

                                                            </td>
                                                            <td class="text_right"><?php echo e(printValue($value)); ?></td>
                                                            <td class="text_right">
                                                                <?php echo e(intval($quartile_decile_result['quartile'][$fundId]) > 0 && is_numeric($value) ? printRank($quartile_decile_result['quartile'][$fundId]) : printRank('N/A')); ?>

                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="3">No records found</td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="3">No information available for this search</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                            
                            <div class="decile_table"
                                <?php if(isset($quartile_set) && $quartile_set == 'decile'): ?> style="display: block;" <?php else: ?> style="display: none;" <?php endif; ?>>
                                <div class="fund_section new_fund_section">
                                    <ul>
                                        <li>
                                            <p>start date :</p>
                                            <span><?php echo e(isset($start_date) ? date('d/m/Y', strtotime($start_date)) : ''); ?></span>
                                        </li>
                                        <li>
                                            <p>end date :</p>
                                            <span><?php echo e(isset($end_date) ? date('d/m/Y', strtotime($end_date)) : ''); ?></span>
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


                                        <?php if(!empty($as_on_time_frame_data)): ?>
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

                                        <?php if(isset($request) && $request->Category == 'by_fund'): ?>
                                            <li class="fund-name-item">
                                                <p>fund name :</p>
                                                <span><?php echo e(isset($fund_names) ? $fund_names : ''); ?></span>
                                            </li>
                                        <?php endif; ?>

                                    </ul>
                                </div>

                                <div class="graph_table">
                                    <div class="share_pdf">

                                        <div class="sharethis-inline-share-buttons"></div>
                                        <a href="javascript:void(0)" id="exportPDFdecile" class="pdf"><img
                                                src="<?php echo e(asset('themes/frontend/assets/infosolz/images/pdf.png')); ?>"></a>

                                    </div>
                                    <table
                                        class="table <?php echo e(isset($quartile_set) && $quartile_set === 'decile' ? 'datatable' : ''); ?>"
                                        id="pdfData-decile">
                                        <thead>
                                            <tr>
                                                <th class="text_left">fund name</th>
                                                <th class="text_center">ratio</th>
                                                <th class="text_center">Decile</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(isset($request->quartile_set) && $request->quartile_set === 'decile'): ?>
                                                <?php if(isset($quartile_decile_result['fund_absolute_return']) && isset($quartile_decile_result['decile'])): ?>
                                                    <?php
                                                        $ratio_array = ['beta', 'volatility', 'tracking_error'];
                                                        if (
                                                            isset($request->report_category) &&
                                                            isset($quartile_decile_result['fund_absolute_return'])
                                                        ) {
                                                            if (in_array($request->report_category, $ratio_array)) {
                                                                asort($quartile_decile_result['fund_absolute_return']);

                                                                asort($quartile_decile_result['decile']);
                                                            } else {
                                                                arsort($quartile_decile_result['fund_absolute_return']);

                                                                arsort($quartile_decile_result['decile']);
                                                            }
                                                        }
                                                    ?>
                                                    <?php $__currentLoopData = $quartile_decile_result['fund_absolute_return']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fundId => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td class="text_left">
                                                                <?php echo e(getNameTable('fund_master', 'fund_name', 'fund_id', $fundId)); ?>

                                                            </td>
                                                            <td class="text_right"><?php echo e(printValue($value)); ?></td>
                                                            <td class="text_right">
                                                                <?php echo e(intval($quartile_decile_result['decile'][$fundId]) > 0 && is_numeric($value) ? printRank($quartile_decile_result['decile'][$fundId]) : printRank('N/A')); ?>

                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="3">No records found</td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="3">No information available for this search</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    <?php else: ?>
                        <?php echo printNoData(); ?>

                    <?php endif; ?>


                </div>
                <?php if(isset($quartile_decile_result['fund_absolute_return'])): ?>
                    <div class="disclaimer">
                        <p><strong>Note : </strong>For the calculations, the first working day is considered in case of
                            Starting and Ending day.</p>
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
    /*function get_fund_types(thiss) {
        // alert(thiss);
        if (thiss === 'by_fund') {
            $('#type_Category').removeAttr('checked', 'checked');
            $('#fund_Category').attr('checked', 'checked');
        } else if (thiss === 'by_category') {
            $('#type_Category').attr('checked', 'checked');
            $('#fund_Category').removeAttr('checked', 'checked');
        }
    }

    function max_min_fund(element) {

        var value = element.getAttribute('data-value');
        // console.log(value);

        $('#quartile_set').val(value);

        // $('#fund_msgg').html('');

        var quartile_set = $('#quartile_set').val();
        var thiss = $('#fund_Category').val();
        var count = $('#allocation_select_fund').select2('data').length;

        console.log('quartile_set:', quartile_set);
        console.log('Category:', thiss);
        console.log('count:', count);

        if (thiss == 'by_fund') {

            if (quartile_set == 'quartile') {

                $('#fund_msgg').html('<p>Funds selection limit minimum 4 and maximum 20 for <b>Quartile</b></p>');

                if (count >= 4 && count <= 20) {
                    $('#submit_btn').prop('disabled', false);
                } else {

                    $('#submit_btn').prop('disabled', true);
                }
            } else if (quartile_set == 'decile') {

                $('#fund_msgg').html('<p>Funds selection limit minimum 10 and maximum 20 for <b>Decile</b></p>');
                console.log(count);
                if (count >= 10 && count <= 20) {

                    $('#submit_btn').prop('disabled', false);
                } else {

                    $('#submit_btn').prop('disabled', true);
                }
            }
        } else {
            $('#submit_btn').prop('disabled', false);
        }


    }

    window.onload = function() {

        // alert('onload');

        var get_quartile = $('#quartile_set').val();

        var thiss = $('#fund_Category').val();


        $('#submit_btn').prop('disabled', false);

        console.log('q--' + get_quartile);

        if (get_quartile == 'quartile') {
            var element = document.getElementById('quartile_tab');

            $('#quartile_tab').attr('class', 'active');
            $('#decile_tab').removeAttr('class', 'active');


        } else if (get_quartile == 'decile') {
            var element = document.getElementById('decile_tab');


            $('#quartile_tab').removeAttr('class', 'active');
            $('#decile_tab').attr('class', 'active');

        } else {
            var element = document.getElementById('quartile_tab');
        }

        max_min_fund(element);

        // $('#quartile_set').value(element);
    }

    function set_fund_select_val() {

        var quartile_set = $('#quartile_set').val();
        var thiss = $('#fund_Category').val();
        var count = $('#allocation_select_fund').select2('data').length;

        console.log('quartile_set:', quartile_set);
        console.log('Category:', thiss);
        console.log('count:', count);

        if (thiss == 'by_fund') {
            if (quartile_set == 'quartile') {
                if (count >= 4 && count <= 20) {
                    // console.log('enable');
                    $('#submit_btn').prop('disabled', false);
                } else {
                    // console.log('disabled');
                    // alert('Funds selection limit minimum 4 and maximum 20');
                    $('#fund_msgg').html('<p>Funds selection limit minimum 4 and maximum 20 for <b>Quartile</b></p>');
                    $('#submit_btn').prop('disabled', true);
                }
            } else if (quartile_set == 'decile') {
                if (count >= 10 && count <= 20) {
                    $('#submit_btn').prop('disabled', false);
                } else {
                    // alert('Funds selection limit minimum 10 and maximum 20');
                    $('#fund_msgg').html('<p>Funds selection limit minimum 10 and maximum 20 for <b>Decile</b></p>');

                    $('#submit_btn').prop('disabled', true);
                }
            }
        } else {
            $('#submit_btn').prop('disabled', false);
        }
    }*/

    function currentQuartileMode() {
        return $('#quartile_set').val() || 'quartile';
    }

    function selectedFundCount() {
        return ($('#select_fund_multiple').val() || []).length;
    }

    function toggleRankingFields() {
        var ranking = $('input[name="ranking"]:checked').val() || 'range';
        var isAsOn = ranking === 'as_on';

        $('.div_show').toggle(!isAsOn);
        $('.div_hide').toggle(isAsOn);

        $('input[name="start_date"], input[name="end_date"]').prop('disabled', isAsOn);
        $('input[name="as_on_date"], select[name="as_on_time_frame"]').prop('disabled', !isAsOn);
    }

    function toggleCategoryFields() {
        var category = $('input[name="Category"]:checked').val() || 'by_category';
        var isByFund = category === 'by_fund';

        $('.div_show_1').toggle(!isByFund);
        $('.div_hide_1').toggle(isByFund);

        $('select[name="fund_type_id"]').prop('disabled', isByFund);
        $('select[name="fund_id[]"]').prop('disabled', !isByFund);
    }

    function updateQuartileSelectionState() {
        var category = $('input[name="Category"]:checked').val() || 'by_category';
        var mode = currentQuartileMode();
        var count = selectedFundCount();
        var min = mode === 'decile' ? 10 : 4;

        $('#select_fund_multiple').attr('data-min', min);

        if (mode === 'quartile') {
            $('.quartile_table').show();
            $('.decile_table').hide();
        } else {
            $('.quartile_table').hide();
            $('.decile_table').show();
        }

        if (category !== 'by_fund') {
            $('#fund_msgg').html('');
            $('#submit_btn').prop('disabled', false);
            return;
        }

        if (count >= min && count <= 20) {
            $('#fund_msgg').html('');
            $('#submit_btn').prop('disabled', false);
            return;
        }

        $('#fund_msgg').html('<p>Selection limit minimum ' + min + ' and maximum 20 for <b>' + (mode === 'decile' ? 'Decile' : 'Quartile') + '</b></p>');
        $('#submit_btn').prop('disabled', true);
    }

    function max_min_fund(element) {
        var value = element.getAttribute('data-value');

        $('#quartile_set').val(value);
        $('#quartile_tab').toggleClass('active', value === 'quartile');
        $('#decile_tab').toggleClass('active', value === 'decile');

        updateQuartileSelectionState();
    }

    function get_fund_types_js(thiss) {
        toggleCategoryFields();
        updateQuartileSelectionState();
    }

    document.addEventListener('DOMContentLoaded', function() {
        toggleRankingFields();
        toggleCategoryFields();
        updateQuartileSelectionState();

        $('input[name="ranking"]').on('change', toggleRankingFields);
        $('input[name="Category"]').on('change', function() {
            get_fund_types_js(this.value);
        });
        $('#select_fund_multiple').on('change', updateQuartileSelectionState);

        var exportButton = document.getElementById('exportPDFquartile');

        if (!exportButton) {
            return;
        }

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

                doc.setFontSize(16);
                doc.setTextColor(45, 135, 23);
                doc.text('Quartile', pageWidth / 2, 35, {
                    align: 'center'
                });

                doc.setFontSize(12);
                doc.setTextColor(0, 0, 0);

                // Date and ratio details
                var startDate =
                    "<?php echo e(isset($start_date) ? date('d/m/Y', strtotime($start_date)) : '00/00/0000'); ?>";
                var endDate =
                    "<?php echo e(isset($end_date) ? date('d/m/Y', strtotime($end_date)) : '00/00/0000'); ?>";
                var ratio =
                    <?php if(isset($request->report_category)): ?>
                        <?php switch($request->report_category):
                            case ('returns'): ?>
                            'Returns/CAGR'
                            <?php break; ?>

                            <?php case ('jensens_alpha'): ?>
                            'Jensen’s alpha'
                            <?php break; ?>

                            <?php case ('sharpe'): ?>
                            'Sharpe'
                            <?php break; ?>

                            <?php case ('treynor'): ?>
                            'Treynor'
                            <?php break; ?>

                            <?php case ('information_ratio'): ?>
                            'Information Ratio'
                            <?php break; ?>

                            <?php case ('one_month_rolling_return'): ?>
                            '1 month Rolling Return'
                            <?php break; ?>

                            <?php case ('beta'): ?>
                            'Beta'
                            <?php break; ?>

                            <?php case ('volatility'): ?>
                            'Volatility'
                            <?php break; ?>

                            <?php case ('tracking_error'): ?>
                            'Tracking Error'
                            <?php break; ?>

                            <?php case ('skewness'): ?>
                            'Skewness'
                            <?php break; ?>

                            <?php case ('kurtosis'): ?>
                            'Kurtosis'
                            <?php break; ?>

                            <?php case ('r_square'): ?>
                            'R Square'
                            <?php break; ?>
                        <?php endswitch; ?>
                    <?php endif; ?> ;

                var duration =
                    <?php if(isset($as_on_time_frame_data)): ?>
                        <?php switch($request->as_on_time_frame):
                            case ('1_month'): ?>
                            '1 Month'
                            <?php break; ?>

                            <?php case ('3_months'): ?>
                            '3 Months'
                            <?php break; ?>

                            <?php case ('6_months'): ?>
                            '6 Months'
                            <?php break; ?>

                            <?php case ('1_year'): ?>
                            '1 Year'
                            <?php break; ?>

                            <?php case ('2_year'): ?>
                            '2 Years'
                            <?php break; ?>

                            <?php case ('3_years'): ?>
                            '3 Years'
                            <?php break; ?>

                            <?php case ('5_years'): ?>
                            '5 Years'
                            <?php break; ?>

                            <?php default: ?>
                            null
                        <?php endswitch; ?>
                    <?php else: ?>
                        null
                    <?php endif; ?> ;

                var fundClassification =
                    "<?php echo e(isset($request) && $request->Category == 'by_category' && isset($fund_type_name) ? $fund_type_name : ''); ?>";

                var startX = 15;
                var lineHeight = 10;
                var tableStartY = 70;

                doc.text(`Start date: ${startDate}`, startX, tableStartY - 20);
                doc.text(`End date: ${endDate}`, startX + 100, tableStartY - 20);

                doc.text(`By Ratio: ${ratio}`, startX, tableStartY - 10);
                if (duration !== null) {
                    doc.text(`Duration: ${duration}`, startX + 100, tableStartY - 10);
                }

                if ("<?php echo e($request->Category); ?>" == 'by_category') {
                    doc.text(`Fund Classification: ${fundClassification}`, startX, tableStartY);
                }


                // Prepare the table data
                var tableData = [];
                var tableRows = document.querySelectorAll("#pdfData-quartile tbody tr");
                tableRows.forEach(function(row) {
                    var rowData = [];
                    row.querySelectorAll('td').forEach(function(cell) {
                        rowData.push(cell.innerText);
                    });
                    tableData.push(rowData);
                });

                // Add table to PDF
                doc.autoTable({
                    head: [
                        ['Fund Name', 'Ratio', 'Quartile']
                    ],
                    body: tableData,
                    startX: startX,
                    startY: tableStartY + 10,
                    headStyles: {
                        fillColor: [45, 135, 23]
                    },
                });

                var currentDate = new Date();
                var fileName = 'Quartile-' + currentDate.toISOString().split('T')[0] + '.pdf';
                doc.save(fileName);


            };
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        var exportButton = document.getElementById('exportPDFdecile'); // Updated button ID

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

                doc.setFontSize(16);
                doc.setTextColor(45, 135, 23);
                doc.text('Decile', pageWidth / 2, 35, {
                    align: 'center'
                }); // Updated text to Decile

                doc.setFontSize(12);
                doc.setTextColor(0, 0, 0);

                // Date and ratio details
                var startDate =
                    "<?php echo e(isset($start_date) ? date('d/m/Y', strtotime($start_date)) : '00/00/0000'); ?>";
                var endDate =
                    "<?php echo e(isset($end_date) ? date('d/m/Y', strtotime($end_date)) : '00/00/0000'); ?>";
                var ratio =
                    <?php if(isset($request->report_category)): ?>
                        <?php switch($request->report_category):
                            case ('returns'): ?>
                            'Returns/CAGR'
                            <?php break; ?>

                            <?php case ('jensens_alpha'): ?>
                            'Jensen’s alpha'
                            <?php break; ?>

                            <?php case ('sharpe'): ?>
                            'Sharpe'
                            <?php break; ?>

                            <?php case ('treynor'): ?>
                            'Treynor'
                            <?php break; ?>

                            <?php case ('information_ratio'): ?>
                            'Information Ratio'
                            <?php break; ?>

                            <?php case ('one_month_rolling_return'): ?>
                            '1 month Rolling Return'
                            <?php break; ?>

                            <?php case ('beta'): ?>
                            'Beta'
                            <?php break; ?>

                            <?php case ('volatility'): ?>
                            'Volatility'
                            <?php break; ?>

                            <?php case ('tracking_error'): ?>
                            'Tracking Error'
                            <?php break; ?>

                            <?php case ('skewness'): ?>
                            'Skewness'
                            <?php break; ?>

                            <?php case ('kurtosis'): ?>
                            'Kurtosis'
                            <?php break; ?>

                            <?php case ('r_square'): ?>
                            'R Square'
                            <?php break; ?>
                        <?php endswitch; ?>
                    <?php endif; ?> ;

                var duration =
                    <?php if(isset($as_on_time_frame_data)): ?>
                        <?php switch($request->as_on_time_frame):
                            case ('1_month'): ?>
                            '1 Month'
                            <?php break; ?>

                            <?php case ('3_months'): ?>
                            '3 Months'
                            <?php break; ?>

                            <?php case ('6_months'): ?>
                            '6 Months'
                            <?php break; ?>

                            <?php case ('1_year'): ?>
                            '1 Year'
                            <?php break; ?>

                            <?php case ('2_year'): ?>
                            '2 Years'
                            <?php break; ?>

                            <?php case ('3_years'): ?>
                            '3 Years'
                            <?php break; ?>

                            <?php case ('5_years'): ?>
                            '5 Years'
                            <?php break; ?>

                            <?php default: ?>
                            null
                        <?php endswitch; ?>
                    <?php else: ?>
                        null
                    <?php endif; ?> ;

                var fundClassification =
                    "<?php echo e(isset($request) && $request->Category == 'by_category' && isset($fund_type_name) ? $fund_type_name : ''); ?>";

                var startX = 15;
                var lineHeight = 10;
                var tableStartY = 70;

                doc.text(`Start date: ${startDate}`, startX, tableStartY - 20);
                doc.text(`End date: ${endDate}`, startX + 100, tableStartY - 20);

                doc.text(`By Ratio: ${ratio}`, startX, tableStartY - 10);
                if (duration !== null) {
                    doc.text(`Duration: ${duration}`, startX + 100, tableStartY - 10);
                }

                if ("<?php echo e($request->Category); ?>" == 'by_category') {
                    doc.text(`Fund Classification: ${fundClassification}`, startX, tableStartY);
                }

                // Prepare the table data
                var tableData = [];
                var tableRows = document.querySelectorAll("#pdfData-decile tbody tr");
                tableRows.forEach(function(row) {
                    var rowData = [];
                    row.querySelectorAll('td').forEach(function(cell) {
                        rowData.push(cell.innerText);
                    });
                    tableData.push(rowData);
                });

                // Add table to PDF
                doc.autoTable({
                    head: [
                        ['Fund Name', 'Ratio', 'Decile']
                    ], // Updated table header
                    body: tableData,
                    startX: startX,
                    startY: tableStartY + 10,
                    headStyles: {
                        fillColor: [45, 135, 23]
                    },
                });

                var currentDate = new Date();
                var fileName = 'Decile-' + currentDate.toISOString().split('T')[0] +
                    '.pdf'; // Updated file name
                doc.save(fileName);

            };
        });
    });
</script>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/ratio-reports/quartile_decile.blade.php ENDPATH**/ ?>