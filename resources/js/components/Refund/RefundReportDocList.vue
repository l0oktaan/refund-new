<template>
    <div>
        <b-row align-h="center">
            <b-col cols="12" class="form_name">
                <p class="topic">รายการเอกสารส่งเพื่อประกอบการพิจารณา</p>
            </b-col>
        </b-row>
        <b-row align-h="center">
            <b-col cols="11">
                <table class="report_doc_list" style="width: 100%">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 25%" class="topic">ประเภทเอกสาร</th>
                            <th scope="col" style="width: 75%" class="topic">รายการเอกสาร</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><p class="head">1. เอกสารสัญญา</p></td>
                            <td>
                                <p class="head"><i class="far fa-square fa-lg"></i> สัญญา/ใบสั่งจ้างเลขที่ <span class="show-list">{{contract.contract_no}}</span>  ลงวันที่ <span class="show-list">{{getThaiDate(contract.contract_date)}}</span></p>
                                <p class="head">(*กรณีมีหนังสือแจ้งผู้รับจ้างให้เริ่มทำงาน หรือหนังสือส่งมอบสถานที่ ให้แนบมาประกอบการพิจารณาด้วย)</p>
                            </td>
                        </tr>
                        <tr>
                            <td><p class="head">2. เอกสารการแก้ไขสัญญา</p></td>
                            <td>
                                <p class="head" v-if="!contract_edit || contract_edit.length == 0">- ไม่มี -</p>
                                <div class="main_order" v-for="(item,index) in contract_edit" :key="index">
                                    <p class="head"><i class="far fa-square fa-lg"></i> หนังสือแก้ไขสัญญาลงวันที่ <span class="show-list">{{getThaiDate(item.contract_edit_date)}}</span></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><p class="head">3. ข้อมูลการอนุมัติ งด / ลด / ขยายเวลา</p></td>
                            <td>
                                <!-- <p>{{contract_time_edit}}</p> -->
                                <!-- <p>{{approve_type_1}}</p>  -->
                                <!-- <p>{{approve_type_2}}</p> -->
                                <!-- <p>{{approve_type_3}}</p> -->
                                <!-- <p>{{approve_other_type}}</p> -->
                                <div v-if="contract_time_edit || contract_time_edit.length > 0">
                                    <div v-for="(item,index) in contract_time_edit" :key="index">
                                        
                                        <div v-if="approve_type_1.findIndex(x=>x.id == item.id)>=0">
                                            <p  class="head">
                                                <i class="far fa-square fa-lg"></i> {{index+1}}. หนังสือผู้รับจ้างขอรับความช่วยเหลือตาม<span class="show-list">{{getApproveType(item.approve_type)}}</span>ที่แสดงวันที่หน่วยงานรับเรื่องไว้อย่างชัดเจน
                                            </p>
                                            <p  class="head">
                                                <i class="far fa-square fa-lg mr-3"></i> หนังสือส่วนราชการอนุมัติ<span class="show-list">{{getEditType(item.edit_type)}}</span> ตาม<span class="show-list">{{getApproveType(item.approve_type)}}</span>ที่ผู้มีอำนาจลงนามอนุมัติ
                                            </p>                                       
                                        </div>
                                        <div v-else-if="approve_type_2.findIndex(x=>x.id == item.id)>=0">                                       
                                        <p  class="head">
                                                <i class="far fa-square fa-lg"></i> {{index+1}}. หนังสือส่วนราชการอนุมัติ<span class="show-list">{{getEditType(item.edit_type)}}</span> จำนวน<span class="show-list">{{item.edit_days}}</span>วัน ตาม<span class="show-list">{{getApproveType(item.approve_type)}}</span> กรณี<span class="show-list">{{item.approve_case}}</span> ที่ผู้มีอำนาจลงนามอนุมัติ และเอกสารอื่นที่เกี่ยวข้อง
                                            </p>                                                                                
                                        </div>
                                        <div v-else-if="approve_type_3.findIndex(x=>x.id == item.id)>=0">                                       
                                        <p  class="head">
                                                <i class="far fa-square fa-lg"></i> {{index+1}}. หนังสือส่วนราชการอนุมัติ<span class="show-list">{{getEditType(item.edit_type)}}</span> จำนวน<span class="show-list">{{item.edit_days}}</span>วัน ตาม<span class="show-list">{{getApproveType(item.approve_type)}}</span> กรณี<span class="show-list">{{item.approve_case}}</span> ที่ผู้มีอำนาจลงนามอนุมัติ และเอกสารอื่นที่เกี่ยวข้อง
                                            </p>                                                                                
                                        </div>
                                        <div v-else-if="approve_other_type.findIndex(x=>x.id == item.id)>=0">                                       
                                        <p  class="head">
                                                <i class="far fa-square fa-lg"></i> {{index+1}}. หนังสือส่วนราชการอนุมัติ<span class="show-list">{{getEditType(item.edit_type)}}</span> จำนวน<span class="show-list">{{item.edit_days}}</span>วัน ตาม<span class="show-list">{{item.approve_other_desc + ' (' + item.approve_other_type + ')'}}</span> กรณี<span class="show-list">{{item.approve_case}}</span> ที่ผู้มีอำนาจลงนามอนุมัติ และเอกสารอื่นที่เกี่ยวข้อง
                                            </p>                                                                                
                                        </div>
                                        
                                    </div>
                                    <p  class="head">
                                        <b>กรณีอนุมัติให้ตาม (2) เหตุสุดวิสัย หรือ (3) เหตุเกิดจากพฤติการณ์อันหนึ่งอันใดที่คู่สัญญาไม่ต้องรับผิดตามกฎหมาย ให้แนบ</b>
                                    </p>
                                    <p  class="head  pl-4">
                                        1. เอกสารที่ระบุว่าเหตุหรือปัญหาอุปสรรคดังกล่าวสิ้นสุดลงวันที่เท่าใด 
                                    </p>
                                        <p  class="head  pl-4">
                                        2. หนังสือผู้รับจ้างแจ้งเหตุภายใน 15 วัน นับแต่เหตุสิ้นสุด ที่แสดงวันที่หน่วยงานรับเรื่องไว้อย่างชัดเจน 
                                    </p>
                                    <p class="head">
                                        (*กรณีผู้ลงนามอนุมัติ งด/ลด/ขยายเวลา เป็นผู้ได้รับมอบอำนาจ ให้แนบคำสั่งมอบอำนาจมาประกอบการพิจารณาด้วย)
                                    </p>
                                    
                                </div>
                                <div v-if="!contract_time_edit || contract_time_edit.length == 0">
                                    <p class="head">- ไม่มี -</p>
                                </div>
                                
                                    <!-- <div v-if="edit_type_1.length > 0">
                                        <p class="head">
                                            <b>กรณีอนุมัติให้ตามมติ ครม.</b>
                                        </p>
                                        <div v-for="(item,index) in edit_type_1" :key="index">
                                            <p  class="head pl-4">
                                                <i class="far fa-square fa-lg"></i> 1) หนังสือผู้รับจ้างขอรับความช่วยเหลือตาม <span class="show-list">{{getApproveType(item.approve_type)}}</span>ที่แสดงวันที่หน่วยงานรับเรื่องไว้อย่างชัดเจน
                                            </p>
                                            <p  class="head pl-4">
                                                <i class="far fa-square fa-lg"></i> 2) หนังสือส่วนราชการอนุมัติ {{arrEditType[arrEditType.findIndex(x=>x.value == item.edit_type)]['text']}} ตาม <span class="show-list">{{getApproveType(item.approve_type)}}</span>ที่ผู้มีอำนาจลงนามอนุมัติ
                                            </p>
                                        </div>
                                        
                                    </div> -->
                                    <!-- <div v-if="edit_type_2.length > 0 || edit_type_3.length > 0">
                                        <p  class="head">
                                            <b>กรณีอนุมัติตาม พรบ. ระเบียบ ข้อบังคับ หรือข้อบัญญัติ ของส่วนราชการว่าด้วยการพัสดุ</b>
                                        </p>
                                    </div>
                                    <div v-if="edit_type_2.length > 0">                                        
                                        <p class="head  pl-2">
                                            <b>ระเบียบพัสดุ ข้อ 136 ,ข้อ 139 (1) พรบ. จัดซื้อจัดจ้าง มาตรา 97 ,102 (1)</b>
                                        </p>
                                        <div v-for="(item2,index) in edit_type_2" :key="index">
                                            <p  class="head  pl-4">
                                                กรณี <span class="show-list">{{item2.approve_case}}</span>
                                            </p>
                                            <p  class="head  pl-4">
                                                <i class="far fa-square fa-lg"></i> หนังสือส่วนราชการอนุมัติ <span class="show-list">{{arrEditType[arrEditType.findIndex(x=>x.value == item2.edit_type)]['text']}}</span> จำนวน <span class="show-list">{{item2.edit_days}}</span>วัน ที่ผู้มีอำนาจลงนามอนุมัติ และเอกสารอื่นที่เกี่ยวข้อง
                                            </p>
                                        </div>                                        
                                    </div> -->    
                                                         
                                    
                            </td>
                        </tr>
                        <tr>
                            <td><p class="head"></p></td>
                            <td>
                                    <div v-if="true">
                                    <p  class="head">
                                        <b>การขอถอนคืนครั้งนี้</b>
                                    </p>
                                    <div v-if="form.type==1">
                                        <p  class="head">
                                            <b>กรณีอนุมัติให้ตามมติ ครม.</b>
                                        </p>
                                        <p  class="head">
                                            <i class="far fa-square fa-lg"></i> (1) หนังสืออนุมัติงดหรือลดค่าปรับ หรือคืนค่าปรับตาม<span class="show-list">มติ ครม. เมื่อวันที่ {{getThaiDate(form.minutes_date) + ' (' + getBookNo(form.book_no) + ')'}}</span>ตามที่ขอถอนคืนในครั้งนี้ ที่ผู้มีอำนาจลงนามอนุมัติ
                                        </p>
                                        <p  class="head">
                                            <i class="far fa-square fa-lg"></i> 2) หนังสือผู้รับจ้างขอรับความช่วยเหลือตาม<span class="show-list">มติ ครม. เมื่อวันที่  {{getThaiDate(form.minutes_date) + ' (' + getBookNo(form.book_no) + ')'}}</span>ที่แสดงวันที่หน่วยงานรับเรื่องไว้อย่างชัดเจน
                                        </p>
                                    </div>
                                    <div v-else-if="form.type==2">
                                        <p class="head">
                                            <b>กรณีอนุมัติตาม พรบ. ระเบียบ ข้อบังคับ หรือข้อบัญญัติ ของส่วนราชการว่าด้วยการพัสดุ</b>
                                        </p>
                                        <p  class="head">
                                            <i class="far fa-square fa-lg"></i> หนังสืออนุมัติงดหรือลดค่าปรับ หรือขยายเวลาตาม <span class="show-list">{{detail[detail.findIndex(x=>x.consider_id == 59)]['value'] + ' ข้อ ' + detail[detail.findIndex(x=>x.consider_id == 170)]['value'] }}</span> ตามที่ขอถอนคืนในครั้งนี้ ที่ผู้มีอำนาจลงนามอนุมัติ
                                        </p>
                                        <p  class="head">
                                            <i class="far fa-square fa-lg"></i> กรณีอนุมัติให้ตาม (2) เหตุสุดวิสัย หรือ (3) เหตุเกิดจากพฤติการณ์อันหนึ่งอันใดที่คู่สัญญาไม่ต้องรับผิดตามกฎหมาย ให้แนบ
                                        </p>
                                        <p  class="head  pl-2">
                                            1. เอกสารที่ระบุว่าเหตุหรือปัญหาอุปสรรคดังกล่าวสิ้นสุดลงวันที่เท่าใด 
                                        </p>
                                         <p  class="head  pl-2">
                                            2. หนังสือผู้รับจ้างแจ้งเหตุภายใน 15 วัน นับแต่เหตุสิ้นสุด ที่แสดงวันที่หน่วยงานรับเรื่องไว้อย่างชัดเจน 
                                        </p>
                                    </div>
                                    <div v-else-if="form.type==3">
                                        <p class="head">
                                            <b>กรณีอื่นๆ</b>
                                        </p>
                                        <p class="head pl-2">
                                            <b>กรณีเหตุการณ์ความไม่สงบทางการเมือง</b>
                                        </p>
                                        
                                        <p  class="head  pl-4">
                                            1. หนังสืออนุมัติงดหรือลดค่าปรับ หรือขยายเวลาตาม <span class="show-list">ว 168 หรือ ว 291 </span>ตามที่ขอถอนคืนในครั้งนี้ ที่ผู้มีอำนาจลงนามอนุมัติ
 
                                        </p>
                                         <p  class="head  pl-4">
                                            2. หนังสือผู้รับจ้างขอรับความช่วยเหลือตาม <span class="show-list">ว 168 หรือ ว 291 </span> ที่แสดงวันที่หน่วยงานรับเรื่องไว้อย่างชัดเจน 
                                        </p>
                                    </div>
                                    <div>
                                        <p class="head">
                                            (*กรณีผู้ลงนามอนุมัติ งด/ลด/ขยายเวลา เป็นผู้ได้รับมอบอานาจ ให้แนบคาสั่งมอบอานาจมาประกอบการพิจารณาด้วย)
                                        </p>
                                    </div>
                                    </div>
                            </td>
                        </tr>
                        <tr>
                            <td><p class="head">4. ข้อมูลการส่งมอบงาน/สิ่งของ</p></td>
                            <td>
                                <div v-for="(item,index) in delivery" :key="index">
                                    <p class="head">
                                        <b>{{index+1}}. การส่งมอบงาน/สิ่งของ</b> <span class="show-list">{{item.delivery}}</span>
                                    </p>
                                    <p class="head"><i class="far fa-square fa-lg"></i> หนังสือผู้รับจ้าง/ผู้ขาย ส่งมอบงาน/สิ่งของ <span class="show-list">{{item.delivery}}</span> เมื่อวันที่<span class="show-list"> {{getThaiDate(item.delivery_date)}} </span></p>
                                    <p class="head"><i class="far fa-square fa-lg"></i> ใบตรวจการจ้างงาน/ใบตรวจรับของ <span class="show-list">{{item.delivery}}</span></p>
                                </div >

                            </td>
                        </tr>
                        <tr>
                            <td><p class="head">5. ข้อมูลการนำส่ง/เบิกหักผลักส่งค่าปรับ</p></td>
                            <td>
                                <p v-for="(item,index) in deposit_penalty" :key="index" class="head">
                                    <i class="far fa-square fa-lg"></i> เอกสารเบิกหักผลักส่ง/นำส่ง เลขที่ <span class="show-list">{{item.deposit_no}}</span>
                                     วันที่ผ่านรายการ <span class="show-list">{{getThaiDate(item.deposit_date)}}</span> จำนวนเงิน <span class="show-list">{{item.amount_in_contract | numeral('0,0.00')}}</span> บาท
                                </p>
                                <p class="head">
                                    (*กรณีนำส่งค่าปรับรวมหลายสัญญาในครั้งเดียวกัน ให้แนบรายละเอียดที่นำส่งเป็นสัญญาใด จำนวนเท่าไหร่ด้วย)
                                </p>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td colspan="2"><p class="head">6. กรอกข้อมูลขออนุมัติถอนคืนเงินค่าปรับ รายละเอียดที่ต้องแนบเหมือนกับข้อ 3 ทั้งนี้ จะเป็นตามข้อ 3.1 หรือ 3.2 ดูข้อมูลจากแบบฟอร์มถอนคืนที่เลือก</p></td>
                        </tr> -->
                    </tbody>

                </table>
            </b-col>
        </b-row>
        <b-row align-h="center">
            <b-col cols="11">
                <p class="head"><b>หมายเหตุ :</b></p>
                <p class="head pl-4">1. เอกสารประกอบการพิจารณา ต้องมีการรับรองสำเนาถูกต้องทุกฉบับ</p>
                <p class="head pl-4">2. กรมบัญชีกลางอาจมีการขอเอกสารอื่นเพิ่มเติมนอกเหนือจากที่ระบุไว้ในรายละเอียดข้างต้น</p>
                <p class="head pl-4">3. เอกสารประกอบการพิจารณาไม่ครบถ้วน กรมบัญชีกลางจะดำเนินการส่งเรื่องคืนตามหนังสือกรมบัญชีกลาง ที่ กค 0412.5/ว 29 ลงวันที่ 17 มกราคม 2561</p>

            </b-col>
        </b-row>
    </div>
