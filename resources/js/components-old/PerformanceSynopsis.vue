<template>
    <section class="info_monitor_sec">
        <div class="compare-scemes-sec investing-tools perform-snapshot-tabs select2-styles">
            <div class="container">

              <div class="row mb-4">
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-4 index_changes_header">
                        <h4>Fund House Name</h4>
                        <multiselect class="" label="fund_house" track-by="fund_house" v-model="selectedFundHouse" tag-placeholder="" placeholder="Select Fund House" :options="fundHouses" :multiple="false" :taggable="false" selectLabel="" :searchable="true" :block-keys="['Tab', 'backspace']" :max-height="150" :showNoResults="true">
                        </multiselect>
                    </div>                    
                </div>

                <h4>{{ headingText }}</h4>

                <table class="table">
                  <thead>
                  <tr>
                    <th scope="col" rowspan="2">No. of Equity Schemes</th>
                    <th scope="col" rowspan="2">Fund House</th>
                    <th scope="col" colspan="4" class="text-center">Number of Schemes as per Quartile Ranks</th>
                  </tr>
                  <tr>                                      
                    <th scope="col" class="text-center">1</th>
                    <th scope="col" class="text-center">2</th>
                    <th scope="col" class="text-center">3</th>
                    <th scope="col" class="text-center">4</th>                    
                  </tr>
                </thead>

                  <tbody>
                      <template v-if="Object.keys(pSData).length">
                        <tr>
                          <td>{{ pSData.total_scheme }}</td>
                          <td>{{ pSData.fund_house }} </td>
                          <td class="text-center">{{ pSData.one }}</td>
                          <td class="text-center">{{ pSData.two }}</td>
                          <td class="text-center">{{ pSData.three }}</td>
                          <td class="text-center">{{ pSData.four }}</td>
                        </tr>
                      </template>

                      <tr v-else>
                        <td colspan="7" class="text-center"><h5>No Record Yet!!!</h5></td>
                      </tr>

                      <tr v-if="process">
                        <td colspan="10">
                          <div class="text-center mt-3">
                            <LoadingBar :status="process"></LoadingBar>
                          </div>
                        </td>
                      </tr>                  
                  </tbody>
                </table>


            </div>
            
        </div>
    </section>   
    </template>
    <style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>
    <script>
    import CustomTable from './Common/CustomTable.vue'
    import Multiselect from '@suadelabs/vue3-multiselect'
    import mixin from '../mixin';
    import LoadingBar from "./Common/loading";
    import { mapGetters, mapActions } from 'vuex'
    import moment from 'moment';
    export default {
        props: {
            page_title: {
            type: String,
            required: true,
            default: '',
            },
            page_description: {
            type: String,
            required: true,
            default: '',
            },
            page_image: {
            type: String,
            required: true,
            default: '',
            },
            banner_title: {
            type: String,
            required: true,
            default: '',
            },
        },
        components: {
          Multiselect,
          LoadingBar
      },
      mixins: [mixin],
       data() {
                return {
                    sortKey: 'fund_name',
                    ascending: true,
                    sortKeyM: 'fund_name',
                    ascendingM: true,
                    sortKeC: 'fund_name',
                    ascendingC: true,
                    pSData: [],
                    selectedFundHouse: '',
                    headingText: '',
                    process: false,
                    app_url: process.env.MIX_APP_ENV == 'local' ? process.env.MIX_API_URL_LOCAL : 'https://www.myplexus.com',                   
                }
      },
      methods: {
        ...mapActions('InputData', ['getFundHouses']),
        /* sortTableW(col) {
          if (this.sortKey === col) {
            this.ascending = !this.ascending;
          } else {
            this.ascending = true;
            this.sortKey = col;
          }
    
          var ascending = this.ascending;
    
          this.weekly_snapshot_data.sort(function(a, b) {
            if (a[col] > b[col]) {
              return ascending ? 1 : -1
            } else if (a[col] < b[col]) {
              return ascending ? -1 : 1
            }
            return 0;
          })
        },
        sortTableM(col) {
          if (this.sortKeyM === col) {
            this.ascendingM = !this.ascendingM;
          } else {
            this.ascendingM = true;
            this.sortKeyM = col;
          }
    
          var ascendingM = this.ascendingM;
    
          this.monthly_snapshot_data.sort(function(a, b) {
            if (a[col] > b[col]) {
              return ascendingM ? 1 : -1
            } else if (a[col] < b[col]) {
              return ascendingM ? -1 : 1
            }
            return 0;
          })
        },
        sortTableC(col) {
          if (this.sortKeyC === col) {
            this.ascendingC = !this.ascendingC;
          } else {
            this.ascendingC = true;
            this.sortKeyC = col;
          }
    
          var ascendingC = this.ascendingC;
    
          this.monthly_snapshot_data.sort(function(a, b) {
            if (a[col] > b[col]) {
              return ascendingC ? 1 : -1
            } else if (a[col] < b[col]) {
              return ascendingC ? -1 : 1
            }
            return 0;
          })
        }, */
       formattedDate(date){
           return moment(date).format('DD/MM/YYYY')
       },

       async getPerformanceSynopsis(value){
        let that = this
        that.process = true
        that.pSData = [];
        await axios.get('https://www.myplexus.com/api/v1/performance-synopsis', {
          params: {
                    fund_house: value
                }
        })
                .then(response => {
                    that.pSData = response.data.data.data[0]
                    that.headingText = `Quartile Returns Performance for Equity & Equity Linked Schemes from ${response.data.data.start_date} to ${response.data.data.last_date}`;
                    console.log(response);                   
                })               
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    //that.processWeekly = false
                    that.process = false;
                })           

       },       
      
      },      
      computed: {
            ...mapGetters('InputData', ['loading', 'fundHouses']),
        },

        watch: {
            selectedFundHouse(value) {
              if(value)
              {
                this.getPerformanceSynopsis(value.fund_house);
              }
            }
        },
      mounted() {
        let that = this
        /* that.getPerformanceSynopsis(); */ 
        
        const myPromise = new Promise(async (resolve, reject) => {
                await this.getFundHouses()
                resolve(true)
            });
    
            /* myPromise.then(async (resolve, reject) => {
                if (fund_house) {
                    that.selectedFundHouse = that.fundHouses.filter(function (el) {
                        return el.fund_house == fund_house
                    })[0]
                    await that.getFunds({
                        fund_house: that.selectedFundHouse.fund_house
                    })
                }
                return true
            }); */
        
      },
    }
    </script>
    <style>
    .top_th {
        background: #00665e !important;
        color: #fff  !important;
    }
    .with_border{
    border-left: 1px solid #000  !important;
    border-right: 1px solid #000  !important;
    }
    .left_border{
    border-left: 1px solid #000 !important;
    }
    .right_border{
    border-right: 1px solid #000 !important;
    }
    th{
        vertical-align: middle !important;
    }
    .perform-paramtr .dy-table-wrap .dy-table-block {
        border: 0px !important;
    }
    .dp__pointer {
        height: 48px;
    }
    .investing-tools .invst-wrap .invst-fields select, .custom-input {
        border: 0;
        height: 40px;
        padding: 0 15px;
        width:100%;
        border-radius: 5px;
        box-shadow: 0px 3px 13px -7px #0000005c;
    }
    .text-right {
        text-align: right!important;
    }
    .perform-snapshot-tabs .perform-snapshot-submit{
        margin: 25px 0 15px 0;
    }
    </style>