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
                        <b-form-group label="ปรเภทเงื่อนไข">
                            <b-form-select
                                v-model="consider_type"
                                :options="type_list"
                                name="consider_type"
                            ></b-form-select>
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

                    <b-col cols="3" v-if="(consider_type==3) && (consider_oper==1)">
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

                    <b-col cols="4" v-if="(consider_type==3) && (consider_oper==2)">
                        <b-form-group>
                            <label for="date1">ข้อมูลตรวจสอบ{{date1}}</label>
                            <my-date-picker :showDate="date1" @update="value => consider_var1 = value"></my-date-picker>



                        </b-form-group>
                    </b-col>
                    <b-col cols="6" v-if="(consider_type==3) && (consider_oper==3)">
                        <b-form-group>
                            <label for="date1">ข้อมูลตรวจสอบ</label>
                            <p>{{showDate1}}||{{showDate2}}</p>
                            <my-date-picker :showDate="showDate1" @update="value => consider_var1 = value"></my-date-picker>
                            <my-date-picker :showDate="showDate2" @update="value => consider_var2 = value"></my-date-picker>
                        </b-form-group>
                    </b-col>
                </b-row>
                <div class="text-center">
                    <b-button type="submit" variant="primary">บันทึกเงื่อนไข</b-button>
                    <b-button type="reset" variant="danger" @click="toClearConsider">ยกเลิก</b-button>
                </div>
                <span>{{consider_var1}}</span>
                <consider-cover
                    :considers="consider_list"
                    @fetchConsider = "fetchData"
                    @toEdit = 'toEdit'
                    :form_id="form_id"
                ></consider-cover>
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
            date1: null,
            showDate1: '',
            showDate2: '',
            order_list: ['ลำดับ'],
            type_list: [
                {value: 0, text: 'ประเภทเงื่อนไข'},
                {value: 1, text: 'ใช่หรือไม่'},
                {value: 2, text: 'ใส่ข้อความ'},
                {value: 3, text: 'ตรวจสอบข้อมูล'},
            ],
            oper_list:[
                {value: 0, text: 'ตัวเลือกการตรวจสอบ'},
                {value: 1, text: 'ไม่เกินจำนวนวัน'},
                {value: 2, text: 'ไม่เกินวันที่'},
                {value: 3, text: 'อยู่ในช่วงเวลา'},
            ],
            alert: '',
            lang: 'th',
            state: 'new',
            alert: '',
            myDate1: '2019-10-29',
            myDate2: '2019-10-29',
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

            dateEdit: 0
        }
    },
    watch: {
        myDate1(){
            var iDate = null;
            this.showDate1 = null;
            if (this.myDate1 != null){
                try {
                    iDate = moment(this.myDate1,this.dateFormat);
                } catch (error) {
                    iDate = null;
                }
                this.showDate1 = iDate;
                this.$forceUpdate();
            }else{
                this.showDate1 = null;
                this.$forceUpdate();
            }
            console.log('show date : '+ this.showDate1);
        }
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
        getDate(value){
            console.log(' value : ' + value);
            this.consider_var1 = value;
            this.$forceUpdate();
        },
        onSubmit(e){
            e.preventDefault();
            var consider = {};
            var path = `/api/forms/${this.form_id}/form_rules/${this.rule_id}/form_considers`;

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
        dateSelected(value,mydate){

            this.myDate1 = value.format('ํํํํDD/MM/YYYY');
            this.consider_var1 = value.format('DD/MM/YYYY');

        },
        dateRangeSelected(value,mydate){
            this.consider_var1 = value[0].format('DD/MM/YYYY');
            this.consider_var2 = value[1].format('DD/MM/YYYY');
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
        toEdit(consider){
            var arrDate = [];
            this.clearData();
            console.log('to edit', consider);
            this.state = "update";
            this.consider_id = consider.id;
            this.consider_order = consider.order;
            this.consider_name = consider.name + consider.var1;
            this.consider_description = consider.description;
            this.consider_type = consider.type;
            this.consider_oper = consider.oper;
            if (consider.oper >= 2){
                if (consider.var1 != '' || !consider.var1){
                    this.date1 = consider.var1;
                    this.$forceUpdate();
                    console.log('date 1 :' + this.date1);

                }
                if (consider.var2 != '' || !consider.var2){
                    this.myDate1 = consider.var2;
                }
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
            this.myDate1 = '';
            this.showDate1 = null;
        }
    }
}
</script>
