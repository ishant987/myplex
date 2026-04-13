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
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<style>
    .login_with {
    text-align: center;
    margin-bottom: 5px;
}
.login_with h5 {
    font-size: 16px;
}
.login_with ul {
    margin: 10px 0;
    display: flex;
    justify-content: center;
}
.login_with li {
    list-style: none;
    display: inline;
    margin: 0 10px;
}
.login_with li a {
    width: 46px;
    height: 46px;
    line-height: 46px;
    border: 1px solid #379962;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #379962;
    font-size: 18px;
    transition: all .4s ease-in-out;
}
.login_with li a:hover {
    color: #28253A;
    border-color: #28253A;
}





    .login-page .login-block,
    .sip-calc-login .login-block {
        margin: 55px 0;
        border: 1px solid #e7e4e4;
        width: 100%;
        max-width: 450px;
        margin: 50px auto;
        border-radius: 10px;
    }

    .login-page .login-block .login-wrap,
    .sip-calc-login .login-block .login-wrap {
        padding: 30px 30px 20px;
    }

    .sip-calc-login .login-block .login-wrap .sip-calc-wrapper {
        max-width: 100%;
    }

    .sip-calc-login .login-block .login-wrap .sip-calc-wrapper h3 {
        text-align: center;
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .sip-calc-login .login-block .login-wrap .sip-calc-wrapper .sip-calc-loginin-wrap {
        margin: 0 auto;
    }

    .sip-calc-login .login-block .login-wrap .sip-calc-wrapper .sip-calc-loginin-wrap .sip-calc-social-login {
        text-align: center;
    }

    .sip-calc-login .login-block .login-wrap .sip-calc-wrapper .sip-calc-loginin-wrap .login-field {
        margin-top: 15px;
    }

    .sip-calc-login .login-block .login-wrap .password-field {
        margin-top: 15px;
    }

    .login-page .login-block .login-wrap .log-other-opt,
    .sip-calc-login .login-block .login-wrap .log-other-opt {
        margin-top: 0;
    }

    .box-shadow {
        box-shadow: 2px 8px 15px -6px #0000001f;
    }

    input {
        border: 1px solid #e7e4e4;
        border-radius: 5px;
        padding: 12px 16px;
        box-shadow: 2px 8px 15px -6px #0000001f;
    }

    input,
    select,
    textarea {
        width: 100%;
        line-height: normal;
        font-family: 'Volte-Medium';
        color: #000;
        font-size: 16px;
    }

    .sip-calc-loginin-wrap form label {
        color: #212529;
        display: block;
        line-height: normal;
        margin-bottom: 6px;
    }

    .sip-calc-loginin-wrap form .box-shadow {
        box-shadow: none;
        border: 1px solid #4B4B4B;
        border-radius: 10px;
    }

    .sip-calc-login .login-block .login-wrap .sip-calc-wrapper .sip-calc-loginin-wrap .sip-calc-social-login ul li img {
        width: 100%;
        border-radius: 5px;
    }

    ul {
        padding: 0;
        margin: 0;
        list-style-type: none;
    }

    .sip-calc-login .login-block .login-wrap .sip-calc-wrapper .sip-calc-loginin-wrap .sip-calc-social-login ul li:first-child {
        margin-top: 10px;
    }

    .sip-calc-login .login-block .login-wrap .sip-calc-wrapper .sip-calc-loginin-wrap .sip-calc-social-login ul li {
        margin-top: 15px;
    }

    .float-right {
        float: right !important;
    }

    .sip-calc-loginin-wrap .btn-bg-2 {
        background: #16ab6c;
        max-width: 150px;
        margin: 24px auto 0;
        display: table;
        border-radius: 10px;
    }
    .sip-calc-loginin-wrap .btn-bg-2:hover{
        background: #00665e;
    } 
    .btnsub {
        color: #fff;
        background-color: #198754;
        border-color: #198754;
        padding: 7px 39px;
    }

    #tgaindata,
    #myChart,
	#lumpgain,
	#myChartlump,
	#lumpfinaldata,
	.siptablegoal,
	#sipval
	{
        display: none;
    }
	
	  /*#tallsipdata,
	#btndistabs,
	#lumpgpbut{
		  display: none;
	}*/
	canvas#myChartlump{
    width:400px !important;
    height:auto !important;
    margin:0 auto !important;
}
	
	.radfl {
    display:inline-flex !important;
    align-items: baseline;
}
.radfl  label{
    margin-left:5px !important;
}

	 .planno,
    #calsip,
    .fintsip,
	#tval{
        display: none;
    }
	
	#inflationChart {
            display: none;
        }
	thead th{
    background:#00665e !important;
    color:#fff !important;
     border:1px solid #000 !important;
}

table,
table td{
    border:1px solid #000 !important;
}
	
	canvas#mygoal {
    display:none;
}
	#sipval {
    margin-top:10px !important;
    margin-bottom:20px !important;
}
</style>
<?php if(session()->has('username') && session()->has('useremail') ): ?>
<section class="compare_scheme">
    <div class="container">
        <div class="tab_snap_shot">
            <ul class="nav nav-pills filter_tab mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation"><button class="nav-link active show" id="pills-monthly-tab1"
                        data-bs-toggle="pill" data-bs-target="#pills-monthly1" type="button" role="tab"
                        aria-controls="pills-monthly1" aria-selected="false"><img
                            src="https://myplexus.com/themes/frontend/assets/v1/img/tab_icon_cal1.png"> SIP Planner
                    </button></li>
                <li class="nav-item" role="presentation"><button class="nav-link" id="pills-weekly-tab1"
                        data-bs-toggle="pill" data-bs-target="#pills-weekly1" type="button" role="tab"
                        aria-controls="pills-weekly1" aria-selected="false"><img
                            src="https://myplexus.com/themes/frontend/assets/v1/img/tab_icon_cal.png"> Lumpsum
                        Planner </button></li>
                <li class="nav-item" role="presentation"><button class="nav-link" id="pills-monthly-tab3"
                        data-bs-toggle="pill" data-bs-target="#pills-monthly3" type="button" role="tab"
                        aria-controls="pills-monthly3" aria-selected="true"><img
                            src="https://myplexus.com/themes/frontend/assets/v1/img/tab_icon_cal3.png"> Retirement
                        Planner </button></li>
                <li class="nav-item" role="presentation"><button class="nav-link" id="pills-monthly-tab4"
                        data-bs-toggle="pill" data-bs-target="#pills-monthly4" type="button" role="tab"
                        aria-controls="pills-monthly4" aria-selected="false"><img
                            src="https://myplexus.com/themes/frontend/assets/v1/img/tab_icon_cal4.png"> Risk
                        Tolerance Evaluator </button></li>
                <li class="nav-item" role="presentation"><button class="nav-link" id="pills-monthly-tab2"
                        data-bs-toggle="pill" data-bs-target="#pills-monthly2" type="button" role="tab"
                        aria-controls="pills-monthly2" aria-selected="false"><img
                            src="https://myplexus.com/themes/frontend/assets/v1/img/tab_icon_cal2.png"> Inflation
                        Calculator </button></li>
				<li class="nav-item" role="presentation"><button class="nav-link" id="pills-goal-tab1"
                        data-bs-toggle="pill" data-bs-target="#pills-goal1" type="button" role="tab"
                        aria-controls="pills-goal1" aria-selected="false"><img
                            src="https://myplexus.com/themes/frontend/assets/v1/img/tab_icon_cal2.png"> Goal Planner </button></li>
            </ul>
			
			
            <div class="tab-content" id="pills-tabContent"><!-- SIP PLANNER CALCULATOR TAB START -->
<!--goal planner-->
				 <div class="tab-pane fade" id="pills-monthly3" role="tabpanel" aria-labelledby="pills-monthly-tab2">
					  <div class="comp_schem_bdr">
                                        <div class="s_renge p-0">
                                            <div class="row calbanner">
                                                <div class="l">
                                                    <h4 class="heading-green">Retirement Calculator</h4>
                                                    <p>This calculator can help with planning the financial aspects of
                                                        your retirement, such as providing an idea where you stand in
                                                        terms of retirement savings, how much to save to reach your
                                                        target, and what your retrievals will look like in retirement.
                                                    </p>
                                                </div>
                                                <div class="r"><img
                                                src="https://myplexus.com/themes/frontend/assets/v1/img/retirementcalculator.png">
                                                </div>
                                            </div>
											
                                            <div class="row">
                                                <div class="col-12 left-side">
													<form id="retcal">
                                                    <div class="row mb-5">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6">
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="cal_form_select"><label
                                                                            for=""><strong>Current age *: <i
                                                                                    class="ph ph-question"
                                                                                    data-toggle="tooltip"
                                                                                    data-placement="top" title="How old are you currently?
"
                                                                                    data-bs-original-title="How old are you currently?"
                                                                                    aria-label="How old are you currently?
"></i></strong><span><input
                                                                                    class="form-text input-s"
                                                                                    type="text"
                                                                                    placeholder="Current age *" id="currage">
                                                                                years</span></label>
                                                                        <div class="d-flex">
                                                                            <div class="right">
                                                                                <div class="slidecontainer"><input
                                                                                        type="range" min="1" max="100"
                                                                                        class="slider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                                                                        id="current_age_output"><!-- <p>Value: <span id="demo"></span></p> -->
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="cal_form_select"><label
                                                                            for=""><strong>Expected Age of Retirement *:
                                                                                <i class="ph ph-question"
                                                                                    data-toggle="tooltip"
                                                                                    data-placement="top" title=""
                                                                                    data-bs-original-title="At which age do you expect your reirement?"
                                                                                    aria-label="At which age do you expect your reirement?"></i></strong>
                                                                            <span><input class="form-text input-s"
                                                                                    type="number" id="expageret"
                                                                                    placeholder="Expected age of Retirement *">
                                                                                years</span></label>
                                                                        <div class="d-flex">
                                                                            <div class="right">
                                                                                <div class="slidecontainer"><input
                                                                                        type="range" min="1" max="100"
                                                                                        class="slider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                                                                        id="expected_age_retirement_output"><!-- <p>Value: <span id="demo"></span></p> -->
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="cal_form_select"><label
                                                                            for=""><strong>Life Expectancy *: <i
                                                                                    class="ph ph-question"
                                                                                    data-toggle="tooltip"
                                                                                    data-placement="top" title=""
                                                                                    data-bs-original-title="Till which age do yo want to keep your investments?"
                                                                                    aria-label="Till which age do yo want to keep your investments?"></i></strong>
                                                                            <span><input class="form-text input-s"
                                                                                    type="number" id="lifexp"
                                                                                    placeholder="Life Expectancy *">
                                                                                years</span></label>
                                                                        <div class="d-flex">
                                                                            <div class="right">
                                                                                <div class="slidecontainer"><input
                                                                                        type="range" min="1" max="100"
                                                                                        class="slider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                                                                        id="life_expectancy_output"><!-- <p>Value: <span id="demo"></span></p> -->
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="cal_form_select"><label
                                                                            for=""><strong>Rate of return during
                                                                                accumulation period *: <i
                                                                                    class="ph ph-question"
                                                                                    data-toggle="tooltip"
                                                                                    data-placement="top" title=""
                                                                                    data-bs-original-title="How much rate of return do you expect to achieve till retirement?
