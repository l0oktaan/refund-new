<template>
<header class="app-header navbar">
        <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <router-link to="/refund" class="navbar-brand">
            <img class="navbar-brand-full" src="/images/refund.png" width="135" alt="CGD Refund">
            <img class="navbar-brand-minimized" src="/images/refund.png" width="30" height="30" alt="CGD Refund">
        </router-link>
        <!-- <a  href="/refund">
            <img class="navbar-brand-full" src="/images/refund.png" width="135" alt="CGD Refund">
            <img class="navbar-brand-minimized" src="/images/refund.png" width="30" height="30" alt="CGD Refund">
        </a> -->
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
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
        </ul>
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item dropdown d-md-down-none">
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
                
            </li>
            <li class="nav-item dropdown d-md-down-none">
                <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="icon-envelope-letter"></i>
                <span class="badge badge-pill badge-info">7</span>
                </a>
                
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <h4>{{getUser}}</h4>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Account</strong>
                    </div>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-edit"></i> แก้ไขข้อมูล
                        
                    </a>
                    <a class="dropdown-item" href="#" @click="logout">
                        <i class="fas fa-sign-out-alt"></i> ออกจากระบบ
                        
                    </a>
                    
                </div>
            </li>
        </ul>
        <button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" data-toggle="aside-menu-lg-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <button class="navbar-toggler aside-menu-toggler d-lg-none" type="button" data-toggle="aside-menu-show">
            <span class="navbar-toggler-icon"></span>
        </button>
    </header>

</template>

<script>
export default {
    data(){
        return{
            user: 'user'
        }
    },
    computed: {
        getUser(){
            return this.$store.state.user;
        }
    },
    mounted(){
        this.user = this.$store.state.user;
    },
    methods: {
        logout(){
            this.$store.state.user = '';
            this.$router.push('/');
        }
    }
}
</script>
