<template>
<div class="invst-wrap inst-inflation-calc">

    <h3>Inflation Calculator</h3>

    <div class="row invst-fields invst-field-1">
        <div class="col-lg-4 col-md-4 col-sm-12 invst-field-1-c invst-field-1-c1">
            <label>Value of Current Expenses (Rs.)</label>
            <input type="number" id="inflation-current-exp" placeholder="10000" min="0" v-model="current_expenses" />
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 invst-field-1-c invst-field-1-c2">
            <label>Annual Inflation Rate (%)</label>
            <select v-model="inflation_rate" id="annual-inflation" class="js-example-placeholder-single js-states form-control">
                <option value="" disabled>Select</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>

            </select>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 invst-field-1-c invst-field-1-c3">
            <label>Time Period (Y)</label>
            <input type="number" v-model="period" id="duration-val" placeholder="12" min="0" />
        </div>
    </div>

    <div class="row invst-fields" v-if="inflation_wealth">
        <div class="col-md-10">
            <label>Inflation Adjusted Amount</label>
            <input type="number" readonly v-model="inflation_wealth" id="return-rate" placeholder="" min="0" />
        </div>
        <div class="col-md-2">
            <label>&nbsp;</label>
            <button class="btn btn-green w-100 h-48" @click="send_graph_result" :disabled="process">Send Mail</button>
        </div>
    </div>

    <p v-if="emailMsg" class="text-success mt-3 mb-3 w-100 text-right">{{ emailMsg }}</p>
    <div class="row mt-5">
        <div id="screen_capture" class="mt-3 w-100">
        <div class="col-md-12">
            <div class="graph_div" ref="printMe">
                <div id="chartContainer" style="width: 100%;" :class="{'height_370':showchart}"></div>
                <div v-show="showchart"  style="height:30px; width:70px; background:#fff; position:absolute; z-index:999;bottom: 0;"  id="myplexusC"></div> 
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
                output:null
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
    get_inflation_graph(){
		var current_expenses = this.current_expenses;
		var inflation_rate = this.inflation_rate;
		var period = this.period;
		this.showchart = true
		var inflated_amt = 0;
		var dataPointsIN = [];
		var i = 1;
		
		for(i=1;i<=period;i++){
			
			inflated_amt = current_expenses * Math.pow((1 + inflation_rate / 100), i);
			dataPointsIN.push({label: i+" Year", y: inflated_amt});
			
		}
		let chart = {
        height: 370,
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title:{
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
            color:'#6ab130',
			dataPoints: dataPointsIN,
			}]
		}
        CanvasJS.addColorSet("greenShades",['#6ab130']);
        this.chart = new CanvasJS.Chart("chartContainer", chart);
        this.chart.render();
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
            current_expenses:this.current_expenses,
            inflation_rate:this.inflation_rate,
            inflation_wealth:this.inflation_wealth,
            period:this.period,
            output:this.output,
        };
        this.process = true
        axios.post('/api/v1/send-inflation-calculator-email',data)
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
    activeQuestion(){
          return (this.questions.length)?this.questions[this.activeIndex]:false
    },
    inflation_wealth(){
        if(this.current_expenses && this.inflation_rate && this.period){
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
    
  },
}
</script>
<style>

</style>
