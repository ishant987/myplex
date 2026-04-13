<template>
    <section class="compare_scheme" v-if="currentTab != ''">
        <div class="container">
            <div class="tab_snap_shot">
                <div class="tab-content" id="pills-tabContent">
                    <div class="comp_schem_bdr">
                        <div class="s_renge p-0">
                            <div class="row">
                                <div class="col-6 left-side">
                                    <div class="row mb-5">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="cal_form_select"><label for="">Current age *</label>
                                                <div class="d-flex">
                                                    <div class="left"><input class="form-text" type="text" :value="current_age_input"
                                                            placeholder="Current age *" @input="current_age_input_fuc()"></div>
                                                    <div class="right">
                                                        <div class="slidecontainer"><input type="range" min="1"
                                                                max="100"
                                                                class="slider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                                                id="current_age_output">
                                                            <!-- <p>Value: <span id="demo"></span></p> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="cal_form_select"><label for="">Expected age of Retirement
                                                    *</label>
                                                <div class="d-flex">
                                                    <div class="left"><input class="form-text" type="number"
                                                            placeholder="Expected age of Retirement *"
                                                            id="expected_age_retirement"></div>
                                                    <div class="right">
                                                        <div class="slidecontainer"><input type="range" min="1"
                                                                max="100"
                                                                class="slider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                                                id="expected_age_retirement_output">
                                                            <!-- <p>Value: <span id="demo"></span></p> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="cal_form_select"><label for="">Life Expectancy *</label>
                                                <div class="d-flex">
                                                    <div class="left"><input class="form-text" type="number"
                                                            placeholder="Life Expectancy *" id="life_expectancy"></div>
                                                    <div class="right">
                                                        <div class="slidecontainer"><input type="range" min="1"
                                                                max="100"
                                                                class="slider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                                                id="life_expectancy_output">
                                                            <!-- <p>Value: <span id="demo"></span></p> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-5 mt-5">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="cal_form_select"><label for="">Rate of return during
                                                    accumulation period *</label>
                                                <div class="d-flex">
                                                    <div class="left"><input class="form-text" type="text"
                                                            placeholder="Rate of return during accumulation period *"
                                                            id="accumulation_period"></div>
                                                    <div class="right">
                                                        <div class="slidecontainer"><input type="range" min="1"
                                                                max="100"
                                                                class="slider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                                                id="accumulation_period_output">
                                                            <!-- <p>Value: <span id="demo"></span></p> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="cal_form_select"><label for="">Rate of return after retirement
                                                    *</label>
                                                <div class="d-flex">
                                                    <div class="left"><input class="form-text" type="number"
                                                            placeholder="Rate of return after retirement *"
                                                            id="retirement"></div>
                                                    <div class="right">
                                                        <div class="slidecontainer"><input type="range" min="1"
                                                                max="100"
                                                                class="slider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                                                id="retirement_output">
                                                            <!-- <p>Value: <span id="demo"></span></p> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="cal_form_select"><label for="">Inflation *</label>
                                                <div class="d-flex">
                                                    <div class="left"><input class="form-text" type="number"
                                                            placeholder="Inflation *" id="inflation"></div>
                                                    <div class="right">
                                                        <div class="slidecontainer"><input type="range" min="1"
                                                                max="100"
                                                                class="slider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                                                id="inflation_output">
                                                            <!-- <p>Value: <span id="demo"></span></p> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mt-5">
                                        <div class="col-lg-12 col-md-12 mb-4">
                                            <div class="cal_form_select"><label for="">Monthly expenditure (In Rs.)
                                                    *</label><input class="form-text" type="text"
                                                    placeholder="Monthly expenditure (In Rs.) *"></div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 mb-4">
                                            <div class="cal_form_select"><label for="">Pension/income after retirement
                                                    (If any)</label><input class="form-text" type="number"
                                                    placeholder="Pension/income after retirement (If any)"></div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 mb-4">
                                            <div class="cal_form_select"><label for="">Current Savings per month/SIP (If
                                                    any)</label><input class="form-text" type="number"
                                                    placeholder="Current Savings per month/SIP (If any)"></div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 mb-4">
                                            <div class="cal_form_select"><label for="">Current lump sum (If
                                                    any)</label><input class="form-text" type="number"
                                                    placeholder="Current lump sum (If any)"></div>
                                        </div>
                                    </div>
                                    <div class="three_btn one_btn">
                                        <div class="middle_left"><a href="javascript://" disabled="true">Calculator</a>
                                        </div>
                                    </div>
                                    <div class="row d-none">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="range-slider-wrapper"><span class="slider-heading">Current age
                                                    *</span>
                                                <div id="slider-bedrooms"
                                                    class="slider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                                    data-min="15" data-max="70" data-value="15" data-step="1">
                                                    <div class="ui-slider-range ui-corner-all ui-widget-header ui-slider-range-min"
                                                        style="width: 0%;"></div><span tabindex="0"
                                                        class="ui-slider-handle ui-corner-all ui-state-default"
                                                        style="left: 0%;"><span class="value min-value"
                                                            data-selected-value="15">15</span></span>
                                                </div><input class="vue-value" data-from="retirementCalculator"
                                                    type="hidden" value="0">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="range-slider-wrapper"><span class="slider-heading">Expected age
                                                    of Retirement *</span>
                                                <div id="slider-price"
                                                    class="slider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                                    data-min="50" data-max="75" data-value="50" data-step="1">
                                                    <div class="ui-slider-range ui-corner-all ui-widget-header ui-slider-range-min"
                                                        style="width: 0%;"></div><span tabindex="0"
                                                        class="ui-slider-handle ui-corner-all ui-state-default"
                                                        style="left: 0%;"><span class="value min-value"
                                                            data-selected-value="50">50</span></span>
                                                </div><input class="vue-value" data-from="retirementCalculator"
                                                    type="hidden" value="0">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="range-slider-wrapper"><span class="slider-heading">Life
                                                    Expectancy *</span>
                                                <div id="slider-bedrooms"
                                                    class="slider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                                    data-min="70" data-max="110" data-value="70" data-step="1">
                                                    <div class="ui-slider-range ui-corner-all ui-widget-header ui-slider-range-min"
                                                        style="width: 0%;"></div><span tabindex="0"
                                                        class="ui-slider-handle ui-corner-all ui-state-default"
                                                        style="left: 0%;"><span class="value min-value"
                                                            data-selected-value="70">70</span></span>
                                                </div><input class="vue-value" data-from="retirementCalculator"
                                                    type="hidden" value="0">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="range-slider-wrapper"><span class="slider-heading">Rate of
                                                    return during accumulation period *</span>
                                                <div id="slider-price"
                                                    class="slider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                                    data-min="3" data-max="20" data-value="3" data-step="1">
                                                    <div class="ui-slider-range ui-corner-all ui-widget-header ui-slider-range-min"
                                                        style="width: 0%;"></div><span tabindex="0"
                                                        class="ui-slider-handle ui-corner-all ui-state-default"
                                                        style="left: 0%;"><span class="value min-value"
                                                            data-selected-value="3">3</span></span>
                                                </div><input class="vue-value" data-from="retirementCalculator"
                                                    type="hidden" value="0">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="range-slider-wrapper"><span class="slider-heading">Rate of
                                                    return after retirement *</span>
                                                <div id="slider-bedrooms"
                                                    class="slider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                                    data-min="3" data-max="20" data-value="3" data-step="1">
                                                    <div class="ui-slider-range ui-corner-all ui-widget-header ui-slider-range-min"
                                                        style="width: 0%;"></div><span tabindex="0"
                                                        class="ui-slider-handle ui-corner-all ui-state-default"
                                                        style="left: 0%;"><span class="value min-value"
                                                            data-selected-value="3">3</span></span>
                                                </div><input class="vue-value" data-from="retirementCalculator"
                                                    type="hidden" value="0">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="range-slider-wrapper"><span class="slider-heading">Inflation
                                                    *</span>
                                                <div id="slider-price"
                                                    class="slider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                                    data-min="2" data-max="8" data-value="1" data-step="2">
                                                    <div class="ui-slider-range ui-corner-all ui-widget-header ui-slider-range-min"
                                                        style="width: 0%;"></div><span tabindex="0"
                                                        class="ui-slider-handle ui-corner-all ui-state-default"
                                                        style="left: 0%;"><span class="value min-value"
                                                            data-selected-value="1">1</span></span>
                                                </div><input class="vue-value" data-from="retirementCalculator"
                                                    type="hidden" value="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 right-side">
                                    <div class="text-center text-white">
                                        <h4>Estimate Retirement Fund</h4>
                                        <h3>20000000</h3>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center"><span
                                                style="margin-right:6px;">Monthly</span><label class="switch"><input
                                                    type="checkbox" checked=""><span
                                                    class="checkbox round"></span></label><span
                                                style="margin-left:6px;">Yearly</span>
                                        </div>
                                </div>
                                <div class="table_scc calculator_table d-none">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr class="bg_top top_bg_right_black">
                                                    <td class="bg_222">
                                                        <div class="form_select"><label for="">Monthly expenditure (In
                                                                Rs.) *</label><input class="form-date" type="number">
                                                        </div>
                                                    </td>
                                                    <td class="bg_222">
                                                        <div class="form_select"><label for="">Pension/income after
                                                                retirement (If any)</label><input class="form-date"
                                                                type="number" id="pension"></div>
                                                    </td>
                                                    <td class="bg_222">
                                                        <div class="form_select"><label for="">Current Savings per
                                                                month/SIP (If any)</label><input class="form-date"
                                                                type="number" id="curr_savings"></div>
                                                    </td>
                                                    <td class="bg_222">
                                                        <div class="form_select"><label for="">Current lump sum (If
                                                                any)</label><input class="form-date" type="number"
                                                                id="current_lumsum"></div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div><a href="javascript://" id="retirementCalulator-jquery-click" class="d-none"></a>
                            </div>
                        </div>
                        <div class="invst-wrap invst-retirement-calc">
                            <div class="row invst-fields invst-field-1 justify-content-between">
                                <p v-if="errorMsg" class="text-danger mt-3 mb-3 w-100 text-right">{{ errorMsg }}</p>
                                <div class="invst-inflation-data col-12 mt-5 mb-3"
                                    v-if="corpus_need_on_retirement || savings_required_per_month || savings_equired_per_year">
                                    <div class="row m-0">
                                        <div class="col-lg-4 col-md-4 col-sm-4 inflataion-data-common">
                                            <h5>Corpus you will need on retirement</h5>
                                            <span class="data">{{ corpus_need_on_retirement }}</span>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-4 inflataion-data-common">
                                            <h5>Savings Required per month</h5>
                                            <span class="data">{{ savings_required_per_month }}</span>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-4 inflataion-data-common">
                                            <h5>Savings Required per year</h5>
                                            <span class="data">{{ savings_equired_per_year }}</span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <p v-if="emailMsg" class="text-success mt-3 mb-3 w-100 text-right">{{ emailMsg }}</p>
                            <div class="row mt-5">
                                <div id="screen_capture" class="mt-3 w-100">
                                    <div class="col-md-12">
                                        <div class="graph_div" ref="printMe" style="position: relative;">
                                            <div id="chartContainerRetirementCal" style="width: 100%;"
                                                :class="{ 'height_370': showchart }"></div>
                                            <div v-show="showchart"
                                                style="height:30px; width:70px; background:#fff; position:absolute; z-index:999;bottom: 0px;"
                                                id="myplexusC"></div>
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

