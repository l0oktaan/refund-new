<template>
    <div class="animated fadeIn">
        <div>
        <my-alert :AlertType="alert"></my-alert>
        <b-form @submit="onSubmit">
            <b-row>
                <b-col>
                    <b-form-group>
                        <label for="name">รายละเอียดเงื่อนไข</label>
                        <b-form-input type="text"
                            placeholder="รายละเอียดเงื่อนไข"
                            name="name"
                            v-model = "consider_name"

                            >
                        </b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col cols="3">
                    <b-form-group label="ปรเภทเงื่อนไข">
                        <b-form-select
                            v-model="consider_type"
                            :options="type_list"
                            name="consider_type"
                        ></b-form-select>
                    </b-form-group>
                </b-col>
                <b-col cols="3" v-if="consider_type==3">
                    <b-form-group label="การตรวจสอบเงื่อนไข">
                        <b-form-select
                            v-model="consider_oper"
                            :options="oper_list"
                            name="consider_oper"
                        ></b-form-select>
                    </b-form-group>
                </b-col>
                <b-col cols="3" v-if="(consider_type==3) && (consider_oper==1)">
                        <b-form-group>
                        <label for="var1">ข้อมูลตรวจสอบ</label>
                        <b-form-input type="text"
                            placeholder="ข้อมูลตรวจสอบ"
                            name="var1"
                            v-model = "consider_var1"
                            >
                        </b-form-input>
                    </b-form-group>
                </b-col>
                <b-col cols="3">
                    <date-picker :first-day-of-week="1"></date-picker>
                </b-col>
            </b-row>

        </b-form>
        </div>
    </div>
</template>
<script>
export default {
    props: ['form_id','rule_id'],
    data(){
        return {
            f_id: 0,
            r_id: 0,
            consider_list : [],
            consider_order: 0,
            consider_name: '',
            consider_type: 0,
            consider_oper: 0,
            consider_var1: '',
            consider_var2: '',
            order_list: ['ลำดับ'],
            type_list: [
                {value: 0, text: 'ประเภทเงื่อนไข'},
                {value: 1, text: 'ใช่หรือไม่'},
                {value: 2, text: 'ใส่ข้อความ'},
                {value: 3, text: 'ตรวจสอบข้อมูล'},
            ],
            oper_list:[
                {value: 0, text: 'ตัวเลือกการตรวจสอบ'},
                {value: 1, text: 'ไม่เกินจำนวนวัน'},
                {value: 2, text: 'ไม่เกินวันที่'},
            ],
            alert: ''
        }
    },
    methods: {
        onSubmit(){

        }
    }
}
</script>
