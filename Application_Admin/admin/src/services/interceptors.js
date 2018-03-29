import Vue from 'vue'
import api from '@/api'
import ls from '@/services/ls'
import store from '@/store'

export default {
    install: (Vue, options = {}) => {
        // Add a request interceptor
        api.interceptors.request.use(function (config) {
            if (typeof ls.get('token') !== 'undefined') {

                if (!config.params) {
                    config.params = {}
                }
                config.params.token = ls.get('token')
            }

            return config
        }, function (error) {
            return Promise.reject(error)
        })

        // Add a response interceptor
        api.interceptors.response.use(function (response) {
            return response;
        }, function (error) {
            if (error.response && error.response.status == 401) {
                console.log(401);
                api.get('admin/logout').then(response => {
                    console.log('deco')
                    ls.remove('token')
                }).catch(error => {
                    console.log(error)
                })
                options.router.push({
                    name: 'signin'
                })
            }
            return Promise.reject(error)
        })
    }
}
