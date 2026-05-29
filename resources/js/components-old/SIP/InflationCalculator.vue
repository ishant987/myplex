<template>
   <section class="compare_scheme pt-3" v-if="currentTab != ''">
      <div class="container">
         <div class="tab_snap_shot">
            <div class="tab-content" id="pills-tabContent">
               <div class="comp_schem_bdr">
                  <div class="s_renge p-0">
                     <div class="row calbanner">
                        <div class="l">
                           <h4 class="heading-green"> Inflation Calculator  </h4>
                           <p>This calculates the value of current expenses after a certain time period taking into account the inflation rate. </p>
                        </div>
                        <div class="r">
                           <img src="https://new.myplexus.com/themes/frontend/assets/v1/img/InflationCalculator.png">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12 left-side">
                           <!-- <h4 class="mn_h4">Inflation Calculator</h4> -->
                           <div class="row">
                              <div class="col-lg-4 col-md-12 ">
                                 <div class="cal_form_select">
                                    <label for=""><strong>Value of Current Expenses (₹) * <i class="ph ph-question" data-toggle="tooltip" data-placement="top" title="How much do you spend on a monthly basis?"></i></strong></label>
                                    <input class="form-text" type="number" v-model="current_expenses" />
                                 </div>
                              </div>
                              <div class="col-lg-4 col-md-12">
                                 <div class="range-slider-wrapper">
                                    <span class="slider-heading">Annual Inflation Rate <span class="count"><span id="inflationRate_input_value">2</span> %</span></span>
                                    <!-- <div id="slider-price" class="slider" data-min="2" data-max="8" data-value="2"
                                       data-step="1"></div> -->
                                    <input type="range" min="2" max="25" value="2" class="vue-value" data-from="infCalucaltor" ref="inflationRate" @input="inflationRate_input">
                                    <!-- <input class="vue-value" data-from="infCalucaltor" type="hidden"
                                       ref="inflationRate" value="0" /> -->
                                 </div>
                              </div>
                              <div class="col-lg-4 col-md-12">
                                 <div class="cal_form_select">
                                    <label for=""><strong>Time Period (Y) * </strong></label>
                                    <input class="form-text" type="number" v-model="period" maxlength="3" />
                                 </div>
                              </div>
                              <a href="javascript://" id="infCalucaltor-jquery-click" class="money_title_btn d-none"
                                 @click="UpdateDataFromJquery"></a>
                           </div>
                           <div class="three_btn one_btn text-center" v-if="inflation_wealth">
                             <div class="middle_left d-inline">
                                <strong>Inflation Adjusted Amount : {{ Number(inflation_wealth).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }}</strong>
                             </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row" id="graph_div_show" style="display: none;">
                  <div id="screen_capture" class="mt-3 w-100">
                     <div class="col-md-12">
                        <div class="graph_div" ref="printMe">
                           <div id="chartContainer" style="width: 100%;" :class="{'height_370':showchart}"></div>
                           <div v-show="showchart" style="height:30px; width:70px; background:#fff; position:absolute; z-index:999;bottom:0" id="myplexusC"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- <div class="invst-wrap inst-inflation-calc">
                  <div class="row mt-5">
                      <div id="screen_capture" class="mt-3 w-100">
                          <div class="col-md-12">
                              <div class="graph_div" ref="printMe">
                                  <div id="chartContainer" style="width: 100%;" :class="{ 'height_370': showchart }">
                                  </div>
                                  <div v-show="showchart"
                                      style="height:30px; width:70px; background:#fff;  z-index:999;bottom: 0;"
                                      id="myplexusC"></div>
                              </div>
                          </div>
                      </div>
                  </div>
                  
                  </div> -->
               <div class="plan_faq">
                  <div class="faq_title">
                     <h4>FAQ - <span>Frequently asked questions</span></h4>
                  </div>
                  <div class="single_faq_calc">
                     <h4>What is Inflation?</h4>
                     <p>Inflation is the general rise in prices over a given period of time. It is an important factor to consider when investing in mutual funds, as it can have a significant impact on th real returns(returns adjusted for inflation) you earn on your investments.</p>
                  </div>
                  <div class="single_faq_calc">
                     <h4>What is the role of inflation in Mutual fund investments?</h4>
                  </div>
                  <div class="single_faq_calc">
                     <h4>Real rate of retrun</h4>
                     <p>It is important to evaluate the mutual fund investments based on the real rate of return, which accounts for inflation. A positive real returnindicates that investment is outpacing inflation.</p>
                  </div>
                  <div class="single_faq_calc">
                     <h4>Diversifcation</h4>
                     <p>Diversifcation across different asset classes and sectors can help mitigate the impact of inflation on your mutual fund investments. Different assets may respond differently to inflationary pressures.</p>
                  </div>
                  <div class="single_faq_calc">
                     <h4>Long term perspective</h4>
                     <p>Mutual fund investments are typically better suited for long term investors. Over extended periods, they have the potential to generate returns that outpace inflation.</p>
                  </div>
                  <div class="single_faq_calc">
                     <h4>What is the need for an inflation adjusted fund planner?</h4>
                     <p>This planner helps you plan for your future financial needs while taking into account the impact of inflation. It aims to ensure thatyour investments and savings grow at a rate that outpaces or at least keeps pace with inflation in order to maintain the purchasing power and achieving financial goals over time.</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
