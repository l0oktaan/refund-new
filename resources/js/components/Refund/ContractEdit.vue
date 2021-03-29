<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
        <b-row>
            <b-col>
                <div>
                    <span class="edit_contract">
                        <span style="color:#000;">มีการเปลี่ยนแปลงวงเงินค่าจ้างและอัตราค่าปรับ : </span><toggle-button :value = "false" :sync = "true" :width="60" :height="25"
                            :labels="{checked: 'มี', unchecked: 'ไม่มี'}"
                            :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                            style="padding-top:4px; line-height:0px;"
                            :disabled="isDisable"
                            v-model="isEdit"
                        />
                    </span>
                </div>
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <b-form class="frm"  @submit="SubmitContractEdit" v-if="isEdit && !isDisable">
                    <b-card no-body class="bg-primary">
                        <b-card-body class="pb-0 list ">
                        <b-row>
                                <b-col>
                                    <h5><i class='fas fa-edit'></i> รายละเอียดการแก้ไขสัญญา <span class="detail"> (เฉพาะที่เปลี่ยนแปลงวงเงินค่าจ้างและอัตราค่าปรับ)</span></h5>
                                </b-col>
                        </b-row>
                            <b-row>
                                <b-col sm="4">
                                    <!-- <b-form-group>
                                        <label for="contract_edit_order">หนังสือลงวันที่ :</label>
                                        <b-form-input type="text"
                                            placeholder="ครั้งที่"
                                            name="contract_edit_order"
                                        >
                                        </b-form-input>
                                    </b-form-group> -->
                                    <b-form-group>
                                        <label for="edit_date">หนังสือลงวันที่ : <span class="require"> *</span></label>
                                        <my-date-picker ref="edit_date" :id="11" :showDate="date_show" @update="value => edit_date = value"></my-date-picker>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="4">

                                    <b-form-group>
                                        <label for="budget_new">แก้ไขวงเงินค่าจ้างเป็น : <span class="require"> *</span></label>
                                        <cleave placeholder="วงเงินใหม่" name="budget_new" v-model="contract_edit.budget_new" class="form-control" :options="cleave_options.number"></cleave>
                                        <!-- <b-form-input type="text"
                                            placeholder="วงเงินใหม่"
                                            name="budget_new"
                                            v-model="contract_edit.budget_new"
                                        >


                                        </b-form-input>-->
                                    </b-form-group>
                                </b-col>
                                <b-col sm="4">
                                    <b-form-group>
                                        <label for="penalty_new">ค่าปรับเป็น : <span class="require"> *</span></label>
                                        <cleave placeholder="ค่าปรับใหม่" name="penalty_new" v-model="contract_edit.penalty_new" class="form-control" :options="cleave_options.number"></cleave>
                                        <!-- <b-form-input type="text"
                                            placeholder="ค่าปรับใหม่"
                                            name="penalty_new"
                                            v-model="contract_edit.penalty_new"
                                        >
                                        </b-form-input> -->
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>

                                    <div class="text-center" style="margin-bottom:5px;">
                                        <b-button type="submit" variant="dark" :disabled="isDisable">บันทึกข้อมูล</b-button>
                                        <b-button type="reset" variant="danger" @click="clearData" >ยกเลิก</b-button>
                                    </div>
                                </b-col>
                            </b-row>
                        </b-card-body>
                    </b-card>
                </b-form>
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <!-- ======================= Contract Edit List ========================================-->
                <table class="table table-hover" v-if="contract_edit_list.length > 0">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="width: 20%">หนังสือลงวันที่</th>
                            <th scope="col" style="width: 30%">วงเงินใหม่</th>
                            <th scope="col" style="width: 30%">ค่าปรับใหม่</th>
                            <th scope="col" style="width: 20%">การดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,index) in contract_edit_list" :key="index">
                            <td>{{getThaiDate(item.contract_edit_date)}}</td>
                            <td>{{item.budget_new | numeral('0,0.00') }}</td>
                            <td>{{item.penalty_new | numeral('0,0.00') }}</td>
                            <td>
                                <b-button :disabled="isDisable" :id="'btnEdit'+item.id" class="tools" size="sm" variant="outline-primary" @click="toEdit(item)"><i class="fas fa-edit"></i></b-button>
                                <b-tooltip :target="'btnEdit'+item.id" triggers="hover" placement="left">
                                    แก้ไขข้อมูล
                                </b-tooltip>

                                <b-button :disabled="isDisable" :id="'btnDel'+item.id" class="tools" size="sm" variant="outline-danger" @click="toDel(item)"><i class="fas fa-trash"></i></b-button>
                                <b-tooltip :target="'btnDel'+item.id" triggers="hover" placement="left">
                                    ลบข้อมูล
                                </b-tooltip>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </b-col>
        </b-row>



    </div>
