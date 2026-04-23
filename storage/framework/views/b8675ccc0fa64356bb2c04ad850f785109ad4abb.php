<?php $__env->startSection('content'); ?>
    
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
                                <input type="hidden" name="active_tab" value="<?php echo e($active_tab ?? ''); ?>" id="active-tab-input">
                                
                                
                                <div class="col-md-6 div_show_1">
                                    <div class="form_group">
                                        <select name="fund_type" id="fund_type" class="select2"
                                            data-placeholder="Select Fund Classification">
                                            <option value="">Select Fund Classification</option>
                                            <?php if(isset($fund_type)): ?>
                                                <?php $__currentLoopData = $fund_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($val->ft_id); ?>"
                                                        <?php echo e(isset($fund_type_id) && $fund_type_id == $val->ft_id ? 'selected' : ''); ?>>
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
                                    </div>
                                </div>
                                <div class="col-md-6 div_hide_1">
                                    <div class="form_group multiple_select">
                                        <select name="fund_id[]" class="select2 multiple" multiple
                                            id="allocation_select_fund" onchange ='set_fund_select_val(this.value)'
                                            data-placeholder="Select Fund">
                                            <option value="">Select Fund</option>
                                            <?php if(isset($fund_master)): ?>
                                                <?php $__currentLoopData = $fund_master; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($val->fund_id); ?>"
                                                        <?php if(isset($fund_details) && is_array($fund_details) && in_array($val->fund_code, $fund_details)): ?> selected <?php endif; ?>>
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
                    <?php if(isset($top_scrips) && isset($top_industries)): ?>
                        <div class="wm_tab">
                            <ul class="tabs">
                                <li>
                                    <a class="<?php echo e((isset($active_tab) && $active_tab == 'scrip') || is_null($active_tab) ? 'active' : ''); ?>" onclick="switchTab('scrip')">Top Scrip</a>
                                    
                                </li>
                                <li>
                                    <a class="<?php echo e(isset($active_tab) && $active_tab == 'indus' ? 'active' : ''); ?>" onclick="switchTab('indus')">Top Industry</a>
                                    
                                </li>
                            </ul>
                        </div>


                        <div class="tabsct">
                            <div class="tab">
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
                                            <?php if(isset($top_scrips)): ?>
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
                                            <?php endif; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab">
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
                                            <?php if(isset($top_industries)): ?>
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
                <?php if(isset($top_industries)): ?>
                    <div class="disclaimer">
                        <p><strong>Disclaimer : </strong><?php echo e($disclaimer); ?></p>
                    </div>
            </div>
            <?php endif; ?>


            <div class="popup-overlay"></div>
            <div class="table_popup">
                <div class="graph_table">
                    <h4>Fund Changes</h4>
                    <div class="table_overflow table_height">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Fund Name </th>
                                    <th>% Change </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <button class="close_popup"><i class="fa-solid fa-xmark"></i></button>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<script>
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

    function switchTab(tab_name){
        $('#active-tab-input').val(tab_name);
    }







    document.addEventListener('DOMContentLoaded', function() {
    var exportButtonIndustries = document.getElementById('exportPDF-industries');

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
            doc.text('Top Srips', pageWidth / 2, 35, { align: 'center' });
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
            var fileName = 'Top Srips-' + currentDate.toISOString().split('T')[0] + '.pdf';
            doc.save(fileName);
        };
    });
});

// Similar modifications can be made for the "Top Scrips" section.

document.addEventListener('DOMContentLoaded', function() {
    var exportButtonScrips = document.getElementById('exportPDF-scrips');

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
            doc.text('Top Industries', pageWidth / 2, 35, { align: 'center' });
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
            var fileName = 'Top Industries-' + currentDate.toISOString().split('T')[0] + '.pdf';
            doc.save(fileName);
        };
    });
});





</script>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/composition_report/top_script_rop_industry.blade.php ENDPATH**/ ?>