</template>

<script>
import mixin from '../../mixin';
import LoadingBar from "./../Common/loading";
var CanvasJS = require('../../canvasjs.min.js');
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
        LoadingBar
    },
    mixins: [mixin],
    data() {
        return {
            name: this.username,
            email: this.useremail,
            process: false,
            current_expenses: '',
            inflation_rate: '',
            period: '',
            showchart: false,
            chart: null,
            emailMsg: '',
            searchTimeout: null,
            output: null,
            app_url: process.env.MIX_APP_ENV == 'local' ? process.env.MIX_API_URL_LOCAL : '',
        }
    },
    methods: {

        inflationRate_input(event){
            this.inflation_rate = event.target.value;
            var inflationRate_input_value = event.target.value;
            $('#inflationRate_input_value').text(inflationRate_input_value);

        },

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
        get_inflation_graph() {
            var current_expenses = this.current_expenses;
            var inflation_rate = this.inflation_rate;
            var period = this.period;
            this.showchart = true
            var inflated_amt = 0;
            var dataPointsIN = [];
            var i = 1;

            for (i = 1; i <= period; i++) {

                inflated_amt = current_expenses * Math.pow((1 + inflation_rate / 100), i);
                dataPointsIN.push({
                    label: i + " Year",
                    y: inflated_amt
                });

            }
            let chart = {
                height: 370,
                animationEnabled: true,
                theme: "light2", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Inflation Chart"
                },
                axisY: {
                    title: "Inflated Amount (Rs.)"
                },
                data: [{
                    type: "column",
                    showInLegend: true,
                    legendMarkerColor: "grey",
                    legendText: "Time (Year)",
                    yValueFormatString: "##.00",
                    color: '#6ab130',
                    dataPoints: dataPointsIN,
                }]
            }
            CanvasJS.addColorSet("greenShades", ['#6ab130']);
            this.chart = new CanvasJS.Chart("chartContainer", chart);
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

            let data = {
                name: this.name,
                email: this.email,
                current_expenses: this.current_expenses,
                inflation_rate: this.inflation_rate,
                inflation_wealth: this.inflation_wealth,
                period: this.period,
                output: this.output,
            };
            this.process = true
            axios.post(this.app_url + '/api/v1/send-inflation-calculator-email', data)
                .then(response => {
                    this.emailMsg = response.data.message
                })
                .then(response => {

                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.process = false
                })
            return true;
        },
        UpdateDataFromJquery() {
            // this.current_expenses = this.$refs.currentExpenses.value;
            this.inflation_rate = this.$refs.inflationRate.value;
            if (this.current_expenses && this.inflation_rate && this.period) {
                clearTimeout(this.searchTimeout);
                var self = this;
                this.searchTimeout = setTimeout(function () {
                    self.get_inflation_graph();
                    $("#graph_div_show").show();
                }, 500);
                return self.inflationCalculator(self.current_expenses, self.inflation_rate, self.period).toFixed(2)
            }
        }
    },
    watch: {

    },
    computed: {
        activeQuestion() {
            return (this.questions.length) ? this.questions[this.activeIndex] : false
        },
        inflation_wealth() {
            if (this.current_expenses && this.inflation_rate && this.period) {
                clearTimeout(this.searchTimeout);
                var self = this;
                this.searchTimeout = setTimeout(function () {
                    self.get_inflation_graph();
                    $("#graph_div_show").show();
                }, 500);
                return self.inflationCalculator(self.current_expenses, self.inflation_rate, self.period).toFixed(2)
            }
            return false
        }
    },
    mounted() {
        //this.current_expenses = this.$refs.currentExpenses.value;
        this.inflation_rate = this.$refs.inflationRate.value;
    },
}
</script>

<style>

</style>
