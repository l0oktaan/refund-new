<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
        <b-card>
            <div slot="header" class="navbar">
                <ul class="nav navbar-nav d-md-down-none">
                    <li class="nav-item px-3">
                        <i class='fa fa-align-justify'></i>
                            สรุปข้อมูล
                    </li>
                </ul>

            </div>
            <b-form @submit="onSubmit">


                        <b-row>
                            <b-col sm="12">
                                <b-form-group
                                    label-cols-sm="6"
                                    label="วันที่รับเรื่อง หนังสือขอความช่วยเหลือ :"
                                    label-align-sm="right"
                                    label-for="receive_date"                                >
                                    <my-date-picker ref="receive_date" :id="11" :showDate="date_receive" @update="value => approve.receive_date = value"></my-date-picker>
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
                                       <b-form-input id="approve_refund_days" v-model="approve.refund_days"></b-form-input>
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
                                    label-for="refund_amount"
                                >
                                    <b-input-group append="บาท">
                                       <cleave placeholder="จำนวนเงิน" name="amount" v-model="approve.refund_amount" class="form-control" :options="cleave_options.number"></cleave>
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
                                    label-for="approve_amount"
                                >
                                    <b-input-group append="บาท">
                                       <cleave placeholder="จำนวนเงิน" name="approve_amount" v-model="approve.approve_amount" class="form-control" :options="cleave_options.number"></cleave>
                                    </b-input-group>

                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col>
                                <div class="text-center" style="margin-bottom:5px;">
                                    <b-button type="submit" variant="primary">บันทึกข้อมูล</b-button>
                                </div>
                            </b-col>
                        </b-row>

            </b-form>

        </b-card>
        <refund-report></refund-report>
    </div>
</template>
<script>
export default {
    props: ['refund_id'],
    data(){
        return {
            r_id: this.$route.params.id,
            office_id: 2,
            approve: {},
            date_receive: '',
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
            var path = `/api/offices/${this.office_id}/refunds/${this.r_id}/approve_refunds`;
            axios
            .get(`${path}`)
            .then(response=>{
                if (response.data.data.length > 0){
                    this.toEdit(response.data.data[0]);
                }

            })
            this.$emit('refund_update');
        },
        toEdit(item){
            this.approve = _.cloneDeep(item);
            if (item){
                this.state = 'update';
                this.date_receive = item.receive_date;
            }
            this.$forceUpdate();
        },
         onSubmit(e){
            e.preventDefault();
            ///api/offices/2/refunds/14/deposit_penalties
            var path = `/api/offices/${this.office_id}/refunds/${this.r_id}/approve_refunds`;

            if (this.state == 'new'){

                axios.post(`${path}`,{
                    receive_date: this.approve.receive_date,
                    refund_days: this.approve.refund_days,
                    refund_amount: this.approve.refund_amount,
                    approve_amount: this.approve.approve_amount
                })
                .then(response=>{

                   this.alert = 'success';
                   this.toEdit(response.data.data);

                })
                .catch(error=>{
                    this.alert = 'error';
                })
            }else if (this.state == 'update'){
                path = `${path}/${this.approve.id}`;
                axios
                .put(`${path}`,{
                    receive_date: this.approve.receive_date,
                    refund_days: this.approve.refund_days,
                    refund_amount: this.approve.refund_amount,
                    approve_amount: this.approve.approve_amount
                })
                .then(response=>{
                    this.alert = 'success';
                    this.toEdit(response.data.data);
                })
                .catch(error=>{
                    this.alert = 'error';
                })

            }
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
input{
    max-width: 150px!important;
}
</style>
