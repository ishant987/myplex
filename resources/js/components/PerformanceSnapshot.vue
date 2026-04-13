<template>
<!-- <div class="custom-banner no-bg fw-banner" :class="{'monthly-ranking':!page_image}" :style="(page_image)?{ 'background-image': 'url('+page_image+')'}:{}">
    <div class="container">
        <div class="banner-align-lft fw-title">
            <h1 class="f-b" v-html="banner_title" v-if="banner_title"></h1>
            <h3 v-if="page_description" class="f-sb text-green" v-html="page_description"></h3>
        </div>
        <div class="banner-align-rgt fw-downlaod-btn mt-0" v-if="weekly_snapshot_data.length || monthly_snapshot_data.length">
            <a href="javascript:void(0)" class="btn-bg-3 br-5 f-b pdf-dwnld" @click="downloadPDF">
            Download PDF 
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
            </svg>
            </a>
        </div>
        <div class="clear"></div>
    </div>
</div> -->
<section class="info_monitor_sec">
    <div class="compare-scemes-sec investing-tools perform-snapshot-tabs select2-styles">
        <div class="container tab_snap_shot new-shot scnd-shot">

            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <!-- <li  class="nav-item" role="presentation"><a class="nav-link" :class="{'active show':currentTab == 'weekly'}" data-toggle="tab" href="#tab-weekly" @click="currentTab = 'weekly'">Weekly</a></li> -->
                <li class="nav-item" role="presentation">
                <a 
                    class="nav-link" 
                    :class="{ 'active show': currentTab === 'weekly' }" 
                    data-toggle="tab" 
                    @click="switchTab('weekly')" 
                    :href="generateURL('weekly')"
                >
                    Weekly
                </a>
                </li>
                <li class="nav-item" role="presentation">
                <a 
                    class="nav-link" 
                    :class="{ 'active show': currentTab === 'monthly' }" 
                    data-toggle="tab" 
                    @click="switchTab('monthly')" 
                    :href="generateURL('monthly')"
                >
                    Monthly
                </a>
                </li>
            </ul>

            <div class="comp_schem_bdr">
                <div class="tab_snap_shot">
                    
                    <div class="tab-wrapper">
                
                        <div class="tab-content">

                            <!-- PERFORMANCE SNAPSHOT WEEKLY TAB START -->

                            <div id="tab-weekly" class="tab-pane fade in" :class="{'active show':currentTab == 'weekly'}">
                                <form action="#" method="get">
                                    <div class="invst-wrap wrp-new">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-12">
                                                <Datepicker placeholder="As On Date" class="custom-input readonly-datepicker" v-model="selectedDateWeekly" :format="'dd/MM/yyyy'" :enableTimePicker="false" :autoApply="true" :range="false" :maxDate="maxDateRang"></Datepicker>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-12">
                                                <multiselect 
                                                :disabled="loading || process"
                                                class=""
                                                label="name" 
                                                track-by="ft_id"
                                                v-model="selectedFundClassificationWeekly" 
                                                tag-placeholder=""
                                                placeholder="Select Fund Classification" 
                                                :options="fundClassifications" 
                                                :multiple="false" 
                                                :taggable="false" 
                                                selectLabel=""
                                                :searchable="true"
                                                :block-keys="['Tab', 'Enter', 'backspace']"
                                                :max-height="150"
                                                :showNoResults="true"
                                                >
                                                </multiselect>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-12">
                                                <select v-model="selectedCategoryWeekly" id="ps-weekly-return" class="custom-input">
                                                    <option value="">Report Category</option>
                                                    <option value="return">Return %</option>
                                                    <option value="indices">Indices</option>
                                                    <option value="return_less_index">Return Less Index </option>
                                                </select>
                                            </div>

                                            <div class="col-3 text-center px-0">
                                                <button type="button" class="perform-submit money_title_btn btn" @click="getWeeklySnapshot" :disabled="!selectedDateWeekly || !selectedFundClassificationWeekly || !selectedCategoryWeekly || processWeekly">Submit</button>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <!-- <div class="perform-snapshot-submit">
                                        <div class="col-12 text-right px-0">
                                            <button type="button" class="perform-submit money_title_btn btn" @click="getWeeklySnapshot" :disabled="!selectedDateWeekly || !selectedFundClassificationWeekly || !selectedCategoryWeekly || processWeekly">Submit</button>
                                        </div>
                                    </div> -->
                                </form>

                                <div class="perform-snapshot-points mt-2 bordr-only prfrm-snapst" v-if="weekly_snapshot_data.length">
                                    <ul>
                                        <li><p>Term of Fund : <span>Long Term</span></p></li>
                                        <li><p>Type of Fund : <span>{{ selectedFundClassificationWeekly.name }}</span></p></li>
                                        <li><p>for the Week Ended As On : <span><strong>{{ formattedDate(selectedDateWeekly) }}</strong></span></p></li>
                                    </ul>
                                </div>

                                <div class="datatable_ll main_trer fund_performance_table perform-snapshot-table full-table-style-2 custom-sort-table main-trer-wrapper">
                                    <table id="performance-weekly" class="display w-100 dataTable">
                                        <thead>
                                            <tr>
                                                <th class="sorting" v-on:click="sortTableW('fund_name')" :class="{'sorting_asc':sortKey == 'fund_name' && ascending, 'sorting_desc': sortKey == 'fund_name' && !ascending}" v-if="dataCategoryWeekly != 'indices'">Fund Name <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th class="sorting" v-on:click="sortTableW('indices_name')" :class="{'sorting_asc':sortKey == 'indices_name' && ascending, 'sorting_desc': sortKey == 'indices_name' && !ascending}" v-if="dataCategoryWeekly == 'indices' || dataCategoryWeekly == 'return'">Index Name <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th class="sorting" v-if="dataCategoryWeekly == 'return'" v-on:click="sortTableW('5DAYS')" :class="{'sorting_asc':sortKey == '5DAYS' && ascending, 'sorting_desc': sortKey == '5DAYS' && !ascending}">Daily <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th class="sorting" v-on:click="sortTableW('7DAYS')" :class="{'sorting_asc':sortKey == '7DAYS' && ascending, 'sorting_desc': sortKey == '7DAYS' && !ascending}">7 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th class="sorting" v-on:click="sortTableW('14DAYS')" :class="{'sorting_asc':sortKey == '14DAYS' && ascending, 'sorting_desc': sortKey == '14DAYS' && !ascending}">14 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th class="sorting" v-on:click="sortTableW('30DAYS')" :class="{'sorting_asc':sortKey == '30DAYS' && ascending, 'sorting_desc': sortKey == '30DAYS' && !ascending}">30 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th class="sorting" v-on:click="sortTableW('60DAYS')" :class="{'sorting_asc':sortKey == '60DAYS' && ascending, 'sorting_desc': sortKey == '60DAYS' && !ascending}">60 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(data,index) in weekly_snapshot_data" :key="index">
                                                <td v-if="dataCategoryWeekly != 'indices'"><a class="text-white" :href="`/fund-performance?fund_code=${encodeURIComponent(data.fund_code)}`" target="_blank">{{ data.fund_name }}</a></td>
                                                <td v-if="dataCategoryWeekly == 'indices' || dataCategoryWeekly == 'return'">{{ data.indices_name }}</td>
                                                <td v-if="dataCategoryWeekly == 'return' && data['5DAYS'] != null">
													{{ Number(data['5DAYS'].toFixed(3)).toFixed(2) }}
													</td>
												<!--<td v-else>0.00</td> -->
                                                <td v-if="data['14DAYS'] != null">{{ Number(data['7DAYS'].toFixed(3)).toFixed(2) }}</td>
												<td v-else>0.00</td>
                                                <td v-if="data['14DAYS'] != null">{{ Number(data['14DAYS'].toFixed(3)).toFixed(2) }}</td>
												<td v-else>0.00</td>
                                                <td v-if="data['30DAYS'] != null">{{ Number(data['30DAYS'].toFixed(3)).toFixed(2) }}</td>
												<td v-else>0.00</td>
                                                <td v-if="data['60DAYS'] != null">{{ Number(data['60DAYS'].toFixed(3)).toFixed(2) }}</td>
												<td v-else>0.00</td>
                                            </tr>
                                            <tr v-if="processWeekly">
                                                <td class="top_th text-center" colspan="6" rowspan="1">
                                                    <svg style="width:50px" version="1.1" id="L1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                                                        <circle fill="none" stroke="#fff" stroke-width="6" stroke-miterlimit="15" stroke-dasharray="14.2472,14.2472" cx="50" cy="50" r="47" >
                                                            <animateTransform 
                                                                attributeName="transform" 
                                                                attributeType="XML" 
                                                                type="rotate"
                                                                dur="5s" 
                                                                from="0 50 50"
                                                                to="360 50 50" 
                                                                repeatCount="indefinite" />
                                                        </circle>
                                                        <circle fill="none" stroke="#fff" stroke-width="1" stroke-miterlimit="10" stroke-dasharray="10,10" cx="50" cy="50" r="39">
                                                            <animateTransform 
                                                                attributeName="transform" 
                                                                attributeType="XML" 
                                                                type="rotate"
                                                                dur="5s" 
                                                                from="0 50 50"
                                                                to="-360 50 50" 
                                                                repeatCount="indefinite" />
                                                        </circle>
                                                        <g fill="#fff">
                                                        <rect x="30" y="35" width="5" height="30">
                                                            <animateTransform 
                                                            attributeName="transform" 
                                                            dur="1s" 
                                                            type="translate" 
                                                            values="0 5 ; 0 -5; 0 5" 
                                                            repeatCount="indefinite" 
                                                            begin="0.1"/>
                                                        </rect>
                                                        <rect x="40" y="35" width="5" height="30" >
                                                            <animateTransform 
                                                            attributeName="transform" 
                                                            dur="1s" 
                                                            type="translate" 
                                                            values="0 5 ; 0 -5; 0 5" 
                                                            repeatCount="indefinite" 
                                                            begin="0.2"/>
                                                        </rect>
                                                        <rect x="50" y="35" width="5" height="30" >
                                                            <animateTransform 
                                                            attributeName="transform" 
                                                            dur="1s" 
                                                            type="translate" 
                                                            values="0 5 ; 0 -5; 0 5" 
                                                            repeatCount="indefinite" 
                                                            begin="0.3"/>
                                                        </rect>
                                                        <rect x="60" y="35" width="5" height="30" >
                                                            <animateTransform 
                                                            attributeName="transform" 
                                                            dur="1s" 
                                                            type="translate" 
                                                            values="0 5 ; 0 -5; 0 5"  
                                                            repeatCount="indefinite" 
                                                            begin="0.4"/>
                                                        </rect>
                                                        <rect x="70" y="35" width="5" height="30" >
                                                            <animateTransform 
                                                            attributeName="transform" 
                                                            dur="1s" 
                                                            type="translate" 
                                                            values="0 5 ; 0 -5; 0 5" 
                                                            repeatCount="indefinite" 
                                                            begin="0.5"/>
                                                        </rect>
                                                        </g>
                                                        </svg>      

                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <!-- PERFORMANCE SNAPSHOT WEEKLY TAB END -->

                            <!-- PERFORMANCE SNAPSHOT MONTHLY TAB START -->

                            <div id="tab-monthly" class="tab-pane fade" :class="{'active show':currentTab == 'monthly'}">
                                <form action="#" method="get">
                                    <div class="invst-wrap">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-12">
                                                <Datepicker placeholder="As On Date" class="custom-input readonly-datepicker" v-model="selectedDateMonthly" :format="'dd/MM/yyyy'" :enableTimePicker="false" :autoApply="true" :range="false" :maxDate="maxDateRang"></Datepicker>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-12">
                                                <multiselect 
                                                :disabled="loading || process"
                                                class=""
                                                label="name" 
                                                track-by="ft_id"
                                                v-model="selectedFundClassificationMonthly" 
                                                tag-placeholder=""
                                                placeholder="Select Fund Classification" 
                                                :options="fundClassifications" 
                                                :multiple="false" 
                                                :taggable="false" 
                                                selectLabel=""
                                                :searchable="true"
                                                :block-keys="['Tab', 'Enter', 'backspace']"
                                                :max-height="150"
                                                :showNoResults="true"
                                                >
                                                </multiselect>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-12">
                                                <select v-model="selectedCategoryMonthly" id="ps-monthly-return" class="custom-input">
                                                    <option value="">Report Category</option>
                                                    <option value="return">Return %</option>
                                                    <option value="indices">Indices</option>
                                                    <option value="return_less_index">Return Less Index </option>
                                                    <option value="corpus_change">Corpus Changes</option>
                                                </select>
                                            </div>

                                            <div class="col-3 text-center px-0">
                                                <button type="button" class="perform-submit money_title_btn btn" @click="getMonthlySnapshot" :disabled="!selectedDateMonthly || !selectedFundClassificationMonthly || !selectedCategoryMonthly || processMonthly">Submit</button>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- <div class="perform-snapshot-submit">
                                        <div class="col-12 text-right px-0">
                                            <button type="button" class="perform-submit money_title_btn btn" @click="getMonthlySnapshot" :disabled="!selectedDateMonthly || !selectedFundClassificationMonthly || !selectedCategoryMonthly || processMonthly">Submit</button>
                                        </div>
                                    </div> -->
                                </form>

                                <div class="perform-snapshot-points mt-2 bordr-only prfrm-snapst" v-if="monthly_snapshot_data.length">
                                    <ul>
                                        <li><p>Term of Fund : <span>Long Term</span></p></li>
                                        <li><p>Type of Fund : <span>{{ selectedFundClassificationMonthly.name }}</span></p></li>
                                        <li><p>As On : <span><strong>{{ this.aaum_date ? formattedDate(this.aaum_date): formattedDate(selectedDateMonthly) }}</strong></span></p></li>
                                    </ul>
                                </div>

                                <div class="datatable_ll main_trer fund_performance_table perform-snapshot-table full-table-style-2 custom-sort-table main-trer-wrapper">
                                    <table id="performance-monthly" class="display w-100 dataTable" v-if="dataCategoryMonthly == 'indices' || dataCategoryMonthly == 'return' || dataCategoryMonthly == 'return_less_index'">
                                        <thead>
                                            <tr>
                                                <th class="sorting" v-on:click="sortTableM('fund_name')" :class="{'sorting_asc':sortKeyM == 'fund_name' && ascendingM, 'sorting_desc': sortKeyM == 'fund_name' && !ascendingM}" v-if="dataCategoryMonthly != 'indices'">Fund Name <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th class="sorting" v-on:click="sortTableM('indices_name')" :class="{'sorting_asc':sortKeyM == 'indices_name' && ascendingM, 'sorting_desc': sortKeyM == 'indices_name' && !ascendingM}" v-if="dataCategoryMonthly == 'indices' || dataCategoryMonthly == 'return'">Index Name <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th class="sorting" v-on:click="sortTableM('sixmonths')" :class="{'sorting_asc':sortKeyM == 'sixmonths' && ascendingM, 'sorting_desc': sortKeyM == 'sixmonths' && !ascendingM}">Six Months <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th class="sorting" v-on:click="sortTableM('oneyear')" :class="{'sorting_asc':sortKeyM == 'oneyear' && ascendingM, 'sorting_desc': sortKeyM == 'oneyear' && !ascendingM}">One Year <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th class="sorting" v-on:click="sortTableM('twoyear')" :class="{'sorting_asc':sortKeyM == 'twoyear' && ascendingM, 'sorting_desc': sortKeyM == 'twoyear' && !ascendingM}">Two Year <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th class="sorting" v-on:click="sortTableM('threeyear')" :class="{'sorting_asc':sortKeyM == 'threeyear' && ascendingM, 'sorting_desc': sortKeyM == 'threeyear' && !ascendingM}">Three Year <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(data,index) in monthly_snapshot_data" :key="index">
                                                <td v-if="dataCategoryMonthly != 'indices'"><a class="text-white" :href="`/fund-performance?fund_code=${encodeURIComponent(data.fund_code)}`" target="_blank">{{ data.fund_name }}</a></td>
                                                <td v-if="dataCategoryMonthly == 'indices' || dataCategoryMonthly == 'return'">{{ data.indices_name }}</td>
                                                <!-- <td>{{ Number(data['sixmonths'].toFixed(3)).toFixed(2) }}</td>
                                                <td>{{ Number(data['oneyear'].toFixed(3)).toFixed(2) }}</td>
                                                <td>{{ Number(data['twoyear'].toFixed(3)).toFixed(2) }}</td>
                                                <td>{{ Number(data['threeyear'].toFixed(3)).toFixed(2) }}</td> -->

                                                <td>{{ Number(data['sixmonths']) != 0 ? Number(data['sixmonths'].toFixed(3)).toFixed(2) : 0 }}</td>
                                                <td>{{ Number(data['oneyear']) != 0 ? Number(data['oneyear'].toFixed(3)).toFixed(2) : 0 }}</td>
                                                <td>{{ Number(data['twoyear']) != 0 ? Number(data['twoyear'].toFixed(3)).toFixed(2) : 0 }}</td>
                                                <td>{{ Number(data['threeyear']) != 0 ? Number(data['threeyear'].toFixed(3)).toFixed(2) : 0 }}</td>
                                            </tr>
                                            <tr v-if="processMonthly">
                                                <td class="top_th text-center" colspan="6" rowspan="1">
                                                    <svg style="width:50px" version="1.1" id="L1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                                                        <circle fill="none" stroke="#fff" stroke-width="6" stroke-miterlimit="15" stroke-dasharray="14.2472,14.2472" cx="50" cy="50" r="47" >
                                                            <animateTransform 
                                                                attributeName="transform" 
                                                                attributeType="XML" 
                                                                type="rotate"
                                                                dur="5s" 
                                                                from="0 50 50"
                                                                to="360 50 50" 
                                                                repeatCount="indefinite" />
                                                        </circle>
                                                        <circle fill="none" stroke="#fff" stroke-width="1" stroke-miterlimit="10" stroke-dasharray="10,10" cx="50" cy="50" r="39">
                                                            <animateTransform 
                                                                attributeName="transform" 
                                                                attributeType="XML" 
                                                                type="rotate"
                                                                dur="5s" 
                                                                from="0 50 50"
                                                                to="-360 50 50" 
                                                                repeatCount="indefinite" />
                                                        </circle>
                                                        <g fill="#fff">
                                                        <rect x="30" y="35" width="5" height="30">
                                                            <animateTransform 
                                                            attributeName="transform" 
                                                            dur="1s" 
                                                            type="translate" 
                                                            values="0 5 ; 0 -5; 0 5" 
                                                            repeatCount="indefinite" 
                                                            begin="0.1"/>
                                                        </rect>
                                                        <rect x="40" y="35" width="5" height="30" >
                                                            <animateTransform 
                                                            attributeName="transform" 
                                                            dur="1s" 
                                                            type="translate" 
                                                            values="0 5 ; 0 -5; 0 5" 
                                                            repeatCount="indefinite" 
                                                            begin="0.2"/>
                                                        </rect>
                                                        <rect x="50" y="35" width="5" height="30" >
                                                            <animateTransform 
                                                            attributeName="transform" 
                                                            dur="1s" 
                                                            type="translate" 
                                                            values="0 5 ; 0 -5; 0 5" 
                                                            repeatCount="indefinite" 
                                                            begin="0.3"/>
                                                        </rect>
                                                        <rect x="60" y="35" width="5" height="30" >
                                                            <animateTransform 
                                                            attributeName="transform" 
                                                            dur="1s" 
                                                            type="translate" 
                                                            values="0 5 ; 0 -5; 0 5"  
                                                            repeatCount="indefinite" 
                                                            begin="0.4"/>
                                                        </rect>
                                                        <rect x="70" y="35" width="5" height="30" >
                                                            <animateTransform 
                                                            attributeName="transform" 
                                                            dur="1s" 
                                                            type="translate" 
                                                            values="0 5 ; 0 -5; 0 5" 
                                                            repeatCount="indefinite" 
                                                            begin="0.5"/>
                                                        </rect>
                                                        </g>
                                                        </svg>      

                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                    <table id="performance-monthly" class="display w-100 dataTable" v-if="dataCategoryMonthly == 'corpus_change'">
                                        <thead>
                                            <tr>
                                                <th class="sorting" v-on:click="sortTableC('fund_name')" :class="{'sorting_asc':sortKeyC == 'fund_name' && ascendingC, 'sorting_desc': sortKeyC == 'fund_name' && !ascendingC}" >Fund Name <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th class="sorting" v-on:click="sortTableC('corpus_entry')" :class="{'sorting_asc':sortKeyC == 'corpus_entry' && ascendingC, 'sorting_desc': sortKeyC == 'corpus_entry' && !ascendingC}" >Current Amount (Rs.in Crores) <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th class="sorting" v-on:click="sortTableC('corpus_change')" :class="{'sorting_asc':sortKeyC == 'corpus_change' && ascendingC, 'sorting_desc': sortKeyC == 'corpus_change' && !ascendingC}">Change Amount (Rs.in Crores) <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span> </th>
                                                <th class="sorting" v-on:click="sortTableC('percentage_change')" :class="{'sorting_asc':sortKeyC == 'percentage_change' && ascendingC, 'sorting_desc': sortKeyC == 'percentage_change' && !ascendingC}">(%) Change <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(data,index) in monthly_snapshot_data" :key="index">
                                                <td ><a class="text-white" :href="`/fund-performance?fund_code=${encodeURIComponent(data.fund_code)}`" target="_blank">{{ data.fund_name }}</a></td>
                                                <td>{{ (data['corpus_entry'] / 100).toFixed(2) }}</td>
                                                <td>{{ (data['corpus_change'] / 100).toFixed(2) }}</td>
                                                <td>{{ data['percentage_change'].toFixed(2) }}</td>
                                            </tr>
                                            <tr v-if="processMonthly">
                                                <td class="top_th text-center" colspan="4" rowspan="1">
                                                    <svg style="width:50px" version="1.1" id="L1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                                                        <circle fill="none" stroke="#fff" stroke-width="6" stroke-miterlimit="15" stroke-dasharray="14.2472,14.2472" cx="50" cy="50" r="47" >
                                                            <animateTransform 
                                                                attributeName="transform" 
                                                                attributeType="XML" 
                                                                type="rotate"
                                                                dur="5s" 
                                                                from="0 50 50"
                                                                to="360 50 50" 
                                                                repeatCount="indefinite" />
                                                        </circle>
                                                        <circle fill="none" stroke="#fff" stroke-width="1" stroke-miterlimit="10" stroke-dasharray="10,10" cx="50" cy="50" r="39">
                                                            <animateTransform 
                                                                attributeName="transform" 
                                                                attributeType="XML" 
                                                                type="rotate"
                                                                dur="5s" 
                                                                from="0 50 50"
                                                                to="-360 50 50" 
                                                                repeatCount="indefinite" />
                                                        </circle>
                                                        <g fill="#fff">
                                                        <rect x="30" y="35" width="5" height="30">
                                                            <animateTransform 
                                                            attributeName="transform" 
                                                            dur="1s" 
                                                            type="translate" 
                                                            values="0 5 ; 0 -5; 0 5" 
                                                            repeatCount="indefinite" 
                                                            begin="0.1"/>
                                                        </rect>
                                                        <rect x="40" y="35" width="5" height="30" >
                                                            <animateTransform 
                                                            attributeName="transform" 
                                                            dur="1s" 
                                                            type="translate" 
                                                            values="0 5 ; 0 -5; 0 5" 
                                                            repeatCount="indefinite" 
                                                            begin="0.2"/>
                                                        </rect>
                                                        <rect x="50" y="35" width="5" height="30" >
                                                            <animateTransform 
                                                            attributeName="transform" 
                                                            dur="1s" 
                                                            type="translate" 
                                                            values="0 5 ; 0 -5; 0 5" 
                                                            repeatCount="indefinite" 
                                                            begin="0.3"/>
                                                        </rect>
                                                        <rect x="60" y="35" width="5" height="30" >
                                                            <animateTransform 
                                                            attributeName="transform" 
                                                            dur="1s" 
                                                            type="translate" 
                                                            values="0 5 ; 0 -5; 0 5"  
                                                            repeatCount="indefinite" 
                                                            begin="0.4"/>
                                                        </rect>
                                                        <rect x="70" y="35" width="5" height="30" >
                                                            <animateTransform 
                                                            attributeName="transform" 
                                                            dur="1s" 
                                                            type="translate" 
                                                            values="0 5 ; 0 -5; 0 5" 
                                                            repeatCount="indefinite" 
                                                            begin="0.5"/>
                                                        </rect>
                                                        </g>
                                                        </svg>      

                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- PERFORMANCE SNAPSHOT MONTHLY TAB END -->

                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>   
