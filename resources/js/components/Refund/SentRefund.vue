<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
        <b-row align-h="center">
            <b-col cols="7">
                <b-card class="bg-primary " v-if="status == 'new' || (isAdmin && refund_status < 88)">
                    <div slot="header" class="navbar ">
                        <ul class="nav navbar-nav d-md-down-none">
                            <li class="nav-item px-3">
                                <i class='fa fa-align-justify'></i>
                                    พิมพ์รายงาน และส่งข้อมูล
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
                    <b-card-body class="bg-default">
                        <b-row>
                            <b-col>
                                <b-form-group
                                    label-cols-sm="5"
                                    label="พิมพ์แบบถอนคืนเพื่อลงนาม :"
                                    label-align-sm="right"
                                    label-for="load_form"
                                >
                                    <b-button ref="load_form" variant="warning" size="md" @click="showReport"><i class="fas fa-download fa-1x"></i></b-button>
                                </b-form-group>
                                <b-modal id="modalReport"
                                    ref="modalReport"
                                    size="xl"
                                    class="report"
                                    hideFooter
                                    no-close-on-backdrop
                                    no-close-on-esc
                                    >

                                        <refund-report
                                            :refund_id="refund_id"
                                            :office_id="office_id"
                                            :show_report="show"
                                        ></refund-report>

                                </b-modal>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col>
                                <b-form-group
                                    label-cols-sm="5"
                                    label="แนบแบบถอนคืนที่ลงนามแล้ว :"
                                    label-align-sm="right"
                                    label-for="send_file"
                                >
                                    <b-form-file
                                        ref="send_file"
                                        :file-name-formatter="formatNames"
                                        v-model="file"
                                        :state="Boolean(file)"
                                        placeholder="เลือกไฟล์"
                                        drop-placeholder="ลากไฟล์มาวางที่นี่"
                                        browse-text="เลือกไฟล์"
                                    ></b-form-file>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row v-if="false">
                            <b-col>
                                <b-form-group
                                    label-cols-sm="5"
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
                                    label-cols-sm="5"
                                    label=""
                                    label-align-sm="right"
                                    label-for="description"
                                >

                                    <!-- <b-progress v-if="(uploadPercentage == 0 || uploadPercentage == 100) ? false : true" :value="uploadPercentage" variant="success" striped class="mb-2"></b-progress> -->

                                    <b-button :variant=" file ? 'danger' : 'secondary'" size="md" @click="clearFile()">ยกเลิก</b-button>
                                    <b-button :disabled="file ? false : true" :variant=" file ? 'dark' : 'secondary'" size="md" @click="submitFile()">ส่งข้อมูล</b-button>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-card-body>
                </b-card>
            </b-col>
        </b-row>
        <b-row align-h="center" v-if="status=='success' && !isAdmin">
            <b-col cols="6">
                <b-alert variant="success" show>
                    <h4 class="alert-heading">ข้อมูลถูกจัดส่งแล้ว</h4>
                    <p>
                        ข้อมูลของท่านได้ถูกส่งให้กรมบัญชีกลางเรียบร้อยแล้ว
                    </p>
                </b-alert>
                <!-- <div class="text-center" >
                    <b-button variant="primary" class="download mb-4"
                        v-for="(file,index) in list_files" :key="index"
                        size="md" @click="downloadForm(file.id,index)"
                        >{{ file.upload_by == 'admin' ? 'ฟอร์มโดย Admin' : 'ดูแบบฟอร์มของท่าน'}}
                    </b-button>
                </div> -->
            </b-col>
        </b-row>
        <b-row align-h="center" v-if="list_files.length > 0">
            <b-col cols="7">
                <table class="table table-hover">
                    <thead class="thead">
                        <tr>
                            <th scope="col" style="width: 20%">ลำดับที่</th>
                            <th scope="col" style="width: 35%">วันที่บันทึก</th>
                            <th scope="col" style="width: 30%">ผู้บันทึก</th>
                            <th scope="col" style="width: 15%">Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,index) in list_files" :key="index">
                            <td>{{index+1}}</td>
                            <td>{{getThaiDate(item.created_at)}}</td>
                            <td>{{item.upload_by}}</td>
                            <td>
                                <b-button variant="outline-danger" class="download"
                                    size="sm" @click="downloadForm(item.id,index+1)"
                                    ><i class="far fa-file-pdf fa-2x"></i>
                                </b-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </b-col>
        </b-row>
        <b-row align-h="center">
            <b-col cols="7">
                <admin-approve
                    :refund_status="refund_status"
                    :refund_id="refund_id"
                    :office_id = "office_id"
                ></admin-approve>
            </b-col>
        </b-row>
    </div>
