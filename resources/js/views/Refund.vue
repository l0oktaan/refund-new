<template>
    <div  class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
        <refund-nav></refund-nav>
        <div class="app-body" id="app">
            <refund-menu></refund-menu>

            <main class="main">
                <refund-breadcrumb></refund-breadcrumb>
                <div class="container-fluid">
                    <div class="animated fadeIn">
                    <!--  @yield('content') -->
                        <router-view></router-view>
                    </div>
                </div>
            </main>
            <!-- <refund-side></refund-side> -->
        </div> <!-- End app-body -->
        <footer class="app-footer">
            <div>
                <span>สงวนลิขสิทธิ์ &copy; 2022 The Comptroller General's Department </span>
            </div>
            <div class="ml-auto">
                <span>Powered by</span>
                <a href="https://www.cgd.go.th">IT@CGD</a>
            </div>
        </footer>
    </div>
</template>
<script>

export default{

    data(){
        return {
            items: [
                {
                    name: 'Dashboard',
                    url: '/dashboard',
                    icon: 'icon-speedometer',
                    badge: {
                        variant: 'primary',
                        text: 'NEW'
                    }
                },
            ],
        }
    }
}
</script>

