function initialState() {
    return {
        loading: false,
        fundHouses:[],
        fundClassifications:[],
        funds:[],
        index_change:[],
        currency_change:[],
        commodity_change:[],
        fund_change:[],
        from_date:'',
        to_date: '',
        weekly_best_funds:[],
        monthly_best_funds:[],
        indices:[],
        currencies:[],
        apiURL:'https://beta.myplexus.com',
    }
}

const getters = {
    loading: state => state.loading,
    fundHouses: state => state.fundHouses,
    fundClassifications: state => state.fundClassifications,
    funds: state => state.funds,
    index_change: state => state.index_change,
    currency_change: state => state.currency_change,
    commodity_change: state => state.commodity_change,
    fund_change: state => state.fund_change,
    from_date: state => state.from_date,
    to_date: state => state.to_date,
    weekly_best_funds: state => state.weekly_best_funds,
    monthly_best_funds: state => state.monthly_best_funds,
    indices: state => state.indices,
    currencies: state => state.currencies,
}

const actions = {
    async getFundHouses({ commit, state }) {
        commit('setLoading', true)
        await axios.get(state.apiURL+'/api/v1/fund-houses')
            .then(response => {
                commit('setFundHouses', response.data.data)
            })
            .catch(error => {
                var message = error.response.data.message || error.message
                this.dispatch('Alert/setAlert', {
                    message: message,
                    color: 'warning',
                },
                {
                    root: true
                })
            })
            .finally(() => {
                commit('setLoading', false)
            })
    },
    async getIndices({ commit, state }) {
        commit('setLoading', true)
        await axios.get(state.apiURL+'/api/v1/indices')
            .then(response => {
                commit('setIndices', response.data.data)
            })
            .catch(error => {
                var message = error.response.data.message || error.message
                this.dispatch('Alert/setAlert', {
                    message: message,
                    color: 'warning',
                },
                {
                    root: true
                })
            })
            .finally(() => {
                commit('setLoading', false)
            })
    },
    async getCurrencies({ commit, state }) {
        commit('setLoading', true)
        await axios.get(state.apiURL+'/api/v1/currencies')
            .then(response => {
                commit('setCurrencies', response.data.data)
            }).catch(error => {
                var message = error.response.data.message || error.message
                this.dispatch('Alert/setAlert', {
                    message: message,
                    color: 'warning',
                },
                {
                    root: true
                })
            }).finally(() => {
                commit('setLoading', false)
            })
    },
    async getFundClassifications({ commit, state }) {
        commit('setLoading', true)
        await axios.get(state.apiURL+'/api/v1/fund-classifications')
            .then(response => {
                commit('setFundClassifications', response.data.data)
            })
            .catch(error => {
                var message = error.response.data.message || error.message
                this.dispatch('Alert/setAlert', {
                    message: message,
                    color: 'warning',
                },
                {
                    root: true
                })
            })
            .finally(() => {
                commit('setLoading', false)
            })
    },
    async getFunds({ commit, state },payload) {
        commit('setLoading', true)
        await axios.get(state.apiURL+'/api/v1/funds', { params: payload })
            .then(response => {
                commit('setFunds', response.data.data)
            })
            .catch(error => {
                var message = error.response.data.message || error.message
                this.dispatch('Alert/setAlert', {
                    message: message,
                    color: 'warning',
                },
                {
                    root: true
                })
            })
            .finally(() => {
                commit('setLoading', false)
            })
    },
    async getSnapshotDates({ commit, state }, payload) {
        this.process = true
        await axios.get(state.apiURL+'/api/v1/snapshot-dates', { params: payload })
            .then(response => {
                commit('setFromDate', response.data.data.from_date)
                commit('setToDate', response.data.data.to_date)
            })
            .catch(error => {

            })
            .finally(() => {
                this.process = false
            })
    },
    async getIndexChanges({ commit, state },payload) {
        commit('setLoading', true)
        await axios.get(state.apiURL+'/api/v1/changes-index', { params: payload })
            .then(response => {
                commit('setIndexChanges', response.data.data.changes_index)
                
            })
            .catch(error => {
                var message = error.response.data.message || error.message
                this.dispatch('Alert/setAlert', {
                    message: message,
                    color: 'warning',
                },
                {
                    root: true
                })
            })
            .finally(() => {
                commit('setLoading', false)
            })
    },
    async getCurrencyChanges({ commit, state },payload) {
        commit('setLoading', true)
        await axios.get(state.apiURL+'/api/v1/changes-currency', { params: payload })
            .then(response => {
                commit('setCurrencyChanges', response.data.data.changes_currency)
            })
            .catch(error => {
                var message = error.response.data.message || error.message
                this.dispatch('Alert/setAlert', {
                    message: message,
                    color: 'warning',
                },
                {
                    root: true
                })
            })
            .finally(() => {
                commit('setLoading', false)
            })
    },
    async getCommodityChanges({ commit, state },payload) {
        commit('setLoading', true)
        await axios.get(state.apiURL+'/api/v1/changes-commodity', { params: payload })
            .then(response => {
                commit('setCommodityChanges', response.data.data.changes_commodity)
            })
            .catch(error => {
                var message = error.response.data.message || error.message
                this.dispatch('Alert/setAlert', {
                    message: message,
                    color: 'warning',
                },
                {
                    root: true
                })
            })
            .finally(() => {
                commit('setLoading', false)
            })
    },
    async getFundChanges({ commit, state },payload) {
        commit('setLoading', true)
        await axios.get(state.apiURL+'/api/v1/changes-fund', { params: payload })
            .then(response => {
                commit('setFundChanges', response.data.data.changes_fund)
            })
            .catch(error => {
                var message = error.response.data.message || error.message
                this.dispatch('Alert/setAlert', {
                    message: message,
                    color: 'warning',
                },
                {
                    root: true
                })
            })
            .finally(() => {
                commit('setLoading', false)
            })
    },
    async getWeeklyBestFunds({ commit, state }) {
        commit('setLoading', true)
        await axios.get(state.apiURL+'/api/v1/weekly-best-funds')
            .then(response => {
                commit('setWeeklyBestFunds', response.data.data.weekly_best_funds)
            })
            .catch(error => {
                var message = error.response.data.message || error.message
                this.dispatch('Alert/setAlert', {
                    message: message,
                    color: 'warning',
                },
                {
                    root: true
                })
            })
            .finally(() => {
                commit('setLoading', false)
            })
    },
    async getMonthlyBestFunds({ commit, state }) {
        commit('setLoading', true)
        await axios.get(state.apiURL+'/api/v1/monthly-best-funds')
            .then(response => {
                commit('setMonthlyBestFunds', response.data.data.monthly_best_funds)
            })
            .catch(error => {
                var message = error.response.data.message || error.message
                this.dispatch('Alert/setAlert', {
                    message: message,
                    color: 'warning',
                },
                {
                    root: true
                })
            })
            .finally(() => {
                commit('setLoading', false)
            })
    },

}