</template>
<script>

export default {
    props: ["form","detail","contract","contract_edit","contract_time_edit","delivery","deposit_penalty"],
    data(){
        return {
            arrEditType : [
                {text: 'ขยายเวลา', value : 1},
                {text: 'งดหรือลดค่าปรับ', value : 2},
                {text: 'คืนเงินค่าปรับ', value : 3}
            ],
            
            arrApproveType : this.$store.getters.arrApproveType,
            arrApproveOtherType: [
                {text: 'ตัวเลือก', value : null},
                {text: '(1) เหตุเกิดจากความผิดหรือความบกพร่องของส่วนราชการ (ผู้ว่าจ้าง/หน่วยงาน)', value : 1},
                {text: '(2) เหตุสุดวิสัย', value : 2},
                {text: '(3) เหตุเกิดจากพฤติการณ์อันหนึ่งอันใดที่คู่สัญญาไม่ต้องรับผิดตามกฎหมาย', value : 3}
            ],
            approveTypeGroup2 : [21,24,34,30],
            approveTypeGroup3 : [22,23,31,32],
            count_group_1: 0,
            count_group_2: 0,
            count_group_3: 0,
            approve_order: 0

        }
    },
    computed: {
        get_approve_order(){            
            return this.approve_order++;
        },
        group_1(){
            this.count_group_1 = this.count_group_1 + 1;
            console.log('group_1' + this.count_group_1);
            return this.count_group_1;
        },
        group_2(){
            this.count_group_2 = this.count_group_2 + 1;
            return this.count_group_2;
        },
        group_3(){
            this.count_group_3 = this.count_group_3 + 1;
            return this.count_group_3;
        },
        approve_type_1(){ //มติ ครม.
            return this.contract_time_edit.filter(x=>x.approve_type > 10 && x.approve_type <20);
            // this.refund_filter = this.refunds.filter(x=>x.contracts.findIndex(y=>y.contract_party.search(this.filter)>=0)>=0 || x.contracts.findIndex(z=>z.contract_no.search(this.filter)>=0)>=0 || x.approve_code.search(this.filter)>=0);
        },
        approve_type_2(){ //ระเบียบพัสดุ (1)
            return this.contract_time_edit.filter(x=>this.approveTypeGroup2.findIndex(y=>y == x.approve_type)>=0);
        },
        approve_type_3(){ //ระเบียบพัสดุ (2)
            return this.contract_time_edit.filter(x=>this.approveTypeGroup3.findIndex(y=>y == x.approve_type)>=0);
        },
        approve_other_type(){ //อื่นๆ
            return this.contract_time_edit.filter(x=>x.approve_type==99);
        }
    },
    created(){

    },
    methods: {
        
        getBookNo(value){
            let index = value.search('/');
            return value.substring(index+1,value.length);
        },
        getEditType(value){               
            return this.arrEditType[this.arrEditType.findIndex(x=>x.value == value)].text;            
        },
        getApproveOtherType(value){
            return this.arrApproveOtherType[this.arrApproveOtherType.findIndex(x=>x.value == value)]['text'];
        },
        getApproveType(id){
            if (id){
                return this.arrApproveType[this.arrApproveType.findIndex(x=>x.value == id)]['text'];
            }
        },
        
        getThaiDate(item){
            var d = new Date(item);
            return d.toLocaleDateString('th-TH', { day: 'numeric', month: 'long', year: 'numeric' });
            //return moment(String(value)).format('LL')
        },
        inApproveTypeGroup2(id){

                return this.approveTypeGroup2.includes(id);


        },
        inApproveTypeGroup3(id){

                return this.approveTypeGroup3.includes(id);


        },
        editType(id){
            return this.arrEditType[this.editType.findIndex(x=>x.value == id)]['text'];
        },
        getThaiDate(item){
            var d = new Date(item);
            return d.toLocaleDateString('th-TH', { day: 'numeric', month: 'long', year: 'numeric' });
            //return moment(String(value)).format('LL')
        },
    }
}
</script>
<style scoped>
.form_name{
    font-size: 10pt!important;
}
.form_name3{
    font-size: 9pt!important;
    border: 1px #000 solid!important;
    text-align: center;
    color: #000;
}
.report_doc_list tr th{
    border: 1px #000 solid!important;

    font-weight: normal!important;
    font-size:10pt!important;
}
.report_doc_list{
    border: 1px #000 solid!important;
    margin-top: 10px!important;
    margin-bottom: 10px!important;
}
.report_doc_list tr td{
    vertical-align: top!important;
    padding: 5px 0 0 5px!important;
    border: 1px #000 solid!important;
}

