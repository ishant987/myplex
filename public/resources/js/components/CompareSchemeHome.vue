<template>
<div class="container">
    <ul class="nav nav-tabs justify-content-center border-0">
        <li><a class="" data-toggle="tab" href="#daily-price" :class="{'active show':currentTab == 'daily_price'}" @click="currentTab='daily_price'">Daily Price</a></li>
        <li><a data-toggle="tab" href="#fund-perform-ratios" :class="{'active show':currentTab == 'ratios'}" @click="currentTab='ratios'">Ratios</a></li>
        <li><a data-toggle="tab" href="#composition" :class="{'active show':currentTab == 'composition'}" @click="currentTab='composition'">Composition</a></li>
    </ul>
</div>
<div class="tab-wrapper">
    <div class="container">
        <div class="tab-content">
            <div id="daily-price-home" class="tab-pane fade" :class="{'active show':currentTab == 'daily_price'}">
                <div class="row cs-select2 m-0">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="cs-select2-grp">
                            <div class="cs-select2-group">
                                <div class="cs-radio-grp">
                                    <div class="row m-0">
                                        <div class="col-lg-4 col-md-4 col-sm-12 pr-0 mb-2" v-for="compare_type in compare_price_types" :key="compare_type.type">
                                            <input class="form-check-input" type="radio" name="compare_price_btn"
                                                :id="compare_type.type+'-home'" :value="compare_type.type" v-model="selectedComparePriceType">
                                            <label class="form-check-label" :for="compare_type.type+'-home'">{{ compare_type.title }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invst-wrap select2-styles">
                                    <div class="invst-fields mt-0" v-if="selectedComparePriceType == 'scheme_scheme' || selectedComparePriceType == 'scheme_index' || selectedComparePriceType == 'scheme_currency'">
                                        <label class="select2-label">Schemes</label>
                                        <multiselect
                                        class=""
                                        label="fund_name" 
                                        track-by="fund_id"
                                        v-model="selectedScheme1" 
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
                                    <div class="invst-fields mt-0" v-if="selectedComparePriceType == 'index_index' || selectedComparePriceType == 'index_currency'">
                                        <label class="select2-label">Index</label>
                                        <multiselect
                                        class=""
                                        label="name" 
                                        track-by="name"
                                        v-model="selectedIndex1" 
                                        tag-placeholder="" 
                                        placeholder="Select Index" 
                                        :options="indices" 
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
                                    <div class="invst-fields mt-0" v-if="selectedComparePriceType == 'currency_currency'">
                                        <label class="select2-label">Currency</label>
                                        <multiselect
                                        class=""
                                        label="name" 
                                        track-by="name"
                                        v-model="selectedCurrency1" 
                                        tag-placeholder="" 
                                        placeholder="Select Currency" 
                                        :options="currencies" 
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
                                </div>
                                <div class="invst-wrap select2-styles" >
                                    <div class="invst-fields mt-0" v-if="selectedComparePriceType == 'scheme_scheme'">
                                        <label class="select2-label">Schemes</label>
                                        <multiselect
                                        class=""
                                        label="fund_name" 
                                        track-by="fund_id"
                                        v-model="selectedScheme2" 
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
                                    <div class="invst-fields mt-0" v-if="selectedComparePriceType == 'index_index' || selectedComparePriceType == 'scheme_index'">
                                        <label class="select2-label">Index</label>
                                        <multiselect
                                        class=""
                                        label="name" 
                                        track-by="name"
                                        v-model="selectedIndex2" 
                                        tag-placeholder="" 
                                        placeholder="Select Index" 
                                        :options="indices" 
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
                                    <div class="invst-fields mt-0" v-if="selectedComparePriceType == 'currency_currency' || selectedComparePriceType == 'index_currency' || selectedComparePriceType == 'scheme_currency'">
                                        <label class="select2-label">Currency</label>
                                        <multiselect
                                        class=""
                                        label="name" 
                                        track-by="name"
                                        v-model="selectedCurrency2" 
                                        tag-placeholder="" 
                                        placeholder="Select Currency" 
                                        :options="currencies" 
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="ratio-home" class="tab-pane fade in" :class="{'active show':currentTab == 'ratios'}">
                <div class="row cs-select2 m-0">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="cs-select2-grp">
                            <div class="cs-select2-group invst-wrap select2-styles">
                                <div class="invst-fields mt-0">
                                    <label class="select2-label">Scheme name</label>
                                    <multiselect
                                    class=""
                                    label="fund_name" 
                                    track-by="fund_id"
                                    v-model="selectedFund1Ratio" 
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
                            </div>
                            <div class="cs-select2-group invst-wrap select2-styles">
                                <div class="invst-fields mt-0">
                                    <label class="select2-label">Scheme name</label>
                                    <multiselect
                                    class=""
                                    label="fund_name" 
                                    track-by="fund_id"
                                    v-model="selectedFund2Ratio" 
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
                            </div>
                            <div class="cs-select2-group invst-wrap select2-styles">
                                <div class="invst-fields mt-0">
                                <label class="select2-label">Return Ratio</label>
                                <select class="custom-input" v-model="selectedRatioReturn" :disabled="selectedRatioRisk !== ''">
                                    <option value="">Select</option>
                                    <option value="cagr">Returns</option>
                                    <option value="jensen_alpha">Jensen</option>
                                    <option value="information_ratio">Information Ratio</option>
                                    <option value="rolling_return">Rolling Return</option>
                                </select>
                                </div>
                            </div>
                            <div class="cs-select2-group invst-wrap select2-styles">
                                <div class="invst-fields mt-0">
                                <label class="select2-label">Risk Ratio</label>
                                <select class="custom-input" v-model="selectedRatioRisk" :disabled="selectedRatioReturn !== ''">
                                    <option value="">Select</option>
                                    <option value="beta">Beta</option>
                                    <option value="tracking_error">Tracking Error</option>
                                    <option value="volatality">Volatility</option>
                                </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="composition-home" class="tab-pane fade" :class="{'active show':currentTab == 'composition'}">
                <div class="row cs-select2 m-0">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="cs-select2-grp">
                            <div class="cs-select2-group invst-wrap select2-styles">
                                <div class="invst-fields mt-0">
                                    <label class="select2-label">Scheme name</label>
                                    <multiselect
                                    class=""
                                    label="fund_name" 
                                    track-by="fund_id"
                                    v-model="selectedFund1Composition" 
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
                            </div>
                            <div class="cs-select2-group invst-wrap select2-styles">
                                <div class="invst-fields mt-0">
                                    <label class="select2-label">Scheme name</label>
                                    <multiselect
                                    class=""
                                    label="fund_name" 
                                    track-by="fund_id"
                                    v-model="selectedFund2Composition" 
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
                            </div>
                            <div class="cs-select2-group invst-wrap select2-styles">
                                <div class="invst-fields mt-0">
                                <label class="select2-label">Category</label>
                                <select class="custom-input" v-model="selectedCompositionCategory">
                                    <option value="">Select</option>
                                    <option value="top_script">Top Scrip</option>
                                    <option value="top_industry">Top Industry</option>
                                    <option value="aaum">AAUM</option> 
                                </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CALCULATOR TABS -->
</template>
<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>
<script>
import Multiselect from '@suadelabs/vue3-multiselect'
import mixin from '../mixin';
import { mapGetters, mapActions } from 'vuex'
export default {
    props: {
        
    },
    components: {
      Multiselect,
  },
  mixins: [mixin],
   data() {
        return {
            compare_price_types: [
                {type:'scheme_scheme',title:'Scheme to scheme'},
                {type:'scheme_index',title:'Scheme to index'},
                {type:'scheme_currency',title:'Scheme to currency'},
                {type:'index_index',title:'Index to index'},
                {type:'index_currency',title:'Index to currency'},
                {type:'currency_currency',title:'Currency to currency'},
            ],
            selectedComparePriceType: 'scheme_scheme',
            selectedScheme1:null,
            selectedScheme2:null,
            selectedIndex1:null,
            selectedIndex2:null,
            selectedCurrency1:null,
            selectedCurrency2:null,
            selectedFund1Ratio:null,
            selectedFund2Ratio:null,
            selectedRatioReturn:'',
            selectedRatioRisk:'',
            selectedFund1Composition:null,
            selectedFund2Composition:null,
            selectedCompositionCategory:'',
            currentTab:'daily_price',
        }
  },
  methods: {
   ...mapActions('InputData', ['getFunds','getIndices','getCurrencies']),
   triggerComparePrice(){
        if((this.selectedComparePriceType == 'scheme_scheme' || this.selectedComparePriceType == 'scheme_index' || this.selectedComparePriceType == 'scheme_currency') && this.selectedScheme1 === null){
            return true
        }else if((this.selectedComparePriceType == 'scheme_scheme') && this.selectedScheme2 === null){
           return true
        }else if((this.selectedComparePriceType == 'index_index' || this.selectedComparePriceType == 'index_currency') && this.selectedIndex1  === null){
            return true
        }else if((this.selectedComparePriceType == 'index_index' || this.selectedComparePriceType == 'scheme_index') && this.selectedIndex2  === null){
            return true
        }else if((this.selectedComparePriceType == 'currency_currency') && this.selectedCurrency1  === null){
            return true
        }else if((this.selectedComparePriceType == 'currency_currency' || this.selectedComparePriceType == 'index_currency' || this.selectedComparePriceType == 'scheme_currency') && this.selectedCurrency2  === null){
            return true
        }
        var value1 = ''
        var value2 = ''
        if((this.selectedComparePriceType == 'scheme_scheme' || this.selectedComparePriceType == 'scheme_index' || this.selectedComparePriceType == 'scheme_currency')){
            value1 =  encodeURIComponent(this.selectedScheme1.fund_code)
        }
        if((this.selectedComparePriceType == 'scheme_scheme')){
            value2 =  encodeURIComponent(this.selectedScheme2.fund_code)
        }
        if((this.selectedComparePriceType == 'index_index' || this.selectedComparePriceType == 'index_currency')){
            value1 =  encodeURIComponent(this.selectedIndex1.name)
        }
        if((this.selectedComparePriceType == 'index_index' || this.selectedComparePriceType == 'scheme_index')){
            value2 =  encodeURIComponent(this.selectedIndex2.name)
        }
        if((this.selectedComparePriceType == 'currency_currency')){
            value1 =  encodeURIComponent(this.selectedCurrency1.cm_id)
        }
        if((this.selectedComparePriceType == 'currency_currency' || this.selectedComparePriceType == 'index_currency' || this.selectedComparePriceType == 'scheme_currency')){
           value2 =  encodeURIComponent(this.selectedCurrency2.cm_id)
        }
        window.location.href = 'compare-scheme?compare_price_type='+this.selectedComparePriceType+'&val1='+value1+'&val2='+value2
        //return false

    },
    triggerCompareRatio(){
        if (this.selectedFund1Ratio  === null || this.selectedFund2Ratio  === null) {
            return true
        }else if(!this.selectedRatioReturn && !this.selectedRatioRisk){
            return true
        }
        let type = (this.selectedRatioRisk)?this.selectedRatioRisk:this.selectedRatioReturn
        window.location.href = 'compare-scheme?compare_ratio_type='+type+'&val1='+encodeURIComponent(this.selectedFund1Ratio.fund_code)+'&val2='+encodeURIComponent(this.selectedFund2Ratio.fund_code)
        //return false
        
    },
    triggerCompareComposition(){
        if (this.selectedFund1Composition  === null || this.selectedFund2Composition  === null) {
            return true
        }else if(!this.selectedCompositionCategory){
            return true
        }
        window.location.href = 'compare-scheme?compare_composition_type='+this.selectedCompositionCategory+'&val1='+encodeURIComponent(this.selectedFund1Composition.fund_code)+'&val2='+encodeURIComponent(this.selectedFund2Composition.fund_code)
        //return false
    }
  },
  watch: {
      selectedScheme1(value){
          if(value){
              this.triggerComparePrice()
          }
      },
    selectedScheme2(value){
          if(value){
              this.triggerComparePrice()
          }
      },
    selectedIndex1(value){
          if(value){
              this.triggerComparePrice()
          }
      },
    selectedIndex2(value){
          if(value){
              this.triggerComparePrice()
          }
      },
    selectedCurrency1(value){
          if(value){
              this.triggerComparePrice()
          }
      },
    selectedCurrency2(value){
          if(value){
              this.triggerComparePrice()
          }
      },
    selectedFund1Ratio(value){
          if(value){
              this.triggerCompareRatio()
          }
      },
    selectedFund2Ratio(value){
          if(value){
              this.triggerCompareRatio()
          }
      },
    selectedRatioReturn(value){
          if(value){
              this.triggerCompareRatio()
          }
      },
    selectedRatioRisk(value){
          if(value){
              this.triggerCompareRatio()
          }
      },
      selectedFund1Composition(value){
          if(value){
              this.triggerCompareComposition()
          }
      },
      selectedFund2Composition(value){
          if(value){
              this.triggerCompareComposition()
          }
      },
      selectedCompositionCategory(value){
          if(value){
              this.triggerCompareComposition()
          }
      },
    },
  computed: {
    ...mapGetters('InputData', ['loading','funds','indices','currencies']),
  },
  mounted() {
    let that = this
    that.getFunds({})
    that.getIndices({})
    that.getCurrencies({})
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
label.select2-label {
    margin-top: 20px;
    margin-bottom: 5px;
}
.compare-scemes-sec .cs-radio-grp input {
    margin: 2px 0 0 0;
}
.multiselect__select {
    width: 25px;
}
.multiselect__select:before {
    width: 10px;
    height: 10px;
    background-size: 100%;
}
.multiselect__content-wrapper {
    width: 100%;
}
</style>
