<template>
    <div class="animated fadeIn">

        <my-alert :AlertType="alert"></my-alert>
        <b-card class="bg-secondary">

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
                    <b-col>
                        <b-form-group>
                            <label for="description">คำอธิบายเพิ่มเติม</label>
                            <b-form-input type="text"
                                placeholder="คำอธิบายเพิ่มเติม"
                                name="description"
                                v-model = "consider_description"

                                >
                            </b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col cols="3">
                        <b-form-group label="ประเภทเงื่อนไข">
                            <b-form-select
                                v-model="consider_type"
                                :options="type_list"
                                name="consider_type"
                            ></b-form-select>
                        </b-form-group>
                    </b-col>
                    <b-col cols="3" v-if="consider_type==5">
                        <b-form-group label="หน่วยเป็น:">
                            <b-form-input type="text"
                                placeholder="เช่น วัน บาท"
                                name="var1"
                                v-model = "consider_var1"
                                >
                            </b-form-input>
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

                    <b-col cols="6" v-if="(consider_type==3) && ((consider_oper==1) || (consider_oper==6))">
                            <b-form-group>
                            <label for="var1">ข้อมูลตรวจสอบ</label>
                            <b-form-input type="text"
                                placeholder="จำนวนวัน"
                                name="var1"
                                v-model = "consider_var1"
                                >
                            </b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col cols="6" v-if="(consider_type==3) && (consider_oper > 1 && consider_oper < 5)">
                        <b-form-group>
                            <label for="date1">ข้อมูลตรวจสอบ{{date1}}</label>
                            <my-date-picker ref="d11" :id="11" :showDate="date1" @update="value => consider_var1 = value"></my-date-picker>
                            <div v-if="consider_oper == 3">ถึง</div>
                            <my-date-picker ref="d22" :showDate="showDate2" @update="value => consider_var2 = value" v-if="consider_oper == 3"></my-date-picker>




                        </b-form-group>
                    </b-col>
                    <!-- อยู่ในชุดข้อมูล -->
                    <b-col cols="6" v-if="(consider_type==3) && (consider_oper==5)">
                        <div>
                            <label for="var1">ข้อมูลตรวจสอบ</label>
                           <b-form-tags
                                input-id="tags-pills"
                                v-model="arr_consider_var"
                                tag-variant="primary"
                                tag-pills
                                size="md"
                                separator=" "
                                placeholder="ใส่ข้อมูล โดยแยกข้อมูลด้วยช่องว่าง"
                                class="mb-2"
                                duplicate-tag-text="ข้อมูลซ้ำ"
                                add-button-text="เพิ่ม"
                                add-button-variant="outline-success"
                            ></b-form-tags>
                        </div>

                    </b-col>

                </b-row>
                <div class="text-center">
                    <b-button type="submit" variant="primary">บันทึกเงื่อนไข</b-button>
                    <b-button type="reset" variant="danger" @click="toClearConsider">ยกเลิก</b-button>
                </div>

                <!-- <consider-cover
                    :considers="consider_list"
                    @fetchConsider = "fetchData"
                    @toEdit = 'toEdit'
                    :form_id="form_id"
                ></consider-cover> -->
                <b-card class="bg-primary" v-for="(consider,index) in consider_list" :key="index">
                    <b-card-body class="pb-0 cover">
                        <b-dropdown class="float-right" style="color: #000!important;" variant="transparent p-0" right>
                        <template slot="button-content">
                            <i class="icon-settings sub_rule"></i>
                        </template>
                            <b-dropdown-item @click="toEdit(consider)"><i class="fas fa-link"></i>&nbsp;แก้ไข</b-dropdown-item>

                            <b-dropdown-item @click="delConsider(consider.id,consider.form_rule_id)"><i class="fas fa-trash"></i>&nbsp;ลบ</b-dropdown-item>
                        </b-dropdown>
                        <b-row>
                            <b-col sm="6">
                                <div class="textFiled">เงื่อนไข :{{consider.name}}</div>
                            </b-col>
                        </b-row>
                    </b-card-body>
                </b-card>
            </b-form>
        </b-card>
    </div>
