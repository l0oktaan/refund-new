<template>
    <div class="card animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
        <b-row>
            <b-col sm="5">
                <div class="edit_schedule">                    
                        <h6 style="color:#000;"><i class='far fa-calendar-alt fa-2x'></i>  มีการแก้ไขวันเริ่มต้น/วันสิ้นสุดสัญญา : </h6>
                        <toggle-button :value = "false" :sync = "true" :width="60" :height="25"
                            :labels="{checked: 'มี', unchecked: 'ไม่มี'}"
                            :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                            style="padding-top:4px; line-height:0px;"
                            :disabled="isDisable"
                            v-model="isEdit"
                        />                    
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
                                    <h5><i class='far fa-calendar-alt fa-2x'></i> รายละเอียดการแก้ไขสัญญา <span class="detail"> (เฉพาะที่เปลี่ยนแปลงวันเริ่มต้น/วันสิ้นสุดสัญญา เนื่องจากเกิดความคลาดเคลื่อนในการนับวัน ไม่รวมถึงการขยายาเวลาตามสัญญา)</span></h5>
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
                                        <my-date-picker ref="edit_date" :id="11" :showDate="date_show" @update="value => edit_date = value" disabled></my-date-picker>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="4">

                                    <b-form-group>
                                        <label for="start_date"><i :class=" edit_start ? icon_check : icon_uncheck" @click="edit_start=!edit_start"></i>  แก้ไขวันเริ่มต้นสัญญา เป็นวันที่ : </label>

                                        <my-date-picker ref="start_date" :id="12" :showDate="date_start_show" @update="value => start_date = value" v-if="edit_start"></my-date-picker>                                      


                                        
                                    </b-form-group>
                                </b-col>
                                <b-col sm="4">

                                    <b-form-group>
                                        <label for="end_date"><i :class=" edit_end ? icon_check : icon_uncheck" @click="edit_end=!edit_end"></i>  แก้ไขวันสิ้นสุดสัญญา เป็นวันที่ : </label>
                                        <my-date-picker ref="end_date" :id="13" :showDate="date_end_show" @update="value => end_date = value" v-if="edit_end"></my-date-picker>
                                        


                                        
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
                            <th scope="col" style="width: 30%">แก้ไขวันเริ่มต้นสัญญา</th>
                            <th scope="col" style="width: 30%">แก้ไขวันสิ้นสุดสัญญา</th>
                            <th scope="col" style="width: 20%">การดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,index) in contract_edit_list" :key="index">
                            <td>{{getThaiDate(item.contract_edit_date)}}</td>
                            <td>{{getThaiDate(item.contract_new_start_date)}}</td>
                            <td>{{getThaiDate(item.contract_new_end_date)}}</td>
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

            date_start_show: '',
            start_date: '',

            date_end_show: '',
            end_date: '',
            contract_edit_list: [],
            alert: '',
            contract_edit: {},
            state : 'new',
           
            isEdit: false,
            refund_status: this.$store.getters.refund_status,
            isScheduleEdit: false,
            edit_start: false,
            edit_end: false,
            icon_check: 'far fa-check-square fa-lg',
            icon_uncheck: 'far fa-square fa-lg'
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
            if (this.edit_start == false && this.edit_end == false){
                this.alert = "require";
                    return
            }
            if (this.edit_start){
                if (!(this.start_date) || (this.start_date == '')){
                    this.alert = "require";
                    return
                }
            }
            if (this.edit_end){
                if (!(this.end_date) || (this.end_date == '')){
                    this.alert = "require";
                    return
                }
            }
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/contract_schedule_edits`;
            if (!(this.edit_start || this.edit_end)){
                this.alert = "error";
                return;
            }
            if (this.state == 'new'){
                axios.post(`${path}`,{
                    contract_edit_date: this.edit_date ,
                    contract_new_start_date: this.edit_start ? this.start_date : null,
                    contract_new_end_date: this.edit_end ?  this.end_date : null
                    
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
                    contract_edit_date: this.edit_date,
                    contract_new_start_date: this.edit_start ? this.start_date : null,
                    contract_new_end_date: this.edit_end ?  this.end_date : null
                    
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
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/contract_schedule_edits`;
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
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/contract_schedule_edits/${contract_edit.id}`;
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
        async toEdit(contract_edit){
            //console.log('edit edit');
            this.contract_edit = contract_edit;
            this.date_show = await contract_edit.contract_edit_date;
            this.edit_start = await contract_edit.contract_new_start_date ? true : false;
            this.date_start_show = await contract_edit.contract_new_start_date;
            this.edit_end = await contract_edit.contract_new_end_date ? true : false;
            this.date_end_show = await contract_edit.contract_new_end_date;
            
            this.state = 'update';
            this.$forceUpdate();
        },
        clearData(){
            this.contract_edit = {};
            this.date_show = '';
            this.date_start_show = '';
            this.date_end_show = '';
            this.state = 'new';
            this.edit_start = false;
            this.edit_end = false;
            if (this.contract_edit_list.length <= 0) {
                this.isEdit = false;
            }
            this.$forceUpdate();
        },
        getThaiDate(value){
            if (value){
                var d = new Date(value);
                return d.toLocaleDateString('th-TH', { day: 'numeric', month: 'long', year: 'numeric' });
            }else{
                return "-";
            }
            
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
.edit_schedule{
    display: flex;
    justify-content: space-between;
    /* align-items: baseline; */
    width: 100%;
    margin-bottom: 10px;
    padding: 10px 20px 10px 20px;
    border-radius: 5px;
    background-color: rgb(255, 175, 83);
}
.edit_schedule span{
    padding-top: 5px;
}
.table{
    margin-top: 10px;;
}
.card{
    padding: 10px;
    border-color: #000;
}
</style>
