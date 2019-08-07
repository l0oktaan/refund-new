<template>
    <div class="animated fadeIn">
        <div>
        <my-alert :AlertType="alert"></my-alert>
        <b-form @submit="onSubmit">

            <b-form-group>
                <label for="name">รายละเอียดเงื่อนไข</label>
                <b-form-input type="text"
                    placeholder="รายละเอียดเงื่อนไข"
                    name="name"
                    v-model = "c_name"

                    >
                </b-form-input>
                <div class="error" v-if="!$v.c_name.required">กรุณากรอกข้อมูล</div>
                <div class="error" v-if="!$v.c_name.minLength">กรุณากรอกข้อมูลความยาวไม่น้อยกว่า {{$v.c_name.$params.minLength.min}} ตัวอักษร.</div>
            </b-form-group>
            <b-form-group>
                <label for="description">คำอธิบาย</label>
                <b-form-input type="text"
                    placeholder="คำอธิบาย"
                    name="description"
                    v-model = "c_description"
                    >
                </b-form-input>
            </b-form-group>
            <b-row>
                <b-col sm="6">
                    <b-form-group label="ประเภทเงื่อนไข">
                        <b-form-radio-group
                            v-model="c_type"
                            :options="arr_type"
                            name="c_type"
                        ></b-form-radio-group>
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
            consider_var1: 0

        }
    }
}
</script>
