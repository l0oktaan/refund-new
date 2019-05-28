<template>
    <div class="animated fadeIn">

        <b-card no-body class="sub_rule" :class="getClass(refund.status)">
            <b-card-body class="pb-0 sub_rule">
                <b-dropdown class="float-right" style="color: #000!important;" variant="transparent p-0" right>
                <template slot="button-content">
                    <i class="icon-settings sub_rule"></i>
                </template>
                    <b-dropdown-item><i class="fas fa-edit"></i>&nbsp;แก้ไขหลักเกณฑ์ย่อย</b-dropdown-item>
                    <b-dropdown-item><i class="fas fa-link"></i>&nbsp;ข้อมูลเงื่อนไข</b-dropdown-item>
                    <b-dropdown-item><i class="fas fa-trash"></i>&nbsp;ลบหลักเกณฑ์ย่อย</b-dropdown-item>
                </b-dropdown>
                <b-row>
                    <b-col sm="2">
                        <div class="textFiled">สร้างรายการเมื่อ :</div>
                        <div>{{refund.create_date}}</div>
                    </b-col>
                    <b-col sm="2">
                        <div class="textFiled">สัญญาเลขที่ :</div>
                        <div v-if="refund.contracts.length > 0">{{refund.contracts[0].contract_no}}</div>
                    </b-col>
                    <b-col sm="4">
                        <div class="textFiled">คู่สัญญา :</div>
                        <div v-if="refund.contracts.length > 0">{{refund.contracts[0].contract_party}}</div>
                    </b-col>
                    <b-col sm="2">
                        <div class="textFiled">สถานะรายการ :</div>
                        <div>{{refund.status}}</div>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
    </div>
</template>
<script>
export default {
    props: ['state','refund'],
    data(){
        return {
            iRefund: [],
            contracts: {},
            office_id: 1,
        }
    },
    watch: {
        refund(){
            this.iRefund = this.refund;
            //this.getContract();
            this.$forceUpdate();
        }
    },
    methods: {
        getClass(status){
            return `status${status}`;
        },
        getContract(){
            var contract = [];
            var path = '';
            path = `/api/offices/${this.office_id}/refunds/1/contract`
            console.log('get contract ' + path);
            axios.get(path)
            .then(response=>{
                contract = response.data.data;
                this.contracts = contract[0];
                this.$forceUpdate();
                //Object.assign(refunds[i],{contract: contracts[0]});
            })
        }
    }
}
</script>
<style scoped>

.card{
    margin-bottom: 5px!important;
}
.card-body{
    padding-top: 10px!important;
}
.textFiled{
    font-weight: bold;
    color :rgb(38, 41, 122);
}
.status1{
    background-color: rgb(247, 230, 158);
}
.status2{
    background-color: rgb(170, 224, 149);
}
.dropdown-item i{
    color: #000!important;
}
</style>

