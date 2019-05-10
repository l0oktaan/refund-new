<template>
    <div class="animated fadeIn">
        <b-card>
            <my-alert :AlertType="alert"></my-alert>

            <div slot="header">
                <strong>รายละเอียดฟอร์ม</strong>
            </div>
            <b-form @submit="onSubmit">
                <b-form-group id="lblName1" label="name1" label-for="txtFormName1">
                    <label for="formName1">ชื่อแบบฟอร์ม</label>
                    <b-form-input type="text" v-model="name1"
                        id="txtFormName1"
                        placeholder="ชื่อแบบฟอร์ม"
                        :value="form_id"
                        name="formName1"
                        v-validate="{ required: true, min:2 }"
                        :state="validateState('name1')"
                        aria-describedby="input-1-live-feedback">
                    </b-form-input>
                    <b-form-invalid-feedback id="input-1-live-feedback">
                        This is a required field and must be at least 3 characters
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group>
                    <label for="formName2">ชื่อแบบฟอร์ม เพิ่มเติม</label>
                    <b-form-input type="text" v-model="name2" id="txtFormName2" placeholder="ชื่อแบบฟอร์ม เพิ่มเติม"></b-form-input>
                </b-form-group>
                <b-form-group>
                    <label for="formName3">ชื่อแบบฟอร์ม เพิ่มเติม</label>
                    <b-form-input type="text" v-model="name3" id="txtFormName3" placeholder="ชื่อแบบฟอร์ม เพิ่มเติม"></b-form-input>
                </b-form-group>
                <b-row>
                    <b-col sm="4">
                         <b-form-group >
                            <label for="month1">ลำดับฟอร์ม</label>
                            <b-form-select v-model="order"
                                id="order"
                                name="order"
                                :plain="true"
                                :options="[1,2,3,4,5,6,7,8,9,10,11,12]">
                            </b-form-select>
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
export default {
    props: ['form_id'],
    data(){
        return{
            alert: '',
            state: 'new',
            form: {},

            name1: '',
            name2: '',
            name3: '',
            order: 0
        }
    },
    created(){

    },
    watch:{
        form_id(){
            console.log('start');
            if (this.form_id != 0){
                this.fetchData();
            }

        }
    },
    methods: {
        validateState(ref) {
            if (this.veeFields[ref] && (this.veeFields[ref].dirty || this.veeFields[ref].validated)) {
            return !this.errors.has(ref)
            }
            return null
        },
        validateBeforeSubmit(e) {
            this.$validator.validateAll().then((result) => {
            if (result) {
            // eslint-disable-next-line
                alert('Form Submitted!');
                return;
            }

            alert('Correct them errors!');
            e.preventDefault();
        });
        },
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
        }

    }
}
</script>