</template>
<script>
import moment from 'moment'
export default{
    props : ['office_id'],
    data(){
        return {
            refund_id: this.$route.params.id,
            //office_id: this.$store.getters.office_id,
            date_show: '',
            edit_date: '',
            contract_edit_list: [],
            alert: '',
            contract_edit: {},
            state : 'new',
            cleave_options:{
                number: {
                    prefix: '',
                    numeral: true,
                    numeralPositiveOnly: true,
                    noImmediatePrefix: true,
                    rawValueTrimPrefix: true,
                    numeralIntegerScale: 15,
                    numeralDecimalScale: 2,

                },
            },
            isEdit: false,
            refund_status: this.$store.getters.refund_status
        }
    },
    mounted(){
        this.fetchContractEdit();
    },
    computed: {
        isDisable(){
            console.log('status :' + this.refund_status);
            return (this.refund_status > 7 && this.refund_status != 11) && this.$store.getters.user.type != 'admin' ? true : false
        }
    },
    watch: {
        isEdit(newVal, oldVal){
            if (newVal == false){
                if (this.contract_edit_list.length > 0){
                    this.$nextTick(()=>{
                        this.isEdit = oldVal
                    })

                }
            }
        }
    },
    filters: {

    },

    methods: {

        SubmitContractEdit(e){
            e.preventDefault();
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/contract_budget_edits`;
            console.log('edit path : ' + path);
            if (this.state == 'new'){
                axios.post(`${path}`,{
                    budget_new: this.contract_edit.budget_new,
                    penalty_new: this.contract_edit.penalty_new,
                    contract_edit_date: this.edit_date
                })
                .then(response=>{

                    //this.state = 'update';
                    //this.contract_edit = response.data.data;
                    //this.toEdit(this.contract_edit);
                    this.alert = "success";
                    this.clearData();
                    //this.clearData();
                    this.fetchContractEdit();

                })
                .catch(error=>{
                    this.alert = "error";
                })
            }else if (this.state == 'update'){
                axios.put(`${path}/${this.contract_edit.id}`,{
                    budget_new: this.contract_edit.budget_new,
                    penalty_new: this.contract_edit.penalty_new,
                    contract_edit_date: this.edit_date
                })
                .then(response=>{

                    //this.state = 'update';
                    //this.contract_edit = response.data.data;
                    //this.toEdit(this.contract_edit);
                    this.alert = "success";
                    this.clearData();
                    //this.clearData();
                    this.fetchContractEdit();
                })
                .catch(error=>{
                    this.alert = "error";
                })
            }
        },
        fetchContractEdit(){
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/contract_budget_edits`;
            axios.get(`${path}`)
            .then(response=>{
                this.contract_edit_list = response.data.data;
                (this.contract_edit_list.length > 0) ? this.isEdit = true : this.isEdit = false;
                this.$forceUpdate();
            })
            .catch(error=>{
                console.log('edit contract error :' + error);
            })
        },
        toDel(contract_edit){
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/contract_budget_edits/${contract_edit.id}`;
            this.$swal({
                    title: "กรุณายืนยัน",
                    text: `คุณต้องการลบข้อมูล การแก้ไขสัญญาหรือไม่`,
                    icon: "warning",
                    closeOnClickOutside: false,
                    buttons: [
                        'ยกเลิก',
                        'ยืนยัน'
                    ],
                })
                .then(isConfirm =>{
                    if (isConfirm){
                        console.log('delete : ' + path);
                        axios.delete(`${path}`)
                        .then(response=>{
                            console.log(response.data);
                            this.clearData();
                            this.fetchContractEdit();
                            this.alert = "success";
                        })
                        .catch(error=>{
                            this.alert = "error";
                        })
                    }

                })
        },
        toEdit(contract_edit){
            //console.log('edit edit');
            this.contract_edit = contract_edit;
            this.date_show = contract_edit.contract_edit_date;
            this.state = 'update';
            this.$forceUpdate();
        },
        clearData(){
            this.contract_edit = {};
            this.date_show = '';
            this.state = 'new';
            if (this.contract_edit_list.length <= 0) {
                this.isEdit = false;
            }
            this.$forceUpdate();
        },
        getThaiDate(value){
            var d = new Date(value);
            return d.toLocaleDateString('th-TH', { day: 'numeric', month: 'long', year: 'numeric' });
            //return moment(String(value)).format('LL')
        }
    }
}
</script>
<style scoped>

.description{
    font-size: 0.8em!important;
    color: rgb(49, 49, 49);
    margin-left: 20px;
}

.btn{
    padding-top: 5px!important;
    padding-bottom: 5px!important;
    vertical-align: middle!important;
}
.card-header{
    padding: 5px!important;
}
.list{
    padding: 10px!important;

}
.btn-transparent{
    color: black!important;
}
.dropdown-item i{
    color: black!important;
}
.edit_list{
    background-color: rgb(176, 243, 248);
    margin-bottom: 5px!important;
}
.item_select{
    background-color: rgb(247, 230, 158);
    margin-bottom: 5px!important;
}
.dropdown-item{
    color: black!important;
}
.fieldName{
    color: rgb(4, 30, 53);
    font-weight: bold;
}
.unit{
    color: rgb(154, 156, 158);
    font-weight: bold;
    padding-left: 5px;
}
.detail{
    font-size: 0.9rem!important;
}
.frm{
    margin-top: 10px!important;
}
.edit_contract{


    margin-bottom: 10px;
    padding: 10px 20px 10px 20px;
    border-radius: 5px;
    background-color: rgb(255, 175, 83);
}
.table{
    margin-top: 10px;;
}
</style>