</template>

<script>
export default {
    props: ['refund_id','refund_status','office_id'],
    data(){
        return {
            //office_id: this.$store.getters.office_id,
            file: null,
            alert: '',
            uploadPercentage: 0,
            description: '',
            upload_by: 'user',
            list_files: [],
            status: 'new',
            user: this.$store.getters.user,
            show: false


        }
    },
    computed: {
        isAdmin(){
            console.log('isAdmin :' + this.user.type);
            return this.user.type == 'admin' ? true : false;
        }
    },
    mounted(){

        this.fetchData();

    },
    methods: {

        showReport(){
            this.show = true;
            this.$refs['modalReport'].show()
            setTimeout(() => {
                this.show = false;
            }, 3000);
        },
        formatNames(files) {
            if (files.length === 1) {
                return files[0].name
            } else {
                return `${files.length} files selected`
            }
        },
        clearFile(){
            this.file = null;
            this.uploadPercentage = 0;
        },
        submitFile(){
            this.$swal({
                title: "กรุณาตรวจสอบข้อมูล",
                text: "หากส่งข้อมูลแล้วจะไม่สามารถแก้ไขได้อีก",
                icon: "warning",
                closeOnClickOutside: false,
                buttons: [
                    'ยกเลิก',
                    'ยืนยัน'
                ],
            }).then(isConfirm =>{
                if (isConfirm){
                    var formData = new FormData();
                    var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_files`;
                    formData.append('file',this.file);
                    formData.append('description',this.description);
                    formData.append('upload_by', this.user.username);
                    axios.post(`${path}`,formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        onUploadProgress: function( progressEvent ) {
                            this.uploadPercentage = parseInt( Math.round( ( progressEvent.loaded / progressEvent.total ) * 100 ));
                        }.bind(this)
                    })
                    .then(response=>{
                        this.alert = "success";

                        this.fetchData();
                        this.$emit("refund_update");
                        this.$forceUpdate();
                    })
                    .catch(error=>{
                        console.log("error :" + error);
                    })
                }
            })
        },

        fetchData(){
            this.list_files = [];
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_files`;
            axios.get(`${path}`)
            .then(response=>{
                this.list_files = response.data;
                this.status = this.list_files.length > 0 ? "success" : "new";
                this.$forceUpdate();
            })
            .catch(error=>{
                console.log('error' + error);
            })
        },
        downloadForm(id,index){
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_files/${id}`;
            console.log('download file :' + path);
            axios.get(`${path}`)
            axios({
                url : `${path}`,
                methods : 'GET',
                responseType : 'blob'
            })
            .then(response=>{
                var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                //console.log('file url :' + fileURL);
                //return
                var fileLink = document.createElement('a');
                fileLink.href = fileURL;
                let filename = 'form_refund_' + this.refund_id + '_' + index + '.pdf'
                fileLink.setAttribute('download', filename);
                document.body.appendChild(fileLink);

                fileLink.click();
            })
            .catch(error=>{

            })
        },
        getThaiDate(item){
            var d = new Date(item);
            return d.toLocaleDateString('th-TH', { day: 'numeric', month: 'long', year: 'numeric' });
            //return moment(String(value)).format('LL')
        },


    }
}
</script>

<style scoped>
.download{
    margin-left: 10px!important;
}
td{
    padding-top: 5px;
    padding-bottom: 5px;
    cursor: pointer;
}
.thead{
    background-color: #1074b8;
    color: #fff;
    font-weight: normal!important;
}
.report{
    color: #000!important;
}
</style>
