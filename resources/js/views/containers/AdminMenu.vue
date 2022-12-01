<template>
     <!-- Sidebar -->
            <div class="sidebar">
                <nav class="sidebar-nav">
                    <ul class="nav">
                        <!-- <li class="nav-item  nav-dropdown  ">
                            <a class="nav-link  nav-dropdown-toggle " href="#">
                                    เริ่มต้น
                                    </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item ">
                                    <a class="nav-link" href="https://coreui.io/docs/getting-started/ui-kit/">
                                            UI Kit
                                            </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="https://coreui.io/docs/getting-started/introduction/">
                                            Introduction
                                            </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="https://coreui.io/docs/getting-started/browsers-devices/">
                                            Browsers & devices
                                            </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="https://coreui.io/docs/getting-started/javascript/">
                                            JavaScript
                                            </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="https://coreui.io/docs/getting-started/build-tools/">
                                            Build tools
                                            </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="https://coreui.io/docs/getting-started/webpack/">
                                            Webpack
                                            </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="https://coreui.io/docs/getting-started/accessibility/">
                                            Accessibility
                                            </a>
                                </li>
                            </ul>
                        </li> -->
                        <b-nav vertical v-if="user.type=='admin'">
                            <!-- <b-nav-item  to="/admin"><i class="fas fa-globe"></i>&nbsp;Dashboard</b-nav-item> -->
                            <b-nav-item  to="/admin/users"><i class="fas fa-user-friends" aria-hidden="true"></i>&nbsp;จัดการผู้ใช้</b-nav-item>
                            <b-nav-item  to="/admin/form"><i class="fa fa-align-justify" aria-hidden="true"></i>&nbsp;จัดการแบบฟอร์ม</b-nav-item>
                            <b-nav-item  to="/admin/refunds"><i class="fas fa-flag" aria-hidden="true"></i>&nbsp;รายการขอถอนคืน</b-nav-item>
                            <b-nav-item  to="/admin/control"><i class="fas fa-dollar-sign" aria-hidden="true"></i>&nbsp;การควบคุมยอดนำส่ง-ถอนคืน</b-nav-item>
                        </b-nav>

                        <b-nav vertical v-if="user.type=='user'">
                            <b-nav-item v-for="(lMenu,index) in leftMenu" :key="index"  :to="lMenu.path"><i :class="lMenu.icon"></i>&nbsp;{{lMenu.menu}}</b-nav-item>
                            <!-- <li ><i class="fas fa-download"></i>&nbsp;คู่มือการใช้ระบบ</li> -->
                        </b-nav>


                        <li class="nav-item mt-auto" @click="download">
                            <a class="nav-link  link-download" href="#">
                                <i class="fas fa-download mr-2"></i>แนวปฏิบัติในการบันทึกฯ</a>
                        </li>
                        <li class="nav-item" @click="line_dialog=true">
                            <a class="nav-link  link-download line nav-link-success" href="#">
                                <i class="fab fa-line fa-lg mr-2"></i>แจ้งปัญหาการใช้งาน</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link nav-link-danger" href="https://coreui.io/pro/" target="_top">
                                    <i class="fab fa-line mr-2"></i>แจ้งปัญหาการใช้งาน</a>
                        </li> -->
                    </ul>
                </nav>
                <b-modal v-model="line_dialog"
                    title="ช่องทางในการแจ้งปัญหาการใช้งาน"
                    hide-footer="true"
                >
                    <b-row>
                        <b-col cols="2">e-Mail :</b-col>
                        <b-col>e-withdraw@cgd.go.th</b-col>
                    </b-row>
                    <b-row>
                        <b-col cols="2">Line ID :</b-col>
                        <b-col>@007qgnam</b-col>
                    </b-row>
                    <b-row>
                        <b-col cols="2"></b-col>
                        <b-col><img src="/images/qrcode.png" width="200px" alt="Scan QR Code"></b-col>
                    </b-row>
                    <b-row>
                        <b-col cols="2"></b-col>
                        <b-col><a target="_blank" href="https://lin.ee/r25zOTy"><img src="/images/linebtn.png" width="100px" alt="เพิ่มเพื่อน"></a></b-col>
                    </b-row>
                </b-modal>
            </div>
</template>
<script>
export default {
    data(){
        return {
            user: this.$store.getters.user,
            leftMenu: [
                // {menu: 'Dashboard', path: '/refund', icon: 'fas fa-globe'},
                {menu: 'การถอนคืนฯ', path: '/refund/refunds', icon: 'fa fa-align-justify'},
                {menu: 'ข้อมูลหน่วยงาน', path: '/refund/office', icon: 'fa fa-university'},
            ],
            line_dialog: false
        }
    },
    methods:{
        download(){        
            let path = `/api/user_manual`;
            axios({
                url : `${path}`,
                methods : 'GET',
                responseType : 'blob'
            })
            .then(response=>{
                var fileURL = window.URL.createObjectURL(new Blob([response.data], { type: 'application/pdf' }));
                
                var fileLink = document.createElement('a');
                fileLink.href = fileURL;
                let filename = "e-withdraw_user_manual.pdf";
                fileLink.setAttribute('download', filename);
                document.body.appendChild(fileLink);
                window.open(fileLink, "_blank");
                        
            })
            .catch(error=>{
                console.log(error)
            })           
        },
    }
}
</script>
<style scoped>
.router-link-exact-active{

    background-color: rgb(85, 85, 85)!important;
}
.link-download
{
    background-color: #20a8d8;
}
.link-download:hover{
    background-color: #20a8d8!important;
    box-shadow: rgba(0, 0, 0, 0.35) 0px -50px 36px -28px inset;
}
.link-download.line:hover{
    background-color: #0ea009!important;
    box-shadow: rgba(0, 0, 0, 0.35) 0px -50px 36px -28px inset;
}
</style>
