<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
        <b-row class="justify-content-md-center">
            <b-col cols="12">

            <b-card class="bg-primary">
                <div slot="header" class="navbar">
                    <ul class="nav navbar-nav d-md-down-none">
                        <li class="nav-item px-3">
                            <i class='fa fa-align-justify'></i>
                                บันทึกข้อมูลสัญญา <span class="require">(*)</span> จำเป็นต้องกรอก
                        </li>
                    </ul>

                </div>

            <validation-observer ref="observer" v-slot="{ passes }">
            <b-form @submit.stop.prevent="passes(onContractSubmit)" >
                <b-row>
                    <b-col sm="8">
                        <validation-provider
                            name="ชื่อคู่สัญญา"
                            :rules="{ required: true, min: 5 }"
                            v-slot="validationContext"
                        >
                        <b-form-group>
                            <label for="contract_party">ชื่อคู่สัญญา : <span class="require">*</span></label>
                            <b-form-input type="text"
                                placeholder="ชื่อคู่สัญญา"
                                v-model="contract_party"
                                :state="getValidationState(validationContext)"
                                aria-describedby="input-1-live-feedback"
                            >
                            </b-form-input>
                            <b-form-invalid-feedback id="input-1-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                        </b-form-group>
                        </validation-provider>
                    </b-col>

                    <b-col sm="4">
                        <validation-provider
                            name="สัญญาเลขที่"
                            :rules="{ required: true, min: 5 }"
                            v-slot="validationContext"
                        >
                        <b-form-group>
                            <label for="contract_no">สัญญา/ใบสั่งจ้างเลขที่ :<span class="require">*</span></label>
                            <b-form-input type="text"
                                placeholder="ใส่เลขที่สัญญา"
                                name="contract_no"
                                v-model="contract_no"
                                :state="getValidationState(validationContext)"
                                aria-describedby="input-2-live-feedback"
                            >
                            </b-form-input>
                            <b-form-invalid-feedback id="input-2-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                        </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col sm="3">

                        <b-form-group>
                            <label for="contract_date">สัญญาลงวันที่ :<span class="require">*</span></label>
                            
                            <my-date-picker ref="contract_date" :id="11" :showDate="contract_date" @update="value => contract_date = value"

                            ></my-date-picker>

                        </b-form-group>

                    </b-col>

                    <b-col sm="3">

                        <b-form-group>
                            <label for="budget">วงเงินในสัญญา :<span class="require">*</span></label>
                            
                            <cleave
                                placeholder="ใส่จำนวนวงเงินในสัญญา"
                                name="budget_new"
                                v-model="budget"
                                class="form-control"
                                :options="cleave_options.number"
                                >
                            </cleave>

                        </b-form-group>

                    </b-col>
                    <b-col cols="2">
                        <b-form-group label="หน่วยสกุลเงิน :" v-slot="{ ariaDescribedby }">
                            <b-form-radio-group
                                
                                v-model="currency_unit"
                                :aria-describedby="ariaDescribedby"
                                name="radio-inline"
                                buttons
                                size="sm"
                                button-variant="outline-warning"
                                
                            >
                                <b-form-radio value="THB">บาท</b-form-radio>
                                <b-form-radio value="USD">ดอลลาร์สหรัฐ</b-form-radio>
                            </b-form-radio-group>
                        </b-form-group>
                    </b-col>
                    <!-- <b-col cols="6">
                        <b-form-radio-group id="rbt_penalty_type" v-model="penalty_type" name="rbt_penalty_type">
                            <b-form-radio value="1">
                                <b-form-group :disabled="penalty_type != 1">
                                    <label for="penalty_per_day">ค่าปรับวันละ :</label>
                                    <cleave
                                        placeholder="ใส่จำนวนค่าปรับวันละ"
                                        name="penalty_per_day"
                                        v-model="penalty_per_day"
                                        class="form-control"
                                        :options="cleave_options.number">
                                    </cleave>
                                </b-form-group>
                            </b-form-radio>
                            <b-form-radio value="2">
                                <b-form-group :disabled="penalty_type != 2">
                                    <label for="penalty_per_day">อัตราค่าปรับร้อยละ(ต่อวัน) :</label>
                                    <cleave
                                        placeholder="ค่าปรับอัตราร้อยละต่อวัน"
                                        name="penalty_per_day"
                                        v-model="penalty_per_day_percent"
                                        class="form-control"
                                        :options="cleave_options.number">
                                    </cleave>

                                </b-form-group>
                            </b-form-radio>
                        </b-form-radio-group>
                    </b-col> -->
                    <b-col sm="3">
                        <b-form-group :disabled="penalty_type != 1">
                            <label for="penalty_per_day"><i :class=" penalty_type == 1 ? icon_check : icon_uncheck" @click="penalty_type = 1"></i> ค่าปรับต่อวัน : ({{currency_unit == 'THB' ? 'บาท' : 'ดอลลาร์สหรัฐ'}})</label>
                            <cleave
                                placeholder="ใส่จำนวนค่าปรับวันละ"
                                name="penalty_per_day"
                                v-model="penalty_per_day"
                                class="form-control"
                                :options="cleave_options.number">
                            </cleave>

                        </b-form-group>
                    </b-col>
                    <b-col sm="3">
                        <b-form-group :disabled="penalty_type != 2">
                            <label for="penalty_per_day"><i :class=" penalty_type == 2 ? icon_check : icon_uncheck" @click="penalty_type = 2"></i> ค่าปรับต่อวัน : (ร้อยละ)</label>
                            <cleave
                                placeholder="ค่าปรับอัตราร้อยละต่อวัน"
                                name="penalty_per_day"
                                v-model="penalty_per_day_percent"
                                class="form-control"
                                :options="cleave_options.percent">
                            </cleave>

                        </b-form-group>
                    </b-col>
                    <b-col sm="4">
                        <b-form-group>
                            <label for="contract_start">วันที่สัญญาเริ่มต้น :<span class="require">*</span></label>
                            <my-date-picker ref="start" :id="1" :showDate="contract_start" @update="value => contract_start = value"></my-date-picker>
                        </b-form-group>
                    </b-col>
                    <b-col sm="4">
                        <b-form-group>
                            <label for="contract_end">วันที่สัญญาสิ้นสุด :<span class="require">*</span></label>
                            <my-date-picker ref="end" :id="2" :showDate="contract_end" @update="value => contract_end = value"></my-date-picker>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row align-h="center">
                    <b-col cols="7">
                        <show-alert :message="message" @clearMessage="clearMessage"></show-alert>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col>
                        <div class="text-center" style="margin-bottom:5px;">
                            <b-button type="submit" variant="dark" :disabled="isDisable">บันทึกข้อมูล</b-button>
                        </div>
                    </b-col>
                </b-row>
            </b-form>
            </validation-observer>
            </b-card>
            </b-col>
        </b-row>
        <b-row class="justify-content-md-center">
            <b-col cols="12">
                <contract-edit :refund_id="refund_id" :office_id="office_id"></contract-edit>
            </b-col>
        </b-row>

    </div>
