<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
        <b-form @submit="onSubmit">
            <b-row>
                <b-col sm="4">
                    <b-form-group label="ประเภทเงื่อนไข">
                        <b-form-radio-group
                            v-model="c_type"
                            :options="rule_types"
                            name="c_type"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-form-group>
                <label for="name">ชื่อหลักเกณฑ์</label>
                <b-form-input type="text"

                    placeholder="ชื่อหลักเกณฑ์"
                    name="name"
                    v-model = "c_name"
                    @blur="$v.c_name.$touch()"
                    >
                </b-form-input>
                <div class="error" v-if="!$v.c_name.required">กรุณากรอกข้อมูล</div>
                <div class="error" v-if="!$v.c_name.minLength">กรุณากรอกข้อมูลความยาวไม่น้อยกว่า {{$v.c_name.$params.minLength.min}} ตัวอักษร.</div>
            </b-form-group>


            <div class="text-center">
                <b-button type="submit" variant="primary">บันทึกข้อมูล</b-button>
                <b-button type="reset" variant="danger" @click="toCloseCondition">ปิด</b-button>
            </div>
            <p>rule Sub of : {{rule.sub_of}}</p>
            <p>rule option : {{r_opt}}</p>
        </b-form>
</template>
<script>
import { validationMixin } from 'vuelidate'
import { required, minLength, minValue } from 'vuelidate/lib/validators'
export default {
    props: ['form_id', 'rule_id'],
    data(){
        return {
            c_id: 0,
            c_name: '',
            c_type: 0,
            c_status: 1,

            state: 'new',
            arr_type: [
                {value: 0, text: 'ประเภทของเงื่อนไข'},
                {value: 1, text: 'ใช่หรือไม่'},
                {value: 1, text: 'กำหนดค่า'}
            ],

            alert: ''
        }
    },
    watch: {
        rule_id(){
            if (this.rule_id > 0 ){
                this.fetchData();
            }
        }
    },
    mixins: [validationMixin],
    validations: {

        c_type:{
            minValue: minValue(1)
        },
        c_name:{
            required,
            minLength: minLength(4)
        }

    },methods: {
        toCloseCondition(){

        },
        fetchData(){
            var conditions = [];
            var path = `/api/forms/${form_id}/form_rules/${rule_id}/form_conditions`;
            axios.get(path)
            .then(response=>{
                conditions = response.data.data;
                if (conditions.length > 0){
                    this.c_id = conditions.id;
                    this.c_name = conditions.name;
                    this.c_type = conditions.condition_type;
                    this.c_status = conditions.status;
                }
            })
            .catch(error=>{

            })
        },
        onSubmit(){
            var condition = {};
            var path = `/api/forms/${form_id}/form_rules/${rule_id}/form_conditions`;
            axios.post(path,{
                name: this.c_name,
                condition_type: this.c_type,
                status: this.c_status
            })
            .then(response=>{
                condition = response.data.data;
                this.alert = "success";
                this.c_id = condition.id;
                this.c_name = condition.name;
                this.c_type = condition.condition_type;
                this.c_status = condition.status;
            })
            .catch(error=>{
                this.alert = "error";
            })
        }
    }
}
</script>

