<template>
    <div class="animated fadeIn">
            <b-card>
            <div slot="header" class="navbar">
                <ul class="nav navbar-nav d-md-down-none">
                    <li class="nav-item px-3">
                        <i class='fa fa-align-justify'></i>
                            สรุปข้อมูล
                    </li>
                </ul>

            </div>
            <b-form>


                        <b-row>
                            <b-col sm="12">
                                <b-form-group
                                    label-cols-sm="6"
                                    label="วันที่รับเรื่อง หนังสือขอความช่วยเหลือ :"
                                    label-align-sm="right"
                                    label-for="receive_refund_date"
                                >
                                    <b-form-input id="receive_refund_date"></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col sm="12">
                                <b-form-group
                                    label-cols-sm="6"
                                    label="หน่วยงานอนุมัติให้งด ลดค่าปรับ หรือขยายเวลา หรือคืนเงินค่าปรับ :"
                                    label-align-sm="right"
                                    label-for="approve_refund_days"
                                >
                                    <b-input-group append="วัน">
                                       <b-form-input id="approve_refund_days"></b-form-input>
                                    </b-input-group>

                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col sm="12">
                                <b-form-group
                                    label-cols-sm="6"
                                    label="เป็นเงิน :"
                                    label-align-sm="right"
                                    label-for="approve_refund_amount"
                                >
                                    <b-input-group append="บาท">
                                       <b-form-input id="approve_refund_amount"></b-form-input>
                                    </b-input-group>

                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col sm="12">
                                <b-form-group
                                    label-cols-sm="6"
                                    label="หน่วยงานอนุมัติถอนคืน จำนวน :"
                                    label-align-sm="right"
                                    label-for="amount"
                                >
                                    <b-input-group append="บาท">
                                       <b-form-input id="approve_refund_mount"></b-form-input>
                                    </b-input-group>

                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col>
                                <div class="text-center" style="margin-bottom:5px;">
                                    <b-button variant="primary">บันทึกข้อมูล</b-button>
                                </div>
                            </b-col>
                        </b-row>

            </b-form>

        </b-card>
    </div>
</template>
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
input{
    max-width: 150px!important;
}
</style>
