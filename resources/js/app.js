
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');



window.Vue = require('vue');

import Vue from 'vue'



import $ from 'jquery';
window.$ = window.jQuery = $;

import 'jquery-ui/ui/widgets/datepicker.js';
/* import Buefy from 'buefy'
import 'buefy/dist/buefy.css'

Vue.use(Buefy,{
    defaultDayNames: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
    defaultMonthNames: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.']
}) */

// import { store } from './store'
//import router from './router'
import Vue2Crumbs from 'vue-2-crumbs'

Vue.use(Vue2Crumbs)

import Datetime from 'vue-datetime'
// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css'

Vue.use(Datetime)

import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue)

//import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import Vuex from 'vuex';
//import createPersistedState from 'vuex-persistedstate';
import VuexPersistence from 'vuex-persist'
import Cookies from 'js-cookie';
Vue.use(Vuex)
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import axios from 'axios'
import VueAxios from 'vue-axios'
//axios.defaults.baseURL = 'http://sajjainfo.com';
//axios.defaults.headers.common['Authorization'] = AUTH_TOKEN;

Vue.use(VueAxios, axios)

import jsPDF from 'jspdf'
Vue.use(jsPDF)

import VueSwal from 'vue-swal'
Vue.use(VueSwal)

import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)
//------------------- Validation
import {
    ValidationObserver,
    ValidationProvider,
    extend,
    localize
  } from "vee-validate";
import th from "vee-validate/dist/locale/th.json";
import * as rules from "vee-validate/dist/rules";
Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule]);
  });

  localize("th", th);

  // Install VeeValidate components globally
  Vue.component("ValidationObserver", ValidationObserver);
  Vue.component("ValidationProvider", ValidationProvider);
//------------------- Validation



import ToggleButton from 'vue-js-toggle-button'
Vue.use(ToggleButton)

Vue.use(require('vue-moment'));

import vueNumeralFilterInstaller from 'vue-numeral-filter';
Vue.use(vueNumeralFilterInstaller);

import Cleave from 'vue-cleave-component';
Vue.use(Cleave,{
    options: {
        number: {
            prefix: '',
            numeral: true,
            numeralPositiveOnly: true,
            noImmediatePrefix: true,
            rawValueTrimPrefix: true,
            numeralIntegerScale: 9,
            numeralDecimalScale: 2
          },
    }
});




import App from './views/App.vue'
 import Home from './views/Home.vue'
import Login from './views/Login.vue'
import Refund from './views/Refund.vue'
import RefundDashboard from './views/Dashboard.vue'
import Office from './views/Office.vue'
import RefundList from './views/RefundList.vue'
import RefundForm from './views/RefundForm.vue'
import RefundDetail from './views/RefundDetail.vue'
import RefundFormCheck from './views/RefundFormCheck.vue'
import RefundFormTest from './views/RefundFormTest.vue'

import Admin from './views/Admin/Admin'
import AdminIndex from './views/Admin/AdminIndex'

import AdminRefundList from './views/Admin/Refund/AdminRefundList'
import FormIndex from './views/Admin/Form/FormIndex'

const router = new VueRouter({
    mode: 'history',
    base: '/',
    routes: [
        {
            path: '/',
            component: Home,
            meta: {
                breadCrumb: 'หน้าหลัก' //crumb
            }
        },
        {
            path: '/login',
            component: Login,
            meta: {
                breadCrumb: 'เข้าสู่ระบบ' //crumb
            }
        },
        {
            path: '/refund',
            component: Refund,
            beforeEnter (to, from, next) {
                if (store.state.user.type == 'user') {
                    next()
                } else {
                    next('/login')
                }
            },
            meta: {
                breadCrumb: 'หน้าแรก' //crumb
            },
            children: [
                {
                    path: '',
                    component: RefundDashboard,
                    meta: {
                        breadCrumb: 'Dashboard' //crumb
                    }
                },
                {
                    path: 'refunds',
                    component: RefundList,
                    meta: {
                        breadCrumb: 'แบบถอนคืนเงินรายได้ฯ' //crumb
                    }
                },
                {
                    path: 'refunds/:id',
                    name: 'refund',
                    component: RefundDetail,
                    //component: RefundFormCheck,
                    meta: {
                        breadCrumb: `แบบถอนคืนเงินราย` //crumb
                    },children: [
                        {
                            path: '_id/detail',
                            component: RefundDetail,
                            meta: {
                                breadCrumb: 'ตรวจสอบแบบถอนคืนเงินรายได้ฯ' //crumb
                            }
                        },
                    ]
                },
                {
                    path: 'form',
                    component: RefundForm,
                    meta: {
                        breadCrumb: `แบบถอนคืนเงินราย` //crumb
                    }

                },
                {
                    path: 'form/:id',
                    component: RefundFormTest,
                    meta: {
                        breadCrumb: `แบบถอนคืนเงินรายได้ เลขที่` //crumb
                    }

                },
                {
                    path: 'test/',
                    component: RefundFormTest,
                    meta: {
                        breadCrumb: `แบบถอนคืนเงินรายได้ เลขที่` //crumb
                    }

                },
                {
                    path: 'office',
                    component: Office,
                    meta: {
                        breadCrumb: 'ข้อมูลหน่วยงาน' //crumb
                    }
                },
            ]
        },
        {
            path: '/admin',
            component: Admin,
            mode: 'history',
            beforeEnter (to, from, next) {
                if (store.state.user) {
                    if (store.state.user.type == 'admin'){
                        next()
                    }else{
                        next('/refund')
                    }
                } else {
                    next('/login')
                }
            },
            meta: {
                breadCrumb: 'Dashboard' //crumb
            },

            children: [
                {
                    path: '',
                    component: AdminIndex,
                    meta: {
                        breadCrumb: 'Admin' //crumb
                    }
                },
                {
                    path: 'form',
                    component: FormIndex,
                    meta: {
                        breadCrumb: 'จัดการแบบฟอร์ม' //crumb
                    }
                },
                {
                    path: 'refunds',
                    component: RefundList,
                    meta: {
                        breadCrumb: 'รายการขอถอนคืน' //crumb
                    }
                },
                {
                    path: 'refunds/:id',

                    component: RefundDetail,
                    //component: RefundFormCheck,
                    meta: {
                        breadCrumb: `แบบถอนคืนเงินราย` //crumb
                    },
                },
            ]
        }
    ]
});

