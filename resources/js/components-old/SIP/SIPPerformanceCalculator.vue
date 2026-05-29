<template>
   <div class="comp_schem_bdr">
      <div class="s_renge sip_calc_range_grop p-0">
         <div class="row calbanner">
            <div class="l">
               <h4 class="heading-green">SIP Planner</h4>
               <p>This calculator helps to understand wealth accumulation through investment on monthly basis.</p>
            </div>
            <div class="r">
               <img src="https://new.myplexus.com/themes/frontend/assets/v1/img/cal-1.png">
            </div>
         </div>
         <div class="row">
            <div class="col-md-12 left-side">
               <div class="row ">
                  <div class="col-lg-4 col-md-12 d-none">
                     <div class="cal_form_select">
                        <label for="">Name</label>
                        <input class="form-text" type="text" placeholder="Enter Full Name" v-model="name" />
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-12 d-none">
                     <div class="cal_form_select">
                        <label for="">Email</label>
                        <input class="form-text" type="text" placeholder="Enter Your Email" v-model="email"  />
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-12 mb-4 d-none">
                     <div class="cal_form_select">
                        <label for="">Phone</label>
                        <input class="form-text" type="text" placeholder="Enter Phone Number" v-model="phone"  />
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-4 col-md-12 mb-4">
                     <div class="cal_form_select">
                        <label for=""><strong>SIP Amount (Rs.) *: <i class="ph ph-question" data-toggle="tooltip" data-placement="top" title="The amount which you want to invest every month"></i></strong></label>
                        <input class="form-text" type="text" placeholder="" v-model="sip_amount" />
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-12 mb-4">
                     <div class="cal_form_select">
                        <label for=""><strong>Duration (months) *: <i class="ph ph-question" data-toggle="tooltip" data-placement="top" title="For how long you want to invest"></i></strong></label>
                        <input class="form-text" type="text" placeholder="no. of months" v-model="duration_months"  />
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-12 mb-4">
                     <div class="cal_form_select">
                        <label for=""><strong>Select Fund *: <i class="ph ph-question" data-toggle="tooltip" data-placement="top" title="Tooltip content"></i></strong></label>
                        <select class="form-text" id="sip_fund_performance" v-model="selectedFund">
                           <option value="">Select Fund</option>
                           <option v-for="fund in funds" :value="fund">{{fund.fund_name}}</option>
                        </select>
                     </div>
                  </div>
                  <div class="three_btn one_btn text-center">
                     <div class="middle_left d-inline">
                        <a href="javascript://" id="calculate-ship-perfromance" :disabled="process"
                           @click="sipCalculations" class="btn-cal">Calculate</a>
                     </div>
                  </div>
               </div>
               <div class="row d-none">
                  <div class="col-lg-3 col-md-12">
                     <div class="range-slider-wrapper">
                        <span class="slider-heading">SIP Amount (Rs.)</span>
                        <div id="slider-bedrooms" class="slider" data-min="0" data-max="10000" data-value="" data-step="1000" data-type="sip_amount"></div>
                        <input class="vue-value" data-from="sipPerformance" type="hidden" ref="sipAmount" value="7" :disabled="process" />
                     </div>
                  </div>
                  <div class="col-lg-3 col-md-12">
                     <div class="range-slider-wrapper">
                        <span class="slider-heading">Duration (Month)</span>
                        <div id="slider-price" class="slider" data-min="10" data-max="100" data-value="" data-step="10" data-type="duration_months"></div>
                        <input class="vue-value" data-from="sipPerformance" type="hidden" ref="sipDuration" value="10" :disabled="process" />
                     </div>
                  </div>
                  <div class="col-lg-3 col-md-12">
                     <div class="range-slider-wrapper">
                        <span class="slider-heading">Day of SIP</span>
                        <div id="slider-bedrooms" class="slider" data-min="0" data-max="31" data-value="0" data-step="1" data-type="sip_day"></div>
                        <input class="vue-value" data-from="sipPerformance" type="hidden" ref="sipDay" value="" :disabled="process" />
                     </div>
                  </div>
                  <div class="col-lg-3 col-md-12">
                     <div class="cal_form_select">
                        <label class="mb-3" for="">Select Fund</label>
                        <select class="form-text" id="sip_fund_performance" v-model="selectedFund" @change="sipCalculations" :disabled="process">
                           <option value="">Select Fund</option>
                           <option v-for="fund in funds" :value="fund">{{fund.fund_name}}</option>
                        </select>
                     </div>
                  </div>
                  <a href="javascript://" id="show-table-click" class="money_title_btn d-none" @click="sipCalculations"  :disabled="process"></a>
               </div>
               <div class="row d-sm-flex d-block sip_calc_input mt-3" v-if="Object.keys(sipCalculatedData).length">
                  <table class="table table-striped" style="width:100%">
                     <thead>
                        <tr>
                           <th>Return Rate (%)</th>
                           <th>Your Investments (Rs.)</th>
                           <th>Your Current Value (Rs.)</th>
                           <th>Your Current Nav (Rs.)</th>
                           <th>Your Total Unit</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td>{{ sipCalculatedData.sip_return }}</td>
                           <td>{{ Number(sipCalculatedData.invested_amount).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }}</td>
                           <td>{{ Number(sipCalculatedData.current_value).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }}</td>
                           <td>{{ sipCalculatedData.current_nav }}</td>
                           <td>{{ Number(sipCalculatedData.total_unit).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }}</td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <div class="invst-wrap invst-sip-performace">
         <div class="w-100 text-center mt-5" v-if="process">
            <div class="text-center mt-3">
               <LoadingBar :status="process"></LoadingBar>
            </div>
         </div>
         <div class="invst-fields-graph" >
            <p v-if="emailMsg" class="text-success mt-3 mb-3 w-100 text-right">{{ emailMsg }}</p>
            <div class="row mt-5">
               <div id="screen_capture" class="mt-3 w-100">
                  <div class="col-md-12">
                     <div class="graph_div" ref="printMe">
                        <div id="chartContainerSIP" style="width: 100%; " :class="{'height_370':showchart}"></div>
                        <div v-show="showchart" style="height:30px; width:70px; background:#fff; position:absolute; z-index:999;bottom: 0; display:none;" id="myplexusC"></div>
                     </div>
                  </div>
               </div>
            </div>
            <div>&nbsp;</div>
            <div class="invst-fields-action-buttons" v-if="Object.keys(sipCalculatedData).length " attr-d="justify-content-end" style="position: relative;
               z-index: 9999;">
               <div class="row m-0 ">
                  <div class="col-md-3 action-common action-btn-1">
                     <a href="javascript://" id="show-table" class="money_title_btn" @click="showTableFunction">Show In Table</a>
                  </div>
                  <div class="col-md-3 action-common action-btn-2 d-none">
                     <a href="javascript://" id="send-email" class="money_title_btn" :disabled="processEmail" @click="send_graph_result">Send Results In Email</a>
                  </div>
               </div>
            </div>
         </div>
         <div>&nbsp;</div>
         <!-- SIP CALCULATOR GRAPH DIV START v-show="showTable && !process" -->
         <div id="sip-performance-calc-data" class="monthly_ranking_table"  v-if="Object.keys(sipCalculatedData).length && showTable">
            <div class="datatable_ll main_trer">
               <div class="table-responsive">
                  <table class="table table-striped" style="width:100%">
                     <thead>
                        <tr>
                           <th>SI No.</th>
                           <th>SIP Date</th>
                           <th>NAV</th>
                           <th>SIP Amount</th>
                           <th>No.of Unit</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr v-for="(data,index) in sipCalculatedData.table_data" :key="index">
                           <td>{{ index+1 }}</td>
                           <td>{{ data.date }}</td>
                           <td>{{ data.nav }}</td>
                           <td>{{ data.sip_value }}</td>
                           <td>{{ data.sip_units }}</td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <!-- SIP CALCULATOR GRAPH DIV END -->
   </div>
   <div class="plan_faq">
      <div class="faq_title">
         <h4>FAQ - <span>Frequently asked questions</span></h4>
      </div>
      <p>All the questions that you want to know the answers to - the why, the how, the what etc. neatly put forth for your benefit.</p>
      <div class="single_faq_calc">
         <h4>What is SIP?</h4>
         <p>Do you want to make a lot of money sometime in the future without worrying about short term swings and always beat markets and have ample access to the money that you have invested yet be relatively sure that the targets would be met? If just reading this long sentence has wound you up but if your wish list is really this long then here it is. The best thing to have happened to us since Aladdin’s Lamp is here and we explain everything about it. Read on if you want to know everything about it and if you still have some queries then let us know and we would try to clear all your doubts.</p>
         <p>SIP is the popular shortened form for Systematic Investment Plan. This form of investing refers to the system of putting in small amounts at regular intervals into a mutual fund scheme to meet a, or a set of medium to long-term goals. The principle of regular investing provides a working mechanism of beating markets - IT IS NOT ONLY IMPORTANT HOW MUCH YOU INVEST IN THE MARKETS BUT IT IS FAR MORE IMPORTANT HOW MANY TIMES YOU INVEST.</p>
         <p>Further, it has been observed that target based investments are the most likely to succeed. The reasons for this are not very difficult to find. The discipline to save and invest for the target is high because there is a tangible objective and more importantly YOU have set the objective. So it can be assumed that once you have set for yourself a target, viz. buying a house, higher education for the children or your own retirement planning, you would be more focused on meeting these objectives. But remember, discipline is the most important factor and it makes sense that the discipline is strictly enforced.</p>
      </div>
      <div class="single_faq_calc">
         <h4>What are the benefits of SIP?</h4>
         <h6>Long term wealth creation</h6>
         <p>SIP provides an easy way for you to pace yourself towards a stated goal. Instead of needing to put down a large amount in one go, you can calculate how much you need to put in on, lets say a monthly basis. But please remember SIP does not work on short terms and there is no way you would predict markets on an annual basis. The minimum duration that we would advice is three years but it gets better the longer it goes.</p>
         <h6>Low risk</h6>
         <p>We are often compelled to envy someone who has made a killing in the stock markets but we completely ignore the many instances when he had seen his money simply vanish. Nor do we really advertise our goof ups as readily as we speak of our successes. But please understand-it is impossible to beat the markets and even the best fund managers would come short on beating markets all the time. But we can definitely, largely de-risk ourselves from the entire gamut of high markets and low markets and needing to stay one step ahead. By riding on all the cycles, it simply averages out the highs and the lows. So long as the economy grows it is impossible that the markets or specifically the stock market indices would not. Markets always tend to move along with the P.E(refers to the ratio of the price of the stock to the profit per share) growth of the market, apart from temporary aberrations. Just use this simple and easy step to make your fortune.</p>
         <h6>Liquidity</h6>
         <p>What happens if we suddenly needed some money, a little more than we have immediate access to? Mutual funds and the equity mutual funds are largely open ended, and we advocate largely open ended schemes. The good news is that you can pull out the entire amount lying in your account. Just like that. No questions asked. And the entire amount would be in your bank account within three working days.</p>
         <h6>Predictability</h6>
         <p>Can we look into our crystal ball and say that SIP is guaranteed to make money? The simple answer is yes but with a condition. As long as we are investing in equities, in an economy that is growing then we can safely say that we are guaranteed of performance. It has been proven across diverse markets and a variety of time spans with the same set of results. It is so common in the western world that SIP is now the most preferred way to accumulate wealth amongst the salary earning population as well as self employed professionals. Frankly do you expect that India would not grow or even worse, go down in the next decade or more? Really that is not impossible but very very unlikely.</p>
         <h6>Who all should use the system – what age, what profile, what stage of life etc.</h6>
         <p>SIP is a long-term wealth creation tool. It is best suited for Professionals who would want to painlessly plan for their long-term goals. Self-employed professionals who need to definitely plan for their long-term goals and who do not have the benefit of pension, gratuity etc. Businessmen who would want to hedge their risk by not putting everything back into their own business but also take minor position in other business cycles as well. For those planning to utilize the Income Tax bracket. Everybody else!!!!!!</p>
         <h6>How does it work?</h6>
         <p>Starting an SIP is very simple. You just need to fill up a form and payments could be made by cheques or by using the auto debit facility from your bank. But you can stop the payments for one time or for several times or for the remainder of the stated time frame. It is actually very simple. Unless of course it is a lock in scheme where the scheme does not allow withdrawal.</p>
         <h6>Tax benefits</h6>
         <p>Mutual fund schemes (the ones that are majorly invested in equity) do not have any long term capital gains tax, dividends are tax free and short term capital gains are taxed at 10% Plus surcharge.</p>
      </div>
   </div>
