<template>
  <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>

        <b-card class="bg-primary" v-if="!complete_status && user.type == 'admin'">
            <div slot="header" class="navbar ">
                <ul class="nav navbar-nav d-md-down-none">
                    <li class="nav-item px-3">
                        <i class='fa fa-align-justify'></i>
                            บันทึกผลการพิจารณา
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
        <!-- <b-card class="bg-dark" v-if="status == 'new' || isAdmin"> -->

            <b-card-body class="bg-default" >
                <b-row align-h="center">
                    <b-col>
                        <div>
                            <b-row>
                                <b-col>
                                    <b-form-group
                                        label-cols-sm="4"
                                        label="ผลการตรวจสอบ :"
                                        label-align-sm="right"
                                        label-for="load_form"
                                    >
                                        <!-- <toggle-button :value = "false" :sync = "true" :width="60" :height="25"
                                            :labels="{checked: 'อนุมัติ', unchecked: 'ไม่'}"
                                            :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                                            style="padding-top:4px; line-height:0px;"
                                            v-model="isApprove"
                                        /> -->
                                        <b-form-select v-model="status" :options="arr_status"></b-form-select>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-form-group
                                        label-cols-sm="4"
                                        label="คำอธิบายเพิ่มเติม :"
                                        label-align-sm="right"
                                        label-for="description"
                                    >
                                        <b-form-textarea
                                            ref="description"
                                            id="desription"
                                            v-model = "description"
                                            placeholder="ใส่คำอธิบาย"
                                            rows="3"
                                            no-resize
                                        ></b-form-textarea>

                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-form-group
                                        label-cols-sm="4"
                                        label="วันที่บันทึก :"
                                        label-align-sm="right"
                                        label-for="complete_date"                                >
                                        <my-date-picker ref="complete_date" :id="11" :showDate="date_show" @update="value => date_complete = value"></my-date-picker>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-form-group
                                        label-cols-sm="4"
                                        label=""
                                        label-align-sm="right"
                                        label-for="description"
                                    >
                                        <b-button variant="dark" size="md" @click="onSubmit()">บันทึกข้อมูล</b-button>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </div>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
        <b-card :bg-variant="isApprove ? 'success' : 'danger'" class="p-1 pl-2" v-if="complete_status">
                <b-row>
                    <b-col>
                        <p class="text-right">ผลการตรวจสอบ :</p>
                    </b-col>
                    <b-col>
                        {{isApprove ? "อนุมัติ" : "ไม่อนุมัติ"}}
                    </b-col>
                </b-row>
                <b-row>
                    <b-col>
                        <p class="text-right">คำอธิบายเพิ่มเติม :</p>
                    </b-col>
                    <b-col>
                        {{description}}
                    </b-col>
                </b-row>
                <b-row>
                    <b-col>
                        <p class="text-right">วันที่บันทึก :</p>
                    </b-col>
                    <b-col>
                        {{getThaiDate(date_complete)}}
                    </b-col>
                </b-row>
                <b-row v-if="user.type == 'admin'">
                    <b-col>
                        <p class="text-right">ผู้บันทึก :</p>
                    </b-col>
                    <b-col>
                        {{refund.complete_by}}
                    </b-col>
                </b-row>
            </b-card>
    </div>
</template>

<script>
export default {
    props: ['refund_status', 'refund_id','office_id'],
    data(){
        return{

            description: '',
            isApprove: false,
            alert: '',
            date_complete: null,
            date_show: null,
            user: this.$store.getters.user,
            refund: null,
            complete_status : false,
            arr_status : [
                {value : 0 , text : 'ตัวเลือก'},
                {value : 11 , text : 'ขอเอกสารเพิ่มเติม'},
                {value : 99 , text : 'อนุมัติ'},
                {value : 88 , text : 'ไม่อนุมัติ'},
            ],
            status : 0
        }
    },
    mounted(){
        this.fetchData();
    },
    watch: {
        refund_id(){
            this.fetchData();
        }
    },
    computed: {
        date_today(){
            let today = new Date();
            let str_today = today.getFullYear() + '-' + (today.getMonth()+1) + '-' + today.getDate();
            console.log('today :' + str_today);
            return str_today;
        },
    },
    methods: {
        onSubmit(){
            this.$swal({
                title: "กรุณายืนยันการบันทึกผลการพิจารณา",
                text: "",
                icon: "info",
                closeOnClickOutside: false,
                buttons: [
                    'ยกเลิก',
                    'ยืนยัน'
                ],
            }).then(isConfirm =>{
                if (isConfirm){
                    let path = `/api/offices/${this.office_id}/refunds/${this.refund_id}`;
                    // let today = new Date();
                    // let str_today = today.getFullYear() + '-' + (today.getMonth()+1) + '-' + today.getDate()
                    //console.log(str_today);

                    let user = this.$store.getters.user;
                    let data = null;
                    if (this.status == 11){
                        data = {
                            "status" : this.status,
                            "return_date" : this.date_complete,
                            "return_by" : this.user.username,
                            "return_description" : this.description
                        }
                    }else{
                        data = {
                            "status" : this.status,
                            "complete_date" : this.date_complete,
                            "complete_by" : this.user.username,
                            "complete_description" : this.description
                        }
                    }
                    axios.put(`${path}`,data)
                    .then(response=>{
                        this.alert = 'success';
                        this.refund = response.data.data;
                        this.$nextTick(()=>{

                            if (this.refund.status == 99){
                                this.isApprove = true;
                                this.complete_status = true;
                                this.description = this.refund.complete_description;
                                this.date_complete = this.refund.complete_date;
                            }else if (this.refund.status == 88){
                                this.isApprove = false;
                                this.complete_status = true;
                                this.description = this.refund.complete_description;
                                this.date_complete = this.refund.complete_date;
                            }else if (this.refund.status == 11){
                                this.isApprove = false;
                                this.complete_status = false;
                            }
                            else{
                                this.complete_status = false;
                            }
                        })
                    })
                    .catch(error=>{
                        this.alert = 'error';
                        console.log('error : ' + error);
                    })
                }
            });

        },

        async fetchData(){
            let path = `/api/offices/${this.office_id}/refunds/${this.refund_id}`
            let refund = await axios.get(`${path}`);
            this.refund = refund.data.data[0];
            this.$nextTick(()=>{
                this.description = this.refund.complete_description;
                this.date_complete = this.refund.complete_date;
                if (this.refund.status == 99){
                    this.isApprove = true;
                    this.complete_status = true;
                }else if (this.refund.status == 88){
                    this.isApprove = false;
                    this.complete_status = true;
                }else if (this.refund.status == 11){
                    this.isApprove = false;
                    this.complete_status = false;
                    this.status = 11;
                    this.description = this.refund.return_description;
                    this.date_show = this.refund.return_date;
                }else{
                    this.complete_status = false;
                    this.date_show = this.date_today;
                }
            })

        },
        getThaiDate(item){
            var d = new Date(item);
            return d.toLocaleDateString('th-TH', { day: 'numeric', month: 'long', year: 'numeric' });
            //return moment(String(value)).format('LL')
        },
    },


}
</script>

<style scoped>
p{
    margin-bottom: 0!important;
}
</style>
