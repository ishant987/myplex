<template>
    <section class="compare_scheme">
        <div class="container">
            <div class="comp_schem_bdr">
    <div class="tab_snap_shot">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " :class="{'active show':!getURLParams('fund_classification')}" id="pills-weekly-tab" data-bs-toggle="pill" data-bs-target="#pills-weekly" type="button" role="tab" aria-controls="pills-weekly" aria-selected="true"><i class="ph-calendar-check"></i> By Fund House</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" :class="{'active show':getURLParams('fund_classification')}" id="pills-monthly-tab" data-bs-toggle="pill" data-bs-target="#pills-monthly" type="button" role="tab" aria-controls="pills-monthly" aria-selected="false"><i class="ph-calendar"></i> By Classification</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-weekly" role="tabpanel" aria-labelledby="pills-weekly-tab" >
                            <div class="top_table_bg_color mb-3">
                                <div class="row align-items-end">
                                    <div class="col-lg-10">
                                        <div class="row align-items-end">
                                            <div class="col-lg-8">
                                                <div class="form_select">
                                                    <multiselect 
                                                        class=""
                                                        label="fund_house" 
                                                        track-by="fund_house"
                                                        v-model="selectedFundHouse" 
                                                        tag-placeholder="" 
                                                        placeholder="Select Fund House" 
                                                        :options="fundHouses" 
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
                            </div>
                            <div v-if="getURLParams('fund_house')">
                            <h4 class="heading_opt mb-3">Name of the Fund</h4>
                            <div class="single_scheme__fund mb-2" v-for="fund in funds" :key="fund.fund_id">
                                <a class="" data-bs-toggle="collapse" @click="showFundHouse(fund.fund_id)" :href="'#collapseExample'+fund.fund_id" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    {{ fund.fund_name }}
                                </a>
                                <div class="collapse" :class="{'show':fh_code ==fund.fund_id}" :id="'#collapseExample'+fund.fund_id">
                                    <div class="card card-body">
                                        <div class="single_comparee_fund_cont d-block d-sm-flex w-100">
                                            <li>
                                                <h4>Fund Manager</h4>
                                                <p>{{ fund.fund_manager }}</p>
                                            </li>
                                            <li>
                                                <h4>Opening Date</h4>
                                                <p>{{ fund.opening_date }}</p>
                                            </li>
                                            <li>
                                                <h4>Type Name</h4>
                                                <p>{{ fund.fundtype.name }}</p>
                                            </li>
                                            <li>
                                                <h4>Term Name</h4>
                                                <p>{{ fund.fundterm.term }}</p>
                                            </li>
                                            <li>
                                                <h4>Face Value</h4>
                                                <p>{{ fund.face_value }}</p>
                                            </li>
                                            <li>
                                                <h4>Risk Free Return</h4>
                                                <p>{{ fund.risk_free_return }}</p>
                                            </li>
                                            <li>
                                                <h4>Indices Name</h4>
                                                <p>{{ fund.indices_name }}</p>
                                            </li>
                                            <li>
                                                <h4>Classification</h4>
                                                <p>{{ fund.classification }}</p>
                                            </li>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-monthly" role="tabpanel" aria-labelledby="pills-monthly-tab" :class="{'active show':getURLParams('fund_classification')}">
                            <div class="top_table_bg_color mb-3">
                                <div class="row align-items-end">
                                    <div class="col-lg-10">
                                        <div class="row align-items-end">
                                            <div class="col-lg-8">
                                                <div class="form_select">
                                                    <multiselect 
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="getURLParams('fund_classification')">
                            <h4 class="heading_opt mb-3">Name of the Fund</h4>
                            <div class="single_scheme__fund mb-2" v-for="fund in funds" :key="fund.fund_id">
                                <a class="" data-bs-toggle="collapse" @click="showFundClass(fund.fund_id)" :href="'#collapseExample'+fund.fund_id" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    {{ fund.fund_name }}
                                </a>
                                <div class="collapse" :class="{'show':fc_code ==fund.fund_id}" :id="'#collapseExample'+fund.fund_id">
                                    <div class="card card-body">
                                        <div class="single_comparee_fund_cont d-block d-sm-flex w-100">
                                            <li>
                                                <h4>Fund Manager</h4>
                                                <p>{{ fund.fund_manager }}</p>
                                            </li>
                                            <li>
                                                <h4>Opening Date</h4>
                                                <p>{{ fund.opening_date }}</p>
                                            </li>
                                            <li>
                                                <h4>Type Name</h4>
                                                <p>{{ fund.fundtype.name }}</p>
                                            </li>
                                            <li>
                                                <h4>Term Name</h4>
                                                <p>{{ fund.fundterm.term }}</p>
                                            </li>
                                            <li>
                                                <h4>Face Value</h4>
                                                <p>{{ fund.face_value }}</p>
                                            </li>
                                            <li>
                                                <h4>Risk Free Return</h4>
                                                <p>{{ fund.risk_free_return }}</p>
                                            </li>
                                            <li>
                                                <h4>Indices Name</h4>
                                                <p>{{ fund.indices_name }}</p>
                                            </li>
                                            <li>
                                                <h4>Classification</h4>
                                                <p>{{ fund.classification }}</p>
                                            </li>
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
import Multiselect from '@suadelabs/vue3-multiselect'
import mixin from '../mixin';
import { mapGetters, mapActions } from 'vuex'
export default {
    components: {
      Multiselect,
  },
  mixins: [mixin],
   data() {
            return {
                sortKey: '',
                ascending: false,
                search: '',
                selectedFundHouse:'',
                selectedFundClassification:'',
                columns: [
                    {name:'Scrip', key:'scrip_name'}, 
                    {name:'Category', key:'category'},
                    {name:'Industry', key:'industry'},
                    {name:'Content%', key:'content_per'},
                    {name:'Amount (Rs. In Lacs*)', key:'amount'}
                ],
                portfolio: [],
                totalAmount: null,
                process:false,
                fh_code:'',
                fc_code:'',
            }
  },
  methods: {
   ...mapActions('InputData', ['getFundHouses','getFundClassifications','getFunds']),
   showFundHouse(fundcode){
    this.fh_code=fundcode;
   },
   showFundClass(fundcode){
    this.fc_code=fundcode;
   }
  },
  watch: {
    selectedFundHouse(value) {
        this.$store.commit('InputData/setFunds', [])
        if(value){
            this.removeURLParameter('fund_classification')
            this.addParamToURL('fund_house', value.fund_house)
            this.getFunds({fund_house:value.fund_house})

        }else{
            this.removeURLParameter('fund_house')
        }
    },
    selectedFundClassification(value) {
        this.$store.commit('InputData/setFunds', [])
        if(value){
            this.removeURLParameter('fund_house')
            this.addParamToURL('fund_classification', value.name)
            this.getFunds({fund_classification:value.name})
        }else{
            this.removeURLParameter('fund_classification')
        }
    },
    },
  computed: {
    ...mapGetters('InputData', ['loading','fundHouses','fundClassifications','funds']),
  },
  mounted() {
    let that = this
    let fund_house = that.getURLParams("fund_house")
    let fund_classification = that.getURLParams("fund_classification")

    const myPromise = new Promise(async (resolve, reject) => {
        await this.getFundHouses()
        await this.getFundClassifications()
        resolve(true)
    });
    
    myPromise.then( async (resolve, reject) => {
        if(fund_house){
            that.selectedFundHouse = that.fundHouses.filter(function(el) { return el.fund_house == fund_house })[0]
            that.getFunds({fund_house:that.selectedFundHouse})
        }
        return true
    }).then( async (resolve, reject) => {
        if(fund_classification){
            that.selectedFundClassification = that.fundClassifications.filter(function(el) { return el.name == fund_classification })[0]
            that.getFunds({fund_classification:that.selectedFundClassification})
        }
    })
  },
}
</script>