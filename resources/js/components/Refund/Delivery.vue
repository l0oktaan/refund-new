<template>
    <div class="animated fadeIn">
            <b-card>
            <div slot="header" class="navbar">
                <ul class="nav navbar-nav d-md-down-none">
                    <li class="nav-item px-3">
                        <i class='fa fa-align-justify'></i>
                            ข้อมูลการส่งมอบงาน <span class="description">(เฉพาะงวด / ครั้ง ที่มีค่าปรับ)</span>
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
            <b-form>
                <b-card no-body class="bg-default">
                    <b-card-body class="pb-0 list ">
                        <b-row>
                            <b-col sm="3">
                                <b-form-group>
                                    <label for="deliver_order">ครั้งที่ :</label>
                                    <b-form-input type="text"
                                        placeholder="ครั้งที่"
                                        name="deliver_order"
                                    >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col sm="12">
                                <b-form-group>
                                    <label for="detail">รายละเอียดส่งมอบงาน :</label>
                                    <b-form-input type="text"
                                        placeholder="รายละเอียดส่งมอบงาน"
                                        name="detail"
                                    >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3">
                                <b-form-group>
                                    <label for="time_edit_date">งวดที่ :</label>
                                    <b-form-input type="text"
                                        placeholder="งวดที่ส่งมอบงาน"
                                        name="time_edit_date"
                                    >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3">
                                <b-form-group>
                                    <label for="overdue_days">ครั้งที่ :</label>
                                    <b-form-input type="text"
                                        placeholder="ครั้งที่ส่งมอบงาน"
                                        name="overdue_days"
                                    >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col sm="4">
                                <b-form-group>
                                    <label for="time_edit_date">วันที่ :</label>
                                    <b-form-input type="text"
                                        placeholder="วันที่ส่งมอบงาน"
                                        name="time_edit_date"
                                    >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group>
                                    <label for="overdue_days">เกินกำหนด :</label>
                                    <b-form-input type="text"
                                        placeholder="จำนวนวัน"
                                        name="overdue_days"
                                    >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group>
                                    <label for="penalty">ถูกปรับเป็นเงิน :</label>
                                    <b-form-input type="text"
                                        placeholder="จำนวนเงิน"
                                        name="penalty"
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
                            วันที่ :
                        </b-col>
                        <b-col sm="3">
                            เกินกำหนด :
                        </b-col>
                        <b-col sm="3">
                            ถูกปรับเป็นเงิน :
                        </b-col>
                        <b-col sm="12" md="12" lg="12">
                            การส่งมอบงาน :
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
                            วันที่ :
                        </b-col>
                        <b-col sm="3">
                            เกินกำหนด :
                        </b-col>
                        <b-col sm="3">
                            ถูกปรับเป็นเงิน :
                        </b-col>
                        <b-col sm="12" md="12" lg="12">
                            การส่งมอบงาน :
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
    background-color: rgb(176, 243, 248);
    margin-bottom: 5px!important;
}
.dropdown-item{
    color: black!important;
}
</style>
