<template>
    <div>
        <b-row align-h="center">
            <b-col cols="12" class="form_name">
                <h4 class="topic mt-4">รายการเอกสารที่ต้องจัดเตรียม</h4>
            </b-col>
        </b-row>
        <b-row align-h="center">
            <b-col cols="11">
                <table class="table table-bordered" style="width: 100%">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 30%">ประเภทเอกสาร</th>
                            <th scope="col" style="width: 70%">รายการเอกสาร</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><p class="head">1. เอกสารสัญญา</p></td>
                            <td><p class="head"><i class="far fa-square fa-lg"></i> สัญญาเลขที่ <span class="show-list">{{contract.contract_no}}</span>  ลงวันที่ <span class="show-list">{{getThaiDate(contract.contract_date)}}</span></p></td>
                        </tr>
                        <tr>
                            <td><p class="head">2. เอกสารการแก้ไขสัญญา</p></td>
                            <td>
                                <div class="main_order" v-for="(item,index) in contract_edit" :key="index">
                                    <p class="head"><i class="far fa-square fa-lg"></i> หนังสือแก้ไขสัญญาลงวันที่ <span class="show-list">{{getThaiDate(item.contract_edit_date)}}</span></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><p class="head">3. ข้อมูลการอนุมัติ งด / ลด / ขยายเวลา</p></td>
                            <td>

                                    <p  class="head">
                                        3.1 กรณีอนุมัติให้ตามมติ ครม.
                                    </p>
                                    <div v-for="item in contract_time_edit" :key="item.id">
                                        <div v-if="item.approve_type > 10 && item.approve_type <20 ">
                                            <p  class="head pl-4">
                                                <i class="far fa-square fa-lg"></i> ({{group_2}})(1) หนังสือผู้รับจ้างขอรับความช่วยเหลือตาม <span class="show-list">{{getApproveType(item.approve_type)}}</span>ที่แสดงวันที่หน่วยงานรับเรื่องไว้อย่างชัดเจน
                                            </p>
                                            <p  class="head pl-4">
                                                <i class="far fa-square fa-lg"></i> ({{group_2}})(2) หนังสือส่วนราชการอนุมัติ {{arrEditType[arrEditType.findIndex(x=>x.value == item.edit_type)]['text']}} ตาม <span class="show-list">{{getApproveType(item.approve_type)}}</span>ที่ผู้มีอำนาจลงนามอนุมัติ
                                            </p>
                                        </div>
                                    </div>
                                    <div v-if="count_group_1 == 0">
                                        <p  class="head pl-4">
                                                <i class="fas fa-square fa-lg"></i> หนังสือผู้รับจ้างขอรับความช่วยเหลือ ที่แสดงวันที่หน่วยงานรับเรื่องไว้อย่างชัดเจน
                                            </p>
                                            <p  class="head pl-4">
                                                <i class="fas fa-square fa-lg"></i> หนังสือส่วนราชการอนุมัติ ที่ผู้มีอำนาจลงนามอนุมัติ
                                            </p>
                                    </div>
                                    <p  class="head">
                                        3.2 กรณีอนุมัติตาม พรบ. ระเบียบ ข้อบังคับ หรือข้อบัญญัติ ของส่วนราชการว่าด้วยการพัสดุ
                                    </p>
                                    <p class="head  pl-2">
                                        3.2.1 ระเบียบพัสดุ ข้อ 136 ,ข้อ 139 (1) พรบ. จัดซื้อจัดจ้าง มาตรา 97 ,102 (1)
                                    </p>
                                    <div v-for="item2 in contract_time_edit" :key="item2.id*2">
                                        <div v-if="approveTypeGroup2.findIndex(x=>x == item2.approve_type) >= 0">
                                            <p  class="head  pl-4">
                                                <i class="far fa-square fa-lg"></i> ({{group_2}}) หนังสือส่วนราชการอนุมัติ <span class="show-list">{{arrEditType[arrEditType.findIndex(x=>x.value == item2.edit_type)]['text']}}</span> จำนวน <span class="show-list">{{item2.edit_days}}</span>วัน ที่ผู้มีอำนาจลงนามอนุมัติ และเอกสารอื่นที่เกี่ยวข้อง
                                            </p>
                                        </div>
                                    </div>
                                    <div v-if="count_group_2 == 0">
                                        <p  class="head pl-4">
                                            - ไม่มี -
                                        </p>
                                    </div>
                                    <p  class="head  pl-2">
                                        3.2.2 ระเบียบพัสดุ ข้อ 139 (2) ,(3) พรบ. จัดซื้อจัดจ้าง มาตรา 102 (2) ,(3)
                                    </p>
                                    <div v-for="item3 in contract_time_edit" :key="item3.id*3">
                                        <div v-if="approveTypeGroup3.findIndex(x=> x == item3.approve_type) >= 0">
                                            <p  class="head pl-4">
                                                <i class="far fa-square fa-lg"></i> ({{group_3}}) หนังสือส่วนราชการอนุมัติ <span class="show-list">{{arrEditType[arrEditType.findIndex(x=>x.value == item3.edit_type)]['text']}}</span> จำนวน <span class="show-list">{{item3.edit_days}}</span>วัน ที่ผู้มีอำนาจลงนามอนุมัติ
                                            </p>
                                        </div>
                                    </div>
                                    <div v-if="count_group_3 > 0">
                                        <p  class="head pl-4">
                                            <i class="far fa-square fa-lg"></i> เอกสารที่ระบุว่าเหตุหรือปัญหาอุปสรรคดังกล่าวสิ้นสุดลงวันที่เท่าใด
                                        </p>
                                        <p  class="head pl-4">
                                            <i class="far fa-square fa-lg"></i> เหนังสือผู้รับจ้างแจ้งเหตุภายใน 15 วัน นับแต่เหตุสิ้นสุด
                                        </p>
                                    </div>
                                    <div v-else>
                                        <p class="head pl-4">
                                            - ไม่มี -
                                        </p>
                                    </div>




                            </td>
                        </tr>
                        <tr>
                            <td><p class="head">4. ข้อมูลการส่งมอบงาน/ส่งมอบของ</p></td>
                            <td>
                                <div v-for="(item,index) in delivery" :key="index">
                                    <p class="head">
                                        4.{{index+1}} การส่งมอบงาน/ส่งมอบของ <span class="show-list">{{item.delivery}}</span>
                                    </p>
                                    <p class="head pl-4"><i class="far fa-square fa-lg"></i> หนังสือผู้รับจ้าง/ผู้ขาย ส่งมอบงาน/ส่งมอบของ <span class="show-list">{{item.delivery}}</span> เมื่อวันที่<span class="show-list"> {{getThaiDate(item.delivery_date)}} </span></p>
                                    <p class="head pl-4"><i class="far fa-square fa-lg"></i> ใบตรวจการจ้างงาน/ใบตรวจรับของ <span class="show-list">{{item.delivery}}</span></p>
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
                                    (กรณีนำส่งค่าปรับรวมหลายสัญญาในครั้งเดียวกัน ให้แนบรายละเอียดที่นำส่งเป็นสัญญาใด จำนวนเท่าไหร่ด้วย)
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><p class="head">6. กรอกข้อมูลขออนุมัติถอนคืนเงินค่าปรับ รายละเอียดที่ต้องแนบเหมือนกับข้อ 3 ทั้งนี้ จะเป็นตามข้อ 3.1 หรือ 3.2 ดูข้อมูลจากแบบฟอร์มถอนคืนที่เลือก</p></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">
                                <p class="head"><b>หมายเหตุ :</b> เอกสารประกอบการพิจารณา ต้องมีการรับรองสาเนาถูกต้องทุกฉบับ</p>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </b-col>
        </b-row>

    </div>