.col, .col-6, .col-3{
    padding-left: 2px!important;
    padding-right: 2px!important;
}
.main_order{
    padding-top: 5px;
}
.topic{
    margin-bottom: 0px;
    text-align: center;
    color: #000;
    font-size:1rem!important;
}
p.head{
    font-weight: normal;
    width: 100%;
    margin-bottom: 3px!important;
    vertical-align: top!important;
    font-size: 0.8rem;
}
p.confirm{
    font-weight: normal;
    width: 100%;
    margin-bottom: 7px!important;
    font-size: 8pt!important;

}
p.head.sub{
    padding-left: 20px;
    padding-bottom: 0px;
}
.sub_order{
    margin-left: 5px;
}
th{
    padding: 5px;
}

.page {
        width: 297mm;
        min-height: 210mm;
        padding: 5mm;
        margin: auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}
.subpage {
    padding: 3mm;
    border: 0px rgb(0, 0, 0) solid;
    min-height: 195mm;
    outline: 0mm #FFEAEA solid;
}
.show{
    border-bottom: 1px solid #000;
    width: 100%;
    font-weight: normal!important;
    padding: 0 10px 0 10px!important;
    text-align: left;
    font-size: 8pt!important;
    vertical-align: bottom;

}
.show-list{

    width: 100%;
    font-weight: normal!important;
    padding: 0 5px 0 5px!important;
    text-align: left;
    font-size: 0.8rem!important;
    vertical-align: bottom;
    text-decoration: underline;
}
.table-bordered td{
    padding-top: 5px!important;
    padding-bottom: 3px!important;
    border: 2px #000 solid!important;
}
.table-bordered th{
    padding-top: 5px!important;
    padding-bottom: 3px!important;
    border: 2px #000 solid!important;
    text-align: center!important;

}
.table_rule td{
    padding: 0px 5px 0px 5px!important;
    border: 1px #c8ced3 solid!important;
}
.table_sub_rule td{
    border: 1px #c8ced3 solid!important;
}
.space{
    height: 17px;
    margin-bottom: 3px;
}
</style>