"
                                                                                    aria-label="How much rate of return do you expect to achieve till retirement?
"></i></strong>
                                                                            <span><input class="form-text input-s"
                                                                                    type="text" 
                                                                                    placeholder="Rate of return during accumulation period *"
                                                                                    id="accumulation_period">
                                                                                %</span></label>
                                                                        <div class="d-flex">
                                                                            <div class="right">
                                                                                <div class="slidecontainer"><input
                                                                                        type="range" min="1" max="100"
                                                                                        class="slider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                                                                        id="accumulation_period_output"><!-- <p>Value: <span id="demo"></span></p> -->
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="cal_form_select"><label
                                                                            for=""><strong>Rate of return after
                                                                                retirement *: <i class="ph ph-question"
                                                                                    data-toggle="tooltip"
                                                                                    data-placement="top" title=""
                                                                                    data-bs-original-title="How much rate of return do you expect after your retirement?"
                                                                                    aria-label="How much rate of return do you expect after your retirement?"></i></strong>
                                                                            <span><input class="form-text input-s"
                                                                                    type="number" 
                                                                                    placeholder="Rate of return after retirement *"
                                                                                    id="rateretirement"> %</span></label>
                                                                        <div class="d-flex">
                                                                            <div class="right">
                                                                                <div class="slidecontainer"><input
                                                                                        type="range" min="1" max="100"
                                                                                        class="slider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                                                                        id="retirement_output"><!-- <p>Value: <span id="demo"></span></p> -->
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="cal_form_select"><label
                                                                            for=""><strong>Inflation *: <i
                                                                                    class="ph ph-question"
                                                                                    data-toggle="tooltip"
                                                                                    data-placement="top" title=""
                                                                                    data-bs-original-title="Rate of increase in general price level in economy"
                                                                                    aria-label="Rate of increase in general price level in economy"></i></strong>
                                                                            <span><input class="form-text input-s"
                                                                                    type="number"
                                                                                    placeholder="Inflation *"
                                                                                    id="rateinflationret"> %</span></label>
                                                                        <div class="d-flex">
                                                                            <div class="right">
                                                                                <div class="slidecontainer"><input
                                                                                        type="range" min="1" max="100"
                                                                                        class="slider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                                                                        id="inflation_output"><!-- <p>Value: <span id="demo"></span></p> -->
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row manualinputs">
                                                        <div class="col-12 col-lg-6 col-md-6">
                                                            <div class="cal_form_select"><label for=""><strong>Monthly
                                                                        expenditure (In Rs.) * <i class="ph ph-question"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title=""
                                                                            data-bs-original-title="Amount of money usually spent in every month"
                                                                            aria-label="Amount of money usually spent in every month"></i></strong></label><input
                                                                    class="form-text" type="text"
                                                                    placeholder="Monthly expenditure (In Rs.) *" id="mothexp"></div>
                                                        </div>
                                                        <div class="col-12 col-lg-6 col-md-6">
                                                            <div class="cal_form_select"><label
                                                                    for=""><strong>Pension/income after retirement (If
                                                                        any) <i class="ph ph-question"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title=""
                                                                            data-bs-original-title="Expected amount from pension every month, if any"
                                                                            aria-label="Expected amount from pension every month, if any"></i></strong></label><input
                                                                    class="form-text" type="number"
                                                                    placeholder="Pension/income after retirement (If any)" id="pension">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-6 col-md-6">
                                                            <div class="cal_form_select"><label for=""><strong>Current
                                                                        Savings per month/SIP (If any) <i
                                                                            class="ph ph-question" data-toggle="tooltip"
                                                                            data-placement="top" title=""
                                                                            data-bs-original-title="Amount of money invested every month, if any"
                                                                            aria-label="Amount of money invested every month, if any"></i></strong></label><input
                                                                    class="form-text" type="number"
                                                                    placeholder="Current Savings per month/SIP (If any)" id="currsav">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-6 col-md-6">
                                                            <div class="cal_form_select"><label for=""><strong>Current
                                                                        lump sum (If any) <i class="ph ph-question"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title=""
                                                                            data-bs-original-title="Did you invest any lumpsum amount of money from which you are expecting a return at the age of retirement? If yes metion the lumpsum amount"
                                                                            aria-label="Did you invest any lumpsum amount of money from which you are expecting a return at the age of retirement? If yes metion the lumpsum amount"></i></strong></label><input
                                                                    class="form-text" type="number"
                                                                    placeholder="Current lump sum (If any)" id="currlump"></div>
                                                        </div>
                                                    </div>
														<div class="three_btn one_btn text-center">
                                                <div class="middle_left d-inline">
                                                    <button type="submit" class="btn btnsub calbutret" name="callump">Calculate</button>

                                                </div>

                                            </div>
                                                  </form>
                                                   
													
                                                </div>
												
												<div class="invst-inflation-data mt-3 mb-3 corpdrer">
    <div class="row m-0">
        <div class="col-lg-4 col-md-4 col-sm-4 inflataion-data-common pt-2 pb-2">
            <h5 class="m-0">Corpus you will need on retirement</h5><span id="corpret"></span>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 inflataion-data-common pt-2 pb-2">
            <h5 class="m-0">Savings Required per month</h5><span id="spmonth"></span>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 inflataion-data-common pt-2 pb-2">
            <h5 class="m-0">Savings Required per year</h5><span id="spyear"></span>
        </div>
    </div>
</div>
                                                
												 
                                            </div>
											
                                        </div>
                                      
                                    </div>
					     <div class="plan_faq">
                                        <div class="faq_title">
                                            <h4>FAQ - <span>Frequently asked questions</span></h4>
                                        </div>
                                        <div class="single_faq_calc">
                                            <h4>What is Retirement Planner?</h4>
                                            <p>Retirement planning is a critical financial and lifestyle consideration
                                                that involves setting aside enough money and assets to support yourself
                                                comfortably after you stop working.This requires analyzing current
                                                expenses to estimate future requirement expenses, determining the time
                                                horizon for retirement, assessing the risk apetite, and tax-efficiency
                                                of your retirements.</p>
                                        </div>
                                        <div class="single_faq_calc">
                                            <h4>Why Retirement planning is important?</h4>
                                            <p>The first and foremost reason is inflation which reduces the value of
                                                money over time. So it is essential to have investments that offer the
                                                potential for growth to outpace inflation in order to support desired
                                                lifestyle in retirement. Secondly, life expectancy directly impacts how
                                                long your retirement savings need to last and the income you'll require
                                                during the retirement years. </p>
                                        </div>
                                        <div class="single_faq_calc">
                                            <h4>Benefits of Retirement planning</h4>
                                        </div>
                                        <div class="single_faq_calc">
                                            <h4>Financial Security</h4>
                                            <p>Retirement planning helps in securing you financially once you stop
                                                working by ensuring that your living expenses and maintaining desired
                                                standard of living during retirement.</p>
                                        </div>
                                        <div class="single_faq_calc">
                                            <h4>Inflation Protection</h4>
                                            <p>A well structured retirement plan accounts for inflation, ensuring that
                                                your income keeps pace with rising living costs. This protection helps
                                                maintain your purchasing power over time.</p>
                                        </div>
                                        <div class="single_faq_calc">
                                            <h4>Independence</h4>
                                            <p>With a solid retirement plan, you're less likely to rely on others, such
                                                as family members, for financial support in your later years.</p>
                                        </div>
                                    </div>
				</div>
				 <div class="tab-pane fade" id="pills-monthly2" role="tabpanel" aria-labelledby="pills-monthly-tab2">
                    <div class="comp_schem_bdr">
						<div class="s_renge p-0">
							<div class="row calbanner">
                                <div class="l">
                                    <h4 class="heading-green"> Inflation Calculator </h4>
                                    <p>This calculates the value of current expenses after a certain
                                        time period taking into account the inflation rate. </p>
                                </div>
                                <div class="r"><img
                                        src="https://myplexus.com/themes/frontend/assets/v1/img/InflationCalculator.png">
                                </div>
                            </div>
							 <div class="row">
                                <div class="col-md-12 left-side">
									<form id="inflationcalc">
									<div class="row">
									
                                        <div class="col-lg-4 col-md-12">
                                            <div class="cal_form_select"><label for=""><strong>Value of
                                                        Current Expenses (₹) *</strong></label><input
                                                    class="form-text vcexp" type="number"></div>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                             <div class="cal_form_select"><label for=""><strong>Annual Inflation</strong></label>
												 
												   <select class="infrateann form-text">
            <option value="">Select</option>
													   <option value="6">Low (6%)</option>
            <option value="7">Medium (7%) </option>
            <option value="8">High (8%) </option>
        </select>
											
											</div>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <div class="cal_form_select"><label for=""><strong>Time
                                                        Period (Y) *  <i class="ph ph-question"
                                                            data-toggle="tooltip" data-placement="top" title=""
                                                            data-bs-original-title="Time period of the investment"
                                                            aria-label="Time period of the investment"></i></strong></label><input class="form-text tperiodinf"
                                                    type="number" maxlength="3"></div>
                                        </div>
											   
											    <div class="three_btn one_btn text-center">
                                                        <div class="middle_left d-inline">
                                                            <button type="submit"
                                                                class="btn btnsub calculateButtoninf">Calculate</button>


                                                        </div>

                                                    </div>
										
											   
											   
											   
                                    </div>
									</form>
									<div id="result" class="text-center"></div>

