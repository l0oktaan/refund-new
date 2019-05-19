<template>
    <div class="animated fadeIn">
        <b-form >
            <b-form-group :class="{'form-group-error': $v.r_name.$error }">
                <label for="name">ชื่อหลักเกณฑ์</label>
                <b-form-input type="text"
                    placeholder="ชื่อหลักเกณฑ์"
                    name="name"
                    v-model = "r_name"
                    @blur="$v.r_name.$touch()"
                    >
                </b-form-input>
                <div class="error" v-if="!$v.r_name.required">กรุณากรอกข้อมูล</div>
                <div class="error" v-if="!$v.r_name.minLength">กรุณากรอกข้อมูลความยาวไม่น้อยกว่า {{$v.r_name.$params.minLength.min}} ตัวอักษร.</div>
            </b-form-group>
            <b-row>
                <b-col sm="4">
                    <b-form-group label="ตัวเลือกหลักเกณฑ์">
                        <b-form-radio-group
                            v-model="r_rule_type"
                            :options="arr_rule_type"
                            name="ruleOption"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>
                <b-col sm="8">
                    <b-form-group v-if="r_rule_type == 2">
                        <label for="mainRule">หลักเกณฑ์หลัก</label>
                        <b-form-select
                            v-model="r_sub_of"
                            :plain="true"
                            name="mainRule"
                            :options="arr_main_rule"
                        >
                        </b-form-select>

                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col sm="4">
                    <b-form-group>
                        <label for="order">ลำดับหลักเกณฑ์</label>
                        <b-form-select
                            v-model="r_order"
                            name="order"
                            :plain="true"
                            :options="arr_rule_order"
                        >
                        </b-form-select>

                    </b-form-group>
                </b-col>
            </b-row>
            {{r_id}}{{r_order}}
            <div class="text-center">
                <b-button type="submit" variant="primary">บันทึกข้อมูล</b-button>
                <b-button type="reset" variant="danger" @click="toCloseRule">ปิด</b-button>
            </div>

        </b-form>
    </div>
</template>
<script>
import { validationMixin } from 'vuelidate'
import { required, minLength, minValue } from 'vuelidate/lib/validators'

export default {
    props: ['form_id','rule_id','main_rule'],
    mixins: [validationMixin],
    validations: {

            r_order:{
                minValue: minValue(1)
            },
            r_name:{
                required,
                minLength: minLength(4)
            }

    },
    data(){
        return {
            r_id: 0,
            r_name: '',
            r_order: 0,
            r_rule_type: 0,
            r_sub_of: 0,
            r_result_type: 0,
            r_status: 0,

            arr_rule_type: [
                {value: 1, text: 'หลักเกณฑ์หลัก'},
                {value: 2, text: 'หลักเกณฑ์ย่อย'}
            ],
            arr_main_rule: [],
            arr_rule_order: [],
            arr_result_type: [
                {value: 0, text: 'ประเภทหลักเกณ์'},
                {value: 1, text: 'ป้อนค่า'},
                {value: 2, text: 'ตรงทุกข้อ'},
                {value: 3, text: 'ข้อใดข้อหนึ่ง'},
            ],
            state: 'new'
        }
    },
    watch : {
        rule_id(){
            if (this.rule_id >= 0){
                if (this.rule_id == 0){
                    this.state = 'new';
                    this.getMainRule();
                }else{
                    this.state = 'update';
                    this.r_id = this.rule_id;
                    this.getMainRule();
                    this.fetchData();
                    this.getOrderRule()
                }
            }
        }
    },

    methods: {
        fetchData(){
            var path = '';
            var rule = {};
            path = `/api/forms/${this.form_id}/form_rules/${this.r_id}`;
            axios.get(path)
            .then(response=>{
                rule = response.data.data;
                this.r_id = rule.id;
                this.r_name = rule.name;
                this.r_order = rule.order;
                this.r_rule_type = rule.rule_type;
                this.r_sub_of = rule.sub_of;
                this.r_result_type = rule.result_type;
                this.r_status = rule.status;

            })
        },
        getMainRule(){
            var path = '';
            var rules = [];
            path = `/api/forms/${this.form_id}/form_rules?sub_of=0`;
            axios.get(path)
            .then(response=>{
                rules = response.data.data;
                this.arr_main_rule = [];
                this.arr_main_rule.push({value: 0, text: 'เลือกเกณฑ์หลัก'});
                for (let i=0 ;i < rules.length ; i++){
                    this.arr_main_rule.push({value: rules[i].id, text: rules[i].name});
                }
            })

        },
        getOrderRule(){
            var path = `/api/forms/${this.form_id}/form_rules?sub_of`;
            var rules = [];
            if (this.r_rule_type == 1){ //เกณฑ์หลัก
                path = `${path}=0`
            }else{
                path = `${path}=${this.r_sub_of}`;
            }
            console.log('get order :' + path);
            axios.get(path)
            .then(response=>{
                rules = response.data.data;
                this.arr_rule_order = [];
                this.arr_rule_order.push({value: 0,text: 'ลำดับ'});
                for (let i=1 ; i < rules.length ; i++){
                    this.arr_rule_order.push({value: i, text: i});
                }
            })
        },
        clearData(){

        },
        toCloseRule(){
            this.clearData();
            this.$root.$emit('bv::hide::modal','modalRule');
            this.$root.$emit('fetchData');
        }
    }
}
</script>

