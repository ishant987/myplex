<template>
<div class="invst-wrap invst-retirement-calc">

    <h3>Retirement Calulator</h3>

    <div class="row invst-fields invst-field-1 justify-content-between">
        <div class="invst-retirement-column col-sm-12 mt-0">
            <label class="" data-toggle="tooltip" data-placement="top" title="How old are you in the present?">Current age *</label>
            <select v-model="current_age" id="current_age" class="js-example-placeholder-single js-states form-control">
                <option disabled value="">Select Current Age</option>
                <option :value="index+14" v-for="index in 56" :key="index+14">{{index+14}}</option>
            </select>
        </div>
        <div class="invst-retirement-column col-sm-12 mt-0">
            <label class="" data-toggle="tooltip" data-placement="top"  title="At which age you expect your retirement?">Expected age of Retirement *</label>
            <select v-model="retirement_age" id="retirement_age" class="js-example-placeholder-single js-states form-control">
                <option disabled value="">Select Retirement Age</option>
                <option :value="index+49" v-for="index in 26" :key="index+49">{{index+49}}</option>
            </select>
        </div>

        <div class="invst-retirement-column col-sm-12">
            <label class="" data-toggle="tooltip" data-placement="top"  title="Till which age you need to save corpus?">Life Expectancy *</label>
            <select v-model="life_expect" id="life_expect" class="js-example-placeholder-single js-states form-control">
                <option disabled value="">Select Life Expectancy</option>
                <option :value="index+69" v-for="index in 41" :key="index+69">{{index+69}}</option>
            </select>
        </div>
        <div class="invst-retirement-column col-sm-12">
            <label class="" data-toggle="tooltip" data-placement="top"  title="How much rate of return you are expecting before your retirement? Optimistic – 12%, Realistic – 10%, Aggressive – 14%">Rate of return during accumulation period *</label>
            <select v-model="return_during" id="return_during" class="js-example-placeholder-single js-states form-control">
                <option disabled value="">Select Rate of return during accumulation</option>
                <option :value="index+2" v-for="index in 18" :key="index+2">{{index+2}}</option>
            </select>
        </div>

        <div class="invst-retirement-column col-sm-12">
            <label class="" data-toggle="tooltip" data-placement="top"  title="How much rate of return you are expecting after your retirement? Optimistic – 8%, Realistic – 7%">Rate of return after retirement *</label>
            <select v-model="return_after" id="return_after" class="js-example-placeholder-single js-states form-control">
                <option disabled value="">Select Rate of return after retirement</option>
                <option :value="index+2" v-for="index in 18" :key="index+2">{{index+2}}</option>
            </select>
        </div>
        <div class="invst-retirement-column col-sm-12">
            <label class="" data-toggle="tooltip" data-placement="top"  title="General Rate of increment in prices, Realistic – 4%-8%">Inflation *</label>
            <select v-model="inflation" id="inflation" class="js-example-placeholder-single js-states form-control">
                <option disabled value="">Select Inflation</option>
                <option :value="index+1" v-for="index in 7" :key="index+1">{{index+1}}</option>
            </select>
        </div>

        <div class="invst-retirement-column col-sm-12">
            <label class="" data-toggle="tooltip" data-placement="top"  title="The amount of money you generally spent every month">Monthly expenditure (In Rs.) *</label>
            <input type="number" id="monthly_expence" v-model="monthly_expence" placeholder="" />
        </div>
        <div class="invst-retirement-column col-sm-12">
            <label class="" data-toggle="tooltip" data-placement="top"  title="Do you have any pension scheme? If yes then mention expected pension each month after retirement.">Pension/income after retirement (If any)</label>
            <input type="number" id="pension" v-model="pension" />
        </div>

        <div class="invst-retirement-column col-sm-12">
            <label class="" data-toggle="tooltip" data-placement="top"  title="Do you have any ongoing monthly savings planning? If yes then mention the amount of money you are investing each month.">Current Savings per month/SIP (If any)</label>
            <input type="number" id="curr_savings" v-model="curr_savings"/>
        </div>
        <div class="invst-retirement-column col-sm-12">
            <label class="" data-toggle="tooltip" data-placement="top"  title="Did you invest any lumpsum amount of money from which you are expecting a return at the age of retirement? If yes then mention the lump sum amount.">Current lump sum (If any)</label>
            <input type="number" id="current_lumsum" v-model="current_lumsum"/>
        </div>
        <div class="invst-retirement-calc invst-inflation-calc col-12">
            <div class="invst-fields-action-buttons">
                <div class="row m-0 justify-content-end">
                    <div class="action-common action-btn-1">
                        <button id="show-table" class="btn btn-green" :disabled="disabledCalculate" @click="calculate_retirement">Calculate</button>
                    </div>
                </div>
            </div>
        </div>
        <p v-if="errorMsg" class="text-danger mt-3 mb-3 w-100 text-right">{{ errorMsg }}</p>
        <div class="invst-inflation-data col-12" v-if="corpus_need_on_retirement || savings_required_per_month || savings_equired_per_year">
            <div class="row m-0">
                <div class="col-lg-4 col-md-4 col-sm-4 inflataion-data-common">
                    <h5>Corpus you will need on retirement</h5>
                    <span class="data">{{corpus_need_on_retirement}}</span>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 inflataion-data-common">
                    <h5>Savings Required per month</h5>
                    <span class="data">{{savings_required_per_month}}</span>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 inflataion-data-common">
                    <h5>Savings Required per year</h5>
                    <span class="data">{{savings_equired_per_year}}</span>
                </div>
            </div>
        </div>

    </div>

    <p v-if="emailMsg" class="text-success mt-3 mb-3 w-100 text-right">{{ emailMsg }}</p>
    <div class="row mt-5">
        <div id="screen_capture" class="mt-3 w-100">
        <div class="col-md-12">
            <div class="graph_div" ref="printMe" style="position: relative;">
                <div id="chartContainerRetirementCal" style="width: 100%;" :class="{'height_370':showchart}"></div>
                <div v-show="showchart"  style="height:30px; width:70px; background:#fff; position:absolute; z-index:999;bottom: 0px;"  id="myplexusC"></div> 
            </div>
        </div>
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

    },
    components: {
        
  },
  mixins: [mixin],
   data() {
            return {
                name:this.username,
                email:this.useremail,
                process:false,
                current_expenses:'',
                inflation_rate:'',
                period:'',
                showchart:false,
                chart:null,
                emailMsg:'',
                searchTimeout: null,
                output:null,
                current_age:'',
                retirement_age:'',
                life_expect:'',
                return_during:'',
                return_after:'',
                inflation:'',
                monthly_expence:'',
                pension:0,
                curr_savings:0,
                current_lumsum:0,
                errorMsg:'',
                corpus_need_on_retirement:'',
                savings_required_per_month:'',
                savings_equired_per_year:'',
            }
  },
  methods: {

    calculate_retirement(){
	
		var current_age =  this.current_age * 1;
		var retirement_age =  this.retirement_age * 1;
		var life_expect =  this.life_expect * 1;
		var return_during =  this.return_during/100;
		var return_after =  this.return_after/100;
		var inflation =  this.inflation/100;
		var monthly_expence =  this.monthly_expence;
		var pension =  this.pension;
		var curr_savings =  this.curr_savings;
		var current_lumsum =  this.current_lumsum;
		

		
		if (isNaN(current_age) || !current_age) {
			this.errorMsg = "Invalid input for Current age!"
			return false;
		} 
		else if (isNaN(retirement_age) || !retirement_age) {
			this.errorMsg = "Invalid input for Return age!"
			return false;
		}
		else if (isNaN(life_expect) || !life_expect) {
			this.errorMsg = "Invalid input for Life expectancy!"
			return false;
		}
		else if (isNaN(return_during) || !return_during) {
			this.errorMsg = "Invalid input for Rate of return during accumulation period!"
			return false;
		}
		else if (isNaN(return_after) || !return_after) {
			this.errorMsg = "Invalid input for Rate of return after retirement!"
			return false;
		}
		else if (isNaN(inflation) || !inflation) {
			this.errorMsg = "Invalid input for Inflation !"
			return false;
		}
		else if (isNaN(monthly_expence) || !monthly_expence) {
			this.errorMsg = "Invalid input for Monthly expenditure !"
			return false;
		}
		else{
			//return true;
		}
		
		if (isNaN(pension) || !pension) {
			pension = 0;
		}
		else {
			pension = pension;
		}
		
		if (isNaN(curr_savings) || !curr_savings) {
			curr_savings = 0;
		}
		else{
			curr_savings = curr_savings;
		}
		
		if (isNaN(current_lumsum) || !current_lumsum) {
			current_lumsum = 0;
		}
		else{
			current_lumsum = current_lumsum;
		}
		
		if(current_age >= retirement_age || current_age >= life_expect){
			this.errorMsg = "Current Age should be lesser than Retirement Age and Life Expectancy ! "
			return false;
		}
		else if(retirement_age <= current_age || retirement_age >= life_expect){
			this.errorMsg = "Retirement Age should be grater than Current Age and lesser than Life Expectancy ! "
			return false;
		}
		else if(life_expect <= current_age || life_expect <= retirement_age ){
			this.errorMsg = "Life Expectancy should be grater than Current Age and Retirement Age ! "
			return false;
		}
		else{
			
		}
	
		
		var year_before_retirement = retirement_age - current_age;
		var year_after_retirement = life_expect - retirement_age;
		var inflation_adjusted_return = ((1 + return_after)/(1 + inflation)) - 1;
		var total = monthly_expence - pension;
		var retirement_time_curr_monthly_savings = -this.calculateFV((return_during/12),(year_before_retirement * 12),curr_savings,0,0);
		var annual_total = total*12;
		var retirement_time_curr_lumsum_savings =  current_lumsum * Math.pow(1 + return_during, year_before_retirement ); 
		
			
		var retirement_time_expense_per_year = annual_total * Math.pow(1 + inflation, year_before_retirement);
		var corpus_need_on_retirement = -this.calculatePV(inflation_adjusted_return,year_after_retirement,retirement_time_expense_per_year,0,1);
		var required_corpus = corpus_need_on_retirement - (retirement_time_curr_monthly_savings + retirement_time_curr_lumsum_savings);
		var savings_required_per_month = this.calculatePMT(required_corpus,(return_during * 100),year_before_retirement);
		var savings_equired_per_year = savings_required_per_month * 12;
		
		this.corpus_need_on_retirement = this.conv_number(corpus_need_on_retirement,2)
		this.savings_required_per_month = this.conv_number(savings_required_per_month,2)
        this.savings_equired_per_year = this.conv_number(savings_equired_per_year,2)
		
		this.get_retirement_graph(current_age,retirement_age,life_expect,return_during,return_after,inflation,monthly_expence,pension,curr_savings,current_lumsum,year_before_retirement,year_after_retirement,inflation_adjusted_return,total,retirement_time_curr_monthly_savings,annual_total,retirement_time_curr_lumsum_savings,retirement_time_expense_per_year,corpus_need_on_retirement,required_corpus,savings_required_per_month,savings_equired_per_year);
		
 },
 get_retirement_graph(current_age,retirement_age,life_expect,return_during,return_after,inflation,monthly_expence,pension,curr_savings,current_lumsum,year_before_retirement,year_after_retirement,inflation_adjusted_return,total,retirement_time_curr_monthly_savings,annual_total,retirement_time_curr_lumsum_savings,retirement_time_expense_per_year,corpus_need_on_retirement,required_corpus,savings_required_per_month,savings_equired_per_year){
	  
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
		
		
		for(cnt=((current_age*1) + 1);cnt<=(life_expect*1);cnt++){
		
			age = cnt;
			
			if(age < (retirement_age*1 + 1)){
				invested_amount = (( savings_required_per_month + curr_savings) * 12 * i ) + current_lumsum;
				from_lumsum_savings = current_lumsum * Math.pow((1 + return_during),i);
				from_suggested_savings = -this.calculateFV(return_during/12,i*12,savings_required_per_month,0,0);
				from_current_savings = -this.calculateFV(return_during/12,i*12,-curr_savings,0,0);
				total_return_total_balance = from_lumsum_savings + from_suggested_savings + from_current_savings;
				interest = total_return_total_balance - invested_amount;
				withdrawl = 0;
			}else if(age > (retirement_age*1 + 1)){
				interest = total_return_total_balance * return_after*1;
				withdrawl = withdrawl * (1 + inflation*1);
				invested_amount = 0;
				from_lumsum_savings = 0;
				from_suggested_savings = 0;
				from_current_savings = 0;
				if(age == life_expect*1){
					total_return_total_balance = 0;
				}
				else{
					total_return_total_balance = total_return_total_balance - withdrawl + interest;
				}			
				
			}else {
				withdrawl = retirement_time_expense_per_year*1;
				invested_amount = 0;
				from_lumsum_savings = 0;
				from_suggested_savings = 0;
				from_current_savings = 0;
				total_return_total_balance = total_return_total_balance - withdrawl;
				
				interest = 0;
				
			}
		
			investment_in_cr = invested_amount/10000000;
			balance_in_cr = (total_return_total_balance*1)/10000000;
			withdrwal_in_cr = withdrawl/10000000;
			

			dataPointsR1.push({ label: age+" Year" , y: investment_in_cr });
			dataPointsR2.push({ label: age+" Year", y: balance_in_cr  });
			dataPointsR3.push({ label: age+" Year", y: withdrwal_in_cr  });
			
			i++;
		}

		
        console.log(dataPointsR1);
        console.log(dataPointsR2);
        console.log(dataPointsR3);
        let chart = {
            height: 370,
			//animationEnabled: true,
			//exportEnabled: true,
			title:{
				text: "Retirement Calculator Chart"
			},
			axisY: {
				title: "Rs. in Cr."
			},
			legend: {
				cursor:"pointer",
				itemclick : this.toggleDataSeries
			},
			toolTip: {
				shared: true,
				content: this.toolTipFormatter
			},
			data: [
                {        
                    type: "column",  
                    showInLegend: true, 
                    legendMarkerColor: "#6ab130",
                    legendText: "Investment in Cr. (Rs.)",
                    yValueFormatString: "##.00",
                    color:'#6ab130',
                    dataPoints: dataPointsR1,
                },
                {        
                    type: "column",  
                    showInLegend: true, 
                    legendMarkerColor: "#6d78ad",
                    legendText: "Balance in Cr. (Rs.)",
                    yValueFormatString: "##.00",
                    color:'#6d78ad',
                    dataPoints: dataPointsR2,
                },
                {        
                    type: "column",  
                    showInLegend: true, 
                    legendMarkerColor: "#000000",
                    legendText: "Withdrawl in Cr. (Rs.)",
                    yValueFormatString: "##.00",
                    color:'#000000',
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
			var total = 0 ;
			var str3;
			var str2 ;
			for (var i = 0; i < e.entries.length; i++){
				var str1 = "<span style= \"color:"+e.entries[i].dataSeries.color + "\">" + e.entries[i].dataSeries.name + "</span>: <strong>"+  parseFloat(e.entries[i].dataPoint.y).toFixed(2) + "</strong> <br/>" ;
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
			}
			else {
				e.dataSeries.visible = true;
			}
			this.chart.render();
		},
 calculateFV(rate, nper, pmt, pv, per){
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
		fv_value =  this.conv_number(fv_value, 2);
		//alert(fv_value);
		return fv_value;
 },
 calculatePV(rate, periods, payment, future, type){

		
		// Initialize type
  var type = (typeof type === 'undefined') ? 0 : type;

  // Evaluate rate and periods (TODO: replace with secure expression evaluator)
  rate = eval(rate);
  periods = eval(periods);

  // Return present value
  if (rate === 0) {
    var pv_value = - payment * periods - future;
  } else {
    var pv_value = (((1 - Math.pow(1 + rate, periods)) / rate) * payment * (1 +rate * type) - future) / Math.pow(1 + rate, periods);
  }
		//alert(pv_value);
		return pv_value;
 },
 calculatePMT(goalAmount, rateOfReturn, investmentDuration){
    var annualInflationRate = 0;
	
    var result = this.PMTCalculator(goalAmount, (rateOfReturn - annualInflationRate), investmentDuration);
    //alert(result.pmtValue);
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
    async send_graph_result(){

        if(this.showchart){
            const el = this.$refs.printMe;
            const options = {
                type: 'dataURL'
            }
            this.output = await this.$html2canvas(el, options);
        }

        let data = {
            name:this.name,
            email:this.email,
            current_age:this.current_age,
            retirement_age:this.retirement_age,
            life_expect:this.life_expect,
            return_during:this.return_during,
            return_after:this.return_after,
            inflation:this.inflation,
            monthly_expence:this.monthly_expence,
            pension:this.pension,
            curr_savings:this.curr_savings,
            current_lumsum:this.current_lumsum,
            corpus_need_on_retirement:this.corpus_need_on_retirement,
            savings_required_per_month:this.savings_required_per_month,
            savings_equired_per_year:this.savings_equired_per_year,
            output:this.output,
        };
        this.process = true
        axios.post('/api/v1/send-retirement-calculator-email',data)
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
    disabledCalculate(){
                if(this.current_age === '' ||
                this.retirement_age === '' ||
                this.life_expect === '' ||
                this.return_during === '' ||
                this.return_after === '' ||
                this.inflation === '' ||
                this.monthly_expence === '' ||
                this.pension === '' ||
                this.curr_savings === '' ||
                this.current_lumsum === '' || this.process){
                    return true
                }
        return false
    }
  },
  mounted() {
      
  },
}
</script>
<style>
.h-48{
    height: 48px;
}
</style>