<canvas id="inflationChart"></canvas>
								 </div>
							</div>
						</div>
					 </div>
				</div>
                <div class="tab-pane fade" id="pills-goal1" role="tabpanel" aria-labelledby="pills-weekly-tab5">
                    <div class="comp_schem_bdr">
						<div class="s_renge p-0">
							 <div class="row calbanner">
                                <div class="l">
                                    <h4 class="heading-green">Goal Planner</h4>
                                    <p>This calculator can help with the planning of various goals of life, personal goals and how to achieve them in the most effective way.  </p>
                                </div>
                                <div class="r"><img
                                        src="https://myplexus.com/themes/frontend/assets/v1/img/SIPCalculator,.png">
                                </div>
                            </div>
							 <div class="row">
                                <div class="col-md-12 left-side">
								 	           <form id="goalplanner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-12 mb-4">

                                                        <div class="cal_form_select"><label for=""><strong>Select a Goal
                                                                    <i class="ph ph-question" data-toggle="tooltip"
                                                                        data-placement="top" title=""
                                                                        data-bs-original-title="Select a Goal"
                                                                        aria-label="Select a Goal"></i></strong></label>
                                                            <select class="plan form-text" required>
                                                                <option value="">Select</option>
                                                                <option value="A">Planning for Child’s Marriage
                                                                </option>
                                                                <option value="B">Planning for Child’s Higher Education
                                                                </option>
                                                                <option value="C">Planning for Owning an Asset </option>
                                                                <option value="D">Others </option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12 mb-4">
                                                        <div class="content" id="A">
                                                            <div class="cal_form_select"><label for=""><strong>What is
                                                                        the present cost of such marriage? (in Rs.) <i
                                                                            class="ph ph-question" data-toggle="tooltip"
                                                                            data-placement="top" title=""
                                                                            data-bs-original-title="What is the present cost of such marriage? (in Rs.)"
                                                                            aria-label="What is the present cost of such marriage? (in Rs.)"></i></strong></label>
                                                                <input type="text" class="presentcost form-text" />
                                                            </div>

                                                            <div class="cal_form_select"><label for=""><strong>After how
                                                                        many years is your child likely to get married?
                                                                        (Max. 50 years) <i class="ph ph-question"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title=""
                                                                            data-bs-original-title="After how many years is your child likely to get married? (Max. 50 years)"
                                                                            aria-label="After how many years is your child likely to get married? (Max. 50 years)"></i></strong></label>
                                                                <input type="number" class="marriageyears form-text"
                                                                    max="50" min="1" />
                                                            </div>

                                                            <div class="cal_form_select"><label for=""><strong>Inflation
                                                                        <i class="ph ph-question" data-toggle="tooltip"
                                                                            data-placement="top" title=""
                                                                            data-bs-original-title="Inflation"
                                                                            aria-label="Inflation"></i></strong></label>
                                                                <select class="inflationchildmar form-text">
                                                                    <option value="">Select</option>
                                                                    <option value="6">Low (6%)</option>
                                                                    <option value="7">Medium (7%)</option>
                                                                    <option value="8">High (8%)</option>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="content" id="B">
                                                            <div class="cal_form_select"><label for=""><strong>What is
                                                                        the present cost of such education? (in Rs.) <i
                                                                            class="ph ph-question" data-toggle="tooltip"
                                                                            data-placement="top" title=""
                                                                            data-bs-original-title="What is the present cost of such education? (in Rs.)"
                                                                            aria-label="What is the present cost of such education? (in Rs.)"></i></strong></label>
                                                                <input type="text" class="presentcostedu form-text" />
                                                            </div>

                                                            <div class="cal_form_select"><label for=""><strong>After how
                                                                        many years is your child likely to go for higher
                                                                        education? (Max. 50 years) <i
                                                                            class="ph ph-question" data-toggle="tooltip"
                                                                            data-placement="top" title=""
                                                                            data-bs-original-title="After how many years is your child likely to go for higher education? (Max. 50 years)"
                                                                            aria-label="After how many years is your child likely to go for higher education? (Max. 50 years)"></i></strong></label>
                                                                <input type="number" class="eduyears form-text" max="50"
                                                                    min="1" />
                                                            </div>

                                                            <div class="cal_form_select"><label for=""><strong>Inflation
                                                                        <i class="ph ph-question" data-toggle="tooltip"
                                                                            data-placement="top" title=""
                                                                            data-bs-original-title="Inflation"
                                                                            aria-label="Inflation"></i></strong></label>
                                                                <select class="inflationchildedu form-text">
                                                                    <option value="">Select</option>
                                                                    <option value="6">Low (6%)</option>
                                                                    <option value="7">Medium (7%)</option>
                                                                    <option value="8">High (8%)</option>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="content" id="C">
                                                            <div class="cal_form_select"><label for=""><strong>What is
                                                                        the present cost of such asset? (in Rs.) <i
                                                                            class="ph ph-question" data-toggle="tooltip"
                                                                            data-placement="top" title=""
                                                                            data-bs-original-title="What is the present cost of such asset? (in Rs.)"
                                                                            aria-label="What is the present cost of such asset? (in Rs.)"></i></strong></label>
                                                                <input type="text" class="presentcostasset form-text" />
                                                            </div>

                                                            <div class="cal_form_select"><label for=""><strong>After how
                                                                        many years are you planning to buy the said
                                                                        asset? (Max. 50 years) <i class="ph ph-question"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title=""
                                                                            data-bs-original-title="After how many years are you planning to buy the said asset? (Max. 50 years)"
                                                                            aria-label="After how many years are you planning to buy the said asset? (Max. 50 years)"></i></strong></label>
                                                                <input type="number" class="assetyears form-text"
                                                                    max="50" min="1" />
                                                            </div>

                                                            <div class="cal_form_select"><label for=""><strong>Inflation
                                                                        <i class="ph ph-question" data-toggle="tooltip"
                                                                            data-placement="top" title=""
                                                                            data-bs-original-title="Inflation"
                                                                            aria-label="Inflation"></i></strong></label>
                                                                <select class="inflationasset form-text">
                                                                   <option value="">Select</option>
                                                                    <option value="6">Low (6%)</option>
                                                                    <option value="7">Medium (7%)</option>
                                                                    <option value="8">High (8%)</option>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="content" id="D">
                                                            <div class="cal_form_select"><label for=""><strong>Present
                                                                        Cost (in Rs.) <i class="ph ph-question"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title=""
                                                                            data-bs-original-title="Goal Amount (in Rs.)"
                                                                            aria-label="Goal Amount (in Rs.)"></i></strong></label>
                                                                <input type="text" class="presentcostgoal form-text" />
                                                            </div>

                                                            <div class="cal_form_select"><label
                                                                    for=""><strong>Investment Duration (in Years) <i
                                                                            class="ph ph-question" data-toggle="tooltip"
                                                                            data-placement="top" title=""
                                                                            data-bs-original-title="Investment Duration (in Years)"
                                                                            aria-label="Investment Duration (in Years)"></i></strong></label>
                                                                <input type="number" class="goalyears form-text"
                                                                    max="50" min="1" />
                                                            </div>

                                                            <div class="cal_form_select"><label for=""><strong>Inflation
                                                                        <i class="ph ph-question" data-toggle="tooltip"
                                                                            data-placement="top" title=""
                                                                            data-bs-original-title="Inflation"
                                                                            aria-label="Inflation"></i></strong></label>
                                                                <select class="inflationgoal form-text">
                                                                   
                                                                   <option value="">Select</option>
                                                                    <option value="6">Low (6%)</option>
                                                                    <option value="7">Medium (7%)</option>
                                                                    <option value="8">High (8%)</option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="three_btn one_btn text-center">
                                                        <div class="middle_left d-inline">
                                                            <button type="submit"
                                                                class="btn btnsub btncal">Calculate</button>


                                                        </div>

                                                    </div>
                                                   
                                                </div>
                                            </form>
									 <h3 id="tval">Target Value: <span id="targetvalue"></span></h3>
                                            <div class="three_btn one_btn text-left" style="margin-top: 30px;">
                                                <div class="middle_left d-inline">
                                                    <button type="submit" class="planno btnsub btn">Plan Now</button>
                                                </div>

                                            </div>
									<form id="calsip" style="margin-top: 30px;">
										<div class="row">
										<div class="col-lg-4 col-md-12 mb-4">

                                                        <div class="cal_form_select"><label for=""><strong>Expected
                                                                    Growth: <i class="ph ph-question"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title=""
                                                                        data-bs-original-title="Expected Growth:"
                                                                        aria-label="Expected Growth:"></i></strong></label>
                                                            <select class="expgro form-text">
																<option value="">Select</option>
                                                              <option value="14">Aggressive (14%)</option>
        <option value="12">Moderate (12%)</option>
        <option value="10">Conservative (10%)</option>

                                                            </select>
                                                        </div>
                                                    </div>
											
											<div class="col-lg-4 col-md-12 mb-4">

                                                        <div class="cal_form_select"><label for=""><strong>Investment Mode: <i class="ph ph-question"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title=""
                                                                        data-bs-original-title="Investment Mode:"
                                                                        aria-label="Investment Mode:"></i></strong></label>
															<div class="labfl">
																<div class="radfl">
															
															 <input type="radio" name="mode" value="sip" id="ftsip"> <label for="ftsip">SIP</label>

																</div>
																<div class="radfl">
    <input type="radio" name="mode" value="lump" id="ftlump"> 
																	<label for="ftlump">Lumpsum</label>
																</div>
															</div>
                                                        </div>
                                                    </div>
											 <div class="three_btn one_btn text-left">
                                                <div class="middle_left d-inline">
                                                    <button type="submit" class="calno btnsub btn">Calculate</button>
                                                </div>

                                            </div>
										</div>
									</form>
									<div class="row d-sm-flex d-block sip_calc_input mt-3">

    <table class="table table-striped fintsip">
        <thead>
            <tr>
                <th>Invested Amount</th>
                <th>Gains</th>
            </tr>
        </thead>
        <tbody class="tdatasip">

        </tbody>
    </table>
										
			<h3 id="sipval">SIP: <span id="sipvalue"></span></h3>

										 <table class="table table-striped siptablegoal">
        <thead>
            <tr>
                <th>Invested Amount</th>
                <th>Final Amount</th>
				<th>Gain</th>
                <th>Return %</th>
            </tr>
        </thead>
        <tbody class="siptdatagoal">

        </tbody>
    </table>
										
</div>

