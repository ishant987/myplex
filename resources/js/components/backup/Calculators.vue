<template>
    <div class="calculator-select-calc-popup" v-if="currentTab == ''">
        <div class="select-calc-popup-wrap">
            <h6>Please select calculator</h6>
            <div class="select-calc-choose select2-styles">
                <form action="#" method="post">
                    <select id="select-calcy" v-model="currentTab" class="js-example-placeholder-single js-states form-control">
                        <option value="" selected="" disabled="">Nothing Selected</option>
                        <option value="sip-planner">Sip Planner</option>
                        <option value="sip-p-calc">SIP Performance Calculator</option>
                        <option value="inf-calc">Inflation Calculator</option> 
                        <option value="retire-calc">Retirement Calculator</option>   
                        <option value="risk-tol-eval">Risk Tolerance Evaluator</option>   
                           
                    </select>
                </form>
            </div>
        </div>
    </div>
    
    <!-- CALCULATOR TABS -->

    <div class="compare-scemes-sec investing-tools select2-styles" v-if="currentTab != ''">
        <div class="container">
            <div class="compare-block">
                <!-- <h4>Calculators</h4> -->
            </div>

            <ul class="nav nav-tabs justify-content-center border-0 mt-5">
                <li><a :class="{'active show':currentTab == 'sip-planner'}" @click="currentTab = 'sip-planner'" class="" data-toggle="tab" href="#sip-planner">SIP Planner</a></li>
                <li><a :class="{'active show':currentTab == 'sip-p-calc'}" @click="currentTab = 'sip-p-calc'" data-toggle="tab" href="#sip-p-calc">SIP Performance Calculator</a></li>
                <li><a :class="{'active show':currentTab == 'inf-calc'}" @click="currentTab = 'inf-calc'" data-toggle="tab" href="#inf-calc">Inflation Calculator</a></li>
                <li><a :class="{'active show':currentTab == 'retire-calc'}" @click="currentTab = 'retire-calc'" data-toggle="tab" href="#retire-calc">Retirement Calculator</a></li>
                <li><a :class="{'active show':currentTab == 'risk-tol-eval'}" @click="currentTab = 'risk-tol-eval'" data-toggle="tab" href="#risk-tol-eval">Risk Tolerance Evaluator</a></li>
            </ul>
        </div>
        <div class="tab-wrapper">
            <div class="container">
                <div class="tab-content">

                    <!-- SIP PLANNER CALCULATOR TAB START -->

                    <div id="sip-planner" class="tab-pane fade in" :class="{'active show':currentTab == 'sip-planner'}">
                        <SipPlanner :useremail="useremail" :username="username" :sip_faqs="sip_faqs" :sip_pdf_url="sip_pdf_url"></SipPlanner>
                    </div>

                    <!-- SIP PLANNER CALCULATOR TAB END -->

                    <!-- SIP CALCULATOR TAB START -->

                    <div id="sip-p-calc" class="tab-pane fade" :class="{'active show':currentTab == 'sip-p-calc'}">
                        <SIPPerformanceCalculator :useremail="useremail" :username="username"></SIPPerformanceCalculator>
                    </div>

                    <!-- SIP CALCULATOR TAB END -->

                    <!-- INFLATION CALCULATOR TAB START -->

                    <div id="inf-calc" class="tab-pane fade" :class="{'active show':currentTab == 'inf-calc'}">
                        <InflationCalculator :useremail="useremail" :username="username"></InflationCalculator>
                    </div>

                    <!-- INFLATION CALCULATOR TAB END -->

                    <!-- RETIREMENT CALCULATOR TAB START -->

                    <div id="retire-calc" class="tab-pane fade" :class="{'active show':currentTab == 'retire-calc'}">
                        <RetirementCalulator :useremail="useremail" :username="username"></RetirementCalulator>
                    </div>

                    <!-- RETIREMENT CALCULATOR TAB END -->

                    <!-- RISK TOLERANCE CALCULATOR TAB START -->

                    <div id="risk-tol-eval" class="tab-pane fade" :class="{'active show':currentTab == 'risk-tol-eval'}">
                        <RiskToleranceEvaluator :useremail="useremail" :username="username"></RiskToleranceEvaluator>
                    </div>

                    <!-- RISK TOLERANCE CALCULATOR TAB END -->

                </div>
            </div>
        </div>
    </div>
</template>
<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>
<script>
import SipPlanner from './SIP/SipPlanner.vue'
import RiskToleranceEvaluator from './SIP/RiskToleranceEvaluator.vue'
import InflationCalculator from './SIP/InflationCalculator.vue'
import RetirementCalulator from './SIP/RetirementCalulator.vue'
import SIPPerformanceCalculator from './SIP/SIPPerformanceCalculator.vue'
import Multiselect from '@suadelabs/vue3-multiselect'
import mixin from '../mixin';
import { mapGetters, mapActions } from 'vuex'
import moment from 'moment';
var CanvasJS = require('../canvasjs.min.js');
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
    components: {
      SipPlanner,
      RiskToleranceEvaluator,
      InflationCalculator,
      RetirementCalulator,
      SIPPerformanceCalculator
  },
  mixins: [mixin],
   data() {
        return {
            currentTab:''
        }
  },
  methods: {
   ...mapActions('InputData', ['getFunds','getIndices','getCurrencies']),
   
  },
  watch: {
      
 },
  computed: {
    ...mapGetters('InputData', ['loading','funds','indices','currencies']),
    
  },
  mounted() {
    let that = this
    let tab = that.getURLParams("tab")
    if(tab && (tab == 'sip-planner' || tab == 'sip-p-calc' || tab == 'inf-calc' || tab == 'retire-calc' || tab == 'risk-tol-eval')){
        this.currentTab = tab
    }
  },
}
</script>
<style>
.dp__theme_light {
    --dp-primary-color: #6ab130 !important;
    --dp-primary-disabled-color: #458e38 !important;
}
.multiselect__content-wrapper {
    width: auto;
}
.dp__input_icon_pad {
    padding-left: 35px !important;
}
.compare-btn{
    padding-top:12px;
    padding-bottom:12px;
    margin-bottom: 12px;
}
input.invst-field-1-c::-webkit-input-placeholder {
    /* WebKit, Blink, Edge */
    color: #c2d1cf;
}

input.invst-field-1-c:-moz-placeholder {
    /* Mozilla Firefox 4 to 18 */
    color: #c2d1cf;
    opacity: 1;
}

input.invst-field-1-c::-moz-placeholder {
    /* Mozilla Firefox 19+ */
    color: #c2d1cf;
    opacity: 1;
}

input.invst-field-1-c:-ms-input-placeholder {
    /* Internet Explorer 10-11 */
    color: #c2d1cf;
}

input.invst-field-1-c::-ms-input-placeholder {
    /* Microsoft Edge */
    color: #c2d1cf;
}

input.invst-field-1-c::placeholder {
    /* Most modern browsers support this now. */
    color: #c2d1cf;
}
</style>