<template>
<div class="invst-wrap invst-risk-tol-calc">
    <template v-if="!Object.keys(calculatedValues).length">
        <div class="row m-0 invst-fields invst-field-1 justify-content-between" v-if="!start">
            <div class="risk-tol-eval-common risk-tol-eval-email">
                <label>Email Address</label>
                <input type="email" id="risk-tolerance-user-email" v-model="email" readonly placeholder="Enter Email" />
            </div>
            <div class="risk-tol-eval-common risk-tol-eval-name">
                <label>Enter Name</label>
                <input type="text" id="risk-tolerance-username" v-model="name" placeholder="Enter Name" />
            </div>
        </div>

        <div class="invst-fields-action-buttons" v-if="!start">
            <div class="row m-0 justify-content-end">
                <div class="action-common action-btn-1">
                    <button id="next-step" class="btn btn-green" href="javascript:void(0);" @click="start=true">Next Step</button>
                </div>
            </div>
        </div>

        <div class="risk-tol-choose-age" v-if="start">
            <div class="risk-tol-age-wrap">
                <div v-for="(question,index) in questions" :key="index">
                <div v-if="index == activeIndex" class="row align-items-center risk-tol-age-wrap-in">
                    <div class="risk-tol-age-lft">
                        <h5 v-html="question.q"></h5>
                    </div>
                    <div class="risk-tol-age-rgt">
                        <div class="form-check" v-for="(option,key) in question.o" :key="key">
                            <label class="form-check-label" :for="'optradio'+key" v-if="option">
                                <input :id="'optradio'+key" type="radio" class="form-check-input" name="optradio" :value="key" v-model="question.a" /> {{ option }}
                            </label>
                        </div>
                    </div>
                </div>
                </div>
                <div class="invst-fields-action-buttons risk-tol-age-action">
                    <div class="row m-0 justify-content-end">
                        <div class="action-common action-btn-1">
                            <button id="back" class="btn btn-dark" @click="previous">Back</button>
                        </div>
                        <div class="action-common action-btn-2">
                            <button :disabled="!questions[activeIndex].a" id="next" class="btn btn-green" @click="next" v-if="activeIndex < (questions.length - 1) && !(activeIndex == (questions.length - 3) && questions[activeIndex].a == 2)">Next</button>
                            <button :disabled="!questions[activeIndex].a || process"  id="next" class="btn btn-green" @click="submitForm" v-if="activeIndex == (questions.length - 1) || (activeIndex == (questions.length - 3) && questions[activeIndex].a == 2)">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </template>
    <div class="w-100 text-center" v-if="process">
        <svg style="width:100px" version="1.1" id="L1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
            <circle fill="none" stroke="#fff" stroke-width="6" stroke-miterlimit="15" stroke-dasharray="14.2472,14.2472" cx="50" cy="50" r="47" >
            <animateTransform 
                attributeName="transform" 
                attributeType="XML" 
                type="rotate"
                dur="5s" 
                from="0 50 50"
                to="360 50 50" 
                repeatCount="indefinite" />
        </circle>
        <circle fill="none" stroke="#fff" stroke-width="1" stroke-miterlimit="10" stroke-dasharray="10,10" cx="50" cy="50" r="39">
            <animateTransform 
                attributeName="transform" 
                attributeType="XML" 
                type="rotate"
                dur="5s" 
                from="0 50 50"
                to="-360 50 50" 
                repeatCount="indefinite" />
        </circle>
        <g fill="#fff">
        <rect x="30" y="35" width="5" height="30">
            <animateTransform 
            attributeName="transform" 
            dur="1s" 
            type="translate" 
            values="0 5 ; 0 -5; 0 5" 
            repeatCount="indefinite" 
            begin="0.1"/>
        </rect>
        <rect x="40" y="35" width="5" height="30" >
            <animateTransform 
            attributeName="transform" 
            dur="1s" 
            type="translate" 
            values="0 5 ; 0 -5; 0 5" 
            repeatCount="indefinite" 
            begin="0.2"/>
        </rect>
        <rect x="50" y="35" width="5" height="30" >
            <animateTransform 
            attributeName="transform" 
            dur="1s" 
            type="translate" 
            values="0 5 ; 0 -5; 0 5" 
            repeatCount="indefinite" 
            begin="0.3"/>
        </rect>
        <rect x="60" y="35" width="5" height="30" >
            <animateTransform 
            attributeName="transform" 
            dur="1s" 
            type="translate" 
            values="0 5 ; 0 -5; 0 5"  
            repeatCount="indefinite" 
            begin="0.4"/>
        </rect>
        <rect x="70" y="35" width="5" height="30" >
            <animateTransform 
            attributeName="transform" 
            dur="1s" 
            type="translate" 
            values="0 5 ; 0 -5; 0 5" 
            repeatCount="indefinite" 
            begin="0.5"/>
        </rect>
        </g>
        </svg>
    </div>
    <div class="risk-tol-eval-results br-5" v-if="Object.keys(calculatedValues).length">
        <div class="risk-tol-eval-result-table br-5">
            <h3>Evaluation Results</h3>
            <h6>Hello {{ name }}, Here is summary of your Risk Profile that you just filled.</h6>
            <table id="evaluation-results" class="br-5 box-shadow border-s">
                <thead>
                    <tr>
                        <th>Parameter</th>
                        <th>Type of investor</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Capacity to take Risk</td>
                        <td>{{ calculatedValues.capacity_to_take_risk_for_accor1 }}</td>
                        <td><img :src="'images/'+calculatedValues.accor1_star+'-green-star.png'" :alt="calculatedValues.accor1_star+' - star'" /></td>
                    </tr>
                    <tr>
                        <td>Risk appetite</td>
                        <td>{{ calculatedValues.capacity_to_take_risk_for_accor2 }}</td>
                        <td><img :src="'images/'+calculatedValues.accor2_star+'-green-star.png'" :alt="calculatedValues.accor2_star+' - star'" /></td>
                    </tr>
                    <tr>
                        <td>Need to take Risk</td>
                        <td>{{ calculatedValues.capacity_to_take_risk_for_accor3 }}</td>
                        <td><img :src="'images/'+calculatedValues.accor3_star+'-green-star.png'" :alt="calculatedValues.accor3_star+' - star'" /></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="risk-tol-eval-risk-profile br-5" >
            <div class="row risk-profile-titles">
                <div class="col-lg-6 col-md-6 col-sm-6 title-1"><h3>Your Overall Risk Profile</h3></div>
                <div class="col-lg-6 col-md-6 col-sm-6 title-2"><h3>{{ calculatedValues.capacity_to_take_risk_for_total }}</h3></div>
            </div>
            <table id="overall-risk-profile" class="br-5 box-shadow">
                <thead>
                    <tr>
                        <th>Score</th>
                        <th>Tolerance level</th>
                        <th>Preferable Equity holding</th>
                        <th>Preferable Debt holding</th>
                        <th>Type of Investor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-very-high">
                        <td>4-5</td>
                        <td>Very High</td>
                        <td>100%</td>
                        <td>0%</td>
                        <td>Highly Aggresive</td>
                    </tr>
                    <tr class="table-moderate">
                        <td>3-4</td>
                        <td>Moderate</td>
                        <td>80%</td>
                        <td>20%</td>
                        <td>HAggresive</td>
                    </tr>
                    <tr class="table-high">
                        <td>3-2</td>
                        <td>High</td>
                        <td>60%</td>
                        <td>40%</td>
                        <td>Moderate</td>
                    </tr>
                    <tr class="table-low">
                        <td>1-2</td>
                        <td>Low</td>
                        <td>40%</td>
                        <td>60%</td>
                        <td>Conservative</td>
                    </tr>
                    <tr class="table-very-low">
                        <td>0-1</td>
                        <td>Very Low</td>
                        <td>20%</td>
                        <td>80%</td>
                        <td>Highly Conservative</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>    