<canvas id="mygoal"></canvas>
								 </div>
							</div>
							
						</div>
					</div>
					
					<!-- goal planner faq -->
					 <div class="plan_faq">
                        <div class="faq_title">
                            <h4>FAQ - <span>Frequently asked questions</span></h4>
                        </div>
                        <div class="single_faq_calc">
                            <h4>What is Goal Planner?</h4>
                            <p>Setting a goal for future is a powerful process for thinking how your ideal future is going to be, and encouraging yourself to turn your vision of this future into reality. By knowing precisely what you want to achieve, you know where you have to concentrate your efforts.</p>
                        </div>
                        
                        <div class="single_faq_calc">
                            <h4>Importance of Goal Planner</h4>
                            <p>Goals help motivate us to develop strategies that enables us to perform at the required goal level. Planning any goal makes us efficient in working towards achieving it in return improving the quality of living. Accomplishing the goal can provide satisfaction, a peace of mind and future worth all the hard work. </p>
                        </div>
                        
                        
                      
                    </div>
				</div>				
<!--end -->
				
				
<div class="tab-pane fade" id="pills-weekly1" role="tabpanel" aria-labelledby="pills-weekly-tab1">
                    <div class="comp_schem_bdr">
                        <div class="s_renge p-0">
                            <div class="row calbanner">
                                <div class="l">
                                    <h4 class="heading-green">Lumpsum Planner</h4>
                                    <p>This calculator can help with the planning of various objectives/goals, to figure
                                        out estimated returns on investment after a certain time period by investing a
                                        lumpsum amount. </p>
                                </div>
                                <div class="r"><img
                                        src="https://myplexus.com/themes/frontend/assets/v1/img/SIPCalculator,.png">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 left-side">
                                    <div class="row">
                                           <div class="col-md-12 left-side">
                                    <form id="lumpcalc">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-12 mb-4">

                                                <div class="cal_form_select"><label for=""><strong>Invested Amount <i
                                                                class="ph ph-question" data-toggle="tooltip"
                                                                data-placement="top" title="Amount to be invested as a lumpsum"
                                                                data-bs-original-title="Amount to be invested as a lumpsum"
                                                                aria-label="Amount to be invested as a lumpsum"></i></strong></label><input
                                                        type="text" name="lumpamount" class="lumpamount form-text"
                                                        placeholder="Amount" /></div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 mb-4">
                                                <div class="cal_form_select"><label for=""><strong>Time period (in
                                                            years) *: <i class="ph ph-question" data-toggle="tooltip"
                                                                data-placement="top" title="For how long you want to invest"
                                                                data-bs-original-title="For how long you want to invest"
                                                                aria-label="For how long you want to invest"></i></strong></label>
                                                    <input type="number" name="lumptimeperiod" class="lumptimeperiod form-text"
                                                        placeholder="Time" />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 mb-4">
                                                <div class="cal_form_select"><label for=""><strong>Expected Growth</strong></label>
                                                    <select class="form-text lumpexpgrowth" name="lumpexpgrowth">
														<option value="">Select</option>
                                                        <option value="14">Aggressive (14%)</option>
                                                        <option value="12">Moderate (12%)</option>
                                                        <option value="10">Conservative (10%)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="three_btn one_btn text-center">
                                                <div class="middle_left d-inline">
                                                    <button type="submit" class="btn btnsub btn-cal"
                                                        name="callump">Calculate</button>

                                                </div>

                                            </div>
                                            <div class="finaltable">
                                                <div class="row d-sm-flex d-block sip_calc_input mt-3 tablegaindata">
                                                    <table class="table table-striped" id="lumpfinaldata">
                                                        <thead>
                                                            <tr>
                                                                <th>Invested amount</th>
                                                                <th>Final amount</th>
                                                                <th>Gain</th>
                                                                <th>Return%</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="lumpdata"></tbody>
                                                    </table>

                                                    <div>
                                                        <canvas id="myChartlump"></canvas>

                                                        <!--<button type="submit" class="btn btnsub"
                                                            name="calcsip" id="lumpgpbut">Show in table</button>-->
                                                        

                                                    </div>

                                                    <!--<table class="table table-striped mt-3" id="lumpgain">
                                                        <thead>
                                                            <tr>
                                                                <th>Amt invested</th>
                                                                <th>Gains</th>
                                                               
                                                            </tr>
                                                        </thead>
                                                        <tbody class="lumpgaindata">

                                                        </tbody>
                                                    </table>-->
                                                </div>
                                            </div>
                                        </div>
                                    </form>


                                </div>
                                        <div class="col-lg-6 col-md-12">
                                           
                                        </div>
                                    </div>
                                    <!--v-if--><!--v-if--><!--v-if--><!--v-if--><!--v-if--><!--v-if--><!--v-if--><!--v-if-->
                                </div>
                            </div>
                        </div>
                       
                    </div>
                    <div class="plan_faq">
                        <div class="faq_title">
                            <h4>FAQ - <span>Frequently asked questions</span></h4>
                        </div>
                        <div class="single_faq_calc">
                            <h4>What is Lumpsum Investment?</h4>
                            <p>Lumpsum investments are one-time investments wherein a substantial amount of money is
                                invested in a mutual fund scheme at once. These type of investments are generally
                                suitable for long term goals such as retirement planning, buying a house or any other
                                asset afetr several years, or building wealth over decades. Individulas with a long
                                investment horizon with potentially higher risk tolerance are ideal for lumpsum
                                investments since these investments are subject to market fluctualtions and can be
                                highly volatile in short time period.</p>
                        </div>
                        <div class="single_faq_calc">
                            <h4>Advantages of lumpsum investment</h4>
                        </div>
                        <div class="single_faq_calc">
                            <h4>Higher returns</h4>
                            <p>During bullish market, higher returns can be earned as a consequence of investing a
                                considerable amount in Mutual Funds, compared to investing in smaller amounts at regualr
                                intervals.</p>
                        </div>
                        <div class="single_faq_calc">
                            <h4>Convenience</h4>
                            <p>Investing in lumpsum mode is hassle free and convenient as individulas having a large
                                amount can spread their investments over longer time period and can choose from a wide
                                range of funds with varying investment objectives and risk profiles to align with their
                                financial goals.</p>
                        </div>
                        <div class="single_faq_calc">
                            <h4>Compunding benefits</h4>
                            <p>The power of compunding can help in gaining higher returns by investing early, which can
                                significantly increase wealth over time.</p>
                        </div>
                        <div class="single_faq_calc">
                            <h4>Who can invest in lumpsum mode?</h4>
                            <p>Lumpsum investments are ideal for investors with a view of longer time horizon and and
                                can withstand emotional and financial stress associated with market volatility.
                                Experienced and financially stable investors with a good understanding of the assets
                                they are investing in may be more comfortable with ceratin risk and losses associated
                                with lump-sum investments.</p>
                        </div>
                    </div>
                </div><!-- SIP PLANNER CALCULATOR TAB END --><!-- SIP CALCULATOR TAB START -->
                <div id="pills-monthly1" class="tab-pane fade active show" role="tabpanel"
                    aria-labelledby="pills-monthly-tab1">
                    <div class="comp_schem_bdr">
                        <div class="s_renge sip_calc_range_grop p-0">
                            <div class="row calbanner">
                                <div class="l">
                                    <h4 class="heading-green">SIP Planner</h4>
                                    <p>This calculator helps to understand wealth accumulation through investment on
                                        monthly basis.</p>
                                </div>
                                <div class="r"><img
                                        src="https://myplexus.com/themes/frontend/assets/v1/img/cal-1.png"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 left-side">
                                    <form id="sipcalc">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-12 mb-4">

                                                <div class="cal_form_select"><label for=""><strong>Amount *: <i
                                                                class="ph ph-question" data-toggle="tooltip"
                                                                data-placement="top" title=""
                                                                data-bs-original-title="The amount which you want to invest every month"
                                                                aria-label="The amount which you want to invest every month"></i></strong></label><input
                                                        type="text" name="amount" class="amount form-text"
                                                        placeholder="Amount" /></div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 mb-4">
                                                <div class="cal_form_select"><label for=""><strong>Time period (in
                                                            years) *: <i class="ph ph-question" data-toggle="tooltip"
                                                                data-placement="top" title=""
                                                                data-bs-original-title="For how long you want to invest"
                                                                aria-label="For how long you want to invest"></i></strong></label>
                                                    <input type="number" name="timeperiod" class="timep form-text"
                                                        placeholder="Time" />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 mb-4">
                                                <div class="cal_form_select"><label for=""><strong>Expected Growth</strong></label>
                                                    <select class="form-text expgrowth" name="expgrowth">
														<option value="">Select</option>
                                                        <option value="14">Aggressive (14%)</option>
                                                        <option value="12">Moderate (12%)</option>
                                                        <option value="10">Conservative (10%)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="three_btn one_btn text-center">
                                                <div class="middle_left d-inline">
                                                    <button type="submit" class="btn btnsub btn-cal"
                                                        name="calcsip">Calculate</button>

                                                </div>

                                            </div>
                                            <div class="finaltable">
                                                <div class="row d-sm-flex d-block sip_calc_input mt-3 tablegaindata">
                                                    <table class="table table-striped" id="tgaindata">
                                                        <thead>
                                                            <tr>
                                                                <th>Invested amount</th>
                                                                <th>Final amount</th>
                                                                <th>Gain</th>
                                                                <th>Return%</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="totalgaindata"></tbody>
                                                    </table>

                                                    <div>
                                                        <canvas id="myChart"></canvas>

                                                        <!--<button type="submit" class="btn btnsub btndistab"
                                                            name="calcsip" id="btndistabs">Show in table</button>-->
                                                        

                                                    </div>

                                                    <!--<table class="table table-striped mt-3" id="tallsipdata">
                                                        <thead>
                                                            <tr>
                                                                <th>Year</th>
                                                                <th>Investment</th>
                                                                <th>Investment Value</th>
                                                                <th>Gain</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="findata">

                                                        </tbody>
                                                    </table>-->
                                                </div>
                                            </div>
                                        </div>
                                    </form>


                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="plan_faq">
                        <div class="faq_title">
                            <h4>FAQ - <span>Frequently asked questions</span></h4>
                        </div>
                        <p>All the questions that you want to know the answers to - the why, the how, the what etc.
                            neatly put forth for your benefit.</p>
                        <div class="single_faq_calc">
                            <h4>What is SIP?</h4>
                            <p>Do you want to make a lot of money sometime in the future without worrying about short
                                term swings and always beat markets and have ample access to the money that you have
                                invested yet be relatively sure that the targets would be met? If just reading this long
                                sentence has wound you up but if your wish list is really this long then here it is. The
                                best thing to have happened to us since Aladdin’s Lamp is here and we explain everything
                                about it. Read on if you want to know everything about it and if you still have some
                                queries then let us know and we would try to clear all your doubts.</p>
                            <p>SIP is the popular shortened form for Systematic Investment Plan. This form of investing
                                refers to the system of putting in small amounts at regular intervals into a mutual fund
                                scheme to meet a, or a set of medium to long-term goals. The principle of regular
                                investing provides a working mechanism of beating markets - IT IS NOT ONLY IMPORTANT HOW
                                MUCH YOU INVEST IN THE MARKETS BUT IT IS FAR MORE IMPORTANT HOW MANY TIMES YOU INVEST.
                            </p>
                            <p>Further, it has been observed that target based investments are the most likely to
                                succeed. The reasons for this are not very difficult to find. The discipline to save and
                                invest for the target is high because there is a tangible objective and more importantly
                                YOU have set the objective. So it can be assumed that once you have set for yourself a
                                target, viz. buying a house, higher education for the children or your own retirement
                                planning, you would be more focused on meeting these objectives. But remember,
                                discipline is the most important factor and it makes sense that the discipline is
                                strictly enforced.</p>
                        </div>
                        <div class="single_faq_calc">
                            <h4>What are the benefits of SIP?</h4>
                            <h6>Long term wealth creation</h6>
                            <p>SIP provides an easy way for you to pace yourself towards a stated goal. Instead of
                                needing to put down a large amount in one go, you can calculate how much you need to put
                                in on, lets say a monthly basis. But please remember SIP does not work on short terms
                                and there is no way you would predict markets on an annual basis. The minimum duration
                                that we would advice is three years but it gets better the longer it goes.</p>
                            <h6>Low risk</h6>
                            <p>We are often compelled to envy someone who has made a killing in the stock markets but we
                                completely ignore the many instances when he had seen his money simply vanish. Nor do we
                                really advertise our goof ups as readily as we speak of our successes. But please
                                understand-it is impossible to beat the markets and even the best fund managers would
                                come short on beating markets all the time. But we can definitely, largely de-risk
                                ourselves from the entire gamut of high markets and low markets and needing to stay one
                                step ahead. By riding on all the cycles, it simply averages out the highs and the lows.
                                So long as the economy grows it is impossible that the markets or specifically the stock
                                market indices would not. Markets always tend to move along with the P.E(refers to the
                                ratio of the price of the stock to the profit per share) growth of the market, apart
                                from temporary aberrations. Just use this simple and easy step to make your fortune.</p>
                            <h6>Liquidity</h6>
                            <p>What happens if we suddenly needed some money, a little more than we have immediate
                                access to? Mutual funds and the equity mutual funds are largely open ended, and we
                                advocate largely open ended schemes. The good news is that you can pull out the entire
                                amount lying in your account. Just like that. No questions asked. And the entire amount
                                would be in your bank account within three working days.</p>
                            <h6>Predictability</h6>
                            <p>Can we look into our crystal ball and say that SIP is guaranteed to make money? The
                                simple answer is yes but with a condition. As long as we are investing in equities, in
                                an economy that is growing then we can safely say that we are guaranteed of performance.
                                It has been proven across diverse markets and a variety of time spans with the same set
                                of results. It is so common in the western world that SIP is now the most preferred way
                                to accumulate wealth amongst the salary earning population as well as self employed
                                professionals. Frankly do you expect that India would not grow or even worse, go down in
                                the next decade or more? Really that is not impossible but very very unlikely.</p>
                            <h6>Who all should use the system – what age, what profile, what stage of life etc.</h6>
                            <p>SIP is a long-term wealth creation tool. It is best suited for Professionals who would
                                want to painlessly plan for their long-term goals. Self-employed professionals who need
                                to definitely plan for their long-term goals and who do not have the benefit of pension,
                                gratuity etc. Businessmen who would want to hedge their risk by not putting everything
                                back into their own business but also take minor position in other business cycles as
                                well. For those planning to utilize the Income Tax bracket. Everybody else!!!!!!</p>
                            <h6>How does it work?</h6>
                            <p>Starting an SIP is very simple. You just need to fill up a form and payments could be
                                made by cheques or by using the auto debit facility from your bank. But you can stop the
                                payments for one time or for several times or for the remainder of the stated time
                                frame. It is actually very simple. Unless of course it is a lock in scheme where the
                                scheme does not allow withdrawal.</p>
                            <h6>Tax benefits</h6>
                            <p>Mutual fund schemes (the ones that are majorly invested in equity) do not have any long
                                term capital gains tax, dividends are tax free and short term capital gains are taxed at
                                10% Plus surcharge.</p>
                        </div>
                    </div>
                </div><!-- SIP CALCULATOR TAB END --><!-- INFLATION CALCULATOR TAB START -->
        
              
                <div id="risk-tol-eval" class="tab-pane fade">
                    <section class="compare_scheme pt-3">
                        <div class="container">
                            <div class="tab_snap_shot">
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="comp_schem_bdr">
                                        <div class="s_renge risk_tolarance_evaliator p-0">
                                            <div class="row calbanner">
                                                <div class="l">
                                                    <h4 class="heading-green"> Risk Tolerance Evaluator </h4>
                                                    <p>This helps to evaluate the degree of risk of an investor based on
                                                        a set of questions. </p>
                                                </div>
                                                <div class="r"><img
                                                        src="https://myplexus.com/themes/frontend/assets/v1/img/RiskAppetiteCalculator,.png">
                                                </div>
                                            </div>
                                            <div class="row" id="fromDataInput">
                                                <div class="col-md-12 left-side">
                                                    <div class="row">
                                                        <div
                                                            class="row m-0 invst-fields invst-field-1 justify-content-between mb-3">
                                                            <div class="col-md-6 d-none">
                                                                <div
                                                                    class="risk-tol-eval-common risk-tol-eval-email cal_form_select">
                                                                    <label>Email Address</label><input class="form-text"
                                                                        type="email" id="risk-tolerance-user-email"
                                                                        readonly="" placeholder="Enter Email">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 d-none">
                                                                <div
                                                                    class="risk-tol-eval-common risk-tol-eval-name cal_form_select">
                                                                    <label>Enter Name</label><input class="form-text"
                                                                        type="text" id="risk-tolerance-username"
                                                                        placeholder="Enter Name">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="invst-fields-action-buttons">
                                                            <div class="row m-0 justify-content-end">
                                                                <div class="action-common action-btn-1"><button
                                                                        id="next-step"
                                                                        class="btn btn-green reserch_discover_btn"
                                                                        href="javascript:void(0);">Start</button></div>
                                                            </div>
                                                        </div><!--v-if-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="invst-wrap invst-risk-tol-calc"><!--v-if--></div><!--v-if-->
                                        </div>
                                    </div>
                                    <div class="plan_faq">
                                        <div class="faq_title">
                                            <h4>FAQ - <span>Frequently asked questions</span></h4>
                                        </div>
                                        <div class="single_faq_calc">
                                            <h4>What is Risk Tolerance?</h4>
                                            <p>It is the ability of an individual to withstand negative outcomes in
                                                pusuit of a particular goal or investment. Usually young individuals
                                                should be able to take more risks than older individuals since young
                                                people have the capability to make more money working and have more time
                                                to handle market fluctuations.</p>
                                        </div>
                                        <div class="single_faq_calc">
                                            <h4>Categories of Risk Tolerance</h4>
                                        </div>
                                        <div class="single_faq_calc">
                                            <h4>Aggressive</h4>
                                            <p>Individuals in this category are generally comfortable with a high level
                                                of risk. Substantial returns are their first priority so they are
                                                willing to accept short term fluctuations and potential losses.</p>
                                        </div>
                                        <div class="single_faq_calc">
                                            <h4>Moderate</h4>
                                            <p>They are relatively less risk tolerant when compared to aggressive risk
                                                investors. They take on some risk but also seek to protect their
                                                investment to some extent. They balance their investments between risky
                                                and safe asset classes.</p>
                                        </div>
                                        <div class="single_faq_calc">
                                            <h4>Conservative</h4>
                                            <p>Highly risk averse individuals falls in this category. Their priority
                                                lies in preserving their investments and take on minimal risk in
                                                exchange for relatively lower potential returns.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div><!-- RISK TOLERANCE CALCULATOR TAB END -->
            </div>
        </div>
    </div>
