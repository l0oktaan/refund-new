<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
        <b-form @submit="onSubmit">
            <b-form-group :class="{'form-group-error': $v.rule.name.$error }">
                <label for="name">ชื่อหลักเกณฑ์</label>
                <b-form-input type="text"

                    placeholder="ชื่อหลักเกณฑ์"
                    name="name"
                    v-model = "rule.name"
                    @blur="$v.rule.name.$touch()"
                    >
                </b-form-input>
                <div class="error" v-if="!$v.rule.name.required">กรุณากรอกข้อมูล</div>
                <div class="error" v-if="!$v.rule.name.minLength">กรุณากรอกข้อมูลความยาวไม่น้อยกว่า {{$v.rule.name.$params.minLength.min}} ตัวอักษร.</div>
            </b-form-group>
            <b-row>
                <b-col sm="4">
                    <b-form-group label="ตัวเลือกหลักเกณฑ์">
                        <b-form-radio-group
                            v-model="r_opt"
                            :options="rule_options"
                            name="ruleOption"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>
                <b-col sm="8">
                    <b-form-group v-if="r_opt==1">
                        <label for="mainRule">หลักเกณฑ์หลัก</label>
                        <b-form-select v-model="rule.sub_of"
                            :plain="true"
                            name="mainRule"
                            :options="rule_list"
                        >
                        </b-form-select>
                        <div class="error" v-if="!$v.rule.order.minValue">กรุณากรอกข้อมูล</div>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col sm="4">
                    <b-form-group>
                        <label for="order">ลำดับหลักเกณฑ์</label>
                        <b-form-select v-model="$v.rule.order.$model"
                            name="order"
                            :plain="true"
                            :options="order_list"
                        >
                        </b-form-select>
                        <div class="error" v-if="!$v.rule.order.minValue">กรุณากรอกข้อมูล</div>
                    </b-form-group>
                </b-col>
            </b-row>
            <div class="text-center">
                <b-button type="submit" variant="primary">บันทึกข้อมูล</b-button>
                <b-button type="reset" variant="danger" @click="toCloseRule">ปิด</b-button>
            </div>
            <p>rule Sub of : {{rule.sub_of}}</p>
            <p>rule option : {{r_opt}}</p>
        </b-form>
    </div>
</template>
<script>

import { validationMixin } from 'vuelidate'
import { required, minLength, minValue } from 'vuelidate/lib/validators'

