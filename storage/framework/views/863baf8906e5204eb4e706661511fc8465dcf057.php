<?php $__env->startSection('content'); ?>
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
            <div class="head_brdcm">
                <ul class="brdcmb">
                    <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                    <li><a href="<?php echo e(route('user.ratio_dashboard')); ?>">Ratio Reports</a></li>
                    <li>Monthly snapshot</li>
                </ul>
            </div>

            <div class="perform_head">
                        <h2>Monthly snapshot</h2>
            </div>

                <section class="monthly_snapshop_sec">
                <a href="<?php echo e(route('user.ratio_dashboard')); ?>" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                    <div class="container">
                        <div class="wm_tab">
                            <ul>
                                <li>
                                    <a href="<?php echo e(route('user.weekly_snapshot_new', ['date' => $to_date])); ?>">Weekly</a>
                                </li>
                                <li>
                                    <a class="active"
                                        href="<?php echo e(route('user.monthly_snapshot_new', ['date' => $to_date])); ?>">Monthly</a>
                                </li>
                            </ul>
                        </div>
                        <div class="light_green_bg month_bg">
                            <form method="GET" action="" id="dateForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form_group">
                                            <input type="date" class="form-control" name="date"
                                                id="dateInput" value="<?php echo e(date('Y-m-d', strtotime($to_date))); ?>">

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="bttn_grp">
                                            <button class="btn btn-success" type="submit">Search</button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <?php if(!empty($message)): ?>
                        <div class="alert alert-warning mt-3">
                            <?php echo e($message); ?>

                        </div>
                        <?php endif; ?>
                        <input type="hidden" value="monthly" name="type" id="type">
                        <div class="fund_section new_fund_section monthly_new">
                            <ul>
                                <li>
                                    <p>Monthly Snapshot Report :</p>
                                    <span><?php echo e(date('d/m/Y', strtotime($from_date))); ?> to <?php echo e(date('d-m-Y', strtotime($to_date))); ?></span>
                                </li>
                            </ul>

                            <div class="share_pdf new-share-pdf">
                                <div class="sharethis-inline-share-buttons" ></div>
                                <a href="javascript:void(0)" id="exportPDF" class="pdf"><img
                                        src="<?php echo e(asset('themes/frontend/assets/infosolz/images/pdf.png')); ?>"></a>

                            </div>
                        </div>
                        <div class="row all_tables" id="pdfData">
                            
                            <?php for($i=1;$i<=3;$i++): ?>
                            <div class="col-md-4">
                                <div class="graph_table green_bg">
                                    <h4><img src="https://myplexus.tech2dev.xyz//themes/frontend/assets/infosolz/images/icon1.png" alt=""><?php if($i==1): ?><?php echo e(' BSE Index'); ?><?php elseif($i==2): ?><?php echo e(' NSE Index'); ?><?php else: ?><?php echo e(' Global & Sectoral Index'); ?><?php endif; ?></h4>
                                    <table class="table bs_ns_gl datatable">
                                        <thead>
                                            <tr>
                                                <th>Indices </th>
                                                <th class="text_center">Closing Value </th>
                                                <th class="text_center">% Change </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if($i==1): ?>
                                            <?php $__currentLoopData = $array_bse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indices_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    
                                                    <td><?php echo e($indices_details->name); ?></td>
                                                    <td class="text_right"><?php echo e(printValue($indices_details->cur_value)); ?></td>
                                                    <td class="text_right"><?php echo e(printValue($indices_details->PER_CHANGE)); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php elseif($i==2): ?>
                                            <?php $__currentLoopData = $array_nse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indices_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    
                                                    <td><?php echo e($indices_details->name); ?></td>

                                                    <td class="text_right"><?php echo e(printValue($indices_details->cur_value)); ?></td>
                                                    <td class="text_right"><?php echo e(printValue($indices_details->PER_CHANGE)); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <?php $__currentLoopData = $array_global_it; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indices_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    

                                                    <td><?php echo e($indices_details->name); ?></td>

                                                    <td class="text_right"><?php echo e(printValue($indices_details->cur_value)); ?></td>
                                                    <td class="text_right"><?php echo e(printValue($indices_details->PER_CHANGE)); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php endfor; ?>
                            <div class="col-md-4">
                                <div class="graph_table sky_bg">
                                    <h4><img src="https://myplexus.tech2dev.xyz//themes/frontend/assets/infosolz/images/icon2.png" alt=""> Currency Changes</h4>
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th>Currency </th>
                                                <th class="text_center">₹ </th>
                                                <th class="text_center">% Change </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $changes_currency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curr_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($curr_details->name); ?></td>
                                                    <td class="text_right"><?php echo e(printValue($curr_details->cur_value)); ?></td>
                                                    <td class="text_right"><?php echo e(printValue($curr_details->PER_CHANGE)); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="graph_table yellow_bg">
                                    <h4><img src="https://myplexus.tech2dev.xyz//themes/frontend/assets/infosolz/images/icon3.png" alt=""> Commodity Changes</h4>
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th>Commodity </th>
                                                <th class="text_center">₹ </th>
                                                <th class="text_center">% Change </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $changes_commodity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commodity_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($commodity_details->name); ?></td>
                                                    <td class="text_right"><?php echo e(printValue($commodity_details->cur_value)); ?></td>
                                                    <td class="text_right"><?php echo e(printValue($commodity_details->PER_CHANGE)); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="graph_table orange_bg">
                                    <h4><img src="https://myplexus.tech2dev.xyz//themes/frontend/assets/infosolz/images/icon4.png" alt=""> Percentage Change by Category of Funds(Returns)</h4>
                                    <div class="">
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th>Fund Category </th>
                                                <th class="text_center">% Change(Returns)</th>
                                                <th class="text_center">Median </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $monthly_benchmark; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benchmark_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td class="open_popup" FundTypeID="<?php echo e($benchmark_details->FundTypeID); ?>"><?php echo e($benchmark_details->FUNDTYPE); ?></td>
                                                    <td class="text_right"><?php echo e(printValue($benchmark_details->CHANGEVALUE_NEW)); ?></td>
                                                    <td class="text_right"><?php echo e(printValue($benchmark_details->MEDIANVAL_NEW)); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                    </div>
                                    

                                    

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="graph_table blue_bg">
                                    <h4><img src="https://myplexus.tech2dev.xyz//themes/frontend/assets/infosolz/images/icon5.png" alt=""> 10 Best Performing Schemes</h4>
                                    <div class="">
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th>Scheme Name </th>
                                                <th>Category</th>
                                                <th class="text_center">Return % </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $best_schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scheme_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($scheme_details->fund_name); ?></td>
                                                    <td><?php echo e($scheme_details->name); ?></td>
                                                    <td class="text_right"><?php echo e(printValue($scheme_details->monthly_change)); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="popup-overlay"></div>
                                    <div class="table_popup">
                                        <div class="graph_table">
                                            <h4>Fund Changes</h4>
                                            <div class="table_overflow table_height">
                                                <table class="table pop_up_datatable">
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
                </section>

                <?php if(isset($changes_currency)): ?>
                <div class="disclaimer">
                    <p><strong>Disclaimer : </strong><?php echo e($disclaimer); ?></p>
                </div>
           
                    
            <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<style>
