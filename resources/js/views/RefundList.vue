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
        <b-row>
            <b-col cols="12">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="width: 15%">วันที่สร้าง</th>
                            <th scope="col" style="width: 35%">คู่สัญญา</th>
                            <th scope="col" style="width: 20%">เลขที่สัญญา</th>
                            <th scope="col" style="width: 15%">สถานะ</th>
                            <th scope="col" style="width: 15%">การดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(refund,index) in refunds" :key="index">
                            <td>{{getThaiDate(refund.create_date)}}</td>
                            <td><span v-if="refund.contracts.length > 0">{{refund.contracts[0].contract_party}}</span><span v-else>-</span></td>
                            <td><span v-if="refund.contracts.length > 0">{{refund.contracts[0].contract_no}}</span><span v-else>-</span></td>
                            <td>{{getStatus(refund.status)}}</td>
                            <td>
                                <b-button :id="'btnEdit'+refund.id" class="tools" size="sm" variant="outline-primary" @click="showRefund(refund.id)"><i class="fas fa-edit"></i></b-button>
                                <b-tooltip :target="'btnEdit'+refund.id" triggers="hover" placement="left">
                                    แสดงข้อมูล
                                </b-tooltip>

                                <b-button :id="'btnDel'+refund.id" class="tools" size="sm" variant="outline-danger" @click="delRefund(refund.id)"><i class="fas fa-trash"></i></b-button>
                                <b-tooltip :target="'btnDel'+refund.id" triggers="hover" placement="left">
                                    ลบข้อมูล
                                </b-tooltip>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </b-col>
        </b-row>
        <!-- <refund-cover
            :state="state" :refund="refund"
             v-for="(refund,index) in refunds" :key="index"
            @fetchRefund="fetchData"
        ></refund-cover> -->

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
    computed: {
        path(){
            return this.$route.path;
        },
        isAdmin(){
            var path = [];
            path = this.$route.path.split("/");
            return path.indexOf('admin') > -1 ? true : false;

        }
    },
    methods: {
        fetchData(){
            var user = this.$store.state.user;
            console.log('user :' + user);
            if (this.isAdmin){
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
        },
        getStatus(status){
            if (status < 7){
                return 'ยังไม่ส่งข้อมล'
            }else{
                return 'ส่งข้อมูลแล้ว'
            }
        },
        getClass(status){
            if (status < 7){
                return 'status1'
            }else{
                return 'status2'
            }
        },

        getThaiDate(item){
            var d = new Date(item);
            return d.toLocaleDateString('th-TH', { day: 'numeric', month: 'long', year: 'numeric' });
            //return moment(String(value)).format('LL')
        },
        showRefund(id){

            this.$router.push(`refunds/${id}`);
        },
        delRefund(id){
            this.$swal({
                title: "กรุณายืนยันการลบรายการถอนคืน",
                text: "หากยืนยันการลบ หลักเกณฑ์และเงื่อนไขจะถูกลบไปด้วย",
                icon: "warning",
                closeOnClickOutside: false,
                buttons: [
                    'ยกเลิก',
                    'ยืนยัน'
                ],
            }).then(isConfirm =>{
                if (isConfirm){
                    let path = `/api/offices/${this.office_id}/refunds/${id}`;
                    console.log('path : ' + path);
                    axios.put(`${path}`,{
                        status : '0'
                    })
                    .then(response=>{
                        console.log('OK : ');
                        this.fetchData();
                    })
                    .catch(error=>{
                        console.log('error : ' + error);
                    })
                }
            });
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
.tools{
    padding: 5px 8px 5px 8px!important;
}
td{
    padding-top: 5px;
    padding-bottom: 5px;
    cursor: pointer;
}
.status1{
    background-color: rgb(247, 230, 158);
}
.status2{
    background-color: rgb(170, 224, 149);
}
</style>