</section>
<?php else: ?>
<div class="myplexus-login-page sip-calc-login">
    <div class="login-page">
        <div class="container">
            <div class="login-block bg-gry br-5 box-shadow">
                <div class="login-wrap">
                    <div class="sip-calc-wrapper">
                        <h3>Please Login First To Get Your Result</h3>
                        <div class="sip-calc-loginin-wrap">

                            <!-- <div class="sip-calc-social-login">
                                <h6>Log in with</h6>
                                <ul>
                                    <li><a href="<?php echo e(route('web.calculators.social.login','google')); ?>"><?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/frontend/assets/images/gmail-login-img.jpg')).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/frontend/assets/images/gmail-login-img.jpg')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?></a></li>
                                    <li><a href="<?php echo e(route('web.calculators.social.login','facebook')); ?>"><?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/frontend/assets/images/facebook-login-img.jpg')).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/frontend/assets/images/facebook-login-img.jpg')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?></a></li>
                                </ul>
                                <h6>OR</h6>
                            </div> -->

                            <div class="login_with">
                            <h5>Log In with</h5>
                            <ul>
                                <li><a href="<?php echo e(route('web.calculators.social.login','google-calc')); ?>"><i class="fa fa-envelope"></i></a></li>
                                <li><a href="<?php echo e(route('web.calculators.social.login','facebook-calc')); ?>"><i class="fa fa-facebook"></i></a></li>
                            </ul>
                            <h5>Or</h5>
                        </div>

                            <form action="<?php echo e(route('web.calculators')); ?>" method="POST">
                                <?php echo csrf_field(); ?>

                                <div class="login-field">
                                    <label>Enter your name</label>
                                    <input type="text" id="login_user" name="username" class="box-shadow" placeholder="John Doe" required />
                                </div>
                                <div class="password-field">
                                    <label>Enter your mail</label>
                                    <input type="email" id="login_pass" name="useremail" class="box-shadow" placeholder="Johndoe@mail.com" required />
                                </div>
                                <div class="log-other-opt">
                                    <div class="login-action-btn">
                                        <input type="submit" value="Next" class="text-uppercase btn-bg-2 f-b text-white" />
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </form>
                            <?php if(session()->has('alert')): ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.alert','data' => ['type' => ''.e(session()->get('alert')).'','title' => ''.e(session()->get('title')).'','message' => ''.e(session()->get('message')).'']]); ?>