</template>
<script>
import { Switch as cSwitch } from '@coreui/vue'
export default {
    props: ['refund_id','office_id'],
    data(){
        return {
            //office_id: 0,//this.$store.getters.office_id,
            r_id: this.$route.params.id,
            contract_id: 0,
            contract_party: '',
            contract_no: '',
            contract_date: '',
            budget: '',
            penalty_type: 1,
            icon_check: 'far fa-check-square fa-lg',
            icon_uncheck: 'far fa-square fa-lg',
            penalty_per_day: '',
            penalty_per_day_percent: '',
            contract_start: '',
            contract_end: '',
            date_sign: '',
            date_start: '',
            date_end: '',
            alert: '',
            contract_status: 'new',
            contract: {},
            cleave_options:{
                number: {
                    prefix: '',
                    numeral: true,
                    numeralPositiveOnly: true,
                    noImmediatePrefix: true,
                    rawValueTrimPrefix: true,
                    numeralIntegerScale: 15,
                    numeralDecimalScale: 2
                },
                percent: {
                    prefix: '',
                    numeral: true,
                    numeralPositiveOnly: true,
                    noImmediatePrefix: true,
                    rawValueTrimPrefix: true,
                    numeralIntegerScale: 2,
                    numeralDecimalScale: 2
                },
            },
            refund_status: this.$store.getters.refund_status,
            message: '',
            currency_unit: 'THB'
        }
    },
    validations: {

    },
    async mounted(){
        this.office_id = this.$store.getters.office_id;
        await this.fetchContract();
        this.$forceUpdate();
    },
    computed: {
        isDisable(){
            return (this.refund_status > 7 && this.refund_status != 11) && this.$store.getters.user.type != 'admin' ? true : false
        }

    },
    watch: {
        contract_start(newDate, oldDate){
            if (this.contract_start != '' && this.contract_end){
                if (!this.checkDate(newDate,this.contract_end)){
                    this.$nextTick(() => {
                        this.contract_start = oldDate;
                        //this.date_start = oldDate;
                    })
                }
            }
        },
        contract_end(newDate, oldDate){
            if (this.contract_end != '' && this.contract_start){
                if (!this.checkDate(this.contract_start,newDate)){
                    this.$nextTick(() => {
                        this.contract_end = oldDate;
                        //this.date_end = oldDate;
                    })
                }
            }
        },
        penalty_type(newVal, oldVal){
            if (newVal == 1){
                this.penalty_per_day_percent = '';
            }else if (newVal == 2){
                this.penalty_per_day = '';
            }
        }

    },
    methods: {
        clearMessage(){
            this.message = ''
        },
        getValidationState({ dirty, validated, valid = null }) {
            return dirty || validated ? valid : null;
        },
        async onContractSubmit(e){

            if (!this.penalty_type || this.penalty_type == 0){

                this.message = "กรุณาบันทึกค่าปรับ";
                return;
            }else{
                if (this.penalty_type == 1){
                    if (this.penalty_per_day < 0 || this.penalty_per_day == ''){
                        this.message = "กรุณาบันทึกค่าปรับ";
                        return;
                    }
                }else if (this.penalty_type == 2){
                    if (this.penalty_per_day_percent < 0 || this.penalty_per_day_percent == ''){
                        this.message = "กรุณาบันทึกค่าปรับ";
                        return;
                    }
                }
            }
            var contract = {};

            //return
            if (this.contract_status == 'new'){
                try {
                    let path = await `/api/offices/${this.office_id}/refunds/${this.r_id}/contracts`;
                    let response = await axios.post(`${path}`,{
                        contract_party: this.contract_party,
                        contract_no:    this.contract_no,
                        contract_date:  this.contract_date,
                        budget:         this.budget,
                        currency_unit:  this.currency_unit,
                        penalty_type:   this.penalty_type,
                        penalty_per_day: this.penalty_per_day,
                        penalty_per_day_percent: this.penalty_per_day_percent,
                        contract_start: this.contract_start,
                        contract_end:   this.contract_end,
                    })
                    this.contract_status = await 'update';
                    this.alert = await 'success';
                    // this.contract = contract;
                    await this.$emit("refund_update");
                    await this.$forceUpdate();
                } catch (error) {
                    this.alert = 'error';
                }
                // let response = axios.post(`${path}`,{
                //     contract_party: this.contract_party,
                //     contract_no:    this.contract_no,
                //     contract_date:  this.contract_date,
                //     budget:         this.budget,
                //     penalty_type:   this.penalty_type,
                //     penalty_per_day: this.penalty_per_day,
                //     penalty_per_day_percent: this.penalty_per_day_percent,
                //     contract_start: this.contract_start,
                //     contract_end:   this.contract_end,
                // })
                // .then(response=>{
                //     this.contract_status = 'update';
                //     this.alert = 'success';
                //     // this.contract = contract;
                //     this.$emit("refund_update");
                //     this.$forceUpdate();
                // })
                // .catch(error=>{
                //     this.alert = 'error';
                // })
            }else{
                try {
                    let path = await `/api/offices/${this.office_id}/refunds/${this.r_id}/contracts/${this.contract_id}`;
                    let response = await axios.put(`${path}`,{
                        contract_party: this.contract_party,
                        contract_no:    this.contract_no,
                        contract_date:  this.contract_date,
                        budget:         this.budget,
                        currency_unit:  this.currency_unit,
                        penalty_type:   this.penalty_type,
                        penalty_per_day: this.penalty_per_day,
                        penalty_per_day_percent: this.penalty_per_day_percent,
                        contract_start: this.contract_start,
                        contract_end:   this.contract_end,
                    });
                    this.contract_status = await 'update';
                    this.alert = await 'success';
                    await this.$emit("refund_update");
                    this.$forceUpdate();
                } catch (error) {
                    this.alert = 'error';
                }
                // let path = `/api/offices/${this.office_id}/refunds/${this.r_id}/contracts/${this.contract_id}`;
                // axios.put(`${path}`,{
                //     contract_party: this.contract_party,
                //     contract_no:    this.contract_no,
                //     contract_date:  this.contract_date,
                //     budget:         this.budget,
                //     penalty_type:   this.penalty_type,
                //     penalty_per_day: this.penalty_per_day,
                //     penalty_per_day_percent: this.penalty_per_day_percent,
                //     contract_start: this.contract_start,
                //     contract_end:   this.contract_end,
                // })
                // .then(response=>{
                //     this.contract_status = 'update';
                //     this.alert = 'success';
                //     this.$forceUpdate();
                // })
                // .catch(error=>{
                //     this.alert = 'error';
                // })
            }

        },
        fetchContract(){
            var contract = {};
            var path = `/api/offices/${this.office_id}/refunds/${this.r_id}/contracts`;
            axios.get(`${path}`)
            .then(response=>{


                if (response.data.data.length > 0){
                    this.contract = response.data.data[0];
                    // this.contract_id = this.contract.id;
                    // this.contract_party = this.contract.contract_party;
                    // this.contract_no = this.contract.contract_no;
                    // this.contract_date = this.contract.contract_date;
                    // this.showDatePick('contract_date',this.contract.contract_date);
                    // this.budget = this.contract.budget;
                    // this.penalty_per_day = this.contract.penalty_per_day;

                    // this.showDatePick('start',this.contract.contract_start);
                    // this.showDatePick('end',this.contract.contract_end);
                    // this.contract_start = this.contract.contract_start;
                    // this.contract_end = this.contract.contract_end;
                    this.showContract();
                    this.contract_status = 'update';
                    this.$forceUpdate();
                }


            })
            this.$emit("refund_update");
        },
        showDatePick(refName,value){
            this.$nextTick(() => {
                this.$refs[refName].date = value;
            })
            this.$forceUpdate();
        },
        clearContract(){
            this.contract_id = 0;
            this.contract_party = '';
            this.contract_no = '';
            this.contract_date = '';
            this.budget = '';
            this.currency_unit = 'THB';
            this.penalty_per_day = 0.00;
            this.penalty_per_day_percent = 0.00;
            this.contract_start = '';
            this.contract_end = '';
            this.$nextTick(() => {
                this.$refs.observer.reset();
            });
        },
        showContract(){

            this.contract_id = this.contract.id;
            this.contract_party = this.contract.contract_party;
            this.contract_no = this.contract.contract_no;
            this.contract_date = this.contract.contract_date;
            //this.showDatePick('contract_date',this.contract.contract_date);
            this.budget = this.contract.budget;
            this.currency_unit = this.contract.currency_unit;
            this.penalty_type = this.contract.penalty_type;
            this.penalty_per_day = this.contract.penalty_per_day;
            this.penalty_per_day_percent = this.contract.penalty_per_day_percent;
            if (!this.penalty_type || this.penalty_type == 0){
                if (this.penalty_per_day || this.penalty_per_day > 0){
                    this.penalty_type = 1
                }else if (this.penalty_per_day_percent || this.penalty_per_day_percent > 0){
                    this.penalty_type = 2
                }
            }

            //this.showDatePick('start',this.contract.contract_start);
            //this.showDatePick('end',this.contract.contract_end);
            this.contract_start = this.contract.contract_start;
            this.contract_end = this.contract.contract_end;
            this.contract_status = 'update';
            this.$forceUpdate();
        },
        checkDate(date1,date2){
            var d1 = new Date(date1);
            var d2 = new Date(date2);
            if (d2 > d1){
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
.btn-group-toggle > .btn{
    cursor: pointer!important;
}
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

</style>
