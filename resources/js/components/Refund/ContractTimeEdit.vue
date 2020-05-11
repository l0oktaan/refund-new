<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
            <b-card class="bg-primary">
                <div slot="header" class="navbar">
                    <ul class="nav navbar-nav d-md-down-none">
                        <li class="nav-item px-3">
                            <i class='fa fa-align-justify'></i>
                                ข้อมูลการอนุมัติ งด / ลด / ขยายเวลา <span class="detail"> (ไม่รวม การขออนุมัติถอนคืนในครั้งนี้) </span><span class="require"> (*)</span> จำเป็นต้องกรอก
                        </li>
                    </ul>
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item px-3">
                            <!-- <b-button variant="outline-success">
                                <i class="fas fa-save fa-2x"></i>&nbsp;<span>บันทึกข้อมูล</span>
                            </b-button> -->
                        </li>
                    </ul>
                </div>
                <b-form @submit="onSubmitTimeEdit">

                            <b-row>
                                <b-col sm="3">
                                    <b-form-group>
                                        <label for="time_edit_date">วันที่อนุมัติ : <span class="require">*</span></label>
                                        <my-date-picker ref="approve_date" :id="11" :showDate="date_approve" @update="value => date_approve = value"></my-date-picker>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="3">
                                    <b-form-group>
                                        <label for="edit_type">ประเภทการอนุมัติ :<span class="require">*</span></label>
                                        <b-form-select

                                            :options="arrEditType"
                                            v-model = "time_edit.edit_type"
                                        >
                                        </b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="3" v-if="time_edit && time_edit.edit_type == 4">
                                    <b-form-group >
                                        <label for="edit_detail">ระบุ :</label>
                                        <b-form-input type="text"
                                            placeholder="ระบุประเภทการอนุมัติ"
                                            name="edit_detail"
                                            v-model = "time_edit.edit_detail"
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                 <b-col sm="3" v-if="time_edit.edit_type == 2 || time_edit.edit_type ==3">
                                    <b-form-group>
                                        <label for="edit_budget">จำนวนเงิน :</label>
                                        <cleave placeholder="จำนวนเงิน" name="edit_budget" v-model="time_edit.edit_budget" class="form-control" :options="cleave_options.number"></cleave>

                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col sm="3">
                                    <b-form-group>
                                        <label for="edit_start_date">ตั้งแต่วันที่ :<span class="require">*</span></label>
                                        <my-date-picker ref="edit_start_date" :id="12" :showDate="date_edit_start" @update="value => date_edit_start = value"></my-date-picker>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="3">
                                    <b-form-group>
                                        <label for="edit_end_date">ถึงวันที่ :<span class="require">*</span></label>
                                        <my-date-picker ref="edit_end_date" :id="12" :showDate="date_edit_end" @update="value => date_edit_end = value"></my-date-picker>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="2">
                                    <b-form-group>
                                        <label for="edit_days">จำนวนวัน (คำนวณ) :</label>
                                        <p v-if="cal_edit_days" style="text-align: center">{{cal_edit_days}} วัน</p>
                                    </b-form-group>
                                </b-col>
                                 <b-col sm="3">
                                    <b-form-group>
                                        <label for="edit_days">จำนวนวันที่อนุมัติ :</label>

                                        <b-form-input type="text"
                                            placeholder="จำนวนวัน"
                                            name="edit_days"
                                            v-model = "edit_days"
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col sm="4">
                                    <b-form-group>
                                        <label for="approve_type">อนุมัติให้ตาม :<span class="require">*</span></label>
                                        <b-form-select
                                            :options="arrApproveType"
                                            v-model = "time_edit.approve_type"
                                        >
                                        </b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="8" v-if="arrShowDetail1.includes(parseInt(time_edit.approve_type))">
                                    <b-form-group>
                                        <label for="approve_case">กรณี :</label>
                                        <b-form-input type="text"
                                            placeholder="กรณี"
                                            name="approve_case"
                                            v-model = "time_edit.approve_case"
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col sm="4" v-if="arrShowDetail1.includes(parseInt(time_edit.approve_type)) && arrShowDetail2.includes(parseInt(time_edit.approve_type))">
                                    <b-form-group>
                                        <label for="problem_end_date">อุปสรรคสิ้นสุดวันที่ :</label>
                                        <my-date-picker ref="problem_end_date" :id="13" :showDate="date_problem_end" @update="value => date_problem_end = value"></my-date-picker>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="4" v-if="arrShowDetail1.includes(parseInt(time_edit.approve_type)) && arrShowDetail2.includes(parseInt(time_edit.approve_type))">
                                    <b-form-group>
                                        <label for="book_date">หนังสือผู้รับจ้างแจ้งเหตุสิ้นสุดวันที่ :</label>
                                        <my-date-picker ref="book_date" :id="14" :showDate="date_book" @update="value => date_book = value"></my-date-picker>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <div class="text-center" style="margin-bottom:5px;">
                                        <b-button type="submit" :disabled="isDisable" variant="dark">บันทึกข้อมูล</b-button>
                                        <b-button type="reset" variant="danger" @click="clearData" >ยกเลิก</b-button>
                                    </div>
                                </b-col>
                            </b-row>

                </b-form>
            </b-card>
            <!-- ======================= Contract Edit List ========================================-->
            <table class="table table-hover">
                <thead class="thead">
                    <tr>
                        <th scope="col" style="width: 15%">วันที่อนุมัติ</th>
                        <th scope="col" style="width: 15%">ประเภทการอนุมัติ</th>
                        <th scope="col" style="width: 10%">จำนวนวัน</th>
                        <th scope="col" style="width: 15%">ตั้งแต่วันที่</th>
                        <th scope="col" style="width: 15%">ถึงวันที่</th>
                        <th scope="col" style="width: 20%">อนุมัติให้ตาม</th>
                        <th scope="col" style="width: 10%">การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item,index) in time_edit_list" :key="index">
                        <td>{{getThaiDate(item.approve_date)}}</td>
                        <td>{{arrEditType[item.edit_type].text}}</td>
                        <td>{{item.edit_days}}</td>
                        <td>{{getThaiDate(item.edit_start_date)}}</td>
                        <td>{{getThaiDate(item.edit_end_date)}}</td>
                        <td>{{getApproveType(item.approve_type)}}</td>
                        <td>
                            <b-button :id="'btnEdit'+item.id" class="tools" size="sm" variant="outline-primary" @click="toEdit(item)"><i class="fas fa-edit"></i></b-button>
                            <b-tooltip :target="'btnEdit'+item.id" triggers="hover" placement="left">
                                แก้ไขข้อมูล
                            </b-tooltip>

                            <b-button :disabled="isDisable" :id="'btnDel'+item.id" class="tools" size="sm" variant="outline-danger" @click="toDel(item.id)"><i class="fas fa-trash"></i></b-button>
                            <b-tooltip  :target="'btnDel'+item.id" triggers="hover" placement="left">
                                ลบข้อมูล
                            </b-tooltip>
                        </td>
                    </tr>
                </tbody>
            </table>
    </div>