const mutations = {
    setLoading(state, loading) {
        state.loading = loading
    },
    setFundHouses(state, fundHouses) {
        state.fundHouses = fundHouses
    },
    setFundClassifications(state, fundClassifications) {
        state.fundClassifications = fundClassifications
    },
    setFunds(state, funds) {
        state.funds = funds
    },
    setIndexChanges(state, index_change) {
        state.index_change = index_change
    },
    setCurrencyChanges(state, currency_change) {
        state.currency_change = currency_change
    },
    setCommodityChanges(state, commodity_change) {
        state.commodity_change = commodity_change
    },
    setFundChanges(state, fund_change) {
        state.fund_change = fund_change
    },
    setFromDate(state, from_date) {
        state.from_date = from_date
    },
    setToDate(state, to_date) {
        state.to_date = to_date
    },
    setWeeklyBestFunds(state, weekly_best_funds) {
        state.weekly_best_funds = weekly_best_funds
    },
    setMonthlyBestFunds(state, monthly_best_funds) {
        state.monthly_best_funds = monthly_best_funds
    },
    setIndices(state, indices) {
        state.indices = indices
    },
    setCurrencies(state, currencies) {
        state.currencies = currencies
    },
    resetState(state) {
        state = Object.assign(state, initialState())
    }

}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}
