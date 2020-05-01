<template>
    <div class="animated fadeIn">

        <b-card no-body class="sub_rule" :class="getClass(refund.status)">
            <b-card-body class="pb-0 sub_rule">
                <b-dropdown v-if="isAdmin" class="float-right" style="color: #000!important;" variant="transparent p-0" right>
                    <template slot="button-content">
                        <i class="icon-settings sub_rule"></i>
                    </template>
                    <b-dropdown-item @click="showRefund()"><i class="fas fa-edit" ></i>&nbsp;ข้อมูลการถอนคืน</b-dropdown-item>
                </b-dropdown>
                <b-dropdown v-else class="float-right" style="color: #000!important;" variant="transparent p-0" right>
                    <template slot="button-content">
                        <i class="icon-settings sub_rule"></i>
                    </template>
                    <b-dropdown-item @click="showRefund()"><i class="fas fa-edit" ></i>&nbsp;ข้อมูลการถอนคืน</b-dropdown-item>

                    <b-dropdown-item @click="delRefund(refund.id)"> <i class="fas fa-trash" ></i>&nbsp;ลบข้อมูลการถอนคืน</b-dropdown-item>
                </b-dropdown>
                <b-row>
                    <b-col sm="2">
                        <div class="textFiled">สร้างรายการเมื่อ :</div>
                        <div>{{getThaiDate(refund.create_date)}}</div>
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
                        <div>{{getStatus(refund.status)}}</div>
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
            office_id: 2,
        }
    },
    watch: {
        refund(){
            this.iRefund = this.refund;
            //this.getContract();
            this.$forceUpdate();
        }
    },
    computed: {
        isAdmin(){
            var path = [];
            path = this.$route.path.split("/");
            return path.indexOf('admin') > -1 ? true : false;

        }
    },
    methods: {
        getStatus(status){
            switch(status){
                case 0:
                    return 'อยู่ระหว่างตรวจสอบหลักเกณฑ์'
                    break;
                case 1:
                case 2:
                case 3:
                case 4:
                case 5:
                case 6:
                    return 'อยู่ระหว่างบันทึกข้อมูล'
                    break;
                case 7:
                    return 'ส่งข้อมูลแล้ว'
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
        },
        getThaiDate(item){
            var d = new Date(item);
            return d.toLocaleDateString('th-TH', { day: 'numeric', month: 'long', year: 'numeric' });
            //return moment(String(value)).format('LL')
        },
        showRefund(){
            console.log('show refund :' + this.refund.id);
            this.$router.push(`refunds/${this.refund.id}`);
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
                        this.$emit('fetchRefund');
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

