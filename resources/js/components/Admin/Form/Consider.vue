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
                    <b-form-group label="การตรวจสอบเงื่อนไข">
                        <b-form-select
                            v-model="consider_oper"
                            :options="oper_list"
                            name="consider_oper"
                        ></b-form-select>
                    </b-form-group>
                </b-col>
            </b-row>


            <div class="text-center">
                <b-button type="submit" variant="primary">บันทึกข้อมูล</b-button>
                <b-button type="reset" variant="danger" @click="toCloseCondition">ปิด</b-button>
            </div>
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
            consider_var1: 0,
            consider_var2: 0,
            order_list: ['ลำดับ'],
            oper_list:[
                {value: 0, text: 'ตัวเลือก'},
                {value: 1, text: 'ให้กรอกข้อมูล'},
                {value: 2, text: 'ไม่เกินจำนวนวัน'},
                {value: 3, text: 'ไม่เกินวันที่'},
            ],
            type_list: [
                {value: 0, text: 'ประเภทเงื่อนไข'},
                {value: 1, text: 'ใช่หรือไม่'},
                {value: 2, text: 'ใส่ข้อความ'},
                {value: 3, text: 'ตัวเลข'},
                {value: 4, text: 'วันที่'},
            ],

        }
    }
}
</script>
