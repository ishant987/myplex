<template>
    <section class="info_monitor_sec">
        <div class="container">
            <div class="portfoliodiv">
                <div class="row mb-4">
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-4 index_changes_header">
                        <h4>Fund House Name</h4>
                        <multiselect class="" label="fund_house" track-by="fund_house" v-model="selectedFundHouse" tag-placeholder="" placeholder="Select Fund House" :options="fundHouses" :multiple="false" :taggable="false" selectLabel="" :searchable="true" :block-keys="['Tab', 'backspace']" :max-height="150" :showNoResults="true">
                        </multiselect>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 index_changes_header">
                        <h4>Fund Name</h4>
                        <multiselect :disabled="!selectedFundHouse" class="" label="fund_name" track-by="fund_id" v-model="selectedFund" tag-placeholder="" placeholder="Select Fund" :options="funds" :multiple="false" :taggable="false" selectLabel="" :searchable="true" :block-keys="['Tab', 'backspace']" :max-height="150" :showNoResults="true">
                        </multiselect>
                    </div>
                </div>
				<div class="row" v-if="isFundHouseSelected && isFundNameSelected">
					<div class="col-md-12">
						<h4>Fund Portfolio for {{ lastMonth }}, {{ lastYear }}</h4>
						<div class='seperate_heading'>
                        <h5>- {{ selectedFundHouse.fund_house }}</h5>
                        <h5>- {{ selectedFund.fund_name }}</h5>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="info_monitor_inner">
                            <div class="info_monitor_inner_wrapper">
                                <div class="monthly_ranking_table">
                                    <div class="datatable_ll main_trer">
                                        <div class="table-responsive">								
                                            <CustomTable  id="fund-portfolio" :columns="columns" :rows="portfolio.filter(function(el) { return true })" default_sort_key="script_name" :order_ascending="true" tabindex="2"></CustomTable>
                                            <div class="table-total text-right" v-if="totalAmount">
                                                <p>Total Amount (Rs. in Crores) <span class="total-amount">{{totalAmount}}/-</span></p>
												
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
				isFundHouseSelected: false,
				isFundNameSelected: false,
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
                        name: 'Amount (Rs. In Crores*)',
                        key: 'amount'
                    }
                ],
                portfolio: [],
                lastMonth: '',
                lastYear: '',
                totalAmount: 0,
                process: false,
				numberToWords: 0,
                app_url:process.env.MIX_APP_ENV=='local' ?  process.env.MIX_API_URL_LOCAL :'https://www.myplexus.com',
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
                            that.portfolio[index].lacsamount = that.portfolio[index].amount.toFixed(2);
                            that.portfolio[index].amount = (that.portfolio[index].lacsamount / 100).toFixed(2);
                        });
						that.numberToWords = parseFloat(response.data.data.total_amount);
                        that.totalAmount = parseFloat(response.data.data.total_amount / 100).toLocaleString('en-IN', {minimumFractionDigits: 2});
                        that.lastMonth = response.data.data.month;
                        that.lastYear = response.data.data.year;
						
						//that.selectedFundHouse = '';
						//that.selectedFund = '';
                    })
                    .catch(error => {
                        var message = error.response.data.message || error.message
                        console.log(message);
                    })
                    .finally(() => {
                        that.process = false
                    })
            }, 
            getPreviousMonth() {
                const currentDate = new Date();
                const previousMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, 1);
                // Convert month number to month name (e.g., 0 -> "January", 1 -> "February", etc.)
                const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                return monthNames[previousMonth.getMonth()];
            },
            getCurrentYear() {
                const currentDate = new Date();
                return currentDate.getFullYear();
            },
			
			inWords (value) {
				var a = [
						'',
						'One ',
						'Two ',
						'Three ',
						'Four ',
						'Five ',
						'Six ',
						'Seven ',
						'Eight ',
						'Nine ',
						'Ten ',
						'Eleven ',
						'Twelve ',
						'Thirteen ',
						'Fourteen ',
						'Fifteen ',
						'Sixteen ',
						'Seventeen ',
						'Eighteen ',
						'Nineteen '];
					var b = [
						'',
						'',
						'Twenty',
						'Thirty',
						'Forty',
						'Fifty',
						'Sixty',
						'Seventy',
						'Eighty',
						'Ninety'];
				
		let number = parseFloat(value).toFixed(2).split(".")
        let num = parseInt(number[0]);
        let digit = parseInt(number[1]);
				
				 if ((num = num.toString()).length > 9) return 'overflow';
    var n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
	const d = ('00' + digit).substr(-2).match(/^(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'Rupee ' : '';
	str += (Number(d[1]) !== 0) ? ((str !== '' ) ? "and " : '') + (a[Number(d[1])] || b[d[1][0]] + ' ' + a[d[1][1]]) + 'Paise Only' : 'Only';
    return str;
			},
            
            
        },
        watch: {
            selectedFundHouse(value) {
                this.selectedFund = null
                if (value) {
					this.isFundHouseSelected=true;
                    this.addParamToURL('fund_house', value.fund_house)
                    this.getFunds({
                        fund_house: value.fund_house
                    })
                } else {
					this.isFundHouseSelected=false;
                    this.removeURLParameter('fund_house')
                    this.$store.commit('InputData/setFunds', [])
                }
            },
            selectedFund(value) {
                if (value) {
					this.isFundNameSelected=true;
                    this.addParamToURL('fund_code', value.fund_code)
                    this.getFundPortfolio()
                } else {
					this.isFundNameSelected=false;
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
    