<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
        <b-card class="bg-primary">
            <div slot="header" class="navbar">
                <ul class="nav navbar-nav d-md-down-none">
                    <li class="nav-item px-3">
                        <i class='fa fa-align-justify'></i>
                            การขอถอนคืนเงินค่าปรับให้แก่ผู้มีสิทธิ
                    </li>
                </ul>
            </div>
            <b-form @submit="onSubmit">

                        <b-row>
                            <b-col cols="12" style="text-align:center; margin-bottom:10px;"><h5>การขอถอนคืนเงินค่าปรับให้แก่ผู้มีสิทธิ</h5></b-col>
                        </b-row>
                        <b-row v-if="false">
                            <b-col sm="12">
                                <b-form-group
                                    label-cols-sm="6"
                                    label="วันที่รับเรื่อง หนังสือขอความช่วยเหลือ :"
                                    label-align-sm="right"
                                    label-for="receive_date">
                                    <b-row>
                                        <b-col cols="6">
                                            <my-date-picker ref="receive_date" :id="11" :showDate="date_receive" @update="value => approve.receive_date = value"></my-date-picker>
                                        </b-col>
                                    </b-row>

                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col sm="12">

                                <b-form-group
                                    label-cols-sm="6"
                                    :label = "forms[0].form.name3.includes('693') ? 'หน่วยงานอนุมัติให้แก้ไขอัตรค่าปรับเป็นร้อยละ 0 ตั้งแต่วันที่:' : 'หน่วยงานอนุมัติให้งด ลดค่าปรับ ตั้งแต่วันที่:'"
                                    label-align-sm="right"
                                    label-for="approve_refund_days"
                                >
                                <b-row>
                                    <b-col cols="12" md="6">

                                        <my-date-picker ref="date_start" id="date_start" :showDate="date_start" @update="value => date_start = value"></my-date-picker>
                                    </b-col>
                                </b-row>

                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col sm="12">

                                <b-form-group
                                    label-cols-sm="6"
                                    label="ถึงวันที่:"
                                    label-align-sm="right"
                                    label-for="approve_refund_days"
                                >
                                <b-row>
                                    <b-col cols="12" md="6">
                                        <my-date-picker ref="date_end" :id="13" :showDate="date_end" @update="value =>date_end = value"></my-date-picker>
                                    </b-col>
                                </b-row>

                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col sm="12">

                                <b-form-group
                                    label-cols-sm="6"
                                    label="รวม"
                                    label-align-sm="right"
                                    label-for="approve_refund_days"
                                >
                                    <b-input-group append="วัน">
                                       <b-form-input readonly id="approve_refund_days" v-model="approve.refund_days"></b-form-input>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col sm="12">
                                <b-form-group
                                    label-cols-sm="6"
                                    label="หน่วยงานอนุมัติให้คืนเงินค่าปรับ :"
                                    label-align-sm="right"
                                    label-for="approve_refund_money"
                                >
                                    <b-input-group append="วัน">
                                       <b-form-input id="approve_refund_money" v-model="approve.refund_money"></b-form-input>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col sm="12">
                                <b-form-group
                                    label-cols-sm="6"
                                    label="เป็นเงิน :"
                                    label-align-sm="right"
                                    label-for="refund_amount"
                                >
                                    <b-input-group append="บาท">
                                       <cleave placeholder="จำนวนเงิน" name="amount" v-model="approve.refund_amount" class="form-control" :options="cleave_options.number"></cleave>
                                    </b-input-group>

                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col sm="12">
                                <b-form-group
                                    label-cols-sm="6"
                                    label="หน่วยงานขออนุมัติถอนคืน จำนวน :"
                                    label-align-sm="right"
                                    label-for="approve_amount"
                                >
                                    <b-input-group append="บาท">
                                       <cleave placeholder="จำนวนเงิน" name="approve_amount" v-model="approve.approve_amount" class="form-control" :options="cleave_options.number"></cleave>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col sm="12">
                                <b-form-group
                                    label-cols-sm="6"
                                    label="เลขที่แบบถอนคืน :"
                                    label-align-sm="right"
                                    label-for="approve_code"
                                >
                                    <b-form-input v-model="approve.approve_code" :readonly="true" :state="approve.approve_code ? true : false"></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col>

                                <div class="text-center" style="margin-bottom:5px;">
                                    <b-button  type="submit" variant="dark" :disabled="isDisable">บันทึกข้อมูล</b-button>
                                </div>                                
                            </b-col>
                        </b-row>

            </b-form>

        </b-card>

    </div>
