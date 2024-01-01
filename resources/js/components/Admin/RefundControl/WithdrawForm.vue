<template>
<div>

<validation-observer ref="observer" v-slot="{ passes }">
     <b-form @submit.stop.prevent="passes(onSubmit)" class="form">
        <b-row>
            <b-col sm="6">
                <b-form-group>
                    <label for="amount">จำนวนเงิน  :<span class="require">*</span></label>
                    <cleave placeholder="จำนวนเงิน" name="amount" v-model="refund.amount" class="form-control" :options="cleave_options.number"></cleave>
                </b-form-group>
            </b-col>
            <b-col sm="6">
                <b-form-group>
                    <label for="amount">สิทธิคงเหลือ :<span class="require">*</span></label>
                    <cleave placeholder="จำนวนเงิน" name="amount_in_contract" v-model="refund.amount_in_contract" class="form-control" :options="cleave_options.number"></cleave>
                </b-form-group>
            </b-col>
            <b-col sm="6">
                <b-form-group>
                    <label for="refund">อนุมัติให้ตาม :<span class="require">*</span></label>
                    <b-form-input type="text"
                        placeholder="กฎหมาย ระเบียบ ข้อบังคับ หรือมติ ครม. ที่เกี่ยวข้อง"
                        name="refund_case"
                        v-model = "refund.refund_case"

                        maxlength="10"
                    >
                    </b-form-input>

                </b-form-group>
            </b-col>
            <b-col sm="6"></b-col>
            <b-col sm="6">
                <validation-provider
                    name="เลขที่เอกสาร"
                    rules="required"
                    v-slot="validationContext"
                >
                    <b-form-group>
                        <label for="deposit_no">เลขที่หนังสือกรมบัญชีกลางอนุมัติ<span class="require">*</span></label>
                        <b-form-input type="text"
                            placeholder="เลขที่เอกสาร"
                            name="approve_book_no"
                            v-model = "refund.approve_book_no"
                            :state="getValidationState(validationContext)"
                            aria-describedby="input-1-live-feedback"
                            maxlength="250"
                        >
                        </b-form-input>
                        <b-form-invalid-feedback id="input-1-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                </validation-provider>
            </b-col>
            <b-col sm="6">
                <b-form-group>
                    <label for="approve_date">หนังสือลงวันที่ :<span class="require">*</span></label>
                    <my-date-picker ref="approve_date" :id="11" :showDate="date_approve" @update="value => date_approve = value"></my-date-picker>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>

        </b-row>
        <b-row>
            <b-col>
                <div class="text-center" style="margin-bottom:5px;">
                    <b-button :disabled="isDisable" type="submit" variant="dark">บันทึกข้อมูล</b-button>
                    <!-- <b-button type="reset" variant="danger" @click="clearData" >ยกเลิก</b-button> -->
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
            refund: {},

            date_approve: '',

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
