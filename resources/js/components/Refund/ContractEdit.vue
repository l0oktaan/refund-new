<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
         <b-form>
            <b-card no-body class="bg-secondary">
                <b-card-body class="pb-0 list ">
                   <b-row>
                       <b-col><h5>การแก้ไขสัญญา</h5></b-col>
                   </b-row>
                    <b-row>
                        <b-col sm="2">
                            <b-form-group>
                                <label for="contract_edit_order">ครั้งที่ :</label>
                                <b-form-input type="text"
                                    placeholder="ครั้งที่"
                                    name="contract_edit_order"
                                >
                                </b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col sm="5">
                            <b-form-group>
                                <label for="budget_new">วงเงินใหม่ :</label>
                                <b-form-input type="text"
                                    placeholder="วงเงินใหม่"
                                    name="budget_new"
                                >
                                </b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col sm="5">
                            <b-form-group>
                                <label for="penalty_new">ค่าปรับใหม่ :</label>
                                <b-form-input type="text"
                                    placeholder="ค่าปรับใหม่"
                                    name="penalty_new"
                                >
                                </b-form-input>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col>
                            <div class="text-center" style="margin-bottom:5px;">
                                <b-button type="submit" variant="primary">บันทึกเงื่อนไข</b-button>
                                <b-button type="reset" variant="danger" >ยกเลิก</b-button>
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
                    <b-col sm="2">
                        ครั้งที่ :
                    </b-col>
                    <b-col sm="5">
                        วงเงินใหม่ :
                    </b-col>
                    <b-col sm="5">
                        ค่าปรับใหม่ :
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>



    </div>
</template>
<script>

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
</style>
