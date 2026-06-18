<style>
@media(min-width:767px){
.table-responsive{
    overflow-x:hidden !important;
}}

.bg-gry,.fund_details_table{
	background: #eaf7d2 !important;
}

.perftab tbody td{
    border:1px solid #00665e !important;
    border-style:solid !important;
}

table.perftab thead  {
    background:#00665e !important;
    color:#fff !important;
}
table.perftab th{
    border:1px solid #f7f9dd !important;
}
table.perftab>:not(caption)>*>*,
table.perftab>:not(caption)>*,
table.perftab>tbody>tr:nth-of-type(odd){
    background-color:#eaf7d2;
    box-shadow:none !important;
}
	.fca thead th {
    background:#00665e !important;
    color:#fff !important;
    border:1px solid #000 !important;
    
}

.fca,
.fca td
{
    border:1px solid #000 !important;
}
	tbody img {
    background:none !important;
}
	.grpad .pentatech_inner{
    margin-top:0 !important;
    padding-top:0 !important;
}
.dis{
	text-align: center;
}
</style>
<?php if(isset($dataArr['meta_title'])): ?>
    <?php $__env->startSection('page-title'); ?><?php echo e($dataArr['meta_title']); ?><?php $__env->stopSection(); ?>
    <?php else: ?>
    <?php $__env->startSection('page-title'); ?><?php echo e($dataArr['title'] | $fundMaster->fund_name); ?><?php $__env->stopSection(); ?>
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

                    <?php $__env->startSection('vue-js'); ?> <?php $__env->stopSection(); ?>
                    <?php $__env->startSection('content'); ?>

                        <section class="inner_banner_section">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="inner_section_banner">
                                            <h4>Fund Watch : <?php echo e($fundMaster->fund_name); ?></h4>
                                            <p></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section class="pentatech_section section">
                            <div class="container">
                                <div class="row mb-5">
                                    <div class="col-md-12">
                                        <div class="pentatech_inner_wrapper blog-wrapper fund-watch-listing fw-single-page">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 bg-gry br-5 fw-single-block box-shadow">
                                                   
                                                   
                                                    <div class="fw-single-content pentatech_inner">
														 <h5 class="text-start">Preamble</h5>
                                                        	
                                                            <?php echo e($fundWatch->preamble); ?>

                                                        
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12 blog-main-sidebar fw-sidebar d-none">
                                                    <div class="blog-sidebar-links blog-sidebar-block bg-gry br-5 box-shadow">
                                                        <h5>Recent Funds</h5>
                                                    
                                                        <div class="pentatech_inner">
                                                            <ul class="reset">
                                                                <li>
                                                                    <a href="https://www.myplexus.com/fund-watch/5" class="active">NIPPON INDIA SMALLCAP INDEX 250 FUND</a>
                                                                </li>
                                                                <li>
                                                                    <a href="https://www.myplexus.com/fund-watch/4">NIPPON INDIA 150 MIDCAP INDEX FUND</a>
                                                                </li>
                                                                <li>
                                                                    <a href="https://www.myplexus.com/fund-watch/3">MIRAE ASSET EMERGING BLUECHIP FUND</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="blog-sidebar-links blog-sidebar-block bg-gry br-5 box-shadow">
                                                            <h5>Archives</h5>
                                                        
                                                        <div class="pentatech_inner">
                                                            <ul class="reset">
                                                                <li>
                                                                <a href="https://www.myplexus.com/fund-watch-list/2021">2021 <span>(2)</span></a>
                                                                </li>
                                                                <li>
                                                                <a href="https://www.myplexus.com/fund-watch-list/2020">2020 <span>(3)</span></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="pentatech_filter_title m-3">
                                                        <h5>Fund Details</h5>
                                                    </div>
                                                    <div class="pentatech_inner fund_watch_2_table fund_details_table">
														
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Start Date:</td>
                                                                    <td class="text-start"><?php echo e($schemenamei); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Fund Type:</td>
                                                                    <td class="text-start"><?php echo e($fundMaster->classification); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Benchmark:</td>
                                                                    <td class="text-start"><?php echo e($fundMaster->indices_name); ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="pentatech_filter_title m-3">
                                                        <h5>Management Details</h5>
                                                    </div>
                                                    <div class="pentatech_inner fund_watch_2_table fund_details_table">
                                                        <table class="table">
                                                            <tbody>
																
                                                                <tr>
                                                                    <td>Fund Manager:</td>
                                                                    <td class="text-start"><?php echo e($fundMaster->fund_manager); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Total Schemes:</td>
                                                                    <td class="text-start">
																		<?php echo e($nfm); ?>

																	</td>
                                                                </tr>
																<tr>
                                                                    <td>Schemes Managed:</td>
                                                                    <td class="text-start">
																	<?php echo e($snm); ?>....</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Total Asset Size:</td>
                                                                    <td class="text-start"> <?php echo e($crore); ?> Crores </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="pentatech_filter_title m-3">
                                                        <h5>AAUM Growth</h5>
                                                    </div>
                                                    <div class="pentatech_inner fund_details_table" id="aaum_chart_div" style="height: 500px;">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="co-md-12">
                                        <div class="pentatech_inner_wrapper">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div
                                                        class="pentatech_filter_title_new fund_watch_title m-3 d-block d-sm-flex justify-content-center">
                                                        <h5>Research Team Members</h5>
                                                        <ul class="d-block d-sm-flex p-0 m-0">
                                                            <?php
                                                                $team = explode(',', $fundWatch->team);
                                                            ?>
                                                            <?php $__currentLoopData = $team; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																<?php if($key == 0): ?>
																	 <li><?php echo e($val); ?></li>
																<?php else: ?>
																	 <li><?php echo e($key+1); ?>.<?php echo e($val); ?></li>
																<?php endif; ?>                                                               
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        </ul>
                                                    </div>
                                                    <div class="pentatech_inner fund_details_table">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="r_team_member_left investment">
                                                                    <h5>Fund Philosophy</h5>
                                                                    <p>
                                                                        <?php echo e($fundWatch->philosophy); ?>

                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="r_team_member_left investment">
                                                                    <h5>Investment Style</h5>
                                                                    <p> <?php echo e($fundWatch->investment_style); ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="co-md-12">
                                        <div class="pentatech_inner_wrapper fund_watch_parameter_wrapper">
                                            <h2>Performance Parameter</h2>
                                            <div class="row">
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="pentatech_filter_title fund_watch_title m-3">
                                                        <h5>Lumpsum (Amount Invested Rs. 1,00,000/-)</h5>
                                                    </div>
                                                    <div class="px-3">
                                                        <div class="">
                                                            <div class="datatable_ll main_trer performance_parameter_table">
                                                                <div class="table-responsive">
                                                                    <div id="example_wrapper"
                                                                        class="dataTables_wrapper dt-bootstrap5 no-footer">
                                                                        <div class="row">
                                                                            <div class="col-sm-12 col-md-6"></div>
                                                                            <div class="col-sm-12 col-md-6"></div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-12 ">
                                                                                <table 
                                                                                    class="table table-striped no-footer perftab"
                                                                                    style="width: 100%;">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th class="green_bg sorting sorting_asc"
                                                                                                tabindex="0" aria-controls="example"
                                                                                                rowspan="1" colspan="1"
                                                                                                aria-sort="ascending"
                                                                                                aria-label="Time Frame: activate to sort column descending"
                                                                                                style="width: 213px;">Time Frame</th>
                                                                                            <th class="dark_bg sorting" tabindex="0"
                                                                                                aria-controls="example" rowspan="1"
                                                                                                colspan="1"
                                                                                                aria-label="Amount: activate to sort column ascending"
                                                                                                style="width: 156px;">Amount</th>
                                                                                            <th class="dark_bg sorting" tabindex="0"
                                                                                                aria-controls="example" rowspan="1"
                                                                                                colspan="1"
                                                                                                aria-label="Percentage %: activate to sort column ascending"
                                                                                                style="width: 244px;">Percentage %</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody class="lumsum_table_body">

                                                                                    </tbody>
                                                                                </table>
                                                                                
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-12 col-md-5"></div>
                                                                            <div class="col-sm-12 col-md-7"></div>
                                                                        </div>
                                                                    </div>
                                                                    <p>* <= 1 year - absolute returns; for > 1 year- returns using CAGR</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="pentatech_filter_title fund_watch_title m-3">
                                                        <h5>SIP (Amount Invested Rs 10,000 per month)</h5>
                                                    </div>
                                                    <div class="px-3">
                                                        <div class="">
                                                            <div class="datatable_ll main_trer performance_parameter_table">
                                                                <div class="table-responsive">
                                                                    <table  class="table table-striped perftab" style="width:100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="green_bg">Time Frame</th>
                                                                                <th class="dark_bg">Amount</th>
                                                                                <th class="dark_bg">Percentage %</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="sip_body">

                                                                        </tbody>
                                                                    </table>
                                                                    <p>* <= 1 year - absolute returns; for > 1 year- returns using CAGR</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
											<?php echo e($fundWatch->performance_parameter_bottom); ?>

                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="pentatech_filter_title fund_watch_title m-3">
                                                        <h5>Return Stack (Continuous)</h5>
                                                    </div>
                                                    <div class="px-3">
                                                        <div class="">
                                                            <div class="datatable_ll main_trer performance_parameter_table">
                                                                <div class="table-responsive ">
                                                                    <table  class="table table-striped perftab" style="width:100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="green_bg">Return</th>
                                                                                <th class="dark_bg">6 M</th>
                                                                                <th class="dark_bg">1 Y</th>
                                                                                <th class="dark_bg">2 Y</th>
                                                                                <th class="dark_bg">3 Y</th>
                                                                                <th class="dark_bg">5 Y</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="retunr_continus_table">
                                                                            
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="pentatech_filter_title fund_watch_title m-3">
                                                        <h5>Return Stack (Discontinuous)</h5>
                                                    </div>
                                                    <div class="px-3">
                                                        <div class="">
                                                            <div class="datatable_ll main_trer performance_parameter_table">
                                                                <div class="table-responsive">
                                                                    <table  class="table table-striped perftab" style="width:100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="green_bg">Return</th>
                                                                                <th class="dark_bg">6 M</th>
                                                                                <th class="dark_bg">1 Y</th>
                                                                                <th class="dark_bg">2 Y</th>
                                                                                <!-- <th class="dark_bg">3 Y</th>
                                                                                <th class="dark_bg">4 Y</th>
                                                                                <th class="dark_bg">5 Y</th> -->
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="retunr_discontinus_table">
                                                                            <!--<tr>
                                                                                <td data-label="Return">Benchmark</td>
                                                                                <td data-label="6M">10/-</td>
                                                                                <td data-label="1Y">10/-</td>
                                                                                <td data-label="2Y">10/-</td>
                                                                                <td data-label="3Y">10/-</td>
                                                                                <td data-label="4Y">10/-</td>
                                                                                <td data-label="5Y">10/-</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td data-label="Return">Scheme</td>
                                                                                <td data-label="6M">10/-</td>
                                                                                <td data-label="1Y">10/-</td>
                                                                                <td data-label="2Y">10/-</td>
                                                                                <td data-label="3Y">10/-</td>
                                                                                <td data-label="4Y">10/-</td>
                                                                                <td data-label="5Y">10/-</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td data-label="Return">Category AV</td>
                                                                                <td data-label="6M">10/-</td>
                                                                                <td data-label="1Y">10/-</td>
                                                                                <td data-label="2Y">10/-</td>
                                                                                <td data-label="3Y">10/-</td>
                                                                                <td data-label="4Y">10/-</td>
                                                                                <td data-label="5Y">10/-</td>
                                                                            </tr> -->

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="px-3">
                                                        <p><?php echo e($fundWatch->index_rank_bottom); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <div class="row mb-5">
                                    <div class="co-md-12">
                                        <div class="pentatech_inner_wrapper grpad">
                                            <div class="row">
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="pentatech_filter_title m-3">
                                                        <h5>Return Less Index</h5>
                                                    </div>
                                                    <div class="pentatech_inner" id="returnLessIndex_chart_div" style="height: 500px;">

                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="pentatech_filter_title m-3">
                                                        <h5>Fund Rank</h5>
                                                    </div>
                                                    <div class="px-3">
                                                        <div class="">
                                                            <div class="datatable_ll main_trer">
                                                                <div class="table-responsive ">
                                                                    <table 
                                                                        class="table table-striped no-footer perftab"
                                                                        style="width: 100%;">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="green_bg sorting sorting_asc"
                                                                                    tabindex="0" aria-controls="example"
                                                                                    rowspan="1" colspan="1"
                                                                                    aria-sort="ascending"
                                                                                    aria-label="Time Frame: activate to sort column descending"
                                                                                    style="width: 213px;">Time Frame</th>
                                                                                <th class="dark_bg sorting" tabindex="0"
                                                                                    aria-controls="example" rowspan="1"
                                                                                    colspan="1"
                                                                                    aria-label="Amount: activate to sort column ascending"
                                                                                    style="width: 156px;">Rank</th>
                                                                                <th class="dark_bg sorting" tabindex="0"
                                                                                    aria-controls="example" rowspan="1"
                                                                                    colspan="1"
                                                                                    aria-label="Percentage %: activate to sort column ascending"
                                                                                    style="width: 244px;">Active funds</th>
																				<th class="dark_bg sorting" tabindex="0"
                                                                                    aria-controls="example" rowspan="1"
                                                                                    colspan="1"
                                                                                    aria-label="Percentage %: activate to sort column ascending"
                                                                                    style="width: 156px;">Category Decile</th>
																				<th class="dark_bg sorting" tabindex="0"
                                                                                    aria-controls="example" rowspan="1"
                                                                                    colspan="1"
                                                                                    aria-label="Percentage %: activate to sort column ascending"
                                                                                    style="width: 156px;">Category Quartile</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="return_less_rank_table">
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 ">
                                                    <div class="px-3">
                                                        <p><?php echo e($fundWatch->rank_side); ?></p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- <section class="parametaer_cta_section">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-12 col-lg-6 mb-md-2">
                                        <div class="cta_parameter_graph">
                                            <<img src="<?php echo e(asset('themes/frontend/assets/v1/img/fund-watch-graph.jpg')); ?>" class="img-fluid"> 
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6">
                                        <div class="cta_prameter_content">
                                            <p>A scheme that has been over a decade in existence. In the initial period, there were enormous
                                                challenges that nearly threatened the existence of the scheme and perhaps the fund house too.
                                                Currently occupying the Large and midcap category and with a fund manager who has been in charge
                                                for all of its life brings a certain comfort to the investors, Mirae Asset Emerging Bluechip
                                                fund has occupied pole position in returns, recognition and asset growth since 2018.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>-->
                        <section class="pentatech_section">
                            <div class="container">
                                <div class="row mb-5">
                                    <div class="co-md-12">
                                        <div class="pentatech_inner_wrapper fund_watch_parameter_wrapper">
                                            <h2>Ratio Highlights</h2>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="pentatech_filter_title fund_watch_title m-3">
                                                        <h5>Risk Adjusted Alpha (Jensen’s) and The Risk Ratios</h5>
                                                    </div>
                                                    <div class="px-3">
                                                        <div class="">
                                                            <div class="datatable_ll main_trer performance_parameter_table">
                                                                <div class="table-responsive ">
                                                                    <table  class="table table-striped perftab" style="width:100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="dark_bg">Ratios</th>
                                                                                <th class="dark_bg">Jensen’s Alpha</th>
                                                                                <th class="dark_bg">Beta</th>
                                                                                <th class="dark_bg">Votality</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="risk_alpha_table">
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="px-3">
                                                        <p><?php echo e($fundWatch->risk_adjust_bottom); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="co-md-12">
                                        <div class="pentatech_inner_wrapper fund_watch_parameter_wrapper">
                                            <h2>Fund Composition Analysis</h2>
                                            <div class="col-md-12">
                                                <div class="px-3">
                                                    <div class="table-responsive">
													<table class="table table-striped dataTable no-footer fca" role="grid" style="width: 100%;">
															<thead class="">
																<tr>
																	<th class="sorting sorting_asc"> <?php echo e($dayn); ?></th>
																	<th class="sorting sorting_asc"> <?php echo e($day1n); ?></th>
																	<th class="sorting sorting_asc"> <?php echo e($day2n); ?></th>
																	<th class="sorting sorting_asc"> <?php echo e($day3n); ?></th>
																	<th class="sorting sorting_asc"> <?php echo e($day4n); ?></th>
                                                                    <!-- <th class="sorting sorting_asc"> Content % </th>-->
																</tr>
															</thead>
																<tbody>
																	
																	
																<?php if(!empty($fund_scrips) || !empty($fund_scrips1) || !empty($fund_scrips2) || !empty($fund_scrip3s) || !empty($fund_scrips4)): ?>
																	<?php for($i = 0; $i<10; $i++): ?>
																	<tr>
																		
																		<td><?php echo e($fund_scrips[$i]->scrip_name); ?><br><?php echo e($fund_scrips[$i]->qty); ?></td>
																		<td><?php echo e($fund_scrips1[$i]->scrip_name); ?><br><?php echo e($fund_scrips1[$i]->qty); ?></td>
																		<td><?php echo e($fund_scrips2[$i]->scrip_name); ?><br><?php echo e($fund_scrips2[$i]->qty); ?></td>
																		<td><?php echo e($fund_scrips3[$i]->scrip_name); ?><br><?php echo e($fund_scrips3[$i]->qty); ?></td>
																		<td><?php echo e($fund_scrips4[$i]->scrip_name); ?><br><?php echo e($fund_scrips4[$i]->qty); ?></td>
																	</tr>
																	<?php endfor; ?>
																<?php endif; ?>
																</tbody>
															</table>
													</div>
                                                </div>
										<p><?php echo e($fundWatch->composition_analysis_top); ?></p>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="co-md-12">
                                        <div class="pentatech_inner_wrapper fund_watch_parameter_wrapper">
											<h2>Portfolio Breakup</h2>
                                            <div class="pentatech_filter_title fund_watch_title m-3">
                                                
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="px-3">
                                                        <div class="">
                                                            <div class="datatable_ll main_trer performance_parameter_table">
                                                                <div class="table-responsive">
                                                                    <table id="example" class="table perftab table-striped dataTable no-footer" role="grid" style="width: 100%;">
                                                                        <thead class="">
                                                                            <tr>
                                                                                <th colspan="2" rowspan="1" style="background-color: rgb(34, 34, 34) !important;"></th>
                                                                                <th colspan="2" rowspan="1" style="background-color: rgb(34, 34, 34) !important;"> Debt </th>
                                                                                <th colspan="4" rowspan="1" style="background-color: rgb(34, 34, 34) !important;"> Equity </th>
                                                                                <th colspan="1" rowspan="1" style="background-color: rgb(34, 34, 34) !important;"></th>
                                                                                <th colspan="1" rowspan="1" style="background-color: rgb(34, 34, 34) !important;"></th>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Name of the Fund : activate to sort column descending" width="20%" style="text-align: left; width: 257px;" aria-sort="ascending"> Name of the Fund</th>
                                                                                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Cash% : activate to sort column ascending" width="9%" style="text-align: left; width: 100px;"> Cash% </th>
                                                                                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Sov% : activate to sort column ascending" width="9%" style="text-align: left; width: 100px;"> Sov% </th>
                                                                                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Corp Debt% : activate to sort column ascending" style="text-align: left; width: 102px;"> Corp <br>Debt% </th>
                                                                                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Small Cap% : activate to sort column ascending" style="text-align: left; width: 93px;"> Small <br>Cap% </th>
                                                                                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Mid Cap% : activate to sort column ascending" style="text-align: left; width: 93px;"> Mid <br>Cap% </th>
                                                                                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Large Cap% : activate to sort column ascending" style="text-align: left; width: 93px;"> Large<br> Cap% </th>
                                                                                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Very Large Cap&amp;nbsp;% : activate to sort column ascending" style="text-align: left; width: 103px;"> Very Large<br> Cap&nbsp;% </th>
                                                                                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Others : activate to sort column ascending" width="9%" style="text-align: left; width: 100px;"> Others </th>
                                                                                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Wt&amp;nbsp;PE : activate to sort column ascending" width="9%" style="text-align: left; width: 100px;"> Wt&nbsp;PE </th>
                                                                            </tr>
                                                                        </thead>
                                                                            <tbody class="portfolio_break_up">
                                                                            
                                                                            </tbody>
                                                                        </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="fund_watch_feedback mb-4">
                                            <h5>myplexus.com Feedback</h5>
                                            <p><?php echo e($fundWatch->feedback); ?></p>
                                        </div>
                                        <p class="dis"><i><b>Disclaimer:</b> <?php echo e($fundWatch->disclaimer); ?></i></p>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <input type="hidden" value="<?php echo e($AAUMValue); ?>" id="aaum_values">
                        <input type="hidden" value="<?php echo e($returnLessIndex); ?>" id="returnLessIndex">
                        <input type="hidden" value="<?php echo e($fundMaster->fund_code); ?>" id="fund_code">
                        <input type="hidden" value="<?php echo e($fundMaster->fund_type_id); ?>" id="fund_type">
                        <input type="hidden" value="<?php echo e($fundMaster->indices_name); ?>" id="indices_name">
                        <div id="loaging_image" class="d-none">
                            <img  class="text-center mt-3" src="<?php echo e(asset('themes/frontend/assets/v1/img/loading.gif')); ?>" alt="">
                        </div>
                    <?php $__env->stopSection(); ?>
                    <?php $__env->startPush('scripts'); ?>
                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
                        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
                        <script type="text/javascript">
                        let loadingImage='<img  class="text-center mt-3" src="<?php echo e(asset('themes/frontend/assets/v1/img/loading.gif')); ?>" alt="">';
                            google.charts.load('current', {
                                'packages': ['corechart']
                            });
                            google.charts.setOnLoadCallback(drawVisualization);
                            google.charts.setOnLoadCallback(drawreturnLessIndex);
                            let fund_code = $('#fund_code').val();
                            let indices_name = $('#indices_name').val();
                            let fund_type = $('#fund_type').val();
                            getReturnLessRank();
                            getFundCompostion();
                            schemeSIP();
                            getLumSum();
                            getRiskAdjustedAlpha();
                            getReturnContinus();
							getReturndisContinus();
                            getPortfolioBreakUp();

                            function drawVisualization() {
                                // Some raw data (not necessarily accurate)\
                                let aaum_data = $('#aaum_values').val();
								//console.log(aaum_data);
                                var data = google.visualization.arrayToDataTable(JSON.parse(aaum_data));
								
								
								var minYWithOffset = JSON.parse(aaum_data)[1][1] - (0.2 * JSON.parse(aaum_data)[1][1]);
								var maxYWithOffset = JSON.parse(aaum_data)[1][1] + (0.2 * JSON.parse(aaum_data)[1][1]);
								
                                var options = {
                                    title: "<?php echo e($fundMaster->fund_name); ?>",
									chartArea: { backgroundColor: '#eaf7d2' }, 
									backgroundColor: '#eaf7d2',
									vAxis: {
                                         format: "0.##"+"' Cr'",
										baseline: minYWithOffset,
										topline:maxYWithOffset
                                     },
									legend: {position: 'bottom'},
                                    // vAxis: {
                                    //     title: 'Cups'
                                    // },
                                    // hAxis: {
                                    //     title: 'Month'//
                                    // },
                                    seriesType: 'bars',
                                    colors: ['#3e3e40'],
                                    is3D:true,
                                    series: {
                                        5: {
                                            type: 'line'
                                        }
                                    }
                                };

                                var chart = new google.visualization.ComboChart(document.getElementById('aaum_chart_div'));
                                chart.draw(data, options);
                            }

                            function drawreturnLessIndex() {
                                // Some raw data (not necessarily accurate)\
                                let returnLessIndex = $('#returnLessIndex').val();
                                var data = google.visualization.arrayToDataTable(JSON.parse(returnLessIndex));

                                var options = {
                                    title: "<?php echo e($fundMaster->fund_name); ?>",
                                     vAxis: {
                                         format: "0.##"+"'%'",
                                     },
									chartArea: { backgroundColor: '#eaf7d2' }, 
									backgroundColor: '#eaf7d2',
									legend: {position: 'bottom'},
                                    // hAxis: {
                                    //     title: 'Month'
                                    // },
                                    seriesType: 'bars',
                                    colors: ['#3e3e40'],
                                    is3D:true,
                                    series: {
                                        5: {
                                            type: 'line'
                                        }
                                    }
                                };

                                var chart = new google.visualization.ComboChart(document.getElementById('returnLessIndex_chart_div'));
                                chart.draw(data, options);
                            }

                            function getFundCompostion() {
                                $('.comp_html').html(loadingImage);
                                axios.get('/fund-watch/fund-compositon/' + fund_code)
                                    .then(res => {
                                        if (res.data.status == 'success') {
                                            $('.comp_html').html(res.data.html);
                                        }
                                    })
                            }

                            function getLumSum() {
                                $('.lumsum_table_body').html(loadingImage);
                                axios.get('/fund-watch/fund-lumsum/' + fund_code)
                                    .then(res => {
                                        if (res.data.status == 'success') {
                                            $('.lumsum_table_body').html(res.data.html);
                                        }
                                    })
                            }

                            function getRiskAdjustedAlpha() {
                                $('.risk_alpha_table').html(loadingImage);
                                axios.get('/fund-watch/fund-risk-alpha/' + fund_code)
                                    .then(res => {
                                        if (res.data.status == 'success') {
                                            $('.risk_alpha_table').html(res.data.html);
                                        }
                                    })
                            }

                             /* function getPortfolioBreakUp() {
                                $('.portfolio_break_up').html(loadingImage);
                                axios.get('/fund-watch/fund-portfolio-break-up/' + fund_code)
                                    .then(res => {
                                        if (res.data.status == 'success') {
                                            $('.portfolio_break_up').html(res.data.html);
                                        }
                                    })
                            } */

                            function getPortfolioBreakUp() {
                                $('.portfolio_break_up').html(loadingImage);
                                axios.get('https://www.myplexus.com/api/v1/fund-composition-snapshot-fund-watch/' + fund_code+'/'+fund_type)
                                    .then(res => {
                                        //console.log(res.data.success);
                                        if (res.data.success == true) {
                                            let html = "";
                                           html += `<tr role="row">`;
                                            html += `<td data-label="Name of the Fund" class="sorting_1">${res.data.data.composition_snapshot_fundwatch[0].fund_name}</td>`;
                                            html += `<td data-label="Cash %">${res.data.data.composition_snapshot_fundwatch[0].cash}</td>`;
                                            html += `<td data-label="Sov %">${res.data.data.composition_snapshot_fundwatch[0].sov}</td>`;
                                            html += `<td data-label="Corp Debt %">${res.data.data.composition_snapshot_fundwatch[0].debt}</td>`;
                                            html += `<td data-label="Small Cap %">${res.data.data.composition_snapshot_fundwatch[0].eq_small}</td>`;
                                            html += `<td data-label="Mid Cap %">${res.data.data.composition_snapshot_fundwatch[0].eq_mid}</td>`;
                                            html += `<td data-label="Large Cap %">${res.data.data.composition_snapshot_fundwatch[0].eq_large}</td>`;
                                            html += `<td data-label="Very Large Cap %">${res.data.data.composition_snapshot_fundwatch[0].eq_very_large}</td>`;
                                            html += `<td data-label="Others value">${res.data.data.composition_snapshot_fundwatch[0].others_val}</td>`;
                                            html += `<td data-label="Wt . PE">${res.data.data.composition_snapshot_fundwatch[0].wt_pe}</td>`;
                                            html += `</tr>`;
											
											//console.log(html);

                                            $('.portfolio_break_up').html(html);
                                        } 
                                    })
                            }

                            function getReturnContinus() {
                                $('.retunr_continus_table').html(loadingImage);
                                axios.get('/fund-watch/fund-return-continus/' + fund_code)
                                    .then(res => {
                                        if (res.data.status == 'success') {
                                            $('.retunr_continus_table').html(res.data.html);
                                        }
                                    })
                            }
							function getReturndisContinus() {
                                $('.retunr_discontinus_table').html(loadingImage);
                                axios.get('/fund-watch/fund-return-discontinus/' + fund_code)
                                    .then(res => {
                                        if (res.data.status == 'success') {
                                            $('.retunr_discontinus_table').html(res.data.html);
                                        }
                                    })
                            }

                            function getReturnLessRank() {
                                $('.return_less_rank_table').html(loadingImage);
                                axios.get('/fund-watch/fund-return-less-rank/' + fund_code + '/' + fund_type + '/' + indices_name)
                                    .then(res => {
										console.log(fund_type + indices_name);
                                        if (res.data.status == 'success') {
                                            $('.return_less_rank_table').html(res.data.html);
                                        }
                                    })
                            }
                            async function schemeSIP() {
                                $('.sip_body').html(loadingImage);
                                await axios.get('/fund-watch/fund-sip/' + fund_code)
                                    .then(response => {
                                        let sipDataArr = response.data.scheme_sip_data
                                        for (var keyDur of Object.keys(sipDataArr)) {

                                            let all_values = JSON.parse(sipDataArr[keyDur].ALLVALUES)
                                            let all_dates = JSON.parse(sipDataArr[keyDur].ALLDATES)
                                            let sip_return = calculate_sip(all_dates, all_values)
                                            if (isNaN(sip_return)) {
                                                sip_return = '';
                                            } else {
                                                sip_return = parseFloat(sip_return).toFixed(2);
                                            }
											console.log(sip_return);
                                            sipDataArr[keyDur].sip_return = sip_return
                                        }
                                        let SIPHTML = '';
                                        $.each(sipDataArr, function(key, val) {
                                            SIPHTML += '<tr>';
                                            SIPHTML += '<td data-label="Time Frame">' + key + '</td>';
                                            SIPHTML += '<td data-label="Amount">' + parseFloat(val.CURRENTVALUE).toFixed(0) + '</td>';
                                            SIPHTML += '<td data-label="Percentage %"> ' + val.sip_return + '%</td>';
                                            SIPHTML += '</tr>';
                                        });
                                        $('.sip_body').html(SIPHTML);
                                        // console.log(sipDataArr, SIPHTML);
                                    })
                                    .catch(error => {
                                        //var message = error.response.data.message || error.message
                                        //console.log(error);
                                    })
                                    .finally(() => {
                                        // that.process = false
                                    })
                            }

                            function calculate_sip(dates, values) {
                                //alert(dates+' '+values);
                                var x = XIRR(values, dates, 0.1);
                                //alert(x);
                                x = x * 100;
                                //document.write(x);
                                return x;
                            }

                            function XIRR(values, dates, guess) {
                                // Credits: algorithm inspired by Apache OpenOffice

                                // Calculates the resulting amount
                                var irrResult = function(values, dates, rate) {
                                    var r = rate + 1;
                                    var result = values[0];
                                    for (var i = 1; i < values.length; i++) {
                                        result += values[i] / Math.pow(r, moment(dates[i]).diff(moment(dates[0]), 'days') / 365);
                                    }
                                    return result;
                                }

                                // Calculates the first derivation
                                var irrResultDeriv = function(values, dates, rate) {
                                    var r = rate + 1;
                                    var result = 0;
                                    for (var i = 1; i < values.length; i++) {
                                        var frac = moment(dates[i]).diff(moment(dates[0]), 'days') / 365;
                                        result -= frac * values[i] / Math.pow(r, frac + 1);
                                    }
                                    return result;
                                }

                                // Check that values contains at least one positive value and one negative value
                                var positive = false;
                                var negative = false;
                                for (var i = 0; i < values.length; i++) {
                                    if (values[i] > 0) positive = true;
                                    if (values[i] < 0) negative = true;
                                }

                                // Return error if values does not contain at least one positive value and one negative value
                                if (!positive || !negative) return '#NUM!';

                                // Initialize guess and resultRate
                                var guess = (typeof guess === 'undefined') ? 0.1 : guess;
                                var resultRate = guess;

                                // Set maximum epsilon for end of iteration
                                var epsMax = 1e-10;

                                // Set maximum number of iterations
                                var iterMax = 60;

                                // Implement Newton's method
                                var newRate, epsRate, resultValue;
                                var iteration = 0;
                                var contLoop = true;
                                do {
                                    resultValue = irrResult(values, dates, resultRate);
                                    newRate = resultRate - resultValue / irrResultDeriv(values, dates, resultRate);
                                    epsRate = Math.abs(newRate - resultRate);
                                    resultRate = newRate;
                                    contLoop = (epsRate > epsMax) && (Math.abs(resultValue) > epsMax);
                                } while (contLoop && (++iteration < iterMax));
                                if (contLoop) return '#NUM!';
                                // Return internal rate of return
                                return resultRate;
                            }
                        </script>
                    <?php $__env->stopPush(); ?>

<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/pages/fund_watch/details.blade.php ENDPATH**/ ?>