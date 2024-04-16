<template>
    <!-- <div>
       <b-tabs active-tab-class="tab-active">
            <b-tab>
                <template slot="title">
                    <h6>เลือกหน่วยงาน</h6>
                    <span></span>
                </template>
                <b-form-group>
                    <label for="time_edit_date">หน่วยงาน<span class="require">*</span></label>
                    <b-input-group>
                        <b-form-input
                            list="my-list-id"
                            v-model="office"
                            :required="true"

                        >
                        </b-form-input>
                        <b-input-group-append class="btnClear" @click="clear_office">
                            <b-input-group-text>
                                <b-icon icon="x" />
                            </b-input-group-text>
                        </b-input-group-append>
                        <datalist id="my-list-id">
                            <option v-for="(item,index) in offices" :key="index" :value="item.name"></option>
                        </datalist>
                    </b-input-group>
                </b-form-group>
            </b-tab>
            <b-tab :disabled="false">
                <template slot="title">
                    <h6>รายการสัญญา</h6>
                    <span></span>

                </template>
                <contract-list :office="office" :office_id="office_id"></contract-list>
            </b-tab>
       </b-tabs>
    </div> -->
    <div class="control-container">
        <div class="search-box">
            <b-form @submit.stop.prevent="passes(onSubmit)" class="form">
                <b-row>
                    <b-col sm="12" class="text-center">
                        <h3>การค้นหารายการ</h3>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col sm="12">
                        <b-form-group label="ประเภทรายการ" v-slot="{ ariaDescribedby }">
                            <b-form-radio-group
                                id="radio-group-2"
                                v-model="search_selected"
                                :aria-describedby="ariaDescribedby"
                                name="radio-sub-component"                            >
                                <b-form-radio value="1">ภาษีสรรพสามิต</b-form-radio>
                                <b-form-radio value="2">ค่าปรับ และกรณีอื่น ๆ</b-form-radio>
                            </b-form-radio-group>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col sm="6">
                        <b-form-group>
                            <label for="refund">เลขที่เอกสารนำส่ง :<span class="require">*</span></label>
                            <b-form-input type="text"
                                placeholder="เลขที่เอกสารนำส่ง"
                                name="refund_case"
                                maxlength="10"
                            >
                            </b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col sm="6">
                        <b-form-group>
                            <label for="approve_date">วันที่ผ่านรายการ :<span class="require">*</span></label>
                            <my-date-picker ref="approve_date" :id="11" :showDate="date_approve" @update="value => date_approve = value"></my-date-picker>
                        </b-form-group>
                    </b-col>
                    <b-col sm="12" v-if="search_selected == 2">
                        <b-form-group>
                            <label for="time_edit_date">หน่วยงาน<span class="require">*</span></label>
                            <b-input-group>
                                <b-form-input
                                    list="my-list-id"
                                    v-model="office"
                                    :required="true"

                                >
                                </b-form-input>
                                <b-input-group-append class="btnClear" @click="clear_office">
                                    <b-input-group-text>
                                        <b-icon icon="x" />
                                    </b-input-group-text>
                                </b-input-group-append>
                                <datalist id="my-list-id">
                                    <option v-for="(item,index) in offices" :key="index" :value="item.name"></option>
                                </datalist>
                            </b-input-group>
                        </b-form-group>


                    </b-col>


                </b-row>
                <b-row>

                </b-row>
                <b-row>
                    <b-col>
                        <div class="text-center" style="margin-bottom:5px;">
                            <b-button :disabled="isDisable" type="submit" variant="dark">ค้นหา</b-button>
                            <!-- <b-button type="reset" variant="danger" @click="clearData" >ยกเลิก</b-button> -->
                        </div>
                    </b-col>
                </b-row>
            </b-form>
        </div>
        <div class="box-list">
            <deposit-list :office="office" :office_id="office_id"></deposit-list>
        </div>
    </div>
</template>
<script>

export default{

    data(){
        return {
            office: null,
            office_id: null,
            offices: [],
            refund: {},
            date_approve: null,
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
            amount: 0.00,
            search_selected: 1
        }
    },
    watch: {
        // 'office' : function (newValue,oldValue){
        //         if (newValue == oldValue){
        //             return;
        //         }
        //         this.office_id = newValue ? this.offices.find(x=>x.name == newValue).id : null
        //     },
    },
    mounted(){
        this.getOffice();
    },
    methods:{
        async getOffice(){
            let path = await '/api/offices';
            let response = await axios.get(path);
            this.offices = response.data.data;

        },
        clear_office(){

            this.office = null;
        },
    }
}
</script>
<style scoped>
.content{
    width: 100%;
    display: flex;
    justify-content: right;
    align-items: flex-start;
    flex-direction: column;
}
.form{
    display: block;
    width: 800px;
    align-self: center;
}
.form{
    border: 1px solid #5a5a5a;
    border-radius: 5px;
    margin: 10px;
    padding: 5px 30px 10px 30px;
}
.col_name{
    text-align: right;
}

.btnClear{
    cursor: pointer;
}

.control-container{
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}
.box-list{
    width: 100%;
}
</style>
