require('./bootstrap');

import { createApp } from 'vue'
import store from './store'
import babelPolyfill from 'babel-polyfill'
import KnowYourScheme from './components/KnowYourScheme.vue'
import FundPortfolio from './components/FundPortfolio.vue'
import FundCompositionSnapshot from './components/FundCompositionSnapshot.vue'
import WeeklySnapshot from './components/WeeklySnapshot.vue'
import UserWeeklySnapshot from './components/UserWeeklySnapshot.vue'
import MonthlySnapshot from './components/MonthlySnapshot.vue'
import UserMonthlySnapshot from './components/UserMonthlySnapshot.vue'
import MonthlyRanking from './components/MonthlyRanking.vue'
import FundPerformance from './components/FundPerformance.vue'
import PerformanceSynopsis from './components/PerformanceSynopsis.vue' 
import CompareScheme from './components/CompareScheme.vue'
import PerformanceSnapshot from './components/PerformanceSnapshot.vue'
import UserPerformanceSnapshot from './components/UserPerformanceSnapshot.vue'
import CorpusDetails from './components/CorpusDetails.vue'
import InflationCalculator from './components/SIP/InflationCalculator.vue'
import RetirementCalulator from './components/SIP/RetirementCalulator.vue'
import RiskCalulator from './components/SIP/RiskToleranceEvaluator.vue'
import Calculators from './components/Calculators.vue'
import objective_calualtor from './components/other_objective_calulator.vue'
import CompareSchemeHome from './components/CompareSchemeHome.vue'
import SelectionsHome from './components/SelectionsHome.vue'
import MutualFundDirectory from './components/MutualFundDirectory.vue'
import VueHtml2Canvas from 'vue-html2canvas';
//global.jQuery = require('jquery');
//var $ = global.jQuery;
//window.$ = $;
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const app = createApp({ })
// const cors = require('cors');
// app.use(cors({
//     origin:  "*"
// }));

app.component('know-your-scheme', KnowYourScheme)
app.component('fund-portfolio', FundPortfolio)
app.component('mutual-fund-lib', MutualFundDirectory)
app.component('fund-composition-snapshot', FundCompositionSnapshot)
app.component('weekly-snapshot', WeeklySnapshot)
app.component('user-weekly-snapshot', UserWeeklySnapshot)
app.component('monthly-snapshot', MonthlySnapshot)
app.component('user-monthly-snapshot', UserMonthlySnapshot)
app.component('monthly-ranking', MonthlyRanking)
app.component('fund-performance', FundPerformance)
app.component('corpus-details', CorpusDetails)
app.component('compare-scheme', CompareScheme)
app.component('performance-snapshot', PerformanceSnapshot)
app.component('user-performance-snapshot', UserPerformanceSnapshot)
app.component('calculators', Calculators)
app.component('objective_calualtor', objective_calualtor)
app.component('inflation-calculator', InflationCalculator)
app.component('retirement-calculator', RetirementCalulator)
app.component('risk-evaluation-calculator', RiskCalulator)
app.component('performance-synopsis', PerformanceSynopsis)
//app.component('compare-scheme-home', CompareSchemeHome)
app.use(store)
app.use(VueHtml2Canvas)
app.component('Datepicker', Datepicker);
app.mount('#vue-app')



const appCompareScheme = createApp({})
appCompareScheme.component('compare-scheme-home', CompareSchemeHome)
appCompareScheme.use(store)
appCompareScheme.component('Datepicker', Datepicker);
appCompareScheme.mount('#vue-app-compare-scheme-home')

const appselectionshome = createApp({})
appselectionshome.component('selections-home', SelectionsHome)
appselectionshome.use(store)
appselectionshome.component('Datepicker', Datepicker);
appselectionshome.mount('#vue-app-selections-home')