</template>
<script>
export default {
    props: ['refund_id','office_id','forms'],
    data(){
        return {
            r_id: this.$route.params.id,
            //office_id: this.$store.getters.office_id,
            approve: {},
            date_receive: '',
            date_start: '',
            date_end: '',
            alert: '',
            state: 'new',
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
            form : [],
            refund_status: this.$store.getters.refund_status
        }
    },
    mounted(){

        this.fetchData();
    },
    computed: {
        isDisable(){
            console.log('status :' + this.refund_status);
            return (this.refund_status > 7 && this.refund_status != 11) && this.$store.getters.user.type != 'admin' ? true : false
        }
    },
    watch:{
         date_start(newDate, oldDate){
            if (this.date_start != '' && this.date_end){
                if (!this.checkDate(newDate,this.date_end)){
                    this.$nextTick(() => {
                        this.date_start = oldDate;
                        this.$forceUpdate();
                    })
                }else{
                    this.approve.refund_days = this.diffDate(this.date_start,this.date_end);
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
                    this.approve.refund_days = this.diffDate(this.date_start,this.date_end);
                    // this.checkEqualDate(newDate,this.date_delivery);
                }
            }
        },
    },
    methods: {
        async fetchData(){
            // var path = await `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms`;
            // //var refund_form_id = 0;
            // var res = await axios.get(`${path}`)
            // this.form = await res.data.data
            const path = await `/api/offices/${this.office_id}/refunds/${this.r_id}/approve_refunds`;
            let response = await axios.get(`${path}`)
                if (response.data.data.length > 0){
                    this.approve = await response.data.data[0];

                    this.toEdit(response.data.data[0]);
                }

            await this.$emit('refund_update');
        },
        toEdit(item){
            this.approve = _.cloneDeep(item);
            if (item){
                this.state = 'update';
                this.date_receive = item.receive_date;
                this.date_start = this.approve.start_date;
                this.date_end = this.approve.end_date;
            }
            this.$forceUpdate();
        },
         onSubmit(e){
            e.preventDefault();

            ///api/offices/2/refunds/14/deposit_penalties
            var path = `/api/offices/${this.office_id}/refunds/${this.r_id}/approve_refunds`;

            if (this.state == 'new'){

                axios.post(`${path}`,{
                    //receive_date: this.approve.receive_date,
                    refund_days: this.approve.refund_days,
                    refund_money: this.approve.refund_money,
                    refund_amount: this.approve.refund_amount,
                    approve_amount: this.approve.approve_amount,
                    start_date: this.date_start,
                    end_date: this.date_end,
                })
                .then(response=>{
                   this.alert = 'success';
                   this.$emit('refund_update');
                   this.toEdit(response.data.data);

                })
                .catch(error=>{
                    this.alert = 'error';
                })
            }else if (this.state == 'update'){
                path = `${path}/${this.approve.id}`;
                axios
                .put(`${path}`,{
                    //receive_date: this.approve.receive_date,
                    refund_days: this.approve.refund_days,
                    refund_money: this.approve.refund_money,
                    refund_amount: this.approve.refund_amount,
                    approve_amount: this.approve.approve_amount,
                    start_date: this.date_start,
                    end_date: this.date_end,
                })
                .then(response=>{
                    this.alert = 'success';
                    this.$emit('refund_update');
                    this.toEdit(response.data.data);
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
            if (d2 >= d1){
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
            if (d2 >= d1){
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
input{
    max-width: 150px!important;
}
.code{
    margin-top: 10px!important;
    vertical-align: middle!important;
}
</style>
