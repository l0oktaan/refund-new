<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
        <b-row>
            <b-col cols="auto" class="mr-auto">
                <span class="h4">ข้อมูลการถอนคืนเงินรายได้</span>
                <b-button v-if="user_type=='user'" class="pt-2 pb-2 ml-5" variant="outline-success" @click="createRefund">
                    <i class="fas fa-plus-circle fa-2x"></i>&nbsp;<span>สร้างรายการถอนคืนฯ</span>
                </b-button>
            </b-col>
            <b-col cols="auto" class="text-right">                       
                <b-input-group size="lg" >
                    <template v-slot:append>
                        <b-input-group-text class="clearFilter" @click="filter=''; set_refund_show('all')" v-if="filter!=''"><b-icon icon="x"></b-icon></b-input-group-text>
                        <b-input-group-text @click="onFilter"><b-icon icon="funnel"></b-icon></b-input-group-text>
                    </template>
                    <b-form-input placeholder="ค้นหา..." @keyup.enter.native="onFilter" v-model="filter"></b-form-input>
                </b-input-group>                    
            </b-col>                
        </b-row>
        <b-row class="justify-content-md-center mt-5">
            <b-col cols="3" v-for="(status,index) in arr_refund_status.slice(0,4).filter(x=>x.show.includes(user_type))" :key="index">
                <b-card :class="(status.status.includes(8)) ? get_class : status.class_name" @click="set_refund_show(status.class_name)">
                    <b-row>
                        <b-col>
                            <div class="h3 icon text-right mb-2">
                                <i :class="(status.status.includes(8)) ? get_icon : status.icon"></i>
                            </div>
                        </b-col>
                    </b-row>
                    <div><span><span class="h4">{{status.count}}</span> รายการ</span></div>
                    <div class="h5 mb-0">{{(status.status.includes(8)) ? get_text : status.text}}</div>
                </b-card>
            </b-col>
        </b-row>
        <b-row class="justify-content-md-center">
            <b-col cols="3" v-for="(status,index) in arr_refund_status.slice(4,7)" :key="index">
                <b-card :class="(status.status.includes(8)) ? get_class : status.class_name" @click="set_refund_show(status.class_name)">
                    <b-row>
                        <b-col>
                            <div class="h3 icon text-right mb-2">
                                <i :class="(status.status.includes(8)) ? get_icon : status.icon"></i>
                            </div>
                        </b-col>
                    </b-row>
                    <div><span><span class="h4">{{status.count}}</span> รายการ</span></div>
                    <div class="h5 mb-0">{{(status.status.includes(8)) ? get_text : status.text}}</div>
                </b-card>
            </b-col>
        </b-row>

        <b-row>
            <!-- <b-col>{{refunds}}</b-col> -->
        </b-row>

        <b-row>
            <b-col cols="12">
                <table class="table table-hover">
                    <thead class="thead">
                        <tr>
                            <th scope="col" style="width: 15%" v-if="user_type == 'user'">วันที่สร้าง</th>
                            <th scope="col" style="width: 15%" v-if="user_type == 'admin'">วันที่ส่ง</th>
                            <th scope="col" style="width: 25%" v-if="user_type == 'admin'">หน่วยงาน</th>
                            <th scope="col" style="width: 23%">คู่สัญญา</th>
                            <th scope="col" style="width: 10%">เลขที่สัญญา</th>
                            <th scope="col" style=""></th>
                            <th scope="col" style="width: 15%">สถานะ</th>
                            <th scope="col" style="width: 15%">การดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(refund,index) in refund_show_page" :key="index">
                            <td v-if="user_type == 'user'">{{getThaiDate(refund.create_date)}}</td>
                            <td v-if="user_type == 'admin'">{{getThaiDate(refund.sent_date)}}</td>
                            <td v-if="user_type == 'admin'"><span >{{refund.office.name}}</span></td>
                            <td><span >{{refund.contracts.length ? refund.contracts[0].contract_party : '-'}}</span></td>
                            <td><span >{{refund.contracts.length ? refund.contracts[0].contract_no : '-'}}</span></td>
                            <td class="text-right"><i :class="get_status_icon(refund.status)"></i></td>
                            <td>{{get_status_text(refund.status)}}</td>
                            <td>

                                <div v-if="user_type == 'admin'">
                                    <b-button :id="'btnShow'+refund.id" class="tools" size="sm" variant="outline-primary" @click="showReport(refund.id,refund.office_id)"><i class="fas fa-eye fa-lg"></i></b-button>
                                    <b-tooltip :target="'btnShow'+refund.id" triggers="hover" placement="left">
                                        แสดงข้อมูล
                                    </b-tooltip>

                                    <b-button v-if="refund.status == 8" :id="'btnConsider'+refund.id" class="tools" size="sm" variant="outline-success" @click="considerRefund(refund.id,refund.office_id)"><i class="fas fa-user-check fa-lg"></i></b-button>
                                    <b-tooltip v-if="refund.status == 8" :target="'btnConsider'+refund.id" triggers="hover" placement="left">
                                        รับพิจารณา
                                    </b-tooltip>
                                    <b-button v-if="refund.status >= 9"
                                        :id="'btnEdit'+refund.id"
                                        class="tools" size="sm"
                                        variant="outline-dark"
                                        @click="showRefund(refund.id,refund.office_id)"

                                    >
                                        <i class="fas fa-pencil-alt fa-lg"></i>
                                    </b-button>
                                    <b-tooltip v-if="refund.status >= 9" :target="'btnEdit'+refund.id" triggers="hover" placement="left">
                                        แก้ข้อมูล {{(user.username != refund.consider_by) ? 'โดย :' + refund.consider_by : "" }}
                                    </b-tooltip>
                                </div>
                                <div v-if="user_type == 'user'">
                                    <b-button :id="'btnEdit'+refund.id" class="tools" size="sm" variant="outline-primary" @click="showRefund(refund.id,refund.office_id)"><i class="fas fa-edit"></i></b-button>
                                    <b-tooltip :target="'btnEdit'+refund.id" triggers="hover" placement="left">
                                        แสดงข้อมูล
                                    </b-tooltip>

                                    <b-button v-if="refund.status <= 7" :id="'btnDel'+refund.id" class="tools" size="sm" variant="outline-danger" @click="delRefund(refund.id)"><i class="fas fa-trash"></i></b-button>
                                    <b-tooltip :target="'btnDel'+refund.id" triggers="hover" placement="left">
                                        ลบข้อมูล
                                    </b-tooltip>
                                </div>


                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="tfoot">
                        <tr>
                            <td :colspan="user_type == 'user' ? 6 : 7">
                                <span style="text-align:center">
                                    รายการที่ {{beginRecord}} - {{endRecord}} จากทั้งหมด {{rows}} รายการ
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>




            </b-col>
        </b-row>
        <b-row class="foot">
            <b-col cols="1">
                <div style="text-align:right;">
                    <b-form-select v-model="perPage" :options="arr_perPage"></b-form-select>
                </div>

            </b-col>
            <b-col cols="3" >
               <p style="text-align:left; margin-top:5px;">รายการต่อหน้า</p>
            </b-col>

            <b-col cols="4">
                <div style="text-align:center;">
                    <b-pagination
                        align="center"
                        v-model="currentPage"
                        pills
                        :total-rows="rows"
                        :per-page="perPage"
                    ></b-pagination>

                    <b-button v-if="refund_filter" variant="danger" @click="set_refund_show('all')">แสดงทั้งหมด</b-button>
                </div>

            </b-col>
            <b-col cols="4"></b-col>
        </b-row>
        
        <b-row class="justify-content-md-center">
            <b-col cols>

            </b-col>
        </b-row>
        <b-modal id="modalReport"
            ref="modalReport"
            size="xl"
            hideFooter
            no-close-on-backdrop
            no-close-on-esc
            >

                <refund-report v-if="refund_id != 0"
                    :refund_id="refund_id"
                    :office_id="office_id"
                ></refund-report>

        </b-modal>
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
            refund_id: 0,
            refunds: [],
            refund_show: [],
            refund_show_page: [],
            office_id: this.$store.getters.office_id,
            user: this.$store.getters.user,
            state: '',
            refund_new: [],
            refund_info: [],
            refund_success: [],
            refund_consider: [],
            refund_wait: [],
            refund_complete: [],
            refund_reject: [],
            refund_filter: [],
            count_new: 0,
            count_info: 0,
            count_success: 0,
            count_consider: 0,
            count_complete: 0,
            count_reject: 0,
            refund_filter: false,
            arr_refund_status: this.$store.getters.arr_refund_status,
            user_type: '',
            show: false,
            currentPage: (this.$store.getters.current_page) ? this.$store.getters.current_page : 1,
            perPage: this.$store.getters.per_page,
            arr_perPage: [5,10,15],
            fields: [''],
            alert: '',
            filter: ''

        }
    },
    async mounted(){
        if (!this.perPage){
            this.perPage = 5;
        }
        this.user_type = this.$store.getters.user_type;
        await this.fetchData();
        //this.$store.state.refund_show = 'all';


    },
    computed: {
        beginRecord(){
            return this.currentPage <= 1 ? 1 : ((this.currentPage * this.perPage) - this.perPage) + 1;
        },
        endRecord(){
            return (this.currentPage * this.perPage) > this.rows ? this.rows : this.currentPage * this.perPage;
        },
        rows(){
            return this.refund_show.length;
        },
        path(){
            return this.$route.path;
        },
        isAdmin(){
            var path = [];
            path = this.$route.path.split("/");
            return path.indexOf('admin') > -1 ? true : false;

        },
        get_class(){
            if (this.user_type == 'user'){
                return this.arr_refund_status[2].class_name.user;
            }else if (this.user_type == 'admin'){

                return this.arr_refund_status[2].class_name.admin;
            }
        },
        get_icon(){
            if (this.user_type == 'user'){
                return this.arr_refund_status[2].icon.user;
            }else if (this.user_type == 'admin'){

                return this.arr_refund_status[2].icon.admin;
            }
        },
        get_text(){
            if (this.user_type == 'user'){
                return this.arr_refund_status[2].text.user;
            }else if (this.user_type == 'admin'){
                return this.arr_refund_status[2].text.admin;
            }
        },

    },
    watch: {
        async currentPage(newVal, oldVal){
            
                let end = await newVal * this.perPage;
                let begin = await end - this.perPage;
                this.refund_show_page = await this.refund_show.slice(begin, end);
                //this.$store.commit('current_page',newVal);
            
            
        },
        async refund_show(){
            // let page =  this.$store.getters.current_page;
            // if (!page || page > this.rows/this.perPage){
            //     this.currentPage = 1

            // }else{
            //     this.currentPage = page
            // }
            if (this.refund_show.length > this.perPage){
                let end = 1 * this.perPage;
                let begin = await end - this.perPage;
                this.refund_show_page = await this.refund_show.slice(begin, end);
            }else{
                this.refund_show_page = await this.refund_show;
            }
            
        },
        async perPage(newVal,oldVal){
            this.$store.commit('per_page',newVal);
            let end = 1 * this.perPage;
            let begin = await end - this.perPage;
            this.refund_show_page = await this.refund_show.slice(begin, end);
        }
    },

    methods: {
        
        onFilter(){
            
            if (this.filter != ''){
                this.refund_filter = this.refunds.filter(x=>x.contracts[0].contract_party.search(this.filter)>=0 || x.contracts[0].contract_no.search(this.filter)>=0 || x.approve_code.search(this.filter)>=0);
                
                this.$store.commit('refund_filter',this.refund_filter)
                this.set_refund_show('filter');
            }
        },
        get_status_icon(status){
            return this.arr_refund_status[this.arr_refund_status.findIndex(x=>x.status.includes(status))].icon;
        },
        get_status_text(status){
            if (this.user_type == 'admin'){
                return (status == 8) ? this.arr_refund_status[this.arr_refund_status.findIndex(x=>x.status.includes(status))].text.admin : this.arr_refund_status[this.arr_refund_status.findIndex(x=>x.status.includes(status))].text;
            }else{
                return (status == 8) ? this.arr_refund_status[this.arr_refund_status.findIndex(x=>x.status.includes(status))].text.user : this.arr_refund_status[this.arr_refund_status.findIndex(x=>x.status.includes(status))].text;
            }

        },
        set_refund_show(status){
            //console.log('typeof :' + typeof status);

            let show = null;
            if (status){
                if (typeof status == 'object'){
                    show = 'success';
                    this.refund_filter = true;
                }else if (status == 'all'){
                    this.refund_filter = false;
                }else{
                    show = status;
                    this.refund_filter = true;
                }
            }else{
                this.refund_filter = false;
            }
            this.$store.commit('SET_REFUND_SHOW',show)

            switch (show){
                case 'new' :
                    this.refund_show = this.refund_new;
                    break;
                case 'info' :
                    this.refund_show = this.refund_info;
                    break;
                case 'success' :
                    this.refund_show = this.refund_success;
                    break;
                case 'consider' :
                    this.refund_show = this.refund_consider;
                    break;
                case 'wait' :
                    this.refund_show = this.refund_wait;
                    break;
                case 'complete' :
                    this.refund_show = this.refund_complete;
                    break;
                case 'reject' :
                    this.refund_show = this.refund_reject;
                    break;
                case 'filter' :
                    this.refund_show = this.$store.getters.refund_filter;
                    break;
                case 'all' :                    
                    this.refund_show = this.refunds;
                    this.filter = '';
                    this.$store.commit('refund_filter',null);
                    break;
                default :
                    this.refund_show = this.refunds;
            }
        },
        async refund_status(){
            if (this.user_type == 'user'){
                this.refund_new = await this.refunds.filter(x=>x.status == 1);
                this.refund_info = await this.refunds.filter(x=>x.status >= 2 && x.status < 8);

            }

            this.refund_success = await this.refunds.filter(x=>x.status == 8);
            this.refund_consider = await this.refunds.filter(x=>x.status == 9);
            this.refund_wait = await this.refunds.filter(x=>x.status == 11);
            this.refund_complete = await this.refunds.filter(x=>x.status == 99);
            this.refund_reject = await this.refunds.filter(x=>x.status == 88);

            this.arr_refund_status[0].count = this.refund_new.length;
            this.arr_refund_status[1].count = this.refund_info.length;
            this.arr_refund_status[2].count = this.refund_success.length;
            this.arr_refund_status[3].count = this.refund_consider.length;
            this.arr_refund_status[4].count = this.refund_wait.length;
            this.arr_refund_status[5].count = this.refund_reject.length;
            this.arr_refund_status[6].count = this.refund_complete.length;

            // this.count_new = await this.refund_new.length;
            // this.count_info = await this.refund_info.length;
            // this.count_success = await this.refund_success.length;
            // this.count_consider = await this.refund_consider.length;
            // this.count_wait = await this.refund_wait.length;
            // this.count_complete = await this.refund_complete.length;
            // this.count_reject = await this.refund_reject.length;
        },
        async fetchData(){
            //console.log('refund show :' + this.$store.state.refund_show);
            //let user_type = await this.$store.getters.user_type;
            //console.log('user :' + user_type);
            let path = '';
            if (this.user_type == 'admin'){
                path = await `/api/admin/0/refunds`;
            }else if (this.user_type == 'user'){
                path = await `/api/offices/${this.office_id}/refunds`;
            }else{
                return;
            }


            var refunds = [];
            var contracts = [];
            console.log('path :' + path);
            let response = await axios.get(path);
            this.refunds = await response.data.data;
            this.refund_show = await this.refunds;
            await this.refund_status();
            await this.set_refund_show(this.$store.getters.refund_show);
            //this.state = 'show';
            this.$forceUpdate();
        },
        createRefund(){
            this.$router.push({path: 'form'});
        },
        // getStatus(status){
        //     switch(status){
        //         case 0:
        //         case 1:
        //             return { status :'ตรวจสอบหลักเกณฑ์' , icon : 'icon-magic-wand icon_warning' ,color: 'icon_warning'}
        //             break;
        //         case 2:
        //         case 3:
        //         case 4:
        //         case 5:
        //         case 6:
        //         case 7:
        //             return { status :'บันทึกข้อมูล' , icon : 'icon-pencil icon_primary',color: 'icon_primary'}
        //             break;
        //         case 8:
        //             if (this.user.type == 'admin'){
        //                 return { status :'รอการพิจารณา' , icon : 'fas fa-paper-plane icon_warning',color: 'icon_warning'}
        //             }else{
        //                 return { status :'ส่งข้อมูลแล้ว' , icon : 'fas fa-paper-plane icon_success',color: 'icon_success'}
        //             }

        //             break;
        //         case 9:
        //             return { status :'กำลังพิจารณา' , icon : 'icon-note icon_consider',color: 'icon_consider'}
        //             break;
        //         case 88:
        //             return { status :'ไม่อนุมัติ' , icon : 'fas fa-sign-out-alt icon_reject',color: 'icon_reject'}
        //             break;
        //         case 99:
        //             return { status :'อนุมัติ' , icon : 'fas fa-check icon_complete',color: 'icon_complete'}
        //             break;
        //     }
        // getStatus(status){
        //     switch(status){
        //         case 0:
        //         case 1:
        //             return 'ตรวจสอบหลักเกณฑ์'
        //             break;
        //         case 2:
        //         case 3:
        //         case 4:
        //         case 5:
        //         case 6:
        //         case 7:
        //             return 'บันทึกข้อมูล'
        //             break;
        //         case 8:
        //             return 'ส่งข้อมูลแล้ว'
        //             break;
        //         case 9:
        //             return 'กำลังพิจารณา'
        //             break;
        //         case 88:
        //             return 'ไม่อนุมัติ'
        //             break;
        //         case 99:
        //             return 'อนุมัติ'
        //             break;
        //     }
            // if (status < 7){
            //     return 'ยังไม่ส่งข้อมล'
            // }else{
            //     return 'ส่งข้อมูลแล้ว'
            // }
        // },
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
        async showRefund(id,office_id){
            if (this.$store.getters.user_type == 'admin'){
                await this.$store.commit('office_id', office_id);
            }

            // let route = this.$router.resolve({path: `refunds/${id}`});
            // window.open(route.href, '_blank');
            await this.$router.push(`refunds/${id}`);
        },
        delRefund(id){
            this.$swal({
                title: "กรุณายืนยันการลบรายการถอนคืน",

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
                    // axios.put(`${path}`,{
                    //     status : '0'
                    // })
                    axios.delete(`${path}`)
                    .then(response=>{
                        this.alert = 'success';
                        this.fetchData();
                    })
                    .catch(error=>{
                        console.log('error : ' + error);
                    })
                }
            });
        },
        showReport(refund_id,office_id){
            this.$nextTick(()=>{
                this.refund_id = refund_id;
                this.office_id = office_id;
            })


            this.$refs['modalReport'].show()
        },
        considerRefund(refund_id,office_id){
            //console.log(today);
            this.$swal({
                title: "กรุณายืนยันการรับเรื่อง",
                text: "",
                icon: "info",
                closeOnClickOutside: false,
                buttons: [
                    'ยกเลิก',
                    'ยืนยัน'
                ],
            }).then(isConfirm =>{
                if (isConfirm){
                    let path = `/api/offices/${office_id}/refunds/${refund_id}`;
                    let today = new Date();
                    let str_today = today.getFullYear() + '-' + (today.getMonth()+1) + '-' + today.getDate()
                    //console.log(str_today);

                    let user = this.$store.getters.user;
                    axios.put(`${path}`,{
                        "status" : 9,
                        "consider_date" : str_today,
                        "consider_by" : user.username
                    })
                    .then(response=>{
                        //console.log('OK : ');
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

.warning:hover,.stanby:hover,.new:hover,.info:hover,.success:hover,.consider:hover,.wait:hover,.complete:hover,.reject:hover{
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
.new{
    cursor: pointer;
    background-color: #ffc107;
    border: 1px solid #a88008;
}
.info{
    cursor: pointer;
    background-color: #25a2f5;
    border: 1px solid #086aac;
    color: #011929;
}
.stanby{
    cursor: pointer;
    background-color: #ffc107;
    border: 1px solid #a88008;
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
.consider{
    cursor: pointer;
    background-color: #df7e10;
    border: 1px solid #793e0e;
    color: #ffffff;
}
.wait{
    cursor: pointer;
    background-color: #d13bca;
    border: 1px solid #8a218a;
    color: #ffffff;
}
.complete{
    cursor: pointer;
    background-color: #368d2e;
    border: 1px solid #1d4b10;
    color: #dee8f8;
}
.reject{
    cursor: pointer;
    background-color: #e44c4c;
    border: 1px solid #a03030;
    color: #fcfafa;
}
.icon_complete, .icon_consider, .icon_primary, .icon_reject, .icon_success, .icon_warning{
    margin-right: 5px;
}
.icon_warning{
    color: #a88008;
}
.icon_primary{
    color: #086aac;
}
.icon_success{
    color: #046638;
}
.icon_consider{
    color: #793e0e;
}
.icon_wait{
    color: #83117f;
}
.icon_complete{
    color: #1d4b10;
}
.icon_reject{
    color: #a03030;
}

.thead, .tfoot{
    background-color: #1074b8;
    color: #fff;
    font-weight: normal!important;
}
.tfoot{
    text-align: center!important;
}
.form-control{
    border-color: #1074b8!important;
}
.input-group-text{
    cursor: pointer;
    background-color: #1074b8!important;
    border-color: #1074b8!important;
    color: #fff;
}
.clearFilter{
    background-color: rgb(255, 0, 0)!important;
}
.clearFilter:hover{
    box-shadow: 0 0 0 0.2rem rgb(255, 0, 0, 0.25);
}
 
</style>
