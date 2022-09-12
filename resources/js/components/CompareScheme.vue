<template>
<section class="compare_scheme">
    <div class="container">
        <div class="comp_schem_bdr">
            <h4>Compare Scheme</h4>
            <div class="tab_comp">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" :class="{'active':currentTab == 'daily_price'}" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                            <img :src="this.image_path+'/tab_icon.png'" alt="" />
                            Daily Price
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" :class="{'active show':currentTab == 'ratios'}" @click="currentTab='ratios'" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">
                            <img :src="this.image_path+'/tab_icon1.png'" alt="" />
                            Ratio
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">
                            <img :src="this.image_path+'/tab_icon2.png'" alt="" />
                            Composition
                        </button>
                    </li>
                </ul>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade" :class="{'active show':currentTab == 'daily_price'}" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="table_scc">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr class="bg_top top_bg_right_black">
                                        <td colspan="3">
                                            <div class="form_select">
                                                <label for="">Schemes</label>
                                                <select class="form-select" aria-label="Default select example" id="scheme_one">

                                                </select>
                                            </div>
                                        </td>
                                        <td class="bg_222">
                                            <div class="form_select">
                                                <label for="">From Date</label>
                                                <input class="form-date" type="date" v-model="selectedDateRangeFrom" />
                                            </div>
                                        </td>
                                        <td class="bg_222">
                                            <div class="form_select">
                                                <label for="">To Date</label>
                                                <input class="form-date" type="date" v-model="selectedDateRangeTo" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="bg_green">
                                        <td>
                                            <div class="form_select">
                                                <label for="">Schemes</label>
                                                <select class="form-select" aria-label="Default select example" v-model="selectedScheme1" :disabled="compare_price_process">
                                                    <option v-for="fund in funds" :value="fund">{{fund.fund_name}}</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form_select">
                                                <label for="">Schemes</label>
                                                <select class="form-select" aria-label="Default select example" v-model="selectedScheme2" :disabled="compare_price_process">
                                                    <option v-for="fund in funds" :value="fund">{{fund.fund_name}}</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form_select">
                                                <label for="">Schemes</label>
                                                <select class="form-select" aria-label="Default select example">
                                                    <option selected>Aditya Birla Sun Life Arbitrage</option>
                                                    <option value="">Aditya Birla Sun Life Arbitrage</option>
                                                    <option value="">Aditya Birla Sun Life Arbitrage</option>
                                                    <option value="">Aditya Birla Sun Life Arbitrage</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form_select">
                                                <label for="">Schemes</label>
                                                <select class="form-select" aria-label="Default select example">
                                                    <option selected>Aditya Birla Sun Life Arbitrage</option>
                                                    <option value="">Aditya Birla Sun Life Arbitrage</option>
                                                    <option value="">Aditya Birla Sun Life Arbitrage</option>
                                                    <option value="">Aditya Birla Sun Life Arbitrage</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form_select">
                                                <label for="">Schemes</label>
                                                <select class="form-select" aria-label="Default select example">
                                                    <option selected>Aditya Birla Sun Life Arbitrage</option>
                                                    <option value="">Aditya Birla Sun Life Arbitrage</option>
                                                    <option value="">Aditya Birla Sun Life Arbitrage</option>
                                                    <option value="">Aditya Birla Sun Life Arbitrage</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="three_btn">
                        <div class="row align-items-center">
                            <div class="col-lg-4">
                                <div class="middle_left">
                                    <a href="javascript://" :disabled="disableComparePrice || compare_price_process" @click="priceCompare">Compare</a>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="middle_a d-flex align-items-center justify-content-center">
                                    <a href="" class="active">Day to Day</a>
                                    <a href="">Weekly</a>
                                    <a href="">Monthly</a>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="middle_a d-flex align-items-center justify-content-md-end justify-content-center">
                                    <a href="javascript://" @click="selectedDuration=1" :class="selectedDuration==1 ? 'active' :''">1M</a>
                                    <a href="javascript://" @click="selectedDuration=3" :class="selectedDuration==3 ? 'active' :''">3M</a>
                                    <a href="javascript://" @click="selectedDuration=6" :class="selectedDuration==6 ? 'active' :''">6M</a>
                                    <a href="javascript://" @click="selectedDuration=12" :class="selectedDuration==12 ? 'active' :''">1Y</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <LoadingBar :status="loadingStatus"></LoadingBar>
                    </div>
                    <p v-if="notice_text" class="text-warning mt-3 text-center w-100 mb-0">{{notice_text}}</p>
                    <div class="mt-5 " style="width: 100%;" v-show="show_graph">
                        <div class="row">
                            <div class="col-lg-6 col-md-5 col-sm-12">
                                <div id="chartContainer" style="height: 360px;"></div>
                            </div>
                            <div class="col-lg-6 col-md-5 col-sm-12">
                                <div id="dataPriceChatTwo" style="height: 360px;"></div>
                            </div>
                        </div>
                    </div>
                     <p v-if="nodata_text" class="text-warning mt-3 text-center w-100 mb-0">{{nodata_text}}</p>
                </div>
                <!-- ratio calulation -->
                <div class="tab-pane fade"  :class="{'active show':currentTab == 'ratios'}" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="table_scc">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr class="bg_top top_bg_right_black">
                                                <td colspan="3">
                                                    <div class="form_select">
                                                        <label for="">Schemes</label>
                                                        <select class="form-select" aria-label="Default select example">
                                                            <option selected>Aditya Birla Sun Life Arbitrage</option>
                                                            <option value="">Aditya Birla Sun Life Arbitrage</option>
                                                            <option value="">Aditya Birla Sun Life Arbitrage</option>
                                                            <option value="">Aditya Birla Sun Life Arbitrage</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="bg_222">
                                                    <div class="form_select">
                                                        <label for="">From Date</label>
                                                        <input class="form-date" type="date" v-model="selectedRatioDateFrom"/>
                                                    </div>
                                                </td>
                                                <td class="bg_222">
                                                    <div class="form_select">
                                                        <label for="">To Date</label>
                                                        <input class="form-date" type="date" v-model="selectedRatioDateTo" />
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="bg_green">
                                                <td>
                                                    <div class="form_select">
                                                        <label for="">Schemes</label>
                                                       <select class="form-select" aria-label="Default select example" v-model="selectedFund1Ratio" :disabled="compare_price_process">
                                                            <option v-for="fund in funds" :value="fund">{{fund.fund_name}}</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form_select">
                                                        <label for="">Schemes</label>
                                                               <select class="form-select" aria-label="Default select example" v-model="selectedFund2Ratio" :disabled="compare_price_process">
                                                            <option v-for="fund in funds" :value="fund">{{fund.fund_name}}</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form_select">
                                                        <label for="">Schemes</label>
                                                        <select class="form-select" aria-label="Default select example">
                                                            <option selected>Aditya Birla Sun Life Arbitrage</option>
                                                            <option value="">Aditya Birla Sun Life Arbitrage</option>
                                                            <option value="">Aditya Birla Sun Life Arbitrage</option>
                                                            <option value="">Aditya Birla Sun Life Arbitrage</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form_select">
                                                        <label for="">Schemes</label>
                                                        <select class="form-select" aria-label="Default select example">
                                                            <option selected>Aditya Birla Sun Life Arbitrage</option>
                                                            <option value="">Aditya Birla Sun Life Arbitrage</option>
                                                            <option value="">Aditya Birla Sun Life Arbitrage</option>
                                                            <option value="">Aditya Birla Sun Life Arbitrage</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form_select">
                                                        <label for="">Schemes</label>
                                                        <select class="form-select" aria-label="Default select example">
                                                            <option selected>Aditya Birla Sun Life Arbitrage</option>
                                                            <option value="">Aditya Birla Sun Life Arbitrage</option>
                                                            <option value="">Aditya Birla Sun Life Arbitrage</option>
                                                            <option value="">Aditya Birla Sun Life Arbitrage</option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="three_btn">
                                <div class="row align-items-center">
                                    <div class="col-lg-4">
                                        <div class="middle_left">
                                            <a href="javascript://" :disabled="disableCompareRatio" @click="ratioCompare">Compare</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="middle_a d-flex align-items-center justify-content-center">
                                            <a href="" class="active">Day to Day</a>
                                            <a href="">Weekly</a>
                                            <a href="">Monthly</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="middle_a d-flex align-items-center justify-content-md-end justify-content-center">
                                            <a href="javascript://" @click="selectedRatioDuration=1" :class="selectedRatioDuration==1 ? 'active' :''">1M</a>
                                            <a href="javascript://" @click="selectedRatioDuration=3" :class="selectedRatioDuration==3 ? 'active' :''">3M</a>
                                            <a href="javascript://" @click="selectedRatioDuration=6" :class="selectedRatioDuration==6 ? 'active' :''">6M</a>
                                            <a href="javascript://" @click="selectedRatioDuration=12" :class="selectedRatioDuration==12 ? 'active' :''">1Y</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                              <div class="text-center mt-3">
                                    <LoadingBar :status="loadingStatus"></LoadingBar>
                                </div>
                            <p v-if="notice_text_ratio" class="text-warning mt-3 text-center w-100 mb-0">{{notice_text_ratio}}</p>
                            <div class="mt-5 " style="width: 100%;" v-show="show_ratio_graph">
                            <div id="chartContainerRatio" style="height: 360px; width: 100%;"></div>
                            </div>
                        </div>
                <!-- ratio calulation end-->
            </div>
        </div>
    </div>