</template>
<script>
export default {
    props: ['office_id'],
    data() {
        return {
            //office_id: this.$store.getters.office_id,
            r_id: this.$route.params.id,
            arrEditType : [
                {text: 'ประเภทการอนุมัติ', value : null},
                {text: 'ขยายเวลา', value : 1},
                {text: 'งดหรือลดค่าปรับ', value : 2},
                {text: 'คืนเงินค่าปรับ', value : 3}
            ],
            arrApproveType : this.$store.getters.arrApproveType,
            arrShowDetail1 : [
                21,24,22,23,34,30,31,32
            ],
            arrShowDetail2 : [
                22,23,31,32
            ],
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
            time_edit : {
                edit_type: null,
                approve_type: null,
                edit_detail: '-'
            },
            time_edit_list: [],
            date_approve: '',
            date_contract_end: '',
            date_problem_end: '',
            date_book: '',
            date_edit_start: '',
            date_edit_end: '',
            edit_days: null,
            cal_edit_days: null,
            state: 'new',
            alert: '',
            refund_status: this.$store.getters.refund_status

        }
    },
    mounted(){
        this.fetchEditTimeList();
        this.$forceUpdate();
    },
    computed: {
        isDisable(){
            console.log('status :' + this.refund_status);
            return this.refund_status > 7 && this.$store.getters.user.type != 'admin' ? true : false
        }
    },
    watch: {
        date_edit_start(newDate, oldDate){
            if (this.date_edit_start != '' && this.date_edit_end){
                if (!this.checkDate(newDate,this.date_edit_end)){
                    this.$nextTick(() => {
                        this.date_edit_start = oldDate;
                        this.$forceUpdate();
                    })
                }else{
                    this.cal_edit_days = this.diffDate(this.date_edit_start,this.date_edit_end);
                }
            }
        },
        date_edit_end(newDate, oldDate){

            if (this.date_edit_end != '' && this.date_edit_start){
                if (!this.checkDate(this.date_edit_start,newDate)){
                    this.$nextTick(() => {
                        this.date_edit_end = oldDate;
                        this.$forceUpdate();
                    })
                }else{
                    this.cal_edit_days = this.diffDate(this.date_edit_start,this.date_edit_end);
                }
            }
        },
        cal_edit_days(newVal,oldVal){
            this.edit_days = newVal;
            this.$forceUpdate();
        }
    },
    methods: {

        fetchEditTimeList(){
            this.$emit('refund_update');
            this.time_edit_list = [];
            var path = `/api/offices/${this.office_id}/refunds/${this.r_id}/contract_time_edits`;

            axios.get(`${path}`)
            .then(response=>{
                this.time_edit_list = response.data.data;
            })
            .catch(error=>{
                console.log("error : " + error);
            })

        },
        onSubmitTimeEdit(e){
            e.preventDefault();
            var path = `/api/offices/${this.office_id}/refunds/${this.r_id}/contract_time_edits`;

            if (this.state == 'new'){
                console.log('Path : ' + path + ' data :'+this.time_edit);
                axios.post(`${path}`,{
                    approve_date: this.date_approve,
                    edit_type: this.time_edit.edit_type,
                    edit_detail: this.time_edit.edit_detail,
                    edit_days: this.edit_days,
                    edit_budget: this.time_edit.edit_budget,
                    edit_start_date: this.date_edit_start,
                    edit_end_date: this.date_edit_end,
                    approve_type: this.time_edit.approve_type,
                    approve_case: this.time_edit.approve_case,
                    problem_end_date: this.date_problem_end,
                    book_date: this.date_book
                })
                .then(response=>{

                    this.alert = 'success';

                    this.fetchEditTimeList();

                    this.clearData();
                    this.$forceUpdate();
                })
                .catch(error=>{
                    console.log('error : ' + error);
                    this.alert = 'error';
                })
            }else if (this.state == 'update'){

                path = `${path}/${this.time_edit.id}`
                axios.put(`${path}`,{
                    approve_date: this.date_approve,
                    edit_type: this.time_edit.edit_type,
                    edit_detail: this.time_edit.edit_detail,
                    edit_days: this.edit_days,
                    edit_budget: this.time_edit.edit_budget,
                    edit_start_date: this.date_edit_start,
                    edit_end_date: this.date_edit_end,
                    approve_type: this.time_edit.approve_type,
                    approve_case: this.time_edit.approve_case,
                    problem_end_date: this.date_problem_end,
                    book_date: this.date_book
                })
                .then(response=>{
                    this.alert = 'success';
                    this.clearData();
                    this.fetchEditTimeList();
                    this.$forceUpdate();

                })
                .catch(error=>{
                    console.log('error : ' + error);
                    this.alert = 'error';
                })
            }


        },
        showCalendar(value){
            if (value){
                this.date_approve = value.approve_date;
                this.date_edit_start = value.edit_start_date;
                this.date_edit_end = value.edit_end_date;
                this.edit_days = value.edit_days;
                this.$nextTick(() => {
                    this.date_problem_end = value.problem_end_date;
                    this.date_book = value.book_date;
                })
                this.$forceUpdate();
            }else{
                this.date_approve = '';
                 this.date_edit_start = '';
                this.date_edit_end = '';
                this.date_problem_end = '';
                this.date_book = '';
                this.$forceUpdate();
            }

        },
        toEdit(t_edit){
            //this.time_edit = t_edit;
            this.time_edit = _.cloneDeep(t_edit);

            this.state = 'update';
            this.showCalendar(t_edit);

            this.$forceUpdate();
        },
        toDel(id){
            var path = `/api/offices/${this.office_id}/refunds/${this.r_id}/contract_time_edits/${id}`;
            this.$swal({
                title: "กรุณายืนยัน",
                text: `คุณต้องการลบข้อมูล ใช่หรือไม่`,
                icon: "warning",
                closeOnClickOutside: false,
                buttons: [
                    'ยกเลิก',
                    'ยืนยัน'
                ],
            })
            .then(isConfirm =>{
                if (isConfirm){
                    axios.delete(`${path}`)
                    .then(response=>{
                        this.clearData();
                        this.fetchEditTimeList();
                        this.alert = "success";
                    })
                    .catch(error=>{
                        this.alert = "error";
                    })
                }
            })
        },
        diffDate(date1,date2){
            var d1 = new Date(date1);
            var d2 = new Date(date2);
            var diff = null;
            if (d2 > d1){
                diff = (d2.getTime() - d1.getTime())/(1000*60*60*24) + 1;
                return diff;
            }else{
                this.alert = "error";
                return false;
            }
        },
        checkDate(date1,date2){
            //console.log('check date : '+ date1 + ' and ' + date2);
            var d1 = new Date(date1);
            var d2 = new Date(date2);
            if (d2 > d1){
                console.log('dateDiff :' + (d2.getTime() - d1.getTime())/(1000*60*60*24));
                return true;
            }else{
                this.alert = "error";
                return false;
            }

        },
        getThaiDate(item){
            var d = new Date(item);
            return d.toLocaleDateString('th-TH', { day: 'numeric', month: 'long', year: 'numeric' });
            //return moment(String(value)).format('LL')
        },
        getApproveType(value){
            console.log('Get Approve Type :' + value);
            var index = this.arrApproveType.findIndex(x => x.value == value);
            return this.arrApproveType[index].text;
        },
        clearData(){
            console.log('Clear Time Edit');
            this.time_edit = {
                edit_type: null,
                approve_type: null,
                edit_detail: '-'
            };

            this.state = 'new';
            this.date_approve = '';
            this.date_contract_end = '';
            this.date_problem_end = '';
            this.date_book = '';
            this.date_edit_start = '';
            this.date_edit_end = '';
            this.edit_days = null;
            this.cal_edit_days = null;
            this.$forceUpdate();
            //this.showCalendar();
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
.dropdown-item{
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
.fieldName{
    color: rgb(4, 30, 53);
    font-weight: bold;
    text-align: center;
    margin: 0px!important;
}
.unit{
    color: rgb(154, 156, 158);
    font-weight: bold;
    padding-left: 5px;
}
.item_list{
    margin: 0px!important;
}
.header_list{
    margin-bottom: 5px;
    background-color: #f0f3f5;
    border: 1px solid #c8ced3;

}
.detail{
    font-size: 0.9rem!important;
}
.thead{
    background-color: #1074b8;
    color: #fff;
    font-weight: normal!important;
}
</style>
