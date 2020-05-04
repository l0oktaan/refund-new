import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

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

// import App from './views/App.vue'
// import Home from './views/Home.vue'
// import Login from './views/Login.vue'
// import Refund from './views/Refund.vue'
// import RefundDashboard from './views/Dashboard.vue'
// import Office from './views/Office.vue'
// import RefundList from './views/RefundList.vue'
// import RefundForm from './views/RefundForm.vue'
// import RefundDetail from './views/RefundDetail.vue'
// import RefundFormCheck from './views/RefundFormCheck.vue'
// import RefundFormTest from './views/RefundFormTest.vue'

// import Admin from './views/Admin/Admin'
// import AdminIndex from './views/Admin/AdminIndex'

// import AdminRefundList from './views/Admin/Refund/AdminRefundList'
// import FormIndex from './views/Admin/Form/FormIndex'

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

router.beforeEach((to, from, next) => {
    if (to.fullPath !== "/login") {
        axios.get('/api/profile')
        .then(response => {
            console.log('next page' + response.data);
            next();
        }).catch(error => {
            router.push('/login');
        })
    } else {
        next();
    }
})

export default new VueRouter({mode: 'history', router})
