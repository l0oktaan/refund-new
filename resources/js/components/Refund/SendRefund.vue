<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
        <b-row>
            <!-- <b-col><refund-report></refund-report></b-col> -->
        </b-row>
        <div v-if="status == 'new'">
            <b-row>
                <b-col sm="6">
                    <b-form-group
                        label-cols-sm="6"
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
                <b-col sm="6">
                    <b-form-group
                        label-cols-sm="6"
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
                <b-col sm="6">
                    <b-form-group
                        label-cols-sm="6"
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
        <b-row>
            <b-col cols="5">
                {{list_files}}
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
            status: 'new'
        }
    },
    mounted(){
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
        }
    }
}
</script>

<style scoped>
.btn{
    margin-top: 10px;
}
</style>