</section>

<div class="compare-scemes-sec investing-tools fund-perform-returns select2-styles d-none">
    <div class="container">
        <ul class="nav nav-tabs border-0 mt-5">
            <li><a class="" data-toggle="tab" href="#daily-price" :class="{'active show':currentTab == 'daily_price'}" @click="currentTab='daily_price'">Daily Price</a></li>
            <li><a data-toggle="tab" href="#fund-perform-ratios" :class="{'active show':currentTab == 'ratios'}" @click="currentTab='ratios'">Ratios</a></li>
            <li><a data-toggle="tab" href="#composition" :class="{'active show':currentTab == 'composition'}" @click="currentTab='composition'">Composition</a></li>
        </ul>
    </div>
    <div class="tab-wrapper">
        <div class="container">
            <div class="tab-content">
                <div id="daily-price" class="tab-pane fade in" :class="{'active show':currentTab == 'daily_price'}">
                    <div class="row investing-tools">
                        <div class="col-md-12 d-flex mb-4">
                            <template v-for="compare_type in compare_price_types" :key="compare_type.type">
                                <div class="d-flex mr-3">
                                    <input type="radio" name="compare_price_btn" class="compare_price_types_radio" :value="compare_type.type" v-model="selectedComparePriceType" :id="compare_type.type"> <label class="compare_price_types_lbl" :for="compare_type.type">{{ compare_type.title }}</label>
                                </div>
                            </template>
                        </div>
                        <div class="col-md-3 col-sm-12 invst-wrap select2-styles">

                            <div class="invst-fields mt-0" v-if="selectedComparePriceType == 'index_index' || selectedComparePriceType == 'index_currency'">
                                <label>Index</label>
                                <multiselect :disabled="compare_price_process" class="" label="name" track-by="name" v-model="selectedIndex1" tag-placeholder="" placeholder="Select Index" :options="indices" :multiple="false" :taggable="false" selectLabel="" :searchable="true" :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150" :showNoResults="true">
                                </multiselect>
                            </div>
                            <div class="invst-fields mt-0" v-if="selectedComparePriceType == 'currency_currency'">
                                <label>Currency</label>
                                <multiselect :disabled="compare_price_process" class="" label="name" track-by="name" v-model="selectedCurrency1" tag-placeholder="" placeholder="Select Currency" :options="currencies" :multiple="false" :taggable="false" selectLabel="" :searchable="true" :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150" :showNoResults="true">
                                </multiselect>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 invst-wrap select2-styles">
                            <div class="invst-fields mt-0" v-if="selectedComparePriceType == 'scheme_scheme'">
                                <label>Schemes</label>
                                <multiselect :disabled="compare_price_process" class="" label="fund_name" track-by="fund_id" v-model="selectedScheme2" tag-placeholder="" placeholder="Select Fund" :options="funds" :multiple="false" :taggable="false" selectLabel="" :searchable="true" :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150" :showNoResults="true">
                                </multiselect>
                            </div>
                            <div class="invst-fields mt-0" v-if="selectedComparePriceType == 'index_index' || selectedComparePriceType == 'scheme_index'">
                                <label>Index</label>
                                <multiselect :disabled="compare_price_process" class="" label="name" track-by="name" v-model="selectedIndex2" tag-placeholder="" placeholder="Select Index" :options="indices" :multiple="false" :taggable="false" selectLabel="" :searchable="true" :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150" :showNoResults="true">
                                </multiselect>
                            </div>
                            <div class="invst-fields mt-0" v-if="selectedComparePriceType == 'currency_currency' || selectedComparePriceType == 'index_currency' || selectedComparePriceType == 'scheme_currency'">
                                <label>Currency</label>
                                <multiselect :disabled="compare_price_process" class="" label="name" track-by="name" v-model="selectedCurrency2" tag-placeholder="" placeholder="Select Currency" :options="currencies" :multiple="false" :taggable="false" selectLabel="" :searchable="true" :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150" :showNoResults="true">
                                </multiselect>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 invst-wrap select2-styles">
                            <div class="invst-fields mt-0" v-if="!enablePriceCustomDates">
                                <label class="w-100">Duration</label>
                                <select class="" v-model="selectedDuration">
                                    <option value="">Select</option>
                                    <option value="1">1 Month</option>
                                    <option value="3">3 Months</option>
                                    <option value="6">6 Months</option>
                                    <option value="12">1 Year</option>
                                </select>
                            </div>
                            <div class="invst-fields mt-0" v-if="enablePriceCustomDates">
                                <label class="w-100">Date Range</label>
                                <Datepicker v-model="selectedDateRange" :format="'dd/MM/yyyy'" :enableTimePicker="false" :autoApply="true" :range="true" :maxDate="maxDateRang"></Datepicker>
                            </div>
                            <div class="invst-fields mt-2 d-flex align-items-center">
                                <label class="switch size-md">
                                    <input type="checkbox" v-model="enablePriceCustomDates">
                                    <span class="toggle-input round"></span>
                                </label>
                                <label class="ml-2">Custom Duration</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 invst-wrap select2-styles d-flex mb-12 align-items-center">
                            <div class="invst-fields mt-0">
                                <button class="btn primary-button compare-btn" :disabled="disableComparePrice || compare_price_process" @click="priceCompare">Compare</button>
                            </div>
                        </div>
                    </div>

                </div>

                <div id="fund-perform-ratios" class="tab-pane fade" :class="{'active show':currentTab == 'ratios'}">
                    <div class="row investing-tools">
                        <div class="col-lg-3 col-md-5 col-sm-12 invst-wrap select2-styles">
                            <div class="invst-fields mt-0">
                                <label>Scheme name</label>
                                <multiselect class="" label="fund_name" track-by="fund_id" v-model="selectedFund1Ratio" tag-placeholder="" placeholder="Select Fund" :options="funds" :multiple="false" :taggable="false" selectLabel="" :searchable="true" :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150" :showNoResults="true">
                                </multiselect>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-5 col-sm-12 invst-wrap select2-styles">
                            <div class="invst-fields mt-0">
                                <label>Scheme name</label>
                                <multiselect class="" label="fund_name" track-by="fund_id" v-model="selectedFund2Ratio" tag-placeholder="" placeholder="Select Fund" :options="funds" :multiple="false" :taggable="false" selectLabel="" :searchable="true" :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150" :showNoResults="true">
                                </multiselect>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 invst-wrap select2-styles">
                            <div class="invst-fields mt-0">
                                <label class="w-100">Return Ratio</label>
                                <select class="" v-model="selectedRatioReturn" :disabled="selectedRatioRisk !== ''">
                                    <option value="">Select</option>
                                    <option value="cagr">Returns</option>
                                    <option value="jensen_alpha">Jensen</option>
                                    <option value="information_ratio">Information Ratio</option>
                                    <option value="rolling_return">Rolling Return</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 invst-wrap select2-styles">
                            <div class="invst-fields mt-0">
                                <label class="w-100">Risk Ratio</label>
                                <select class="" v-model="selectedRatioRisk" :disabled="selectedRatioReturn !== ''">
                                    <option value="">Select</option>
                                    <option value="beta">Beta</option>
                                    <option value="tracking_error">Tracking Error</option>
                                    <option value="volatality">Volatility</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 invst-wrap select2-styles">
                            <div class="invst-fields mt-0" v-if="!enableRatioCustomDates">
                                <label class="w-100">Duration</label>
                                <select class="" v-model="selectedRatioDuration">
                                    <option value="">Select</option>
                                    <option value="1">1 Month</option>
                                    <option value="3">3 Months</option>
                                    <option value="6">6 Months</option>
                                    <option value="12">1 Year</option>
                                </select>
                            </div>
                            <div class="invst-fields mt-0" v-if="enableRatioCustomDates">
                                <label class="w-100">Date Range</label>
                                <Datepicker v-model="selectedRatioDateRange" :format="'dd/MM/yyyy'" :enableTimePicker="false" :autoApply="true" :range="true" :maxDate="maxDateRang"></Datepicker>
                            </div>
                            <div class="invst-fields mt-2 d-flex align-items-center">
                                <label class="switch size-md">
                                    <input type="checkbox" v-model="enableRatioCustomDates">
                                    <span class="toggle-input round"></span>
                                </label>
                                <label class="ml-2">Custom Duration</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 invst-wrap select2-styles d-flex mb-12 align-items-center">
                            <div class="invst-fields mt-0">
                                <button class="btn primary-button compare-btn" :disabled="disableCompareRatio" @click="ratioCompare">Compare</button>
                            </div>
                        </div>
                    </div>
                    <p v-if="notice_text_ratio" class="text-warning mt-3 text-center w-100 mb-0">{{notice_text_ratio}}</p>
                    <div class="mt-5 " style="width: 100%;" v-show="show_ratio_graph">
                        <div id="chartContainerRatio" style="height: 360px; width: 100%;"></div>
                        <div style="height:30px; width:70px; background:#00504a; position:absolute; z-index:999; margin-top:-34px;" id="myplexusC"></div>
                    </div>
                    <div class="text-center" v-if="compare_ratio_process">
                        <svg style="width:50px" version="1.1" id="L1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                            <circle fill="none" stroke="#fff" stroke-width="6" stroke-miterlimit="15" stroke-dasharray="14.2472,14.2472" cx="50" cy="50" r="47">
                                <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="5s" from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                            </circle>
                            <circle fill="none" stroke="#fff" stroke-width="1" stroke-miterlimit="10" stroke-dasharray="10,10" cx="50" cy="50" r="39">
                                <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="5s" from="0 50 50" to="-360 50 50" repeatCount="indefinite" />
                            </circle>
                            <g fill="#fff">
                                <rect x="30" y="35" width="5" height="30">
                                    <animateTransform attributeName="transform" dur="1s" type="translate" values="0 5 ; 0 -5; 0 5" repeatCount="indefinite" begin="0.1" />
                                </rect>
                                <rect x="40" y="35" width="5" height="30">
                                    <animateTransform attributeName="transform" dur="1s" type="translate" values="0 5 ; 0 -5; 0 5" repeatCount="indefinite" begin="0.2" />
                                </rect>
                                <rect x="50" y="35" width="5" height="30">
                                    <animateTransform attributeName="transform" dur="1s" type="translate" values="0 5 ; 0 -5; 0 5" repeatCount="indefinite" begin="0.3" />
                                </rect>
                                <rect x="60" y="35" width="5" height="30">
                                    <animateTransform attributeName="transform" dur="1s" type="translate" values="0 5 ; 0 -5; 0 5" repeatCount="indefinite" begin="0.4" />
                                </rect>
                                <rect x="70" y="35" width="5" height="30">
                                    <animateTransform attributeName="transform" dur="1s" type="translate" values="0 5 ; 0 -5; 0 5" repeatCount="indefinite" begin="0.5" />
                                </rect>
                            </g>
                        </svg>
                    </div>
                </div>

                <div id="composition" class="tab-pane fade" :class="{'active show':currentTab == 'composition'}">
                    <div class="row investing-tools">
                        <div class="col-lg-3 col-md-5 col-sm-12 invst-wrap select2-styles">
                            <div class="invst-fields mt-0">
                                <label>Scheme name</label>
                                <multiselect class="" label="fund_name" track-by="fund_id" v-model="selectedFund1Composition" tag-placeholder="" placeholder="Select Fund" :options="funds" :multiple="false" :taggable="false" selectLabel="" :searchable="true" :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150" :showNoResults="true">
                                </multiselect>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-5 col-sm-12 invst-wrap select2-styles">
                            <div class="invst-fields mt-0">
                                <label>Scheme name</label>
                                <multiselect class="" label="fund_name" track-by="fund_id" v-model="selectedFund2Composition" tag-placeholder="" placeholder="Select Fund" :options="funds" :multiple="false" :taggable="false" selectLabel="" :searchable="true" :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150" :showNoResults="true">
                                </multiselect>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12 invst-wrap select2-styles">
                            <div class="invst-fields mt-0">
                                <label class="w-100">Category</label>
                                <select class="" v-model="selectedCompositionCategory">
                                    <option value="">Select</option>
                                    <option value="top_script">Top Scrip</option>
                                    <option value="top_industry">Top Industry</option>
                                    <option value="aaum">AAUM</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12 invst-wrap select2-styles">
                            <div class="invst-fields mt-0">
                                <label class="w-100">Month/Year</label>
                                <Datepicker v-model="selectedCompositionDate" :format="'MM/yyyy'" monthPicker :enableTimePicker="false" :autoApply="true" :range="false" :maxDate="maxDateRangComposition"></Datepicker>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12 invst-wrap select2-styles d-flex mb-12 align-items-end">
                            <div class="invst-fields mt-0">
                                <button class="btn primary-button compare-btn mb-0" :disabled="disableCompareComposition" @click="compositionCompare">Compare</button>
                            </div>
                        </div>
                    </div>
                    <p v-if="notice_text_comp" class="text-warning mt-3 text-center w-100 mb-0">{{notice_text_comp}}</p>
                    <div class="mt-5 " v-show="show_comp">
                        <div class="dy-table-wrap row">
                            <div class="dy-table-block br-5 col-md-6" v-if="Object.keys(compare_comp_script).length && compare_comp_script.scheme1.data.length">
                                <p class="text-white mb-2 "> {{ comp_scheme1_text }} </p>
                                <table class="box-shadow">
                                    <tr>
                                        <th class="bg-gray text-white" style="width: 80% !important;">Scrips</th>
                                        <th class="bg-gray  text-white" style="min-width: 130px;">Content%</th>
                                    </tr>
                                    <tbody>
                                        <tr v-for="script in compare_comp_script.scheme1.data" :key="script.scrip_name">
                                            <td class="modal-td">{{ script.scrip_name }}</td>
                                            <td>{{ script.content_per.toFixed(2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Of Top 10</td>
                                            <td class="modal-td-dark">{{ compare_comp_script.scheme1.top_scripts_sum.toFixed(2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="dy-table-block br-5 col-md-6" v-if="Object.keys(compare_comp_script).length && compare_comp_script.scheme2.data.length">
                                <p class="text-white mb-2 "> {{ comp_scheme2_text }} </p>
                                <table class="box-shadow">
                                    <tr>
                                        <th class="bg-gray text-white" style="width: 80% !important;">Scrips</th>
                                        <th class="bg-gray text-white" style="min-width: 130px;">Content%</th>
                                    </tr>
                                    <tbody>
                                        <tr v-for="script in compare_comp_script.scheme2.data" :key="script.scrip_name">
                                            <td class="modal-td">{{ script.scrip_name }}</td>
                                            <td>{{ script.content_per.toFixed(2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Of Top 10</td>
                                            <td class="modal-td-dark">{{ compare_comp_script.scheme2.top_scripts_sum.toFixed(2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="dy-table-block br-5 col-md-6" v-if="Object.keys(compare_comp_industry).length && compare_comp_industry.scheme1.data.length">
                                <p class="text-white mb-2 "> {{ comp_scheme1_text }} </p>
                                <table class="box-shadow">
                                    <tr>
                                        <th class="bg-gray text-white" style="width: 80% !important;">Industries</th>
                                        <th class="bg-gray  text-white" style="min-width: 130px;">Content%</th>
                                    </tr>
                                    <tbody>
                                        <tr v-for="industry in compare_comp_industry.scheme1.data" :key="industry.industry">
                                            <td class="modal-td">{{ industry.industry }}</td>
                                            <td>{{ industry.industry_content_per.toFixed(2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Of Top 10</td>
                                            <td class="modal-td-dark">{{ compare_comp_industry.scheme1.top_industry_sum.toFixed(2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="dy-table-block br-5 col-md-6" v-if="Object.keys(compare_comp_industry).length && compare_comp_industry.scheme2.data.length">
                                <p class="text-white mb-2 "> {{ comp_scheme2_text }} </p>
                                <table class="box-shadow">
                                    <tr>
                                        <th class="bg-gray text-white" style="width: 80% !important;">Industry</th>
                                        <th class="bg-gray text-white" style="min-width: 130px;">Content%</th>
                                    </tr>
                                    <tbody>
                                        <tr v-for="industry in compare_comp_industry.scheme2.data" :key="industry.industry">
                                            <td class="modal-td">{{ industry.industry }}</td>
                                            <td>{{ industry.industry_content_per.toFixed(2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Of Top 10</td>
                                            <td class="modal-td-dark">{{ compare_comp_industry.scheme2.top_industry_sum.toFixed(2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="dy-table-block br-5 col-md-6" v-if="Object.keys(compare_comp_aaum).length">
                                <table class="box-shadow">
                                    <tr>
                                        <th class="bg-gray text-white" style="width: 80% !important;">Name Of Fund</th>
                                        <th class="bg-gray text-white" style="min-width: 130px;">AAUM</th>
                                    </tr>
                                    <tbody>
                                        <tr v-if="Object.keys(compare_comp_aaum.scheme1.data).length">
                                            <td class="modal-td">{{ comp_scheme1_text }}</td>
                                            <td class="bg-gray text-white">{{ compare_comp_aaum.scheme1.data.corpus_entry.toFixed(2) }}</td>
                                        </tr>
                                        <tr v-if="Object.keys(compare_comp_aaum.scheme2.data).length">
                                            <td class="modal-td">{{ comp_scheme2_text }}</td>
                                            <td class="bg-gray text-white">{{ compare_comp_aaum.scheme2.data.corpus_entry.toFixed(2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="text-center" v-if="compare_comp_process">
                        <svg style="width:50px" version="1.1" id="L1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                            <circle fill="none" stroke="#fff" stroke-width="6" stroke-miterlimit="15" stroke-dasharray="14.2472,14.2472" cx="50" cy="50" r="47">
                                <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="5s" from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                            </circle>
                            <circle fill="none" stroke="#fff" stroke-width="1" stroke-miterlimit="10" stroke-dasharray="10,10" cx="50" cy="50" r="39">
                                <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="5s" from="0 50 50" to="-360 50 50" repeatCount="indefinite" />
                            </circle>
                            <g fill="#fff">
                                <rect x="30" y="35" width="5" height="30">
                                    <animateTransform attributeName="transform" dur="1s" type="translate" values="0 5 ; 0 -5; 0 5" repeatCount="indefinite" begin="0.1" />
                                </rect>
                                <rect x="40" y="35" width="5" height="30">
                                    <animateTransform attributeName="transform" dur="1s" type="translate" values="0 5 ; 0 -5; 0 5" repeatCount="indefinite" begin="0.2" />
                                </rect>
                                <rect x="50" y="35" width="5" height="30">
                                    <animateTransform attributeName="transform" dur="1s" type="translate" values="0 5 ; 0 -5; 0 5" repeatCount="indefinite" begin="0.3" />
                                </rect>
                                <rect x="60" y="35" width="5" height="30">
                                    <animateTransform attributeName="transform" dur="1s" type="translate" values="0 5 ; 0 -5; 0 5" repeatCount="indefinite" begin="0.4" />
                                </rect>
                                <rect x="70" y="35" width="5" height="30">
                                    <animateTransform attributeName="transform" dur="1s" type="translate" values="0 5 ; 0 -5; 0 5" repeatCount="indefinite" begin="0.5" />
                                </rect>
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>

<script>
import CustomTable from './Common/CustomTable.vue'
import Multiselect from '@suadelabs/vue3-multiselect'
import LoadingBar from "./Common/loading";
import mixin from '../mixin';
import {
    mapGetters,
    mapActions
} from 'vuex'
import moment from 'moment';
var CanvasJS = require('../canvasjs.min.js');
export default {
    props: ['image_path'],
    components: {
        Multiselect,
         LoadingBar
    },
    mixins: [mixin],
    data() {
        return {
            compare_price_process: false,
            compare_price_types: [{
                    type: 'scheme_scheme',
                    title: 'Scheme to scheme'
                },
                {
                    type: 'scheme_index',
                    title: 'Scheme to index'
                },
                {
                    type: 'scheme_currency',
                    title: 'Scheme to currency'
                },
                {
                    type: 'index_index',
                    title: 'Index to index'
                },
                {
                    type: 'index_currency',
                    title: 'Index to currency'
                },
                {
                    type: 'currency_currency',
                    title: 'Currency to currency'
                },
            ],
            selectedComparePriceType: 'scheme_scheme',
            enablePriceCustomDates: true,
            selectedDateRange: null,
            selectedDateRangeFrom: null,
            selectedDateRangeTo: null,
            selectedToDate: null,
            selectedDuration: "12",
            selectedScheme1: [],
            selectedScheme2: [],
            selectedIndex1: [],
            selectedIndex2: [],
            selectedCurrency1: [],
            selectedCurrency2: [],
            compare_price_data: [],
            show_graph: false,
            notice_text: '',
            nodata_text: '',
            selectedFund1Ratio: [],
            selectedFund2Ratio: [],
            selectedRatioReturn: 'cagr',
            selectedRatioRisk: '',
            selectedRatioDuration: '12',
            enableRatioCustomDates: false,
            selectedRatioDateRange: null,
            selectedRatioDateFrom: null,// added by sandeep
            selectedRatioDateTo: null, // added by sandeep as per new UI
            selectedFund1Composition: [],
            selectedFund2Composition: [],
            selectedCompositionCategory: '',
            selectedCompositionDate: null,
            show_ratio_graph: false,
            compare_ratio_data: [],
            notice_text_ratio: '',
            chart_ratio: null,
            chart: null,
            compare_ratio_process: false,
            compare_comp_process: false,
            show_comp: false,
            compare_comp_script: [],
            compare_comp_industry: [],
            compare_comp_aaum: [],
            comp_scheme1_text: '',
            comp_scheme2_text: '',
            currentTab: 'daily_price',
            app_url:process.env.MIX_APP_ENV=='local' ?  process.env.MIX_API_URL_LOCAL :'',
            loadingStatus:false,
            notice_text_comp:''
        }
    },
    methods: {
        ...mapActions('InputData', ['getFunds', 'getIndices', 'getCurrencies']),
        toggleDataSeries(e) {
            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            } else {
                e.dataSeries.visible = true;
            }
            this.chart.render();
        },
        priceCompare() {
            let that = this
            this.loadingStatus=true
            this.nodata_text='';
            that.show_graph = false
            this.selectedComparePriceType = 'scheme_scheme';
            let data = {
                'compare_type': this.selectedComparePriceType
            }
            let title1 = ''
            let title2 = ''
            if ((this.selectedComparePriceType == 'scheme_scheme' || this.selectedComparePriceType == 'scheme_index' || this.selectedComparePriceType == 'scheme_currency')) {
                data.value1 = encodeURIComponent(this.selectedScheme1.fund_code)
                title1 = this.selectedScheme1.fund_name
            }
            if ((this.selectedComparePriceType == 'scheme_scheme')) {
                data.value2 = encodeURIComponent(this.selectedScheme2.fund_code)
                title2 = this.selectedScheme2.fund_name
            }
            if ((this.selectedComparePriceType == 'index_index' || this.selectedComparePriceType == 'index_currency')) {
                data.value1 = encodeURIComponent(this.selectedIndex1.name)
                title1 = this.selectedIndex1.name
            }
            if ((this.selectedComparePriceType == 'index_index' || this.selectedComparePriceType == 'scheme_index')) {
                data.value2 = encodeURIComponent(this.selectedIndex2.name)
                title2 = this.selectedIndex2.name
            }
            if ((this.selectedComparePriceType == 'currency_currency')) {
                data.value1 = encodeURIComponent(this.selectedCurrency1.cm_id)
                title1 = this.selectedCurrency1.name
            }
            if ((this.selectedComparePriceType == 'currency_currency' || this.selectedComparePriceType == 'index_currency' || this.selectedComparePriceType == 'scheme_currency')) {
                data.value2 = encodeURIComponent(this.selectedCurrency2.cm_id)
                title2 = this.selectedCurrency2.name
            }

            if (this.selectedDateRangeFrom == null && this.selectedDateRangeTo == null) {
                data.from_date = moment().subtract(1, 'days').subtract(this.selectedDuration, 'months').format('YYYY-MM-DD')
                data.to_date = moment().subtract(1, 'days').format('YYYY-MM-DD')
            } else if (this.enablePriceCustomDates) {
                data.from_date = this.selectedDateRangeFrom; //moment(this.selectedDateRange[0]).format('YYYY-MM-DD')
                data.to_date = this.selectedDateRangeTo; // moment(this.selectedDateRange[1]).format('YYYY-MM-DD')
            }
            that.compare_price_process = true
            that.notice_text = ''
            axios.get(that.app_url + '/api/v1/compare-price', {
                    params: data
                })
                .then(response => {
                    this.loadingStatus=false
                    let graph_data = that.compare_price_data = response.data.data.graph_data
                    if(graph_data[0].length <=0){
                        that.show_graph = false
                         this.nodata_text='No records found';
                         return
                    }
                    that.compare_price_data = response.data.data.graph_data
                    let notice_text = response.data.data.notice_text
                    if (notice_text) {
                        that.notice_text = (response.data.data.notice_value_type == 1) ? title1 + ' ' + notice_text : title2 + ' ' + notice_text
                    }
                    that.chart.options.data[0].dataPoints = []

                    that.chart.options.data[0].name = title1;
                    that.chart.options.axisY[0].title = title1;

                    graph_data[0].forEach(function (item, index) {

                        that.chart.options.data[0].dataPoints.push({
                            y: item.VALUE,
                            label: item.DATE
                        });
                    });
                    that.chart.render();
                    // chart 2 
                    that.chart2.options.data[0].dataPoints = []

                    that.chart2.options.data[0].name = title2;
                    that.chart2.options.axisY[0].title = title2;

                    graph_data[1].forEach(function (item, index) {

                        that.chart2.options.data[0].dataPoints.push({
                            y: item.VALUE,
                            label: item.DATE
                        });
                    });
                    that.chart2.render();
                    that.show_graph = true
                })
                .catch(error => {
                    //var message = error.response.data.message || error.message
                    console.log(error);
                })
                .finally(() => {
                    that.compare_price_process = false
                })

        },
        ratioCompare() {
            let that = this
             that.show_ratio_graph = true
            this.loadingStatus=true
            let data = {}
            let title1 = ''
            let title2 = ''
            data.compare_type = (this.selectedRatioRisk) ? this.selectedRatioRisk : this.selectedRatioReturn
            data.value1 = encodeURIComponent(this.selectedFund1Ratio.fund_code)
            title1 = this.selectedFund1Ratio.fund_name
            data.value2 = encodeURIComponent(this.selectedFund2Ratio.fund_code)
            title2 = this.selectedFund2Ratio.fund_name
            console.log(this.selectedRatioDateFrom,this.selectedRatioDuration);
            if (!this.selectedRatioDateFrom) {
                data.from_date = moment().subtract(1, 'days').subtract(this.selectedRatioDuration, 'months').format('YYYY-MM-DD')
                data.to_date = moment().subtract(1, 'days').format('YYYY-MM-DD');
            } else if (this.selectedRatioDateFrom) {
                data.from_date = this.selectedRatioDateFrom; //moment(this.selectedRatioDateRange[0]).format('YYYY-MM-DD')
                data.to_date =this.selectedRatioDateTo ;// moment(this.selectedRatioDateRange[1]).format('YYYY-MM-DD')
            }
            that.compare_ratio_process = true
            that.notice_text_ratio = ''
            that.chart_ratio.options.data[0].dataPoints = []
            that.chart_ratio.render();
            axios.get(that.app_url + '/api/v1/compare-ratios', {
                    params: data
                })
                .then(response => {
                    let graph_data = that.compare_ratio_data = response.data.data.graph_data
                    that.compare_ratio_data = response.data.data.graph_data
                        // graph_data.push({beta: 0.932713,cagr:11.7043,end_date:"2022-09-11",fund_code:"Tec 001",information_ratio:2.48504,jensen_alpha:1.41132,per_return:11.7043,r_sqr:null,sharp_ratio:-6.28164,start_date:"2021-09-11",tracking_error:0.370725,treynor_ratio:-7.27713,variance:1.24414,volatality:4.47355})
                        // graph_data.push({beta: 0.932713,cagr:11.7043,end_date:"2022-09-11",fund_code:"Tec 001",information_ratio:2.48504,jensen_alpha:1.41132,per_return:11.7043,r_sqr:null,sharp_ratio:-6.28164,start_date:"2021-09-11",tracking_error:0.370725,treynor_ratio:-7.27713,variance:1.24414,volatality:4.47355})
                        // graph_data.push({beta: 0.932713,cagr:11.7043,end_date:"2022-09-11",fund_code:"Tec 001",information_ratio:2.48504,jensen_alpha:1.41132,per_return:11.7043,r_sqr:null,sharp_ratio:-6.28164,start_date:"2021-09-11",tracking_error:0.370725,treynor_ratio:-7.27713,variance:1.24414,volatality:4.47355})
                    let notice_text = response.data.data.notice_text
                    if (notice_text) {
                        that.notice_text_ratio = (response.data.data.notice_value_type == 1) ? title1 + ' ' + notice_text : title2 + ' ' + notice_text
                    }
                    if(graph_data.length){
                        graph_data.map(function(value,key){
                        if(typeof value.length !=undefined){
                            let yVal = value[data.compare_type].toFixed(2)
                            that.chart_ratio.options.data[0].dataPoints.push({
                                y: parseFloat(yVal),
                                label: title1
                            });
                        }
                    })
                    }else{
                        
                    }
                    
                    // if (Object.keys(graph_data[0]).length) {
                    //     let yVal = graph_data[0][data.compare_type].toFixed(2)
                    //     that.chart_ratio.options.data[0].dataPoints.push({
                    //         y: parseFloat(yVal),
                    //         label: title1
                    //     });
                    // }
                    // if (Object.keys(graph_data[1]).length) {
                    //     let yVal = graph_data[1][data.compare_type].toFixed(2)
                    //     that.chart_ratio.options.data[0].dataPoints.push({
                    //         y: parseFloat(yVal),
                    //         label: title2
                    //     });
                    // }
                    // if (Object.keys(graph_data[2]).length) {
                    //     let yVal = graph_data[2][data.compare_type].toFixed(2)
                    //     that.chart_ratio.options.data[0].dataPoints.push({
                    //         y: parseFloat(yVal),
                    //         label: title2
                    //     });
                    // }
                    if (Object.keys(graph_data[0]).length || Object.keys(graph_data[1]).length) {
                        that.chart_ratio.render();
                    } else {
                        that.show_ratio_graph = false
                        that.notice_text_ratio = 'No data Found'
                        return;
                    }
                    this.loadingStatus=false
                    that.show_ratio_graph = true

                })
                .catch(error => {
                    //var message = error.response.data.message || error.message
                     this.loadingStatus=false
                     that.show_ratio_graph = false
                     that.notice_text_ratio = 'No data Found'
                })
                .finally(() => {
                    that.compare_ratio_process = false
                })

        },
        compositionCompare() {
            let that = this
            that.show_comp = true
            let data = {}
            let title1 = ''
            let title2 = ''
            data.compare_type = this.selectedCompositionCategory
            data.value1 = encodeURIComponent(this.selectedFund1Composition.fund_code)
            that.comp_scheme1_text = this.selectedFund1Composition.fund_name
            data.value2 = encodeURIComponent(this.selectedFund2Composition.fund_code)
            that.comp_scheme2_text = this.selectedFund2Composition.fund_name
            data.month = 1 + this.selectedCompositionDate.month
            data.year = this.selectedCompositionDate.year

            that.compare_comp_process = true
            that.notice_text_comp = ''
            that.chart_ratio.render();
            that.compare_comp_script = []
            that.compare_comp_industry = []
            that.compare_comp_aaum = []
            axios.get(that.app_url + '/api/v1/compare-compositions', {
                    params: data
                })
                .then(response => {
                    let graph_data = that.compare_ratio_data = response.data.data.composition_data

                    let notice_text = response.data.data.notice_text
                    if (notice_text) {
                        that.notice_text_comp = (response.data.data.notice_value_type == 1) ? title1 + ' ' + notice_text : title2 + ' ' + notice_text
                    }

                    if ((graph_data.scheme1.data && Object.keys(graph_data.scheme1.data).length) || (graph_data.scheme2.data && Object.keys(graph_data.scheme2.data).length)) {

                        if (data.compare_type == 'top_script') {
                            that.compare_comp_script = graph_data
                        }
                        if (data.compare_type == 'top_industry') {
                            that.compare_comp_industry = graph_data
                        }
                        if (data.compare_type == 'aaum') {
                            that.compare_comp_aaum = graph_data
                        }

                    } else {
                        that.show_comp = false
                        that.notice_text_comp = 'No data Found'
                    }

                })
                .catch(error => {
                    var message = error.response.data.message || error.message
                    that.show_comp = false
                    that.notice_text_comp = 'No data Found'
                    that.notice_text_comp = message
                })
                .finally(() => {
                    that.compare_comp_process = false
                })

        },

    },
    watch: {
        selectedDuration(value){
            if(value){
                this.priceCompare();
            }
        },
        selectedRatioDuration(value){
            if(value){
                this.ratioCompare();
            }
        }
    },
    computed: {
        ...mapGetters('InputData', ['loading', 'funds', 'indices', 'currencies']),
        maxDateRang() {
            let d = new Date();
            return d.setDate(d.getDate() - 1);
        },
        maxDateRangComposition() {
            let d = new Date();
            return new Date(d.getFullYear(), d.getMonth(), 0);
        },
        disableComparePrice() {
            if ((this.selectedComparePriceType == 'scheme_scheme' || this.selectedComparePriceType == 'scheme_index' || this.selectedComparePriceType == 'scheme_currency') && this.selectedScheme1 == '') {
                return true
            } else if ((this.selectedComparePriceType == 'scheme_scheme') && this.selectedScheme2 == '') {
                return true
            } else if ((this.selectedComparePriceType == 'index_index' || this.selectedComparePriceType == 'index_currency') && this.selectedIndex1 == '') {
                return true
            } else if ((this.selectedComparePriceType == 'index_index' || this.selectedComparePriceType == 'scheme_index') && this.selectedIndex2 == '') {
                return true
            } else if ((this.selectedComparePriceType == 'currency_currency') && this.selectedCurrency1 == '') {
                return true
            } else if ((this.selectedComparePriceType == 'currency_currency' || this.selectedComparePriceType == 'index_currency' || this.selectedComparePriceType == 'scheme_currency') && this.selectedCurrency2 == '') {
                return true
            } else if (!this.enablePriceCustomDates && !this.selectedDuration) {
                return true
            } else if (this.enablePriceCustomDates && !this.selectedDateRange) {
                return true
            }
        },
        disableCompareRatio() {
            if (this.selectedFund1Ratio == '' || this.selectedFund2Ratio == '') {
                return true
            } else if (!this.selectedRatioReturn && !this.selectedRatioRisk) {
                return true
            } else if (!this.enableRatioCustomDates && !this.selectedRatioDuration) {
                return true
            } else if (this.enableRatioCustomDates && !this.selectedRatioDateFrom) {
                return true
            }

        },
        disableCompareComposition() {
            if (this.selectedFund1Composition == '' || this.selectedFund2Composition == '') {
                return true
            } else if (!this.selectedCompositionCategory) {
                return true
            } else if (!this.selectedCompositionDate) {
                return true
            }
        }
    },
    mounted() {
        let that = this
        let compare_price_type = that.getURLParams("compare_price_type")
        let compare_ratio_type = that.getURLParams("compare_ratio_type")
        let compare_composition_type = that.getURLParams("compare_composition_type")
        let val1 = that.getURLParams("val1")
        let val2 = that.getURLParams("val2")

        let d = new Date();
        that.selectedCompositionDate = {
            month: new Date(d.getFullYear(), d.getMonth(), 0).getMonth(),
            year: new Date(d.getFullYear(), d.getMonth(), 0).getFullYear()
        }

        const myPromise = new Promise(async (resolve, reject) => {
            await that.getFunds({})
            await that.getIndices({})
            await that.getCurrencies({})
            resolve(true)
        });

        myPromise.then(async (resolve, reject) => {
            if (compare_price_type && val1 && val2) {
                that.selectedComparePriceType = compare_price_type
                if ((this.selectedComparePriceType == 'scheme_scheme' || this.selectedComparePriceType == 'scheme_index' || this.selectedComparePriceType == 'scheme_currency')) {
                    this.selectedScheme1 = that.funds.filter(function (el) {
                        return el.fund_code == decodeURIComponent(val1)
                    })[0]
                }
                if ((this.selectedComparePriceType == 'scheme_scheme')) {
                    this.selectedScheme2 = that.funds.filter(function (el) {
                        return el.fund_code == decodeURIComponent(val2)
                    })[0]
                }
                if ((this.selectedComparePriceType == 'index_index' || this.selectedComparePriceType == 'index_currency')) {
                    this.selectedIndex1 = that.indices.filter(function (el) {
                        return el.name == decodeURIComponent(val1)
                    })[0]
                }
                if ((this.selectedComparePriceType == 'index_index' || this.selectedComparePriceType == 'scheme_index')) {
                    this.selectedIndex2 = that.indices.filter(function (el) {
                        return el.name == decodeURIComponent(val2)
                    })[0]
                }
                if ((this.selectedComparePriceType == 'currency_currency')) {
                    this.selectedCurrency1 = that.currencies.filter(function (el) {
                        return el.cm_id == decodeURIComponent(val1)
                    })[0]
                }
                if ((this.selectedComparePriceType == 'currency_currency' || this.selectedComparePriceType == 'index_currency' || this.selectedComparePriceType == 'scheme_currency')) {
                    this.selectedCurrency2 = that.currencies.filter(function (el) {
                        return el.cm_id == decodeURIComponent(val2)
                    })[0]
                }
                that.priceCompare()
            }
            return true
        }).then(async (resolve, reject) => {
            if (compare_ratio_type && val1 && val2) {
                this.currentTab = 'ratios'
                if (compare_ratio_type == 'cagr' || compare_ratio_type == 'jensen_alpha' || compare_ratio_type == 'information_ratio' || compare_ratio_type == 'rolling_return') {
                    this.selectedRatioReturn = compare_ratio_type
                }
                if (compare_ratio_type == 'beta' || compare_ratio_type == 'tracking_error' || compare_ratio_type == 'volatality') {
                    this.selectedRatioRisk = compare_ratio_type
                }
                this.selectedFund1Ratio = that.funds.filter(function (el) {
                    return el.fund_code == decodeURIComponent(val1)
                })[0]
                this.selectedFund2Ratio = that.funds.filter(function (el) {
                    return el.fund_code == decodeURIComponent(val2)
                })[0]

                that.ratioCompare()
            }
        }).then(async (resolve, reject) => {
            if (compare_composition_type && val1 && val2) {
                this.currentTab = 'composition'
                if (compare_composition_type == 'top_script' || compare_composition_type == 'top_industry' || compare_composition_type == 'aaum') {
                    this.selectedCompositionCategory = compare_composition_type
                }
                this.selectedFund1Composition = that.funds.filter(function (el) {
                    return el.fund_code == decodeURIComponent(val1)
                })[0]
                this.selectedFund2Composition = that.funds.filter(function (el) {
                    return el.fund_code == decodeURIComponent(val2)
                })[0]

                that.compositionCompare()
            }
        });

        let chart = {
            colorSet: "greenShades",
            // backgroundColor: "#000000",
            theme: "light2",
            animationEnabled: true,
            zoomEnabled: true,
            axisY: [{
                tickThickness: 0,
                lineThickness: 1,
                title: "",
                includeZero: false,
                lineColor: "#6ab130",
                tickColor: "#6ab130",
                labelFontColor: "#6ab130",
                titleFontColor: "#6ab130",
            }],
            axisY2: {
                tickThickness: 0,
                lineThickness: 1,
                title: "",
                includeZero: false,
                lineColor: "#205738",
                tickColor: "#205738",
                labelFontColor: "#205738",
                titleFontColor: "#205738",
            },
            toolTip: {
                shared: true
            },
            legend: {
                cursor: "pointer",
                itemclick: this.toggleDataSeries
            },
            title: {},
            data: [{
                    type: "line",
                    name: "Order",
                    yValueFormatString: "##.00",
                    color: "#205738",
                    axisYIndex: 0,
                    showInLegend: true,
                    dataPoints: []
                },
                {
                    type: "line",
                    name: "Revenue",
                    yValueFormatString: "##.00",
                    color: "#fff",
                    axisYType: "secondary",
                    showInLegend: true,
                    dataPoints: []
                }
            ],
        }
        CanvasJS.addColorSet("greenShades", ["#4661EE", "#EC5657", "#1BCDD1", "#8FAABB", "#B08BEB", "#3EA0DD", "#F5A52A", "#23BFAA", "#FAA586", "#EB8CC6"]);
        this.chart = new CanvasJS.Chart("chartContainer", chart);
        this.chart2 = new CanvasJS.Chart("dataPriceChatTwo", chart);
        this.chart.render();
        this.chart2.render();

        let chart_ratio = {
            colorSet: "greenShades",
            backgroundColor: "#fff",
            theme: "light2",
            animationEnabled: true,
            zoomEnabled: false,
            axisY: {
                title: "Ratio Value",
                tickThickness: 0,
                lineThickness: 1,
                includeZero: true,
            },
            toolTip: {
                shared: true
            },
            legend: {
                cursor: "pointer",
                itemclick: this.toggleDataSeries
            },
            title: {},
            dataPointWidth: 100,
            data: [{
                type: "column",
                name: "",
                //yValueFormatString: "##.00",
                legendMarkerColor: "#6ab130",
                showInLegend: true,
                dataPoints: []
            }],
        }
        this.chart_ratio = new CanvasJS.Chart("chartContainerRatio", chart_ratio);
        this.chart_ratio.render();
    },
}
</script>
<style>
.dp__theme_light {
    --dp-primary-color: #6ab130 !important;
    --dp-primary-disabled-color: #458e38 !important;
}
.multiselect__content-wrapper {
    width: auto;
}
.dp__input_icon_pad {
    padding-left: 35px !important;
}
.compare-btn{
    padding-top:12px;
    padding-bottom:12px;
    margin-bottom: 12px;
}
</style>
