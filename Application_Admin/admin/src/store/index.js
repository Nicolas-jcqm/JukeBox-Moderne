import Vue from 'vue'
import Vuex from 'vuex'
import api from '@/api'
import createPersistedState from 'vuex-persistedstate'

import auth from './modules/auth'

Vue.use(Vuex)

export default new Vuex.Store({
    plugins: [createPersistedState()],
    modules: {
        auth,
    },
    
    state: {
        
    },

    getters: {
       
    },

    mutations: {
        
    },
    actions: {

    }
});