.new-share-pdf{
    top:0 !important;
}
</style>


<Script>

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
            doc.text('Monthly Snapshot', pageWidth / 2, 35, { align: 'center' });

            doc.setFontSize(12);
            doc.setTextColor(0, 0, 0);
            doc.text('Monthly Snapshot Report :', 15, 50);
            doc.text(`<?php echo e(date('d/m/Y', strtotime($from_date))); ?> to <?php echo e(date('d-m-Y', strtotime($to_date))); ?>`, 15, 55);

            var yPosition = 70;

            // 1. BSE, NSE, Global and Sectoral Index (Separate Tables)
            <?php if($array_bse): ?>
                doc.text('BSE Index', 15, yPosition);
                yPosition += 10;
                var bseData = [];
                <?php $__currentLoopData = $array_bse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indices_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    bseData.push(['<?php echo e($indices_details->name); ?>', '<?php echo e(printValue($indices_details->cur_value)); ?>', '<?php echo e(printValue($indices_details->PER_CHANGE)); ?>']);
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                // Sort BSE Data (you can change the sorting criteria as needed)
                bseData.sort((a, b) => a[1] - b[1]); // Sorting by closing value
                doc.autoTable({
                    head: [['BSE Indices', 'Closing Value', '% Change']],
                    body: bseData,
                    startY: yPosition,
                    headStyles: { fillColor: [45, 135, 23] },
                });
                yPosition = doc.lastAutoTable.finalY + 10;
            <?php endif; ?>

            <?php if($array_nse): ?>
                doc.text('NSE Index', 15, yPosition);
                yPosition += 10;
                var nseData = [];
                <?php $__currentLoopData = $array_nse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indices_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    nseData.push(['<?php echo e($indices_details->name); ?>', '<?php echo e(printValue($indices_details->cur_value)); ?>', '<?php echo e(printValue($indices_details->PER_CHANGE)); ?>']);
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                // Sort NSE Data
                nseData.sort((a, b) => a[1] - b[1]);
                doc.autoTable({
                    head: [['NSE Indices', 'Closing Value', '% Change']],
                    body: nseData,
                    startY: yPosition,
                    headStyles: { fillColor: [45, 135, 23] },
                });
                yPosition = doc.lastAutoTable.finalY + 10;
            <?php endif; ?>

            <?php if($array_global_it): ?>
                doc.text('Global & Sectoral Index', 15, yPosition);
                yPosition += 10;
                var globalData = [];
                <?php $__currentLoopData = $array_global_it; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indices_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    globalData.push(['<?php echo e($indices_details->name); ?>', '<?php echo e(printValue($indices_details->cur_value)); ?>', '<?php echo e(printValue($indices_details->PER_CHANGE)); ?>']);
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                // Sort Global Data
                globalData.sort((a, b) => a[1] - b[1]);
                doc.autoTable({
                    head: [['Global/Sectoral Indices', 'Closing Value', '% Change']],
                    body: globalData,
                    startY: yPosition,
                    headStyles: { fillColor: [45, 135, 23] },
                });
                yPosition = doc.lastAutoTable.finalY + 10;
            <?php endif; ?>

            // Continue with the rest of your tables in a similar fashion
            // For Currency Changes
            <?php if($changes_currency): ?>
                doc.text('Currency Changes', 15, yPosition);
                yPosition += 10;
                var currencyData = [];
                <?php $__currentLoopData = $changes_currency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curr_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    currencyData.push(['<?php echo e($curr_details->name); ?>', '<?php echo e(printValue($curr_details->cur_value)); ?>', '<?php echo e(printValue($curr_details->PER_CHANGE)); ?>']);
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                // Sort Currency Data
                currencyData.sort((a, b) => a[1] - b[1]);
                doc.autoTable({
                    head: [['Currency', '₹', '% Change']],
                    body: currencyData,
                    startY: yPosition,
                    headStyles: { fillColor: [45, 135, 23] },
                });
                yPosition = doc.lastAutoTable.finalY + 10;
            <?php endif; ?>


            // 5. Commodity Changes
            doc.text('Commodity Changes', 15, yPosition);
            yPosition += 10;
            var commodityData = [];
            <?php $__currentLoopData = $changes_commodity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commodity_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                commodityData.push(['<?php echo e($commodity_details->name); ?>', '<?php echo e(number_format($commodity_details->cur_value, 2)); ?>', '<?php echo e(number_format($commodity_details->PER_CHANGE, 2)); ?>']);
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            doc.autoTable({
                head: [['Commodity', '₹', '% Change']],
                body: commodityData,
                startY: yPosition,
                headStyles: { fillColor: [45, 135, 23] },
            });
            yPosition = doc.lastAutoTable.finalY + 10;

            // 6. Percentage Change by Category of Funds
            doc.text('Percentage Change by Category of Funds (Returns)', 15, yPosition);
            yPosition += 10;
            var benchmarkData = [];
            <?php $__currentLoopData = $monthly_benchmark; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benchmark_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                benchmarkData.push(['<?php echo e($benchmark_details->FUNDTYPE); ?>', '<?php echo e(number_format($benchmark_details->CHANGEVALUE, 2)); ?>', '<?php echo e(number_format($benchmark_details->MEDIANVAL, 2)); ?>']);
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            doc.autoTable({
                head: [['Fund Category', '% Change (Returns)', 'Median']],
                body: benchmarkData,
                startY: yPosition,
                headStyles: { fillColor: [45, 135, 23] },
            });
            yPosition = doc.lastAutoTable.finalY + 10;

            // 7. 10 Best Performing Schemes
            doc.text('10 Best Performing Schemes', 15, yPosition);
            yPosition += 10;
            var schemeData = [];
            <?php $__currentLoopData = $best_schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scheme_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                schemeData.push(['<?php echo e($scheme_details->fund_name); ?>', '<?php echo e($scheme_details->name); ?>', '<?php echo e(number_format($scheme_details->monthly_change, 2)); ?>']);
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            doc.autoTable({
                head: [['Scheme Name', 'Category', 'Return %']],
                body: schemeData,
                startY: yPosition,
                headStyles: { fillColor: [45, 135, 23] },
            });
            yPosition = doc.lastAutoTable.finalY + 10;

            // And so on for the other data tables...

            // Save the document
            var currentDate = new Date();
            var fileName = 'Monthly-Snapshot-' + currentDate + '.pdf';
            doc.save(fileName);
        };
    });
});





</Script>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/ratio-reports/monthly_snapshot_new.blade.php ENDPATH**/ ?>