</template>
<script>
import moment from 'moment'
moment.locale('th-TH');
export default {
    props: ['form_id','rule_id'],
    data(){
        return {
            f_id: 0,
            r_id: 0,
            consider_list : [],
            consider_id: 0,
            consider_order: 0,
            consider_name: '',
            consider_description: '',
            consider_type: 0,
            consider_oper: 0,
            consider_var1: '',
            consider_var2: '',
            var_unit: '',
            arr_consider_var: [],
            date1: null,
            showDate1: '',
            showDate2: '',
            order_list: ['ลำดับ'],
            type_list: [
                {value: 0, text: 'ประเภทเงื่อนไข'},
                {value: 1, text: 'ใช่หรือไม่'},
                {value: 2, text: 'ใส่ข้อความ'},
                {value: 5, text: 'ใส่ตัวเลข'},
                {value: 4, text: 'ใส่วันที่'},
                {value: 3, text: 'ตรวจสอบข้อมูล'},
            ],
            oper_list:[
                {value: 0, text: 'ตัวเลือกการตรวจสอบ'},
                {value: 1, text: 'ไม่เกินจำนวนวัน'},
                {value: 2, text: 'ไม่เกินวันที่'},
                {value: 4, text: 'หลังจากวันที่'},
                {value: 3, text: 'อยู่ในช่วงเวลา'},
                {value: 5, text: 'อยู่ในชุดข้อมูล'},
                {value: 6, text: 'ไม่เกินจำนวนวัน (เริ่มต้น-สิ้นสุด)'}
            ],
            alert: '',
            lang: 'th',
            state: 'new',
            alert: '',
            myDate1: '',
            myDate2: '',
            toOpen: false,
            lang: {
                days: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
                months: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
                pickers: ['next 7 days', 'next 30 days', 'previous 7 days', 'previous 30 days'],
                placeholder: {
                    date: 'เลือกวันที่',
                    dateRange: 'Select Date Range'
                },

            },

            dateFormat: "LL",

            dateEdit: 0,

        }
    },
    watch: {

        myDate1(newDate, oldDate){

            if (this.consider_oper == 3){
                if (this.myDate2 != '' || this.myDate2){

                    if (!this.checkDate(newDate,this.myDate2)){
                        this.consider_var1 = oldDate;



                    }
                }
            }
        },
        myDate2(newDate, oldDate){

            if (this.consider_oper == 3){
                if (this.myDate2 != '' || this.myDate2){

                    if (!this.checkDate(this.myDate1,newDate)){
                        this.consider_var2 = oldDate;



                    }
                }
            }
        },
        consider_var1(newDate, oldDate){

             if (this.consider_oper > 1 && newDate != '' && !newDate){
                this.myDate1 = this.consider_var1;
                this.$nextTick(() => {
                    this.$refs.d11.date = this.myDate1;
                })
            }
        },
        consider_var2(newDate, oldDate){
            //console.log('change date 2' + this.consider_var2);
             if (this.consider_oper == 3 && newDate != '' && !newDate){
                this.myDate2 = this.consider_var2;
                this.$nextTick(() => {
                    this.$refs.d22.date = this.myDate2;
                })
            }
        },
    },
    computed: {
        getDate1(){
            var iDate = null;
            try {
                iDate = moment(this.myDate1,this.dateFormat);
            } catch (error) {
                iDate = null;
            }
            return iDate
        },


    },
    mounted(){
        moment.locale('th');
        this.myDate1 = moment(Date(),this.dateFormat);

        this.clearData();
        this.fetchData();
    },

    methods: {
        moment,

        // getDate(myDate){
        //     console.log('Show Date : ' + moment(myDate,"DD/MM/YYYY"));
        //     return moment(myDate,"DD/MM/YYYY");
        // },
        checkDate(date1,date2){

            var d1 = new Date(date1);
            var d2 = new Date(date2);
            if (d2 > d1){
                return true;
            }else{
                this.alert = "error";
                return false;
            }

        },
        getDate(value){
            //console.log(' value : ' + value);
            this.consider_var1 = value;
            this.$forceUpdate();
        },
        checkConsiderType(){
            if (this.consider_type < 3){
                this.consider_oper = 0;
                this.consider_var1 = '';
                this.consider_var2 = '';
            }else if (this.consider_type == 3){
                if (this.consider_oper < 3){
                    this.consider_var2 = '';
                }
            }
        },
        onSubmit(e){
            e.preventDefault();
            var consider = {};
            var path = `/api/forms/${this.form_id}/form_rules/${this.rule_id}/form_considers`;
            this.checkConsiderType();
            if (this.consider_oper == 5){
                this.consider_var1 = this.arr_consider_var.toString();
            }

            if(this.state == 'new'){
                axios.post(path,{
                    order: this.consider_order,
                    name: this.consider_name,
                    description: this.consider_description,
                    type: this.consider_type,
                    oper: this.consider_oper,
                    var1: this.consider_var1,
                    var2: this.consider_var2
                })
                .then(response=>{
                    consider = response.data.data;
                    // this.consider_id = consider.id;
                    // this.consider_order = consider.order;
                    // this.consider_name = consider.name;
                    // this.consider_type = consider.type;
                    // this.consider_oper = consider.oper;
                    // this.consider_var1 = consider.var1;
                    // this.consider_var2 = consider.var2;
                    this.alert = "success"
                    this.fetchData();
                    this.clearData();


                })
                .catch(error=>{
                    this.alert = "error";
                })
            }else if(this.state == "update"){
                path = `/api/forms/${this.form_id}/form_rules/${this.rule_id}/form_considers/${this.consider_id}`;
                axios.put(`${path}`,{
                    order: this.consider_order,
                    name: this.consider_name,
                    description: this.consider_description,
                    type: this.consider_type,
                    oper: this.consider_oper,
                    var1: this.consider_var1,
                    var2: this.consider_var2
                })
                .then(resposne=>{
                    this.alert = "success"
                    this.fetchData();
                    this.clearData();
                })
                .catch(error=>{
                    this.alert = "error";
                })
            }
        },

        fetchData(){

            var path = `/api/forms/${this.form_id}/form_rules/${this.rule_id}/form_considers`;

            axios.get(`${path}`)
            .then(response=>{
                this.consider_list = response.data.data;
                this.$forceUpdate();
            })
            .catch(error=>{

            })
        },
        showDate(){

        },
        toEdit(consider){

            var arrDate = [];
            this.clearData();
            //console.log('to edit', consider);
            this.state = "update";
            this.consider_id = consider.id;
            this.consider_order = consider.order;
            this.consider_name = consider.name;
            this.consider_description = consider.description;
            this.consider_type = consider.type;
            this.consider_oper = consider.oper;
            if (consider.oper >= 2 && consider.oper < 5){
                if (consider.var1 != '' || !consider.var1){
                    this.myDate1 = consider.var1;
                    this.$nextTick(() => {
                        this.$refs.d11.date = this.myDate1;
                    })
                    this.$forceUpdate();
                }

                if (consider.oper == 3){
                    //console.log('var 2 :' + consider.var2)
                    this.myDate2 = consider.var2;
                     this.$nextTick(() => {

                        this.$refs.d22.date = this.myDate2;
                    })
                    this.$forceUpdate();
                }
            }
            if (consider.oper == 5){
                this.arr_consider_var = consider.var1.split(",");
            }
            this.consider_var1 = consider.var1;
            this.consider_var2 = consider.var2;

            //this.myDate2 = consider.var2;
            //this.myDate1 = new Date(parseInt(arrDate[2]),parseInt(arrDate[1]),parseInt(arrDate[0]));
            //console.log('show date' + this.myDate1 + ' from : '+ arrDate[2] + '+' + parseInt(arrDate[1]) + '+' + arrDate[0]);
            this.$forceUpdate();

        },
        toClearConsider(){

            this.clearData();
        },
        clearData(){
            this.state = "new";
            //this.consider_list = [],
            this.consider_order = 0;
            this.consider_name ='';
            this.consider_description ='';
            this.consider_type = 0;
            this.consider_oper = 0;
            this.consider_var1 = '';
            this.consider_var2 = '';
            this.arr_consider_var = [];
            this.myDate1 = '';
            this.myDate2 = '';
            this.showDate1 = null;
        },
        delConsider(id,form_rule_id){
            this.$swal({
                    title: "กรุณายืนยันการลบเงื่อนไข",
                    text: "คุณต้องการลบเงื่อนไขนี้ใช่หรือไม่",
                    icon: "warning",
                    closeOnClickOutside: false,
                    buttons: [
                        'ยกเลิก',
                        'ยืนยัน'
                    ],

                }).then(isConfirm =>{
                    if (isConfirm){
                        let path = `/api/forms/${this.form_id}/form_rules/${form_rule_id}/form_considers/${id}`;
                        axios.delete(path)
                        .then(response=>{
                            //this.$emit('fetchConsider');
                            this.clearData();
                            this.fetchData();
                            //this.$parent.alert = 'success';
                            this.alert = 'success';
                        })
                    }
                });
        },

    }
}
</script>
<style scoped>
.btn{
    padding-left: 15px!important;
    padding-right: 15px!important;

}
.bg-primary{
    background-color: #20a8d8 !important;
}
.bg-default{
    color: #000!important;
}
.cover{
    color: #fff!important;
}
.sub_rule{
    color: #000!important;
}
.card{
    margin: 10px!important;
}
.dropdown-item>i{
    color: #000!important;
}
.showSub{
    cursor: pointer;
}
.noSub{
    color: rgb(97, 97, 97)!important;
    cursor: default;
}
.float-right{
    margin-right: 5px;
}
</style>
