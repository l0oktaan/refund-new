<template>
    <!-- <b-button variant="outline-primary" @click="loadReport"><i class="fas fa-file-download fa-2x"></i></b-button> -->
    <div>
        <b-row class="justify-content-md-center text-center">
            <b-col>

                <b-button ref="print_form" id="print_form" variant="outline-dark" size="md" @click="printReport('printThis'+refund_id)"><i class="fas fa-print fa-2x"></i></b-button>
                <b-button ref="timeline_form" id="timeline_form" variant="outline-danger" size="md" @click="printReport('timeline')"><i class="fas fa-clock fa-2x"></i></b-button>
                <b-button ref="save_form" id="save_form" variant="outline-danger" size="md" @click="printReport('attach'+ refund_id)"><i class="fas fa-clipboard-list fa-2x"></i></b-button>
                <b-popover target="print_form" triggers="hover" placement="top">
                    พิมพ์แบบถอนคืน
                </b-popover>
                <b-popover target="timeline_form" triggers="hover" placement="top">
                    บันทึก Timeline
                </b-popover>
                <b-popover target="save_form" triggers="hover" placement="top">
                    พิมพ์รายการเอกสาร
                </b-popover>

            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <div class="book" id="book" ref="book">
                    <div class="page" :id="`printThis${refund_id}`" ref="printThis">
                        <div class="subpage" v-if="isReady">
                            <b-row>
                                <b-col cols="3">

                                    <table class="report">
                                        <tr>
                                            <td style="width: 30%;verical-align:top" class="office" ><p class="head" style="margin-bottom:0px!important">เลขที่แบบถอนคืน :</p></td>
                                            <td style="width: 70%;verical-align:top" class="office"><p class="head" style="margin-bottom:0px!important">{{refund.refund.approve_code}}</p></td>
                                        </tr>
                                        <tr>
                                            <td style="verical-align:top" class="office"><p class="head" style="margin-bottom:0px!important">ส่วนราชการ :</p></td>
                                            <td style="verical-align:top" class="office"><p class="head" style="margin-bottom:0px!important">{{refund.refund.office.code + ' : ' + refund.refund.office.name}}</p></td>
                                        </tr>
                                    </table>
                                </b-col>
                                <b-col cols="6" class="form_name">
                                    <p class="topic">{{refund.form.name1}}<span v-if="refund.form.type==1">{{' เมื่อวันที่ ' + getThaiFullDate(refund.form.minutes_date)}}</span></p>
                                    <p class="topic">{{refund.form.name2}}<span v-if="refund.form.type==1">{{' ' + refund.form.book_no + ' ลงวันที่ ' + getThaiFullDate(refund.form.book_date)}}</span></p>
                                </b-col>
                                <b-col cols="3">
                                    <p class="form_name3">{{refund.form.name3}}</p>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <table class="report">
                                        <thead>
                                            <tr>
                                                <th style="width: 40%"><p class="topic">ข้อเท็จจริง</p></th>
                                                <th style="width: 35%"><p class="topic">หลักเกณฑ์/เงื่อนไข</p></th>
                                                <th style="width: 25%"><p class="topic">การพิจารณา</p></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td >
                                                    <div class="main_order" v-for="contract in refund.refund.contracts" :key="contract.id">
                                                        <p class="head">1. รายละเอียดสัญญา ราย <span class="show"> {{contract.contract_party}}</span></p>
                                                        <div class="sub_order">
                                                            <p class="head">1.1 สัญญา/ใบสั่งจ้างเลขที่ <span class="show">{{contract.contract_no}}</span>  ลงวันที่ <span class="show">{{getThaiDate(contract.contract_date)}}</span></p>
                                                             <p class="head sub">วงเงินในสัญญา <span class="show">{{contract.budget | numeral('0,0.00')}} </span>{{contract.currency_unit=='USD' ? 'ดอลลาร์สหรัฐ' : 'บาท'}}  ค่าปรับ<span v-if="contract.penalty_type==1">วันละ <span class="show">{{contract.penalty_per_day | numeral('0,0.00')}} </span>{{contract.currency_unit=='USD' ? 'ดอลลาร์สหรัฐ' : 'บาท'}}</span><span v-if="contract.penalty_type==2">ร้อยละ<span class="show">{{contract.penalty_per_day_percent | numeral('0,0.00')}}</span>ต่อวัน</span></p>
                                                            <p class="head sub">สัญญาเริ่มต้น <span class="show">{{getThaiDate(contract.contract_start)}}</span>  สิ้นสุด <span class="show">{{getThaiDate(contract.contract_end)}}</span></p>

                                                            <p class="head" v-if="refund.refund.contract_edits">1.2 รายละเอียดการแก้ไขสัญญา เฉพาะที่เปลี่ยนวงเงินค่าจ้างและอัตราค่าปรับ {{refund.refund.contract_schedule_edits ? 'หรือมีการแก้ไขวันเริ่มต้น/วันสิ้นสุดสัญญา' : ''}}</p>
                                                            <div v-if="refund.refund.contract_schedule_edits && refund.refund.contract_schedule_edits.length > 0">
                                                                <div v-for="(contract_edit,index) in refund.refund.contract_schedule_edits" :key="index">
                                                                    <p class="head sub">{{'1.2.' + (index+1)}} หนังสือลงวันที่ <span class="show">{{getThaiDate(contract_edit.contract_edit_date)}}</span></p>
                                                                    <p class="head sub2">แก้ไขวัน<span v-if="contract_edit.contract_new_start_date">เริ่มต้นสัญญา เป็นวันที่<span class="show">{{getThaiDate(contract_edit.contract_new_start_date)}}</span></span><span v-if="contract_edit.contract_new_end_date">สิ้นสุดสัญญา เป็นวันที่<span class="show">{{getThaiDate(contract_edit.contract_new_end_date)}}</span></span></p>
                                                                    
                                                                </div>
                                                            </div>
                                                            <div v-if="refund.refund.contract_edits && refund.refund.contract_edits.length > 0">
                                                                <div v-for="(contract_edit,index) in refund.refund.contract_edits" :key="index">
                                                                    <p class="head sub">{{'1.2.' + (refund.refund.contract_schedule_edits && refund.refund.contract_schedule_edits.length > 0 ? refund.refund.contract_schedule_edits.length+1 : index+1)}} หนังสือลงวันที่ <span class="show">{{getThaiDate(contract_edit.contract_edit_date)}}</span></p>
                                                                    <p class="head sub2">แก้ไขวงเงินค่าจ้างเป็น <span class="show">{{contract_edit.budget_new | numeral('0,0.00')}}</span> บาท ค่าปรับเป็น <span class="show">{{contract_edit.penalty_new | numeral('0,0.00')}}</span> บาท</p>
                                                                </div> 
                                                            </div> 
                                                            <p class="head sub" v-if="(!refund.refund.contract_schedule_edits || refund.refund.contract_schedule_edits.length == 0) && (!refund.refund.contract_edits || refund.refund.contract_edits.length == 0)">-ไม่มี-</p>
                                                        </div> 
                                                    </div>
                                                    <div class="main_order">
                                                        <p class="head">2. รายละเอียดการอนุมัติ ขยาย/งด/ลด</p>
                                                        <div v-if="time_edits && time_edits.length > 0">
                                                            <div v-for="(time_edit,index) in time_edits" :key="index">
                                                                <p class="head sub">{{'2.' + (index + 1)}} วันที่อนุมัติ <span class="show">{{getThaiDate(time_edit.approve_date)}}</span> อนุมัติ <span class="show">{{getEditType(time_edit.edit_type)}}</span><span v-if="time_edit.edit_type > 1 && (time_edit.edit_budget && time_edit.edit_budget > 0)">จำนวนเงิน<span v-if="time_edit.edit_type > 1"><span class="show">{{time_edit.edit_budget | numeral('0,0.00')}}</span> บาท</span></span> </p>
                                                                <p class="head sub2">ตาม <span class="show">{{getApproveType(time_edit.approve_type)}}</span><span class="show" v-if="time_edit.approve_type == 99">{{'( ' + time_edit.approve_other_desc + ' )'}}</span></p>
                                                                <p class="head sub2" v-if="time_edit.approve_type == 99"> เข้าตามกรณี <span class="show">{{arrApproveOtherType[arrApproveOtherType.findIndex(x=>x.value == time_edit.approve_other_type)]['text']}}</span></p>
                                                                <p class="head sub2"><span v-if="time_edit.approve_type > 20 && time_edit.approve_type < 40">กรณี</span> <span class="show" v-if="time_edit.approve_type > 20 && time_edit.approve_type < 40">{{time_edit.approve_case}}</span>จำนวนวัน<span class="show">{{time_edit.edit_days}}</span>วัน </p>
                                                                <p class="head sub2">{{time_edit.edit_type == 1 ? 'โดยอนุมัติขยายเวลา ' : time_edit.edit_type == 2 ? 'โดยอนุมัติงดหรือลดค่าปรับ ' : ''}}ตั้งแต่วันที่ <span class="show">{{getThaiDate(time_edit.edit_start_date)}}</span> {{time_edit.edit_type == 1 ? 'เป็นสิ้นสุดสัญญาวันที่' : 'ถึงวันที่ :'}} <span class="show">{{getThaiDate(time_edit.edit_end_date)}}</span></p>
                                                                <p class="head sub2" v-if="arrShowTimeEditDetail.includes(parseInt(time_edit.approve_type)) || (time_edit.approve_type == 99 && time_edit.approve_other_type != 1)">อุปสรรคสิ้นสุดวันที่ <span class="show">{{getThaiDate(time_edit.problem_end_date)}}</span> หนังสือแจ้งเหตุวันที่ <span class="show">{{getThaiDate(time_edit.book_date)}}</span></p>
                                                                <p class="head sub2" v-if="parseInt(time_edit.approve_type) == 40">โดยได้รับผลกระทบจากเหตุความไม่สงบทางการเมือง<br> ตั้งแต่วันที่ : <span class="show">{{getThaiDate(time_edit.problem_end_date)}}</span> ถึงวันที่ <span class="show">{{getThaiDate(time_edit.book_date)}}</span></p>
                                                                <p class="head sub2" v-if="parseInt(time_edit.approve_type) == 41">โดยได้รับผลกระทบจากกรณีโรคโควิด 19<br> ตั้งแต่วันที่ : <span class="show">{{getThaiDate(time_edit.problem_end_date)}}</span> ถึงวันที่ <span class="show">{{getThaiDate(time_edit.book_date)}}</span></p>
                                                            </div>
                                                        </div>
                                                        <p class="head sub" v-else>-ไม่มี-</p>
                                                    </div>
                                                </td>
                                                <!-- หลักเกณฑ์/เงื่อนไขตามมติคณะรัฐมนตรี -->
                                                <td colspan="2" style="padding-left: 0px; padding-right: 0px;" >
                                                    <table style="width: 100%;" class="table_rule" >
                                                        <tr v-for="(rule,index) in refund.form.rules" :key="index">
                                                            <td :colspan="(rule.sub_rules.length > 0) ? 2 : 0 "  :class="(rule.sub_rules.length > 0) ? 'has_sub_rule' : 'non_sub_rule'">
                                                                <p class="head">{{rule.order + '. ' + rule.name}}</p>
                                                                <table style="width: 100%" class="table_sub_rule_2">
                                                                    <tr v-for="(sub_rule,index_x) in rule.sub_rules" :key="index_x" class="sub_rule_tr">
                                                                        <td style="width: 378px" class="sub_rule_td">
                                                                            <p class="head sub">{{(index+1) + '.' + (index_x + 1) + ' ' + sub_rule.name}}</p>
                                                                        </td>
                                                                        <td style="width: 270px">
                                                                            <!-- <p class="head" v-for="(sub_consider,index_y) in sub_rule.considers" :key="index_y"><i :class="(1 == 1) ? icon_check : icon_uncheck"></i> {{sub_consider.name}}</p> -->
                                                                            <div v-for="(sub_consider,index_y) in sub_rule.considers" :key="index_y">
                                                                                <p class="head" v-if="sub_consider.type == 1"><i :class="(getDetail(sub_consider.id).status == 1) ? icon_check : icon_uncheck"></i> {{sub_consider.name}}</p>
                                                                                <p class="head" v-if="sub_consider.type == 2"><i :class="(getDetail(sub_consider.id).status == 1) ? icon_check : icon_uncheck"></i> {{sub_consider.name}}
                                                                                    <span class="show" >{{(getDetail(sub_consider.id).value) ? getDetail(sub_consider.id).value : ''}}</span>
                                                                                </p>
                                                                                <!-- <p class="head" v-if="sub_consider.type == 3"><i :class="(getDetail(sub_consider.id).status == 1) ? icon_check : icon_uncheck"></i> {{sub_consider.name}} ({{((getDetail(sub_consider.id).value)) ? ((getDetail(sub_consider.id).result_type == 'date') ? getThaiDate((getDetail(sub_consider.id).value)) : (sub_consider.oper == 1) ? getDetail(sub_consider.id).value + ' วัน' :getDetail(sub_consider.id).value) : ''}})</p> -->
                                                                                <p class="head" v-if="sub_consider.type == 3"><i :class="(getDetail(sub_consider.id).status == 1) ? icon_check : icon_uncheck"></i> {{sub_consider.name}}
                                                                                    <span class="show" v-if="getDetail(sub_consider.id).value && getDetail(sub_consider.id).result_type == 'date'">{{getThaiDate(getDetail(sub_consider.id).value)}}</span>
                                                                                    <span class="show" v-else-if="getDetail(sub_consider.id).value && (getDetail(sub_consider.id).result_type == 'value' || getDetail(sub_consider.id).result_type == 'inArray')">{{getDetail(sub_consider.id).value}}</span>
                                                                                    <span v-else-if="getDetail(sub_consider.id).value && getDetail(sub_consider.id).result_type == 'number'"><span class="show">{{getDetail(sub_consider.id).value}}</span> วัน</span>

                                                                                </p>
                                                                                <div v-if="(sub_consider.type == 3 && getDetail(sub_consider.id).value && (getDetail(sub_consider.id).result_type == 'gap'))">
                                                                                    <p class="head sub">วันที่ปัญหาอุปสรรคสิ้นสุด <span class="show">{{getThaiDate(getDetail(sub_consider.id).value.split('|')[0])}}</span> </p>
                                                                                    <p class="head sub">วันที่ผู้รับจ้างแจ้งเหตุสิ้นสุด <span class="show">{{getThaiDate(getDetail(sub_consider.id).value.split('|')[1])}}</span></p>
                                                                                </div>
                                                                                <div v-if="(sub_consider.type == 3 && getDetail(sub_consider.id).value && (getDetail(sub_consider.id).result_type == 'gap2'))">
                                                                                    <p class="head sub">ให้ความช่วยเหลือตามมติ ครม.ว 208 ถึงวันที่ <span class="show">{{getThaiDate(getDetail(sub_consider.id).value.split('|')[0])}}</span> </p>
                                                                                    <p class="head sub">ส่งมอบงานงวดสุดท้ายวันที่ <span class="show">{{getThaiDate(getDetail(sub_consider.id).value.split('|')[1])}}</span></p>
                                                                                </div>

                                                                                <p class="head" v-if="sub_consider.type == 4"><i :class="(getDetail(sub_consider.id).status == 1) ? icon_check : icon_uncheck"></i> {{sub_consider.name}}
                                                                                    <span class="show" v-if="getDetail(sub_consider.id).value">{{getThaiDate(getDetail(sub_consider.id).value)}}</span>
                                                                                </p>
                                                                                <p class="head" v-if="sub_consider.type == 5"><i :class="(getDetail(sub_consider.id).status == 1) ? icon_check : icon_uncheck"></i> {{sub_consider.name}}
                                                                                    <span class="show" >{{(getDetail(sub_consider.id).value) ? getDetail(sub_consider.id).value : ''}}</span> {{sub_consider.var1}}
                                                                                </p>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td v-if="rule.sub_rules.length == 0"  style="width: 270px">


                                                                <div v-for="(sub_consider,index_z) in rule.considers" :key="index_z">
                                                                    <p class="head" v-if="sub_consider.type == 1"><i :class="(getDetail(sub_consider.id).status == 1) ? icon_check : icon_uncheck"></i> {{sub_consider.name}}</p>
                                                                    <p class="head" v-if="sub_consider.type == 2"><i :class="(getDetail(sub_consider.id).status == 1) ? icon_check : icon_uncheck"></i> {{sub_consider.name}}
                                                                        <span class="show" >{{(getDetail(sub_consider.id).value) ? getDetail(sub_consider.id).value : ''}}</span>
                                                                    </p>
                                                                    <!-- <p class="head" v-if="sub_consider.type == 3"><i :class="(getDetail(sub_consider.id).status == 1) ? icon_check : icon_uncheck"></i> {{sub_consider.name}} ({{((getDetail(sub_consider.id).value)) ? ((getDetail(sub_consider.id).result_type == 'date') ? getThaiDate((getDetail(sub_consider.id).value)) : (sub_consider.oper == 1) ? getDetail(sub_consider.id).value + ' วัน' :getDetail(sub_consider.id).value) : ''}})</p> -->
                                                                    <p class="head" v-if="sub_consider.type == 3"><i :class="(getDetail(sub_consider.id).status == 1) ? icon_check : icon_uncheck"></i> {{sub_consider.name}}
                                                                        <span class="show" v-if="getDetail(sub_consider.id).value && getDetail(sub_consider.id).result_type == 'date'">{{getThaiDate(getDetail(sub_consider.id).value)}}</span>
                                                                        <span class="show" v-else-if="getDetail(sub_consider.id).value && (getDetail(sub_consider.id).result_type == 'value' || getDetail(sub_consider.id).result_type == 'inArray')">{{getDetail(sub_consider.id).value}}</span>
                                                                        <span v-else-if="getDetail(sub_consider.id).value && getDetail(sub_consider.id).result_type == 'number'"><span class="show">{{getDetail(sub_consider.id).value}}</span> วัน</span>
                                                                    </p>
                                                                    <div v-if="(sub_consider.type == 3 && getDetail(sub_consider.id).value && (getDetail(sub_consider.id).result_type == 'gap'))">
                                                                        <p class="head">วันที่ปัญหาอุปสรรคสิ้นสุด <span class="show">{{getThaiDate(getDetail(sub_consider.id).value.split('|')[0])}}</span> </p>
                                                                        <p class="head">วันที่ผู้รับจ้างแจ้งเหตุสิ้นสุด <span class="show">{{getThaiDate(getDetail(sub_consider.id).value.split('|')[1])}}</span></p>
                                                                    </div>
                                                                    <div v-if="(sub_consider.type == 3 && getDetail(sub_consider.id).value && (getDetail(sub_consider.id).result_type == 'gap2'))">
                                                                        <p class="head">ให้ความช่วยเหลือตามมติ ครม.ว 208 ถึงวันที่ <span class="show">{{getThaiDate(getDetail(sub_consider.id).value.split('|')[0])}}</span> </p>
                                                                        <p class="head">ส่งมอบงานงวดสุดท้ายวันที่ <span class="show">{{getThaiDate(getDetail(sub_consider.id).value.split('|')[1])}}</span></p>
                                                                    </div>
                                                                    <p class="head" v-if="sub_consider.type == 4"><i :class="(getDetail(sub_consider.id).status == 1) ? icon_check : icon_uncheck"></i> {{sub_consider.name}}
                                                                        <span class="show" v-if="getDetail(sub_consider.id).value">{{getThaiDate(getDetail(sub_consider.id).value)}}</span>
                                                                    </p>
                                                                    <p class="head" v-if="sub_consider.type == 5"><i :class="(getDetail(sub_consider.id).status == 1) ? icon_check : icon_uncheck"></i> {{sub_consider.name}}
                                                                        <span class="show" >{{(getDetail(sub_consider.id).value) ? getDetail(sub_consider.id).value : ''}}</span> {{sub_consider.var1}}
                                                                    </p>
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
                                            <tr>
                                                <td style="width: 435px">
                                                    <div class="main_order">
                                                        <p class="head">3. รายละเอียดการส่งมอบงานเกินกำหนดสัญญา</p>
                                                        <div v-for="(deliver,index) in delivers" :key="index">
                                                            <p class="head sub">{{'3.' + (index + 1)}} ส่งมอบงาน <span class="show">{{deliver.delivery}}</span> เมื่อวันที่ <span class="show">{{getThaiDate(deliver.delivery_date)}}</span></p>
                                                            <p class="head sub2" >เกินกำหนดสัญญาตั้งแต่วันที่ <span class="show">{{getThaiDate(deliver.overdue_start_date)}}</span> ถึงวันที่ <span class="show">{{getThaiDate(deliver.overdue_end_date)}}</span></p>
                                                            <p class="head sub2" v-if="deliver.detail != ''">รายละเอียดส่งมอบงาน<span class="show">{{deliver.detail}}</span></p>
                                                            <p class="head sub2" v-if="deliver.penalty_accept && deliver.penalty_accept > 0">คิดค่าปรับ <span class="show">{{deliver.overdue_days}}</span> วัน ถูกปรับเป็นเงิน <span class="show">{{deliver.penalty_accept | numeral('0,0.00')}}</span>{{refund.refund.contracts[0].currency_unit == 'THB' ? 'บาท' : 'ดอลลาร์สหรัฐ'}}</p>                                                            
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="width: 379px"></td>
                                                <td style="width: 270px">
                                                    <p class="head">รวมส่งมอบงานล่าช้า <span class="show">{{getOverdueDays()}}</span> วัน</p>
                                                    <p class="head">รวมเป็นเงินค่าปรับ <span class="show">{{getPenaltyAcceptAll() | numeral('0,0.00')}}</span> {{refund.refund.contracts[0].currency_unit == 'THB' ? 'บาท' : 'ดอลลาร์สหรัฐ'}}</p>
                                                    <p class="head" v-if="(getPenaltyAll() != getPenaltyAcceptAll()) && (getPenaltyAll() > 0) ">ตามข้อเท็จจริงต้องปรับไว้ <span class="show">{{getPenaltyAll() | numeral('0,0.00')}}</span> {{refund.refund.contracts[0].currency_unit == 'THB' ? 'บาท' : 'ดอลลาร์สหรัฐ'}}</p>
                                                </td>
                                            </tr>
                                            <tr >
                                                <td>
                                                    <div class="main_order">
                                                            <p class="head">4. รายละเอียดการนำส่ง/เบิกหักผลักส่งค่าปรับเป็นรายได้แผ่นดิน</p>
                                                            <div v-for="(deposit,index) in deposits" :key="index">
                                                                <p class="head sub">{{'4.' + (index + 1)}} เลขที่เอกสาร <span class="show">{{deposit.deposit_no}}</span> วันที่ผ่านรายการ <span class="show">{{getThaiDate(deposit.deposit_date)}}</span></p>
                                                                <p class="head sub2">เป็นเงิน <span class="show">{{deposit.amount | numeral('0,0.00')}}</span> บาท <span v-if="deposit.amount != deposit.amount_in_contract">เป็นค่าปรับของสัญญานี้ <span class="show">{{deposit.amount_in_contract | numeral('0,0.00')}}</span> บาท</span></p>
                                                            </div>
                                                        </div>

                                                </td>
                                                <td></td>
                                                <td>
                                                    <p class="head">นำส่ง/เบิกหักผลักส่งค่าปรับเป็นรายได้แผ่นดิน</p>
                                                    <p class="head">รวมเป็นเงิน <span class="show">{{getDepositAll() | numeral('0,0.00')}}</span> บาท</p>
                                                    <p class="head">ในปีงบประมาณ <span class="show">{{getDepositYear()}}</span></p>
                                                </td>
                                            </tr>
                                            <tr >
                                                <td>
                                                    <div class="main_order">
                                                            <p class="head">5. การขอถอนคืนเงินค่าปรับแก่ผู้มีสิทธิ</p>
                                                            <div v-for="(approve,index) in approves" :key="index">
                                                                <p class="head sub" v-if="approve.refund_days != approve.refund_money">{{refund.form.name3.includes('693') ? 'หน่วยงานอนุมัติแก้ไขอัตราค่าปรับเป็นร้อยละ 0 จำนวน ' : 'หน่วยงานอนุมัติ งดหรือลดค่าปรับ จำนวน '}}<span class="show">{{approve.refund_days}} </span>วัน </p>
                                                                <p class="head sub" v-if="approve.refund_days != approve.refund_money"><span>และคืนค่าปรับ จำนวน <span class="show">{{approve.refund_money}} </span> วัน</span> เป็นเงิน <span class="show">{{approve.refund_amount | numeral('0,0.00')}}</span> บาท</p>
                                                                <p class="head sub" v-if="approve.refund_days == approve.refund_money">{{refund.form.name3.includes('693')? 'หน่วยงานคิดค่าปรับในอัตราร้อยละ 0' : 'หน่วยงานอนุมัติงดหรือลดค่าปรับหรือคืนค่าปรับ'}} จำนวน <span class="show">{{approve.refund_days}} </span>วัน เป็นเงิน <span class="show">{{approve.refund_amount | numeral('0,0.00')}}</span> บาท</p>
                                                                <p class="head sub"></p>
                                                                <p class="head sub">หน่วยงานขออนุมัติถอนคืน จำนวน <span class="show">{{approve.approve_amount | numeral('0,0.00')}} </span> บาท</p>
                                                            </div>
                                                        </div>
                                                </td>
                                                <td></td>
                                                <td style="text-align: center;">
                                                    <p class="confirm">ขอรับรองว่าเป็นข้อมูลที่ถูกต้อง</p>
                                                    <div class="head-sign">ลงชื่อ ..............................................................</div>
                                                    <div class="head-sign">(...........................................................................)</div>
                                                    <div class="head-sign">ตำแหน่ง ...............................................................</div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </b-col>
                            </b-row>
                        </div>
                    </div>
                    <div class="page" id="timeline">
                        <div class="subpage" v-if="isReady">

                            <b-row>
                                <b-col>
                                    <my-schedule :list="sort_timeline"></my-schedule>
                                </b-col>
                            </b-row>
                        </div>
                    </div>
                    <div class="page" :id="`attach${refund_id}`">
                        <div class="subpage" v-if="isReady">
                            <refund-report-doc-list
                                :form = "refund.form"
                                :detail = "refund.detail"
                                :contract = "refund.refund.contracts[0]"
                                :contract_edit = "refund.refund.contract_edits"
                                :contract_time_edit = "time_edits"
                                :delivery = "delivers"
                                :deposit_penalty = "deposits"
                                :approve = "approves[0]"
                            ></refund-report-doc-list>
                        </div>
                    </div>
                </div>

            </b-col>
        </b-row>

    </div>
