<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
        <b-row align-h="center">
            <b-col cols="6">
                <div v-if="status == 'new' || isAdmin">
                    <b-row>
                        <b-col>
                            <b-form-group
                                label-cols-sm="4"
                                label="โหลดแบบฟอร์มเพื่อลงนาม :"
                                label-align-sm="right"
                                label-for="load_form"
                            >
                                <!-- <b-button ref="load_form" variant="primary" size="md" @click="downloadForm">แบบฟอร์ม</b-button> -->
                                <refund-report></refund-report>


                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col>
                            <b-form-group
                                label-cols-sm="4"
                                label="แบบฟอร์มที่มีการลงนาม :"
                                label-align-sm="right"
                                label-for="send_file"
                            >
                                <b-form-file
                                    ref="send_file"
                                    :file-name-formatter="formatNames"
                                    v-model="file"
                                    :state="Boolean(file)"
                                    placeholder="เลือกแบบฟอร์มที่ต้องการส่ง"
                                    drop-placeholder="Drop file here..."
                                    browse-text="เลือกไฟล์"
                                ></b-form-file>


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
                                label=""
                                label-align-sm="right"
                                label-for="description"
                            >
                                <br>

                                <b-progress :value="uploadPercentage" variant="success" striped class="mb-2"></b-progress>
                                <br>
                                <b-button :variant=" file ? 'danger' : 'secondary'" size="md" @click="clearFile()">ยกเลิก</b-button>
                                <b-button :variant=" file ? 'primary' : 'secondary'" size="md" @click="submitFile()">ส่งข้อมูล</b-button>
                            </b-form-group>
                        </b-col>
                    </b-row>
                </div>
            </b-col>
        </b-row>
        <b-row align-h="center" v-if="status=='success'">
            <b-col cols="6">
                <b-alert variant="success" show>
                    <h4 class="alert-heading">ข้อมูลถูกจัดส่งแล้ว</h4>
                    <p>
                        ข้อมูลของท่านได้ถูกส่งให้กรมบัญชีกลางเรียบร้อยแล้ว
                    </p>
                </b-alert>
                <div class="text-center">
                    <b-button variant="primary" size="md" @click="downloadForm">ดูแบบฟอร์มของท่าน</b-button>
                </div>
            </b-col>

        </b-row>


    </div>
</template>

<script>
export default {
    props: ['refund_id','refund_status'],
    data(){
        return {
            office_id: 2,
            file: null,
            alert: '',
            uploadPercentage: 0,
            description: '',
            upload_by: 'xxx',
            list_files: [],
            status: 'new',
            isAdmin: false
        }
    },
    mounted(){
       this.isAdmin = this.$store.state.user == 'admin' ? true : false;

        
        this.fetchData();
    },
    methods: {
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
                    formData.append('upload_by',this.upload_by);
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
                this.list_files = response.data.data;
                this.status = this.list_files.length > 0 ? "success" : "new";
                this.$forceUpdate();
            })
            .catch(error=>{
                console.log('error' + error);
            })
        },
        downloadForm(){
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_files/${this.list_files[0].id}`;
            console.log('download file :' + path);
            axios.get(`${path}`)
            .then(response=>{
                var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                var fileLink = document.createElement('a');
                fileLink.href = fileURL;
                fileLink.setAttribute('download', 'report.pdf');
                document.body.appendChild(fileLink);

                fileLink.click();
            })
            .catch(error=>{

            })
        }
    }
}
</script>

<style scoped>

</style>
