<template>

    <div class="custom-banner no-bg fw-bannerfund-portfolio-banner monthly-ranking monthly-snapshot-banner"><section class="inner_banner_section"><div class="container"><div class="row"><div class="col-md-12"><div class="inner_section_banner"><h4>Weekly Snapshot</h4></div></div></div></div></section></div>
    <!-- <div class="custom-banner no-bg fw-banner " :class="{'monthly-ranking weekly-snapshot-banner':!page_image}" :style="(page_image)?{ 'background-image': 'url('+page_image+')'}:{}">
        <div class="container">
            <div class="banner-align-lft fw-title">
                <h1 class="f-b">{{ page_title }}</h1>
                <h3 class="f-sb text-green"  v-if="from_date && to_date">Weekly Snapshot Report - {{from_date}} to </h3>
            </div>
            <div class="clear"></div>
        </div>
    </div> -->
    <section class="monthly_snapshop_sec">
        <div class="container">
            <div class="fund-c-analysis m-t-30 m-b-30 monthly-compo">
                <div class="container p-0">
                    <div class="snapshot_inner">
                        <div class="snapshot_header" style="padding: 0 3px;">
                            <p v-if="from_date && to_date">Weekly Snapshot Report: {{from_date}} to {{addDates}}</p>
                        </div>
                        <div class="perform-paramtr monthly-compo-wrap weekly-snapshot-cols">
                            <div class="row perform-pmtr-lumpsum">
                                    
                                <div class="col-lg-4 col-md-12 col-sm-12 box_border_right">
                                    <div class="dy-table-wrap">
                                        <div class="dy-table-block br-5 index_changes_header">
                                            <h4>Index Changes</h4>
                                            <div class="changes_table">
                                                <!--<table class="table table-responsive table-striped box-shadow">
                                                    <thead>
                                                        <tr>
                                                            <th class="w-50">Indices <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                            <th>Closing Value <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                            <th style="min-width: 130px;">% Change <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="index in index_change" :key="index.name">
                                                            <td>{{ index.name }}</td>
                                                            <td>{{ index.cur_value }}</td>
                                                            <td>{{ index.PER_CHANGE.toFixed(2) }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table> -->
												
												<CustomTable id="best-weekly-index" :columns="[
                                                                        {name:'Indices', key:'name'}, 
                                                                        {name:'Closing Value', key:'cur_value'},
                                                                        {name:'% Change', key:'PER_CHANGE',decimalplaces:2}
                                                                    ]"
                                                                    :rows="index_change.filter(function(el) { return true })"
                                                                    default_sort_key="name"
                                                                    :order_ascending="true"
                                                                    tabindex="2"
                                                                    >
                                                                </CustomTable>
												
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <div class="dy-table-wrap">
                                        <div class="dy-table-block br-5 index_changes_header">
                                            <h4>Currency Changes</h4>
                                            <div class="changes_table">
                                                <!--<table class="table table-responsive table-striped box-shadow">
                                                    <thead>
                                                        <tr>
                                                            <th class="w-50">Currency <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                            <th>₹ <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                            <th style="min-width: 130px;">% Change <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="currency in currency_change" :key="currency.name">
                                                        <td>{{ currency.name }}</td>
                                                        <td>{{ currency.cur_value }}</td>
                                                        <td>{{ currency.PER_CHANGE.toFixed(2) }}</td>
                                                    </tr>
                                                    </tbody>                                                    
                                                </table> -->
												
												<CustomTable id="best-weekly-currency" :columns="[
                                                                        {name:'Currency', key:'name'}, 
                                                                        {name:'₹', key:'cur_value'},
                                                                        {name:'% Change', key:'PER_CHANGE',decimalplaces:2}
                                                                    ]"
                                                                    :rows="currency_change.filter(function(el) { return true })"
                                                                    default_sort_key="name"
                                                                    :order_ascending="true"
                                                                    tabindex="2"
                                                                    >
                                                                </CustomTable>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <div class="dy-table-wrap">
                                        <div class="dy-table-block br-5 index_changes_header">
                                            <h4>Commodity Changes</h4>
                                            <div class="changes_table">
                                                <!--<table class="table table-responsive table-striped box-shadow">
                                                    <thead>
                                                        <tr>
                                                        <th class="w-50">Commodity <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th>₹ <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th style="min-width: 130px;">% Change <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="commodity in commodity_change" :key="commodity.name">
                                                            <td>{{ commodity.name }}</td>
                                                            <td>{{ commodity.cur_value }}</td>
                                                            <td>{{ commodity.PER_CHANGE.toFixed(2) }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table> -->
												
										<CustomTable class="table-responsive table-striped box-shadow" id="best-weekly-commodity" :columns="[
                                                                        {name:'Commodity', key:'name'}, 
                                                                        {name:'₹', key:'cur_value'},
                                                                        {name:'% Change', key:'PER_CHANGE',decimalplaces:2}
                                                                    ]"
                                                                    :rows="commodity_change.filter(function(el) { return true })"
                                                                    default_sort_key="name"
                                                                    :order_ascending="true"
                                                                    tabindex="2"
                                                                    >
                                                                </CustomTable>
												
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="fund-c-analysis mt-4 m-t-30 custom-sort-table monthly-snap-full weekly-snapshot-blocks">
                <div class="container p-0">
                    <div class="snapshot_inner">
                        <div class="perform-paramtr c-snapchot-parent">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 perform-pmtr-lumpsum">
                                    <div class="dy-table-wrap">
                                        <div class="dy-table-block br-5 total-table hide-table">
                                            <div class="row m-0">
                                                <div class="col-lg-6 col-md-12 col-sm-12 pl-0 weekly-table-block-one box_border_right">
                                                    <div class="changes_table ws-table-wrap">
                                                        <div class="table-top" :class="{'opened':showTable1}" >
                                                            <div class="dy-table-block br-5  index_changes_header">
                                                                <h4>Percentage Change by Category of Funds</h4>
                                                            </div>
                                                            <!-- <div class="align-right-block"><img src="../../images/toggle-arrow.png" /></div> -->
                                                        </div>
                                                        <table class="table dataTable no-footer table-striped" role="grid" v-if="showTable1">
                                                            <thead>
                                                                <tr>
                                                                    <th class="sorting" style="width: 47% !important;" v-on:click="sortTable('FUNDTYPE')" :class="{'sorting_asc':sortKey == 'FUNDTYPE' && ascending, 'sorting_desc': sortKey == 'FUNDTYPE' && !ascending}">Fund Category <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                                    <th class="sorting" v-on:click="sortTable('CHANGEVALUE')" :class="{'sorting_asc':sortKey == 'CHANGEVALUE' && ascending, 'sorting_desc': sortKey == 'CHANGEVALUE' && !ascending}">Average <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                                    <th class="sorting" v-on:click="sortTable('MEDIANVAL')" :class="{'sorting_asc':sortKey == 'MEDIANVAL' && ascending, 'sorting_desc': sortKey == 'MEDIANVAL' && !ascending}">Median <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody >                            
                                                                <tr v-for="fund_type in per_changes" :key="fund_type.FUNDTYPE">
                                                                    <td><div class="cursor-pointer" @click="selectedFundType = fund_type.FundTypeID;">{{ fund_type.FUNDTYPE }}</div></td>
                                                                    <td>{{ fund_type.CHANGEVALUE.toFixed(2) }}</td>
                                                                    <td>{{ fund_type.MEDIANVAL.toFixed(2) }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        
                                                    </div>
                                                </div>
            
                                                <div class="col-lg-6 col-md-12 col-sm-12 pr-0 weekly-table-block-two" style="
                                                margin-top: -40px;
                                            ">
                                                    <div class="changes_table ws-table-wrap">
                                                        <div class="table-top" :class="{'opened':showTable2}" >
                                                            <div class="main_trer monthly_snap_shot_table">
                                                                <div class="dy-table-block br-5  index_changes_header">
                                                                    <h4>10 Best Performing Schemes</h4>
                                                                </div>
                                                                <!-- <div class="align-right-block"><img src="../../images/toggle-arrow.png" /></div> -->
                                                        
                                                                <CustomTable
                                                                v-if="showTable2"
                                                                id="best-funds"
                                                                :columns="[
                                                                    {name:'Scheme Name', key:'fund_name'}, 
                                                                    {name:'Category', key:'name'},
                                                                    {name:'Return %', key:'weekly_change',decimalplaces:2}
                                                                ]"
                                                                :rows="weekly_best_funds.filter(function(el) { return true })"
                                                                default_sort_key="fund_name"
                                                                :order_ascending="true"
                                                                tabindex="2"
                                                                ></CustomTable>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <div >
           <div :class="modalClasses" class="fade" id="reject" role="dialog">
               <div class="modal-dialog">
                     <div class="modal-content fund-c-analysis">
                          <div class="modal-header">
                            <h6 class="">Fund Changes</h6>
        
                            <button type="button" class="close" @click="toggle();selectedFundType=''">&times;</button>
                          </div>
                          <div class="modal-body perform-paramtr c-snapchot-parent">
                              <div class="changes_table dy-table-wrap">
                                    <div class="dy-table-block br-5">
                                        <!--<table class="table table-responsive table-striped box-shadow">
											<thead>
                                            <tr>
                                                <th style="width: 80% !important;">Fund Name</th>
                                                <th style="min-width: 130px;">% Change</th>
                                            </tr>
											</thead>
                                            <tbody v-if="fund_change.length && !loading">
                                                <tr v-for="index in fund_change" :key="index.fund_code">
                                                    <td>{{ index.fund_name }}</td>
                                                    <td>{{ index.change_value.toFixed(2) }}</td>
                                                </tr>
                                            </tbody>
                                        </table> -->
										
																<CustomTable                                                                
                                                                id="best-weekly-funds-changes"
                                                                :columns="[
                                                                    {name:'Fund Name', key:'fund_name'},                            
                                                                    {name:'% Change', key:'change_value',decimalplaces:2}
                                                                ]"
                                                                :rows="fund_change.filter(function(el) { return true })"
                                                                default_sort_key="fund_name"
                                                                :order_ascending="true"
                                                                tabindex="2"
                                                                ></CustomTable>
										
                                    </div>
                                </div>
                          </div>
                      </div>
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
            CustomTable
      },
      mixins: [mixin],
       data() {
                return {
                    sortKey: 'FUNDTYPE',
                    ascending: true,
                    process:false,
                    showTable1:true,
                    showTable2:true,
                    showModal: false,
                    modalClasses: ['modal','fade'],
                    per_changes:[],
                    selectedFundType:''
                }
      },
      methods: {
          async getWeeklyChangesFundType() {
            this.process = true
            await axios.get('https://www.myplexus.com/api/v1/weekly-changes-fund-type')
                .then(response => {
                    this.per_changes =  response.data.data.changes_fund_type
                })
                .catch(error => {
                    
                })
                .finally(() => {
                    this.process = false
                })
        },
        sortTable(col) {
          if (this.sortKey === col) {
            this.ascending = !this.ascending;
          } else {
            this.ascending = true;
            this.sortKey = col;
          }
    
          var ascending = this.ascending;
    
          this.per_changes.sort(function(a, b) {
            if (a[col] > b[col]) {
              return ascending ? 1 : -1
            } else if (a[col] < b[col]) {
              return ascending ? -1 : 1
            }
            return 0;
          })
        },
       ...mapActions('InputData', ['getSnapshotDates','getIndexChanges','getCurrencyChanges','getCommodityChanges','getWeeklyBestFunds','getFundChanges']),
       toggle() {
            
            let modalClasses = this.modalClasses
        
            if (modalClasses.indexOf('d-block') > -1) {
                document.body.className = ''
                modalClasses.pop()
                modalClasses.pop()
        
                //hide backdrop
                let backdrop = document.querySelector('.modal-backdrop')
                document.body.removeChild(backdrop)
            }
            else {
                document.body.className += ' modal-open'
                modalClasses.push('d-block')
                modalClasses.push('show')
        
                //show backdrop
                let backdrop = document.createElement('div')
                backdrop.classList = "modal-backdrop fade show"
                document.body.appendChild(backdrop)
            }
        },
      },
      watch: {
          selectedFundType(value){
              if(value){
                  this.getFundChanges({type:'weekly',fund_type_id:value})
                  this.toggle()
              }
          }
    },
      computed: {
        ...mapGetters('InputData', ['loading','index_change','currency_change','commodity_change','from_date','to_date','weekly_best_funds','fund_change']),
		  
		  addDates()
		  {
            // console.log('From Date: ', this.from_date);
			 const dtArr = this.from_date.split('/');
			  //console.log(dtArr);
		  	//const frmDate = this.from_date;
			  const toDate = new Date(dtArr[1]+'/'+dtArr[0]+'/'+dtArr[2]);
			  //console.log(d);
			 toDate.setDate(toDate.getDate() + 6);			  
			 const day = toDate.toLocaleString('default', { day: '2-digit' });
			const month = toDate.toLocaleString('default', { month: '2-digit' });
			const year = toDate.toLocaleString('default', { year: 'numeric' });
			return day + '/' + month + '/' + year;
			  
    		//return frmDate; 
		  }
      },
      mounted() {
        this.getSnapshotDates({type:'weekly'})
        this.getIndexChanges({type:'weekly'})
        this.getCurrencyChanges({type:'weekly'})
        this.getCommodityChanges({type:'weekly'})
        this.getWeeklyChangesFundType()
        this.getWeeklyBestFunds()
      },
    }
    </script>
    <style>
    .table-top.opened .align-right-block img {
        transform: rotate(180deg);
        transition: 0.5s;
    }
    .weekly-snapshot-blocks .ws-table-wrap,.weekly-table-block-two .ws-table-wrap{
        overflow-x: auto;
    }
    </style>