
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)


import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import Vuex from 'vuex'
Vue.use(Vuex)

import axios from 'axios'
import VueAxios from 'vue-axios'
//axios.defaults.baseURL = 'http://sajjainfo.com';
//axios.defaults.headers.common['Authorization'] = AUTH_TOKEN;
Vue.use(VueAxios, axios)
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest'
};
Vue.use(VueAxios, axios)

import App from './views/App.vue'
import Home from './views/Home.vue'
import Admin from './views/Admin/Admin'
import AdminIndex from './views/Admin/AdminIndex'


const router = new VueRouter({
    mode: 'history',
    base: '/',
    routes: [
        {
            path: '/',
            component: Home
        },
        {
            path: '/admin',
            component: Admin,
            mode: 'history',
            children: [
                {
                    path: '',
                    component: AdminIndex
                }
            ]
        }
    ]
});
import AdminNav from './components/Admin/AdminNav.vue';
Vue.component('AdminNav', AdminNav).defaults;

import AdminMenu from './components/Admin/AdminMenu.vue';
Vue.component('AdminMenu', AdminMenu).defaults;


const app = new Vue({
    el: '#app',
    components: { App },
    router
});
