<?php if(isset($dataArr['meta_title'])): ?>
<?php $__env->startSection('page-title'); ?><?php echo e($dataArr['meta_title']); ?><?php $__env->stopSection(); ?>
<?php else: ?>
<?php $__env->startSection('page-title'); ?><?php echo e($dataArr['title']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if(isset($dataArr['meta_key'])): ?>
<?php $__env->startSection('meta-keywords'); ?><?php echo e($dataArr['meta_key']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if(isset($dataArr['meta_descp'])): ?>
<?php $__env->startSection('meta-description'); ?><?php echo e($dataArr['meta_descp']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if(isset($dataArr['image_path'])): ?>
<?php $__env->startSection('meta-image'); ?><?php echo e($dataArr['image_path']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if($dataArr['full_url']): ?>
<?php $__env->startSection('cur-url'); ?><?php echo e($dataArr['full_url']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php $__env->startSection('content'); ?>
<style>
.tab_snap_shot .nav-pills .nav-link.active {
    background: #134c48!important;
    color: #fff!important;
}
/* .tab_snap_shot .nav-pills .nav-link {
    background: #fff!important;
    color: #134c48;
} */
table.cmn_table tr td {
    font-size: .727rem !important;
}
</style>
<div class="custom-banner no-bg fw-banner <?php if(!$dataArr['image_path']): ?> fund-portfolio-banner  <?php endif; ?>" <?php if($dataArr['image_path']): ?> style="background-image:url(<?php echo e($dataArr['image_path']); ?>)" <?php endif; ?>>
    <section class="inner_banner_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner_section_banner">
                        <h4><?php echo e($dataArr['title']); ?></h4>

                        <div class="share_pdf " style="position: relative;  display: flex; align-items: center; gap: 10px;"> <!--padding-left:90%;margin-top:-35px; -->
                            <div class="sharethis-inline-share-buttons"></div>
                            <a href="javascript:void(0)" id="exportPDF" class="pdf"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/pdf.png')); ?>" width="24"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<section class="compare_scheme pt-5">
    <div class="container">
        <div class="comp_schem_bdr">
            <div class="tab_snap_shot">
                <ul class="nav nav-pills mb-3 justify-content-md-center" id="pills-tab" role="tablist">
                    <li class="nav-item me-5" role="presentation"><a class="text-dark nav-link <?php if((isset($ratio_type) && ($ratio_type == 'returns')) || !isset($ratio_type)): ?> active <?php endif; ?> " href="performance-synopsis?type=<?=$type?>&ratio_type=returns" ><i class="fa-solid fa-calendar-check"></i>By Ratio: Returns</a></li>
                    <li class="nav-item" role="presentation"><a class="text-dark nav-link <?php if((isset($ratio_type) && ($ratio_type == 'jensens_alpha')) || !isset($ratio_type)): ?> active <?php endif; ?>  " href="performance-synopsis?type=<?=$type?>&ratio_type=jensens_alpha" ><i class="ph-calendar-check"></i>By Ratio: Jensen’s Alpha</a></li>
                </ul>
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation"><a class="text-dark nav-link <?php if((isset($type) && ($type == 'quartile-active')) || !isset($type)): ?> active <?php endif; ?> " href="performance-synopsis?type=quartile-active&ratio_type=<?=$ratio_type?>" ><i class="fa-solid fa-calendar-check"></i> Quartile (Active Schemes)</a></li>
                    <li class="nav-item" role="presentation"><a class="text-dark nav-link <?php if((isset($type) && ($type == 'quartile-passive')) || !isset($type)): ?> active <?php endif; ?>  " href="performance-synopsis?type=quartile-passive&ratio_type=<?=$ratio_type?>" ><i class="ph-calendar"></i> Quartile (Passive Schemes)</a></li>
                    <li class="nav-item" role="presentation"><a class="text-dark nav-link <?php if((isset($type) && ($type == 'decile-active')) || !isset($type)): ?> active <?php endif; ?> " href="performance-synopsis?type=decile-active&ratio_type=<?=$ratio_type?>" ><i class="ph-calendar-check"></i> Decile (Active Schemes)</a></li>
                    <li class="nav-item" role="presentation"><a class="text-dark nav-link <?php if((isset($type) && ($type == 'decile-passive')) || !isset($type)): ?> active <?php endif; ?> " href="performance-synopsis?type=decile-passive&ratio_type=<?=$ratio_type?>" ><i class="ph-calendar"></i> Decile (Passive Schemes)</a></li>
                </ul>
                <div class="tab-content" id="">
                    <div class="tab-pane fade show active p-0" id="pills-weekly" role="tabpanel" aria-labelledby="pills-weekly-tab">
                        <div class="top_table_bg_color mb-3 p-0" style="background: none;">
                            
                            <div class="fund_compo p-0" style="background: none;" id="pills-tabContent">          
                            
                                <div class="w-100 text-center single_fund titleBox d-none">
                                    <img src="https://www.myplexus.com/themes/frontend/assets/v1/img/Logo_v2-03.png" width="250" alt="">
                                    <h1>Performance Synopsis </h1>
                                    <h4>
                                        <?php if($type=='quartile-passive'): ?>
                                            Comprehensive Report of Quartile Rank Improvement by Fund Houses
                                        <?php elseif($type=='decile-active'): ?>
                                            Comprehensive Report of Decile Rank Improvement by Fund Houses
                                        <?php elseif($type=='decile-passive'): ?>
                                            Comprehensive Report of Decile Rank Improvement by Fund Houses
                                        <?php else: ?>
                                            Comprehensive Report of Quartile Rank Improvement by Fund Houses
                                        <?php endif; ?>
                                    </h4>                                    
                                    <h5 class="text-white"><?php echo e(date("F Y",strtotime($monthly_performance_synopses_last_date.' -1 year first day of next month'))); ?> - <?php echo e(date("F Y",strtotime($monthly_performance_synopses_last_date))); ?></h5>
                                </div>
                                <div class="titleBox2 fw-bold" style="border: 1px solid #fff; border-radius: 18px; padding: 10px;background: var(--darkgreen);">
                                    <h4 class="text-white">
                                        <?php if($type=='quartile-passive'): ?>
                                            Comprehensive Report of Quartile Rank Improvement by Fund Houses
                                        <?php elseif($type=='decile-active'): ?>
                                            Comprehensive Report of Decile Rank Improvement by Fund Houses
                                        <?php elseif($type=='decile-passive'): ?>
                                            Comprehensive Report of Decile Rank Improvement by Fund Houses
                                        <?php else: ?>
                                            Comprehensive Report of Quartile Rank Improvement by Fund Houses
                                        <?php endif; ?>
                                    </h4>
                                    <!-- <?php echo e(date("jS F'Y",strtotime($monthly_performance_synopses_last_date.' -1 year first day of next month'))); ?> -->
                                    <h5><?php echo e(date("F Y",strtotime($monthly_performance_synopses_last_date.' -1 year first day of next month'))); ?> - <?php echo e(date("F Y",strtotime($monthly_performance_synopses_last_date))); ?></h5>
                                    
                                </div>
                                <div class="fund_compo_in " id="fund_compo_in">
                                    <?php if($type=='quartile-passive' || $type=='quartile-active'): ?>
                                        
                                        <table  class="table cmn_table port_up_table" width="100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col" rowspan="2" style="background-color: #00665E !important;width:50px;border-bottom:1px solid #fff !important;">No. of Equity Schemes <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span>
                                                    </th>
                                                    <th scope="col" rowspan="2" style="background-color: #00665E !important;width:175px!important;border-bottom:1px solid #fff !important;">Fund House <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span>
                                                    </th>
                                                    <th scope="col" colspan="8" class="text-center" style="background-color: #00665E !important;">Number of Schemes as per Quartile Ranks</th>
                                                </tr>                                            
                                                <tr>
                                                <?php for($i=4;$i>=1;$i--): ?>
                                                    <th scope="col" class="text-center" style="background-color: #00665E !important;border:none;border-left:1px solid #fff !important;border-top:1px solid #fff !important;border-bottom:1px solid #fff !important;"> <?php echo e($i); ?> <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span>
                                                    </th>
                                                    <th scope="col" class="text-center" style="background-color: #00665E !important;border:none;border-right:1px solid #fff !important;border-top:1px solid #fff !important;border-bottom:1px solid #fff !important;"> <span class="fw-bold fs-5">+/-</span> <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span>
                                                </th>
                                                <?php endfor; ?>    
                                                </tr>

                                            </thead>

                                            <tbody id="" class="fs-8">
                                                <?php if(!empty($performance_synopses)): ?>
                                                <?php $__currentLoopData = $performance_synopses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$performance_synopsis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    
                                                <tr>
                                                    <td scope="col" class="text-center "><?php echo e($performance_synopsis['total_schemes']); ?></td>
                                                    <td scope="col" class="text-start" style="width:175px!important;"><?php echo e($performance_synopsis['fund_house']); ?></td>
                                                    <?php for($i=4;$i>=1;$i--): ?>
                                                        <td scope="col" class="text-center cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="<?php echo e($performance_synopsis['quartileSchemes'.$i]); ?>" style="border-left:1px solid #000 !important;">
                                                            <?php echo e($performance_synopsis['quartile'.$i]); ?> 
                                                        </td>
                                                        <td scope="col" class="text-center"  style="background-color:#ADC178;border-right:1px solid #000 !important;">
                                                            
                                                            <?php if($performance_synopsis['quartile'.$i]-$performance_synopsis['_quartile'.$i] > 0): ?>
                                                                <?php echo e($performance_synopsis['quartile'.$i]-$performance_synopsis['_quartile'.$i]); ?>

                                                            <i class="fa-solid fa-arrow-up text-success"></i>
                                                            <?php elseif($performance_synopsis['quartile'.$i]-$performance_synopsis['_quartile'.$i] < 0): ?>
                                                                <?php echo e(($performance_synopsis['quartile'.$i]-$performance_synopsis['_quartile'.$i]) * -1); ?>

                                                            <i class="fa-solid fa-arrow-down text-danger"></i>
                                                            <?php else: ?>
                                                                <?php echo e($performance_synopsis['quartile'.$i]-$performance_synopsis['_quartile'.$i]); ?>

                                                            <?php endif; ?>
                                                        </td>
                                                    <?php endfor; ?>    
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                <tr>
                                                    <td scope="col" colspan="10" class="text-center">No Records Found</td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                        
                                    <?php else: ?>
                                        
                                        <table id="" class="table cmn_table port_up_table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col" rowspan="2"  style="background-color: #00665E !important;border-bottom: 1px solid #fff !important;width:50px!important;">No. of Equity Schemes <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span></th>
                                                    <th scope="col" rowspan="2" style="background-color: #00665E !important;border-bottom: 1px solid #fff !important;width:175px!important;">Fund House <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span></th>
                                                    <th scope="col" colspan="20" class="text-center" style="background-color: #00665E !important;border-bottom: 1px solid #fff !important;">Number of Schemes as per Decile Ranks</th>
                                                </tr>
                                                <tr>
                                                    <?php for($i=10;$i>=1;$i--): ?>
                                                            <th scope="col" class="text-center" style="background-color: #00665E !important;"><?php echo e($i); ?> <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span></th>
                                                            <!-- <th scope="col" class="text-center">Improvement</th> -->
                                                        <?php endfor; ?>  
                                                </tr>
                                            </thead>
                                            <tbody class="fs-8">
                                                <?php if(!empty($performance_synopses)): ?>
                                                    <?php $__currentLoopData = $performance_synopses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$performance_synopsis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td scope="col" class="text-center "><?php echo e($performance_synopsis['total_schemes']); ?></td>
                                                        <td scope="col" class="text-start" style="width:175px!important;"><?php echo e($performance_synopsis['fund_house']); ?></td>
                                                        <?php for($i=10;$i>=1;$i--): ?>
                                                        <td scope="col" class="text-center"  data-bs-toggle="tooltip" data-bs-html="true"  data-bs-placement="top" title="<?php echo e($performance_synopsis['decileSchemes'.$i]); ?>" style="border-left:1px solid #000 !important;">
                                                            <?php echo e($performance_synopsis['decile'.$i]); ?> 
                                                            
                                                            <?php if($performance_synopsis['decile'.$i]-$performance_synopsis['_decile'.$i] > 0): ?>
                                                                (<?php echo e($performance_synopsis['decile'.$i]-$performance_synopsis['_decile'.$i]); ?>

                                                            <i class="fa-solid fa-arrow-up text-success"></i>)
                                                            <?php elseif($performance_synopsis['decile'.$i]-$performance_synopsis['_decile'.$i] < 0): ?>
                                                                (<?php echo e(($performance_synopsis['decile'.$i]-$performance_synopsis['_decile'.$i]) * -1); ?>

                                                            <i class="fa-solid fa-arrow-down text-danger"></i>)
                                                            <?php else: ?>
                                                                (<?php echo e($performance_synopsis['decile'.$i]-$performance_synopsis['_decile'.$i]); ?>)
                                                            <?php endif; ?>
                                                        </td>
                                                        <!-- <td scope="col" class="text-center">
                                                            <?php echo e($performance_synopsis['decile'.$i]-$performance_synopsis['_decile'.$i]); ?>

                                                            <?php if($performance_synopsis['decile'.$i]-$performance_synopsis['_decile'.$i] > 0): ?>
                                                            <i class="fa-solid fa-arrow-up text-success"></i>
                                                            <?php elseif($performance_synopsis['decile'.$i]-$performance_synopsis['_decile'.$i] < 0): ?>
                                                            <i class="fa-solid fa-arrow-down text-danger"></i>
                                                            <?php endif; ?>
                                                        </td> -->
                                                        <?php endfor; ?>    
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                    <tr>
                                                        <td scope="col" colspan="22" class="text-center">No Records Found</td>
                                                    </tr>
                                                <?php endif; ?>
                                                
                                            </tbody>
                                            
                                        </table>

                                    <?php endif; ?>
                                </div>
                                <!-- <p class="discl"><strong>Disclaimer :</strong> <?php echo $disclaimer_text; ?></p> -->
                                <div class="classification-disc fund_compo mt-3" id="disc" style="background-color: #134c48;">
                                    <h6 class="text-green">Note</h6>
                                    <?php if($type=='quartile-passive' || $type=='quartile-active'): ?>
                                        <ul>
                                            <li> Quartile 4 represents the highest rank. </li>
                                            <li> Quartile 1 represents the lowest rank. </li>
                                            <li> Data showing for schemes that have completed 1 year. </li>
                                            <li> (+/-) - It represents the number of schemes that have improved or declined in quartile rank based on return performance, compared to the previous month’s rank over the past 1 year. </li>
                                        </ul>
                                    <?php else: ?>
                                        <ul>
                                            <li> Decile 10 represents the highest rank. </li>
                                            <li> Decile 1 represents the lowest rank. </li>
                                            <li> Data showing for schemes that have completed 1 year. </li>
                                            <li> (<i class="fa-solid fa-arrow-up text-success"></i>) represents the number of schemes that have improved in decile rank based on return performance, compared to the previous month’s rank over the past 1 year. </li>
                                            <li> (<i class="fa-solid fa-arrow-down text-danger"></i>) represents the number of schemes that have declined in decile rank based on return performance, compared to the previous month’s rank over the past 1 year.</li>
                                            
                                        </ul>
                                    <?php endif; ?>
                                </div>
                                <div class="classification-disc fund_compo" style="background-color: transparent;height:200px">

                                </div>


                                

                            </div>
                        </div><!--v-if-->
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->startPush('scripts'); ?>
<!-- <script src="https://myplexus.com/themes/frontend/assets/v1/js/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> 
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
<script>
var table = new DataTable('.port_up_table', {
    //responsive: true,
    info: false,
    ordering: true,
    paging: false,
    searching: false,
    order: [],
    scrollX: true,
    scrollCollapse: true,
    bAutoWidth: false, 
    columnDefs: [
        { "width": "50px", "targets": [0] },
        { "width": "200px", "targets": [1] }
    ]
    
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" i></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var exportButton = document.getElementById('exportPDF');

        exportButton.addEventListener('click', function() {
            const isMobile = navigator.userAgentData.mobile;

            //alert(isMobile);
            //$("html, body").animate({ scrollTop: 0 }, "fast");
            table.destroy();
            if(isMobile){
                var options = {
                    margin: 0.2,
                    filename: '<?=$type?>-.pdf',
                    image: {
                        type: 'png',
                        quality: 500
                    },
                    html2canvas: {
                        scale: 1, // Increase scale to improve image quality
                        sectors: false, // Enable CORS for loading cross-origin images
                        //allowTaint: true, // Allow rendering of tainted images
                        logging: true // Enable logging for debugging
                    },
                    jsPDF: {
                        unit: 'in',
                        format: 'letter',
                        orientation: 'landscape' //portrait
                    },
                
                }
            }else{
                var options = {
                    margin: 0.2,
                    filename: '<?=$type?>-.pdf',
                    image: {
                        type: 'png',
                        quality: 500
                    },
                    html2canvas: {
                        scale: 1, // Increase scale to improve image quality
                        sectors: false, // Enable CORS for loading cross-origin images
                        //allowTaint: true, // Allow rendering of tainted images
                        logging: true // Enable logging for debugging
                    },
                    jsPDF: {
                        unit: 'in',
                        format: 'letter',
                        orientation: 'landscape' //portrait
                    },
                    pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
                
                }
            }
            
             $('.titleBox').removeClass('d-none');
             $('.titleBox2').addClass('d-none');
            
            

            //e.preventDefault();
            const element = document.getElementById('pills-tabContent');            
            //const element = document.getElementsByClassName('pdfPrint');

            //console.log(element);
            
            //html2pdf().from(element).set(options).save();
            html2pdf().from(element).set(options).outputPdf().then(function(pdf) {
                //This logs the right base64
                //console.log(btoa(pdf));
                 $('.titleBox').addClass('d-none');
                 $('.titleBox2').removeClass('d-none');

                var table = new DataTable('.port_up_table', {
                    //responsive: true,
                    info: false,
                    ordering: true,
                    paging: false,
                    searching: false,
                    order: [],
                    scrollX: true,
                    bAutoWidth: false, 
                    columnDefs: [
                        { "width": "50px", "targets": [0] },
                        { "width": "200px", "targets": [1] }
                    ]
                    
                });
                
            }).save();
            //location.reload();
        });
    });


    // var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    // var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    //     return new bootstrap.Tooltip(tooltipTriggerEl)
    // })
    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
    
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/pages/performance-synopsis.blade.php ENDPATH**/ ?>