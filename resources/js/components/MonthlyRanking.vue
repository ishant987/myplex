<template>
<div class="custom-banner no-bg fw-banner" :class="{'monthly-ranking':!page_image}" :style="(page_image)?{ 'background-image': 'url('+page_image+')'}:{}">
    <div class="container">
        <div class="banner-align-lft fw-title">
            <h1 class="f-b">{{ page_title }}</h1>
            <h3 v-if="page_description" class="f-sb text-green" v-html="page_description"></h3>
        </div>
        <div class="banner-align-rgt fw-downlaod-btn mt-0 d-none">
            <a href="javascript:void(0)" class="btn-bg-3 br-5 f-b" @click="downloadPDF">
            Download PDF 
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
            </svg>
            </a>
        </div>
        <div class="clear"></div>
    </div>
</div>

    <div class="classifications-pg bg-gry">
        <div class="container">
            <div class="row align-items-center align-fix fund-port-cols">
                <div class="col-lg-7 col-md-6 col-sm-12 choose-classy select2-styles pl-0 fund-port-col-1">
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
                <div class="col-lg-5 col-md-6 col-sm-12 choose-cnt pr-0 fund-port-col-2" v-if="snapshotText">
                    <p>Monthly Ranking of - <br/> <span>{{ snapshotText }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="fund-c-analysis m-t-30 custom-sort-table">
        <div class="container p-0">

            <div class="perform-paramtr">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 perform-pmtr-lumpsum">
                        <div class="dy-table-wrap">
                            <div class="dy-table-block br-5">
                                
                                    
                                    <table class="table dataTable no-footer" id="data-table" role="grid" ref="html2Pdf">
                                        <thead>
                                        <tr role="row">
                                            <th class="top_th" colspan="3" rowspan="1">&nbsp;</th>
                                            <th class="top_th with_border text-center" colspan="3" rowspan="1">
                                                <div>
                                                    <strong style="text-transform: uppercase; ">Ranking</strong>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr role="row">
                                            <th class="sorting" v-on:click="sortTable('fund_name')" :class="{'sorting_asc':sortKey == 'fund_name' && ascending, 'sorting_desc': sortKey == 'fund_name' && !ascending}" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Name of Fund" style="width: 25%;">Name of Fund</th>
                                            <th class="sorting" v-on:click="sortTable('aaum')" :class="{'sorting_asc':sortKey == 'aaum' && ascending, 'sorting_desc': sortKey == 'aaum' && !ascending}" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="AAUM( Lacs)">AAUM<br><span style="font-weight: normal;">(₹ Lacs)</span></th>
                                            <th class="sorting" v-on:click="sortTable('one_year_return')" :class="{'sorting_asc':sortKey == 'one_year_return' && ascending, 'sorting_desc': sortKey == 'one_year_return' && !ascending}" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Return%(1 Year)">Return%<br><span style="font-weight: normal;">(1 Year)</span></th>
                                            <th class="sorting" v-on:click="sortTable('return_quality')" :class="{'sorting_asc':sortKey == 'return_quality' && ascending, 'sorting_desc': sortKey == 'return_quality' && !ascending}"  tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Return Quality">Return Quality</th>
                                            <th class="sorting" v-on:click="sortTable('volatality')" :class="{'sorting_asc':sortKey == 'volatality' && ascending, 'sorting_desc': sortKey == 'volatality' && !ascending}" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Volatility ">Volatility </th>
                                            <th class="sorting" v-on:click="sortTable('market_risk')" :class="{'sorting_asc':sortKey == 'market_risk' && ascending, 'sorting_desc': sortKey == 'market_risk' && !ascending}" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Market Risk" aria-sort="descending">Market Risk</th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="process">
                                            <tr role="row">
                                                <td class="top_th text-center" colspan="6" rowspan="1">
                                                    <svg style="width:100px" version="1.1" id="L1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
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
                                        <tbody v-if="!process">                            
                                            <tr class="odd" role="row" v-for="(fund,index) in monthly_ranking" :key="index">
                                                <td class="sorting_1">
                                                    {{ fund.fund_name }}
                                                </td>
                                                <td>
                                                    <img v-if="fund.per_change_aaum !== null && fund.per_change_aaum > 0" src="../../images/up-green-arrow.png" :title="fund.per_change_aaum+'%'" class="arrow-up" > 
                                                    <img v-if="fund.per_change_aaum !== null && fund.per_change_aaum < 0" src="../../images/down-red-arrow.png" :title="fund.per_change_aaum+'%'" class="arrow-up" > 
                                                    <span v-if="fund.per_change_aaum !== null">{{ fund.aaum.toFixed(2) }}</span>
                                                    <span v-else>NA</span>
                                                </td>
                                                <td>
                                                    <span v-if="fund.one_year_return !== null ">{{ fund.one_year_return.toFixed(2) }}</span>
                                                    <span v-else>NA</span>
                                                </td>
                                                <td class="left_border">
                                                    <img v-if="fund.return_quality !== null " :src="`/images/${fund.return_quality}-green-star.png`" :title="fund.return_quality" :alt="fund.return_quality" >
                                                    <span v-else>NA</span>
                                                </td>
                                                <td>
                                                    <img v-if="fund.volatality !== null " :src="`/images/${fund.volatality}-red-star.png`" :title="fund.volatality" :alt="fund.volatality" >
                                                    <span v-else>NA</span>
                                                </td>
                                                <td >
                                                    <img v-if="fund.market_risk !== null " :src="`/images/${fund.market_risk}-red-star.png`" :title="fund.market_risk" :alt="fund.market_risk" >
                                                    <span v-else>NA</span>
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
                selectedFundClassification:'',
                monthly_ranking: [],
                snapshotText: null,
                process:false,
            }
  },
  methods: {
   ...mapActions('InputData', ['getFundClassifications']),
   sortTable(col) {
      if (this.sortKey === col) {
        this.ascending = !this.ascending;
      } else {
        this.ascending = true;
        this.sortKey = col;
      }

      var ascending = this.ascending;

      this.monthly_ranking.sort(function(a, b) {
        if (a[col] > b[col]) {
          return ascending ? 1 : -1
        } else if (a[col] < b[col]) {
          return ascending ? -1 : 1
        }
        return 0;
      })
    },
   async getMonthlyRanking(){
       let that = this
       that.process = true
       that.snapshotText = ''
       await axios.get('/api/v1/monthly-ranking/'+that.selectedFundClassification.ft_id)
            .then(response => {
                that.monthly_ranking = response.data.data.monthly_ranking
                return true
            })
            .then(response => {
                let first_fund = that.monthly_ranking[0]
                var formattedMonth = moment(first_fund.end_date, 'YYYY-MM-DD').format('MMMM');
                var formattedYear = moment(first_fund.end_date, 'YYYY-MM-DD').format('YYYY');
                that.snapshotText = that.selectedFundClassification.name+' : For The Month of  '+formattedMonth+' , '+ formattedYear
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
            this.getMonthlyRanking()
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
            //that.getMonthlyRanking()
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