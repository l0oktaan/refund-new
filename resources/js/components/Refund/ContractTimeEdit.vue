<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
            <b-card>
                <div slot="header" class="navbar">
                    <ul class="nav navbar-nav d-md-down-none">
                        <li class="nav-item px-3">
                            <i class='fa fa-align-justify'></i>
                                ข้อมูลการอนุมัติ งด / ลด / ขยายเวลา
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
                    <b-card no-body class="bg-default">
                        <b-card-body class="pb-0 list ">
                            <b-row>
                                <b-col sm="3">
                                    <b-form-group>
                                        <label for="time_edit_date">วันที่อนุมัติ :</label>
                                        <my-date-picker ref="approve_date" :id="11" :showDate="date_approve" @update="value => time_edit.approve_date = value"></my-date-picker>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="3">
                                    <b-form-group>
                                        <label for="edit_type">ประเภทการอนุมัติ :</label>
                                        <b-form-select

                                            :options="arrEditType"
                                            v-model = "time_edit.edit_type"
                                        >
                                        </b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="3">
                                    <b-form-group v-if="time_edit && time_edit.edit_type == 3">
                                        <label for="edit_detail">ระบุ :</label>
                                        <b-form-input type="text"
                                            placeholder="ระบุประเภทการอนุมัติ"
                                            name="edit_detail"
                                            v-model = "time_edit.edit_detail"
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col sm="3">
                                    <b-form-group>
                                        <label for="edit_days">จำนวนวัน :</label>

                                        <b-form-input type="text"
                                            placeholder="จำนวนวัน"
                                            name="edit_days"
                                            v-model = "time_edit.edit_days"
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="3">
                                    <b-form-group>
                                        <label for="edit_budget">จำนวนเงิน :</label>
                                        <cleave placeholder="จำนวนเงิน" name="edit_budget" v-model="time_edit.edit_budget" class="form-control" :options="cleave_options.number"></cleave>

                                    </b-form-group>
                                </b-col>
                                <b-col sm="3">
                                    <b-form-group>
                                        <label for="time_edit_date">สิ้นสุดสัญญาวันที่ :</label>
                                        <my-date-picker ref="contract_end_date" :id="12" :showDate="date_contract_end" @update="value => time_edit.contract_end_date = value"></my-date-picker>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col sm="3">
                                    <b-form-group>
                                        <label for="approve_type">อนุมัติให้ตาม :</label>
                                        <b-form-select
                                            :options="arrApproveType"
                                            v-model = "time_edit.approve_type"
                                        >
                                        </b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="9">
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
                                <b-col sm="3">
                                    <b-form-group>
                                        <label for="problem_end_date">อุปสรรคสิ้นสุดวันที่ :</label>
                                        <my-date-picker ref="problem_end_date" :id="13" :showDate="date_problem_end" @update="value => time_edit.problem_end_date = value"></my-date-picker>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="3">
                                    <b-form-group>
                                        <label for="book_date">หนังสือแจ้งเหตุวันที่ :</label>
                                        <my-date-picker ref="book_date" :id="14" :showDate="date_book" @update="value => time_edit.book_date = value"></my-date-picker>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <div class="text-center" style="margin-bottom:5px;">
                                        <b-button type="submit" variant="primary">บันทึกข้อมูล</b-button>
                                        <b-button type="reset" variant="danger" @click="clearData" >ยกเลิก</b-button>
                                    </div>
                                </b-col>
                            </b-row>
                        </b-card-body>
                    </b-card>
                </b-form>
            </b-card>
            <!-- ======================= Contract Edit List ========================================-->

            <b-card no-body class="header_list">
                <b-card-body class="pb-0 list ">
                    <b-row>
                        <b-col cols="2">
                            <p class="text-center fieldName">วันที่อนุมัติ</p>
                        </b-col>
                        <b-col cols="2">
                            <p class="text-center fieldName">ประเภท </p>
                        </b-col>
                        <b-col cols="2">
                            <p class="text-center fieldName">จำนวนวัน</p>
                        </b-col>
                        <b-col cols="3">
                            <p class="text-center fieldName">จำนวนเงิน </p>
                        </b-col>
                        <b-col>
                            <p class="text-right fieldName">จัดการ </p>
                        </b-col>

                    </b-row>
                </b-card-body>
            </b-card>
            <b-card no-body :class="(t_edit.id === time_edit.id) && (time_edit) ? 'item_select' : 'edit_list'" v-for="(t_edit,index) in time_edit_list" :key="index">
                <b-card-body class="pb-0 list ">
                    <b-dropdown class="float-right" variant="transparent p-0" right>
                        <template slot="button-content">
                            <i class="icon-settings" style="color: #000;"></i>
                        </template>
                        <b-dropdown-item @click="toEdit(t_edit)"><i class="fas fa-edit"></i>&nbsp;แก้ไขข้อมูล</b-dropdown-item>
                        <b-dropdown-item @click="toDel(t_edit.id)"><i class="fas fa-trash"></i>&nbsp;ลบข้อมูล</b-dropdown-item>
                    </b-dropdown>
                    <b-row>
                        <b-col cols="2">
                            <p class="text-left item_list">{{getThaiDate(t_edit.approve_date)}}</p>
                        </b-col>
                        <b-col cols="2">
                            <p class="text-center item_list">{{arrEditType[t_edit.edit_type].text}}</p>
                        </b-col>
                        <b-col cols="2">
                            <span class="float-right"> {{t_edit.edit_days}} <span class="unit"> วัน</span>  </span>
                        </b-col>
                        <b-col cols="3">
                            <span class="float-right"> {{t_edit.edit_budget | numeral('0,0.00') }} <span class="unit"> บาท</span>  </span>
                        </b-col>
                        <b-col></b-col>
                        <!-- <b-col sm="6" md="3" lg="2">
                            วันที่ : {{getThaiDate(item.approve_date)}}
                        </b-col>
                        <b-col sm="6" md="3" lg="2">
                            ประเภท :
                        </b-col>
                        <b-col sm="6" md="3" lg="2">
                            จำนวนวัน :
                        </b-col>
                        <b-col sm="12" md="12" lg="4">
                            กรณี :
                        </b-col> -->

                    </b-row>
                </b-card-body>
            </b-card>
    </div>
