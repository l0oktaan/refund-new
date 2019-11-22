<template>
    <div class="animated fadeIn">
            <my-alert :AlertType="alert"></my-alert>
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
                        <!-- <b-button variant="outline-success">
                            <i class="fas fa-save fa-2x"></i>&nbsp;<span>บันทึกข้อมูล</span>
                        </b-button> -->
                    </li>
                </ul>
            </div>
            <b-form @submit="onSubmit">
                <b-card no-body class="bg-default">
                    <b-card-body class="pb-0 list ">
                        <b-row align-h="center">
                            <b-col sm="3">
                                <b-form-group>
                                    <label for="deposit_no">เลขที่เอกสาร :</label>
                                    <b-form-input type="text"
                                        placeholder="เลขที่"
                                        name="deposit_no"
                                        v-model = "deposit.deposit_no"
                                    >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col sm="3">
                                <b-form-group>
                                    <label for="deposit_date">วันที่ :</label>
                                    <my-date-picker ref="deposit_date" :id="11" :showDate="date_deposit" @update="value => deposit.deposit_date = value"></my-date-picker>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3">
                                <b-form-group>
                                    <label for="amount">จำนวน : (บาท)</label>
                                    <cleave placeholder="จำนวนเงิน" name="amount" v-model="deposit.amount" class="form-control" :options="cleave_options.number"></cleave>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col>
                                <div class="text-center" style="margin-bottom:5px;">
                                    <b-button type="submit" variant="primary">บันทึกข้อมูล</b-button>
                                     <b-button type="reset" variant="danger" @click="clearData" >ยกเลิก</b-button>
                                </div>
                            </b-col>
                        </b-row>
                    </b-card-body>
                </b-card>
            </b-form>
            <!-- ======================= Deposit Penalty List ========================================-->

            <b-card no-body class="header_list">
                <b-card-body class="pb-0 list">

                    <b-row align-h="center">
                        <b-col cols="3">
                            <p class="text-center fieldName">เลขที่เอกสาร</p>
                        </b-col>
                        <b-col cols="3">
                            <p class="text-center fieldName">วันที่</p>
                        </b-col>


                        <b-col  cols="3">
                            <p class="text-center fieldName">จำนวน (บาท)</p>
                        </b-col>
                        <b-col cols="1">
                            <p class="text-right fieldName">จัดการ </p>
                        </b-col>
                    </b-row>

                </b-card-body>
            </b-card>
            <b-card no-body :class="(item.id === deposit.id) && (deposit) ? 'item_select' : 'edit_list'" v-for="(item,index) in deposit_list" :key="index" class="animated fadeIn">
                <b-card-body class="pb-0 list ">
                    <b-row align-h="center">
                        <b-col cols="3" align="center">
                            {{item.deposit_no}}
                        </b-col>
                        <b-col cols="3" align="left">
                            {{getThaiDate(item.deposit_date)}}
                        </b-col>

                        <b-col cols="3"  align="right">
                            {{item.amount | numeral('0,0.00') }}
                        </b-col>
                        <b-col align="right"  cols="1">

                                <b-dropdown variant="transparent p-0">
                                    <template slot="button-content">
                                        <i class="icon-settings" style="color: #000;"></i>
                                    </template>
                                    <b-dropdown-item @click="toEdit(item)"><i class="fas fa-edit"></i>&nbsp;แก้ไขข้อมูล</b-dropdown-item>
                                    <b-dropdown-item @click="toDel(item.id)"><i class="fas fa-trash"></i>&nbsp;ลบข้อมูล</b-dropdown-item>
                                </b-dropdown>

                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>
        </b-card>
    </div>
</template>
<script>

export default {
    props: ['refund_id'],
    data(){
        return {
            r_id: this.$route.params.id,
            office_id: 2,
            deposit: {},
            deposit_list: [],
            date_deposit: '',
            alert: '',
            state: 'new',
            cleave_options:{
                number: {
                    prefix: '',
                    numeral: true,
                    numeralPositiveOnly: true,
                    noImmediatePrefix: true,
                    rawValueTrimPrefix: true,
                    numeralIntegerScale: 15,
                    numeralDecimalScale: 2,
                },
            },
        }
    },
    mounted(){
        this.fetchData();
    },
    methods: {
        fetchData(){
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/deposit_penalties`;
            this.deposit_list = [];
            axios
            .get(`${path}`)
            .then(response=>{
                this.deposit_list = response.data.data;
            })
            .catch(error=>{
                this.alert = 'error';
            })
        },
        onSubmit(e){
            e.preventDefault();
            ///api/offices/2/refunds/14/deposit_penalties
            var path = `/api/offices/${this.office_id}/refunds/${this.r_id}/deposit_penalties`;

            if (this.state == 'new'){
                console.log('Path : ' + path + ' date : ' + this.deposit.deposit_date);
                axios.post(`${path}`,{
                    deposit_no: this.deposit.deposit_no,
                    deposit_date: this.deposit.deposit_date,
                    amount: this.deposit.amount
                })
                .then(response=>{

                   this.alert = 'success';
                    this.toEdit(response.data.data);

                    this.fetchData();
                })
                .catch(error=>{
                    this.alert = 'error';
                })
            }else if (this.state == 'update'){
                path = `${path}/${this.deposit.id}`;
                axios
                .put(`${path}`,{
                    deposit_no : this.deposit.deposit_no,
                    deposit_date : this.deposit.deposit_date,
                    amount : this.deposit.amount
                })
                .then(response=>{

                    this.alert = 'success';
                    this.toEdit(response.data.data);

                    this.fetchData();
                })
                .catch(error=>{
                    this.alert = 'error';
                })

            }
        },
         getThaiDate(item){
            var d = new Date(item);
            return d.toLocaleDateString('th-TH', { day: 'numeric', month: 'long', year: 'numeric' });
            //return moment(String(value)).format('LL')
        },
        toEdit(item){
            this.deposit = _.cloneDeep(item);
            if (item){
                this.state = 'update';
                this.date_deposit = item.deposit_date;
            }
        },
        clearData(){
            this.deposit = {};
            this.state = 'new';
            this.date_deposit = '';
        },
        toDel(id){
            this.$swal({
                title: "กรุณายืนยัน",
                text: `คุณต้องการลบข้อมูล ใช่หรือไม่`,
                icon: "warning",
                closeOnClickOutside: false,
                buttons: [
                    'ยกเลิก',
                    'ยืนยัน'
                ],
            })
            .then(isConfirm =>{
                var path = `/api/offices/${this.office_id}/refunds/${this.r_id}/deposit_penalties/${id}`;
                axios
                .delete(`${path}`)
                .then(response=>{
                    this.alert = "success";
                    this.clearData();
                    this.fetchData();

                })
                .catch(error=>{
                    this.alert = "error";
                })
            })
        },
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
.edit_list{
    background-color: rgb(176, 243, 248);
    margin-bottom: 5px!important;
}
.item_select{
    background-color: rgb(247, 230, 158);
    margin-bottom: 5px!important;
}
.fieldName{
    color: rgb(4, 30, 53);
    font-weight: bold;
    text-align: center;
    margin: 0px!important;
}
.unit{
    color: rgb(154, 156, 158);
    font-weight: bold;
    padding-left: 5px;
}
.item_list{
    margin: 0px!important;
}
.header_list{
    margin-bottom: 5px;
    background-color: #f0f3f5;
    border: 1px solid #c8ced3;

}
</style>
