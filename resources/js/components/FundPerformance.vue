<template>
    <!-- CALCULATOR TABS -->

    <section class="compare_scheme">
        <div class="container">
            <div class="comp_schem_bdr">
                <div class="tab_snap_shot">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-Return-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-Return" type="button" role="tab" aria-controls="pills-Return"
                                aria-selected="true" @click="currentTab = 'returns'"><i class="ph-calendar-check"></i>
                                Return</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-Ratio-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-Ratio" type="button" role="tab" aria-controls="pills-Ratio"
                                aria-selected="false" @click="currentTab = 'ratios'"><i class="ph-calendar"></i>
                                Ratio</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-Portfolio-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-Portfolio" type="button" role="tab"
                                aria-controls="pills-Portfolio" aria-selected="false"
                                @click="currentTab = 'portfolios'"><i class="ph-calendar"></i> Portfolio</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <!-- FUND PERFORMANCE RETURNS TAB START -->
                        <div class="tab-pane fade show active" id="pills-Return" role="tabpanel"
                            aria-labelledby="pills-Return-tab">

                            <div class="datatable_ll performance_compare_top_table mt-4">
                                <h4>Scheme Name:</h4>
                                <div class="row">
                                    <div class="col-md-12 col-md-4">
                                        <multiselect :disabled="process" class="" label="fund_name" track-by="fund_id"
                                            v-model="selectedFundReturns" tag-placeholder="" placeholder="Select Fund"
                                            :options="funds" :multiple="false" :taggable="false" selectLabel=""
                                            :searchable="true" :block-keys="['Tab', 'Enter', 'backspace']"
                                            :max-height="150" :showNoResults="true">
                                        </multiselect>
                                    </div>
                                </div>
                                <div class="table-responsive mt-3" v-if="Object.keys(fund_details).length">
                                    <table id="example" class="" style="width:100%">
                                        <tbody>
                                            <tr>
                                                <td><b>NAV: {{ fund_details.nav }}</b></td>
                                                <td><b>NAV Date : {{ fund_details.nav_entry_date }}</b></td>
                                                <td><b>Category:{{ fund_details.no_of_schemes }}</b></td>
                                                <td><b>AAUM: (LAC) {{ fund_details.aaum }}</b></td>
                                            </tr>
                                            <tr>
                                                <td><b>Scheme Commencement Date:{{ fund_details.fund_opened }}</b></td>
                                                <td><b>Fund Manager: {{ fund_details.fund_man }}</b></td>
                                                <td><b>Schemes in Category (No.): {{ fund_details.no_of_schemes }}</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Benchmark: {{ fund_details.benchmark }}</b></td>
                                                <td><b>Benchmark Value: {{ fund_details.benchmark_closing_value }}</b>
                                                </td>
                                                <td><b>Benchmark Date: {{ fund_details.benchmark_entry_date }}</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center mt-3">
                                    <LoadingBar :status="process"></LoadingBar>
                                </div>
                            </div>
                            <div class="datatable_ll main_trer fund_performance_table">
                                <div class="table-responsive">
                                    <div
                                        class="fund_per_heading d-block d-sm-flex align-items-center justify-content-between">
                                        <h4>Performance Compare</h4>
                                        <div>
                                            <a href="javascript://" class="money_title_btn"
                                                @click="ratio_type = 'to_category'; getFundRatios()"
                                                :disabled="ratio_type == 'to_category' || process">To Category</a>
                                            <a href="javascript://" class="money_title_btn"
                                                @click="ratio_type = 'to_benchmark'; getFundRatios()"
                                                :disabled="ratio_type == 'to_benchmark' || process">To Benchmark</a>
                                        </div>
                                    </div>

                                    <table id="example" class="table table-striped" style="width:100%"
                                        v-if="ratio_type">
                                        <thead>
                                            <tr>
                                                <td style="border-radius:7px" class="dark_bg color_white text-center" colspan="9">Performance
                                                    Compare To Category <span
                                                        v-if="ratio_type == 'to_category'">Category</span><span
                                                        v-if="ratio_type == 'to_benchmark'">Benchmark</span></td>
                                            </tr>
                                            <tr>
                                                <th>Return <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span></th>
                                                <th>7 Days <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span></th>
                                                <th>30 Days <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span></th>
                                                <th>90 Days <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span></th>
                                                <th>180 Days <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span></th>
                                                <th>1 Year <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span></th>
                                                <th>2 Year <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span></th>
                                                <th>3 Year <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span></th>
                                                <th>5 Year <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span></th>
                                            </tr>
                                        </thead>
                                        <tbody id="category_data">
                                            <tr v-if="Object.keys(return_scheme).length">
                                                <td>Scheme</td>
                                                <td>{{ return_scheme.SEVENDAYS.toFixed(2) }}</td>
                                                <td>{{ return_scheme.THIRTYDAYS.toFixed(2) }}</td>
                                                <td>{{ return_scheme.NINTYDAYS.toFixed(2) }}</td>
                                                <td>{{ return_scheme.SIXMONTHS.toFixed(2) }}</td>
                                                <td>{{ return_scheme.ONEYEAR.toFixed(2) }}</td>
                                                <td>{{ return_scheme.TWOYEAR.toFixed(2) }}</td>
                                                <td>{{ return_scheme.THREEYEAR.toFixed(2) }}</td>
                                                <td>{{ return_scheme.FIVEYEAR.toFixed(2) }}</td>
                                            </tr>
                                            <tr class="odd" v-if="Object.keys(scheme_sip_data).length">
                                                <td>Scheme SIP</td>
                                                <td>NA</td>
                                                <td>NA</td>
                                                <td>NA</td>
                                                <td>{{ scheme_sip_data.SIXMONTHS.sip_return }}</td>
                                                <td>{{ scheme_sip_data.ONEYEAR.sip_return }}</td>
                                                <td>{{ scheme_sip_data.TWOYEAR.sip_return }}</td>
                                                <td>{{ scheme_sip_data.THREEYEAR.sip_return }}</td>
                                                <td>{{ scheme_sip_data.FIVEYEAR.sip_return }}</td>
                                            </tr>
                                            <tr
                                                v-if="Object.keys(return_benchmark).length && ratio_type == 'to_benchmark'">
                                                <td>{{ fund_details.benchmark }}</td>
                                                <td>{{ return_benchmark.SEVENDAYS.toFixed(2) }}</td>
                                                <td>{{ return_benchmark.THIRTYDAYS.toFixed(2) }}</td>
                                                <td>{{ return_benchmark.NINTYDAYS.toFixed(2) }}</td>
                                                <td>{{ return_benchmark.SIXMONTHS.toFixed(2) }}</td>
                                                <td>{{ return_benchmark.ONEYEAR.toFixed(2) }}</td>
                                                <td>{{ return_benchmark.TWOYEAR.toFixed(2) }}</td>
                                                <td>{{ return_benchmark.THREEYEAR.toFixed(2) }}</td>
                                                <td>{{ return_benchmark.FIVEYEAR.toFixed(2) }}</td>
                                            </tr>
                                            <tr class="odd"
                                                v-if="Object.keys(benchmark_sip_data).length && ratio_type == 'to_benchmark'">
                                                <td>{{ fund_details.benchmark }} SIP</td>
                                                <td>NA</td>
                                                <td>NA</td>
                                                <td>NA</td>
                                                <td>{{ benchmark_sip_data.SIXMONTHS.sip_return }}</td>
                                                <td>{{ benchmark_sip_data.ONEYEAR.sip_return }}</td>
                                                <td>{{ benchmark_sip_data.TWOYEAR.sip_return }}</td>
                                                <td>{{ benchmark_sip_data.THREEYEAR.sip_return }}</td>
                                                <td>{{ benchmark_sip_data.FIVEYEAR.sip_return }}</td>
                                            </tr>
                                            <template
                                                v-if="Object.keys(category_compare_data).length && ratio_type == 'to_category'">
                                                <tr>
                                                    <td>Category Average</td>
                                                    <td>{{ category_compare_data.SEVENDAYS.length !== 0
                                                            ? category_compare_data.SEVENDAYS.category_avg.toFixed(2) : 'NA'
                                                    }}
                                                    </td>
                                                    <td>{{ category_compare_data.THIRTYDAYS.length !== 0
                                                            ? category_compare_data.THIRTYDAYS.category_avg.toFixed(2) :
                                                            'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.NINTYDAYS.length !== 0
                                                            ? category_compare_data.NINTYDAYS.category_avg.toFixed(2) : 'NA'
                                                    }}
                                                    </td>
                                                    <td>{{ category_compare_data.SIXMONTHS.length !== 0
                                                            ? category_compare_data.SIXMONTHS.category_avg.toFixed(2) : 'NA'
                                                    }}
                                                    </td>
                                                    <td>{{ category_compare_data.ONEYEAR.length !== 0
                                                            ? category_compare_data.ONEYEAR.category_avg.toFixed(2) : 'NA'
                                                    }}
                                                    </td>
                                                    <td>{{ category_compare_data.TWOYEAR.length !== 0
                                                            ? category_compare_data.TWOYEAR.category_avg.toFixed(2) : 'NA'
                                                    }}
                                                    </td>
                                                    <td>{{ category_compare_data.THREEYEAR.length !== 0
                                                            ? category_compare_data.THREEYEAR.category_avg.toFixed(2) : 'NA'
                                                    }}
                                                    </td>
                                                    <td>{{ category_compare_data.FIVEYEAR.length !== 0
                                                            ? category_compare_data.FIVEYEAR.category_avg.toFixed(2) : 'NA'
                                                    }}
                                                    </td>
                                                </tr>
                                                <tr class="odd">
                                                    <td>Category Median</td>
                                                    <td>{{ category_compare_data.SEVENDAYS.length !== 0
                                                            ? category_compare_data.SEVENDAYS.median.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.THIRTYDAYS.length !== 0
                                                            ? category_compare_data.THIRTYDAYS.median.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.NINTYDAYS.length !== 0
                                                            ? category_compare_data.NINTYDAYS.median.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.SIXMONTHS.length !== 0
                                                            ? category_compare_data.SIXMONTHS.median.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.ONEYEAR.length !== 0
                                                            ? category_compare_data.ONEYEAR.median.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.TWOYEAR.length !== 0
                                                            ? category_compare_data.TWOYEAR.median.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.THREEYEAR.length !== 0
                                                            ? category_compare_data.THREEYEAR.median.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.FIVEYEAR.length !== 0
                                                            ? category_compare_data.FIVEYEAR.median.toFixed(2) : 'NA'
                                                    }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Category Leader</td>
                                                    <td>{{ category_compare_data.SEVENDAYS.length !== 0
                                                            ? category_compare_data.SEVENDAYS.leader.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.THIRTYDAYS.length !== 0
                                                            ? category_compare_data.THIRTYDAYS.leader.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.NINTYDAYS.length !== 0
                                                            ? category_compare_data.NINTYDAYS.leader.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.SIXMONTHS.length !== 0
                                                            ? category_compare_data.SIXMONTHS.leader.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.ONEYEAR.length !== 0
                                                            ? category_compare_data.ONEYEAR.leader.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.TWOYEAR.length !== 0
                                                            ? category_compare_data.TWOYEAR.leader.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.THREEYEAR.length !== 0
                                                            ? category_compare_data.THREEYEAR.leader.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.FIVEYEAR.length !== 0
                                                            ? category_compare_data.FIVEYEAR.leader.toFixed(2) : 'NA'
                                                    }}</td>
                                                </tr>
                                                <tr class="odd">
                                                    <td>Category Laggard</td>
                                                    <td>{{ category_compare_data.SEVENDAYS.length !== 0
                                                            ? category_compare_data.SEVENDAYS.laggard.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.THIRTYDAYS.length !== 0
                                                            ? category_compare_data.THIRTYDAYS.laggard.toFixed(2) : 'NA'
                                                    }}
                                                    </td>
                                                    <td>{{ category_compare_data.NINTYDAYS.length !== 0
                                                            ? category_compare_data.NINTYDAYS.laggard.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.SIXMONTHS.length !== 0
                                                            ? category_compare_data.SIXMONTHS.laggard.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.ONEYEAR.length !== 0
                                                            ? category_compare_data.ONEYEAR.laggard.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.TWOYEAR.length !== 0
                                                            ? category_compare_data.TWOYEAR.laggard.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.THREEYEAR.length !== 0
                                                            ? category_compare_data.THREEYEAR.laggard.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.FIVEYEAR.length !== 0
                                                            ? category_compare_data.FIVEYEAR.laggard.toFixed(2) : 'NA'
                                                    }}</td>
                                                </tr>
                                                <tr id="cat_dec">
                                                    <td>Category Decile</td>
                                                    <td>{{ category_compare_data.SEVENDAYS.length !== 0
                                                            ? category_compare_data.SEVENDAYS.decile : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.THIRTYDAYS.length !== 0
                                                            ? category_compare_data.THIRTYDAYS.decile : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.NINTYDAYS.length !== 0
                                                            ? category_compare_data.NINTYDAYS.decile : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.SIXMONTHS.length !== 0
                                                            ? category_compare_data.SIXMONTHS.decile : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.ONEYEAR.length !== 0
                                                            ? category_compare_data.ONEYEAR.decile : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.TWOYEAR.length !== 0
                                                            ? category_compare_data.TWOYEAR.decile : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.THREEYEAR.length !== 0
                                                            ? category_compare_data.THREEYEAR.decile : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.FIVEYEAR.length !== 0
                                                            ? category_compare_data.FIVEYEAR.decile : 'NA'
                                                    }}</td>
                                                </tr>
                                                <tr class="odd" id="cat_qur">
                                                    <td>Category Quartile</td>
                                                    <td>{{ category_compare_data.SEVENDAYS.length !== 0
                                                            ? category_compare_data.SEVENDAYS.quartile : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.THIRTYDAYS.length !== 0
                                                            ? category_compare_data.THIRTYDAYS.quartile : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.NINTYDAYS.length !== 0
                                                            ? category_compare_data.NINTYDAYS.quartile : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.SIXMONTHS.length !== 0
                                                            ? category_compare_data.SIXMONTHS.quartile : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.ONEYEAR.length !== 0
                                                            ? category_compare_data.ONEYEAR.quartile : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.TWOYEAR.length !== 0
                                                            ? category_compare_data.TWOYEAR.quartile : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.THREEYEAR.length !== 0
                                                            ? category_compare_data.THREEYEAR.quartile : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.FIVEYEAR.length !== 0
                                                            ? category_compare_data.FIVEYEAR.quartile : 'NA'
                                                    }}</td>
                                                </tr>
                                            </template>
                                            <template
                                                v-if="Object.keys(scheme_high_low_data).length && ratio_type == 'to_benchmark'">
                                                <tr>
                                                    <td>Scheme High</td>
                                                    <td>{{ scheme_high_low_data.SEVENDAYS.scheme_high }}</td>
                                                    <td>{{ scheme_high_low_data.THIRTYDAYS.scheme_high }}</td>
                                                    <td>{{ scheme_high_low_data.NINTYDAYS.scheme_high }}</td>
                                                    <td>{{ scheme_high_low_data.SIXMONTHS.scheme_high }}</td>
                                                    <td>{{ scheme_high_low_data.ONEYEAR.scheme_high }}</td>
                                                    <td>{{ scheme_high_low_data.TWOYEAR.scheme_high }}</td>
                                                    <td>{{ scheme_high_low_data.THREEYEAR.scheme_high }}</td>
                                                    <td>{{ scheme_high_low_data.FIVEYEAR.scheme_high }}</td>
                                                </tr>
                                                <tr class="odd">
                                                    <td>Scheme Low</td>
                                                    <td>{{ scheme_high_low_data.SEVENDAYS.scheme_low }}</td>
                                                    <td>{{ scheme_high_low_data.THIRTYDAYS.scheme_low }}</td>
                                                    <td>{{ scheme_high_low_data.NINTYDAYS.scheme_low }}</td>
                                                    <td>{{ scheme_high_low_data.SIXMONTHS.scheme_low }}</td>
                                                    <td>{{ scheme_high_low_data.ONEYEAR.scheme_low }}</td>
                                                    <td>{{ scheme_high_low_data.TWOYEAR.scheme_low }}</td>
                                                    <td>{{ scheme_high_low_data.THREEYEAR.scheme_low }}</td>
                                                    <td>{{ scheme_high_low_data.FIVEYEAR.scheme_low }}</td>
                                                </tr>
                                            </template>
                                            <template
                                                v-if="Object.keys(benchmark_high_low_data).length && ratio_type == 'to_benchmark'">
                                                <tr>
                                                    <td>Benchmark High</td>
                                                    <td>{{ benchmark_high_low_data.SEVENDAYS.benchmark_high }}</td>
                                                    <td>{{ benchmark_high_low_data.THIRTYDAYS.benchmark_high }}</td>
                                                    <td>{{ benchmark_high_low_data.NINTYDAYS.benchmark_high }}</td>
                                                    <td>{{ benchmark_high_low_data.SIXMONTHS.benchmark_high }}</td>
                                                    <td>{{ benchmark_high_low_data.ONEYEAR.benchmark_high }}</td>
                                                    <td>{{ benchmark_high_low_data.TWOYEAR.benchmark_high }}</td>
                                                    <td>{{ benchmark_high_low_data.THREEYEAR.benchmark_high }}</td>
                                                    <td>{{ benchmark_high_low_data.FIVEYEAR.benchmark_high }}</td>
                                                </tr>
                                                <tr class="odd">
                                                    <td>Benchmark Low</td>
                                                    <td>{{ benchmark_high_low_data.SEVENDAYS.benchmark_low }}</td>
                                                    <td>{{ benchmark_high_low_data.THIRTYDAYS.benchmark_low }}</td>
                                                    <td>{{ benchmark_high_low_data.NINTYDAYS.benchmark_low }}</td>
                                                    <td>{{ benchmark_high_low_data.SIXMONTHS.benchmark_low }}</td>
                                                    <td>{{ benchmark_high_low_data.ONEYEAR.benchmark_low }}</td>
                                                    <td>{{ benchmark_high_low_data.TWOYEAR.benchmark_low }}</td>
                                                    <td>{{ benchmark_high_low_data.THREEYEAR.benchmark_low }}</td>
                                                    <td>{{ benchmark_high_low_data.FIVEYEAR.benchmark_low }}</td>
                                                </tr>
                                            </template>
                                            <tr class="odd"
                                                v-if="Object.keys(jensenalpha_beta_volatility_data).length && ratio_type == 'to_benchmark'">
                                                <td>Scheme ALPHA</td>
                                                <td>{{ jensenalpha_beta_volatility_data.SEVENDAYS.length !== 0
                                                        ? jensenalpha_beta_volatility_data.SEVENDAYS.jensen_alpha.toFixed(2)
                                                        : 'NA'
                                                }}</td>
                                                <td>{{ jensenalpha_beta_volatility_data.THIRTYDAYS.length !== 0
                                                        ?
                                                        jensenalpha_beta_volatility_data.THIRTYDAYS.jensen_alpha.toFixed(2)
                                                        : 'NA'
                                                }}</td>
                                                <td>{{ jensenalpha_beta_volatility_data.NINTYDAYS.length !== 0
                                                        ? jensenalpha_beta_volatility_data.NINTYDAYS.jensen_alpha.toFixed(2)
                                                        : 'NA'
                                                }}</td>
                                                <td>{{ jensenalpha_beta_volatility_data.SIXMONTHS.length !== 0
                                                        ? jensenalpha_beta_volatility_data.SIXMONTHS.jensen_alpha.toFixed(2)
                                                        : 'NA'
                                                }}</td>
                                                <td>{{ jensenalpha_beta_volatility_data.ONEYEAR.length !== 0
                                                        ? jensenalpha_beta_volatility_data.ONEYEAR.jensen_alpha.toFixed(2) :
                                                        'NA'
                                                }}</td>
                                                <td>{{ jensenalpha_beta_volatility_data.TWOYEAR.length !== 0
                                                        ? jensenalpha_beta_volatility_data.TWOYEAR.jensen_alpha.toFixed(2) :
                                                        'NA'
                                                }}</td>
                                                <td>{{ jensenalpha_beta_volatility_data.THREEYEAR.length !== 0
                                                        ? jensenalpha_beta_volatility_data.THREEYEAR.jensen_alpha.toFixed(2)
                                                        : 'NA'
                                                }}</td>
                                                <td>{{ jensenalpha_beta_volatility_data.FIVEYEAR.length !== 0
                                                        ? jensenalpha_beta_volatility_data.FIVEYEAR.jensen_alpha.toFixed(2)
                                                        : 'NA'
                                                }}</td>
                                            </tr>
                                            <tr v-if="process">
                                                <td colspan="10">
                                                    <div class="text-center mt-3">
                                                        <LoadingBar :status="process"></LoadingBar>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-5 " v-show="ratio_type" style="width: 100%;">
                                    <div id="chartContainer" style="height: 360px; width: 100%;"></div>
                                    <div style="height:30px; width:70px; background:#ffffff; position:absolute; z-index:999; margin-top:-34px;"
                                        id="myplexusC"></div>
                                </div>
                            </div>
                        </div>
                        <!-- FUND PERFORMANCE RETURNS TAB END -->
                        <!-- FUND PERFORMANCE RETURNS RATIOS TAB START -->
                        <div class="tab-pane fade" id="pills-Ratio" role="tabpanel" aria-labelledby="pills-Ratio-tab">
                            <div class="datatable_ll performance_compare_top_table mt-4">
                                <h4>Scheme Name:</h4>
                                <div class="row">
                                    <div class="col-md-12 col-md-4">
                                        <multiselect :disabled="processRatios" class="" label="fund_name"
                                            track-by="fund_id" v-model="selectedFundRatios" tag-placeholder=""
                                            placeholder="Select Fund" :options="funds" :multiple="false"
                                            :taggable="false" selectLabel="" :searchable="true"
                                            :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150"
                                            :showNoResults="true">
                                        </multiselect>
                                    </div>
                                </div>
                            <div class="datatable_ll mt-3" v-if="Object.keys(fund_details_ratios).length">
                                <div class="table-responsive">
                                    <table id="example" class="" style="width:100%">
                                        <tbody>
                                            <tr>
                                                <td><b>NAV: {{ fund_details_ratios.nav }}</b></td>
                                                <td><b>NAV Date : {{ fund_details_ratios.nav_entry_date }}</b></td>
                                                <td><b>Category:{{ fund_details_ratios.no_of_schemes }}</b></td>
                                                <td><b>AAUM: (LAC) {{ fund_details_ratios.aaum }}</b></td>
                                            </tr>
                                            <tr>
                                                <td><b>Scheme Commencement Date:{{ fund_details_ratios.fund_opened
                                                }}</b></td>
                                                <td><b>Fund Manager: {{ fund_details_ratios.fund_man }}</b></td>
                                                <td><b>Schemes in Category (No.): {{ fund_details_ratios.no_of_schemes
                                                }}</b></td>
                                            </tr>
                                            <tr>
                                                <td><b>Benchmark: {{ fund_details_ratios.benchmark }}</b></td>
                                                <td><b>Benchmark Value: {{ fund_details_ratios.benchmark_closing_value
                                                }}</b></td>
                                                <td><b>Benchmark Date: {{ fund_details_ratios.benchmark_entry_date
                                                }}</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>
                            <div class="datatable_ll main_trer fund_performance_table" v-if="selectedFundRatios">
                                <div class="table-responsive">

                                    <table id="example" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <td class="dark_bg color_white text-center" colspan="3">Ratio as on
                                                    <span class="ratio-date"
                                                        v-if="Object.keys(jensenalpha_beta_volatility_ratios).length">{{
                                                                jensenalpha_beta_volatility_ratios.ONEYEAR.end_date
                                                        }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Scheme Name</th>
                                                <th>1 Year</th>
                                                <th>2 Year</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template v-if="Object.keys(jensenalpha_beta_volatility_ratios).length">
                                                <tr>
                                                    <td>Jensen Alpha</td>
                                                    <td>{{
                                                            Object.keys(jensenalpha_beta_volatility_ratios.ONEYEAR).length ?
                                                                jensenalpha_beta_volatility_ratios.ONEYEAR.jensen_alpha.toFixed(2)
                                                                : 'NA'
                                                    }}</td>
                                                    <td>{{
                                                            Object.keys(jensenalpha_beta_volatility_ratios.THREEYEAR).length
                                                                ?
                                                                jensenalpha_beta_volatility_ratios.THREEYEAR.jensen_alpha.toFixed(2)
                                                                : 'NA'
                                                    }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Beta</td>
                                                    <td>{{
                                                            Object.keys(jensenalpha_beta_volatility_ratios.ONEYEAR).length ?
                                                                jensenalpha_beta_volatility_ratios.ONEYEAR.beta.toFixed(2) :
                                                                'NA'
                                                    }}</td>
                                                    <td>{{
                                                            Object.keys(jensenalpha_beta_volatility_ratios.THREEYEAR).length
                                                                ? jensenalpha_beta_volatility_ratios.THREEYEAR.beta.toFixed(2) :
                                                                'NA'
                                                    }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Volatility</td>
                                                    <td>{{
                                                            Object.keys(jensenalpha_beta_volatility_ratios.ONEYEAR).length ?
                                                                jensenalpha_beta_volatility_ratios.ONEYEAR.volatality.toFixed(2)
                                                                : 'NA'
                                                    }}</td>
                                                    <td>{{
                                                            Object.keys(jensenalpha_beta_volatility_ratios.THREEYEAR).length
                                                                ?
                                                                jensenalpha_beta_volatility_ratios.THREEYEAR.volatality.toFixed(2)
                                                                : 'NA'
                                                    }}</td>
                                                </tr>
                                            </template>
                                            <tr v-else>
                                                <td colspan="10">
                                                    <div class="text-center mt-3">
                                                        <LoadingBar :status="processRatios"></LoadingBar>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="">
                                <div class="fund-perform-ratio-table br-5 full-table-style-3">
                                    <table id="fund-perform-ratio-data-2">

                                        <tbody>
                                            <template v-if="Object.keys(aaum_data).length">
                                                <tr v-if="Object.keys(aaum_data.last_aaum).length">
                                                    <td>AAUM as on {{ aaum_data.last_aaum.entry_date }}</td>
                                                    <td>{{ aaum_data.last_aaum.corpus_entry.toFixed(2) }}</td>
                                                </tr>
                                                <tr v-if="Object.keys(aaum_data.f_aaum).length">
                                                    <td>AAUM as on {{ aaum_data.f_aaum.entry_date }}</td>
                                                    <td>{{ aaum_data.f_aaum.corpus_entry.toFixed(2) }}</td>
                                                </tr>
                                                <tr v-if="Object.keys(aaum_data.s_aaum).length">
                                                    <td>AAUM as on {{ aaum_data.s_aaum.entry_date }}</td>
                                                    <td>{{ aaum_data.s_aaum.corpus_entry.toFixed(2) }}</td>
                                                </tr>
                                                <tr v-if="Object.keys(aaum_data.t_aaum).length">
                                                    <td>AAUM as on {{ aaum_data.t_aaum.entry_date }}</td>
                                                    <td>{{ aaum_data.t_aaum.corpus_entry.toFixed(2) }}</td>
                                                </tr>
                                            </template>
                                            <tr v-else>
                                                <td colspan="10">
                                                    <div class="text-center mt-3">
                                                        <LoadingBar :status="processRatios"></LoadingBar>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <!-- FUND PERFORMANCE RETURNS RATIOS TAB END -->

                        <!-- FUND PERFORMANCE RETURNS PORTFOLIOS TAB START -->
                        <div class="tab-pane fade" id="pills-Portfolio" role="tabpanel"
                            aria-labelledby="pills-Portfolio-tab">
                            <div class="datatable_ll performance_compare_top_table mt-4">
                                <h4>Scheme Name:</h4>
                                <div class="row">
                                    <div class="col-md-12 col-md-4">
                                        <multiselect :disabled="processPortfolios" class="" label="fund_name"
                                                track-by="fund_id" v-model="selectedFundPortFolios" tag-placeholder=""
                                                placeholder="Select Fund" :options="funds" :multiple="false"
                                                :taggable="false" selectLabel="" :searchable="true"
                                                :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150"
                                                :showNoResults="true">
                                            </multiselect>
                                    </div>
                                </div>
                            
                                <div class="table-responsive mt-3" v-if="Object.keys(fund_details_portfolios).length">
                                    <table id="example" class="" style="width:100%">
                                        <tbody>
                                            <tr>
                                                <td><b>NAV: {{ fund_details_portfolios.nav }}</b></td>
                                                <td><b>NAV Date : {{ fund_details_portfolios.nav_entry_date }}</b></td>
                                                <td><b>Category:{{ fund_details_portfolios.no_of_schemes }}</b></td>
                                                <td><b>AAUM: (LAC) {{ fund_details_portfolios.aaum }}</b></td>
                                            </tr>
                                            <tr>
                                                <td><b>Scheme Commencement Date:{{ fund_details_portfolios.fund_opened
                                                }}</b></td>
                                                <td><b>Fund Manager: {{ fund_details_portfolios.fund_man }}</b></td>
                                                <td><b>Schemes in Category (No.): {{
                                                        fund_details_portfolios.no_of_schemes
                                                }}</b></td>
                                            </tr>
                                            <tr>
                                                <td><b>Benchmark: {{ fund_details_portfolios.benchmark }}</b></td>
                                                <td><b>Benchmark Value: {{
                                                        fund_details_portfolios.benchmark_closing_value
                                                }}</b></td>
                                                <td><b>Benchmark Date: {{ fund_details_portfolios.benchmark_entry_date
                                                }}</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="datatable_ll main_trer fund_performance_table">
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <td class="dark_bg color_white text-center" colspan="9">Portfolio
                                                    Details as on <span class="ratio-date"
                                                        v-if="Object.keys(portfolio_data).length">{{
                                                                formatMonthYear(portfolio_data.monthinfo,
                                                                    portfolio_data.yearinfo)
                                                        }}</span></td>
                                            </tr>
                                            <tr>
                                                <th>No.of Scrips</th>
                                                <th>Wtd. PE </th>
                                                <th>Large Cap</th>
                                                <th>Very Large Cap</th>
                                                <th>Mid Cap</th>
                                                <th>Corp Debit</th>
                                                <th>Mid Cap</th>
                                                <th>SOV</th>
                                                <th>SOV</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template v-if="Object.keys(portfolio_data).length">
                                                <tr>
                                                    <td>{{ portfolio_data.no_of_scripts }}</td>
                                                    <td>{{ portfolio_data.wt_pe.toFixed(2) }}</td>
                                                    <td>{{ portfolio_data.eq_large.toFixed(2) }}</td>
                                                    <td>{{ portfolio_data.eq_very_large.toFixed(2) }}</td>
                                                    <td>{{ portfolio_data.eq_mid.toFixed(2) }}</td>
                                                    <td>{{ portfolio_data.eq_small.toFixed(2) }}</td>
                                                    <td>{{ portfolio_data.debt.toFixed(2) }}</td>
                                                    <td>{{ portfolio_data.sov.toFixed(2) }}</td>
                                                    <td>{{ portfolio_data.cash.toFixed(2) }}</td>
                                                </tr>
                                            </template>
                                            <tr v-else>
                                                <td colspan="10">
                                                    <div class="text-center mt-3">
                                                        <LoadingBar :status="processPortfolios"></LoadingBar>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="" v-if="selectedFundPortFolios">
                                    <div class="col-lg-12 col-md-12 col-sm-12  text-center">
                                        <a href="javascript://" class="money_title_btn " @click="getTopTenScripts">Top
                                            10 Scripts</a>&nbsp;&nbsp;
                                        <a href="javascript://" class="money_title_btn "
                                            @click="getTopIndustries(10)">Top 10 Industries</a>&nbsp;&nbsp;
                                        <a href="javascript://" class="money_title_btn "
                                            @click="getTopIndustries(100)">All Industries</a>&nbsp;&nbsp;
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- FUND PERFORMANCE RETURNS PORTFOLIOS TAB END -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div :class="modalClasses" class="fade" id="modal1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content fund-c-analysis">
                <div class="modal-header">
                    <h6 class="">Top 10 Scrips</h6>

                    <button type="button" class="close" @click="toggle();">&times;</button>
                </div>
                <div class="modal-body perform-paramtr c-snapchot-parent">
                    <div class="datatable_ll main_trer">
                        <div class="table-responsive br-5">
                            <a v-if="Object.keys(fund_details_portfolios).length" target="_blank"
                                class="mb-3 primary-button btn"
                                :href="`/fund-portfolio?fund_house=${fund_details_portfolios.fund_house}&fund_code=${fund_details_portfolios.fund_code}`">View
                                Complete Portfolio </a>
                            <table id="example" class="table table-striped">
                                <tr>
                                    <th style="width: 80% !important;">Scrips</th>
                                    <th style="min-width: 130px;">Content%</th>
                                </tr>
                                <tbody>
                                    <template v-if="Object.keys(portfolio_top_scripts).length">
                                        <tr v-for="script in portfolio_top_scripts" :key="script.scrip_name">
                                            <td class="modal-td">{{ script.scrip_name }}</td>
                                            <td>{{ script.content_per.toFixed(2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Of Top 10</td>
                                            <td class="grey">{{ portfolio_top_scripts_sum.toFixed(2) }}</td>
                                        </tr>
                                    </template>
                                    <tr v-else>
                                        <td colspan="10">
                                            <div class="text-center mt-3">
                                                <LoadingBar :status="true"></LoadingBar>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div :class="modalClasses1" class="fade" id="modal2" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content fund-c-analysis">
                <div class="modal-header">
                    <h6 class="" v-if="industry_modal == 'top_ten'">Top 10 Scrips</h6>
                    <h6 class="" v-if="industry_modal == 'all'">All Industries</h6>

                    <button type="button" class="close" @click="toggle1();">&times;</button>
                </div>
                <div class="modal-body perform-paramtr c-snapchot-parent">
                    <div class="datatable_ll main_trer">
                        <div class="table-responsive br-5">
                            <a v-if="Object.keys(fund_details_portfolios).length" target="_blank"
                                class="mb-3 primary-button btn"
                                :href="`/fund-portfolio?fund_house=${fund_details_portfolios.fund_house}&fund_code=${fund_details_portfolios.fund_code}`">View
                                Complete Portfolio </a>
                            <table id="example" class="table table-striped">
                                <tr>
                                    <th style="width: 80% !important;">Industry</th>
                                    <th style="min-width: 130px;">Content%</th>
                                </tr>
                                <tbody>
                                    <template v-if="Object.keys(portfolio_top_industries).length">
                                        <tr v-for="industry in portfolio_top_industries" :key="industry.industry">
                                            <td class="modal-td">{{ industry.industry }}</td>
                                            <td>{{ industry.industry_content_per.toFixed(2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Of Top 10</td>
                                            <td class="grey">{{ portfolio_top_industries_sum.toFixed(2) }}</td>
                                        </tr>
                                    </template>
                                    <tr v-else>
                                        <td colspan="10">
                                            <div class="text-center mt-3">
                                                <LoadingBar :status="true"></LoadingBar>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css">

</style>

<script>
import CustomTable from './Common/CustomTable.vue'
import Multiselect from '@suadelabs/vue3-multiselect'
import mixin from '../mixin';
import LoadingBar from "./Common/loading";
import {
    mapGetters,
    mapActions
} from 'vuex'
import moment from 'moment';
import Vue3ChartJs from '@j-t-mcc/vue3-chartjs'
var CanvasJS = require('../canvasjs.min.js');
export default {
    components: {
        CustomTable,
        Multiselect,
        Vue3ChartJs,
        LoadingBar,
    },
    mixins: [mixin],
    data() {
        return {
            currentTab: 'returns',
            selectedFundReturns: '',
            fund_details: [],
            return_scheme: [],
            category_compare_data: [],
            scheme_sip_data: [],
            scheme_high_low_data: [],
            benchmark_high_low_data: [],
            jensenalpha_beta_volatility_data: [],
            benchmark_sip_data: [],
            return_benchmark: [],
            nav_graph_data: [],
            process: false,
            pprocess: false,
            ratio_type: '',
            selectedNavDays: 365,
            graphProcess: false,
            chart: null,
            selectedFundRatios: '',
            processRatios: false,
            fund_details_ratios: [],
            jensenalpha_beta_volatility_ratios: [],
            aaum_data: [],
            selectedFundPortFolios: '',
            processPortfolios: false,
            fund_details_portfolios: [],
            portfolio_data: [],
            portfolio_top_scripts: [],
            portfolio_top_scripts_sum: '',
            portfolio_top_industries: [],
            portfolio_top_industries_sum: '',
            industry_modal: '',
            modalClasses: ['modal', 'fade'],
            modalClasses1: ['modal', 'fade'],
            app_url: process.env.MIX_APP_ENV == 'local' ? process.env.MIX_API_URL_LOCAL : '',
        }
    },
    methods: {
        getTopTenScripts() {
            let that = this
            if (!Object.keys(that.portfolio_top_scripts).length) {
                that.schemePortfolioTopTenScripts();
            }
            that.toggle();
        },
        getTopIndustries(top_rows) {
            console.log(top_rows);
            let that = this
            that.industry_modal = (top_rows == 10) ? 'top_ten' : 'all'
            that.schemePortfolioTopIndustries(top_rows);
            that.toggle1();
        },
        toggle() {

            let modalClasses = this.modalClasses

            if (modalClasses.indexOf('d-block') > -1) {
                document.body.className = ''
                modalClasses.pop()
                modalClasses.pop()

                //hide backdrop
                let backdrop = document.querySelector('.modal-backdrop')
                document.body.removeChild(backdrop)
            } else {
                document.body.className += ' modal-open'
                modalClasses.push('d-block')
                modalClasses.push('show')

                //show backdrop
                let backdrop = document.createElement('div')
                backdrop.classList = "modal-backdrop fade show"
                document.body.appendChild(backdrop)
            }
        },
        toggle1() {

            let modalClasses = this.modalClasses1

            if (modalClasses.indexOf('d-block') > -1) {
                document.body.className = ''
                modalClasses.pop()
                modalClasses.pop()

                //hide backdrop
                let backdrop = document.querySelector('.modal-backdrop')
                document.body.removeChild(backdrop)
            } else {
                document.body.className += ' modal-open'
                modalClasses.push('d-block')
                modalClasses.push('show')

                //show backdrop
                let backdrop = document.createElement('div')
                backdrop.classList = "modal-backdrop fade show"
                document.body.appendChild(backdrop)
            }
        },
        ...mapActions('InputData', ['getFundHouses', 'getFunds']),
        formatMonthYear(month, year) {
            var formattedMonth = moment().month(month).format('MMMM');
            return 'month of  ' + formattedMonth + ' , ' + year
        },
        async getFundDetails() {
            let that = this
            if (that.currentTab == 'returns') {
                that.process = true
                var fund_code = that.selectedFundReturns.fund_code
            } else if (that.currentTab == 'ratios') {
                that.processRatios = true
                var fund_code = that.selectedFundRatios.fund_code

            } else if (that.currentTab == 'portfolios') {
                that.processPortfolios = true
                that.pprocess = true
                var fund_code = that.selectedFundPortFolios.fund_code
            }

            await axios.get(this.app_url + '/api/v1/fund-details', {
                params: {
                    fund_code: fund_code
                }
            })
                .then(response => {
                    if (that.currentTab == 'returns') {
                        that.fund_details = response.data.data.fund_details
                    } else if (that.currentTab == 'ratios') {
                        that.fund_details_ratios = response.data.data.fund_details
                    } else if (that.currentTab == 'portfolios') {
                        that.fund_details_portfolios = response.data.data.fund_details
                    }
                })
                .catch(error => {
                    //var message = error.response.data.message || error.message
                    console.log(error);
                })
                .finally(() => {
                    if (that.currentTab == 'returns') {
                        that.process = false
                    } else if (that.currentTab == 'ratios') {
                        that.processRatios = false
                    } else if (that.currentTab == 'portfolios') {
                        that.processPortfolios = false
                    }
                })
        },
        async getFundRatios() {
            let that = this
            that.process = true
            console.log(that.chart.options.data[0]);
            if (!Object.keys(that.nav_graph_data).length) {
                await that.schemeNAV()
            }

            if (!Object.keys(that.return_scheme).length) {
                await that.schemeReturn()
            }
            if (!Object.keys(that.return_benchmark).length && that.ratio_type == 'to_benchmark') {
                await that.benchmarkReturn()
            }
            if (!Object.keys(that.category_compare_data).length && that.ratio_type == 'to_category') {
                await axios.get(this.app_url + '/api/v1/fund-performance-compare-category', {
                    params: {
                        fund_code: that.selectedFundReturns.fund_code
                    }
                })
                    .then(response => {
                        that.category_compare_data = response.data.data.category_compare_data
                    })
                    .catch(error => {
                        //var message = error.response.data.message || error.message
                        console.log(error);
                    })
                    .finally(() => {
                        // that.process = false
                    })
            }
            if (!Object.keys(that.scheme_high_low_data).length && that.ratio_type == 'to_benchmark') {
                await that.schemeHighLow()
            }
            if (!Object.keys(that.benchmark_high_low_data).length && that.ratio_type == 'to_benchmark') {
                await that.benchmarkHighLow()
            }
            if (!Object.keys(that.jensenalpha_beta_volatility_data).length && that.ratio_type == 'to_benchmark') {
                await that.schemeJensenalphaBetaVolatility()
            }
            if (!Object.keys(that.scheme_sip_data).length) {
                await that.schemeSIP()
            }
            if (!Object.keys(that.benchmark_sip_data).length) {
                await that.benchmarkSIP()
            }
            that.process = false
        },
        async schemeHighLow() {
            let that = this
            await axios.get(this.app_url + '/api/v1/fund-performance-scheme-high-low', {
                params: {
                    fund_code: that.selectedFundReturns.fund_code
                }
            })
                .then(response => {
                    that.scheme_high_low_data = response.data.data.scheme_high_low_data
                })
                .catch(error => {
                    //var message = error.response.data.message || error.message
                    console.log(error);
                })
                .finally(() => {
                    // that.process = false
                })
        },
        async benchmarkHighLow() {
            let that = this
            await axios.get(this.app_url + '/api/v1/fund-performance-benchmark-high-low', {
                params: {
                    fund_code: that.selectedFundReturns.fund_code
                }
            })
                .then(response => {
                    that.benchmark_high_low_data = response.data.data.benchmark_high_low_data
                })
                .catch(error => {
                    //var message = error.response.data.message || error.message
                    console.log(error);
                })
                .finally(() => {
                    // that.process = false
                })
        },
        async schemeJensenalphaBetaVolatility() {
            let that = this

            if (that.currentTab == 'returns') {
                var fund_code = that.selectedFundReturns.fund_code
            } else if (that.currentTab == 'ratios') {
                var fund_code = that.selectedFundRatios.fund_code
            }

            await axios.get(this.app_url + '/api/v1/fund-performance-jensenalpha-beta-volatility', {
                params: {
                    fund_code: fund_code
                }
            })
                .then(response => {
                    if (that.currentTab == 'returns' || (that.selectedFundReturns.fund_code && that.selectedFundReturns.fund_code == fund_code)) {
                        that.jensenalpha_beta_volatility_data = response.data.data.jensenalpha_beta_volatility_data
                    }
                    if (that.currentTab == 'ratios' || (that.selectedFundRatios.fund_code && that.selectedFundRatios.fund_code == fund_code)) {
                        that.jensenalpha_beta_volatility_ratios = response.data.data.jensenalpha_beta_volatility_data
                    }
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => { })
        },
        async schemeReturn() {
            let that = this
            await axios.get(this.app_url + '/api/v1/fund-return-scheme', {
                params: {
                    fund_code: that.selectedFundReturns.fund_code
                }
            })
                .then(response => {
                    that.return_scheme = response.data.data.return_scheme
                })
                .catch(error => {
                    //var message = error.response.data.message || error.message
                    console.log(error);
                })
                .finally(() => {
                    // that.process = false
                })
        },
        async benchmarkReturn() {
            let that = this
            await axios.get(this.app_url + '/api/v1/fund-return-benchmark', {
                params: {
                    fund_code: that.selectedFundReturns.fund_code
                }
            })
                .then(response => {
                    that.return_benchmark = response.data.data.return_benchmark
                })
                .catch(error => {
                    //var message = error.response.data.message || error.message
                    console.log(error);
                })
                .finally(() => {
                    // that.process = false
                })
        },
        async schemeNAV() {
            let that = this
            that.graphProcess = true
            that.dataPoints = []
            await axios.get(this.app_url + '/api/v1/fund-index-currency', {
                params: {
                    fund_code: that.selectedFundReturns.fund_code,
                    days: that.selectedNavDays
                }
            })
                .then(response => {
                    let nav_data = that.nav_graph_data = response.data.data.nav_data
                    that.chart.options.data[0].dataPoints = []
                    nav_data.forEach(function (item, index) {
                        that.chart.options.data[0].dataPoints.push({
                            y: item.VALUE,
                            label: item.DATE
                        });
                    });
                    that.chart.render();
                })
                .catch(error => {
                    //var message = error.response.data.message || error.message
                    console.log(error);
                })
                .finally(() => {
                    that.graphProcess = false
                })
        },
        async schemeSIP() {
            let that = this
            await axios.get(this.app_url + '/api/v1/fund-performance-scheme-sip', {
                params: {
                    fund_code: that.selectedFundReturns.fund_code
                }
            })
                .then(response => {
                    let sipDataArr = response.data.data.scheme_sip_data
                    for (var keyDur of Object.keys(sipDataArr)) {

                        let all_values = JSON.parse(sipDataArr[keyDur].ALLVALUES)
                        let all_dates = JSON.parse(sipDataArr[keyDur].ALLDATES)
                        let sip_return = that.calculate_sip(all_dates, all_values)
                        if (isNaN(sip_return)) {
                            sip_return = '';
                        } else {
                            sip_return = parseFloat(sip_return).toFixed(2);
                        }
                        sipDataArr[keyDur].sip_return = sip_return
                    }
                    that.scheme_sip_data = sipDataArr
                })
                .catch(error => {
                    //var message = error.response.data.message || error.message
                    console.log(error);
                })
                .finally(() => {
                    // that.process = false
                })
        },
        async benchmarkSIP() {
            let that = this
            await axios.get(this.app_url + '/api/v1/fund-performance-benchmark-sip', {
                params: {
                    fund_code: that.selectedFundReturns.fund_code
                }
            })
                .then(response => {
                    let sipDataArr = response.data.data.benchmark_sip_data
                    for (var keyDur of Object.keys(sipDataArr)) {

                        let all_values = JSON.parse(sipDataArr[keyDur].ALLVALUES)
                        let all_dates = JSON.parse(sipDataArr[keyDur].ALLDATES)
                        let sip_return = that.calculate_sip(all_dates, all_values)
                        if (isNaN(sip_return)) {
                            sip_return = '';
                        } else {
                            sip_return = parseFloat(sip_return).toFixed(2);
                        }
                        sipDataArr[keyDur].sip_return = sip_return
                    }
                    that.benchmark_sip_data = sipDataArr
                })
                .catch(error => {
                    //var message = error.response.data.message || error.message
                    console.log(error);
                })
                .finally(() => {
                    // that.process = false
                })
        },
        calculate_sip(dates, values) {
            let that = this
            //alert(dates+' '+values);
            var x = that.XIRR(values, dates, 0.1);
            //alert(x);
            x = x * 100;
            //document.write(x);
            return x;
        },
        XIRR(values, dates, guess) {
            // Credits: algorithm inspired by Apache OpenOffice

            // Calculates the resulting amount
            var irrResult = function (values, dates, rate) {
                var r = rate + 1;
                var result = values[0];
                for (var i = 1; i < values.length; i++) {
                    result += values[i] / Math.pow(r, moment(dates[i]).diff(moment(dates[0]), 'days') / 365);
                }
                return result;
            }

            // Calculates the first derivation
            var irrResultDeriv = function (values, dates, rate) {
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
        },
        toggleDataSeries(e) {
            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            } else {
                e.dataSeries.visible = true;
            }
            this.chart.render();
        },
        async schemeAAUM() {
            let that = this
            that.aaum_data = []
            await axios.get(this.app_url + '/api/v1/fund-performance-aaum', {
                params: {
                    fund_code: that.selectedFundRatios.fund_code
                }
            })
                .then(response => {
                    that.aaum_data = response.data.data.aaum_data
                })
                .catch(error => {
                    //var message = error.response.data.message || error.message
                    console.log(error);
                })
                .finally(() => {
                    // that.process = false
                })
        },
        async schemePortfolio() {
            let that = this
            that.portfolio_data = []
            that.processPortfolios = true
            await axios.get(this.app_url + '/api/v1/fund-portfolio-details', {
                params: {
                    fund_code: that.selectedFundPortFolios.fund_code
                }
            })
                .then(response => {
                    that.portfolio_data = response.data.data.portfolio_data
                    that.processPortfolios = false
                })
                .catch(error => {
                    //var message = error.response.data.message || error.message
                    console.log(error);
                })
                .finally(() => {
                    // that.process = false
                    that.processPortfolios = false
                })
        },
        async schemePortfolioTopTenScripts() {
            let that = this
            await axios.get(this.app_url + '/api/v1/fund-portfolio-top-scripts', {
                params: {
                    fund_code: that.selectedFundPortFolios.fund_code
                }
            })
                .then(response => {
                    that.portfolio_top_scripts = response.data.data.portfolio_top_scripts
                    that.portfolio_top_scripts_sum = response.data.data.portfolio_top_scripts_sum
                })
                .catch(error => {
                    //var message = error.response.data.message || error.message
                    console.log(error);
                })
                .finally(() => {
                    // that.process = false
                })
        },
        async schemePortfolioTopIndustries(top_rows = 10) {
            let that = this
            that.portfolio_top_industries = []
            that.portfolio_top_industries_sum = ''
            await axios.get(this.app_url + '/api/v1/fund-portfolio-top-industries', {
                params: {
                    fund_code: that.selectedFundPortFolios.fund_code,
                    top_rows: top_rows
                }
            })
                .then(response => {
                    that.portfolio_top_industries = response.data.data.portfolio_top_industries
                    that.portfolio_top_industries_sum = response.data.data.portfolio_top_industries_sum
                })
                .catch(error => {
                    //var message = error.response.data.message || error.message
                    console.log(error);
                })
                .finally(() => {
                    // that.process = false
                })
        },
    },
    watch: {
        selectedFundReturns(value) {
            if (value) {
                this.ratio_type = ''
                this.return_scheme = []
                this.category_compare_data = []
                this.scheme_sip_data = []
                this.dataPoints = []
                this.scheme_high_low_data = []
                this.benchmark_high_low_data = []
                this.jensenalpha_beta_volatility_data = []
                this.benchmark_sip_data = []
                this.return_benchmark = []
                this.getFundDetails()
            }
        },
        async selectedFundRatios(value) {
            let that = this
            if (value) {
                await that.getFundDetails()
                await that.schemeJensenalphaBetaVolatility()
                await that.schemeAAUM()
            }
        },
        async selectedFundPortFolios(value) {
            let that = this
            if (value) {
                that.portfolio_top_scripts = []
                await that.getFundDetails()
                await that.schemePortfolio()
            }
        },
        selectedNavDays(value) {
            this.schemeNAV()
        }
    },
    computed: {
        ...mapGetters('InputData', ['loading', 'fundHouses', 'funds']),
    },
    mounted() {
        let that = this
        let fund_code = that.getURLParams("fund_code")

        const myPromise = new Promise(async (resolve, reject) => {
            await this.getFunds({})
            resolve(true)
        });

        myPromise.then(async (resolve, reject) => {
            if (fund_code) {
                console.log(fund_code);
                that.selectedFundReturns = that.funds.filter(function (el) {
                    return el.fund_code == fund_code
                })[0]
                that.selectedFundPortFolios = that.funds.filter(function (el) {
                    return el.fund_code == fund_code
                })[0]
                that.selectedFundRatios = that.funds.filter(function (el) {
                    return el.fund_code == fund_code
                })[0]
            }
            return true
        })

        let chart = {
            colorSet: "greenShades",
            backgroundColor: "#fff  ",
            theme: "light2",
            animationEnabled: true,
            axisY: {
                includeZero: false,
                title: "Scheme",
                suffix: " "
            },
            toolTip: {
                shared: "true"
            },
            legend: {
                cursor: "pointer",
                itemclick: this.toggleDataSeries
            },
            title: {
                text: "Scheme NAV Chart"
            },
            data: [{
                type: "spline",
                showInLegend: true,
                yValueFormatString: "##.00",
                name: "NAV Value",
                dataPoints: this.dataPoints
            }]
        }
        CanvasJS.addColorSet("greenShades", ["#4661EE", "#EC5657", "#1BCDD1", "#8FAABB", "#B08BEB", "#3EA0DD", "#F5A52A", "#23BFAA", "#FAA586", "#EB8CC6"]);
        this.chart = new CanvasJS.Chart("chartContainer", chart);
        this.chart.render();

    },
}
</script>
<style >
.graph_radio input {
    width: auto;
    margin-left: 8px;
    margin-top: 10px;
}

.graph_radio label {
    color: #fff;
    cursor: pointer;
}

.modal-td {
    background-color: #f7f7fb !important;
    color: #000 !important;
}

.modal-td-dark {
    background-color: #00665e !important;
    color: #fff !important;
}
.multiselect__tags, .multiselect__single{
    background-color: #eaefec !important;
    border-radius: 7px;
    margin-bottom: 0;
}
</style>
