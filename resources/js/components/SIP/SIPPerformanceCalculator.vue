<template>
    <div class="comp_schem_bdr">
                            <div class="s_renge sip_calc_range_grop">
                                <h4>SIP Performance Calculator</h4>
                                <div class="row">
                                    <div class="col-lg-3 col-md-12">
                                        <div class="range-slider-wrapper">
                                            <span class="slider-heading">SIP Amount (Rs.)</span>
                                            <div id="slider-bedrooms" class="slider" data-min="0" data-max="8" data-value="7" data-step="1" ></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <div class="range-slider-wrapper">
                                            <span class="slider-heading">Duration (Month)</span>
                                            <div id="slider-price" class="slider" data-min="10" data-max="100" data-value="100" data-step="10"></div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <div class="range-slider-wrapper">
                                            <span class="slider-heading">Day of SIP</span>
                                            <div id="slider-bedrooms" class="slider" data-min="0" data-max="8" data-value="7" data-step="1"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <div class="cal_form_select">
                                            <label class="mb-3" for="">Select Fund</label>
                                            <select class="form-text"  v-model="selectedFund"  @change="sipCalculations" :disabled="process">
                                                <option value="">Select Fund</option>
                                                <option v-for="fund in funds" :value="fund">{{fund.fund_name}}</option>
                                            </select> 
                                        </div>
                                    </div>

                                </div>
                                <div class="d-sm-flex d-block sip_calc_input mt-3">
                                    <div class="cal_form_select">
                                        <label for="">Return Rate (%)</label>
                                        <input class="form-text" type="number" />
                                    </div>
                                    <div class="cal_form_select">
                                        <label for="">Your Investments (Rs.)</label>
                                        <input class="form-text" type="number" />
                                    </div>
                                    <div class="cal_form_select">
                                        <label for="">Your Current Value (Rs.)</label>
                                        <input class="form-text" type="number" />
                                    </div>
                                    <div class="cal_form_select">
                                        <label for="">Your Current Value (Rs.)</label>
                                        <input class="form-text" type="number" />
                                    </div>
                                    <div class="cal_form_select mr-0">
                                        <label for="">Your Current Value (Rs.)</label>
                                        <input class="form-text" type="number" />
                                    </div>
                                </div>
                            </div>
                        </div>
