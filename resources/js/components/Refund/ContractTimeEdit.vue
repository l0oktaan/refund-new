<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
            <b-card class="bg-primary">
                <div slot="header" class="navbar">
                    <ul class="nav navbar-nav d-md-down-none">
                        <li class="nav-item px-3">
                            <i class='fa fa-align-justify'></i>
                                ข้อมูลการอนุมัติ งด / ลด / ขยายเวลา <span class="detail"> (ไม่รวม การขออนุมัติถอนคืนในครั้งนี้) </span><span class="require"> (*)</span> จำเป็นต้องกรอก
                        </li>
                    </ul>
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item px-3">
                            <!-- <b-button variant="outline-success">
                                <i class="fas fa-save fa-2x"></i>&nbsp;<span>บันทึกข้อมูล</span>
                            </b-button> -->
                        </li>
                    </ul>
                </div>
                <span class="edit_contract" v-if="!isEdit">
                    <span style="color:#000;">รายการอนุมัติ งด / ลด / ขยายเวลา : </span><toggle-button :value = "false" :sync = "true" :width="60" :height="25"
                        :labels="{checked: 'มี', unchecked: 'ไม่มี'}"
                        :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                        style="padding-top:4px; line-height:0px;"
                        v-model="isEdit"
                    />
                </span>

                <b-form @submit="onSubmitTimeEdit" v-if="isEdit">
                            <b-row>
                                <b-col sm="3">
                                    <b-form-group>
                                        <label for="time_edit_date">วันที่อนุมัติ : <span class="require">*</span></label>
                                        <my-date-picker ref="approve_date" :id="11" :showDate="date_approve" @update="value => date_approve = value"></my-date-picker>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="3">
                                    <b-form-group>
                                        <label for="edit_type">ประเภทการอนุมัติ :<span class="require">*</span></label>
                                        <b-form-select

                                            :options="arrEditType"
                                            v-model = "time_edit.edit_type"
                                        >
                                        </b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="3" v-if="time_edit && time_edit.edit_type == 4">
                                    <b-form-group >
                                        <label for="edit_detail">ระบุ :</label>
                                        <b-form-input type="text"
                                            placeholder="ระบุประเภทการอนุมัติ"
                                            name="edit_detail"
                                            v-model = "time_edit.edit_detail"
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                 <b-col sm="3" v-if="time_edit.edit_type == 2 || time_edit.edit_type == 3">
                                    <b-form-group>
                                        <label for="edit_budget">จำนวนเงิน :<span class="require" v-if="time_edit.edit_type == 3">*</span></label>
                                        <cleave placeholder="จำนวนเงิน" name="edit_budget" v-model="time_edit.edit_budget" class="form-control" :options="cleave_options.number"></cleave>

                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col sm="3">
                                    <b-form-group>
                                        <label for="edit_start_date">ตั้งแต่วันที่ :<span class="require">*</span></label>
                                        <my-date-picker ref="edit_start_date" :id="12" :showDate="date_edit_start" @update="value => date_edit_start = value"></my-date-picker>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="3">
                                    <b-form-group>
                                        <label for="edit_end_date">{{time_edit.edit_type == 1 ? 'เป็นสิ้นสุดสัญญาวันที่' : 'ถึงวันที่ :'}}<span class="require">*</span></label>
                                        <my-date-picker ref="edit_end_date" :id="12" :showDate="date_edit_end" @update="value => date_edit_end = value"></my-date-picker>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="2">
                                    <b-form-group>
                                        <label for="edit_days">จำนวนวัน (คำนวณ) :</label>
                                        <p v-if="cal_edit_days" style="text-align: center">{{cal_edit_days}} วัน</p>
                                    </b-form-group>
                                </b-col>
                                 <b-col sm="3">
                                    <b-form-group>
                                        <label for="edit_days">จำนวนวันที่อนุมัติ :</label>

                                        <b-form-input type="text"
                                            placeholder="จำนวนวัน"
                                            name="edit_days"
                                            v-model = "edit_days"
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col sm="4">
                                    <b-form-group>
                                        <label for="approve_type">อนุมัติให้ตาม :<span class="require">*</span></label>
                                        <b-form-select
                                            :options="arrApproveType"
                                            v-model = "time_edit.approve_type"
                                        >
                                        </b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="4" v-if="time_edit.approve_type > 10 && time_edit.approve_type < 20">                                    
                                    <b-form-group>
                                        <label for="receive_book_date">วันที่หน่วยงานได้รับหนังสือขอรับความช่วยเหลือ :</label>
                                        <my-date-picker ref="receive_book_date" :id="14" :showDate="date_receive_book" @update="value => date_receive_book = value"></my-date-picker>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="8" v-if="time_edit.approve_type == 99">
                                    <b-form-group>
                                        <label for="approve_case">ข้อมูลเพิ่มเติม :<span class="require">*</span></label>
                                        <b-form-input type="text"
                                            placeholder="เช่น ระเบียบกระทรวงมหาดไทยว่าด้วยการพัสดุฯ พ.ศ. 2535 และที่แก้ไขเพิ่มเติม ข้อ 132"
                                            name="approve_case"
                                            v-model = "time_edit.approve_other_desc"
                                            id="txt_approve_other_desc"
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="6" v-if="time_edit.approve_type == 99">
                                    <b-form-group>
                                        <label for="approve_type">เข้าตามกรณี :<span class="require">*</span></label>
                                        <b-form-select
                                            :options="arrApproveOtherType"
                                            v-model = "time_edit.approve_other_type"
                                        >
                                        </b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="6" v-if="arrShowDetail1.includes(parseInt(time_edit.approve_type)) || (time_edit.approve_other_type && (time_edit.approve_other_type < 4 || time_edit.approve_other_type == 10))">
                                    <b-form-group>
                                        <label for="approve_case">กรณี :</label>
                                        <b-form-input type="text"
                                            placeholder="เช่น เหตุอุทกภัย"
                                            name="approve_case"
                                            v-model = "time_edit.approve_case"
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>

                            </b-row>
                            <b-row v-if="(arrShowDetail1.includes(parseInt(time_edit.approve_type)) && arrShowDetail2.includes(parseInt(time_edit.approve_type))) || (time_edit.approve_other_type && time_edit.approve_other_type > 1 && time_edit.approve_other_type < 4)">
                                <b-col sm="4" >
                                    <b-form-group>
                                        <label for="problem_end_date">อุปสรรคสิ้นสุดวันที่ :</label>
                                        <my-date-picker ref="problem_end_date" :id="13" :showDate="date_problem_end" @update="value => date_problem_end = value"></my-date-picker>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="4" >
                                    <b-form-group>
                                        <label for="book_date">วันที่หน่วยงานได้รับหนังสือแจ้งเหตุสิ้นสุด :</label>
                                        <my-date-picker ref="book_date" :id="14" :showDate="date_book" @update="value => date_book = value"></my-date-picker>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row v-if="arrShowDetail4.includes(parseInt(time_edit.approve_type))">
                                <b-col sm="4" >
                                    <b-form-group>
                                        <label for="problem_end_date" v-if="time_edit.approve_type == 40">โดยได้รับผลกระทบจากเหตุความไม่สงบทางการเมือง ตั้งแต่วันที่ :</label>
                                        <label for="problem_end_date" v-if="time_edit.approve_type == 41">โดยได้รับผลกระทบจากกรณีโรคโควิด 19 ตั้งแต่วันที่ :</label>
                                        <my-date-picker ref="problem_end_date" :id="13" :showDate="date_problem_end" @update="value => date_problem_end = value"></my-date-picker>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="4" >
                                    <b-form-group>
                                        <label for="book_date">ถึงวันที่ :</label>
                                        <my-date-picker ref="book_date" :id="14" :showDate="date_book" @update="value => date_book = value"></my-date-picker>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row align-h="center">
                                <b-col cols="10">
                                    <b-alert
                                        variant="danger"
                                        dismissible
                                        fade
                                        :show="showRuleAlert"
                                        @dismissed="showRuleAlert=false"
                                    >
                                        <p style="text-align:justify" v-if="parseInt(time_edit.approve_type)==40">ระบุเวลาให้อยู่ในช่วงเดือนพฤศจิกายน 2556 ถึง พฤษภาคม 2557 เท่านั้น</p>
                                        <p style="text-align:justify" v-if="parseInt(time_edit.approve_type)==41">ระบุเวลาตั้งแต่ เดือนมีนาคม 2563 เป็นต้นไป</p>
                                        <p style="text-align:justify" v-if="(parseInt(time_edit.approve_type) > 10) && (parseInt(time_edit.approve_type) < 20)">วันที่หน่วยงานได้รับหนังสือขอรับความช่วยเหลือ ไม่อยู่ในกำหนดเวลาการยื่นขอรับความช่วยเหลือตามมติ ครม. ดังกล่าว</p>
                                        <p style="text-align:justify" v-else>{{messageRule}}</p>
                                    </b-alert>
                                    <show-alert :message="message" delay="2" @clearMessage="clearMessage"></show-alert>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <div class="text-center" style="margin-bottom:5px;">
                                        <b-button type="submit" :disabled="isDisable" variant="dark">บันทึกข้อมูล</b-button>
                                        <b-button type="reset" variant="danger" @click="clearData" >ยกเลิก</b-button>
                                    </div>
                                </b-col>
                            </b-row>

                </b-form>
            </b-card>
            <!-- ======================= Contract Edit List ========================================-->
            <table class="table table-hover" v-if="time_edit_list && time_edit_list.length > 0">
                <thead class="thead">
                    <tr>
                        <th scope="col" style="width: 15%">วันที่อนุมัติ</th>
                        <th scope="col" style="width: 15%">ประเภทการอนุมัติ</th>
                        <th scope="col" style="width: 10%">จำนวนวัน</th>
                        <th scope="col" style="width: 15%">ตั้งแต่วันที่</th>
                        <th scope="col" style="width: 15%">ถึงวันที่</th>
                        <th scope="col" style="width: 20%">อนุมัติให้ตาม</th>
                        <th scope="col" style="width: 10%">การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item,index) in time_edit_list" :key="index">
                        <td>{{getThaiDate(item.approve_date)}}</td>
                        <td>{{arrEditType[item.edit_type].text}}</td>
                        <td>{{item.edit_days}}</td>
                        <td>{{getThaiDate(item.edit_start_date)}}</td>
                        <td>{{getThaiDate(item.edit_end_date)}}</td>
                        <td>{{getApproveType(item.approve_type)}}</td>
                        <td>
                            <b-button :id="'btnEdit'+item.id" class="tools" size="sm" variant="outline-primary" @click="toEdit(item)"><i class="fas fa-edit"></i></b-button>
                            <b-tooltip :target="'btnEdit'+item.id" triggers="hover" placement="left">
                                แก้ไขข้อมูล
                            </b-tooltip>

                            <b-button :disabled="isDisable" :id="'btnDel'+item.id" class="tools" size="sm" variant="outline-danger" @click="toDel(item.id)"><i class="fas fa-trash"></i></b-button>
                            <b-tooltip  :target="'btnDel'+item.id" triggers="hover" placement="left">
                                ลบข้อมูล
                            </b-tooltip>
                        </td>
                    </tr>
                </tbody>
            </table>
    </div>
