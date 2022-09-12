<template>
    <table :id="id" class="display dataTable no-footer">
        <thead>
            <tr>
                <th v-for="col in columns" :key="col.key" v-on:click="sortTable(col.key)" class="sorting" :style="col.hasOwnProperty('style')?col.style:{}" :class="{'sorting_asc':sortKey == col.key && ascending, 'sorting_desc': sortKey == col.key && !ascending}">
                    {{col.name}}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(row,index) in rows" :key="index">
                <td v-for="(col,key) in columns" :key="index+key">{{ col.hasOwnProperty('decimalplaces')?row[col.key].toFixed(col.decimalplaces):row[col.key] }}</td>
            </tr>
        </tbody>
    </table>
    <p v-if="!rows.length" class="p-2">No Record Found</p>
</template>
<script>
export default {
    props: {
        columns: {
        type: [Array],
        required: true,
        },
        rows: {
        type: [Array],
        required: true,
        },
        id: {
        type: String,
        required: false,
        default: '',
        },
        default_sort_key: {
        type: String,
        required: false,
        default: '',
        },
        order_ascending: {
        type: Boolean,
        required: false,
        default: false,
        },
        tabindex: {
        type: Number,
        required: false,
        default: 0,
        },
    },
   data() {
            return {
                sortKey: this.default_sort_key,
                ascending: this.order_ascending,                
            }
  },
  methods: {
    sortTable(col) {
      if (this.sortKey === col) {
        this.ascending = !this.ascending;
      } else {
        this.ascending = true;
        this.sortKey = col;
      }

      var ascending = this.ascending;

      this.rows.sort(function(a, b) {
        if (a[col] > b[col]) {
          return ascending ? 1 : -1
        } else if (a[col] < b[col]) {
          return ascending ? -1 : 1
        }
        return 0;
      })
    }
  },
  computed: {
    
  },
  watch:{
    rows(value){
      if(value.length){
        this.sortTable(this.default_sort_key)
      }
    }
  }

}
</script>