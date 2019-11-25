<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
        <h4>ข้อมูลการถอนคืนเงินรายได้</h4>
        <b-tabs v-model="tabIndex">

            <!--================================= Tab Form ==================================-->
            <b-tab v-for="(tab,index) in tab_forms" :key="index" >
                <template slot="title">
                <h5>แบบฟอร์ม :<i :class="tab.status == 1 ? icon_check : icon_uncheck"></i></h5>
                <span>{{tab.title}}</span>
              </template>
                  <refund-check :form_id="refund_forms[index].form_id" :refund_id="refund_id"></refund-check>
            </b-tab>
            <!--==================================== Tab Form End =====================================-->
            <b-tab v-if="isPass" >
                <template slot="title">
                    <h5>ขั้นตอนที่ 1 : <i :class="tabs[1].status == 1 ? icon_check : icon_uncheck"></i></h5>
                    <span>{{tabs[1].title}}</span>
                </template>
                <contract-form></contract-form>
            </b-tab>
            <b-tab v-if="isPass" >
                <template slot="title">
                    <h5>ขั้นตอนที่ 2 : <i :class="tabs[2].status == 1 ? icon_check : icon_uncheck"></i></h5>
                    <span>{{tabs[2].title}}</span>
                </template>
                <contract-time-edit></contract-time-edit>

            </b-tab>

            <b-tab v-if="isPass">
                <template slot="title">
                    <h5>ขั้นตอนที่ 3 : <i :class="tabs[3].status == 1 ? icon_check : icon_uncheck"></i></h5>
                    <span>{{tabs[3].title}}</span>
                </template>
                <delivery :refund_id="refund_id"></delivery>

            </b-tab>
            <b-tab v-if="isPass">
                <template slot="title">
                    <h5>ขั้นตอนที่ 4 : <i :class="tabs[4].status == 1 ? icon_check : icon_uncheck"></i></h5>
                    <span>{{tabs[4].title}}</span>
                </template>

                <deposit-penalty :refund_id="refund_id"></deposit-penalty>
            </b-tab>
            <b-tab v-if="isPass">
                <template slot="title">
                    <h5>สรุปข้อมูล : <i :class="tabs[2].status == 1 ? icon_check : icon_uncheck"></i></h5>
                    <span>{{tabs[3].title}}</span>
                </template>
                <refund-summary  :refund_id="refund_id"></refund-summary>
            </b-tab>
          </b-tabs>
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
                {title: 'จำนวนเงินที่ขออนุมัติ', status: 0},

            ],
            tab_forms: [],
            forms: [],
            arrFormSelected: [],
            isSelect: [],
            r_id: 0,
            refund_id : this.$route.params.id,
            form_id : this.$route.params.id,
            form_id: 0,
            office_id: 2,

            refund_status: 'new',
            refund_forms: [],
            alert: '',
            icon_check: 'far fa-check-square fa-lg',
            icon_uncheck: 'far fa-square fa-lg',
            isPass: false
        }
    },
    watch: {
        refund_id(){
            if (this.refund_id != 0){
                this.r_id = this.refund_id;
                this.refund_status = "edit"
            }
        },
        tabIndex(){
            console.log('tab index :' + this.tabIndex);
        }
    },
    computed : {
        form_tabs(){
            if (this.tabs.length > 3){
                return this.tabs.splice(0,3);
            }else{
                return [];
            }

        }
    },
    mounted(){
        this.getRefundForm();
        this.tabIndex = 3;
        this.$forceUpdate();

    },
    methods: {
        getForm(){
            var path = '/api/forms';
            var forms = [];
            axios.get(path)
            .then(response=>{
                forms = response.data.data;
                this.forms = forms;
                this.createArray();
                console.log('form :' + forms.length);
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
                            title : 'ฟอร์มหมายเลข :' + this.refund_forms[i]['form'].order,
                            status : 0
                        }
                    );

                }


                this.tab_forms = tabs;
                this.refund_forms = arr;
                this.tabIndex = 0;

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
            console.log('create array');
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
        saveRefundForm(){

            if (this.arrFormSelected.length > 0 && this.refund_status == 'new'){
                this.$swal({
                    title: "กรุณาตรวจสอบข้อมูล",
                    text: "หากบันทึกแล้วจะไม่สามารถเพิ่มฟอร์มใหม่ได้",
                    icon: "warning",
                    closeOnClickOutside: false,
                    buttons: [
                        'ยกเลิก',
                        'ยืนยัน'
                    ],

                }).then(isConfirm =>{
                    if (isConfirm){

                        var refund = {};
                        var path = '';
                        // Create Refund
                        path = `/api/offices/${this.office_id}/refunds`;
                        axios.post(`${path}`,{
                            approve_code: '123456'
                        })
                        .then(response=>{
                            refund = response.data.data;
                            this.refund_id = refund.id;
                            this.refund_status = 'update';
                            for (let i = 0 ; i < this.arrFormSelected.length ; i++){
                                path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms`;
                                axios.post(path,{
                                    form_id: this.arrFormSelected[i].id,
                                    result: 0,
                                    status: 0
                                })
                                .then(response=>{
                                    this.refund_forms.push(response.data.data);
                                    var arr = this.refund_forms;
                                    this.refund_forms.forEach(function(element,index,arr){
                                        Object.assign(arr[index],{result: false});

                                    });
                                    this.refund_forms = arr;

                                    this.tab_forms.push(
                                        {
                                            title : 'ฟอร์มหมายเลข :' + this.arrFormSelected[i].order,
                                            status : 0
                                        }
                                    );

                                    this.$forceUpdate();
                                })
                                .catch(error=>{
                                    this.alert = 'error';
                                })

                            }
                            if (this.arrFormSelected.length > 0){
                                //console.log('array ' + this.arrFormSelected.length);
                                this.alert = 'success';
                                this.tabs[0].status = 1;


                                this.$forceUpdate();

                            }
                            setInterval(function(){
                                this.tabIndex = 1;

                                console.log("tab Index   :" + this.tabIndex);
                            },3000);

                        })
                        .catch(error=>{
                            this.alert = 'error';
                        })
                    }

                });

            }else{

            }
        },
        onTabChange(value){
            console.log('tab :' + value);
        }
    }
}
</script>
<style scoped>
.tabTitle{
    font-size: 1rem;
    font-weight: bold;
}
.nav-link{
    padding-top: 10px!important;
}

</style>
