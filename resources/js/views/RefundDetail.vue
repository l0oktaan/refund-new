<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
        <h4>ข้อมูลการถอนคืนเงินรายได้</h4>
        <b-tabs v-model="tabIndex" active-tab-class="tab-active" id="tabs-status">
            <!--================================= Tab Form ==================================-->
            <b-tab v-for="(tab,index) in tab_forms" :key="index" :disable="'disabled'">
                <template slot="title">
                    <h6>ขั้นตอนที่ 1 :<i :class="refund_s > 1 ? icon_check : icon_uncheck"></i></h6>
                    <span>หลักเกณฑ์และเงื่อนไข</span>
                </template>
                  <refund-check :form_id="refund_forms[index].form_id"
                    :refund_id="refund_id"
                    :refund_form_id="refund_forms[index].id"
                    @showTabs="showTabs"
                    @refund_update="checkRefundStatus"
                    :office_id = "office_id"
                >
                </refund-check>
            </b-tab>
            <!--==================================== Tab Form End =====================================-->
            <!--==================================== Tab  =====================================-->
            <b-tab v-if="refund_s >= 2" :disabled="refund_s < 2">
                <template slot="title">
                    <h6>ขั้นตอนที่ 2 : <i :class="refund_s > 2 ? icon_check : icon_uncheck"></i></h6>
                    <span>{{tabs[1].title}}</span>
                </template>
                <contract-form @refund_update="checkRefundStatus" :office_id = "office_id"></contract-form>
            </b-tab>
            <b-tab v-if="refund_s >= 2" :disabled="refund_s < 3">
                <template slot="title">
                    <h6 :class="refund_s < 3 ? 'mute' : ''">ขั้นตอนที่ 3 : <i :class="refund_s > 3 ? icon_check : icon_uncheck"></i></h6>
                    <span :class="refund_s < 3 ? 'mute' : ''">{{tabs[2].title}}</span>
                </template>
                <contract-time-edit @refund_update="checkRefundStatus" :office_id = "office_id"></contract-time-edit>
            </b-tab>
            <b-tab v-if="refund_s >= 2" :disabled="refund_s < 3">
                <template slot="title">
                    <h6 :class="refund_s < 3 ? 'mute' : ''">ขั้นตอนที่ 4 : <i :class="refund_s > 4 ? icon_check : icon_uncheck"></i></h6>
                    <span :class="refund_s < 3 ? 'mute' : ''">ข้อมูลการส่งมอบงาน</span>
                </template>
                <delivery :refund_id="refund_id" @refund_update="checkRefundStatus" :office_id = "office_id"></delivery>

            </b-tab>
            <b-tab v-if="refund_s >= 2" :disabled="refund_s < 5">
                <template slot="title">
                    <h6 :class="refund_s < 5 ? 'mute' : ''">ขั้นตอนที่ 5 : <i :class="refund_s > 5 ? icon_check : icon_uncheck"></i></h6>
                    <span :class="refund_s < 5 ? 'mute' : ''">การนำส่งเงินค่าปรับ</span>
                </template>

                <deposit-penalty :refund_id="refund_id" @refund_update="checkRefundStatus" :office_id = "office_id"></deposit-penalty>
            </b-tab>
            <b-tab v-if="refund_s >= 2" :disabled="refund_s < 6">
                <template slot="title">
                    <h6 :class="refund_s < 6 ? 'mute' : ''">ขั้นตอนที่ 6 : <i :class="refund_s > 6 ? icon_check : icon_uncheck"></i></h6>
                    <span :class="refund_s < 6 ? 'mute' : ''">สรุปข้อมูลการขออนุมัติ</span>
                </template>
                <refund-summary :refund_id="refund_id" @refund_update="checkRefundStatus" :office_id = "office_id"></refund-summary>
            </b-tab>
            <b-tab v-if="refund_s >= 2" :disabled="refund_s < 7">
                <template slot="title">
                    <h6 :class="refund_s < 7 ? 'mute' : ''">ขั้นตอนที่ 7 : <i :class="refund_s > 7 ? icon_check : icon_uncheck"></i></h6>
                    <span :class="refund_s < 7 ? 'mute' : ''">พิมพ์รายงานและส่งข้อมูล</span>
                </template>
                <sent-refund :refund_status="refund_s" :refund_id="refund_id" @refund_update="checkRefundStatus" :office_id = "office_id"></sent-refund>
            </b-tab>
            <!-- <b-tab v-if="isAdmin">
                <template slot="title">
                    <h6>ผลการตรวจสอบ : <i :class="refund_s > 8 ? icon_check : icon_uncheck"></i></h6>
                    <span>บันทึกผลการตรวจสอบ</span>
                </template>
                <admin-approve :refund_status="refund_s" :refund_id="refund_id" :office_id = "office_id" @refund_update="checkRefundStatus"></admin-approve>
            </b-tab> -->
            <!--==================================== Tab End =====================================-->
            <!-- <b-tab>
                <template slot="title">
                    <h6>ผลการตรวจสอบ : </h6>
                    <span>บันทึกผลการตรวจสอบ</span>
                </template>
                <refund-report :refund_id="50" :refund_form_id="65"></refund-report>
            </b-tab> -->
          </b-tabs>
          <div class="text-center" style="margin-top: 10px;" v-if="refund_s>1">

                    <b-button variant="success" @click="tabIndex--" :disabled="(tabIndex == 0) ? true : false"><i class="fas fa-step-backward"></i></b-button>
                    <span>เปลี่ยนหน้า</span>
                    <b-button variant="success" @click="tabIndex++" :disabled="(tabIndex == (tabs.length + tab_forms.length)-1) ? true : false"><i class="fas fa-step-forward"></i></b-button>


        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            tabIndex: 0,
            tabs: [
                {title: 'เลือกแบบฟอร์มขอถอนคืน', status: 0},
                {title: 'ข้อมูลสัญญา', status: 0},
                {title: 'ข้อมูลการอนุมัติ งด/ลด/ขยายเวลา', status: 0},
                {title: 'ข้อมูลการส่งมอบงาน', status: 0},
                {title: 'การนำส่งเงินค่าปรับ', status: 0},
                {title: 'การขออนุมัติ', status: 0},
            ],
            tab_forms: [],
            forms: [],
            arrFormSelected: [],
            isSelect: [],
            r_id: 0,
            refund_id : this.$route.params.id,
            form_id : this.$route.params.id,
            form_id: 0,
            office_id: 0,//this.$store.getters.office_id,
            refund_status: 'new',
            refund_forms: [],
            alert: '',
            icon_check: 'far fa-check-square fa-lg',
            icon_uncheck: 'far fa-square fa-lg',
            isPass: false,
            refund_s: 0,
            hasContract: false
        }
    },
    beforeRouteLeave(to, from, next) {
        if (!this.$store.getters.refund_contract_no){
            this.$swal({
                title: "กรุณายืนยัน",
                text: "การบันทึกข้อมูลยังไม่สมบูรณ์ รายการถอนคืนจะถูกลบ",
                icon: "warning",
                closeOnClickOutside: false,
                buttons: [
                    'ยกเลิก',
                    'ยืนยัน'
                ],
            }).then(isConfirm =>{
                if (isConfirm){
                    let path = `/api/offices/${this.office_id}/refunds/${this.refund_id}`;
                    // axios.put(`${path}`,{
                    //     status : '0'
                    // })

                        axios.delete(`${path}`)
                        .then(response=>{
                            next()
                        })
                        .catch(error=>{
                            return false;
                        })
                }else{
                    return false;
                }
            });
        }else{
            this.$store.commit('refund_contract_no',null)
            next();
        }
        // next();
    },
    watch: {
        refund_id(){
            if (this.refund_id != 0){
                this.r_id = this.refund_id;
                this.refund_status = "edit";
            }
        },
        tabIndex(){
        },
    },
    computed : {
        form_tabs(){
            if (this.tabs.length > 3){
                return this.tabs.splice(0,3);
            }else{
                return [];
            }
        },
        isAdmin(){
            var path = [];
            path = this.$route.path.split("/");
            return path.indexOf('admin') > -1 ? true : false;
        }
    },
    mounted(){
        this.office_id = this.$store.getters.office_id;
        this.getRefundForm();
        //this.tabIndex = 3;
        this.$forceUpdate();
    },
    methods: {
        deleteRefund(){
            this.$swal({
                title: "กรุณายืนยัน",
                text: "การบันทึกข้อมูลยังไม่สมบูรณ์ รายการถอนคืนจะถูกลบ",
                icon: "warning",
                closeOnClickOutside: false,
                buttons: [
                    'ยกเลิก',
                    'ยืนยัน'
                ],
            }).then(isConfirm =>{
                if (isConfirm){
                    let path = `/api/offices/${this.office_id}/refunds/${this.refund_id}`;
                    // axios.put(`${path}`,{
                    //     status : '0'
                    // })
                    this.$nextTick(()=>{
                        axios.delete(`${path}`)
                        .then(response=>{
                            return true;
                        })
                        .catch(error=>{
                            return false;
                        })
                    })

                }else{
                    return false;
                }
            });
        },
        showTabs(){
            this.isPass = !this.isPass
        },
        getForm(){
            var path = '/api/forms';
            var forms = [];
            axios.get(path)
            .then(response=>{
                forms = response.data.data;
                this.forms = forms;
                this.createArray();
            })
        },
        getRefundForm(){
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms`;
            var arr = [];
            axios.get(`${path}`)
            .then(response=>{
                this.tab_forms = [];
                this.refund_forms = response.data.data;
                this.forms = this.refund_forms;
                var arr = this.refund_forms;
                var tabs = [];
                for (let i = 0 ; i < this.refund_forms.length ; i++){
                    Object.assign(arr[i],{result: false});
                    tabs.push(
                        {
                            title : this.refund_forms[i]['form'].name3,
                            status : 0
                        }
                    );
                }
                this.tab_forms = tabs;
                this.refund_forms = arr;
                this.tabIndex = 0;
                this.checkRefundStatus();
                this.$forceUpdate();
            })
        },
        confirmChange(form,index){
            let formIndex = this.arrFormSelected.findIndex(i => i.id === form.id);
            if (formIndex >= 0){
                this.arrFormSelected.splice(formIndex,1);
            }else{
                this.arrFormSelected.push(
                    {id: form.id, name: form.name1, order: form.order, selectIndex: index}
                );
            }
            this.arrFormSelected = this.sortArrays(this.arrFormSelected);
        },
        sortArrays(arr){
            return _.orderBy(arr,'order','asc');
        },
        createArray(){
            if (this.forms.length > 0){
                for (let i = 0 ; i < this.forms.length ; i++){
                    this.isSelect.push(false);
                }
            }
        },
        clearData(){
            this.tabIndex = 0;
            for (let i = 0 ; i < this.tabs.length ; i++){
                this.tabs[i].status = 0;
            }
            this.tab_forms = [];
            this.forms = [];
            this.arrFormSelected = [];
            this.isSelect = [];
            this.form_id = 0;
            this.refund_status = 'new';
        },

        async checkRefundStatus(){
            var refund = {};
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}`;
            let response = await axios.get(`${path}`);
            refund = await response.data.data[0];
            this.refund_s =  await refund.status;
            await this.$store.commit("refund_status",this.refund_s);
        },

        onTabChange(value){
        },
        checkPass(val){
            if (val == 1){
                this.isPass = true;
                this.$forceUpdate();
            }
        }
    },
    beforeDestroy(){
        this.$store.commit("refund_status",null);
    }
}
</script>
<style scoped>

.nav-tabs .nav-link{
    padding-top: 10px!important;
    color: #000!important;
}
.mute{
    color: rgb(122, 122, 122)!important;
}
</style>
