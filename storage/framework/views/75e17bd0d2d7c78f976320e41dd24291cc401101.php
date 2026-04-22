<?php $__env->startSection('content'); ?>
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
            <div class="head_brdcm">
                <ul class="brdcmb">
                    <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                    <li><a href="<?php echo e(route('user.ratio_dashboard')); ?>">Ratio Reports</a></li>
                    <li>Quick Ratio</li>
                </ul>
            </div>

         

                <section class="monthly_snapshop_sec">
                <a href="<?php echo e(route('user.ratio_dashboard')); ?>" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                    <div class="container">
                        <div class="wm_tab">
                            <ul>
                                <li>
                                    <?php 
                                    $currentUrl = url()->current();
                                    ?>
                                    <a href="javascript:void(0)" id="tab-weekly" onclick="tabSelect('weekly')" class="<?php if((isset($request->type) && ($request->type == 'weekly')) || !isset($request->type)): ?> active <?php endif; ?>">Weekly</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" id="tab-monthly" onclick="tabSelect('monthly')" class="<?php if(isset($request->type) && ($request->type == 'monthly')): ?> active <?php endif; ?>">Monthly</a>
                                </li>
                            </ul>
                        </div>
                        <div class="light_green_bg month_bg">
                            <form method="GET" action="" id="dateForm">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form_group">
                                            <input type="date" class="form-control" name="date"
                                                id="dateInput" value="<?php if(isset($request->date) && !empty($request->date)): ?> <?php echo e(\Carbon\Carbon::parse($request->date)->format('Y-m-d')); ?> <?php endif; ?>">

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form_group">
                                            <select name="fund_type_id" class="select2"
                                            data-placeholder="Select Fund Classification">
                                                <option value=""></option>
                                                <?php if($all_fund_types->isEmpty()): ?>
                                                    <option value="" disabled>No fund classifications available</option>
                                                <?php endif; ?>
                                                <?php $__currentLoopData = $all_fund_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fund_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($fund_type->ft_id); ?>"
                                                        <?php if($fund_type->ft_id == old('fund_type_id', $request->fund_type_id)): ?> selected <?php endif; ?>>
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
                                            <?php if($all_fund_types->isEmpty()): ?>
                                                <small class="text-danger d-block mt-2">Fund classifications are missing in the current database, so this list is empty.</small>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form_group">
                                            <select id="report-category" name="report_category"
                                            data-placeholder="Select">
                                                <option value="">Select</option>
                                                <option value="return" <?php if(isset($request->report_category) && $request->report_category == 'return'): ?> selected <?php endif; ?>>Return %</option>
                                                <option value="indices" <?php if(isset($request->report_category) && $request->report_category == 'indices'): ?> selected <?php endif; ?>>Indices</option>
                                                <option value="return_less_index" <?php if(isset($request->report_category) && $request->report_category == 'return_less_index'): ?> selected <?php endif; ?>>Return Less Index</option>
                                                <?php if(isset($request->type) && $request->type == 'monthly'): ?>
                                                <option value="corpus_change" <?php if(isset($request->report_category) && $request->report_category == 'corpus_change'): ?> selected <?php endif; ?>>Corpus Changes</option>
                                                <?php endif; ?>
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
                                    <div class="col-md-2">
                                        <div class="bttn_grp">
                                            <?php
                                            $type = 'weekly';
                                                if(isset($request->type) && ($request->type == 'monthly')){
                                                    $type = 'monthly';
                                                } 
                                            ?>
                                            <input type="hidden" name="type" id="type" value="<?php echo e($type); ?>">
                                            <button class="perform-submit money_title_btn btn" type="submit">Search</button>
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
                        

                        <?php if(isset($request) && !empty($request->date) && !empty($request->fund_type_id)): ?>
                        <div class="light_green_bg">
                            <div class="perform-snapshot-points mt-2 bordr-only prfrm-snapst">
                                <ul>
                                    <li>
                                        <p>Term of Fund : 
                                            <span>Long Term</span>
                                        </p>
                                    </li>
                                    <li>
                                        <p>Type of Fund : 
                                        <span><?php if(isset($request_fund_type->name)): ?> <?php echo e($request_fund_type->name); ?><?php endif; ?></span>
                                        </p>
                                    </li>
                                    <li>
                                        <p>As On :
                                        <span><?php if(isset($request->date)): ?> <?php echo e(date('d/m/Y',strtotime($request->date))); ?> <?php endif; ?></span>
                                        </p>
                                    </li>
                                </ul>
                                
                            </div>
                        </div>
                        
                        <?php endif; ?>
                        <div class="row all_tables" id="pdfData">
                            
                            
                            <div class="col-md-12">
                                <div class="graph_table orange_bg">

                                    <div class="share_pdf">
                                        <div class="sharethis-inline-share-buttons" ></div>
                                        <a href="javascript:void(0)" id="exportPDF" class="pdf"><img
                                                src="<?php echo e(asset('themes/frontend/assets/infosolz/images/pdf.png')); ?>"></a>

                                    </div>
                                    
                                    <!-- ======Weekly====== -->
                                    <?php if(isset($request->type) && ($request->type == 'weekly')): ?>
                                    <?php if(isset($responseArr) && ($request->report_category == 'return')): ?>
                                        <?php if(isset($responseArr['snapshot_data'])): ?>
                                        <div class="weekly-return">
                                        
                                            <table class="table  datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Fund Name</th>
                                                        <th>Index Name </th>
                                                        <th class="text_center">Daily</th>
                                                        <th class="text_center">7 Days</th>
                                                        <th class="text_center">14 Days</th>
                                                        <th class="text_center">30 Days</th>
                                                        <th class="text_center">60 Days</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(isset($responseArr['snapshot_data'])): ?>
                                                        <?php $__currentLoopData = $responseArr['snapshot_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quickRatio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><a class="text-white" href="/fund-performance?fund_code=<?php echo e($quickRatio->fund_code); ?>" target="_blank"><?php echo e($quickRatio->fund_name); ?></a></td>
                                                                <td><?php echo e($quickRatio->indices_name); ?></td>

                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'5DAYS'}))?printValue($quickRatio->{'5DAYS'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'7DAYS'}))?printValue($quickRatio->{'7DAYS'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'14DAYS'}))?printValue($quickRatio->{'14DAYS'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'30DAYS'}))?printValue($quickRatio->{'30DAYS'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'60DAYS'}))?printValue($quickRatio->{'60DAYS'}):' '); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if(isset($responseArr) && ($request->report_category == 'indices')): ?>
                                        <?php if(isset($responseArr['snapshot_data'])): ?>
                                        <div class="weekly-indices">
                                            <table class="table  datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Index Name </th>
                                                        <th class="text_center">7 Days</th>
                                                        <th class="text_center">14 Days</th>
                                                        <th class="text_center">30 Days</th>
                                                        <th class="text_center">60 Days</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(isset($responseArr['snapshot_data'])): ?>
                                                        <?php $__currentLoopData = $responseArr['snapshot_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quickRatio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($quickRatio->indices_name); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'7DAYS'}))?printValue($quickRatio->{'7DAYS'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'14DAYS'}))?printValue($quickRatio->{'14DAYS'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'30DAYS'}))?printValue($quickRatio->{'30DAYS'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'60DAYS'}))?printValue($quickRatio->{'60DAYS'}):' '); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if(isset($responseArr) && ($request->report_category == 'return_less_index')): ?>
                                        <?php if(isset($responseArr['snapshot_data'])): ?>
                                        <div class="weekly-return-less-index">
                                            <table class="table  datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Fund Name</th>
                                                        <th class="text_center">7 Days</th>
                                                        <th class="text_center">14 Days</th>
                                                        <th class="text_center">30 Days</th>
                                                        <th class="text_center">60 Days</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(isset($responseArr['snapshot_data'])): ?>
                                                        <?php $__currentLoopData = $responseArr['snapshot_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quickRatio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><a class="text-white" href="/fund-performance?fund_code=<?php echo e($quickRatio->fund_code); ?>" target="_blank"><?php echo e($quickRatio->fund_name); ?></a></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'7DAYS'}))?printValue($quickRatio->{'7DAYS'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'14DAYS'}))?printValue($quickRatio->{'14DAYS'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'30DAYS'}))?printValue($quickRatio->{'30DAYS'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'60DAYS'}))?printValue($quickRatio->{'60DAYS'}):' '); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php endif; ?>

                                    <!-- ======End Weekly====== -->
                                    <!-- ========Molthly====== -->
                                    
                                    <?php if(isset($request->type) && ($request->type == 'monthly')): ?>
                                    <?php if(isset($responseArr) && ($request->report_category == 'return')): ?>
                                        <?php if(isset($responseArr['snapshot_data'])): ?>
                                        <div class="weekly-return">
                                            <table class="table  datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Fund Name</th>
                                                        <th>Index Name </th>
                                                        <th class="text_center">Six Months</th>
                                                        <th class="text_center">One Year</th>
                                                        <th class="text_center">Two Year</th>
                                                        <th class="text_center">Three Year</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(isset($responseArr['snapshot_data'])): ?>
                                                        <?php $__currentLoopData = $responseArr['snapshot_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quickRatio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><a class="text-white" href="/fund-performance?fund_code=<?php echo e($quickRatio->fund_code); ?>" target="_blank"><?php echo e($quickRatio->fund_name); ?></a></td>
                                                                <td><?php echo e($quickRatio->indices_name); ?></td>

                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'sixmonths'}))?printValue($quickRatio->{'sixmonths'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'oneyear'}))?printValue($quickRatio->{'oneyear'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'twoyear'}))?printValue($quickRatio->{'twoyear'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'threeyear'}))?printValue($quickRatio->{'threeyear'}):' '); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if(isset($responseArr) && ($request->report_category == 'indices')): ?>
                                        <?php if(isset($responseArr['snapshot_data'])): ?>
                                        <div class="weekly-indices">
                                            <table class="table  datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Index Name </th>
                                                        <th class="text_center">Six Months</th>
                                                        <th class="text_center">One Year</th>
                                                        <th class="text_center">Two Year</th>
                                                        <th class="text_center">Three Year</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(isset($responseArr['snapshot_data'])): ?>
                                                        <?php $__currentLoopData = $responseArr['snapshot_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quickRatio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($quickRatio->indices_name); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'sixmonths'}))?printValue($quickRatio->{'sixmonths'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'oneyear'}))?printValue($quickRatio->{'oneyear'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'twoyear'}))?printValue($quickRatio->{'twoyear'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'threeyear'}))?printValue($quickRatio->{'threeyear'}):' '); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if(isset($responseArr) && ($request->report_category == 'return_less_index')): ?>
                                        <?php if(isset($responseArr['snapshot_data'])): ?>
                                        <div class="weekly-return-less-index">
                                            <table class="table  datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Fund Name</th>
                                                        <th class="text_center">Six Months</th>
                                                        <th class="text_center">One Year</th>
                                                        <th class="text_center">Two Year</th>
                                                        <th class="text_center">Three Year</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(isset($responseArr['snapshot_data'])): ?>
                                                        <?php $__currentLoopData = $responseArr['snapshot_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quickRatio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><a class="text-white" href="/fund-performance?fund_code=<?php echo e($quickRatio->fund_code); ?>" target="_blank"><?php echo e($quickRatio->fund_name); ?></a></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'sixmonths'}))?printValue($quickRatio->{'sixmonths'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'oneyear'}))?printValue($quickRatio->{'oneyear'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'twoyear'}))?printValue($quickRatio->{'twoyear'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'threeyear'}))?printValue($quickRatio->{'threeyear'}):' '); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if(isset($responseArr) && ($request->report_category == 'corpus_change')): ?>
                                        <?php if(isset($responseArr['snapshot_data'])): ?>
                                        <div class="weekly-corpus-change">
                                            <table class="table  datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Fund Name</th>
                                                        <th class="text_center">Current Amount (Rs.in Crores)</th>
                                                        <th class="text_center">Change Amount (Rs.in Crores)</th>
                                                        <th class="text_center"> (%) Change </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(isset($responseArr['snapshot_data'])): ?>
                                                        <?php $__currentLoopData = $responseArr['snapshot_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quickRatio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><a class="text-white" href="/fund-performance?fund_code=<?php echo e($quickRatio->fund_code); ?>" target="_blank"><?php echo e($quickRatio->fund_name); ?></a></td>
                                                                <td class="text_right"><?php echo e(printValue($quickRatio->corpus_entry/100)); ?></td>
                                                                <td class="text_right"><?php echo e(printValue($quickRatio->corpus_change/100)); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'percentage_change'}))?printValue($quickRatio->{'percentage_change'}):' '); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php endif; ?>

                                    <!-- ======End Molthly====== -->
                                     
                                    <?php if(!isset($responseArr['snapshot_data'])): ?>
                                    <div class="weekly-return-less-index">
                                            <table class="table  datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Fund Name</th>
                                                        <th class="text_center">7 Days</th>
                                                        <th class="text_center">14 Days</th>
                                                        <th class="text_center">30 Days</th>
                                                        <th class="text_center">60 Days</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(isset($responseArr['snapshot_data'])): ?>
                                                        <?php $__currentLoopData = $responseArr['snapshot_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quickRatio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td colspan="7" class="text-center">No information is available for this search</td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                    
                                </div>
                            </div>
                            
                    </div>
                </section>

                <?php if(isset($responseArr)): ?>
                <div class="disclaimer">
                    <p><strong>Disclaimer : </strong><?php echo e($disclaimer); ?></p>
                </div>
           
                    
            <?php endif; ?>
            </div>
        </div>
    </div>
<script>
function tabSelect(val) {

    $("#type").val(val);
    if (val == 'weekly') {
        $("#tab-weekly").addClass('active');
        $("#tab-monthly").removeClass('active');
        $('#report-category option[value="corpus_change"]').remove();
    } else {
        $("#tab-weekly").removeClass('active');
        $("#tab-monthly").addClass('active');
        
        $('#report-category').append(
            '<option value="corpus_change" <?php if(isset($request->report_category) && $request->report_category == "corpus_change"): ?> selected <?php endif; ?>>Corpus Changes</option>'
        );
    }
}
</Script>
<?php $__env->stopSection(); ?>

<style>
    .share_pdf {
    position: static !important;
    right: 0;
    top: -38px;
    display: flex;
    align-items: center;
    gap: 10px;
    float: right;
    padding-bottom: 10px;
}
</style>

<Script>


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

                doc.addImage(img, 'PNG', centerX, 10, imgWidth, imgHeight);

                doc.setFontSize(16);
                doc.setTextColor(45, 135, 23);
                doc.text('Quick Ratio', pageWidth / 2, 35, {
                    align: 'center'
                });

                doc.setFontSize(12);
                doc.setTextColor(0, 0, 0);

                // Date and ratio details
                var startDate =
                    "<?php echo e(isset($request->date) ? date('d/m/Y', strtotime($request->date)) : '00/00/0000'); ?>";
                
                    var ratio =
                    <?php if(isset($request->report_category)): ?>
                        <?php switch($request->report_category):
                            case ('return'): ?>
                            'Return %'
                            <?php break; ?>

                            <?php case ('indices'): ?>
                            'Indices'
                            <?php break; ?>

                            <?php case ('return_less_index'): ?>
                            'Return Less Index'
                            <?php break; ?>

                            <?php case ('corpus_change'): ?>
                            'Corpus Change'
                            <?php break; ?>
                            
                        <?php endswitch; ?>
                    <?php endif; ?> ;

                    var type =
                    <?php if(isset($request->type)): ?>
                        <?php switch($request->type):
                            case ('weekly'): ?>
                            'Weekly'
                            <?php break; ?>

                            <?php case ('monthly'): ?>
                            'Monthly'
                            <?php break; ?>
                            
                        <?php endswitch; ?>
                    <?php endif; ?> ;

                var fundClassification = "<?php echo e(isset($request_fund_type->name) ? $request_fund_type->name : ''); ?>";

                var startX = 15;
                var lineHeight = 10;
                var tableStartY = 70;

                if (type !== null) {
                    doc.text(`Type: ${type}`, startX, tableStartY - 20);
                }

                doc.text(`As On: ${startDate}`, startX, tableStartY - 10);

                if (fundClassification !== null) {
                
                    doc.text(`Fund Classification: ${fundClassification}`, startX, tableStartY);
                }

                doc.text(`By: ${ratio}`, startX +100, tableStartY - 10);

                var table = new DataTable('.datatable');
                var tableData = [];

                table.rows({ search: 'applied' }).data().each(function(row) {
                    var strippedRow = row.map(cell => cell.replace(/<[^>]+>/g, '')); // Remove HTML tags
                    tableData.push(strippedRow);
                });

                /*table.rows({ search: 'applied' }).data().each(function(row) {
                    var processedRow = row.map(cell => {
                        // Remove HTML tags and replace blank cells with "N/A"
                        var plainText = cell.replace(/<[^>]+>/g, '');
                        return plainText.trim() === '' ? 'N/A' : plainText;
                    });
                    tableData.push(processedRow);
                });*/
                <?php if(isset($request->type) && $request->type =='weekly'): ?>
                    <?php if(isset($request->report_category) && $request->report_category =='return'): ?>
                        doc.autoTable({
                            head: [
                                ['Fund Name', 'Index Name', 'Daily', '7 Days', '14 Days', '30 Days', '60 Days']
                            ],
                            body: tableData,
                            startX: startX,
                            startY: tableStartY + 10,
                            headStyles: {
                                fillColor: [45, 135, 23]
                            },
                            columnStyles: {
                                // Apply right alignment to specific columns
                                2: { halign: 'right' },  
                                3: { halign: 'right' },  
                                4: { halign: 'right' },      
                                5: { halign: 'right' },      
                                6: { halign: 'right' },      
                            }
                        });
                    <?php endif; ?>
                    <?php if(isset($request->report_category) && $request->report_category =='indices'): ?>
                        doc.autoTable({
                            head: [
                                ['Index Name', '7 Days', '14 Days', '30 Days', '60 Days']
                            ],
                            body: tableData,
                            startX: startX,
                            startY: tableStartY + 10,
                            headStyles: {
                                fillColor: [45, 135, 23]
                            },
                            columnStyles: {
                                // Apply right alignment to specific columns
                                1: { halign: 'right' },  
                                2: { halign: 'right' },  
                                3: { halign: 'right' },  
                                4: { halign: 'right' },      
                            }
                        });
                    <?php endif; ?>
                    <?php if(isset($request->report_category) && $request->report_category =='return_less_index'): ?>
                        doc.autoTable({
                            head: [
                                ['Fund Name', '7 Days', '14 Days', '30 Days', '60 Days']
                            ],
                            body: tableData,
                            startX: startX,
                            startY: tableStartY + 10,
                            headStyles: {
                                fillColor: [45, 135, 23]
                            },
                            columnStyles: {
                                // Apply right alignment to specific columns
                                1: { halign: 'right' },  
                                2: { halign: 'right' },  
                                3: { halign: 'right' },  
                                4: { halign: 'right' },      
                            }
                        });
                    <?php endif; ?>
                <?php endif; ?>

                <?php if(isset($request->type) && $request->type =='monthly'): ?>
                    <?php if(isset($request->report_category) && $request->report_category =='return'): ?>
                        doc.autoTable({
                            head: [
                                ['Fund Name', 'Index Name', 'Six Months', 'One Year', 'Two Year', 'Three Year']
                            ],
                            body: tableData,
                            startX: startX,
                            startY: tableStartY + 10,
                            headStyles: {
                                fillColor: [45, 135, 23]
                            },
                            columnStyles: {
                                // Apply right alignment to specific columns
                                2: { halign: 'right' },  
                                3: { halign: 'right' },  
                                4: { halign: 'right' },   
                                5: { halign: 'right' },   
                            }
                        });
                    <?php endif; ?>
                    <?php if(isset($request->report_category) && $request->report_category =='indices'): ?>
                        doc.autoTable({
                            head: [
                                ['Index Name', 'Six Months', 'One Year', 'Two Year', 'Three Year']
                            ],
                            body: tableData,
                            startX: startX,
                            startY: tableStartY + 10,
                            headStyles: {
                                fillColor: [45, 135, 23]
                            },
                            columnStyles: {
                                // Apply right alignment to specific columns
                                1: { halign: 'right' },  
                                2: { halign: 'right' },  
                                3: { halign: 'right' },  
                                4: { halign: 'right' },   
                            }
                        });
                    <?php endif; ?>
                    <?php if(isset($request->report_category) && $request->report_category =='return_less_index'): ?>
                        doc.autoTable({
                            head: [
                                ['Fund Name', 'Six Months', 'One Year', 'Two Year', 'Three Year']
                            ],
                            body: tableData,
                            startX: startX,
                            startY: tableStartY + 10,
                            headStyles: {
                                fillColor: [45, 135, 23]
                            },
                            columnStyles: {
                                // Apply right alignment to specific columns
                                1: { halign: 'right' },  
                                2: { halign: 'right' },  
                                3: { halign: 'right' },  
                                4: { halign: 'right' },   
                            }
                        });
                    <?php endif; ?>
                    <?php if(isset($request->report_category) && $request->report_category =='corpus_change'): ?>
                        doc.autoTable({
                            head: [
                                ['Fund Name', 'Current Amount (Rs.in Crores)', 'Change Amount (Rs.in Crores)', '(%) Change']
                            ],
                            body: tableData,
                            startX: startX,
                            startY: tableStartY + 10,
                            headStyles: {
                                fillColor: [45, 135, 23]
                            },
                            columnStyles: {
                                // Apply right alignment to specific columns
                                1: { halign: 'right' },  
                                2: { halign: 'right' },  
                                3: { halign: 'right' },    
                            }
                        });
                    <?php endif; ?>
                <?php endif; ?>

                var currentDate = new Date();

                var fileName = 'Quick-Ratio-' + currentDate + '.pdf';

                doc.save(fileName);
            };
        });
    });


</Script>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/ratio-reports/quick_ratio_new.blade.php ENDPATH**/ ?>