<?php $__env->startSection('content'); ?>

    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                        <li><a href="<?php echo e(route('user.composition_report')); ?>">composition report</a></li>
                        <li>Composition<br> Allocation Snapshot</li>
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
                                

                                
                                <div class="col-md-6 div_show_1">
                                    <div class="form_group">
                                        <select name="fund_type" id="fund_type" class="select2"
                                            data-placeholder="Select Fund Category">
                                            <option value="">Select Fund Classification</option>
                                            <?php if(isset($fund_type)): ?>
                                                <?php $__currentLoopData = $fund_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($val->ft_id); ?>"
                                                        <?php echo e(isset($fund_type_id) && $fund_type_id == $val->ft_id ? 'selected' : ''); ?>>
                                                        <?php echo e($val->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 div_hide_1">
                                    <div class="form_group multiple_select">
                                        <select name="fund_id[]" class="select2 multiple" multiple
                                            id="allocation_select_fund" data-max="2"
                                            onchange ='set_fund_select_val(this.value)'>
                                            <option value="">Select Fund</option>
                                            <?php if(isset($fund_master)): ?>
                                                <?php $__currentLoopData = $fund_master; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($val->fund_id); ?>"
                                                        <?php if(isset($fund_details) && is_array($fund_details) && in_array($val->fund_id, array_column($fund_details, 'fund_id'))): ?> selected <?php endif; ?>>
                                                        <?php echo e($val->fund_name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
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
                                <div class="col-md-12">
                                    <div class="bttn_grp">
                                        

                                        

                                        <button type="submit" id="submit_btn">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php if(isset($monthName) && isset($year) && isset( $request->Category)): ?>
                    <div class="fund_section new_fund_section">
                        <ul>
                            <li>
                                <p>Composition Allocation Snapshot :</p>
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
                   
                        <div class="graph_table allo_data">
                            <div class="share_pdf">
                                
                                <div class="sharethis-inline-share-buttons" ></div>
                                <a href="javascript:void(0)" id="exportPDF" class="pdf"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/pdf.png')); ?>" ></a>
                                
                            </div>
                            <!-- <table class="table allo">
                                <thead>
                                    <tr>
                                        <th colspan=""></th>
                                        <th colspan="" class="text_center">Equity</th>
                                        <th colspan=""></th>
                                    </tr>
                                </thead>

                            </table> -->
                            <table class="table datatable"  id="pdfData">

                                <thead>
                                    <tr>
                                        <th colspan="4"></th>
                                        <th colspan="4" class="text_center">Equity</th>
                                        <th colspan="2"></th>
                                    </tr>
                                    <tr>
                                        <td class="text_left">Name of the Fund</td>
                                        <td class="text_center">Cash %</td>
                                        <td class="text_center">SOV %</td>
                                        <td class="text_center">Corp debt %</td>
                                        <td class="text_center">Small cap %</td>
                                        <td class="text_center">Mid cap %</td>
                                        <td class="text_center">Large cap %</td>
                                        <td class="text_center">Very large cap %</td>
                                        <td class="text_center">Others</td>
                                        <td class="text_center">Wt. PE</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    
                                    <?php if(isset($fund_snapshot)): ?>
                                    <?php $__currentLoopData = $fund_snapshot; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="text_left"><?php echo e($item['fund_name']); ?></td>
                                            <td class="text_right"><?php echo e($item['cash']); ?></td>
                                            <td class="text_right"><?php echo e($item['sov']); ?></td>
                                            <td class="text_right"><?php echo e($item['debt']); ?></td>
                                            <td class="text_right"><?php echo e($item['eq_small']); ?></td>
                                            <td class="text_right"><?php echo e($item['eq_mid']); ?></td>
                                            <td class="text_right"><?php echo e($item['eq_large']); ?></td>
                                            <td class="text_right"><?php echo e($item['eq_very_large']); ?></td>
                                            <td class="text_right"><?php echo e($item['others_val']); ?></td>
                                            <td class="text_right"><?php echo e($item['wt_pe']); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="9">No information available for this search</td>
                                    </tr>
                                    <?php endif; ?>

                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <?php echo printNoData(); ?>

                    <?php endif; ?>
                </div>
                <?php if(isset($fund_snapshot)): ?>

                


                <div class="disclaimer">
                    <p><strong>Disclaimer : </strong><?php echo e($disclaimer); ?></p>
                    <div class="all_note" style="
                    padding-left: 16px;
                ">
                    <ul>
                        <li>For loss making scrips, earnings are considered as zero.</li>
                        <li>Loss Making Scrips have not been taken into account for calculation of total fund portfolio weighted PE.</li>
                        <li>Equity Mutual Fund and ETF are added to Others.</li>
                        <li>P/E Ratio (TTM) is considered for calculating weighted PE.</li>

                      </ul>
                    </div>
                </div>
           
                    
            <?php endif; ?>
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




    document.addEventListener('DOMContentLoaded', function() {
    var exportButton = document.getElementById('exportPDF');

    exportButton.addEventListener('click', function() {
        var { jsPDF } = window.jspdf;
        var doc = new jsPDF();

        // Load logo image
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
            doc.text('Alloction Snaoshot', pageWidth / 2, 35, { align: 'center' });

            var startX = 15;
            var lineHeight = 10;
            var yPosition = 70;

            var monthName = "<?php echo e(isset($monthName) ? $monthName : ''); ?>";
            var year = "<?php echo e(isset($year) ? $year : ''); ?>";

            if (monthName && year) {
                doc.setFontSize(12);
                doc.setTextColor(0, 0, 0);
                doc.text('Composition Allocation Snapshot:', startX, yPosition);
                doc.text('For the month of ' + monthName + ', ' + year, startX + 100, yPosition);
                yPosition += lineHeight;
            }

            <?php if(isset($request) && $request->Category == 'by_category'): ?>
                var fundClassification = "<?php echo e(isset($fund_type_name) ? $fund_type_name[0] : ''); ?>";
                if (fundClassification) {
                    doc.text('Fund Classification:', startX, yPosition);
                    doc.text(fundClassification, startX + 100, yPosition);
                    yPosition += lineHeight;
                }
            <?php endif; ?>

            <?php if(isset($request) && $request->Category == 'by_fund'): ?>
                var fundNames = "<?php echo e(isset($fund_names) ? $fund_names : ''); ?>";
                if (fundNames) {
                    doc.text('Fund Name:', startX, yPosition);
                    doc.text(fundNames, startX + 100, yPosition);
                    yPosition += lineHeight;
                }
            <?php endif; ?>

            var table = new DataTable('#pdfData');
            var tableData = [];
            table.rows({ search: 'applied' }).data().each(function(row) {
                tableData.push(row);
            });

            doc.autoTable({
                head: [
                    [
                        { content: '', colSpan: 4 },
                        { content: 'Equity', colSpan: 4, styles: { halign: 'center' } },
                        { content: '', colSpan: 2 }
                    ],
                    [
                        { content: 'Name of the Fund', styles: { halign: 'left' } },
                        { content: 'Cash %', styles: { halign: 'center' } },
                        { content: 'SOV %', styles: { halign: 'center' } },
                        { content: 'Corp debt %', styles: { halign: 'center' } },
                        { content: 'Small cap %', styles: { halign: 'center' } },
                        { content: 'Mid cap %', styles: { halign: 'center' } },
                        { content: 'Large cap %', styles: { halign: 'center' } },
                        { content: 'Very large cap %', styles: { halign: 'center' } },
                        { content: 'Others', styles: { halign: 'center' } },
                        { content: 'Wt. PE', styles: { halign: 'center' } }
                    ]
                ],
                body: tableData,
                startX: startX,
                startY: yPosition + 10,
                headStyles: { fillColor: [45, 135, 23], textColor: [255, 255, 255] },
                styles: { halign: 'center' }
            });

            // Save the PDF with a generated filename
            var currentDate = new Date();
            var fileName = 'Alloction-Snaoshot-' + currentDate + '.pdf';
            doc.save(fileName);
        };
    });
});



</script>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/composition_report/allocation_snapshot.blade.php ENDPATH**/ ?>