</template>
<script>
export default {
    data() {
        return {
            office_id: 2,
            r_id: this.$route.params.id,
            arrEditType : [
                {text: 'ประเภทการอนุมัติ', value : null},
                {text: 'ขยาย', value : 1},
                {text: 'งดหรือลด', value : 2},
                {text: 'อื่นๆ', value : 3}
            ],
            arrApproveType : [
                {text: 'อนุมัติให้ตาม', value: null},
                {text: 'มติ ครม. ว 63', value: 1},
                {text: 'มติ ครม. ว 66', value: 2},
                {text: 'ระเบียบพัสดุ 2535 ข้อ 136', value: 3},
                {text: 'ระเบียบพัสดุ 2535 ข้อ 139 (2)', value: 4},
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
            state: 'new',
            alert: ''

        }
    },
    mounted(){
        this.fetchEditTimeList();
        this.$forceUpdate();
    },
    methods: {
        fetchEditTimeList(){
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
                    // approve_date: this.time_edit.approve_date,
                    // edit_type: this.time_edit.edit_type,
                    // edit_detail: this.time_edit.edit_detail,
                    // edit_days: this.time_edit.edit_days,
                    // edit_budget: this.time_edit.edit_budget,
                    // contract_end_date: this.time_edit.contract_end_date,
                    // approve_type: this.time_edit.approve_type,
                    // approve_case: this.time_edit.approve_case,
                    // problem_end_date: this.time_edit.problem_end_date,
                    // book_date: this.time_edit.book_date
                    	approve_date : this.time_edit.approve_date,
                        edit_type : this.time_edit.edit_type,
                        edit_detail : this.time_edit.edit_detail,
                        edit_days : this.time_edit.edit_days,
                        edit_budget: this.time_edit.edit_budget,
                        contract_end_date: this.time_edit.contract_end_date,
                        approve_type: this.time_edit.approve_type,
                        approve_case: this.time_edit.approve_case,
                        problem_end_date: this.time_edit.problem_end_date,
                        book_date : this.time_edit.book_date
                })
                .then(response=>{
                    console.log('response :' + response);
                    this.alert = 'success';
                    this.time_edit = response.data.data;
                    this.state = 'update';
                    this.showCalendar(this.time_edit);
                })
                .catch(error=>{
                    console.log('error : ' + error);
                    this.alert = 'error';
                })
            }else if (this.state == 'update'){

                path = `${path}/${this.time_edit.id}`

                axios.put(`${path}`,{
                    approve_date: this.time_edit.approve_date,
                    edit_type: this.time_edit.edit_type,
                    edit_detail: this.time_edit.edit_detail,
                    edit_days: this.time_edit.edit_days,
                    edit_budget: this.time_edit.edit_budget,
                    contract_end_date: this.time_edit.contract_end_date,
                    approve_type: this.time_edit.approve_type,
                    approve_case: this.time_edit.approve_case,
                    problem_end_date: this.time_edit.problem_end_date,
                    book_date: this.time_edit.book_date
                })
                .then(response=>{
                    this.alert = 'success';
                    this.time_edit = response.data.data;
                    this.state = 'update';
                    this.showCalendar(this.time_edit);
                })
                .catch(error=>{
                    this.alert = 'error';
                })
            }
            this.fetchEditTimeList();


        },
        showCalendar(value){
            if (value){
                this.date_approve = value.approve_date;
                this.date_contract_end = value.contract_end_date;
                this.date_problem_end = value.problem_end_date;
                this.date_book = value.book_date;
                this.$forceUpdate();
            }else{
                this.date_approve = '';
                this.date_contract_end = '';
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

                axios.delete(`${path}`)
                .then(response=>{

                    this.clearData();
                    this.fetchEditTimeList();
                    this.alert = "success";
                })
                .catch(error=>{
                    this.alert = "error";
                })
            })
        },
        getThaiDate(item){
            var d = new Date(item);
            return d.toLocaleDateString('th-TH', { day: 'numeric', month: 'long', year: 'numeric' });
            //return moment(String(value)).format('LL')
        },
        clearData(){
            this.time_edit = {
                edit_type: null,
                approve_type: null,
                edit_detail: '-'
            };

            this.state = 'new';
            this.showCalendar();
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
</style>
