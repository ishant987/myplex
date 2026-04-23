<?php $__env->startSection('content'); ?>
    <?php
        $selectedRanking = old('ranking', $request->ranking ?? 'range');
        $selectedCompareType = old('compare_type', $request->compare_type ?? 'Scheme');
        $isAsOnMode = $selectedRanking === 'as_on';
    ?>
    <style>
        .r-square-toggle {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
        }

        .r-square-toggle p {
            margin: 0;
            font-weight: 600;
        }

        .r-square-toggle a {
            min-width: 112px;
            text-align: center;
        }

        .r-square-form .subs_in.bttn_grp {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
        }

        .r-square-form .subs_in.bttn_grp p {
            margin: 0;
        }
    </style>

    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                    <div class="head_brdcm">
                        <ul class="brdcmb">
                            <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                            <li><a href="<?php echo e(route('user.ratio_dashboard')); ?>">Ratio Reports</a></li>
                            <li>R-Square Ratios Reports</li>
                        </ul>
                    </div>
                 
                    <div class="light_green_bg r-square-form">
                        <form method="GET" action="">
                            <input type="hidden" name="quartile_set" id="quartile_set"
                                value="<?php echo e(isset($quartile_set) ? $quartile_set : 'quartile'); ?>">

                            <div class="row">
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

                                <div class="col-md-4 ">
                                    <div class="subs_in bttn_grp w-100 mb-3">
                                        <p>Select Primary </p>   
                                        <a href="javascript:void(0)">Scheme</a>         
                                    </div>
                                    <div class="form_group">
                                        <select name="scheme_id" class="select2 " id=""
                                            data-placeholder="Select Primary Scheme" >        
                                                <option value="">Select Primary Scheme</option>                                    
                                                <?php $__currentLoopData = $funds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($fund->fund_id); ?>"
                                                        <?php if($fund->fund_id == old('fund_id', $request->scheme_id)): ?> selected
                                                     <?php endif; ?>>
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
                                    <input type="hidden" name="Category" id="Category" value=by_fund>
                                    
                                </div>

                                <div class="col-md-8 ">
                                    
                                    <div class="subs_in bttn_grp w-100 mb-3 r-square-toggle" style="z-index:1;">
                                        <p>Compare With </p>
                                        <a href="javascript:void(0)" onclick="$('#compare_type').val('Scheme');selectCompareTypeList('Scheme');" class="<?php if($selectedCompareType == 'Scheme'): ?> bg-secondary <?php endif; ?>">Scheme</a>
                                        <a href="javascript:void(0)" onclick="$('#compare_type').val('Index');selectCompareTypeList('Index');" class="<?php if($selectedCompareType == 'Index'): ?> bg-secondary <?php endif; ?>">Index</a>
                                        <a href="javascript:void(0)" onclick="$('#compare_type').val('Currency');selectCompareTypeList('Currency');" class="<?php if($selectedCompareType == 'Currency'): ?> bg-secondary <?php endif; ?>">Currency</a>
                                        <a href="javascript:void(0)" onclick="$('#compare_type').val('Commodity');selectCompareTypeList('Commodity');" class="<?php if($selectedCompareType == 'Commodity'): ?> bg-secondary <?php endif; ?>">Commodity</a>                                    
                                    </div>
                                    <div class="form_group d-none">
                                        <select name="compare_type" id="compare_type" onchange=" selectCompareTypeList(this.value);">
                                            <option value="Scheme"  <?php if(old('compare_type', $request->compare_type) == 'Scheme'): ?> selected <?php endif; ?> > Scheme </option>
                                            <option value="Index"  <?php if(old('compare_type', $request->compare_type) == 'Index'): ?> selected <?php endif; ?> > Index </option>
                                            <option value="Currency"  <?php if(old('compare_type', $request->compare_type) == 'Currency'): ?> selected <?php endif; ?> > Currency </option>
                                            <option value="Commodity"  <?php if(old('compare_type', $request->compare_type) == 'Commodity'): ?> selected <?php endif; ?> > Commodity </option>
                                        </select>
                                        <?php $__errorArgs = ['compare_type'];
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
                                    <div class="form_group">
                                        
                                        <div id="fund_wrapper" class="<?php if($selectedCompareType != 'Scheme'): ?> d-none <?php endif; ?>">
                                            <select name="fund_id[]" class=" select2  multiple" multiple
                                                id="allocation_select_fund" onchange ='fund_multiple(this,"scheme")'
                                                data-placeholder="Select Schemes" data-min="1"  data-max="10" style="">
                                                    <?php $__currentLoopData = $funds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($fund->fund_id); ?>"
                                                            <?php if($fund->fund_id == old('fund_id', $request->fund_id)): ?> selected
                                                        <?php elseif(isset($fund_id) && in_array($fund->fund_id, $fund_id)): ?>
                                                        selected <?php endif; ?>>
                                                            <?php echo e($fund->fund_name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                
                                            </select>
                                        </div>
                                        <div id="index_wrapper" class="<?php if($selectedCompareType != 'Index'): ?> d-none <?php endif; ?>">
                                            <select name="index_id[]" class=" select2  multiple " multiple
                                                id="allocation_select_index" onchange ='fund_multiple(this,"index")'
                                                data-placeholder="Select Indexes" data-min="1"  data-max="10" style="">
                                                    <?php $__currentLoopData = $indices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($indice->idc_id); ?>"
                                                            <?php if($indice->idc_id == old('idc_id', $request->index_id)): ?> selected
                                                        <?php elseif(isset($index_id) && in_array($indice->idc_id, $index_id)): ?>
                                                        selected <?php endif; ?>>
                                                            <?php echo e($indice->name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                
                                            </select>
                                        </div>
                                        <div id="currency_wrapper" class="<?php if($selectedCompareType != 'Currency'): ?> d-none <?php endif; ?>">
                                            <select name="currency_id[]" class="  select2 multiple " multiple
                                                id="allocation_select_currency" onchange ='fund_multiple(this,"currency")'
                                                data-placeholder="Select Currencies" data-min="1"  data-max="10" style="">  
                                                    <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($currency->is_comodity=='0'): ?>
                                                        <option value="<?php echo e($currency->cm_id); ?>"
                                                            <?php if($currency->cm_id == old('cm_id', $request->currency_id)): ?> selected
                                                        <?php elseif(isset($currency_id) && in_array($currency->cm_id, $currency_id)): ?>
                                                        selected <?php endif; ?>>
                                                            <?php echo e($currency->name); ?>

                                                        </option>
                                                    <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>

                                        <div id="commodity_wrapper" class="<?php if($selectedCompareType != 'Commodity'): ?> d-none <?php endif; ?>">
                                            <select name="commodity_id[]" class=" select2  multiple" multiple
                                                id="allocation_select_commodity" onchange ='fund_multiple(this,"commodity")'
                                                data-placeholder="Select Commodities" data-min="1"  data-max="10" style="">  
                                                    <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commodity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($commodity->is_comodity=='1'): ?>
                                                        <option value="<?php echo e($commodity->cm_id); ?>"
                                                            <?php if($commodity->cm_id == old('cm_id', $request->commodity_id)): ?> selected
                                                        <?php elseif(isset($commodity_id) && in_array($commodity->cm_id, $commodity_id)): ?>
                                                        selected <?php endif; ?>>
                                                            <?php echo e($commodity->name); ?>

                                                        </option>
                                                    <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <span class="text-danger" id="fund_msgg"></span>
                                    </div>
                                </div>

                                <div class="col-md-4 ">
                                    
                                    
                                    
                                </div>

                                <input type="hidden" name="report_category" value="r_square">


                                



                                <div class="col-md-12">
                                    <div class="bttn_grp">
                                        <button type="submit" id="submit_btn">Search</button>
                                        <!-- <button type="submit" name="submit" value="search_by_fund">show by fund</button> -->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php if(isset($request) &&
                            isset($start_date) &&
                            isset($end_date) &&
                            $request->Category != '' &&
                            $request->report_category != ''): ?>


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
                                        <?php echo e('R Sqaure'); ?>

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

                                

                                
                                    <li>
                                        <p>primary Fund Name :</p>
                                        <span><?php echo e($schemeMaterData->fund_name ?? ''); ?></span>
                                    </li>
                                
                                <?php if(isset($request) && $request->Category == 'by_fund'): ?>
                                    <li>
                                        <p>Compare <?php echo e(strtolower($request->compare_type ?? 'scheme')); ?> names :</p>
                                        <span><?php echo e(isset($fund_names) ? $fund_names : ''); ?></span>
                                    </li>
                                <?php endif; ?>

                            </ul>
                        </div>

                        <div class="graph_table">
                            <div class="share_pdf">

                                <!-- <a href="javascript:void(0)" class="mb-3"><i class="fa-solid fa-share-nodes"></i></a> -->


                                <!-- ShareThis Inline Share Buttons (Hidden) -->
                                <!-- <div class="sharethis-inline-share-buttons" id="shareThisWidget" style="visibility: hidden; height: 0;"></div> -->
                                <div class="sharethis-inline-share-buttons"></div>
                                <a href="javascript:void(0)" id="exportPDF" class="pdf d-none"><img
                                        src="<?php echo e(asset('themes/frontend/assets/infosolz/images/pdf.png')); ?>"></a>

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

                                            // dd($request->report_category,$fundReturns);

                                            $ratio_array = ['beta', 'volatility', 'tracking_error'];

                                            if (isset($request->report_category) && isset($fundReturns)) {
                                                if (in_array($request->report_category, $ratio_array)) {
                                                    asort($fundReturns);
                                                } else {
                                                    arsort($fundReturns);
                                                }
                                            }

                                            // Convert the sorted array to a collection if needed
                                            $sortedFundReturns = collect($fundReturns)->toArray();
                                            //print_r($sortedFundReturns);

                                            $ranks = [];

                                            $rank = 1;
                                            foreach ($sortedFundReturns as $key => $value) {
                                                if ($value == 'N/A') {
                                                    $ranks[$key] = ' ';
                                                } else {
                                                    $ranks[$key] = $rank++;
                                                }
                                            }

                                        ?>
                                    <?php endif; ?>
                                    <?php
                                        //print_r($sortedFundReturns);
                                    ?>
                                    <?php if(isset($sortedFundReturns) && count($sortedFundReturns) > 0): ?>
                                        <?php $__currentLoopData = $sortedFundReturns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Id => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="text_left">
                                                    <?php if($request->compare_type=='Scheme'): ?>
                                                    <?php echo e(getNameTable('fund_master', 'fund_name', 'fund_id', $Id)); ?>

                                                    <?php elseif($request->compare_type=='Index'): ?>
                                                    <?php echo e(getNameTable('indices_master', 'name', 'idc_id', $Id)); ?>

                                                    <?php elseif($request->compare_type=='Currency'): ?>
                                                    <?php echo e(getNameTable('currency_master', 'name', 'cm_id', $Id)); ?>

                                                    <?php elseif($request->compare_type=='Commodity'): ?>
                                                    <?php echo e(getNameTable('currency_master', 'name', 'cm_id', $Id)); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td class="text_right">
                                                    <?php echo e(is_numeric(printValue($value)) ? printValue($value) : ' '); ?></td>
                                                <td class="text_right"><?php echo e(printRank($ranks[$Id])); ?></td>
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
                <?php if(isset($sortedFundReturns)): ?>
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
    function selectedCompareCount(type) {
        var map = {
            Scheme: '#allocation_select_fund',
            Index: '#allocation_select_index',
            Currency: '#allocation_select_currency',
            Commodity: '#allocation_select_commodity'
        };

        return ($(map[type]).val() || []).length;
    }

    function toggleRankingFields() {
        var ranking = $('input[name="ranking"]:checked').val() || 'range';
        var isAsOn = ranking === 'as_on';

        $('.div_show').toggle(!isAsOn);
        $('.div_hide').toggle(isAsOn);

        $('input[name="start_date"], input[name="end_date"]').prop('disabled', isAsOn);
        $('input[name="as_on_date"], select[name="as_on_time_frame"]').prop('disabled', !isAsOn);
    }

    function selectCompareTypeList(type) {
        $('#compare_type').val(type);
        $('#fund_wrapper, #index_wrapper, #currency_wrapper, #commodity_wrapper').addClass('d-none');

        if (type === 'Scheme') {
            $('#fund_wrapper').removeClass('d-none');
        } else if (type === 'Index') {
            $('#index_wrapper').removeClass('d-none');
        } else if (type === 'Currency') {
            $('#currency_wrapper').removeClass('d-none');
        } else if (type === 'Commodity') {
            $('#commodity_wrapper').removeClass('d-none');
        }

        $('.r-square-toggle a').removeClass('bg-secondary');
        $('.r-square-toggle a').filter(function() {
            return $(this).text().trim() === type;
        }).addClass('bg-secondary');

        updateCompareSelectionState();
    }

    function updateCompareSelectionState() {
        var type = $('#compare_type').val() || 'Scheme';
        var count = selectedCompareCount(type);

        if (count >= 1 && count <= 10) {
            $('#fund_msgg').html('');
            $('#submit_btn').prop('disabled', false);
            return;
        }

        $('#fund_msgg').html('<p>Selection limit minimum 1 and maximum 10 for <b>' + type + '</b></p>');
        $('#submit_btn').prop('disabled', true);
    }

    function fund_multiple() {
        updateCompareSelectionState();
    }


    document.addEventListener('DOMContentLoaded', function() {
        toggleRankingFields();
        selectCompareTypeList($('#compare_type').val() || 'Scheme');

        $('input[name="ranking"]').on('change', toggleRankingFields);
        $('#allocation_select_fund, #allocation_select_index, #allocation_select_currency, #allocation_select_commodity').on('change', function() {
            updateCompareSelectionState();
        });

        var exportButton = document.getElementById('exportPDF');

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
                doc.text('Performance Ratios', pageWidth / 2, 35, {
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
                            'R Sqaure'
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

                var fundClassification = "<?php echo e(isset($fund_type_name) ? $fund_type_name[0] : ''); ?>";

                var startX = 15;
                var lineHeight = 10;
                var tableStartY = 70;

                doc.text(`Start date: ${startDate}`, startX, tableStartY - 20);
                doc.text(`End date: ${endDate}`, startX + 100, tableStartY - 20);

                doc.text(`By Ratio: ${ratio}`, startX, tableStartY - 10);
                // doc.text(`Duration: ${duration}`, startX + 100, tableStartY - 10);
                if (duration !== null) {
                    doc.text(`Duration: ${duration}`, startX + 100, tableStartY - 10);
                }

                if ("<?php echo e($request->Category); ?>" == 'by_category') {
                    doc.text(`Fund Classification: ${fundClassification}`, startX, tableStartY);
                }

                var table = new DataTable('#pdfData');
                var tableData = [];
                table.rows({
                    search: 'applied'
                }).data().each(function(row) {
                    tableData.push(row);
                });

                doc.autoTable({
                    head: [
                        ['Fund Name', 'Ratio', 'Rank']
                    ],
                    body: tableData,
                    startX: startX,
                    startY: tableStartY + 10,
                    headStyles: {
                        fillColor: [45, 135, 23]
                    }
                });

                var currentDate = new Date();

                var fileName = 'Performance-Ratios-' + currentDate + '.pdf';

                doc.save(fileName);
            };
        });
    });
</script>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/ratio-reports/r_square_comparison.blade.php ENDPATH**/ ?>