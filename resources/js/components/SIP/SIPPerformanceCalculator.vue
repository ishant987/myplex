<template>
<div class="comp_schem_bdr">
    <div class="s_renge sip_calc_range_grop">
        <h4>SIP Performance Calculator</h4>
        <div class="row">
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
        <div class="d-sm-flex d-block sip_calc_input mt-3" v-if="Object.keys(sipCalculatedData).length">
            <div class="cal_form_select">
                <label for="">Return Rate (%)</label>
                <input class="form-text" type="number" readonly :value="sipCalculatedData.sip_return" />
            </div>
            <div class="cal_form_select">
                <label for="">Your Investments (Rs.)</label>
                <input class="form-text" type="number" readonly :value="sipCalculatedData.invested_amount" />
            </div>
            <div class="cal_form_select">
                <label for="">Your Current Value (Rs.)</label>
                <input class="form-text" type="number" readonly :value="sipCalculatedData.current_value" />
            </div>
            <div class="cal_form_select">
                <label for="">Your Current Value (Rs.)</label>
                <input class="form-text" type="number" readonly :value="sipCalculatedData.current_nav" />
            </div>
            <div class="cal_form_select mr-0">
                <label for="">Your Current Value (Rs.)</label>
                <input class="form-text" type="number" readonly :value="sipCalculatedData.total_unit" />
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
                            <div id="chartContainerSIP" style="width: 100%;" :class="{'height_370':showchart}"></div>
                            <div v-show="showchart" style="height:30px; width:70px; background:#fff; position:absolute; z-index:999;bottom: 0;" id="myplexusC"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div>&nbsp;</div>
            <div class="invst-fields-action-buttons" v-if="Object.keys(sipCalculatedData).length ">
                <div class="row m-0 justify-content-end">
                    <div class="col-md-3 action-common action-btn-1">
                        <a href="javascript://" id="show-table" class="money_title_btn" @click="showTable = true">Show In Table</a>
                    </div>
                    <div class="col-md-3 action-common action-btn-2">
                        <a href="javascript://" id="send-email" class="money_title_btn" :disabled="processEmail" @click="send_graph_result">Send Results In Email</a>
                    </div>
                </div>
            </div>
        </div>
        <div>&nbsp;</div>
        <!-- SIP CALCULATOR GRAPH DIV START -->

        <div id="sip-performance-calc-data" class="monthly_ranking_table" v-show="showTable && !process" v-if="Object.keys(sipCalculatedData).length">
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
            app_url: process.env.MIX_APP_ENV == 'local' ? process.env.MIX_API_URL_LOCAL : '',
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
                    text: "Inflation Calculator Chart"
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
                email: 'sandeep@gmail.com',
                output: this.output,
                fund_code: this.selectedFund.fund_code,
                fund_name: this.selectedFund.fund_name,
                sip_amount: this.sip_amount,
                duration_months: this.duration_months,
                sip_day: this.sip_day,
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
            this.sip_amount = this.$refs.sipAmount.value;
            this.duration_months = this.$refs.sipDuration.value;
            this.sip_day = this.$refs.sipDay.value;
            if (this.sip_amount && Object.keys(this.selectedFund).length && this.duration_months && this.sip_day) {
                let data = {
                    name: this.name,
                    email: 'sandeep@gmail.com',
                    fund_code: this.selectedFund.fund_code,
                    sip_amount: this.sip_amount,
                    duration_months: this.duration_months,
                    sip_day: this.sip_day,
                    output: this.output,
                };
                this.process = true
                this.sipCalculatedData = []
                axios.post(this.app_url + '/api/v1/sip-performance-calculator', data)
                    .then(response => {
                        this.sipCalculatedData = response.data.data
                    })
                    .then(response => {
                        this.sipCalculatedData.sip_return = this.calculate_sip(JSON.parse(this.sipCalculatedData.sip_data.ALLDATES), JSON.parse(this.sipCalculatedData.sip_data.ALLVALUES))
                    })
                    .then(response => {
                        this.get_sip_graph()
                    })
                    .catch(error => {
                        console.log(error);
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
        selectedFund(value) {
            if (value) {
                this.sipCalculations()
            }
        },

    },
    computed: {
        ...mapGetters('InputData', ['loading', 'funds']),

    },
    mounted() {
        this.getFunds({})
    },
}
</script>
<style>

</style>
