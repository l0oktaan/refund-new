<template>
    <div class="animated fadeIn">
        <b-row>
            <b-col>
                <div class="topHead float-right">
                    <b-button variant="outline-success">
                        <i class="fas fa-plus-circle fa-2x"></i>&nbsp;<span>สร้างรายการถอนคืนฯ</span>
                    </b-button>
                    <b-button variant="outline-primary">
                        <i class="fas fa-search fa-2x"></i>&nbsp;<span>ค้นหา</span>
                    </b-button>
                </div>
                <h4>ข้อมูลการถอนคืนเงินรายได้</h4>
            </b-col>
        </b-row>
        <refund-cover :refund="refund" v-for="(refund,index) in refunds" :key="index"  ></refund-cover>
    </div>
</template>
<script>
export default {
    data(){
        return {
            refunds: [
                {
                    id: 1,
                    refund_date: '2/10/2565',
                    contract_no: '24/2564',
                    contract_party: 'บริษัท ช ทวี จำกัด',
                    status: 1
                },
                {
                    id: 2,
                    refund_date: '10/10/2565',
                    contract_no: '24/2564',
                    contract_party: 'บริษัท มาสเตอร์ เมคเกอ จำกัด',
                    status: 2
                },
                {
                    id: 3,
                    refund_date: '10/10/2565',
                    contract_no: '24/2564',
                    contract_party: 'บริษัท มาสเตอร์ เมคเกอ จำกัด',
                    status: 2
                },
            ],
            office_id: 1,
        }
    },
    mounted(){
        this.fetchData();
    },
    methods: {
        fetchData(){
            var path = `/api/offices/${this.office_id}/refunds`;
            var refunds = [];
            var contracts = [];
            axios.get(path)
            .then(response=>{
                refunds = response.data.data;
                console.log('get refund ' + refunds[0].id);
                if (refunds.length > 0){
                    for (let i = 0 ; i < refunds.length ; i++){
                        path = `/api/offices/${this.office_id}/refunds/${refunds[i].id}/contract`
                        console.log('get contract ' + path);
                        axios.get(path)
                        .then(response=>{
                            contracts = response.data.data;
                            Object.assign(refunds[i],{contract: contracts[0]});
                        })
                    }

                }
                this.refunds = refunds;
                this.$forceUpdate();

            })
        },

    }
}
</script>
<style scoped>
.btnAdd{
    border-radius: 50%;
    width: 45px;
    height: 45px;
    padding: 0px;
    vertical-align: middle;
}
.btn{
    padding-top: 15px!important;
    padding-bottom: 15px!important;
}
i{
    vertical-align: middle!important;
}
.topHead{
    margin-bottom: 10px;
}

</style>
