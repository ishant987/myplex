<?php $__env->startSection('content'); ?>
    <?php
        $history = session()->has('history') ? session('history') : [];
        $disable = count($history) > 0 ? true : false;
        // echo '<pre>';
        // print_r($history);
        // exit();
        if (isset($fund_absolute_return) && count($fund_absolute_return) > 0) {
            // dd($fund_absolute_return);
            $ratio_array = ['beta', 'volatility', 'tracking_error'];
            if (isset($report_category) && in_array($report_category, $ratio_array)) {
                $fund_absolute_return = custom_sort($fund_absolute_return);
                // asort($fund_absolute_return);
            } else {
                $fund_absolute_return = custom_sort($fund_absolute_return, 'dsc');
                // arsort($fund_absolute_return);
            }

            if (isset($records) && $records > 0) {
                $fund_absolute_return = array_slice($fund_absolute_return, 0, $records, true);
            }
        }
        // dd($fund_absolute_return);
    ?>

    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                        <li>filters</li>
                    </ul>
                </div>

                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                    <div class="perform_head">
                        <h2>filters</h2>
                    </div>
                    <div class="light_green_bg">
                        <form class="mb-4" action="">
                            <input type="hidden" name="disable" value="<?php echo e($disable); ?>">
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form_group radio_btn">
                                            <label>
                                                <input type="radio" name="ranking" value="range"
                                                    <?php echo e($disable ? 'disabled' : ''); ?> checked>
                                                Range
                                            </label>
                                            <label>
                                                <input type="radio" name="ranking" value="as_on"
                                                    <?php echo e($disable ? 'disabled' : ''); ?>>
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
                                            <input type="text" class=<?php echo e($disable ? '' : 'datepicker'); ?>

                                                placeholder="Start date" name="start_date"
                                                value="<?php echo e(old('start_date', $start_date ?? '')); ?>" readonly>
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
                                            <input type="text" class=<?php echo e($disable ? '' : 'datepicker'); ?>

                                                placeholder="End date" name="end_date"
                                                value="<?php echo e(old('end_date', $end_date ?? '')); ?>" readonly>
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
                                            <input type="text" name="as_on_date"
                                                class=<?php echo e($disable ? '' : 'datepicker'); ?> placeholder="date"
                                                value="<?php echo e(old('as_on_date', $as_on_date ?? '')); ?>" readonly>
                                        </div>
                                    </div>

                                    <input type="hidden" id="checkedFundIds" value=""
                                        name="checkedFundIds">

                                    <input type="hidden" id="fundIds" value="<?php echo e($checkedFundIds ?? ''); ?>"
                                        name="allfundIds">

                                    <div class="col-md-4 div_hide">
                                        <div class="form_group">
                                            <select name="as_on_time_frame" <?php echo e($disable ? 'disabled' : ''); ?>>
                                                <option value="1_month" <?php if(old('as_on_time_frame', $as_on_time_frame ?? '') == '1_month'): ?> selected <?php endif; ?>>1
                                                    Month</option>
                                                <option value="3_months" <?php if(old('as_on_time_frame', $as_on_time_frame ?? '') == '3_months'): ?> selected <?php endif; ?>>3
                                                    Months</option>
                                                <option value="6_months" <?php if(old('as_on_time_frame', $as_on_time_frame ?? '') == '6_months'): ?> selected <?php endif; ?>>6
                                                    Months</option>
                                                <option value="1_year" <?php if(old('as_on_time_frame', $as_on_time_frame ?? '') == '1_year'): ?> selected <?php endif; ?>>1
                                                    Year</option>
                                                <option value="2_years" <?php if(old('as_on_time_frame', $as_on_time_frame ?? '') == '2_years'): ?> selected <?php endif; ?>>2
                                                    Years</option>
                                                <option value="3_years" <?php if(old('as_on_time_frame', $as_on_time_frame ?? '') == '3_years'): ?> selected <?php endif; ?>>3
                                                    Years</option>
                                                <option value="5_years" <?php if(old('as_on_time_frame', $as_on_time_frame ?? '') == '5_years'): ?> selected <?php endif; ?>>5
                                                    Years</option>
                                            </select>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-4">
                                        <div class="form_group radio_btn">
                                            <label>
                                                <input type="radio" name="Category" value="by_category"
                                                    onclick='get_fund_types_js(this.value)'
                                                    <?php if(!isset($Category) || (isset($Category) && $Category == 'by_category')): ?> <?php echo e('Checked'); ?> <?php endif; ?>
                                                    <?php echo e($disable ? 'disabled' : ''); ?>>
                                                By Category
                                            </label>
                                            <label>
                                                <input type="radio" name="Category" value="by_fund"
                                                    onclick='get_fund_types_js(this.value)'
                                                    <?php if(isset($Category) && $Category == 'by_fund'): ?> <?php echo e('Checked'); ?> <?php endif; ?>
                                                    <?php echo e($disable ? 'disabled' : ''); ?>>
                                                By Fund
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 div_show_1">
                                        <div class="form_group">
                                            <select name="fund_type" id="fund_type" class="select2"
                                                data-placeholder="Select Fund Classification"
                                                onchange="fund_type_change(this)" <?php echo e($disable ? 'disabled' : ''); ?>>
                                                <option value="">Select Fund Classification</option>
                                                <?php if(isset($all_fund_types)): ?>
                                                    <?php $__currentLoopData = $all_fund_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($val->ft_id); ?>"
                                                            <?php echo e(isset($fund_type) && $fund_type == $val->ft_id ? 'selected' : ''); ?>>
                                                            <?php echo e($val->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </select>
                                            <?php $__errorArgs = ['fund_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="alert alert-danger"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            <span class="" id="fund_type_msgg" style="color:#379962;"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-4 div_hide_1">
                                        <div class="form_group multiple_select">
                                            <select name="fund_id[]" class="select2 multiple" multiple
                                                id="select_fund_multiple" data-max="20" data-min="4"
                                                onchange='fund_multiple(this)' data-placeholder="Select Fund"
                                                <?php echo e($disable ? 'disabled' : ''); ?>>
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
                                        </div>
                                        <span class="text-danger" id="fund_msgg"></span>
                                    </div>

                                    <div class="col-md-4"
                                        style="<?php echo e(isset($records) || old('records') ? '' : 'display: none;'); ?>"
                                        id="record">
                                        <div class="form_group">
                                            <input type="number" placeholder="Records" name="records" id="record_val"
                                                value="<?php echo e(old('records', $records ?? '')); ?>"
                                                <?php echo e($disable ? 'disabled' : ''); ?>>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="col-md-4">
                                        <div class="form_group radio_btn">
                                            <label>
                                                <input type="radio" name="filter" value="by_ratio"
                                                    <?php echo e(!isset($filter) || (isset($filter) && $filter == 'by_ratio') ? 'checked' : ''); ?>>
                                                By Ratio
                                            </label>
                                            <label>
                                                <input type="radio" name="filter" value="by_composition"
                                                    <?php if(isset($filter) && $filter == 'by_composition'): ?> <?php echo e('checked'); ?> <?php endif; ?>>
                                                By Composition
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 div_show_2" id="ratio">
                                        <div class="form_group">
                                            <select name="report_category">
                                                <option value="">Ratio</option>
                                                <optgroup label="Return Ratio">
                                                    <option value="returns"
                                                        <?php echo e(old('report_category', request('report_category')) == 'returns' ? 'selected' : ''); ?>>
                                                        Returns/CAGR
                                                    </option>
                                                    <option value="jensens_alpha"
                                                        <?php echo e(old('report_category', request('report_category')) == 'jensens_alpha' ? 'selected' : ''); ?>>
                                                        Jensen’s alpha
                                                    </option>
                                                    <option value="sharpe"
                                                        <?php echo e(old('report_category', request('report_category')) == 'sharpe' ? 'selected' : ''); ?>>
                                                        Sharpe
                                                    </option>
                                                    <option value="treynor"
                                                        <?php echo e(old('report_category', request('report_category')) == 'treynor' ? 'selected' : ''); ?>>
                                                        Treynor
                                                    </option>
                                                    <option value="information_ratio"
                                                        <?php echo e(old('report_category', request('report_category')) == 'information_ratio' ? 'selected' : ''); ?>>
                                                        Information Ratio
                                                    </option>
                                                    <option value="one_month_rolling_return"
                                                        <?php echo e(old('report_category', request('report_category')) == 'one_month_rolling_return' ? 'selected' : ''); ?>>
                                                        1 month Rolling Return
                                                    </option>
                                                </optgroup>

                                                <optgroup label="Risk Ratio">
                                                    <option value="beta"
                                                        <?php echo e(old('report_category', request('report_category')) == 'beta' ? 'selected' : ''); ?>>
                                                        Beta
                                                    </option>
                                                    <option value="volatility"
                                                        <?php echo e(old('report_category', request('report_category')) == 'volatility' ? 'selected' : ''); ?>>
                                                        Volatility
                                                    </option>
                                                    <option value="tracking_error"
                                                        <?php echo e(old('report_category', request('report_category')) == 'tracking_error' ? 'selected' : ''); ?>>
                                                        Tracking Error
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

                                    <div class="col-md-4 div_hide_2" id="composition">
                                        <div class="form_group">
                                            <select name="composition" id="composition_value">
                                                <option value="">Select Composition</option>
                                                <option value="scrip"
                                                    <?php echo e(old('composition', request('composition')) == 'scrip' ? 'selected' : ''); ?>>
                                                    Scrip</option>
                                                <option value="industry"
                                                    <?php echo e(old('composition', request('composition')) == 'industry' ? 'selected' : ''); ?>>
                                                    Industry</option>
                                                <option value="aum"
                                                    <?php echo e(old('composition', request('composition')) == 'aum' ? 'selected' : ''); ?>>
                                                    AUM</option>
                                                <option value="fund_manager"
                                                    <?php echo e(old('composition', request('composition')) == 'fund_manager' ? 'selected' : ''); ?>>
                                                    Fund Manager</option>
                                            </select>
                                        </div>
                                        <?php $__errorArgs = ['composition'];
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

                                    <div class="col-md-4" id="scrip"
                                        style="display: <?php echo e($errors->has('fund_scrips') || old('fund_scrips') || request('fund_scrips') ? 'block' : 'none'); ?>">
                                        <div class="form_group">
                                            <select class="select2" name="fund_scrips" data-placeholder="select scrips">
                                                <option value="">select scrips</option>
                                                <?php $__currentLoopData = $mpx_fund_scrips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($scr->actual_scrip); ?>"
                                                        <?php echo e(old('fund_scrips', request('fund_scrips', isset($getData['fund_scrips']) ? $getData['fund_scrips'] : '')) == $scr->actual_scrip ? 'selected' : ''); ?>>
                                                        <?php echo e($scr->actual_scrip); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['fund_scrips'];
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

                                    <div class="col-md-4" id="industry"
                                        style="display: <?php echo e($errors->has('industry') || old('industry') || request('industry') ? 'block' : 'none'); ?>">
                                        <div class="form_group">
                                            <select class="select2" name="industry" data-placeholder="select industries">
                                                <option value="">select industries</option>
                                                <?php $__currentLoopData = $industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $industry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($industry->industry); ?>"
                                                        <?php echo e(old('industry', request('industry', isset($getData['industry']) ? $getData['industry'] : '')) == $industry->industry ? 'selected' : ''); ?>>
                                                        <?php echo e($industry->industry); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['industry'];
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
                                            <?php $__errorArgs = ['checkedFundIds'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="alert alert-danger"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            <button type="submit" name="search" id="submit_btn"
                                                value="search">Search</button>
                                            <a href="<?php echo e(route('user.filters')); ?>" id="fund_type_btn">Reset</a>
                                            
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                    <?php if(isset($fund_absolute_return)): ?>

                        

                        <?php if(isset($history)): ?>
                            <?php $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                <div class="fund_section new_fund_section">
                                    <ul>
                                        <?php if(isset($h['filter']) && $h['filter'] == 'by_composition'): ?>
                                            <li>
                                                <?php
                                                    $monthName = date('F', strtotime($h['last_date']));
                                                    $year = date('Y', strtotime($h['last_date']));
                                                ?>
                                                <p>Date : </p>
                                                <span>for the month of <?php echo e($monthName); ?>, <?php echo e($year); ?></span>
                                            </li>
                                        <?php elseif(isset($h['filter']) && $h['filter'] == 'by_ratio'): ?>
                                            <li>
                                                <p>Start Date : </p>
                                                <span><?php echo e(date('d-m-Y', strtotime($h['start_date']))); ?></span>
                                            </li>
                                            <li>
                                                <p>End Date : </p>
                                                <span><?php echo e(date('d-m-Y', strtotime($h['end_date']))); ?></span>
                                            </li>
                                        <?php endif; ?>
                                        <li>
                                            <?php if(isset($h['Category']) && $h['Category'] == 'by_fund'): ?>
                                                <p>Fund Names : </p>
                                                <span>
                                                    <?php $__currentLoopData = $h['fund_id']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php echo e(getNameTable('fund_master', 'fund_name', 'fund_id', $item)); ?>,
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </span>
                                            <?php elseif(isset($h['Category']) && $h['Category'] == 'by_category'): ?>
                                                <p>Fund Type : </p>
                                                <span><?php echo e(getNameTable('fund_type', 'name', 'ft_id', $h['fund_type'])); ?></span>
                                            <?php endif; ?>
                                        </li>
                                        <?php if(isset($h['filter'])): ?>
                                            <li>
                                                <p>Filtered : </p>
                                                <span><?php echo e(isset($h['filter']) ? str_replace('_', ' ', $h['filter']) : 'N/A'); ?></span>
                                            </li>
                                            <?php if($h['filter'] == 'by_ratio'): ?>
                                                <li>
                                                    <p>Return Ratio : </p>
                                                    <span><?php echo e(isset($h['report_category']) ? str_replace('_', ' ', $h['report_category']) : 'N/A'); ?></span>
                                                </li>
                                            <?php elseif($h['filter'] == 'by_composition'): ?>
                                                <li>
                                                    <p>Composition : </p>
                                                    <span><?php echo e(isset($h['composition']) ? str_replace('_', ' ', $h['composition']) : 'N/A'); ?></span>
                                                </li>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                        <div class="graph_table">
                            <table class="table filter_datatable">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="all_check" id="all_check" onclick="allcheck()">
                                        </th>
                                        <th>Fund name</th>
                                        <th class="text_center">Value</th>
                                        <?php if(!isset($composition) || (isset($composition) && $composition != 'fund_manager')): ?>
                                            <th class="text_center">Rank</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($fund_absolute_return) > 0): ?>
                                        <?php $i = 1 ?>
                                        <?php $__currentLoopData = $fund_absolute_return; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fund_id => $fund_return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><input type="checkbox" id="checkbox_<?php echo e($fund_id); ?>"
                                                        onclick='selectDynamicFund(<?php echo e($fund_id); ?>)' class="fundCheck"></td>
                                                

                                                <td><?php echo e(getNameTable('fund_master', 'fund_name', 'fund_id', $fund_id)); ?>

                                                </td>

                                                <td class="text_right">
                                                    <?php echo e(is_numeric($fund_return) ? printValue($fund_return) : 'N/A'); ?>

                                                </td>

                                                <?php if(!isset($composition) || (isset($composition) && $composition != 'fund_manager')): ?>
                                                    <td class="text_right">
                                                        
                                                        <?php echo e(is_numeric($fund_return) ? $i : 'N/A'); ?>


                                                    </td>
                                                <?php endif; ?>

                                            </tr>
                                            <?php $i++ ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td class="text_center" colspan="4">
                                                No data available in table
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <?php echo printNoData(); ?>

                    <?php endif; ?>
                </div>
                <?php if(isset($fund_absolute_return)): ?>
                <div class="disclaimer">
                    <p><strong>Disclaimer : </strong><?php echo e($disclaimer); ?></p>
                </div>
              <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function toggleFilterCategoryFields() {
            var selectedCategory = document.querySelector('input[name="Category"]:checked');
            var isByFund = selectedCategory && selectedCategory.value === 'by_fund';
            var recordValue = document.getElementById('record_val')?.value || '';
            var showRecordForCategory = !isByFund && recordValue !== '' && Number(recordValue) > 0;

            document.querySelectorAll('.div_show_1').forEach(function(element) {
                element.style.display = isByFund ? 'none' : 'block';
            });

            document.querySelectorAll('.div_hide_1').forEach(function(element) {
                element.style.display = isByFund ? 'block' : 'none';
            });

            var fundTypeSelect = document.getElementById('fund_type');
            var fundSelect = document.getElementById('select_fund_multiple');

            if (fundTypeSelect) {
                fundTypeSelect.disabled = isByFund;
            }

            if (fundSelect) {
                fundSelect.disabled = !isByFund;
            }

            var recordSection = document.getElementById('record');
            if (recordSection) {
                recordSection.style.display = showRecordForCategory ? 'block' : 'none';
            }
        }

        function get_fund_types_js() {
            toggleFilterCategoryFields();
        }

        function fund_multiple() {
            var selectedFunds = $('#select_fund_multiple').val() || [];
            $('#checkedFundIds').val(selectedFunds.join(','));
        }

        function fund_type_change(selectElement) {
            var selectedValue = selectElement.value;

            $.ajax({
                url: '/filters/fund_count',
                type: 'GET',
                data: {
                    fund_type_id: selectedValue,
                },
                success: function(response) {
                    $('#fund_type_msgg').html('There are ' + response +
                        ' funds in this fund type. Select How many records you want to show.');
                    $('#record_val').val(response);
                    toggleFilterCategoryFields();

                },
                error: function(xhr, status, error) {
                    console.error("AJAX request failed:", error);
                }
            });
        }

        function allcheck() {
            var isChecked = $('#all_check').prop('checked');
            var fundIds = $('#fundIds').val().split(',').filter(Boolean);

            fundIds.forEach(function(fundId) {
                $('#checkbox_' + fundId).prop('checked', isChecked);
            });

            $('#checkedFundIds').val(fundIds.join(','));
        }



        function selectDynamicFund(fundId) {
            var currentValues = $('#checkedFundIds').val().split(',').filter(Boolean);
            var isChecked = $('#checkbox_' + fundId).is(':checked');

            if (isChecked) {
                if (!currentValues.includes(fundId.toString())) {
                    currentValues.push(fundId);
                }
            } else {
                currentValues = currentValues.filter(function(id) {
                    return id !== fundId.toString();
                });
            }

            var isCheckedAll = $('#all_check').prop('checked');
            if (isCheckedAll) {
                $('#all_check').prop('checked', false);
            }

            console.log('currentValues===',currentValues);

            $('#checkedFundIds').val(currentValues.join(','));
        }
       

        document.querySelectorAll('input[name="Category"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                toggleFilterCategoryFields();
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            toggleFilterCategoryFields();
            fund_multiple();

            function updateDisplay() {
                var selectedValue = document.querySelector('input[name="filter"]:checked').value;
                var ratioElement = document.getElementById('ratio');
                var compositionElement = document.getElementById('composition');
                var scripElement = document.getElementById('scrip');
                var industryElement = document.getElementById('industry');

                if (ratioElement && compositionElement) {
                    if (selectedValue === 'by_ratio') {
                        document.getElementById('ratio').style.display = 'block';
                        document.getElementById('composition').style.display = 'none';

                        industryElement.style.display = 'none';
                        scripElement.style.display = 'none';

                    } else if (selectedValue === 'by_composition') {
                        document.getElementById('ratio').style.display = 'none';
                        document.getElementById('composition').style.display = 'block';
                    }
                }

                updateCompositionDisplay();
            }

            updateDisplay();

            document.querySelectorAll('input[name="filter"]').forEach(function(radio) {
                radio.addEventListener('change', updateDisplay);
            });

            function updateCompositionDisplay() {
                var selectedFilterValue = document.querySelector('input[name="filter"]:checked').value;
                var selectedValue = document.getElementById('composition_value').value;
                var scripElement = document.getElementById('scrip');
                var industryElement = document.getElementById('industry');

                if (selectedFilterValue === 'by_composition' && selectedValue === 'scrip') {
                    scripElement.style.display = 'block';
                    industryElement.style.display = 'none';
                } else if (selectedFilterValue === 'by_composition' && selectedValue === 'industry') {
                    scripElement.style.display = 'none';
                    industryElement.style.display = 'block';
                } else {
                    scripElement.style.display = 'none';
                    industryElement.style.display = 'none';
                }
            }

            updateCompositionDisplay();

            document.getElementById('composition_value').addEventListener('change', updateCompositionDisplay);
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/filters/index.blade.php ENDPATH**/ ?>