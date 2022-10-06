<template>
    <div class="info_monitor_inner">
					<div class="info_monitor_inner_wrapper mb-3">
						<div class="dictionary_search_area d-block d-sm-flex align-items-center">
							<div class="dictionary_entity_row d-flex align-items-center">
								<label>Show</label>
								<select class="dictionary_entity_select" v-model="limit" :disabled="limitDisabled">
									<option v-for="limit in limits" :value="limit">{{limit}}</option>
								</select>
								<span>entries</span>
							</div>
							<div class="dictionary_search">
								<div class="search_dictionary d-flex">
									<input type="text" placeholder="Search" class="dictionary_search_fiel" v-model="search_text"/>
									<button v-if="!showAll" @click="showAllData(true)">Show All</button>
									<button v-else @click="showAllData(false)">Paginate</button>
								</div>
							</div>
						</div>
						<div class="dictionary_table"> 
              <div class="mb-3 pull-right"  v-if="showAll!=true">
                <pagination  class="" :data="fund_directory" @pagination-change-page="list"></pagination>
              </div>
							<div class="datatable_ll main_trer">
								<div class="table-responsive">
									<table id='mutualFundDictionaryTable'  class="table table-striped" style="width:100%">
										<thead>
											<tr>
												<th>Abbreviation</th>
												<th>Meaning</th>
											</tr>
										</thead>
                    <tbody v-if="!process">
                        <tr v-for="directory in fund_directory.data">
                          <td>{{directory.title}}</td>
                          <td>{{directory.description}}</td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                      <tr>
                          <td colspan="6">
                              <div class="text-center mt-3">
                                  <LoadingBar :status="process"></LoadingBar>
                              </div>      
                          </td>
                      </tr>
                    </tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
</template>

<script>
    import CustomTable from './Common/CustomTable.vue'
    import Multiselect from '@suadelabs/vue3-multiselect'
    import LoadingBar from "./Common/loading";
    import mixin from '../mixin';
    import { mapGetters, mapActions } from 'vuex';
    import pagination from 'laravel-vue-pagination';
    
    export default {
        props: {
            
        },
        components: {
          Multiselect,
          LoadingBar,
          pagination
      },
      mixins: [mixin],
       data() {
                return {
                    fund_directory: [],
                    limits:[50,100,200,300],
                    process:false,
                    app_url:process.env.MIX_APP_ENV=='local' ?  process.env.MIX_API_URL_LOCAL :'',
                    counts:2,
                    defaultStart:5,
                    shareText:'',
                    limit:100,
                    search_text:'',
                    page:0,
                    data:{},
                    showAll:false,
                    limitDisabled:false,
                }
      },
      methods: {
       currentURL(){
        return window.location.href
       },
       list(page){
        this.page=page,
        this.getFundDirectory();
       },
       showAllData(type){
        this.limitDisabled=type;
        this.showAll=type;
        this.getFundDirectory();
       }, 
       async getFundDirectory(){
        this.data.limit =this.limit;
        this.data.text =this.search_text;
        this.data.showAll =this.showAll;
        if(this.data.text!=''){
          this.data.page ='';
        }else{
          this.data.page =this.page;
        }
       let that = this
       that.process = true
       await axios.get('/api/v2/mutual-fund-directory',{
                params: this.data
            })
            .then(response => {
                that.fund_directory = response.data.data.table_data
                return true
            })
            .then(response => {
            })
            .catch(error => {
                console.log(error);
            })
            .finally(() => {
                that.process = false
            })
   },
      },
      watch: {
        limit(value){
          if(value){
            this.getFundDirectory();
          }
        },
        search_text(value){
          if(value){
            this.getFundDirectory();
          }
        },
        },
      computed: {
        ...mapGetters('InputData', ['loading','fundClassifications']),
      },
      mounted() {
        this.getFundDirectory();
      },
    }
    </script>