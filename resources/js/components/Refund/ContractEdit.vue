<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
         <b-form  @submit="SubmitContractEdit">
            <b-card no-body class="bg-secondary">
                <b-card-body class="pb-0 list ">
                   <b-row>
                       <b-col><h5>บันทึกการแก้ไขสัญญา</h5></b-col>
                   </b-row>
                    <b-row>
                        <b-col sm="4">
                            <!-- <b-form-group>
                                <label for="contract_edit_order">หนังสือลงวันที่ :</label>
                                <b-form-input type="text"
                                    placeholder="ครั้งที่"
                                    name="contract_edit_order"
                                >
                                </b-form-input>
                            </b-form-group> -->
                            <b-form-group>
                                <label for="edit_date">หนังสือลงวันที่ :</label>
                                <my-date-picker ref="edit_date" :id="11" :showDate="date_show" @update="value => edit_date = value"></my-date-picker>
                            </b-form-group>
                        </b-col>
                        <b-col sm="4">
                            <b-form-group>
                                <label for="budget_new">แก้ไขวงเงินค่าจ้างเป็น :</label>
                                <b-form-input type="text"
                                    placeholder="วงเงินใหม่"
                                    name="budget_new"
                                     v-model="contract_edit.budget_new"
                                >
                                </b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col sm="4">
                            <b-form-group>
                                <label for="penalty_new">ค่าปรับเป็น :</label>
                                <b-form-input type="text"
                                    placeholder="ค่าปรับใหม่"
                                    name="penalty_new"
                                    v-model="contract_edit.penalty_new"
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

        <b-card no-body class="bg-default edit_list" v-for="(contract_edit,index) in contract_edit_list" :key="index">
            <b-card-body class="pb-0 list ">
                <b-dropdown class="float-right" variant="transparent p-0" right>
                    <template slot="button-content">
                        <i class="icon-settings" style="color: #000;"></i>
                    </template>
                    <b-dropdown-item @click="toEdit(contract_edit)"><i class="fas fa-edit"></i>&nbsp;แก้ไขข้อมูล</b-dropdown-item>
                    <b-dropdown-item><i class="fas fa-trash"></i>&nbsp;ลบข้อมูล</b-dropdown-item>
                </b-dropdown>
                <b-row>
                    <b-col sm="4">
                        หนังสือลงวันที่ : {{contract_edit.contract_edit_date}}
                    </b-col>
                    <b-col sm="4">
                        วงเงินใหม่ : {{contract_edit.budget_new}} บาท
                    </b-col>
                    <b-col sm="4">
                        ค่าปรับใหม่ : {{contract_edit.penalty_new}} บาท
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
    </div>
</template>
<script>
export default{

    data(){
        return {
            refund_id: this.$route.params.id,
            office_id: 2,
            date_show: '',
            edit_date: '',
            contract_edit_list: [],
            alert: '',
            contract_edit: {},
            state : 'new'
        }
    },
    mounted(){
        this.fetchContractEdit();
    },
    watch: {
        refund_id(){

        }
    },
    methods: {
        SubmitContractEdit(e){
            e.preventDefault();
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/contract_budget_edits`;
            console.log('edit path : ' + path);
            if (this.state == 'new'){
                axios.post(`${path}`,{
                    budget_new: this.contract_edit.budget_new,
                    penalty_new: this.contract_edit.penalty_new,
                    contract_edit_date: this.edit_date
                })
                .then(response=>{

                    this.contract_edit = response.data.data;
                    this.toEdit(this.contract_edit);
                    this.alert = "success";
                    this.fetchContractEdit();

                })
                .catch(error=>{
                    this.alert = "error";
                })
            }else if (this.state == 'update'){
                axios.put(`${path}/${this.contract_edit.id}`,{
                    budget_new: this.contract_edit.budget_new,
                    penalty_new: this.contract_edit.penalty_new,
                    contract_edit_date: this.edit_date
                })
                .then(response=>{
                    this.contract_edit = response.data.data;
                    this.toEdit(this.contract_edit);
                    this.alert = "success";
                    this.fetchContractEdit();
                })
                .catch(error=>{
                    this.alert = "error";
                })
            }
        },
        fetchContractEdit(){
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/contract_budget_edits`;
            axios.get(`${path}`)
            .then(response=>{
                this.contract_edit_list = response.data.data;
                this.$forceUpdate();
            })
            .catch(error=>{
                console.log('edit contract error :' + error);
            })
        },
        toEdit(contract_edit){
            console.log('edit edit');
            this.contract_edit = contract_edit;
            this.date_show = contract_edit.contract_edit_date;
            this.state = 'update';
            this.$forceUpdate();
        },
        clearData(){
            this.contract_edit = {};
            this.date_show = '';
            this.state = 'new';
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
