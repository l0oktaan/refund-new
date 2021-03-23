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
        <b-card :bg-variant="'success'" class="p-1 pl-2" v-if="complete_status">
            <b-row>
                <b-col>
                    <p class="text-right">ผลการตรวจสอบ :</p>
                </b-col>
                <b-col>
                    แจ้งผลการพิจารณาแล้ว
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
                {value : 11 , text : 'ขอให้ชี้แจง/ขอเอกสารเพิ่มเติม'},
                {value : 12 , text : 'อยู่ระหว่างหารือหน่วยงานฯ'},
                {value : 13 , text : 'เสนอร่าง'},
                {value : 14 , text : 'เสนอผู้อำนวยกอง'},                
                {value : 99 , text : 'แจ้งผลการพิจารณา'}                
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
            return str_today;
        },
    },
    methods: {
        onSubmit(){       
            let path = `/api/offices/${this.office_id}/refunds/${this.refund_id}`    
            let user = this.$store.getters.user;
            let data = null;
            switch (this.status){
                case 11 :
                    data = {
                        "status" : this.status,
                        "return_date" : this.date_complete,
                        "return_by" : this.user.username,
                        "return_description" : this.description
                    }
                    break;
                case 12 :
                    data = {
                        "status" : this.status,
                        "discuss_date" : this.date_complete,
                        "discuss_by" : this.user.username,
                        "discuss_description" : this.description
                    }
                    break;
                case 13 :
                    data = {
                        "status" : this.status,
                        "draft_date" : this.date_complete,
                        "draft_by" : this.user.username,
                        "draft_description" : this.description
                    }
                    break;
                case 14 :
                    data = {
                        "status" : this.status,
                        "director_date" : this.date_complete,
                        "director_by" : this.user.username,
                        "director_description" : this.description
                    }
                    break;
                case 99 :
                    data = {
                        "status" : this.status,
                        "complete_date" : this.date_complete,
                        "complete_by" : this.user.username,
                        "complete_description" : this.description
                    }
                    break;
                default :
            }
            
            axios.put(`${path}`,data)
            .then(response=>{
                this.alert = 'success';
                this.refund = response.data.data;
                this.$nextTick(()=>{
                    if (this.refund.status == 99){
                        
                        this.complete_status = true;
                        this.description = this.refund.complete_description;
                        this.date_complete = this.refund.complete_date;
                    }else{
                        
                        this.complete_status = false;
                    }  this.complete_status = false;
                    
                })
            })
            .catch(error=>{
                this.alert = 'error';
                this.complete_status = false;
            })           
        },

        async fetchData(){
            let path = `/api/offices/${this.office_id}/refunds/${this.refund_id}`
            let refund = await axios.get(`${path}`);
            this.refund = refund.data.data[0];
            this.$nextTick(()=>{                
                switch (this.refund.status){
                    case 11 :
                        this.complete_status = false;
                        this.status = this.refund.status;
                        this.description = this.refund.return_description;
                        this.date_show = this.refund.return_date;
                        break;
                    case 12 :
                        this.complete_status = false;
                        this.status = this.refund.status;
                        this.description = this.refund.discuss_description;
                        this.date_show = this.refund.discuss_date;
                        break;                    
                    case 13 :
                        this.complete_status = false;
                        this.status = this.refund.status;
                        this.description = this.refund.draft_description;
                        this.date_show = this.refund.draft_date;
                        break;   
                    case 14 :
                        this.complete_status = false;
                        this.status = this.refund.status;
                        this.description = this.refund.director_description;
                        this.date_show = this.refund.director_date;
                        break;
                    case 99 :                    
                        this.complete_status = true;
                        this.status = this.refund.status;
                        this.description = this.refund.complete_description;
                        this.date_complete = this.refund.complete_date;
                        break;
                    default :
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
