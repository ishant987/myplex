<template>
    <section class="compare_scheme">
        <div class="container">
            <div class="comp_schem_bdr">
                <h4>Compare Scheme</h4>
                <div class="tab_comp">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" :class="{ 'active': currentTab == 'daily_price' }" id="pills-home-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab"
                                aria-controls="pills-home" aria-selected="true">
                                <img :src="this.image_path + '/tab_icon.png'" alt="" />
                                Daily Price
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" :class="{ 'active show': currentTab == 'ratios' }"
                                @click="currentTab = 'ratios'" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                                aria-selected="false">
                                <img :src="this.image_path + '/tab_icon1.png'" alt="" />
                                Ratio
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" :class="{ 'active show': currentTab == 'composition' }"
                                @click="currentTab = 'composition'" id="pills-contact-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                                aria-selected="false">
                                <img :src="this.image_path + '/tab_icon2.png'" alt="" />
                                Composition
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade" :class="{ 'active show': currentTab == 'daily_price' }" id="pills-home"
                        role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="three_btn">
                            <div class="row align-items-center justify-content-end">
                                <div class="col-lg-4 mb-2">
                                    <div
                                        class="middle_a d-flex align-items-center justify-content-md-end justify-content-center">
                                        <a href="javascript://" @click="selectedDuration = 1"
                                            :class="selectedDuration == 1 ? 'active' : ''">1M</a>
                                        <a href="javascript://" @click="selectedDuration = 3"
                                            :class="selectedDuration == 3 ? 'active' : ''">3M</a>
                                        <a href="javascript://" @click="selectedDuration = 6"
                                            :class="selectedDuration == 6 ? 'active' : ''">6M</a>
                                        <a href="javascript://" @click="selectedDuration = 12"
                                            :class="selectedDuration == 12 ? 'active' : ''">1Y</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table_scc">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr class="bg_top top_bg_right_black">
                                            <td colspan="2">
                                                <div class="form_select">
                                                    <label for="">Schemes, Index, Currency, Commodity</label>
                                                    <multiselect :disabled="compare_price_process" class=""
                                                        label="fund_name" track-by="fund_id" v-model="selectedScheme1"
                                                        tag-placeholder="" placeholder="Select Fund" :options="funds"
                                                        :multiple="false" :taggable="false" selectLabel=""
                                                        :searchable="true" :block-keys="['Tab', 'Enter', 'backspace']"
                                                        :max-height="300" :showNoResults="true" :width="100">
                                                    </multiselect>
                                                </div>
                                            </td>
                                            <td class="bg_222">
                                                <div class="form_select">
                                                    <label for="">From Date</label>
                                                    <input class="form-date" type="date"
                                                        v-model="selectedDateRangeFrom" />
                                                </div>
                                            </td>
                                            <td class="bg_222">
                                                <div class="form_select">
                                                    <label for="">To Date</label>
                                                    <input class="form-date" type="date"
                                                        v-model="selectedDateRangeTo" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="bg_green">
                                            <td width="300px">
                                                <div class="form_select">
                                                    <label for="">Schemes, Index, Currency, Commodity</label>
                                                    <multiselect :disabled="compare_price_process" class=""
                                                        label="fund_name" track-by="fund_id" v-model="selectedScheme2"
                                                        tag-placeholder="" placeholder="Select Fund" :options="funds"
                                                        :multiple="false" :taggable="false" selectLabel=""
                                                        :searchable="true" :block-keys="['Tab', 'Enter', 'backspace']"
                                                        :max-height="300" :showNoResults="true" :width="100">
                                                    </multiselect>
                                                </div>
                                            </td>
                                            <td width="300px">
                                                <div class="form_select">
                                                    <label for="">Schemes, Index, Currency, Commodity</label>
                                                    <multiselect :disabled="compare_price_process" class=""
                                                        label="fund_name" track-by="fund_id" v-model="selectedScheme3"
                                                        tag-placeholder="" placeholder="Select Fund" :options="funds"
                                                        :multiple="false" :taggable="false" selectLabel=""
                                                        :searchable="true" :block-keys="['Tab', 'Enter', 'backspace']"
                                                        :max-height="300" :showNoResults="true">
                                                    </multiselect>
                                                </div>
                                            </td>
                                            <td width="300px">
                                                <div class="form_select">
                                                    <label for="">Schemes, Index, Currency, Commodity</label>
                                                    <multiselect :disabled="compare_price_process" class=""
                                                        label="fund_name" track-by="fund_id" v-model="selectedScheme4"
                                                        tag-placeholder="" placeholder="Select Fund" :options="funds"
                                                        :multiple="false" :taggable="false" selectLabel=""
                                                        :searchable="true" :block-keys="['Tab', 'Enter', 'backspace']"
                                                        :max-height="300" :showNoResults="true">
                                                    </multiselect>
                                                </div>
                                            </td>
                                            <td width="300px">
                                                <div class="form_select">
                                                    <label for="">Schemes, Index, Currency, Commodity</label>
                                                    <multiselect :disabled="compare_price_process" class=""
                                                        label="fund_name" track-by="fund_id" v-model="selectedScheme5"
                                                        tag-placeholder="" placeholder="Select Fund" :options="funds"
                                                        :multiple="false" :taggable="false" selectLabel=""
                                                        :searchable="true" :block-keys="['Tab', 'Enter', 'backspace']"
                                                        :max-height="300" :showNoResults="true">
                                                    </multiselect>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="three_btn mt-3">
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="middle_left">
                                        <a href="javascript://" :disabled="disableComparePrice || compare_price_process"
                                            @click="priceCompare">Compare</a>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="middle_a d-flex align-items-center justify-content-center">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <LoadingBar :status="loadingStatus"></LoadingBar>
                        </div>
                        <p v-if="notice_text" class="text-warning mt-3 text-center w-100 mb-0">{{ notice_text }}</p>
                        <div class="mt-5 " style="width: 100%;" v-show="show_graph">
                            <div class="row">
                                <div class="col-lg-6 col-md-5 col-sm-12">
                                    <div id="chartContainer" style="height: 360px;"></div>
                                </div>
                                <div class="col-lg-6 col-md-5 col-sm-12" v-show="show_graph2">
                                    <div id="dataPriceChatTwo" style="height: 360px;"></div>
                                </div>
                            </div>
                            <div class="row d-none">

                            </div>
                            <div class="row  mt-5">
                                <div class="col-lg-6 col-md-5 col-sm-12" v-show="show_graph3">
                                    <div id="dataPriceChatThree" style="height: 360px;"></div>
                                </div>
                                <div class="col-lg-6 col-md-5 col-sm-12" v-show="show_graph4">
                                    <div id="dataPriceChatFour" style="height: 360px;"></div>
                                </div>
                            </div>
                            <div class="row  mt-5">
                                <div class="col-lg-6 col-md-5 col-sm-12" v-show="show_graph5">
                                    <div id="dataPriceChatFive" style="height: 360px;"></div>
                                </div>
                                <div class="col-lg-6 col-md-5 col-sm-12" v-show="show_graph6">
                                    <div id="dataPriceChatSix" style="height: 360px;"></div>
                                </div>
                            </div>
                        </div>
                        <p v-if="nodata_text" class="text-warning mt-3 text-center w-100 mb-0">{{ nodata_text }}</p>
                    </div>
                    <!-- ratio calulation -->
                    <div class="tab-pane fade" :class="{ 'active show': currentTab == 'ratios' }" id="pills-profile"
                        role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="three_btn mb-2">
                            <div class="row align-items-center justify-content-end">
                                <div class="col-lg-4">
                                    <div
                                        class="middle_a d-flex align-items-center justify-content-md-end justify-content-center">
                                        <a href="javascript://" @click="selectedRatioDuration = 1"
                                            :class="selectedRatioDuration == 1 ? 'active' : ''">1M</a>
                                        <a href="javascript://" @click="selectedRatioDuration = 3"
                                            :class="selectedRatioDuration == 3 ? 'active' : ''">3M</a>
                                        <a href="javascript://" @click="selectedRatioDuration = 6"
                                            :class="selectedRatioDuration == 6 ? 'active' : ''">6M</a>
                                        <a href="javascript://" @click="selectedRatioDuration = 12"
                                            :class="selectedRatioDuration == 12 ? 'active' : ''">1Y</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table_scc">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr class="bg_top top_bg_right_black">
                                            <td colspan="2">
                                                <div class="form_select">
                                                    <label for="">Schemes, Index, Currency, Commodity</label>
                                                    <multiselect class="" label="fund_name" track-by="fund_id"
                                                        v-model="selectedFund1Ratio" tag-placeholder=""
                                                        placeholder="Select Fund" :options="funds" :multiple="false"
                                                        :taggable="false" selectLabel="" :searchable="true"
                                                        :disabled="compare_price_process"
                                                        :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150"
                                                        :showNoResults="true">
                                                    </multiselect>

                                                </div>
                                            </td>
                                            <td colspan="">
                                                <table class="table">
                                                    <tr>
                                                        <td>
                                                            <div class="form_select">
                                                                <label for="">Return Ratio</label>
                                                                <select class="" v-model="selectedRatioReturn"
                                                                    :disabled="selectedRatioRisk !== ''"
                                                                    style="width:123px">
                                                                    <option value="">Select</option>
                                                                    <option value="cagr">Returns</option>
                                                                    <option value="jensen_alpha">Jensen</option>
                                                                    <option value="information_ratio">Information Ratio
                                                                    </option>
                                                                    <option value="rolling_return">Rolling Return
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form_select">
                                                                <label for="">Risk Ratio</label>
                                                                <select class="form-select" v-model="selectedRatioRisk"
                                                                    :disabled="selectedRatioReturn !== ''">
                                                                    <option value="">Select</option>
                                                                    <option value="beta">Beta</option>
                                                                    <option value="tracking_error">Tracking Error
                                                                    </option>
                                                                    <option value="volatality">Volatility</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>


                                            </td>
                                            <td class="bg_222">
                                                <div class="form_select">
                                                    <label for="">From Date</label>
                                                    <input class="form-date" type="date"
                                                        v-model="selectedRatioDateFrom" />
                                                </div>
                                            </td>
                                            <td class="bg_222">
                                                <div class="form_select">
                                                    <label for="">To Date</label>
                                                    <input class="form-date" type="date"
                                                        v-model="selectedRatioDateTo" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="bg_green">
                                            <td width="450" colspan="2">
                                                <div class="form_select">
                                                    <label for="">Schemes, Index, Currency, Commodity</label>
                                                    <multiselect class="" label="fund_name" track-by="fund_id"
                                                        v-model="selectedFund2Ratio" tag-placeholder=""
                                                        placeholder="Select Fund" :options="funds" :multiple="false"
                                                        :taggable="false" selectLabel="" :searchable="true"
                                                        :disabled="compare_price_process"
                                                        :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150"
                                                        :showNoResults="true">
                                                    </multiselect>
                                                </div>
                                            </td>
                                            <td width="350">
                                                <div class="form_select">
                                                    <label for="">Schemes, Index, Currency, Commodity</label>
                                                    <multiselect class="" label="fund_name" track-by="fund_id"
                                                        v-model="selectedFund3Ratio" tag-placeholder=""
                                                        placeholder="Select Fund" :options="funds" :multiple="false"
                                                        :taggable="false" selectLabel="" :searchable="true"
                                                        :disabled="compare_price_process"
                                                        :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150"
                                                        :showNoResults="true">
                                                    </multiselect>
                                                </div>
                                            </td>
                                            <td width="350">
                                                <div class="form_select">
                                                    <label for="">Schemes, Index, Currency, Commodity</label>
                                                    <multiselect class="" label="fund_name" track-by="fund_id"
                                                        v-model="selectedFund4Ratio" tag-placeholder=""
                                                        placeholder="Select Fund" :options="funds" :multiple="false"
                                                        :taggable="false" selectLabel="" :searchable="true"
                                                        :disabled="compare_price_process"
                                                        :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150"
                                                        :showNoResults="true">
                                                    </multiselect>
                                                </div>
                                            </td>
                                            <td width="350">
                                                <div class="form_select">
                                                    <label for="">Schemes, Index, Currency, Commodity</label>
                                                    <multiselect class="" label="fund_name" track-by="fund_id"
                                                        v-model="selectedFund5Ratio" tag-placeholder=""
                                                        placeholder="Select Fund" :options="funds" :multiple="false"
                                                        :taggable="false" selectLabel="" :searchable="true"
                                                        :disabled="compare_price_process"
                                                        :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150"
                                                        :showNoResults="true">
                                                    </multiselect>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="three_btn mt-3">
                            <div class="row align-items-center">
                                <div class="col-lg-2">
                                    <div class="middle_left">
                                        <a href="javascript://" :disabled="disableCompareRatio"
                                            @click="ratioCompare">Compare</a>
                                    </div>
                                </div>
                                <!-- <div class="col-lg-6">
                                    <div class="middle_a d-flex align-items-center justify-content-center">
                                        <a href="javascript://" @click="selectedRatioReturn='cagr'"
                                            :class="selectedRatioReturn=='cagr' ? 'active' :''">Returns</a>
                                        <a href="javascript://" @click="selectedRatioReturn='jensen_alpha'"
                                            :class="selectedRatioReturn=='jensen_alpha' ? 'active' :''">Jensen</a>
                                        <a href="javascript://" @click="selectedRatioReturn='information_ratio'"
                                            :class="selectedRatioReturn=='information_ratio' ? 'active' :''">Information
                                            Ratio</a>
                                        <a href="javascript://" @click="selectedRatioReturn='rolling_return'"
                                            :class="selectedRatioReturn=='rolling_return' ? 'active' :''">Rolling
                                            Return</a>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <LoadingBar :status="loadingStatus"></LoadingBar>
                        </div>
                        <p v-if="notice_text_ratio" class="text-warning mt-3 text-center w-100 mb-0">
                            {{ notice_text_ratio }}</p>
                        <div class="mt-5 " style="width: 100%;" v-show="show_ratio_graph">
                            <div id="chartContainerRatio" style="height: 360px; width: 100%;"></div>
                        </div>
                    </div>
                    <!-- ratio calulation end-->
                    <!-- composition  -->
                    <div class="tab-pane fade" :class="{ 'active show': currentTab == 'composition' }" id="pills-contact"
                        role="tabpanel" aria-labelledby="pills-contact-tab">
                        <div class="table_scc">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr class="bg_top top_bg_right_black">
                                            <td colspan="2">
                                                <div class="form_select">
                                                    <label for="">Schemes, Index, Currency, Commodity</label>
                                                    <multiselect class="" label="fund_name" track-by="fund_id"
                                                        v-model="selectedFund1Composition" tag-placeholder=""
                                                        placeholder="Select Fund" :options="funds" :multiple="false"
                                                        :taggable="false" selectLabel="" :searchable="true"
                                                        :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150"
                                                        :showNoResults="true">
                                                    </multiselect>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form_select">
                                                    <label for="">Category</label>
                                                    <select class="form-select" v-model="selectedCompositionCategory">
                                                        <option value="">Select</option>
                                                        <option value="top_script">Top Scrip</option>
                                                        <option value="top_industry">Top Industry</option>
                                                        <option value="aaum">AAUM</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td colspan="2" class="bg_222">
                                                <div class="form_select">
                                                    <label for="">Month/Year</label>
                                                    <Datepicker v-model="selectedCompositionDate" :format="'MM/yyyy'"
                                                        monthPicker :enableTimePicker="false" :autoApply="true"
                                                        :range="false" :maxDate="maxDateRangComposition"></Datepicker>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="bg_green">
                                            <td width="300">
                                                <div class="form_select">
                                                    <label for="">Schemes, Index, Currency, Commodity</label>
                                                    <multiselect class="" label="fund_name" track-by="fund_id"
                                                        v-model="selectedFund2Composition" tag-placeholder=""
                                                        placeholder="Select Fund" :options="funds" :multiple="false"
                                                        :taggable="false" selectLabel="" :searchable="true"
                                                        :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150"
                                                        :showNoResults="true">
                                                    </multiselect>
                                                </div>
                                            </td>
                                            <td width="300">
                                                <div class="form_select">
                                                    <label for="">Schemes, Index, Currency, Commodity</label>
                                                    <multiselect class="" label="fund_name" track-by="fund_id"
                                                        v-model="selectedFund3Composition" tag-placeholder=""
                                                        placeholder="Select Fund" :options="funds" :multiple="false"
                                                        :taggable="false" selectLabel="" :searchable="true"
                                                        :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150"
                                                        :showNoResults="true">
                                                    </multiselect>
                                                </div>
                                            </td>
                                            <td width="300">
                                                <div class="form_select">
                                                    <label for="">Schemes, Index, Currency, Commodity</label>
                                                    <multiselect class="" label="fund_name" track-by="fund_id"
                                                        v-model="selectedFund4Composition" tag-placeholder=""
                                                        placeholder="Select Fund" :options="funds" :multiple="false"
                                                        :taggable="false" selectLabel="" :searchable="true"
                                                        :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150"
                                                        :showNoResults="true">
                                                    </multiselect>
                                                </div>
                                            </td>
                                            <td width="300">
                                                <div class="form_select">
                                                    <label for="">Schemes, Index, Currency, Commodity</label>
                                                    <multiselect class="" label="fund_name" track-by="fund_id"
                                                        v-model="selectedFund5Composition" tag-placeholder=""
                                                        placeholder="Select Fund" :options="funds" :multiple="false"
                                                        :taggable="false" selectLabel="" :searchable="true"
                                                        :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150"
                                                        :showNoResults="true">
                                                    </multiselect>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="three_btn mt-3">
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="middle_left">
                                        <a href="javascript://" :disabled="disableCompareComposition"
                                            @click="compositionCompare">Compare</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p v-if="notice_text_comp" class="text-warning mt-3 text-center w-100 mb-0">{{ notice_text_comp }}
                        </p>
                        <p v-if="compositionTypeValidationError" class="text-warning mt-3 text-center w-100 mb-0">
                            {{ compositionTypeValidationError }}</p>
                        <p v-if="compositionValidationError" class="text-warning mt-3 text-center w-100 mb-0">
                            {{ compositionValidationError }}</p>
                        <div class="compsition-tables" v-show="show_comp">
                            <div class="row main_trer mt-5" v-if="compare_comp_script.length">
                                <div class="col-lg-6 col-md-12" v-for="(com_data, index) in compare_comp_script">
                                    <p>{{ com_data.fund_name }}</p>
                                    <table class="table table-borderless table-striped">
                                        <thead>
                                            <tr>
                                                <th>Scrips</th>
                                                <th>Content%</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="script in com_data.data" :key="script.scrip_name">
                                                <td class="modal-td">{{ script.scrip_name }}</td>
                                                <td>{{ script.content_per.toFixed(2) }}</td>
                                            </tr>

                                        </tbody>
                                        <tfoot>
                                            <th>Total Of Top 10</th>
                                            <th>{{ com_data.top_scripts_sum.toFixed(2) }}</th>
                                        </tfoot>
                                    </table>
                                </div>
                                <hr :if="index % 2">
                            </div>
                            <div class="row main_trer mt-5" v-if="compare_comp_industry.length">
                                <div class="col-lg-6 col-md-12" v-for="(com_industry, index) in compare_comp_industry">
                                    <p>{{ com_industry.fund_name }}</p>
                                    <table class="table table-borderless table-striped">
                                        <thead>
                                            <tr>
                                                <th>Industries</th>
                                                <th>Content%</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="industry in com_industry.data" :key="industry.industry">
                                                <td class="grey">{{ industry.industry }}</td>
                                                <td>{{ industry.industry_content_per.toFixed(2) }}</td>
                                            </tr>

                                        </tbody>
                                        <tfoot>
                                            <th>Total Of Top 10</th>
                                            <th>{{ com_industry.top_industry_sum != 0 ?
                                                    com_industry.top_industry_sum.toFixed(2) : com_industry.top_industry_sum
                                            }}</th>
                                        </tfoot>
                                    </table>
                                </div>
                                <hr :if="index % 2">
                            </div>
                            <div class="row main_trer mt-5" v-if="Object.keys(compare_comp_aaum).length">
                                <div class="col-lg-6 col-md-12">
                                    <table class="table table-borderless table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name Of Fund</th>
                                                <th>AAUM</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(ammu_data, index) in compare_comp_aaum" :key="index">
                                                <td class="modal-td">{{ ammu_data.fund_name }}</td>
                                                <td>{{ ammu_data.corpus_entry.toFixed(2) }}</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="text-center mt-3">
                                <LoadingBar :status="compare_comp_process"></LoadingBar>
                            </div>
                        </div>
                    </div>
                    <!-- composition end -->
                </div>
            </div>
        </div>

    </section>

