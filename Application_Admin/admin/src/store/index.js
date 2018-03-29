import Vue from 'vue'
import Vuex from 'vuex'
import api from '@/api'
import createPersistedState from 'vuex-persistedstate'
import jukebox from './modules/jukebox'

Vue.use(Vuex)

export default new Vuex.Store({
    plugins: [createPersistedState()],
    modules: {
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
