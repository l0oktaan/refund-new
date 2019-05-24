<template>
    <div class="animated fadeIn">
            <b-card>
            <div slot="header" class="navbar">
                <ul class="nav navbar-nav d-md-down-none">
                    <li class="nav-item px-3">
                        <i class='fa fa-align-justify'></i>
                            ข้อมูลการนำส่ง / เบิกหักผลักส่งค่าปรับเป็นรายได้แผ่นดิน
                    </li>
                </ul>
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item px-3">
                        <b-button variant="outline-success">
                            <i class="fas fa-save fa-2x"></i>&nbsp;<span>บันทึกข้อมูล</span>
                        </b-button>
                    </li>
                </ul>
            </div>
            <b-form>
                <b-card no-body class="bg-default">
                    <b-card-body class="pb-0 list ">
                        <b-row>
                            <b-col sm="3">
                                <b-form-group>
                                    <label for="deposit_order">ครั้งที่ :</label>
                                    <b-form-input type="text"
                                        placeholder="ครั้งที่"
                                        name="deposit_order"
                                    >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3">
                                <b-form-group>
                                    <label for="deposit_no">เลขที่ :</label>
                                    <b-form-input type="text"
                                        placeholder="เลขทีั่"
                                        name="deposit_no"
                                    >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col sm="3">
                                <b-form-group>
                                    <label for="deposit_date">วันที่ :</label>
                                    <b-form-input type="text"
                                        placeholder="วันที่"
                                        name="deposit_date"
                                    >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3">
                                <b-form-group>
                                    <label for="amount">จำนวน :</label>
                                    <b-form-input type="text"
                                        placeholder="จำนวนเงิน"
                                        name="amount"
                                    >
                                    </b-form-input>
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
                    </b-card-body>
                </b-card>
            </b-form>
            <!-- ======================= Contract Edit List ========================================-->
            <b-card no-body class="bg-default edit_list">
                <b-card-body class="pb-0 list ">
                    <b-dropdown class="float-right" variant="transparent p-0" right>
                        <template slot="button-content">
                            <i class="icon-settings" style="color: #000;"></i>
                        </template>
                        <b-dropdown-item><i class="fas fa-edit"></i>&nbsp;แก้ไขข้อมูล</b-dropdown-item>
                        <b-dropdown-item><i class="fas fa-trash"></i>&nbsp;ลบข้อมูล</b-dropdown-item>
                    </b-dropdown>
                    <b-row>
                        <b-col sm="3">
                            ครั้งที่ :
                        </b-col>
                        <b-col sm="3">
                            เลขที่ :
                        </b-col>
                        <b-col sm="3">
                            วันที่ :
                        </b-col>
                        <b-col sm="3">
                            จำนวน :
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>
            <b-card no-body class="bg-default edit_list">
                <b-card-body class="pb-0 list ">
                    <b-dropdown class="float-right" variant="transparent p-0" right>
                        <template slot="button-content">
                            <i class="icon-settings" style="color: #000;"></i>
                        </template>
                        <b-dropdown-item><i class="fas fa-edit"></i>&nbsp;แก้ไขข้อมูล</b-dropdown-item>
                        <b-dropdown-item><i class="fas fa-trash"></i>&nbsp;ลบข้อมูล</b-dropdown-item>
                    </b-dropdown>
                    <b-row>
                        <b-col sm="3">
                            ครั้งที่ :
                        </b-col>
                        <b-col sm="3">
                            เลขที่ :
                        </b-col>
                        <b-col sm="3">
                            วันที่ :
                        </b-col>
                        <b-col sm="3">
                            จำนวน :
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>
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
    background-color: rgb(248, 219, 176);
    margin-bottom: 5px!important;
}
.dropdown-item{
    color: black!important;
}
</style>
