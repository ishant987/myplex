<?php $__env->startSection('content'); ?>
    <?php
        $selectedIndexValue = is_array($indices_name ?? null) ? ($indices_name[0] ?? '') : ($indices_name ?? '');
    ?>
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                        <li><a href="<?php echo e(route('user.indices_report')); ?>">indices report</a></li>
                        <li>Indices Composition</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>

                    <div class="light_green_bg">
                        <form action="">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <select class="select2" name="indices" data-placeholder="Select Indices">
                                            <option value="">Select Indices</option>
                                            <?php $__currentLoopData = $indices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($index->corelation); ?>"
                                                    <?php if($selectedIndexValue !== '' && $index->corelation == $selectedIndexValue): ?> selected <?php endif; ?>><?php echo e($index->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                

                                <?php echo $__env->make('web.layout.includes.year_month', [
                                    'yearFieldName' => 'year',
                                    'monthFieldName' => 'month',
                                    'selectedYear' => $year ?? '',
                                    'selectedMonth' => $month ?? '',
                                    'size' => 3,
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <div class="col-md-2">
                                    <div class="bttn_grp">
                                        <button type="submit" id="classification">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php if(isset($indices_composition)): ?>
                        <div class="fund_section new_fund_section">
                            <ul>
                                <li>
                                    <p>Benchmark :</p>
                                    <span><?php echo e($selectedIndexValue); ?></span>
                                </li>
                                <li>
                                    <p>Indices Composition : </p>
                                    <?php if(isset($year) && isset($month)): ?>
                                        <span>For the Month of <?php echo e(date('F', mktime(0, 0, 0, $month, 1, $year))); ?>,
                                            <?php echo e($year); ?></span>
                                    <?php endif; ?>

                                </li>
                            </ul>
                        </div>

                        <div class="graph_table">
                            <div class="share_pdf">
                                    
                                <div class="sharethis-inline-share-buttons" ></div>
                                <a href="javascript:void(0)" id="exportPDF-indices-composition" class="pdf"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/pdf.png')); ?>" ></a>
                                
                            </div>
                            <table class="table datatable" id="pdfData-indices-composition">
                                <thead>
                                    <tr>
                                        <th>name of the scrip</th>
                                        <th>type</th>
                                        <th>industry</th>
                                        <th class="text_center">percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($indices_composition)): ?>
                                        <?php $__currentLoopData = $indices_composition; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($item['scrip_name']); ?></td>
                                                <td><?php echo e($item['type']); ?></td>
                                                <td><?php echo e($item['industry']); ?></td>
                                                <td class="text_right"><?php echo e(number_format($item['percentage'], 2)); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>

                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="graph_section">
                            <p style="text-align: center;">Please search above to show the results</p>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if(isset($indices_composition)): ?>
                <div class="disclaimer">
                    <p><strong>Disclaimer : </strong><?php echo e($disclaimer); ?></p>
                </div>
              <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<script>
    document.addEventListener('DOMContentLoaded', function() 
    {
        var exportButton = document.getElementById('exportPDF-indices-composition');

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
                doc.text('Indices Composition', pageWidth / 2, 35, { align: 'center' });

                doc.setFontSize(12);
                doc.setTextColor(0, 0, 0);

                // Add the benchmark name
                var benchmarkName = "<?php echo e($selectedIndexValue); ?>";
                doc.text(`Benchmark: ${benchmarkName}`, 15, 50);

                // Add the date (Month and Year)
                <?php if(isset($month) && isset($year)): ?>
                    var compositionDate = `For the Month of <?php echo e(date('F', mktime(0, 0, 0, $month, 1))); ?>, <?php echo e($year); ?>`;
                    // doc.text(compositionDate, 15, 60);
                    doc.text(`Indices Composition: ${compositionDate}`, 15, 60);
                <?php endif; ?>

                var yPosition = 70;

                
                var table = document.getElementById('pdfData-indices-composition');
                var tableData = [];

                table.querySelectorAll('tbody tr').forEach(function(row) {
                    var rowData = [];
                    row.querySelectorAll('td').forEach(function(cell) {
                        rowData.push(cell.innerText);
                    });
                    tableData.push(rowData);
                });

                doc.autoTable({
                    head: [['Name Of The Scrip', 'Type', 'Industry', 'Percentage']],
                    body: tableData,
                    startX: 15,
                    startY: yPosition + 10,
                    headStyles: { fillColor: [45, 135, 23] },
                    columnStyles: {
                        3: { halign: 'right' }
                    }
                });

                var currentDate = new Date();
                // var fileName = 'Indices-Composition-' + currentDate.toISOString().split('T')[0] + '.pdf';
                var fileName = 'Indices-Composition-' + currentDate + '.pdf';
            
                doc.save(fileName);
            };
        });
    });
</script>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/indices-reports/indices-composition.blade.php ENDPATH**/ ?>