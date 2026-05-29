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

<section class="compare_scheme" v-if="currentTab != ''">
    <div class="container">
        <div class="tab_snap_shot">
            <ul class="nav nav-pills filter_tab mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link" :class="{'active show':currentTab == 'sip-p-calc'}" @click="currentTab = 'sip-p-calc'" id="pills-monthly-tab1" data-bs-toggle="pill" data-bs-target="#pills-monthly1" type="button" role="tab" aria-controls="pills-monthly1" aria-selected="false">
                        <img :src="image_path+`/tab_icon_cal1.png`" /> SIP Planner
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link " :class="{'active show':currentTab == 'sip-planner'}" @click="currentTab = 'sip-planner'" id="pills-weekly-tab1" data-bs-toggle="pill" data-bs-target="#pills-weekly1" type="button" role="tab" aria-controls="pills-weekly1" aria-selected="false">
                        <img :src="image_path+`/tab_icon_cal.png`" /> Lumpsum Fund Planner
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link " :class="{'active show':currentTab == 'retire-calc'}" @click="currentTab = 'retire-calc'" id="pills-monthly-tab3" data-bs-toggle="pill" data-bs-target="#pills-monthly3" type="button" role="tab" aria-controls="pills-monthly3" aria-selected="true">
                        <img :src="image_path+`/tab_icon_cal3.png`" /> Retirement Planner
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" :class="{'active show':currentTab == 'risk-tol-eval'}" @click="currentTab = 'risk-tol-eval'" id="pills-monthly-tab4" data-bs-toggle="pill" data-bs-target="#pills-monthly4" type="button" role="tab" aria-controls="pills-monthly4" aria-selected="false">
                        <img :src="image_path+`/tab_icon_cal4.png`" /> Risk Tolerance Evaluator
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" :class="{'active show':currentTab == 'inf-calc'}" @click="currentTab = 'inf-calc'" id="pills-monthly-tab2" data-bs-toggle="pill" data-bs-target="#pills-monthly2" type="button" role="tab" aria-controls="pills-monthly2" aria-selected="false">
                        <img :src="image_path+`/tab_icon_cal2.png`" /> Inflation Calculator
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <!-- SIP PLANNER CALCULATOR TAB START -->
                <div class="tab-pane fade " :class="{'active show':currentTab == 'sip-planner'}" id="pills-weekly1" role="tabpanel" aria-labelledby="pills-weekly-tab1">
                    <SipPlanner :useremail="useremail" :username="username" :sip_faqs="sip_faqs" :sip_pdf_url="sip_pdf_url"></SipPlanner>
                </div>
                <!-- SIP PLANNER CALCULATOR TAB END -->
                <!-- SIP CALCULATOR TAB START -->
                <div id="pills-monthly1" class="tab-pane fade "  role="tabpanel" aria-labelledby="pills-monthly-tab1" :class="{'active show':currentTab == 'sip-p-calc'}">
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
</section>
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
import {
    mapGetters,
    mapActions
} from 'vuex'
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
        image_path: {
            requires: true,
        }
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
            currentTab: 'sip-p-calc'
        }
    },
    methods: {
        ...mapActions('InputData', ['getFunds', 'getIndices', 'getCurrencies']),

    },
    watch: {

    },
    computed: {
        ...mapGetters('InputData', ['loading', 'funds', 'indices', 'currencies']),

    },
    mounted() {
        let that = this
        let tab = that.getURLParams("tab")
        if (tab && (tab == 'sip-planner' || tab == 'sip-p-calc' || tab == 'inf-calc' || tab == 'retire-calc' || tab == 'risk-tol-eval')) {
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
