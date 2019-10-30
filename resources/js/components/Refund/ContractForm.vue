<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
        <b-form @submit="onContractSubmit">
            <b-row>
                <b-col sm="12">
                    <b-form-group>
                        <label for="contract_party">ชื่อคู่สัญญา :</label>
                        <b-form-input type="text"
                            placeholder="ชื่อคู่สัญญา"
                            name="contract_party"
                            v-model="contract_party"
                        >
                        </b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col sm="6">
                    <b-form-group>
                        <label for="contract_no">สัญญาเลขที่ :</label>
                        <b-form-input type="text"
                            placeholder="สัญญาเลขที่"
                            name="contract_no"
                            v-model="contract_no"
                        >
                        </b-form-input>
                    </b-form-group>
                </b-col>
                <b-col sm="6">
                    <b-form-group>
                        <label for="contract_date">สัญญาลงวันที่ :</label>
                        <my-date-picker ref="contract_date" :id="11" :showDate="date_sign" @update="value => contract_date = value"></my-date-picker>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col sm="6">
                    <b-form-group>
                        <label for="budget">วงเงินในสัญญา :</label>
                        <b-form-input type="text"
                            placeholder="วงเงินในสัญญา"
                            name="budget"
                            v-model="budget"
                        >
                        </b-form-input>
                    </b-form-group>
                </b-col>
                <b-col sm="6">
                    <b-form-group>
                        <label for="penalty_per_day">ค่าปรับวันละ :</label>
                        <b-form-input type="text"
                            placeholder="ค่าปรับวันละ"
                            name="penalty_per_day"
                            v-model="penalty_per_day"
                        >
                        </b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col sm="6">
                    <b-form-group>
                        <label for="contract_start">วันที่สัญญาเริ่มต้น :</label>
                        <my-date-picker ref="start" :id="11" :showDate="date_start" @update="value => contract_start = value"></my-date-picker>
                    </b-form-group>
                </b-col>
                <b-col sm="6">
                    <b-form-group>
                        <label for="contract_end">วันที่สัญญาสิ้นสุด :</label>
                        <my-date-picker ref="end" :id="11" :showDate="date_end" @update="value => contract_end = value"></my-date-picker>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col>
                    <div class="text-center" style="margin-bottom:5px;">
                        <b-button type="submit" variant="primary">บันทึกเงื่อนไข</b-button>
                        <b-button type="reset" variant="danger" @click="clearContract">ยกเลิก</b-button>
                    </div>
                </b-col>
            </b-row>
            <b-row>
                <b-col>
                    <b-card>
                        <div slot="header" class="navbar">
                            <ul class="nav navbar-nav d-md-down-none">
                                <li class="nav-item px-3">
                                    <i class='fa fa-align-justify'></i>
                                        ข้อมูลการแก้ไขสัญญา <span class="description">(เฉพาะกรณีเปลี่ยนแปลงวงเงินค่าจ้างและอัตราค่าปรับ)</span>
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
                    </b-card>
                </b-col>
            </b-row>
        </b-form>
    </div>
</template>
<script>
export default {
    props: ['refund_id'],
    data(){
        return {
            office_id: 2,
            r_id: this.$route.params.id,
            contract_id: 0,
            contract_party: '',
            contract_no: '',
            contract_date: '',
            budget: 0,
            penalty_per_day: 0,
            contract_start: '',
            contract_end: '',
            date_sign: '',
            date_start: '',
            date_end: '',
            alert: '',
            contract_status: 'new'
        }
    },
    methods: {
        onContractSubmit(e){
            e.preventDefault();
            var contract = {};
            var path = `/api/offices/${this.office_id}/refunds/${this.r_id}/contract`;
            console.log('contract path : ' + path);
            console.log('contract status : ' + this.contract_status);
            if (this.contract_status == 'new'){

                axios.post(`${path}`,{
                    contract_party: this.contract_party,
                    contract_no:    this.contract_no,
                    contract_date:  this.contract_date,
                    budget:         this.budget,
                    penalty_per_day:this.penalty_per_day,
                    contract_start: this.contract_start,
                    contract_end:   this.contract_end,
                })
                .then(response=>{
                    contract = response.data.data
                    this.contract_id = contract.id;
                    this.contract_party = contract.contract_party;
                    this.contract_no = contract.contract_no;
                    this.contract_date = contract.contract_date;
                    this.budget = contract.budget;
                    this.penalty_per_day = contract.penalty_per_day;
                    this.contract_start = contract.contract_start;
                    this.contract_end = contract.contract_end;
                    this.contract_status = 'update';
                    this.alert = 'success';
                })
                .catch(error=>{
                    this.alert = 'error';
                })
            }

        },
        fetchContract(){
            var contract = {};
            var path = `/api/offices/${office_id}refunds/${refund_id}/contract`;
            axios.get(`${path}`)
            .then(resposne=>{
                contract = response.data.data
                this.contract_id = contract.id;
                this.contract_party = contract.contract_party;
                this.contract_no = contract.contract_no;
                this.contract_date = contract.contract_date;
                this.budget = contract.budget;
                this.penalty_per_day = contract.penalty_per_day;
                this.contract_start = contract.contract_start;
                this.contract_end = contract.contract_end;

            })
        },
        clearContract(){
            this.contract_id = 0;
            this.contract_party = '';
            this.contract_no = '';
            this.contract_date = '';
            this.budget = 0;
            this.penalty_per_day = '';
            this.contract_start = '';
            this.contract_end = '';
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
</style>