export default {
    props: ['form_id','rule_id','sub_of'],
    data(){
        return {
            r_id: -1,
            rule: {
                id: 0,
                name: '',
                order: 0,
                options: 0,
                sub_of: 0,
                rule_type: 0,
                result_type: 0,
                status: 1
            },
            state: 'new',
            order_list: [],
            rule_list: [],
            r_opt: -1,
            rule_options: [
                {value: 0, text: 'หลักเกณฑ์หลัก'},
                {value: 1, text: 'หลักเกณฑ์ย่อย'}
            ],
            rule_sub_of: [],
            rule_type: [
                {value: 0, text: 'ประเภทหลักเกณ์'},
                {value: 1, text: 'ป้อนค่า'},
                {value: 2, text: 'ตรงทุกข้อ'},
                {value: 3, text: 'ข้อใดข้อหนึ่ง'},
            ],
            result_type: [

            ],
            alert: ''

        }
    },
    mixins: [validationMixin],
    validations: {
        rule: {
            order:{
                minValue: minValue(1)
            },
            name:{
                required,
                minLength: minLength(4)
            }
        }
    },
    watch : {
        rule_id(){
            this.r_id = this.rule_id;

            console.log('watch rule!!!');
            if (this.r_id > 0){
                this.state = 'update';
                this.fetchData();
                this.getOrderList();
            }else if (this.r_id == 0){
                this.state = 'new';
                this.$v.$reset();
                this.clearData();
                this.getOrderList();
            }

        }
    },
    methods: {
        onSubmit(e){
            e.preventDefault();
            var path = `/api/forms/${this.form_id}/form_rules`;
            //console.log('name rule : ' + this.rule.name+' ' + this.rule.order+ ' ' + this.rule.sub_of+' ' + this.rule.rule_type+' ' + this.rule.status);
            if (this.state == 'new'){
                axios.post(path,{
                    name: this.rule.name,
                    order: this.rule.order,
                    sub_of: this.rule.sub_of,
                    rule_type: this.rule.rule_type,
                    result_type: this.rule.result_type,
                    status: this.rule.status,
                })
                .then(response=>{
                    this.rule = response.data.data;
                    this.alert = "success"
                })
                .catch(error=>{
                    this.alert = "error";
                })
            }else if (this.state == 'update'){
                //console.log('update rule id:' + this.rule.id);
                console.log('name rule : ' + this.rule.name+' ' + this.rule.order+ ' ' + this.rule.sub_of+' ' + this.rule.rule_type+' ' + this.rule.status);
                path = `${path}/${this.r_id}`;
                axios.put(`${path}`,{
                    name: this.rule.name,
                    order: this.rule.order,
                    sub_of: this.rule.sub_of,
                    rule_type: this.rule.rule_type,
                    result_type: this.rule.result_type,
                    status: this.rule.status,
                })
                .then(response=>{
                    this.alert = "success";
                    this.rule = response.data.data;
                })
                .catch(error=>{
                    this.alert = "error";
                })
            }
        },
        fetchData(){
            var path = `/api/forms/${this.form_id}/form_rules/${this.r_id}`;
            var rule = {};
            //this.clearData();
            axios.get(path)
            .then(response=>{
                rule = response.data.data;
                //console.log('get rule: '+ rule);
                this.rule = rule;
                //console.log('get rule :' + this.rule.sub_of);
                this.$forceUpdate();
                if(this.rule.sub_of == 0){
                    this.r_opt = 0;
                }else{
                    this.r_opt = 1;
                }
            })
        },
        clearData(){
            this.r_id = 0;
            this.state = 'new';
            this.order_list = [];
            this.rule.id = 0;
            this.rule.name = '';
            this.rule.order = 0;
            this.rule.sub_of = 0;
            this.rule.type = 0;
            this.rule.options = 0;
            this.rule.result_type = 0;
            this.r_opt = -1;
            this.rule_list = [];
        },
        /* ค้นหาหลักเกณฑ์ย่อย ของหลักเกณฑ์ */
        getSubRule(rule_id){
            var subRules = [];
            var path = `/api/forms/${this.form_id}/form_rules?sub_of=${rule_id}`;
            axios.get(`${path}`)
            .then(response=>{
                subRules = response.data.data;
            })
            .catch(error=>{
                subRules = [];
            })
            return subRules;
        },
        getOrderList(){

            var order = [];
            var rules = [];
            var order_max = 0;
            var path = `/api/forms/${this.form_id}/form_rules`;
            if (this.sub_of > 0){
                path = `${path}?sub_of=${this.sub_of}`;
            }
            console.log('path: '+ path);
            axios.get(path)
            .then(response=>{
                rules = response.data.data;
                //Add rule list to select
                console.log('rule length:' + rules.length);
                this.rule_list = [];
                this.rule_list.push({value: 0, text: 'หลักเกณฑ์หลัก'});

                for (let i = 0; i < rules.length ; i++){
                    this.rule_list.push({value: rules[i].id, text: rules[i].name});
                }
                //console.log('rule :' + rules.length);
                order_max = rules.length;
                //console.log('order_max:'+ order_max + 'state :' + this.state + ' rule id :' + this.rule_id + ' r_id :' + this.r_id);
                if (this.state == 'new'){
                    order_max = order_max + 1;
                }
                order.push({value: 0, text: 'ลำดับ'})
                for (let i = 1 ; i <= order_max ; i++){
                    order.push({value: i, text: i});
                }
                //console.log('order :' + order);
                this.order_list = order;
            })
        },
        getAllRule(){

        },
        toCloseRule(){

            this.clearData();
            this.$root.$emit('bv::hide::modal','modalRule');
            this.$root.$emit('fetchData');
        },
    }
}
</script>
<style scoped>
.error{
    color: red;
}
</style>
