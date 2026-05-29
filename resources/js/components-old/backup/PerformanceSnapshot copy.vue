<template>

    <div class="compare-scemes-sec investing-tools perform-snapshot-tabs select2-styles">
        <div class="container">
            <!-- <div class="compare-block">
                <h4>Performance Snapshot</h4>
            </div> -->

            <ul class="nav nav-tabs border-0 mt-5">
                <li><a class="" :class="{'active show':currentTab == 'weekly'}" data-toggle="tab" href="#tab-weekly" @click="currentTab = 'weekly'">Weekly</a></li>
                <li><a :class="{'active show':currentTab == 'monthly'}" data-toggle="tab" href="#tab-monthly" @click="currentTab = 'monthly'">Monthly</a></li>
            </ul>
        </div>
        <div class="tab-wrapper">
            <div class="container">
                <div class="tab-content">

                    <!-- PERFORMANCE SNAPSHOT WEEKLY TAB START -->

                    <div id="tab-weekly" class="tab-pane fade in" :class="{'active show':currentTab == 'weekly'}">
                        <form action="#" method="get">
                            <div class="invst-wrap">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <Datepicker class="custom-input" v-model="selectedDateWeekly" :format="'dd/MM/yyyy'" :enableTimePicker="false" :autoApply="true" :range="false" :maxDate="maxDateRang"></Datepicker>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
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
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <select v-model="selectedCategoryWeekly" id="ps-weekly-return" class="custom-input">
                                            <option value="">Report Category</option>
                                            <option value="return">Return %</option>
                                            <option value="indices">Indices</option>
                                            <option value="return_less_index">Return Less Index </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="perform-snapshot-submit">
                                <div class="col-12 text-right px-0">
                                    <button class="perform-submit btn" @click="getWeeklySnapshot" :disabled="!selectedDateWeekly || !selectedFundClassificationWeekly || !selectedCategoryWeekly || processWeekly">Submit</button>
                                </div>
                            </div>
                        </form>

                        <div class="perform-snapshot-points" v-if="weekly_snapshot_data.length">
                            <ul>
                                <li><p>Type of Fund : <span>{{ selectedFundClassificationWeekly.name }}</span></p></li>
                                <li><p>As On : <span><strong>{{ formattedDate(selectedDateWeekly) }}</strong></span></p></li>
                            </ul>
                        </div>

                        <div class="perform-snapshot-table full-table-style-2 custom-sort-table">
                            <table id="performance-weekly" class="display w-100 dataTable">
                                <thead>
                                    <tr>
                                        <th class="sorting" v-on:click="sortTableW('fund_name')" :class="{'sorting_asc':sortKey == 'fund_name' && ascending, 'sorting_desc': sortKey == 'fund_name' && !ascending}" v-if="dataCategoryWeekly != 'indices'">Fund name</th>
                                        <th class="sorting" v-on:click="sortTableW('indices_name')" :class="{'sorting_asc':sortKey == 'indices_name' && ascending, 'sorting_desc': sortKey == 'indices_name' && !ascending}" v-if="dataCategoryWeekly == 'indices' || dataCategoryWeekly == 'return'">Index name</th>
                                        <th class="sorting" v-on:click="sortTableW('7DAYS')" :class="{'sorting_asc':sortKey == '7DAYS' && ascending, 'sorting_desc': sortKey == '7DAYS' && !ascending}">7 days</th>
                                        <th class="sorting" v-on:click="sortTableW('14DAYS')" :class="{'sorting_asc':sortKey == '14DAYS' && ascending, 'sorting_desc': sortKey == '14DAYS' && !ascending}">14 days</th>
                                        <th class="sorting" v-on:click="sortTableW('30DAYS')" :class="{'sorting_asc':sortKey == '30DAYS' && ascending, 'sorting_desc': sortKey == '30DAYS' && !ascending}">30 days</th>
                                        <th class="sorting" v-on:click="sortTableW('60DAYS')" :class="{'sorting_asc':sortKey == '60DAYS' && ascending, 'sorting_desc': sortKey == '60DAYS' && !ascending}">60 days</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data,index) in weekly_snapshot_data" :key="index">
                                        <td v-if="dataCategoryWeekly != 'indices'"><a class="text-white" :href="`/fund-performance?fund_code=${encodeURIComponent(data.fund_code)}`" target="_blank">{{ data.fund_name }}</a></td>
                                        <td v-if="dataCategoryWeekly == 'indices' || dataCategoryWeekly == 'return'">{{ data.indices_name }}</td>
                                        <td>{{ data['7DAYS'].toFixed(2) }}</td>
                                        <td>{{ data['14DAYS'].toFixed(2) }}</td>
                                        <td>{{ data['30DAYS'].toFixed(2) }}</td>
                                        <td>{{ data['60DAYS'].toFixed(2) }}</td>
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
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <Datepicker class="custom-input" v-model="selectedDateMonthly" :format="'dd/MM/yyyy'" :enableTimePicker="false" :autoApply="true" :range="false" :maxDate="maxDateRang"></Datepicker>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
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
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <select v-model="selectedCategoryMonthly" id="ps-monthly-return" class="custom-input">
                                            <option value="">Report Category</option>
                                            <option value="return">Return %</option>
                                            <option value="indices">Indices</option>
                                            <option value="return_less_index">Return Less Index </option>
                                            <option value="corpus_change">Corpus Changes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="perform-snapshot-submit">
                                <div class="col-12 text-right px-0">
                                    <button class="perform-submit btn" @click="getMonthlySnapshot" :disabled="!selectedDateMonthly || !selectedFundClassificationMonthly || !selectedCategoryMonthly || processMonthly">Submit</button>
                                </div>
                            </div>
                        </form>

                        <div class="perform-snapshot-points" v-if="monthly_snapshot_data.length">
                            <ul>
                                <li><p>Type of Fund : <span>{{ selectedFundClassificationMonthly.name }}</span></p></li>
                                <li><p>As On : <span><strong>{{ formattedDate(selectedDateMonthly) }}</strong></span></p></li>
                            </ul>
                        </div>

                        <div class="perform-snapshot-table full-table-style-2 custom-sort-table">
                            <table id="performance-monthly" class="display w-100 dataTable" v-if="dataCategoryMonthly == 'indices' || dataCategoryMonthly == 'return' || dataCategoryMonthly == 'return_less_index'">
                                <thead>
                                    <tr>
                                        <th class="sorting" v-on:click="sortTableM('fund_name')" :class="{'sorting_asc':sortKeyM == 'fund_name' && ascendingM, 'sorting_desc': sortKeyM == 'fund_name' && !ascendingM}" v-if="dataCategoryMonthly != 'indices'">Fund name</th>
                                        <th class="sorting" v-on:click="sortTableM('indices_name')" :class="{'sorting_asc':sortKeyM == 'indices_name' && ascendingM, 'sorting_desc': sortKeyM == 'indices_name' && !ascendingM}" v-if="dataCategoryMonthly == 'indices' || dataCategoryMonthly == 'return'">Index name</th>
                                        <th class="sorting" v-on:click="sortTableM('sixmonths')" :class="{'sorting_asc':sortKeyM == 'sixmonths' && ascendingM, 'sorting_desc': sortKeyM == 'sixmonths' && !ascendingM}">Six Months </th>
                                        <th class="sorting" v-on:click="sortTableM('oneyear')" :class="{'sorting_asc':sortKeyM == 'oneyear' && ascendingM, 'sorting_desc': sortKeyM == 'oneyear' && !ascendingM}">One Year</th>
                                        <th class="sorting" v-on:click="sortTableM('twoyear')" :class="{'sorting_asc':sortKeyM == 'twoyear' && ascendingM, 'sorting_desc': sortKeyM == 'twoyear' && !ascendingM}">Two Year</th>
                                        <th class="sorting" v-on:click="sortTableM('threeyear')" :class="{'sorting_asc':sortKeyM == 'threeyear' && ascendingM, 'sorting_desc': sortKeyM == 'threeyear' && !ascendingM}">Three Year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data,index) in monthly_snapshot_data" :key="index">
                                        <td v-if="dataCategoryMonthly != 'indices'"><a class="text-white" :href="`/fund-performance?fund_code=${encodeURIComponent(data.fund_code)}`" target="_blank">{{ data.fund_name }}</a></td>
                                        <td v-if="dataCategoryMonthly == 'indices' || dataCategoryMonthly == 'return'">{{ data.indices_name }}</td>
                                        <td>{{ data['sixmonths'].toFixed(2) }}</td>
                                        <td>{{ data['oneyear'].toFixed(2) }}</td>
                                        <td>{{ data['twoyear'].toFixed(2) }}</td>
                                        <td>{{ data['threeyear'].toFixed(2) }}</td>
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
                                        <th class="sorting" v-on:click="sortTableC('fund_name')" :class="{'sorting_asc':sortKeyC == 'fund_name' && ascendingC, 'sorting_desc': sortKeyC == 'fund_name' && !ascendingC}" >Fund name</th>
                                        <th class="sorting" v-on:click="sortTableC('corpus_entry')" :class="{'sorting_asc':sortKeyC == 'corpus_entry' && ascendingC, 'sorting_desc': sortKeyC == 'corpus_entry' && !ascendingC}" >Current Amount (Rs.in Lacs) </th>
                                        <th class="sorting" v-on:click="sortTableC('corpus_change')" :class="{'sorting_asc':sortKeyC == 'corpus_change' && ascendingC, 'sorting_desc': sortKeyC == 'corpus_change' && !ascendingC}">Change Amount (Rs.in Lacs)  </th>
                                        <th class="sorting" v-on:click="sortTableC('percentage_change')" :class="{'sorting_asc':sortKeyC == 'percentage_change' && ascendingC, 'sorting_desc': sortKeyC == 'percentage_change' && !ascendingC}">(%) Change</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data,index) in monthly_snapshot_data" :key="index">
                                        <td ><a class="text-white" :href="`/fund-performance?fund_code=${encodeURIComponent(data.fund_code)}`" target="_blank">{{ data.fund_name }}</a></td>
                                        <td>{{ data['corpus_entry'].toFixed(2) }}</td>
                                        <td>{{ data['corpus_change'].toFixed(2) }}</td>
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
                app_url:'https://beta.myplexus.com'
            }
  },
  methods: {
   ...mapActions('InputData', ['getFundClassifications']),
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
        Object.keys(data).forEach(key => {
        that.addParamToURL(key, data[key])
        });

        if(that.selectedCategoryWeekly == 'indices'){
            that.sortKey = 'indices_name'
        }
        

        that.dataCategoryWeekly = that.selectedCategoryWeekly;
        that.weekly_snapshot_data = []
       await axios.get(that.app_url+'/api/v1/performance-snapshot', { params: data })
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
        Object.keys(data).forEach(key => {
        that.addParamToURL(key, data[key])
        });

        if(that.selectedCategoryMonthly == 'indices'){
            that.sortKeyM = 'indices_name'
        }
        

        that.dataCategoryMonthly = that.selectedCategoryMonthly;
        that.monthly_snapshot_data = []
       await axios.get(that.app_url+'/api/v1/performance-snapshot', { params: data })
            .then(response => {
                that.monthly_snapshot_data = response.data.data.snapshot_data
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
        return d.setDate(d.getDate() - 1);
    },
  },
  mounted() {
    console.log('app_url',this.app_url)
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
                    that.selectedDateWeekly = moment(date)
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
</style>