<template>
    <div class="comp_schem_bdr">
        <div class="s_renge">
            <h4 class="mn_h4 text-white">Calculate SIP</h4>
            <div class="row">
                <div class="col-md-6 left-side">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="cal_form_select">
                                <label for="">Name</label>
                                <input class="form-text" type="text" placeholder="Enter Full Name" v-model="name" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="cal_form_select">
                                <label for="">Email</label>
                                <input class="form-text" type="text" placeholder="Enter Your Email" v-model="email" />
                            </div>
                        </div>
                    <div class="col-lg-6 col-md-12">
                    <div class="cal_form_select">
                        <label for="">Phone</label>
                        <input class="form-text" type="text" placeholder="Enter Phone Number" min="10" max="12" v-model="phone" />
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="cal_form_select">
                        <label for="">Select Plan</label>
                        <select v-model="plan" :disabled="!name || !email && step==2" class="form-text">
                            <option value="">Select Plan</option>
                            <option value="1">Planning for retirement</option>
                            <option value="2">Planning for child's marriage</option>
                            <option value="3">Planning for child's higher education</option>
                            <option value="4">Planning for owning an asset</option>
                            <option value="5">Others</option>
                        </select>
                    </div>
                </div>
               
                    </div>
                    <template v-if="step==1 || step==2">
                <div class="row mt-3" v-if="plan == 1">
                    <div class="row mb-3">
                        <div class="col-lg-12 col-md-12">
                            <div class="cal_form_select">
                                <label>Current monthly expenditure (in Rs.)</label>
                                <input class="form-text" type="text" v-model="var_1" />
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="cal_form_select">
                                <label>Number of years left for retirement (Max. 50 years)</label>
                                <input type="number" max="50" class="form-text" v-model="var_2" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-12 col-md-12">
                            <div class="cal_form_select">
                                <label>Assume a rate of inflation (in %)</label>
                                <input class="form-text" type="text" v-model="var_3" />
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="cal_form_select">
                                <label>Assume a risk free rate of return on your retirement fund (in Rs.)</label>
                                <input type="number" max="50" class="form-text" v-model="var_4" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3" v-if="var_5">
                        <div class="col-lg-12 col-md-12">
                            <div class="cal_form_select">
                                <label>Retirement Fund required to meet your post retirement monthly expenses (in Rs.)</label>
                                <input :disabled="true" type="number" class="form-text" v-model="var_5" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3" v-if="plan == 2">
                    <div class="row mb-3">
                        <div class="col-lg-12 col-md-12">
                            <div class="cal_form_select">
                                <label>What is the present cost of such marriage ? (in Rs.)</label>
                                <input type="number" class="form-text" v-model="var_1" />
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="cal_form_select">
                                <label>After how many years is your child likely to get married ? (Max. 50 years)</label>
                                <input type="number" max="50" class="form-text" v-model="var_2" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-12 col-md-12">
                            <div class="cal_form_select">
                                <label>Assume a rate of inflation (in %)</label>
                                <input type="number" class="form-text" v-model="var_3" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3" v-if="var_5">
                        <div class="col-lg-12 col-md-12">
                            <div class="cal_form_select">
                                <label>The amount you would require for your child's marriage (in Rs.)</label>
                                <input :disabled="true" type="number" class="form-text" v-model="var_5" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3" v-if="plan == 3">
                    <div class="row mb-3">
                        <div class="col-lg-12 col-md-12">
                            <div class="cal_form_select">
                                <label>What is the present cost of such educaton ? (in Rs.)</label>
                                    <input type="number" class="form-text" v-model="var_1"    />
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="cal_form_select">
                                <label>After how many years is your child likely to go for higher education ? (Max. 50 years)</label>
                                    <input type="number" max="50" class="form-text" v-model="var_2"    />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-12 col-md-12">
                            <div class="cal_form_select">
                                <label>Assume a rate of inflation (in %)</label>
                                    <input type="number" class="form-text" v-model="var_3"    />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3" v-if="var_5">
                        <div class="col-lg-12 col-md-12">
                            <div class="cal_form_select">
                                <label>The amount you would require for yor child's higher education (in Rs.)</label>
                                    <input :disabled="true" type="number" class="form-text" v-model="var_5"    />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3" v-if="plan == 4">
                    <div class="row mb-3">
                        <div class="col-lg-12 col-md-12">
                            <div class="cal_form_select">
                                <label>What is the present cost of such asset ? (in Rs.)</label>
                                    <input type="number" class="form-text" v-model="var_1"    />
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="cal_form_select">
                                <label>After how many years you are planning to buy the said asset ? (Max. 50 years)</label>
                                    <input type="number" max="50" class="form-text" v-model="var_2"    />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-12 col-md-12">
                            <div class="cal_form_select">
                                <label>Assume a rate of inflation (in %)</label>
                                    <input type="number" class="form-text" v-model="var_3"    />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3" v-if="var_5">
                        <div class="col-lg-12 col-md-12">
                            <div class="cal_form_select">
                                <label>Amount you would require to own the said asset (in Rs.)</label>
                                    <input :disabled="true" type="number" class="form-text" v-model="var_5"    />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3" v-if="plan == 5">
                    <div class="row mb-3">
                        <div class="col-lg-12 col-md-12">
                            <div class="cal_form_select">
                                <label>Goal Amount (Rs.)</label>
                                    <input type="number" class="form-text" v-model="goalsipamount"    />
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="cal_form_select">
                                <label>Investment Duration (Y)</label>
                                    <input type="number" class="form-text" v-model="goalinvestmentduration"    />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-12 col-md-12">
                            <div class="cal_form_select">
                                <label>Expected Rate of Return (%p.a.)</label>
                                    <input type="number" class="form-text" v-model="goalrateofreturn"    />
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="cal_form_select">
                                <label>Annual Inflation Rate (%)</label>
                                    <select  v-model="inflationrate" class="form-text" title="Inflation would decrease your savings buying power every year. A realistic range is in between 2%-10%, but over the last decade it has been between 4%-6% per annum">
                                        <option value="" selected disabled>Select Inflation Rate</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                    </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3" >
                        <div class="col-lg-12 col-md-12" v-if="final_goal_amt">
                            <div class="cal_form_select">
                                <label>Inflation Adjusted Goal Amount (Rs.)</label>
                                    <input :disabled="true" type="number" class="form-text" v-model="final_goal_amt"    />
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12" v-if="goal_sip_investments">
                            <div class="cal_form_select">
                                <label>Your Total Investment (Rs.)</label>
                                    <input :disabled="true" type="number" class="form-text" v-model="goal_sip_investments"    />
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12" v-if="goal_sip_amt">
                            <div class="cal_form_select">
                                <label>Monthly SIP Amount (Rs.)</label>
                                    <input :disabled="true" type="number" class="form-text" v-model="goal_sip_amt"    />
                            </div>
                        </div>
                        <p class="text-danger" v-if="error_msg">{{error_msg}}</p>
                    </div>
                </div>
            </template>
            <div v-if="plan && plan != 5 && step != 3" class="sip-planner-ic-action-cm sip-planner-ic-action-2 mt-4">
                <!-- <button v-if="step == 2" id="sip-planner-ic-submit" class="btn mr-2 btn-green" @click="step = 3">How much should I start saving now?</button> -->
                <button id="sip-planner-ic-submit" class="money_title_btn" :disabled="!var_1 || !var_2 || !var_3 || (plan == 1 &&  !var_4)" @click="calculate_sip(plan)">Calculate</button>
                <button class="reset-btn btn" @click="var_1='';var_2='';var_3='';var_4='';var_5='';step = 1">Reset</button>
            </div>
            <div v-if="plan && plan == 5 && step != 3" class="sip-planner-ic-action-cm sip-planner-ic-action-2 mt-4">
                <button id="sip-planner-ic-submit" class="money_title_btn" :disabled="!inflationrate || !goalrateofreturn || !goalinvestmentduration" @click="calculate_goal_sip(plan)">Calculate</button>
                <button class="btn" @click="inflationrate='';goalrateofreturn='';goalinvestmentduration='';goalsipamount='';final_goal_amt='';goal_sip_investments='';goal_sip_amt='';">Reset</button>
            </div>
    
            <div v-if="step == 3" class="sip-planner-ic-action-cm sip-planner-ic-action-2 mt-4">
                <button id="sip-planner-ic-submit" class="money_title_btn" :disabled="!var_5 || !var_6 || !var_7 || !var_8" @click="Calculate_Next">Caculate</button>
                <button class="btn" @click="var_6='';var_7='';var_8='';var_9=''">Reset</button>
            </div>
                </div>
                <div class="col-md-6 right-side">
                    <img src="https://new.myplexus.com/themes/frontend/assets/v1/img/SIPCalculator,.png" class="w-100">
                </div>
            </div>
        
        </div>
        <div class="row mx-0 invst-fields invst-field-1 justify-content-between align-items-center sip-planner-ic-action">
            <div class="sip-planner-ic-action-cm sip-planner-ic-action-1">
                <a v-if="sip_pdf_url" :href="sip_pdf_url" target="_blank" class="sip-tut text-white">SIP Tutorial</a>
            </div>
           
        </div>
        <div class="row">
            <div id="screen_capture" class="mt-3 w-100">
                <div class="col-md-12">
                    <div class="graph_div" ref="printMe">
                        <div id="chartContainerGOAL" style="width: 100%;" :class="{'height_370':showchart}"></div>
                        <div v-show="showchart" style="height:30px; width:70px; background:#fff; position:absolute; z-index:999;bottom:0" id="myplexusC"></div>
                    </div>
                </div>
            </div>
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
    </div>
    </template>
    
    <script>
    import mixin from '../../mixin';
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
            sip_faqs: {
                type: String,
                required: true,
                default: '',
            },
            sip_pdf_url: {
                type: String,
                required: true,
                default: '',
            },
        },
        components: {},
        mixins: [mixin],
        data() {
            return {
                name: this.username,
                email: this.useremail,
                phone: '',
                step: 1,
                plan: '',
                var_1: '',
                var_2: '',
                var_3: '',
                var_4: '',
                var_5: '',
                var_6: '',
                var_7: '',
                var_8: '',
                var_9: '',
                inflationrate: '',
                goalrateofreturn: '',
                goalinvestmentduration: '',
                goalsipamount: '',
                final_goal_amt: '',
                final_goal_amt_hid: '',
                goal_sip_amt: '',
                goal_sip_investments: '',
                goal_sip_amt_hid: '',
                goal_sip_investments_hid: '',
                error_msg: '',
                error_msg2: '',
                chart: null,
                showchart: false,
                output: null,
                emailMsg: ''
            }
        },
        methods: {
            Calculate_Next() {
                $("#hid_next").val(1);
                var var_5 = this.var_5
                var var_6 = this.var_6
                var var_7 = this.var_7
                var var_8 = this.var_8
                if (var_5 == "" || var_6 == "" || var_7 == "" || var_8 == "") {
                    this.error_msg2 = 'Please fill all the fields.'
                    return false;
                } else {
                    this.var_9 = (var_5 / ((1 - Math.pow((1 + var_8 / 1200), (var_6 * var_7))) / ((-1 * var_8) / 1200))).toFixed(2);
                }
                this.send_graph_result();
            },
            async calculate_sip(ival) {
                var var_1 = this.var_1;
                var var_2 = this.var_2;
                var var_3 = this.var_3;
    
                var var_4 = this.var_4;
                var MonthlyRequirement;
                var Amt = new Number(65);
                var Infl;
                var Yr, iCount;
                var Intr;
                var ReturnRate;
                var var_5;
                if (ival == 1) {
                    MonthlyRequirement = var_1; //************* as mentioned above 
                    Amt = MonthlyRequirement * 12; //************* yearly requirement
                    Infl = var_3; //************* as mentioned above 
                    Yr = var_2; //************* as mentioned above 
                    ReturnRate = var_4; //************* as mentioned above
    
                    Intr = (Infl * Amt) / 100;
    
                    for (let icount = 1; icount <= Yr; icount++) {
                        Amt = Amt + Intr;
                        Intr = (Infl * Amt) / 100;
                    }
                    Amt = (Amt * 100) / ReturnRate;
    
                    var_5 = parseFloat(Amt).toFixed(2);
                } else {
                    Amt = var_1 * 1;
                    Infl = var_3; //************* as mentioned above 
                    Yr = var_2; //************* as mentioned above 
                    //************* as mentioned above
    
                    Intr = (Infl * Amt) / 100;
    
                    for (let icount = 1; icount <= Yr; icount++) {
                        Amt = Amt + Intr;
                        Intr = (Infl * Amt) / 100;
                    }
    
                    var_5 = Amt.toFixed(2);
                }
    
                this.var_5 = var_5;
                this.showchart = false
                this.chart = null;
                document.getElementById("chartContainerGOAL").innerHTML = "";
                await this.send_graph_result();
                this.step = 2
            },
            async calculate_goal_sip() {
    
                var goalAmount = this.goalsipamount
                var rateOfReturn = this.goalrateofreturn;
                var investmentDuration = this.goalinvestmentduration;
                var annualInflationRate = 0;
                var inflation_rate = this.inflationrate;
                var final_goal_amt = 0;
    
                final_goal_amt = goalAmount * Math.pow((1 + parseFloat(inflation_rate) / 100), investmentDuration);
    
                var result = this.goalSipCalculator(final_goal_amt, (rateOfReturn - annualInflationRate), investmentDuration);
                console.log(result);
                if (result === null) {
                    this.error_msg = 'Error! Ensure all the values are valid numbers.'
                } else {
                    this.showchart = true
                    this.final_goal_amt = parseFloat(final_goal_amt).toFixed(2);
                    this.final_goal_amt_hid = parseFloat(final_goal_amt).toFixed(2);
                    this.goal_sip_amt = parseFloat(result.pmtValue).toFixed(2);
                    this.goal_sip_investments = parseFloat(result.investment).toFixed(2);
    
                    this.goal_sip_amt_hid = parseFloat(result.pmtValue).toFixed(2);
                    this.goal_sip_investments_hid = parseFloat(result.investment).toFixed(2);
    
                    this.get_goal_graph();
                    await this.send_graph_result();
                }
    
            },
            goalSipCalculator(goalAmount, rateOfReturn, investmentDuration) {
                // PMT is an internal function
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
            isNumeric(n) {
                return !isNaN(parseFloat(n)) && isFinite(n);
            },
            async send_graph_result() {
    
                if (this.showchart) {
                    const el = this.$refs.printMe;
                    const options = {
                        type: 'dataURL'
                    }
                    this.output = await this.$html2canvas(el, options);
                }
                let form_data = [
    
                ]
                let result_data = [
    
                ]
                if (this.step == 1 && this.plan != 5) {
    
                    if (this.plan == 1) {
                        form_data.push({
                            'text': 'Plan',
                            value: 'Planning for retirement'
                        })
                        form_data.push({
                            'text': 'Current monthly expenditure (in Rs.)',
                            value: this.var_1
                        })
                        form_data.push({
                            'text': 'Number of years left for retirement (Max. 50 years)',
                            value: this.var_2
                        })
                        form_data.push({
                            'text': 'Assume a rate of inflation (in %)',
                            value: this.var_3
                        })
                        form_data.push({
                            'text': 'Assume a risk free rate of return on your retirement fund (in Rs.)',
                            value: this.var_4
                        })
                        result_data.push({
                            'text': 'Retirement Fund required to meet your post retirement monthly expenses (in Rs.)',
                            value: this.var_5
                        })
                    }
                    if (this.plan == 2) {
                        form_data.push({
                            'text': 'Plan',
                            value: "Planning for child's marriage"
                        })
                        form_data.push({
                            'text': 'What is the present cost of such marriage ? (in Rs.)',
                            value: this.var_1
                        })
                        form_data.push({
                            'text': 'After how many years is your child likely to get married ? (Max. 50 years)',
                            value: this.var_2
                        })
                        form_data.push({
                            'text': 'Assume a rate of inflation (in %)',
                            value: this.var_3
                        })
                        result_data.push({
                            'text': "The amount you would require for your child's marriage (in Rs.)",
                            value: this.var_5
                        })
                    }
                    if (this.plan == 3) {
                        form_data.push({
                            'text': 'Plan',
                            value: "Planning for child's higher education"
                        })
                        form_data.push({
                            'text': 'What is the present cost of such educaton ? (in Rs.)',
                            value: this.var_1
                        })
                        form_data.push({
                            'text': 'After how many years is your child likely to go for higher education ? (Max. 50 years)',
                            value: this.var_2
                        })
                        form_data.push({
                            'text': 'Assume a rate of inflation (in %)',
                            value: this.var_3
                        })
                        result_data.push({
                            'text': "The amount you would require for yor child's higher education (in Rs.)",
                            value: this.var_5
                        })
                    }
                    if (this.plan == 4) {
                        form_data.push({
                            'text': 'Plan',
                            value: 'Planning for owning an asset'
                        })
                        form_data.push({
                            'text': 'What is the present cost of such asset ? (in Rs.)',
                            value: this.var_1
                        })
                        form_data.push({
                            'text': 'After how many years you are planning to buy the said asset ? (Max. 50 years)',
                            value: this.var_2
                        })
                        form_data.push({
                            'text': 'Assume a rate of inflation (in %)',
                            value: this.var_3
                        })
                        result_data.push({
                            'text': "Amount you would require to own the said asset (in Rs.)",
                            value: this.var_5
                        })
                    }
    
                }
                if (this.step == 3) {
    
                    if (this.plan == 1) {
                        form_data.push({
                            'text': 'Plan',
                            value: 'Planning for retirement'
                        })
                    }
                    if (this.plan == 2) {
                        form_data.push({
                            'text': 'Plan',
                            value: "Planning for child's marriage"
                        })
                    }
                    if (this.plan == 3) {
                        form_data.push({
                            'text': 'Plan',
                            value: "Planning for child's higher education"
                        })
                    }
                    if (this.plan == 4) {
                        form_data.push({
                            'text': 'Plan',
                            value: 'Planning for owning an asset'
                        })
                    }
                    form_data.push({
                        'text': 'Amount Required on maturity (in Rs.)',
                        value: this.var_5
                    })
                    form_data.push({
                        'text': 'Number of years (Max. 50 years)',
                        value: this.var_6
                    })
                    form_data.push({
                        'text': 'Frequency (Time a year)',
                        value: this.var_7
                    })
                    form_data.push({
                        'text': 'Expected yield on investment (in %)',
                        value: this.var_8
                    })
                    result_data.push({
                        'text': 'Installment amount to be invested: (in %)',
                        value: this.var_9
                    })
                }
                if (this.plan == 5) {
                    form_data.push({
                        'text': 'Plan',
                        value: 'Others'
                    })
                    form_data.push({
                        'text': 'Goal Amount (Rs.)',
                        value: this.final_goal_amt
                    })
                    form_data.push({
                        'text': 'Investment Duration (Y)',
                        value: this.goalinvestmentduration
                    })
                    form_data.push({
                        'text': 'Expected Rate of Return (%p.a.)',
                        value: this.goalrateofreturn
                    })
                    form_data.push({
                        'text': 'Annual Inflation Rate (%)',
                        value: this.inflationrate
                    })
    
                    result_data.push({
                        'text': 'Inflation Adjusted Goal Amount (Rs.)',
                        value: this.final_goal_amt
                    })
                    result_data.push({
                        'text': 'Your Total Investment (Rs.)',
                        value: this.goal_sip_investments
                    })
                    result_data.push({
                        'text': 'Monthly SIP Amount (Rs.)',
                        value: this.goal_sip_amt
                    })
    
                }
                let data = {
                    name: this.name,
                    email: this.email,
                    phone: this.phone,
                    step: this.step,
                    plan: this.plan,
                    var_1: this.var_1,
                    var_2: this.var_2,
                    var_3: this.var_3,
                    var_4: this.var_4,
                    var_5: this.var_5,
                    var_6: this.var_6,
                    var_7: this.var_7,
                    var_8: this.var_8,
                    var_9: this.var_9,
                    inflationrate: this.inflationrate,
                    goalrateofreturn: this.goalrateofreturn,
                    goalinvestmentduration: this.goalinvestmentduration,
                    goalsipamount: this.goalsipamount,
                    final_goal_amt: this.final_goal_amt,
                    final_goal_amt_hid: this.final_goal_amt_hid,
                    goal_sip_amt: this.goal_sip_amt,
                    goal_sip_investments: this.goal_sip_investments,
                    goal_sip_amt_hid: this.goal_sip_amt_hid,
                    goal_sip_investments_hid: this.goal_sip_investments_hid,
                    output: this.output,
                    form_data: form_data,
                    result_data: result_data,
                };
    
                axios.post('/api/v1/send-sip-planner-email', data)
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
            async get_goal_graph() {
                let that = this
                var goal_sip_amount = this.goalsipamount;
                var goal_investment_duration = this.goalinvestmentduration;
                var goal_rate_of_return = this.goalrateofreturn;
                var goal_sip_pmt = this.goal_sip_amt;
                var i = 1;
                var invested_amt = 0;
                var return_amt = 0;
                var dataPoints1 = [];
                var dataPoints2 = [];
    
                for (i = 1; i <= goal_investment_duration; i++) {
                    invested_amt = goal_sip_pmt * (i * 12);
                    return_amt = -this.calculateFV((goal_rate_of_return / 12 / 100), i * 12, goal_sip_pmt, 0, 0);
                    dataPoints1.push({
                        label: i + " Year",
                        y: invested_amt
                    });
                    dataPoints2.push({
                        label: i + " Year",
                        y: return_amt
                    });
                }
                let chart = {
                    // animationEnabled: true,
                    height: 370,
                    title: {
                        text: "Goal Sip Calculator Chart"
                    },
                    axisY: {
                        title: "Rs."
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
                            name: "Invested Amount",
                            color: '#6ab130',
                            yValueFormatString: "##.00",
                            dataPoints: dataPoints1
                        },
                        {
                            type: "column",
                            showInLegend: true,
                            name: "Return",
                            color: "#000",
                            yValueFormatString: "##.00",
                            dataPoints: dataPoints2
                        }
                    ]
                }
                CanvasJS.addColorSet("greenShades", ['#6ab130']);
                this.chart = new CanvasJS.Chart("chartContainerGOAL", chart);
                this.chart.render();
            },
            calculateFV(rate, nper, pmt, pv, per) {
                //alert('nper-'+nper);
                //alert('pmt-'+pmt);
                var fv_value, x;
                nper = parseFloat(nper);
                pmt = parseFloat(pmt);
                pv = parseFloat(pv);
                //rate = eval((rate) / (per * 100));
                if ((pmt == 0) || (nper == 0)) {
                    //alert("Why do you want to test me with zeros?");
                    return (0);
                }
    
                if (rate == 0) { // Interest rate is 0
                    fv_value = -(pv + (pmt * nper));
                } else {
                    x = Math.pow(1 + rate, nper);
                    fv_value = -(-pmt + x * pmt + rate * x * pv) / rate;
                }
                fv_value = this.conv_number(fv_value, 2);
                return fv_value;
            },
            conv_number(expr, decplaces) {
                var str = "" + Math.round(eval(expr) * Math.pow(10, decplaces));
                while (str.length <= decplaces) {
                    str = "0" + str;
                }
    
                var decpoint = str.length - decplaces;
                return (str.substring(0, decpoint) + "." + str.substring(decpoint, str.length));
            },
            toolTipFormatter(e) {
                var str = "";
                var total = 0;
                var str3;
                var str2;
                for (var i = 0; i < e.entries.length; i++) {
                    var str1 = "<span style= \"color:" + e.entries[i].dataSeries.color + "\">" + e.entries[i].dataSeries.name + "</span>: <strong>" + e.entries[i].dataPoint.y + "</strong> <br/>";
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
            }
        },
        watch: {
    
        },
        computed: {
    
        },
        mounted() {
    
        },
    }
    </script>
    
    <style>
    .height_370 {
        height: 370px;
    }
    </style>
    