// router.beforeEach((to, from, next) => {
//     if (to.fullPath !== "/login") {
//         axios.get('/api/profile')
//         .then(response => {
//             console.log('next page' + response.data);
//             next();
//         }).catch(error => {
//             router.push('/login');
//         })
//     } else {
//         next();
//     }
// })
import AdminNav from './components/Admin/AdminNav.vue';
Vue.component('AdminNav', AdminNav).defaults;

import AdminMenu from './components/Admin/AdminMenu.vue';
Vue.component('AdminMenu', AdminMenu).defaults;

import AdminBreadcrumb from './components/Admin/AdminBreadcrumb.vue';
Vue.component('AdminBreadcrumb', AdminBreadcrumb).defaults;

import AdminSide from './components/Admin/AdminSide.vue';
Vue.component('AdminSide', AdminSide).defaults;

import FormFind from './components/Admin/Form/FormFind.vue';
Vue.component('FormFind', FormFind).defaults;

import FormCover from './components/Admin/Form/FormCover.vue';
Vue.component('FormCover', FormCover).defaults;

import FormDetail from './components/Admin/Form/FormDetail.vue';
Vue.component('FormDetail', FormDetail).defaults;

import FormRuleList from './components/Admin/Form/FormRuleList.vue';
Vue.component('FormRuleList', FormRuleList).defaults;

import FormRule from './components/Admin/Form/FormRule.vue';
Vue.component('FormRule', FormRule).defaults;

import RuleCover from './components/Admin/Form/RuleCover.vue';
Vue.component('RuleCover', RuleCover).defaults;

import SubRule from './components/Admin/Form/SubRule.vue';
Vue.component('SubRule', SubRule).defaults;

import RuleCondition from './components/Admin/Form/RuleCondition.vue';
Vue.component('RuleCondition', RuleCondition).defaults;

import RuleConsider from './components/Admin/Form/Consider.vue';
Vue.component('RuleConsider', RuleConsider).defaults;

import ConsiderCover from './components/Admin/Form/ConsiderCover.vue';
Vue.component('ConsiderCover', ConsiderCover).defaults;

import MyAlert from './components/MyAlert.vue';
Vue.component('MyAlert', MyAlert).default;

import ShowAlert from './components/ShowAlert.vue';
Vue.component('ShowAlert', ShowAlert).default;

import MyLogin from './components/Login/Login.vue';
Vue.component('MyLogin', MyLogin).default;



//***********************Refund************************* */
import RefundNav from './components/Refund/RefundNav.vue';
Vue.component('RefundNav', RefundNav).defaults;

import RefundMenu from './components/Refund/RefundMenu.vue';
Vue.component('RefundMenu', RefundMenu).defaults;

import RefundBreadcrumb from './components/Refund/RefundBreadcrumb.vue';
Vue.component('RefundBreadcrumb', RefundBreadcrumb).defaults;

import RefundSide from './components/Refund/RefundSide.vue';
Vue.component('RefundSide', RefundSide).defaults;

import RefundCover from './components/Refund/RefundCover.vue';
Vue.component('RefundCover', RefundCover).defaults;

