<template>
    <div class="animated fadeIn">
        <b-card>
            <my-alert :AlertType="alert"></my-alert>

            <div slot="header">
                <strong>รายละเอียดฟอร์ม</strong>
            </div>
            <b-form @submit="onSubmit">
                <b-row>
                    <b-col cols="3">
                        <b-form-group>
                            <label for="form_type">ประเภทแบบฟอร์ม</label>
                            <b-form-select v-model="type" :options="arr_type"></b-form-select>

                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col :cols="type==1? 8 : 12">
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
                    <b-col v-if="type==1">
                        <b-form-group>
                            <label for="minutes_date">เมื่อวันที่</label>
                            <thai-date name="minutes_date" v-model="minutes_date"></thai-date>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col :cols="type==1? 5 : 12">
                        <b-form-group >
                            <label for="name2">รายละเอียดแบบฟอร์ม</label>
                            <b-form-input type="text"
                                v-model="name2"

                                placeholder="ชื่อแบบฟอร์ม เพิ่มเติม">
                            </b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col cols="4" v-if="type==1">
                        <b-form-group >
                            <label for="book_no">เลขที่หนังสือ</label>
                            <b-form-input type="text"
                                v-model="book_no"
                                placeholder="ใส่เลขที่หนังสือ">
                            </b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col cols="3" v-if="type==1">
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
            arr_type: [
                {text: 'ประเภทแบบฟอร์ม', value: 0},
                {text: 'ตามมติ ครม', value: 1},
                {text: 'ตาม พรบ. และระเบียบพัสดุ', value: 2},
                {text: 'อื่นๆ', value: 3},
            ],
            type: 0,
            minutes_date: '',
            book_no: '',
            book_date: '',
            order: 0,
            form_order_list: [],
            form_order_max: 0,
            user: this.$store.getters.user
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
        type(){
            if (this.state == "new"){
                switch (this.type){
                    case 1 :
                        this.name1 = "แบบการถอนคืนเงินรายได้แผ่นดิน ตามมติคณะรัฐมนตรี";
                        this.name2 = "แจ้งตามหนังสือสำนักเลขาธิการคณะรัฐมนตรี";
                        this.book_no = "ด่วนที่สุด ที่ นร 0505/"
                        this.name3 = "แบบถอนคืนตาม "
                        break;
                    case 2 :
                        this.name1 = "แบบถอนคืนเงินรายได้แผ่นดิน ตาม พรบ.การจัดซื้อจัดจ้างและบริหารพัสดุภาครัฐ พ.ศ. 2560";
                        this.name2 = "หรือระเบียบ ข้อบังคับ ข้อบัญญัติ ว่าด้วยการพัสดุของหน่วยงานนั้น ๆ";                        
                        this.name3 = "แบบถอนคืนตาม พรบ.จัดซื้อจัดจ้าง 2560 หรือระเบียบพัสดุ";
                        this.book_no = ""
                        this.minutes_date = "";
                        this.book_date = "";
                        break;
                    case 3 :
                        this.name1 = "";
                        this.name2 = "";                        
                        this.name3 = "";
                        this.book_no = ""
                        this.minutes_date = "";
                        this.book_date = "";
                        break;
                }
            }
        }
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
                this.$nextTick(()=>{
                     var form = {}
                    form = response.data.data;
                    this.name1 = form.name1;
                    this.name2 = form.name2;
                    this.name3 = form.name3;
                    this.type = form.type;
                    this.minutes_date = form.minutes_date;
                    this.book_no = form.book_no;
                    this.book_date = form.book_date;
                    this.order = form.order;
                    console.log(form);
                })
               
                
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
            this.type = 0;
            this.minutes_date = "";
            this.book_no = "";
            this.book_date = "";
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
                    type : this.type,
                    minutes_date : this.minutes_date,
                    book_no : this.book_no,
                    book_date : this.book_date,
                    order : this.order,
                    create_by : this.user.username,
                    status : 1
                }).then((response)=>{
                    this.alert = "success";
                    this.state = "update";
                    form = response.data.data;
                    this.fid = form.id;
                    // this.name1 = form.name1;
                    // this.name2 = form.name2;
                    // this.name3 = form.name3;
                    // this.order = form.order;
                    //console.log(form);
                this
                })
            }else if (this.state == "update"){
                axios.put(`${path}/${this.fid}`,{
                    name1 : this.name1,
                    name2 : this.name2,
                    name3 : this.name3,
                    type : this.type,
                    minutes_date : this.minutes_date,
                    book_no : this.book_no,
                    book_date : this.book_date,
                    order : this.order,                    
                    status : 1
                }).then((response)=>{
                    this.alert = "success";
                    // form = response.data.data;
                    // this.name1 = form.name1;
                    // this.name2 = form.name2;
                    // this.name3 = form.name3;
                    // this.order = form.order;
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
.form-control, .custom-select, .time-input{
    border-color: rgb(2, 74, 182)!important;
}
</style>
