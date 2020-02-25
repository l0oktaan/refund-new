<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
            <b-card class="bg-dark">
            <div slot="header" class="navbar">
                <ul class="nav navbar-nav d-md-down-none">
                    <li class="nav-item px-3">
                        <i class='fa fa-align-justify'></i>
                            ข้อมูลการส่งมอบงาน <span class="detail"> (ตั้งแต่งวดแรกที่มีค่าปรับ)</span><span class="require"> (*)</span> จำเป็นต้องกรอก
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
            <validation-observer ref="observer" v-slot="{ passes }">
            <b-form @submit.stop.prevent="passes(onSubmit)">
                        <b-row>
                            <b-col >
                                <validation-provider
                                    name="ส่งมอบงาน"
                                    rules="required|min:5"
                                    v-slot="validationContext"
                                >
                                <b-form-group>
                                    <label for="time_edit_date">ส่งมอบงาน : <span class="require">*</span></label>
                                    <b-form-input type="text"
                                        placeholder="งวดที่ / ครั้งที่"
                                        name="delivery"
                                        v-model="delivery.delivery"
                                        :state="getValidationState(validationContext)"
                                        aria-describedby="input-1-live-feedback"
                                    >
                                    </b-form-input>
                                    <b-form-invalid-feedback id="input-1-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                </b-form-group>
                                </validation-provider>
                            </b-col>
                        </b-row>
                        <b-row>
                        <b-col >
                            <b-form-group>
                                <label for="detail">รายละเอียดส่งมอบงาน :</label>
                                <b-form-input type="text"
                                    placeholder="เช่น ส่งมอบงานเกินกำหนด 45 วัน แต่ปรับไว้ 43 วัน เป็นต้น"
                                    name="detail"
                                    v-model="delivery.detail"
                                >
                                </b-form-input>
                            </b-form-group>
                        </b-col>
                        </b-row>
                        <b-row>
                            <b-col>
                                <b-form-group>
                                    <label for="date_start">วันที่เริ่มคิดค่าปรับ : <span class="require">*</span><span class="detail"></span></label>
                                    <my-date-picker ref="date_start" id="date_start" :showDate="date_start" @update="value => date_start = value"></my-date-picker>
                                </b-form-group>
                            </b-col>
                            <b-col>
                                <b-form-group>
                                    <label for="date_end">วันที่สิ้นสุดการคิดค่าปรับ : <span class="require">*</span><span class="detail"></span></label>
                                    <my-date-picker ref="date_end" id="date_end" :showDate="date_end" @update="value => date_end = value"></my-date-picker>
                                </b-form-group>
                            </b-col>
                            <b-col>
                                <b-form-group>
                                    <label for="overdue_days">เกินกำหนด : (วัน)</label>
                                    <b-form-input type="text"
                                        placeholder="จำนวนวัน"
                                        name="overdue_days"
                                        v-model="overdue_days"
                                        disabled
                                    >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col>
                                <b-form-group>
                                    <label for="delivery_date">วันที่ส่งมอบงาน : <span class="require">*</span><span class="detail">(วันที่หน่วยงานได้รับหนังสือ)</span></label>
                                    <my-date-picker ref="delivery_date" :id="11" :showDate="date_delivery" @update="value => date_delivery = value"></my-date-picker>

                                </b-form-group>
                            </b-col>

                            <b-col>
                                <b-form-group>
                                    <label for="penalty">ถูกปรับเป็นเงิน : (บาท) <span class="require">*</span></label>
                                    <cleave placeholder="จำนวนเงิน" name="penalty" v-model="delivery.penalty" class="form-control" :options="cleave_options.number"></cleave>
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
            </b-form>
            </validation-observer>
        </b-card>
            <!-- ======================= Delivery List ========================================-->



        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col" style="width: 15%">งวดที่ / ครั้งที่</th>
                    <th scope="col" style="width: 15%">วันที่ส่งมอบ</th>
                    <th scope="col" style="width: 30%">รายละเอียดส่งมอบ</th>
                    <th scope="col" style="width: 15%">เกินกำหนด (วัน)</th>
                    <th scope="col" style="width: 15%">ถูกปรับเป็นเงิน (บาท)</th>
                    <th scope="col" style="width: 10%">การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item,index) in delivery_list" :key="index">
                    <td>{{item.delivery}}</td>
                    <td>{{getThaiDate(item.delivery_date)}}</td>
                    <td>{{item.detail}}</td>
                    <td>{{item.overdue_days}}</td>
                    <td>{{item.penalty | numeral('0,0.00') }}</td>
                    <td>
                        <b-button :id="'btnEdit'+item.id" class="tools" size="sm" variant="outline-primary" @click="toEdit(item)"><i class="fas fa-edit"></i></b-button>
                        <b-tooltip :target="'btnEdit'+item.id" triggers="hover" placement="left">
                            แก้ไขข้อมูล
                        </b-tooltip>

                        <b-button :id="'btnDel'+item.id" class="tools" size="sm" variant="outline-danger" @click="toDel(item.id)"><i class="fas fa-trash"></i></b-button>
                        <b-tooltip :target="'btnDel'+item.id" triggers="hover" placement="left">
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
    props: ['refund_id'],
    data(){
        return {
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
            office_id: 2,
            r_id: this.$route.params.id,
            delivery: {},
            delivery_list: [],
            delivery_date: '',
            date_delivery: '',
            date_start: '',
            date_end: '',
            overdue_days: null,
            state: 'new',
            alert: ''
        }
    },
    watch: {
        date_start(newDate, oldDate){
            if (this.date_start != '' && this.date_end){
                if (!this.checkDate(newDate,this.date_end)){
                    this.$nextTick(() => {
                        this.date_start = oldDate;
                        this.$forceUpdate();
                    })
                }else{
                    this.overdue_days = this.diffDate(this.date_start,this.date_end);
                }
            }
        },
        date_end(newDate, oldDate){

            if (this.date_end != '' && this.date_start){
                if (!this.checkDate(this.date_start,newDate)){
                    this.$nextTick(() => {
                        this.date_end = oldDate;
                        this.$forceUpdate();
                    })
                }else{
                    this.overdue_days = this.diffDate(this.date_start,this.date_end);
                }
            }
        },
    },
    mounted(){
        this.fetchData();
    },
    methods: {
        getValidationState({ dirty, validated, valid = null }) {
            return dirty || validated ? valid : null;
        },
        fetchData(){
            this.delivery_list = [];
            var path = `/api/offices/${this.office_id}/refunds/${this.r_id}/delivers`;
            axios
            .get(`${path}`)
            .then(response=>{
                this.delivery_list = response.data.data;
                this.$forceUpdate();
            })
            .catch(error=>{
                this.alert = "error";
            })
            this.$emit('refund_update');
        },
        getThaiDate(item){
            var d = new Date(item);
            return d.toLocaleDateString('th-TH', { day: 'numeric', month: 'long', year: 'numeric' });
            //return moment(String(value)).format('LL')
        },
        toEdit(item){

            this.delivery = _.cloneDeep(item);
            if (item){
                this.state = 'update';
                this.date_delivery = item.delivery_date;
                this.date_start = item.overdue_start_date;
                this.date_end = item.overdue_end_date;
                this.overdue_days = item.overdue_days;
            }
        },
        clearData(){
            this.delivery = {};
            this.state = 'new';
            this.date_delivery = '';
            this.date_start = '';
            this.date_end = '';
            this.delivery_date = '';
            this.overdue_days = null;
            this.$nextTick(() => {
                this.$refs.observer.reset();
            });
            this.$forceUpdate();
        },
        toDel(id){
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
                    var path = `/api/offices/${this.office_id}/refunds/${this.r_id}/delivers/${id}`;
                    axios
                    .delete(`${path}`)
                    .then(response=>{

                        this.clearData();
                        this.fetchData();
                        this.alert = "success";
                    })
                    .catch(error=>{
                        this.alert = "error";
                    })
                }
            })
        },
        onSubmit(e){
            //e.preventDefault();
            var path = `/api/offices/${this.office_id}/refunds/${this.r_id}/delivers`;
            console.log('delivery status :' + this.state);
            if (this.state == 'new'){
                axios
                .post(`${path}`,{
                    // delivery: this.delivery.delivery,
                    // detail: this.delivery.detail,
                    // delivery_date: this.delivery.delivery_date,
                    // overdue_days: this.delivery.overdue_days,
                    // penalty: this.delivery.penalty
                    delivery: this.delivery.delivery,
                    detail: this.delivery.detail,
                    delivery_date: this.date_delivery,
                    overdue_start_date: this.date_start,
                    overdue_end_date: this.date_end,
                    overdue_days: this.overdue_days,
                    penalty: this.delivery.penalty
                })
                .then(response=>{

                    this.alert = 'success';
                    //this.toEdit(response.data.data);

                    this.fetchData();
                    this.clearData();
                })
                .catch(error=>{
                    console.log('delever error :' + error)
                    this.alert = 'error';
                })
            }else if (this.state == 'update'){
                path = `${path}/${this.delivery.id}`;

                axios
                .put(`${path}`,{
                    delivery: this.delivery.delivery,
                    detail: this.delivery.detail,
                    delivery_date: this.date_delivery,
                    overdue_start_date: this.date_start,
                    overdue_end_date: this.date_end,
                    overdue_days: this.overdue_days,
                    penalty: this.delivery.penalty
                })
                .then(response=>{

                    this.alert = 'success';
                    //this.toEdit(response.data.data);

                    this.fetchData();
                    this.clearData();
                })
                .catch(error=>{
                    this.alert = 'error';
                })

            }
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
                //console.log('dateDiff :' + (d2.getTime() - d1.getTime())/(1000*60*60*24));
                return true;
            }else{
                this.alert = "error";
                return false;
            }

        },
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
</style>
