<template>
     <section class="info_monitor_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="info_monitor_inner">
                        <div class="info_monitor_inner_wrapper mb-3">
                            <div class="monthly_ranking_title d-block d-sm-flex align-items-center justify-content-between mb-3">
                                <div class="monthly_ranking_text">
                                    <h4>{{ page_title }}</h4>
                                    <p v-if="snapshotTextHeding">{{snapshotTextHeding}}</p>
                                </div>
                                <div class="monthly_ranking_share d-block d-sm-flex">
                                    <a  target="_blank" :href="'https://www.facebook.com/sharer/sharer.php?u='+currentURL()"  class="share_btn facebook"><i class="ph-facebook-logo"></i> Facebook</a>
                                    <a  target="_blank" :href="'http://twitter.com/share?text='+shareText+'&url='+currentURL()" class="share_btn twitter"><i class="ph-twitter-logo"></i> Twitter</a>
                                    <a target="_blank" :href="'https://www.linkedin.com/shareArticle?mini=true&url='+currentURL()+'&title='+shareText" class="share_btn linkedin"><i class="ph-linkedin-logo"></i> Linkedin</a>
                                    <a href="javascript://" class="share_btn pdf" @click="downloadPDF"><i class="ph-file-pdf"></i> Pdf</a>
                                </div>
                            </div>
                            <div class="monthly_ranking_Search_part mb-1">
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
                                    :max-height="200"
                                    :showNoResults="true"
                                    >
                                </multiselect>
                                <p class="mt-3" v-if="snapshotText">Type of Fund : {{snapshotText}}</p>
                            </div>
                            <div class="monthly_ranking_table">
                                <div class="datatable_ll main_trer">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-striped" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th style="background-color: #fff !important" colspan="3"></th>
                                                    <th style="background-color: #222222 !important" colspan="3">Ranking</th>
                                                </tr>
                                                <tr>
                                                    <th>Name of Fund</th>
                                                    <th>AAUM (Lacs)</th>
                                                    <th>Return %</th>
                                                    <th>Return Quality</th>
                                                    <th>Volitilty</th>
                                                    <th>Market Risk</th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="!process">
                                                <tr  v-for="(fund,index) in monthly_ranking" :key="index" :class="index%2 ? 'even' : 'odd'">
                                                    <td data-label="Name of Fund">
                                                        {{ fund.fund_name }}
                                                    </td>
                                                    <td data-label="AAUM">
                                                        <span v-if="fund.per_change_aaum !== null">{{ fund.aaum.toFixed(2) }}</span>
                                                        <span v-else>NA</span>
                                                    </td>
                                                    <td data-label="Return %">
                                                        <span v-if="fund.one_year_return !== null ">{{ fund.one_year_return.toFixed(2) }}</span>
                                                        <span v-else>NA</span>
                                                    </td>
                                                    <td data-label="Return Quality">
                                                        <div class="return_quality_td">
                                                            <i v-for="count in fund.return_quality" class="ph-star-fill active" :id="count">
                                                            </i>
                                                            <i v-if=" fund.return_quality!==null" v-for="countStart in getRemaningStars(fund.return_quality)" class="ph-star-fill" :class="index%2 ? '' : 'grey'" :id="countStart+'empty'"></i>
                                                            <span v-else>NA</span>
                                                        </div>
                                                    </td>
                                                    <td data-label="Volitilty">
                                                        <img style="padding-right:2px" v-if="fund.volatality !== null " v-for="count in fund.volatality"  :src="`/images/fire_icon.png`" :title="count" :alt="count" >&nbsp;
                                                        <span v-else>NA</span>
                                                    </td>
                                                    <td data-label="Market Risk">
                                                        <img style="padding-right:2px" v-if="fund.market_risk !== null " v-for="count in fund.market_risk"  :src="`/images/fire_icon.png`" :title="count" :alt="count" >&nbsp;
                                                        <span v-else>NA</span>
                                                    </td>
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
import LoadingBar from "./Common/loading";
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
      LoadingBar
  },
  mixins: [mixin],
   data() {
            return {
                sortKey: 'fund_name',
                ascending: true,
                selectedFundClassification:'',
                monthly_ranking: [],
                snapshotText: null,
                snapshotTextHeding: null,
                process:false,
                app_url:process.env.MIX_APP_ENV=='local' ?  process.env.MIX_API_URL_LOCAL :'',
                counts:2,
                defaultStart:5,
                shareText:''
            }
  },
  methods: {
   ...mapActions('InputData', ['getFundClassifications']),
   getRemaningStars(rates){
        return typeof rates=='number'? this.defaultStart-rates:0;
   },
   currentURL(){
    return window.location.href
   },
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
       await axios.get(that.app_url+'/api/v1/monthly-ranking/'+that.selectedFundClassification.ft_id)
            .then(response => {
                that.monthly_ranking = response.data.data.monthly_ranking
                return true
            })
            .then(response => {
                let first_fund = that.monthly_ranking[0]
                var formattedMonth = moment(first_fund.end_date, 'YYYY-MM-DD').format('MMMM');
                var formattedYear = moment(first_fund.end_date, 'YYYY-MM-DD').format('YYYY');
                that.snapshotTextHeding='For The Month of  '+formattedMonth+' , '+ formattedYear;
                that.snapshotText = that.selectedFundClassification.name
                that.shareText = 'Monthly Ranking For the Month of  '+formattedMonth+' '+ formattedYear
            })
            .catch(error => {
                console.log(error);
            })
            .finally(() => {
                that.process = false
            })
   },
   downloadPDF(){
       window.open('/monthly-ranking-pdf/'+this.selectedFundClassification.ft_id, '_blank');
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
            that.getMonthlyRanking()
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