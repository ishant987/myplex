<template>
<div class="container">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="select-service-common select-service-one">
                <p class="mb-50">
                     Lorem test tyfo Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s dummy text ever since the 1500s
                </p>
                <h4>Fund Performance</h4>
                <div class="home-select-wrap">
                    <multiselect
                        class=""
                        label="fund_name" 
                        track-by="fund_id"
                        v-model="selectedFund" 
                        tag-placeholder="" 
                        placeholder="Select Fund" 
                        :options="funds" 
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
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="select-service-common select-service-two">
                <p class="mb-50">
                     Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s dummy text ever since the 1500s
                </p>
                <h4>Performance Snapshot</h4>
                <div class="home-select-wrap">
                    <multiselect 
                    class=""
                    label="name" 
                    track-by="ft_id"
                    v-model="selectedFundClassification1" 
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
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="select-service-common select-service-three">
                <p>An unique layout that very simply outlines
                    various performance parameters, in numerical
                    and colour coded styles that help you in 
                    understanding how funds have performed. 
                    Your first evaluation tool
                </p>
                <h4>Monthly Ranking</h4>
                <span class="span-title text-capitalize" v-if="monthly_ranking_date">For The Month of {{monthly_ranking_date.date_month}} {{monthly_ranking_date.date_year}}</span>
                <div class="home-select-wrap">
                    <multiselect 
                    class=""
                    label="name" 
                    track-by="ft_id"
                    v-model="selectedFundClassification2" 
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
            </div>
        </div>
    </div>
</div>
</template>
<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>

<script>
import Multiselect from '@suadelabs/vue3-multiselect'
import mixin from '../mixin';
import { mapGetters, mapActions } from 'vuex'
import moment from 'moment';
export default {
    props: {
        
    },
    components: {
      Multiselect,
  },
  mixins: [mixin],
   data() {
            return {
                snapshotText: null,
                process:false,
                selectedFund:null,
                selectedFundClassification1:null,
                selectedFundClassification2:null,
                monthly_ranking_date:null
            }
  },
  methods: {
   ...mapActions('InputData', ['getFundClassifications','getFunds']),
   
   async getMonthlyRankingDates(){
       let that = this
       that.process = true
       that.snapshotText = ''
       await axios.get('/api/v1/monthly-ranking-date')
            .then(response => {
                that.monthly_ranking_date = response.data.data
                return true
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
    selectedFund(value){
        if(value){
            window.location.href = 'fund-performance?fund_code='+encodeURIComponent(value.fund_code)
        }
    },
    selectedFundClassification1(value){
        if(value){
            window.location.href = 'performance-snapshot?fund_type_id='+encodeURIComponent(value.ft_id)+'&type=weekly&report_category=return&date='+moment().format('YYYY-MM-DD')
        }
    },
    selectedFundClassification2(value){
        if(value){
            window.location.href = 'monthly-ranking?fund_classification='+encodeURIComponent(value.name)
        }
    }
  },
  computed: {
    ...mapGetters('InputData', ['loading','fundClassifications','funds']),
  },
  mounted() {
    let that = this
    that.getMonthlyRankingDates()
    that.getFundClassifications()
    that.getFunds({})
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