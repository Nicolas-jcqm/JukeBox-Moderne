import Vue from 'vue'
import Router from 'vue-router'
import signin from '@/components/signin'
import signup from '@/components/signup'
import home from '@/components/home'
import history from '@/components/history'
import catalog from '@/components/catalog'

Vue.use(Router)

export default new Router({
    routes: [
        {
            path: '/',
            name: 'signin',
            component: signin
        },
        {
            path: '/signup',
            name: 'signup',
            component: signup
        },
        {
            path: '/home',
            name: 'home',
            component: home
        },
        {
            path:'/history',
            name:'history',
            component: history
        },
        {
          path: '/catalog/:tokenJukebox',
          name: 'catalog',
          component: catalog
        }
  ]
})
