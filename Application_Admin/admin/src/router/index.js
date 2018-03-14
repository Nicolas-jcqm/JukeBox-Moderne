import Vue from 'vue'
import Router from 'vue-router'
import signin from '@/components/signin'
import home from '@/components/home'

Vue.use(Router)

export default new Router({
    routes: [
        {
            path: '/',
            name: 'signin',
            component: signin
    },
        {
            path: '/home',
            name: 'home',
            component: home
    }
  ]
})
