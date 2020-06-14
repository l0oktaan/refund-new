<template>
    <div class="animated fadeIn">
        <b-card>
            <my-alert :AlertType="alert"></my-alert>

            <div slot="header">
                <strong>รายละเอียดฟอร์ม</strong>
            </div>
            <b-form @submit="onSubmit">
                <b-row>
                    <b-col>
                        <b-form-group>
                            <label for="name1">ชื่อแบบฟอร์ม</label>
                            <b-form-input type="text"

                                placeholder="ชื่อแบบฟอร์ม"
                                name="name1"
                                v-model="name1"
                                >
                            </b-form-input>

                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group>
                            <label for="minutes_date">ชื่อแบบฟอร์ม</label>
                            <thai-date name="minutes_date" v-model="minutes_date"></thai-date>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col>
                        <b-form-group >
                            <label for="name2">รายละเอียดแบบฟอร์ม</label>
                            <b-form-input type="text"
                                v-model="name2"

                                placeholder="ชื่อแบบฟอร์ม เพิ่มเติม">
                            </b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group >
                            <label for="book_no">เลขที่หนังสือ</label>
                            <b-form-input type="text"
                                v-model="book_no"
                                placeholder="ใส่เลขที่หนังสือ">
                            </b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group>
                            <label for="book_date">ลงวันที่</label>
                            <thai-date name="book_date" v-model="book_date"></thai-date>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col>
                        <b-form-group>
                            <label for="formName3">ชื่อย่อแบบฟอร์ม</label>
                            <b-form-input type="text" v-model="name3" id="txtFormName3" placeholder="ชื่อแบบฟอร์ม เพิ่มเติม"></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col sm="4">
                         <b-form-group>
                            <label for="month1">ลำดับฟอร์ม</label>
                            <b-form-select v-model="order"

                                name="order"
                                :plain="true"
                                :options="form_order_list"
                                >
                            </b-form-select>

                        </b-form-group>
                    </b-col>
                </b-row>

                <div class="text-center">
                    <b-button type="submit" variant="primary">บันทึกข้อมูล</b-button>
                    <b-button type="reset" variant="danger" @click="toCloseForm">ปิด</b-button>
                </div>

            </b-form>
            <form-rule-list :form_id="fid" v-show="state=='update'"></form-rule-list>
        </b-card>

    </div>
</template>
<script>

export default {
    props: ['form_id','fCount'],
    data(){
        return{
            alert: '',
            state: 'new',
            form: {},
            submitStatus: null,
            fid: 0,
            name1: '',
            name2: '',
            name3: '',
            type: [

            ],
            minutes_date: '',
            book_no: '',
            book_date: '',
            order: 0,
            form_order_list: [],
            form_order_max: 0
        }
    },

    created(){

    },
    mounted() {
        if (this.form_id > 0){
                this.fid = this.form_id;
                this.fetchData();
            }else{
                this.state = "new";
                this.clearForm();
                //console.log("reset");
            }
            this.getFormOrderList();
    },
    watch: {
        // form_id(){
        //     console.log("show :" + this.form_id);
        //     if (this.form_id > 0){
        //         this.fid = this.form_id;
        //         this.fetchData();
        //     }else{
        //         this.state = "new";
        //         this.clearForm();
        //         console.log("reset");
        //     }
        //     this.getFormOrderList();
        // }
    },
    computed: {

    },
    methods: {

        fetchData(){
            let path = `/api/forms/${this.fid}`;
            this.state = "update";
            //console.log('path' + path);
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
        getFormOrderList(){
            var max = this.fCount;
            var order = [];

            order.push({'value': 0, text: 'ลำดับ'});
            if (this.state == "new"){
                max = max + 1;
            }
            for (let i = 1; i <= max; i++){
                order.push({value: i, text: i});
            }
            this.form_order_list = order;
            this.form_order_max = order[order.length-1].value;


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
            this.$root.$emit('fetchData');
        },
        clearForm(){
            //this.form_id = 0;
            this.fid = 0;
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
                    this.fid = form.id;
                    this.name1 = form.name1;
                    this.name2 = form.name2;
                    this.name3 = form.name3;
                    this.order = form.order;
                    //console.log(form);
                this
                })
            }else if (this.state == "update"){
                axios.put(`${path}/${this.fid}`,{
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
                    //console.log(error);
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
</script>
<style scoped>

</style>