</template>
<script>

export default {
    props: ["contract","contract_edit","contract_time_edit","delivery","deposit_penalty"],
    data(){
        return {
            arrEditType : [
                {text: 'ขยายเวลา', value : 1},
                {text: 'งดหรือลดค่าปรับ', value : 2},
                {text: 'คืนเงินค่าปรับ', value : 3}
            ],
            arrApproveType : [
                {text: 'มติ ครม. ว 63 ลว 2 พ.ค. 54', value: 11},
                {text: 'มติ ครม. ว 66 ลว 6 พ.ค. 54', value: 12},
                {text: 'มติ ครม. ว 72 ลว 8 มี.ค. 55', value: 13},
                {text: 'มติ ครม. ว 204 ลว 15 ส.ค. 55', value: 14},
                {text: 'มติ ครม. ว 208 ลว 27 พ.ย. 56', value: 15},
                {text: 'มติ ครม. ว 141 ลว 21 พ.ย. 57', value: 16},
                {text: 'มติ ครม. ว 272 ลว 7 ก.ย. 59', value: 17},
                {text: 'มติ ครม. ว 399 ลว 10 ส.ค. 60', value: 18},
                {text: 'มติ ครม. ว 165 ลว 26 เม.ย. 62', value: 19},
                {text: 'ระเบียบพัสดุ 2535 ข้อ 136', value: 21},
                {text: 'ระเบียบพัสดุ 2535 ข้อ 139 (1)', value: 24},
                {text: 'ระเบียบพัสดุ 2535 ข้อ 139 (2)', value: 22},
                {text: 'ระเบียบพัสดุ 2535 ข้อ 139 (3)', value: 23},
                {text: 'พรบ. จัดซื้อจัดจ้าง ปี 2560 มาตรา 97', value: 34},
                {text: 'พรบ. จัดซื้อจัดจ้าง ปี 2560 มาตรา 102 (1)', value: 30},
                {text: 'พรบ. จัดซื้อจัดจ้าง ปี 2560 มาตรา 102 (2)', value: 31},
                {text: 'พรบ. จัดซื้อจัดจ้าง ปี 2560 มาตรา 102 (3)', value: 32}
            ],
            approveTypeGroup2 : [21,24,34,30],
            approveTypeGroup3 : [22,23,31,32],
            count_group_1: 0,
            count_group_2: 0,
            count_group_3: 0,

        }
    },
    computed: {
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
    },
    created(){
        
    },
    methods: {
        
        getApproveType(id){
            if (id){
                return this.arrApproveType[this.arrApproveType.findIndex(x=>x.value == id)]['text']
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
table>thead>th{
    border: 2px #000 solid!important;
}
table{
    border-width: 0px!important;
    margin-top: 10px!important;
}
table>tr>td{
    vertical-align: top!important;
    padding: 1px!important;
    border: 2px #000 solid!important;
}
table>tfoot>td{
    border-width: 0px!important;
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
    outline: 5mm #FFEAEA solid;
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
    padding: 0 10px 0 10px!important;
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
    background-color: rgb(29, 197, 219);
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