</template>
<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>

<script>
import moment from 'moment';
import Multiselect from '@suadelabs/vue3-multiselect'
import mixin from '../../mixin';
import LoadingBar from "./../Common/loading";
var CanvasJS = require('../../canvasjs.min.js');
import {
    mapGetters,
    mapActions
} from 'vuex'
export default {
    props: {
        username: {
            type: String,
            required: true,
            default: '',
        },
        useremail: {
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
            name: this.username,
            email: this.useremail,
            phone:'',
            process: false,
            showchart: false,
            chart: null,
            emailMsg: '',
            searchTimeout: null,
            output: null,
            selectedFund: [],
            sip_amount: '',
            duration_months: '',
            sip_day: '',
            sipCalculatedData: [],
            showTable: false,
            processEmail: false,
            app_url: process.env.MIX_APP_ENV == 'local' ? process.env.MIX_API_URL_LOCAL : 'https://myplexus.com',
        }
    },
    methods: {
        ...mapActions('InputData', ['getFunds']),
        inflationCalculator(currentValue, annualInflationRate, period) {
            if (!(this.isNumeric(currentValue) && this.isNumeric(annualInflationRate) && this.isNumeric(period))) {
                return null;
            }

            currentValue = parseFloat(currentValue);
            annualInflationRate = parseFloat(annualInflationRate);
            period = parseFloat(period);

            var inflatedValue = currentValue * Math.pow((1 + annualInflationRate / 100), period);
            return inflatedValue;
        },
        showTableFunction(){
            //alert(this.process)
            //this.process=false;
            this.showTable = true
        },
        get_sip_graph() {
            var graph_data = this.sipCalculatedData.graph_table_data;
            this.showchart = true
            var dataPoints1 = [];
            var dataPoints2 = [];
            var i = 0;
            for (i = 0; i < graph_data.length; i++) {
                dataPoints1.push({
                    label: graph_data[i][0],
                    y: parseInt(graph_data[i][1])
                })
                dataPoints2.push({
                    label: graph_data[i][0],
                    y: parseInt(graph_data[i][2])
                })
            }
            let chart = {
                height: 370,
                animationEnabled: true,
                theme: "light2", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "SIP Performance Chart"
                },
                axisY: {
                    title: "Amount In INR"
                },
                legend: {
                    cursor: "pointer",
                    itemclick: this.toggleDataSeries
                },
                toolTip: {
                    shared: true,
                    content: this.toolTipFormatter
                },
                data: [{
                        type: "line",
                        showInLegend: true,
                        legendMarkerColor: "#6ab130",
                        name: "Invested Amount",
                        yValueFormatString: "##.00",
                        color: '#6ab130',
                        dataPoints: dataPoints1,
                    },
                    {
                        type: "line",
                        showInLegend: true,
                        legendMarkerColor: "#000",
                        name: "Unit Value",
                        yValueFormatString: "##.00",
                        color: '#000',
                        dataPoints: dataPoints2,
                    }
                ]
            }
            this.chart = new CanvasJS.Chart("chartContainerSIP", chart);
            this.chart.render();
        },
        toolTipFormatter(e) {
            var str = "";
            var total = 0;
            var str3;
            var str2;
            for (var i = 0; i < e.entries.length; i++) {
                var str1 = "<span style= \"color:" + e.entries[i].dataSeries.color + "\">" + e.entries[i].dataSeries.name + "</span>: <strong>" + parseFloat(e.entries[i].dataPoint.y).toFixed(2) + "</strong> <br/>";
                total = e.entries[i].dataPoint.y + total;
                str = str.concat(str1);
            }
            str2 = "<strong>" + e.entries[0].dataPoint.label + "</strong> <br/>";
            //str3 = "<span style = \"color:Tomato\">Total: </span><strong>" + total + "</strong><br/>";
            //return (str2.concat(str)).concat(str3);
            return (str2.concat(str));
        },
        toggleDataSeries(e) {
            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            } else {
                e.dataSeries.visible = true;
            }
            this.chart.render();
        },
        async send_graph_result() {

            if (this.showchart) {
                const el = this.$refs.printMe;
                const options = {
                    type: 'dataURL'
                }
                this.output = await this.$html2canvas(el, options);
            }
            this.processEmail = true
            let data = {
                name: this.name,
                email: this.email,
                output: this.output,
                fund_code: this.selectedFund.fund_code,
                fund_name: this.selectedFund.fund_name,
                sip_amount: this.sip_amount,
                duration_months: this.duration_months,
                sip_day: 1,
                sip_return: this.sipCalculatedData.sip_return,
                invested_amount: this.sipCalculatedData.invested_amount,
                current_value: this.sipCalculatedData.current_value,
                current_nav: this.sipCalculatedData.current_nav,
                total_unit: this.sipCalculatedData.total_unit,
            };
            axios.post(this.app_url + '/api/v1/send-sip-calculator-email', data)
                .then(response => {
                    this.emailMsg = response.data.message
                })
                .then(response => {

                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.processEmail = false
                })
            return true;
        },
        sipCalculations() {
            // this.sip_amount = this.$refs.sipAmount.value;
            // this.duration_months = this.$refs.sipDuration.value;
            // this.sip_day = this.$refs.sipDay.value;
            if (this.sip_amount && Object.keys(this.selectedFund).length && this.duration_months) {
                let data = {
                    name: this.name,
                    email: this.email,
                    fund_code: this.selectedFund.fund_code,
                    sip_amount: this.sip_amount,
                    duration_months: this.duration_months,
                    sip_day: 1,
                    output: this.output,
                };
                this.process = true
                this.sipCalculatedData = []
                axios.post(this.app_url + '/api/v1/sip-performance-calculator', data)
                    .then(response => {
                        this.sipCalculatedData = response.data.data
                        this.process = false
                    })
                    .then(response => {
                        this.sipCalculatedData.sip_return = this.calculate_sip(JSON.parse(this.sipCalculatedData.sip_data.ALLDATES), JSON.parse(this.sipCalculatedData.sip_data.ALLVALUES))
                        this.process = false
                    })
                    .then(response => {
                        this.get_sip_graph()
                        this.process = false
                    })
                    .catch(error => {
                        console.log(error);
                        this.process = false
                    })
                    .finally(() => {
                        this.process = false
                    })
                return true;
            }
        },
        calculate_sip(dates, values) {
            let that = this
            var x = that.XIRR(values, dates, 0.1);
            return this.isNumeric(x) ? (x * 100).toFixed(2) : x;
        },
        XIRR(values, dates, guess) {

            // Credits: algorithm inspired by Apache OpenOffice

            // Calculates the resulting amount
            var irrResult = function (values, dates, rate) {
                var r = rate + 1;
                var result = values[0];
                for (var i = 1; i < values.length; i++) {
                    result += values[i] / Math.pow(r, moment(dates[i]).diff(moment(dates[0]), 'days') / 365);

                }
                return result;
            }

            // Calculates the first derivation
            var irrResultDeriv = function (values, dates, rate) {
                var r = rate + 1;
                var result = 0;
                for (var i = 1; i < values.length; i++) {
                    var frac = moment(dates[i]).diff(moment(dates[0]), 'days') / 365;
                    result -= frac * values[i] / Math.pow(r, frac + 1);
                }
                return result;
            }

            // Check that values contains at least one positive value and one negative value
            var positive = false;
            var negative = false;
            for (var i = 0; i < values.length; i++) {
                if (values[i] > 0) positive = true;
                if (values[i] < 0) negative = true;
            }

            // Return error if values does not contain at least one positive value and one negative value
            if (!positive || !negative) return '#NUM!';

            // Initialize guess and resultRate
            var guess = (typeof guess === 'undefined') ? 0.1 : guess;
            var resultRate = guess;

            // Set maximum epsilon for end of iteration
            var epsMax = 1e-10;

            // Set maximum number of iterations
            var iterMax = 60;

            // Implement Newton's method
            var newRate, epsRate, resultValue;
            var iteration = 0;
            var contLoop = true;
            do {
                resultValue = irrResult(values, dates, resultRate);
                newRate = resultRate - resultValue / irrResultDeriv(values, dates, resultRate);
                epsRate = Math.abs(newRate - resultRate);
                resultRate = newRate;
                contLoop = (epsRate > epsMax) && (Math.abs(resultValue) > epsMax);
            } while (contLoop && (++iteration < iterMax));
            if (contLoop) return '#NUM!';
            // Return internal rate of return
            return resultRate;
        },
    },
    watch: {
        /*selectedFund(value) {
            if (value) {
                this.sipCalculations()
            }
        },*/

    },
    computed: {
        ...mapGetters('InputData', ['loading', 'funds']),

    },
    mounted() {
        this.getFunds({})
    },
}


$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

