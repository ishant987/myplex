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

            $allfundIds = implode(',', array_keys($fund_absolute_return));
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
                        <form class="mb-4" action="" id="filter_form">
                            <input type="hidden" name="disable" value="<?php echo e($disable); ?>">
                            <div class="row">
                                <input type="hidden" name="start_date" value="<?php echo e(old('start_date', $start_date ?? '')); ?>"
                                    readonly>

                                <input type="hidden" name="end_date" value="<?php echo e(old('end_date', $end_date ?? '')); ?>"
                                    readonly>

                                <input type="hidden" id="checkedFundIds" value="" name="checkedFundIds">

                                <input type="hidden" id="fundIds" value="<?php echo e($allfundIds ?? ''); ?>" name="allfundIds">



                                <div class="clearfix"></div>

                                <div class="col-md-4">
                                    <div class="form_group radio_btn radio_btn_checked">
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



                                <div class="col-md-4" id="record">
                                    <div class="form_group">
                                        <input type="number" placeholder="Records" name="records" id="record_val"
                                            value="">
                                    </div>
                                    <span class="text-danger" id="record_msgg"></span>
                                    <?php if($errors->has('records')): ?>
                                        <div class="alert alert-danger" id="record_msg"><?php echo e($message); ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="col-md-4 offset-md-4" id="scrip"
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

                                <div class="col-md-4 offset-md-4" id="industry"
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
                                        <button type="button" name="search" id="submit_btn" value="search"
                                            onclick="submitForm()">Search</button>
                                        <a href="<?php echo e(route('user.filters')); ?>" id="fund_type_btn">Reset</a>
                                        
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php if(isset($fund_absolute_return)): ?>
                        <div class="fund_section new_fund_section step_sec">
                            <ul>
                                <li>
                                    <p>Start Date : </p>
                                    <span><?php echo e(date('d-m-Y', strtotime($start_date))); ?></span>
                                </li>
                                <li>
                                    <p>End Date : </p>
                                    <span><?php echo e(date('d-m-Y', strtotime($end_date))); ?></span>
                                </li>
                                <?php if(isset($history)): ?>
                                    <?php $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($key == 0): ?>
                                            <?php if(isset($h['Category']) && $h['Category'] == 'by_category'): ?>
                                                <li>
                                                    <p>Fund Classification : </p>
                                                    <span><?php echo e(getNameTable('fund_type', 'name', 'ft_id', $h['fund_type'])); ?></span>
                                                </li>
                                                <h6 class="step_title">STEP : <?php echo e(++$key); ?></h6>
                                                <li>
                                                    <p>Top Schemes : </p>
                                                    <span><?php echo e($h['records'] ?? ''); ?></span>
                                                </li>
                                            <?php elseif(isset($h['Category']) && $h['Category'] == 'by_fund'): ?>
                                                <h6 class="step_title">STEP : <?php echo e(++$key); ?></h6>
                                                <li>
                                                    <p>Number of funds selected : </p>
                                                    <span><?php echo e($h['records'] ?? ''); ?></span>
                                                </li>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <h6 class="step_title">STEP : <?php echo e(++$key); ?></h6>
                                            <li>
                                                <p>Top Schemes : </p>
                                                <span><?php echo e($h['records'] ?? ''); ?></span>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(isset($h['filter']) && $h['filter'] == 'by_ratio'): ?>
                                            <?php if(isset($h['report_category'])): ?>
                                                <?php if(in_array($h['report_category'], $ratio_array)): ?>
                                                    <li>
                                                        <p>Risk Ratio : </p>
                                                        <span><?php echo e(str_replace('_', ' ', $h['report_category']) ?? ''); ?></span>
                                                    </li>
                                                <?php else: ?>
                                                    <li>
                                                        <p>Return Ratio : </p>
                                                        <span><?php echo e(str_replace('_', ' ', $h['report_category']) ?? ''); ?></span>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php elseif(isset($h['filter']) && $h['filter'] == 'by_composition'): ?>
                                            <li>
                                                <p>Composition : </p>
                                                <span><?php echo e(isset($h['composition']) ? str_replace('_', ' ', $h['composition']) : 'N/A'); ?></span>
                                            </li>
                                            <?php if(isset($h['composition']) && ($h['composition'] == 'scrip' || $h['composition'] == 'industry')): ?>
                                                <?php if(isset($h['scrip'])): ?>
                                                    <li>
                                                        <p>Scrip : </p>
                                                        <span><?php echo e($h['scrip'] ?? ''); ?></span>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if(isset($h['industry'])): ?>
                                                    <li>
                                                        <p>Industry : </p>
                                                        <span><?php echo e($h['industry'] ?? ''); ?></span>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <div class="graph_table">
                            <div class="share_pdf">

                                <div class="sharethis-inline-share-buttons"></div>
                                <a href="javascript:void(0)" id="exportPDF" class="pdf"><img
                                        src="<?php echo e(asset('themes/frontend/assets/infosolz/images/pdf.png')); ?>"></a>

                            </div>
                            <table class="table datatable" id="pdfData">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="all_check" id="all_check" onclick="allcheck()">
                                        </th>
                                        <th>Fund name</th>
                                        <th class="text_center">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($fund_absolute_return) > 0): ?>
                                        <?php $__currentLoopData = $fund_absolute_return; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fund_id => $fund_return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><input type="checkbox" id="checkbox_<?php echo e($fund_id); ?>"
                                                        class="fundCheck" data-fundId="<?php echo e($fund_id); ?>"
                                                        onclick="selectDynamicFund()"></td>
                                                <td><?php echo e(getNameTable('fund_master', 'fund_name', 'fund_id', $fund_id)); ?>

                                                </td>
                                                <td class="text_left"><?php echo e($fund_return); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <?php echo printNoData(); ?>

                    <?php endif; ?>
                </div>

                <?php if(count($fund_absolute_return) > 0): ?>
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

    <script>
        function allcheck() {
            var isChecked = $('#all_check').prop('checked');
            var fundIds = $('#fundIds').val().split(',').filter(Boolean);

            fundIds.forEach(function(fundId) {
                $('#checkbox_' + fundId).prop('checked', isChecked);
            });

            selectDynamicFund()
        }

        function selectDynamicFund() {
            var checkedCount = $('.fundCheck:checked').length;

            $('#record_val').val(checkedCount);
        }


        function submitForm() {

            var checkedIds = [];
            var records = null;
            var last_fund_ids = $('#fundIds').val();
            var fundIds = last_fund_ids.split(',').filter(Boolean);

            $('.fundCheck:checked').each(function() {
                var fundId = $(this).data('fundid');
                checkedIds.push(fundId);
            });

            if (checkedIds.length >= 2) {
                $('#checkedFundIds').val(checkedIds.join(','));
                records = checkedIds.length;
            } else {
                $('#checkedFundIds').val('');
                $('#checkedFundIds').val(last_fund_ids);
                records = fundIds.length;
            }

            var record_val = $('#record_val').val();

            if (record_val != null && records >= record_val && record_val >= 2) {
                $('#filter_form').submit();
            } else {
                var msg = 'You need to select minimum 2 and maximum ' + records + ' funds.';
                $('#record_msgg').html(msg);
                $('.preloader').hide();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {

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




        document.addEventListener('DOMContentLoaded', function() {
            var exportButton = document.getElementById('exportPDF');

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

                    // Add logo
                    doc.addImage(img, 'PNG', centerX, 10, imgWidth, imgHeight);

                    // Title
                    doc.setFontSize(16);
                    doc.setTextColor(45, 135, 23);
                    doc.text('Filter', pageWidth / 2, 35, {
                        align: 'center'
                    });

                    // Set font for body text
                    doc.setFontSize(12);
                    doc.setTextColor(0, 0, 0);

                    // Date details
                    var startDate = "<?php echo e(date('d-m-Y', strtotime($start_date))); ?>";
                    var endDate = "<?php echo e(date('d-m-Y', strtotime($end_date))); ?>";
                    var ratioArray = []; // Array to store ratios

                    // Assuming $history is a JavaScript object in the script
                    <?php $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        ratioArray.push({
                            step: <?php echo e($key + 1); ?>,
                            records: <?php echo e($h['records'] ?? 0); ?>,
                            fundClassification: "<?php echo e(isset($h['fund_type']) ? getNameTable('fund_type', 'name', 'ft_id', $h['fund_type']) : ''); ?>",
                            reportCategory: "<?php echo e(isset($h['report_category']) ? str_replace('_', ' ', $h['report_category']) : ''); ?>"
                        });
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    var startX = 15;
                    var yPosition = 70;

                    // Adding start date and end date
                    doc.text('Start Date : ' + startDate, startX, yPosition);
                    doc.text('End Date : ' + endDate, startX + 100, yPosition);
                    yPosition += 10;

                    // Loop through history to add details
                    ratioArray.forEach(function(item) {
                        // Add Fund Classification
                        if (item.fundClassification) {
                            doc.text('Fund Classification : ' + item.fundClassification, startX,
                                yPosition);
                            yPosition += 10;
                        }

                        // Add Step information
                        doc.text('STEP : ' + item.step, startX, yPosition);
                        yPosition += 5;

                        // Add Top Schemes and Return Ratio on the same line
                        var topSchemesText = 'Top Schemes : ' + item.records;
                        var returnRatioText = 'Return Ratio : ' + item.reportCategory;

                        // Calculate positions to align them on the same line
                        var returnRatioX = startX +
                            100; // Adjust this value based on your layout

                        doc.text(topSchemesText, startX, yPosition);
                        doc.text(returnRatioText, returnRatioX, yPosition);
                        yPosition += 10;

                        // Add spacing after each step
                        yPosition += 5;
                    });

                    // Prepare table data
                    var table = document.getElementById('pdfData');
                    var tableData = [];

                    // Extract table data
                    for (var i = 1, row; row = table.rows[i]; i++) {
                        var rowData = [];
                        // Fund Name
                        rowData.push(row.cells[1].innerText); // Fund name
                        // Value
                        rowData.push(row.cells[2].innerText); // Value
                        // Rank (if exists)
                        if (row.cells.length > 3) {
                            rowData.push(row.cells[3].innerText); // Rank
                        }
                        tableData.push(rowData);
                    }

                    // Add the table to the PDF
                    doc.autoTable({
                        head: [
                            ['Fund Name', 'Value']
                        ], // Adjusted the headers based on your table structure
                        body: tableData,
                        startY: yPosition,
                        theme: 'grid',
                        headStyles: {
                            fillColor: [45, 135, 23]
                        }
                    });

                    // Save the PDF
                    var currentDate = new Date();
                    var fileName = 'Filter-' + currentDate.toISOString().slice(0, 10) + '.pdf';

                    doc.save(fileName);
                };
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/filters/filtered_by_fund_manager.blade.php ENDPATH**/ ?>