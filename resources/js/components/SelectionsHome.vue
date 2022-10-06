<template>
<div class="">
    <div class="single_abt_item d-flex align-items-start mb-5" data-aos="" data-aos-duration="1500">
        <div class="abt_icon">
            <img :src="this.image_path+'/fund-icon.png'" alt="pfrt" />
        </div>
        <div class="single_abt_content">
            <h4>Fund Performance</h4>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            <div class="select_option">
                <multiselect 
                class="abt_select"
                 label="fund_name" 
                 track-by="fund_id" 
                 v-model="selectedFund" 
                 tag-placeholder="" 
                 placeholder="Select Fund" 
                 :options="funds" 
                 :multiple="false" 
                 :taggable="false" 
                 selectLabel="" :searchable="true" 
                 :block-keys="['Tab', 'Enter', 'backspace']" 
                 :max-height="150" 
                 :showNoResults="true">
                </multiselect>
            </div>
        </div>
    </div>
    <div class="single_abt_item d-flex align-items-start mb-5"  data-aos-duration="1500">
        <div class="abt_icon">
            <img :src="this.image_path+'/performance-icon.png'" alt="performance"/>
        </div>
        <div class="single_abt_content">
            <h4>Performance Snapshot</h4>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            <div class="select_option">
                <multiselect 
                    class=""
                    label="name" 
                    track-by="ft_id"
                    v-model="selectedFundClassification1" 
                    tag-placeholder=""
                    placeholder="Select Fund Classification" 
                    :options="fundClassifications" 
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
    <div class="single_abt_item d-flex align-items-start"  data-aos-duration="1500">
        <div class="abt_icon">
            <img :src="this.image_path+'/ranking-icon.png'" alt='ranking-ico'/>
        </div>
        <div class="single_abt_content">
            <h4>Monthly Ranking</h4>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            <div class="select_option">
                <select class="abt_select" v-model="selectedFundClassification2">
                    <option value="">Select Scheme</option>
                    <option v-for="claify in fundClassifications" :value="claify">{{claify.name}}</option>
                </select>
            </div>
        </div>
    </div>

</div>
</template>

<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>

<script>
import Multiselect from '@suadelabs/vue3-multiselect'
import mixin from '../mixin';
import {
    mapGetters,
    mapActions
} from 'vuex'
import moment from 'moment';
export default {
    props: ['image_path'],
    components: {
        Multiselect,
    },
    mixins: [mixin],
    data() {
        return {
            snapshotText: null,
            process: false,
            selectedFund: null,
            selectedFundClassification1: '',
            selectedFundClassification2: '',
            monthly_ranking_date: null
        }
    },
    methods: {
        ...mapActions('InputData', ['getFundClassifications', 'getFunds']),

        async getMonthlyRankingDates() {
            let that = this
            that.process = true
            that.snapshotText = ''
            await axios.get('/api/v1/monthly-ranking-date')
                .then(response => {
                    that.monthly_ranking_date = response.data.data
                    return true
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
        selectedFund(value) {
            if (value) {
                window.location.href = 'fund-performance?fund_code=' + encodeURIComponent(value.fund_code)
            }
        },
        selectedFundClassification1(value) {
            if (value) {
                window.location.href = 'performance-snapshot?fund_type_id=' + encodeURIComponent(value.ft_id) + '&type=weekly&report_category=return&date=' + moment().format('YYYY-MM-DD')
            }
        },
        selectedFundClassification2(value) {
            if (value) {
                window.location.href = 'monthly-ranking?fund_classification=' + encodeURIComponent(value.name)
            }
        }
    },
    computed: {
        ...mapGetters('InputData', ['loading', 'fundClassifications', 'funds']),
    },
    mounted() {
        let that = this
        that.getMonthlyRankingDates()
        that.getFundClassifications()
        that.getFunds({})
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
</style>