import RefundFormCover from './components/Refund/RefundFormCover.vue';
Vue.component('RefundFormCover', RefundFormCover).defaults;

import ContractForm from './components/Refund/ContractForm.vue';
Vue.component('ContractForm', ContractForm).defaults;

import ContractEdit from './components/Refund/ContractEdit.vue';
Vue.component('ContractEdit', ContractEdit).defaults;

import ContractTimeEdit from './components/Refund/ContractTimeEdit.vue';
Vue.component('ContractTimeEdit', ContractTimeEdit).defaults;

import Delivery from './components/Refund/Delivery.vue';
Vue.component('Delivery', Delivery).defaults;

import DepositPenalty from './components/Refund/DepositPenalty.vue';
Vue.component('DepositPenalty', DepositPenalty).defaults;

import RefundSummary from './components/Refund/RefundSummary.vue';
Vue.component('RefundSummary', RefundSummary).defaults;

import RefundCheck from './components/Refund/RefundCheck.vue';
Vue.component('RefundCheck', RefundCheck).defaults;

import RuleCheck from './components/Refund/RuleCheck.vue';
Vue.component('RuleCheck', RuleCheck).defaults;

import RefundRule from './components/Refund/RefundRule.vue';
Vue.component('RefundRule', RefundRule).defaults;

import ConsiderCheck from './components/Refund/ConsiderCheck.vue';
Vue.component('ConsiderCheck', ConsiderCheck).defaults;

import MyDatePicker from './components/MyDatePicker.vue';
Vue.component('MyDatePicker', MyDatePicker).defaults;

import RefundReport from './components/Refund/RefundReport.vue';
Vue.component('RefundReport', RefundReport).defaults;

import SentRefund from './components/Refund/SentRefund.vue';
Vue.component('SentRefund', SentRefund).defaults;

import AdminApprove from './components/Refund/AdminApprove.vue';
Vue.component('AdminApprove', AdminApprove).defaults;

const store = new Vuex.Store({
    state: {
        user: null,
        userToken: null,
        refund_show: null,
        office_id: null
    },
    // plugins: [
    //     createPersistedState({
    //         storage: {
    //             getItem: key => Cookies.get(key),
    //             setItem: (key, value) =>
    //                 Cookies.set(key, value, { expires: 3, secure: true }),
    //             removeItem: key => Cookies.remove(key)
    //         }
    //     })
    // ],
    plugins: [new VuexPersistence().plugin],
    getters: {
        refund_show: state => {
            return state.refund_show;
        },
        user_type (state){
            if (state.user){
                return state.user.type
            }
        },
        user (state){
            if (state.user){
                return state.user
            }
        },
        userToken (state){
            if (state.userToken){
                return state.userToken
            }
        },
        office_id (state){
            if (state.office_id){
                return state.office_id
            }
        }
    },
    mutations: {
        authUser (state, userData){
            //console.log(userData.user);
            state.user = userData.user
            state.userToken = userData.token
        },
        clearAuthData (state){
            state.user = null
            state.userToken = null
        },
        SET_USER:(state, value) => {
            state.user = value
        },
        SET_REFUND_SHOW: (state, value) => {
            state.refund_show = value
        },
        FETCH_FORM: (state) => {

        },
        office_id (state, value){
            state.office_id = value
        }

    },
    actions: {
        login ({ commit, state}, authData){
            let path = '/api/login'
            return new Promise((resolve, reject) => {
                axios.post(path,{
                    username: authData.username,
                    password: authData.password
                })
                .then(response=>{
                    const userData = response.data.data
                    commit('authUser',{
                        user: userData,
                        token: response.data.success
                    })
                    localStorage.setItem('token', response.data.success)
                    if (userData.type == 'admin'){
                        router.replace('/admin')
                    }else if (userData.type == 'user'){
                        commit('office_id', userData.office_id)
                        router.replace('/refund')
                    }
                    resolve(response)
                })
                .catch(error=>{
                    reject(error)
                })
            })
        },
        checkLogin({ state }){
            const userData = state.user
            if (userData){
                if (userData.type == 'admin'){
                    router.replace('/admin')
                }else if (userData.type == 'user'){
                    router.replace('/refund')
                }
            }
        },
        logout({ commit }){
            commit('clearAuthData')
            router.replace('/login')
        },

    }

})
Vue.use(VueAxios, axios)

// let AUTH_TOKEN = store.getters('userToken');
// axios.defaults.headers.common['Authorization'] = AUTH_TOKEN;
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',


};
axios.interceptors.request.use(
    (config) => {
      let token = localStorage.getItem('token');

      if (token) {
        config.headers['Authorization'] = `Bearer ${ token }`;
      }

      return config;
    },

    (error) => {
      return Promise.reject(error);
    }
  );
const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store,

});
