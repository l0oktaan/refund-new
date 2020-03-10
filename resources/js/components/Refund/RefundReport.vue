<template>
    <!-- <b-button variant="outline-primary" @click="loadReport"><i class="fas fa-file-download fa-2x"></i></b-button> -->
    <div>
        <b-row class="justify-content-md-center text-center">
            <b-col>
                <b-button ref="print_form" id="print_form" variant="outline-dark" size="md" @click="printReport"><i class="fas fa-print fa-2x"></i></b-button>
                <b-button ref="save_form" id="save_form" variant="outline-danger" size="md" ><i class="fas fa-file-pdf fa-2x"></i></b-button>
                <b-popover target="print_form" triggers="hover" placement="top">
                    พิมพ์แบบถอนคืน
                </b-popover>
                <b-popover target="save_form" triggers="hover" placement="top">
                    บันทึกแบบถอนคืนเป็น PDF
                </b-popover>
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <div class="book" >
                    <div class="page" id="printThis">
                        <div class="subpage" v-if="isReady">
                            <b-row align-h="end">
                                <b-col cols="6" class="form_name">
                                    <p class="topic">{{refund.form.name1}}</p>
                                    <p class="topic">{{refund.form.name2}}</p>
                                </b-col>
                                <b-col cols="3">
                                    <p class="form_name3">{{refund.form.name3}}</p>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 40%"><p class="topic">ข้อเท็จจริง</p></th>
                                                <th style="width: 35%"><p class="topic">หลักเกณฑ์/เงื่อนไขตามมติคณะรัฐมนตรี</p></th>
                                                <th style="width: 25%"><p class="topic">การพิจารณา</p></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="main_order" v-for="contract in refund.refund.contracts" :key="contract.id">
                                                        <p class="head">1. รายละเอียดสัญญา ราย <span class="show"> {{contract.contract_party}}</span></p>
                                                        <div class="sub_order">
                                                            <p class="head">1.1 สัญญาเลขที่ <span class="show">{{contract.contract_no}}</span>  ลงวันที่ <span class="show">{{getThaiDate(contract.contract_date)}}</span></p>
                                                            <p class="head sub">สัญญาเริ่มต้น <span class="show">{{getThaiDate(contract.contract_start)}}</span>  สิ้นสุด <span class="show">{{getThaiDate(contract.contract_end)}}</span></p>
                                                            <p class="head" v-if="refund.refund.contract_edits">1.2 รายละเอียดการแก้ไขสัญญา เฉพาะที่เปลี่ยนวงเงินค่าจ้างและอัตราค่าปรับ</p>
                                                            <div v-for="(contract_edit,index) in refund.refund.contract_edits" :key="index">
                                                                <p class="head sub">{{'1.2.' + (index+1)}} หนังสือลงวันที่ <span class="show">{{getThaiDate(contract_edit.contract_edit_date)}}</span></p>
                                                                <p class="head sub">แก้ไขวงเงินค่าจ้างเป็น <span class="show">{{contract_edit.budget_new | numeral('0,0.00')}}</span> บาท ค่าปรับเป็น <span class="show">{{contract_edit.penalty_new | numeral('0,0.00')}}</span> บาท</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="main_order" v-if="time_edits">
                                                        <p class="head">2. รายละเอียดการอนุมัติงด/ลด/ขยายเวลา</p>
                                                        <div v-for="(time_edit,index) in time_edits" :key="index">
                                                            <p class="head sub">{{'2.' + (index + 1)}} วันที่อนุมัติ <span class="show">{{getThaiDate(time_edit.approve_date)}}</span> ประเภทการอนุมัติ <span class="show">{{getEditType(time_edit.edit_type)}}</span></p>
                                                            <p class="head sub">อนุมัติให้ตาม <span class="show">{{getApproveType(time_edit.approve_type)}}</span></p>
                                                            <p class="head sub" v-if="arrShowTimeEditDetail.includes(time_edit.approve_type)">กรณี <span class="show">{{time_edit.approve_case}}</span></p>
                                                            <p class="head sub" v-if="arrShowTimeEditDetail.includes(time_edit.approve_type)">อุปสรรคสิ้นสุดวันที่ <span class="show">{{getThaiDate(time_edit.problem_end_date)}}</span> หนังสือแจ้งเหตุวันที่ <span class="show">{{getThaiDate(time_edit.book_date)}}</span></p>
                                                            <p class="head sub">จำนวนวัน <span class="show">{{time_edit.edit_days}}</span> วัน <span v-if="time_edit.edit_type == 2 || time_edit.edit_type ==3">จำนวนเงิน <span class="show">{{time_edit.edit_budget | numeral('0,0.00')}} บาท</span></span></p>
                                                            <p class="head sub">ตั้งแต่วันที่ <span class="show">{{getThaiDate('2019-09-01')}}</span> ถึงวันที่ <span class="show">{{getThaiDate('2019-09-30')}}</span></p>

                                                        </div>
                                                    </div>


                                                </td>
                                                <!-- หลักเกณฑ์/เงื่อนไขตามมติคณะรัฐมนตรี -->
                                                <td colspan="2" style="padding-left: 0px; padding-right: 0px;">
                                                    <table style="width: 100%" class="table_rule">
                                                        <tr v-for="(rule,index) in refund.form.rules" :key="index">
                                                            <td :colspan="(rule.sub_rules.length > 0) ? 2 : 0" :style="(rule.sub_rules.length > 0) ? 'paddind: 0px!important' : 'width: 60%'">
                                                                <p class="head">{{rule.order + '. ' + rule.name}}</p>
                                                                <table style="width: 100%" class="table_sub_rule">
                                                                    <tr v-for="(sub_rule,index_x) in rule.sub_rules" :key="index_x">
                                                                        <td style="width: 60%">
                                                                            <p class="head">{{(index+1) + '.' + (index_x + 1) + ' ' + sub_rule.name}}</p>
                                                                        </td>
                                                                        <td style="width: 40%">
                                                                            <!-- <p class="head" v-for="(sub_consider,index_y) in sub_rule.considers" :key="index_y"><i :class="(1 == 1) ? icon_check : icon_uncheck"></i> {{sub_consider.name}}</p> -->
                                                                            <div v-for="(sub_consider,index_y) in sub_rule.considers" :key="index_y">
                                                                                <p class="head" v-if="sub_consider.type == 1"><i :class="(getDetail(sub_consider.id).status == 1) ? icon_check : icon_uncheck"></i> {{sub_consider.name}}</p>
                                                                                <p class="head" v-if="sub_consider.type == 2"><i :class="(getDetail(sub_consider.id).status == 1) ? icon_check : icon_uncheck"></i> {{sub_consider.name}}
                                                                                    <span class="show" >{{(getDetail(sub_consider.id).value) ? getDetail(sub_consider.id).value : ''}}</span>
                                                                                </p>
                                                                                <p class="head" v-if="sub_consider.type == 3"><i :class="(getDetail(sub_consider.id).status == 1) ? icon_check : icon_uncheck"></i> {{sub_consider.name}} ({{((getDetail(sub_consider.id).value)) ? ((getDetail(sub_consider.id).result_type == 'date') ? getThaiDate((getDetail(sub_consider.id).value)) : getDetail(sub_consider.id).value) : ''}})</p>
                                                                                <p class="head" v-if="sub_consider.type == 4"><i :class="(getDetail(sub_consider.id).status == 1) ? icon_check : icon_uncheck"></i> {{sub_consider.name}}
                                                                                    <span class="show" v-if="getDetail(sub_consider.id).value">{{getThaiDate(getDetail(sub_consider.id).value)}}</span>
                                                                                </p>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td v-if="rule.sub_rules.length == 0"  style="width: 40%">
                                                                <!-- <p class="head" ><i :class="(1 == 1) ? icon_check : icon_uncheck"></i> {{refund.detail[find_detail_index(rule.considers[0]['id'])]['result_type']}}</p> -->

                                                                <!-- <p>{{getDetail(rule.considers[0]['id']).result_type}}</p> -->
                                                                <div v-if="rule.considers[0]['type'] == 1">
                                                                    <p class="head" ><i :class="(getDetail(rule.considers[0]['id']).status == 1) ? icon_check : icon_uncheck"></i> {{rule.considers[0]['name']}}</p>
                                                                </div>
                                                                <div v-if="rule.considers[0]['type'] == 2">
                                                                    <p class="head" ><i :class="(getDetail(rule.considers[0]['id']).status == 1) ? icon_check : icon_uncheck"></i> {{rule.considers[0]['name']}}<span class="show">{{(getDetail(rule.considers[0]['id']).value) ? getDetail(rule.considers[0]['id']).value : ''}}</span></p>
                                                                </div>
                                                                <div v-if="rule.considers[0]['type'] == 3">
                                                                    <p class="head" ><i :class="(getDetail(rule.considers[0]['id']).status == 1) ? icon_check : icon_uncheck"></i> {{rule.considers[0]['name']}} ({{(getDetail(rule.considers[0]['id']).value) ? ((getDetail(rule.considers[0]['id']).result_type == 'date') ? getThaiDate(getDetail(rule.considers[0]['id']).value) : getDetail(rule.considers[0]['id']).value) : ''}})</p>
                                                                </div>
                                                                <div v-if="rule.considers[0]['type'] == 4">
                                                                    <p class="head" ><i :class="(getDetail(rule.considers[0]['id']).status == 1) ? icon_check : icon_uncheck"></i> {{rule.considers[0]['name']}}<span class="show" v-if="getDetail(rule.considers[0]['id']).status == 1">{{getThaiDate(getDetail(rule.considers[0]['id']).value)}}</span></p>
                                                                </div>
                                                            </td>
                                                            <!-- <td style="width: 57%">
                                                                <div class="main_order">
                                                                    <p class="head">{{rule.order + '. ' + rule.name}}</p>
                                                                     <div v-for="(sub_rule,index) in rule.sub_rules" :key="index">
                                                                        <p class="head sub">{{(index+1) + '. ' + sub_rule.name}}</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td style="width: 43%">
                                                                <div class="main_order" >

                                                                    <p class="head" v-if="rule.sub_rules.length == 0"><i :class="(1 == 1) ? icon_check : icon_uncheck"></i> {{rule.considers[0]['name']}}</p>
                                                                    <div v-else class="space"></div>
                                                                    <div v-for="(sub_rule,index) in rule.sub_rules" :key="index">
                                                                        <p class="head" v-for="(sub_consider,index_y) in sub_rule.considers" :key="index_y"><i :class="(1 == 1) ? icon_check : icon_uncheck"></i> {{sub_consider.name}}</p>
                                                                    </div>
                                                                </div>
                                                            </td> -->
                                                        </tr>
                                                    </table>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered">
                                        <tr>
                                            <td style="width: 40%">
                                                <div class="main_order">
                                                    <p class="head">3. รายละเอียดการส่งมอบงาน (เฉพาะที่มีค่าปรับ)</p>
                                                    <div v-for="(deliver,index) in delivers" :key="index">
                                                        <p class="head sub">{{'3.' + (index + 1)}} ส่งมอบงาน <span class="show">{{deliver.delivery}}</span> เมื่อวันที่ <span class="show">{{getThaiDate(deliver.delivery_date)}}</span></p>
                                                        <p class="head sub">เกินกำหนด <span class="show">{{deliver.overdue_days}}</span> วัน ถูกปรับเป็นเงิน <span class="show">{{deliver.penalty | numeral('0,0.00')}} บาท</span></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width: 35%"></td>
                                            <td style="width: 25%">
                                                <p class="head">รวมส่งมอบงานล่าช้า <span class="show">{{getOverdueDays()}}</span> วัน</p>
                                                <p class="head">รวมเป็นเงินค่าปรับ <span class="show">{{getPenaltyAll() | numeral('0,0.00')}}</span> บาท</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="main_order">
                                                        <p class="head">4. รายละเอียดการการนำส่ง/เบิกหักผลักส่งค่าปรับเป็นรายได้แผ่นดิน</p>
                                                        <div v-for="(deposit,index) in deposits" :key="index">
                                                            <p class="head sub">{{'4.' + (index + 1)}} เลขที่เอกสาร <span class="show">{{deposit.deposit_no}}</span> เมื่อวันที่ <span class="show">{{getThaiDate(deposit.deposit_date)}}</span></p>
                                                            <p class="head sub">เป็นเงิน <span class="show">{{deposit.amount | numeral('0,0.00')}} บาท</span></p>
                                                        </div>
                                                    </div>

                                            </td>
                                            <td></td>
                                            <td>
                                                <p class="head">นำส่ง/เบิกหักผลักส่งค่าปรับเป็นรายได้แผ่นดิน</p>
                                                <p class="head">ในปีงบประมาณ <span class="show">{{getDepositYear()}}</span></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="main_order">
                                                        <p class="head">5. การขอถอนคืนเงินค่าปรับแก้ผู้มีสิทธิ</p>
                                                        <div v-for="(approve,index) in approves" :key="index">
                                                            <p class="head sub">หน่วยงานอนุมัติให้ลงด ลดค่าปรับ คือเงินค่าปรับ </p>
                                                            <p class="head sub">จำนวน <span class="show">{{approve.refund_days}} วัน</span> เป็นเงิน <span class="show">{{approve.refund_amount | numeral('0,0.00')}}</span></p>
                                                            <p class="head sub">หน่วยงานขออนุมัติถอนคืน จำนวน <span class="show">{{approve.approve_amount | numeral('0,0.00')}} บาท</span></p>
                                                        </div>
                                                    </div>
                                            </td>
                                            <td></td>
                                            <td style="text-align: center;">
                                                <p></p>
                                                <p class="head">ลงชื่อ ....................................................</p>
                                                <p class="head">(................................................................)</p>
                                                <p class="head">ตำแหน่ง ....................................................</p>
                                            </td>
                                        </tr>
                                    </table>
                                </b-col>
                            </b-row>
                        </div>
                    </div>
                    <!-- <div class="page">
                        <div class="subpage">Page 2/2</div>
                    </div> -->
                </div>
            </b-col>
        </b-row>

    </div>
