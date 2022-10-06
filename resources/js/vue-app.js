require('./bootstrap');

import { createApp } from 'vue'
import store from './store'
import KnowYourScheme from './components/KnowYourScheme.vue'
import FundPortfolio from './components/FundPortfolio.vue'
import FundCompositionSnapshot from './components/FundCompositionSnapshot.vue'
import WeeklySnapshot from './components/WeeklySnapshot.vue'
import MonthlySnapshot from './components/MonthlySnapshot.vue'
import MonthlyRanking from './components/MonthlyRanking.vue'
import FundPerformance from './components/FundPerformance.vue'
import CompareScheme from './components/CompareScheme.vue'
import PerformanceSnapshot from './components/PerformanceSnapshot.vue'
import Calculators from './components/Calculators.vue'
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

app.component('know-your-scheme', KnowYourScheme)
app.component('fund-portfolio', FundPortfolio)
app.component('mutual-fund-lib', MutualFundDirectory)
app.component('fund-composition-snapshot', FundCompositionSnapshot)
app.component('weekly-snapshot', WeeklySnapshot)
app.component('monthly-snapshot', MonthlySnapshot)
app.component('monthly-ranking', MonthlyRanking)
app.component('fund-performance', FundPerformance)
app.component('compare-scheme', CompareScheme)
app.component('performance-snapshot', PerformanceSnapshot)
app.component('calculators', Calculators)
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