<div class="invst-wrap invst-sip-performace">
    <h3>SIP Performance Calculator</h3>

    <div class="row invst-fields invst-field-1">
        <div class="col-lg-2 col-md-2 col-sm-12 invst-field-1-c invst-field-1-c1">
            <label>SIP Amount (Rs.)</label>
            <input @change="sipCalculations" type="number" :disabled="process"  id="sip_amount" v-model="sip_amount" placeholder="10000" min="0" />
        </div>
        <div class="col-lg-6 col-md-4 col-sm-12 invst-field-1-c invst-field-1-c2">
            <label>Select Fund</label>
            <multiselect
                :disabled="process" 
                class="js-example-placeholder-single js-states"
                label="fund_name" 
                track-by="fund_id"
                v-model="selectedFund" 
                tag-placeholder="" 
                placeholder="Select Fund" 
                :options="funds" 
                :multiple="false" 
                :taggable="false" 
                selectLabel=""
                :searchable="true"
                :block-keys="['Tab', 'Enter', 'backspace']"
                :max-height="150"
                :showNoResults="true"
                >
                </multiselect>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-12 invst-field-1-c invst-field-1-c3">
            <label>Duration (month)</label>
            <input type="number" @change="sipCalculations" :disabled="process" v-model="duration_months" id="duration-val" placeholder="12" min="0" />
        </div>
        <div class="col-lg-2 col-md-2 col-sm-12 invst-field-1-c invst-field-1-c4">
            <label>Day of SIP</label>
            <select @change="sipCalculations" :disabled="process" v-model="sip_day" id="sip_day" class="js-example-placeholder-single js-states form-control">
                <option disabled value="">Select</option>
                <option :value="index" v-for="index in 31" :key="index">{{index}}</option>
            </select>
        </div>
    </div>
    <div class="w-100 text-center mt-5" v-if="process">
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
    <div class="row invst-fields invst-field-2" v-if="Object.keys(sipCalculatedData).length">
        <div class="col-custom col invst-field-2-c invst-field-2-c1">
            <label>Return Rate (%)</label>
            <input type="number" id="return-rate" placeholder="" min="0" readonly :value="sipCalculatedData.sip_return" />
        </div>
        <div class="col-custom col invst-field-2-c invst-field-2-c2">
            <label>Your Investment (Rs.)</label>
            <input type="number" id="your-investment" placeholder="" min="0" readonly :value="sipCalculatedData.invested_amount" />
        </div>
        <div class="col-custom col invst-field-2-c invst-field-2-c3">
            <label>Your Current Value (Rs.)</label>
            <input type="number" id="current-value" placeholder="" min="0" readonly :value="sipCalculatedData.current_value" />
        </div>
        <div class="col-custom col invst-field-2-c invst-field-2-c4">
            <label>Current NAV (Rs.)</label>
            <input type="number" id="current-nav" placeholder="" min="0" readonly :value="sipCalculatedData.current_nav" />
        </div>
        <div class="col-custom col invst-field-2-c invst-field-2-c5">
            <label>Total Unit</label>
            <input type="number" id="current-nav" placeholder="" min="0" readonly :value="sipCalculatedData.total_unit" />
        </div>
    </div>

    <div class="invst-fields-graph" >
        <!-- <img src="../images/graph-image.jpg" alt="graph" class="img-fluid"> -->
        <p v-if="emailMsg" class="text-success mt-3 mb-3 w-100 text-right">{{ emailMsg }}</p>
        <div class="row mt-5">
            <div id="screen_capture" class="mt-3 w-100">
            <div class="col-md-12">
                <div class="graph_div" ref="printMe">
                    <div id="chartContainerSIP" style="width: 100%;" :class="{'height_370':showchart}"></div>
                    <div v-show="showchart"  style="height:30px; width:70px; background:#fff; position:absolute; z-index:999;bottom: 0;"  id="myplexusC"></div> 
                </div>
            </div>
            </div>
        </div>
        <div class="invst-fields-action-buttons" v-if="Object.keys(sipCalculatedData).length">
            <div class="row m-0 justify-content-end">
                <div class="action-common action-btn-1">
                    <button id="show-table" class="btn btn-green" @click="showTable = true">Show In Table</button>
                </div>
                <div class="action-common action-btn-2">
                    <button id="send-email" class="btn btn-green" :disabled="processEmail" @click="send_graph_result">Send Results In Email</button>
                </div>
            </div>
        </div>
    </div>
    

    <!-- SIP CALCULATOR GRAPH DIV START -->

    <div id="sip-performance-calc-data" class="sip-performance-calc-table" v-show="showTable" v-if="Object.keys(sipCalculatedData).length">
        <div class="container">
            <div class="sip-p-table-inner full-table-style">
                <table id="sip_calc_table" class="display box-shadow br-5 w-100">
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

    <!-- SIP CALCULATOR GRAPH DIV END -->


