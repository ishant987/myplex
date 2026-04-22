<?php $__env->startSection('content'); ?>
    <?php
        $history = session()->has('history') ? session('history') : [];
        $disable = count($history) > 0 ? true : false;
        $selectedRanking = old('ranking', request('ranking', 'range'));
        $selectedCategory = old('Category', request('Category', 'by_category'));
        $selectedComposition = old('composition', request('composition'));
        $isAsOnMode = $selectedRanking === 'as_on';
        $isByFundMode = $selectedCategory === 'by_fund';
        $hasSearchCriteria = filled($selectedComposition);

        if (isset($fund_absolute_return) && count($fund_absolute_return) > 0) {
            if ($selectedComposition === 'fund_manager') {
                asort($fund_absolute_return);
            } else {
                $fund_absolute_return = custom_sort($fund_absolute_return, 'dsc');
            }

            if (isset($records) && $records > 0) {
                $fund_absolute_return = array_slice($fund_absolute_return, 0, $records, true);
            }
        }
    ?>

    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                        <li>Filters</li>
                        <li>By Composition</li>
                    </ul>
                </div>

                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>

                    <div class="light_green_bg">
                        <form class="mb-4" action="">
                            <input type="hidden" name="disable" value="<?php echo e($disable); ?>">
                            <input type="hidden" name="filter" value="by_composition">

                            <div class="row">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form_group radio_btn">
                                            <label>
                                                <input type="radio" name="ranking" value="range"
                                                    onchange="toggleRankingFields()"
                                                    <?php echo e($selectedRanking === 'range' ? 'checked' : ''); ?>

                                                    <?php echo e($disable ? 'disabled' : ''); ?>>
                                                Range
                                            </label>
                                            <label>
                                                <input type="radio" name="ranking" value="as_on"
                                                    onchange="toggleRankingFields()"
                                                    <?php echo e($selectedRanking === 'as_on' ? 'checked' : ''); ?>

                                                    <?php echo e($disable ? 'disabled' : ''); ?>>
                                                As on
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 div_show" style="<?php echo e($isAsOnMode ? 'display:none;' : ''); ?>">
                                        <div class="form_group">
                                            <input type="date" class="form-control" name="start_date"
                                                <?php echo e($isAsOnMode ? 'disabled' : ''); ?>

                                                value="<?php echo e(request()->has('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('Y-m-d') : (old('start_date') ? \Carbon\Carbon::parse(old('start_date'))->format('Y-m-d') : '')); ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4 div_show" style="<?php echo e($isAsOnMode ? 'display:none;' : ''); ?>">
                                        <div class="form_group">
                                            <input type="date" class="form-control" name="end_date"
                                                <?php echo e($isAsOnMode ? 'disabled' : ''); ?>

                                                value="<?php echo e(request()->has('end_date') ? \Carbon\Carbon::parse(request('end_date'))->format('Y-m-d') : (old('end_date') ? \Carbon\Carbon::parse(old('end_date'))->format('Y-m-d') : '')); ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4 div_hide" style="<?php echo e($isAsOnMode ? '' : 'display:none;'); ?>">
                                        <div class="form_group">
                                            <input type="date" name="as_on_date" class="form-control"
                                                <?php echo e($isAsOnMode ? '' : 'disabled'); ?>

                                                value="<?php echo e(request()->has('as_on_date') ? \Carbon\Carbon::parse(request('as_on_date'))->format('Y-m-d') : (old('as_on_date') ? \Carbon\Carbon::parse(old('as_on_date'))->format('Y-m-d') : '')); ?>">
                                        </div>
                                    </div>

                                    <input type="hidden" id="checkedFundIds" value="" name="checkedFundIds">
                                    <input type="hidden" id="fundIds" value="<?php echo e($checkedFundIds ?? ''); ?>" name="allfundIds">

                                    <div class="col-md-4 div_hide" style="<?php echo e($isAsOnMode ? '' : 'display:none;'); ?>">
                                        <div class="form_group">
                                            <select name="as_on_time_frame" <?php echo e($disable || !$isAsOnMode ? 'disabled' : ''); ?>>
                                                <option value="1_month" <?php if(old('as_on_time_frame', $as_on_time_frame ?? '') == '1_month'): ?> selected <?php endif; ?>>1 Month</option>
                                                <option value="3_months" <?php if(old('as_on_time_frame', $as_on_time_frame ?? '') == '3_months'): ?> selected <?php endif; ?>>3 Months</option>
                                                <option value="6_months" <?php if(old('as_on_time_frame', $as_on_time_frame ?? '') == '6_months'): ?> selected <?php endif; ?>>6 Months</option>
                                                <option value="1_year" <?php if(old('as_on_time_frame', $as_on_time_frame ?? '') == '1_year'): ?> selected <?php endif; ?>>1 Year</option>
                                                <option value="2_years" <?php if(old('as_on_time_frame', $as_on_time_frame ?? '') == '2_years'): ?> selected <?php endif; ?>>2 Years</option>
                                                <option value="3_years" <?php if(old('as_on_time_frame', $as_on_time_frame ?? '') == '3_years'): ?> selected <?php endif; ?>>3 Years</option>
                                                <option value="5_years" <?php if(old('as_on_time_frame', $as_on_time_frame ?? '') == '5_years'): ?> selected <?php endif; ?>>5 Years</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form_group radio_btn">
                                            <label>
                                                <input type="radio" name="Category" value="by_category"
                                                    onclick='get_fund_types_js(this.value)'
                                                    <?php if($selectedCategory == 'by_category'): ?> checked <?php endif; ?>
                                                    <?php echo e($disable ? 'disabled' : ''); ?>>
                                                By Category
                                            </label>
                                            <label>
                                                <input type="radio" name="Category" value="by_fund"
                                                    onclick='get_fund_types_js(this.value)'
                                                    <?php if($selectedCategory == 'by_fund'): ?> checked <?php endif; ?>
                                                    <?php echo e($disable ? 'disabled' : ''); ?>>
                                                By Fund
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 div_show_1" style="<?php echo e($isByFundMode ? 'display:none;' : ''); ?>">
                                        <div class="form_group">
                                            <select name="fund_type" id="fund_type" class="select2"
                                                data-placeholder="Select Fund Classification"
                                                onchange="fund_type_change(this)" <?php echo e($disable ? 'disabled' : ''); ?>>
                                                <option value="">Select Fund Classification</option>
                                                <?php if(isset($all_fund_types)): ?>
                                                    <?php $__currentLoopData = $all_fund_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($val->ft_id); ?>"
                                                            <?php echo e(isset($fund_type) && $fund_type == $val->ft_id ? 'selected' : ''); ?>>
                                                            <?php echo e($val->name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </select>
                                            <span id="fund_type_msgg" style="color:#379962;"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-4 div_hide_1" style="<?php echo e($isByFundMode ? '' : 'display:none;'); ?>">
                                        <div class="form_group multiple_select">
                                            <select name="fund_id[]" class="select2 multiple" multiple
                                                id="select_fund_multiple" data-max="20" data-min="4"
                                                onchange='fund_multiple(this)' data-placeholder="Select Fund"
                                                <?php echo e($disable ? 'disabled' : ''); ?> <?php echo e($isByFundMode ? '' : 'disabled'); ?>>
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
                                        </div>
                                        <span class="text-danger" id="fund_msgg"></span>
                                    </div>

                                    <div class="col-md-4"
                                        style="<?php echo e(!$isByFundMode && (isset($records) || old('records')) ? '' : 'display:none;'); ?>"
                                        id="record">
                                        <div class="form_group">
                                            <input type="number" placeholder="Records" name="records" id="record_val"
                                                value="<?php echo e(old('records', $records ?? '')); ?>"
                                                <?php echo e($disable ? 'disabled' : ''); ?>>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="col-md-4">
                                        <div class="form_group">
                                            <select name="composition" id="composition_value">
                                                <option value="">Select Composition</option>
                                                <option value="scrip" <?php echo e($selectedComposition == 'scrip' ? 'selected' : ''); ?>>Scrip</option>
                                                <option value="industry" <?php echo e($selectedComposition == 'industry' ? 'selected' : ''); ?>>Industry</option>
                                                <option value="aum" <?php echo e($selectedComposition == 'aum' ? 'selected' : ''); ?>>AUM</option>
                                                <option value="fund_manager" <?php echo e($selectedComposition == 'fund_manager' ? 'selected' : ''); ?>>Fund Manager</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4" id="scrip"
                                        style="display: <?php echo e($selectedComposition === 'scrip' || $errors->has('fund_scrips') || old('fund_scrips') || request('fund_scrips') ? 'block' : 'none'); ?>">
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
                                        </div>
                                    </div>

                                    <div class="col-md-4" id="industry"
                                        style="display: <?php echo e($selectedComposition === 'industry' || $errors->has('industry') || old('industry') || request('industry') ? 'block' : 'none'); ?>">
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
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="bttn_grp">
                                            <button type="submit" name="search" id="submit_btn" value="search">Search</button>
                                            <a href="<?php echo e(route('user.filters.composition')); ?>" id="fund_type_btn">Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php if($hasSearchCriteria && isset($fund_absolute_return)): ?>
                        <div class="graph_table">
                            <table class="table filter_datatable">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="all_check" id="all_check" onclick="allcheck()"></th>
                                        <th>Fund name</th>
                                        <th class="text_center">Value</th>
                                        <?php if($selectedComposition !== 'fund_manager'): ?>
                                            <th class="text_center">Rank</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($fund_absolute_return) > 0): ?>
                                        <?php $i = 1; ?>
                                        <?php $__currentLoopData = $fund_absolute_return; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fund_id => $fund_return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><input type="checkbox" id="checkbox_<?php echo e($fund_id); ?>" onclick='selectDynamicFund(<?php echo e($fund_id); ?>)' class="fundCheck"></td>
                                                <td><?php echo e(getNameTable('fund_master', 'fund_name', 'fund_id', $fund_id)); ?></td>
                                                <td class="text_right"><?php echo e(is_numeric($fund_return) ? printValue($fund_return) : ($fund_return ?? 'N/A')); ?></td>
                                                <?php if($selectedComposition !== 'fund_manager'): ?>
                                                    <td class="text_right"><?php echo e(is_numeric($fund_return) ? $i : 'N/A'); ?></td>
                                                <?php endif; ?>
                                            </tr>
                                            <?php $i++; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td class="text_center" colspan="<?php echo e($selectedComposition !== 'fund_manager' ? 4 : 3); ?>">No data available in table</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php elseif($hasSearchCriteria): ?>
                        <?php echo printNoData(); ?>

                    <?php endif; ?>
                </div>

                <?php if($hasSearchCriteria && isset($fund_absolute_return)): ?>
                    <div class="disclaimer">
                        <p><strong>Disclaimer : </strong><?php echo e($disclaimer); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function toggleRankingFields() {
            var selectedRanking = document.querySelector('input[name="ranking"]:checked');
            var isAsOn = selectedRanking && selectedRanking.value === 'as_on';

            document.querySelectorAll('.div_show').forEach(function(element) {
                element.style.display = isAsOn ? 'none' : 'block';
            });

            document.querySelectorAll('.div_hide').forEach(function(element) {
                element.style.display = isAsOn ? 'block' : 'none';
            });

            document.querySelectorAll('input[name="start_date"], input[name="end_date"]').forEach(function(element) {
                element.disabled = isAsOn;
            });

            var asOnDate = document.querySelector('input[name="as_on_date"]');
            var asOnTimeFrame = document.querySelector('select[name="as_on_time_frame"]');

            if (asOnDate) {
                asOnDate.disabled = !isAsOn;
            }

            if (asOnTimeFrame) {
                asOnTimeFrame.disabled = !isAsOn;
            }
        }

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
            $.ajax({
                url: '<?php echo e(route('user.filters.fund-count')); ?>',
                type: 'GET',
                dataType: 'json',
                data: {
                    fund_type_id: selectElement.value,
                },
                success: function(response) {
                    var count = response && typeof response.count !== 'undefined' ? response.count : 0;
                    $('#fund_type_msgg').text('There are ' + count + ' funds in this fund type. Select how many records you want to show.');
                    $('#record_val').val(count);
                    toggleFilterCategoryFields();
                },
                error: function() {
                    $('#fund_type_msgg').text('Unable to fetch fund count right now.');
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

            if ($('#all_check').prop('checked')) {
                $('#all_check').prop('checked', false);
            }

            $('#checkedFundIds').val(currentValues.join(','));
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleRankingFields();
            toggleFilterCategoryFields();
            fund_multiple();

            document.querySelectorAll('input[name="Category"]').forEach(function(radio) {
                radio.addEventListener('change', toggleFilterCategoryFields);
            });

            function updateCompositionDisplay() {
                var selectedValue = document.getElementById('composition_value').value;
                var scripElement = document.getElementById('scrip');
                var industryElement = document.getElementById('industry');

                if (selectedValue === 'scrip') {
                    scripElement.style.display = 'block';
                    industryElement.style.display = 'none';
                } else if (selectedValue === 'industry') {
                    scripElement.style.display = 'none';
                    industryElement.style.display = 'block';
                } else {
                    scripElement.style.display = 'none';
                    industryElement.style.display = 'none';
                }
            }

            updateCompositionDisplay();

            var compositionValueElement = document.getElementById('composition_value');
            if (compositionValueElement) {
                compositionValueElement.addEventListener('change', updateCompositionDisplay);
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/filters/composition.blade.php ENDPATH**/ ?>