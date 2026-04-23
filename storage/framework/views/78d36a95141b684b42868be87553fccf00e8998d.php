<?php $__env->startSection('content'); ?>
    <?php
        $fund_names = '';
        $isByFundMode = isset($request) && $request->Category === 'by_fund';
        $selectedCategory = $isByFundMode ? 'by_fund' : 'by_category';
        $selectedCompositionType = isset($getData['scrip_industry']) ? $getData['scrip_industry'] : 'scrip';
        $selectedIndustry = trim((string) ($getData['industry'] ?? ''));
        $selectedScrip = trim((string) ($getData['fund_scrips'] ?? ''));
    ?>
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                        <li><a href="<?php echo e(route('user.composition_report')); ?>">composition report</a></li>
                        <li>Occurrence Report</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>

                    <div class="wm_tab">
                        <ul class="tabs">
                            
                            <li>
                                <!-- <a class="<?php echo e(isset($getData) && $getData['scrip_industry'] == 'scrip' ? 'active' : ''); ?>"
                                                    id="decile_tab" data-value="scrip" onclick="industry_scrip_select(this)">Scrip</a> -->
                                <a class="<?php echo e($selectedCompositionType === 'scrip' ? 'active' : ''); ?>"
                                    id="decile_tab" data-value="scrip" onclick="industry_scrip_select(this)">Scrip</a>
                            </li>
                            <li>
                                <!-- <a class="<?php if(isset($getData['scrip_industry'])): ?> <?php if($getData['scrip_industry'] == 'industry'): ?>
                                            active <?php endif; ?>
<?php else: ?>
active
                                         <?php endif; ?>

                                "
                                                    id="quartile_tab" data-value="industry"
                                                    onclick="industry_scrip_select(this)">Industry</a> -->
                                <a class="<?php echo e($selectedCompositionType === 'industry' ? 'active' : ''); ?>"
                                    id="quartile_tab" data-value="industry"
                                    onclick="industry_scrip_select(this)">Industry</a>
                            </li>


                        </ul>
                    </div>

                    <div class="light_green_bg">
                        <form action="<?php echo e(route('user.occurrence_report')); ?>" method="GET" id="occurrence-report-form">
                            <div class="row">

                                

                                <!-- <input type="hidden" name="scrip_industry" id="scrip_industry"
                                                    value="<?php if(isset($getdata)): ?> <?php if($getData['scrip_industry'] == 'industry'): ?>
                                            industry
                                            <?php elseif($getData['scrip_industry'] == 'scrip'): ?>
                                            scrip <?php endif; ?>
