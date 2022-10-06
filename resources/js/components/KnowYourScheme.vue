<template>
<div class="compare-scemes-sec investing-tools perform-snapshot-tabs know-scheme-tabs select2-styles mt-5">
<div class="container">
    <ul class="nav nav-tabs border-0">
        <li><a class="" :class="{'active show':!getURLParams('fund_classification')}" data-toggle="tab" href="#tab-by-fund-house">By Fund House</a></li>
        <li><a class="" :class="{'active show':getURLParams('fund_classification')}" data-toggle="tab" href="#tab-by-classification">By Classification</a></li>
    </ul>
</div>
<div class="tab-wrapper">
    <div class="container">
        <div class="tab-content">

            <!-- KNOW YOUR SCHEME BY FUND HOUSE TAB START -->

            <div id="tab-by-fund-house" class="tab-pane fade in " :class="{'active show':!getURLParams('fund_classification')}">
                <form action="#" method="get">
                    <div class="invst-wrap">
                        <div class="row align-items-center">
                            <div class="col-lg-9 col-md-9 col-sm-12">
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
                </form>

                <div class="accordion-table border-w br-5" v-if="getURLParams('fund_house')">
                    <h6>Name of the Fund</h6>
                    <div id="accordion">
                        <div class="card" v-for="fund in funds" :key="fund.fund_id">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" :data-target="'#collapse'+fund.fund_id" aria-expanded="true" aria-controls="collapseOne">{{ fund.fund_name }}</button>
                                </h5>
                            </div>
                            <div :id="'collapse'+fund.fund_id" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>FundManager</th>
                                                <th>Opening Date</th>
                                                <th>Type Name</th>
                                                <th>Term Name</th>
                                                <th>Facevalue</th>
                                                <th>Risk Free Return</th>
                                                <th>Indices Name</th>
                                                <th>Classification</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ fund.fund_manager }}</td>
                                                <td>{{ fund.opening_date }}</td>
                                                <td>{{ fund.fundtype.name }}</td>
                                                <td>{{ fund.fundterm.term }}</td>
                                                <td>{{ fund.face_value }}</td>
                                                <td>{{ fund.risk_free_return }}</td>
                                                <td>{{ fund.indices_name }}</td>
                                                <td>{{ fund.classification }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </div>
                </div>

            </div>

            <!-- KNOW YOUR SCHEME BY FUND HOUSE TAB END -->

            <!-- KNOW YOUR SCHEME BY CLASSIFICATION TAB START -->

            <div id="tab-by-classification" class="tab-pane fade" :class="{'active show':getURLParams('fund_classification')}">
                    <div class="invst-wrap">
                        <div class="row align-items-center">
                            <div class="col-lg-9 col-md-9 col-sm-12">
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

                <div class="accordion-table border-w br-5" v-if="getURLParams('fund_classification')">
                    <h6>Name of the Fund</h6>
                    <div id="accordion" >
                        <div class="card" v-for="fund in funds" :key="fund.fund_id">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" :data-target="'#collapse'+fund.fund_id" aria-expanded="true" aria-controls="collapseOnee">{{ fund.fund_name }}</button>
                                </h5>
                            </div>
                            <div :id="'collapse'+fund.fund_id" class="collapse" aria-labelledby="headingOnee" data-parent="#accordion">
                                <div class="card-body">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>FundManager</th>
                                                <th>Opening Date</th>
                                                <th>Type Name</th>
                                                <th>Term Name</th>
                                                <th>Facevalue</th>
                                                <th>Risk Free Return</th>
                                                <th>Indices Name</th>
                                                <th>Classification</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ fund.fund_manager }}</td>
                                                <td>{{ fund.opening_date }}</td>
                                                <td>{{ fund.fundtype.name }}</td>
                                                <td>{{ fund.fundterm.term }}</td>
                                                <td>{{ fund.face_value }}</td>
                                                <td>{{ fund.risk_free_return }}</td>
                                                <td>{{ fund.indices_name }}</td>
                                                <td>{{ fund.classification }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </div>
                </div>
            </div>
            <!-- KNOW YOUR SCHEME BY CLASSIFICATION TAB END -->
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
            }
  },
  methods: {
   ...mapActions('InputData', ['getFundHouses','getFundClassifications','getFunds']),
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