</template>
<script>
import jsPDF from 'jspdf'
export default {
    props: ['refund_id'],
    data(){
        return{
            refund : null,
            isReady : false,
            office_id: 2,
            obj: {
                'id' : 1111,
                'form' : {
                    'id' : 'f_111',
                    'name' : 'form 1'
                }
            },
            arrEditType : [
                {text: 'ประเภทการอนุมัติ', value : null},
                {text: 'ขยายเวลา', value : 1},
                {text: 'งดหรือลดค่าปรับ', value : 2},
                {text: 'คืนเงินค่าปรับ', value : 3}
            ],
            arrApproveType : [
                {text: 'อนุมัติให้ตาม', value: null},
                {text: 'มติ ครม. ว 63 ลว 2 พ.ค. 54', value: 11},
                {text: 'มติ ครม. ว 66 ลว 6 พ.ค. 54', value: 12},
                {text: 'มติ ครม. ว 72 ลว 8 มี.ค. 55', value: 13},
                {text: 'มติ ครม. ว 204 ลว 15 ส.ค. 55', value: 14},
                {text: 'มติ ครม. ว 208 ลว 27 พ.ย. 56', value: 15},
                {text: 'มติ ครม. ว 141 ลว 21 พ.ย. 57', value: 16},
                {text: 'มติ ครม. ว 272 ลว 7 ก.ย. 59', value: 17},
                {text: 'มติ ครม. ว 399 ลว 10 ส.ค. 60', value: 18},
                {text: 'ระเบียบพัสดุ 2535 ข้อ 136', value: 21},
                {text: 'ระเบียบพัสดุ 2535 ข้อ 139 (1)', value: 24},
                {text: 'ระเบียบพัสดุ 2535 ข้อ 139 (2)', value: 22},
                {text: 'ระเบียบพัสดุ 2535 ข้อ 139 (3)', value: 23},
                {text: 'พรบ. จัดซื้อจัดจ้าง ปี 2560 มาตรา 102 (1)', value: 30},
                {text: 'พรบ. จัดซื้อจัดจ้าง ปี 2560 มาตรา 102 (2)', value: 31},
                {text: 'พรบ. จัดซื้อจัดจ้าง ปี 2560 มาตรา 102 (3)', value: 32}
            ],
            arrShowTimeEditDetail : [
                22,23,31,32
            ],
            time_edits : [],
            delivers: [],
            deposits: [],
            approves: [],
            refund_form_id: 0,
            icon_check: 'far fa-check-square fa-lg',
            icon_uncheck: 'far fa-square fa-lg',
        }
    },
    mounted(){
        //this.getRefundFormID();
        this.getRefund();
        this.getContractTimeEdit();
        this.getDeliver();
        this.getDeposit();
        this.getApproveRefund();
    },
    computed: {

    },
    methods: {
        getRefundFormID(){
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms`;
            //var refund_form_id = 0;
            axios.get(`${path}`)
            .then(response=>{

                return response.data.data[0]['id'];

                //console.log('Refund Form ID :' + refund_form_id);
                // return refund_form_id;
            })
            .catch(error=>{

            })
        },
        loadReport(){
            let pdfName = 'test';
            var doc = new jsPDF();
            doc.setFont('Trirong');
            doc.text("ทดสอบ", 10, 10);
            doc.save(pdfName + '.pdf');
        },
        getRefund(){
            var refund_form_id = 0;
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms`;
            //var refund_form_id = 0;
            axios.get(`${path}`)
            .then(response=>{
                refund_form_id = response.data.data[0]['id'];
                path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${refund_form_id}`;
                axios.get(`${path}`)
                .then(response=>{
                    this.refund = _.cloneDeep(response.data.data);
                    this.isReady = true;
                    this.$forceUpdate();
                })
                .catch(error=>{

                })
            })
            .catch(error=>{

            })

        },
        getContractTimeEdit(){
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/contract_time_edits`;
            axios.get(`${path}`)
            .then(response=>{
                this.time_edits = response.data.data;
                this.$forceUpdate();
            })
            .catch(error=>{

            })
        },
        getDeliver(){
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/delivers`;
            axios.get(`${path}`)
            .then(response=>{
                this.delivers = response.data.data;
                this.$forceUpdate();
            })
            .catch(error=>{

            })
        },
        getDeposit(){
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/deposit_penalties`;
            axios.get(`${path}`)
            .then(response=>{
                this.deposits = response.data.data;
                this.$forceUpdate();
            })
            .catch(error=>{

            })
        },
        getApproveRefund(){
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/approve_refunds`;
            axios.get(`${path}`)
            .then(response=>{
                this.approves = response.data.data;
                this.$forceUpdate();
            })
            .catch(error=>{

            })
        },
        getThaiDate(item){
            var d = new Date(item);
            return d.toLocaleDateString('th-TH', { day: 'numeric', month: 'long', year: 'numeric' });
            //return moment(String(value)).format('LL')
        },
        getEditType(value){
            var index = this.arrEditType.findIndex(x => x.value == value);
            return this.arrEditType[index].text;
        },
        getApproveType(value){
            console.log('Get Approve Type :' + value);
            var index = this.arrApproveType.findIndex(x => x.value == value);
            return this.arrApproveType[index].text;
        },

        printReport(){
            console.log('print report');
            this.printElement(document.getElementById("printThis"));

        },
        printElement(elem) {

            var domClone = elem.cloneNode(true);

            var $printSection = document.getElementById("printSection");
            if (!$printSection) {
                var $printSection = document.createElement("div");
                $printSection.id = "printSection";
                document.body.appendChild($printSection);
            }
            $printSection.innerHTML = "";
            $printSection.appendChild(domClone);
            window.print();
        },
        getDetail(id){
            return this.refund.detail[this.refund.detail.findIndex(i => i.consider_id == id)];
        },
        getOverdueDays(){
            var overDueDays = 0;
            for (let i = 0; i < this.delivers.length; i++) {
                overDueDays = overDueDays + this.delivers[i]['overdue_days'];
            }
            return overDueDays;
        },
        getPenaltyAll(){
            var penalty = 0;

            for (let i = 0; i < this.delivers.length; i++) {
                penalty = penalty + this.delivers[i]['penalty'];
            }
            return penalty;
        },
        getDepositYear(){
            var arrYear = [];
            var tmp = [];
            var strYear = ''
            for (let i = 0; i < this.deposits.length; i++){
                tmp = this.deposits[i]['deposit_date'].split('-');
                if (arrYear.indexOf(tmp[0]) < 0){
                    arrYear.push(tmp[0]);
                }
            }

            for (let i = 0; i < arrYear.length; i++){
                strYear = strYear + (parseInt(arrYear[i]) + 543);
            }
            return strYear;

        }
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
.table th td{
    border: 2px #000 solid!important;
}
.table{
    margin-bottom: 0px!important;
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
    font-size: 10pt!important;
}
p.head{
    font-weight: normal;
    width: 100%;
    margin-bottom: 3px!important;
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
        height: 210mm;
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
    height: 195mm;
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
.table-bordered td{
    padding-top: 5px!important;
    padding-bottom: 3px!important;
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
