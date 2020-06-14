
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

import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue'
Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)

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
import { SidebarNav } from '@coreui/vue'
Vue.component('SidebarNav', SidebarNav).defaults;

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
import RefundShow from './views/RefundShow.vue'
import RefundDetail from './views/RefundDetail.vue'
import RefundFormCheck from './views/RefundFormCheck.vue'
import RefundFormTest from './views/RefundFormTest.vue'

import Admin from './views/Admin/Admin'
import AdminIndex from './views/Admin/AdminIndex'

import AdminRefundList from './views/Admin/Refund/AdminRefundList'
import FormIndex from './views/Admin/Form/FormIndex'


//const DefaultContainer = () => import('@/views/containers/DefaultContainer')

const router = new VueRouter({
    mode: 'history',
    base: '/',
    routes: [
        {
            path: '/',

            component: Home,
            redirect: '/login',
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
                    component: RefundShow,
                    meta: {
                        breadCrumb: 'การถอนคืนฯ' //crumb
                    },
                    children: [
                        {
                            path: '',
                            component: RefundList,
                            meta: {
                                breadCrumb: 'รายการถอนคืนฯ' //crumb
                            },
                        },
                        {
                            path: ':id',
                            name: 'refund',
                            component: RefundDetail,
                            //component: RefundFormCheck,
                            meta: {
                                breadCrumb: `ข้อมูลการถอนคืนฯ` //crumb
                            }
                        },
                    ]
                },
                // {
                //     path: 'refunds/:id',
                //     name: 'refund',
                //     component: RefundDetail,
                //     //component: RefundFormCheck,
                //     meta: {
                //         breadCrumb: `แบบถอนคืนเงินราย` //crumb
                //     }
                // },
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
            component: Refund,
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
                breadCrumb: 'Admin' //crumb
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
                    component: RefundShow,
                    meta: {
                        breadCrumb: 'การถอนคืนฯ' //crumb
                    },
                    children: [
                        {
                            path: '',
                            component: RefundList,
                            meta: {
                                breadCrumb: 'รายการถอนคืนฯ' //crumb
                            },
                        },
                        {
                            path: ':id',
                            name: 'refund',
                            component: RefundDetail,
                            //component: RefundFormCheck,
                            meta: {
                                breadCrumb: `ข้อมูลการถอนคืนฯ` //crumb
                            }
                        },
                    ]
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
// ---------------- Layout -----------------------
import AdminNav from './components/Admin/AdminNav.vue';
Vue.component('AdminNav', AdminNav).defaults;

import AdminMenu from './components/Admin/AdminMenu.vue';
Vue.component('AdminMenu', AdminMenu).defaults;

import AdminBreadcrumb from './components/Admin/AdminBreadcrumb.vue';
Vue.component('AdminBreadcrumb', AdminBreadcrumb).defaults;

import AdminSide from './components/Admin/AdminSide.vue';
Vue.component('AdminSide', AdminSide).defaults;

import RefundNav from './views/containers/AdminNav.vue';
Vue.component('RefundNav', RefundNav).defaults;

import RefundMenu from './views/containers/AdminMenu.vue';
Vue.component('RefundMenu', RefundMenu).defaults;

import RefundBreadcrumb from './views/containers/AdminBreadcrumb.vue';
Vue.component('RefundBreadcrumb', RefundBreadcrumb).defaults;

import RefundSide from './views/containers/AdminSide.vue';
Vue.component('RefundSide', RefundSide).defaults;


//------------------------- Component ----------------
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

import CheckGap from './components/CheckGap.vue';
Vue.component('CheckGap', CheckGap).defaults;

import ThaiDate from './components/ThaiDate.vue';
Vue.component('ThaiDate', ThaiDate).defaults;

import RefundReport from './components/Refund/RefundReport.vue';
Vue.component('RefundReport', RefundReport).defaults;

import RefundReportDocList from './components/Refund/RefundReportDocList.vue';
Vue.component('RefundReportDocList', RefundReportDocList).defaults;

import SentRefund from './components/Refund/SentRefund.vue';
Vue.component('SentRefund', SentRefund).defaults;

import AdminApprove from './components/Refund/AdminApprove.vue';
//import state from 'sweetalert/typings/modules/state';
Vue.component('AdminApprove', AdminApprove).defaults;

const store = new Vuex.Store({
    state: {
        user: null,
        userToken: null,
        refund_show: null,
        office_id: null,
        refund_status: null,
        arr_refund_status: null,
        arrApproveType : [
            {text: 'อนุมัติให้ตาม', value: null},
            {text: 'มติ ครม. ว 63 ลว 2 พ.ค. 54', value: 11},
            {text: 'มติ ครม. ว 66 ลว 6 พ.ค. 54', value: 12},
            {text: 'มติ ครม. ว 72 ลว 8 มี.ค. 55', value: 13},
            {text: 'มติ ครม. ว 204 ลว 15 ส.ค. 55', value: 14},
            {text: 'มติ ครม. ว 208 ลว 27 พ.ย. 56', value: 15},
            {text: 'มติ ครม. ว 141 ลว 21 พ.ย. 57', value: 16},
            {text: 'มติ ครม. ว 272 ลว 7 ก.ย. 59', value: 17},
            {text: 'มติ ครม. ว 399 ลว 10 ส.ค. 60', value: 18},
            {text: 'มติ ครม. ว 165 ลว 26 เม.ย. 62', value: 19},
            {text: 'ระเบียบพัสดุ 2535 ข้อ 136', value: 21},
            {text: 'ระเบียบพัสดุ 2535 ข้อ 139 (1)', value: 24},
            {text: 'ระเบียบพัสดุ 2535 ข้อ 139 (2)', value: 22},
            {text: 'ระเบียบพัสดุ 2535 ข้อ 139 (3)', value: 23},
            {text: 'พรบ. จัดซื้อจัดจ้าง ปี 2560 มาตรา 97', value: 34},
            {text: 'พรบ. จัดซื้อจัดจ้าง ปี 2560 มาตรา 102 (1)', value: 30},
            {text: 'พรบ. จัดซื้อจัดจ้าง ปี 2560 มาตรา 102 (2)', value: 31},
            {text: 'พรบ. จัดซื้อจัดจ้าง ปี 2560 มาตรา 102 (3)', value: 32},
            {text: 'ระเบียบ ข้อบังคับ ข้อบัญญัติ ว่าด้วยการพัสดุของหน่วยงานนั้นๆ', value: 99}
        ],
        current_page: null,
        per_page: null,
        refund_contract_no: null,
        refund_filter: []
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
        },
        refund_status (state){
            if (state.refund_status){
                return state.refund_status
            }
        },
        arr_refund_status (state){
            state.arr_refund_status = [
                {
                    status : [1],
                    class_name: 'new',
                    show: ['user'],
                    text : 'ตรวจสอบหลักเกณฑ์',
                    icon: 'icon-magic-wand icon_warning',
                    color: 'icon_warning',
                    count: 0
                },
                {
                    status : [2,3,4,5,6,7],
                    class_name: 'info',
                    show: ['user'],
                    text : 'อยู่ระหว่างบันทึกข้อมูล',
                    icon: 'icon-pencil icon_primary',
                    color: 'icon_primary',
                    count: 0
                },
                {
                    status : [8],
                    class_name: {'user':'success','admin':'stanby'},
                    show: ['user','admin'],
                    text : { 'user':'ส่งข้อมูลแล้ว','admin':'อยู่ระหว่างรอรับเรื่อง'},
                    icon: {'user':'fas fa-paper-plane icon_success','admin':'fas fa-paper-plane icon_warning'},
                    color: {'user':'icon_success','admin':'icon_warning'},
                    count: 0
                },
                {
                    status : [9],
                    class_name: 'consider',
                    show: ['user','admin'],
                    text : 'อยู่ระหว่างพิจารณา',
                    icon: 'icon-note icon_consider',
                    color: 'icon_consider',
                    count: 0
                },
                {
                    status : [11],
                    class_name: 'wait',
                    show: ['user','admin'],
                    text : 'รอเอกสารเพิ่มเติม',
                    icon: 'fas fa-reply icon_wait',
                    color: 'icon_wait',
                    count: 0
                },
                {
                    status : [88],
                    class_name: 'reject',
                    show: ['user','admin'],
                    text : 'ไม่อนุมัติ',
                    icon: 'fas fa-sign-out-alt icon_reject',
                    color: 'icon_reject',
                    count: 0
                },
                {
                    status : [99],
                    class_name: 'complete',
                    show: ['user','admin'],
                    text : 'อนุมัติ',
                    icon: 'fas fa-check icon_complete',
                    color: 'icon_complete',
                    count: 0
                },
            ]
            return state.arr_refund_status
        },
        arrApproveType (state) {
            return state.arrApproveType
        },
        current_page (state){
            return state.current_page
        },
        per_page (state){
            return state.per_page
        },
        refund_contract_no (state){
            return state.refund_contract_no
        },
        refund_filter (state){
            return state.refund_filter
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
            state.office_id = null
            state.refund_show = null

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
        },
        refund_status (state,value){
            state.refund_status = value
        },
        current_page (state, value){
            state.current_page = value
        },
        per_page (state, value){
            state.per_page = value
        },
        refund_contract_no (state, value){
            state.refund_contract_no = value
        },
        refund_filter (state, value){
            state.refund_filter = value
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
            }else{
                return
            }
        },
        logout({ commit }){
            commit('clearAuthData')
            localStorage.removeItem('token')
            router.push('/login')
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
