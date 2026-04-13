  
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

                    <?php $__env->startSection('vue-js'); ?> <?php $__env->stopSection(); ?>
                    <?php $__env->startSection('content'); ?>
                        <div class="custom-banner no-bg fw-banner <?php if(!$dataArr['image_path']): ?> fund-portfolio-banner <?php endif; ?>"
                            <?php if($dataArr['image_path']): ?> style="background-image:url(<?php echo e($dataArr['image_path']); ?>)" <?php endif; ?>>
                            <section class="inner_banner_section">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="inner_section_banner">
                                                <h4><?php echo e($dataArr['title']); ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <!---<div id="vue-app">
                            <compare-scheme image_path="<?php echo e(asset('themes/frontend/assets/v1/img/')); ?>"></compare-scheme>
                            <div class="clearfix">&nbsp;</div>
                        </div>--->
                        <section class="compare_scheme 2">
                            <div class="container">
                                <div class="comp_schem_bdr">
                                    <div class="tab_comp">
                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-home-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                                    aria-selected="true" onclick="clearData()">
                                                    <img src="https://new.myplexus.com/themes/frontend/assets/v1/img/tab_icon.png"
                                                        alt=""> Daily Price </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                                                    aria-selected="false" onclick="clearData()">
                                                    <img src="https://new.myplexus.com/themes/frontend/assets/v1/img/tab_icon1.png"
                                                        alt=""> Ratio </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                                                    aria-selected="false" onclick="clearData()">
                                                    <img src="https://new.myplexus.com/themes/frontend/assets/v1/img/tab_icon2.png"
                                                        alt=""> Composition </button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                            <div class="three_btn">
                                                <div class="row align-items-center justify-content-end">
                                                    <div class="col-lg-4 mb-2">
                                                        <div
                                                            class="middle_a d-flex align-items-center justify-content-md-end justify-content-center">
                                                            <a href="javascript:void(0)"  onclick="setYearSelect('1M', this)" class="sety">1M</a>
                                                            <a href="javascript:void(0)"  onclick="setYearSelect('3M', this)" class="sety">3M</a>
                                                            <a href="javascript:void(0)"  onclick="setYearSelect('6M', this)" class="sety">6M</a>
                                                            <a href="javascript:void(0)" onclick="setYearSelect('1Y', this)" class="sety active">1Y</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table_scc compare_section_div_str">
                                                <div class="row mb-1">
                                                    <div class="col-md-12 col-lg-6 pe-lg-1">
                                                        <div class="form_select border_top_left">
                                                            <div class="d-flex">
                                                                <button class="btn btn-primary active mr-1"
                                                                    onclick="main_type('funds', this)">Schemes</button>
                                                                <button class="btn btn-primary mr-1"
                                                                    onclick="main_type('indices', this)">Index</button>
                                                                <button class="btn btn-primary mr-1"
                                                                    onclick="main_type('currencies', this)">Currency</button>
                                                                <button class="btn btn-primary mr-1"
                                                                    onclick="main_type('comodity', this)">Commodity</button>
                                                            </div>
                                                            <select class="form-select form-select-lg js-example-basic-single" id="main_list">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-3 pe-lg-1 ps-lg-0">
                                                        <div class="form_select top_bg_right_black h-100">
                                                            <label for="">From Date</label>
                                                            <input class="form-date" id="frm_date" type="date">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-3 ps-lg-0">
                                                        <div class="form_select top_bg_right_black border_top_right h-100">
                                                            <label for="">To Date</label>
                                                            <input class="form-date" id="todate" type="date">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-lg-3 pe-lg-1 col-12 mb-1">
                                                        <div class="form_select bg_green border_bottom_left">
                                                            <div class="d-flex">
                                                                <button class="btn btn-primary active mr-11 w-45"
                                                                    onclick="first_child_type('funds', this)">Schemes</button>
                                                                <button class="btn btn-primary mr-11 w-45"
                                                                    onclick="first_child_type('indices', this)">Index</button>
                                                                <button class="btn btn-primary mr-11 w-45"
                                                                    onclick="first_child_type('currencies', this)">Currency</button>
                                                                <button class="btn btn-primary mr-11 w-45"
                                                                    onclick="first_child_type('comodity', this)">Commodity</button>
                                                            </div>
                                                            <select class="form-select form-select-lg js-example-basic-single"
                                                                id="first_child_list">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-lg-3 ps-lg-0 pe-lg-1 col-12 mb-1">
                                                        <div class="form_select bg_green">
                                                            <div class="d-flex">
                                                                <button class="btn btn-primary mr-12 w-45"
                                                                    onclick="second_child_type('funds', this)">Schemes</button>
                                                                <button class="btn btn-primary mr-12 w-45"
                                                                    onclick="second_child_type('indices', this)">Index</button>
                                                                <button class="btn btn-primary mr-12 w-45"
                                                                    onclick="second_child_type('currencies', this)">Currency</button>
                                                                <button class="btn btn-primary mr-12 w-45"
                                                                    onclick="second_child_type('comodity', this)">Commodity</button>
                                                            </div>
                                                            <select class="form-select form-select-lg js-example-basic-single"
                                                                id="second_child_list">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-lg-3 pe-lg-1 ps-lg-0 col-12 mb-1">
                                                        <div class="form_select bg_green">
                                                            <div class="d-flex">
                                                                <button class="btn btn-primary mr-13 w-45"
                                                                    onclick="third_child_type('funds', this)">Schemes</button>
                                                                <button class="btn btn-primary mr-13 w-45"
                                                                    onclick="third_child_type('indices', this)">Index</button>
                                                                <button class="btn btn-primary mr-13 w-45"
                                                                    onclick="third_child_type('currencies', this)">Currency</button>
                                                                <button class="btn btn-primary mr-13 w-45"
                                                                    onclick="third_child_type('comodity', this)">Commodity</button>
                                                            </div>
                                                            <select class="form-select form-select-lg js-example-basic-single"
                                                                id="third_child_list">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-lg-3 ps-lg-0 col-12">
                                                        <div class="form_select bg_green border_bottom_right">
                                                            <div class="d-flex">
                                                                <button class="btn btn-primary mr-14 w-45"
                                                                    onclick="fourth_child_type('funds', this)">Schemes</button>
                                                                <button class="btn btn-primary mr-14 w-45"
                                                                    onclick="fourth_child_type('indices', this)">Index</button>
                                                                <button class="btn btn-primary mr-14 w-45"
                                                                    onclick="fourth_child_type('currencies', this)">Currency</button>
                                                                <button class="btn btn-primary mr-14 w-45"
                                                                    onclick="fourth_child_type('comodity', this)">Commodity</button>
                                                            </div>
                                                            <select class="form-select form-select-lg js-example-basic-single"
                                                                id="fourth_child_list">
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="three_btn mt-3">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-4">
                                                        <div class="middle_left 3">                                                            
                                                            <button class="btn btn-success" onclick="compare()">Compare</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="middle_a d-flex align-items-center justify-content-center">                                

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center mt-3">
                                                <!--v-if-->
                                            </div>                                           
                                        </div>
                                        <!-- ratio calulation -->
                                         <?php echo $__env->make('web.pages.ratio-calculation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>                                        
                                        <!-- ratio calulation end-->

                                        
                                        <!-- composition  -->
                                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                            <div class="table_scc compare_section_div_str">
                                                <div class="">
                                                    <div class="row mb-1">
                                                        <div class="col-md-12 col-lg-5 pe-lg-1">
                                                            <div class="form_select border_top_left">
                                                                
															<div class="d-flex">
                                                                <button class="btn btn-primary active mr-1"
                                                                    onclick="composition_main_type('funds', this)">Schemes</button>
                                                                <button class="btn btn-primary mr-1"
                                                                    onclick="composition_main_type('indices', this)">Index</button>
                                                                
                                                            </div>
																<select class="form-select form-select-lg js-example-basic-single" id="composition_select_first">
                                                            </select>
                                                                <!-- <select class="form-select" id="composition_select_first">
                                                                    <option value="">Select</option>                                                                   
                                                                </select>-->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4 pe-sm-1 ps-lg-0">
                                                            <div class="form_select h-100">                                                               														<label for="">Category</label>
                                                                <select class="form-select" id="compostion_category">
                                                                    <option value="">Select</option>
                                                                    <option value="top_script">Top Scrip</option>
                                                                    <option value="top_industry">Top Industry</option>
                                                                    <option value="aaum">AAUM</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3 ps-lg-0">
                                                            <div class="form_select top_bg_right_black border_top_right h-100">
                                                                <label for="">Month / Year</label>
                                                            <input type="month" id="start" name="start" min="2000-03" value="<?=date('Y-m');?>" style="
    width: 100%;
    padding: 8px;
    border-radius: 7px;
">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 col-lg-3 pe-lg-1 col-6 mb-1">
                                                            <div class="form_select bg_green border_bottom_left">
                                                                <div class="d-flex">
																	<button class="btn btn-primary active mr-2 w-45"
																		onclick="composition_main_type_one('funds', this)">Schemes</button>
																	<button class="btn btn-primary mr-2 w-45"
																		onclick="composition_main_type_one('indices', this)">Index</button>
																	
                                                            	</div>
                                                                <select class="form-select form-select-lg js-example-basic-single" id="composition_select_two">
                                                                    
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-lg-3 ps-lg-0 pe-lg-1 col-6">
                                                            <div class="form_select bg_green">
                                                                <div class="d-flex">
																	<button class="btn btn-primary active mr-3 w-45"
																		onclick="composition_main_type_two('funds', this)">Schemes</button>
																	<button class="btn btn-primary mr-3 w-45"
																		onclick="composition_main_type_two('indices', this)">Index</button>
																	
                                                            	</div>
                                                                <select class="form-select form-select-lg js-example-basic-single" id="composition_select_three">
                                                                                                                                    
                                                                </select>
                                                            </div>
                                                        </div>
														<div class="col-md-12 col-lg-3 ps-lg-0 pe-lg-1 col-6">
                                                            <div class="form_select bg_green">
                                                                <div class="d-flex">
																	<button class="btn btn-primary active mr-4 w-45"
																		onclick="composition_main_type_three('funds', this)">Schemes</button>
																	<button class="btn btn-primary mr-4 w-45"
																		onclick="composition_main_type_three('indices', this)">Index</button>
																	
                                                            	</div>
                                                                <select class="form-select form-select-lg js-example-basic-single" id="composition_select_four">                                                                    
                                                                </select>
                                                            </div>
                                                        </div>
														<div class="col-md-12 col-lg-3 ps-lg-0 pe-lg-1 col-6">
                                                            <div class="form_select bg_green">
                                                                <div class="d-flex">
																	<button class="btn btn-primary active mr-5 w-45"
																		onclick="composition_main_type_four('funds', this)">Schemes</button>
																	<button class="btn btn-primary mr-5 w-45"
																		onclick="composition_main_type_four('indices', this)">Index</button>
																	
                                                            	</div>
                                                                <select class="form-select form-select-lg js-example-basic-single" id="composition_select_five">                                                                    
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="three_btn mt-3">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-4">
                                                        <div class="middle_left 1">
                                                            <button class="btn btn-success" id="compostion_btn">Compare</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            <div class="mt-5" style="">
                                                <div id="loader" style="display: none;">
                                                    <img src="<?php echo e(asset('themes/frontend/assets/v1/img/spinning-loading.gif')); ?>" width="150px" height="100px" alt="" />
                                                </div>
                                                <div class="dy-table-wrap row showrslt" id="compose_table">                                                    
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="text-center mt-3">                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <!-- composition end -->
                                    </div>
                                </div>

                                <div id="price_loader" style="display: none;">
                                                    <img src="<?php echo e(asset('themes/frontend/assets/v1/img/spinning-loading.gif')); ?>" width="150px" height="100px" alt="" />
                                </div>

                                <div class="text-center mt-3">
                                    <div id="container1" class="showrslt"></div>
                                </div>
                                <div class="text-center mt-3">
                                    <div id="container2" class="showrslt"></div>
                                </div>
                                <div class="text-center mt-3">
                                    <div id="container3" class="showrslt"></div>
                                </div>
                                <div class="text-center mt-3">
                                    <div id="container4" class="showrslt"></div>
                                </div>
                            </div>
                        </section>
                    <?php $__env->stopSection(); ?>
                    <?php $__env->startPush('style'); ?>
                    <?php $__env->stopPush(); ?>

                    <?php $__env->startPush('scripts'); ?>
                    <!-- <script src="https://code.highcharts.com/highcharts.js"></script>
                    <script src="https://code.highcharts.com/modules/series-label.js"></script>
                    <script src="https://code.highcharts.com/modules/exporting.js"></script>
                    <script src="https://code.highcharts.com/modules/export-data.js"></script>
                    <script src="https://code.highcharts.com/modules/accessibility.js"></script> -->

                        <script>
                            let basePath = "https://myplexus.com/api/v1/";
                            let compareBasePath = 'https://myplexus.com/api/v2/';
                            let from_date = "";
                            let to_date = "";
                            let value1 = value2 = value3 = value4 = value5 = value6 = "";
                            let compare_type = compare_type1 = compare_type2 = compare_type3 = compare_type4 = "";
                            let compare_type_composition = compare_type1_composition = compare_type2_composition = compare_type3_composition = compare_type4_composition = compare_type5_composition = "";
                            let compare_composition = compare1_composition = compare2_composition = compare3_composition = compare4_composition = "";
                            let compare1 = compare2 = compare3 = compare4 = "";
                            let value1_text = value2_text = value3_text = value4_text = value5_text = "";

                            $('document').ready(function() {
								
								let active_url = window.location.href;
								var activeTab = active_url.substring(active_url.indexOf("=") + 1);
								console.log('Active Tab:'+activeTab);
								
								if( activeTab == 'information_ratio')
								{
									$(".nav-link").removeClass("active");
									$('.tab-pane').removeClass("active show");
									$('#pills-profile-tab').addClass("active");
									$('#pills-profile').addClass('active show');
									
								} else if( activeTab == 'scheme_scheme' )
								{
									$(".nav-link").removeClass("active");
									$('.tab-pane').removeClass("active show");
									$('#pills-home-tab').addClass("active");
									$('#pills-home').addClass('active show');
									
								} else if( activeTab == 'top_industry' )
								{
									$(".nav-link").removeClass("active");
									$('.tab-pane').removeClass("active show");
									$('#pills-contact-tab').addClass("active");
									$('#pills-contact').addClass('active show');
								}

                                getFunds('main_list');
                                getFunds('first_child_list');

                                getFunds('composition_select_first');
                                getFunds('composition_select_two');
                                getFunds('composition_select_three');
                                getFunds('composition_select_four');
                                getFunds('composition_select_five');

                                compare_type_composition = "scheme";
                                compare_type1_composition = "scheme";
                                compare_type2_composition = "scheme";
                                compare_type3_composition = "scheme";
                                compare_type4_composition = "scheme";

                                let new_date = new Date();
                                new_date.setFullYear(new_date.getFullYear() - 1);
                                from_date = new_date.getFullYear() + '-' + (new_date.getMonth() + 1) + '-' + new_date.getDate();
                                //console.log(from_date);
								
								//$("#start").val(new_date.getFullYear());

                                let to_new_date = new Date();
                                to_date = to_new_date.getFullYear() + '-' + (to_new_date.getMonth() + 1) + '-' + to_new_date.getDate();
                                //console.log(to_date);

                                compare_type = "scheme";
                                compare_type1 = "scheme";

                                /* let main_types = ["fund", "index", "currency"];
                                let second_main_types = ["fund", "index", "currency"];
                                let third_main_types = ["fund", "index", "currency"];
                                let fourth_main_types = ["fund", "index", "currency"];
                                let fifth_main_types = ["fund", "index", "currency"];

                                let main_cate_type = main_types[0];
                                let second_cate_type = second_main_types[1];
                                let third_cate_type = third_main_types[2];
                                let fourth_cate_type = fourth_main_types[3];
                                let fifth_cate_type = fifth_main_types[1];

                                let basePath = "https://new.myplexus.com/api/";

                                        $.ajax({
                                                type:'GET',
                                                url: basePath+"v1/funds",  
                                                success: function(data) {
                                                    console.log(data);
                                                }
                                        });

                                        $.ajax({
                                                type:'GET',
                                                url: basePath+"v1/indices",  
                                                success: function(data) {
                                                    console.log(data);
                                                }
                                        });

                                        $.ajax({
                                                type:'GET',
                                                url: basePath+"v1/currencies",  
                                                success: function(data) {
                                                    console.log(data);
                                                }
                                        }); */
                            });


                            function first_child_type(cate_type, e) {
                                console.log(e);

                                $('.mr-11').each(function() {
                                    this.classList.remove('active');
                                });                               
                                    let url = basePath + cate_type;

                                    if (cate_type == "funds") {
                                        e.classList.add('active');
                                        getFunds('first_child_list');
                                        compare_type1 = "scheme";
                                    }

                                    if (cate_type == "indices") {
                                        e.classList.add('active');
                                        getIndices('first_child_list');
                                        compare_type1 = "index";
                                    }

                                    if (cate_type == "currencies") {
                                        e.classList.add('active');
                                        getCurrencies('first_child_list');
                                        compare_type1 = "currency";
                                    }

                                    if (cate_type == "comodity") {
                                        e.classList.add('active');
                                        getComodities('first_child_list');
                                        compare_type1 = "currency";
                                    }

                                
                            }

                            function second_child_type(cate_type, e) {
                                console.log(e);

                                $('.mr-12').each(function() {
                                    this.classList.remove('active');
                                });

                                
                                    let url = basePath + cate_type;

                                    if (cate_type == "funds") {
                                        e.classList.add('active');
                                        getFunds('second_child_list');
                                        compare_type2 = "scheme";
                                    }

                                    if (cate_type == "indices") {
                                        e.classList.add('active');
                                        getIndices('second_child_list');
                                        compare_type2 = "index";
                                    }

                                    if (cate_type == "currencies") {
                                        e.classList.add('active');
                                        getCurrencies('second_child_list');
                                        compare_type2 = "currency";
                                    }

                                    if (cate_type == "comodity") {
                                        e.classList.add('active');
                                        getComodities('second_child_list');
                                        compare_type2 = "currency";
                                    }

                                
                            }


                            function third_child_type(cate_type, e) {
                                console.log(e);

                                $('.mr-13').each(function() {
                                    this.classList.remove('active');
                                });                               
                                    let url = basePath + cate_type;

                                    if (cate_type == "funds") {
                                        e.classList.add('active');
                                        getFunds('third_child_list');
                                        compare_type3 = "scheme";
                                    }

                                    if (cate_type == "indices") {
                                        e.classList.add('active');
                                        getIndices('third_child_list');
                                        compare_type3 = "index";
                                    }

                                    if (cate_type == "currencies") {
                                        e.classList.add('active');
                                        getCurrencies('third_child_list');
                                        compare_type3 = "currency";
                                    }

                                    if (cate_type == "comodity") {
                                        e.classList.add('active');
                                        getComodities('third_child_list');
                                        compare_type3 = "currency";
                                    }

                                
                            }

                            function fourth_child_type(cate_type, e) {
                                console.log(e);

                                $('.mr-14').each(function() {
                                    this.classList.remove('active');
                                });                                
                                    let url = basePath + cate_type;

                                    if (cate_type == "funds") {
                                        e.classList.add('active');
                                        getFunds('fourth_child_list');
                                        compare_type4 = "scheme";
                                    }

                                    if (cate_type == "indices") {
                                        e.classList.add('active');
                                        getIndices('fourth_child_list');
                                        compare_type4 = "index";
                                    }

                                    if (cate_type == "currencies") {
                                        e.classList.add('active');
                                        getCurrencies('fourth_child_list');
                                        compare_type4 = "currency";
                                    }

                                    if (cate_type == "comodity") {
                                        e.classList.add('active');
                                        getComodities('fourth_child_list');
                                        compare_type4 = "currency";
                                    }
                                
                            }

                            function composition_main_type(cate_type, e)
                            {
                                $('.mr-1').each(function() {
                                    this.classList.remove('active');
                                });

                                    let url = basePath + cate_type;

                                    if (cate_type == "funds") {
                                        e.classList.add('active');
                                        getFunds('composition_select_first');
										if( $("#compostion_category option[value='aaum']").length <= 0 )
										{
											$("#compostion_category").append('<option value="aaum">AAUM</option>');
										}
                                         compare_type_composition = "scheme"; 										
                                        //compare_type = "scheme";
                                    }

                                    if (cate_type == "indices") {
                                        e.classList.add('active');
                                        getIndices('composition_select_first');
										$("#compostion_category option[value='aaum']").remove();
                                        //compare_type = "index";
                                        compare_type_composition = "index";
                                    }
                            }

                            function composition_main_type_one(cate_type, e)
                            {
                                $('.mr-2').each(function() {
                                    this.classList.remove('active');
                                });

                                    let url = basePath + cate_type;

                                    if (cate_type == "funds") {
                                        e.classList.add('active');
                                        getFunds('composition_select_two');
										if( $("#compostion_category option[value='aaum']").length <= 0 )
										{
											$("#compostion_category").append('<option value="aaum">AAUM</option>');
										}
                                        //compare_type = "scheme";
                                        compare_type1_composition = "scheme";
                                    }

                                    if (cate_type == "indices") {
                                        e.classList.add('active');
                                        getIndices('composition_select_two');
										$("#compostion_category option[value='aaum']").remove();
                                        //compare_type = "index";
                                        compare_type1_composition = "index";
                                    }
                            }

                            function composition_main_type_two(cate_type, e)
                            {
                                $('.mr-3').each(function() {
                                    this.classList.remove('active');
                                });

                                    let url = basePath + cate_type;

                                    if (cate_type == "funds") {
                                        e.classList.add('active');
                                        getFunds('composition_select_three');
										if( $("#compostion_category option[value='aaum']").length <= 0 )
										{
											$("#compostion_category").append('<option value="aaum">AAUM</option>');
										}
                                        //compare_type = "scheme";
                                        compare_type2_composition = "scheme";
                                    }

                                    if (cate_type == "indices") {
                                        e.classList.add('active');
                                        getIndices('composition_select_three');
										$("#compostion_category option[value='aaum']").remove();
                                        //compare_type = "index";
                                        compare_type2_composition = "index";
                                    }
                            }

                            function composition_main_type_three(cate_type, e)
                            {
                                $('.mr-4').each(function() {
                                    this.classList.remove('active');
                                });

                                    let url = basePath + cate_type;

                                    if (cate_type == "funds") {
                                        e.classList.add('active');
                                        getFunds('composition_select_four');
										if( $("#compostion_category option[value='aaum']").length <= 0 )
										{
											$("#compostion_category").append('<option value="aaum">AAUM</option>');
										}
                                        //compare_type = "scheme";
                                        compare_type3_composition = "scheme";
                                    }

                                    if (cate_type == "indices") {
                                        e.classList.add('active');
                                        getIndices('composition_select_four');
										$("#compostion_category option[value='aaum']").remove();
                                        //compare_type = "index";
                                        compare_type3_composition = "index";
                                    }
                            }

                            function composition_main_type_four(cate_type, e)
                            {
                                $('.mr-5').each(function() {
                                    this.classList.remove('active');
                                });

                                    let url = basePath + cate_type;

                                    if (cate_type == "funds") {
                                        e.classList.add('active');
                                        getFunds('composition_select_five');
										if( $("#compostion_category option[value='aaum']").length <= 0 )
										{
											$("#compostion_category").append('<option value="aaum">AAUM</option>');
										}
                                        //compare_type = "scheme";
                                        compare_type4_composition = "scheme";
                                    }

                                    if (cate_type == "indices") {
                                        e.classList.add('active');
                                        getIndices('composition_select_five');
										$("#compostion_category option[value='aaum']").remove();
                                        //compare_type = "index";
                                        compare_type4_composition = "index";
                                    }
                            }

                            function main_type(cate_type, e) {
                                console.log(e);

                                $('.mr-1').each(function() {
                                    this.classList.remove('active');
                                });

                                    let url = basePath + cate_type;

                                    if (cate_type == "funds") {
                                        e.classList.add('active');
                                        getFunds('main_list');
                                        compare_type = "scheme";
                                    }

                                    if (cate_type == "indices") {
                                        e.classList.add('active');
                                        getIndices('main_list');
                                        compare_type = "index";
                                    }

                                    if (cate_type == "currencies") {
                                        e.classList.add('active');
                                        getCurrencies('main_list');
                                        compare_type = "currency";
                                    }

                                    if (cate_type == "comodity") {
                                        e.classList.add('active');
                                        getComodities('main_list');
                                        compare_type = "currency";
                                    }                               
                            }
							
							function setYearSelect(id, e)
                            {
                                $('.sety').each(function() {
                                    this.classList.remove('active');
                                });
								
								 $('#frm_date').val('');
                                $('#todate').val('');

                                var today = new Date();
                                var dd = String(today.getDate());
                                var mm = String(today.getMonth() + 1); //January is 0!
                                var yyyy = today.getFullYear();

                                to_date = yyyy+'-'+mm+'-'+dd;

                                if(id == '1M')
                                {
                                    from_date = getToDate(1, 'M', to_date);
                                    e.classList.add('active');

                                } else if(id == '3M')
                                {
                                    from_date = getToDate(3, 'M', to_date);
                                    e.classList.add('active');

                                } else if(id == '6M')
                                {
                                    from_date = getToDate(6, 'M', to_date);
                                    e.classList.add('active');

                                } else if(id == '1Y')
                                {
                                    from_date = getToDate(12, 'M', to_date);
                                    e.classList.add('active');
                                }

                                console.log(from_date+'####'+to_date);
                            }

                            function getToDate(duration, duration_type, frm_date)
                            {
								console.log(frm_date);
								
                                toDate = new Date(frm_date);
                                let dd = mm = yyyy = "";
								
								console.log(toDate);

                                if(duration_type == 'M')
                                {
                                    if(duration == 1)
                                    {
                                        dd = String(toDate.getDate());                                        
                                        mm = String(toDate.getMonth()); //January is 0!
                                        yyyy = toDate.getFullYear();
										
										//console.log(yyyy);

                                    } else 
                                    {
                                        dd = String(toDate.getDate());
                                        toDate.setMonth((toDate.getMonth() + 1) - duration);
                                        mm = String(toDate.getMonth()); //January is 0!
                                        yyyy = toDate.getFullYear();
                                    }                                   

                                } 

                                toDate = yyyy+'-'+mm+'-'+dd;

                                return toDate;

                            }

                            function getFunds(id) {
                                let url = basePath + 'funds';

                                $.ajax({
                                    type: 'GET',
                                    url: url,
                                    success: function(data) {
                                        console.log(data);

                                        if (data.success) {
                                            let html = "";

                                            if (data.data.length >= 1) {
                                                html += '<option value="">Select Scheme</option>';

                                                for (i = 0; i < data.data.length; i++) {
                                                    html += '<option value="' + data.data[i].fund_code + '">' + data.data[i]
                                                        .fund_name + '</option>'
                                                }
                                            }

                                            $('#' + id).html(html);

                                        }
                                    }
                                });
                            }

                            function getIndices(id) {
                                let url = basePath + 'indices';

                                $.ajax({
                                    type: 'GET',
                                    url: url,
                                    success: function(data) {
                                        console.log(data);

                                        if (data.success) {
                                            let html = "";

                                            if (data.data.length >= 1) {
                                                html += '<option value="">Select Index</option>';

                                                for (i = 0; i < data.data.length; i++) {
                                                    html += '<option value="' + (i + 1) + '">' + data.data[i].name + '</option>'
                                                }
                                            }

                                            $('#' + id).html(html);

                                        }
                                    }
                                });
                            }

                            function getCurrencies(id) {
                                let url = basePath + 'currencies';

                                $.ajax({
                                    type: 'GET',
                                    url: url,                                    
                                    success: function(data) {
                                        console.log(data);

                                        if (data.success) {
                                            let html = "";

                                            if (data.data.length >= 1) {
                                                html += '<option value="">Select Currency</option>';									
												
												
                                                for (i = 0; i < data.data.length; i++) {
                                                    if( data.data[i].is_comodity == 0 )
                                                    {
                                                        html += '<option value="' + data.data[i].cm_id + '">' + data.data[i].name +
                                                        '</option>'
                                                    }
                                                    
                                                }
                                            }
												
											
                                            $('#' + id).html(html);
                                        }
                                    }
                                });
                            }

                            function getComodities(id) {
                                let url = basePath + 'currencies';

                                $.ajax({
                                    type: 'GET',
                                    url: url,                                    
                                    success: function(data) {
                                        console.log(data);

                                        if (data.success) {
                                            let html = "";

                                            if (data.data.length >= 1) {
                                                html += '<option value="">Select Comodity</option>';

                                                for (i = 0; i < data.data.length; i++) {
                                                    if( data.data[i].is_comodity == 1 )
                                                    {
                                                        html += '<option value="' + data.data[i].cm_id + '">' + data.data[i].name +
                                                        '</option>'
                                                    }
                                                    
                                                }
                                            }

                                            $('#' + id).html(html);
                                        }
                                    }
                                });
                            }

                            $('#compostion_btn').on('click', function() {

                                let compare_type = "";
                                let value1 = "";
                                let value1_selected_text = "";
                                let value2 = "";
                                let value2_selected_text = "";
                                let value3 = "";
                                let value3_selected_text = "";
                                let value4 = "";
                                let value4_selected_text = "";
                                let value5 = "";
                                let value5_selected_text = "";
                                let year_month = [];
                                let composition_month = "";
                                let composition_year = "";
                                let compare_url = "";
                                
                                compare_type = $('#compostion_category').val();

                                if(compare_type_composition == 'scheme')
                                {
                                    value1 = $('#composition_select_first').val();

                                } else if( compare_type1_composition == 'index' ) {

                                    value1 =  $('#composition_select_first').val() != "" ? $('#composition_select_first option:selected').text() : "";

                                }   

                                value1_selected_text = $('#composition_select_first').val() != "" ? $('#composition_select_first option:selected').text() : "";

                                if( compare_type1_composition == 'scheme' )
                                {

                                    value2 = $('#composition_select_two').val();

                                } else if( compare_type1_composition == 'index' ) {

                                    value2 = $('#composition_select_two').val() != "" ? $('#composition_select_two option:selected').text() : "";
                                }

                                value2_selected_text = $('#composition_select_two').val() != "" ? $('#composition_select_two option:selected').text() : "";


                                if(compare_type2_composition == 'scheme')
                                {

                                    value3 = $('#composition_select_three').val();

                                } else if( compare_type2_composition == 'index' ) {

                                    value3 = $('#composition_select_three').val() != "" ? $('#composition_select_three option:selected').text() : "";

                                }
                                
                                value3_selected_text = $('#composition_select_three').val() != "" ? $('#composition_select_three option:selected').text() : "";


                                if( compare_type3_composition == 'scheme' )
                                {
                                    value4 = $('#composition_select_four').val();

                                } else if( compare_type3_composition == 'index' ) {

                                    value4 = $('#composition_select_four').val() != "" ? $('#composition_select_four option:selected').text() : "";

                                }
                                
                                value4_selected_text = $('#composition_select_four').val() != "" ? $('#composition_select_four option:selected').text() : "";


                                if( compare_type4_composition == 'scheme' )
                                {
                                    value5 = $('#composition_select_five').val();

                                } else if( compare_type4_composition == 'index' ) {

                                    value5 = $('#composition_select_five').val() != "" ? $('#composition_select_five option:selected').text() : "";
                                }
                                
                                value5_selected_text = $('#composition_select_five').val() != "" ? $('#composition_select_five option:selected').text() : "";

                                if( compare_type != "" && value1 != "" && ( value2 != "" || value3 != "" || value4 != "" || value5 != "" ) && $('#start').val() != "" )
                                {
                                    if( value1 != "" && value2 != "" )
                                    {
										console.log('testing: '+value2);
                                        compare_composition = compare_type_composition+"_"+compare_type1_composition;
										
                                    } else {
										
										compare_composition = "";
									}

                                    if( value1 != "" && value3 != "" )
                                    {
                                        compare1_composition = compare_type_composition+"_"+compare_type2_composition;
										
                                    } else {
										
										compare1_composition = "";
									
									}                                    

                                    if( value1 != "" && value4 != "" )
                                    {
                                        compare2_composition = compare_type_composition+"_"+compare_type3_composition;
										
                                    } else {
										
										compare2_composition = "";
									}

                                    if( value1 != "" && value5 != "" )
                                    {
                                        compare3_composition = compare_type_composition+"_"+compare_type4_composition;
										
                                    } else {
										
										compare3_composition = "";
									
									}
                                                                         
                                    year_month = $('#start').val().split('-');

                                    if(parseInt(year_month[1]) < 10)
                                    {                                        
                                        year_month[1] = year_month[1].replace(/^0+/, '');
                                    } 

                                    composition_year = year_month[0];
                                    composition_month = year_month[1];

                                    compare_url = 'https://www.myplexus.com/api/v1/compare-compositions';

                                    $.ajax({
                                        type: 'GET',
                                        url: compare_url,
                                        data: {
                                            value1: value1,
                                            value2: value2,
                                            value3: value3,
                                            value4: value4,
                                            value5: value5,                                           
                                            compare_type: compare_type,
                                            month: composition_month,
                                            year: composition_year,
                                            compare1: compare_composition,
                                            compare2: compare1_composition,
                                            compare3: compare2_composition,
                                            compare4: compare3_composition
                                            /* compare5: compare4_composition */
                                        },

                                        beforeSend: function() {                                            
                                            $('#compose_table').html("");
                                            $('#loader').css('display', 'block');
                                        },

                                        success: function(data) {                                  

                                            if(data.success)
                                            {
												
												console.log(data);

                                                //console.log(data.data.composition_data.scheme1.data.length);
												 $('.showrslt').html("");
                                                $('#compose_table').html("");

                                                if( compare_type == 'top_script' || compare_type == 'top_industry' )
                                                {
                                                    let html = "";

                                                    if( data.data.composition_data.scheme1.data.length >= 1 )
                                                    {
                                                        html += buildHtml(compare_type, value1_selected_text, data.data.composition_data.scheme1);

                                                        if(data.data.composition_data.scheme2)
                                                        {
                                                            if( data.data.composition_data.scheme2.data.length >= 1 )
                                                            {
                                                                html += buildHtml(compare_type, value2_selected_text, data.data.composition_data.scheme2);
                                                            }
                                                        }
                                                        
                                                        if(data.data.composition_data.scheme3)
                                                        {
                                                            if( data.data.composition_data.scheme3.data.length >= 1 )
                                                            {
                                                                html += buildHtml(compare_type, value3_selected_text, data.data.composition_data.scheme3);
                                                            }
                                                        }

                                                        if(data.data.composition_data.scheme4)
                                                        {
                                                            if( data.data.composition_data.scheme4.data.length >= 1 )
                                                            {
                                                                html += buildHtml(compare_type, value4_selected_text, data.data.composition_data.scheme4);
                                                            }
                                                        }

                                                        if( data.data.composition_data.scheme5 )
                                                        {
                                                            if( data.data.composition_data.scheme5.data.length >= 1 )
                                                            {
                                                                html += buildHtml(compare_type, value5_selected_text, data.data.composition_data.scheme5);
                                                            }
                                                        }                                                                                               
                                                    }

                                                    $('#compose_table').html(html);  


                                                } else {
                                                    
                                                    var html_auum = "";

                                                    if( data.data.composition_data.scheme1)
                                                    {
                                                        html_auum += '<div class="dy-table-block br-5 col-md-6">';                                    
                                                        html_auum += '<table class="box-shadow com-table">';
                                                        html_auum += '<tr>';
                                                        html_auum += '<th class="bg-gray text-white" style="width: 80% !important;">Name Of Fund</th>';
                                                        html_auum += '<th class="bg-gray text-white" style="min-width: 130px;">AAUM</th>';
                                                        html_auum += '</tr>';
                                                        html_auum += '<tbody>';

                                                            

                                                            console.log(html_auum);

                                                        html_auum += buildHtml(compare_type, value1_selected_text, data.data.composition_data.scheme1);

                                                        if(data.data.composition_data.scheme2)
                                                        {                                                            
                                                                html_auum += buildHtml(compare_type, value2_selected_text, data.data.composition_data.scheme2);
                                                           
                                                        }
                                                        
                                                        if(data.data.composition_data.scheme3)
                                                        {                                                            
                                                                html_auum += buildHtml(compare_type, value3_selected_text, data.data.composition_data.scheme3);
                                                            
                                                        }

                                                        if(data.data.composition_data.scheme4)
                                                        {
                                                           
                                                                html_auum += buildHtml(compare_type, value4_selected_text, data.data.composition_data.scheme4);
                                                            
                                                        }

                                                        if( data.data.composition_data.scheme5 )
                                                        {
                                                            
                                                                html_auum += buildHtml(compare_type, value5_selected_text, data.data.composition_data.scheme5);
                                                            
                                                        }
                                                        
                                                        html_auum += '</tbody>';
                                                        html_auum += '</table>';
                                                        html_auum += '</div>';                                                        
                                                        
                                                    }

                                                    $('#compose_table').html(html_auum);


                                                }

                                                
                                                
                                                 
                                                    
                                            }
                                            
                                        },
                                        complete:function(data){
                                            // Hide image container
                                            $("#loader").hide();
                                           
                                        }
                                    });
                                }

                            });

                            function buildHtml(compare_type, hd_text, scheme_data)
                            {
                                var html = "";
                                console.log(hd_text);

                                if(compare_type == 'top_script')
                                {
                                    html += '<div class="dy-table-block br-5 col-md-6">';
                                    html += '<p class="text-white mb-2">'+hd_text+'</p>';
                                    html += '<table class="box-shadow com-table">';
                                    html += '<tr>';
                                    html += '<th class="bg-gray text-white" style="width: 80% !important;">Scrips</th>';
                                    html += '<th class="bg-gray text-white" style="min-width: 130px;">Content%</th>';
                                    html += '</tr>';
                                    html += '<tbody>';
                                    for(let i=0; i< scheme_data.data.length; i++)
                                    {
                                        html += '<tr><td class="modal-td">'+scheme_data.data[i].scrip_name+'</td><td>'+scheme_data.data[i].content_per.toFixed(2)+'</td></tr>';
                                    }                                                       
                                    html += '<tr>';
                                    html += '<td>Total Of Top 10</td>';
                                    html += '<td class="modal-td-dark">'+scheme_data.top_scripts_sum.toFixed(2)+'</td>';
                                    html += '</tr>';
                                    html += '</tbody>';
                                    html += '</table>';
                                    html += '</div>';

                                } else if(compare_type == 'top_industry')
                                {
                                    html += '<div class="dy-table-block br-5 col-md-6">';
                                    html += '<p class="text-white mb-2">'+hd_text+'</p>';
                                    html += '<table class="box-shadow com-table">';
                                    html += '<tr>';
                                    html += '<th class="bg-gray text-white" style="width: 80% !important;">Industries</th>';
                                    html += '<th class="bg-gray text-white" style="min-width: 130px;">Content%</th>';
                                    html += '</tr>';
                                    html += '<tbody>';
                                    for(let i=0; i< scheme_data.data.length; i++)
                                    {
                                        html += '<tr><td class="modal-td">'+scheme_data.data[i].industry+'</td><td>'+scheme_data.data[i].industry_content_per.toFixed(2)+'</td></tr>';
                                    }                                                       
                                    html += '<tr>';
                                    html += '<td>Total Of Top 10</td>';
                                    html += '<td class="modal-td-dark">'+scheme_data.top_industry_sum.toFixed(2)+'</td>';
                                    html += '</tr>';
                                    html += '</tbody>';
                                    html += '</table>';
                                    html += '</div>';

                                } else {                                   
                                    html += '<tr><td class="modal-td">'+hd_text+'</td><td>'+scheme_data.data.corpus_entry.toFixed(2)+'</td></tr>';                                 
                                }

                                

                                return html;
                            }

                            function compare() {
								
								if($('#frm_date').val() != "" && $('#todate').val() != "")
                                {
                                    //console.log( $('#frm_date').val()+'###'+$('#todate').val() );

                                    to_date = $('#todate').val();
                                    from_date = $('#frm_date').val();
									
										$('.sety').each(function() {
										this.classList.remove('active');
									});
                                }

                                if (compare_type == 'scheme' || compare_type == 'currency' || compare_type == 'comodity') {
                                    value1 = $('#main_list').val();
                                    value1_text = $('#main_list option:selected').text();

                                } else {

                                    value1 = $('#main_list option:selected').text();
                                    value1_text = $('#main_list option:selected').text();
                                }

                                if (compare_type1 == 'scheme' || compare_type1 == 'currency' || compare_type1 == 'comodity' ) {
                                    value2 = $('#first_child_list').val();
                                    value2_text = $('#first_child_list option:selected').text();

                                } else {

                                    value2 = $('#first_child_list option:selected').text();
                                    value2_text = $('#first_child_list option:selected').text();
                                }

                                if (compare_type2 == 'scheme' || compare_type2 == 'currency' || compare_type2 == 'comodity') {
                                    value3 = $('#second_child_list').val();
                                    value3_text = $('#second_child_list option:selected').text();

                                } else {

                                    value3 = $('#second_child_list option:selected').text();
                                    value3_text = $('#second_child_list option:selected').text();
                                }

                                if (compare_type3 == 'scheme' || compare_type3 == 'currency' || compare_type3 == 'comodity') {
                                    value4 = $('#third_child_list').val();
                                    value4_text = $('#third_child_list option:selected').text();

                                } else {

                                    value4 = $('#third_child_list option:selected').text();
                                    value4_text = $('#third_child_list option:selected').text();
                                }

                                if (compare_type4 == 'scheme' || compare_type4 == 'currency' || compare_type4 == 'comodity') {

                                    value5 = $('#fourth_child_list').val();
                                    value5_text = $('#fourth_child_list option:selected').text();

                                } else {

                                    value5 = $('#fourth_child_list option:selected').text();
                                    value5_text = $('#fourth_child_list option:selected').text();

                                }

                                if(value1 != "" && value2 != "")
                                {
                                    compare1 = compare_type+'_'+compare_type1;
                                }

                                if(value1 != "" && value3 != "")
                                {
                                    compare2 = compare_type+'_'+compare_type2;
                                }

                                if(value1 != "" && value4 != "")
                                {
                                    compare3 = compare_type+'_'+compare_type3;
                                }

                                if(value1 != "" && value5 != "")
                                {
                                    compare4 = compare_type+'_'+compare_type4;
                                }

                                console.log(compare1+'#'+compare2+'#'+compare3+'#'+compare4);                                

                                let compare_url = compareBasePath+'compare-price';

                                $.ajax({
                                    type: 'GET',
                                    url: compare_url,
                                    data: {
                                        value1: value1,
                                        value2: value2,
                                        value3: value3,
                                        value4: value4,
                                        value5: value5,
                                        value6: value6,
                                        from_date: from_date,
                                        to_date: to_date,
                                        compare1: compare1,
                                        compare2: compare2,
                                        compare3: compare3,
                                        compare4: compare4
                                    },
                                    beforeSend: function() {                                            
                                            $('#container1').html("");
                                            $('#container2').html("");
                                            $('#container3').html("");
                                            $('#container4').html("");
                                            $('#price_loader').css('display', 'block');
                                        },

                                    success: function(data) {

                                        let graph_data1_date = [];
                                        let graph_data1_value = [];

                                        let graph_data2_date = [];
                                        let graph_data2_value = [];

                                        let graph_data3_date = [];
                                        let graph_data3_value = [];

                                        let graph_data4_date = [];
                                        let graph_data4_value = [];

                                        let graph_data5_date = [];
                                        let graph_data5_value = [];

                                        console.log(data);

                                        if(data.success)
                                        {
                                                /* For First Graph */

                                                if( data.data.graph_data[0].length >= 1 && data.data.graph_data[1].length >= 1)
                                                {
                                                    if( graph_data1_date.length >= 1 && graph_data1_value.length >=1 )
                                                    {
                                                        for( let i=0; i<data.data.graph_data[1].length; i++ )
                                                        {        
                                                            let date_array = data.data.graph_data[1][i].DATE.split("/");
                                                            let string_date = date_array[2]+'-'+date_array[1]+'-'+date_array[0];
                                                            let new_date = new Date(string_date);

                                                            //console.log('Orginal: '+data.data.graph_data[0][i].DATE+' String Date: '+string_date+' Date Parse: '+new_date);

                                                            let dateFormat = new_date.getFullYear() + "-" + (new_date.getMonth()+1) + "-" + new_date.getDate();

                                                            graph_data2_date.push(dateFormat);

                                                            graph_data2_value.push( 
                                                            data.data.graph_data[1][i].VALUE
                                                            );
                                                        }


                                                    } else {													

                                                        for( let i=0; i<data.data.graph_data[0].length; i++ )
                                                        {        
                                                            let date_array = data.data.graph_data[0][i].DATE.split("/");
                                                            let string_date = date_array[2]+'-'+date_array[1]+'-'+date_array[0];
                                                            let new_date = new Date(string_date);

                                                            //console.log('Orginal: '+data.data.graph_data[0][i].DATE+' String Date: '+string_date+' Date Parse: '+new_date);

                                                            let dateFormat = new_date.getFullYear() + "-" + (new_date.getMonth()+1) + "-" + new_date.getDate();

                                                            graph_data1_date.push(dateFormat);

                                                            graph_data1_value.push( 
                                                            data.data.graph_data[0][i].VALUE
                                                            );
                                                        }

                                                        for( let i=0; i<data.data.graph_data[1].length; i++ )
                                                        {        
                                                            let date_array = data.data.graph_data[1][i].DATE.split("/");
                                                            let string_date = date_array[2]+'-'+date_array[1]+'-'+date_array[0];
                                                            let new_date = new Date(string_date);

                                                            //console.log('Orginal: '+data.data.graph_data[0][i].DATE+' String Date: '+string_date+' Date Parse: '+new_date);

                                                            let dateFormat = new_date.getFullYear() + "-" + (new_date.getMonth()+1) + "-" + new_date.getDate();

                                                            graph_data2_date.push(dateFormat);

                                                            graph_data2_value.push( 
                                                            data.data.graph_data[1][i].VALUE
                                                            );
                                                        }

                                                    }
													
													$('.showrslt').html();

                                                    Highcharts.chart('container1', {
                                                            chart: {
                                                                type: 'spline',
                                                                zoomType: 'xy'
                                                            },

                                                            title: {
                                                                text: ''
                                                            },

                                                            xAxis: {
                                                                type: 'datetime',
                                                                // This is from the Highcharts Stock - Stock license required
                                                                ordinal: true,
                                                                labels: {
                                                                // Format the date
                                                                formatter: function() {
                                                                    return Highcharts.dateFormat('%Y-%m-%d', this.value);
                                                                }
                                                                },
                                                                /* tickPositioner: function() {
                                                                return dates.map(function(date) {
                                                                    return Date.parse(date);
                                                                });
                                                                } */
                                                            },

                                                            yAxis: [{ 
                                                                labels: {
                                                                    format: '{value}',
                                                                    style: {
                                                                        color: Highcharts.getOptions().colors[2]
                                                                    }
                                                                },
                                                                opposite: true,
                                                            },
                                                            {
                                                                labels: {
                                                                    format: '{value}',
                                                                    style: {
                                                                        color: Highcharts.getOptions().colors[2]
                                                                    }
                                                                },
                                                            }],
															time: { useUTC: false },

                                                            plotOptions: {
                                                                column: {
                                                                pointPadding: 0.2,
                                                                borderWidth: 0
                                                                }
                                                            },

                                                            legend: {
                                                                title: {
                                                                text: ''
                                                                }
                                                            },

                                                            series: [ 
                                                                {
                                                                    yAxis: 0,
                                                                    name: value1_text,                                                                    
                                                                    marker: {
                                                                        show: true,
                                                                        symbol: 'circle',
                                                                        
                                                                    },
                                                                    data: 
                                                                        (function() {
                                                                        return graph_data1_date.map(function(date, i) {
                                                                            return [Date.parse(date), graph_data1_value[i]];
                                                                        });
                                                                        })(),
                                                                    color: 'red',
                                                                    width: '1px'
                                                                }, 
                                                                {
                                                                    name: value2_text,   
                                                                    yAxis: 1,                                                                 
                                                                    marker: {
                                                                        show: true,
                                                                        symbol: 'circle',
                                                                        
                                                                    },
                                                                    data: 
                                                                        (function() {
                                                                        return graph_data2_date.map(function(date, i) {
                                                                            return [Date.parse(date), graph_data2_value[i]];
                                                                        });
                                                                        })(),
                                                                    color: 'blue',
                                                                    width: '1px'
                                                                },                                                                     
                                                                
                                                            ],
                                                            /* responsive: {
                                                                    rules: [{
                                                                        condition: {
                                                                            maxWidth: 500
                                                                        },
                                                                        chartOptions: {
                                                                            legend: {
                                                                                floating: false,
                                                                                layout: 'horizontal',
                                                                                align: 'center',
                                                                                verticalAlign: 'bottom',
                                                                                x: 0,
                                                                                y: 0
                                                                            },
                                                                            yAxis: [{
                                                                                labels: {
                                                                                    align: 'right',
                                                                                    x: 0,
                                                                                    y: -6
                                                                                },
                                                                                showLastLabel: false
                                                                            }, {
                                                                                labels: {
                                                                                    align: 'left',
                                                                                    x: 0,
                                                                                    y: -6
                                                                                },
                                                                                showLastLabel: false
                                                                            }, {
                                                                                visible: false
                                                                            }]
                                                                        }
                                                                    }]
                                                                } */

                                                            });                                
                                                }  
                                                
                                                /* Graph 2 start */
                                                if( data.data.graph_data[0].length >= 1 && data.data.graph_data[2].length >= 1 )
                                                {
                                                    if( graph_data1_date.length >= 1 && graph_data1_value.length >=1 )
                                                    {
                                                        for( let i=0; i<data.data.graph_data[2].length; i++ )
                                                        {        
                                                            let date_array = data.data.graph_data[2][i].DATE.split("/");
                                                            let string_date = date_array[2]+'-'+date_array[1]+'-'+date_array[0];
                                                            let new_date = new Date(string_date);

                                                            //console.log('Orginal: '+data.data.graph_data[0][i].DATE+' String Date: '+string_date+' Date Parse: '+new_date);

                                                            let dateFormat = new_date.getFullYear() + "-" + (new_date.getMonth()+1) + "-" + new_date.getDate();

                                                            graph_data3_date.push(dateFormat);

                                                            graph_data3_value.push( 
                                                            data.data.graph_data[2][i].VALUE
                                                            );
                                                        }


                                                    } else {

                                                        for( let i=0; i<data.data.graph_data[0].length; i++ )
                                                        {        
                                                            let date_array = data.data.graph_data[0][i].DATE.split("/");
                                                            let string_date = date_array[2]+'-'+date_array[1]+'-'+date_array[0];
                                                            let new_date = new Date(string_date);

                                                            //console.log('Orginal: '+data.data.graph_data[0][i].DATE+' String Date: '+string_date+' Date Parse: '+new_date);

                                                            let dateFormat = new_date.getFullYear() + "-" + (new_date.getMonth()+1) + "-" + new_date.getDate();

                                                            graph_data1_date.push(dateFormat);

                                                            graph_data1_value.push( 
                                                            data.data.graph_data[0][i].VALUE
                                                            );
                                                        }

                                                        for( let i=0; i<data.data.graph_data[2].length; i++ )
                                                        {        
                                                            let date_array = data.data.graph_data[2][i].DATE.split("/");
                                                            let string_date = date_array[2]+'-'+date_array[1]+'-'+date_array[0];
                                                            let new_date = new Date(string_date);

                                                            //console.log('Orginal: '+data.data.graph_data[0][i].DATE+' String Date: '+string_date+' Date Parse: '+new_date);

                                                            let dateFormat = new_date.getFullYear() + "-" + (new_date.getMonth()+1) + "-" + new_date.getDate();

                                                            graph_data3_date.push(dateFormat);

                                                            graph_data3_value.push( 
                                                            data.data.graph_data[2][i].VALUE
                                                            );
                                                        }

                                                    }

                                                    Highcharts.chart('container2', {
                                                            chart: {
                                                                type: 'spline',
                                                                zoomType: 'x'
                                                            },

                                                            title: {
                                                                text: ''
                                                            },

                                                            xAxis: {
                                                                type: 'datetime',
                                                                // This is from the Highcharts Stock - Stock license required
                                                                ordinal: true,
                                                                labels: {
                                                                // Format the date
                                                                formatter: function() {
                                                                    return Highcharts.dateFormat('%Y-%m-%d', this.value);
                                                                }
                                                                },
                                                                /* tickPositioner: function() {
                                                                return dates.map(function(date) {
                                                                    return Date.parse(date);
                                                                });
                                                                } */
                                                            },

                                                            yAxis: [{ 
                                                                labels: {
                                                                    format: '{value}',
                                                                    style: {
                                                                        color: Highcharts.getOptions().colors[2]
                                                                    }
                                                                },
                                                                opposite: true,
                                                            },
                                                            {
                                                                labels: {
                                                                    format: '{value}',
                                                                    style: {
                                                                        color: Highcharts.getOptions().colors[2]
                                                                    }
                                                                },
                                                            }],
															time: { useUTC: false },

                                                            plotOptions: {
                                                                column: {
                                                                pointPadding: 0.2,
                                                                borderWidth: 0
                                                                }
                                                            },

                                                            legend: {
                                                                title: {
                                                                text: ''
                                                                }
                                                            },

                                                            series: [ 
                                                                {
                                                                    name: value1_text,
                                                                    yAxis: 0,
                                                                    marker: {
                                                                        show: true,
                                                                        symbol: 'circle',
                                                                        
                                                                    },
                                                                    data: 
                                                                        (function() {
                                                                        return graph_data1_date.map(function(date, i) {
                                                                            return [Date.parse(date), graph_data1_value[i]];
                                                                        });
                                                                        })(),
                                                                    color: 'red',
                                                                    width: '1px'
                                                                }, 
                                                                {
                                                                    name: value3_text,
                                                                    yAxis: 1,
                                                                    marker: {
                                                                        show: true,
                                                                        symbol: 'circle',
                                                                        
                                                                    },
                                                                    data: 
                                                                        (function() {
                                                                        return graph_data3_date.map(function(date, i) {
                                                                            return [Date.parse(date), graph_data3_value[i]];
                                                                        });
                                                                        })(),
                                                                    color: 'blue',
                                                                    width: '1px'
                                                                },                                                                     
                                                                
                                                            ]

                                                            });                                
                                                }

                                                /* Graph 3 Start */

                                                if( data.data.graph_data[0].length >= 1 && data.data.graph_data[3].length >= 1)
                                                {
                                                    if( graph_data1_date.length >= 1 && graph_data1_value.length >=1 )
                                                    {
                                                        for( let i=0; i<data.data.graph_data[3].length; i++ )
                                                        {        
                                                            let date_array = data.data.graph_data[3][i].DATE.split("/");
                                                            let string_date = date_array[2]+'-'+date_array[1]+'-'+date_array[0];
                                                            let new_date = new Date(string_date);

                                                            //console.log('Orginal: '+data.data.graph_data[0][i].DATE+' String Date: '+string_date+' Date Parse: '+new_date);

                                                            let dateFormat = new_date.getFullYear() + "-" + (new_date.getMonth()+1) + "-" + new_date.getDate();

                                                            graph_data4_date.push(dateFormat);

                                                            graph_data4_value.push( 
                                                            data.data.graph_data[3][i].VALUE
                                                            );
                                                        }


                                                    } else {

                                                        for( let i=0; i<data.data.graph_data[0].length; i++ )
                                                        {        
                                                            let date_array = data.data.graph_data[0][i].DATE.split("/");
                                                            let string_date = date_array[2]+'-'+date_array[1]+'-'+date_array[0];
                                                            let new_date = new Date(string_date);

                                                            //console.log('Orginal: '+data.data.graph_data[0][i].DATE+' String Date: '+string_date+' Date Parse: '+new_date);

                                                            let dateFormat = new_date.getFullYear() + "-" + (new_date.getMonth()+1) + "-" + new_date.getDate();

                                                            graph_data1_date.push(dateFormat);

                                                            graph_data1_value.push( 
                                                            data.data.graph_data[0][i].VALUE
                                                            );
                                                        }

                                                        for( let i=0; i<data.data.graph_data[3].length; i++ )
                                                        {        
                                                            let date_array = data.data.graph_data[3][i].DATE.split("/");
                                                            let string_date = date_array[2]+'-'+date_array[1]+'-'+date_array[0];
                                                            let new_date = new Date(string_date);

                                                            //console.log('Orginal: '+data.data.graph_data[0][i].DATE+' String Date: '+string_date+' Date Parse: '+new_date);

                                                            let dateFormat = new_date.getFullYear() + "-" + (new_date.getMonth()+1) + "-" + new_date.getDate();

                                                            graph_data4_date.push(dateFormat);

                                                            graph_data4_value.push( 
                                                            data.data.graph_data[3][i].VALUE
                                                            );
                                                        }

                                                    }

                                                    Highcharts.chart('container3', {
                                                            chart: {
                                                                type: 'spline',
                                                                zoomType: 'x'
                                                            },

                                                            title: {
                                                                text: ''
                                                            },

                                                            xAxis: {
                                                                type: 'datetime',
                                                                // This is from the Highcharts Stock - Stock license required
                                                                ordinal: true,
                                                                labels: {
                                                                // Format the date
                                                                formatter: function() {
                                                                    return Highcharts.dateFormat('%Y-%m-%d', this.value);
                                                                }
                                                                },
                                                                /* tickPositioner: function() {
                                                                return dates.map(function(date) {
                                                                    return Date.parse(date);
                                                                });
                                                                } */
                                                            },

                                                            yAxis: [{ 
                                                                labels: {
                                                                    format: '{value}',
                                                                    style: {
                                                                        color: Highcharts.getOptions().colors[2]
                                                                    }
                                                                },
                                                                opposite: true,
                                                            },
                                                            {
                                                                labels: {
                                                                    format: '{value}',
                                                                    style: {
                                                                        color: Highcharts.getOptions().colors[2]
                                                                    }
                                                                },
                                                            }],
															time: { useUTC: false },

                                                            plotOptions: {
                                                                column: {
                                                                pointPadding: 0.2,
                                                                borderWidth: 0
                                                                }
                                                            },

                                                            legend: {
                                                                title: {
                                                                text: ''
                                                                }
                                                            },

                                                            series: [ 
                                                                {
                                                                    name: value1_text,
                                                                    yAxis: 0,
                                                                    marker: {
                                                                        show: true,
                                                                        symbol: 'circle',
                                                                        
                                                                    },
                                                                    data: 
                                                                        (function() {
                                                                        return graph_data1_date.map(function(date, i) {
                                                                            return [Date.parse(date), graph_data1_value[i]];
                                                                        });
                                                                        })(),
                                                                    color: 'red',
                                                                    width: '1px'
                                                                }, 
                                                                {
                                                                    name: value4_text,
                                                                    yAxis: 1,
                                                                    marker: {
                                                                        show: true,
                                                                        symbol: 'circle',
                                                                        
                                                                    },
                                                                    data: 
                                                                        (function() {
                                                                        return graph_data4_date.map(function(date, i) {
                                                                            return [Date.parse(date), graph_data4_value[i]];
                                                                        });
                                                                        })(),
                                                                    color: 'blue',
                                                                    width: '1px'
                                                                },                                                                     
                                                                
                                                            ]

                                                            });                                
                                                }

                                                /* Graph 4 start */

                                                if( data.data.graph_data[0].length >= 1 && data.data.graph_data[4].length >= 1)
                                                {
                                                    if( graph_data1_date.length >= 1 && graph_data1_value.length >=1 )
                                                    {
                                                        for( let i=0; i<data.data.graph_data[4].length; i++ )
                                                        {        
                                                            let date_array = data.data.graph_data[4][i].DATE.split("/");
                                                            let string_date = date_array[2]+'-'+date_array[1]+'-'+date_array[0];
                                                            let new_date = new Date(string_date);

                                                            //console.log('Orginal: '+data.data.graph_data[0][i].DATE+' String Date: '+string_date+' Date Parse: '+new_date);

                                                            let dateFormat = new_date.getFullYear() + "-" + (new_date.getMonth()+1) + "-" + new_date.getDate();

                                                            graph_data5_date.push(dateFormat);

                                                            graph_data5_value.push( 
                                                            data.data.graph_data[4][i].VALUE
                                                            );
                                                        }


                                                    } else {

                                                        for( let i=0; i<data.data.graph_data[0].length; i++ )
                                                        {        
                                                            let date_array = data.data.graph_data[0][i].DATE.split("/");
                                                            let string_date = date_array[2]+'-'+date_array[1]+'-'+date_array[0];
                                                            let new_date = new Date(string_date);

                                                            //console.log('Orginal: '+data.data.graph_data[0][i].DATE+' String Date: '+string_date+' Date Parse: '+new_date);

                                                            let dateFormat = new_date.getFullYear() + "-" + (new_date.getMonth()+1) + "-" + new_date.getDate();

                                                            graph_data1_date.push(dateFormat);

                                                            graph_data1_value.push( 
                                                            data.data.graph_data[0][i].VALUE
                                                            );
                                                        }

                                                        for( let i=0; i<data.data.graph_data[4].length; i++ )
                                                        {        
                                                            let date_array = data.data.graph_data[4][i].DATE.split("/");
                                                            let string_date = date_array[2]+'-'+date_array[1]+'-'+date_array[0];
                                                            let new_date = new Date(string_date);

                                                            //console.log('Orginal: '+data.data.graph_data[0][i].DATE+' String Date: '+string_date+' Date Parse: '+new_date);

                                                            let dateFormat = new_date.getFullYear() + "-" + (new_date.getMonth()+1) + "-" + new_date.getDate();

                                                            graph_data5_date.push(dateFormat);

                                                            graph_data5_value.push( 
                                                            data.data.graph_data[4][i].VALUE
                                                            );
                                                        }

                                                    }

                                                    Highcharts.chart('container4', {
                                                            chart: {
                                                                type: 'spline',
                                                                zoomType: 'x'
                                                            },

                                                            title: {
                                                                text: ''
                                                            },

                                                            xAxis: {
                                                                type: 'datetime',
                                                                // This is from the Highcharts Stock - Stock license required
                                                                ordinal: true,
                                                                labels: {
                                                                // Format the date
                                                                formatter: function() {
                                                                    return Highcharts.dateFormat('%Y-%m-%d', this.value);
                                                                }
                                                                },
                                                                /* tickPositioner: function() {
                                                                return dates.map(function(date) {
                                                                    return Date.parse(date);
                                                                });
                                                                } */
                                                            },

                                                            yAxis: [{ 
                                                                labels: {
                                                                    format: '{value}',
                                                                    style: {
                                                                        color: Highcharts.getOptions().colors[2]
                                                                    }
                                                                },
                                                                opposite: true,
                                                            },
                                                            {
                                                                labels: {
                                                                    format: '{value}',
                                                                    style: {
                                                                        color: Highcharts.getOptions().colors[2]
                                                                    }
                                                                },
                                                            }],
															time: { useUTC: false },

                                                            plotOptions: {
                                                                column: {
                                                                pointPadding: 0.2,
                                                                borderWidth: 0
                                                                }
                                                            },

                                                            legend: {
                                                                title: {
                                                                text: ''
                                                                }
                                                            },

                                                            series: [ 
                                                                {
                                                                    name: value1_text,
                                                                    yAxis: 0,
                                                                    marker: {
                                                                        show: true,
                                                                        symbol: 'circle',
                                                                        
                                                                    },
                                                                    data: 
                                                                        (function() {
                                                                        return graph_data1_date.map(function(date, i) {
                                                                            return [Date.parse(date), graph_data1_value[i]];
                                                                        });
                                                                        })(),
                                                                    color: 'red',
                                                                    width: '1px'
                                                                }, 
                                                                {
                                                                    name: value5_text,
                                                                    yAxis: 1,
                                                                    marker: {
                                                                        show: true,
                                                                        symbol: 'circle',
                                                                        
                                                                    },
                                                                    data: 
                                                                        (function() {
                                                                        return graph_data5_date.map(function(date, i) {
                                                                            return [Date.parse(date), graph_data5_value[i]];
                                                                        });
                                                                        })(),
                                                                    color: 'blue',
                                                                    width: '1px'
                                                                },                                                                     
                                                                
                                                            ]

                                                            });                                
                                                }

                                                
                                        }

                                    },
                                        complete:function(data){
                                            // Hide image container
                                            $("#price_loader").hide();
                                           
                                        }
                                });

                            }
							
							function clearData()
							{
								$('.showrslt').html('');
							}
							
                        </script>
                    <?php $__env->stopPush(); ?>

<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/new.myplexus.com/httpdocs/my-plexus/resources/views/web/pages/compare-scheme.blade.php ENDPATH**/ ?>