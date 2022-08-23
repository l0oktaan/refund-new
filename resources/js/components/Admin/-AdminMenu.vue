<template>
     <!-- Sidebar -->
            <div class="sidebar">
                <nav class="sidebar-nav">
                    <ul class="nav">
                        
                        <b-nav vertical>
                            <b-nav-item  to="/admin"><i class="fas fa-globe"></i>&nbsp;Dashboard</b-nav-item>
                            <b-nav-item  to="/admin/form"><i class="fa fa-align-justify" aria-hidden="true"></i>&nbsp;จัดการแบบฟอร์ม</b-nav-item>
                            <b-nav-item  to="/admin/refunds"><i class="fas fa-flag" aria-hidden="true"></i>&nbsp;รายการขอถอนคืน</b-nav-item>
                            <b-nav-item  to="/admin/limits"><i class="fas fa-flag" aria-hidden="true"></i>&nbsp;การควบคุมยอดการนำส่ง-ถอนคืน</b-nav-item>
</b-nav>


                        <li class="nav-item mt-auto">
                            <a class="nav-link nav-link-success" href="https://coreui.io" target="_top">
                                    <i class="nav-icon cui-cloud-download"></i> Download CoreUI</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-danger" href="https://coreui.io/pro/" target="_top">
                                    <i class="nav-icon cui-layers"></i> Try CoreUI
                                    <strong>PRO</strong>
                                    </a>
                        </li>
                    </ul>
                </nav>
            </div>

</template>
<style scoped>


</style>
