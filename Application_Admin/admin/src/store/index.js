import Vue from 'vue'
import Vuex from 'vuex'
import api from '@/api'
import createPersistedState from 'vuex-persistedstate'

import auth from './modules/auth'
import jukebox from './modules/jukebox'

Vue.use(Vuex)

export default new Vuex.Store({
    plugins: [createPersistedState()],
    modules: {
        auth,
        jukebox
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
