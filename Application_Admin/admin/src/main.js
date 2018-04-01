// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'
import BootstrapVue from 'bootstrap-vue'
import interceptors from './services/interceptors'
import draggable from 'vuedraggable'


import ls from './services/ls'

Vue.config.productionTip = false

Vue.use(BootstrapVue);
require('../node_modules/bootstrap/dist/css/bootstrap.css')


Vue.use(interceptors, {
	router
})

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  draggable,
  template: '<App/>',
  components: { App }
})
