<template>
    <div class="animated fadeIn">
        <b-card>
            <my-alert :AlertType="alert"></my-alert>

            <div slot="header">
                <strong>รายละเอียดฟอร์ม</strong>
            </div>
            <b-form @submit="onSubmit">
                <b-form-group id="gName1" label="ชื่อแบบฟอร์ม" label-for="name1" :class="{'form-group-error': $v.name1.$error }">
                    <b-form-input type="text"
                        id="name1"
                        placeholder="ชื่อแบบฟอร์ม"
                        name="name1"
                        @blur="$v.name1.$touch()"
                        v-model="name1"
                        >
                    </b-form-input>
                    <div class="error" v-if="!$v.name1.required">กรุณากรอกข้อมูล</div>
                    <div class="error" v-if="!$v.name1.minLength">กรุณากรอกข้อมูลความยาวไม่น้อยกว่า {{$v.name1.$params.minLength.min}} ตัวอักษร.</div>
                </b-form-group>
                <b-form-group :class="{'form-group-error': $v.name2.$error }">
                    <label for="name2">ชื่อแบบฟอร์ม เพิ่มเติม</label>
                    <b-form-input type="text"
                        v-model.trim="$v.name2.$model"
                        id="name2"
                        placeholder="ชื่อแบบฟอร์ม เพิ่มเติม">
                    </b-form-input>
                    <div class="error" v-if="!$v.name2.required">กรุณากรอกข้อมูล</div>
                    <div class="error" v-if="!$v.name2.minLength">กรุณากรอกข้อมูลความยาวไม่น้อยกว่า {{$v.name2.$params.minLength.min}} ตัวอักษร.</div>
                </b-form-group>
                <b-form-group :class="{invalid: $v.name1.$error}">
                    <label for="formName3">ชื่อแบบฟอร์ม เพิ่มเติม</label>
                    <b-form-input type="text" v-model="name3" id="txtFormName3" placeholder="ชื่อแบบฟอร์ม เพิ่มเติม"></b-form-input>
                </b-form-group>
                <b-row>
                    <b-col sm="4">
                         <b-form-group :class="{'form-group-error': $v.order.$error }">
                            <label for="month1">ลำดับฟอร์ม</label>
                            <b-form-select v-model="order"
                                id="order"
                                name="order"
                                :plain="true"
                                :options="[1,2,3,4,5,6,7,8,9,10,11,12]"
                                @blur="$v.order.$touch">
                            </b-form-select>
                            <div class="error" v-if="!$v.order.required">กรุณากรอกข้อมูล</div>
                        </b-form-group>
                    </b-col>
                </b-row>

                <div class="text-center">
                    <b-button type="submit" variant="primary">บันทึกข้อมูล</b-button>
                    <b-button type="reset" variant="danger" @click="toCloseForm">ยกเลิก</b-button>
                </div>

            </b-form>
            <form-rule-list></form-rule-list>

        </b-card>

    </div>
</template>
<script>
import { validationMixin } from 'vuelidate'
import { required,minLength } from 'vuelidate/lib/validators'
export default {
    props: ['form_id'],
    data(){
        return{
            alert: '',
            state: 'new',
            form: {},
            submitStatus: null,
            name1: '',
            name2: '',
            name3: '',
            order: 0,
        }
    },
    mixins: [validationMixin],
    validations: {
        name1: {
            required,
            minLength: minLength(4)
        },
        name2: {
            required,
            minLength: minLength(4)
        },
        order: {
            required
        }
    },
    created(){

    },
    watch:{
        form_id(){
            console.log('start');
            if (this.form_id > 0){
                this.fetchData();
            }else{
                this.$v.$reset();
                console.log("Rest Valid")
            }

        }
    },
    computed: {

    },
    methods: {

        fetchData(){
            let path = `/api/forms/${this.form_id}`;
            this.state = "update";
            console.log('path' + path);
            axios.get(path)
            .then(response=>{
                var form = {}
                form = response.data.data;
                this.name1 = form.name1;
                this.name2 = form.name2;
                this.name3 = form.name3;
                this.order = form.order;
                console.log(form);
            })
        },
        showModal2(){
            //var modalName = 'modal-2'+this.form_id
            var modalName
            if (this.form_id == null ){
                modalName = 'modalRule'
            }else{
                modalName = 'modal-2'+this.form_id
                this.status = "edit"
            }
            this.$root.$emit('bv::show::modal',modalName);
        },
        toCloseForm(){
            this.clearForm();
            this.$root.$emit('bv::hide::modal','modalForm');
        },
        clearForm(){
            //this.form_id = 0;
            this.name1 = "";
            this.name2 = "";
            this.name3 = "";
            this.order = 0;
        },
        onSubmit(e){
            e.preventDefault();

            this.$v.$touch()
            if (this.$v.$invalid) {
                this.submitStatus = 'ERROR'
            } else {
                let path;
                path = '/api/forms';
                var form = {};
                if (this.state == "new"){
                    axios.post(path,{
                        name1 : this.name1,
                        name2 : this.name2,
                        name3 : this.name3,
                        order : this.order,
                        create_by : 'Songwut',
                        status : 1
                    }).then((response)=>{
                        this.alert = "success";
                        this.state = "update";

                        form = response.data.data;
                        this.form_id = form.id;
                        this.name1 = form.name1;
                        this.name2 = form.name2;
                        this.name3 = form.name3;
                        this.order = form.order;
                        console.log(form);
                    this
                    })
                }else if (this.state == "update"){
                    axios.put(`${path}/${this.form_id}`,{
                        name1 : this.name1,
                        name2 : this.name2,
                        name3 : this.name3,
                        order : this.order,
                        create_by : 'Songwut',
                        status : 1
                    }).then((response)=>{
                        this.alert = "success";
                        form = response.data.data;
                        this.name1 = form.name1;
                        this.name2 = form.name2;
                        this.name3 = form.name3;
                        this.order = form.order;
                    }).catch(error=>{
                        console.log(error);
                        this.alert = "error";
                    })

                }
                this.submitStatus = 'PENDING'
                setTimeout(() => {
                this.submitStatus = 'OK'
                }, 500)
            }

        }

    }
}
</script>
