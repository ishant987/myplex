<template>
    <section class="compare_scheme" v-if="currentTab != ''">
        <div class="container">
            <div class="tab_snap_shot">
                <div class="tab-content" id="pills-tabContent">
                    <div class="comp_schem_bdr">
                        <div class="s_renge">
                            <!-- <h4 class="mn_h4">Inflation Calculator</h4> -->
                            <div class="row">
                                <div class="col-lg-4 col-md-12 pe-5">
                                    <div class="cal_form_select">
                                        <label for="">Value of Current Expenses (Rs.)</label>
                                        <input class="form-text" type="number" v-model="current_expenses" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="range-slider-wrapper">
                                        <span class="slider-heading">Annual Inflation Rate (%)</span>
                                        <div id="slider-price" class="slider" data-min="2" data-max="8" data-value="2"
                                            data-step="1"></div>
                                        <input class="vue-value" data-from="infCalucaltor" type="hidden"
                                            ref="inflationRate" value="0" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="cal_form_select">
                                        <label for="">Time Period (Y)</label>
                                        <input class="form-text" type="number" v-model="period" />
                                    </div>
                                </div>
                                <a href="javascript://" id="infCalucaltor-jquery-click" class="money_title_btn d-none"
                                    @click="UpdateDataFromJquery"></a>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12" v-if="inflation_wealth">
                                    <div class="cal_form_select">
                                        <label for="">Inflation Adjusted Amount</label>
                                        <input class="form-text" readonly v-model="inflation_wealth" type="number" />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="invst-wrap inst-inflation-calc">

                        <div class="row mt-5">
                            <div id="screen_capture" class="mt-3 w-100">
                                <div class="col-md-12">
                                    <div class="graph_div" ref="printMe">
                                        <div id="chartContainer" style="width: 100%;" :class="{ 'height_370': showchart }">
                                        </div>
                                        <div v-show="showchart"
                                            style="height:30px; width:70px; background:#fff; position:absolute; z-index:999;bottom: 0;"
                                            id="myplexusC"></div>
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
            console.log('dfvfb');
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
                    text: "Inflation Calculator Chart"
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
                    self.get_inflation_graph()
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
                    self.get_inflation_graph()
                }, 500);
                return self.inflationCalculator(self.current_expenses, self.inflation_rate, self.period).toFixed(2)
            }
            return false
        }
    },
    mounted() {
        this.current_expenses = this.$refs.currentExpenses.value;
        this.inflation_rate = this.$refs.inflationRate.value;
    },
}
</script>

<style>

</style>