</template>
<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>
<script>
import CustomTable from './Common/CustomTable.vue'
import Multiselect from '@suadelabs/vue3-multiselect'
import mixin from '../mixin';
import { mapGetters, mapActions } from 'vuex'
import moment from 'moment';
export default {
    props: {
        page_title: {
        type: String,
        required: true,
        default: '',
        },
        page_description: {
        type: String,
        required: true,
        default: '',
        },
        page_image: {
        type: String,
        required: true,
        default: '',
        },
        banner_title: {
        type: String,
        required: true,
        default: '',
        },
    },
    components: {
      Multiselect,
  },
  mixins: [mixin],
   data() {
            return {
                sortKey: 'fund_name',
                ascending: true,
                sortKeyM: 'fund_name',
                ascendingM: true,
                sortKeC: 'fund_name',
                ascendingC: true,
                composition_snapshot: [],
                snapshotText: null,
                processWeekly:false,
                currentTab:'weekly',
                selectedDateWeekly:null,
                selectedFundClassificationWeekly:null,
                selectedCategoryWeekly:'',
                weekly_snapshot_data:[],
                dataCategoryMonthly:'',
                processMonthly:false,
                selectedDateMonthly:null,
                selectedFundClassificationMonthly:null,
                selectedCategoryMonthly:'',
                monthly_snapshot_data:[],
            }
  },
  methods: {
   ...mapActions('InputData', ['getFundClassifications']),
   downloadPDF(){
       let that = this
       let fund_type_id = that.getURLParams("fund_type_id")
        let type = that.getURLParams("type")
        let report_category = that.getURLParams("report_category")
        let date = that.getURLParams("date")
       window.open('/performance-snapshot-pdf?fund_type_id='+fund_type_id+'&type='+type+'&report_category='+report_category+'&date='+date, '_blank');
   },
   switchTab(tabName) {
      this.currentTab = tabName;
    },
   generateURL(tabName) {
      const baseURL = 'https://myplexus.com/performance-snapshot';
      const queryParams = {
        fund_type_id: this.getURLParams('fund_type_id'),
        type: tabName,
        report_category: this.getURLParams('report_category'),
        date: this.getURLParams("date"),
        tab: tabName,
      };
      const queryString = new URLSearchParams(queryParams).toString();
      return `${baseURL}?${queryString}`;
    },
    sortTableW(col) {
      if (this.sortKey === col) {
        this.ascending = !this.ascending;
      } else {
        this.ascending = true;
        this.sortKey = col;
      }

      var ascending = this.ascending;

      this.weekly_snapshot_data.sort(function(a, b) {
        if (a[col] > b[col]) {
          return ascending ? 1 : -1
        } else if (a[col] < b[col]) {
          return ascending ? -1 : 1
        }
        return 0;
      })
    },
    sortTableM(col) {
      if (this.sortKeyM === col) {
        this.ascendingM = !this.ascendingM;
      } else {
        this.ascendingM = true;
        this.sortKeyM = col;
      }

      var ascendingM = this.ascendingM;

      this.monthly_snapshot_data.sort(function(a, b) {
        if (a[col] > b[col]) {
          return ascendingM ? 1 : -1
        } else if (a[col] < b[col]) {
          return ascendingM ? -1 : 1
        }
        return 0;
      })
    },
    sortTableC(col) {
      if (this.sortKeyC === col) {
        this.ascendingC = !this.ascendingC;
      } else {
        this.ascendingC = true;
        this.sortKeyC = col;
      }

      var ascendingC = this.ascendingC;

      this.monthly_snapshot_data.sort(function(a, b) {
        if (a[col] > b[col]) {
          return ascendingC ? 1 : -1
        } else if (a[col] < b[col]) {
          return ascendingC ? -1 : 1
        }
        return 0;
      })
    },
   formattedDate(date){
       return moment(date).format('DD/MM/YYYY')
   },
   async getWeeklySnapshot(){
       let that = this
       that.processWeekly = true
       let data = {
            fund_type_id:that.selectedFundClassificationWeekly.ft_id,
            type:'weekly',
            report_category:that.selectedCategoryWeekly,
            date:moment(that.selectedDateWeekly).format('YYYY-MM-DD')
        }

        console.log('Weekly Data: ', data)
        Object.keys(data).forEach(key => {
        that.addParamToURL(key, data[key])
        });

        if(that.selectedCategoryWeekly == 'indices'){
            that.sortKey = 'indices_name'
        }
        

        that.dataCategoryWeekly = that.selectedCategoryWeekly;
        that.weekly_snapshot_data = []
       await axios.get('https://myplexus.com/api/v1/performance-snapshot', { params: data })
            .then(response => {
                that.weekly_snapshot_data = response.data.data.snapshot_data
                return true
            })
            .then(response => {
            })
            .catch(error => {
                console.log(error);
            })
            .finally(() => {
                that.processWeekly = false
            })
   },
   async getMonthlySnapshot(){
       let that = this
       that.processMonthly = true
       let data = {
            fund_type_id:that.selectedFundClassificationMonthly.ft_id,
            type:'monthly',
            report_category:that.selectedCategoryMonthly,
            date:moment(that.selectedDateMonthly).format('YYYY-MM-DD')
        }
        console.log('Monthly Data: ',data);
        Object.keys(data).forEach(key => {
        that.addParamToURL(key, data[key])
        });

        if(that.selectedCategoryMonthly == 'indices'){
            that.sortKeyM = 'indices_name'
        }
        

        that.dataCategoryMonthly = that.selectedCategoryMonthly;
        that.monthly_snapshot_data = []
       await axios.get('/api/v1/performance-snapshot', { params: data })
            .then(response => {
                that.monthly_snapshot_data = response.data.data.snapshot_data
                that.aaum_date = response.data.data.aaum_date;
                // console.log('aaum_date: ',that.aaum_date);
                return true
            })
            .then(response => {
            })
            .catch(error => {
                console.log(error);
            })
            .finally(() => {
                that.processMonthly = false
            })
   },
  },
  watch: {
    selectedFundClassification(value) {
        this.$store.commit('InputData/setFunds', [])
        if(value){
            this.addParamToURL('fund_classification', value.name)
            this.getFundCompositionSnapshot()
        }else{
            this.removeURLParameter('fund_classification')
        }
    },
    },
  computed: {
    ...mapGetters('InputData', ['loading','fundClassifications']),
    maxDateRang(){
        let d = new Date();
        return d.setDate(d.getDate());
    },
  },
  mounted() {
    let that = this
    let fund_type_id = that.getURLParams("fund_type_id")
    let type = that.getURLParams("type")
    let report_category = that.getURLParams("report_category")
    let date = that.getURLParams("date")
    const myPromise = new Promise(async (resolve, reject) => {
        await this.getFundClassifications()
        resolve(true)
    });
    
    myPromise.then( async (resolve, reject) => {
        if(fund_type_id){
            if(type == 'weekly'){

                that.currentTab = 'weekly'
                that.selectedFundClassificationWeekly = that.fundClassifications.filter(function(el) { return el.ft_id == fund_type_id })[0]
                if(report_category){
                    that.selectedCategoryWeekly = report_category
                }
                if(date){
                    that.selectedDateWeekly = moment().subtract(1, 'days')
                }
            }else if(type == 'monthly'){
                that.currentTab = 'monthly'
                that.selectedFundClassificationMonthly = that.fundClassifications.filter(function(el) { return el.ft_id == fund_type_id })[0]
                if(report_category){
                    that.selectedCategoryMonthly = report_category
                }
                if(date){
                    that.selectedDateMonthly = moment(date)
                }
            }
        }
        return true
    }).then( async (resolve, reject) => {
        if(type == 'weekly'){
            that.getWeeklySnapshot()    
        }else if(type == 'monthly'){
            that.getMonthlySnapshot()
        }
    });
  },
  
}
// console.log('Current Tab: ',currentTab);
</script>
<style>
.top_th {
	background: #00665e !important;
	color: #fff  !important;
}
.with_border{
border-left: 1px solid #000  !important;
border-right: 1px solid #000  !important;
}
.left_border{
border-left: 1px solid #000 !important;
}
.right_border{
border-right: 1px solid #000 !important;
}
th{
    vertical-align: middle !important;
}
.perform-paramtr .dy-table-wrap .dy-table-block {
	border: 0px !important;
}
.dp__pointer {
    height: 48px;
}
.investing-tools .invst-wrap .invst-fields select, .custom-input {
    border: 0;
    height: 40px;
    padding: 0 15px;
    width:100%;
    border-radius: 5px;
    box-shadow: 0px 3px 13px -7px #0000005c;
}
.text-right {
    text-align: right!important;
}
.perform-snapshot-tabs .perform-snapshot-submit{
    margin: 25px 0 15px 0;
}
.readonly-datepicker {
  pointer-events: none; /* Disable pointer events */
  background-color: #a09e9e; /* Optional: change background color to indicate readonly */
}
</style>