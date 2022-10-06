<template>
     <div class="custom-banner no-bg fw-banner" :class="{'monthly-ranking':!page_image}" :style="(page_image)?{ 'background-image': 'url('+page_image+')'}:{}">
    <section class="inner_banner_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner_section_banner">
                        <h4>{{ page_title }}</h4>
                        <p v-if="page_description" class="f-sb text-green" v-html="page_description"></p>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
</div>
<section class="info_monitor_sec">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="info_monitor_inner">
                    <div class="info_monitor_inner_wrapper mb-3">
                        <div class="monthly_ranking_title d-block d-sm-flex align-items-center justify-content-between mb-3">
                            <div class="monthly_ranking_text">
                                <h4>Composition Snapshot</h4>
                            </div>
                        </div>
                        <div class="monthly_ranking_Search_part mb-1">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <h6 class="text-green-2">Fund classifications</h6>
                                    <multiselect 
                                    :disabled="loading || process"
                                    class=""
                                    label="name" 
                                    track-by="ft_id"
                                    v-model="selectedFundClassification" 
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
                                <div class="col-lg-6 col-md-6 col-sm-12"  v-if="snapshotText">
                                    <div class="banner-align-rgt fw-downlaod-btn mt-4">
                                    <a href="javascript:void(0)" class="money_title_btn" @click="downloadPDF">
                                             Download PDF 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                    </svg>
                                    </a>
                                </div>
                                </div>
                            </div>
                            <div class="row mt-3" v-if="snapshotText">
                                <div class="col-md-12">
                                    <p><b>Composition Snapshot of </b> -  <span>{{ snapshotText }}</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="monthly_ranking_table">
                            <div class="datatable_ll main_trer">
                                <div class="table-responsive">

                                    <table id="example" class="table table-striped" style="width:100%" role="grid" >
                                        <thead class="">
                                            <tr role="row">
                                                <th class="top_th" colspan="4" rowspan="1">&nbsp;</th>
                                                <th class="top_th with_border text-center" colspan="4" rowspan="1"> Equity</th>
                                                <th class="top_th" rowspan="1" colspan="1">&nbsp;</th>
                                            </tr> 
                                            <tr >
                                                <th class="sorting" v-on:click="sortTable('fund_name')" :class="{'sorting_asc':sortKey == 'fund_name' && ascending, 'sorting_desc': sortKey == 'fund_name' && !ascending}" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name of the Fund: activate to sort column descending" width="20%">Name of the Fund</th>
                                                <th class="sorting" v-on:click="sortTable('cash')" :class="{'sorting_asc':sortKey == 'cash' && ascending, 'sorting_desc': sortKey == 'cash' && !ascending}" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Cash&amp;nbsp;%: activate to sort column ascending" width="9%">Cash&nbsp;%</th>
                                                <th class="sorting" v-on:click="sortTable('sov')" :class="{'sorting_asc':sortKey == 'sov' && ascending, 'sorting_desc': sortKey == 'sov' && !ascending}" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Sov&amp;nbsp;%: activate to sort column ascending" width="9%">Sov&nbsp;%</th>
                                                <th class="sorting" v-on:click="sortTable('debt')" :class="{'sorting_asc':sortKey == 'debt' && ascending, 'sorting_desc': sortKey == 'debt' && !ascending}" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Corp Debt&amp;nbsp;%: activate to sort column ascending" >Corp Debt&nbsp;%</th>
                                                <th class="sorting" v-on:click="sortTable('eq_small')" :class="{'sorting_asc':sortKey == 'eq_small' && ascending, 'sorting_desc': sortKey == 'eq_small' && !ascending}" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Small Cap&amp;nbsp;%: activate to sort column ascending" >Small Cap&nbsp;%</th>
                                                <th class="sorting" v-on:click="sortTable('eq_mid')" :class="{'sorting_asc':sortKey == 'eq_mid' && ascending, 'sorting_desc': sortKey == 'eq_mid' && !ascending}" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Mid Cap&amp;nbsp;%: activate to sort column ascending" >Mid Cap&nbsp;%</th>
                                                <th class="sorting" v-on:click="sortTable('eq_large')" :class="{'sorting_asc':sortKey == 'eq_large' && ascending, 'sorting_desc': sortKey == 'eq_large' && !ascending}" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Large Cap&amp;nbsp;%: activate to sort column ascending" >Large Cap&nbsp;%</th>
                                                <th class="sorting" v-on:click="sortTable('eq_very_large')" :class="{'sorting_asc':sortKey == 'eq_very_large' && ascending, 'sorting_desc': sortKey == 'eq_very_large' && !ascending}" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Very  Large  Cap&amp;nbsp;%: activate to sort column ascending">Very  Large  Cap&nbsp;%</th>
                                                <th class="sorting" v-on:click="sortTable('wt_pe')" :class="{'sorting_asc':sortKey == 'wt_pe' && ascending, 'sorting_desc': sortKey == 'wt_pe' && !ascending}" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Wt&amp;nbsp;.&amp;nbsp;PE: activate to sort column ascending" width="9%">Wt&nbsp;.&nbsp;PE</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="process">
                                            <tr role="row">
                                                <td colspan="10">
                                                        <div class="text-center mt-3">
                                                            <LoadingBar :status="process"></LoadingBar>
                                                        </div>      
                                                </td>
                                            </tr> 
                                        </tbody>                            
                                        <tbody v-if="!process">                            
                                            <tr  class="odd" role="row" v-for="(composition,index) in composition_snapshot" :key="index">
                                            <td data-label="Name of the Fund" class="sorting_1">{{ composition.fund_name }}</td>
                                            <td data-label="Cash %" >{{ composition.cash }}</td>
                                            <td data-label="Sov %" >{{ composition.sov }}</td>
                                            <td data-label="Corp Debt %">{{ composition.debt }}</td>
                                            <td data-label="Small Cap %">{{ composition.eq_small }}</td>
                                            <td data-label="Mid Cap %" >{{ composition.eq_mid }}</td>
                                            <td data-label="Large Cap %" >{{ composition.eq_large }}</td>
                                            <td data-label="Very Large Cap %" >{{ composition.eq_very_large }}</td>
                                            <td data-label="Wt . PE" >{{ composition.wt_pe }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="table-total text-right" v-if="totalAmount">
                                        <p>Total Amount (Rs. in lacs) <span class="total-amount">{{totalAmount}}/-</span></p>
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
import Multiselect from '@suadelabs/vue3-multiselect'
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
    },
    components: {
      Multiselect,
      LoadingBar
  },
  mixins: [mixin],
   data() {
            return {
                sortKey: 'fund_name',
                ascending: true,
                selectedFundClassification:'',
                composition_snapshot: [],
                snapshotText: null,
                process:false,
                totalAmount:'',
                app_url:process.env.MIX_APP_ENV=='local' ?  process.env.MIX_API_URL_LOCAL :'',
            }
  },
  methods: {
   ...mapActions('InputData', ['getFundClassifications']),
   downloadPDF(){
       window.open(this.app_url+'/composition-snapshot-pdf/'+this.selectedFundClassification.ft_id, '_blank');
   },
   sortTable(col) {
      if (this.sortKey === col) {
        this.ascending = !this.ascending;
      } else {
        this.ascending = true;
        this.sortKey = col;
      }

      var ascending = this.ascending;

      this.composition_snapshot.sort(function(a, b) {
        if (a[col] > b[col]) {
          return ascending ? 1 : -1
        } else if (a[col] < b[col]) {
          return ascending ? -1 : 1
        }
        return 0;
      })
    },
   async getFundCompositionSnapshot(){
       let that = this
       that.process = true
       that.snapshotText = ''
       await axios.get(that.app_url+'/api/v1/fund-composition-snapshot/'+that.selectedFundClassification.ft_id)
            .then(response => {
                let composition_snapshot = response.data.data.composition_snapshot
                Object.keys(composition_snapshot).map(function(key, index) {
                    composition_snapshot[index].cash = composition_snapshot[index].cash.toFixed(2);
                    composition_snapshot[index].sov = composition_snapshot[index].sov.toFixed(2);
                    composition_snapshot[index].debt = composition_snapshot[index].debt.toFixed(2);
                    composition_snapshot[index].eq_small = composition_snapshot[index].eq_small.toFixed(2);
                    composition_snapshot[index].eq_mid = composition_snapshot[index].eq_mid.toFixed(2);
                    composition_snapshot[index].eq_large = composition_snapshot[index].eq_large.toFixed(2);
                    composition_snapshot[index].eq_very_large = composition_snapshot[index].eq_very_large.toFixed(2);
                });
                that.composition_snapshot = composition_snapshot
                return true
            })
            .then(response => {
                let first_fund = that.composition_snapshot[0]
                var formattedMonth = moment().month(first_fund.monthinfo - 1).format('MMMM');
                that.snapshotText = that.selectedFundClassification.name+' : For The Month of  '+formattedMonth+' , '+ first_fund.yearinfo
            })
            .catch(error => {
                console.log(error);
            })
            .finally(() => {
                that.process = false
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
  },
  mounted() {
    let that = this
    let fund_classification = that.getURLParams("fund_classification")

    const myPromise = new Promise(async (resolve, reject) => {
        await this.getFundClassifications()
        resolve(true)
    });
    
    myPromise.then( async (resolve, reject) => {
        if(fund_classification){
            that.selectedFundClassification = that.fundClassifications.filter(function(el) { return el.name == fund_classification })[0]
            //that.getFundCompositionSnapshot()
        }
        return true
    })
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
</style>