<?php else: ?>
industry
                                        <?php endif; ?>"> -->

                                <input type="hidden" name="scrip_industry" id="scrip_industry"
                                    value="<?php echo e($selectedCompositionType); ?>">



                                <div class="col-md-4">
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

                                <div class="col-md-4 div_hide_1" style="<?php echo e($isByFundMode ? '' : 'display:none;'); ?>">
                                    <div class="form_group">
                                        <select name="fund_id[]" class="select2 multiple" multiple
                                            id="allocation_select_fund" onchange="set_fund_select_val(this.value)">
                                            <?php $__currentLoopData = $all_funds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($fund->fund_id); ?>"
                                                    <?php if(old('fund_id') !== null && in_array($fund->fund_id, (array) old('fund_id'))): ?> selected
                                                    <?php elseif(isset($fund_ids) && in_array($fund->fund_id, $fund_ids)): ?>
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

                                <div class="col-md-4 div_show_1" style="<?php echo e($isByFundMode ? 'display:none;' : ''); ?>">
                                    <div class="form_group">
                                        <select name="fund_type_id" class="select2" data-placeholder="Select Fund Type">
                                            <option value="">Select Fund Type</option>
                                            <?php $__currentLoopData = $all_fund_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fund_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($fund_type->ft_id); ?>"
                                                    <?php if($fund_type->ft_id == old('fund_type_id', isset($getData) ? $getData['fund_type_id'] : null)): ?> selected <?php endif; ?>>
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
                                <!-- <div class="col-md-4 industry"
                                                    style="<?php echo e(isset($getData) ? ($getData['scrip_industry'] == 'industry' ? 'display:block' : 'display:none') : 'display:block'); ?>"> -->
                                <div class="col-md-4 industry"
                                    style="<?php echo e($selectedCompositionType === 'industry' ? 'display:block' : 'display:none'); ?>">
                                    <div class="form_group">
                                        <select class="select2" id="industry_select" name="industry" data-placeholder="Select Industry">
                                            <option value="">Select Industry</option>
                                            <?php $__currentLoopData = $industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $industry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    value="<?php echo e($industry->industry); ?>"<?php echo e(strcasecmp(trim((string) $industry->industry), $selectedIndustry) === 0 ? 'selected' : ''); ?>>
                                                    <?php echo e($industry->industry); ?> </option>
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

                                <!-- <div class="col-md-4 scrip"
                                                    style="<?php echo e(isset($getData) && $getData['scrip_industry'] == 'scrip' ? 'display:block' : 'display:none'); ?>"> -->
                                <div class="col-md-4 scrip"
                                    style="<?php echo e($selectedCompositionType === 'scrip' ? 'display:block' : 'display:none'); ?>">
                                    <div class="form_group">
                                        <select class="select2" id="fund_scrips_select" name="fund_scrips" data-placeholder="Select Scrip">
                                            <option value="">Select Scrip</option>
                                            <?php $__currentLoopData = $mpx_fund_scrips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    value="<?php echo e($scr->actual_scrip); ?>"<?php echo e(strcasecmp(trim((string) $scr->actual_scrip), $selectedScrip) === 0 ? 'selected' : ''); ?>>
                                                    <?php echo e($scr->actual_scrip); ?></option>
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
                                    </div>
                                </div>

                                <?php echo $__env->make('web.layout.includes.year_month', [
                                    'yearFieldName' => 'year',
                                    'monthFieldName' => 'month',
                                    'selectedYear' => $getData['year'] ?? '',
                                    'selectedMonth' => $getData['month'] ?? '',
                                    'size' => 6,
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                

                                <div class="col-md-12">
                                    <div class="bttn_grp">
                                        <button type="submit" name="search" id="submit_btn" value="search">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php if(!empty($has_searched)): ?>
                        <div class="fund_section new_fund_section">
                            <ul>
                                <?php if(isset($getData['month']) && isset($getData['year'])): ?>
                                    <li>
                                        <p>Occurrence Report : </p> <span> For month of
                                            <?php echo e(isset($getData['month']) ? date('F', mktime(0, 0, 0, $getData['month'], 10)) : 'N/A'); ?>,
                                            <?php echo e(isset($getData['year']) ? $getData['year'] : 'N/A'); ?></span>
                                    </li>
                                <?php endif; ?>

                                <?php if(isset($getData['scrip_industry']) && $getData['scrip_industry'] == 'scrip'): ?>

                                    <li>
                                        <p>Scrip Name: </p>

                                        <span><?php echo e($selectedScrip !== '' ? $selectedScrip : 'N/A'); ?>,
                                        </span>

                                    </li>
                                <?php elseif(isset($getData['scrip_industry']) && $getData['scrip_industry'] == 'industry'): ?>
                                    <li>
                                        <p>Industry Name: </p>

                                        <span><?php echo e($selectedIndustry !== '' ? $selectedIndustry : 'N/A'); ?>,
                                        </span>

                                    </li>

                                <?php endif; ?>

                                <?php if(isset($fund_type_get_data->name)): ?>
                                    <li>
                                        <p>Fund type : </p>
                                        <span><?php echo e(isset($fund_type_get_data->name) ? $fund_type_get_data->name : 'N/A'); ?></span>
                                    </li>
                                <?php elseif(!empty($getData['fund_id'])): ?>
                                    <li>
                                        <p>Fund Names: </p>

                                        <?php $__currentLoopData = (array) $getData['fund_id']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fund_id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $fund_names .=
                                                    getNameTable('fund_master', 'fund_name', 'fund_id', $fund_id) .
                                                    ', ';
                                            ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <span><?php echo e(rtrim($fund_names, ', ')); ?></span>
                                    </li>
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
                                        <th class="text_left">name of the Fund</th>
                                        <th class="text_left">
                                            <?php if($selectedCompositionType === 'industry'): ?> Industry
                                                Name
                                            <?php elseif($selectedCompositionType === 'scrip'): ?>
                                                Scrip Name <?php endif; ?>
                                        </th>
                                        <th class="text_center">content (%)</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($fund_composition) && count($fund_composition) > 0): ?>
                                        <?php $__currentLoopData = $fund_composition; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="text_left">
                                                    <?php echo e(getNameTable('fund_master', 'fund_name', 'fund_code', $val->fund_code)); ?>

                                                </td>

                                                <?php if($selectedCompositionType === 'industry'): ?>
                                                    <td class="text_left">
                                                        <?php echo e(isset($val->industry) ? $val->industry : 'N/A'); ?>

                                                    </td>
                                                <?php elseif($selectedCompositionType === 'scrip'): ?>
                                                    <td class="text_left">
                                                        <?php echo e(isset($val->scrip_name) ? $val->scrip_name : 'N/A'); ?>

                                                    </td>
                                                <?php endif; ?>


                                                <td class="text_right">
                                                    <?php echo e(isset($val->content_per) ? printValue($val->content_per) : '0'); ?>

                                                </td>
                                                
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text_center">
                                                <?php echo e($message ?: 'No information available for this search.'); ?>

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
                <?php if(isset($fund_composition) && count($fund_composition) > 0): ?>
                    <div class="disclaimer">
                        <p><strong>Disclaimer : </strong><?php echo e($disclaimer); ?></p>
                    </div>


                <?php endif; ?>
            </div>
        </div>
    </div>
    
<?php $__env->stopSection(); ?>


<script>
    function get_classification(thiss) {
        decile

        if (thiss == 'classification') {

            $('#fund_type_div').removeAttr('style');
            $('#fund_type').prop('required', true);


            $('#fund_master').prop('required', false);
            $('#fund_master').val('0');


            $('#fund_name_div').attr('style', 'display:none');

        } else if (thiss == 'fund') {

            $('#fund_type_div').attr('style', 'display:none');
            $('#fund_type').prop('required', false);

            $('#fund_type').val('0');


            $('#fund_master').prop('required', true);

            $('#fund_name_div').removeAttr('style');


        }


    }

    function get_fund_by_scrips(thiss) {

        var scrips_name = thiss;

        var url = '<?php echo e(route('user.get_fund_by_scrips')); ?>';

        $.ajax({
            type: "GET",
            url: url,
            data: {
                'scrips_name': scrips_name
            },
            success: function(response) {

                $('#fund_master').html(response);

            }
        });

    }


    function updateOccurrenceModeUI(mode) {
        var isByFund = mode === 'by_fund';
        $('.div_show_1').toggle(!isByFund);
        $('.div_hide_1').toggle(isByFund);

        if (!isByFund) {
            $('#fund_msgg').html('');
            $('#submit_btn').prop('disabled', false);
        } else {
            set_fund_select_val();
        }
    }

    function set_fund_select_val() {
        var thiss = $('input[name="Category"]:checked').val();
        var count = ($('#allocation_select_fund').val() || []).length;

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

    function get_fund_types(thiss) {
        updateOccurrenceModeUI(thiss);
    }

    function industry_scrip_select(element) {
        var dataValue = element.getAttribute('data-value');
        $('#scrip_industry').val(dataValue);
        $('.wm_tab .tabs a').removeClass('active');
        $(element).addClass('active');
        if (dataValue === 'scrip') {
            $('.industry').hide();
            $('.scrip').show();
            $('#industry_select').prop('disabled', true);
            $('#fund_scrips_select').prop('disabled', false);
        } else if (dataValue === 'industry') {
            $('.industry').show();
            $('.scrip').hide();
            $('#industry_select').prop('disabled', false);
            $('#fund_scrips_select').prop('disabled', true);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var selectedCategory = $('input[name="Category"]:checked').val() || 'by_category';
        updateOccurrenceModeUI(selectedCategory);
        $('#allocation_select_fund').on('change', set_fund_select_val);
        industry_scrip_select(document.querySelector('.wm_tab .tabs a.active') || document.getElementById('decile_tab'));

        $('#occurrence-report-form').on('submit', function() {
            var compositionType = $('#scrip_industry').val() || 'scrip';

            if (compositionType === 'industry') {
                $('#industry_select').prop('disabled', false);
                $('#fund_scrips_select').prop('disabled', true);
            } else {
                $('#industry_select').prop('disabled', true);
                $('#fund_scrips_select').prop('disabled', false);
            }
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
                doc.text('Occurrence Report', pageWidth / 2, 35, {
                    align: 'center'
                });

                doc.setFontSize(12);
                doc.setTextColor(0, 0, 0);


                var fundNames = "<?php echo e(isset($fund_names) ? rtrim($fund_names, ', ') : ''); ?>";


                var startX = 15;
                var lineHeight = 10;
                var yPosition = 70;


                // Start replacing this section with new HTML-based data

                // Scrips Boomers (Month, Year)
                <?php if(isset($getData['month']) && isset($getData['year'])): ?>
                    var scripsBoomersText =
                        `Occurrence Report: For the month of <?php echo e(isset($getData['month']) ? date('F', mktime(0, 0, 0, $getData['month'], 10)) : 'N/A'); ?>, <?php echo e(isset($getData['year']) ? $getData['year'] : 'N/A'); ?>`;
                    doc.text(scripsBoomersText, 15, 70);
                <?php endif; ?>

                var yPosition = 80; // Adjust the position to move after the first text

                // Limit
                // <?php if(isset($limit)): ?>
                //     var limitText = `Limit: <?php echo e(isset($limit) ? $limit : ''); ?>`;
                //     doc.text(limitText, 15, yPosition);
                //     yPosition += 10;
                // <?php endif; ?>

                // Fund Classification
                <?php if($selectedCategory === 'by_category'): ?>
                    var fundClassificationText =
                        `Fund Classification: <?php echo e(isset($fund_type_get_data->name) ? $fund_type_get_data->name : 'N/A'); ?>`;
                    doc.text(fundClassificationText, 15, yPosition);
                    yPosition += 10;
                <?php endif; ?>
                
                // Fund Name
                <?php if($selectedCategory === 'by_fund'): ?>
                    // Split the fund names if too long to fit within 180 units (adjust width as necessary)
                    var splitFundNames = doc.splitTextToSize(fundNames, 160);
                    doc.text('Fund Names: ', startX, yPosition);
                    yPosition += 10;
                    doc.text(splitFundNames, startX, yPosition); // This will handle multiple lines
                    yPosition += splitFundNames.length *
                        lineHeight; // Adjust yPosition based on the number of lines
                <?php endif; ?>
                // End of replacing section

                var table = new DataTable('#pdfData');
                var tableData = [];
                table.rows({
                    search: 'applied'
                }).data().each(function(row) {
                    tableData.push(row);
                });

                var middle_name = `<?php echo e($selectedCompositionType === 'industry' ? 'Industry Name' : 'Scrip Name'); ?>`;
                doc.autoTable({
                    head: [
                        ['Name of The Fund', middle_name, 'Content(%)']
                    ],
                    body: tableData,
                    startX: 15,
                    startY: yPosition + 10,
                    headStyles: {
                        fillColor: [45, 135, 23]
                    }
                });

                var currentDate = new Date();
                var fileName = 'Occurrence-Report-' + currentDate + '.pdf';

                doc.save(fileName);
            };
        });
    });
</script>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/composition_report/occurrence_report.blade.php ENDPATH**/ ?>