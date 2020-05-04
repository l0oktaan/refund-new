<template>
    <div class="animated fadeIn">
        <b-row>
            <b-col>
                <div class="topHead float-right">
                    <b-button class="pt-2 pb-2" variant="outline-success" @click="createRefund">
                        <i class="fas fa-plus-circle fa-2x"></i>&nbsp;<span>สร้างรายการถอนคืนฯ</span>
                    </b-button>
                    <b-button class="pt-2 pb-2" variant="outline-primary">
                        <i class="fas fa-search fa-2x"></i>&nbsp;<span>ค้นหา</span>
                    </b-button>
                </div>
                <h4>ข้อมูลการถอนคืนเงินรายได้</h4>
            </b-col>
        </b-row>
        <b-row class="justify-content-md-center">
            <b-col cols="3">
                <b-card class="warning" @click="set_refund_show('new')">
                    <b-row>
                        <b-col>
                            <div class="h3 icon text-right mb-2">
                                <i class="icon-magic-wand"></i>
                            </div>
                        </b-col>
                    </b-row>
                    <div><span><span class="h4">{{count_new}}</span> รายการ</span></div>
                    <div class="h5 mb-0">ตรวจสอบหลักเกณฑ์</div>

                </b-card>
            </b-col>
            <b-col cols="3">
                <b-card class="primary" @click="set_refund_show('info')">
                    <b-row>
                        <b-col>
                            <div class="h3 icon text-right mb-2">
                                <i class="icon-pencil"></i>
                            </div>
                        </b-col>
                    </b-row>
                    <div><span><span class="h4">{{count_info}}</span> รายการ</span></div>
                    <div class="h5 mb-0">กำลังบันทึกข้อมูล</div>

                </b-card>
            </b-col>
            <b-col cols="3">
                <b-card class="success" @click="set_refund_show('success')">
                    <b-row>
                        <b-col>
                            <div class="h3 icon text-right mb-2">
                                <i class="icon-flag"></i>
                            </div>
                        </b-col>
                    </b-row>
                    <div><span><span class="h4">{{count_success}}</span> รายการ</span></div>
                    <div class="h5 mb-0">ส่งข้อมูลแล้ว</div>

                </b-card>
            </b-col>

        </b-row>

        <b-row>
            <!-- <b-col>{{refunds}}</b-col> -->
        </b-row>
        <b-row v-if="true">
            <b-col cols="12">
                <table class="table table-hover">
                    <thead class="thead">
                        <tr>
                            <th scope="col" style="width: 15%">วันที่สร้าง</th>
                            <th scope="col" style="width: 35%">คู่สัญญา</th>
                            <th scope="col" style="width: 20%">เลขที่สัญญา</th>
                            <th scope="col" style="width: 15%">สถานะ</th>
                            <th scope="col" style="width: 15%">การดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(refund,index) in refund_show" :key="index">
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
        <b-row class="justify-content-md-center">
            <b-col cols="2">
                <b-button v-if="refund_filter" variant="outline-danger" @click="set_refund_show('all')">แสดงทั้งหมด</b-button>
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
            refund_show: [],
            office_id: 2,
            state: '',
            refund_new: [],
            refund_info: [],
            refund_success: [],
            count_new: 0,
            count_info: 0,
            count_success: 0,
            refund_filter: false,
            arr_refund_status: [
                {
                    name : 'new',
                    text : 'ตรวจสอบหลักเกณฑ์',
                    status : [1]
                },
                {
                    name : 'info',
                    text : 'กำลังบันทึกข้อมูล',
                    status : [2,3,4,5,6,7]
                },
                {
                    name : 'success',
                    text : 'ส่งข้อมูลแล้ว',
                    status : [8]
                },
            ]
        }
    },
    async mounted(){
        await this.fetchData();
        //this.$store.state.refund_show = 'all';


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
        set_refund_show(status){
            if (status == 'all'){
                this.refund_filter = false;
            }else{
                this.refund_filter = true;
            }
            this.$store.commit('SET_REFUND_SHOW',status)

            switch (status){
                case 'new' :
                    this.refund_show = this.refund_new;
                    break;
                case 'info' :
                    this.refund_show = this.refund_info;
                    break;
                case 'success' :
                    this.refund_show = this.refund_success;
                    break;
                case 'all' :
                    this.refund_show = this.refunds;
                    break;
                default :
                    this.refund_show = this.refunds;
            }
        },
        async refund_status(){
            this.refund_new = await this.refunds.filter(x=>x.status == 1);
            this.refund_info = await this.refunds.filter(x=>x.status >= 2 && x.status < 8);
            this.refund_success = await this.refunds.filter(x=>x.status == 8);
            this.count_new = await this.refund_new.length;
            this.count_info = await this.refund_info.length;
            this.count_success = await this.refund_success.length;
        },
        async fetchData(){
            //console.log('refund show :' + this.$store.state.refund_show);
            var user = this.$store.state.user;
            //console.log('user :' + user);
            var path = `/api/offices/${this.office_id}/refunds`;

            var refunds = [];
            var contracts = [];
            console.log('path :' + path);
            let response = await axios.get(path);
            this.refunds = await response.data.data;
            this.refund_show = await this.refunds;
            await this.refund_status();
            await this.set_refund_show(this.$store.getters.refund_show);
            this.state = 'show';
            this.$forceUpdate();
        },
        createRefund(){
            this.$router.push({path: 'form'});
        },
        getStatus(status){
            switch(status){
                case 0:
                case 1:
                    return 'ตรวจสอบหลักเกณฑ์'
                    break;
                case 2:
                case 3:
                case 4:
                case 5:
                case 6:
                case 7:
                    return 'บันทึกข้อมูล'
                    break;
                case 8:
                    return 'ส่งข้อมูลแล้ว'
                    break;
                case 9:
                    return 'กำลังพิจารณา'
                    break;
                case 88:
                    return 'ไม่อนุมัติ'
                    break;
                case 99:
                    return 'อนุมัติ'
                    break;
            }
            // if (status < 7){
            //     return 'ยังไม่ส่งข้อมล'
            // }else{
            //     return 'ส่งข้อมูลแล้ว'
            // }
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
            // let route = this.$router.resolve({path: `refunds/${id}`});
            // window.open(route.href, '_blank');
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
.warning{
    cursor: pointer;
    background-color: #ffc107;
    border: 1px solid #a88008;
}
.warning:hover,.primary:hover,.success:hover{
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
.primary{
    cursor: pointer;
    background-color: #25a2f5;
    border: 1px solid #086aac;
    color: #011929;
}
.success{
    cursor: pointer;
    background-color: #55e09f;
    border: 1px solid #046638;
    color: #03331d;
}
.thead{
    background-color: #1074b8;
    color: #fff;
    font-weight: normal!important;
}
</style>