</template>

<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css">

</style>

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
            selectedSchemes: [],
            selectedScheme1: [],
            selectedScheme2: [],
            selectedScheme3: [],
            selectedScheme4: [],
            selectedScheme5: [],
            selectedScheme6: [],
            selectedIndex1: [],
            selectedIndex2: [],
            selectedCurrency1: [],
            selectedCurrency2: [],
            compare_price_data: [],
            show_graph: false,
            show_graph3: false,
            show_graph4: false,
            show_graph5: false,
            show_graph6: false,
            notice_text: '',
            nodata_text: '',
            selectedFund1Ratio: [],
            selectedFund2Ratio: [],
            selectedFund3Ratio: [],
            selectedFund4Ratio: [],
            selectedFund5Ratio: [],
            selectedFund6Ratio: [],
            selectedRatioReturn: '',
            selectedRatioRisk: '',
            selectedRatioDuration: '12',
            enableRatioCustomDates: false,
            selectedRatioDateRange: null,
            selectedRatioDateFrom: null, // added by sandeep
            selectedRatioDateTo: null, // added by sandeep as per new UI
            selectedFund1Composition: [],
            selectedFund2Composition: [],
            selectedFund3Composition: [],
            selectedFund4Composition: [],
            selectedFund5Composition: [],
            selectedFund6Composition: [],
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
            app_url: process.env.MIX_APP_ENV == 'local' ? process.env.MIX_API_URL_LOCAL : '',
            loadingStatus: false,
            notice_text_comp: '',
            compositionValidationError: '',
            compositionTypeValidationError: ''
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
        DailyPriceScheme(e, position) {
            this.selectedSchemes[position] = {
                'value': encodeURIComponent(e.target.value),
                'title': e.target.options[e.target.options.selectedIndex].text
            };

        },
        priceCompare() {
            console.log(this.selectedScheme4.fund_name);
            let that = this
            this.loadingStatus = true
            this.nodata_text = '';
            that.show_graph = false
            this.selectedComparePriceType = 'scheme_scheme';
            let data = {
                'compare_type': this.selectedComparePriceType,
            }
            let title1 = ''
            let title2 = '',
                title3 = '',
                title4 = '',
                title5 = '',
                title6 = '';
            if ((this.selectedComparePriceType == 'scheme_scheme' || this.selectedComparePriceType == 'scheme_index' || this.selectedComparePriceType == 'scheme_currency')) {
                data.value1 = encodeURIComponent(this.selectedScheme1.fund_code)
                title1 = this.selectedScheme1.fund_name
            }
            if ((this.selectedComparePriceType == 'scheme_scheme')) {
                data.value2 = encodeURIComponent(this.selectedScheme2.fund_code)
                title2 = this.selectedScheme2.fund_name
                data.value3 = encodeURIComponent(this.selectedScheme3.fund_code)
                title3 = this.selectedScheme3.fund_name
                data.value4 = encodeURIComponent(this.selectedScheme4.fund_code)
                title4 = this.selectedScheme4.fund_name
                data.value5 = encodeURIComponent(this.selectedScheme5.fund_code)
                title5 = this.selectedScheme5.fund_name
                data.value6 = encodeURIComponent(this.selectedScheme6.fund_code)
                title6 = this.selectedScheme6.fund_name
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
            axios.get(that.app_url + '/api/v2/compare-price', {
                params: data
            })
                .then(response => {
                    this.loadingStatus = false
                    let graph_data = that.compare_price_data = response.data.data.graph_data
                    if (graph_data[0].length <= 0) {
                        that.show_graph = false
                        this.nodata_text = 'No records found';
                        return
                    }
                    that.compare_price_data = response.data.data.graph_data
                    let notice_text = response.data.data.notice_text
                    if (notice_text) {
                        that.notice_text = (response.data.data.notice_value_type == 1) ? title1 + ' ' + notice_text : title2 + ' ' + notice_text
                    }
                    that.chart.options.data[0].dataPoints = []

                    that.chart.options.data[0].name = title1;
                    // that.chart.options.axisY[0].title = title1;

                    graph_data[0].forEach(function (item, index) {

                        that.chart.options.data[0].dataPoints.push({ y: item.VALUE, label: item.DATE });
                    });
                    that.chart.options.data[1].dataPoints = []

                    that.chart.options.data[1].name = title2;
                    // that.chart.options.axisY2.title = title2;

                    graph_data[1].forEach(function (item, index) {

                        that.chart.options.data[1].dataPoints.push({ y: item.VALUE, label: item.DATE });
                    });
                    that.chart.render();
                    that.show_graph = true
                    // chart 3 

                    if (data.value3 != 'undefined') {
                        that.chart2.options.data[0].name = title1;
                        that.chart2.options.data[1].name = title3;
                        let NewChatArray2 = [graph_data[0], graph_data[2]];
                        NewChatArray2.forEach(function (item, index) {
                            that.chart2.options.data[index].dataPoints = []
                            item.forEach(function (val) {
                                that.chart2.options.data[index].dataPoints.push({ y: val.VALUE, label: item.DATE });
                            });
                        });
                        that.chart2.render();
                        that.show_graph2 = true
                    }
                    if (data.value4 != 'undefined') {
                        that.chart3.options.data[0].name = title1;
                        that.chart3.options.data[1].name = title4;
                        let NewChatArray3 = [graph_data[0], graph_data[3]];
                        NewChatArray3.forEach(function (item, index) {
                            that.chart3.options.data[index].dataPoints = []
                            item.forEach(function (val) {
                                that.chart3.options.data[index].dataPoints.push({ y: val.VALUE, label: item.DATE });
                            });
                        });
                        that.chart3.render();
                        that.show_graph3 = true
                    }
                    if (data.value5 != 'undefined') {
                        that.chart4.options.data[0].name = title1;
                        that.chart4.options.data[1].name = title4;
                        let NewChatArray4 = [graph_data[0], graph_data[4]];
                        NewChatArray4.forEach(function (item, index) {
                            that.chart4.options.data[index].dataPoints = []
                            item.forEach(function (val) {
                                that.chart4.options.data[index].dataPoints.push({ y: val.VALUE, label: item.DATE });
                            });
                        });
                        that.chart4.render();
                        that.show_graph4 = true
                    }

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
            that.show_ratio_graph = false
            this.loadingStatus = true
            let data = {}
            data.compare_type = (this.selectedRatioRisk) ? this.selectedRatioRisk : this.selectedRatioReturn
            data.value1 = encodeURIComponent(this.selectedFund1Ratio.fund_code)
            data.value2 = encodeURIComponent(this.selectedFund2Ratio.fund_code)
            data.value3 = encodeURIComponent(this.selectedFund3Ratio.fund_code)
            data.value4 = encodeURIComponent(this.selectedFund4Ratio.fund_code)
            data.value5 = encodeURIComponent(this.selectedFund5Ratio.fund_code)
            data.value6 = encodeURIComponent(this.selectedFund6Ratio.fund_code)
            let titles = [
                this.selectedFund1Ratio.fund_name,
                this.selectedFund2Ratio.fund_name,
                this.selectedFund3Ratio.fund_name,
                this.selectedFund4Ratio.fund_name,
                this.selectedFund5Ratio.fund_name,
                this.selectedFund6Ratio.fund_name,
            ];
            if (!this.selectedRatioDateFrom) {
                data.from_date = moment().subtract(1, 'days').subtract(this.selectedRatioDuration, 'months').format('YYYY-MM-DD')
                data.to_date = moment().subtract(1, 'days').format('YYYY-MM-DD');
            } else if (this.selectedRatioDateFrom) {
                data.from_date = this.selectedRatioDateFrom; //moment(this.selectedRatioDateRange[0]).format('YYYY-MM-DD')
                data.to_date = this.selectedRatioDateTo; // moment(this.selectedRatioDateRange[1]).format('YYYY-MM-DD')
            }
            that.compare_ratio_process = true
            that.notice_text_ratio = ''
            that.chart_ratio.options.data[0].dataPoints = []
            that.chart_ratio.render();
            axios.get(that.app_url + '/api/v2/compare-ratios', {
                params: data
            })
                .then(response => {
                    let graph_data = that.compare_ratio_data = response.data.data.graph_data
                    that.compare_ratio_data = response.data.data.graph_data
                    let notice_text = response.data.data.notice_text
                    if (notice_text) {
                        that.notice_text_ratio = (response.data.data.notice_value_type == 1) ? title1 + ' ' + notice_text : title2 + ' ' + notice_text
                    }
                    if (graph_data.length) {
                        let grap_data = graph_data.filter(value => JSON.stringify(value) !== '{}')
                        console.log(grap_data);
                        grap_data.map(function (value, key) {
                            if (typeof value.length != undefined) {
                                let yVal = value[data.compare_type].toFixed(2)
                                that.chart_ratio.options.data[0].dataPoints.push({
                                    y: parseFloat(yVal),
                                    label: titles[key]
                                });
                            }
                        })
                    } else {

                    }

                    if (Object.keys(graph_data[0]).length || Object.keys(graph_data[1]).length) {
                        that.chart_ratio.render();
                    } else {
                        that.show_ratio_graph = false
                        that.notice_text_ratio = 'No data Found for this schemes '
                        return;
                    }
                    this.loadingStatus = false
                    that.show_ratio_graph = true

                })
                .catch(error => {
                    //var message = error.response.data.message || error.message
                    this.loadingStatus = false
                    that.show_ratio_graph = false
                    that.notice_text_ratio = 'No data FoundNo data Found for this schemes '
                    that.compare_ratio_process = false
                })
                .finally(() => {
                    this.loadingStatus = false
                    that.compare_ratio_process = false
                })

        },
        compositionCompare() {
            let that = this

            let data = {}
            let title1 = ''
            let title2 = ''
            data.compare_type = this.selectedCompositionCategory
            data.value1 = encodeURIComponent(this.selectedFund1Composition.fund_code)
            that.comp_scheme1_text = this.selectedFund1Composition.fund_name
            data.value2 = encodeURIComponent(this.selectedFund2Composition.fund_code)
            that.comp_scheme2_text = this.selectedFund2Composition.fund_name
            if (data.comapre_type == '') {
                that.compositionTypeValidationError = 'Please select compare type'
                return false;
            }
            if (data.value1 == '' && data.value2 == '') {
                that.compositionValidationError = 'Please select least 2 schems to compare'
                return false;
            }
            that.show_comp = true

            if (this.selectedFund3Composition.fund_id) {
                data.value3 = encodeURIComponent(this.selectedFund3Composition.fund_code)
                that.comp_scheme3_text = this.selectedFund3Composition.fund_name
            }
            if (this.selectedFund4Composition.fund_id) {
                data.value4 = encodeURIComponent(this.selectedFund4Composition.fund_code)
                that.comp_scheme4_text = this.selectedFund4Composition.fund_name
            }
            if (this.selectedFund5Composition.fund_id) {
                data.value5 = encodeURIComponent(this.selectedFund5Composition.fund_code)
                that.comp_scheme5_text = this.selectedFund5Composition.fund_name
            }
            if (this.selectedFund6Composition.fund_id) {
                data.value6 = encodeURIComponent(this.selectedFund6Composition.fund_code)
                that.comp_scheme6_text = this.selectedFund6Composition.fund_name
            }
            data.month = 1 + this.selectedCompositionDate.month
            data.year = this.selectedCompositionDate.year

            that.compare_comp_process = true
            that.notice_text_comp = ''
            that.chart_ratio.render();
            that.compare_comp_script = []
            that.compare_comp_industry = []
            that.compare_comp_aaum = []
            axios.get(that.app_url + '/api/v2/compare-compositions', {
                params: data
            })
                .then(response => {
                    that.compare_comp_process = false
                    let graph_data = that.compare_ratio_data = response.data.data.composition_data
                    if (typeof graph_data[0].data.length == 0) {
                        that.show_comp = false
                        that.notice_text_comp = 'No data Found'
                        that.compare_comp_process = false
                        return false;
                    }

                    let notice_text = response.data.data.notice_text
                    if (notice_text) {
                        that.notice_text_comp = (response.data.data.notice_value_type == 1) ? title1 + ' ' + notice_text : title2 + ' ' + notice_text
                    }

                    if (data.compare_type == 'top_script') {
                        that.compare_comp_script = graph_data
                    }
                    if (data.compare_type == 'top_industry') {
                        that.compare_comp_industry = graph_data
                    }
                    if (data.compare_type == 'aaum') {
                        that.compare_comp_aaum = graph_data
                    }
                    that.compare_comp_process = false

                })
                .catch(error => {
                    // var message = error.response.data.message || error.message
                    that.show_comp = false
                    that.notice_text_comp = 'No data Found'
                    that.compare_comp_process = false
                })
                .finally(() => {
                    that.compare_comp_process = false
                })

        },

    },
    watch: {
        selectedDuration(value) {
            if (value) {
                this.priceCompare();
            }
        },
        selectedRatioDuration(value) {
            if (value) {
                this.ratioCompare();
            }
        },
        // selectedRatioReturn(value) {
        //     if (value) {
        //         this.ratioCompare();
        //     }
        // }
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
        if (compare_composition_type == 'top_industry') {
            this.currentTab = 'composition'
        }
        if (compare_ratio_type == 'information_ratio') {
            this.currentTab = 'ratios'
        }
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
                color: "#cdaa44",
                axisYType: "secondary",
                showInLegend: true,
                dataPoints: []
            }
            ],
        }
        CanvasJS.addColorSet("greenShades", ["#4661EE", "#EC5657", "#1BCDD1", "#8FAABB", "#B08BEB", "#3EA0DD", "#F5A52A", "#23BFAA", "#FAA586", "#EB8CC6"]);
        this.chart = new CanvasJS.Chart("chartContainer", chart);
        this.chart2 = new CanvasJS.Chart("dataPriceChatTwo", chart);
        this.chart3 = new CanvasJS.Chart("dataPriceChatThree", chart);
        this.chart4 = new CanvasJS.Chart("dataPriceChatFour", chart);
        this.chart5 = new CanvasJS.Chart("dataPriceChatFive", chart);
        this.chart6 = new CanvasJS.Chart("dataPriceChatSix", chart);
        this.chart.render();
        this.chart2.render();
        this.chart3.render();
        this.chart4.render();
        this.chart5.render();
        this.chart6.render();

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
    width: 100%;
}

.multiselect--above {
    width: 300px !important;
}

.multiselect__tags,
.multiselect__single {
    background: none !important;
}

.multiselect__single {
    color: #adadad !important
}

.multiselect__input {
    background: none !important;
}

.dp__input_icon_pad {
    padding-left: 35px !important;
}

.table-responsive {
    overflow-x: visible !important;
}

.compare-btn {
    padding-top: 12px;
    padding-bottom: 12px;
    margin-bottom: 12px;
}
</style>
