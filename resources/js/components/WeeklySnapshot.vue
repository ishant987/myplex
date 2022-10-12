<template>
<div class="custom-banner no-bg fw-bannerfund-portfolio-banner " :class="{'monthly-ranking monthly-snapshot-banner':!page_image}" :style="(page_image)?{ 'background-image': 'url('+page_image+')'}:{}">
    <section class="inner_banner_section" >
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner_section_banner">
                        <h4>{{ page_title }}</h4>
                        <p>{{page_description}}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<section class="monthly_snapshop_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="snapshot_inner">
                        <div class="snapshot_header">
                            <h4>Weekly Snapshot</h4>
                            <p v-if="from_date && to_date">Weekly Snapshot Report :{{from_date}} to {{to_date}}</p>
                        </div>
                        <div class="row">
                            <div class="col-md-4 box_border_right">
                                <div class="snopshot_changes_box">
                                    <div class="snopshot_changes_box_header index_changes_header">
                                        <h4>Index Changes</h4>
                                    </div>
                                    <div class="changes_table">
                                        <table class="table table-responsive table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Indeces</th>
                                                    <th>Closing  Value</th>
                                                    <th>%Changes</th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="index_change.length">
                                                <tr v-for="index in index_change" :key="index.name">
                                                    <td>{{ index.name }}</td>
                                                    <td>{{ index.cur_value }}</td>
                                                    <td>{{ index.PER_CHANGE.toFixed(2) }}</td>
                                                </tr>
                                            </tbody>
                                            <tbody v-else>
                                                <tr>
                                                    <td colspan="6">
                                                        <div class="text-center mt-3">
                                                            <LoadingBar :status="process"></LoadingBar>
                                                        </div>      
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 box_border_right">
                                <div class="snopshot_changes_box">
                                    <div class="snopshot_changes_box_header">
                                        <h4>Currency Changes</h4>
                                    </div>
                                    <div class="changes_table">
                                        <table class="table table-responsive table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Currency</th>
                                                    <th>₹</th>
                                                    <th>%Changes</th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="currency_change.length">
                                                <tr v-for="currency in currency_change" :key="currency.name">
                                                    <td>{{ currency.name }}</td>
                                                    <td>{{ currency.cur_value }}</td>
                                                    <td>{{ currency.PER_CHANGE.toFixed(2) }}</td>
                                                </tr>
                                            </tbody>
                                            <tbody v-else>
                                                <tr>
                                                    <td colspan="6">
                                                        <div class="text-center mt-3">
                                                            <LoadingBar :status="process"></LoadingBar>
                                                        </div>      
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="snopshot_changes_box">
                                    <div class="snopshot_changes_box_header">
                                        <h4>Commodity Changes</h4>
                                    </div>
                                    <div class="changes_table">
                                        <table class="table table-responsive table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Currency</th>
                                                    <th>₹</th>
                                                    <th>%Changes</th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="commodity_change.length">
                                                <tr v-for="commodity in commodity_change" :key="commodity.name">
                                                    <td>{{ commodity.name }}</td>
                                                    <td>{{ commodity.cur_value }}</td>
                                                    <td>{{ commodity.PER_CHANGE.toFixed(2) }}</td>
                                                </tr>
                                            </tbody>
                                            <tbody v-else>
                                                <tr>
                                                    <td colspan="6">
                                                        <div class="text-center mt-3">
                                                            <LoadingBar :status="process"></LoadingBar>
                                                        </div>      
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="snapshopt_download_single">
                                    <div class="snapshopt_download_single_inner d-block d-sm-flex align-items-center">
                                        <div class="download_snapshot_pdf_icon">
                                            <img :src="image_path+'/download_pdf_icon.png'" />
                                        </div>
                                        <h4>Weekly Percentage Changes (By Category of Funds)</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="snapshopt_download_single">
                                    <div class="snapshopt_download_single_inner d-block d-sm-flex align-items-center">
                                        <div class="download_snapshot_pdf_icon">
                                            <img :src="image_path+'/download_pdf_icon.png'" />
                                        </div>
                                        <h4>10 Best Performing Schemes for the Month</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="snapshopt_download_single">
                                    <div class="snapshopt_download_single_inner d-block d-sm-flex align-items-center">
                                        <div class="download_snapshot_pdf_icon">
                                            <img :src="image_path+'/download_pdf_icon.png'" />
                                        </div>
                                        <h4>10 Worst Performing Schemes for The Month</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="fund-c-analysis m-t-30 custom-sort-table monthly-snap-full weekly-snapshot-blocks d-none">
        <div class="container p-0">

            <div class="perform-paramtr c-snapchot-parent">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 perform-pmtr-lumpsum">
                        <div class="dy-table-wrap">
                            <div class="dy-table-block br-5 total-table hide-table">
                                <div class="row m-0">
                                    <div class="col-lg-6 col-md-12 col-sm-12 pl-0 weekly-table-block-one">
                                        <div class="ws-table-wrap">
                                            <div class="table-top bg-dg" :class="{'opened':showTable1}" @click="showTable1 = !showTable1">
                                                <div class="align-lft-block"><h6>Percentage Change by Category of Funds</h6></div>
                                                <div class="align-right-block"><img src="../../images/toggle-arrow.png" /></div>
                                            </div>
                                            <table class="table dataTable no-footer" role="grid" v-if="showTable1">
                                                <thead>
                                                    <tr>
                                                        <th class="sorting" style="width: 47% !important;" v-on:click="sortTable('FUNDTYPE')" :class="{'sorting_asc':sortKey == 'FUNDTYPE' && ascending, 'sorting_desc': sortKey == 'FUNDTYPE' && !ascending}">Fund Category</th>
                                                        <th class="sorting" v-on:click="sortTable('CHANGEVALUE')" :class="{'sorting_asc':sortKey == 'CHANGEVALUE' && ascending, 'sorting_desc': sortKey == 'CHANGEVALUE' && !ascending}">% Change</th>
                                                        <th class="sorting" v-on:click="sortTable('MEDIANVAL')" :class="{'sorting_asc':sortKey == 'MEDIANVAL' && ascending, 'sorting_desc': sortKey == 'MEDIANVAL' && !ascending}">Median</th>
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

                                    <div class="col-lg-6 col-md-12 col-sm-12 pr-0 weekly-table-block-two">
                                        <div class="ws-table-wrap">
                                            <div class="table-top bg-dg" :class="{'opened':showTable2}" @click="showTable2 = !showTable2">
                                                <div class="align-lft-block"><h6>10 Best Performing Schemes</h6></div>
                                                <div class="align-right-block"><img src="../../images/toggle-arrow.png" /></div>
                                            </div>
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
    <div >
   <div :class="modalClasses" class="fade" id="reject" role="dialog">
       <div class="modal-dialog">
             <div class="modal-content fund-c-analysis">
                  <div class="modal-header">
                    <h6 class="">Fund Changes</h6>

                    <button type="button" class="close" @click="toggle();selectedFundType=''">&times;</button>
                  </div>
                  <div class="modal-body perform-paramtr c-snapchot-parent">
                      <div class="dy-table-wrap">
                            <div class="dy-table-block br-5">
                                <table class="box-shadow">
                                    <tr>
                                        <th style="width: 80% !important;">Fund Name</th>
                                        <th style="min-width: 130px;">% Change</th>
                                    </tr>
                                    <tbody v-if="fund_change.length && !loading">
                                        <tr v-for="index in fund_change" :key="index.fund_code">
                                            <td>{{ index.fund_name }}</td>
                                            <td>{{ index.change_value.toFixed(2) }}</td>
                                        </tr>
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
</template>
<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>
<script>
import CustomTable from './Common/CustomTable.vue'
import mixin from '../mixin';
import { mapGetters, mapActions } from 'vuex'
import moment from 'moment';
import LoadingBar from "./Common/loading";

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
        image_path:{
            type:String
        }
    },
    components: {
        CustomTable,
        LoadingBar
  },
  mixins: [mixin],
   data() {
            return {
                sortKey: 'FUNDTYPE',
                ascending: true,
                process:false,
                showTable1:false,
                showTable2:false,
                showModal: false,
                modalClasses: ['modal','fade'],
                per_changes:[],
                selectedFundType:'',
                app_url:process.env.MIX_APP_ENV=='local' ?  process.env.MIX_API_URL_LOCAL :'',

            }
  },
  methods: {
      async getWeeklyChangesFundType() {
        this.process = true
        await axios.get(this.app_url+'/api/v1/weekly-changes-fund-type')
            .then(response => {
                this.per_changes =  response.data.data.changes_fund_type
                this.process = false
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