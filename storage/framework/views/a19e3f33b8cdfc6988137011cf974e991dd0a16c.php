<?php $__env->startSection('content'); ?>

    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                        <li><a href="<?php echo e(route('user.composition_report')); ?>">composition report</a></li>
                        <li>Scheme Portfolio</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>

                    <div class="light_green_bg">
                        <form action="">
                            <div class="row">

                                

                                <div class="col-md-6">
                                    <div class="form_group">
                                        <select name="fund_master" id="fund_master" class="select2">
                                            <option>Select Any Funds</option>
                                            <?php if(isset($fund_master)): ?>
                                                <?php $__currentLoopData = $fund_master; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($val->fund_code); ?>"
                                                        <?php echo e(request()->get('fund_master') == $val->fund_code ? 'selected' : ''); ?>>
                                                        <?php echo e($val->fund_name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <select name="month" id="month" required>
                                            <option value="">select month</option>
                                            <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($m); ?>"
                                                    <?php echo e(isset($month) && $month == $m ? 'selected' : ''); ?>>
                                                    <?php echo e(date('F', mktime(0, 0, 0, $m, 10))); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <select name="year" id="year" required>
                                            <option value="">select year</option>
                                            <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    value="<?php echo e($y); ?>"<?php echo e(isset($year) && $year == $y ? 'selected' : ''); ?>>
                                                    <?php echo e($y); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="bttn_grp">
                                        <button type="submit" name="search" value="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php if(isset($scrips) && count($scrips) > 0): ?>
                        <div class="fund_section new_fund_section">
                            <ul>
                                <li>
                                    <p>AUM of fund(Rs.In Crores):</p>
                                    <span><?php echo e(isset($total_corpus_entry) ? number_format($total_corpus_entry,2): ''); ?></span>
                                </li>

                                <li>
                                    <p>name of Fund :</p>
                                    <span><?php echo e(is_object($fund_details ?? null) ? $fund_details->fund_name : ''); ?></span>
                                </li>
                                <li>
                                    <p>Scheme Portfolio :</p>
                                    <span>For the month of
                                        <?php echo e(isset($month) ? date('F', mktime(0, 0, 0, $month, 10)) : ''); ?>,<?php echo e(isset($year) ? $year : ''); ?></span>
                                </li>
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
                                        <th>Name of the Scrip</th>
                                        <th>industry</th>
                                        <th>category</th>
                                        <th class="text_center">content (%)</th>
                                        <th class="text_center">Amount(Rs.In Crores)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $scrips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="text_left"><?php echo e(isset($val->scrip_name) ? $val->scrip_name : ''); ?>

                                            </td>
                                            <td class="text_left"><?php echo e(isset($val->industry) ? $val->industry : ''); ?></td>
                                            <td class="text_left"><?php echo e(isset($val->category) ? $val->category : ''); ?></td>
                                            <td class="text_right">
                                                <?php echo e(isset($val->content_per) ? printValue($val->content_per) : ''); ?>

                                            </td>

                                            <td class="text_right">
                                                <?php echo e(isset($val->amount) ? printValue($val->amount) : ''); ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>

                        </div>
                    <?php else: ?>
                        <?php echo printNoData(); ?>

                    <?php endif; ?>
                </div>
                <?php if(isset($scrips)): ?>
                <div class="disclaimer">
                    <p><strong>Disclaimer : </strong><?php echo e($disclaimer); ?></p>
                </div>
           
                    
            <?php endif; ?>
            </div>
        </div>

    </div>



<?php $__env->stopSection(); ?>

<script>
    function get_funds(thiss) {

        var fund_type_id = thiss;

        var url = "<?php echo e(route('user.get_funds')); ?>";

        $.ajax({
            type: "GET",
            url: url,
            data: {
                'type_id': fund_type_id
            },
            success: function(response) {

                $('#fund_master').html(response);

            }
        });

    }



document.addEventListener('DOMContentLoaded', function() {
    var exportButton = document.getElementById('exportPDF');

    if (!exportButton) {
        return;
    }

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
            doc.text('Scheme Portfolio', pageWidth / 2, 35, { align: 'center' });

            doc.setFontSize(12);
            doc.setTextColor(0, 0, 0);

            // Fetch dynamic data for AUM, fund name, and scheme portfolio
            var aumFund = "<?php echo e(isset($total_corpus_entry) ? number_format($total_corpus_entry, 2) : ''); ?>";
            var fundName = "<?php echo e(is_object($fund_details ?? null) ? $fund_details->fund_name : ''); ?>";
            var schemePortfolioMonth = "<?php echo e(isset($month) ? date('F', mktime(0, 0, 0, $month, 10)) : ''); ?>";
            var schemePortfolioYear = "<?php echo e(isset($year) ? $year : ''); ?>";

            var startX = 15;
            var yPosition = 70;

            // Adding AUM of fund
            doc.text('AUM of Fund (Rs.In Crores): ' + aumFund, startX, yPosition);
            yPosition += 10;

            // Adding name of the fund
            doc.text('Name of Fund: ' + fundName, startX, yPosition);
            yPosition += 10;

            // Adding scheme portfolio details
            doc.text('Scheme Portfolio: For the month of ' + schemePortfolioMonth + ', ' + schemePortfolioYear, startX, yPosition);
            yPosition += 10;

            // Adding table data (your existing DataTable logic)
            var table = new DataTable('#pdfData');
            var tableData = [];
            table.rows({ search: 'applied' }).data().each(function(row) {
                tableData.push(row);
            });

            doc.autoTable({
                head: [['Fund Name', 'Ratio', 'Rank']],
                body: tableData,
                startX: startX,
                startY: yPosition + 10,
                headStyles: { fillColor: [45, 135, 23] }
            });

            var currentDate = new Date();
            var fileName = 'Scheme-Portfolio-' + currentDate + '.pdf';

            doc.save(fileName);
        };
    });
});


</script>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/composition_report/scheme_portfolio.blade.php ENDPATH**/ ?>