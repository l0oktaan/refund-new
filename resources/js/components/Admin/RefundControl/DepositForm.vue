<template>
<div>

<validation-observer ref="observer" v-slot="{ passes }">
     <b-form @submit.stop.prevent="passes(onSubmit)" class="form">
        <b-row>
            <b-col sm="6">
                <validation-provider
                    name="เลขที่เอกสาร"
                    rules="required|numeric|length:10"
                    v-slot="validationContext"
                >
                    <b-form-group>

                        <label for="deposit_no">เลขที่เอกสาร : (นำส่ง/เบิกหักผลักส่ง)<span class="require">*</span></label>
                        <b-form-input type="text"
                            placeholder="เลขที่เอกสาร"
                            name="deposit_no"
                            v-model = "deposit.deposit_no"
                            :state="getValidationState(validationContext)"
                            aria-describedby="input-1-live-feedback"
                            maxlength="10"
                        >
                        </b-form-input>
                        <b-form-invalid-feedback id="input-1-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                </validation-provider>
            </b-col>
            <b-col sm="6">
                <b-form-group>
                    <label for="deposit_date">วันที่ผ่านรายการ :<span class="require">*</span></label>
                    <my-date-picker ref="deposit_date" :id="11" :showDate="date_deposit" @update="value => date_deposit = value"></my-date-picker>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col sm="6">
                <b-form-group>
                    <label for="amount">จำนวนเงินที่นำส่ง  :<span class="require">*</span></label>
                    <cleave placeholder="จำนวนเงิน" name="amount" v-model="deposit.amount" class="form-control" :options="cleave_options.number"></cleave>
                </b-form-group>
            </b-col>
            <b-col sm="6">
                <b-form-group>
                    <label for="amount">จำนวนเงินที่นำส่ง เฉพาะสัญญานี้ :<span class="require">*</span></label>
                    <cleave placeholder="จำนวนเงิน" name="amount_in_contract" v-model="deposit.amount_in_contract" class="form-control" :options="cleave_options.number"></cleave>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <div class="text-center" style="margin-bottom:5px;">
                    <b-button :disabled="isDisable" type="submit" variant="dark">บันทึกข้อมูล</b-button>
                    <b-button type="reset" variant="danger" @click="clearData" >ยกเลิก</b-button>
                </div>
            </b-col>
        </b-row>
    </b-form>
    </validation-observer>
</div>

</template>

<script>
export default {
    props: ['contract_new_id','state'],
    data(){
        return {

            //office_id: this.$store.getters.office_id,
            deposit: {},

            date_deposit: '',

            alert: '',

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
            amount: 0.00
        }
    },
    watch: {

    },
    methods: {
        getValidationState({ dirty, validated, valid = null }) {
            return dirty || validated ? valid : null;
        },
    }
}
</script>

<style scoped>
.form{
    padding: 20px;
}
</style>
