<template>
    <div class="animated fadeIn">
            <my-alert :AlertType="alert"></my-alert>
            <b-card class="bg-dark">
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

                        <b-row align-h="center">
                            <b-col sm="3">
                                <b-form-group>
                                    <label for="deposit_no">เลขที่เอกสาร : (เบิกหักผลักส่ง/นำส่ง)</label>
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
                                    <label for="deposit_date">วันที่ผ่านรายการ :</label>
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

            </b-form>
        </b-card>
            <!-- ======================= Deposit Penalty List ========================================-->

        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col" style="width: 15%">เลขที่เอกสาร</th>
                    <th scope="col" style="width: 20%">วันที่</th>
                    <th scope="col" style="width: 10%">จำนวน (บาท)</th>
                    <th scope="col" style="width: 10%">การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item,index) in deposit_list" :key="index">
                    <td>{{item.deposit_no}}</td>
                    <td>{{getThaiDate(item.deposit_date)}}</td>
                    <td>{{item.amount | numeral('0,0.00') }}</td>
                    <td>
                        <b-button :id="'btnEdit'+item.id" class="tools" size="sm" variant="outline-primary" @click="toEdit(item)"><i class="fas fa-edit"></i></b-button>
                        <b-tooltip :target="'btnEdit'+item.id" triggers="hover" placement="left">
                            แก้ไขข้อมูล
                        </b-tooltip>

                        <b-button :id="'btnDel'+item.id" class="tools" size="sm" variant="outline-danger" @click="toDel(item.id)"><i class="fas fa-trash"></i></b-button>
                        <b-tooltip :target="'btnDel'+item.id" triggers="hover" placement="left">
                            ลบข้อมูล
                        </b-tooltip>
                    </td>
                </tr>
            </tbody>
        </table>


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
            this.$emit('refund_update');
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
                    this.clearData();
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
                    this.clearData();
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
                if (isConfirm){
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
                }

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