<script>
    import mixin from '../../mixin';
    var CanvasJS = require('../../canvasjs.min.js');
	import Vue3ChartJs from '@j-t-mcc/vue3-chartjs'
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
			Vue3ChartJs
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
                current_age: '',
                retirement_age: '',
                life_expect: '',
                return_during: '',
                return_after: '',
                inflation: '',
                monthly_expence: '',
                pension: 0,
                curr_savings: 0,
                current_lumsum: 0,
                errorMsg: '',
                corpus_need_on_retirement: '',
                savings_required_per_month: '',
                savings_equired_per_year: '',
				current_age_input:'',
				expected_age_retirement:'',
				life_expectancy:'',
				accumulation_period:'',
				retirement:'',
				inflation:''
            }
        },
        methods: {
			current_age_input_change(){
				console.log(document.getElementById("current_age_input"));
			},
            UpdateCalualtorInputs() {
                this.current_age = this.$refs.currentAge.value
                this.retirement_age = this.$refs.retirementAge.value
                this.life_expect = this.$refs.lifeExpect.value
                this.return_during = this.$refs.returnDuring.value
                this.return_after = this.$refs.returnAfter.value
                this.inflation = this.$refs.inflation.value
            },
            calculate_retirement() {
                // this.UpdateCalualtorInputs();
                var current_age = this.current_age * 1;
                var retirement_age = this.retirement_age * 1;
                var life_expect = this.life_expect * 1;
                var return_during = this.return_during / 100;
                var return_after = this.return_after / 100;
                var inflation = this.inflation / 100;
                var monthly_expence = this.monthly_expence;
                var pension = this.pension;
                var curr_savings = this.curr_savings;
                var current_lumsum = this.current_lumsum;

                if (isNaN(current_age) || !current_age) {
                    this.errorMsg = "Invalid input for Current age!"
                    return false;
                } else if (isNaN(retirement_age) || !retirement_age) {
                    this.errorMsg = "Invalid input for Return age!"
                    return false;
                } else if (isNaN(life_expect) || !life_expect) {
                    this.errorMsg = "Invalid input for Life expectancy!"
                    return false;
                } else if (isNaN(return_during) || !return_during) {
                    this.errorMsg = "Invalid input for Rate of return during accumulation period!"
                    return false;
                } else if (isNaN(return_after) || !return_after) {
                    this.errorMsg = "Invalid input for Rate of return after retirement!"
                    return false;
                } else if (isNaN(inflation) || !inflation) {
                    this.errorMsg = "Invalid input for Inflation !"
                    return false;
                } else if (isNaN(monthly_expence) || !monthly_expence) {
                    this.errorMsg = "Invalid input for Monthly expenditure !"
                    return false;
                } else {
                    //return true;
                }

                if (isNaN(pension) || !pension) {
                    pension = 0;
                } else {
                    pension = pension;
                }

                if (isNaN(curr_savings) || !curr_savings) {
                    curr_savings = 0;
                } else {
                    curr_savings = curr_savings;
                }

                if (isNaN(current_lumsum) || !current_lumsum) {
                    current_lumsum = 0;
                } else {
                    current_lumsum = current_lumsum;
                }

                if (current_age >= retirement_age || current_age >= life_expect) {
                    this.errorMsg = "Current Age should be lesser than Retirement Age and Life Expectancy ! "
                    return false;
                } else if (retirement_age <= current_age || retirement_age >= life_expect) {
                    this.errorMsg = "Retirement Age should be grater than Current Age and lesser than Life Expectancy ! "
                    return false;
                } else if (life_expect <= current_age || life_expect <= retirement_age) {
                    this.errorMsg = "Life Expectancy should be grater than Current Age and Retirement Age ! "
                    return false;
                } else {
                    this.errorMsg = '';
                }
                console.log(current_age)
                var year_before_retirement = retirement_age - current_age;
                var year_after_retirement = life_expect - retirement_age;
                var inflation_adjusted_return = ((1 + return_after) / (1 + inflation)) - 1;
                var total = monthly_expence - pension;
                var retirement_time_curr_monthly_savings = -this.calculateFV((return_during / 12), (year_before_retirement * 12), curr_savings, 0, 0);
                var annual_total = total * 12;
                var retirement_time_curr_lumsum_savings = current_lumsum * Math.pow(1 + return_during, year_before_retirement);

                var retirement_time_expense_per_year = annual_total * Math.pow(1 + inflation, year_before_retirement);
                var corpus_need_on_retirement = -this.calculatePV(inflation_adjusted_return, year_after_retirement, retirement_time_expense_per_year, 0, 1);
                var required_corpus = corpus_need_on_retirement - (retirement_time_curr_monthly_savings + retirement_time_curr_lumsum_savings);
                var savings_required_per_month = this.calculatePMT(required_corpus, (return_during * 100), year_before_retirement);
                var savings_equired_per_year = savings_required_per_month * 12;

                this.corpus_need_on_retirement = this.conv_number(corpus_need_on_retirement, 2)
                this.savings_required_per_month = this.conv_number(savings_required_per_month, 2)
                this.savings_equired_per_year = this.conv_number(savings_equired_per_year, 2)

                this.get_retirement_graph(current_age, retirement_age, life_expect, return_during, return_after, inflation, monthly_expence, pension, curr_savings, current_lumsum, year_before_retirement, year_after_retirement, inflation_adjusted_return, total, retirement_time_curr_monthly_savings, annual_total, retirement_time_curr_lumsum_savings, retirement_time_expense_per_year, corpus_need_on_retirement, required_corpus, savings_required_per_month, savings_equired_per_year);

            },
            get_retirement_graph(current_age, retirement_age, life_expect, return_during, return_after, inflation, monthly_expence, pension, curr_savings, current_lumsum, year_before_retirement, year_after_retirement, inflation_adjusted_return, total, retirement_time_curr_monthly_savings, annual_total, retirement_time_curr_lumsum_savings, retirement_time_expense_per_year, corpus_need_on_retirement, required_corpus, savings_required_per_month, savings_equired_per_year) {

                this.showchart = true
                var dataPointsR1 = [];
                var dataPointsR2 = [];
                var dataPointsR3 = [];
                var withdraw_data = [];
                var interest_data = [];

                var i = 1;
                var cnt = 1;
                var age = 0;
                var investment_in_cr = 0;
                var balance_in_cr = 0;
                var withdrwal_in_cr = 0;
                var invested_amount = 0;
                var from_lumsum_savings = 0;
                var from_suggested_savings = 0;
                var from_current_savings = 0;
                var total_return_total_balance = 0;
                var interest = 0;
                var withdrawl = 0;

                for (cnt = ((current_age * 1) + 1); cnt <= (life_expect * 1); cnt++) {

                    age = cnt;

                    if (age < (retirement_age * 1 + 1)) {
                        invested_amount = ((savings_required_per_month + curr_savings) * 12 * i) + current_lumsum;
                        from_lumsum_savings = current_lumsum * Math.pow((1 + return_during), i);
                        from_suggested_savings = -this.calculateFV(return_during / 12, i * 12, savings_required_per_month, 0, 0);
                        from_current_savings = -this.calculateFV(return_during / 12, i * 12, -curr_savings, 0, 0);
                        total_return_total_balance = from_lumsum_savings + from_suggested_savings + from_current_savings;
                        interest = total_return_total_balance - invested_amount;
                        withdrawl = 0;
                    } else if (age > (retirement_age * 1 + 1)) {
                        interest = total_return_total_balance * return_after * 1;
                        withdrawl = withdrawl * (1 + inflation * 1);
                        invested_amount = 0;
                        from_lumsum_savings = 0;
                        from_suggested_savings = 0;
                        from_current_savings = 0;
                        if (age == life_expect * 1) {
                            total_return_total_balance = 0;
                        } else {
                            total_return_total_balance = total_return_total_balance - withdrawl + interest;
                        }

                    } else {
                        withdrawl = retirement_time_expense_per_year * 1;
                        invested_amount = 0;
                        from_lumsum_savings = 0;
                        from_suggested_savings = 0;
                        from_current_savings = 0;
                        total_return_total_balance = total_return_total_balance - withdrawl;

                        interest = 0;

                    }

                    investment_in_cr = invested_amount / 10000000;
                    balance_in_cr = (total_return_total_balance * 1) / 10000000;
                    withdrwal_in_cr = withdrawl / 10000000;

                    dataPointsR1.push({
                        label: age + " Year",
                        y: investment_in_cr
                    });
                    dataPointsR2.push({
                        label: age + " Year",
                        y: balance_in_cr
                    });
                    dataPointsR3.push({
                        label: age + " Year",
                        y: withdrwal_in_cr
                    });

                    i++;
                }

                console.log(dataPointsR1);
                console.log(dataPointsR2);
                console.log(dataPointsR3);
                let chart = {
                    height: 370,
                    //animationEnabled: true,
                    //exportEnabled: true,
                    title: {
                        text: "Retirement Calculator Chart"
                    },
                    axisY: {
                        title: "Rs. in Cr."
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
                        type: "column",
                        showInLegend: true,
                        legendMarkerColor: "#6ab130",
                        legendText: "Investment in Cr. (Rs.)",
                        yValueFormatString: "##.00",
                        color: '#6ab130',
                        dataPoints: dataPointsR1,
                    },
                    {
                        type: "column",
                        showInLegend: true,
                        legendMarkerColor: "#6d78ad",
                        legendText: "Balance in Cr. (Rs.)",
                        yValueFormatString: "##.00",
                        color: '#6d78ad',
                        dataPoints: dataPointsR2,
                    },
                    {
                        type: "column",
                        showInLegend: true,
                        legendMarkerColor: "#000000",
                        legendText: "Withdrawl in Cr. (Rs.)",
                        yValueFormatString: "##.00",
                        color: '#000000',
                        dataPoints: dataPointsR3,
                    }
                    ]
                }
                this.chart = new CanvasJS.Chart("chartContainerRetirementCal", chart);
                this.chart.render();

                this.send_graph_result();

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
            calculateFV(rate, nper, pmt, pv, per) {
                //alert('nper-'+nper);
                //alert('pmt-'+pmt);
                nper = parseFloat(nper);
                pmt = parseFloat(pmt);
                pv = parseFloat(pv);
                //rate = eval((rate) / (per * 100));
                if ((pmt == 0) || (nper == 0)) {
                    //alert("Why do you want to test me with zeros?");
                    return (0);
                }
                if (rate == 0) { // Interest rate is 0
                    var fv_value = -(pv + (pmt * nper));
                } else {
                    var x = Math.pow(1 + rate, nper);
                    var fv_value = -(-pmt + x * pmt + rate * x * pv) / rate;
                }
                fv_value = this.conv_number(fv_value, 2);
                //alert(fv_value);
                return fv_value;
            },
            calculatePV(rate, periods, payment, future, type) {

                // Initialize type
                var type = (typeof type === 'undefined') ? 0 : type;

                // Evaluate rate and periods (TODO: replace with secure expression evaluator)
                rate = eval(rate);
                periods = eval(periods);

                // Return present value
                if (rate === 0) {
                    var pv_value = -payment * periods - future;
                } else {
                    var pv_value = (((1 - Math.pow(1 + rate, periods)) / rate) * payment * (1 + rate * type) - future) / Math.pow(1 + rate, periods);
                }
                //alert(pv_value);
                return pv_value;
            },
            calculatePMT(goalAmount, rateOfReturn, investmentDuration) {
                var annualInflationRate = 0;

                var result = this.PMTCalculator(goalAmount, (rateOfReturn - annualInflationRate), investmentDuration);
                console.log(result);
                return result.pmtValue;
            },
            conv_number(expr, decplaces) {
                var str = "" + Math.round(eval(expr) * Math.pow(10, decplaces));
                while (str.length <= decplaces) {
                    str = "0" + str;
                }

                var decpoint = str.length - decplaces;
                return (str.substring(0, decpoint) + "." + str.substring(decpoint, str.length));
            },
            PMTCalculator(goalAmount, rateOfReturn, investmentDuration) {
                // PMT is an internal function

                //alert(goalAmount+' '+rateOfReturn+' '+investmentDuration); 
                function pmt(rate, per, nper, pv, fv) {
                    if (fv == 0) {
                        return null;
                    }

                    rate = rate / (per * 100);

                    if (rate == 0) {
                        pmtValue = -(fv + pv) / nper;
                    } else {
                        var x = Math.pow(1 + rate, nper);
                        fv = fv + x * pv;
                        pmtValue = -((rate * fv) / (-1 + x));
                    }

                    return pmtValue;
                }

                if (!(this.isNumeric(goalAmount) && this.isNumeric(rateOfReturn) && this.isNumeric(investmentDuration))) {
                    return null;
                }

                goalAmount = parseFloat(goalAmount);
                rateOfReturn = parseFloat(rateOfReturn);
                investmentDuration = parseFloat(investmentDuration);

                // Assuming monthly SIP investment
                var per = 12;
                var nper = per * investmentDuration;

                var pmtValue = pmt(rateOfReturn, per, nper, 0, goalAmount) * -1;
                var investment = pmtValue * nper;

                return {
                    pmtValue: pmtValue,
                    investment: investment,
                    earnings: (goalAmount - investment)
                };
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
                    current_age: this.current_age,
                    retirement_age: this.retirement_age,
                    life_expect: this.life_expect,
                    return_during: this.return_during,
                    return_after: this.return_after,
                    inflation: this.inflation,
                    monthly_expence: this.monthly_expence,
                    pension: this.pension,
                    curr_savings: this.curr_savings,
                    current_lumsum: this.current_lumsum,
                    corpus_need_on_retirement: this.corpus_need_on_retirement,
                    savings_required_per_month: this.savings_required_per_month,
                    savings_equired_per_year: this.savings_equired_per_year,
                    output: this.output,
                };
                this.process = true
                axios.post('/api/v1/send-retirement-calculator-email', data)
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
            }
        },
        watch: {

        },
        computed: {
            disabledCalculate() {
                if (this.current_age === '' ||
                    this.retirement_age === '' ||
                    this.life_expect === '' ||
                    this.return_during === '' ||
                    this.return_after === '' ||
                    this.inflation === '' ||
                    this.monthly_expence === '' ||
                    this.pension === '' ||
                    this.curr_savings === '' ||
                    this.current_lumsum === '' || this.process) {
                    return true
                }
                return false
            }
        },
        mounted() {
let chart = {
            colorSet: "greenShades",
            backgroundColor: "#fff  ",
            theme: "light2",
            animationEnabled: true,
            axisY: {
                includeZero: false,
                title: "Scheme",
                suffix: " "
            },
            toolTip: {
                shared: "true"
            },
            legend: {
                cursor: "pointer",
                itemclick: this.toggleDataSeries
            },
            title: {
                text: "Scheme NAV Chart"
            },
            data: [{
                type: "spline",
                showInLegend: true,
                yValueFormatString: "##.00",
                name: "NAV Value",
                dataPoints: this.dataPoints
            }]
        }
        CanvasJS.addColorSet("greenShades", ["#4661EE", "#EC5657", "#1BCDD1", "#8FAABB", "#B08BEB", "#3EA0DD", "#F5A52A", "#23BFAA", "#FAA586", "#EB8CC6"]);
        this.chart = new CanvasJS.Chart("chartContainer", chart);
        this.chart.render();

    },
        },
    }

</script>

<style>
    .h-48 {
        height: 48px;
    }
</style>