</template>
<script>
import mixin from '../../mixin';
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
        
  },
  mixins: [mixin],
   data() {
            return {
                name:this.username,
                email:this.useremail,
                start:false,
                questions:[
{
	q:"How old are you?",
	o:{
		1:"<=20 years old",
		2:"21 years old - 40 years old",
		3:"41 years old - 60 years old",
		4:"60 years old - 80 years old",
		5:">=80 years old",
	},
	a:null,
},
{
	q:"How much is your annual income (before taxes)?",
	o:{
		1:"25 lakhs+",
		2:"15-25 lakhs",
		3:"10-15 lakhs",
		4:"5-10 lakhs",
		5:"<5 lakhs",
	},
	a:null,
},
{
	q:"What is the total value of your savings and investments till date?",
	o:{
		1:"20 lakhs+",
		2:"10-20 lakhs",
		3:"5-10 lakhs",
		4:"1-5 lakhs",
		5:"<1 lakhs",
	},
	a:null,
},
{
	q:"Your current and future income sources (for example, salary, business income) are:",
	o:{
		1:"Very stable",
		2:"Stable",
		3:"Somewhat stable",
		4:"Unstable",
		5:"Very unstable",
	},
	a:null,
},
{
	q:"Your household can be best described as: *Select the option that is closest to your answer.",
	o:{
		1:"Dual income, no dependents",
		2:"Dual income, at least one dependent",
		3:"Single income, no dependents",
		4:"Single income, at least one dependent",
		5:"No income/Retired",
	},
	a:null,
},
{
	q:"Which of the following insurances do you have?<br>a. Life Insurance Term Plan<br>b. Life Insurance (other types e.g. ULIP, Money Back)<br>c. Health Insurance<br>d. Personal Accident Insurance",
	o:{
		1:"4 of above",
		2:"3 of above",
		3:"2 of above",
		4:"1 of above",
		5:"None",
	},
	a:null,
},
{
	q:"Which investment products have you invested in so far?<br>a.Fixed Deposits<br>b.EPF Stocks<br>c.PPF/LIC or other insurance cum investment schemes<br>d.Equity Mutual Funds",
	o:{
		1:"4 of above",
		2:"3 of above",
		3:"2 of above",
		4:"1 of above",
		5:"None",
	},
	a:null,
},
{
	q:"What degree of risk have you taken with your investments in the past?",
	o:{
		1:"Very Large (trading Futures and Options)",
		2:"Large (primarily stocks and Mutual Funds)",
		3:"Medium (almost equal amounts of FD and Mutual Funds)",
		4:"Small (little bit of stocks and Mutual Funds)",
		5:"Very Small (e.g. Bank deposits and FDs only)",
	},
	a:null,
},
{
	q:"What degree of risk are you currently prepared to take with your investments?",
	o:{
		1:"Very Large (trading Futures and Options)",
		2:"Large (primarily stocks and Mutual Funds)",
		3:"Medium (comparable amount of FDs and Mutual Funds)",
		4:"Small (little bit of Mutual Funds)",
		5:"Very Small (e.g. Bank deposits and FDs only)",
	},
	a:null,
},
{
	q:"When faced with a major investment decision, are you more concerned about the possible losses or the possible gains?",
	o:{
		1:"Always the possible gains",
		2:"Usually the possible gains",
		3:"Usually go with market flow",
		4:"Usually the possible losses",
		5:"Always the possible losses",
	},
	a:null,
},
{
	q:"Which risk-return combination would you prefer?",
	o:{
		1:"20% annual returns with chances of a 50% interim loss at some point",
		2:"15% annual returns with chances of a 35% interim loss at some point",
		3:"12% annual returns with chances of a 25% interim loss at some point",
		4:"10% annual returns with chances of a 15% interim loss at some point",
		5:"7% annual returns with low chances of any loss",
	},
	a:null,
},
{
	q:"Consider a scenario where you have made some investments in stocks, either directly or through Mutual Funds. What are you most likely to do in the event of a sudden fall in the stock market?",
	o:{
		1:"Invest more to take advantage of the fall in stock prices",
		2:"Do nothing as this is how stock markets behave generally",
		3:"Sell poor performed schemes and stay invested in the rest",
		4:"Sell some of your investments and keep the rest",
		5:"Sell all your investments to avoid any further erosion",
	},
	a:null,
},
{
	q:"In 2007 the stock market did very well but just next year in 2008 it crashed by almost 60%. If something like that happens this year or next year, how much loss in the total value of your long term investments would you be okay with before you begin to feel uncomfortable?",
	o:{
		1:"Any loss is fine",
		2:"40-50%",
		3:"25-30%",
		4:"15-20%",
		5:"Never OK to see my investments in loss",
	},
	a:null,
},
{
	q:"How long will you stick to your investment plan if it does not meet your expectations of returns?",
	o:{
		1:"> 6 years",
		2:"5-6 years",
		3:"4-5 years",
		4:"2-3 years",
		5:"< 1 year",
	},
	a:null,
},
{
	q:"What is your primary investment objective?",
	o:{
		1:"Future Lifestyle Improvement",
		2:"Children Education",
		3:"Retirement Planning",
		4:"Capital Appreciation",
		5:"Capital Preservation",
	},
	a:null,
},
{
	q:"Do you have your own house/Apartment?",
	o:{
		1:"Yes",
		2:"",
		3:"",
		4:"No",
		5:"",
	},
	a:null,
},
{
	q:"Do you have a goal for which you want to stay invested?",
	o:{
		1:"Yes",
		2:"otherwise",
		3:"",
		4:"",
		5:"",
	},
	a:null,
},
{
	q:"If it is time rigid then what is that time tenure ?",
	o:{
		1:"<7 years",
		2:"6 to 7 year",
		3:"3 to 5 year",
		4:"1 to 2 year",
		5:"< 1 year",
	},
	a:null,
},
{
	q:"If it is amount rigid then what is your expected return from investment?",
	o:{
		1:"Potential return of 6% per annum",
		2:"Potential return of 10% per annum",
		3:"Potential return of 12% per annum",
		4:"Potential return of 15% per annum",
		5:"Potential return of more than 15% per annum",
	},
	a:null,
},
],
activeIndex:0,
calculatedValues:[],
process:false
            }
  },
  methods: {
     previous(){
         if(this.activeIndex){
            this.activeIndex = this.activeIndex - 1;
         }else{
             this.start = false
         }
     },
     next(){
         if(this.activeIndex < this.questions.length){
            this.activeIndex = +(this.activeIndex) + 1;
         }
     },
     submitForm(){
       let that = this
       this.process = true
       let ansArr = []
       for(let icount=0;icount < that.questions.length;icount++){
           ansArr.push({question:icount+1,answer:that.questions[icount]['a']})
       }
       let data = {
           name:that.name,
           email:that.email,
           answers:ansArr
       }  
       axios.post('/api/v1/calculate-risk-tolerance-portfolio',data)
            .then(response => {
                this.calculatedValues = response.data.data.risk_tolerance_portfolio
            })
            .then(response => {
                
            })
            .catch(error => {
                console.log(error);
            })
            .finally(() => {
                this.process = false
            })
     }
  },
  watch: {
      
},
  computed: {
    activeQuestion(){
          return (this.questions.length)?this.questions[this.activeIndex]:false
    },
  },
  mounted() {
    
  },
}
</script>
<style>

</style>
