<?php $__env->startSection('content'); ?>

    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                        <li><a href="<?php echo e(route('user.ratio_analysis')); ?>"> Ratio Analysis</a></li>
                        <li>Sortino Ratio</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                    <?php
                        $selectedSortinoFundIds = collect((array) ($fund_id ?? request()->input('fund_id', [])))
                            ->map(fn ($id) => (int) $id)
                            ->all();
                        $selectedSortinoCategory = (string) request()->input('Category', '');
                        $selectedSortinoReportCategory = (string) request()->input('report_category', '');
                        $selectedSortinoMar = (string) request()->input('limit', '');
                        $selectedSortinoTimeFrame = (string) request()->input('as_on_time_frame', '');
                        $showSortinoResults = isset($request, $start_date, $end_date)
                            && $selectedSortinoCategory !== ''
                            && $selectedSortinoReportCategory !== '';
                    ?>

                    <div class="light_green_bg">
                        <form method="GET" action="">
                            <input type="hidden" name="quartile_set" id="quartile_set"
                                value="<?php echo e(isset($quartile_set) ? $quartile_set : 'quartile'); ?>">

                            <div class="row">
                                
                                <input type="hidden" name="ranking" value="range">

                                <div class="col-md-6">
                                    <div class="row date_sec">
                                        <label>Starting period</label>
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <select class="select2" name="month" id="month" required data-placeholder="Select month">
                                                    <option value="">select month</option>
                                                    <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($m); ?>"
                                                            <?php echo e(isset($month) && $month == $m ? 'selected' : ''); ?>>
                                                            <?php echo e(date('F', mktime(0, 0, 0, $m, 10))); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $__errorArgs = ['month'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="alert alert-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <select class="select2" name="year" id="year" required onchange="get_second_month_year()" data-placeholder="Select Year">
                                                    <option value="">select year</option>
                                                    <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option
                                                            value="<?php echo e($y); ?>"<?php echo e(isset($year) && $year == $y ? 'selected' : ''); ?>>
                                                            <?php echo e($y); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $__errorArgs = ['year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="alert alert-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row date_sec">
                                        <label>Ending period</label>
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <select class="select2" name="month_second" id="month_second" required
                                                    onchange="get_second_period(this.value)" data-placeholder="Select Month">
                                                    <option value="">select month</option>
                                                    <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($m); ?>"
                                                            <?php echo e(isset($month_second) && $month_second == $m ? 'selected' : ''); ?>>
                                                            <?php echo e(date('F', mktime(0, 0, 0, $m, 10))); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $__errorArgs = ['month_second'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="alert alert-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <select class="select2" name="year_second" id="year_second" required data-placeholder="Select Year">
                                                    <option value="">select year</option>
                                                    <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option
                                                            value="<?php echo e($y); ?>"<?php echo e(isset($year_second) && $year_second == $y ? 'selected' : ''); ?>>
                                                            <?php echo e($y); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $__errorArgs = ['year_second'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="alert alert-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                

                                
                                             
                                
                                <input type="hidden" name="Category" id="fund_Category" value="by_fund">


                                <div class="col-md-4">
                                    <div class="form_group">
                                        <select name="fund_id[]" class="select2 multiple" multiple
                                            id="allocation_select_fund" onchange ='set_fund_select_val(this.value)' data-placeholder="Select Fund">
                                            <option value=""></option>
                                            <?php $__currentLoopData = $all_funds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($fund->fund_id); ?>"
                                                    <?php echo e(in_array((int) $fund->fund_id, $selectedSortinoFundIds, true) ? 'selected' : ''); ?>>
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
                                    <span class="text-danger" id="fund_msgg"></span>
                                </div>

                                

                                <input type="hidden" name="report_category" value="sortino">

                                <div class="col-md-4">
                                    <div class="form_group">
                                        <input type="number" name="limit" placeholder="Annual minimum Acceptable Rate (in %) " value="<?php echo e(isset($request->limit)?$request->limit:''); ?>">

                                        <?php $__errorArgs = ['limit'];
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
                                        <button type="submit" id="submit_btn">Search</button>
                                        <!-- <button type="submit" name="submit" value="search_by_fund">show by fund</button> -->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>



                    <?php if($showSortinoResults): ?>
                        <div class="fund_section new_fund_section">
                            <ul>
                                <li>
                                    <p>Start Month & Year :</p>
                                    <span><?php echo e(isset($start_date) ? date('F, Y', strtotime($start_date)) : '00/00/0000'); ?></span>
                                </li>
                                <li>
                                    <p>End Month & Year :</p>
                                    <span><?php echo e(isset($end_date) ? date('F, Y', strtotime($end_date)) : '00/00/0000'); ?></span>
                                </li>



                                <li>
                                    <p>By Ratio :</p>

                                    <span>
                                        <?php if($selectedSortinoReportCategory === 'sortino'): ?>
                                            <?php echo e('Sortino'); ?>

                                        <?php elseif($selectedSortinoReportCategory === 'upside_potential'): ?>
                                            <?php echo e('Upside Potential'); ?>

                                        <?php elseif($selectedSortinoReportCategory === 'downside_risk'): ?>
                                            <?php echo e('Downside Risk'); ?>

                                        <?php endif; ?>
                                    </span>
                                </li>

                                <?php if(!empty($as_on_time_frame_data)): ?>
                                    <li>
                                        <p>Duration :</p>
                                        <span>
                                            <?php if($selectedSortinoTimeFrame === '1_month'): ?>
                                                <?php echo e('1 Month'); ?>

                                            <?php elseif($selectedSortinoTimeFrame === '3_months'): ?>
                                                <?php echo e('3 Month'); ?>

                                            <?php elseif($selectedSortinoTimeFrame === '6_months'): ?>
                                                <?php echo e('6 Month'); ?>

                                            <?php elseif($selectedSortinoTimeFrame === '1_year'): ?>
                                                <?php echo e('1 Year'); ?>

                                            <?php elseif($selectedSortinoTimeFrame === '2_year'): ?>
                                                <?php echo e('2 Year'); ?>

                                            <?php elseif($selectedSortinoTimeFrame === '3_years'): ?>
                                                <?php echo e('3 Years'); ?>

                                            <?php elseif($selectedSortinoTimeFrame === '5_years'): ?>
                                                <?php echo e('5 Years'); ?>

                                            <?php endif; ?>
                                        </span>
                                    </li>
                                <?php endif; ?>

                                <?php if($selectedSortinoMar !== ''): ?>
                                    <li>
                                        <p>Minimum Acceptable Rate (in %)  :</p>
                                        <span><?php echo e($selectedSortinoMar); ?></span>
                                    </li>
                                <?php endif; ?>

                                <?php if($selectedSortinoCategory === 'by_category'): ?>
                                <li>
                                    <p>fund classification :</p>
                                    <span><?php echo e(isset($fund_type_name) ? $fund_type_name : ''); ?></span>
                                </li>
                            <?php endif; ?>

                                <?php if($selectedSortinoCategory === 'by_fund'): ?>
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
                            <table class="table datatable"  id="pdfData">
                                <thead>
                                    <tr>
                                        <th class="text_left">Fund Name</th>
                                        <th class="text_center">Upside Potential</th>
                                        <th class="text_center">Downside Risk</th>
                                        <th class="text_center">Sortino Ratio</th>
                                        <th class="text_center">Rank</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sortedFundReturns = [];
                                        $ranks = [];
                                    ?>
                                    <?php if(isset($stat_result['fund_absolute_return']) && count($stat_result['fund_absolute_return']) > 0): ?>
                                    <?php
                                        $fundReturns = $stat_result['fund_absolute_return'];

                                        // $sortedFundReturns = collect($fundReturns)->sortDesc()->toArray();

                                        // dd($fundReturns);

                                        arsort($fundReturns);

                                        // Convert the sorted array to a collection if needed
                                        $sortedFundReturns = collect($fundReturns)->toArray();

                                        $ranks = [];

                                        $rank = 1;
                                        foreach ($sortedFundReturns as $key => $value) {

                                            if ($value === 'N/A' || $value === '') {
                                                
                                                $ranks[$key] = 'N/A';
                                            }else{
                                                $ranks[$key] = $rank++;
                                            }
                                          
                                        }

                                        // dd($fundReturns);

                                    ?>
                                    <?php endif; ?>

                                    <?php if(!empty($fund_all_return) && !empty($sortedFundReturns)): ?>
                                        <?php $__currentLoopData = $sortedFundReturns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fundId => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="text_left">
                                                    <?php echo e(getNameTable('fund_master', 'fund_name', 'fund_id', $fundId)); ?></td>
                                                <td class="text_right">
                                                    <?php echo e(printValue($fund_all_return[$fundId]['upside_potential'])); ?></td>
                                                <td class="text_right">
                                                    <?php echo e(printValue($fund_all_return[$fundId]['downside_risk'])); ?></td>
                                                <td class="text_right"><?php echo e(printValue($value)); ?></td>
                                                <td class="text_right"><?php echo e(printRank($ranks[$fundId] ?? 'N/A')); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5">No records found</td>
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

<?php
    $sortinoPdfRatio = match ($selectedSortinoReportCategory ?? null) {
        'sortino' => 'Sortino',
        'upside_potential' => 'Upside Potential',
        'downside_risk' => 'Downside Risk',
        default => '',
    };

    $sortinoPdfDuration = '';
    if (!empty($as_on_time_frame_data) && $selectedSortinoTimeFrame !== '') {
        $sortinoPdfDuration = match ($selectedSortinoTimeFrame) {
            '1_month' => '1 Month',
            '3_months' => '3 Months',
            '6_months' => '6 Months',
            '1_year' => '1 Year',
            '2_year' => '2 Years',
            '3_years' => '3 Years',
            '5_years' => '5 Years',
            default => '',
        };
    }
?>

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

    function get_second_month_year() {
    var firstYear = parseInt($('#year').val());
    var firstMonth = parseInt($('#month').val());
    var currentYear = new Date().getFullYear();
    var currentMonth = new Date().getMonth() + 1; // getMonth returns 0-indexed month

    if (isNaN(firstMonth)) {
        $('#month_second').html('<option value="">Please select the first period month</option>');
        $('#year_second').html('<option value="">Please select the first period year</option>');
        return;
    }

    var monthOptions = '';
    var yearOptions = '';

    var startMonth = firstMonth + 5;
    if (startMonth > 12) {
        startMonth = startMonth - 12;
        firstYear += 1; 
    }

    // Generate year options
    for (var y = firstYear; y <= firstYear + 3 && y <= currentYear; y++) {
        yearOptions += '<option value="' + y + '">' + y + '</option>';
    }

    $('#year_second').html(yearOptions);

    // Generate month options based on selected year
    $('#year_second').change(function() {
        var selectedYear = parseInt($('#year_second').val());
        monthOptions = '';
        if (selectedYear > firstYear) {
            for (var m = 1; m <= (selectedYear == currentYear ? currentMonth : 12); m++) {
                monthOptions += '<option value="' + m + '">' + getMonthName(m) + '</option>';
            }
        } else {
            for (var m = startMonth; m <= 12; m++) {
                monthOptions += '<option value="' + m + '">' + getMonthName(m) + '</option>';
            }
        }
        $('#month_second').html(monthOptions);
    });

    $('#year_second').trigger('change');
}

function get_second_period(selectedMonth) {
    var firstMonth = parseInt($('#month').val());
    var firstYear = parseInt($('#year').val());

    if (isNaN(firstYear) || isNaN(firstMonth)) {
        $('#year_second').html('<option value="">Please select the first period</option>');
        return;
    }

    var currentYear = new Date().getFullYear();
    var yearOptions = '';

    for (var y = firstYear; y <= firstYear + 3 && y <= currentYear; y++) {
        yearOptions += '<option value="' + y + '">' + y + '</option>';
    }

    $('#year_second').html(yearOptions);
}

function getMonthName(monthNumber) {
    var monthNames = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];
    return monthNames[monthNumber - 1];
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
            doc.text('Sortino Ratios', pageWidth / 2, 35, { align: 'center' });

            doc.setFontSize(12);
            doc.setTextColor(0, 0, 0);

            var startX = 15;
            var yPosition = 70;

            // Extracted values from the provided HTML structure
            var startDate = "<?php echo e(isset($start_date) ? date('F, Y', strtotime($start_date)) : '00/00/0000'); ?>";
            var endDate = "<?php echo e(isset($end_date) ? date('F, Y', strtotime($end_date)) : '00/00/0000'); ?>";
            
            var ratio = <?php echo json_encode($sortinoPdfRatio, 15, 512) ?>;

            var duration = <?php echo json_encode($sortinoPdfDuration, 15, 512) ?>;

            var fundClassification = "<?php echo e(isset($fund_type_name) ? $fund_type_name : ''); ?>";
            var fundNames = "<?php echo e(isset($fund_names) ? $fund_names : ''); ?>";
            var minimumAcceptableRate = <?php echo json_encode($selectedSortinoMar, 15, 512) ?>;

            // Add data to the PDF
            doc.text('Start Month & Year: ' + startDate, startX, yPosition);
            doc.text('End Month & Year: ' + endDate, startX + 100, yPosition);
            yPosition += 10;

            doc.text('By Ratio: ' + ratio, startX, yPosition); // Left side
            if (minimumAcceptableRate !== '') {
                doc.text('Minimum Acceptable Rate (in %): ' + minimumAcceptableRate, startX + 100, yPosition); // Right side
            }
            yPosition += 10;

            if (fundNames !== '') {
                var wrappedFundNames = doc.splitTextToSize(fundNames, 180); // 180 defines the max width of text before breaking
                doc.text('Fund Name:', startX, yPosition);
                yPosition += 10;
                doc.text(wrappedFundNames, startX, yPosition);  // Write the wrapped text
                yPosition += (wrappedFundNames.length * 7); // Adjust yPosition based on the number of lines
            }

            

            // Add table data (example from your DataTable logic)
            var table = new DataTable('#pdfData');
            var tableData = [];
            table.rows({ search: 'applied' }).data().each(function(row) {
                tableData.push(row);
            });

            doc.autoTable({
                head: [['Fund Name', 'Upside Potential','Downside Risk','Sortino Ratio', 'Rank']],
                body: tableData,
                startX: startX,
                startY: yPosition + 10,
                headStyles: { fillColor: [45, 135, 23] }
            });

            var currentDate = new Date();
            var fileName = 'Sortino-Ratios-' + currentDate + '.pdf';

            doc.save(fileName);
        };
    });
});


</script>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/auth/ratio_analysis/sortino_ratio.blade.php ENDPATH**/ ?>