<?php $__env->startSection('content'); ?>
    <?php
        $top_scrips = collect($top_scrips ?? []);
        $top_industries = collect($top_industries ?? []);
        $topScripBreakdown = $top_scrip_breakdown ?? [];
        $topIndustryBreakdown = $top_industry_breakdown ?? [];
        $isByFundMode = isset($request) && data_get($request, 'Category') === 'by_fund';
    ?>
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                        <li><a href="<?php echo e(route('user.composition_report')); ?>">composition report</a></li>
                        <li>Top Scrips<br> Top Industries</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>

                    <div class="light_green_bg">
                        <form action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form_group radio_btn">
                                        <label>
                                            <input type="radio" id="type_Category" name="Category"
                                                value="by_category"
                                                <?php if(!$isByFundMode): ?> checked <?php endif; ?>
                                                onclick='get_fund_types(this.value)'>
                                            By Category
                                        </label>
                                        <label>
                                            <input type="radio" id="fund_Category" name="Category" value="by_fund"
                                                <?php if($isByFundMode): ?> checked <?php endif; ?>
                                                onclick='get_fund_types(this.value)'>
                                            By Fund
                                        </label>
                                    </div>
                                </div>
                                <input type="hidden" name="active_tab" value="<?php echo e($active_tab ?? ''); ?>" id="active-tab-input">
                                
                                
                                <div class="col-md-6 div_show_1" style="<?php echo e($isByFundMode ? 'display:none;' : ''); ?>">
                                    <div class="form_group">
                                        <select name="fund_type_id" id="fund_type_id" class="select2"
                                            data-placeholder="Select Fund Classification" <?php if(!$isByFundMode): ?> required <?php endif; ?>>
                                            <option value=""></option>
                                            <?php if(isset($all_fund_types)): ?>
                                                <?php $__currentLoopData = $all_fund_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($val->ft_id); ?>"
                                                        <?php if($val->ft_id == old('fund_type_id', $request->fund_type_id ?? $fund_type_id ?? '')): ?> selected <?php endif; ?>>
                                                        <?php echo e($val->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
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
                                    <span class="text-danger" id="category_msgg"></span>
                                </div>
                                <div class="col-md-6 div_hide_1" style="<?php echo e($isByFundMode ? '' : 'display:none;'); ?>">
                                    <div class="form_group multiple_select">
                                        <select name="fund_id[]" class="select2 multiple" multiple
                                            id="allocation_select_fund" onchange ='set_fund_select_val(this.value)'
                                            data-placeholder="Select Fund">
                                            <?php if(isset($all_funds)): ?>
                                                <?php $__currentLoopData = $all_funds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($val->fund_id); ?>"
                                                        <?php if($val->fund_id == old('fund_id', $request->fund_id)): ?>
                                                            selected
                                                        <?php elseif(isset($fund_id) && in_array($val->fund_id, $fund_id)): ?>
                                                            selected
                                                        <?php endif; ?>>
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



                                <?php echo $__env->make('web.layout.includes.year_month', [
                                    'yearFieldName' => 'year',
                                    'monthFieldName' => 'month',
                                    'selectedYear' => $year ?? '',
                                    'selectedMonth' => $month ?? '',
                                    'size' => 6,
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


                                <div class="col-md-6">
                                    <div class="form_group">
                                        <label for="limit">Show:</label>
                                        <select name="limit" id="limit" class="select2">
                                            <option value="10" <?php echo e(request('limit') == 10 ? 'selected' : ''); ?>>10
                                            </option>
                                            <option value="20" <?php echo e(request('limit') == 20 ? 'selected' : ''); ?>>20
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="bttn_grp">
                                        
                                        <?php if(isset($top_scrips)): ?>
                                            <p>Showing top <?php echo e(count($top_scrips)); ?> results</p>
                                        <?php endif; ?>

                                        <button type="submit" name="search" id="submit_btn" value="search">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <input type="hidden" name="fund_codes" id="fund_codes"
                        value="<?php echo e(isset($fund_details) ? json_encode($fund_details) : ''); ?>">
                    <input type="hidden" name="lastDate" id="lastDate" value="<?php echo e(isset($lastDate) ? $lastDate : ''); ?>">
                    <?php if(!empty($message)): ?>
                        <div class="graph_table">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text_center"><?php echo e($message); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php elseif($top_scrips->isNotEmpty() || $top_industries->isNotEmpty()): ?>
                        <div class="wm_tab">
                            <ul class="tabs">
                                <li>
                                    <a class="<?php echo e((isset($active_tab) && $active_tab == 'scrip') || is_null($active_tab) ? 'active' : ''); ?>" onclick="switchTab('scrip')" href="javascript:void(0)">Top Scrips</a>
                                </li>
                                <li>
                                    <a class="<?php echo e(isset($active_tab) && $active_tab == 'indus' ? 'active' : ''); ?>" onclick="switchTab('indus')" href="javascript:void(0)">Top Industries</a>
                                </li>
                            </ul>
                        </div>


                        <div class="tabsct">
                            <div class="tab" style="<?php echo e((isset($active_tab) && $active_tab == 'scrip') || is_null($active_tab) ? 'display:block' : 'display:none'); ?>">
                                <div class="quartile_tab">
                                    <div class="fund_section new_fund_section">
                                        <ul>
                                            <li>
                                                <p>Top scrips :</p>
                                                <?php if(isset($monthName) && isset($year)): ?>
                                                    <span>For the month of <?php echo e($monthName); ?>,<?php echo e($year); ?></span>
                                                <?php endif; ?>
                                            </li>
                                            
                                            <?php if(isset($request) && $request->Category == 'by_category'): ?>
                                                <li>
                                                    <p>fund classification :</p>
                                                    <span><?php echo e(isset($fund_type_name) ? $fund_type_name : ''); ?></span>
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
                                            <a href="javascript:void(0)" id="exportPDF-scrips" class="pdf"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/pdf.png')); ?>" ></a>
                                            
                                        </div>
                                        <table class="table datatable" id="pdfData-scrips">
                                            <thead>
                                                <tr>
                                                    <th>name of the scrips</th>
                                                    <th>industry</th>
                                                    <th class="text_center">content %</th>
                                                    <th class="text_center">Amount (in Cr.)</th>
                                                </tr>
                                            </thead>
                                            <?php if($top_scrips->count() > 0): ?>
                                                <tbody>
                                                    <?php $__currentLoopData = $top_scrips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scrips): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($scrips->scrip_name); ?></td>
                                                            <td><?php echo e($scrips->industry); ?></td>
                                                            <td class="text_right open-popup-scrip-industry"
                                                                data-category="content_per" data-using="scrip"
                                                                data-parameter="<?php echo e($scrips->scrip_name); ?>">
                                                                <?php echo e(printValue($scrips->content_per)); ?>

                                                            </td>
                                                            <td class="text_right open-popup-scrip-industry"
                                                                data-using="scrip" data-category="amount"
                                                                data-parameter="<?php echo e($scrips->scrip_name); ?>">
                                                                <?php echo e(printValue($scrips->amount)); ?></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            <?php else: ?>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="4">No information available for this search</td>
                                                    </tr>
                                                </tbody>
                                            <?php endif; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab" style="<?php echo e(isset($active_tab) && $active_tab == 'indus' ? 'display:block' : 'display:none'); ?>">
                                <div class="decile">
                                    <div class="fund_section new_fund_section">
                                        <ul>
                                            <li>
                                                <p>Top industries :</p>
                                                <?php if(isset($monthName) && isset($year)): ?>
                                                    <span>For the month of <?php echo e($monthName); ?>,<?php echo e($year); ?></span>
                                                <?php endif; ?>
                                            </li>

                                            <?php if(isset($request) && $request->Category == 'by_category'): ?>
                                                <li>
                                                    <p>fund classification :</p>
                                                    <span><?php echo e(isset($fund_type_name) ? $fund_type_name : ''); ?></span>
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
                                            <a href="javascript:void(0)" id="exportPDF-industries" class="pdf"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/pdf.png')); ?>" ></a>
                                            
                                        </div>
                                        <table class="table datatable" id="pdfData-industries">
                                            <thead>
                                                <tr>
                                                    <th class="text_left">name of the Industries</th>
                                                    <th class="text_center">category</th>
                                                    <th class="text_center">content %</th>
                                                    <th class="text_center">Amount (in Cr.)</th>
                                                </tr>
                                            </thead>
                                            <?php if($top_industries->count() > 0): ?>
                                                <tbody>
                                                    <?php $__currentLoopData = $top_industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $industry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td class="text_left"><?php echo e($industry->industry); ?></td>
                                                            <td class="text_left"><?php echo e($industry->category); ?></td>
                                                            <td class="text_left open-popup-scrip-industry"
                                                                data-using="industry" data-category="content_per"
                                                                data-parameter="<?php echo e($industry->industry); ?>">
                                                                <?php echo e(printValue($industry->content_per)); ?>

                                                            </td>
                                                            <td class="text_left open-popup-scrip-industry"
                                                                data-using="industry" data-category="amount"
                                                                data-parameter="<?php echo e($industry->industry); ?>">
                                                                <?php echo e(printValue($industry->amount)); ?></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            <?php else: ?>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="4">No information available for this search</td>
                                                    </tr>
                                                </tbody>
                                            <?php endif; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php echo printNoData(); ?>

                    <?php endif; ?>
                </div>
                <?php if($top_scrips->isNotEmpty() || $top_industries->isNotEmpty()): ?>
                    <div class="disclaimer">
                        <p><strong>Disclaimer : </strong><?php echo e($disclaimer); ?></p>
                    </div>
            </div>
            <?php endif; ?>


            <div class="popup-overlay"></div>
            <div class="table_popup">
                <div class="graph_table">
                    <h4>Composition Details</h4>
                    <div class="table_overflow table_height">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Fund Name </th>
                                    <th id="composition-details-value-header">% Change </th>
                                </tr>
                            </thead>
                            <tbody id="composition-details-body">

                            </tbody>
                        </table>
                    </div>
                </div>
                <button class="close_popup"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <style>
                .popup-overlay {
                    position: fixed;
                    inset: 0;
                    background: rgba(0, 0, 0, 0.45);
                    z-index: 9998;
                    display: none;
                }

                .table_popup {
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    width: min(720px, calc(100vw - 32px));
                    max-height: 80vh;
                    overflow: hidden;
                    background: #fff;
                    border-radius: 16px;
                    box-shadow: 0 24px 60px rgba(0, 0, 0, 0.22);
                    z-index: 9999;
                    display: none;
                    padding: 20px;
                }

                .popup-overlay.show,
                .table_popup.show {
                    display: block !important;
                }

                .table_popup .graph_table {
                    margin-bottom: 0;
                }

                .table_popup h4 {
                    margin-bottom: 16px;
                }

                .table_popup .close_popup {
                    position: absolute;
                    top: 12px;
                    right: 12px;
                    border: 0;
                    background: transparent;
                    font-size: 22px;
                    line-height: 1;
                    cursor: pointer;
                }
            </style>

            <script>
                (function () {
                    const topScripBreakdownInline = <?php echo json_encode($topScripBreakdown, 15, 512) ?>;
                    const topIndustryBreakdownInline = <?php echo json_encode($topIndustryBreakdown, 15, 512) ?>;

                    function normalizeCompositionKeyInline(value) {
                        return String(value || '').trim().replace(/\s+/g, ' ').toLowerCase();
                    }

                    function formatCompositionDetailValueInline(value) {
                        const numericValue = Number(value || 0);
                        return Number.isFinite(numericValue) ? numericValue.toFixed(2) : '0.00';
                    }

                    function openCompositionDetailsInline(rows, category) {
                        const tbody = document.getElementById('composition-details-body');
                        const header = document.getElementById('composition-details-value-header');

                        if (!tbody || !header) {
                            return;
                        }

                        header.textContent = category === 'amount' ? 'Amount (in Cr.)' : 'Content %';
                        tbody.innerHTML = '';

                        if (!rows.length) {
                            tbody.innerHTML = '<tr><td colspan="2">No composition details available.</td></tr>';
                        } else {
                            rows.forEach(function (row) {
                                const tr = document.createElement('tr');
                                tr.innerHTML =
                                    '<td>' + (row.fund_name || 'N/A') + '</td>' +
                                    '<td>' + formatCompositionDetailValueInline(row[category]) + '</td>';
                                tbody.appendChild(tr);
                            });
                        }

                        document.querySelectorAll('.popup-overlay, .table_popup').forEach(function (element) {
                            element.classList.add('show');
                        });
                    }

                    document.addEventListener('click', function (event) {
                        const trigger = event.target.closest('.open-popup-scrip-industry');
                        if (trigger) {
                            const usingType = trigger.getAttribute('data-using');
                            const category = trigger.getAttribute('data-category');
                            const parameter = trigger.getAttribute('data-parameter');
                            const normalizedParameter = normalizeCompositionKeyInline(parameter);
                            const rows = usingType === 'industry'
                                ? (topIndustryBreakdownInline[normalizedParameter] || [])
                                : (topScripBreakdownInline[normalizedParameter] || []);

                            openCompositionDetailsInline(rows, category);
                            return;
                        }

                        if (event.target.closest('.close_popup') || event.target.classList.contains('popup-overlay')) {
                            document.querySelectorAll('.popup-overlay, .table_popup').forEach(function (element) {
                                element.classList.remove('show');
                            });
                        }
                    });
                })();
            </script>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<script>
    const topScripBreakdown = <?php echo json_encode($topScripBreakdown, 15, 512) ?>;
    const topIndustryBreakdown = <?php echo json_encode($topIndustryBreakdown, 15, 512) ?>;

    function normalizeCompositionKey(value) {
        return String(value || '').trim().replace(/\s+/g, ' ').toLowerCase();
    }

    function formatCompositionDetailValue(value) {
        var numericValue = Number(value || 0);
        return Number.isFinite(numericValue) ? numericValue.toFixed(2) : '0.00';
    }

    function openCompositionDetails(rows, category) {
        var tbody = document.getElementById('composition-details-body');
        var header = document.getElementById('composition-details-value-header');

        if (!tbody || !header) {
            return;
        }

        header.textContent = category === 'amount' ? 'Amount (in Cr.)' : 'Content %';
        tbody.innerHTML = '';

        if (!rows.length) {
            tbody.innerHTML = '<tr><td colspan="2">No composition details available.</td></tr>';
        } else {
            rows.forEach(function(row) {
                var tr = document.createElement('tr');
                tr.innerHTML =
                    '<td>' + (row.fund_name || 'N/A') + '</td>' +
                    '<td>' + formatCompositionDetailValue(row[category]) + '</td>';
                tbody.appendChild(tr);
            });
        }

        $('.popup-overlay, .table_popup').addClass('show');
    }

    function set_fund_select_val() {

        var thiss = $('input[name="Category"]:checked').val();
        var count = $('#allocation_select_fund').select2('data').length;

        console.log(thiss + '  ' + count);

        if (thiss == 'by_fund') {

            if (count >= 2 && count <= 20) {
                $('#fund_msgg').html('');
                $('#submit_btn').prop('disabled', false);
            } else {
                $('#fund_msgg').html('<p>Selection limit minimum 2 and maximum 20 for <b>Funds</b></p>');
                $('#submit_btn').prop('disabled', true);
            }


        } else {
            $('#fund_msgg').html('');
            $('#submit_btn').prop('disabled', false);
        }
    }

    function validate_category_selection() {
        var selectedCategory = $('input[name="Category"]:checked').val() || 'by_category';
        var selectedFundType = $('#fund_type_id').val();

        if (selectedCategory === 'by_category') {
            if (selectedFundType) {
                $('#category_msgg').html('');
                $('#submit_btn').prop('disabled', false);
            } else {
                $('#category_msgg').html('<p>Select a <b>Fund Classification</b> to run this report.</p>');
                $('#submit_btn').prop('disabled', true);
            }
        }
    }

    function get_fund_types(thiss) {
        $('.div_show_1').toggle(thiss === 'by_category');
        $('.div_hide_1').toggle(thiss === 'by_fund');
        $('#fund_type_id').prop('required', thiss === 'by_category');

        var count = $('#allocation_select_fund').select2('data').length;

        if (thiss == 'by_category') {
            $('#fund_msgg').html('');
            validate_category_selection();
        } else if (thiss == 'by_fund') {
            $('#category_msgg').html('');

            if (count >= 2 && count <= 20) {
                $('#fund_msgg').html('');
                $('#submit_btn').prop('disabled', false);
            } else {
                $('#fund_msgg').html('<p>Selection limit minimum 2 and maximum 20 for <b>Funds</b></p>');
                $('#submit_btn').prop('disabled', true);
            }

        }
    }

    function switchTab(tab_name){
        $('#active-tab-input').val(tab_name);
    }

document.addEventListener('DOMContentLoaded', function() {
        get_fund_types($('input[name="Category"]:checked').val() || 'by_category');
        $('#fund_type_id').on('change', validate_category_selection);

        $(document).on('click', '.open-popup-scrip-industry', function() {
            var usingType = $(this).data('using');
            var category = $(this).data('category');
            var parameter = $(this).data('parameter');
            var normalizedParameter = normalizeCompositionKey(parameter);
            var rows = usingType === 'industry'
                ? (topIndustryBreakdown[normalizedParameter] || [])
                : (topScripBreakdown[normalizedParameter] || []);

            openCompositionDetails(rows, category);
        });

        $(document).on('click', '.close_popup, .popup-overlay', function() {
            $('.popup-overlay, .table_popup').removeClass('show');
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
    var exportButtonIndustries = document.getElementById('exportPDF-industries');

    if (!exportButtonIndustries) {
        return;
    }

    exportButtonIndustries.addEventListener('click', function() {
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
            doc.text('Top Industries', pageWidth / 2, 35, { align: 'center' });
            doc.setFontSize(12);
            doc.setTextColor(0, 0, 0);

            var startX = 15;
            var lineHeight = 10;
            var yPosition = 70;

            // Adding top industries dynamic information
            <?php if(isset($monthName) && isset($year)): ?>
                var industriesHeaderText = `Top Industries: For the month of <?php echo e($monthName); ?>, <?php echo e($year); ?>`;
                doc.text(industriesHeaderText, 15, yPosition);
                yPosition += lineHeight;
            <?php endif; ?>

            <?php if(isset($request) && $request->Category == 'by_category'): ?>
                var fundClassificationText = `Fund Classification: <?php echo e(isset($fund_type_name) ? $fund_type_name : 'N/A'); ?>`;
                doc.text(fundClassificationText, 15, yPosition);
                yPosition += lineHeight;
            <?php endif; ?>

            <?php if(isset($request) && $request->Category == 'by_fund'): ?>
                var fundNames = "<?php echo e(isset($fund_names) ? $fund_names : ''); ?>";
                var splitFundNames = doc.splitTextToSize(fundNames, 160);
                doc.text('Fund Name: ', startX, yPosition);
                yPosition += 10;
                doc.text(splitFundNames, startX, yPosition); 
                yPosition += splitFundNames.length * lineHeight;
            <?php endif; ?>

            // Data table for industries
            var table = new DataTable('#pdfData-industries');
            var tableData = [];
            table.rows({ search: 'applied' }).data().each(function(row) {
                tableData.push([row[0], row[1], row[2], row[3]]);
            });

            doc.autoTable({
                head: [['Industry Name', 'Category', 'Content %', 'Amount (in Cr.)']],
                body: tableData,
                startX: 15,
                startY: yPosition + 10,
                headStyles: { fillColor: [45, 135, 23] }
            });

            var currentDate = new Date();
            var fileName = 'Top Industries-' + currentDate.toISOString().split('T')[0] + '.pdf';
            doc.save(fileName);
        };
    });
});

// Similar modifications can be made for the "Top Scrips" section.

document.addEventListener('DOMContentLoaded', function() {
    var exportButtonScrips = document.getElementById('exportPDF-scrips');

    if (!exportButtonScrips) {
        return;
    }

    exportButtonScrips.addEventListener('click', function() {
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
            doc.text('Top Scrips', pageWidth / 2, 35, { align: 'center' });
            doc.setFontSize(12);
            doc.setTextColor(0, 0, 0);

            var startX = 15;
            var lineHeight = 10;
            var yPosition = 70;

            // Adding top scrips dynamic information
            <?php if(isset($monthName) && isset($year)): ?>
                var scripsHeaderText = `Top Scrips: For the month of <?php echo e($monthName); ?>, <?php echo e($year); ?>`;
                doc.text(scripsHeaderText, 15, yPosition);
                yPosition += lineHeight;
            <?php endif; ?>

            <?php if(isset($request) && $request->Category == 'by_category'): ?>
                var fundClassificationText = `Fund Classification: <?php echo e(isset($fund_type_name) ? $fund_type_name : 'N/A'); ?>`;
                doc.text(fundClassificationText, 15, yPosition);
                yPosition += lineHeight;
            <?php endif; ?>

            <?php if(isset($request) && $request->Category == 'by_fund'): ?>
                var fundNames = "<?php echo e(isset($fund_names) ? $fund_names : ''); ?>";
                var splitFundNames = doc.splitTextToSize(fundNames, 160);
                doc.text('Fund Name: ', startX, yPosition);
                yPosition += 10;
                doc.text(splitFundNames, startX, yPosition); 
                yPosition += splitFundNames.length * lineHeight;
            <?php endif; ?>

            // Data table for scrips
            var table = new DataTable('#pdfData-scrips');
            var tableData = [];
            table.rows({ search: 'applied' }).data().each(function(row) {
                tableData.push([row[0], row[1], row[2], row[3]]);
            });

            doc.autoTable({
                head: [['Scrip Name', 'Industry', 'Content %', 'Amount (in Cr.)']],
                body: tableData,
                startX: 15,
                startY: yPosition + 10,
                headStyles: { fillColor: [45, 135, 23] }
            });

            var currentDate = new Date();
            var fileName = 'Top Scrips-' + currentDate.toISOString().split('T')[0] + '.pdf';
            doc.save(fileName);
        };
    });
});





</script>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/composition_report/top_script_rop_industry.blade.php ENDPATH**/ ?>