<?php $component->withName('form.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => ''.e(session()->get('alert')).'','title' => ''.e(session()->get('title')).'','message' => ''.e(session()->get('message')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>
                            <div class="calculator-select-calc" style="display: none;">
                                <img src="../images/select-calc-bg-img.jpg" class="img-fluid">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    Chart.register(ChartDataLabels);

    // Initialize the chart
    var myChart = null;
    var tgaindata = document.getElementById("tgaindata");
    var myCharts = document.getElementById("myChart");
    //var tallsipdata = document.getElementById("tallsipdata");
    //var btndistabs = document.getElementById("btndistabs");

    var sipcalcForm = document.getElementById('sipcalc');
    var tallsipElements = document.querySelectorAll('.tallsip');
    var timep = [];

    sipcalcForm.addEventListener('submit', function (e) {
        e.preventDefault();
		 timep = [];
        // Clear the existing data in the tables and chart
        tgaindata.style.display = 'none';
        //tallsipdata.style.display = 'none';
        if (myChart) {
            myChart.destroy();
            myChart = null;
        }

        var amount = parseInt(document.querySelector('.amount').value);
        var timeperiod = parseInt(document.querySelector('.timep').value);
        var expgrowth = parseInt(document.querySelector('.expgrowth').value);
        var yearlyinve = amount * 12;

        var rateyear = expgrowth / 100 / 12;
        var finalam;
        var gain;
        var totalfinalcalc = 0;
        var finalcalcValues = [];
        var gainvalues = [];
        var finalinvvalue = [];

        /*var findata = document.querySelector('.findata');
        findata.innerHTML = '';*/

        for (let i = 1; i <= timeperiod; i++) {
            var finalcalc = amount * (Math.pow((1 + rateyear), (12 * i)) - 1) / rateyear * (1 + rateyear);
            var invvalue = yearlyinve*i;
            gain = finalcalc - invvalue;
            //var row = document.createElement('tr');
           /* row.innerHTML = '<td>' + i + '</td><td>' + invvalue.toFixed(0) + '</td><td>' + finalcalc.toFixed(0) + '</td><td>' + gain.toFixed(0) + '</td>';
            findata.appendChild(row);*/
            finalcalcValues.push(finalcalc.toFixed(2));
            gainvalues.push(gain.toFixed(2));
            finalinvvalue.push(invvalue.toFixed(2));
            timep.push(i);
        }
		        var format = new Intl.NumberFormat('en-IN', {
                style: 'currency',
                currency: 'INR',
                minimumFractionDigits: 2,
            });
        finalam = amount * (Math.pow((1 + rateyear), (12 * timeperiod)) - 1) / rateyear * (1 + rateyear);
        var iamt = format.format(timeperiod * yearlyinve);
        var famt =format.format(finalam);
        var gamt = format.format((finalam - timeperiod * yearlyinve));
		
        

        var totalgaindata = document.querySelector('.totalgaindata');
        tgaindata.style.display = "table";
       //btndistabs.style.display = "block";

        totalgaindata.innerHTML = '';

        var row = document.createElement('tr');
        row.innerHTML = '<td>' + iamt+ '</td><td>' + famt + '</td><td>' + gamt + '</td><td>' + expgrowth + '%</td>';
        totalgaindata.appendChild(row);

        // Create or update the chart with the new data
        createChart(timep, finalinvvalue, finalcalcValues, gainvalues);
    });

    function createChart(timep, finalinvvalue, finalcalcValues, gainvalues) {
        const data = {
            labels: timep,
            datasets: [{
                label: 'Investment',
                backgroundColor: '#4472c4',
                borderColor: 'rgb(255, 99, 132)',
                data: finalinvvalue,
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: "#4472c4",
                    font: {
                        weight: 'bold',
                        size: 16
                    },
                    formatter: function (value, context, values) {
                        return new Intl.NumberFormat('en-IN', {
                            style: 'currency',
                            currency: 'INR',
                            maximumSignificantDigits: 10
                        }).format(value)
                    }
                }
            },
            {
                label: 'Investment value',
                backgroundColor: '#ed7d31',
                borderColor: 'rgb(255, 99, 132)',
                data: finalcalcValues,
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: "#000",
                    font: {
                        weight: 'bold',
                        size: 16
                    },
                    formatter: function (value, context, values) {
                        return new Intl.NumberFormat('en-IN', {
                            style: 'currency',
                            currency: 'INR',
                            maximumSignificantDigits: 10
                        }).format(value)
                    }
                }
            },
            {
                label: 'Gain',
                backgroundColor: '#a5a5a5',
                borderColor: 'rgb(255, 99, 132)',
                data: gainvalues,
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: "#000",
                    font: {
                        weight: 'bold',
                        size: 16
                    },
                    formatter: function (value, context, values) {
                        return new Intl.NumberFormat('en-IN', {
                            style: 'currency',
                            currency: 'INR',
                            maximumSignificantDigits: 10
                        }).format(value)
                    }
                }
            }
            ]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: "bottom"
                    },
                    datalabels: {
                        display: false
                    }
                },
                locale: 'en-IN',
                indexAxis: 'x',
                scales: {
					x: {
                title: {
                    display: true,
                    text: 'Years',
					font: {
                        size: 20, // Set the font size for the x-axis title
                        weight: 'bold' // Set the font weight for the x-axis title
                    }
                },
				ticks:{
				font:{
						weight:'bold',
				size:16}}
            },
                    y: {
						title: {
                    display: true,
                    text: 'Amount',
							font: {
                        size: 20, // Set the font size for the x-axis title
                        weight: 'bold' // Set the font weight for the x-axis title
                    }
                },
                        ticks: {
                            callback: (value, index, values) => {
                                return new Intl.NumberFormat('en-IN', {
                                    style: 'currency',
                                    currency: 'INR',
                                    maximumSignificantDigits: 3
                                }).format(value)
                            },font:{
						weight:'bold',
						size:16}
                        }
						
                    }
                }
            },
        };

        myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    }

    document.querySelectorAll('.btndistab').forEach(function (element) {
        element.addEventListener('click', function (e) {
            e.preventDefault();
            tallsipdata.style.display = 'table';
        });
    });
});
</script>
<script>
     document.addEventListener('DOMContentLoaded', function() {
    Chart.register(ChartDataLabels);

    // Initialize the chart
    var myChartlump = null;
    //var lumpgaindata = document.querySelector('.lumpgaindata');
    var lumpdata = document.querySelector('.lumpdata');
    var lumpfinaldata = document.getElementById("lumpfinaldata");
    //var lumpgpbut = document.getElementById("lumpgpbut");
    var lumpgainTable = document.getElementById('lumpgain');

    var lumpcalcForm = document.getElementById('lumpcalc');
    lumpcalcForm.addEventListener('submit', function(e) {
        e.preventDefault();
        var lumpamt = parseInt(document.querySelector('.lumpamount').value);
        var lumptimeperiod = parseInt(document.querySelector('.lumptimeperiod').value);
        var lumpexpgrowth = parseInt(document.querySelector('.lumpexpgrowth').value);

        var fval;
        var gain;
        fval = lumpamt * Math.pow(1 + (lumpexpgrowth / 100), lumptimeperiod);
        gain = fval - lumpamt;

        // Clear the existing data in the tables
        //lumpgaindata.innerHTML = '';
        lumpdata.innerHTML = '';
		var format = new Intl.NumberFormat('en-IN', {
                style: 'currency',
                currency: 'INR',
                minimumFractionDigits: 2,
            });

        /*var newRow1 = document.createElement('tr');
        newRow1.innerHTML = '<td>' + format.format(lumpamt) + '</td><td>' + format.format(gain) + '</td>';
        lumpgaindata.appendChild(newRow1);*/

        var newRow2 = document.createElement('tr');
        newRow2.innerHTML = '<td>' + format.format(lumpamt) + '</td><td>' + format.format(fval) + '</td><td>' + format.format(gain) + '</td><td>' + lumpexpgrowth + '%</td>';
        lumpdata.appendChild(newRow2);

        lumpfinaldata.style.display = "table";

        // Create or update the chart
        if (myChartlump === null) {
            createChart(lumpamt, gain);
        } else {
            updateChart(myChartlump, lumpamt, gain);
        }

        //lumpgpbut.style.display = "block";
    });

    function createChart(lumpamt, gain) {
        var totalamount= lumpamt + gain;
       
       var perinve=(lumpamt/totalamount.toFixed(2))*100;
       var pergain=(gain/totalamount.toFixed(2))*100;
        const datalump = {
            labels: ['Amount Invested', 'Gains'],
            datasets: [{
                label: 'Amount Invested',
                data: [perinve.toFixed(0), pergain.toFixed(0)],
                backgroundColor: ['#4472c4', '#ed7d31'],
                datalabels: {
                    anchor: 'center',
                    align: 'center',
                    color: "#fff",
                    font: {
                        weight: '400',
                        size: 17,
                        family: 'Bebas Neue'
                    },
                    formatter: function(value, context, values) {
                        return value+"%";
                    }
                }
            }]
        };

        const config = {
            type: 'doughnut',
            data: datalump,
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: "bottom"
                    },
                    datalabels: {
                        display: function(context) {
                            return context.chart.width > 250;
                        }
                    },
                },
                locale: 'en-IN',
                indexAxis: 'x',
            },
        };

        myChartlump = new Chart(
            document.getElementById('myChartlump'),
            config
        );
    }

    function updateChart(chart, lumpamt, gain) {
        var totalamount= lumpamt + gain;
       
        var perinve=(lumpamt/totalamount.toFixed(2))*100;
        var pergain=(gain/totalamount.toFixed(2))*100;
        chart.data.datasets[0].data = [perinve.toFixed(0), pergain.toFixed(0)];
        chart.update();
    }

   /* document.querySelectorAll('#lumpgpbut').forEach(function (element) {
        element.addEventListener('click', function (e) {
            e.preventDefault();
            lumpgainTable.style.display = 'table';
        });
    });*/
});
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    // Initialize variables
    var total_cost;
    var duration;
    var inflation;
    var targetvalue;
    var totalInvestmentRequired;
    var myChartgoal = null; // Initialize the chart variable
    var siptablegoal = document.querySelector('.siptablegoal');

    // Hide all content divs initially
    var contentDivs = document.querySelectorAll(".content");
    contentDivs.forEach(function (div) {
        div.style.display = "none";
    });

    // Listen for changes on the dropdown
    var planSelect = document.querySelector(".plan");
    planSelect.addEventListener("change", function () {
        // Get the selected option value
        var selectedOption = planSelect.value;
	    document.getElementById('tval').style.display = 'none';
		document.getElementById('calsip').style.display = 'none';
		document.querySelector('.planno').style.display = 'none';
		document.getElementById('sipval').style.display = 'none';
		document.querySelector('.siptablegoal').style.display = 'none';
		document.getElementById('mygoal').style.display = 'none';
		

        // Hide all content divs
        contentDivs.forEach(function (div) {
            div.style.display = "none";
        });

        // Show the corresponding content div based on the selected option
        document.getElementById(selectedOption).style.display = "block";
    });
		

    // Listen for changes in input fields within each content div
    var contentInputs = document.querySelectorAll(".content input, .content select");
    contentInputs.forEach(function (input) {
        input.addEventListener("input", function () {
            var selectedOption = planSelect.value;

            if (selectedOption === "A") {
                total_cost = parseInt(document.querySelector('.presentcost').value);
                duration = parseInt(document.querySelector('.marriageyears').value);
                inflation = parseInt(document.querySelector('.inflationchildmar').value);
            } else if (selectedOption === "B") {
                total_cost = parseInt(document.querySelector('.presentcostedu').value);
                duration = parseInt(document.querySelector('.eduyears').value);
                inflation = parseInt(document.querySelector('.inflationchildedu').value);
            } else if (selectedOption === "C") {
                total_cost = parseInt(document.querySelector('.presentcostasset').value);
                duration = parseInt(document.querySelector('.assetyears').value);
                inflation = parseInt(document.querySelector('.inflationasset').value);
            } else if (selectedOption === "D") {
                total_cost = parseInt(document.querySelector('.presentcostgoal').value);
                duration = parseInt(document.querySelector('.goalyears').value);
                inflation = parseInt(document.querySelector('.inflationgoal').value);
            }
			
        });
    });

    var targetValueElement = document.getElementById('targetvalue');
    var plannoButton = document.querySelector('.planno');
    var calsipForm = document.getElementById('calsip');
	var sipvaluetar=document.getElementById('sipvalue');
	var sipvaluetar=document.getElementById('sipvalue');
	var sipvalhead= document.getElementById('sipval');
    var tdatasipTable = document.querySelector('.tdatasip');
    var fintsipDiv = document.querySelector('.fintsip');
    var tartable = document.getElementById('tval');
    var format = new Intl.NumberFormat('en-IN', {
        style: 'currency',
        currency: 'INR',
        minimumFractionDigits: 2,
    });

    // Reset the table and chart
    function resetTableAndChart() {
        targetValueElement.innerHTML = '';
        var tbody = tdatasipTable.querySelector('tbody');
        if (tbody) {
            tbody.innerHTML = ''; // Clear the tbody
        }
        if (myChartgoal) {
            myChartgoal.destroy(); // Destroy the existing chart if it exists
        }
        fintsipDiv.style.display = 'none';
        siptablegoal.style.display = 'none';
    }

    // Submit the goalplanner form
    document.getElementById('goalplanner').addEventListener("submit", function (e) {
        e.preventDefault();
        resetTableAndChart();

        // Continue with the rest of the code
        targetvalue = total_cost * Math.pow(1 + (inflation / 100), duration);
        tartable.style.display = "block";
        targetValueElement.innerHTML = format.format(targetvalue);
        plannoButton.style.display = 'block';
    });

    // Toggle the calsip form
    var calsipFormVisible = false;

    plannoButton.addEventListener("click", function (e) {
        e.preventDefault();
        calsipFormVisible = !calsipFormVisible;
        calsipForm.style.display = calsipFormVisible ? 'block' : 'none';
    });

    var totalInvestmentRequiredsip;
    // Submit the calsip form
    calsipForm.addEventListener("submit", function (e) {
        // Destroy the existing chart if it exists
        if (myChartgoal !== null) {
            myChartgoal.destroy();
        }

        document.getElementById('mygoal').style.display = 'block';

        e.preventDefault();
        var expg = parseInt(document.querySelector('.expgro').value);
        var mode = document.querySelector('input[name="mode"]:checked').value;
        var intratemonth = expg / 100 / 12;
        var months = duration * 12;
        var gain;
        var timep = [];
        var finalcalcvalues = [];
        var gainvalues = [];
        var finalinvvalue = [];
		var totalInvestmentRequiredsipannual;

        if (mode === "sip") {
           totalInvestmentRequiredsip = targetvalue / (((Math.pow(1 + intratemonth, months) - 1) / intratemonth) * (1 + intratemonth));
			
			sipvaluetar.innerHTML= format.format(totalInvestmentRequiredsip);
			sipvalhead.style.display="block";
            totalInvestmentRequiredsipannual = totalInvestmentRequiredsip * 12;
        
            for (let i = 1; i <= duration; i++) {
                var finalcalc = totalInvestmentRequiredsip * (Math.pow((1 + intratemonth), (12 * i)) - 1) / intratemonth * (1 + intratemonth);
                gain = finalcalc - totalInvestmentRequiredsipannual*i;
                finalcalcvalues.push(finalcalc.toFixed(2));
                gainvalues.push(gain.toFixed(2));
                finalinvvalue.push(totalInvestmentRequiredsipannual*i.toFixed(2));
                timep.push(i);
            }
            const data = {
                labels: timep,
                datasets: [{
                    label: 'Investment',
                    backgroundColor: '#4472c4',
                    borderColor: 'rgb(255, 99, 132)',
                    data: finalinvvalue,
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: "#4472c4",
                        font: {
                            weight: 'bold',
                            size: 16
                        },
                        formatter: function (value, context, values) {
                            return new Intl.NumberFormat('en-IN', {
                                style: 'currency',
                                currency: 'INR',
                                maximumSignificantDigits: 10
                            }).format(value);
                        }
                    }
                },
                {
                    label: 'Investment value',
                    backgroundColor: '#ed7d31',
                    borderColor: 'rgb(255, 99, 132)',
                    data: finalcalcvalues,
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: "#000",
                        font: {
                            weight: 'bold',
                            size: 16
                        },
                        formatter: function (value, context, values) {
                            return new Intl.NumberFormat('en-IN', {
                                style: 'currency',
                                currency: 'INR',
                                maximumSignificantDigits: 10
                            }).format(value);
                        }
                    }
                },
                {
                    label: 'Gain',
                    backgroundColor: '#a5a5a5',
                    borderColor: 'rgb(255, 99, 132)',
                    data: gainvalues,
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: "#000",
                        font: {
                            weight: 'bold',
                            size: 16
                        },
                        formatter: function (value, context, values) {
                            return new Intl.NumberFormat('en-IN', {
                                style: 'currency',
                                currency: 'INR',
                                maximumSignificantDigits: 10
                            }).format(value);
                        }
                    }
                }
                ]
            };

            const config = {
                type: 'bar',
                data: data,
                options: {
                    plugins: {
                        legend: {
                            display: true,
                            position: "bottom"
                        },
                        datalabels: {
                            display: false
                        }
                    },
                    locale: 'en-IN',
                    indexAxis: 'x',
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Years',
                                font: {
                                    size: 20,
                                    weight: 'bold'
                                }
                            },
                            ticks: {
                                font: {
                                    weight: 'bold',
                                    size: 16
                                }
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Amount',
                                font: {
                                    size: 20,
                                    weight: 'bold'
                                }
                            },
                            ticks: {
                                callback: (value, index, values) => {
                                    return new Intl.NumberFormat('en-IN', {
                                        style: 'currency',
                                        currency: 'INR',
                                        maximumSignificantDigits: 3
                                    }).format(value);
                                },
                                font: {
                                    weight: 'bold',
                                    size: 16
                                }
                            }
                        }
                    }
                },
            };

            myChartgoal = new Chart(
                document.getElementById('mygoal'),
                config
            );
        } else if (mode === "lump") {
			sipvalhead.style.display="none";
            totalInvestmentRequired = targetvalue / Math.pow(1 + (10 / 100), duration);
			Chart.register(ChartDataLabels);
            myChartgoal = new Chart(document.getElementById('mygoal'), {
                type: 'doughnut',
                data: {
                    labels: ['Amount Invested', 'Gains'],
                    datasets: [{
                        label: 'Amount Invested',
                        data: [0, 0],
                        backgroundColor: ['#4472c4', '#ed7d31'],
                    }]
                },
                  options: {
    plugins: {
        legend: {
            display: true,
            position: "bottom"
        },
        datalabels: {
            display: true,
            color: 'white',
            font: {
                weight: 'bold',
                size: 16
            },
            formatter: function (value, context,values) {
                return value + '%';
            }
        }
    },
    locale: 'en-IN',
    indexAxis: 'x'
}
            });
        }

        
        if (mode === "sip") {
            fintsipDiv.style.display = 'none';
            
            var chartCanvas = document.getElementById('mygoal');
            if (chartCanvas) {
                chartCanvas.style.width = '100%';
                chartCanvas.style.height = '600px';
            }

            var tdatasipTable = document.querySelector('.siptdatagoal');
            tdatasipTable.innerHTML='';
            tdatasipTable.innerHTML += '<tr><td>' + format.format(totalInvestmentRequiredsipannual*duration) + '</td><td>' + format.format(targetvalue) + '</td><td>' + format.format(targetvalue - totalInvestmentRequiredsipannual*duration) + '</td><td>' + expg + '%</td></tr>';
            siptablegoal.style.display = 'table';
            //siptablegoal.style.display = 'block';
        }

        if (mode === "lump") {
            fintsipDiv.style.display = 'table';
            siptablegoal.style.display = 'none';
            gain = targetvalue - totalInvestmentRequired;

            var tbody = document.querySelector('.tdatasip');
            tbody.innerHTML = '';

            var newRow = document.createElement('tr');
            newRow.innerHTML = '<td>' + format.format(totalInvestmentRequired) + '</td><td>' + format.format(gain) + '</td>';
            tbody.appendChild(newRow);

            var chartCanvas = document.getElementById('mygoal');
            if (chartCanvas) {
                chartCanvas.style.width = '400px';
                chartCanvas.style.height = 'auto';
                chartCanvas.style.margin = 'auto';
            }
			 var total=totalInvestmentRequired+gain;
            var perinve=(totalInvestmentRequired/total.toFixed(2))*100;
        var pergain=(gain/total.toFixed(2))*100;

            myChartgoal.data.datasets[0].data = [perinve.toFixed(0), pergain.toFixed(0)];
            myChartgoal.update();
        }
    });
});
    </script>


   <script>
           document.addEventListener("DOMContentLoaded", function () {
            var inflationChart = null;

            document.getElementById("inflationcalc").addEventListener("submit", function (e) {
                e.preventDefault();

                var currentExpenses = parseFloat(document.querySelector(".vcexp").value);
                var inflationRate = parseFloat(document.querySelector(".infrateann").value);
                var timePeriod = parseFloat(document.querySelector(".tperiodinf").value);

                if (!isNaN(currentExpenses) && !isNaN(inflationRate) && !isNaN(timePeriod)) {
                    var data = [];
                    var labels = [];

                    for (var t = 1; t <= timePeriod; t++) {
                        var futureExpenses = currentExpenses * Math.pow((1 + (inflationRate / 100)), t);
                        data.push(futureExpenses.toFixed(2));
                        labels.push(t);
                    }

                    // Clear the previous chart if it exists
                    if (inflationChart) {
                        inflationChart.destroy();
                    }
					var format = new Intl.NumberFormat('en-IN', {
                style: 'currency',
                currency: 'INR',
                minimumFractionDigits: 2,
					
					});

                    document.getElementById("result").textContent = "Inflation Adjusted Amount: "+ format.format(futureExpenses);

                    createChart(labels, data); // Create and display the chart

                    // Set the chart to display:block
                    document.getElementById('inflationChart').style.display = 'block';
                } else {
                    document.getElementById("result").textContent = "Please enter valid values for current expenses, inflation rate, and time period.";

                    // Set the chart to display:none
                    document.getElementById('inflationChart').style.display = 'none';
                }
            });

            function createChart(labels, data) {
                var ctx = document.getElementById('inflationChart');

                inflationChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Inflated Amount',
                            data: data,
                            borderColor: '#6ab130',
                            backgroundColor: '#6ab130',
                            barThickness: 40,
                            datalabels: {
                                anchor: 'end',
                                align: 'top',
                                color: "#4472c4",
                                font: {
                                    weight: '400',
                                    size: 15
                                },
                                formatter: function (value, context, values) {
                                    return new Intl.NumberFormat('en-IN', {
                                        style: 'currency',
                                        currency: 'INR',
                                        maximumSignificantDigits: 10
                                    }).format(value)
                                }
                            }
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                display: true,
                                position: "bottom"
                            },
                            datalabels: {
                                display: false
                            }
                        },
                        locale: 'en-IN',
                        indexAxis: 'x',
                        scales: {
							
                            y: {
								title: {
                    display: true,
                    text: 'Amount',
							font: {
                        size: 20, // Set the font size for the x-axis title
                        weight: 'bold' // Set the font weight for the x-axis title
                    }
                },
                                ticks: {
                                    callback: (value, index, values) => {
                                        return new Intl.NumberFormat('en-IN', {
                                            style: 'currency',
                                            currency: 'INR',
                                            maximumSignificantDigits: 3
                                        }).format(value)
                                    },font:{
						weight:'bold',
						size:16}
                                }
                            },
                            x:{
							 title: {
                    display: true,
                    text: 'Years',
					font: {
                        size: 20, // Set the font size for the x-axis title
                        weight: 'bold' // Set the font weight for the x-axis title
                    }
                },ticks:{
				font:{
					
						weight:'bold',
						size:16
}
				}}
                        }
                    },
                });
            }
        });
    </script>