</template>
<script>
export default {
    props: ['office_id'],
    data() {
        return {
            //office_id: this.$store.getters.office_id,
            r_id: this.$route.params.id,
            arrEditType : [
                {text: 'ประเภทการอนุมัติ', value : null},
                {text: 'ขยายเวลา', value : 1},
                {text: 'งดหรือลดค่าปรับ', value : 2},
                {text: 'คืนเงินค่าปรับ', value : 3}
            ],
            arrApproveOtherType: [
                {text: 'ตัวเลือก', value : null},
                {text: '(1) เหตุเกิดจากความผิดหรือความบกพร่องของส่วนราชการ (ผู้ว่าจ้าง/หน่วยงาน)', value : 1},
                {text: '(1) เหตุเกิดจากความผิดหรือความบกพร่องของหน่วยการบริหารราชการส่วนท้องถิ่น', value : 10},
                {text: '(2) เหตุสุดวิสัย', value : 2},
                {text: '(3) เหตุเกิดจากพฤติการณ์อันหนึ่งอันใดที่คู่สัญญาไม่ต้องรับผิดตามกฎหมาย', value : 3},
                {text: 'อื่น', value : 4}
            ],
            arrApproveType : this.$store.getters.arrApproveType,
            arrShowDetail1 : [
                21,24,22,23,34,30,31,32
            ],
            arrShowDetail2 : [
                22,23,31,32
            ],
            arrShowDetail4 : [
                40,41
            ],
            cleave_options:{
                number: {
                    prefix: '',
                    numeral: true,
                    numeralPositiveOnly: true,
                    noImmediatePrefix: true,
                    rawValueTrimPrefix: true,
                    numeralIntegerScale: 15,
                    numeralDecimalScale: 2,
                },
            },
            time_edit : {
                edit_type: null,
                approve_type: null,
                edit_detail: '-',
                approve_other_type: null
            },
            time_edit_list: [],
            date_approve: '',
            date_contract_end: '',
            date_problem_end: '',
            date_book: '',
            date_receive_book: '',
            date_edit_start: '',
            date_edit_end: '',
            edit_days: null,
            cal_edit_days: null,
            state: 'new',
            alert: '',
            refund_status: this.$store.getters.refund_status,
            message: '',
            isEdit: false,
            showRuleAlert: false,
            messageRule: 'กรณี (2) เหตุสุดวิสัย หรือ (3) เหตุเกิดจากพฤติการณ์อันหนึ่งอันใดที่คู่สัญญาไม่ต้องรับผิดตามกฎหมาย คู่สัญญาต้องแจ้งเหตุดังกล่าวให้ส่วนราชการทราบภายใน 15 วัน นับแต่เหตุนั้นได้สิ้นสุดลง หากข้อเท็จจริงปรากฏว่าคู่สัญญาไม่มีการแจ้งภายใน 15 วัน นับแต่เหตุนั้นได้สิ้นสุดลง โปรดดำเนินการตรวจสอบและทบทวนการอนุมัติงดหรือลดค่าปรับ หรือขยายเวลาดังกล่าวให้ถูกต้องตาม พรบ. ระเบียบ ข้อบังคับ หรือข้อบัญญัติของหน่วยงานก่อนขอทำความตกลงกับกรมบัญชีกลาง',

        }
    },
    mounted(){
        this.fetchEditTimeList();
        this.$forceUpdate();
    },
    computed: {
        isDisable(){

            return (this.refund_status > 7 && this.refund_status != 11) && this.$store.getters.user.type != 'admin' ? true : false
        }
    },
    watch: {
        
        date_edit_start(newDate, oldDate){
            
            if (this.date_edit_start != '' && this.date_edit_end){
                if (!this.checkDate(newDate,this.date_edit_end)){
                    this.$nextTick(() => {
                        this.date_edit_start = oldDate;
                        this.$forceUpdate();
                    })
                }else{

                    this.cal_edit_days = this.diffDate(this.date_edit_start,this.date_edit_end);
                }
            }
        },
        date_edit_end(newDate, oldDate){
            
            if (this.date_edit_end != '' && this.date_edit_start){
                if (!this.checkDate(this.date_edit_start,newDate)){
                    this.$nextTick(() => {
                        this.date_edit_end = oldDate;
                        this.$forceUpdate();
                    })
                }else{

                    this.cal_edit_days = this.diffDate(this.date_edit_start,this.date_edit_end);
                }
            }
        },
        cal_edit_days(newVal,oldVal){
            
            this.edit_days = newVal;
            this.$forceUpdate();
        },
        date_problem_end(newDate, oldDate){
            if (this.isCabinet){
                return;
            }
            console.log('type :' + this.time_edit.approve_type);
            if (this.date_problem_end != '' && this.date_book){
                if (!this.checkDate(newDate,this.date_book)){
                    this.$nextTick(() => {
                        this.date_problem_end = oldDate;
                        this.$forceUpdate();
                    })
                }else{
                    if(parseInt(this.time_edit.approve_type) == 40){
                        let checkDate = new Date(newDate);
                        let effect_start_date = new Date(2013,10,1);
                        let effect_end_date = new Date(2014,4,31);
                        if (checkDate < effect_start_date || checkDate > effect_end_date){
                            this.showRuleAlert = true;
                        }else{
                            this.showRuleAlert = false;
                        }
                    }else if (this.time_edit.approve_type == 41){
                        let checkDate = new Date(newDate);
                        let effect_date = new Date(2020,2,1,7,0,0);
                        if (checkDate < effect_date){
                            console.log('False');
                            this.showRuleAlert = true;
                        }else{
                            console.log('True');
                            this.showRuleAlert = false;
                        }
                    }else{
                        let diff = this.diffDate(this.date_problem_end,this.date_book);

                        if (diff > 15){
                            this.$nextTick(() => {
                                // this.date_problem_end = oldDate;
                                this.showRuleAlert = true;
                            })
                        }else{
                            this.showRuleAlert = false;
                        }
                    }
                    
                }
            }else{
                if(parseInt(this.time_edit.approve_type) == 40){
                    let checkDate = new Date(newDate);
                    console.log('check date : ' + checkDate);
                    let effect_start_date = new Date(2013,10,1);
                    let effect_end_date = new Date(2014,4,31);
                    console.log('start :' + effect_start_date);
                    if (checkDate < effect_start_date || checkDate > effect_end_date){
                        this.showRuleAlert = true;
                    }else{
                        this.showRuleAlert = false;
                    }
                }else if (this.time_edit.approve_type == 41){
                    let checkDate = new Date(newDate);
                    let effect_date = new Date(2020,2,1,7,0,0);
                    if (checkDate < effect_date){
                        this.showRuleAlert = true;
                    }else{
                        this.showRuleAlert = false;
                    }
                }
            }
        },
        date_receive_book(newDate,oldDate){    
                   
            if (newDate != ''){
                if (this.time_edit.approve_type > 10 && this.time_edit.approve_type < 20){
                    const arr = this.arrApproveType.filter(x=>x.value == this.time_edit.approve_type)
                    const approve = arr[0]
                    const begin_date = new Date(approve.startDate);
                    const end_date = new Date(approve.endDate);
                    const checkDate = new Date(newDate);
                    
                    if (checkDate < begin_date || checkDate > end_date){
                       
                        this.showRuleAlert = true;
                    }else{
                        this.showRuleAlert = false;
                    }
                    return;
                }
            }
        },
        date_book(newDate,oldDate){
            
            if (this.isCabinet){
                return;
            }
            if (this.date_book != '' && this.date_problem_end){
                
                if (!this.checkDate(this.date_problem_end,newDate)){
                    this.$nextTick(() => {
                        this.date_book = oldDate;
                        this.$forceUpdate();
                    })
                }else{
                    if(this.time_edit.approve_type == 40){
                        let checkDate = new Date(newDate);
                        // console.log('end : ' + checkDate);
                        
                        let effect_start_date = new Date(2013,10,1,7,0,0);
                        let effect_end_date = new Date(2014,4,31,7,0,0);
                        
                        if (checkDate < effect_start_date || checkDate > effect_end_date){
                            this.showRuleAlert = true;
                        }else{
                            this.showRuleAlert = false;
                        }
                    }else if (this.time_edit.approve_type == 41){
                        let checkDate = new Date(newDate);
                        let effect_date = new Date(2020,2,1,7,0,0);
                        if (checkDate < effect_date){
                            this.showRuleAlert = true;
                        }else{
                            this.showRuleAlert = false;
                        }
                    }else{
                        let diff = this.diffDate(this.date_problem_end,this.date_book);

                        if (diff > 15){
                            this.$nextTick(() => {
                                // this.date_book = oldDate;
                                this.showRuleAlert = true;
                            })
                        }else{
                            this.showRuleAlert = false;
                        }
                    }
                   
                }
            }else{
                
                if(parseInt(this.time_edit.approve_type) == 40){
                    // console.log('date str :' + this.date_book);
                    let checkDate = new Date(newDate);
                    // console.log('end : ' + checkDate);
                    
                    let effect_start_date = new Date(2013,10,1,7,0,0);
                    let effect_end_date = new Date(2014,4,31,7,0,0);
                    console.log('end : ' + checkDate);
                    console.log('checkend : ' + effect_end_date);
                    if (checkDate < effect_start_date || checkDate > effect_end_date){
                        this.showRuleAlert = true;
                    }else{
                        this.showRuleAlert = false;
                    }
                }else if (this.time_edit.approve_type == 41){
                    let checkDate = new Date(newDate);
                    let effect_date = new Date(2020,2,1,7,0,0);
                    if (checkDate < effect_date){
                        this.showRuleAlert = true;
                    }else{
                        this.showRuleAlert = false;
                    }
                }
            }
        }
    },
    methods: {
        checkRule(){
            if (parseInt(this.time_edit.approve_type) >= 40 || (this.time_edit.approve_type > 10 && this.time_edit.approve_type < 20)){
                this.showRuleAlert = false;
                return true;
            }
            let diff = this.diffDate(this.date_problem_end,this.date_book);

            if (diff > 15){
                this.showRuleAlert = true;
                return false;
            }else{
                this.showRuleAlert = false;
                return true;
            }
        },
        clearMessage(){
            this.message = ''
        },
        fetchEditTimeList(){
            this.$emit('refund_update');
            this.time_edit_list = [];
            var path = `/api/offices/${this.office_id}/refunds/${this.r_id}/contract_time_edits`;
            axios.get(`${path}`)
            .then(response=>{
                this.time_edit_list = response.data.data;
                if (this.time_edit_list.length > 0){
                    this.isEdit = true;
                }
            })
            .catch(error=>{
                console.log("error : " + error);
            })
        },
        onSubmitTimeEdit(e){
            e.preventDefault();
            if (this.time_edit.edit_type == 3){
                if (!this.time_edit.edit_budget || this.time_edit.edit_budget == '' || this.time_edit.edit_budget == 0){
                    this.message = "กรุณาบันทึกข้อมูล จำนวนเงิน";
                    return;
                }
            }
            if (this.time_edit.approve_type == 99){
                // console.log('type :' + this.time_edit.approve_type);
                // console.log('case :' + this.time_edit.approve_case);
                // console.log('description :' + this.time_edit.approve_other_desc);
                // console.log('other type :' + this.time_edit.approve_other_type);
                // return;
                if (this.time_edit.approve_other_desc == '' || !this.time_edit.approve_other_type){
                   this.message = "กรุณาบันทึกข้อมูลเพิ่มเติมในการอนุมัติตามระเบียบ ข้อบังคับ ข้อบัญญัติ ว่าด้วยการพัสดุของหน่วยงาน";
                    return;
                }
            }
            if ((this.arrShowDetail1.includes(parseInt(this.time_edit.approve_type)) || this.time_edit.approve_other_type) && (!this.time_edit.approve_case ||this.time_edit.approve_case == '') && !this.time_edit.approve_other_type == 4){
                this.message = 'กรุณาใส่ข้อมูลในช่อง "กรณี"';
                return;

            }
            if (this.time_edit.approve_type > 10 && this.time_edit.approve_type < 20){
                if (!this.date_receive_book || this.showRuleAlert){
                    this.message = `กรุณาใส่ข้อมูลในช่อง "วันที่หน่วยงานได้รับหนังสือขอรับความช่วยเหลือ" ให้ถูกต้อง`;
                    return;
                }
            }
            if (!this.checkRule()){
                return;
            }
            var path = `/api/offices/${this.office_id}/refunds/${this.r_id}/contract_time_edits`;

            if (this.state == 'new'){

                axios.post(`${path}`,{
                    approve_date: this.date_approve,
                    edit_type: this.time_edit.edit_type,
                    edit_detail: this.time_edit.edit_detail,
                    edit_days: this.edit_days,
                    edit_budget: this.time_edit.edit_budget,
                    edit_start_date: this.date_edit_start,
                    edit_end_date: this.date_edit_end,
                    approve_type: this.time_edit.approve_type,
                    approve_other_desc: this.time_edit.approve_other_desc,
                    approve_other_type: this.time_edit.approve_other_type,
                    approve_case: this.time_edit.approve_case,
                    problem_end_date: this.date_problem_end,
                    book_date: (this.time_edit.approve_type >10 && this.time_edit.approve_type < 20) ? this.date_receive_book : this.date_book
                    // book_date: this.date_book
                })
                .then(response=>{

                    this.alert = 'success';

                    this.fetchEditTimeList();

                    this.clearData();
                    this.$forceUpdate();
                })
                .catch(error=>{
                    console.log('error : ' + error);
                    this.alert = 'error';
                })
            }else if (this.state == 'update'){

                path = `${path}/${this.time_edit.id}`
                axios.put(`${path}`,{
                    approve_date: this.date_approve,
                    edit_type: this.time_edit.edit_type,
                    edit_detail: this.time_edit.edit_detail,
                    edit_days: this.edit_days,
                    edit_budget: this.time_edit.edit_budget,
                    edit_start_date: this.date_edit_start,
                    edit_end_date: this.date_edit_end,
                    approve_type: this.time_edit.approve_type,
                    approve_other_desc: this.time_edit.approve_other_desc,
                    approve_other_type: this.time_edit.approve_other_type,
                    approve_case: this.time_edit.approve_case,
                    problem_end_date: this.date_problem_end,
                    book_date: (this.time_edit.approve_type >10 && this.time_edit.approve_type < 20) ? this.date_receive_book : this.date_book
                })
                .then(response=>{
                    this.alert = 'success';
                    this.clearData();
                    this.fetchEditTimeList();
                    this.$forceUpdate();

                })
                .catch(error=>{
                    console.log('error : ' + error);
                    this.alert = 'error';
                })
            }


        },
        showCalendar(value){
            if (value){
                this.date_approve = value.approve_date;
                this.date_edit_start = value.edit_start_date;
                this.date_edit_end = value.edit_end_date;
                this.edit_days = value.edit_days;
                
                this.$nextTick(() => {
                    if (value.approve_type > 10 && value.approve_type < 20){
                        this.date_receive_book = value.book_date
                    }
                    this.date_problem_end = value.problem_end_date;
                    this.date_book = value.book_date;
                })
                this.$forceUpdate();
            }else{
                this.date_approve = '';
                 this.date_edit_start = '';
                this.date_edit_end = '';
                this.date_problem_end = '';
                this.date_book = '';
                this.$forceUpdate();
            }

        },
        toEdit(t_edit){
            //this.time_edit = t_edit;
            this.time_edit = _.cloneDeep(t_edit);

            this.state = 'update';
            this.showCalendar(t_edit);

            this.$forceUpdate();
        },
        toDel(id){
            var path = `/api/offices/${this.office_id}/refunds/${this.r_id}/contract_time_edits/${id}`;
            this.$swal({
                title: "กรุณายืนยัน",
                text: `คุณต้องการลบข้อมูล ใช่หรือไม่`,
                icon: "warning",
                closeOnClickOutside: false,
                buttons: [
                    'ยกเลิก',
                    'ยืนยัน'
                ],
            })
            .then(isConfirm =>{
                if (isConfirm){
                    axios.delete(`${path}`)
                    .then(response=>{
                        this.clearData();
                        this.fetchEditTimeList();
                        this.alert = "success";
                    })
                    .catch(error=>{
                        this.alert = "error";
                    })
                }
            })
        },
        diffDate(date1,date2){
            var d1 = new Date(date1);
            var d2 = new Date(date2);
            var diff = null;
            if (d2 >= d1){
                diff = (d2.getTime() - d1.getTime())/(1000*60*60*24) + 1;
                return diff;
            }else{
                // this.alert = "error";
                return false;
            }
        },
        checkEffectDate(){

        },
        isCabinet(){
            return (this.time_edit.approve_type >10 && this.time_edit.approve_type < 20) ? true : false;
        },
        checkDate(date1,date2){
            //console.log('check date : '+ date1 + ' and ' + date2);
            var d1 = new Date(date1);
            var d2 = new Date(date2);
            if (d2 >= d1){
                console.log('dateDiff :' + (d2.getTime() - d1.getTime())/(1000*60*60*24));
                return true;
            }else{
                this.alert = "error";
                return false;
            }

        },
        getThaiDate(item){
            var d = new Date(item);
            return d.toLocaleDateString('th-TH', { day: 'numeric', month: 'long', year: 'numeric' });

        },
        getApproveType(value){

            var index = this.arrApproveType.findIndex(x => x.value == value);
            return this.arrApproveType[index].text;
        },
        clearData(){
            console.log('Clear Time Edit');
            this.time_edit = {
                edit_type: null,
                approve_type: null,
                edit_detail: '-',
                approve_other_type: null
            };
            if (this.time_edit_list.length == 0){
                this.isEdit = false
            }
            this.state = 'new';
            this.date_approve = null;
            this.date_contract_end = null;
            this.date_problem_end = null;
            this.date_book = null;
            this.date_edit_start = null;
            this.date_edit_end = null;
            this.edit_days = null;
            this.cal_edit_days = null;
            this.date_receive_book = null;
            this.$forceUpdate();
            //this.showCalendar();
        }
    }
}
</script>

