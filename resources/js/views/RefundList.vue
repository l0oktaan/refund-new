<template>
    <div class="animated fadeIn">
        <b-row>
            <b-col>
                <div class="topHead float-right">
                    <b-button variant="outline-success" @click="createRefund">
                        <i class="fas fa-plus-circle fa-2x"></i>&nbsp;<span>สร้างรายการถอนคืนฯ</span>
                    </b-button>
                    <b-button variant="outline-primary">
                        <i class="fas fa-search fa-2x"></i>&nbsp;<span>ค้นหา</span>
                    </b-button>
                </div>
                <h4>ข้อมูลการถอนคืนเงินรายได้</h4>
            </b-col>
        </b-row>
        <refund-cover
            :state="state" :refund="refund"
             v-for="(refund,index) in refunds" :key="index"
            @fetchRefund="fetchData"
        ></refund-cover>
    </div>
</template>
<script>
export default {
    data(){
        return {
            refunds: [],
            office_id: 2,
            state: ''
        }
    },
    mounted(){
        this.fetchData();

    },
    methods: {
        fetchData(){
            var user = this.$store.state.user;
            console.log('user :' + user);
            if (user == 'admin'){
                var path = `/api/offices/${this.office_id}/refunds?status=8`;
            }else{
                var path = `/api/offices/${this.office_id}/refunds?fields=contracts`;
            }
            
            var refunds = [];
            var contracts = [];
            console.log('path :' + path);
            axios.get(path)
            .then(response=>{
                refunds = response.data;
                this.refunds = refunds;
                this.state = 'show';
                this.$forceUpdate();
            })
        },
        createRefund(){
            this.$router.push({path: 'form'});
        }

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