</template>
<script>
import { saveAs } from 'file-saver';
import jsPDF from 'jspdf'
import domtoimage from 'dom-to-image-more'
export default {
    props: ['refund_id','office_id','show_report'],
    data(){
        return{
            refund : null,
            isReady : false,
            bookHeight : 0,
            refund_status : 0,
            //office_id: this.$store.getters.office_id,
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
                {text: 'งดค่าปรับ', value : 4},
                {text: 'ลดค่าปรับ', value : 5},
                {text: 'งดหรือลดค่าปรับ', value : 2},
                {text: 'คืนเงินค่าปรับ', value : 3} 
            ],
            arrApproveType : this.$store.getters.arrApproveType,
            arrApproveOtherType: [
                {text: 'ตัวเลือก', value : null},
                {text: '(1) เหตุเกิดจากความผิดหรือความบกพร่องของส่วนราชการ (ผู้ว่าจ้าง/หน่วยงาน)', value : 1},
                {text: '(1) เหตุเกิดจากความผิดหรือความบกพร่องของหน่วยการบริหารราชการส่วนท้องถิ่น', value : 10},
                {text: '(2) เหตุสุดวิสัย', value : 2},
                {text: '(3) เหตุเกิดจากพฤติการณ์อันหนึ่งอันใดที่คู่สัญญาไม่ต้องรับผิดตามกฎหมาย', value : 3}
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
            check: false,
            report_height: 0,
            show: false,
            time_line: []
        }
    },
   async mounted(){
        await this.getRefundFormID();
        await this.getRefund();
        await this.getContractTimeEdit();
        await this.getDeliver();
        await this.getDeposit();
        await this.getApproveRefund();
    },
    created(){

        setInterval(() => {
            this.check = !this.check;
        }, 5000);
    },
    watch: {
        // refund_id(){
        //     if (this.refund_id != 0){
        //         this.getRefund();
        //         this.getContractTimeEdit();
        //         this.getDeliver();
        //         this.getDeposit();
        //         this.getApproveRefund();
        //     }
        // },
        check(){
            this.matchHeight();
        },
        async show_report(){
            if (this.show_report == true){
                await this.getRefundFormID();
                await this.getRefund();
                await this.getContractTimeEdit();
                await this.getDeliver();
                await this.getDeposit();
                await this.getApproveRefund();
            }
        }
    },
    computed: {
        sort_timeline(){
            return this.time_line.sort(function(a, b) {
                console.log(a.type + ' ' + b.type)
                if (a.type == 'contract' || b.type == 'contract'){
                    return
                }
                return a.start - b.start;
            });
        }

    },
    methods: {
        matchHeight(){
            this.$nextTick(()=>{
                this.report_height = this.$refs.printThis.clientHeight/3.779527559055;
            })

        },
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
        async getRefund(){
            try {
                var refund_form_id = await 0;
            var path = await `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms`;
            //var refund_form_id = 0;
            let res = await axios.get(`${path}`)

            refund_form_id = await res.data.data[0]['id'];
            path = await `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${refund_form_id}`;
            let response = await axios.get(`${path}`)

                this.refund = await _.cloneDeep(response.data.data);
                this.refund_status = await this.refund.status;
                this.isReady = await true;
                let start = await new Date(this.refund.refund.contracts[0].contract_start);
                let end = await new Date(this.refund.refund.contracts[0].contract_end)
                await this.createTimeLine({
                    name: 'สัญญาเริ่มต้น และสิ้นสุด',
                    type: 'contract',
                    start: Date.UTC(start.getFullYear(),start.getMonth(),start.getDate()),
                    end: Date.UTC(end.getFullYear(),end.getMonth(),end.getDate()),
                    color: "#ffe6e6",
                    borderWidth: "1",
                    borderColor: "gray",                   
                    
                })
                if (this.refund.refund.contract_schedule_edits && this.refund.refund.contract_schedule_edits.length > 0){
                    for (let i=0;i<this.refund.refund.contract_schedule_edits.length;i++){
                        let edit_start = await null;
                        let edit_end = await null;
                        if (this.refund.refund.contract_schedule_edits[i].contract_new_start_date){
                            edit_start = await new Date(this.refund.refund.contract_schedule_edits[i].contract_new_start_date)
                        }else{
                            edit_start = await start
                        }
                        if (this.refund.refund.contract_schedule_edits[i].contract_new_end_date){
                            edit_end = await new Date(this.refund.refund.contract_schedule_edits[i].contract_new_end_date)
                        }else{
                            edit_end = await end
                        }
                        await this.createTimeLine({
                            name: ' มีการแก้ไขวันเริ่มต้น/วันสิ้นสุดสัญญา วันที่ ' + this.getThaiDate(this.refund.refund.contract_schedule_edits[i].contract_edit_date),
                            type: 'schedule_edit',
                            start: Date.UTC(edit_start.getFullYear(),edit_start.getMonth(),edit_start.getDate()),
                            end: Date.UTC(edit_end.getFullYear(),edit_end.getMonth(),edit_end.getDate()),
                            color: "#ffe6e6",
                            borderWidth: "1",
                            borderColor: "gray",                   
                            
                        })
                    }
                }
                await this.$forceUpdate();
            } catch (error) {
                console.log('Get Refund Error')
            }
            





        },

        async getContractTimeEdit(){
            try {
                var path = await  `/api/offices/${this.office_id}/refunds/${this.refund_id}/contract_time_edits`;
                let response = await axios.get(`${path}`)

                    let time_edits = await  response.data.data;
                    this.time_edits = await  time_edits;
                    for (let i=0;i<time_edits.length;i++){
                        let start = await  new Date(time_edits[i].edit_start_date);
                        let end = await  new Date(time_edits[i].edit_end_date);

                        await this.createTimeLine({
                            name: 'อนุมัติ' + this.getEditType(time_edits[i].edit_type) + ' ' + time_edits[i].edit_days + ' วัน',
                            type: 'time_edit',
                            start: Date.UTC(start.getFullYear(),start.getMonth(),start.getDate()),
                            end: Date.UTC(end.getFullYear(),end.getMonth(),end.getDate()),
                            color: "#e6ffff",
                            borderWidth: "1",
                            borderColor: "gray",
                        });
                    }

                    await this.$forceUpdate();
            } catch (error) {
                console.log('GetTimeEdit Error')
            }
            


        },
        async getDeliver(){
            try {
                var path = await `/api/offices/${this.office_id}/refunds/${this.refund_id}/delivers`;
                let response = await axios.get(`${path}`)

                this.delivers = await response.data.data;
                for (let i=0;i<this.delivers.length;i++){
                    let start = await  new Date(this.delivers[i].overdue_start_date);
                    let end = await  new Date(this.delivers[i].overdue_end_date);

                    await this.createTimeLine({
                        name : 'ค่าปรับงาน' + this.delivers[i].delivery + ((!this.delivers[i].penalty) ? ' (ไม่มีค่าปรับ)' : ''),
                        type: 'delivery',
                        start: Date.UTC(start.getFullYear(),start.getMonth(),start.getDate()),
                        end: Date.UTC(end.getFullYear(),end.getMonth(),end.getDate()),
                        color: "#e6e6ff",
                        borderWidth: "1",
                        borderColor: "gray",
                    })
                }
                this.$forceUpdate();
            } catch (error) {
                console.log('delivery error')
            }
            


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
        async getApproveRefund(){
            var path = await `/api/offices/${this.office_id}/refunds/${this.refund_id}/approve_refunds`;
            let response = await axios.get(`${path}`)

            this.approves = response.data.data;
            for (let i=0;i<this.approves.length;i++){
                let start = await  new Date(this.approves[i].start_date);
                let end = await  new Date(this.approves[i].end_date);
                let approve = this.refund.form.name3.replace('แบบถอนคืน','');
                approve = approve.replace('ตาม','');

                await this.createTimeLine({
                    name : approve.includes('693') ? 'แก้ไขสัญญาโดยคิดค่าปรับในอัตราร้อยละ 0 (' + approve + ') ' + this.approves[i].refund_days + ' วัน' : 'อนุมัติงด ลด ค่าปรับ (' + approve + ') ' + this.approves[i].refund_days + ' วัน',
                    type: 'approve',
                    start: Date.UTC(start.getFullYear(),start.getMonth(),start.getDate()),
                    end: Date.UTC(end.getFullYear(),end.getMonth(),end.getDate()),
                    color: "#e6ffe6",
                    borderWidth: "1",
                    borderColor: "gray",
                    

                })
            }

            this.$forceUpdate();

        },
        getThaiDate(item){
            var d = new Date(item);
            return d.toLocaleDateString('th-TH', { day: 'numeric', month: 'short', year: 'numeric' });
            //return moment(String(value)).format('LL')
        },
        getThaiFullDate(item){
            var d = new Date(item);
            return d.toLocaleDateString('th-TH', { day: 'numeric', month: 'long', year: 'numeric' });
            //return moment(String(value)).format('LL')
        },
        getEditType(value){
            try {
                var index = this.arrEditType.findIndex(x => x.value == value);
                if (index >= 0){                
                    let text = this.arrEditType[index]['text'];
                    console.log('edit type index :' + index + ' text :' + text);
                    return text;
                }else{
                    return '';
                }
            } catch (error) {
                console.log(error)
                return '';
            }
            
            
        },
        getApproveType(value){
            //console.log('Get Approve Type :' + value);
            var index = this.arrApproveType.findIndex(x => x.value == value);
            return this.arrApproveType[index].text;
        },

        async printReport(print_page){
            let code = await this.refund ? this.refund.refund.approve_code : ''
            
            //console.log('print report');
            if (print_page == "timeline"){
                var node = await document.getElementById(print_page);
                domtoimage.toJpeg(node, { quality: 1})
                .then(function (dataUrl) {
                    var link = document.createElement('a');
                    link.download = code +'_timeline.jpeg';
                    link.href = dataUrl;
                    link.click();
                });
            }else{
                await this.printElement(document.getElementById(print_page));
            }
            //


            // var printSection = document.getElementById("printSection");
            // if (!printSection) {
            //     printSection = document.createElement("div");
            //     printSection.id = "printSection";
            //     document.body.appendChild(printSection);
            // }
            // printSection.innerHTML = "";
            // printSection.appendChild(domClone);
            // window.print();
        },
        async printElement(elem) {

            var domClone = await elem.cloneNode(true);

            var printSection = await document.getElementById("printSection");

            if (!printSection) {
                printSection = await document.createElement("div");
                printSection.id = await "printSection";
                await document.body.appendChild(printSection);
            }
            printSection.innerHTML = await "";
            await printSection.appendChild(domClone);
            await window.print();
        },
        getDetail(id){
            return this.refund.detail[this.refund.detail.findIndex(i => i.consider_id == id)];
        },
        getOverdueDays(){
            var overDueDays = 0;
            for (let i = 0; i < this.delivers.length; i++) {
                if (this.delivers[i]['penalty_accept'] && this.delivers[i]['penalty_accept'] > 0){
                    overDueDays = overDueDays + this.delivers[i]['overdue_days'];
                }                
            }
            return overDueDays;
        },

        getPenaltyAll(){
            var penalty = 0;

            for (let i = 0; i < this.delivers.length; i++) {
                penalty = penalty + (this.delivers[i]['penalty'] ? this.delivers[i]['penalty'] : 0);
                
            }
            
            return penalty.toFixed(2);
        },
        getPenaltyAcceptAll(){
            var penalty_accept = 0;
            for (let i = 0; i < this.delivers.length; i++) {
                penalty_accept = penalty_accept + (this.delivers[i]['penalty_accept'] ? this.delivers[i]['penalty_accept'] : 0 );
            }            
            return penalty_accept.toFixed(2);
        },
        getDepositAll(){
            let sum = 0;
            for (let i=0; i < this.deposits.length; i++){
                sum = sum + this.deposits[i]['amount_in_contract'];
            }
            return sum;
        },
        getDepositYear(){
            var arrYear = [];
            var tmp = [];
            var strYear = ''
            for (let i = 0; i < this.deposits.length; i++){
                tmp = this.deposits[i]['deposit_date'].split('-');
                if (parseInt(tmp[1]) > 9){
                    tmp[0] = String(parseInt(tmp[0])+1);
                }
                if (arrYear.indexOf(tmp[0]) < 0){
                    arrYear.push(tmp[0]);
                }

            }
            //console.log(arrYear);
            arrYear.sort();
            for (let i = 0; i < arrYear.length; i++){
                strYear = strYear + (parseInt(arrYear[i]) + 543);
                if (i < arrYear.length-1){
                    strYear = strYear + ', '
                }
            }
            return strYear;

        },

        createTimeLine(item){
            
            this.$nextTick(()=>{
                this.time_line.push(item)
            })

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
    font-weight: normal!important;
    font-size: 9pt!important;

}
.sign{
    padding-top: 5px!important;
}
p.head{
    font-weight: normal;
    width: 100%;

    font-size: 8pt!important;

}
.head-sign{
    font-weight: normal;
    width: 100%;
    font-size: 8pt!important;
    padding-top: 10pt!important;

}
.head{
    font-weight: normal;
    width: 100%;
    margin-bottom: 3px!important;
    font-size: 8pt!important;

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
p.head.sub2{
    padding-left: 35px;
    padding-bottom: 0px;
}
.sub_order{
    margin-left: 5px;
}
th{
    padding: 5px;
    font-size:10pt!important;
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
    border-bottom: 1px dashed #000;
    width: 100%;
    font-weight: normal!important;
    padding: 0 3px 0 7px!important;
    text-align: left;
    font-size: 8pt!important;
    vertical-align: bottom;


}
.show-list{
    border-bottom: 1px solid #000;
    width: 100%;
    font-weight: normal!important;
    padding: 0 10px 0 10px!important;
    text-align: left;
    font-size: 1rem!important;
    vertical-align: bottom;

}

table.report tr td,table.report th{
    border: 1px #000000 solid;
    vertical-align: top;
}

table.report>tbody>tr:first-child>td:last-child{
    padding-top: 0px!important;
    padding-bottom: 0px!important;
}

.table_rule, .table_sub_rule{
    border: 0px!important;

}
.table_rule > tr:first-child > td{
    border-top: 0px!important
}
.table_rule > tr > td:last-child,.table_sub_rule > tr > td:last-child{
    border-right: 0px!important;
    border-left: 0px!important;
}
.table_rule > tr > td:first-child,.table_sub_rule > tr > td:first-child{
    border-left: 0px!important;
}
.table_rule > tr > td:first-child{
    border-right: 0px!important;
}
.table_sub_rule > tr:last-child > td{
    border-bottom: 0px!important;
}


.has_sub_rule{
    column-span: 2;
    padding: 0px!important;
}
.non_sub_rule{
    width: 378px;
}
.space{
    height: 17px;
    margin-bottom: 3px;
}
.sub_rule_tr> td{
    border: none!important;
    margin-bottom: 3px!important;
}
.sub_rule_tr:nth-child(even) > td{
    background-color: rgb(245, 245, 245)!important;
}
.office{
    border: 0px!important;
}
</style>