</div>
</template>
<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>
<script>
import moment from 'moment';
import Multiselect from '@suadelabs/vue3-multiselect'
import mixin from '../../mixin';
var CanvasJS = require('../../canvasjs.min.js');
import { mapGetters, mapActions } from 'vuex'
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
        Multiselect
  },
  mixins: [mixin],
   data() {
            return {
                name:this.username,
                email:this.useremail,
                process:false,
                showchart:false,
                chart:null,
                emailMsg:'',
                searchTimeout: null,
                output:null,
                selectedFund:[],
                sip_amount:'',
                duration_months:'',
                sip_day:'',
                sipCalculatedData:[],
                showTable:false,
                processEmail:false,
                app_url:process.env.MIX_APP_ENV=='local' ?  process.env.MIX_API_URL_LOCAL :'',
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
    get_sip_graph(){
		var graph_data = this.sipCalculatedData.graph_table_data;
		this.showchart = true
		var dataPoints1 = [];
		var dataPoints2 = [];
		var i = 0;
		for(i=0;i<graph_data.length;i++){
			dataPoints1.push({label: graph_data[i][0], y: parseInt(graph_data[i][1])})
			dataPoints2.push({label: graph_data[i][0], y: parseInt(graph_data[i][2])})
		}
		let chart = {
        height: 370,
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title:{
			text: "Inflation Calculator Chart"
		},
		axisY: {
			title: "Amount In INR"
		},
        legend: {
            cursor:"pointer",
            itemclick : this.toggleDataSeries
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
            color:'#6ab130',
			dataPoints: dataPoints1,
			},
            {        
			type: "line",  
			showInLegend: true, 
			legendMarkerColor: "#000",
			name: "Unit Value",
            yValueFormatString: "##.00",
            color:'#000',
			dataPoints: dataPoints2,
			}
            ]
		}
        this.chart = new CanvasJS.Chart("chartContainerSIP", chart);
        this.chart.render();
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
    async send_graph_result(){

        if(this.showchart){
            const el = this.$refs.printMe;
            const options = {
                type: 'dataURL'
            }
            this.output = await this.$html2canvas(el, options);
        }
        this.processEmail = true
        let data = {
            name:this.name,
            email:'sandeep@gmail.com',
            output:this.output,
            fund_code:this.selectedFund.fund_code,
            fund_name:this.selectedFund.fund_name,
            sip_amount:this.sip_amount,
            duration_months:this.duration_months,
            sip_day:this.sip_day,
            sip_return:this.sipCalculatedData.sip_return,
            invested_amount:this.sipCalculatedData.invested_amount,
            current_value:this.sipCalculatedData.current_value,
            current_nav:this.sipCalculatedData.current_nav,
            total_unit:this.sipCalculatedData.total_unit,
        };
        axios.post(this.app_url+'/api/v1/send-sip-calculator-email',data)
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
    sipCalculations(){
        // console.log(document.querySelector(".value").getAttribute('data-selected-value'));
        if(this.sip_amount && this.selectedFund && this.duration_months && this.sip_day){
            let data = {
            name:this.name,
            email:'sandeep@gmail.com',
            fund_code:this.selectedFund.fund_code,
            sip_amount:this.sip_amount,
            duration_months:this.duration_months,
            sip_day:this.sip_day,
            output:this.output,
        };
        this.process = true
        this.sipCalculatedData = []
        axios.post(this.app_url+'/api/v1/sip-performance-calculator',data)
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
    calculate_sip(dates,values){
       let that = this
        var x = that.XIRR(values, dates, 0.1);
        return this.isNumeric(x)?(x*100).toFixed(2):x;
    },
    XIRR(values, dates, guess) {
        
        // Credits: algorithm inspired by Apache OpenOffice
        
        // Calculates the resulting amount
        var irrResult = function(values, dates, rate) {
            var r = rate + 1;
            var result = values[0];
            for (var i = 1; i < values.length; i++) {
            result += values[i] / Math.pow(r, moment(dates[i]).diff(moment(dates[0]), 'days') / 365);
            
            }
            return result;
        }

        // Calculates the first derivation
        var irrResultDeriv = function(values, dates, rate) {
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
        } while(contLoop && (++iteration < iterMax));
        if(contLoop) return '#NUM!';
        // Return internal rate of return
        return resultRate;
    },
  },
  watch: {
      selectedFund(value){
          if(value){
              this.sipCalculations()
          }
      }
},
  computed: {
    ...mapGetters('InputData', ['loading','funds']),
    
  },
  mounted() {
    this.getFunds({})
    
  },
}
</script>
<style>

</style>
