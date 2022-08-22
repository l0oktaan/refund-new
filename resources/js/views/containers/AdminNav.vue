<template>
<header class="app-header navbar">
        <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <router-link to="/refund" class="navbar-brand">
            <img class="navbar-brand-full" src="/images/logo.png" width="30px" alt="CGD Refund">
            <img class="navbar-brand-minimized" src="/images/logo.png" width="30px" height="30px" alt="CGD Refund">
            <span class="cgd">ระบบถอนคืนเงินรายได้แผ่นดิน ประเภทค่าปรับ</span>
        </router-link>
        <!-- <a  href="/refund">
            <img class="navbar-brand-full" src="/images/refund.png" width="135" alt="CGD Refund">
            <img class="navbar-brand-minimized" src="/images/refund.png" width="30" height="30" alt="CGD Refund">
        </a> -->
        <!-- <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="nav navbar-nav d-md-down-none">
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Dashboard</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Users</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Settings</a>
            </li>
        </ul> -->
        <ul class="nav navbar-nav ml-auto v-center">
            <!-- <li class="nav-item dropdown d-md-down-none">
                <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-bell"></i>
                    <span class="badge badge-pill badge-danger">5</span>
                </a>

            </li>
            <li class="nav-item dropdown d-md-down-none">
                <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-list"></i>
                    <span class="badge badge-pill badge-warning">15</span>
                </a>

            </li>-->
            <li class="nav-item">
                <span class="mr-3">{{user.name}}</span>
            </li> 
            <!-- <li class="nav-item">
                <a class="dropdown-item" href="#" @click="logout">
                    <i class="fas fa-sign-out-alt"></i> ออกจากระบบ
                </a>
            </li>  -->
            <li class="nav-item dropdown">                
                <a class="nav-link nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle fa-2x mr-2"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">     
                    <a class="dropdown-item" href="#" @click="passchange">
                        <i class="icon-key"></i> เปลี่ยนรหัสผ่าน
                    </a>               
                    <a class="dropdown-item" href="#" @click="logout">
                        <i class="fas fa-sign-out-alt"></i> ออกจากระบบ
                    </a>
                </div>
                
            </li>
            <li class="nav-item">
                <a class="dropdown-item" href="#" @click="logout">
                    <i class="fas fa-sign-out-alt"></i> ออกจากระบบ
                </a>
            </li> 
        </ul>
        <!-- <button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" data-toggle="aside-menu-lg-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <button class="navbar-toggler aside-menu-toggler d-lg-none" type="button" data-toggle="aside-menu-show">
            <span class="navbar-toggler-icon"></span>
        </button> -->
    </header>

</template>

<script>
export default {
    data(){
        return{
            user: this.$store.getters.user
        }
    },
    computed: {
        getUser(){
            return !this.$store.getters.user ? '' : this.$store.getters.user.username ;
        },
        isAdmin(){
            var path = [];
            path = this.$route.path.split("/");
            return path.indexOf('admin') > -1 ? true : false;
        }
    },
    mounted(){

    },
    methods: {
        async logout(){
            
            // return
            await this.$store.dispatch('logout');
            
        },
        passchange(){
            this.$router.push('/passchange');            
        }
    }
}
</script>
<style scoped>
.dropdown-menu, .nav-link{
    margin-right: 15px!important;
}

.nav-item{
    display: inline-block;
    vertical-align: middle;
}
.navbar-brand {
    width: 350px!important;
}
.navbar-brand > img{
    margin-left: 10px!important;
}
.cgd{
    color: #023e8f!important;
    margin-left: 10px;
}
</style>
