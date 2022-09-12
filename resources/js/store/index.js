import { createStore } from 'vuex'

import Alert from './modules/alert'
import InputData from './modules/inputData'

const debug = process.env.NODE_ENV !== 'production'

export default createStore({
    modules: {
        Alert,
        InputData,
    },
    strict: debug,
})