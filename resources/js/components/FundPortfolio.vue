<template>
<section class="info_monitor_sec">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="info_monitor_inner">
                    <div class="info_monitor_inner_wrapper mb-3">
                        <div class="monthly_ranking_title d-block d-sm-flex align-items-center justify-content-between mb-3">
                            <div class="monthly_ranking_text">
                                <h4>Fund Portfolio</h4>
                            </div>
                        </div>
                        <div class="monthly_ranking_Search_part mb-1">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <h6 class="text-green-2">Fund House Name</h6>
                                    <multiselect class="" label="fund_house" track-by="fund_house" v-model="selectedFundHouse" tag-placeholder="" placeholder="Select Fund House" :options="fundHouses" :multiple="false" :taggable="false" selectLabel="" :searchable="true" :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150" :showNoResults="true">
                                    </multiselect>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <h6 class="text-green-2">Fund Name</h6>
                                    <multiselect :disabled="!selectedFundHouse" class="" label="fund_name" track-by="fund_id" v-model="selectedFund" tag-placeholder="" placeholder="Select Fund" :options="funds" :multiple="false" :taggable="false" selectLabel="" :searchable="true" :block-keys="['Tab', 'Enter', 'backspace']" :max-height="150" :showNoResults="true">
                                    </multiselect>
                                </div>
                            </div>
                        </div>
                        <div class="monthly_ranking_table">
                            <div class="datatable_ll main_trer">
                                <div class="table-responsive">
                                    <CustomTable  :id="'example'" :columns="columns" :rows="portfolio" default_sort_key="script_name" :order_ascending="true" tabindex="1"></CustomTable>
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
import {
    mapGetters,
    mapActions
} from 'vuex'
export default {
    components: {
        CustomTable,
        Multiselect,
    },
    mixins: [mixin],
    data() {
        return {
            sortKey: '',
            ascending: false,
            search: '',
            selectedFundHouse: '',
            selectedFund: '',
            columns: [{
                    name: 'Scrip',
                    key: 'scrip_name'
                },
                {
                    name: 'Category',
                    key: 'category'
                },
                {
                    name: 'Industry',
                    key: 'industry'
                },
                {
                    name: 'Content%',
                    key: 'content_per'
                },
                {
                    name: 'Amount (Rs. In Lacs*)',
                    key: 'amount'
                }
            ],
            portfolio: [],
            totalAmount: null,
            process: false,
            app_url:process.env.MIX_APP_ENV=='local' ?  process.env.MIX_API_URL_LOCAL :'',
        }
    },
    methods: {
        ...mapActions('InputData', ['getFundHouses', 'getFunds']),
        async getFundPortfolio() {
            let that = this
            that.process = true
            await axios.get(that.app_url+'/api/v1/fund-portfolio', {
                    params: {
                        fund_code: that.selectedFund.fund_code
                    }
                })
                .then(response => {
                    that.portfolio = response.data.data.portfolio
                    Object.keys(that.portfolio).map(function (key, index) {
                        that.portfolio[index].amount = that.portfolio[index].amount.toFixed(2);
                    });
                    that.totalAmount = response.data.data.total_amount
                })
                .catch(error => {
                    var message = error.response.data.message || error.message
                    console.log(message);
                })
                .finally(() => {
                    that.process = false
                })
        },
    },
    watch: {
        selectedFundHouse(value) {
            this.selectedFund = null
            if (value) {
                this.addParamToURL('fund_house', value.fund_house)
                this.getFunds({
                    fund_house: value.fund_house
                })
            } else {
                this.removeURLParameter('fund_house')
                this.$store.commit('InputData/setFunds', [])
            }
        },
        selectedFund(value) {
            if (value) {
                this.addParamToURL('fund_code', value.fund_code)
                this.getFundPortfolio()
            } else {
                this.removeURLParameter('fund_code')
                this.portfolio = []
                this.totalAmount = null
            }
        },
    },
    computed: {
        ...mapGetters('InputData', ['loading', 'fundHouses', 'funds']),
    },
    mounted() {
        let that = this
        let fund_house = that.getURLParams("fund_house")
        let fund_code = that.getURLParams("fund_code")

        const myPromise = new Promise(async (resolve, reject) => {
            await this.getFundHouses()
            resolve(true)
        });

        myPromise.then(async (resolve, reject) => {
            if (fund_house) {
                that.selectedFundHouse = that.fundHouses.filter(function (el) {
                    return el.fund_house == fund_house
                })[0]
                await that.getFunds({
                    fund_house: that.selectedFundHouse.fund_house
                })
            }
            return true
        }).then(async (resolve, reject) => {

            if (fund_code) {
                that.selectedFund = that.funds.filter(function (el) {
                    return el.fund_code == fund_code
                })[0]
            }
            return true
        })
    },
}
</script>