<style scoped>

.description{
    font-size: 0.8em!important;
    color: rgb(49, 49, 49);
    margin-left: 20px;
}

.btn{
    padding-top: 5px!important;
    padding-bottom: 5px!important;
    vertical-align: middle!important;
}
.card-header{
    padding: 5px!important;
}
.list{
    padding: 10px!important;

}
.btn-transparent{
    color: black!important;
}
.dropdown-item i{
    color: black!important;
}
.edit_list{
    background-color: rgb(176, 243, 248);
    margin-bottom: 5px!important;
}
.dropdown-item{
    color: black!important;
}
.edit_list{
    background-color: rgb(176, 243, 248);
    margin-bottom: 5px!important;
}
.item_select{
    background-color: rgb(247, 230, 158);
    margin-bottom: 5px!important;
}
.fieldName{
    color: rgb(4, 30, 53);
    font-weight: bold;
    text-align: center;
    margin: 0px!important;
}
.unit{
    color: rgb(154, 156, 158);
    font-weight: bold;
    padding-left: 5px;
}
.item_list{
    margin: 0px!important;
}
.header_list{
    margin-bottom: 5px;
    background-color: #f0f3f5;
    border: 1px solid #c8ced3;

}
.detail{
    font-size: 0.9rem!important;
}
.thead{
    background-color: #1074b8;
    color: #fff;
    font-weight: normal!important;
}
.custom-select{
    color: #000!important;
}
.edit_contract{


    margin-bottom: 10px;
    padding: 10px 20px 10px 20px;
    border-radius: 5px;
    background-color: rgb(255, 175, 83);
}
</style>