<script>
	document.addEventListener("DOMContentLoaded", function () {
var slider = document.getElementById("current_age_output");
var output = document.getElementById("currage");

var slidertwo = document.getElementById("expected_age_retirement_output");
var outputtwo = document.getElementById("expageret");
		
var sliderthree = document.getElementById("life_expectancy_output");
var outputthree = document.getElementById("lifexp");
		
var sliderfour = document.getElementById("accumulation_period_output");
var outputfour = document.getElementById("accumulation_period");
		
var sliderfive = document.getElementById("retirement_output");
var outputfive = document.getElementById("rateretirement");

var slidersix = document.getElementById("inflation_output");
var outputsix = document.getElementById("rateinflationret");
		
slider.oninput = function() {
  output.value = this.value;
}

slidertwo.oninput = function() {
  outputtwo.value = this.value;
}
		
sliderthree.oninput = function() {
  outputthree.value = this.value;
}
		sliderfour.oninput = function() {
  outputfour.value = this.value;
}
		sliderfive.oninput = function() {
  outputfive.value = this.value;
}
		slidersix.oninput = function() {
  outputsix.value = this.value;
}
	});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var corpdrer = document.querySelector('.corpdrer');
    corpdrer.style.display = 'none';

    document.getElementById('retcal').addEventListener('submit', function(e) {
        e.preventDefault();

        var currage = parseInt(document.getElementById('currage').value);
        var expageret = parseInt(document.getElementById('expageret').value);
        var lifexp = parseInt(document.getElementById('lifexp').value);

        var years_bef_retire = expageret - currage;
        var years_after_retire = lifexp - expageret;
        
        var accumulation_period = parseFloat(document.getElementById('accumulation_period').value) / 100;
        var rateretirement = parseFloat(document.getElementById('rateretirement').value) / 100;
        var rateinflationret = parseFloat(document.getElementById('rateinflationret').value) / 100;
        var mothexp = parseInt(document.getElementById('mothexp').value);
        var pension = parseInt(document.getElementById('pension').value);
        var currsav = parseInt(document.getElementById('currsav').value);
        var currlump = parseInt(document.getElementById('currlump').value);

        var monthly_exp_after_ret = mothexp * Math.pow(1 + rateinflationret, years_bef_retire);
        var pension_inf_adjusted = pension * Math.pow(1 + rateinflationret, years_after_retire);
        var annual_expafter_retirement = (monthly_exp_after_ret - pension_inf_adjusted) * 12;
        var inf_adj_return = ((1 + rateretirement) / (1 + rateinflationret)) - 1;

        function customPV(rate, nper, pmt) {
            var retirementcorpus = 0;
            for (var i = 1; i <= nper; i++) {
                retirementcorpus += pmt / Math.pow(1 + rate, i);
            }
            return retirementcorpus;
        }
        
        var retirementcorpus = customPV(inf_adj_return, years_after_retire, annual_expafter_retirement);
        var r = accumulation_period / 12;
        var n = years_bef_retire * 12;

        var retirement_time_current_month_savings = currsav * ((Math.pow(1 + r, n) - 1) / r);

        var retirement_time_current_lumpsum_savings = currlump * Math.pow(1 + accumulation_period, years_bef_retire);

        var required_corpus = retirementcorpus - (retirement_time_current_month_savings + retirement_time_current_lumpsum_savings);

        function calculateSavingsPerMonth(rate, years, corpus) {
            var months = years * 12;
            var monthlyRate = rate / 12;
            var savingsPerMonth = (corpus * monthlyRate) / (Math.pow(1 + monthlyRate, months) - 1);
            return savingsPerMonth;
        }

        var savpermonth = calculateSavingsPerMonth(accumulation_period, years_bef_retire, required_corpus);
        var saveperyear = savpermonth * 12;

        document.getElementById('corpret').innerHTML = '₹' + retirementcorpus.toFixed(2);
        document.getElementById('spmonth').innerHTML = '₹' + savpermonth.toFixed(2);
        document.getElementById('spyear').innerHTML = '₹' + saveperyear.toFixed(2);

        corpdrer.style.display = 'block';
    });
});
</script>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the current URL's query parameters
            var urlParams = new URLSearchParams(window.location.search);

            // Get a specific parameter by name
            var cal = urlParams.get('cal');

            var tabButtons = document.querySelectorAll('.tab_snap_shot button');
            var tabPanes = document.querySelectorAll('.tab-pane');

            if (cal === "sip") {
                tabButtons.forEach(function(button) {
                    button.classList.remove('active');
                });

                var monthlyTab = document.getElementById('pills-monthly-tab1');
                monthlyTab.classList.add('active');

                tabPanes.forEach(function(pane) {
                    pane.classList.remove('active', 'show');
                });

                var monthlyPane = document.getElementById('pills-monthly1');
                monthlyPane.classList.add('active', 'show');
            }
            else if (cal === "lump") {
                tabButtons.forEach(function(button) {
                    button.classList.remove('active');
                });

                var weeklyTab = document.getElementById('pills-weekly-tab1');
                weeklyTab.classList.add('active');

                tabPanes.forEach(function(pane) {
                    pane.classList.remove('active', 'show');
                });

                var weeklyPane = document.getElementById('pills-weekly1');
                weeklyPane.classList.add('active', 'show');
            }
            else if (cal === "retire") {
                tabButtons.forEach(function(button) {
                    button.classList.remove('active');
                });

                var retireTab = document.getElementById('pills-monthly-tab3');
                retireTab.classList.add('active');

                tabPanes.forEach(function(pane) {
                    pane.classList.remove('active', 'show');
                });

                var retirePane = document.getElementById('pills-monthly3');
                retirePane.classList.add('active', 'show');
            }
            else if (cal === "inflation") {
                tabButtons.forEach(function(button) {
                    button.classList.remove('active');
                });

                var inflationTab = document.getElementById('pills-monthly-tab2');
                inflationTab.classList.add('active');

                tabPanes.forEach(function(pane) {
                    pane.classList.remove('active', 'show');
                });

                var inflationPane = document.getElementById('pills-monthly2');
                inflationPane.classList.add('active', 'show');
            }
			else if (cal === "pills-goal1") {
                tabButtons.forEach(function(button) {
                    button.classList.remove('active');
                });

                var goalplanner = document.getElementById('pills-goal-tab1');
                goalplanner.classList.add('active');

                tabPanes.forEach(function(pane) {
                    pane.classList.remove('active', 'show');
                });

                var goalplannerPane = document.getElementById('pills-goal1');
                goalplannerPane.classList.add('active', 'show');
            }
			
			  var monthlyTab1 = document.getElementById('pills-monthly-tab4');
			
			 if (monthlyTab1) {
    monthlyTab1.addEventListener('click', function(e) {
      e.preventDefault();
      window.location.href = 'https://myplexus.com/calculator?cal=risk';
    });
  }

        });
    </script>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/web/pages/calculatortest.blade.php ENDPATH**/ ?>