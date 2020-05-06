<template>
    <div>
        <b-row align-h="center">
            <b-col cols="12" class="form_name">
                <h4 class="topic mt-4">รายการเอกสารที่ต้องจัดเตรียม</h4>
            </b-col>
        </b-row>
        <b-row align-h="center">
            <b-col cols="10">
                <table class="table table-bordered" style="width: 100%">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 40%">ประเภทเอกสาร</th>
                            <th scope="col" style="width: 60%">รายการเอกสาร</th>
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
                                <p v-for="(item,index) in contract_time_edit" :key="index" class="head"><i class="far fa-square fa-lg"></i> หนังสืออนุมัติวันที่ <span class="show-list">{{getThaiDate(item.approve_date)}}</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td><p class="head">4. ข้อมูลการส่งมอบงาน</p></td>
                            <td>

                                    <p v-for="(item,index) in delivery" :key="index" class="head"><i class="far fa-square fa-lg"></i> หนังสือส่งมอบงาน <span class="show-list">{{item.delivery}}</span></p>

                            </td>
                        </tr>
                        <tr>
                            <td><p class="head">5. ข้อมูลการนำส่งเงินค่าปรับ</p></td>
                            <td>
                                <p v-for="(item,index) in deposit_penalty" :key="index" class="head"><i class="far fa-square fa-lg"></i> เอกสารเบิกหักผลักส่ง/นำส่ง เลขที่ <span class="show-list">{{item.deposit_no}}</span><br> วันที่ผ่านรายการ <span class="show-list">{{getThaiDate(item.deposit_date)}}</span></p>
                            </td>
                        </tr>
                    </tbody>
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

        }
    },
    methods: {
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

    margin-top: 10px!important;
}
table>tr>td{
    vertical-align: top!important;
    padding: 1px!important;
    border: 2px #000 solid!important;
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
