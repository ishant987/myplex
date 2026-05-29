<template>
    <!-- CALCULATOR TABS -->

    <section class="compare_scheme">
        <div class="container tab_snap_shot new-shot">

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

            <div class="comp_schem_bdr">
                <div class="tab_snap_shot">
                    
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
                                <div class="mt-3 bordr-only" v-if="Object.keys(fund_details).length">
									
									<div class="row">
										<div class="col-md-6 col-lg-4 mb-2"><b>NAV:</b> {{ fund_details.nav }}</div>
										<div class="col-md-6 col-lg-4 mb-2"><b>NAV Date: </b> {{ fund_details.nav_entry_date }}</div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Category:</b> {{ fund_details.category }}</div>
										<div class="col-md-6 col-lg-4 mb-2"><b>AAUM:</b> (LAC) {{ fund_details.aaum }}</div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Scheme Commencement Date:</b> {{ fund_details.fund_opened }}</div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Fund Manager:</b> {{ fund_details.fund_man }}</div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Schemes in Category (No.):</b> {{ fund_details.no_of_schemes }}</div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Benchmark:</b> {{ fund_details.benchmark }}</div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Benchmark Value:</b> {{ fund_details.benchmark_closing_value }}</div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Benchmark Date:</b> {{ fund_details.benchmark_entry_date }}</div>
									</div>																		
                                </div>
                                <div class="text-center mt-3">
                                    <LoadingBar :status="process"></LoadingBar>
                                </div>
                            </div>
                            <div class="datatable_ll main_trer fund_performance_table">
                                <div class="table-responsive">
                                    <div
                                        class="fund_per_heading d-block d-sm-flex align-items-center justify-content-between hding-vue">
                                        <h4>{{ heading }}</h4>
                                        <div class="new-bttn">
                                            <a href="javascript://" class="money_title_btn category_btn"
                                                @click="ratio_type = 'to_category'; getFundRatios()"
                                                :disabled="ratio_type == 'to_category' || process" >To Category</a>
                                            <a href="javascript://" class="money_title_btn"
                                                @click="ratio_type = 'to_benchmark'; getFundRatios()"
                                                :disabled="ratio_type == 'to_benchmark' || process">To Benchmark</a>
                                        </div>
                                    </div>

                                    <table id="example" class="table dataTable no-footer table-striped" style="width:100%"
                                        v-if="ratio_type">
                                        <thead>
                                            <tr>
                                                <td style="border-radius:7px" class="dark_bg color_white text-center" colspan="9">Performance
                                                    Compare To <span
                                                        v-if="ratio_type == 'to_category'">Category</span><span
                                                        v-if="ratio_type == 'to_benchmark'">Benchmark</span></td>
                                            </tr>
                                            <tr>
                                                <th class="sorting" style="width: 47% !important;" v-on:click="sortTable('benchmark')" :class="{'sorting_asc':sortKey == 'benchmark' && ascending, 'sorting_desc': sortKey == 'benchmark' && !ascending}">Return <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th>7 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th>30 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th>90 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th>180 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th>1 Year <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th>2 Year <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th>3 Year <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th>5 Year <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                            </tr>
                                        </thead>
                                        <tbody id="category_data">
                                            <tr v-if="Object.keys(return_scheme).length">
                                                <td>Scheme</td>
                                                <td>{{ return_scheme.SEVENDAYS.toFixed(2) != '9999.00' ? return_scheme.SEVENDAYS.toFixed(2) : 'NA'}}</td>
                                                <td>{{ return_scheme.THIRTYDAYS.toFixed(2) != '9999.00' ? return_scheme.THIRTYDAYS.toFixed(2) : 'NA'}}</td>
                                                <td>{{ return_scheme.NINTYDAYS.toFixed(2) != '9999.00' ? return_scheme.NINTYDAYS.toFixed(2) : 'NA'}}</td>
                                                <td>{{ return_scheme.SIXMONTHS.toFixed(2) != '9999.00' ? return_scheme.SIXMONTHS.toFixed(2) : 'NA'}}</td>
                                                <td>{{ return_scheme.ONEYEAR.toFixed(2) != '9999.00' ? return_scheme.ONEYEAR.toFixed(2) : 'NA'}}</td>
                                                <td>{{ return_scheme.TWOYEAR.toFixed(2) != '9999.00' ? return_scheme.TWOYEAR.toFixed(2) : 'NA'}}</td>
                                                <td>{{ return_scheme.THREEYEAR.toFixed(2) != '9999.00' ? return_scheme.THREEYEAR.toFixed(2) : 'NA'}}</td>
                                                <td>{{ return_scheme.FIVEYEAR.toFixed(2) != '9999.00' ? return_scheme.FIVEYEAR.toFixed(2) : 'NA'}}</td>
                                            </tr>
                                            <tr class="odd" v-if="Object.keys(scheme_sip_data).length">
                                                <td>Scheme SIP</td>
                                                <td>NA</td>
                                                <td>{{ scheme_sip_data.ONEMONTH.sip_return=='Infinity'? 'NA': scheme_sip_data.ONEMONTH.sip_return}}</td>
                                                <td>{{ scheme_sip_data.THREEMONTHS.sip_return=='Infinity'? 'NA':scheme_sip_data.THREEMONTHS.sip_return }}</td>
                                                <td>{{ scheme_sip_data.SIXMONTHS.sip_return=='Infinity'? 'NA': scheme_sip_data.SIXMONTHS.sip_return }}</td>
												<td>{{ scheme_sip_data.ONEYEAR.sip_return=='Infinity'? 'NA': scheme_sip_data.ONEYEAR.sip_return}}</td>
                                                <td>{{ scheme_sip_data.TWOYEAR.sip_return=='Infinity'? 'NA': scheme_sip_data.TWOYEAR.sip_return}}</td>
                                                <td>{{ scheme_sip_data.THREEYEAR.sip_return=='Infinity'? 'NA': scheme_sip_data.THREEYEAR.sip_return}}</td>
												<td>{{ scheme_sip_data.FIVEYEAR.sip_return=='Infinity'? 'NA': scheme_sip_data.FIVEYEAR.sip_return}}</td>
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
                                                    <td>{{ category_compare_data.SEVENDAYS.length !== 0 && Number(category_compare_data.SEVENDAYS.category_avg) !== 'NA'
                                                            ? category_compare_data.SEVENDAYS.category_avg.toFixed(2) : 'NA'
                                                    }}
                                                    </td>
                                                    <td>{{ category_compare_data.THIRTYDAYS.length !== 0 && Number(category_compare_data.THIRTYDAYS.category_avg) !== 'NA'
                                                            ? category_compare_data.THIRTYDAYS.category_avg.toFixed(2) :
                                                            'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.NINTYDAYS.length !== 0 && Number(category_compare_data.NINTYDAYS.category_avg) !== 'NA'
                                                            ? category_compare_data.NINTYDAYS.category_avg.toFixed(2) : 'NA'
                                                    }}
                                                    </td>
                                                    <td>{{ category_compare_data.SIXMONTHS.length !== 0 && Number(category_compare_data.SIXMONTHS.category_avg) !== 'NA'
                                                            ? category_compare_data.SIXMONTHS.category_avg.toFixed(2) : 'NA'
                                                    }}
                                                    </td>
                                                    <td>{{ category_compare_data.ONEYEAR.length !== 0 && Number(category_compare_data.ONEYEAR.category_avg) !== 'NA'
                                                            ? category_compare_data.ONEYEAR.category_avg.toFixed(2) : 'NA'
                                                    }}
                                                    </td>
                                                    <td>{{ category_compare_data.TWOYEAR.length !== 0 && Number(category_compare_data.TWOYEAR.category_avg) !== 'NA'
                                                            ? category_compare_data.TWOYEAR.category_avg.toFixed(2) : 'NA'
                                                    }}
                                                    </td>
                                                    <td>{{ category_compare_data.THREEYEAR.length !== 0 && Number(category_compare_data.THREEYEAR.category_avg) !== 'NA'
                                                            ? category_compare_data.THREEYEAR.category_avg.toFixed(2) : 'NA'
                                                    }}
                                                    </td>
                                                    <td>{{ category_compare_data.FIVEYEAR.length !== 0 && Number(category_compare_data.FIVEYEAR.category_avg) !== 'NA'
                                                            ? category_compare_data.FIVEYEAR.category_avg.toFixed(2) : 'NA'
                                                    }}
                                                    </td>
                                                </tr>
                                                
                                                    <tr class="odd">
                                                    <td>Category Median</td>
                                                    <td>{{ category_compare_data.SEVENDAYS.length !== 0 && Number(category_compare_data.SEVENDAYS.median) !== 'NA'
                                                            ? category_compare_data.SEVENDAYS.median.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.THIRTYDAYS.length !== 0 && Number(category_compare_data.THIRTYDAYS.median) !== 'NA'
                                                            ? category_compare_data.THIRTYDAYS.median.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.NINTYDAYS.length !== 0 && Number(category_compare_data.NINTYDAYS.median) !== 'NA'
                                                            ? category_compare_data.NINTYDAYS.median.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.SIXMONTHS.length !== 0 && Number(category_compare_data.SIXMONTHS.median) !== 'NA'
                                                            ? category_compare_data.SIXMONTHS.median.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.ONEYEAR.length !== 0 && Number(category_compare_data.ONEYEAR.median) !== 'NA'
                                                            ? category_compare_data.ONEYEAR.median.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.TWOYEAR.length !== 0 && Number(category_compare_data.TWOYEAR.median) !== 'NA'
                                                            ? category_compare_data.TWOYEAR.median.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.THREEYEAR.length !== 0 && Number(category_compare_data.THREEYEAR.median) !== 'NA'
                                                            ? category_compare_data.THREEYEAR.median.toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.FIVEYEAR.length !== 0 && Number(category_compare_data.FIVEYEAR.median) !== 'NA'
                                                            ? category_compare_data.FIVEYEAR.median.toFixed(2) : 'NA'
                                                    }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Category Leader</td>
                                                    <td>{{ category_compare_data.SEVENDAYS.length !== 0 && Number(category_compare_data.SEVENDAYS.leader) !== 'NA' 
                                                            ? Number(category_compare_data.SEVENDAYS.leader).toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.THIRTYDAYS.length !== 0 && Number(category_compare_data.THIRTYDAYS.leader) !== 'NA' 
                                                            ? Number(category_compare_data.THIRTYDAYS.leader).toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.NINTYDAYS.length !== 0 && Number(category_compare_data.NINTYDAYS.leader) !== 'NA' 
                                                            ? Number(category_compare_data.NINTYDAYS.leader).toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.SIXMONTHS.length !== 0 && Number(category_compare_data.SIXMONTHS.leader) !== 'NA' 
                                                            ? Number(category_compare_data.SIXMONTHS.leader).toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.ONEYEAR.length !== 0 && Number(category_compare_data.ONEYEAR.leader) !== 'NA' 
                                                            ? Number(category_compare_data.ONEYEAR.leader).toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.TWOYEAR.length !== 0 && Number(category_compare_data.TWOYEAR.leader) !== 'NA' 
                                                            ? Number(category_compare_data.TWOYEAR.leader).toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.THREEYEAR.length !== 0 && Number(category_compare_data.THREEYEAR.leader) !== 'NA' 
                                                            ? Number(category_compare_data.THREEYEAR.leader).toFixed(2) : 'NA'
                                                    }}</td>
                                                    <td>{{ category_compare_data.FIVEYEAR.length !== 0 && Number(category_compare_data.FIVEYEAR.leader) !== 'NA' 
                                                            ? Number(category_compare_data.FIVEYEAR.leader).toFixed(2) : 'NA'
                                                    }}</td>
                                                </tr>
                                                <!-- <tr class="odd">
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
                                                </tr>  -->
                                                <tr>
                                                <td>Category Laggard</td>
                                                <td>
                                                    {{
                                                    category_compare_data.SEVENDAYS.length !== 0 
                                                    ? (Number(category_compare_data.SEVENDAYS.laggard) !== 'NA' ? Number(category_compare_data.SEVENDAYS.laggard).toFixed(2) : 'NA')
                                                    : 'NA'
                                                    }}
                                                </td>
                                                <td>
                                                    {{
                                                    category_compare_data.THIRTYDAYS.length !== 0 
                                                    ? (Number(category_compare_data.THIRTYDAYS.laggard) !== 'NA' ? Number(category_compare_data.THIRTYDAYS.laggard).toFixed(2) : 'NA')
                                                    : 'NA'
                                                    }}
                                                </td>
                                                <td>
                                                    {{
                                                    category_compare_data.NINTYDAYS.length !== 0 
                                                    ? (Number(category_compare_data.NINTYDAYS.laggard) !== 'NA' ? Number(category_compare_data.NINTYDAYS.laggard).toFixed(2) : 'NA')
                                                    : 'NA'
                                                    }}
                                                </td>
                                                <td>
                                                    {{
                                                    category_compare_data.SIXMONTHS.length !== 0 
                                                    ? (Number(category_compare_data.SIXMONTHS.laggard) !== 'NA' ? Number(category_compare_data.SIXMONTHS.laggard).toFixed(2) : 'NA')
                                                    : 'NA'
                                                    }}
                                                </td>
                                                <td>
                                                    {{
                                                    category_compare_data.ONEYEAR.length !== 0 
                                                    ? (Number(category_compare_data.ONEYEAR.laggard) !== 'NA' ? Number(category_compare_data.ONEYEAR.laggard).toFixed(2) : 'NA')
                                                    : 'NA'
                                                    }}
                                                </td>
                                                <td>
                                                    {{
                                                    category_compare_data.TWOYEAR.length !== 0 
                                                    ? (Number(category_compare_data.TWOYEAR.laggard) !== 'NA' ? Number(category_compare_data.TWOYEAR.laggard).toFixed(2) : 'NA')
                                                    : 'NA'
                                                    }}
                                                </td>
                                                <td>
                                                    {{
                                                    category_compare_data.THREEYEAR.length !== 0 
                                                    ? (Number(category_compare_data.THREEYEAR.laggard) !== 'NA' ? Number(category_compare_data.THREEYEAR.laggard).toFixed(2) : 'NA')
                                                    : 'NA'
                                                    }}
                                                </td>
                                                <td>
                                                    {{
                                                    category_compare_data.FIVEYEAR.length !== 0 
                                                    ? (Number(category_compare_data.FIVEYEAR.laggard) !== 'NA' ? Number(category_compare_data.FIVEYEAR.laggard).toFixed(2) : 'NA')
                                                    : 'NA'
                                                    }}
                                                </td>
                                            </tr>

                                                <tr id="cat_dec">
                                                    <td>Category Decile</td>
                                                    <!--<td>{{ category_compare_data.SEVENDAYS.length !== 0
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
                                                    }}</td> -->
													<!-- <td> {{ category_declie[0] }}</td>
													<td> {{ category_declie[1] }}</td>
													<td> {{ category_declie[2] }}</td>
													<td> {{ category_declie[3] }}</td>
													<td> {{ category_declie[4] }}</td>
													<td> {{ category_declie[5] }}</td>
													<td> {{ category_declie[6] }}</td>
													<td> {{ category_declie[7] }}</td> -->

                                                    <td>
                                                        {{
                                                        category_compare_data.SEVENDAYS.length !== 0 
                                                        ? (category_compare_data.SEVENDAYS.decile !== 'NA' ? category_compare_data.SEVENDAYS.decile : 'NA')
                                                        : 'NA'
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                        category_compare_data.THIRTYDAYS.length !== 0 
                                                        ? (category_compare_data.THIRTYDAYS.decile !== 'NA' ? category_compare_data.THIRTYDAYS.decile : 'NA')
                                                        : 'NA'
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                        category_compare_data.NINTYDAYS.length !== 0 
                                                        ? (category_compare_data.NINTYDAYS.decile !== 'NA' ? category_compare_data.NINTYDAYS.decile : 'NA')
                                                        : 'NA'
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                        category_compare_data.SIXMONTHS.length !== 0 
                                                        ? (category_compare_data.SIXMONTHS.decile !== 'NA' ? category_compare_data.SIXMONTHS.decile : 'NA')
                                                        : 'NA'
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                        category_compare_data.ONEYEAR.length !== 0 
                                                        ? (category_compare_data.ONEYEAR.decile !== 'NA' ? category_compare_data.ONEYEAR.decile : 'NA')
                                                        : 'NA'
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                        category_compare_data.TWOYEAR.length !== 0 
                                                        ? (category_compare_data.TWOYEAR.decile !== 'NA' ? category_compare_data.TWOYEAR.decile : 'NA')
                                                        : 'NA'
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                        category_compare_data.THREEYEAR.length !== 0 
                                                        ? (category_compare_data.THREEYEAR.decile !== 'NA' ? category_compare_data.THREEYEAR.decile : 'NA')
                                                        : 'NA'
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                        category_compare_data.FIVEYEAR.length !== 0 
                                                        ? (category_compare_data.FIVEYEAR.decile !== 'NA' ? category_compare_data.FIVEYEAR.decile : 'NA')
                                                        : 'NA'
                                                        }}
                                                    </td>

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
													
													<!-- <td> {{ category_quartile[0] }}</td>
													<td> {{ category_quartile[1] }}</td>
													<td> {{ category_quartile[2] }}</td>
													<td> {{ category_quartile[3] }}</td>
													<td> {{ category_quartile[4] }}</td>
													<td> {{ category_quartile[5] }}</td>
													<td> {{ category_quartile[6] }}</td>
													<td> {{ category_quartile[7] }}</td> -->
													
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
                                                <td> {{ getAlpha(scheme_years_values[0], index_years_values[0]) != 0 ? Number(getAlpha(scheme_years_values[0], index_years_values[0])).toFixed(2) : 0 }} </td>

                                                <td> {{ getAlpha(scheme_years_values[1], index_years_values[1]) != 0 ? Number(getAlpha(scheme_years_values[1], index_years_values[1])).toFixed(2) : 0 }} </td>

                                                <td> {{ getAlpha(scheme_years_values[2], index_years_values[2]) != 0 ? Number(getAlpha(scheme_years_values[2], index_years_values[2])).toFixed(2) : 0 }} </td>

                                                <td> {{ getAlpha(scheme_years_values[3], index_years_values[3]) != 0 ? Number(getAlpha(scheme_years_values[3], index_years_values[3])).toFixed(2) : 0 }} </td>

                                                <td> {{ getAlpha(scheme_years_values[4], index_years_values[4]) != 0 ? Number(getAlpha(scheme_years_values[4], index_years_values[4])).toFixed(2) : 0 }} </td>

                                                <td> {{ getAlpha(scheme_years_values[5], index_years_values[5]) != 0 ? Number(getAlpha(scheme_years_values[5], index_years_values[5])).toFixed(2) : 0 }} </td>

                                                <td> {{ getAlpha(scheme_years_values[6], index_years_values[6]) != 0 ? Number(getAlpha(scheme_years_values[6], index_years_values[6])).toFixed(2) : 0 }} </td>

                                                <td> {{ getAlpha(scheme_years_values[7], index_years_values[7]) != 0 ? Number(getAlpha(scheme_years_values[7], index_years_values[7])).toFixed(2) : 0 }} </td>
                                                <!-- <td>{{ jensenalpha_beta_volatility_data.SEVENDAYS.length !== 0
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
                                                }}</td> -->
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
                                <div class="">
									
									<div class="row">
										<div class="col-md-6 col-lg-4 mb-2"><b>NAV: {{ fund_details_ratios.nav }}</b></div>
										<div class="col-md-6 col-lg-4 mb-2"><b>NAV Date : {{ fund_details_ratios.nav_entry_date }}</b></div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Category:{{ fund_details_ratios.category }}</b></div>
										<div class="col-md-6 col-lg-4 mb-2"><b>AAUM: (LAC) {{ fund_details_ratios.aaum }}</b></div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Scheme Commencement Date:{{ fund_details_ratios.fund_opened
                                                }}</b></div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Fund Manager: {{ fund_details_ratios.fund_man }}</b></div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Schemes in Category (No.): {{ fund_details_ratios.no_of_schemes
                                                }}</b></div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Benchmark: {{ fund_details_ratios.benchmark }}</b></div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Benchmark Value: {{ fund_details_ratios.benchmark_closing_value
                                                }}</b></div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Benchmark Date: {{ fund_details_ratios.benchmark_entry_date
                                                }}</b></div>										
									</div>
                                </div>
                            </div>
                            </div>
                            <div class="datatable_ll main_trer fund_performance_table" v-if="selectedFundRatios">
                                <div class="table-responsive">

                                    <table id="example" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <td style="border-radius:7px" class="dark_bg color_white text-center" colspan="3">Ratio as on
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
                                            <template v-if="processRatios !== true && Object.keys(jensenalpha_beta_volatility_ratios).length">
                                                <tr>
                                                    <td>Jensen Alpha</td>
                                                    <td>{{
                                                            Object.keys(jensenalpha_beta_volatility_ratios.ONEYEAR).length ?
                                                                jensenalpha_beta_volatility_ratios.ONEYEAR.jensen_alpha.toFixed(3)
                                                                : 'NA'
                                                    }}</td>
                                                    <td>{{
                                                            Object.keys(jensenalpha_beta_volatility_ratios.TWOYEAR).length
                                                                ?
                                                                jensenalpha_beta_volatility_ratios.TWOYEAR.jensen_alpha.toFixed(3)
                                                                : 'NA'
                                                    }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Beta</td>
                                                    <td>{{
                                                            Object.keys(jensenalpha_beta_volatility_ratios.ONEYEAR).length ?
                                                                jensenalpha_beta_volatility_ratios.ONEYEAR.beta.toFixed(3) :
                                                                'NA'
                                                    }}</td>
                                                    <td>{{
                                                            Object.keys(jensenalpha_beta_volatility_ratios.TWOYEAR).length
                                                                ? jensenalpha_beta_volatility_ratios.TWOYEAR.beta.toFixed(3) :
                                                                'NA'
                                                    }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Volatility</td>
                                                    <td>{{
                                                            Object.keys(jensenalpha_beta_volatility_ratios.ONEYEAR).length ?
                                                                jensenalpha_beta_volatility_ratios.ONEYEAR.volatality.toFixed(3)
                                                                : 'NA'
                                                    }}</td>
                                                    <td>{{
                                                            Object.keys(jensenalpha_beta_volatility_ratios.TWOYEAR).length
                                                                ?
                                                                jensenalpha_beta_volatility_ratios.TWOYEAR.volatality.toFixed(3)
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
                                    <table id="fund-perform-ratio-data-2" class="table table-striped" style="width:100%">
                                        <th v-if="Object.keys(aaum_data).length && Object.keys(aaum_data.last_aaum).length">
                                            AAUM {{ aaum_data.last_aaum.entry_date }} (in Crores)
                                        </th>

                                        <th v-if="Object.keys(aaum_data).length && Object.keys(aaum_data.f_aaum).length">
                                            AAUM {{ aaum_data.f_aaum.entry_date }} (in Crores)
                                        </th>

                                        <th v-if="Object.keys(aaum_data).length && Object.keys(aaum_data.s_aaum).length">
                                            AAUM {{ aaum_data.s_aaum.entry_date }} (in Crores)
                                        </th>

                                        <th v-if="Object.keys(aaum_data).length && Object.keys(aaum_data.t_aaum).length">
                                            AAUM {{ aaum_data.t_aaum.entry_date }} (in Crores)
                                        </th>

                                        <tbody>
                                            <template v-if="Object.keys(aaum_data).length">
                                                <tr>                                                    
                                                    <td v-if="Object.keys(aaum_data.last_aaum).length">
                                                        {{ (aaum_data.last_aaum.corpus_entry / 100).toFixed(2) }}
                                                    </td>
                                                    <td v-if="Object.keys(aaum_data.f_aaum).length">
                                                        {{ (aaum_data.f_aaum.corpus_entry / 100).toFixed(2) }}
                                                    </td>
                                                    <td v-if="Object.keys(aaum_data.s_aaum).length">
                                                       {{ (aaum_data.s_aaum.corpus_entry / 100).toFixed(2) }}
                                                    </td>
                                                    <td v-if="Object.keys(aaum_data.t_aaum).length">
                                                        {{ (aaum_data.t_aaum.corpus_entry / 100).toFixed(2) }}
                                                    </td>
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
                            
                                <div class="mt-3" v-if="Object.keys(fund_details_portfolios).length">
									
									<div class="row">
										<div class="col-md-6 col-lg-4 mb-2"><b>NAV: {{ fund_details_portfolios.nav }}</b></div>
										<div class="col-md-6 col-lg-4 mb-2"><b>NAV Date : {{ fund_details_portfolios.nav_entry_date }}</b></div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Category:{{ fund_details_portfolios.category }}</b></div>
										<div class="col-md-6 col-lg-4 mb-2"><b>AAUM: (LAC) {{ fund_details_portfolios.aaum }}</b></div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Scheme Commencement Date:{{ fund_details_portfolios.fund_opened
                                                }}</b></div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Fund Manager: {{ fund_details_portfolios.fund_man }}</b></div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Schemes in Category (No.): {{
                                                        fund_details_portfolios.no_of_schemes
                                                }}</b></div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Benchmark: {{ fund_details_portfolios.benchmark }}</b></div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Benchmark Value: {{
                                                        fund_details_portfolios.benchmark_closing_value
                                                }}</b></div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Benchmark Date: {{ fund_details_portfolios.benchmark_entry_date
                                                }}</b></div>
									</div>
                                </div>
                            </div>
                            <div class="datatable_ll main_trer fund_performance_table">
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <td style="border-radius:7px" class="dark_bg color_white text-center" colspan="9">Portfolio
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
                                                <th>Small Cap</th>
                                                <th>Corp Debit</th>
                                                <th>SOV</th>
                                                <th>Cash</th>
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
                                            10 Scrips</a>&nbsp;&nbsp;
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
                    <h6 class="" v-if="industry_modal == 'top_ten'">Top 10 Industries</h6>
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
			category_declie: [],
			category_quartile: [],
			scheme_years_values: [],
            index_years_values: [],
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
			heading: '',
            modalClasses: ['modal', 'fade'],
            modalClasses1: ['modal', 'fade'],
            app_url: process.env.MIX_APP_ENV == 'local' ? process.env.MIX_API_URL_LOCAL : 'https://www.myplexus.com',
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
            if(month == 0){
                var month = 12;
            }
            var monthNumber = parseInt(month) - 1;
            var formattedMonth = moment().month(monthNumber).format('MMMM');
            return 'month of  ' + formattedMonth + ' , ' + year
        },
        async getFundDetails() {
            // alert('getFundDetails');
            let that = this
			console.log('Selected Fund');
            console.log(that.selectedFundReturns);
            

            if (that.currentTab == 'returns') {
                that.process = true
                var fund_code = that.selectedFundReturns.fund_code
                let data = {
                fund_code:that.selectedFundReturns.fund_code
                }
                Object.keys(data).forEach(key => {
                    that.addParamToURL(key, data[key])
                });

                that.selectedFundReturns = that.funds.filter(function (el) {
                    return el.fund_code == fund_code
                })[0]
                that.selectedFundPortFolios = that.funds.filter(function (el) {
                    return el.fund_code == fund_code
                })[0]
                that.selectedFundRatios = that.funds.filter(function (el) {
                    return el.fund_code == fund_code
                })[0]
            } else if (that.currentTab == 'ratios') {
                that.processRatios = true
                var fund_code = that.selectedFundRatios.fund_code
                let data = {
                fund_code:that.selectedFundReturns.fund_code
                }
                Object.keys(data).forEach(key => {
                    that.addParamToURL(key, data[key])
                });

                that.selectedFundReturns = that.funds.filter(function (el) {
                    return el.fund_code == fund_code
                })[0]
                that.selectedFundPortFolios = that.funds.filter(function (el) {
                    return el.fund_code == fund_code
                })[0]
                that.selectedFundRatios = that.funds.filter(function (el) {
                    return el.fund_code == fund_code
                })[0]
            } else if (that.currentTab == 'portfolios') {
                that.processPortfolios = true
                that.process = true
                var fund_code = that.selectedFundPortFolios.fund_code
                let data = {
                fund_code:that.selectedFundReturns.fund_code
                }
                Object.keys(data).forEach(key => {
                    that.addParamToURL(key, data[key])
                });

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

            await axios.get(this.app_url + '/api/v1/fund-details', {
                params: {
                    fund_code: fund_code
                }
            })
                .then(response => {
                    if (that.currentTab == 'returns') {
                        console.log('Fund Details below');
                        console.log(response.data.data.fund_details);
                        that.fund_details = response.data.data.fund_details
                    } else if (that.currentTab == 'ratios') {                        
                        that.fund_details_ratios = response.data.data.fund_details;
                    } else if (that.currentTab == 'portfolios') {
                        console.log('Portfolio dATA : ', response.data.data.fund_details);
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
                this.getFundRatios();
        },
        async getFundRatios() {
        // console.log('reached');
            let that = this
            that.process = true
            // alert(that.ratio_type)
            if(that.ratio_type === ''){
                // alert('blank ratio type');
                that.ratio_type = 'to_category';
            }
			// that.ratio_type = 'to_category'
			if( that.ratio_type == 'to_category' )
			{
				that.heading = 'Scheme Performance, '+that.selectedFundReturns.fund_name+' - Category as on '+that.fund_details.nav_entry_date;
				//console.log(that.selectedFundReturns.fund_name);
			}
			
			if( that.ratio_type == 'to_benchmark' )
			{
				that.heading = 'Scheme Performance, '+that.selectedFundReturns.fund_name+' - Benchmark as on '+that.fund_details.benchmark_entry_date;
				//console.log(that.selectedFundReturns.fund_name);
			}
			
			
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
					
						console.log('Category Compare Data : ',that.category_compare_data);
					
						that.category_declie = [];
                        that.category_quartile = [];	
					
						console.log(Number(that.category_compare_data.SEVENDAYS.laggard));
						console.log(Number(that.category_compare_data.SEVENDAYS.leader) != "");
					
						if(Number(that.category_compare_data.SEVENDAYS.laggard) !== "" && Number(that.category_compare_data.SEVENDAYS.leader) !== "")
						{
							const { SEVENDAYS: {laggard: sevendays_laggard, leader: sevendays_leader} } = that.category_compare_data;
							that.addLaggardLeder(sevendays_laggard, sevendays_leader, 'sevendays');							
						} else {
							console.log('New Laggard :', that.category_compare_data.SEVENDAYS.laggard);						
							console.log('New Leader :', that.category_compare_data.SEVENDAYS.leader);
							that.addLaggardLeder('NA', 'NA', 'sevendays');
						}
					
						if(Number(that.category_compare_data.THIRTYDAYS.laggard) !== "" && Number(that.category_compare_data.THIRTYDAYS.leader) !== "")
						{
							const { THIRTYDAYS: {laggard: thirtydays_laggard, leader: thirtydays_leader} } = that.category_compare_data;
							that.addLaggardLeder(thirtydays_laggard, thirtydays_leader, 'thirtydays');							
						} else {
							that.addLaggardLeder('NA', 'NA', 'thirtydays');
						}
					
						if(Number(that.category_compare_data.NINTYDAYS.laggard) !== "" && Number(that.category_compare_data.NINTYDAYS.leader) !== "")
						{
							const { NINTYDAYS: {laggard: nintydays_laggard, leader: nintydays_leader} } = that.category_compare_data;
							that.addLaggardLeder(nintydays_laggard, nintydays_leader, 'nintydays');							
						} else {
							that.addLaggardLeder('NA', 'NA', 'nintydays');
						}
					
						if(Number(that.category_compare_data.SIXMONTHS.laggard) !== "" && Number(that.category_compare_data.SIXMONTHS.leader) !== "")
						{
							const { SIXMONTHS: {laggard: sixmonths_laggard, leader: sixmonths_leader} } = that.category_compare_data;
							that.addLaggardLeder(sixmonths_laggard, sixmonths_leader, 'sixmonths');							
						} else {
							that.addLaggardLeder('NA', 'NA', 'sixmonths');
						}
					
						if(Number(that.category_compare_data.ONEYEAR.laggard) !== "" && Number(that.category_compare_data.ONEYEAR.leader) !== "")
						{
							const { ONEYEAR: {laggard: oneyear_laggard, leader: oneyear_leader} } = that.category_compare_data;
							that.addLaggardLeder(oneyear_laggard, oneyear_leader, 'oneyear');							
						} else {
							that.addLaggardLeder('NA', 'NA', 'oneyear');
						}
					
						if(Number(that.category_compare_data.TWOYEAR.laggard) !== "" && Number(that.category_compare_data.TWOYEAR.leader) !== "")
						{
							const { TWOYEAR: {laggard: twoyears_laggard, leader: twoyears_leader} } = that.category_compare_data;
							that.addLaggardLeder(twoyears_laggard, twoyears_leader, 'twoyears');							
						} else {
							that.addLaggardLeder('NA', 'NA', 'twoyears');
						}
					
						if(Number(that.category_compare_data.THREEYEAR.laggard) !== "" && Number(that.category_compare_data.THREEYEAR.leader) !== "")
						{
							const { THREEYEAR: {laggard: threeyears_laggard, leader: threeyears_leader} } = that.category_compare_data;
							that.addLaggardLeder(threeyears_laggard, threeyears_leader, 'threeyears');							
						} else {
							that.addLaggardLeder('NA', 'NA', 'threeyears');
						}
					
						if(Number(that.category_compare_data.FIVEYEAR.laggard) !== "" && Number(that.category_compare_data.FIVEYEAR.leader) !== "")
						{
							const { FIVEYEAR: {laggard: fiveears_laggard, leader: fiveears_leader} } = that.category_compare_data;
							that.addLaggardLeder(fiveears_laggard, fiveears_leader, 'fiveyears');							
						} else {
							that.addLaggardLeder('NA', 'NA', 'fiveyears');
						}					
						
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
		
		addLaggardLeder(laggard, leader, no_of_days) {		
			
			let arr = [];				
			
			
			if( laggard == 0 && leader == 0 )
			{				
				this.category_declie.push(0);
				this.category_quartile.push(0);
				
			} else if( laggard == 'NA' || leader == 'NA' ) {

                this.category_declie.push('NA');
				this.category_quartile.push('NA');

            } else {
				
				const class_gap = Number((Number(leader).toFixed(2)-Number(laggard).toFixed(2))/10).toFixed(3);
				const quartile_class_gap = Number((Number(leader).toFixed(2)-Number(laggard).toFixed(2))/4).toFixed(3);               		
							
				if(no_of_days == 'sevendays')
				{									
					this.category_declie.push(this.getDecileNum(class_gap, laggard, leader, this.scheme_years_values[0].toFixed(2)));
					this.category_quartile.push(this.getQuartileNum(quartile_class_gap, laggard, leader, this.scheme_years_values[0].toFixed(2)));
				}
				
				if(no_of_days == 'thirtydays')
				{
					console.log("=======================30 days===================");
					this.category_declie.push(this.getDecileNum(class_gap, laggard, leader, this.scheme_years_values[1].toFixed(2)));
					this.category_quartile.push(this.getQuartileNum(quartile_class_gap, laggard, leader, this.scheme_years_values[1].toFixed(2)));
					console.log("=======================30 days===================");
				}
				
				if(no_of_days == 'nintydays')
				{
					this.category_declie.push(this.getDecileNum(class_gap, laggard, leader, this.scheme_years_values[2].toFixed(2)));
					this.category_quartile.push(this.getQuartileNum(quartile_class_gap, laggard, leader, this.scheme_years_values[2].toFixed(2)));
				}
				
				if(no_of_days == 'sixmonths')
				{
					this.category_declie.push(this.getDecileNum(class_gap, laggard, leader, this.scheme_years_values[3].toFixed(2)));
					this.category_quartile.push(this.getQuartileNum(quartile_class_gap, laggard, leader, this.scheme_years_values[3].toFixed(2)));
				}
				
				if(no_of_days == 'oneyear')
				{
					this.category_declie.push(this.getDecileNum(class_gap, laggard, leader, this.scheme_years_values[4].toFixed(2)));		
					this.category_quartile.push(this.getQuartileNum(quartile_class_gap, laggard, leader, this.scheme_years_values[4].toFixed(2)));
					
				}
				
				if(no_of_days == 'twoyears')
				{
					this.category_declie.push(this.getDecileNum(class_gap, laggard, leader, this.scheme_years_values[5].toFixed(2)));
					
					this.category_quartile.push(this.getQuartileNum(quartile_class_gap, laggard, leader, this.scheme_years_values[5].toFixed(2)));
					
				}
				
				if(no_of_days == 'threeyears')
				{
					this.category_declie.push(this.getDecileNum(class_gap, laggard, leader, this.scheme_years_values[6].toFixed(2)));
					this.category_quartile.push(this.getQuartileNum(quartile_class_gap, laggard, leader, this.scheme_years_values[6].toFixed(2)));
				}
				
				if(no_of_days == 'fiveyears')
				{
					this.category_declie.push(this.getDecileNum(class_gap, laggard, leader, this.scheme_years_values[7].toFixed(2)));
                    //console.log("=======================Five Year===================");
					this.category_quartile.push(this.getQuartileNum(quartile_class_gap, laggard, leader, this.scheme_years_values[7].toFixed(2)));
                    //console.log("=======================Five Year===================");
				}
				
				//console.log('Arr: ');
				//console.log(this.category_declie);
				
			}
			
		},
		
		getQuartileNum(class_gap, laggard, leader, scheme_value)
		{		
			let first_value = leader.toFixed(2);
			let second_value = (first_value - class_gap).toFixed(3);
			let third_value = 0;
			let num_val = 0;
			
			if(scheme_value == 0)
			{
				return 0;
			}
			
			if( Number(second_value) <= Number(scheme_value) && Number(scheme_value) <= Number(first_value) )
			{
				num_val = 1;
			
			} else {
				
				for(let i=2; i<=4; i++)
				{
					third_value = second_value;
					first_value = third_value;
					second_value = (first_value - class_gap).toFixed(3);
					third_value=0;  
                    
                    console.log('Quartile Inside First Value: '+Number(first_value)+' Quartile Second Value: '+Number(second_value));
					
					if( Number(second_value) <= Number(scheme_value) && Number(scheme_value) <= Number(first_value) )
					{						
						num_val = i;
					}				
					
				}			
			}
			
			return num_val;
		},
		
		getDecileNum(class_gap, laggard, leader, scheme_value)
		{
			//console.log('Original Decile First Value: '+Number(leader)+' Original Decile Second Value: '+Number(leader - class_gap)+' scheme value: '+scheme_value);
			
			let first_value = leader.toFixed(2);
			let second_value = (first_value - class_gap).toFixed(3);
			let third_value = 0;
			let num_val = 0;
			
			//console.log('Decile First Value: '+Number(first_value)+' Decile Second Value: '+Number(second_value)+' scheme value: '+scheme_value);
			
			if(scheme_value == 0)
			{
				return 0;
			}
			
			if( Number(second_value) <= Number(scheme_value) && Number(scheme_value) <= Number(first_value) )
			{
				num_val = 1;
			
			} else {
				
				for(let i=2; i<=10; i++)
				{
					third_value = second_value;
					first_value = third_value;
					second_value = (first_value - class_gap).toFixed(3);
					third_value=0;
					
					//console.log('Decile Inside First Value: '+Number(first_value)+' Decile Second Value: '+Number(second_value));
					
					if( Number(second_value) <= Number(scheme_value) && Number(scheme_value) <= Number(first_value) )
					{
						num_val = i;
					}				
					
				}			
			}
			
			return num_val;
		},

        getAlpha(scReturn, IndReturn) {

            console.log('Scheme Return: '+scReturn+' Index Return: '+IndReturn);
            const alphaRtn = Number(scReturn).toFixed(2) - Number(IndReturn).toFixed(2);
            console.log('Alpha Return: '+alphaRtn);
            return alphaRtn;
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

            await axios.get(this.app_url + '/api/v1/fund-performance-jensenalpha-beta-volatility-oneandtwoyear', {
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
					console.log(response.data.data.return_scheme);
					const {SEVENDAYS: sevendays, THIRTYDAYS: thirtydays, NINTYDAYS: threemonths, SIXMONTHS: sixmonths, ONEYEAR: oneyear, TWOYEAR: twoyears, THREEYEAR: threeyears, FIVEYEAR: fiveyears} = response.data.data.return_scheme;
				//console.log(sevendays, thirtydays, threemonths, sixmonths, oneyear, twoyears, threeyears, fiveyears);
				that.scheme_years_values = [sevendays, thirtydays, threemonths, sixmonths, oneyear, twoyears, threeyears, fiveyears];
				console.log(that.scheme_years_values);
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
                    const {SEVENDAYS: sevendays, THIRTYDAYS: thirtydays, NINTYDAYS: threemonths, SIXMONTHS: sixmonths, ONEYEAR: oneyear, TWOYEAR: twoyears, THREEYEAR: threeyears, FIVEYEAR: fiveyears} = response.data.data.return_benchmark;
				//console.log(sevendays, thirtydays, threemonths, sixmonths, oneyear, twoyears, threeyears, fiveyears);
				that.index_years_values = [sevendays, thirtydays, threemonths, sixmonths, oneyear, twoyears, threeyears, fiveyears];
				console.log(that.index_years_values);
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
            // alert(this.app_url);
            await axios.get(this.app_url + '/api/v1/fund-performance-scheme-sip', {
                params: {
                    fund_code: that.selectedFundReturns.fund_code
                }
            })
                .then(response => {
					
					console.log('Response : ',response);
                    let sipDataArr = response.data.data.scheme_sip_data
                    console.log('SIP_DATA_ARRAY',sipDataArr);
                    for (var keyDur of Object.keys(sipDataArr)) {
						
						if(sipDataArr[keyDur] != "")
						{
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
						else {
							
							
							sipDataArr[keyDur].sip_return = 'NA';
						
						}

                        
                    }
					console.log('SIPDATA: ',sipDataArr);
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
                    console.log('Benchmark sip data');
                    console.log(sipDataArr);
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
			//console.log('All Values: ', values);
			//console.log('All Dates: ', dates);			
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
				//console.log(result);
                // alert(result);
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
			
			console.log(resultRate);
			
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
				this.heading = ''
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
        

        // const button = document.querySelector('.category_btn');
        // if (button) {
            // button.click();
            // const ratioType = button.getAttribute('data-ratio-type'); // Assuming you store ratio type as a data attribute
            // this.setRatioTypeAndFetchData(ratioType);
        // }

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
